<?php

require_once dirname(__DIR__) . '/models/Material.php';
require_once dirname(__DIR__) . '/Helpers/Auth.php';

class MaterialController
{
    /**
     * Devuelve los materiales disponibles para una sala (JSON)
     */
    public function byRoom(): void
    {
        Auth::requireLogin();

        if (!isset($_GET['room_id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'room_id requerido']);
            return;
        }

        $roomId = (int) $_GET['room_id'];

        $materialModel = new Material();
        $materials = $materialModel->getByRoom($roomId);

        header('Content-Type: application/json');
        echo json_encode($materials);
    }
}
