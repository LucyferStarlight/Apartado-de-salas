<?php

require_once dirname(__DIR__) . '/core/Database.php';

class Room
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Obtener todas las salas
     */
    public function getAll(): array
    {
        $sql = "SELECT id, name FROM rooms ORDER BY name";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener una sala por ID
     */
    public function findById(int $id): ?array
    {
        $sql = "SELECT id, name FROM rooms WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $room = $stmt->fetch(PDO::FETCH_ASSOC);

        return $room ?: null;
    }

    /**
     * Obtener materiales disponibles para una sala
     * (se usará más adelante en el formulario)
     */
    public function getMaterials(int $roomId): array
    {
        $sql = "
            SELECT 
                m.id,
                m.name,
                rm.quantity
            FROM room_materials rm
            JOIN materials m ON m.id = rm.material_id
            WHERE rm.room_id = :room_id
            ORDER BY m.name
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':room_id', $roomId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
