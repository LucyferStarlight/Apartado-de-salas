# Apartado de Salas

Sistema web para la gestión y apartado de salas institucionales, desarrollado en PHP sin framework, con arquitectura MVC y control de acceso por roles.

Este proyecto surge a partir de una versión legacy y fue refactorizado completamente con el objetivo de mejorar la organización del código, la mantenibilidad y la escalabilidad del sistema.

---

## 🧭 Estado actual del proyecto

El sistema se encuentra **funcional y estable**, con un flujo completo de usuario y administración, implementado bajo una arquitectura **MVC (Modelo–Vista–Controlador)** y un **router propio en PHP**.

---
## 🔗 Vista en vivo
El sistema se encuentra desplegado y funcional en el siguiente enlace:

👉 https://arakatadevs.com.mx/Portafolio/Apartado-Salas

>**Nota:** El acceso al sistema requiere credenciales de usuario.
>Algunas funcionalidades están disponibles únicamente para el rol de administrador.

### 🔑 Credenciales de demostración

**Administrador**
- Usuario: `admin`
- Contraseña: `1234`

**Usuario**
- Usuario: `jefe_departamento`
- contraseña: `1234`

> Estas credenciales son únicamente para fines demostrativos y para facilitar la evaluación del proyecto
> El sistema no contiene información sensible

---

## ✅ Funcionalidades implementadas

### Autenticación y sesiones
- Inicio de sesión (login)
- Cierre de sesión (logout)
- Manejo de sesiones
- Protección de rutas

### Roles y control de acceso
- Rol **usuario**
- Rol **administrador**
- Dashboard dinámico según rol
- Control de permisos a nivel backend

### Gestión de reservaciones
- Creación de solicitudes de apartado de salas
- Soporte para múltiples horarios por solicitud
- Validación de traslape de fechas y horarios
- Asociación de materiales según la sala
- Vista de **“Mis solicitudes”** para usuarios y administradores
- Listado global de solicitudes (administrador)
- Filtro de solicitudes pendientes
- Vista de detalle de solicitud (revisión administrativa)
- Aprobación y rechazo de solicitudes

### Arquitectura y estructura
- Arquitectura MVC organizada por responsabilidades
- Front Controller (`public/index.php`)
- Router propio para rutas GET y POST
- Acceso a base de datos mediante PDO
- Uso de prepared statements
- Separación clara entre lógica, vistas y acceso a datos

---

## 🛠 Tecnologías utilizadas

- PHP (sin framework)
- MariaDB / MySQL
- HTML / CSS
- JavaScript (Fetch API)
- PDO

---

## 🌿 Ramas del repositorio

- `main`: versión legacy original del sistema
- `clean-architecture`: refactorización completa con arquitectura MVC y nuevas funcionalidades

---

## 📌 Notas

Este proyecto fue desarrollado durante prácticas profesionales y posteriormente refactorizado con fines de aprendizaje, mejora técnica y portafolio personal.

El sistema está preparado para futuras extensiones como:
- generación de documentos (PDF),
- notificaciones por correo,
- mejoras visuales con Bootstrap.
La vista en vivo de este proyecto está en: www.arakatadevs.com.mx/Portafolio/Apartado-Salas/