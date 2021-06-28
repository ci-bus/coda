<?php
//TIPO 3, SUMa DE TODAS LAS MANGA OFICIALES
include("conexion.php");
include("includes/funcionesTiempos.php");
include("includes/funciones.php");
include("escudos.php");
echo "<div id='recargas'><p>TIEMPOS INTERMEDIOS:</p><hr>";
if (isset($_GET["copa"]))
	$copa = $_GET["copa"];
else
	$copa = '0';
$idCarrera = $_GET['id'];
$idManga = $_GET['idmanga'];
$idetapa = $_GET['idetapa'];
$idseccion = $_GET['idseccion'];
$sql = "SELECT descripcion FROM web_manga_control_horario WHERE id_ca_manga='$idManga' AND orden!=0 AND orden!=10 AND orden!=1 AND orden!=2 AND orden!=3 AND orden!=4 AND orden!=5 ORDER BY orden";
$resultado = $mysqli2->query($sql);
if ($resultado->num_rows == 0)
	echo "No existen puntos Tiempos Intermedios";
else {
	$num_int = $resultado->num_rows;
	echo "<table id='tab_tem' border='0' width='100%'>
			<thead>
			<tr><th colspan='4'></th><th colspan='" . $num_int . "' class='centro'>PUNTOS INTERMEDIOS</th><th></th></tr>
			<tr><th>N.</th><th>EQUIPO</th><th colspan='2' class='centro'><p class='nomargen'>VEHICULO</p><p class='mini1 nomargen'>GRUPO/CLASE</p><p class='mini1 nomargen'>CAT/AGR</p></th>";
	while ($row = $resultado->fetch_array()) {
		$desc = $row['descripcion'];
		echo "<th class='centro'>" . $desc . "</th>";
	}
	echo "<th class='centro'>TIEMPO</th></tr></thead>";
}
if ($copa == '0') {
	$sql = "SELECT inscritos.idinscrito,inscritos.piloto,inscritos.copiloto,inscritos.vehiculo,inscritos.concursante,inscritos.dorsal,inscritos.modelo,inscritos.grupo,
		inscritos.clase,inscritos.agrupacion,inscritos.categoria,inscritos.nac_piloto,inscritos.nac_copiloto,inscritos.nac_competidor,inscritos.sr
		FROM web_inscritos inscritos
	WHERE inscritos.autorizado=1 AND idcarrera='$idCarrera'
	GROUP BY inscritos.dorsal
	ORDER BY inscritos.dorsal +1 ASC";
} else
	echo "MANDA COPA";
$resultado = $mysqli2->query($sql) or print "No se pudo acceder al contenido de los tiempos online.";
$pos = 1;
$par = 0;
if ($resultado->num_rows > 0) {
	while ($row = $resultado->fetch_array()) {
		$j = 1;
		$idinscrito = $row['idinscrito'];
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
		$el_dorsal = $row['dorsal'];
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
		$vehiculo = "<p class='veh'>" . $marca . " " . $modelo . "</p><p class='gru mini1 nomargen'>" . $grupo .  "/" . $clase . "<br>" . $cat . "/" . $agr . "</p>";
		if ($par % 2 == 0)
			$classcss = "filapar";
		else
			$classcss = "filaimpar";
		$saber_tiempo_total = $mysqli2->query("SELECT t_t FROM web_tiempos WHERE idinscrito='$idinscrito' AND idmanga='$idManga'")->fetch_array();
		$t_t = $saber_tiempo_total['t_t'];
		$saber_tiempo_salida = $mysqli->query("SELECT ch.orden AS orden,t.tiempo FROM abc_57os_ca_tiempo t 
				INNER JOIN abc_57os_ca_manga_control_horario ch ON ch.id=t.id_ca_manga_control_horario 
				WHERE t.dorsal='$el_dorsal' AND t.id_ca_manga='$idManga' AND ch.orden = '5'")->num_rows;
		if ($saber_tiempo_salida > 0) {
			echo "<tr class='" . $classcss . "'><td>" . $dorsal . "</td><td>" . $equipo . "</td><td class='centro'>" . $vehiculo . "</td><td>".escudo($marca)."</td>";
			//////////////BUSCAR TIEMPOS INTERMEDIOS/////////////////////////////
			while ($j <= $num_int) {
				$punto = "i" . $j;
				$sql_intermedio = $mysqli2->query("SELECT $punto FROM web_intermedios WHERE idinscrito = '$idinscrito' AND idmanga = $idManga")->fetch_array();
				$tiempo_intermedio = $sql_intermedio[$punto];
				if ($tiempo_intermedio == '')
					echo "<td class='centro'> *** </td>";
				else
					echo "<td class='centro'>" . milisegundos_a_tiempo($tiempo_intermedio) . "</td>";
				$j++;
			}
			////////////////////////////////////////////////////////////////////
			if ($t_t == '')
				echo "<td class='centro'> *** </td></tr>";
			else
				echo "<td class='negrita centro'>" . decimales(milisegundos_a_tiempo($t_t),1) . "</td></tr>";
			$par++;
		}
		$pos++;
	}
} else
	echo "No hay contenido online para mostrar...";


?>
</tbody>
</table>
<!-- FIN TABLA TEMPORADA->
<br>
<br>
<br>
<br>