<?php

require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Helpers/Session.php';

class AuthController
{
    /**
     * Muestra el formulario de login
     */
    public function showLogin(): void
    {
        // Si ya hay sesión activa, no tiene sentido mostrar login
        if (Session::isActive()) {
            header('Location: /dashboard');
            exit;
        }

        // Recuperar error si existe
        $error = Session::getFlash('error');

        // Mostrar vista
        require_once __DIR__ . '/../Views/auth/login.php';
    }

    /**
     * Procesa el login (POST)
     */
    public function login(): void
    {
        // Seguridad básica: solo aceptar POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /login');
            exit;
        }

        // Obtener datos del formulario
        $user = $_POST['user'] ?? '';
        $pass = $_POST['pass'] ?? '';

        // Validación mínima (no negocio, solo existencia)
        if (empty($user) || empty($pass)) {
            Session::setFlash('error', 'Todos los campos son obligatorios.');
            header('Location: /login');
            exit;
        }

        // Llamar al modelo
        $userModel = new User();
        $authResult = $userModel->authenticate($user, $pass);

        // Evaluar respuesta del modelo
        if ($authResult === false) {
            Session::setFlash('error', 'Usuario o contraseña incorrectos.');
            header('Location: /login');
            exit;
        }

        // Autenticación correcta → crear sesión
        Session::create($authResult);

        // Redirigir a dashboard
        header('Location: /dashboard');
        exit;
    }

    /**
     * Cierra sesión
     */
    public function logout(): void
    {
        Session::destroy();
        header('Location: /login');
        exit;
    }
}
