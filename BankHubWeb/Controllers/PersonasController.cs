using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.Rendering;
using Microsoft.EntityFrameworkCore;
using BankHubWeb.Models;
using System.Net.Http;
using Newtonsoft.Json;
using System.Text;


namespace BankHubWeb.Controllers
{
    public class PersonasController : Controller
    {
        private readonly BdjeloskaContext _context;
        private readonly IHttpClientFactory _httpClientFactory;

        public PersonasController(BdjeloskaContext context, IHttpClientFactory httpClientFactory)
        {
            _context = context;
            // Inyectando API
            _httpClientFactory = httpClientFactory;
        }

        // GET: Personas
        public async Task<IActionResult> Index()
        {
            return View(await _context.Personas.ToListAsync());
        }

        // GET: Personas/Details/5
        public async Task<IActionResult> Details(ulong? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var persona = await _context.Personas
                .FirstOrDefaultAsync(m => m.Id == id);
            if (persona == null)
            {
                return NotFound();
            }

            return View(persona);
        }

        // GET: Personas/Create
        public IActionResult Create()
        {
            return View();
        }

        // POST: Personas/Create
        // To protect from overposting attacks, enable the specific properties you want to bind to.
        // For more details, see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> Create([Bind("Id,Nombre,Apellido,FechaNacimiento,DocumentoIdentidad,Direccion,Telefono,Email,CreatedAt,UpdatedAt")] Persona persona)
        {
            if (ModelState.IsValid)
            {
                _context.Add(persona);
                await _context.SaveChangesAsync();
                return RedirectToAction(nameof(Index));
            }
            return View(persona);
        }

        // GET: Personas/Edit/5
        public async Task<IActionResult> Edit(ulong? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var persona = await _context.Personas.FindAsync(id);
            if (persona == null)
            {
                return NotFound();
            }
            return View(persona);
        }

        // POST: Personas/Edit/5
        // To protect from overposting attacks, enable the specific properties you want to bind to.
        // For more details, see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> Edit(ulong id, [Bind("Id,Nombre,Apellido,FechaNacimiento,DocumentoIdentidad,Direccion,Telefono,Email,CreatedAt,UpdatedAt")] Persona persona)
        {
            if (id != persona.Id)
            {
                return NotFound();
            }

            if (ModelState.IsValid)
            {
                try
                {
                    _context.Update(persona);
                    await _context.SaveChangesAsync();
                }
                catch (DbUpdateConcurrencyException)
                {
                    if (!PersonaExists(persona.Id))
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
            return View(persona);
        }

        // GET: Personas/Delete/5
        public async Task<IActionResult> Delete(ulong? id)
        {
            if (id == null)
            {
                return NotFound();
            }

            var persona = await _context.Personas
                .FirstOrDefaultAsync(m => m.Id == id);
            if (persona == null)
            {
                return NotFound();
            }

            return View(persona);
        }

        // POST: Personas/Delete/5
        [HttpPost, ActionName("Delete")]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> DeleteConfirmed(ulong id)
        {
            var persona = await _context.Personas.FindAsync(id);
            if (persona != null)
            {
                _context.Personas.Remove(persona);
            }

            await _context.SaveChangesAsync();
            return RedirectToAction(nameof(Index));
        }

        private bool PersonaExists(ulong id)
        {
            return _context.Personas.Any(e => e.Id == id);
        }
        // CREATE VIA API

        // Método GET para mostrar el formulario de creación a través de la API
        [HttpGet]
        public IActionResult CreateViaApi()
        {
            return View(new Persona()); // Asegúrate de que esta vista exista en Views/Personas/CreateViaApi.cshtml
        }


        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> CreateViaApi(Persona persona)
        {
            if (!ModelState.IsValid)
            {
                return View(persona);
            }

            var client = _httpClientFactory.CreateClient();
            // Crear un objeto anónimo con solo las propiedades que necesita la API
            var payload = new
            {
                table = "personas",
                nombre = persona.Nombre,
                apellido = persona.Apellido,
                fecha_nacimiento = persona.FechaNacimiento.ToString("yyyy-MM-dd"), // Asegúrate de que el formato sea el correcto
                documento_identidad = persona.DocumentoIdentidad,
                direccion = persona.Direccion,
                telefono = persona.Telefono,
                email = persona.Email
            };

            var json = JsonConvert.SerializeObject(payload);
            var content = new StringContent(json, Encoding.UTF8, "application/json");

            var response = await client.PostAsync("http://localhost/BankHubAPI/api.php?table=personas", content);
            if (response.IsSuccessStatusCode)
            {
                return RedirectToAction("Index"); // O cualquier otra acción que prefieras después de un éxito
            }
            else
            {
                ModelState.AddModelError("", "Failed to create via API.");
                return View(persona);
            }
        }

        // BUSCAR VIA API

        // Acción que muestra el formulario para buscar por ID
        [HttpGet]
        public IActionResult BuscarPersona()
        {
            return View();
        }

        // Acción que procesa la búsqueda por ID
        [HttpPost]
        public async Task<IActionResult> BuscarPersona(string id)
        {
            if (string.IsNullOrWhiteSpace(id))
            {
                ViewBag.ErrorMessage = "Por favor ingrese un ID válido.";
                return View("BuscarPersona");
            }

            var client = _httpClientFactory.CreateClient();
            var response = await client.GetAsync($"http://localhost/BankHubAPI/api.php?table=personas&id={id}");

            if (response.IsSuccessStatusCode)
            {
                var jsonResponse = await response.Content.ReadAsStringAsync();

                try
                {
                    // Deserializa como una lista y toma el primer elemento
                    var personas = JsonConvert.DeserializeObject<List<Persona>>(jsonResponse);
                    var persona = personas.FirstOrDefault();

                    if (persona != null)
                    {
                        return View("Details", persona);
                    }
                    else
                    {
                        ViewBag.ErrorMessage = "Persona no encontrada.";
                        return View("BuscarPersona");
                    }
                }
                catch (JsonSerializationException ex)
                {
                    // Captura cualquier error de deserialización y muestra un mensaje adecuado
                    ViewBag.ErrorMessage = "Error al procesar la respuesta de la API.";
                    return View("BuscarPersona");
                }
            }
            else
            {
                ViewBag.ErrorMessage = "Error al realizar la solicitud a la API.";
                return View("BuscarPersona");
            }
        }




    }
}
