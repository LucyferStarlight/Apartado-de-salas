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
    <form action="/login" method="POST">
    <div name="encabezado">
        <center>
            <label>Inicio de Sesión</label>
        </center>
    </div>
    <div name="cuerpo">
    <label>Usuario</label><br>
    <input type="text" name="user" id="usr"><br>
    <label>Contraseña</label><br>
    <input type="text" name="pass" id="pass"><br>
    <input type="submit" value="Iniciar Sesión" id="btn" name="btn">
    </div>

    </form>
</body>
</html>