<?php
//TIPO 3, SUMa DE TODAS LAS MANGA OFICIALES
include("conexion.php");
include("includes/funcionesTiempos.php");
include("escudos.php");
	if(isset($_GET["copa"]))
				$copa = $_GET["copa"];
			else
				$copa = '0';
	if(isset($_GET["campeonato"]))
				$campeonato = $_GET["campeonato"];
			else
				$campeonato = '0';
	if(isset($_GET["grupo"]))
				$grup_o = $_GET["grupo"];
			else
				$grup_o = '0';
	$numMangas = mysql_query("SELECT m.id as idmanga FROM abc_57os_ca_carrera c
	INNER JOIN abc_57os_ca_etapa e ON c.id=e.id_ca_carrera
	INNER JOIN abc_57os_ca_seccion s ON e.id=s.id_ca_etapa
	INNER JOIN abc_57os_ca_manga m ON s.id=m.id_ca_seccion
	WHERE c.id='$idCarrera' AND m.tipo=1");  //mangas de tipo oficial tipo=1
	if(mysql_num_rows($numMangas)==0)
		echo "Aun no se ha publicado la Clasificaci&oacute;n Final";
	else{
		$id_primera_manga = @mysql_result($numMangas, 0, "idmanga");
		$maxMangas = mysql_num_rows($numMangas);
		}
	//echo "NUM: ".$maxMangas."MANGA1: ".$id_primera_manga;
$campeonatos_carrera = mysql_query("SELECT * FROM abc_57os_ca_campeonato WHERE id_ca_carrera='$idCarrera'");
	while($mifila=mysql_fetch_array($campeonatos_carrera))
		{
		$nom = strtoupper($mifila['nombre']);
		$id_campeonato = $mifila['id'];
	if($copa=='0')
		{
		if($grup_o=='0')
			{
			$sql = "SELECT com.id AS idconcursante, m.tipo AS tipo_manga,m.numero AS num_manga,com.dorsal,pi.nombre AS piloto_nombre,id_ca_copiloto_segundo AS copi2,
			con.nombre AS competidor,veh.categoria AS categoria,veh.agrupacion AS agrupacion,con.nacionalidad AS con_nac,
			veh.grupo AS grupo,veh.clase AS clase,veh.marca AS marca,veh.modelo As modelo,pi.nacionalidad AS pi_nac,com.id AS idcompetidor
			FROM abc_57os_ca_carrera car
			INNER JOIN abc_57os_ca_competidor com ON car.id=com.id_ca_carrera
			INNER JOIN abc_57os_ca_etapa e ON e.id_ca_carrera=car.id
			INNER JOIN abc_57os_ca_seccion s ON s.id_ca_etapa=e.id
			INNER JOIN abc_57os_ca_manga m ON m.id_ca_seccion=s.id
			INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto
			INNER JOIN abc_57os_ca_concursante con ON con.id=com.id_ca_concursante
			INNER JOIN abc_57os_ca_vehiculo veh ON veh.id=com.id_ca_vehiculo
			INNER JOIN abc_57os_ca_campeonato_competidor ccm ON ccm.id_ca_competidor=com.id
			WHERE car.id='$idCarrera' AND com.autorizado=1 AND ccm.id_ca_campeonato='$id_campeonato' GROUP BY dorsal";
			}
		else{
			$sql = "SELECT com.id AS idconcursante, m.tipo AS tipo_manga,m.numero AS num_manga,com.dorsal,pi.nombre AS piloto_nombre,id_ca_copiloto_segundo AS copi2,
			con.nombre AS competidor,veh.categoria AS categoria,veh.agrupacion AS agrupacion,con.nacionalidad AS con_nac,
			veh.grupo AS grupo,veh.clase AS clase,veh.marca AS marca,veh.modelo As modelo,pi.nacionalidad AS pi_nac,com.id AS idcompetidor
			FROM abc_57os_ca_carrera car
			INNER JOIN abc_57os_ca_competidor com ON car.id=com.id_ca_carrera
			INNER JOIN abc_57os_ca_etapa e ON e.id_ca_carrera=car.id
			INNER JOIN abc_57os_ca_seccion s ON s.id_ca_etapa=e.id
			INNER JOIN abc_57os_ca_manga m ON m.id_ca_seccion=s.id
			INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto
			INNER JOIN abc_57os_ca_concursante con ON con.id=com.id_ca_concursante
			INNER JOIN abc_57os_ca_vehiculo veh ON veh.id=com.id_ca_vehiculo
			INNER JOIN abc_57os_ca_campeonato_competidor ccm ON ccm.id_ca_competidor=com.id
			WHERE car.id='$idCarrera' AND com.autorizado=1 AND ccm.id_ca_campeonato='$id_campeonato' AND veh.grupo='$grup_o' GROUP BY dorsal";
			}
		$resultado = mysql_query($sql) or print "No se pudo acceder al contenido de los tiempos online.";
			$res = mysql_num_rows($resultado);
			$no_concursante=0;
			//ÑAPA AUTENTICA PARA EVITAR LOS CONCURSANTES 0
			if($res==0)
				{
				if(empty($clas_e) && empty($grup_o))
				{
				$sql = "SELECT com.id AS idconcursante, m.tipo AS tipo_manga,m.numero AS num_manga,com.dorsal,pi.nombre AS piloto_nombre,
				veh.grupo AS grupo,veh.clase AS clase,veh.marca AS marca,veh.modelo As modelo,pi.nacionalidad AS pi_nac,com.id_ca_copiloto_segundo AS copi2,
				veh.categoria AS categoria,veh.agrupacion AS agrupacion,con.nacionalidad AS con_nac
				FROM abc_57os_ca_carrera car,com.id AS idcompetidor
				INNER JOIN abc_57os_ca_competidor com ON car.id=com.id_ca_carrera
				INNER JOIN abc_57os_ca_etapa e ON e.id_ca_carrera=car.id
				INNER JOIN abc_57os_ca_seccion s ON s.id_ca_etapa=e.id
				INNER JOIN abc_57os_ca_manga m ON m.id_ca_seccion=s.id
				INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto
				INNER JOIN abc_57os_ca_vehiculo veh ON veh.id=com.id_ca_vehiculo
				INNER JOIN abc_57os_ca_campeonato_competidor ccm ON ccm.id_ca_competidor=com.id
				WHERE car.id='$idCarrera' AND com.autorizado=1 AND ccm.id_ca_campeonato='$id_campeonato' GROUP BY dorsal";
				$resultado = mysql_query($sql) or print "No se pudo acceder al contenido de los tiempos online.";
				}
				else{
					if($grup_o==0)
						{
						$sql = "SELECT com.id AS idconcursante, m.tipo AS tipo_manga,m.numero AS num_manga,com.dorsal,pi.nombre AS piloto_nombre,
						veh.grupo AS grupo,veh.clase AS clase,veh.marca AS marca,veh.modelo As modelo,pi.nacionalidad AS pi_nac,com.id_ca_copiloto_segundo AS copi2,
						veh.categoria AS categoria,veh.agrupacion AS agrupacion,com.id AS idcompetidor,con.nacionalidad AS con_nac
						FROM abc_57os_ca_carrera car
						INNER JOIN abc_57os_ca_competidor com ON car.id=com.id_ca_carrera
						INNER JOIN abc_57os_ca_etapa e ON e.id_ca_carrera=car.id
						INNER JOIN abc_57os_ca_seccion s ON s.id_ca_etapa=e.id
						INNER JOIN abc_57os_ca_manga m ON m.id_ca_seccion=s.id
						INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto
						INNER JOIN abc_57os_ca_vehiculo veh ON veh.id=com.id_ca_vehiculo
						INNER JOIN abc_57os_ca_campeonato_competidor ccm ON ccm.id_ca_competidor=com.id
						WHERE car.id='$idCarrera' AND com.autorizado=1 AND ccm.id_ca_campeonato='$id_campeonato' AND veh.clase='$clas_e' GROUP BY dorsal";
						$resultado = mysql_query($sql) or print "No se pudo acceder al contenido de los tiempos online.";
						}
					else{
						$sql = "SELECT com.id AS idconcursante, m.tipo AS tipo_manga,m.numero AS num_manga,com.dorsal,pi.nombre AS piloto_nombre,
						veh.grupo AS grupo,veh.clase AS clase,veh.marca AS marca,veh.modelo As modelo,pi.nacionalidad AS pi_nac,
						com.id_ca_copiloto_segundo AS copi2,con.nacionalidad AS con_nac,
						veh.categoria AS categoria,veh.agrupacion AS agrupacion,com.id AS idcompetidor
						FROM abc_57os_ca_carrera car
						INNER JOIN abc_57os_ca_competidor com ON car.id=com.id_ca_carrera
						INNER JOIN abc_57os_ca_etapa e ON e.id_ca_carrera=car.id
						INNER JOIN abc_57os_ca_seccion s ON s.id_ca_etapa=e.id
						INNER JOIN abc_57os_ca_manga m ON m.id_ca_seccion=s.id
						INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto
						INNER JOIN abc_57os_ca_vehiculo veh ON veh.id=com.id_ca_vehiculo
						INNER JOIN abc_57os_ca_campeonato_competidor ccm ON ccm.id_ca_competidor=com.id
						WHERE car.id='$idCarrera' AND com.autorizado=1 AND ccm.id_ca_campeonato='$id_campeonato' AND veh.grupo='$grup_o' GROUP BY dorsal";
						$resultado = mysql_query($sql) or print "No se pudo acceder al contenido de los tiempos online.";
						}
					}
				}
		}
	else{ //COPAS!
		$sql = "SELECT com.dorsal AS dorsal,veh.marca AS marca,veh.grupo AS grupo,veh.clase AS clase,veh.marca AS marca,veh.modelo As modelo,
		pi.nombre AS piloto_nombre,copa.id AS id_copa,copa.descripcion,pi.nacionalidad AS pi_nac,con.nombre AS competidor,con.nacionalidad AS con_nac,
		cocom.id_ca_competidor AS idmanga,coman.id_ca_manga,veh.categoria AS categoria,veh.agrupacion AS agrupacion,com.id AS idcompetidor 
		FROM abc_57os_ca_copa copa 
		INNER JOIN abc_57os_ca_copa_competidor cocom ON copa.id=cocom.id_ca_copa 
		INNER JOIN abc_57os_ca_copa_manga coman ON coman.id_ca_copa=copa.id 
		INNER JOIN abc_57os_ca_competidor com ON com.id = cocom.id_ca_competidor
		INNER JOIN abc_57os_ca_concursante con ON con.id=com.id_ca_concursante		
		INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto 
		INNER JOIN abc_57os_ca_vehiculo veh ON veh.id=com.id_ca_vehiculo 
		INNER JOIN abc_57os_ca_campeonato_competidor cacom ON cacom.id_ca_competidor=com.id 
		WHERE copa.id = '$copa' AND com.id_ca_carrera='$idCarrera' AND cacom.id_ca_campeonato='$id_campeonato' GROUP BY com.dorsal";
			
	}
$resultado = mysql_query($sql) or print "No se pudo acceder al contenido de los tiempos - online.";
$nom = str_replace('ESPAÃ‘A', 'ESPAÑA', $nom);
$afec = mysql_num_rows($resultado);
if($afec!=0)
	echo "<br><p class='negrita centro fu1'>".$nom."</p><br>";
if(mysql_num_rows($resultado)>0)
		{
		while($fila=mysql_fetch_array($resultado))
			{
			$dorsal = $fila['dorsal'];
			$competidor = $fila['competidor'];
			$piloto = $fila['piloto_nombre'];
			$copi2 = $fila['copi2'];
				if($copi2!=0 || $copi2!='0' || !empty($copi2)){
			$sql_copi2 = mysql_query("SELECT copi.nombre AS copiloto,copi.nacionalidad AS nacionalidad FROM abc_57os_ca_copiloto copi 
			INNER JOIN abc_57os_ca_competidor com ON copi.id=com.id_ca_copiloto_segundo
			WHERE com.id_ca_carrera = '$idCarrera' AND com.id_ca_copiloto_segundo = '$copi2'");
				if(mysql_num_rows($sql_copi2)>0)
					{
					$copi2 = @mysql_result($sql_copi2, 0, "copiloto");
					$copi2_nac = bandera(@mysql_result($sql_copi2, 0, "nacionalidad"));
					}
				}
				else{
					$copi2 ='';
					$copi2_nac = '';
					}
			$sql_copi = mysql_query("SELECT copi.nombre AS copiloto,copi.nacionalidad AS nacionalidad FROM abc_57os_ca_copiloto copi 
			INNER JOIN abc_57os_ca_competidor com ON copi.id=com.id_ca_copiloto
			WHERE com.id_ca_carrera = '$idCarrera' AND com.dorsal = '$dorsal'");
				if(mysql_num_rows($sql_copi)>0)
					{
					$copiloto = @mysql_result($sql_copi, 0, "copiloto");
					$copi_nac = @mysql_result($sql_copi, 0, "nacionalidad");
					$copi_nacs = explode('/',$copi_nac);
					$copi_nac1 = bandera($copi_nacs[0]);
					$copi_nac2 = bandera($copi_nacs[1]);
					}
				else{
					$copiloto ='';
					$copi_nac ='';
					}
			$con_nac = $fila['con_nac'];
			$con_nac = explode("/", $con_nac);
			$con_nac1 = bandera($con_nac[0]);
			$con_nac2 = bandera($con_nac[1]);
			$vehiculo = $fila['marca'];
			$modelo = $fila['modelo'];
			$categoria = $fila['categoria'];
			$agrupacion = $fila['agrupacion'];
			$idcomp = $fila['idcompetidor'];
			$pi_nac = $fila['pi_nac'];
			$pi_nacs = explode('/',$pi_nac);
			$pi_nac1 = bandera($pi_nacs[0]);
			$pi_nac2 = bandera($pi_nacs[1]);
			$num_manga = $fila['num_manga'];
			$tipo_manga = $fila['tipo_manga'];
			$idconcursante = $fila['idconcursante'];
				$mimanga=$id_primera_manga+$maxMangas;
				$ta_s=0;
				$ta_l=0;
				$t_pa=0;
				$cont=0;
				$aban=0;
					while($mimanga != $id_primera_manga-1)
						{
						//BUSCO PRIMERO EN LAS MANGAS Y ACUMULO
						$acum = mysql_query("SELECT ch.orden AS orden,t.tiempo,m.descripcion AS des FROM abc_57os_ca_tiempo t 
						INNER JOIN abc_57os_ca_manga_control_horario ch ON ch.id=t.id_ca_manga_control_horario 
						INNER JOIN abc_57os_ca_manga m ON ch.id_ca_manga=m.id 
						WHERE t.dorsal='$dorsal' AND t.id_ca_manga='$mimanga' AND m.tipo=1 AND t.id_ca_carrera='$idCarrera'");
						$abandono = mysql_query("SELECT id FROM abc_57os_ca_abandono WHERE id_ca_manga='$mimanga' AND dorsal='$dorsal'");
							if(mysql_num_rows($abandono)>0)
								$aban++;
								if($mimanga=='122' AND $id_campeonato=='48'){ //MEGA ÑAPA NUEVA PARA EL ANDALUZ, buscar solucion rapida
								$ta_s += 0;
								$ta_l += 0;
								}
								else{
										if(mysql_num_rows($acum)>=2)//2 TIEMPOS, LLEGADA
										{
											
										while($fil=mysql_fetch_array($acum))
											{
											$orden = $fil['orden'];
											if($orden==0){//ES SALIDA
												$ta_s += tiempo_a_milisegundos($fil['tiempo']);
												}
											if($orden==10){//ES LLEGADA
												$ta_l += tiempo_a_milisegundos($fil['tiempo']);
												}
											//echo "NOMBRE:".$fil['des'];
											}
										//if($ta_s>0 AND $t_al>0)
										$cont++;
										}
								}
				//BUSCO TB LAS PENALIZACIONES HASTA 
						$acum_pen = mysql_query("SELECT tiempo FROM abc_57os_ca_penalizacion WHERE id_ca_manga='$mimanga' AND dorsal='$dorsal'");
							if(mysql_num_rows($acum_pen)>0)//lo recorro por si tiene mas de una penalizacion en la misma MANGA
								{
								$t_pa=0;
									while($rowpa=mysql_fetch_array($acum_pen))
										$t_pa+=$rowpa['tiempo']; //tiempo en segundos
								}
						$mimanga--;						
						}
						
			$c_pen = mysql_query("SELECT tiempo FROM abc_57os_ca_penalizacion WHERE id_ca_manga='$idManga' AND dorsal='$dorsal'");
				if(mysql_num_rows($c_pen)>0)//lo recorro por si tiene mas de una penalizacion en la misma MANGA
					{
					$pen=0;
					while($rowp=mysql_fetch_array($c_pen))
						$pen+=$rowp['tiempo'];
					}
				else
					$pen=0;
				$t_pam = segundos_a_milisegundos($t_pa);
				$tiempo = tiempo_a_milisegundos($t_l)-tiempo_a_milisegundos($t_s)+segundos_a_milisegundos($pen);
				$t_p=segundos_a_milisegundos($pen);
				$tat = $ta_l-$ta_s; //tiempo acumulado en las mangas anteriores, lo sumamos a la actual
				$tat += (tiempo_a_milisegundos($ta_l)-tiempo_a_milisegundos($ta_s)+segundos_a_milisegundos($pen)+$t_pam);
				//echo "D:".$dorsal."M:".$cont."<br><br>";
//PASO A CALCULAR LAS POSICIONES SEGUN TIEMPO LLEGADA
					//	if( ($cont==$maxMangas AND $tat>0) || ($idCarrera='27' AND $aban==0 AND $tat>0)){  //HA COMPETIDO EN TODAS LAS MANGAS y el tiempo es >0
					//MUUUUY IMPORTANTE, FALTA AQUI BUSCAR LAS MANGAS Q NO COMPITEN LOS PILOTOS PERO SI PUNTUAN
						if( ($cont==$maxMangas AND $tat>0)){  //HA COMPETIDO EN TODAS LAS MANGAS y el tiempo es >0
								$ordenar[] = array(
								'piloto' => $piloto, 
								'copiloto' => $copiloto,
								'copiloto2' => $copi2,
								'dorsal'=>$dorsal,
								'vehiculo'=>$vehiculo,
								'modelo'=>$modelo,
								'categoria'=>$categoria,
								'agrupacion'=>$agrupacion,
								'penalizacion'=>$t_p,
								'tipo'=>$tipo,
								'hora'=>$hora,
								'pi_nac1' =>$pi_nac1,
								'pi_nac2' =>$pi_nac2,
								'copi_nac1' =>$copi_nac1,
								'copi_nac2' =>$copi_nac2,
								'con_nac1' =>$con_nac1,
								'con_nac2' =>$con_nac2,
								'idconcursante' =>$idconcursante,
								'idcompetidor' =>$idcomp,
								'acu_hasta' =>$tat,
								'pen_hasta'=>$t_pam+$t_p,
								'competidor' =>$competidor);
								}
			}
		}
	if($afec!=0){?>
	<table border="0" width="100%" id="tab_tem">
				<thead>
				<tr>
					<th width='10%'>Pos</th><th width='10%'>dorsal</th><th width='20%'>Concursante</th><th>Equipo</th><th width='20%' colspan="2">Vehiculo</th><th>-</th>
					<th>Gr</th><th>Cl</th><th>Cat</th><th>Agr</th><th width='10%' class="centro">Anterior<br>Tiempo<br>Primero<br>Penalizacion</th>
				</tr>
				</thead>
					<tbody>
	<?php
	}
	$par=0;
	//echo $maxMangas;
		foreach ($ordenar as $key => $row) {
		$aux[$key] = $row['acu_hasta'];
		}
		array_multisort($aux, SORT_ASC, $ordenar);
		$pos=1;
		foreach ($ordenar as $key => $row) {
			if($par%2==0){
				$classcss="filapar";
				$classcss2="filapar2";
				}
			else{
				$classcss="filaimpar";
				$classcss2="filaimpar2";
				}
				
		//PARA POSICIONES POR GRUPOS AGRUPACIONES ETC ETC
		/*foreach ($ordenar as $key2 => $row2) {
						$aux2[$key2] = $row2['tiempo'];
					}
					array_multisort($aux2, SORT_ASC, $ordenar);
						$total_agrupacion=0;
						$total_categoria=0;
						$pos_en_su_categoria=1;
						$pos_en_su_agrupacion=1;*/
				$acu_hasta=milisegundos_a_tiempo($row['acu_hasta']);
						if(strlen($acu_hasta)==9)
							$acu_hasta = "00:".$acu_hasta;
				if($pos==1){ //EL MEJOR TIEMPO......SIN DUDA ES EL PRIMErOO ;-)
					$mejor_tiempo_tramo = $acu_hasta;
					$tiempo_anterior = $acu_hasta;
						}
			$dif_primero = milisegundos_a_tiempo(tiempo_a_milisegundos($acu_hasta) - tiempo_a_milisegundos($mejor_tiempo_tramo));
			$dif_anterior = milisegundos_a_tiempo(tiempo_a_milisegundos($acu_hasta) - tiempo_a_milisegundos($tiempo_anterior));

				/*	foreach ($ordenar as $key2 => $row2) {
						
							if($row2['categoria']==$row['categoria']) //PERTENECE A ESTA CATEGORIA
								{
								$total_categoria++; //Aqui calculo por calcular el total que pertenecen a este grupo
								if($row2['dorsal']==$row['dorsal']) // COMPARO SU DORSAL PARA SABER QUIEN POLLAS ES
									$posicion_categoria_dorsal = $pos_en_su_categoria;
								$pos_en_su_categoria++;
								}
							if($row2['agrupacion']==$row['agrupacion']) //PERTENECE A ESTA AGRUPACION
								{
								$total_agrupacion++; //Aqui calculo por calcular el total que pertenecen a esta CLAsE
								if($row2['dorsal']==$row['dorsal']) // COMPARO SU DORSAL PARA SABER QUIEN POLLAS ES
									$posicion_agrupacion_dorsal = $pos_en_su_agrupacion;
								$pos_en_su_agrupacion++;
								}
						
					}*/
					
		//--------------------------------------------------------------------FIN DE POLLaRDEOS_----------------------------
			echo "<tr class='".$classcss."'><td class='pos negrita'>".$pos."</td><td class='dor'>".$row['dorsal']."</td>
			<td class='com'><img class='banderas' src='http://codea.es/coda2019/".$row['con_nac1']."'>".$row['competidor']."</td>";
		if($copiloto!=''){
			if($row['copiloto2']!='' || $row['copiloto2']!=0)
				echo"<td class='con'><img class='banderas' src='http://codea.es/coda2019/".$row['pi_nac1']."'>".acortar_nombre($row['piloto'])."<br><img class='banderas' src='http://codea.es/coda2019/".$co_nac."'>".acortar_nombre($row['copiloto'])."<br><img class='banderas' src='http://codea.es/coda2019/".$row['co2_nac']."'>".acortar_nombre($row['copiloto2'])."</td>";
			else
				echo '<td ><p><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac1'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac2'].'">'.acortar_nombre($row['piloto']).'</p><p><img class="banderas" src="http://codea.es/coda2019/'.$row['copi_nac1'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['copi_nac2'].'">'.acortar_nombre($row['copiloto']).'</p></td>';
			}
		else
			echo "<td class='con'><img class='banderas' src='http://codea.es/coda2019/".$row['pi_nac1']."'>".acortar_nombre($row['piloto'])."<br></td>";
	echo "<td class='cla'>".escudo($row['vehiculo'])."</td>
	<td><span class='veh'>".$row['vehiculo']." ".$row['modelo']."</span></td>";
	
	$idcompetidor = $row['idcompetidor'];
				$con_campeonato = "SELECT mo.nombre AS region_campeonato,mo.slug AS slug FROM abc_57os_ca_campeonato_competidor caco
				INNER JOIN abc_57os_ca_campeonato ca ON caco.id_ca_campeonato = ca.id
				INNER JOIN abc_57os_ca_modalidad mo ON mo.id=ca.id_ca_modalidad
				WHERE caco.id_ca_competidor = '$idcompetidor' GROUP BY mo.nombre";
				$res_con_campeonato = mysql_query($con_campeonato);
	echo "<td class='centro'>";
					while($rows=mysql_fetch_array($res_con_campeonato))
					{
					$slug = $rows['slug'];
					$region = $rows['region_campeonato'];
					$search  = array('Ã±', 'Ã­');
					$replace = array('Ñ', 'Í');
					$region = str_replace($search, $replace, $region);
					echo "<p class='mini1 nomargen ".$slug." negrita'>".strtoupper($region)."</p>";
					//echo "<p class='mini1 nomargen espana negrita'>ESPAÑA</p>";
					//echo "<p class='mini1 nomargen europa negrita'>EUROPA</p>";
					}
			echo "</td><td class='".$classcss2." centro'>";
	$res_con_campeonato = mysql_query($con_campeonato);
					while($rows=mysql_fetch_array($res_con_campeonato))
					{
					$slug = $rows['slug'];
						$con_grupo = mysql_query("SELECT gr.$slug FROM abc_57os_ca_competidor com
								INNER JOIN abc_57os_ca_vehiculo ve ON ve.id=com.id_ca_vehiculo
								INNER JOIN abc_57os_ca_grupo gr ON gr.id=ve.id_ca_grupo WHERE com.id='$idcompetidor'");
					$grupo = @mysql_result($con_grupo, 0, $slug);
					echo "<p class='mini1 nomargen ".$slug." negrita'>".$grupo."</p>";
					}
			echo "</td><td class='centro'>";
	$res_con_campeonato = mysql_query($con_campeonato);
					while($rows=mysql_fetch_array($res_con_campeonato))
					{
					$slug = $rows['slug'];
						$con_clase = mysql_query("SELECT cl.$slug FROM abc_57os_ca_competidor com
								INNER JOIN abc_57os_ca_vehiculo ve ON ve.id=com.id_ca_vehiculo
								INNER JOIN abc_57os_ca_clase cl ON cl.id=ve.id_ca_clase WHERE com.id='$idcompetidor'");
					$clase = @mysql_result($con_clase, 0, $slug);
					echo "<p class='mini1 nomargen ".$slug." negrita'>".$clase."</p>";
					}
			echo "</td><td  class='".$classcss2." centro'>";
	$res_con_campeonato = mysql_query($con_campeonato);
					while($rows=mysql_fetch_array($res_con_campeonato))
					{
					echo "<p class='mini1 nomargen ".$slug." negrita'>".$row['categoria']."</p>";
					}
			echo "</td><td class='centro'>";
			$res_con_campeonato = mysql_query($con_campeonato);
					while($rows=mysql_fetch_array($res_con_campeonato))
					{
					echo "<p class='mini1 nomargen andalucia negrita'>".$row['agrupacion']."</p>";
					}
					//echo "<td class='centro'>".$grupo."</td><td class='centro'>".$clase."</td><td class='centro'>".$cat."</td><td class='centro'>".$agr."</td>";
			echo "</td>";
	if($pos!=1)
		echo '<td class="tie centro"><p class="anterior cursiva nomargen">+'.$dif_primero.'</p><p class="negrita nomargen">'.$acu_hasta.'</p><p class="cursiva nomargen">+'.$dif_anterior.'</p>';
	else
		echo "<td class='centro'><p>".$acu_hasta."</p>";
	if($row['pen_hasta']!=0)
		echo '<p><span class="penalizaciones">'.milisegundos_a_tiempo($row['pen_hasta']).'</span></p>';
	echo "</td></tr>";
			$mejor_tiempo_tramo = $acu_hasta;
			$pos++;
			$par++;
		}
	if($afec!=0){		
	?>
	</tbody>
		</table>
			<?php
		}
	unset($ordenar);
	unset($aux);
	}
	?>
<br>
<br>
<br>
<br>


