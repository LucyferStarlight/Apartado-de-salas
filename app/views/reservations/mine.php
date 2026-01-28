<?php
require_once dirname(__DIR__, 2) . '/Helpers/Session.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis solicitudes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 30px;
        }Apartar

        .container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        th {
            background: #f0f0f0;
        }

        .status {
            font-weight: bold;
        }

        .pendiente { color: #856404; }
        .aprobado { color   #155724; }
        .rechazado { color: #721c24 }
    </style>
</head>
<body>

<div class="container">

    <h1>Mis solicitudes</h1>

    <?php if(empty($reservations)): ?>
        <p>No has realizado ninguna solicitud.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Evento</th>
                    <th>Sala</th>
                    <th>Estado</th>
                    <th>Fecha de solicitud</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $r): ?>
                    <tr>
                        <td><?=htmlspecialchars($r['event_name']) ?></td>
                        <td><?=htmlspecialchars($r['room_name']) ?></td>
                        <td class="status <?= $r['status'] ?>"><?= ucfirst($r['status']) ?></td>
                        <td><?= $r['created_at'] ?></td>
                    </tr>
                    <?php endforeach ?>
            </tbody>
        </table>
        <?php endif ?>

        <p><a href="<?= BASE_URL ?>/dashboard"><- Volver al dashboard</a></p>

</div>

</body>
</html>