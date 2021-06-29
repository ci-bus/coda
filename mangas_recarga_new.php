<?php
//echo $orden;
include("conexion.php");
include("escudos.php");
/*
if (isset($_GET["campeonato"]))
	$campeonato = $_GET["campeonato"];
else
	$campeonato = '0'; */
if (isset($_GET["copa"]))
	$copa = $_GET["copa"];
else
	$copa = '0';
//EN REALIDAD CON LA BD NUEVA SOLO NECESITO LA MANGA
if (isset($_GET["idmanga"]) && isset($_GET["id"])) {
	$idManga = $_GET["idmanga"];
	$idCarrera = $_GET["id"];
	//$idseccion = $_GET["idseccion"];
	//$idetapa = $_GET["idetapa"];
	//$DB_PREFIJO = "abc_57os_";
	$saber_manga = $mysqli2->query("SELECT numero,decimales FROM web_manga WHERE id='$idManga'")->fetch_array();
	$num_manga = $saber_manga['numero'];
	$decimales = $saber_manga['decimales'];
}
include("includes/funciones.php"); //ME CAGO EN SU PUTA MADRE QUE NO FUNCIONAA!!!!! REVISAR
include("includes/funcionesTiempos.php");
$campeonatos_carrera = $mysqli2->query("SELECT * FROM web_campeonatos WHERE idcarrera='$idCarrera'");
while ($mifila = $campeonatos_carrera->fetch_array()) {
	$nom = strtoupper($mifila['nombre']);
	$id_campeonato = $mifila['id'];
	//SE PODRIA COMPROBAR QUE EXISTAN TIEMPOS DENTRO A FIN DE NO MOSTRAR TITULOS VACIOS
	echo "<p class='negrita centro fu1'>" . $nom . "</p>";
	//TABLA CONTENEDORA DE LAS 2 TABLAS
	echo "<div id='div_contenedor'>";
	echo "<table id='tabla_contenedor'>";
	echo "<tr><td><p>TIEMPOS</p>";
	echo "<table id='tabla_tiempos'><tbody><th class='centro'>P.</th><th class='centro'>N.</th><th class='centro'><img src='img/tactil.png' class='icono'>EQUIPO</th><th colspan='2' class='centro'><p>Vehiculo</p><p class='mini1 nomargen'>Grupo/clase</p><p class='mini1 nomargen'>Cat./Agr.</p></th><th class='centro'><p class='mini1 nomargen'>PRIMERO</p><p>TIEMPO</p><p class='mini1 nomargen'>ANTERIOR</p></th></tbody>";
	if ($copa == '0') {
		$sql = "SELECT inscritos.piloto,inscritos.copiloto,tiempos.t_t,tiempos.penalizacion,inscritos.vehiculo,inscritos.concursante,inscritos.dorsal,inscritos.modelo,inscritos.grupo,
		inscritos.clase,inscritos.agrupacion,inscritos.categoria,inscritos.nac_piloto,inscritos.nac_copiloto,inscritos.nac_competidor,inscritos.sr
		FROM web_inscritos inscritos
	INNER JOIN web_tiempos tiempos ON tiempos.idinscrito = inscritos.idinscrito
	WHERE tiempos.idmanga='$idManga' AND inscritos.autorizado=1 AND tiempos.idcampeonato='$id_campeonato' 
	GROUP BY inscritos.dorsal
	ORDER BY tiempos.t_t ASC";
	} else {
		$sql = "SELECT inscritos.piloto,inscritos.copiloto,tiempos.t_t,tiempos.penalizacion,inscritos.vehiculo,inscritos.concursante,inscritos.dorsal,inscritos.modelo,inscritos.grupo,
		inscritos.clase,inscritos.agrupacion,inscritos.categoria,inscritos.nac_piloto,inscritos.nac_copiloto,inscritos.nac_competidor,inscritos.sr
		FROM web_inscritos inscritos
	INNER JOIN web_tiempos tiempos ON tiempos.idinscrito = inscritos.idinscrito
	INNER JOIN web_copas_inscritos copas ON tiempos.idinscrito=copas.idcompetidor
	WHERE tiempos.idmanga='$idManga' AND inscritos.autorizado=1 AND tiempos.idcampeonato='$id_campeonato' AND copas.idcopa='$copa' 
	GROUP BY inscritos.dorsal
	ORDER BY tiempos.t_t ASC";
	}
	$resultado = $mysqli2->query($sql) or print "No se pudo acceder al contenido de los tiempos online CONSULTA1.";

	if (!$resultado) {

		echo "Eiii piyinn<hr>";
		echo $sql;
	}
	if ($resultado->num_rows > 0) {
		$pos = 1;
		$par = 0;
		unset($pos_grupo);
		unset($pos_categoria);
		unset($pos_clase);
		unset($pos_agr);
		while ($row = $resultado->fetch_array()) {
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
			$dorsal = "<span class='dor'>" . $row['dorsal'] . "</span>";
			$sr = $row['sr'];
			if ($sr == 1)
				$dorsal .= "<br><span class='negrita cursiva'>SR</span>";
			$marca = $row['vehiculo'];
			$modelo = $row['modelo'];
			$grupo = $row['grupo'];
			$clase = $row['clase'];
			$agr = $row['agrupacion'];
			$cat = $row['categoria'];
			////////////POSICIONES GRUPOS CLASES AGR Y CATEGORIAS //////////////////////////
			$pos_grupo[$grupo] = $pos_grupo[$grupo] ? $pos_grupo[$grupo] + 1 : 1;
			$pos_en_su_grupo = "<span class='negrita'>(" . $pos_grupo[$grupo] . ")</span>";
			$pos_clase[$clase] = $pos_clase[$clase] ? $pos_clase[$clase] + 1 : 1;
			$pos_en_su_clase = "<span class='negrita'>(" . $pos_clase[$clase] . ")</span>";
			$pos_categoria[$cat] = $pos_categoria[$cat] ? $pos_categoria[$cat] + 1 : 1;
			$pos_en_su_categoria = "<span class='negrita'>(" . $pos_categoria[$cat] . ")</span>";
			$pos_agr[$agr] = $pos_agr[$agr] ? $pos_agr[$agr] + 1 : 1;
			$pos_en_su_agr = "<span class='negrita'>(" . $pos_agr[$agr] . ")</span>";
			/////////////////////////////////////////////////////////////////////////////////
			$vehiculo = "<p class='veh'>" . $marca . " " . $modelo . "</p><p class='gru'>" . $grupo . $pos_en_su_grupo . "/" . $clase . $pos_en_su_clase . "<br>" . $cat . $pos_en_su_categoria . "/" . $agr . $pos_en_su_agrupacion . "</p>";
			$concursante = $row['concursante'];
			$con_nac = $row['nac_competidor'];
			$con_nac = explode("/", $con_nac);
			$con_nac1 = bandera($con_nac[0]);
			$con_nac2 = bandera($con_nac[1]);
			$concursante = "<img class='banderas' src='" . $pi_nac1 . "'><img class='banderas' src='" . $pi_nac2 . "'>" . $concursante;
			$t_t = decimales($row['t_t'], $decimales);
			if ($pos == 1) {
				$mejor_tiempo = $t_t;
				$tiempo_anterior = $t_t;
			}
			$dif_primero = milisegundos_a_tiempo($t_t - $mejor_tiempo);
			$dif_anterior = milisegundos_a_tiempo($t_t - $tiempo_anterior);
			$t_t = milisegundos_a_tiempo($t_t);
			$penalizacion = $row['penalizacion'];
			if ($par % 2 == 0)
				$classcss = "filapar";
			else
				$classcss = "filaimpar";
			/*PREPARO LOS TIEMPOS PARA LA FILA*/
			if ($pos == 1) {
				if ($penalizacion == 0 || $penalizacion == '')
					$tiempos = "<p class='negrita nomargen'>" . $t_t . "</p>";
				else
					$tiempos = "<p class='negrita nomargen'>" . $t_t . "</p><p class='penalizaciones nomargen'>" . milisegundos_a_tiempo(segundos_a_milisegundos($row['penalizacion'])) . "</p>";
			} else {
				if ($penalizacion == 0 || $penalizacion == '')
					$tiempos = "<p class='anterior cursiva nomargen'>" . $dif_primero . "</p><p class='negrita nomargen'>" . $t_t . "</p><p class='cursiva nomargen'>" . $dif_anterior . "</p>";
				else
					$tiempos = "<p class='anterior cursiva nomargen'>" . $dif_primero . "</p><p class='negrita nomargen'>" . $t_t . "</p><p class='cursiva nomargen'>" . $dif_anterior . "</p><p class='penalizaciones nomargen'>" . milisegundos_a_tiempo(segundos_a_milisegundos($row['penalizacion'])) . "</p>";
			}
			echo "<tr class='" . $classcss . "'><td class='centro pos'>" . $pos . "</td><td><div class='mitooltip'>" . $dorsal . "<span class='mitooltiptext'>".$concursante."</span></div></td><td class='con'>" . $equipo . "</td><td>" . escudo($vehiculo) . "</td><td class='centro'>" . $vehiculo . "</td><td class='tie centro'>" . $tiempos . "</td></tr>";
			$par++;
			$pos++;
			$tiempo_anterior = decimales($row['t_t'], $decimales);
		} //WHILE
	} //IF
	else {
		echo "<tr><td colspan='6'>No existen tiempos...</td></tr>";
		echo "</table>";
	}
	echo "</table>";

	echo "</td><td><p>ACUMULADOS</p>"; //ACUMULADOS
	echo "<table id='tabla_tiempos'><tbody><th class='centro'>P.</th><th class='centro'>N.</th><th class='centro'>EQUIPO</th><th colspan='2' class='centro'><p>Vehiculo</p><p class='mini1 nomargen'>Grupo/clase</p><p class='mini1 nomargen'>Cat./Agr.</p></th><th class='centro'><p class='mini1 nomargen'>PRIMERO</p><p>TIEMPO</p><p class='mini1 nomargen'>ANTERIOR</p></th></tbody>";
	if ($copa == '0') {
		$sql = "SELECT inscritos.piloto,inscritos.copiloto,SUM(tiempos.t_t) AS t_t,SUM(tiempos.penalizacion) AS penalizacion,inscritos.vehiculo,inscritos.concursante,inscritos.dorsal,inscritos.modelo,inscritos.grupo,
		inscritos.clase,inscritos.agrupacion,inscritos.categoria,inscritos.nac_piloto,inscritos.nac_copiloto,inscritos.nac_competidor,tiempos.idinscrito,inscritos.sr
		FROM web_inscritos inscritos
	INNER JOIN web_tiempos tiempos ON tiempos.idinscrito = inscritos.idinscrito
	WHERE inscritos.autorizado=1 AND tiempos.idcampeonato='$id_campeonato' AND tiempos.tipo_manga=1 AND tiempos.num_manga <= '$num_manga'
	GROUP BY inscritos.dorsal
	ORDER BY t_t ASC";
	} else {
		$sql = "SELECT inscritos.piloto,inscritos.copiloto,SUM(tiempos.t_t) AS t_t,SUM(tiempos.penalizacion) AS penalizacion,inscritos.vehiculo,inscritos.concursante,inscritos.dorsal,inscritos.modelo,inscritos.grupo,
		inscritos.clase,inscritos.agrupacion,inscritos.categoria,inscritos.nac_piloto,inscritos.nac_copiloto,inscritos.nac_competidor,tiempos.idinscrito,inscritos.sr
		FROM web_inscritos inscritos
	INNER JOIN web_tiempos tiempos ON tiempos.idinscrito = inscritos.idinscrito
	INNER JOIN web_copas_inscritos copas ON tiempos.idinscrito=copas.idcompetidor
	WHERE inscritos.autorizado=1 AND tiempos.idcampeonato='$id_campeonato' AND tiempos.tipo_manga=1 AND tiempos.idcampeonato='$id_campeonato' AND copas.idcopa='$copa' AND tiempos.num_manga <= '$num_manga'
	GROUP BY inscritos.dorsal
	ORDER BY t_t ASC";
	}
	$resultado = $mysqli2->query($sql) or print "No se pudo acceder al contenido de los tiempos online CONSULTA1.";
	if ($resultado->num_rows > 0) {
		$pos = 1;
		$par = 0;
		unset($pos_grupo);
		unset($pos_categoria);
		unset($pos_clase);
		unset($pos_agr);
		while ($row = $resultado->fetch_array()) {
			// SABER SI EL PILOTO HA COMPETIDO EN TODAS LAS MNAGAS ANTERIORES
			$idinscrito = $row['idinscrito'];
			$saber_competidas = $mysqli2->query("SELECT idtiempos FROM web_tiempos WHERE idinscrito='$idinscrito' AND num_manga<='$num_manga' AND idcampeonato='$id_campeonato'");
			$saber_cuantas_competido = $saber_competidas->num_rows;
			if ($num_manga == $saber_cuantas_competido) {
				//////////////////////////////////////////////////////////////
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
				$dorsal = "<span class='dor'>" . $row['dorsal'] . "</span>";
				$sr = $row['sr'];
				if ($sr == 1)
					$dorsal .= "<br><span class='negrita cursiva'>SR</span>";
				$marca = $row['vehiculo'];
				$modelo = $row['modelo'];
				$grupo = $row['grupo'];
				$clase = $row['clase'];
				$agr = $row['agrupacion'];
				$cat = $row['categoria'];
				////////////POSICIONES GRUPOS CLASES AGR Y CATEGORIAS //////////////////////////
				$pos_grupo[$grupo] = $pos_grupo[$grupo] ? $pos_grupo[$grupo] + 1 : 1;
				$pos_en_su_grupo = "<span class='negrita'>(" . $pos_grupo[$grupo] . ")</span>";
				$pos_clase[$clase] = $pos_clase[$clase] ? $pos_clase[$clase] + 1 : 1;
				$pos_en_su_clase = "<span class='negrita'>(" . $pos_clase[$clase] . ")</span>";
				$pos_categoria[$cat] = $pos_categoria[$cat] ? $pos_categoria[$cat] + 1 : 1;
				$pos_en_su_categoria = "<span class='negrita'>(" . $pos_categoria[$cat] . ")</span>";
				$pos_agr[$agr] = $pos_agr[$agr] ? $pos_agr[$agr] + 1 : 1;
				$pos_en_su_agr = "<span class='negrita'>(" . $pos_agr[$agr] . ")</span>";
				/////////////////////////////////////////////////////////////////////////////////
				$vehiculo = "<p class='veh'>" . $marca . " " . $modelo . "</p><p class='gru'>" . $grupo . $pos_en_su_grupo . "/" . $clase . $pos_en_su_clase . "<br>" . $cat . $pos_en_su_categoria . "/" . $agr . $pos_en_su_agrupacion . "</p>";
				$concursante = $row['concursante'];
				$con_nac = $row['nac_competidor'];
				$con_nac = explode("/", $con_nac);
				$con_nac1 = bandera($con_nac[0]);
				$con_nac2 = bandera($con_nac[1]);
				$concursante = "<img class='banderas' src='" . $pi_nac1 . "'><img class='banderas' src='" . $pi_nac2 . "'>" . $concursante;
				$t_t = decimales($row['t_t'], $decimales);
				if ($pos == 1) {
					$mejor_tiempo = $t_t;
					$tiempo_anterior = $t_t;
				}
				$dif_primero = milisegundos_a_tiempo($t_t - $mejor_tiempo);
				$dif_anterior = milisegundos_a_tiempo($t_t - $tiempo_anterior);
				$t_t = milisegundos_a_tiempo($t_t);
				$penalizacion = $row['penalizacion'];
				if ($par % 2 == 0)
					$classcss = "filapar";
				else
					$classcss = "filaimpar";
				/*PREPARO LOS TIEMPOS PARA LA FILA*/
				if ($pos == 1) {
					if ($penalizacion == 0 || $penalizacion == '')
						$tiempos = "<p class='negrita nomargen'>" . $t_t . "</p>";
					else
						$tiempos = "<p class='negrita nomargen'>" . $t_t . "</p><p class='penalizaciones nomargen'>" . milisegundos_a_tiempo(segundos_a_milisegundos($row['penalizacion'])) . "</p>";
				} else {
					if ($penalizacion == 0 || $penalizacion == '')
						$tiempos = "<p class='anterior cursiva nomargen'>" . $dif_primero . "</p><p class='negrita nomargen'>" . $t_t . "</p><p class='cursiva nomargen'>" . $dif_anterior . "</p>";
					else
						$tiempos = "<p class='anterior cursiva nomargen'>" . $dif_primero . "</p><p class='negrita nomargen'>" . $t_t . "</p><p class='cursiva nomargen'>" . $dif_anterior . "</p><p class='penalizaciones nomargen'>" . milisegundos_a_tiempo(segundos_a_milisegundos($row['penalizacion'])) . "</p>";
				}
				echo "<tr class='" . $classcss . "'><td class='centro pos'>" . $pos . "</td><td><div class='mitooltip'>" . $dorsal . "<span class='mitooltiptext'>".$concursante."</span></div></td><td class='con'>" . $equipo . "</td><td>" . escudo($vehiculo) . "</td><td class='centro'>" . $vehiculo . "</td><td class='tie centro'>" . $tiempos . "</td></tr>";
				$tiempo_anterior = decimales($row['t_t'], $decimales);
				$par++;
				$pos++;
			}
		} //WHILE
		echo "</table>";
		echo "</td></tr></table></div>";
	} else {
		echo "<tr><td colspan='6'>No existen acumulados...</td></tr>";
		echo "</table>";
	}
	$afec = $resultado->num_rows;
	echo "<br><br>";
} //WHILE DE CAMPEONATOS
?>
<br>
<br>
<br>
<br>
<p class='negrita centro fu1'>ABANDONOS</p>
<div id='div_contenedor'>
	<table id="tabla_tiempos_ancha">
		<thead>
			<th>N.</th>
			<th>CONCURSANTE</th>
			<th>EQUIPO</th>
			<th colspan="2" class="centro">VEHICULO</th>
			<th>MOTIVO</th>
		</thead>
		<tbody>
			<?php
			$sql_abandonos_manga = $mysqli2->query("SELECT wi.dorsal,wi.piloto,wi.copiloto,wi.concursante,wa.motivo,wi.vehiculo,wi.modelo,wi.nac_piloto,wi.nac_competidor,
		wi.nac_copiloto
	FROM web_inscritos wi 
	INNER JOIN web_abandonos wa ON wa.idinscrito = wi.idinscrito
	WHERE wa.idmanga = '$idManga'");
			if ($sql_abandonos_manga->num_rows > 0) {
				while ($fila = $sql_abandonos_manga->fetch_array()) {
					$dorsal = $fila['dorsal'];
					$motivo = $fila['motivo'];
					$concursante = $fila['concursante'];
					$piloto = $fila['piloto'];
					$copiloto = $fila['copiloto'];
					$marca = $fila['vehiculo'];
					$modelo = $fila['modelo'];

					$con_nac = $fila['nac_competidor'];
					$con_nac = explode("/", $con_nac);
					$con_nac1 = bandera($con_nac[0]);
					$con_nac2 = bandera($con_nac[1]);

					$piloto = $fila['piloto'];
					$pi_nac = $fila['nac_piloto'];
					$pi_nacs = explode('/', $pi_nac);
					$pi_nac1 = bandera($pi_nacs[0]);
					$pi_nac2 = bandera($pi_nacs[1]);

					$copiloto = $fila['copiloto'];
					$copi_nac = $fila['nac_copiloto'];
					$copi_nacs = explode('/', $copi_nac);
					$copi_nac1 = bandera($copi_nacs[0]);
					$copi_nac2 = bandera($copi_nacs[1]);

					if ($copiloto == '')
						$equipo = $piloto;
					else
						$equipo = "<img class='banderas' src='" . $pi_nac1 . "'><img class='banderas' src='" . $pi_nac2 . "'>" . $piloto . "<br><img class='banderas' src='" . $copi_nac1 . "'><img class='banderas' src='" . $copi_nac2 . "'>" . $copiloto;

					if ($par % 2 == 0)
						$classcss = "filapar";
					else
						$classcss = "filaimpar";
					echo "<tr class='" . $classcss . "'><td class='dor negrita'>" . $dorsal . "</td><td class='con'><img class='banderas' src='" . $con_nac1 . "'><img class='banderas' src='" . $con_nac2 . "'>" . $concursante . "</td><td class='con'>" . $equipo . "</td>";
					echo "<td>" . escudo($marca) . "</td><td class='centro veh'>" . $marca . " " . $modelo . "</td><td>" . $motivo . "</td></tr>";
				}
			} else {
				echo "<tr><td colspan ='7'>No existen abandonos en esta manga.</td></tr>";
			}
			//$mysqli2->close();
			?>
		</tbody>
	</table>
</div>