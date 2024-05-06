using BankHubWebService.Models;
using Microsoft.EntityFrameworkCore;
using System.Collections.Generic;
using System.Reflection.Emit;

namespace BankHubWebService.Data
{
    public class ApplicationDbContext : DbContext
    {
        public ApplicationDbContext(DbContextOptions<ApplicationDbContext> options)
            : base(options)
        {
        }

        public DbSet<Persona> Personas { get; set; }

        protected override void OnModelCreating(ModelBuilder modelBuilder)
        {
            base.OnModelCreating(modelBuilder);

            // Configurando índices únicos
            modelBuilder.Entity<Persona>()
                .HasIndex(p => p.DocumentoIdentidad)
                .IsUnique();

            modelBuilder.Entity<Persona>()
                .HasIndex(p => p.Email)
                .IsUnique();
        }
    }
}
