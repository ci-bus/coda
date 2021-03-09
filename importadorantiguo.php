<?php
function milisegundos_a_tiempo($mili)
{
	if (is_numeric($mili)) {
		$s = 1000;
		$m = 60 * $s;
		$h = 60 * $m;
		$res = '';
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
$id = $_GET['id'];
echo "EXPORTADOR / IMPORTADOR DE PRUEBAS ANTERIORES A SISTEMA";
echo "<br>ID CARRERA: " . $id;
/********************************************************* */
//BASE DE DATOS ANTIGUA DE DONDE VAMOS A SACAR LOS DATOS/////
/********************************************************* */
if (!$mysqli) {
	$IPservidor = "localhost:3306";
	$nombreBD = "coda";
	$usuario = "manuel";
	$clave = "coda200900==";
	$mysqli = new mysqli($IPservidor, $usuario, $clave, $nombreBD);
	$mysqli->set_charset("utf8");
	echo "conexion BD 1 ::::ok";
}
/********************************************************* */
//BASE DE DATOS NUEVA DONDE VAMOS A IMPORTAR LOS DATOS  /////
/********************************************************* */
if (!$mysqli2) {
	$IPservidor2 = "localhost:3306";
	$nombreBD2 = "web2020";
	$usuario2 = "web2020";
	$clave2 = "Kp!vt750";
	$mysqli2 = new mysqli($IPservidor2, $usuario2, $clave2, $nombreBD2);
	$mysqli2->set_charset("utf8");
	echo "   conexion BD 2 ::::ok";
}
/////////////////////////////////////////////////////////
////   1-OBTENER INFO COMPLETA DE LA CARRERA      //////
////////////////////////////////////////////////////////
/*$todas_pruebas = $mysqli->query("SELECT idcarreras FROM carreras");
while ($fila = $todas_pruebas->fetch_array()) {
	$id = $fila['idcarreras'];*/
	$sql_prueba = $mysqli->query("SELECT * FROM carreras WHERE idcarreras = '$id'");
	if ($sql_prueba->num_rows > 0) {
		echo "<h3>DATOS DE CARRERA A EXPORTAR:</h3>";
		while ($row = $sql_prueba->fetch_array()) {
			$descripcion = $row['descripcion'];
			$fecha = $row['fecha'];
			$fecha_larga = $row['fecha_larga'];
			$estado = $row['estado'];
			$tipo = $row['tipo'];
			$tipo_informe = $row['tipo_informe'];
			$modo = $row['modo_tiempos'];
			$temporada = $row['temporada'];
			$organizador = $row['organizador'];
			$idweb = $row['idweb'];
			if ($idweb == 'NULL' || $idweb == NULL)
				$idweb = 0;
			$titulo = $row['titulo'];
			$poblacion = $row['poblacion'];
			$desactivada = $row['desactivada'];
			$imagen = $row['imagen'];
			$mapa = $row['mapa'];
			$idgrupo = $row['idgrupo'];
		}
		echo "TITULO:" . $titulo . " FECHA: " . $fecha . " FECHA LARGA: " . $fecha_larga;
		$sql_insertar = $mysqli2->query("SELECT idcarrera FROM web_pruebas_archivo WHERE idcarrera = '$id'");
		if ($sql_insertar->num_rows > 0) {
			//SIGNIFICARA QUE YA EXISTE
			echo "<h2>ESTE REGISTRO DE CARRERA YA EXISTE</h2>";
		} else {
			$sql_insertar = $mysqli2->query("INSERT INTO web_pruebas_archivo (idcarrera,temporada,web,ruta_tablon,titulo,fecha,fecha_larga,poblacion,tipo,modo_tiempos,img_prueba,img_organizador,img_sponsor,organizador,estado) 
		VALUES ('$id','$temporada','$idweb','','$titulo','$fecha','$fecha_larga','$poblacion','$tipo','$modo','','','','$organizador','$estado')");
		}
	} else
		echo "NO EXISTEN DATOS CON ESTE ID DE CARRERA: " . $id;

	//////////////////////////////////////////////////////////////
	/////   2- MANGAS PERTENECIENTES A ESTA CARRERA      /////////
	//////////////////////////////////////////////////////////////
	$borrar_tiempos = $mysqli2->query("DELETE FROM web_tiempos_archivo WHERE idcarrera='$id'");
	$sql_mangas = $mysqli->query("SELECT * FROM mangas WHERE idcarreras = '$id'");
	if ($sql_mangas->num_rows > 0) {
		echo "<h4>MANGAS DE ESTA CARRERA</h4>";
		while ($row = $sql_mangas->fetch_array()) {
			$idmanga = $row['idmangas'];
			$descripcion = $row['descripcion'];
			$longitud = $row['longitud'];
			$tipo_manga = $row['tipo_manga'];
			$orden = $row['orden'];
			$estado = $row['estado'];
			$hora = $row['hora_teorica_salida_primero'];
			$sql_insertar_mangas = $mysqli2->query("SELECT id FROM web_manga_archivo WHERE id = '$idmanga'");
			if ($sql_insertar_mangas->num_rows > 0) {
				//YA EXISTE ESTA MANGA
				echo "<h2>ESTE REGISTRO DE MANGA YA EXISTE</h2>";
			} else {
				$sql_insertar_mangas = $mysqli2->query("INSERT INTO web_manga_archivo (id,id_usuario,idcarrera,descripcion,numero,longitud,tipo,hora_salida,estado,decimales) 
			VALUES ('$idmanga','1','$id','$descripcion','$orden','$longitud','$tipo_manga','$hora','$estado','3')");
			}
			echo "<p>MANGA: " . $descripcion . " LONGITUD: " . $longitud . "</p>";
			echo "<p>REGISTRO DE TIEMPOS DE ESTA MANGA:</p>";
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			///////////////////////////BUSCAMOS EL TIEMPO POR MANGA Y EVITAMOS ERROR DE INSCRITOS Q APARECEN ARRASTRADOS DE OTRAS ID QUE NO SE SABEN Q SON///////////////
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$sql_tiempos = $mysqli->query("SELECT t.idinscritos,t.idtiempos,t.idmangas,t.tiempo_salida,t.tiempo_llegada,t.tiempo_invertido,t.penalizaciones
 		FROM tiempos t WHERE t.idmangas = '$idmanga'");
			if ($sql_tiempos->num_rows > 0) {
				//echo "<h4>TIEMPOS ENCONTRADOS EN ESTA CARRERA</h4>";
				echo "<table border='1'><tr><th>ID_TIEMPO</th><th>ID_MANGA</th><th>ID_INSCRITO</th><th>H_SAL</th><th>H_LLEG</th><th>INVERTIDO</th><th>PENA.</th><th>TIPO_M</th><th colspan='2'>ORDEN</th></tr>";
				while ($row = $sql_tiempos->fetch_array()) {
					$idtiempo = $row['idtiempos'];
					$idmanga = $row['idmangas'];
					////////BUSCAR TIPO y NUMERO DE MANGA PARA DESPUES PODER HACER LA SUMA CLAS.FINAL SEGUN TIPO MANGA
					//////////////////////////////////////////////////////////////////////////////////////////////////
					$idinscrito = $row['idinscritos'];
					$h_s = $row['tiempo_salida'];
					$h_l = $row['tiempo_llegada'];
					$t_t = $row['tiempo_invertido'];
					$penalizacion = $row['penalizaciones'];
					if ($penalizacion > 0) {
						$saber_motivo = $mysqli->query("SELECT descripcion FROM penalizaciones WHERE idinscritos='$idinscrito' AND idmangas='$idmanga'")->fetch_array();
						$motivo = $saber_motivo['descripcion'];
						$motivo = str_replace("'", " min", $motivo);
					} else {
						$motivo = '';
					}
					if ($h_l > 0) {
						echo "<tr><td>" . $idtiempo . "</td><td>" . $idmanga . "</td><td>" . $idinscrito . "</td><td>" . milisegundos_a_tiempo($h_s) . "</td><td>" . milisegundos_a_tiempo($h_l) . "</td>";
						echo "<td>" . milisegundos_a_tiempo($t_t) . "</td><td>" . $penalizacion . "<br>" . $motivo . "</td><td>" . $tipo_manga . "</td><td>" . $orden . "</td>";
						$mysqli2->query("INSERT INTO web_tiempos_archivo (idtiempos,idmanga,h_s,h_l,idcarrera,t_t,penalizacion,idinscrito,num_manga,tipo_manga,idcampeonato,motivo)
					VALUES('$idtiempo','$idmanga','$h_s','$h_l','$id','$t_t','$penalizacion','$idinscrito','$orden','$tipo_manga','','$motivo')");
						echo "<td>REGISTRO OK</td>";
						echo "</tr>";
					}
				}
				echo "</table>";
			}
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			////                                       ABANDONOS                                    /////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$sql_abandonos = $mysqli->query("SELECT * FROM abandonos WHERE idmangas = '$idmanga'");
			if ($sql_abandonos->num_rows > 0) {
				echo "<h2>ABANDONOS DE LA CARRERA</h2>";
				echo "<table border='1'><thead><tr><th>ID_MANGA</td><td>ID_INSCRITO</td><td>RAZON</td></tr>";
				while ($row = $sql_abandonos->fetch_array()) {
					$idmanga = $row['idmangas'];
					$idinscrito = $row['idinscritos'];
					$motivo = $row['razon_abandono'];
					echo "<tr><td>" . $idmanga . "</td><td>" . $idinscrito . "</td><td>" . $motivo . "</td></tr>";
					$comprobar_tabla = $mysqli2->query("SELECT id FROM web_abandonos_archivo WHERE  idinscrito='$idinscrito' AND idmanga= '$idmanga'");
					if ($comprobar_tabla->num_rows == 0) {
						$mysqli2->query("INSERT INTO web_abandonos_archivo (id,idinscrito,idmanga,idcarrera,motivo) VALUES
				('','$idinscrito','$idmanga','$id','$motivo')");
					}
				}
			} else {
				echo "NO EXISTEN ABANDONOS";
			}
			//                FIN DE ABANDONOS                                //
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			////                                     FIN DE TIEMPOS                                                                   ////////
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		}
	} else
		echo "NO EXISTEN MANGAS EN ESTA CARRERA";
	//////////////////////////////////////////////////////////////
	/////   3- LISTA DE INSCRITOS DE  ESTA CARRERA       /////////
	//////////////////////////////////////////////////////////////

	$sql_incritos = $mysqli->query("SELECT * FROM inscritos WHERE idcarreras = '$id'");
	if ($sql_incritos->num_rows > 0) {
		echo "<h4>INSCRITOS A ESTA CARRERA</h4>";
		echo "<table border='1'>";
		echo "<th>ID</th><th>D.</th><th>CONCUR.</th><th>EQUIPO</th><th>VEHICULO</th><th>CC</th><th>EXC.</th><th>AUTO.</th>";
		while ($row = $sql_incritos->fetch_array()) {
			$idinscrito = $row['idinscritos'];
			$dorsal = $row['dorsal'];
			$piloto = $row['piloto'];
			$copiloto = $row['copiloto'];
			$concursante  = $row['concursante'];
			$equipo = $piloto . "<br>" . $copiloto;
			$vehiculo = $row['vehiculo'];
			$cc = $row['cilindrada'];
			$grupo = $row['grupo'];
			$clase = $row['clase'];
			$excluido = $row['excluido'];
			$autorizado = $row['autorizado'];
			echo "<tr><td>" . $idinscrito . "</td><td>" . $dorsal . "</td><td>" . $concursante . "</td><td>" . $equipo . "</td><td>" . $vehiculo . "</td><td>" . $cc . "</td><td>" . $excluido . "</td><td>" . $autorizado . "</td></tr>";
			$sql_insertar_inscritos = $mysqli2->query("SELECT idinscrito FROM web_inscritos_archivo WHERE idinscrito = '$idinsrito'");
			if ($sql_insertar_inscritos->num_rows > 0) {
				//YA EXISTE ESTA MANGA
				echo "ESTE REGISTRO DE INSCRITO YA EXISTE";
			} else {
				$sql_insertar_inscritos = $mysqli2->query("INSERT INTO web_inscritos_archivo
			(idcarrera,idinscrito,concursante,piloto,copiloto,vehiculo,grupo,clase,categoria,dorsal,cc,autorizado,excluido) VALUES 
			('$id','$idinscrito','$concursante','$piloto','$copiloto','$vehiculo','$grupo','$clase','','$dorsal','$cc','$autorizado','$excluido')");
				/*$pp = "INSERT INTO web_inscritos_archivo
			(idcarrera,idinscrito,concursante,piloto,copiloto,vehiculo,grupo,clase,categoria,dorsal,cc,autorizado,excluido) VALUES 
			('$id','$idinscrito','$concursante','$piloto','$copiloto','$vehiculo','$grupo','$clase','','$dorsal','$cc','$autorizado','$excluido')";
			echo $pp;*/
			}
		}
		echo "</table>";
	}
//}//WHILE DE TODAS LAS CARRERAS



//////////////////////////////////////////////////////////////
/////   3- TIEMPOS DE TODAS LA MANGAS                /////////
//////////////////////////////////////////////////////////////
/*ESTO LO DEJO AQUI PERO TIENE PROBLEMA Q ARRASTRA LOS ID QUE NO SABEMOS PORQUE ESTAN Y DEVUELVE TODOS LOS TIEMPOS DE CADA MANGA*/ 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*$sql_tiempos = $mysqli->query("SELECT t.idinscritos,t.idtiempos,t.idmangas,t.tiempo_salida,t.tiempo_llegada,t.tiempo_invertido,t.penalizaciones,m.tipo_manga,m.orden
 FROM mangas m INNER JOIN tiempos t ON m.idcarreras=t.idcarreras 
 WHERE t.idcarreras = '$id' AND t.idinscritos='47'");
if ($sql_tiempos->num_rows > 0) {
	echo "<h4>TIEMPOS ENCONTRADOS EN ESTA CARRERA</h4>";
	echo "<table border='1'><tr><th>ID_TIEMPO</th><th>ID_MANGA</th><th>ID_INSCRITO</th><th>H_SAL</th><th>H_LLEG</th><th>INVERTIDO</th><th>PENA.</th><th>TIPO_M</th><th colspan='2'>ORDEN</th></tr>";
	while ($row = $sql_tiempos->fetch_array()) {
		$idtiempo = $row['idtiempos'];
		$idmanga = $row['idmangas'];
		////////BUSCAR TIPO y NUMERO DE MANGA PARA DESPUES PODER HACER LA SUMA CLAS.FINAL SEGUN TIPO MANGA
		//////////////////////////////////////////////////////////////////////////////////////////////////
		$idinscrito = $row['idinscritos'];
		$h_s = $row['tiempo_salida'];
		$h_l = $row['tiempo_llegada'];
		$t_t = $row['tiempo_invertido'];
		$penalizacion = $row['penalizaciones'];
		$orden = $row['orden'];
		$tipo = $row['tipo_manga'];
		echo "<tr><td>" . $idtiempo . "</td><td>" . $idmanga . "</td><td>" . $idinscrito . "</td><td>" . milisegundos_a_tiempo($h_s) . "</td><td>" . milisegundos_a_tiempo($h_l) . "</td>";
		echo "<td>" . milisegundos_a_tiempo($t_t) . "</td><td>" . $penalizacion . "</td><td>" . $tipo . "</td><td>" . $orden . "</td>";
		$juanito = "INSERT INTO web_tiempos_archivo (idtiempos,idmanga,h_s,h_l,idcarrera,t_t,penalizacion,idinscrito,num_manga,tipo_manga,idcampeonato)
			VALUES('$idtiempo','$idmanga','$h_s','$h_l','$id','$t_t','$penalizacion','$idinscrito','$orden','$tipo','')";
		echo $juanito . "<br>";
		if ($mysqli2) {
			echo "<td>REGISTRO OK</td>";
		} else {
			echo "<td>KO</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
}*/
//////////////////////////////////////////////////////////////////////////////