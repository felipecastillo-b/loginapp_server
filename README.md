# LoginApp Server

Este proyecto es un servidor para la aplicación de inicio de sesión (LoginApp) desarrollado en PHP. A continuación, se detallan los pasos necesarios para configurar y ejecutar el proyecto.

## Requisitos

- [XAMPP](https://www.apachefriends.org/index.html) (incluye Apache, PHP y MySQL)
- phpMyAdmin (incluido con XAMPP)

## Configuración del Proyecto

### 1. Instalación de XAMPP

1. Descarga e instala XAMPP desde [aquí](https://www.apachefriends.org/index.html).
2. Inicia el Panel de Control de XAMPP y asegúrate de que Apache y MySQL están corriendo.

### 2. Configuración de la Base de Datos

1. Abre phpMyAdmin accediendo a `http://localhost/phpmyadmin` en tu navegador.
2. Crea una nueva base de datos llamada `login_register_app`, si deseas cambiar el nombre de la base de datos es necesario tambien cambiarla dentro del archivo `Constants.php`.
3. Las tablas necesarios son `estado`, `registro`, `tipo` y `usuario`.
