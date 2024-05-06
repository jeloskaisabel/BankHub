using System;
using Newtonsoft.Json;

namespace BankHubWeb.Models;

public partial class Transaccione
{
    [JsonProperty("id")]
    public ulong Id { get; set; }

    [JsonProperty("cuenta_bancaria_id")]
    public ulong CuentaBancariaId { get; set; }

    [JsonProperty("tipo_transaccion")]
    public string TipoTransaccion { get; set; } = null!;

    [JsonProperty("monto")]
    public decimal Monto { get; set; }

    [JsonProperty("fecha_transaccion")]
    public DateTime FechaTransaccion { get; set; }

    [JsonProperty("created_at")]
    public DateTime? CreatedAt { get; set; }

    [JsonProperty("updated_at")]
    public DateTime? UpdatedAt { get; set; }

    [JsonIgnore]
    public virtual CuentasBancaria CuentaBancaria { get; set; } = null!;
}
