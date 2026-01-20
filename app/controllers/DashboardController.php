<?php

require_once __DIR__ . '/../Helpers/Session.php';

class DashboardController
{
    /**
     * Muestra el dashboard principal
     */
    public function index(): void
    {
        // Proteger la ruta
        if (!Session::isActive()) {
            header('Location: /login');
            exit;
        }

        // Obtener datos del usuario desde la sesión
        $user = $_SESSION['user'];

        // Cargar la vista
        require_once dirname(__DIR__) . '/views/dashboard/index.php';
    }
}
