<?php

require_once dirname(__DIR__) . '/core/Database.php';

class Reservation
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Crear una nueva reservación (expediente)
     */
    public function create(
        int $userId,
        int $roomId,
        string $eventName,
        ?string $notes = null
    ): int {
        $sql = "
            INSERT INTO reservations (user_id, room_id, event_name, notes)
            VALUES (:user_id, :room_id, :event_name, :notes)
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':room_id', $roomId, PDO::PARAM_INT);
        $stmt->bindParam(':event_name', $eventName);
        $stmt->bindParam(':notes', $notes);

        $stmt->execute();

        // Devuelve el ID de la reservación creada
        return (int) $this->db->lastInsertId();
    }

    /**
     * Obtener una reservación por ID
     */
    public function findById(int $id): ?array
    {
        $sql = "
            SELECT 
                r.id,
                r.user_id,
                r.room_id,
                r.event_name,
                r.status,
                r.notes,
                r.created_at,
                u.username,
                rm.name AS room_name
            FROM reservations r
            JOIN users u ON u.id = r.user_id
            JOIN rooms rm ON rm.id = r.room_id
            WHERE r.id = :id
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

        return $reservation ?: null;
    }

    /**
     * Obtener todas las reservaciones
     * (para Comunicación y Difusión)
     */
    public function getAll(): array
    {
        $sql = "
            SELECT 
                r.id,
                r.event_name,
                r.status,
                r.created_at,
                rm.name AS room_name,
                u.username
            FROM reservations r
            JOIN rooms rm ON rm.id = r.room_id
            JOIN users u ON u.id = r.user_id
            ORDER BY r.created_at DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Cambiar el estado de la reservación
     */
    public function updateStatus(int $reservationId, string $status): bool
    {
        $allowedStatuses = ['pendiente', 'aprobado', 'rechazado'];

        if (!in_array($status, $allowedStatuses, true)) {
            throw new InvalidArgumentException('Estado de reservación inválido');
        }

        $sql = "
            UPDATE reservations
            SET status = :status
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $reservationId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Asignar materiales a una reservación
     */
    public function attachMaterials(int $reservationId, array $materialIds): void
    {
        // 1️⃣ borrar cualquier residuo previo
        $this->db->prepare(
            "DELETE FROM reservation_materials WHERE reservation_id = :id"
        )->execute([':id' => $reservationId]);

        // 2️⃣ normalizar
        $materialIds = array_unique(
            array_filter(
                array_map('intval', $materialIds),
                fn($id) => $id > 0
            )
        );

        // 3️⃣ insertar
        $stmt = $this->db->prepare(
            "INSERT INTO reservation_materials (reservation_id, material_id)
            VALUES (:reservation_id, :material_id)"
        );

        foreach ($materialIds as $materialId) {
            $stmt->execute([
                ':reservation_id' => $reservationId,
                ':material_id'    => $materialId
            ]);
        }

    }


    /**
     * Obtener materiales de una reservación
     */
    public function getMaterials(int $reservationId): array
    {
        $sql = "
            SELECT m.id, m.name
            FROM reservation_materials rm
            JOIN materials m ON m.id = rm.material_id
            WHERE rm.reservation_id = :reservation_id
            ORDER BY m.name
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':reservation_id', $reservationId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener reservaciones filtradas por estado
     */
    public function getByStatus(string $status): array
    {
        $allowedStatuses = ['pendiente', 'aprobado', 'rechazado'];

        if (!in_array($status, $allowedStatuses, true)) {
            return [];
        }

        $sql = "
            SELECT 
                r.id,
                r.event_name,
                r.status,
                r.created_at,
                rm.name AS room_name,
                u.username
            FROM reservations r
            JOIN rooms rm ON rm.id = r.room_id
            JOIN users u ON u.id = r.user_id
            WHERE r.status = :status
            ORDER BY r.created_at DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status, \PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Obtener reservaciones de un usuario específico
     */
    public function getByUser(int $userId): array{
        $sql = "
                    SELECT
                        r.id,
                        r.event_name,
                        r.status,
                        r.created_at,
                        rm.name AS room_name
                    FROM reservations r
                    JOIN rooms rm ON rm.id = r.room_id
                    WHERE r.user_id = :user_id
                    ORDER BY r.created_at DESC
                ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener reservaciones
     */
    public function getSlots(int $reservationId): array{
        $sql = "
                SELECT date, start_time, end_time
                FROM reservation_slots
                WHERE reservation_id = :id
                ORDER BY date, start_time
            ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $reservationId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
