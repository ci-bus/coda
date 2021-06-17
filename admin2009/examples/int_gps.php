<?php
error_reporting(0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style>
		html {
			font-family: sans-serif;
			line-height: 1.15;
			-webkit-text-size-adjust: 100%;
			-ms-text-size-adjust: 100%;
			-ms-overflow-style: scrollbar;
			-webkit-tap-highlight-color: rgba(34, 42, 66, 0);
		}

		body {
			margin: 0;
			font-family: "Poppins", sans-serif;
			font-size: 0.875rem;
			font-weight: 400;
			line-height: 1.5;
			color: #525f7f;
			text-align: left;
			background-color: #1e1e2f;
		}

		.titulos {
			font-size: 18px;
			font-weight: bold;
		}

		#tab_tem th {
			background-color: #5a86fa;
		}

		.centro {
			tex-align: center;
		}

		#tab_tem {
			border-collapse: collapse;
		}

		#tab_tem tr {}

		.filapar {
			background-color: #284fb6;
			color: #161616;
		}

		.filaimpar {
			background-color: #0b4cf7;
			color: #161616;
		}

		.verde {
			color: #12b808;
		}

		.rojo {
			color: #f7200b;
		}

		.frojo {
			background-color: #f7200b;
		}

		.negrita {
			font-weight: bold;
		}

		.dorsal {
			text-align: center;
			font-size: 24px;
			font-weight: 600;
			font-style: italic;
			text-shadow: 2px 2px 2px aliceblue;
			margin: -12px auto;
		}

		.carretera {
			background: url("img/carretera.png");
		}
	</style>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<!--script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script-->
	<script>
		function cargar(pagina, divid, capa) {
			var url = pagina;
			var div = divid;
			div = '#' + div;
			var capa = capa;
			capa = '#' + capa;
			jQuery(capa).ready(function() {

				jQuery(div).ajaxStart(function() {
					jQuery(this).css('display', 'block');
				});

				jQuery(div).ajaxStop(function() {
					jQuery(this).hide();
				});

				setTimeout(jQuery(capa).load(url), 500);

			});
		}
	</script>
</head>

<body>
	<?php
	//$uss= "seguimiento6";
	//$pass = "granada";
	$cuenta_int = 1; /// SI DE MODIFICAN EL NOMBRE DE LOS INTERMEDIOS, SOLO TOCAR ESTA VARIABLE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	$num_coche = 1;

	if (isset($_POST['id'])) {
		$id = $_POST['id'];
	}
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	}

	if (isset($_POST['pass'])) {
		$pass = $_POST['pass'];
	}
	if (isset($_GET['pass'])) {
		$pass = $_GET['pass'];
	}

	if (isset($_POST['uss'])) {
		$uss = $_POST['uss'];
	}
	if (isset($_GET['uss'])) {
		$uss = $_GET['uss'];
	}

	if (isset($_POST['url'])) {
		$url = $_POST['url'];
	}
	if (isset($_GET['url'])) {
		$url = $_GET['url'];
	}

	if (isset($_POST['idmanga'])) {
		$idmanga = $_POST['idmanga'];
	}
	if (isset($_GET['idmanga'])) {
		$idmanga = $_GET['idmanga'];
	}
	//echo $url;
	//$url = "https://rest.anube.es/rallyrest/default/api/split_times/2829/1.xml?_username=tracking4&_password=21lou";
	?>
	<script>
		/*Esta es la famosa recarga automatica de evento, en este caso la usaremos de forma general*/
		var seconds = 10; // el tiempo en que se refresca
		var divid = "recarga"; // el div que quieres actualizar!
		var url = "int_gps.php?idmanga=<?php echo $idmanga; ?>&id=<?php echo $id; ?>&url=<?php echo $url ?>"; // el archivo que ira en el div

		function refreshdiv() {

			// The XMLHttpRequest object

			var xmlHttp;
			try {
				xmlHttp = new XMLHttpRequest(); // Firefox, Opera 8.0+, Safari
			} catch (e) {
				try {
					xmlHttp = new ActiveXObject("Msxml2.XMLHTTP"); // Internet Explorer
				} catch (e) {
					try {
						xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
					} catch (e) {
						alert("Tu explorador no soporta AJAX.");
						return false;
					}
				}
			}

			// Timestamp for preventing IE caching the GET request
			var timestamp = parseInt(new Date().getTime().toString().substring(0, 10));
			var nocacheurl = url + "&t=" + timestamp;

			// The code...

			xmlHttp.onreadystatechange = function() {
				if (xmlHttp.readyState == 4 && xmlHttp.readyState != null) {
					document.getElementById(divid).innerHTML = xmlHttp.responseText;
					setTimeout('refreshdiv()', seconds * 1000);
				}
			}
			xmlHttp.open("GET", nocacheurl, true);
			xmlHttp.send(null);
		}

		// Empieza la función de refrescar
		refreshdiv(); // corremos inmediatamente la funcion
	</script>

	<?php
	if (isset($url)) {
		$time = simplexml_load_file($url) or print(" ****error en la carga del archivo XML");
		echo "<div id='recarga'>";
		include("../../conexion.php");
		include("../../includes/funcionesTiempos.php");
		echo "<p class='titulos'>API INTERMEDIOS EN FUNCIONAMIENTO! NO CERRAR HASTA FINALIZAR EL TRAMO<p>";
		echo "URL: " . $url . "&IDMANGA: " . $idmanga . " ID: " . $id;
		$sql = "SELECT descripcion FROM abc_57os_ca_manga_control_horario WHERE id_ca_manga='$idmanga' AND orden!=5 AND orden!=10 ORDER BY orden";
		$resultado = $mysqli->query($sql);
		$num_int = $resultado->num_rows;
		if ($num_int == 0)
			echo "No existen puntos Tiempos Intermedios En Esta Manga";
		else {
			$num_inter = $num_int;
			echo "<table id='tab_tem' border='0' width='100%'>
			<thead>
			<tr><th>N.</th>";
			while ($row = $resultado->fetch_array()) {
				$desc = $row['descripcion'];
				echo "<th>" . $desc . "</th>";
			}
			echo "<th>TIEMPO</th></tr></thead>";
		}
		$sql = "SELECT com.id_ca_carrera AS idCarrera,com.id AS idconcursante, m.tipo AS tipo_manga,m.numero AS num_manga,com.dorsal,pi.nombre AS piloto_nombre,
	con.nombre AS competidor,
	veh.grupo AS grupo,veh.clase AS clase,veh.marca AS marca,veh.modelo As modelo,pi.nacionalidad AS pi_nac
	FROM abc_57os_ca_carrera car
	INNER JOIN abc_57os_ca_competidor com ON car.id=com.id_ca_carrera
	INNER JOIN abc_57os_ca_etapa e ON e.id_ca_carrera=car.id
	INNER JOIN abc_57os_ca_seccion s ON s.id_ca_etapa=e.id
	INNER JOIN abc_57os_ca_manga m ON m.id_ca_seccion=s.id
	INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto
	INNER JOIN abc_57os_ca_concursante con ON con.id=com.id_ca_concursante
	INNER JOIN abc_57os_ca_vehiculo veh ON veh.id=com.id_ca_vehiculo
	WHERE m.id='$idmanga' AND com.autorizado=1 GROUP BY dorsal";

		$resultado = $mysqli->query($sql) or print "No se pudo acceder al contenido de los tiempos online.";
		if ($resultado->num_rows > 0) {
			while ($fila = $resultado->fetch_array()) {
				$idCarrera = $fila['idCarrera'];
				$dorsal = $fila['dorsal'];
				$competidor = $fila['competidor'];
				$piloto = $fila['piloto_nombre'];
				$vehiculo = $fila['marca'];
				$modelo = $fila['modelo'];
				$grupo = $fila['grupo'];
				$clase = $fila['clase'];
				$idcomp = $fila['idcompetidor'];
				$pi_nac = $fila['pi_nac'];
				$co_nac = $fila['co_nac'];
				$num_manga = $fila['num_manga'];
				$tipo_manga = $fila['tipo_manga'];
				$idconcursante = $fila['idconcursante'];
				$comp = $mysqli->query("SELECT ch.orden AS orden,t.tiempo FROM abc_57os_ca_tiempo t 
			INNER JOIN abc_57os_ca_manga_control_horario ch ON ch.id=t.id_ca_manga_control_horario 
			WHERE t.dorsal='$dorsal' AND t.id_ca_manga='$idmanga'"); //EVITO SALIDAS Y LLEGADAS
				$t_s = 0;
				$t_l = 0;
				$i1 = 0;
				$i2 = 0;
				$i3 = 0;
				$i4 = 0;
				$i5 = 0;
				$gps[1] = '***';
				$gps[2] = '***';
				$gps[3] = '***';
				$gps[4] = '***';
				$gps[5] = '***';
				if ($comp->num_rows > 0) //TODOS LOS PUNTOS SALIDA,LLEGADAS E INTERM
				{
					while ($fil = $comp->fetch_array()) {
						$orden = $fil['orden'];
						if ($orden == 5) { //ES SALIDA
							$t_s = $fil['tiempo'];
						}
						if ($orden == 10) { //ES LLEGADA
							$t_l = $fil['tiempo'];
						}
						if ($orden == 6) { //I1
							$i1 = $fil['tiempo'];
						}
						if ($orden == 7) { //I2
							$i2 = $fil['tiempo'];
						}
						if ($orden == 8) { //I3
							$i3 = $fil['tiempo'];
						}
						if ($orden == 9) { //I3
							$i4 = $fil['tiempo'];
						}
						if ($orden == 11) { //I3
							$i5 = $fil['tiempo'];
						}
					}
					$cuenta_int2 = $cuenta_int;
					$j = 0;
					foreach ($time->entry as $times) {
						$bus = $times[$j]['carNo'];
						if ($bus == $dorsal) //ENCOONTRAR Dorsal Q PERTENECE ESE TIEMPO
						{
							while ($cuenta_int2 != $num_inter + 1) {
								$hour = "hour" . $cuenta_int2;
								$int = $times[0]->hours[0][$hour];
								if ($int != '***') //ESTADO DEL GPS SIN TIEMPO PERO CON INTERMEDIO PREPARADO
								{
									$horas = 3600 * (substr($int, 11, 2));
									$minutos = 60 * (substr($int, 14, 2));
									$segundos = substr($int, 17, 2);
									$milesimas = substr($int, 20, 3);
									$valor = strrchr($milesimas, ':');
									if ($valor == ':')
										$milesimas = '000';
									$t_paso = $horas + $minutos + $segundos . $milesimas;
									$t_invertido = $t_paso - (tiempo_a_milisegundos($t_s));
									$gps[$cuenta_int2] = milisegundos_a_tiempo($t_paso);
									//echo tiempo_a_milisegundos($t_s)."--".$t_paso;
									//-----------------------AVERIGUAR ID DEL n.INTERMEDIO En BD -------------------
									$id_ch = $mysqli2->query("SELECT id FROM web_manga_control_horario WHERE id_ca_manga = '$idmanga' AND orden='$cuenta_int2'");
									while ($filab = $id_ch->fetch_array())
										$ch = $filab['id'];
									//echo "N.INT: " . $cuenta_int2 . " CH: " . $ch;
									$nombre_intermedio = "i" . $cuenta_int2;
									//echo $nombre_intermedio;
									/*---------------------------------------------------*/
									$com_exi = $mysqli2->query("SELECT id FROM web_intermedios 
									WHERE idinscrito='$idconcursante' AND idmanga='$idmanga'");
									if ($com_exi->num_rows == 0) {
										//$sqli = $mysqli->query("INSERT INTO abc_57os_ca_tiempo (id,id_usuario,id_ca_competidor,id_ca_carrera,id_ca_manga,id_ca_manga_control_horario,dorsal,tiempo) VALUES ('','2','$idconcursante','$idCarrera','$idmanga','$ch','$dorsal','$t_paso')");
										$sqli = $mysqli2->query("INSERT INTO web_intermedios (id,idinscrito,idmanga,$nombre_intermedio) 
										VALUES ('','$idconcursante','$idmanga','$t_invertido')");
									} else {
										//$sqli = $mysqli2->query("UPDATE abc_57os_ca_tiempo SET tiempo = '$t_paso' WHERE id_ca_competidor = '$idconcursante' AND id_ca_manga_control_horario = '$ch'");
										$sqli = $mysqli2->query("UPDATE web_intermedios SET $nombre_intermedio = '$t_invertido' WHERE idinscrito = '$idconcursante' AND idmanga = '$idmanga'");
									}
								}
								//else echo "NO EXISTE PUNTO EN API ANUBE";
								$cuenta_int2++;
							}
						}
						$j++;
					}
					$ordenar[] = array(
						'piloto' => $piloto,
						'copiloto' => $copiloto,
						'dorsal' => $dorsal,
						'vehiculo' => $vehiculo,
						'modelo' => $modelo,
						'grupo' => $grupo,
						'clase' => $clase,
						'gps1' => $gps[1],
						'gps2' => $gps[2],
						'gps3' => $gps[3],
						'gps4' => $gps[4],
						'gps5' => $gps[5],
						'i1' => $i1,
						'i2' => $i2,
						'i3' => $i3,
						'i4' => $i4,
						'i5' => $i5,
						't_s' => $t_s,
						't_l' => $t_l,
						'tipo' => $tipo,
						'hora' => $hora,
						'pi_nac' => $pi_nac,
						'co_nac' => $co_nac,
						'idconcursante' => $idconcursante,
						'competidor' => $competidor
					);
				}
			}
		}
		foreach ($ordenar as $key => $row) {
			$aux[$key] = $row['t_s'];
		}
		array_multisort($aux, SORT_ASC, $ordenar);
		$pos = 1;
		foreach ($ordenar as $key => $row) {
			if ($par % 2 == 0)
				$classcss = 'filapar';
			else
				$classcss = 'filaimpar';
			echo "<tr class='" . $classcss . "' alt='" . $piloto . "'><td><span class='dorsal'>" . $row['dorsal'] . "</span><br><span class='negrita'>" . $row['t_s'] . "</span></td>";
			for ($i = 1; $i <= $num_int; $i++) //contruir los intermedios AUT
			{
				$int = "i" . $i;
				$gps = "gps" . $i;
				if ($row[$int] == 0)
					echo "<td>BD - <br>GPS: " . $row[$gps] . "</td>";
				else {
					echo "<td><span class='verde negrita'>BD: " . $row[$int] . "</span><br>GPS: " . $row[$gps] . "</td>";
				}
			}
			echo '<td class="centro">' . $row['t_l'] . '</td></tr>';
			/*POSICIONES DEL VEHICULO*/
			if ($row['t_l'] != 0) //META y/o podemos meter tambien SI HA SALIDO
				echo "<tr class='carretera'><td></td><td></td><td></td><td></td><td></td><td><img src='img/coche" . $num_coche . ".png' width='35px'></td></tr>";
			else {
				$punto = 0;
				for ($i = 1; $i <= $num_int; $i++) //construir los intermedios AUT
				{
					$ii = $i + 1;
					$int = "i" . $i;
					$iint = "i" . $ii; //SIGUIENTE INTERMEDIO
					$n_int = $row[$int];
					$n_iint = $row[$iint];
					//echo $int."-".$n_int."++";
					if ($n_int != 0 || $n_int != '-') //SABER EN QUE PUNTO INT SE ENCUENTRA
					{
						$punto++;
					}
				}
				//echo $row['dorsal']."--".$punto."<br>";
				//CONTRUIR LA TABLA	
			}
			echo "<tr class='carretera'>";
			echo "<td></td>";
			for ($i = 1; $i <= $num_int; $i++) //construir los intermedios AUT
			{
				if ($i == $punto)
					echo "<td><img src='img/coche" . $num_coche . ".png' width='35px'></td>";
				else
					echo "<td></td>";
			}
			echo "<td></td>";
			echo "</tr>";
			/*FIN POSICIONES*/
			if ($num_coche == 10)
				$num_coche1;
			else
				$num_coche++;
			$par++;
			$pos++;
			$tiempo_anterior = $row['tiempo'];
		} //FOREACH
		echo "</table></div>";
	} else {
		echo "<p class='titulos'>API INTERMEDIOS CON ANUBE</p>";
		//echo "<h1>PUNTO INTERMEDIO 1</h1><br>";
		echo "<form name='intermedios' action='int_gps.php' method='post'>";
		echo "<br>";
		echo "URL CON ARCHIVO XML: <input name='url' type='text' size='80'><br>";
		echo "USUARIO: <input name='uss' type='text' size='80'><br>";
		echo "PASSWORD: <input name='pass' type='text' size='80'><br>";
		echo "<input name='idmanga' type='hidden' value='" . $idmanga . "'><br>";
		echo "<input name='id' type='hidden' value='" . $id . "'><br>";
		echo "<input type='submit' value='ENVIAR'>";
		echo "</select>";
		echo "</form>";
	}
	?>
</body>

</html>