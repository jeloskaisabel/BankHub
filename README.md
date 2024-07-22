
# BankHub

Este repositorio contiene varios proyectos relacionados con el sistema BankHub. Cada proyecto tiene una función específica dentro del sistema bancario. A continuación se describe el contenido de cada carpeta y archivo en el repositorio.

## Contenido del repositorio

### Carpetas y Proyectos

- **BankHub**: Este directorio contiene los siguientes componentes del sistema bancario:
  - **Gestión de Usuarios**: Módulo para la creación, actualización y eliminación de usuarios en el sistema.
  - **Gestión de Cuentas**: Módulo para la creación y gestión de cuentas bancarias.
  - **Transacciones**: Módulo que permite realizar y registrar transacciones financieras.
  - **Consultas y Reportes**: Herramientas para generar reportes financieros y realizar consultas sobre el estado de las cuentas y transacciones.
  - **Seguridad y Autenticación**: Funciones de autenticación y autorización para asegurar que solo usuarios autorizados puedan acceder al sistema.

- **BankHubAPI**: Proporciona una interfaz de programación de aplicaciones (API) para interactuar con el sistema BankHub desde aplicaciones externas. Incluye endpoints para:
  - **Autenticación**: Iniciar sesión y gestionar tokens de autenticación.
  - **Operaciones de Cuenta**: Consultar saldo, realizar transferencias y ver historial de transacciones.
  - **Gestión de Usuarios**: Crear, actualizar y eliminar usuarios.

- **BankHubApplicativo**: Aplicación de escritorio para la gestión interna del banco, utilizada por los empleados para:
  - **Atención al Cliente**: Registro y seguimiento de solicitudes de clientes.
  - **Procesamiento de Préstamos**: Evaluación y aprobación de solicitudes de préstamos.
  - **Gestión de Productos Bancarios**: Creación y gestión de productos como cuentas de ahorro, cuentas corrientes y certificados de depósito.

- **BankHubWeb**: Interfaz web del sistema BankHub que permite a los usuarios:
  - **Acceso a Cuentas**: Consultar saldos y movimientos de sus cuentas.
  - **Transferencias en Línea**: Realizar transferencias bancarias entre cuentas.
  - **Solicitud de Productos**: Solicitar nuevos productos bancarios en línea.

- **BankHubWebService**: Servicios web que soportan la funcionalidad de la aplicación web y móvil, incluyendo:
  - **Notificaciones**: Envío de alertas y notificaciones a los usuarios.
  - **Servicios de Pago**: Integración con pasarelas de pago para procesar pagos en línea.
  - **Servicios de Consulta**: Servicios para consultas de saldos y movimientos en tiempo real.

- **CuentasBankHub**: Sistema especializado para la gestión de cuentas bancarias, que incluye:
  - **Apertura de Cuentas**: Proceso para la apertura de nuevas cuentas bancarias.
  - **Cierre de Cuentas**: Procedimientos para el cierre y liquidación de cuentas.
  - **Auditoría de Cuentas**: Herramientas para la auditoría y control de las cuentas bancarias.

### Archivos

- **bdjeloska.sql**: Archivo SQL utilizado para la importación y configuración de la base de datos del sistema BankHub. Incluye las estructuras de tablas, relaciones y datos iniciales necesarios para el funcionamiento del sistema.

## Tecnologías Utilizadas

- **PHP**: Utilizado para la lógica del servidor y la creación de APIs.
- **C#**: Utilizado en la aplicación de escritorio.
- **HTML/CSS/JavaScript**: Utilizados en la interfaz web.
- **Blade**: Motor de plantillas de Laravel para la generación de vistas.
- **MySQL**: Base de datos para almacenar toda la información del sistema.
- **Laravel**: Framework PHP utilizado para la creación de APIs y backend.
- **.NET**: Framework utilizado para la aplicación de escritorio en C#.

## Dependencias

- **Laravel Framework**: `composer require laravel/laravel`
- **.NET Core**: Instalación de SDK de .NET
- **Node.js y npm**: Para la gestión de paquetes y dependencias front-end.
- **MySQL**: Para la base de datos.

## Cómo Empezar

1. **Clonar el repositorio**:
    ```sh
    git clone https://github.com/jeloskaisabel/Examen-324.git
    ```

2. **Importar la base de datos**:
    - Utiliza el archivo `bdjeloska.sql` para importar las estructuras y datos iniciales en tu sistema de base de datos.
    ```sh
    mysql -u usuario -p base_de_datos < bdjeloska.sql
    ```

3. **Configurar el entorno**:
    - Sigue las instrucciones específicas de cada proyecto dentro de sus respectivos directorios para configurar y ejecutar los servicios necesarios.

4. **Instalar dependencias**:
    - Para el backend de Laravel:
      ```sh
      cd BankHubAPI
      composer install
      ```
    - Para la aplicación web:
      ```sh
      cd BankHubWeb
      npm install
      ```
    - Para la aplicación de escritorio, asegúrate de tener el SDK de .NET instalado y restaurar las dependencias:
      ```sh
      cd BankHubApplicativo
      dotnet restore
      ```

5. **Configurar archivos de entorno**:
    - Crea y configura los archivos `.env` según las instrucciones en cada proyecto. Asegúrate de incluir las configuraciones de base de datos y otros servicios necesarios.

6. **Migrar y sembrar la base de datos** (para proyectos Laravel):
    ```sh
    php artisan migrate --seed
    ```

7. **Ejecutar los servicios**:
    - Inicia los servicios de la API, la aplicación de escritorio y la interfaz web según las instrucciones de configuración.
    - Para Laravel:
      ```sh
      php artisan serve
      ```
    - Para .NET:
      ```sh
      dotnet run
      ```
    - Para la aplicación web:
      ```sh
      npm start
      ```

## Despliegue

### Despliegue en Servidor

1. **Configurar Servidor**:
   - Asegúrate de tener un servidor con Apache/Nginx, PHP, y MySQL instalados.
   - Configura tu servidor para apuntar a la carpeta `public` de tu proyecto Laravel.

2. **Instalar dependencias en el servidor**:
   ```sh
   composer install
   npm install
   ```

3. **Configurar archivo de entorno en el servidor**:
   - Copia el archivo `.env` y configura las variables necesarias.

4. **Migrar y sembrar la base de datos**:
   ```sh
   php artisan migrate --seed
   ```

5. **Optimizar configuración**:
   ```sh
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

### Despliegue de la Aplicación de Escritorio

1. **Compilar la aplicación**:
   ```sh
   dotnet publish -c Release -o ./publish
   ```

2. **Distribuir el ejecutable**:
   - Distribuye los archivos compilados en la carpeta `publish` a los usuarios finales.

## Contribuciones

Las contribuciones son bienvenidas. Por favor, abre un issue para discutir cualquier cambio que quieras realizar.

## Licencia

Este proyecto está licenciado bajo los términos de la [Licencia MIT](LICENSE).



