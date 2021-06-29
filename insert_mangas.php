<html>

<head>
	<META HTTP-EQUIV="REFRESH" CONTENT="15;URL=http://codea.es/insert_mangas.php?id=<?php echo $_GET['id'] ?>">
</head>

<body>
	<?php
	function tiempo_a_milisegundos($tiempo)
	{
		$s = 1000;
		$m = 60 * $s;
		$h = 60 * $m;
		list($tiempo, $mili) = explode('.', trim($tiempo), 2);
		list($hora, $minuto, $segundo) = explode(':', trim($tiempo), 3);
		$res = 0;
		if (is_numeric($mili) && is_numeric($hora) && is_numeric($minuto) && is_numeric($segundo)) {
			while (strlen($mili) != 3) {
				if (strlen($mili) < 3) $mili .= '0';
				else substr($mili, 0, -1);
			}
			$res = $mili;
			$res += $segundo * $s;
			$res += $minuto * $m;
			$res += $hora * $h;
		}
		return $res;
	}

	function milisegundos_a_tiempo($mili)
	{
		if (is_numeric($mili)) {
			$s = 1000;
			$m = 60 * $s;
			$h = 60 * $m;
			$hora = floor($mili / $h);
			$mili = $mili - ($hora * $h);
			$minuto = floor($mili / $m);
			$mili = $mili - ($minuto * $m);
			$segundo = floor($mili / $s);
			$mili = $mili - ($segundo * $s);
			if (strlen($hora . '') == 1) $hora = '0' . $hora;
			if (strlen($minuto . '') == 1) $minuto = '0' . $minuto;
			if (strlen($segundo . '') == 1) $segundo = '0' . $segundo;
			if (strlen($mili . '') == 1) $mili = '00' . $mili;
			else if (strlen($mili . '') == 2) $mili = '0' . $mili;
			$time = $minuto . ':' . $segundo . '.' . $mili;
			if ($hora != '00') {
				$time = $hora . ':' . $time;
			}
			return $time;
		} else return $mili;
	}
	function segundos_a_milisegundos($segundos)
	{
		$segundos = $segundos * 1000;
		return $segundos;
	}

	include "conexion_credenciales.php";

	/*BASE DE DATOS DEL SERVIDOR DE JOSE*/
	$mysqli = new mysqli($IPservidor3, $usuario3, $clave3, $nombreBD3);
	$mysqli->set_charset("utf8");

	$mysqli2 = new mysqli($IPservidor2, $usuario2, $clave2, $nombreBD2);
	$mysqli2->set_charset("utf8");

	$id = $_GET['id'];
	$nuevos = 0;
	$actualizados = 0;
	$modo = $mysqli->query("SELECT * FROM abc_57os_ca_campeonato WHERE id_ca_carrera = '$id'");
	if ($modo->num_rows > 0) {
		echo "CAMPEONATOS PeRTENECIENTES:";
		while ($fi = $modo->fetch_array()) {
			$modo_tiempo = $fi['tiempo_tipo'];
			$id_campeonato = $fi['id'];
			$modalidad = $fi['id_ca_modalidad'];
			$nom_camp = $fi['nombre'];
			$nom_camp = str_replace('ESPAÃ‘A', 'ESPAÑA', $nom_camp);
			$nom_camp = str_replace('EspaÃ±a', 'ESPAÑA', $nom_camp);
			$man_oficiales = $mysqli->query("SELECT man.descripcion FROM abc_57os_ca_manga man INNER JOIN abc_57os_ca_campeonato_manga caman ON caman.id_ca_manga=man.id 
			INNER JOIN abc_57os_ca_campeonato cam ON cam.id=caman.id_ca_campeonato WHERE cam.id='$id_campeonato' AND man.tipo='1'");
			$man_ofi = $man_oficiales->num_rows;
			echo "<br>" . $nom_camp . "MOD:" . $modalidad . "T_TIPO:" . $modo_tiempo . " MANGAS OFICIALES: " . $man_ofi . " ID_CAMP: " . $id_campeonato;
			//CONCULTO SI EXISTEN LOS CAMPEONATOS EN WEB_TABLA
			$con_exi_camp = $mysqli2->query("SELECT id FROM web_campeonatos WHERE id='$id_campeonato'");
			if ($con_exi_camp->num_rows > 0)
				$sql_cam = $mysqli2->query("UPDATE web_campeonatos SET id='$id_campeonato',idcarrera='$id',nombre='$nom_camp',idmodalidad='$modalidad',tipo_tiempo='$modo_tiempo',mangas_oficiales='$man_ofi' WHERE id='$id_campeonato'");
			else
				$sql_cam = $mysqli2->query("INSERT INTO web_campeonatos (id,idcarrera,nombre,idmodalidad,tipo_tiempo,mangas_oficiales) VALUES ('$id_campeonato','$id','$nom_camp','$modalidad','$modo_tiempo','$man_ofi')");

			//SABER LAS COPAS QUE HAY EN ESTA CARRERA
			$copas = $mysqli->query("SELECT id,descripcion,id_ca_campeonato FROM abc_57os_ca_copa WHERE id_ca_carrera = '$id'");
			if ($copas->num_rows > 0) {
				echo "<br>COPAS EXISTENTES: <br>";
				while ($fico = $copas->fetch_array()) {
					$des = $fico['descripcion'];
					$des = str_replace('ESPAÃ‘A', 'ESPAÑA', $des);
					$copa_idcampeonato = $fico['id_ca_campeonato'];
					$idcopa = $fico['id'];
					//LOS INSCRITOS A DICHAS COPAS
					$copas_ins = $mysqli->query("SELECT id_ca_competidor FROM abc_57os_ca_copa_competidor WHERE id_ca_copa='$idcopa'");
					if ($copas_ins->num_rows > 0) {
						while ($ficoin = $copas_ins->fetch_array()) {
							$copa_idcompetidor = $ficoin['id_ca_competidor'];
							$con_ins_cop = $mysqli2->query("SELECT idcompetidor FROM web_copas_inscritos WHERE idcompetidor='$copa_idcompetidor' AND idcopa='$idcopa'");
							if ($con_ins_cop->num_rows == 0)
								$inscop = $mysqli2->query("INSERT INTO web_copas_inscritos (id,idcopa,idcompetidor) VALUES ('','$idcopa','$copa_idcompetidor')");
							//$idcopa = $ficoin['id_ca_copa'];
						}
						/*$con_ins_cop=$mysqli2->query("SELECT id_competidor FROM web_copas WHERE idcompetidor='$copa_idcompetidor'");
							if($con_ins_cop->num_rows>0){
								$inscop = $mysqli2->query("UPDATE web_copas_inscritos SET idcampeonato='$des' WHERE id='$idcopa'");
								}
							else*/
					}
					//consulto registro en BD para INS o ACTUALIZACION
					$con_co = $mysqli2->query("SELECT id FROM web_copas WHERE id='$idcopa'");
					if ($con_co->num_rows > 0) {
						$inscop = $mysqli2->query("UPDATE web_copas SET descripcion='$des' WHERE id='$idcopa'");
					} else
						$inscop = $mysqli2->query("INSERT INTO web_copas (id,descripcion,idcampeonato,idcarrera) VALUES ('$idcopa','$des','$copa_idcampeonato','$id')");
					echo "<p style='margin:0 auto;font-size:8px'>" . $des . "-" . $copa_idcampeonato . "-" . $idcopa . "</p>";
				}
			}



			echo "<br>MODO_TIEMPO: " . $modo_tiempo;
			//$idManga = $_GET['idmanga'];
			$con_mangas = $mysqli->query("SELECT man.descripcion AS des,man.id AS id FROM abc_57os_ca_manga man 
INNER JOIN abc_57os_ca_seccion sec ON man.id_ca_seccion=sec.id 
INNER JOIN abc_57os_ca_etapa eta ON sec.id_ca_etapa=eta.id WHERE eta.id_ca_carrera='$id'");
			while ($filaca = $con_mangas->fetch_array()) {
				$idManga = $filaca['id'];
				echo "<p>MANGA: " . $filaca['des'] . "</p>";
				$sql = "SELECT com.id AS idconcursante, m.tipo AS tipo_manga,m.numero AS num_manga,com.dorsal,pi.nombre AS piloto_nombre,
		veh.grupo AS grupo,veh.clase AS clase,veh.marca AS marca,veh.modelo As modelo,pi.nacionalidad AS pi_nac
		FROM abc_57os_ca_carrera car
		INNER JOIN abc_57os_ca_competidor com ON car.id=com.id_ca_carrera
		INNER JOIN abc_57os_ca_etapa e ON e.id_ca_carrera=car.id
		INNER JOIN abc_57os_ca_seccion s ON s.id_ca_etapa=e.id
		INNER JOIN abc_57os_ca_manga m ON m.id_ca_seccion=s.id
		INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto
		INNER JOIN abc_57os_ca_vehiculo veh ON veh.id=com.id_ca_vehiculo
		INNER JOIN abc_57os_ca_campeonato_competidor ccm ON ccm.id_ca_competidor=com.id
		WHERE m.id='$idManga' AND com.autorizado=1 AND ccm.id_ca_campeonato = '$id_campeonato' GROUP BY dorsal";
				//echo $sql;
				$resultado = $mysqli->query($sql) or print "No se pudo acceder al contenido de los tiempos online.";

				if ($resultado->num_rows > 0) {
					while ($fila = $resultado->fetch_array()) {
						$ss = $fila['ss'];
						$t_l = 0;
						$dorsal = $fila['dorsal'];
						$competidor = $fila['competidor'];
						$piloto = $fila['piloto_nombre'];
						$vehiculo = $fila['marca'];
						$idcomp = $fila['idcompetidor'];
						$tipo_manga = $fila['tipo_manga'];
						$idconcursante = $fila['idconcursante'];
						//INSERTARLO EN LOS CAMPEONATOS QUE ESTA INSCRITO
						/*$sql_camp_com = $mysqli->query("SELECT id_ca_campeonato FROM abc_57os_ca_campeonato_competidor WHERE id_ca_competidor='$idconcursante'");
			if($sql_camp_com->num_rows>0){
				while($fi=$sql_camp_com->fetch_array()){
					$idcampe = $fi['id_ca_campeonato'];
						$con_camp_web = $mysqli2->query("SELECT id FROM web_campeonatos_inscritos WHERE idinscrito='$idconcursante' AND idcampeonato='$idcampe'");
					if($con_camp_web->num_rows==0)
						$ins_camp = $mysqli2->query("INSERT INTO web_campeonatos_inscritos (id,idinscrito,idcampeonato,idcarrera) VALUES ('','$idconcursante','$idcampe','$id')");
					//FALTARIA AQUI ACTUALIZACION EN CASO DE CAMBIO DE CAMPEONATO, ES REDUNDANTE Y POR ESO NO LA HAGO, HABRIA Q VACIAR LOS INSCRITOS Y CREAR DE NUEVO
				}
			}
			else
				echo "NO EXISTE INSCRITO EN ESTE CAMPEONATO, Error SISTEMA";*/
						$tipo_manga = $fila['tipo_manga'];
						$num_manga = $fila['num_manga'];
						$sql_oficial = $mysqli->query("SELECT ch.orden AS orden,t.tiempo FROM abc_57os_ca_tiempo t 
			INNER JOIN abc_57os_ca_manga_control_horario ch ON ch.id=t.id_ca_manga_control_horario 
			INNER JOIN abc_57os_ca_manga m ON ch.id_ca_manga=m.id 
			WHERE t.dorsal='$dorsal' AND t.id_ca_manga='$idManga'");
						$abandono = $mysqli->query("SELECT id FROM abc_57os_ca_abandono WHERE id_ca_manga='$idManga' AND dorsal='$dorsal'");
						if ($abandono->num_rows == 0) {
							$aban = 0;
							$tipo = 0;
							if ($sql_oficial->num_rows >= 2) //MIN 2 TIEMPOS, SALIDA - LLEGADA
							{
								while ($fil = $sql_oficial->fetch_array()) {
									$tipo = $fil['tipo'];
									$orden = $fil['orden'];
									if ($orden == 0) { //ES SALIDA
										$t_s = tiempo_a_milisegundos($fil['tiempo']);
									}
									if ($orden == 10) { //ES LLEGADA
										$t_l = tiempo_a_milisegundos($fil['tiempo']);
									}
									if ($t_s > 0 and $t_l > 0) {
										$t_t = ($t_l - $t_s);
									} else
										$t_t = 0;
								}
							}
						} else {
							$aban = 1;
						}
						$c_pen = $mysqli->query("SELECT tiempo FROM abc_57os_ca_penalizacion WHERE id_ca_manga='$idManga' AND dorsal='$dorsal'");
						if ($c_pen->num_rows > 0) //lo recorro por si tiene mas de una penalizacion en la misma MANGA
						{
							$pen = 0;
							while ($rowp = $c_pen->fetch_array())
								$pen += $rowp['tiempo'];
						} else
							$pen = 0;
						$penm = segundos_a_milisegundos($pen);
						$t_t += $penm;
						/*SABER CUANTAS MANGAS OFICIALES TIENE ESTE PILOTO EN ESTE CAMPEONATO
			$man_oficiales = $mysqli->query("SELECT man.descripcion FROM abc_57os_ca_manga man 
			INNER JOIN abc_57os_ca_campeonato_manga caman ON caman.id_ca_manga=man.id 
			INNER JOIN abc_57os_ca_campeonato cam ON cam.id=caman.id_ca_campeonato 
			INNER JOIN abc_57os_ca_campeonato_competidor cacom ON cacom.id_ca_campeonato=cam.id 
			WHERE cam.id_ca_carrera='$id' AND cacom.id_ca_competidor='$idconcursante' GROUP BY man.descripcion");
			$man_ofi = $man_oficiales->num_rows;*/
						echo "<p style='margin:0 auto;font-size:10px'>" . $idconcursante . "----" . $dorsal . "--" . $piloto . "----" . $t_s . "----" . $t_l . "----TT: " . milisegundos_a_tiempo($t_t) . "----TIPO: " . $tipo_manga . "---NUM MANGA: " . $num_manga . "-PEN: " . $pen . " CAMP: " . $idcampe . "</p>";
						$con = "SELECT man.descripcion FROM abc_57os_ca_manga man INNER JOIN abc_57os_ca_campeonato_manga caman ON caman.id_ca_manga=man.id 
				INNER JOIN abc_57os_ca_campeonato cam ON cam.id=caman.id_ca_campeonato 
				INNER JOIN abc_57os_ca_campeonato_competidor cacom ON cacom.id_ca_campeonato=cam.id 
				WHERE cam.id_ca_carrera='$id' AND cam.id='$id_campeonato' AND man.id='$idManga' AND cacom.id_ca_competidor='$idconcursante' GROUP BY man.descripcion";
						//echo $con;
						$con2 = $mysqli->query($con);
						//echo "<br>AFEc CAMP: ".$con2->num_rows;
						//if($con2->num_rows>0){
						//CONSULTAR SI EXISTE EL TIEMPO
						$con_camp = "SELECT idinscrito FROM web_tiempos WHERE idinscrito='$idconcursante' AND num_manga='$num_manga' AND idcampeonato='$id_campeonato'";
						$con_camp2 = $mysqli2->query($con_camp);
						//echo "<br>AFE INSCRITO- ".$con_camp2->num_rows." - ".$con_camp;
						if ($con_camp2->num_rows == 0) {
							$ins_tiempo = $mysqli2->query("INSERT INTO web_tiempos (idtiempos,idinscrito,idmanga,h_s,h_l,idcarrera,t_t,penalizacion,num_manga,tipo_manga,idcampeonato)
					VALUES ('','$idconcursante','$idManga','$t_s','$t_l','$id','$t_t','$pen','$num_manga','$tipo_manga','$id_campeonato')") or print('error en Insercion de DATOS');
							$nuevos++;
						} else {
							$act_tiempo = $mysqli2->query("UPDATE web_tiempos SET
				h_s='$t_s',
				h_l='$t_l',
				t_t='$t_t',
				idcarrera='$id',
				num_manga='$num_manga',
				tipo_manga='$tipo_manga',
				penalizacion='$pen',
				idcampeonato='$id_campeonato'
				WHERE idinscrito='$idconcursante' AND idmanga='$idManga' AND idcampeonato='$id_campeonato'") or print("Error Actualizando el registro");
							$actualizados++;
						}

						//}
						/*else{
				$act_tiempo = $mysqli2->query("UPDATE web_tiempos SET
				h_s='$t_s',
				h_l='$t_l',
				t_t='$t_t',
				idcarrera='$id',
				num_manga='$num_manga',
				tipo_manga='$tipo_manga',
				penalizacion='$pen',
				idcampeonato='$id_campeonato'
				WHERE idinscrito='$idconcursante' AND idmanga='$idManga' AND idcampeonato='$id_campeonato'") or print("Error Actualizando el registro");
				$actualizados++;
			}*/
						$t_t = 0;
					}
				}
				echo "<p style='margin:0 auto;font-size:10px'>REG.NUEVOS: " . $nuevos . "</p>";
				echo "<p style='margin:0 auto;font-size:10px'>REG.ACTUALIZADOS: " . $actualizados . "</p>";
				$nuevos = 0;
				$actualizados = 0;
			}
		}
	} //WHILE DE MANGAS	
	?>
</body>

</html>