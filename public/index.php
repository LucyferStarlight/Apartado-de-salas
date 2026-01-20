<?php

// Mostrar errores (solo en desarrollo)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Cargar el Router
require_once __DIR__ . '/../app/core/Router.php';

// Crear instancia del Router
$router = new Router();

// Cargar las rutas
require_once __DIR__ . '/../routes/web.php';

// Ejecutar el router
$router->dispatch();
