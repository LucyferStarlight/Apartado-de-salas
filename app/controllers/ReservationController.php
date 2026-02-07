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
    /**
     * Listado de reservaciones (ADMIN)
     */
    public function index(): void
    {
        // Solo admins
        Auth::requireRole('admin');

        $reservationModel = new Reservation();

        // Filtro opcional por estado
        $status = $_GET['status'] ?? null;

        if ($status) {
            $reservations = $reservationModel->getByStatus($status);
        } else {
            $reservations = $reservationModel->getAll();
        }

        require_once dirname(__DIR__) . '/views/reservations/index.php';
    }
    /**
     * Listado de reservaciones (USUARIOS/ENCARGADOS)
     */
    public function getByStatus(string $status): array
    {
        $allowed = ['pendiente', 'aprobado', 'rechazado'];

        if (!in_array($status, $allowed, true)) {
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
        $stmt->bindParam(':status', $status);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Aprobar (SOLO ADMIN)
     */
    public function approve(): void {
        Auth::requireRole('admin');

        // Validar método
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/reservations');
            exit;
        }

        // Obtener ID
        $id = $_POST['id'] ?? null;

        if (!$id) {
            Session::setFlash('error', 'Solicitud inválida.');
            header('Location: ' . BASE_URL . '/reservations');
            exit;
        }

        // Cambiar estado
        $reservationModel = new Reservation();
        $reservationModel->updateStatus((int)$id, 'aprobado');

        // Feedback
        Session::setFlash('success', 'Solicitud aprobada correctamente.');

        // Volver al listado
        header('Location: ' . BASE_URL . '/reservations');
        exit;
    }
    /**
     * Rechazar (SOLO ADMIN)
     */
    public function reject(): void
    {
        // Solo administradores
        Auth::requireRole('admin');

        // Validar método
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/reservations');
            exit;
        }

        // Obtener ID
        $id = $_POST['id'] ?? null;

        if (!$id) {
            Session::setFlash('error', 'Solicitud inválida.');
            header('Location: ' . BASE_URL . '/reservations');
            exit;
        }

        // Cambiar estado
        $reservationModel = new Reservation();
        $reservationModel->updateStatus((int)$id, 'rechazado');

        // Feedback
        Session::setFlash('success', 'Solicitud rechazada.');

        // Volver al listado
        header('Location: ' . BASE_URL . '/reservations');
        exit;
    }

    /**
     * Ver solicitudes individuales
     */
    public function mine(): void {

        Auth::requireLogin();

        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            Session::setFlash('error', 'Sesión inválida');
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $reservationModel = new Reservation();
        $reservations = $reservationModel->getByUser($userId);

        require_once dirname(__DIR__) . '/views/reservations/mine.php';
    }

    /**
     * Revisar información de solicitudes individuales
     */
    public function show(): void{
        Auth::requireRole('admin');

        $id = $_GET['id'] ?? null;

        if (!$id) {
            Session::setFlash('error', 'Solicitud no válida.');
            header('Location: ' . BASE_URL . '/reservations');
            exit;
        }

        $reservationModel = new Reservation();

        $reservation = $reservationModel->findById((int)$id);
        $slots = $reservationModel->getSlots((int)$id);
        $materials = $reservationModel->getMaterials((int)$id);

        if (!$reservation) {
            Session::setFlash('error', 'Solicitud no encontrada.');
            header('Location: ' . BASE_URL . '/reservations');
            exit;
        }

        require_once dirname(__DIR__) . '/views/reservations/show.php';
    }
}
