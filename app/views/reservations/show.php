<?php
require_once dirname(__DIR__, 2) . '/Helpers/Session.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de solicitud</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 30px;
        }

        .container {
            background: #fff;
            padding: 25px;
            max-width: 900px;
            margin: auto;
            border-radius: 6px;
        }

        h1 {
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 20px;
        }

        ul {
            padding-left: 20px;
        }

        .actions {
            margin-top: 30px;
        }

        .actions form {
            display: inline-block;
            margin-right: 10px;
        }

        button {
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        .approve {
            background: #28a745;
            color: #fff;
        }

        .reject {
            background: #dc3545;
            color: #fff;
        }

        .back {
            background: #6c757d;
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="container">

    <h1>Detalle de solicitud</h1>

    <!-- Información general -->
    <div class="section">
        <strong>Evento:</strong> <?= htmlspecialchars($reservation['event_name']) ?><br>
        <strong>Sala:</strong> <?= htmlspecialchars($reservation['room_name']) ?><br>
        <strong>Solicitante:</strong> <?= htmlspecialchars($reservation['username']) ?><br>
        <strong>Estado:</strong> <?= ucfirst($reservation['status']) ?><br>
        <strong>Fecha de creación:</strong> <?= $reservation['created_at'] ?>
    </div>

    <!-- Horarios -->
    <div class="section">
        <h3>Horarios solicitados</h3>
        <ul>
            <?php foreach ($slots as $slot): ?>
                <li>
                    <?= $slot['date'] ?>
                    de <?= $slot['start_time'] ?> a <?= $slot['end_time'] ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Materiales -->
    <div class="section">
        <h3>Material solicitado</h3>
        <?php if (empty($materials)): ?>
            <p>No se solicitó material.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($materials as $m): ?>
                    <li><?= htmlspecialchars($m['name']) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <!-- Observaciones -->
    <?php if (!empty($reservation['notes'])): ?>
        <div class="section">
            <h3>Observaciones</h3>
            <p><?= nl2br(htmlspecialchars($reservation['notes'])) ?></p>
        </div>
    <?php endif; ?>

    <!-- Acciones -->
    <div class="actions">
        <?php if ($reservation['status'] === 'pendiente'): ?>

            <form method="POST" action="<?= BASE_URL ?>/reservations/approve">
                <input type="hidden" name="id" value="<?= $reservation['id'] ?>">
                <button class="approve">Aprobar</button>
            </form>

            <form method="POST" action="<?= BASE_URL ?>/reservations/reject">
                <input type="hidden" name="id" value="<?= $reservation['id'] ?>">
                <button class="reject">Rechazar</button>
            </form>

        <?php endif; ?>

        <a class="back" href="<?= BASE_URL ?>/reservations">Volver</a>
    </div>

</div>

</body>
</html>
