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
- Vista inicial de dashboard protegida por sesión

### Funcionalidades pendientes

- Cierre de sesión (logout)
- Gestión de usuarios
- Módulo de salas (apartado, disponibilidad, administración)
- Manejo de roles y permisos
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
