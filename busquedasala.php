<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos/estilobusqueda.css">
    <title>Busqueda</title>
</head>
<body> 
    <center>
    <div class="header">
			<a href="https://www.gob.mx/" target="_blank"><!--GOBIERNO DE MÉXICO-->
			<img class="img" src="https://www.cuautla.tecnm.mx/assets/files/main/img/pleca-gob1.png" alt="Gobierno de México" width="200" height="60">
			</a>
			<a href="https://www.gob.mx/sep" class="btn-hv" target="_blank"><!--SEP-->
				<img class="img" src="https://www.cuautla.tecnm.mx/assets/files/main/img/pleca-gob2.png" alt="Educación" width="200" height="60">
			</a>
			<a href="https://www.cuautla.tecnm.mx/"><!--TECNM-->
			<img class="img" src="https://www.cuautla.tecnm.mx/assets/files/main/img/pleca_tecnm.jpg" alt="TecNM" width="200px" height="68px">
			</a>
			<a href="" target="_blank"><!--ITC-->
			<img class="itc" src="https://www.cuautla.tecnm.mx/img/itcuautla.png" width="80px" height="58px">
			</a>
			</div>
    <h1>Buscar salas apartadas</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
        <label for="busqueda">Buscar:</label>
        <input type="text" name="busqueda" id="busqueda" placeholder="Código de apartado">
        <input type="submit" value="Buscar" id="boton">
    </form><br>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET['busqueda'])) {
// Configuración de la conexión a la base de datos MySQL
$servername = "localhost"; 
$username = "root"; 
$password = "rootayala"; 
$database = "sistema_apartado";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener la búsqueda del formulario
$busqueda = $_GET['busqueda'];

// Consulta SQL para buscar en la base de datos
$sql = "SELECT * FROM apartar_sala WHERE Num_apartado LIKE '%$busqueda%'"; // Cambiar 'tabla' y 'columna' según tu estructura de base de datos

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mostrar los resultados
    echo "<h2>Resultados de la búsqueda:</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Fecha de Registro</th><th>Hora de Registro</th><th>Sala</th><th>Fecha de Inicio</th><th>Fecha de Término</th><th>Hora de Inicio</th><th>Hora de Término</th><th>Nombre del Evento</th><th>Responsable</th><th>Materiales</th><th>Código de Apartado</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["Fecha_registro"]. "</td>";
        echo "<td>" . $row["Hora_registro"]. "</td>";
        echo "<td>" . $row["Sala"]. "</td>";
        echo "<td>" . $row["Fecha_inicio"]. "</td>";
        echo "<td>" . $row["Fecha_termino"]. "</td>";
        echo "<td>" . $row["Hora_inicio"]. "</td>";
        echo "<td>" . $row["Hora_termino"]. "</td>";
        echo "<td>" . $row["Nombre_Evento"]. "</td>";
        echo "<td>" . $row["Responsable"]. "</td>";
        echo "<td>" . $row["Materiales"]. "</td>";
        echo "<td>" . $row["Num_apartado"]. "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron resultados para tu búsqueda.";
}


// Cerrar la conexión
$conn->close();
        }
    }
?>
</center>
</body>
</html>