<?php
// Se asume que el controlador ya validó sesión
require_once dirname(__DIR__, 2) . '/Helpers/Session.php';
require_once dirname(__DIR__, 2) . '/models/Room.php';
require_once dirname(__DIR__, 2) . '/models/Material.php';

$roomModel = new Room();
$rooms = $roomModel->getAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Apartar sala</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            background: #fff;
            padding: 25px;
            border-radius: 6px;
        }

        h1 {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 8px;
            margin: 6px 0 15px 0;
        }

        .slot {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 4px;
            background: #fafafa;
        }

        .actions {
            margin-top: 20px;
        }

        button {
            padding: 10px 15px;
            border: none;
            background: #0056b3;
            color: #fff;
            cursor: pointer;
            border-radius: 4px;
        }

        button.secondary {
            background: #6c757d;
        }

        .error {
            background: #f8d7da;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="container">

    <h1>Apartar sala</h1>

    <?php if ($error = Session::getFlash('error')): ?>
        <div class="error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/reservations/store">

        <!-- Sala -->
        <label for="room">Sala</label>
        <select name="room_id" id="roomSelect" required>
            <option value="">Seleccione una sala</option>
            <?php foreach ($rooms as $room): ?>
                <option value="<?= $room['id'] ?>">
                    <?= htmlspecialchars($room['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Evento -->
        <label for="event">Nombre del evento</label>
        <input type="text" name="event_name" required>

        <!-- Observaciones -->
        <label for="notes">Observaciones (opcional)</label>
        <textarea name="notes" rows="3"></textarea>

        <!-- Horarios -->
        <h3>Horarios solicitados</h3>

        <div id="slots">
            <div class="slot">
                <label>Fecha</label>
                <input type="date" name="dates[]" required>

                <label>Hora inicio</label>
                <input type="time" name="start_times[]" required>

                <label>Hora fin</label>
                <input type="time" name="end_times[]" required>
            </div>
        </div>

        <button type="button" class="secondary" onclick="addSlot()">Agregar otro horario</button>

        <!-- Materiales -->
        <h3>Material requerido</h3>
        <p>Los materiales disponibles dependerán de la sala seleccionada.</p>

        <!-- Por ahora vacío; se llenará después dinámicamente -->
        <div id="materials">
            <p><em>Seleccione una sala para ver los materiales disponibles.</em></p>
        </div>

        <div class="actions">
            <button type="submit">Enviar solicitud</button>
            <a href="<?= BASE_URL ?>/dashboard">Cancelar</a>
        </div>
    </form>

</div>

<script>
function addSlot() {
    const slots = document.getElementById('slots');

    const div = document.createElement('div');
    div.className = 'slot';

    div.innerHTML = `
        <label>Fecha</label>
        <input type="date" name="dates[]" required>

        <label>Hora inicio</label>
        <input type="time" name="start_times[]" required>

        <label>Hora fin</label>
        <input type="time" name="end_times[]" required>
    `;

    slots.appendChild(div);
}
</script>

</body>
</html>
<script>
const roomSelect = document.getElementById('roomSelect');
const materialsDiv = document.getElementById('materials');

roomSelect.addEventListener('change', async function () {
    const roomId = this.value;

    if (!roomId) {
        materialsDiv.innerHTML = '<p><em>Seleccione una sala para ver los materiales disponibles.</em></p>';
        return;
    }

    try {
        const response = await fetch(`<?= BASE_URL ?>/api/materials?room_id=${roomId}`)
        const materials = await response.json();

        if (materials.length === 0) {
            materialsDiv.innerHTML = '<p>No hay materiales disponibles para esta sala.</p>';
            return;
        }

        let html = '';

        materials.forEach(material => {
            html += `
                <div>
                    <label>
                        <input type="checkbox" name="materials[]" value="${material.id}">
                        ${material.name}
                    </label>
                </div>
            `;
        });

        materialsDiv.innerHTML = html;

    } catch (error) {
        materialsDiv.innerHTML = '<p>Error al cargar materiales.</p>';
    }
});
</script>
