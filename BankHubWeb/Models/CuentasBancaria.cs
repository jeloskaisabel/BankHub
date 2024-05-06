using System;
using System.Collections.Generic;
using Newtonsoft.Json;  // Asegúrate de tener esta referencia para usar JsonProperty

namespace BankHubWeb.Models;

public partial class CuentasBancaria
{
    [JsonProperty("id")]
    public ulong Id { get; set; }

    [JsonProperty("persona_id")]
    public ulong PersonaId { get; set; }

    [JsonProperty("tipo_cuenta")]
    public string TipoCuenta { get; set; } = null!;

    [JsonProperty("saldo")]
    public decimal Saldo { get; set; }

    [JsonProperty("moneda")]
    public string Moneda { get; set; } = null!;

    [JsonProperty("created_at")]
    public DateTime? CreatedAt { get; set; }

    [JsonProperty("updated_at")]
    public DateTime? UpdatedAt { get; set; }

    [JsonIgnore]
    public virtual Persona Persona { get; set; } = null!;

    [JsonIgnore]
    public virtual ICollection<Transaccione> Transacciones { get; set; } = new List<Transaccione>();
}
