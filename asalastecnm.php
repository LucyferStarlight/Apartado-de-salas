<html>
		<head>
			<link rel="stylesheet" href="estilos/estilotecnol.css">
			<title>Página tec</title>
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
			<div id="formulario">
			<h1>Sistema de apartado de salas</h1>
			<p>
				Para evitar confusiones revise las salas ya apartadas con el botón "Ver salas apartadas"<br>
				En caso de no contar con el "am" o "pm" en la hora, utilice el formato de 24 horas <br><br>
				Al final de la página viene su codigo de apartado de salas, este le será útil para el <br>
				departamento de Comunicación y difusión, en el formato que les deberá de entregar. <br><br>
			</p>
			<p id="h5">
				Tenga en cuenta que el codigo de apartado cambia cada vez que presione el botón "Apartar" <br><br>
			</h5>
			<form method="POST" action="redireccionp.html">
			<label>Selecciona una sala para apartar</label>
			<select name="Sala" id="opciones" onchange="CambiarEstado()">
			<option value="" id="opcion"></option>
			<option value="Sala Zapata" id="SZapata">Sala Zapata</option>
			<option value="Sala Morelos" id="SMorelos">Sala Morelos</option>
			</select>
			<br><br>
			<a href="#Salastext" id="salas">Ver salas apartadas</a><br><br>
			<label>Fecha de inicio del evento</label>
			<input type="date" id="input" name="Finicio"><br><br>
			<label>Fecha de termino del evento</label>
			<input type="date" id="input" name="Ftermino"><br><br>
			<label>Hora de inicio (HH:MM)</label>
			<input type="time" id="input" name="Hinicio"><br><br>
			<label>Hora de termino (HH:MM)</label>
			<input type="time" id="input" name="Htermino"><br><br>
			<label>Nombre del evento</label>
			<input type="text" id="input" name="Evento"><br><br>
			<label>Jefe de departamento solicitante</label>
			<input type="text" id="input" name="responsable"><br><br>
			<label>Enlista el material que se usará</label><br>
		<div id="checkboxPantallas" style="display:none;">
			<input type="checkbox" name="pant" value="-Pantallas">
			<label>Pantallas</label><br>
		</div>
		<div id="checkboxMic" style="display:none;">
			<input type="checkbox" name="mic" value="<br>-Microfonos">
			<label>Microfonos</label><br>
		</div>
		<div id="checkboxBocina" style="display:none;">
			<input type="checkbox" name="bocinas" value="<br>-Bocinas">
			<label>Bocinas</label><br>
		</div>
		<div id="checkboxPodium" style="display:none;">
			<input type="checkbox" name="podium" value="<br>-Podium">
			<label>Podium</label><br>
		</div>
		<div id="checkboxCam360" style="display:none;">
			<input type="checkbox" name="cam360" value="<br>-Cámara 360°">
			<label>Cámara 360°</label><br>
		</div>
			<div id="checkboxTrasmin" style="display:none;" >
			<input type="checkbox" name="trans" value="<br>-Transmisión">
			<label>Transmisión</label><br>
		</div>
		<div id="checkboxInter" style="display:none;" >
			<input type="checkbox" name="inter" value="<br>-Internet">
			<label>Internet</label><br><br>
		</div>	
			<input type="submit" value="apartar" id="submit" onclick="comprobar()">
			</form>
			</div>
			<h2 id="Salastext">Salas apartadas</h2>
			<p id="aviso">
				Tenga en cuenta que el último registro es la última sala apartada.
			</p>
		<?php
				//Se declaran las variables para la conexion a la base de datos
					$host="localhost";
					$usuario="salas";
					$contraseña="apartadosalas";
					$bd="sistema_apartado" ; 
					//Se realiza la conexion a la base de datos
					$conexion=new mysqli($host,$usuario,$contraseña,$bd);
					//Se declaran las variables de los checkbox
					$pant=$_POST['pant'];
					$mic=$_POST['mic'];
					$bocina=$_POST['bocinas'];
					$podium=$_POST['podium'];
					$cam360=$_POST['cam360'];
					$trans=$_POST['trans'];
					$inter=$_POST['inter'];

				//Se declaran las variables de la base de datos
				$sala=$_POST['Sala'];	
				$fi=$_POST['Finicio'];
				$ft=$_POST['Ftermino'];
				$hi=$_POST['Hinicio'];
				$ht=$_POST['Htermino'];
				$evento=$_POST['Evento'];
				$resp=$_POST['responsable'];
				$ma=$pant.$mic.$bocina.$podium.$cam360.$trans.$inter;

				
				//Se realiza la consulta para mostrar la base de datos
				$consulta="SELECT * FROM apartar_sala ORDER BY Fecha_registro, Hora_registro ASC";
				//Se ejecuta la consulta y se obtiene el resultado
				$resultado=$conexion->query($consulta);
				//Se verifica si la consulta fue exitosa
				if ($resultado) {
				//Comienza la construcción de la tabla HTML
				echo "<center><table border='1' width='1300px' height='250px' align='center' bgcolor='#807E82' id='Salastext'>";
				echo "<tr><th>Fecha Registro</th><th>Hora Registro</th><th>Sala</th><th>Fecha Inicio</th><th>Fecha Termino</th><th>Hora Inicio</th><th>Hora Termino</th><th>Evento</th><th>Responsable</th><th>Material</th></tr></center>";
				//Se itera sobre los resultados y agrega cada fila a la tabla
				while ($registro = $resultado->fetch_assoc()) {
					echo "<tr>";
					echo "<td>" . $registro['Fecha_registro'] . "</td>";
					echo "<td>" . $registro['Hora_registro'] . "</td>";
					echo "<td>" . $registro['Sala'] . "</td>";
					echo "<td>" . $registro['Fecha_inicio'] . "</td>";
					echo "<td>" . $registro['Fecha_termino'] . "</td>";
					echo "<td>" . $registro['Hora_inicio'] . "</td>";
					echo "<td>" . $registro['Hora_termino'] . "</td>";
					echo "<td>" . $registro['Nombre_Evento'] . "</td>";
					echo "<td>" . $registro['Responsable'] . "</td>";
					echo "<td>" . $registro['Materiales'] . "</td>";
					echo "</tr>";
				}

				// Se cierra la tabla HTML
				echo "</table>";

				//Se liberan los resultados
				$resultado->free();
			}
			else {
				// Manejo de error si la consulta no fue exitosa
				echo "Error en la consulta: " . $conexion->error;
			}
			// Función para generar un número de apartado único
			function generarNumeroApartado() {
				$prefijo = "TECNM-";
				$numero_apartado = $prefijo . uniqid();

				return $numero_apartado;
			}
			// Generar un número de apartado único
			$numero_apartado = generarNumeroApartado();



			echo "Codigo de apartado: $numero_apartado<br>";


				//Se realiza la consulta para verificar si la sala ya está reservada en el mismo horario
				$sql = "SELECT * FROM apartar_sala WHERE Sala = '$sala' AND ((Fecha_inicio <= '$fi' AND Fecha_termino >= '$fi') OR (Fecha_inicio <= '$ft' AND Fecha_termino >= '$ft') OR (Fecha_inicio >= '$fi' AND Fecha_termino <= '$ft')) AND ((Hora_inicio <= '$hi' AND Hora_termino >= '$hi') OR (Hora_inicio <= '$ht' AND Hora_termino >= '$ht') OR (Hora_inicio >= '$hi' AND Hora_termino <= '$ht'))";

				$resultado = $conexion->query($sql);

				if ($resultado->num_rows > 0) {
					echo "La sala ya está reservada en este horario.";
				}else{
					//Se comprueba que todos los espacios este llenos
					if ($sala != "" && $fi != "" && $ft != "" && $hi != "" && $ht != "" && $evento != "" && $resp != "" && $ma != "") {
						// Obtener la fecha y hora actual del sistema
						date_default_timezone_set('America/Mexico_City');
						$fecha_actual = date("Y-m-d");
						$hora_actual = date("H:i:s");
				
						// Se insertan los datos del formulario en la base de datos
						$insertar = "INSERT INTO apartar_sala VALUES(CURDATE(), CURTIME(), '$sala', '$fi', '$ft', '$hi', '$ht', '$evento', '$resp', '$ma','$numero_apartado')";
				
						if (mysqli_query($conexion, $insertar)) { //Si no hay errores al ingresar los valores a la bd, se ejecuta este if
							echo "<br><br>Se apartó la sala con éxito";	
							header('Location: redireccion.php');
							exit();
						} else { //Caso contrario, si hay algun error al insertar un valor que no sea, se ejecuta este else
							echo "<br><br>Hubo un error de inserción: {$conexion->error}";
						}
					} else {
						//Si hubo algún input que no se lleno, se ejecuta este else
						echo "<br>Rellena todos los espacios correctamente";
					}
				}

				//Se cierra la conexion a la base de datos
				$conexion->close();	
		?>
	<br>
	<center>
	<a href="#formulario" id="salas">Regresar</a>
	</center>	
	</body>
</html>
	<script>
		function CambiarEstado(){
			var opciones= document.getElementById('opciones');
			var pantallas=document.getElementById('checkboxPantallas');
			var mic=document.getElementById('checkboxMic');
			var bocina=document.getElementById('checkboxBocina');
			var podium=document.getElementById('checkboxPodium');
			var cam360=document.getElementById('checkboxCam360');
			var transmision=document.getElementById('checkboxTrasmin');
			var internet=document.getElementById('checkboxInter');

			if(opciones.value=='Sala Zapata'){
				pantallas.style.display='block';
				mic.style.display='block';
				bocina.style.display='block';
				podium.style.display='block';
				cam360.style.display='block';
				transmision.style.display='block';
				internet.style.dislay='block';
			}
			else if(opciones.value=='Sala Morelos'){
				pantallas.style.display='block';
				mic.style.display='block';
				bocina.style.display='block';
				podium.style.display='none';
				cam360.style.display='none';
				transmision.style.display='block';
				internet.style.dislay='block';
			}
			else{
				pantallas.style.display='none';
				mic.style.display='none';
				bocina.style.display='none';
				podium.style.display='none';
				cam360.style.display='none';
				transmision.style.display='none';
				internet.style.dislay='none';
			}
		}
	</script>