<?php

require_once dirname(__DIR__) . '/models/user.php';
require_once dirname(__DIR__) . '/Helpers/Session.php';

class AuthController
{
    public function showLogin(): void
    {
        if (Session::isActive()) {
            header('Location: dashboard');
            exit;
        }

        $error = Session::getFlash('error');

        require_once dirname(__DIR__) . '/views/auth/login.php';
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: login');
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

        if ($authResult === false) {
            Session::setFlash('error', 'Usuario o contraseña incorrectos.');
            header('Location: login');
            exit;
        }

        Session::create($authResult);

        header('Location: dashboard');
        exit;
    }
    //Función para salir de sesión
    public function logout(): void
    {
        Session::destroy();
        header('Location: login');
        exit;
    }
    
}
