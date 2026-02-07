<?php

require_once __DIR__ . '/Session.php';

class Auth
{
    /** 
    * Verifica si hay sesión activa
    */
    public static function check(): bool
    {
        return Session::isActive();
    }
    /**
    * Obtiene el usuario autenticado
     */
    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }
    /**
    * Exige que el usuario esté autenticado
    */
    public static function requireLogin(): void
    {
        if (!self::check()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }
    /**
    * Verifica que el usuario tenga un rol específico
    */
    public static function hasRole(string $role): bool
    {
        if (!self::check()) {
            return false;
        }

        return ($_SESSION['user']['role'] ?? null) === $role;
    }
    
    /**
    * Exige que el usuario tenga un rol específico
    */
    public static function requireRole(string $role): void
    {
        self::requireLogin();

        if (!self::hasRole($role)) {
            http_response_code(403);
            echo '403 - Acceso no autorizado';
            exit;
        }
    }
}
