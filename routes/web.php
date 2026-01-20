<?php

// Mostrar formulario de login
$router->add('GET', '/login', 'AuthController', 'showLogin');

// Procesar login (formulario)
$router->add('POST', '/login', 'AuthController', 'login');

// Cerrar sesión
$router->add('GET', '/logout', 'AuthController', 'logout');

//Ruta raíz /
$router->add('GET', '/', 'AuthController', 'showLogin');

//Ruta Dashboard
$router->add('GET', '/dashboard', 'DashboardController', 'index');
