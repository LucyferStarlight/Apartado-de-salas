<?php

require_once dirname(__DIR__) . '/core/Database.php';

class Material
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Obtener todos los materiales del catálogo
     * (útil para administración)
     */
    public function getAll(): array
    {
        $sql = "SELECT id, name, description FROM materials ORDER BY name";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener materiales disponibles para una sala específica
     */
    public function getByRoom(int $roomId): array
    {
        $sql = "
            SELECT 
                m.id,
                m.name,
                m.description,
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

    /**
     * Verifica si un material pertenece a una sala
     * (seguridad backend, no confiar en el frontend)
     */
    public function existsInRoom(int $materialId, int $roomId): bool
    {
        $sql = "
            SELECT 1
            FROM room_materials
            WHERE material_id = :material_id
              AND room_id = :room_id
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':material_id', $materialId, PDO::PARAM_INT);
        $stmt->bindParam(':room_id', $roomId, PDO::PARAM_INT);
        $stmt->execute();

        return (bool) $stmt->fetchColumn();
    }

    /**
     * Valida que todos los materiales pertenezcan a la sala
     */
    public function validateForRoom(array $materialIds, int $roomId): bool
    {
        
        if(empty($materialIds)){
            return true;
        }

        //Normalizar IDs: enterios únicos y válidos
        $materialIds = array_unique(
            array_filter(
                array_map('intval', $materialIds),
                fn($id) => $id > 0
            )
        );

        if(empty($materialIds)){
            return true;
        }

        foreach ($materialIds as $materialId) {
            if (!$this->existsInRoom((int)$materialId, $roomId)) {
                return false;
            }
        }

        return true;
    }

}
