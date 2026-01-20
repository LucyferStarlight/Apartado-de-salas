<?php

require_once dirname(__DIR__) . '/core/Database.php';

class User
{
    /**
     * Autentica un usuario por username y contraseña
     *
     * @param string $username
     * @param string $password
     * @return array|false
     */
    public function authenticate(string $username, string $password)
    {
        $db = Database::getConnection();

        $sql = "
            SELECT id, username, email, password, role
            FROM users
            WHERE username = :username
            LIMIT 1
        ";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':username', $username, PDO::PARAM_STR);

        $stmt->execute();

        $user = $stmt->fetch();

        // Si no existe el usuario
        if (!$user) {
            return false;
        }

        // Verificar contraseña
        if (!password_verify($password, $user['password'])) {
            return false;
        }

        // Nunca devolver la contraseña
        unset($user['password']);

        return $user;
    }
}
