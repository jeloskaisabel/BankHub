using System;
using System.ComponentModel.DataAnnotations.Schema;
using System.ComponentModel.DataAnnotations;
using Microsoft.EntityFrameworkCore;



namespace BankHubWebService.Models
{
    public class Persona
    {
        public long Id { get; set; }

        [Required]
        [StringLength(255)]
        public string Nombre { get; set; }

        [Required]
        [StringLength(255)]
        public string Apellido { get; set; }

        [Required]
        [Column("fecha_nacimiento")]
        public DateTime FechaNacimiento { get; set; }

        [Required]
        [StringLength(255)]
        [Column("documento_identidad")]
        public string DocumentoIdentidad { get; set; }

        [StringLength(255)]
        public string Direccion { get; set; }

        [StringLength(255)]
        public string Telefono { get; set; }

        [Required]
        [StringLength(255)]
        public string Email { get; set; }

        [Column("created_at")]  // Asegura que el mapeo se haga correctamente
        public DateTime? CreatedAt { get; set; }

        [Column("updated_at")]  // Asegura que el mapeo se haga correctamente
        public DateTime? UpdatedAt { get; set; }

        [StringLength(255)]
        public string Departamento { get; set; }
    }
}
