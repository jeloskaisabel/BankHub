using BankHubWeb.Models;
using Microsoft.EntityFrameworkCore;

namespace BankHubWeb
{
    public class Program
    {
        public static void Main(string[] args)
        {
            var builder = WebApplication.CreateBuilder(args);
            // Add services to the container.
            builder.Services.AddControllersWithViews();
            builder.Services.AddHttpClient();
            builder.Services.AddDbContext<BdjeloskaContext>(options =>
            {
                var connectionString = builder.Configuration.GetConnectionString("CadenaSQL");
                options.UseMySQL(connectionString)
                       .EnableSensitiveDataLogging(builder.Environment.IsDevelopment()) // Habilita en desarrollo
                       .EnableDetailedErrors(builder.Environment.IsDevelopment()); // Habilita en desarrollo
            });

            // Configura los servicios de logging adicionales si lo necesitas
            builder.Logging.ClearProviders();
            builder.Logging.AddConsole();



            var app = builder.Build();


            // Configure the HTTP request pipeline.
            if (!app.Environment.IsDevelopment())
            {
                app.UseExceptionHandler("/Home/Error");
                // The default HSTS value is 30 days. You may want to change this for production scenarios, see https://aka.ms/aspnetcore-hsts.
                app.UseHsts();
            }

            app.UseHttpsRedirection();
            app.UseStaticFiles();

            app.UseRouting();

            app.UseAuthorization();

            app.MapControllerRoute(
                name: "default",
                pattern: "{controller=Home}/{action=Index}/{id?}");

            app.Run();
        }
    }
}
