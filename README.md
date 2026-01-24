# Apartado de Salas

Proyecto en desarrollo para la gestión y apartado de salas, actualmente en proceso de refactorización completa.

## Estado actual del proyecto

El sistema ha sido reestructurado desde cero utilizando una arquitectura **MVC (Modelo–Vista–Controlador)** con un **router propio en PHP**, con el objetivo de mejorar la organización del código, facilitar el mantenimiento y permitir escalabilidad futura.

### Funcionalidades implementadas

- Arquitectura MVC organizada por responsabilidades
- Front Controller (`public/index.php`)
- Router propio para manejo de rutas GET y POST
- Sistema de autenticación (login) funcional
- Conexión a base de datos mediante PDO
- Manejo de sesiones
- Dashboard protegido por sesión
- Módulo de reservaciones funcional:
  - Creación de solicitudes de apartado
  - Asignación de horarios múltiples
  - Validación de traslapes de fechas y horas
  - Asignación de materiales por sala
  - Validaciones backend y control de integridad
  - Uso de transacciones para consistencia de datos

### Funcionalidades pendientes

- Cierre de sesión (logout)
- Gestión de usuarios
- Listado de reservaciones (usuario y administración)
- Aprobación / rechazo de solicitudes
- Manejo de roles y permisos
- Generación de documentos de solicitud
- Envío de notificaciones por correo
- Mejora de la interfaz con Bootstrap

## Tecnologías utilizadas

- PHP (sin framework)
- MariaDB / MySQL
- HTML / CSS
- PDO para acceso a base de datos

## Nota

Este proyecto se encuentra en una rama de refactorización (`clean-architecture`).  
La rama `main` conserva la versión original del sistema como referencia.

---
