<?php
if (!$mysqli2) {
	$IPservidor2 = "localhost:3306";
	$nombreBD2 = "web2020";
	$usuario2 = "web2020";
	$clave2 = "Kp!vt750";
	$mysqli2 = new mysqli($IPservidor2, $usuario2, $clave2, $nombreBD2);
	$mysqli2->set_charset("utf8");
}
$id = $_GET['id'];
$guardado = file_get_contents("./mejortiempo.txt");
session_start();
include("../includes/funcionesTiempos.php");
$idManga = $_GET['idmanga'];
///////////////ESTADO DE LA MANGA PARA QUE CAMBIE a CARTEL O TIEMPOS SEGUN HAYA LLEGADA////////////////
$saber_salida = $mysqli2->query("SELECT estado FROM web_manga WHERE id = '$idManga'")->fetch_array();
$salida = $saber_salida['estado'];
///////////////////////////////////////////////////////////////////////////////////////////////////////
//$salida = 0;
$pag = $_SESSION['pag'];
$inicio = $_SESSION['inicio'];
//////////////////  DECIMALES DE LA PRUEBA /////////////////////////////////////////////
$sql_decimales = $mysqli2->query("SELECT decimales FROM web_manga WHERE id='$idManga'")->fetch_array();
$decimales = $sql_decimales['decimales'];
///////////////////////// TOTAL DE LLEGADOS ////////////////////////////////////////
$total_registros = $mysqli2->query("SELECT t_t FROM web_tiempos WHERE idmanga='$idManga' AND t_t>0 GROUP BY t_t")->num_rows;
//////////////////////////////MEJOR TIEMPO ////////////////////////////////////////////////////////////
$mejor = $mysqli2->query("SELECT web_tiempos.t_t AS mejor_tiempo,web_inscritos.dorsal AS mejor_dorsal FROM web_tiempos 
INNER JOIN web_inscritos ON web_inscritos.idinscrito=web_tiempos.idinscrito 
WHERE idmanga='$idManga' AND t_t >0 ORDER BY t_t LIMIT 1 ")->fetch_array();
$mejor_tiempo = $mejor['mejor_tiempo'];
$mejor_dorsal = $mejor['mejor_dorsal'];
//////////////////////////////////           COCHES EN PISTA           ////////////////////////////////////////////////////
//$sql_en_pista = $mysqli2->query("SELECT coches_en_pista FROM web_pruebas WHERE id='$id'")->fetch_array();
//$coches_en_pista = $sql_en_pista['coches_en_pista'];
/////////////////////////////////            COCHES POR SALIR         //////////////////////////////////////////////////////
$total_coches = $mysqli2->query("SELECT idinscrito FROM web_inscritos WHERE idcarrera='$id' AND excluido=0")->num_rows;
$total_llegados = $mysqli2->query("SELECT t_t FROM web_tiempos WHERE idmanga='$idManga' AND t_t>0")->num_rows;
//$abandonados_manga = $mysqli->query("SELECT id FROM web_abandonos WHERE idmanga = '$idManga'")->num_rows;
$coches_por_salir = $total_coches-$total_llegados;
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>
<div id="header">
	<div id="logo"><img class="logo" src="logo.png"></div>
	<div id="primero">
		<div id="ult_tiempo"><span class="blanco t6 fuente">POR SALIR: </span><span class="fuente2 rojo"><?php echo $coches_por_salir; ?></span></div>
		<div id="num_enpista"><span class="blanco t6 fuente">EN PISTA: </span><span class="fuente2 rojo"><?php echo $coches_en_pista; ?></span></div>
		<div id="tiempo1" class="fuente1">
			<span class="dorsal">
				<?php
				if ($salida !=0)
					echo $mejor_dorsal;

				?>
			</span>
			<span class="verde<?php if ($mejor_tiempo < $guardado) echo ' blinking'; ?>">
				<?php
				if ($salida !=0)
					echo decimales(milisegundos_a_tiempo($mejor_tiempo), $decimales);
				else
					echo " - - - - - ";

				?>
			</span>
		</div>
	</div>
	<div id="dor_pista">
	</div>
</div>
<?php
//////////////////////////////////// COMPARAR EL MEJOR TIEMPO //////////////////////////////////////////////
echo "<div class='tooltip'>";
if ($mejor_tiempo < $guardado and $salida !=0)
	echo "<p class='naranja t7 fuente tooltiptext'>NUEVO MEJOR TIEMPO</p>";
echo "</div>";
?>
<div id="content">
	<?php

	$min = '99:99:99.999';
	if ($salida == 0) {
		echo "<p class='t5 blanco fuente centro'>ESPERANDO SALIDA DEL PRIMER PILOTO...</p>";
		echo "<p class='t5 blanco fuente centro'>SIGUENOS EN NUESTRAS REDES SOCIALES</p>";
		echo "<p class='t8 blanco fuente centro blinking'>CODEA.ES</p>";
	} else {
		//echo "<table width='100%' border='0' ><tr style='vertical-align:top'><td>";

		$sql = "SELECT tiempos.t_t AS t_t, inscritos.dorsal AS dorsal, inscritos.vehiculo AS marca,inscritos.idinscrito AS idcompetidor
				FROM web_tiempos tiempos
				INNER JOIN web_inscritos inscritos ON tiempos.idinscrito = inscritos.idinscrito
				WHERE tiempos.idmanga = '$idManga' AND inscritos.autorizado = '1'
				GROUP BY inscritos.dorsal
				ORDER BY t_t ASC LIMIT $inicio,$pag";
		$resultado = $mysqli2->query($sql) or print "No se pudo acceder al contenido de los tiempos online";
		if ($resultado->num_rows > 0) {
			$pos = $inicio + 1;
			echo "<div id='separador'>";
			while ($fila = $resultado->fetch_array()) {
				$pen = 0;
				$dorsal = $fila['dorsal'];
				$vehiculo = $fila['marca'];
				$idcomp = $fila['idcompetidor'];
				$num_manga = $fila['num_manga'];
				$t_t = decimales(milisegundos_a_tiempo($fila['t_t']), $decimales);
				echo "<p class='amarillo t3 fuente nomargen'><span class='blanco t4 negrita alin1'>" . $pos . " </span><span class='dorsal todos_tiempos t2 alin2'>" . $dorsal . "</span><span class='todos_tiempos t2 alin3'>" . $t_t . "</span></p>";
				if ($pos == 10 || $pos == 20 || $pos == 30 || $pos == 40 || $pos == 50 || $pos == 60 || $pos == 70 || $pos == 80 || $pos == 90 || $pos == 100 || $pos == 110 || $pos == 120)
					echo "</div><div id='separador'>";
				$pos++;
			}
		}
		echo "</table>";
	} //else SI HAY SALIDA

	if ($pag < $total_registros) {
		$pag += 30;
		$inicio += 30;
		$_SESSION['inicio'] = $inicio;
		$_SESSION['pag'] = $pag;
	} else {
		$pag = 30;
		$inicio = 0;
		$_SESSION['inicio'] = $inicio;
		$_SESSION['pag'] = $pag;
	}/*
		if($pag>=$total){
		$pag=30;
		$inicio = 0;
		$_SESSION['inicio']=$inicio;
		$_SESSION['pag']=$pag;
		}*/
	if ($mejor_tiempo < $guardado) {
		file_put_contents("./mejortiempo.txt", $mejor_tiempo);
	}
	?>
</div>