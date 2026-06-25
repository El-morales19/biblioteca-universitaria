# Biblioteca Universitaria

Sistema web de gestión bibliotecaria desarrollado en Laravel para la administración de usuarios, libros, préstamos, devoluciones y reportes.

## Descripción

Biblioteca Universitaria es una implementación orientada a la gestión de recursos bibliográficos dentro de una institución educativa. El sistema implementa control de acceso basado en roles, baja lógica de registros, reportes estadísticos y exportación de información.

## Características

### Gestión de Usuarios

* Alta de usuarios
* Consulta de usuarios
* Modificación de usuarios
* Baja lógica de usuarios
* Reactivación de usuarios

### Gestión de Libros

* Registro de libros
* Consulta de libros
* Actualización de información
* Baja lógica de libros
* Reactivación de libros

### Gestión de Préstamos

* Registro de préstamos
* Registro de devoluciones
* Historial de préstamos
* Validación de disponibilidad de libros
* Selección exclusiva de alumnos activos

### Reportes

* Libros disponibles
* Libros prestados
* Usuarios con préstamos activos
* Historial de préstamos
* Exportación PDF
* Exportación Excel

### Seguridad

* Autenticación mediante Laravel Breeze
* Control de acceso por roles
* Bloqueo de usuarios inactivos
* Restricción de acceso a recursos protegidos

## Roles del Sistema

### Administrador

* Gestión completa de usuarios
* Gestión de libros
* Gestión de préstamos
* Acceso a reportes globales

### Bibliotecario

* Gestión de libros
* Gestión de préstamos
* Acceso a reportes globales

### Alumno

* Consulta de libros
* Consulta de préstamos personales
* Consulta de reportes personales
* Recepción de notificaciones internas

## Patrones de Diseño Implementados

### Creacionales

* Singleton
* Builder

### Estructurales

* Facade
* Proxy

### Comportamiento

* Template Method
* Mediator

## Tecnologías Utilizadas

* PHP 8
* Laravel 13
* Laravel Breeze
* Tailwind CSS
* SQLite
* DomPDF
* Laravel Excel

## Instalación

### Clonar repositorio

```bash
git clone <url-del-repositorio>
cd biblioteca-universitaria
```

### Instalar dependencias

```bash
composer install
npm install
```

### Configurar entorno

```bash
cp .env.example .env
php artisan key:generate
```

Configurar los datos de conexión a la base de datos en el archivo `.env`.

### Ejecutar migraciones

```bash
php artisan migrate --seed
```

### Compilar recursos

```bash
npm run build
```

### Iniciar servidor

```bash
php artisan serve
```

## Ejecución de Pruebas

```bash
php artisan test
```

## Autor

Proyecto desarrollado para la asignatura Implementación de Sistemas.

Eli Morales.
Licenciatura en Informática.
Facultad de Contaduría y Administración.
Universidad Nacional Autónoma de México.

