<?php

require_once dirname(__DIR__) . '/models/Reservation.php';
require_once dirname(__DIR__) . '/models/ReservationSlot.php';
require_once dirname(__DIR__) . '/models/Material.php';
require_once dirname(__DIR__) . '/Helpers/Session.php';
require_once dirname(__DIR__) . '/Helpers/Auth.php';
require_once dirname(__DIR__) . '/core/Database.php';

class ReservationController
{
    /**
     * Mostrar formulario de creación
     */
    public function create(): void
    {
        Auth::requireLogin();

        require_once dirname(__DIR__) . '/views/reservations/create.php';
    }

    /**
     * Procesar la creación de la reservación
     */
    public function store(): void
    {
        Auth::requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: '. BASE_URL . '/reservations/create');
            exit;
        }

        // === 1. Obtener datos del formulario ===
        $userId   = $_SESSION['user']['id'] ?? null;
        $roomId   = $_POST['room_id'] ?? null;
        $event    = trim($_POST['event_name'] ?? '');
        $notes    = trim($_POST['notes'] ?? '');

        $dates       = $_POST['dates'] ?? [];      // array
        $startTimes  = $_POST['start_times'] ?? []; // array
        $endTimes    = $_POST['end_times'] ?? [];   // array
        $materials   = $_POST['materials'] ?? [];   // array
        $materials   = array_map('intval',$materials);

        // === 2. Validación mínima ===
        if (!$userId || !$roomId || empty($event)) {
            Session::setFlash('error', 'Datos incompletos.');
            header('Location: '. BASE_URL . '/reservations/create');
            exit;
        }

        if (count($dates) === 0) {
            Session::setFlash('error', 'Debe agregar al menos un horario.');
            header('Location: '. BASE_URL . '/reservations/create');
            exit;
        }

        // === 3. Inicializar modelos ===
        $reservationModel = new Reservation();
        $slotModel        = new ReservationSlot();
        $materialModel    = new Material();

        try {

        $db = Database::getConnection();
        $db->beginTransaction();

            // === 4. Crear reservación (expediente) ===
            $reservationId = $reservationModel->create(
                $userId,
                (int)$roomId,
                $event,
                $notes ?: null
            );

            // === 5. Validar y crear slots ===
            foreach ($dates as $index => $date) {
                $start = $startTimes[$index] ?? null;
                $end   = $endTimes[$index] ?? null;

                if (!$date || !$start || !$end) {
                    throw new Exception('Bloque horario incompleto.');
                }

                if ($slotModel->hasConflict((int)$roomId, $date, $start, $end)) {
                    throw new Exception("Conflicto de horario el $date de $start a $end.");
                }

                $slotModel->create($reservationId, $date, $start, $end);
            }

            // === 6. Asignar materiales ===
            if (!$materialModel->validateForRoom($materials, (int)$roomId)) {
                throw new Exception('Seleccionaste materiales no válidos para la sala.');
            }

            $reservationModel->attachMaterials($reservationId, $materials);


            // === COMMIT ===
            $db->commit();
            // === 7. Éxito ===
            Session::setFlash('success', 'La reservación fue creada correctamente.');
            header('Location:'. BASE_URL.'/dashboard');
            exit;

        } catch (Exception $e) {
            if(isset($db) && $db->inTransaction()){
                $db->rollBack();
            }

            //Errores
            Session::setFlash('error', $e->getMessage());
            header('Location: ' . BASE_URL . '/reservations/create');
            exit;
        }
    }
}
