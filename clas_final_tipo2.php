<<<<<<< HEAD
<?php
//TIPO 2, SUMa DE 2 MEJORES MANGA OFICIALES
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
	echo "<table id='tabla_tiempos_ancha'><thead><th class='centro'>P.</th><th class='centro'>N.</th><th><img src='img/tactil.png' class='icono'>EQUIPO</th><th colspan='2' class='centro'><p>Vehiculo</p><p class='mini1 nomargen'>Grupo/clase</p><p class='mini1 nomargen'>Cat./Agr.</p></th>";
	$saber_nombre_mangas = $mysqli2->query("SELECT wm.descripcion FROM web_manga wm INNER JOIN web_seccion ws ON ws.id=wm.id_ca_seccion INNER JOIN web_etapa we ON we.id=ws.id_ca_etapa WHERE we.id_ca_carrera='$idCarrera' ORDER BY wm.numero ASC");
	while ($row_mangas = $saber_nombre_mangas->fetch_array()) {
		echo "<th class='centro'>" . $row_mangas['descripcion'] . "</th>";
	}
	echo "<th class='centro'><p class='mini1 nomargen'>PRIMERO</p><p>TIEMPO</p><p class='mini1 nomargen'>ANTERIOR</p></th></thead>";
	if ($copa == '0') {
		$sql = "SELECT inscritos.idinscrito
		FROM web_inscritos inscritos
	INNER JOIN web_tiempos tiempos ON tiempos.idinscrito = inscritos.idinscrito
	WHERE inscritos.autorizado=1 AND tiempos.idcampeonato='$id_campeonato' AND tiempos.tipo_manga=1
	GROUP BY inscritos.dorsal
	ORDER BY t_t ASC";
		//COMPROBAR AQUI EL NUMERO DE MANGAS QUE HA HECHO CADA UNO CON LAS OFICIALES QUE HAY!!!!!!!!! SUPER IMPORTANTE
	} else {
		$sql = "SELECT inscritos.idinscrito
		FROM web_inscritos inscritos
	INNER JOIN web_tiempos tiempos ON tiempos.idinscrito = inscritos.idinscrito
	INNER JOIN web_copas_inscritos copas ON tiempos.idinscrito=copas.idcompetidor
	WHERE inscritos.autorizado=1 AND tiempos.idcampeonato='$id_campeonato' AND tiempos.tipo_manga=1 AND copas.idcopa='$copa'
	GROUP BY inscritos.dorsal
	ORDER BY t_t ASC";
	}
	$resultado = $mysqli2->query($sql) or print "No se pudo acceder al contenido de los tiempos online.";
	if ($resultado->num_rows > 0) {
		$ordenar = array();
		while ($rows = $resultado->fetch_array()) {
			$idinscrito = $rows['idinscrito'];
			/////////////////////MOMENTO DE BUSCAR EL PEOR TIEMPO/////////////////////
			$buscar_peor_tiempo = $mysqli2->query("SELECT MAX(t_t) AS peor FROM web_tiempos WHERE idinscrito='$idinscrito' AND tipo_manga=1 AND idcampeonato='$id_campeonato'")->fetch_array();
			$peor_tiempo = $buscar_peor_tiempo['peor'];
			//////////////////////////////////////////////////////////////////////////
			$cons_num_mangas_oficiales_competidas = $mysqli2->query("SELECT idtiempos FROM web_tiempos WHERE idinscrito = '$idinscrito' AND tipo_manga=1 AND idcampeonato='$id_campeonato'")->num_rows;
			if ($cons_num_mangas_oficiales_competidas >= 2) {
				//SUMAR SUS 2 MEJORES MANGAS
				$cont = 0;
				$cont_penalizacion = 0;
				$mejores_mangas = $mysqli2->query("SELECT t_t AS t_t,penalizacion AS penalizacion FROM web_tiempos tiempos WHERE idinscrito='$idinscrito' AND tipo_manga=1 AND idcampeonato='$id_campeonato' ORDER BY t_t ASC LIMIT 2");
				while ($row_mejores = $mejores_mangas->fetch_array()) {
					$cont += $row_mejores['t_t'];
					$cont_penalizacion += $row_mejores['penalizacion'];
				}
				//ALMACENO EN UN VECTOR EL IDINSCRITO Y EL TIEMPO
				$ordenar[] = array(
					'tiempo' => $cont,
					'idinscrito' => $idinscrito,
					'peor_tiempo' => $peor_tiempo,
					'mangas_competidas' => $cons_num_mangas_oficiales_competidas,
					'penalizacion' => $cont_penalizacion
				);
			} //IF CONDICION SI HA HECHO MINIMO 2 MANGAS DE  LAS OFICIALES
		} //WHILE
	} //IF
	$pos = 1;
	$par = 0;
	unset($pos_grupo);
	unset($pos_categoria);
	unset($pos_clase);
	unset($pos_agr);
	foreach ($ordenar as $key => $row) {
		$aux[$key] = $row['tiempo'];
	}
	array_multisort($aux, SORT_ASC, $ordenar);
	foreach ($ordenar as $key => $row) {
		$idinscrito_orden = $row['idinscrito'];
		$buscar_resto_datos = $mysqli2->query("SELECT concursante,piloto,copiloto,dorsal,nac_piloto,nac_copiloto,nac_competidor,vehiculo,modelo,grupo,clase,categoria,agrupacion
		 FROM web_inscritos WHERE idinscrito='$idinscrito_orden'")->fetch_array();
		$concusante = $buscar_resto_datos['concursante'];
		$piloto = $buscar_resto_datos['piloto'];
		$pi_nac = $buscar_resto_datos['nac_piloto'];
		$pi_nacs = explode('/', $pi_nac);
		$pi_nac1 = bandera($pi_nacs[0]);
		$pi_nac2 = bandera($pi_nacs[1]);

		$copiloto = $buscar_resto_datos['copiloto'];
		$copi_nac = $buscar_resto_datos['nac_copiloto'];
		$copi_nacs = explode('/', $copi_nac);
		$copi_nac1 = bandera($copi_nacs[0]);
		$copi_nac2 = bandera($copi_nacs[1]);
		if ($copiloto == '')
			$equipo = $piloto;
		else
			$equipo = "<img class='banderas' src='" . $pi_nac1 . "'><img class='banderas' src='" . $pi_nac2 . "'>" . $piloto . "<br><img class='banderas' src='" . $copi_nac1 . "'><img class='banderas' src='" . $copi_nac2 . "'>" . $copiloto;
		$dorsal = $buscar_resto_datos['dorsal'];
		$grupo = $buscar_resto_datos['grupo'];
		$clase = $rbuscar_resto_datosow['clase'];
		$agr = $buscar_resto_datos['agrupacion'];
		$cate = $buscar_resto_datos['categoria'];
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
		$marca = $buscar_resto_datos['vehiculo'];
		$modelo = $buscar_resto_datos['modelo'];
		$vehiculo = "<p class='veh'>" . $marca . " " . $modelo . "</p><p class='gru'>" . $grupo . $pos_en_su_grupo . "/" . $clase . $pos_en_su_clase . "<br>" . $cat . $pos_en_su_categoria . "/" . $agr . $pos_en_su_agrupacion . "</p>";

		$par % 2 == 0 ? $class = 'filapar' : $class = 'filaimpar';
		echo "<tr class='" . $class . "'><td class='centro medio'>" . $pos . "</td><td class='centro dor medio'>" . $dorsal . "</td><td>" . $equipo . "</td><td>" . escudo($vehiculo) . "</td><td class='centro'>" . $vehiculo . "</td>";
		////////////////////// BUSCAR TODOS LOS TIEMPOS DE TODAS LAS MANGAS Y FILTRAR POR CAMPEONATO//////////////////////////////////////////////////////
		$saber_id_mangas = $mysqli2->query("SELECT wm.id FROM web_manga wm INNER JOIN web_seccion ws ON ws.id=wm.id_ca_seccion INNER JOIN web_etapa we ON we.id=ws.id_ca_etapa WHERE we.id_ca_carrera='$idCarrera' ORDER BY wm.numero ASC");
		while ($row_mangasid = $saber_id_mangas->fetch_array()) {
			$idManga = $row_mangasid['id'];
			$buscar_datos_mangas = $mysqli2->query("SELECT t_t FROM web_tiempos WHERE idinscrito = '$idinscrito_orden' AND tipo_manga=1 AND idcampeonato='$id_campeonato' AND idmanga='$idManga'");
			$saber_resultado = $buscar_datos_mangas->num_rows;
			if ($saber_resultado > 0) {
				$tiempo_manga = $buscar_datos_mangas->fetch_array();
				$tiempo = $tiempo_manga['t_t'];
				$peor = $row['peor_tiempo'];
				$mangas_competidas = $row['mangas_competidas'];
				if (($peor == $tiempo) AND ($mangas_competidas==3))
					echo "<td class='centro tie'>" . milisegundos_a_tiempo($tiempo) . "</td>";
				else
					echo "<td class='centro tie negrita'>" . milisegundos_a_tiempo($tiempo) . "</td>";
			} else
				echo "<td class='centro tie'> - - - </td>";
		}
		$t_t = $row['tiempo'];
		$penalizacion = milisegundos_a_tiempo(segundos_a_milisegundos($row['penalizacion']));
		if ($pos == 1) {
			$mejor_tiempo = $t_t;
			$tiempo_anterior = $t_t;
		}
		$dif_primero = milisegundos_a_tiempo($t_t - $mejor_tiempo);
		$dif_anterior = milisegundos_a_tiempo($t_t - $tiempo_anterior);
		if ($pos == 1) {
			if ($penalizacion == 0 || $penalizacion == '')
				$tiempos = "<p class='negrita nomargen'>" . milisegundos_a_tiempo($row['tiempo']) . "</p>";
			else
				$tiempos = "<p class='negrita nomargen'>" . milisegundos_a_tiempo($row['tiempo']) . "</p><p class='penalizaciones nomargen'>" . $penalizacion . "</p>";
		} else {
			if ($penalizacion == 0 || $penalizacion == '')
				$tiempos = "<p class='anterior cursiva nomargen'>" . $dif_primero . "</p><p class='negrita nomargen'>" . milisegundos_a_tiempo($row['tiempo']) . "</p><p class='cursiva nomargen'>" . $dif_anterior . "</p>";
			else
				$tiempos = "<p class='anterior cursiva nomargen'>" . $dif_primero . "</p><p class='negrita nomargen'>" . milisegundos_a_tiempo($row['tiempo']) . "</p><p class='cursiva nomargen'>" . $dif_anterior . "</p><p class='penalizaciones nomargen'>" . $penalizacion . "</p>";
		}
		echo "<td class='tie centro'>" . $tiempos . "</p></td></tr>";
		$tiempo_anterior = $row['tiempo'];
		$pos++;
		$par++;
	}
	echo "</table>";
	echo "</div>";
	unset($ordenar);
	unset($aux);
} //WHILE


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////  ABANDONOS ///////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


$aban = $mysqli2->query("SELECT wa.motivo,wi.concursante,wi.piloto,wi.copiloto,wi.nac_competidor,wi.nac_piloto,wi.nac_copiloto,wi.dorsal,
		wi.vehiculo,wi.modelo
					FROM web_abandonos wa
					INNER JOIN web_inscritos wi ON wa.idinscrito = wi.idinscrito		
					WHERE wi.excluido=1 AND wa.idcarrera='$idCarrera' ORDER BY wi.dorsal");
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
					echo "<td>" . escudo($vehiculo) . "</td><td class='centro'>" . $marca . "<br>" . $modelo . "</td><td class='centro'>" . $motivo . "</td></tr>";
					$par++;
				}
			} //IF
			else
				echo "<tr><td colspan='7'>No existen Abandonos en esta carrera</td></tr>";
			?>
	</table>
=======
<?php
//TIPO 2, SUMa DE 2 MEJORES MANGA OFICIALES
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
	echo "<table id='tabla_tiempos_ancha'><thead><th class='centro'>P.</th><th class='centro'>N.</th><th><img src='img/tactil.png' class='icono'>EQUIPO</th><th colspan='2' class='centro'><p>Vehiculo</p><p class='mini1 nomargen'>Grupo/clase</p><p class='mini1 nomargen'>Cat./Agr.</p></th>";
	$saber_nombre_mangas = $mysqli2->query("SELECT wm.descripcion FROM web_manga wm INNER JOIN web_seccion ws ON ws.id=wm.id_ca_seccion INNER JOIN web_etapa we ON we.id=ws.id_ca_etapa WHERE we.id_ca_carrera='$idCarrera' ORDER BY wm.numero ASC");
	while ($row_mangas = $saber_nombre_mangas->fetch_array()) {
		echo "<th class='centro'>" . $row_mangas['descripcion'] . "</th>";
	}
	echo "<th class='centro'><p class='mini1 nomargen'>PRIMERO</p><p>TIEMPO</p><p class='mini1 nomargen'>ANTERIOR</p></th></thead>";
	if ($copa == '0') {
		$sql = "SELECT inscritos.idinscrito
		FROM web_inscritos inscritos
	INNER JOIN web_tiempos tiempos ON tiempos.idinscrito = inscritos.idinscrito
	WHERE inscritos.autorizado=1 AND tiempos.idcampeonato='$id_campeonato' AND tiempos.tipo_manga=1
	GROUP BY inscritos.dorsal
	ORDER BY t_t ASC";
		//COMPROBAR AQUI EL NUMERO DE MANGAS QUE HA HECHO CADA UNO CON LAS OFICIALES QUE HAY!!!!!!!!! SUPER IMPORTANTE
	} else {
		$sql = "SELECT inscritos.idinscrito
		FROM web_inscritos inscritos
	INNER JOIN web_tiempos tiempos ON tiempos.idinscrito = inscritos.idinscrito
	INNER JOIN web_copas_inscritos copas ON tiempos.idinscrito=copas.idcompetidor
	WHERE inscritos.autorizado=1 AND tiempos.idcampeonato='$id_campeonato' AND tiempos.tipo_manga=1 AND copas.idcopa='$copa'
	GROUP BY inscritos.dorsal
	ORDER BY t_t ASC";
	}
	$resultado = $mysqli2->query($sql) or print "No se pudo acceder al contenido de los tiempos online.";
	if ($resultado->num_rows > 0) {
		$ordenar = array();
		while ($rows = $resultado->fetch_array()) {
			$idinscrito = $rows['idinscrito'];
			/////////////////////MOMENTO DE BUSCAR EL PEOR TIEMPO/////////////////////
			$buscar_peor_tiempo = $mysqli2->query("SELECT MAX(t_t) AS peor FROM web_tiempos WHERE idinscrito='$idinscrito' AND tipo_manga=1 AND idcampeonato='$id_campeonato'")->fetch_array();
			$peor_tiempo = $buscar_peor_tiempo['peor'];
			//////////////////////////////////////////////////////////////////////////
			$cons_num_mangas_oficiales_competidas = $mysqli2->query("SELECT idtiempos FROM web_tiempos WHERE idinscrito = '$idinscrito' AND tipo_manga=1 AND idcampeonato='$id_campeonato'")->num_rows;
			if ($cons_num_mangas_oficiales_competidas >= 2) {
				//SUMAR SUS 2 MEJORES MANGAS
				$cont = 0;
				$cont_penalizacion = 0;
				$mejores_mangas = $mysqli2->query("SELECT t_t AS t_t,penalizacion AS penalizacion FROM web_tiempos tiempos WHERE idinscrito='$idinscrito' AND tipo_manga=1 AND idcampeonato='$id_campeonato' ORDER BY t_t ASC LIMIT 2");
				while ($row_mejores = $mejores_mangas->fetch_array()) {
					$cont += $row_mejores['t_t'];
					$cont_penalizacion += $row_mejores['penalizacion'];
				}
				//ALMACENO EN UN VECTOR EL IDINSCRITO Y EL TIEMPO
				$ordenar[] = array(
					'tiempo' => $cont,
					'idinscrito' => $idinscrito,
					'peor_tiempo' => $peor_tiempo,
					'mangas_competidas' => $cons_num_mangas_oficiales_competidas,
					'penalizacion' => $cont_penalizacion
				);
			} //IF CONDICION SI HA HECHO MINIMO 2 MANGAS DE  LAS OFICIALES
		} //WHILE
	} //IF
	$pos = 1;
	$par = 0;
	unset($pos_grupo);
	unset($pos_categoria);
	unset($pos_clase);
	unset($pos_agr);
	foreach ($ordenar as $key => $row) {
		$aux[$key] = $row['tiempo'];
	}
	array_multisort($aux, SORT_ASC, $ordenar);
	foreach ($ordenar as $key => $row) {
		$idinscrito_orden = $row['idinscrito'];
		$buscar_resto_datos = $mysqli2->query("SELECT concursante,piloto,copiloto,dorsal,nac_piloto,nac_copiloto,nac_competidor,vehiculo,modelo,grupo,clase,categoria,agrupacion
		 FROM web_inscritos WHERE idinscrito='$idinscrito_orden'")->fetch_array();
		$concusante = $buscar_resto_datos['concursante'];
		$piloto = $buscar_resto_datos['piloto'];
		$pi_nac = $buscar_resto_datos['nac_piloto'];
		$pi_nacs = explode('/', $pi_nac);
		$pi_nac1 = bandera($pi_nacs[0]);
		$pi_nac2 = bandera($pi_nacs[1]);

		$copiloto = $buscar_resto_datos['copiloto'];
		$copi_nac = $buscar_resto_datos['nac_copiloto'];
		$copi_nacs = explode('/', $copi_nac);
		$copi_nac1 = bandera($copi_nacs[0]);
		$copi_nac2 = bandera($copi_nacs[1]);
		if ($copiloto == '')
			$equipo = $piloto;
		else
			$equipo = "<img class='banderas' src='" . $pi_nac1 . "'><img class='banderas' src='" . $pi_nac2 . "'>" . $piloto . "<br><img class='banderas' src='" . $copi_nac1 . "'><img class='banderas' src='" . $copi_nac2 . "'>" . $copiloto;
		$dorsal = $buscar_resto_datos['dorsal'];
		$grupo = $buscar_resto_datos['grupo'];
		$clase = $rbuscar_resto_datosow['clase'];
		$agr = $buscar_resto_datos['agrupacion'];
		$cate = $buscar_resto_datos['categoria'];
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
		$marca = $buscar_resto_datos['vehiculo'];
		$modelo = $buscar_resto_datos['modelo'];
		$vehiculo = "<p class='veh'>" . $marca . " " . $modelo . "</p><p class='gru'>" . $grupo . $pos_en_su_grupo . "/" . $clase . $pos_en_su_clase . "<br>" . $cat . $pos_en_su_categoria . "/" . $agr . $pos_en_su_agrupacion . "</p>";

		$par % 2 == 0 ? $class = 'filapar' : $class = 'filaimpar';
		echo "<tr class='" . $class . "'><td class='centro medio'>" . $pos . "</td><td class='centro dor medio'>" . $dorsal . "</td><td>" . $equipo . "</td><td>" . escudo($vehiculo) . "</td><td class='centro'>" . $vehiculo . "</td>";
		////////////////////// BUSCAR TODOS LOS TIEMPOS DE TODAS LAS MANGAS Y FILTRAR POR CAMPEONATO//////////////////////////////////////////////////////
		$saber_id_mangas = $mysqli2->query("SELECT wm.id FROM web_manga wm INNER JOIN web_seccion ws ON ws.id=wm.id_ca_seccion INNER JOIN web_etapa we ON we.id=ws.id_ca_etapa WHERE we.id_ca_carrera='$idCarrera' ORDER BY wm.numero ASC");
		while ($row_mangasid = $saber_id_mangas->fetch_array()) {
			$idManga = $row_mangasid['id'];
			$buscar_datos_mangas = $mysqli2->query("SELECT t_t FROM web_tiempos WHERE idinscrito = '$idinscrito_orden' AND tipo_manga=1 AND idcampeonato='$id_campeonato' AND idmanga='$idManga'");
			$saber_resultado = $buscar_datos_mangas->num_rows;
			if ($saber_resultado > 0) {
				$tiempo_manga = $buscar_datos_mangas->fetch_array();
				$tiempo = $tiempo_manga['t_t'];
				$peor = $row['peor_tiempo'];
				$mangas_competidas = $row['mangas_competidas'];
				if (($peor == $tiempo) AND ($mangas_competidas==3))
					echo "<td class='centro tie'>" . milisegundos_a_tiempo($tiempo) . "</td>";
				else
					echo "<td class='centro tie negrita'>" . milisegundos_a_tiempo($tiempo) . "</td>";
			} else
				echo "<td class='centro tie'> - - - </td>";
		}
		$t_t = $row['tiempo'];
		$penalizacion = milisegundos_a_tiempo(segundos_a_milisegundos($row['penalizacion']));
		if ($pos == 1) {
			$mejor_tiempo = $t_t;
			$tiempo_anterior = $t_t;
		}
		$dif_primero = milisegundos_a_tiempo($t_t - $mejor_tiempo);
		$dif_anterior = milisegundos_a_tiempo($t_t - $tiempo_anterior);
		if ($pos == 1) {
			if ($penalizacion == 0 || $penalizacion == '')
				$tiempos = "<p class='negrita nomargen'>" . milisegundos_a_tiempo($row['tiempo']) . "</p>";
			else
				$tiempos = "<p class='negrita nomargen'>" . milisegundos_a_tiempo($row['tiempo']) . "</p><p class='penalizaciones nomargen'>" . $penalizacion . "</p>";
		} else {
			if ($penalizacion == 0 || $penalizacion == '')
				$tiempos = "<p class='anterior cursiva nomargen'>" . $dif_primero . "</p><p class='negrita nomargen'>" . milisegundos_a_tiempo($row['tiempo']) . "</p><p class='cursiva nomargen'>" . $dif_anterior . "</p>";
			else
				$tiempos = "<p class='anterior cursiva nomargen'>" . $dif_primero . "</p><p class='negrita nomargen'>" . milisegundos_a_tiempo($row['tiempo']) . "</p><p class='cursiva nomargen'>" . $dif_anterior . "</p><p class='penalizaciones nomargen'>" . $penalizacion . "</p>";
		}
		echo "<td class='tie centro'>" . $tiempos . "</p></td></tr>";
		$tiempo_anterior = $row['tiempo'];
		$pos++;
		$par++;
	}
	echo "</table>";
	echo "</div>";
	unset($ordenar);
	unset($aux);
} //WHILE


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////  ABANDONOS ///////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


$aban = $mysqli2->query("SELECT wa.motivo,wi.concursante,wi.piloto,wi.copiloto,wi.nac_competidor,wi.nac_piloto,wi.nac_copiloto,wi.dorsal,
		wi.vehiculo,wi.modelo
					FROM web_abandonos wa
					INNER JOIN web_inscritos wi ON wa.idinscrito = wi.idinscrito		
					WHERE wi.excluido=1 AND wa.idcarrera='$idCarrera' ORDER BY wi.dorsal");
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
					echo "<td>" . escudo($vehiculo) . "</td><td class='centro'>" . $marca . "<br>" . $modelo . "</td><td class='centro'>" . $motivo . "</td></tr>";
					$par++;
				}
			} //IF
			else
				echo "<tr><td colspan='7'>No existen Abandonos en esta carrera</td></tr>";
			?>
	</table>
>>>>>>> main
</div>