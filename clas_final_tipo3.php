<?php
//TIPO 3, SUMa DE TODAS LAS MANGA OFICIALES
include("conexion.php");
include("includes/funcionesTiempos.php");
include("escudos.php");
if (isset($_GET["copa"]))
	$copa = $_GET["copa"];
else
	$copa = '0';
if (isset($_GET["campeonato"]))
	$campeonato = $_GET["campeonato"];
else
	$campeonato = '0';
//IMPORTANTE, SABER CUANDO SE PUEDE MOSTRAR LA CLASIFICACION (Boton en el sistema)
$campeonatos_carrera = $mysqli2->query("SELECT * FROM web_campeonatos WHERE idcarrera='$idCarrera'");
while ($mifila = $campeonatos_carrera->fetch_array()) {
	$nom = strtoupper($mifila['nombre']);
	$id_campeonato = $mifila['id'];
	$num_mangas_oficiales_campeonato = $mifila['mangas_oficiales'];
	//SE PODRIA COMPROBAR QUE EXISTAN TIEMPOS DENTRO A FIN DE NO MOSTRAR CAMPEONATOS VACIOS
	echo "<p class='negrita centro fu1'>" . $nom . "</p>";
	echo "<table id='tabla_tiempos'><tbody><th class='centro'>P.</th><th class='centro'>D.</th><th>CONCURSANTE</th><th class='centro'><img src='img/tactil.png' class='icono'>EQUIPO</th><th colspan='2'>VEHICULO</th><th class='centro'><p>PRIMERO</p><p>TIEMPO</p><p>ANTERIOR</p></th></tbody>";
	if ($copa == '0') {
		$sql = "SELECT inscritos.idinscrito,inscritos.piloto,inscritos.copiloto,SUM(tiempos.t_t) AS t_t,SUM(tiempos.penalizacion) AS penalizacion,inscritos.vehiculo,inscritos.concursante,inscritos.dorsal,inscritos.modelo,inscritos.grupo,
		inscritos.clase,inscritos.agrupacion,inscritos.categoria,inscritos.nac_piloto,inscritos.nac_copiloto,inscritos.nac_competidor
		FROM web_inscritos inscritos
	INNER JOIN web_tiempos tiempos ON tiempos.idinscrito = inscritos.idinscrito
	WHERE inscritos.autorizado=1 AND tiempos.idcampeonato='$id_campeonato' AND tiempos.tipo_manga=1
	GROUP BY inscritos.dorsal
	ORDER BY tiempos.t_t ASC";
		//COMPROBAR AQUI EL NUMERO DE MANGAS QUE HA HECHO CADA UNO CON LAS OFICIALES QUE HAY!!!!!!!!! SUPER IMPORTANTE
	} else {
		echo "MANDA COPA";
	}
	$resultado = $mysqli2->query($sql) or print "No se pudo acceder al contenido de los tiempos online CONSULTA1.";
	if ($resultado->num_rows > 0) {
		$pos = 1;
		$par = 0;
		while ($row = $resultado->fetch_array()) {
			$idinscrito = $row['idinscrito'];
			$cons_num_mangas_oficiales_competidas = $mysqli2->query("SELECT idtiempos FROM web_tiempos WHERE idinscrito = '$idinscrito' AND tipo_manga=1")->num_rows;
			if ($cons_num_mangas_oficiales_competidas == $num_mangas_oficiales_campeonato) {
				$piloto = $row['piloto'];
				$pi_nac = $row['nac_piloto'];
				$pi_nacs = explode('/', $pi_nac);
				$pi_nac1 = bandera($pi_nacs[0]);
				$pi_nac2 = bandera($pi_nacs[1]);

				$copiloto = $row['copiloto'];
				$copi_nac = $row['nac_copiloto'];
				$copi_nacs = explode('/', $copi_nac);
				$copi_nac1 = bandera($copi_nacs[0]);
				$copi_nac2 = bandera($copi_nacs[1]);
				if ($copiloto == '')
					$equipo = $piloto;
				else
					$equipo = "<img class='banderas' src='" . $pi_nac1 . "'><img class='banderas' src='" . $pi_nac2 . "'>" . $piloto . "<br><img class='banderas' src='" . $copi_nac1 . "'><img class='banderas' src='" . $copi_nac2 . "'>" . $copiloto;
				//AQUI HACER EL EQUIPO
				$dorsal = $row['dorsal'];
				$marca = $row['vehiculo'];
				$modelo = $row['modelo'];
				$grupo = $row['grupo'];
				$clase = $row['clase'];
				$agrupacion = $row['agrupacion'];
				$categoria = $row['categoria'];
				$vehiculo = $marca . "<br>" . $modelo . "<br><p>" . $grupo . "/" . $clase . "/" . $categoria . "/" . $agrupacion . "</p>";
				$concursante = $row['concursante'];
				$con_nac = $row['nac_competidor'];
				$con_nac = explode("/", $con_nac);
				$con_nac1 = bandera($con_nac[0]);
				$con_nac2 = bandera($con_nac[1]);
				$concursante = "<img class='banderas' src='" . $pi_nac1 . "'><img class='banderas' src='" . $pi_nac2 . "'>" . $concursante;
				$t_t = $row['t_t'];
				if ($pos == 1) {
					$mejor_tiempo = $t_t;
					$tiempo_anterior = $t_t;
				}
				$dif_primero = milisegundos_a_tiempo($t_t - $mejor_tiempo);
				$dif_anterior = milisegundos_a_tiempo($t_t - $tiempo_anterior);
				$t_t = milisegundos_a_tiempo($t_t);
				$penalizacion = milisegundos_a_tiempo($row['penalizacion']);
				if ($par % 2 == 0)
					$classcss = "filapar";
				else
					$classcss = "filaimpar";
				/*PREPARO LOS TIEMPOS PARA LA FILA*/
				if ($pos == 1) {
					if ($penalizacion == 0 || $penalizacion == '')
						$tiempos = "<p class='negrita nomargen'>" . $t_t . "</p>";
					else
						$tiempos = "<p class='negrita nomargen'>" . $t_t . "</p><p class='penalizaciones nomargen'>" . $penalizacion . "</p>";
				} else {
					if ($penalizacion == 0 || $penalizacion == '')
						$tiempos = "<p class='anterior cursiva nomargen'>" . $dif_anterior . "</p><p class='negrita nomargen'>" . $t_t . "</p><p class='cursiva nomargen'>" . $dif_primero . "</p>";
					else
						$tiempos = "<p class='anterior cursiva nomargen'>" . $dif_anterior . "</p><p class='negrita nomargen'>" . $t_t . "</p><p class='cursiva nomargen'>" . $dif_primero . "</p><p class='penalizaciones nomargen'>" . $penalizacion . "</p>";
				}
				echo "<tr class='" . $classcss . "'><td class='centro'>" . $pos . "</td><td class='dor'>" . $dorsal . "</td><td>" . $concursante . "</td><td>" . $equipo . "</td><td>" . escudo($vehiculo) . "</td><td>" . $vehiculo . "</td><td class='tie centro'>" . $tiempos . "</td></tr>";
				$par++;
				$pos++;
				$tiempo_anterior = $t_t;
			} //IF CONDICION SI HA HECHO TODAS LAS OFICIALES
		} //WHILE
	} //IF
	echo "</table>";
} //WHILE
?>
<br>
<br>
<p>ABANDONOS</p>
<table border="0" width="100%" id="tab_tem">
	<thead>
		<tr>
			<th>dorsal</th>
			<th>Concursante</th>
			<th>Equipo</th>
			<th>Vehiculo</th>
			<th>Control</th>
			<th>Raz&oacute;n</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>