using System;
using System.Collections.Generic;
using Newtonsoft.Json;  // Asegúrate de tener esta referencia para usar JsonProperty

namespace BankHubWeb.Models;

public partial class Persona
{
    [JsonProperty("id")]
    public ulong Id { get; set; }

    [JsonProperty("nombre")]
    public string Nombre { get; set; } = null!;

    [JsonProperty("apellido")]
    public string Apellido { get; set; } = null!;

    [JsonProperty("fecha_nacimiento")]
    public DateTime FechaNacimiento { get; set; }

    [JsonProperty("documento_identidad")]
    public string DocumentoIdentidad { get; set; } = null!;

    [JsonProperty("direccion")]
    public string Direccion { get; set; } = null!;

    [JsonProperty("telefono")]
    public string Telefono { get; set; } = null!;

    [JsonProperty("email")]
    public string Email { get; set; } = null!;

    [JsonProperty("created_at")]
    public DateTime? CreatedAt { get; set; }

    [JsonProperty("updated_at")]
    public DateTime? UpdatedAt { get; set; }

    public virtual ICollection<CuentasBancaria> CuentasBancaria { get; set; } = new List<CuentasBancaria>();
}