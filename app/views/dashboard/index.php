<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Apartado de Salas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Más adelante aquí irá Bootstrap -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 900px;
            margin: 40px auto;
            background: #ffffff;
            padding: 25px;
            border-radius: 6px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0;
        }

        .user-info {
            font-size: 14px;
        }

        .actions {
            margin-top: 20px;
        }

        .actions a {
            display: block;
            padding: 12px;
            margin-bottom: 10px;
            background-color: #0056b3;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
        }

        .actions a.admin {
            background-color: #6c757d;
        }

        .message {
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .logout {
            color: #c00;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- Encabezado -->
    <header>
        <h1>Sistema de Apartado de Salas</h1>
        <div class="user-info">
            Usuario: <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong><br>
            <a class="logout" href="<?= BASE_URL ?>/logout">Cerrar sesión</a>
        </div>
    </header>

    <!-- Mensajes -->
    <?php if ($success = Session::getFlash('success')): ?>
        <div class="message success">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <?php if ($error = Session::getFlash('error')): ?>
        <div class="message error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <!-- Acciones generales -->
    <section class="actions">
        <a href="<?= BASE_URL ?>/reservations/create">Apartar sala</a>
    <a href="<?= BASE_URL ?>/reservations/mine">Mis solicitudes</a>
    <a href="<?= BASE_URL ?>/logout">Cerrar sesión</a>

    </section>

    <!-- Acciones administrativas -->
    <?php if (!empty($_SESSION['user']['is_admin'])): ?>
        <section class="actions">
            <a href="/reservations" class="admin">Ver todas las solicitudes</a>
            <a href="/reservations?status=pendiente" class="admin">Solicitudes pendientes</a>
        </section>
    <?php endif; ?>

</div>

</body>
</html>
