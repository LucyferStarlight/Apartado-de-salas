<?php
require_once dirname(__DIR__, 2) . '/Helpers/Session.php';
require_once dirname(__DIR__, 2) . '/Helpers/Auth.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitudes de Salas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 30px;
        }

        .container {
            background: #fff;
            padding: 20px;
            border-radius: 6px;
            max-width: 1000px;
            margin: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .status-pendiente {
            color: #856404;
            font-weight: bold;
        }

        .status-aprobado {
            color: #155724;
            font-weight: bold;
        }

        .status-rechazado {
            color: #721c24;
            font-weight: bold;
        }

        a {
            text-decoration: none;
            color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">

    <h1>Solicitudes de Apartado de Salas</h1>

    <p>
        <a href="<?= BASE_URL ?>/dashboard">← Volver al dashboard</a>
    </p>

    <?php if (empty($reservations)): ?>
        <p>No hay solicitudes registradas.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Evento</th>
                    <th>Sala</th>
                    <th>Solicitante</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $r): ?>
                    <tr>
                        <td><?= $r['id'] ?></td>
                        <td><?= htmlspecialchars($r['event_name']) ?></td>
                        <td><?= htmlspecialchars($r['room_name']) ?></td>
                        <td><?= htmlspecialchars($r['username']) ?></td>
                        <td class="status-<?= $r['status'] ?>">
                            <?= ucfirst($r['status']) ?>
                        </td>
                        <td><?= $r['created_at'] ?></td>
                        <td>
                        <?php if ($r['status'] === 'pendiente'): ?>
                            
                            <a href="<?= BASE_URL ?>/reservations/show?id=<?=$r['id'] ?>">Revisar</a>
                        <?php else: ?>
                            <?= ucfirst($r['status']) ?>
                        <?php endif; ?>
                    </td>
                    </tr>
                    
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>

</body>
</html>
