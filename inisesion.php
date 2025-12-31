<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilos/estiloini.css">
    <title>Iniciar Sesion</title>
</head>
<body>
    <center>
    <div class="header">
        <a href="https://www.gob.mx/" target="_blank">
        <img src="https://www.cuautla.tecnm.mx/assets/files/main/img/pleca-gob1.png" alt="Gobierno de México" width="200" height="60">
        </a>
        <a href="https://www.gob.mx/sep" class="btn-hv" target="_blank">
			<img src="https://www.cuautla.tecnm.mx/assets/files/main/img/pleca-gob2.png" alt="Educación" width="200" height="60">
		</a>
        <a href="https://www.cuautla.tecnm.mx/"z><!--TECNM-->
        <img src="https://www.cuautla.tecnm.mx/assets/files/main/img/pleca_tecnm.jpg" alt="TecNM" width="200px" height="68px">
		</a>
        <a href="" target="_blank"><!--ITC-->
        <img class="" src="https://www.cuautla.tecnm.mx/img/itcuautla.png" width="80px" height="58px">
        </a>
    </div>
    </center>
    <p>
        
    </p>
    <form action="inisesion.php" method="POST">
        <h1>Iniciar Sesión</h1>
        <p>Para acceder a la página de "Apartado de salas" inicie sesion con su correo y contraseña por favor.</p>
        <input type="email" placeholder="Ingrese su Correo" name="correo" required>
        <input type="password" placeholder="Ingrese su contraseña" name="passw" required>
        <button>Iniciar Sesion</button>
<?php
    //Se declaran las variables para la conexion a la base de datos
			$host="localhost";
			$usuario="salas";
			$contraseña="apartadosalas";
			$bd="sesionestecnm"; 

            //Se realiza la conexion con la base de datos
            $conn=new mysqli($host,$usuario,$contraseña,$bd);

        //Se obtienen los datos del formulario
        $email=$_POST['correo'];
        $passwo=$_POST['passw'];
/*
Eliminar este bloque
*/

        //Se realiza la consulta para verificar que exista el correo y contraseña en la base de datos
        $consultaemail="SELECT * FROM responsablestec WHERE correo= '$email'";
        $resultadoe=$conn->query($consultaemail);

        //Se realiza la consulta para los encargados de Comunicacion y difusion
        $consultaCyD="SELECT * FROM Comunicacion_Difusion WHERE correo= '$email'";
        $resultadoeCyD=$conn->query($consultaCyD);

        if($resultadoe->num_rows > 0) {
            $consultapass="SELECT * FROM responsablestec WHERE pass= '$passwo'";
            $resultadop=$conn->query($consultapass);
        
            // Se verifica la contraseña
            if ($resultadop->num_rows > 0) {
                // Las credenciales son correctas
                echo "Inicio de sesión exitoso";
                
                //Redirige a la página de apartado de sesion
                header('Location: redireccion.html');
                exit();
            } else {
                // Contraseña incorrecta
                echo "Contraseña incorrecta";
            }
        } 
        else if ($resultadoeCyD->num_rows > 0) {
            $consultapCyD="SELECT * FROM Comunicacion_Difusion WHERE pass= '$passwo'";
            $resultadopCyD=$conn->query($consultapCyD);

            //Se verifica la contraseña
            if($resultadopCyD->num_rows > 0){
                //Las credenciales son correctas
                echo "Inicio de sesión exitoso";

                //Redirige a la página de busqueda de salas apartadas
                header('Location: redireccionbusqueda.html');
                exit();
            }else{
                //Contraseña incorrecta
                echo "Contraseña incorrecta";
            }
        }else {
            // Correo electrónico no encontrado en la base de datos
            echo "Correo electrónico no registrado";
        }
        
        // Liberar resultados y cerrar la conexión
        $resultadoe->free();
        $resultadop->free();
        $conn->close();
?>
    </form>
</body>
</html>
