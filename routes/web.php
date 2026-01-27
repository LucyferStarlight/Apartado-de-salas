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

// Reservaciones
$router->add('GET',  '/reservations/create', 'ReservationController', 'create');
$router->add('POST', '/reservations/store',  'ReservationController', 'store');
$router->add('GET', '/reservations', 'ReservationController', 'index');
//Aprobar
$router->add('POST', '/reservations/approve', 'ReservationController', 'approve');
//Rechazar
$router->add('POST', '/reservations/reject', 'ReservationController', 'reject');

//Ruta API interna
$router->add('GET', '/api/materials', 'MaterialController', 'byRoom');
