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
    public class CuentasBancariasController : Controller
    {
        private readonly BdjeloskaContext _context;
        private readonly IHttpClientFactory _httpClientFactory;

        public CuentasBancariasController(BdjeloskaContext context, IHttpClientFactory httpClientFactory)
        {
            _context = context;
            _httpClientFactory = httpClientFactory;
        }

        // GET: CuentasBancarias
        public async Task<IActionResult> Index()
        {
            var bdjeloskaContext = _context.CuentasBancarias.Include(c => c.Persona);
            return View(await bdjeloskaContext.ToListAsync());
        }

        // GET: CuentasBancarias/Details/5
        public async Task<IActionResult> Details(ulong? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var cuentasBancaria = await _context.CuentasBancarias
                .Include(c => c.Persona)
                .FirstOrDefaultAsync(m => m.Id == id);
            if (cuentasBancaria == null)
            {
                return NotFound();
            }

            return View(cuentasBancaria);
        }

        // GET: CuentasBancarias/Create
        public IActionResult Create()
        {
            ViewData["PersonaId"] = new SelectList(_context.Personas, "Id", "Id");
            return View();
        }

        // POST: CuentasBancarias/Create
        // To protect from overposting attacks, enable the specific properties you want to bind to.
        // For more details, see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> Create([Bind("Id,PersonaId,TipoCuenta,Saldo,Moneda,CreatedAt,UpdatedAt")] CuentasBancaria cuentasBancaria)
        {
            ModelState.Remove("Persona");
            if (ModelState.IsValid)
            {
                _context.Add(cuentasBancaria);
                await _context.SaveChangesAsync();
                return RedirectToAction(nameof(Index));
            }
            ViewData["PersonaId"] = new SelectList(_context.Personas, "Id", "Id", cuentasBancaria.PersonaId);
            return View(cuentasBancaria);
        }

        // GET: CuentasBancarias/Edit/5
        public async Task<IActionResult> Edit(ulong? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var cuentasBancaria = await _context.CuentasBancarias.FindAsync(id);
            if (cuentasBancaria == null)
            {
                return NotFound();
            }
            ViewData["PersonaId"] = new SelectList(_context.Personas, "Id", "Id", cuentasBancaria.PersonaId);
            return View(cuentasBancaria);
        }

        // POST: CuentasBancarias/Edit/5
        // To protect from overposting attacks, enable the specific properties you want to bind to.
        // For more details, see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> Edit(ulong id, [Bind("Id,PersonaId,TipoCuenta,Saldo,Moneda,CreatedAt,UpdatedAt")] CuentasBancaria cuentasBancaria)
        {
            ModelState.Remove("Persona");
            if (id != cuentasBancaria.Id)
            {
                return NotFound();
            }

            if (ModelState.IsValid)
            {
                try
                {
                    _context.Update(cuentasBancaria);
                    await _context.SaveChangesAsync();
                }
                catch (DbUpdateConcurrencyException)
                {
                    if (!CuentasBancariaExists(cuentasBancaria.Id))
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
            ViewData["PersonaId"] = new SelectList(_context.Personas, "Id", "Id", cuentasBancaria.PersonaId);
            return View(cuentasBancaria);
        }

        // GET: CuentasBancarias/Delete/5
        public async Task<IActionResult> Delete(ulong? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var cuentasBancaria = await _context.CuentasBancarias
                .Include(c => c.Persona)
                .FirstOrDefaultAsync(m => m.Id == id);
            if (cuentasBancaria == null)
            {
                return NotFound();
            }

            return View(cuentasBancaria);
        }

        // POST: CuentasBancarias/Delete/5
        [HttpPost, ActionName("Delete")]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> DeleteConfirmed(ulong id)
        {
            var cuentasBancaria = await _context.CuentasBancarias.FindAsync(id);
            if (cuentasBancaria != null)
            {
                _context.CuentasBancarias.Remove(cuentasBancaria);
            }

            await _context.SaveChangesAsync();
            return RedirectToAction(nameof(Index));
        }

        private bool CuentasBancariaExists(ulong id)
        {
            return _context.CuentasBancarias.Any(e => e.Id == id);
        }


        // CUENTAS BANCARIAS API

        // GET: Muestra el formulario de creación de Cuenta Bancaria a través de la API
        [HttpGet]
        public IActionResult CreateViaApi()
        {
            ViewData["PersonaId"] = new SelectList(_context.Personas, "Id", "Id"); // Asegúrate de que 'Nombre' es el campo que quieres mostrar

            return View(new CuentasBancaria());
        }

        // POST: Procesa el formulario de creación de Cuenta Bancaria
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> CreateViaApi(CuentasBancaria cuenta)
        {
            ModelState.Remove("Persona");
            ViewData["PersonaId"] = new SelectList(_context.Personas, "Id", "Id", cuenta.PersonaId);
            if (!ModelState.IsValid)
            {
                // Esto mostrará los errores de validación en el formulario

                return View(cuenta);
            }

            var client = _httpClientFactory.CreateClient();
            var payload = new
            {
                table = "cuentas_bancarias",
                persona_id = cuenta.PersonaId,
                tipo_cuenta = cuenta.TipoCuenta,
                saldo = cuenta.Saldo,
                moneda = cuenta.Moneda
            };
            Console.WriteLine($"Received PersonaId: {cuenta.PersonaId}");

            var json = JsonConvert.SerializeObject(payload);
            var content = new StringContent(json, Encoding.UTF8, "application/json");

            var response = await client.PostAsync("http://localhost/BankHubAPI/api.php?table=cuentas_bancarias", content);
            if (!response.IsSuccessStatusCode)
            {
                // Leer el contenido de la respuesta para mostrar el mensaje de error específico
                var errorResponse = await response.Content.ReadAsStringAsync();
                var errorData = JsonConvert.DeserializeObject<Dictionary<string, string>>(errorResponse);
                if (errorData != null && errorData.ContainsKey("message"))
                {
                    ModelState.AddModelError("", $"Failed to create account via API. Server responded with: {errorData["message"]}");
                }
                else
                {
                    ModelState.AddModelError("", $"Failed to create account via API. Response: {errorResponse}");
                }
            }

            if (!ModelState.IsValid)
            {
                // Esto también mostrará los errores capturados desde la respuesta de la API
                return View(cuenta);
            }

            return RedirectToAction("Index");
        }

        // BUSCAR VIA API

        // Acción que muestra el formulario para buscar por ID
        [HttpGet]
        public IActionResult BuscarCuenta()
        {
            return View();
        }


        [HttpPost]
        public async Task<IActionResult> BuscarCuenta(string id)
        {
            if (string.IsNullOrWhiteSpace(id))
            {
                ViewBag.ErrorMessage = "Por favor ingrese un ID válido.";
                return View();
            }

            var client = _httpClientFactory.CreateClient();
            var response = await client.GetAsync($"http://localhost/BankHubAPI/api.php?table=cuentas_bancarias&id={id}");

            if (response.IsSuccessStatusCode)
            {
                var jsonResponse = await response.Content.ReadAsStringAsync();

                try
                {
                    // Deserializa como una lista y toma el primer elemento
                    var cuentas = JsonConvert.DeserializeObject<List<CuentasBancaria>>(jsonResponse);
                    var cuenta = cuentas.FirstOrDefault();

                    if (cuenta != null)
                    {
                        return View("Details", cuenta);
                    }
                    else
                    {
                        ViewBag.ErrorMessage = "Cuenta no encontrada.";
                        return View("BuscarCuenta");
                    }
                }
                catch (JsonSerializationException)
                {
                    // Captura cualquier error de deserialización y muestra un mensaje adecuado
                    ViewBag.ErrorMessage = "Error al procesar la respuesta de la API.";
                    return View("BuscarCuenta");
                }
            }
            else
            {
                ViewBag.ErrorMessage = "Error al realizar la solicitud a la API.";
                return View("BuscarCuenta");
            }
        }

    }

        
}
