<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    form{
        width: 50%;
        height: 50%;
        text-align: center;
    }
    form,div.encabezado{
        margin-top: 20px;
        margin-left: 20%;
        margin-right: 20%;
        margin-bottom: 20px;
    }
    form,div.cuerpo{
        margin-top: 15px;
        margin-left: 20%;
        margin-right: 20%;
        margin-bottom: 35%;
    }
</style>
<body>
   <form action="<?= BASE_URL ?>/login" method="POST" enctype="application/x-www-form-urlencoded">

        <div>
            <label>Usuario</label><br>
            <input type="text" name="username" required>
        </div>

        <div>
            <label>Contraseña</label><br>
            <input type="password" name="password" required>
        </div>

        <button type="submit">Iniciar sesión</button>

    </form>

</body>
</html>