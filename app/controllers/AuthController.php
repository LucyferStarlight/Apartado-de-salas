<?php

require_once dirname(__DIR__) . '/models/user.php';
require_once dirname(__DIR__) . '/Helpers/Session.php';

class AuthController
{
    public function showLogin(): void {
        
        if (Session::isActive()) {
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }


        require_once dirname(__DIR__) . '/views/auth/login.php';
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $user = $_POST['username'] ?? '';
        $pass = $_POST['password'] ?? '';

        if (empty($user) || empty($pass)) {
            Session::setFlash('error', 'Todos los campos son obligatorios.');
            header('Location: login');
            exit;
        }

        $userModel = new User();
        $authResult = $userModel->authenticate($user, $pass);

        if (!$authResult) {
            Session::setFlash('error', 'Usuario o contraseña incorrectos.');
            // Forzar guardado de sesión
            session_write_close();
            
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        Session::create($authResult);

        header('Location: ' .BASE_URL . '/dashboard');
        exit;
    }
    //Función para salir de sesión
    public function logout(): void
    {
        //Si no hay sesión, solo redirige
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }

        //Destruir sesión correctamente
        session_unset();
        session_destroy();

        //Regenerar ID por seguridad
        session_regenerate_id(true);

        //Redirigir al login
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
    
}
