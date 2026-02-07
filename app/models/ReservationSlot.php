<?php

require_once dirname(__DIR__) . '/core/Database.php';

class ReservationSlot
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Crear un bloque de horario para una reservación
     */
    public function create(
        int $reservationId,
        string $date,
        string $startTime,
        string $endTime
    ): bool {
        $sql = "
            INSERT INTO reservation_slots (reservation_id, date, start_time, end_time)
            VALUES (:reservation_id, :date, :start_time, :end_time)
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':reservation_id', $reservationId, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':start_time', $startTime);
        $stmt->bindParam(':end_time', $endTime);

        return $stmt->execute();
    }

    /**
     * Obtener todos los bloques de una reservación
     */
    public function getByReservation(int $reservationId): array
    {
        $sql = "
            SELECT date, start_time, end_time
            FROM reservation_slots
            WHERE reservation_id = :reservation_id
            ORDER BY date, start_time
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':reservation_id', $reservationId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Verificar si existe traslape para una sala, fecha y horario
     */
    public function hasConflict(
        int $roomId,
        string $date,
        string $startTime,
        string $endTime
    ): bool {
        $sql = "
            SELECT 1
            FROM reservation_slots rs
            JOIN reservations r ON r.id = rs.reservation_id
            WHERE r.room_id = :room_id
              AND rs.date = :date
              AND (
                    (rs.start_time < :end_time AND rs.end_time > :start_time)
                  )
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':room_id', $roomId, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':start_time', $startTime);
        $stmt->bindParam(':end_time', $endTime);
        $stmt->execute();

        return (bool) $stmt->fetchColumn();
    }

    /**
     * Obtener todos los bloques ocupados de una sala en una fecha
     * (para mostrar disponibilidad)
     */
    public function getOccupiedSlots(int $roomId, string $date): array
    {
        $sql = "
            SELECT rs.start_time, rs.end_time
            FROM reservation_slots rs
            JOIN reservations r ON r.id = rs.reservation_id
            WHERE r.room_id = :room_id
              AND rs.date = :date
            ORDER BY rs.start_time
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':room_id', $roomId, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
