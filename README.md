# Apartado de Salas

Sistema web para la gestión y apartado de salas institucionales, desarrollado en PHP sin framework, con arquitectura MVC y control de acceso por roles.

## Estado actual del proyecto

El proyecto fue refactorizado completamente desde una versión legacy hacia una arquitectura **MVC (Modelo–Vista–Controlador)**, incorporando un **router propio**, separación de responsabilidades y validaciones de seguridad a nivel backend.

## Funcionalidades implementadas

- Arquitectura MVC organizada
- Front Controller (`public/index.php`)
- Router propio para rutas GET y POST
- Autenticación de usuarios (login / logout)
- Manejo de sesiones
- Control de acceso por roles:
  - **Usuario**: puede crear solicitudes de apartado
  - **Administrador**: puede gestionar todas las solicitudes
- Dashboard dinámico según rol
- Creación de solicitudes de apartado de salas
- Validación de traslape de horarios
- Gestión de materiales por sala
- Flujo administrativo:
  - Ver todas las solicitudes
  - Filtrar solicitudes pendientes
  - Aprobar o rechazar reservaciones
- Conexión a base de datos mediante PDO

## Funcionalidades pendientes / futuras

- Vista de “Mis solicitudes” para usuarios
- Detalle individual de solicitudes
- Generación de documentos (PDF)
- Envío de notificaciones por correo
- Mejora visual con Bootstrap

## Tecnologías utilizadas

- PHP (sin framework)
- MariaDB / MySQL
- HTML / CSS
- JavaScript (fetch API)
- PDO para acceso a base de datos

## Ramas del repositorio

- `main`: versión legacy original del sistema
- `clean-architecture`: refactorización completa con MVC y nuevas funcionalidades

---

Proyecto desarrollado como parte de prácticas profesionales y refactorizado con fines de aprendizaje y portafolio.
