<?php
include("conexion.php");
include("escudos.php");
if (isset($_GET["idmanga"]) && isset($_GET["id"])) {
	$idManga = $_GET["idmanga"];
	$idCarrera = $_GET["id"];
	$saber_manga = $mysqli2->query("SELECT numero,decimales,descripcion FROM web_manga_archivo WHERE id='$idManga'")->fetch_array();
	$num_manga = $saber_manga['numero'];
	$decimales = $saber_manga['decimales'];
	$nom = $saber_manga['descripcion'];
}
include("includes/funciones.php"); //ME CAGO EN SU PUTA MADRE QUE NO FUNCIONAA!!!!! REVISAR
include("includes/funcionesTiempos.php");
//SE PODRIA COMPROBAR QUE EXISTAN TIEMPOS DENTRO A FIN DE NO MOSTRAR TITULOS VACIOS
echo "<p class='negrita centro fu1'>" . $nom . "</p>";
echo "<br>";
//TABLA CONTENEDORA DE LAS 2 TABLAS
echo "<div id='div_contenedor'>";
echo "<table id='tabla_contenedor'>";
echo "<tr><td><p>TIEMPOS</p>";
echo "<table id='tabla_tiempos'><tbody><th class='centro'>P.</th><th class='centro'>N.</th><th class='centro'><img src='img/tactil.png' class='icono'>EQUIPO</th><th colspan='2' class='centro'><p>Vehiculo</p><p class='mini1 nomargen'>Grupo/clase</p><p class='mini1 nomargen'>Cat./Agr.</p></th><th class='centro'><p class='mini1 nomargen'>PRIMERO</p><p>TIEMPO</p><p class='mini1 nomargen'>ANTERIOR</p></th></tbody>";

$sql = "SELECT inscritos.piloto,inscritos.copiloto,tiempos.t_t,tiempos.penalizacion,inscritos.vehiculo,inscritos.concursante,inscritos.dorsal,inscritos.modelo,inscritos.grupo,
		inscritos.clase,inscritos.agrupacion,inscritos.categoria,inscritos.nac_piloto,inscritos.nac_copiloto,inscritos.nac_competidor,inscritos.sr
		FROM web_inscritos_archivo inscritos
	INNER JOIN web_tiempos_archivo tiempos ON tiempos.idinscrito = inscritos.idinscrito
	WHERE tiempos.idmanga='$idManga' AND inscritos.autorizado=1
	GROUP BY inscritos.dorsal
	ORDER BY tiempos.t_t ASC";

$resultado = $mysqli2->query($sql) or print "No se pudo acceder al contenido de los tiempos online CONSULTA1.";
if ($resultado->num_rows > 0) {
	$pos = 1;
	$par = 0;
	unset($pos_grupo);
	unset($pos_categoria);
	unset($pos_clase);
	unset($pos_agr);
	while ($row = $resultado->fetch_array()) {
		$piloto = $row['piloto'];
		$copiloto = $row['copiloto'];
		if ($copiloto == '')
			$equipo = $piloto;
		else
			$equipo = $piloto . "<br>" . $copiloto;
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
				$tiempos = "<p class='negrita nomargen'>" . $t_t . "</p><p class='penalizaciones nomargen'>" . milisegundos_a_tiempo($row['penalizacion']) . "</p>";
		} else {
			if ($penalizacion == 0 || $penalizacion == '')
				$tiempos = "<p class='anterior cursiva nomargen'>" . $dif_primero . "</p><p class='negrita nomargen'>" . $t_t . "</p><p class='cursiva nomargen'>" . $dif_anterior . "</p>";
			else
				$tiempos = "<p class='anterior cursiva nomargen'>" . $dif_primero . "</p><p class='negrita nomargen'>" . $t_t . "</p><p class='cursiva nomargen'>" . $dif_anterior . "</p><p class='penalizaciones nomargen'>" . milisegundos_a_tiempo($row['penalizacion']) . "</p>";
		}
		echo "<tr class='" . $classcss . "'><td class='centro pos'>" . $pos . "</td><td title='" . $concursante . "'>" . $dorsal . "<td class='con'>" . $equipo . "</td><td>" . escudo($vehiculo) . "</td><td class='centro'>" . $vehiculo . "</td><td class='tie centro'>" . $tiempos . "</td></tr>";
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

$sql = "SELECT inscritos.piloto,inscritos.copiloto,SUM(tiempos.t_t) AS t_t,SUM(tiempos.penalizacion) AS penalizacion,inscritos.vehiculo,inscritos.concursante,inscritos.dorsal,inscritos.modelo,inscritos.grupo,
		inscritos.clase,inscritos.agrupacion,inscritos.categoria,inscritos.nac_piloto,inscritos.nac_copiloto,inscritos.nac_competidor,tiempos.idinscrito,inscritos.sr
		FROM web_inscritos_archivo inscritos
	INNER JOIN web_tiempos_archivo tiempos ON tiempos.idinscrito = inscritos.idinscrito
	WHERE inscritos.autorizado=1 AND tiempos.tipo_manga=1 AND tiempos.num_manga <= '$num_manga'
	GROUP BY inscritos.dorsal
	ORDER BY t_t ASC";

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
		$saber_competidas = $mysqli2->query("SELECT idtiempos FROM web_tiempos_archivo WHERE idinscrito='$idinscrito' AND num_manga<='$num_manga'");
		$saber_cuantas_competido = $saber_competidas->num_rows;
		//echo "OFI: ".$num_manga . "HASTA: ".$saber_cuantas_competido;
		if ($num_manga == $saber_cuantas_competido) {
			$piloto = $row['piloto'];
			$copiloto = $row['copiloto'];
			if ($copiloto == '')
				$equipo = $piloto;
			else
				$equipo = $piloto . "<br>" . $copiloto;
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
					$tiempos = "<p class='negrita nomargen'>" . $t_t . "</p><p class='penalizaciones nomargen'>" . milisegundos_a_tiempo($row['penalizacion']) . "</p>";
			} else {
				if ($penalizacion == 0 || $penalizacion == '')
					$tiempos = "<p class='anterior cursiva nomargen'>" . $dif_primero . "</p><p class='negrita nomargen'>" . $t_t . "</p><p class='cursiva nomargen'>" . $dif_anterior . "</p>";
				else
					$tiempos = "<p class='anterior cursiva nomargen'>" . $dif_primero . "</p><p class='negrita nomargen'>" . $t_t . "</p><p class='cursiva nomargen'>" . $dif_anterior . "</p><p class='penalizaciones nomargen'>" . milisegundos_a_tiempo($row['penalizacion']) . "</p>";
			}
			echo "<tr class='" . $classcss . "'><td class='centro pos'>" . $pos . "</td><td title='" . $concursante . "'>" . $dorsal . "</td><td class='con'>" . $equipo . "</td><td>" . escudo($vehiculo) . "</td><td class='centro'>" . $vehiculo . "</td><td class='tie centro'>" . $tiempos . "</td></tr>";
			$tiempo_anterior = decimales($row['t_t'], $decimales);
			$par++;
			$pos++;
		} // CIERRE DE CONDICION DE COMPETIR HASTA
	} //WHILE
	echo "</table>";
	echo "</td></tr></table></div>";
} else {
	echo "<tr><td colspan='6'>No existen acumulados...</td></tr>";
	echo "</table>";
}
$afec = $resultado->num_rows;
echo "<br><br>";
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
			$sql_abandonos_manga = $mysqli2->query("SELECT wi.dorsal,wi.piloto,wi.copiloto,wi.concursante,wa.motivo,wi.vehiculo,wi.modelo
			FROM web_inscritos_archivo wi 
			INNER JOIN web_abandonos_archivo wa ON wa.idinscrito = wi.idinscrito
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

					if ($copiloto == '')
						$equipo = $piloto;
					else
						$equipo =  $piloto . "<br>" . $copiloto;

					if ($par % 2 == 0)
						$classcss = "filapar";
					else
						$classcss = "filaimpar";
					echo "<tr class='" . $classcss . "'><td class='dor negrita'>" . $dorsal . "</td><td class='con'>" . $concursante . "</td><td class='con'>" . $equipo . "</td>";
					echo "<td>" . escudo($marca) . "</td><td class='centro veh'>" . $marca . " " . $modelo . "</td><td>" . $motivo . "</td></tr>";
					$par++;
				}
			} else {
				echo "<tr><td colspan ='7'>No existen abandonos en esta manga.</td></tr>";
			}
			//$mysqli2->close();
			?>
		</tbody>
	</table>
</div>