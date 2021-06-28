<?php
//TIPO 3, SUMa DE TODAS LAS MANGA OFICIALES
include("conexion.php");
include("includes/funcionesTiempos.php");
include("escudos.php");
if (isset($_GET["copa"]))
	$copa = $_GET["copa"];
else
	$copa = '0';
//IMPORTANTE, SABER CUANDO SE PUEDE MOSTRAR LA CLASIFICACION (Boton en el sistema)
$campeonatos_carrera = $mysqli2->query("SELECT * FROM web_campeonatos WHERE idcarrera='$idCarrera'");
while ($mifila = $campeonatos_carrera->fetch_array()) {
	$nom = strtoupper($mifila['nombre']);
	$id_campeonato = $mifila['id'];
	$num_mangas_oficiales_campeonato = $mifila['mangas_oficiales'];
	//SE PODRIA COMPROBAR QUE EXISTAN TIEMPOS DENTRO A FIN DE NO MOSTRAR CAMPEONATOS VACIOS
	echo "<p class='negrita centro fu1'>" . $nom . "</p>";
	echo "<div id='div_contenedor'>";
	echo "<table id='tabla_tiempos_ancha'><thead><th class='centro'>P.</th><th class='centro'>N.</th><th>CONCURSANTE</th><th><img src='img/tactil.png' class='icono'>EQUIPO</th><th colspan='2' class='centro'><p>Vehiculo</p><p class='mini1 nomargen'>Grupo/clase</p><p class='mini1 nomargen'>Cat./Agr.</p></th><th class='centro'><p class='mini1 nomargen'>PRIMERO</p><p>TIEMPO</p><p class='mini1 nomargen'>ANTERIOR</p></th></thead>";
	if ($copa == '0') {
		$sql = "SELECT inscritos.idinscrito,inscritos.piloto,inscritos.copiloto,SUM(tiempos.t_t) AS t_t,SUM(tiempos.penalizacion) AS penalizacion,inscritos.vehiculo,inscritos.concursante,inscritos.dorsal,inscritos.modelo,inscritos.grupo,
		inscritos.clase,inscritos.agrupacion,inscritos.categoria,inscritos.nac_piloto,inscritos.nac_copiloto,inscritos.nac_competidor
		FROM web_inscritos inscritos
	INNER JOIN web_tiempos tiempos ON tiempos.idinscrito = inscritos.idinscrito
	WHERE inscritos.autorizado=1 AND tiempos.idcampeonato='$id_campeonato' AND tiempos.tipo_manga=1
	GROUP BY inscritos.dorsal
	ORDER BY t_t ASC";
		//COMPROBAR AQUI EL NUMERO DE MANGAS QUE HA HECHO CADA UNO CON LAS OFICIALES QUE HAY!!!!!!!!! SUPER IMPORTANTE
	} else {
		$sql = "SELECT inscritos.idinscrito,inscritos.piloto,inscritos.copiloto,SUM(tiempos.t_t) AS t_t,SUM(tiempos.penalizacion) AS penalizacion,inscritos.vehiculo,inscritos.concursante,inscritos.dorsal,inscritos.modelo,inscritos.grupo,
		inscritos.clase,inscritos.agrupacion,inscritos.categoria,inscritos.nac_piloto,inscritos.nac_copiloto,inscritos.nac_competidor
		FROM web_inscritos inscritos
	INNER JOIN web_tiempos tiempos ON tiempos.idinscrito = inscritos.idinscrito
	INNER JOIN web_copas_inscritos copas ON tiempos.idinscrito=copas.idcompetidor
	WHERE inscritos.autorizado=1 AND tiempos.idcampeonato='$id_campeonato' AND tiempos.tipo_manga=1 AND copas.idcopa='$copa'
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
			$idinscrito = $row['idinscrito'];
			$cons_num_mangas_oficiales_competidas = $mysqli2->query("SELECT idtiempos FROM web_tiempos WHERE idinscrito = '$idinscrito' AND tipo_manga=1 AND idcampeonato='$id_campeonato'")->num_rows;
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
				$con_nac = $row['nac_competidor'];
				$con_nac = explode("/", $con_nac);
				$con_nac1 = bandera($con_nac[0]);
				$con_nac2 = bandera($con_nac[1]);
				$concursante = "<img class='banderas' src='" . $pi_nac1 . "'><img class='banderas' src='" . $pi_nac2 . "'>" . $concursante;
				$t_t = decimales($row['t_t'], 1);
				if ($pos == 1) {
					$mejor_tiempo = $t_t;
					$tiempo_anterior = $t_t;
				}
				$dif_primero = milisegundos_a_tiempo($t_t - $mejor_tiempo);
				$dif_anterior = milisegundos_a_tiempo($t_t - $tiempo_anterior);
				$t_t = milisegundos_a_tiempo($t_t);
				$penalizacion = milisegundos_a_tiempo(segundos_a_milisegundos($row['penalizacion']));
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
} //WHILE
$aban = $mysqli->query("SELECT abandono.motivo,piloto.nombre AS piloto,copiloto.nombre AS copiloto, concursante.nombre AS concursante,
competidor.dorsal,vehiculo.marca AS vehiculo
FROM abc_57os_ca_abandono abandono
INNER JOIN abc_57os_ca_competidor competidor ON competidor.id=abandono.id_ca_competidor
INNER JOIN abc_57os_ca_piloto piloto ON piloto.id = competidor.id_ca_piloto
INNER JOIN abc_57os_ca_copiloto copiloto ON copiloto.id = competidor.id_ca_copiloto
INNER JOIN abc_57os_ca_concursante concursante ON concursante.id = competidor.id_ca_concursante
INNER JOIN abc_57os_ca_vehiculo vehiculo ON vehiculo.id = competidor.id_Ca_vehiculo
WHERE abandono.id_ca_carrera='$idCarrera'
ORDER BY competidor.dorsal + 1 ASC");
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

					$con_nac = $fila['nac_competidor'];
					$con_nacs = explode("/", $con_nac);
					$con_nac1 = bandera($con_nacs[0]);
					$con_nac2 = bandera($con_nacs[1]);

					$pi_nac = $fila['nac_piloto'];
					$pi_nacs = explode('/', $pi_nac);
					$pi_nac1 = bandera($pi_nacs[0]);
					$pi_nac2 = bandera($pi_nacs[1]);

					$copi_nac = $fila['nac_copiloto'];
					$copi_nacs = explode('/', $copi_nac);
					$copi_nac1 = bandera($copi_nacs[0]);
					$copi_nac2 = bandera($copi_nacs[1]);
					if ($par % 2 == 0)
						$classcss = "filapar";
					else
						$classcss = "filaimpar";
					echo "<tr class='" . $classcss . "'><td class='dor negrita'>" . $dorsal . "</td><td class='con'>" . $concursante . "</td>";
					if ($copiloto == '' || $copiloto == '0')
						echo "<td>" . $piloto . "</td>";
					else {
						echo '<td><img class="banderas" src="' . $pi_nac1 . '"><img class="banderas" src="' . $pi_nac2 . '">' . $piloto;
						echo '<br><img class="banderas" src="' . $copi_nac1 . '"><img class="banderas" src="' . $copi_nac2 . '">' . $copiloto . '</td>';
					}
					echo "<td>" . escudo($marca) . "</td><td class='centro'>" . $marca . "<br>" . $modelo . "</td><td class='centro'>" . $motivo . "</td></tr>";
					$par++;
				}
			} //IF
			else
				echo "<tr><td colspan='7'>No existen Abandonos en esta carrera</td></tr>";
			?>
	</table>
</div>