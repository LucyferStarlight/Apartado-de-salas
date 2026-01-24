<?php

require_once __DIR__ . '/Session.php';

class Auth
{
    public static function requireLogin(): void
    {
        if (!Session::isActive()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }
}
