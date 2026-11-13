# Sistema Web de Estacionamiento de Vehículos

Sistema web para administrar un estacionamiento: entradas y salidas de vehículos con ticket en PDF, cobro por tiempo (efectivo o QR), clientes abonados con mensualidad, espacios en tiempo real, caja y reportes en PDF y Excel.

Hecho con **Laravel 12**, **MySQL**, **Blade**, **jQuery + AJAX** y la plantilla **AdminLTE 3**.

## Requisitos

- [XAMPP](https://www.apachefriends.org/) con **PHP 8.2** y **MySQL/MariaDB**.
- [Composer](https://getcomposer.org/).
- En `C:\xampp\php\php.ini` deben estar activas (sin `;` al inicio) estas líneas, que necesita la exportación a Excel:
  ```ini
  extension=gd
  extension=zip
  ```

No necesita Node.js ni internet: los archivos de AdminLTE, Bootstrap, jQuery, DataTables y SweetAlert2 ya están en `public/vendor/`.

## Instalación

1. Encender **Apache** y **MySQL** en el panel de XAMPP.

2. Clonar el proyecto dentro de `C:\xampp\htdocs` y entrar a la carpeta:
   ```bash
   git clone https://github.com/ronaldmamani028-arch/estacionamiento.git
   cd estacionamiento
   ```

3. Instalar las dependencias de PHP:
   ```bash
   composer install
   ```

4. Copiar el archivo de configuración `.env.example` a `.env`:
   ```bash
   copy .env.example .env
   ```
   (En Linux o Mac: `cp .env.example .env`.)

5. Generar la clave de la aplicación:
   ```bash
   php artisan key:generate
   ```

6. Crear la base de datos `estacionamiento` en phpMyAdmin (http://localhost/phpmyadmin), con cotejamiento `utf8mb4_unicode_ci`.
   El `.env` ya viene configurado para XAMPP: usuario `root` sin contraseña. Si tu MySQL tiene otra contraseña, cámbiala en `DB_PASSWORD`.

7. Crear las tablas y cargar los datos iniciales:
   ```bash
   php artisan migrate --seed
   ```

8. Iniciar el servidor y abrir http://127.0.0.1:8000:
   ```bash
   php artisan serve
   ```

## Usuario inicial

| Correo | Contraseña | Rol |
|---|---|---|
| `admin@estacionamiento.com` | `admin123` | Administrador |

Cambia esta contraseña después del primer ingreso (menú **Usuarios**).

Los datos iniciales también crean los roles, los tipos de vehículo (Auto, Moto, Camioneta), sus tarifas de ejemplo, 30 espacios y los métodos de pago (Efectivo y QR Yape).

## Roles

| Rol | Puede |
|---|---|
| Administrador | Todo: usuarios, tipos de vehículo, tarifas, espacios y todo lo de los otros roles. |
| Operador/Cajero | Entradas y salidas, cobros, mensualidades, clientes, vehículos y ver los espacios. |
| Supervisor | Solo mirar: espacios en tiempo real, listados, caja y reportes. |

## Notas

- La imagen `public/img/qr-yape.png` es un QR de ejemplo: reemplázala por tu QR de Yape con el mismo nombre.
- Los registros nunca se eliminan: se activan o desactivan.
