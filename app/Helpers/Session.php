<?php

class Session
{
    /**
     * Inicia la sesión si no está activa
     */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Crea una sesión de usuario
     */
    public static function create(array $userData): void
    {
        self::start();
        $_SESSION['user'] = $userData;
    }

    /**
     * Verifica si hay sesión activa
     */
    public static function isActive(): bool
    {
        self::start();
        return isset($_SESSION['user']);
    }

    /**
     * Destruye la sesión
     */
    public static function destroy(): void
    {
        self::start();
        session_unset();
        session_destroy();
    }

    /**
     * Guarda un mensaje flash (temporal)
     */
    public static function setFlash(string $key, string $message): void
    {
        self::start();
        $_SESSION['flash'][$key] = $message;
    }

    /**
     * Obtiene y borra un mensaje flash
     */
    public static function getFlash(string $key): ?string
    {
        self::start();

        if (!isset($_SESSION['flash'][$key])) {
            return null;
        }

        $message = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);

        return $message;
    }
}
