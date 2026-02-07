<?php

class Database
{
    private static ?PDO $connection = null;

    /**
     * Devuelve una conexión PDO activa
     */
    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            self::connect();
        }

        return self::$connection;
    }

    /**
     * Crea la conexión PDO
     */
    private static function connect(): void
    {
        $config = require dirname(__DIR__) . '/config/database.php';

        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";

        try {
            self::$connection = new PDO(
                $dsn,
                $config['user'],
                $config['password'],
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            die('Error de conexión a la base de datos');
        }
    }
}
