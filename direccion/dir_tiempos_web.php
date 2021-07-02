<?php
//echo "copa--->".$_GET['copa']."manga--->".$_GET['manga'];
session_start();
include("valida2.php");
include("../conexion.php");
$idcarrera = $_GET['id'];
$pass = $_SESSION['pass'];
include_once("funcionesTiempos.php");
include_once("nombresTildes.php");
include('escudos.php');
//echo "ID: " . $idcarrera;
if (isset($_GET['manga']) && !empty($_GET['manga'])) {
	$idManga = $_GET['manga'];
	$res_int = $mysqli->query("SELECT id FROM web_manga_control_horario WHERE id_ca_manga='$idManga' AND orden!=0 AND orden!=1 AND orden!=2 AND orden!=3 AND orden!=4 AND orden!=5 AND orden!=10 ORDER BY orden")->num_rows;
	if ($res_int > 0)
		$num_inter = $res_int;
	else
		$num_inter = 0;
	$sql = $mysqli2->query("SELECT ins.idinscrito,ins.piloto,ins.copiloto,ins.dorsal
	FROM web_inscritos ins
	WHERE ins.autorizado=1 AND idcarrera='$idcarrera'");
	while ($row = $sql->fetch_array()) {
		$h_s = 0;
		$t_t = 0;
		$h_l = 0;
		$dorsal = $row['dorsal'];
		$piloto = $row['piloto'];
		$copiloto = $row['copiloto'];
		$idinscrito = $row['idinscrito'];
		$sql_tiempo = $mysqli2->query("SELECT t_t,h_s,h_l FROM web_tiempos WHERE idmanga = '$idManga' AND idinscrito='$idinscrito'");
		while ($row2 = $sql_tiempo->fetch_array()) {
			$h_s = $row2['h_s'];
			$h_l = $row2['h_l'];
			$t_t = $row2['t_t'];
		}
		if ($t_t > 0)  // HA LLEGADO
			$tipo = 2;
			else{
				if($h_s>0)
					$tipo = 1;
				else
					$tipo = 0;
			}
		//echo $idinscrito . "--" . $dorsal . "-H_S" . $h_s . "H_L:" . $h_l . "T-T:" . $t_t . " ESTADO: ".$tipo."<br>";
		///////////////////-----ARRAY COMPLETO DE PARTIcIPANTES------------//////////////////
		$ordenar[] = array(
			'piloto' => $piloto,
			'copiloto' => $copiloto,
			'dorsal' => $dorsal,
			'tiempo' => milisegundos_a_tiempo($t_t),
			'tipo' => $tipo,
			'h_s' => milisegundos_a_tiempo($h_s),
			'h_l' => milisegundos_a_tiempo($h_l),
			't_t' => milisegundos_a_tiempo($t_t),
			'idinscrito' => $idinscrito
		);
		///////////////////---------LEER ARRAY COMPLETO-----------///////////////////////////
		////////////////////////////////////////////////////////
	}
	foreach ($ordenar as $key => $row) {
		$aux[$key] = $row['tipo'];
	}
	array_multisort($aux, SORT_ASC, $ordenar);
	foreach ($ordenar as $key => $row) {
		switch ($row['tipo']) {
			case 0:
				$color = 'amarillo';
				$mensaje = 'POR SALIR';
				break;
			case 1:
				$color = 'verde';
				$mensaje = 'EN PISTA';
				break;
			case 2:
				$color = 'gris';
				$mensaje = 'META';
		}
		echo "<div class='cubos " . $color . "' onclick=\"info('" . $ros['piloto'] . "','" . $row['dorsal'] . "','" . $row['vehiculo'] . "','" . $row['modelo'] . "','" . $row['copiloto'] . "')\">";
		echo "<p class='dorsaln'>" . $row['dorsal'] . "</p><p class='nomargen t1'>" . $mensaje . "</p><p class='nomargen t2'>Hs:" . $row['h_s'] . "</p><p class='nomargen t2'>H_LL:" . $row['h_l'] . "</p><p class='nomargen t2'>T_t:" . $row['t_t'] . "</p>";
		echo "</div>";
	}
} else {
	echo "SELECCIONAR MANGA PARA MOSTRAR TIEMPOS...";
	//echo "<div id='info3'>";
	//include("atomic.php");
	//echo "</div>";
}
