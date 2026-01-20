<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>

    <h1>Bienvenido, <?= htmlspecialchars($user['username']) ?></h1>

    <p>Rol: <?= htmlspecialchars($user['role']) ?></p>

    <a href="/logout">Cerrar sesión</a>

</body>
</html>
