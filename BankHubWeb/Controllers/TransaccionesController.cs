using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.Rendering;
using Microsoft.EntityFrameworkCore;
using BankHubWeb.Models;
using Newtonsoft.Json;
using System.Text;

namespace BankHubWeb.Controllers
{
    public class TransaccionesController : Controller
    {
        private readonly BdjeloskaContext _context;
        private readonly IHttpClientFactory _httpClientFactory;

        public TransaccionesController(BdjeloskaContext context, IHttpClientFactory httpClientFactory)
        {
            _context = context;
            _httpClientFactory = httpClientFactory;
        }

        // GET: Transacciones
        public async Task<IActionResult> Index()
        {
            var bdjeloskaContext = _context.Transacciones.Include(t => t.CuentaBancaria);
            return View(await bdjeloskaContext.ToListAsync());
        }

        // GET: Transacciones/Details/5
        public async Task<IActionResult> Details(ulong? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var transaccione = await _context.Transacciones
                .Include(t => t.CuentaBancaria)
                .FirstOrDefaultAsync(m => m.Id == id);
            if (transaccione == null)
            {
                return NotFound();
            }

            return View(transaccione);
        }

        // GET: Transacciones/Create
        public IActionResult Create()
        {
            ViewData["CuentaBancariaId"] = new SelectList(_context.CuentasBancarias, "Id", "Id");
            return View();
        }

        // POST: Transacciones/Create
        // To protect from overposting attacks, enable the specific properties you want to bind to.
        // For more details, see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> Create([Bind("Id,CuentaBancariaId,TipoTransaccion,Monto,FechaTransaccion,CreatedAt,UpdatedAt")] Transaccione transaccione)
        {
            ModelState.Remove("CuentaBancaria");
            if (ModelState.IsValid)
            {
                _context.Add(transaccione);
                await _context.SaveChangesAsync();
                return RedirectToAction(nameof(Index));
            }
            ViewData["CuentaBancariaId"] = new SelectList(_context.CuentasBancarias, "Id", "Id", transaccione.CuentaBancariaId);
            return View(transaccione);
        }

        // GET: Transacciones/Edit/5
        public async Task<IActionResult> Edit(ulong? id)
        {

            if (id == null)
            {
                return NotFound();
            }

            var transaccione = await _context.Transacciones.FindAsync(id);
            if (transaccione == null)
            {
                return NotFound();
            }
            ViewData["CuentaBancariaId"] = new SelectList(_context.CuentasBancarias, "Id", "Id", transaccione.CuentaBancariaId);
            return View(transaccione);
        }

        // POST: Transacciones/Edit/5
        // To protect from overposting attacks, enable the specific properties you want to bind to.
        // For more details, see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> Edit(ulong id, [Bind("Id,CuentaBancariaId,TipoTransaccion,Monto,FechaTransaccion,CreatedAt,UpdatedAt")] Transaccione transaccione)
        {
            ModelState.Remove("CuentaBancaria");
            if (id != transaccione.Id)
            {
                return NotFound();
            }

            if (ModelState.IsValid)
            {
                try
                {
                    _context.Update(transaccione);
                    await _context.SaveChangesAsync();
                }
                catch (DbUpdateConcurrencyException)
                {
                    if (!TransaccioneExists(transaccione.Id))
                    {
                        return NotFound();
                    }
                    else
                    {
                        throw;
                    }
                }
                return RedirectToAction(nameof(Index));
            }
            ViewData["CuentaBancariaId"] = new SelectList(_context.CuentasBancarias, "Id", "Id", transaccione.CuentaBancariaId);
            return View(transaccione);
        }

        // GET: Transacciones/Delete/5
        public async Task<IActionResult> Delete(ulong? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var transaccione = await _context.Transacciones
                .Include(t => t.CuentaBancaria)
                .FirstOrDefaultAsync(m => m.Id == id);
            if (transaccione == null)
            {
                return NotFound();
            }

            return View(transaccione);
        }

        // POST: Transacciones/Delete/5
        [HttpPost, ActionName("Delete")]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> DeleteConfirmed(ulong id)
        {
            var transaccione = await _context.Transacciones.FindAsync(id);
            if (transaccione != null)
            {
                _context.Transacciones.Remove(transaccione);
            }

            await _context.SaveChangesAsync();
            return RedirectToAction(nameof(Index));
        }

        private bool TransaccioneExists(ulong id)
        {
            return _context.Transacciones.Any(e => e.Id == id);
        }

        //CREATE VIA API

        [HttpGet]
        public IActionResult CreateTransaccionViaApi()
        {
            ViewData["CuentasBancarias"] = new SelectList(_context.CuentasBancarias, "Id", "Id");
            return View();
        }

        // POST: Procesa el formulario de creación de Transacción
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> CreateTransaccionViaApi(Transaccione transaccion)
        {
            ModelState.Remove("CuentaBancaria");
            if (!ModelState.IsValid)
            {
                ViewData["CuentasBancarias"] = new SelectList(_context.CuentasBancarias, "Id", "Id", transaccion.CuentaBancariaId);
                return View(transaccion);
            }

            var client = _httpClientFactory.CreateClient();
            var payload = new
            {
                table = "transacciones",
                cuenta_bancaria_id = transaccion.CuentaBancariaId,
                tipo_transaccion = transaccion.TipoTransaccion,
                monto = transaccion.Monto,
                fecha_transaccion = transaccion.FechaTransaccion.ToString("o") // ISO 8601 format
            };

            var json = JsonConvert.SerializeObject(payload);
            var content = new StringContent(json, Encoding.UTF8, "application/json");

            var response = await client.PostAsync("http://localhost/BankHubAPI/api.php?table=transacciones", content);
            if (!response.IsSuccessStatusCode)
            {
                // Manejar errores de la respuesta aquí
            }

            // Redirigir a la vista de detalles de la cuenta o a la lista de transacciones
            return RedirectToAction(nameof(Index));
        }


        // BUSCAR VIA API

        [HttpGet]
        public IActionResult BuscarTransaccion()
        {
            return View();
        }

        [HttpPost]
        public async Task<IActionResult> BuscarTransaccion(string id)
        {
            if (string.IsNullOrWhiteSpace(id))
            {
                ViewBag.ErrorMessage = "Por favor ingrese un ID válido.";
                return View();
            }

            var client = _httpClientFactory.CreateClient();
            var response = await client.GetAsync($"http://localhost/BankHubAPI/api.php?table=transacciones&id={id}");

            if (response.IsSuccessStatusCode)
            {
                var jsonResponse = await response.Content.ReadAsStringAsync();

                try
                {
                    // Deserializa como una lista y toma el primer elemento
                    var transacciones = JsonConvert.DeserializeObject<List<Transaccione>>(jsonResponse);
                    var transaccion = transacciones.FirstOrDefault();

                    if (transaccion != null)
                    {
                        return View("Details", transaccion);
                    }
                    else
                    {
                        ViewBag.ErrorMessage = "Transacción no encontrada.";
                        return View("BuscarTransaccion");
                    }
                }
                catch (JsonSerializationException)
                {
                    // Captura cualquier error de deserialización y muestra un mensaje adecuado
                    ViewBag.ErrorMessage = "Error al procesar la respuesta de la API.";
                    return View("BuscarTransaccion");
                }
            }
            else
            {
                ViewBag.ErrorMessage = "Error al realizar la solicitud a la API.";
                return View("BuscarTransaccion");
            }
        }
    }
}
