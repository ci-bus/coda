<?php
//TIPO 3, SUMa DE TODAS LAS MANGA OFICIALES
include("conexion.php");
include("includes/funcionesTiempos.php");
include("escudos.php");
$id=$_GET['id'];
$num_mangas_oficiales_campeonato = $mysqli2->query("SELECT id FROM web_manga_archivo WHERE idcarrera='$id' AND tipo='1'")->num_rows;
//echo $num_mangas_oficiales_campeonato;
	echo "<p class='negrita centro fu1'>CLASIFICACI&Oacute;N FINAL</p>";
	echo "<br>";
	echo "<div id='div_contenedor'>";
	echo "<table id='tabla_tiempos_ancha'><thead><th class='centro'>P.</th><th class='centro'>N.</th><th>CONCURSANTE</th><th><img src='img/tactil.png' class='icono'>EQUIPO</th><th colspan='2' class='centro'><p>Vehiculo</p><p class='mini1 nomargen'>Grupo/clase</p><p class='mini1 nomargen'>Cat./Agr.</p></th><th class='centro'><p class='mini1 nomargen'>PRIMERO</p><p>TIEMPO</p><p class='mini1 nomargen'>ANTERIOR</p></th></thead>";
		$sql = "SELECT inscritos.idinscrito,inscritos.piloto,inscritos.copiloto,SUM(tiempos.t_t) AS t_t,SUM(tiempos.penalizacion) AS penalizacion,inscritos.vehiculo,inscritos.concursante,inscritos.dorsal,inscritos.modelo,inscritos.grupo,
		inscritos.clase,inscritos.agrupacion,inscritos.categoria,tiempos.h_s,tiempos.h_l
		FROM web_inscritos_archivo inscritos
	INNER JOIN web_tiempos_archivo tiempos ON tiempos.idinscrito = inscritos.idinscrito
	WHERE inscritos.autorizado=1 AND tiempos.tipo_manga=1 AND tiempos.h_l > 0
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
			$idinscrito = $row['idinscrito'];
			$cons_num_mangas_oficiales_competidas = $mysqli2->query("SELECT idtiempos FROM web_tiempos_archivo WHERE idinscrito = '$idinscrito' AND tipo_manga=1")->num_rows;
			//echo "<br>DORSAL: ".$row['dorsal']."OF.COMPEITODAS: ".$cons_num_mangas_oficiales_competidas."---OFICALES TOTAL: ".$num_mangas_oficiales_campeonato;
			if ($cons_num_mangas_oficiales_competidas == $num_mangas_oficiales_campeonato) {
				$piloto = $row['piloto'];
				$copiloto = $row['copiloto'];
				if ($copiloto == '')
					$equipo = $piloto;
				else
					$equipo = $piloto . "<br>" . $copiloto;
				//AQUI HACER EL EQUIPO
				$dorsal = $row['dorsal'];
				$marca = $row['vehiculo'];
				$modelo = $row['modelo'];
				$grupo = $row['grupo'];
				$clase = $row['clase'];
				$agr = $row['agrupacion'];
				$cate = $row['categoria'];
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
				$t_t = decimales($row['t_t'], 1);
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
				$h_s = $row['h_s'];
				$h_l = $row['h_l'];
				/*PREPARO LOS TIEMPOS PARA LA FILA*/
				if ($pos == 1) {
					if ($penalizacion == 0 || $penalizacion == '')
						$tiempos = "<p class='negrita nomargen'>" . $t_t . "</p>";
					else
						$tiempos = "<p class='negrita nomargen'>" . $t_t . "</p><p class='penalizaciones nomargen'>" . $penalizacion . "</p>";
				} else {
					if ($penalizacion == 0 || $penalizacion == '')
						$tiempos = "<p class='anterior cursiva nomargen'>" . $dif_primero . "</p><p class='negrita nomargen'>" . $t_t . "</p><p class='cursiva nomargen'>" . $dif_anterior . "</p>";
					else
						$tiempos = "<p class='anterior cursiva nomargen'>" . $dif_primero . "</p><p class='negrita nomargen'>" . $t_t . "</p><p class='cursiva nomargen'>" . $dif_anterior . "</p><p class='penalizaciones nomargen'>" . $penalizacion . "</p>";
				}
				echo "<tr class='" . $classcss . "'><td class='centro'>" . $pos . "</td><td class='dor'>" . $dorsal . "</td><td  class='con'>" . $concursante . "</td><td  class='con'>" . $equipo . "</td><td>" . escudo($vehiculo) . "</td><td class='centro'>" . $vehiculo . "</td><td class='tie centro'>" . $tiempos . "</td></tr>";
				$tiempo_anterior = decimales($row['t_t'], 1);
				$par++;
				$pos++;
			} //IF CONDICION SI HA HECHO TODAS LAS OFICIALES
		} //WHILE
	} //IF
	echo "</table>";
	echo "</div>";
$aban = $mysqli2->query("SELECT wa.motivo,wi.concursante,wi.piloto,wi.copiloto,wi.dorsal,
		wi.vehiculo,wi.modelo
					FROM web_abandonos_archivo wa
					INNER JOIN web_inscritos_archivo wi ON wa.idinscrito = wi.idinscrito		
					WHERE wi.excluido=0 AND wa.idcarrera='$idCarrera' GROUP BY wi.dorsal ORDER BY wi.dorsal+0");
?>
<br>
<br>
<p class='negrita centro fu1'>ABANDONOS</p>
<div id='div_contenedor'>
	<table id="tabla_tiempos_ancha">
		<thead>
			<tr>
				<th>dorsal</th>
				<th>Concursante</th>
				<th>Equipo</th>
				<th class="centro" colspan="2">Vehiculo</th>
				<th class="centro">MOTIVO</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if ($aban->num_rows > 0) {
				while ($fila = $aban->fetch_array()) {
					$dorsal = $fila['dorsal'];
					$motivo = $fila['motivo'];
					$concursante = $fila['concursante'];
					$piloto = $fila['piloto'];
					$copiloto = $fila['copiloto'];
					$marca = $fila['vehiculo'];
					$modelo = $fila['modelo'];
					if ($par % 2 == 0)
						$classcss = "filapar";
					else
						$classcss = "filaimpar";
					echo "<tr class='" . $classcss . "'><td class='dor negrita'>" . $dorsal . "</td><td class='con'>" . $concursante . "</td>";
					if ($copiloto == '' || $copiloto == '0')
						echo "<td>" . $piloto . "</td>";
					else {
						echo '<td>' . $piloto;
						echo '<br>' . $copiloto . '</td>';
					}
					echo "<td>" . escudo($vehiculo) . "</td><td class='centro'>" . $marca . "<br>" . $modelo . "</td><td class='centro'>" . $motivo . "</td></tr>";
					$par++;
				}
			} //IF
			else
				echo "<tr><td colspan='7'>No existen Abandonos en esta carrera</td></tr>";
			?>
	</table>
</div>