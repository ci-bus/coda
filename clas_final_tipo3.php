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
			com.srally_esp AS ss,
			veh.grupo AS grupo,veh.clase AS clase,veh.marca AS marca,veh.modelo As modelo,pi.nacionalidad AS pi_nac
			FROM abc_57os_ca_carrera car
			INNER JOIN abc_57os_ca_competidor com ON car.id=com.id_ca_carrera
			INNER JOIN abc_57os_ca_etapa e ON e.id_ca_carrera=car.id
			INNER JOIN abc_57os_ca_seccion s ON s.id_ca_etapa=e.id
			INNER JOIN abc_57os_ca_manga m ON m.id_ca_seccion=s.id
			INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto
			INNER JOIN abc_57os_ca_vehiculo veh ON veh.id=com.id_ca_vehiculo
			INNER JOIN abc_57os_ca_campeonato_competidor ccm ON ccm.id_ca_competidor=com.id
			WHERE car.id='$idCarrera' AND com.autorizado=1 AND ccm.id_ca_campeonato='$id_campeonato' GROUP BY dorsal";
			}
		else{
			$sql = "SELECT com.id AS idconcursante, m.tipo AS tipo_manga,m.numero AS num_manga,com.dorsal,pi.nombre AS piloto_nombre,id_ca_copiloto_segundo AS copi2,
			veh.grupo AS grupo,veh.clase AS clase,veh.marca AS marca,veh.modelo As modelo,pi.nacionalidad AS pi_nac
			FROM abc_57os_ca_carrera car
			INNER JOIN abc_57os_ca_competidor com ON car.id=com.id_ca_carrera
			INNER JOIN abc_57os_ca_etapa e ON e.id_ca_carrera=car.id
			INNER JOIN abc_57os_ca_seccion s ON s.id_ca_etapa=e.id
			INNER JOIN abc_57os_ca_manga m ON m.id_ca_seccion=s.id
			INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto
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
				FROM abc_57os_ca_carrera car
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
						veh.grupo AS grupo,veh.clase AS clase,veh.marca AS marca,veh.modelo As modelo,pi.nacionalidad AS pi_nac,com.id_ca_copiloto_segundo AS copi2,
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
		$sql = "SELECT com.dorsal,cc.id_ca_campeonato,ve.marca,ve.modelo,pi.nombre AS piloto_nombre,com.id,ve.grupo,ve.clase,pi.nacionalidad AS pi_nac,
		con.nombre AS competidor,copi.nombre AS copiloto_nombre,copi.nacionalidad AS copi_nac,com.id_ca_copiloto_segundo AS copi2
			FROM abc_57os_ca_competidor com 
			INNER JOIN abc_57os_ca_copa_competidor cocom ON com.id=cocom.id_ca_competidor 
			INNER JOIN abc_57os_ca_piloto pi ON com.id_ca_piloto = pi.id 
			INNER JOIN abc_57os_ca_copiloto copi ON com.id_ca_copiloto = copi.id 
			INNER JOIN abc_57os_ca_vehiculo ve ON ve.id=com.id_ca_vehiculo 
			INNER JOIN abc_57os_ca_campeonato_competidor cc on cc.id_ca_competidor=com.id
			INNER JOIN abc_57os_ca_concursante con ON con.id=com.id_ca_concursante
			WHERE com.id_ca_carrera = '$idCarrera' AND cocom.id_ca_copa='$copa' AND cc.id_ca_campeonato='$id_campeonato'";
	}
//$resultado = mysql_query($sql) or print "No se pudo acceder al contenido de los tiempos online.";
echo "<br><p class='negrita centro fu1'>".$nom."</p><br>";
if(mysql_num_rows($resultado)>0)
		{
		while($fila=mysql_fetch_array($resultado))
			{
			$ss = $fila['ss'];
			$dorsal = $fila['dorsal'];
			//$competidor = $fila['competidor'];
			$piloto = $fila['piloto_nombre'];
			
			$sqlc = mysql_query("SELECT con.nombre AS competidor FROM abc_57os_ca_competidor com INNER JOIN abc_57os_ca_concursante con 
			ON con.id=com.id_ca_concursante WHERE com.dorsal='$dorsal' AND com.id_ca_carrera='$idCarrera'");
			if(mysql_num_rows($sqlc)>0)
					$competidor = @mysql_result($sqlc, 0, "competidor");
			else
					$competidor=0;
				
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
					$co_nac = bandera(@mysql_result($sql_copi, 0, "nacionalidad"));
					}
				else{
					$copiloto ='';
					$copi_nac = '';
					}
			$vehiculo = $fila['marca'];
			$modelo = $fila['modelo'];
			$grupo = $fila['grupo'];
			$clase = $fila['clase'];
			$idcomp = $fila['idcompetidor'];
			$pi_nac = bandera($fila['pi_nac']);
			$num_manga = $fila['num_manga'];
			$tipo_manga = $fila['tipo_manga'];
			$idconcursante = $fila['idconcursante'];
				$mimanga=$id_primera_manga+$maxMangas;
				$ta_s=0;
				$ta_l=0;
				$t_pa=0;
				$cont=0;
			$baban = mysql_query("SELECT c.dorsal FROM abc_57os_ca_abandono a INNER JOIN abc_57os_ca_competidor c ON c.id=a.id_ca_competidor 
					WHERE a.id_ca_carrera='$idCarrera' AND c.dorsal='$dorsal' ORDER BY c.dorsal");
					if(mysql_num_rows($baban)>=1)
						$babandono = 1;
					else
						$babandono = 0;
					while($mimanga != $id_primera_manga-1)
						{
						//BUSCO PRIMERO EN LAS MANGAS Y ACUMULO
						$acum = mysql_query("SELECT ch.orden AS orden,t.tiempo,m.descripcion AS des FROM abc_57os_ca_tiempo t 
						INNER JOIN abc_57os_ca_manga_control_horario ch ON ch.id=t.id_ca_manga_control_horario 
						INNER JOIN abc_57os_ca_manga m ON ch.id_ca_manga=m.id 
						WHERE t.dorsal='$dorsal' AND t.id_ca_manga='$mimanga' AND m.tipo!=0 AND t.id_ca_carrera='$idCarrera'");
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
				$tat += (tiempo_a_milisegundos($t_l)-tiempo_a_milisegundos($t_s)+segundos_a_milisegundos($pen)+$t_pam);
				//echo "D:".$dorsal."M:".$cont."<br><br>";
//PASO A CALCULAR LAS POSICIONES SEGUN TIEMPO LLEGADA
						if(($cont==$maxMangas AND $tat>0 AND $babandono==0) || ($id_campeonato='36' AND $tat>0 AND $babandono==0)){  //HA COMPETIDO EN TODAS LAS MANGAS y el tiempo es >0
								$ordenar[] = array(
								'piloto' => $piloto, 
								'ss' => $ss, 
								'copiloto' => $copiloto,
								'copiloto2' => $copi2,
								'dorsal'=>$dorsal,
								'vehiculo'=>$vehiculo,
								'modelo'=>$modelo,
								'grupo'=>$grupo,
								'clase'=>$clase,
								'penalizacion'=>$t_p,
								'tipo'=>$tipo,
								'hora'=>$hora,
								'pi_nac' =>$pi_nac,
								'co_nac' =>$co_nac,
								'co2_nac' =>$copi2_nac,
								'idconcursante' =>$idconcursante,
								'acu_hasta' =>milisegundos_a_tiempo($tat),
								'pen_hasta'=>$t_pam+$t_p,
								'competidor' =>$competidor);
								}
			}
		}
	?>
	<table border="0" width="100%" id="tab_tem">
				<thead>
				<tr>
	<?php
		if($competidor=='0')
			echo "<th width='10%'>Pos</th><th width='10%'>dorsal</th><th>Equipo</th><th width='20%' colspan='2'>Vehiculo<br>Grupo/Clase</th><th width='10%'><p class='anterior centro'>Anterior</p><p class='tie centro'>Tiempo</p><p class='anterior cursiva centro'>Primero</p><p class='penalizaciones centro'>Penalizacion</th>";
		else	
			echo "<th width='10%'>Pos</th><th width='10%'>dorsal</th><th width='30%'>Concursante</th><th>Equipo</th><th width='20%' colspan='2'>Vehiculo<br>Grupo/Clase</th><th width='10%'><p class='anterior centro'>Anterior</p><p class='tie nomargen centro'>Tiempo</p><p class='anterior cursiva centro'>Primero</p><p class='penalizaciones centro'>Penalizacion</th>";
	?>
					
				</tr>
				</thead>
					<tbody>
	<?php
	$par=0;
	//echo $maxMangas;
		foreach ($ordenar as $key => $row) {
		$aux[$key] = $row['acu_hasta'];
		}
		array_multisort($aux, SORT_ASC, $ordenar);
		$pos=1;
		foreach ($ordenar as $key => $row) {
			if($par%2==0)
				$classcss="filapar";
			else
				$classcss="filaimpar";
		if($pos==1){ //EL MEJOR TIEMPO......SIN DUDA ES EL PRIMErOO ;-)
					$mejor_tiempo_tramo = $row['acu_hasta'];
					$tiempo_anterior = $row['acu_hasta'];
				}
			if(strlen($mejor_tiempo_acumulado)>9){
				$dif_primero = milisegundos_a_tiempo(tiempo_a_milisegundos($row['acu_hasta'])-tiempo_a_milisegundos($mejor_tiempo_tramo));
				$dif_anterior = milisegundos_a_tiempo(tiempo_a_milisegundos($row['acu_hasta'])-tiempo_a_milisegundos($tiempo_anterior));
				}
			else{
				$dif_primero = milisegundos_a_tiempo(tiempo_a_milisegundos("00:".$row['acu_hasta'])-tiempo_a_milisegundos("00:".$mejor_tiempo_tramo));
				$dif_anterior = milisegundos_a_tiempo(tiempo_a_milisegundos("00:".$row['acu_hasta'])-tiempo_a_milisegundos("00:".$tiempo_anterior));
				}
			echo "<tr class='".$classcss."'><td class='pos negrita'>".$pos."</td><td class='dor'>".$row['dorsal'];
		if($row['ss']!=0)
			echo "<br><span class='negrita'>SR</span></td>";
		else
			echo "</td>";
		if($competidor!='0')	
			echo "<td class='com'>".$row['competidor']."</td>";
		if($copiloto!=''){
			if($row['copiloto2']!='' || $row['copiloto2']!=0)
				echo"<td class='con'><img class='banderas' src='http://codea.es/coda2019/".$pi_nac."'>".acortar_nombre($row['piloto'])."<br><img class='banderas' src='http://codea.es/coda2019/".$co_nac."'>".acortar_nombre($row['copiloto'])."<br><img class='banderas' src='http://codea.es/coda2019/".$row['co2_nac']."'>".acortar_nombre($row['copiloto2'])."</td>";
			else
				echo"<td class='con'><img class='banderas' src='http://codea.es/coda2019/".$pi_nac."'>".acortar_nombre($row['piloto'])."<br><img class='banderas' src='http://codea.es/coda2019/".$co_nac."'>".acortar_nombre($row['copiloto'])."</td>";
			}
		else
			echo "<td class='con'><img class='banderas' src='http://codea.es/coda2019/".$pi_nac."'>".acortar_nombre($row['piloto'])."<br></td>";
	echo "<td class='cla'>".escudo($row['vehiculo'])."</td>
	<td><span class='veh'>".$row['vehiculo']." ".$row['modelo']."</span>
	<br><span class='gru'>".$row['grupo']."(".$posicion_grupo_dorsal.") / ".$row['clase']."(".$posicion_clase_dorsal.")</span></td>";
	if($posicion!=1){
		if($row['pen_hasta']>0)
			echo "<td><p class='anterior cursiva doce centro'>+".$dif_anterior."</p><p class='tie negrita nomargen centro'>".milisegundos_a_tiempo($row['acu_hasta'])."</p><p class='cursiva doce centro'>+".$dif_primero."</p><p class='penalizaciones doce centro'>".milisegundos_a_tiempo($row['pen_hasta'])."</p></td></tr>";
		else
			echo "<td><p class='anterior cursiva nomargen doce centro'>+".$dif_anterior."</p><p class='tie negrita nomargen centro'>".milisegundos_a_tiempo($row['acu_hasta'])."</p><p class='cursiva centro nomargen doce'>+".$dif_primero."</p></td></tr>";
		}
	else
		echo "<td>".$row['acu_hasta']."</td></tr>";
		$pos++;
		$par++;
		$tiempo_anterior=$row['acu_hasta'];
		}
			
	?>
	</tbody>
		</table>
			<?php
	unset($ordenar);
	unset($aux);
	}
	?>
<br>
<br>
<p>ABANDONOS</p>
<table border="0" width="100%" id="tab_tem">
				<thead>
				<tr>
					<th>dorsal</th><th>Concursante</th><th>Equipo</th><th>Vehiculo</th><th>Control</th><th>Raz&oacute;n</th>
				</tr>
				</thead>
					<tbody>
					<?php
					$pen = mysql_query("SELECT veh.marca,veh.modelo,pi.nombre AS piloto,con.nombre AS concursante,c.dorsal,a.motivo 
					FROM abc_57os_ca_abandono a
					INNER JOIN abc_57os_ca_competidor c ON c.id=a.id_ca_competidor 
					INNER JOIN abc_57os_ca_concursante con ON con.id=c.id_ca_concursante 
					INNER JOIN abc_57os_ca_piloto pi ON pi.id=c.id_ca_piloto 
					INNER JOIN abc_57os_ca_vehiculo veh ON veh.id=c.id_ca_vehiculo 
					WHERE a.id_ca_carrera='$idCarrera' ORDER BY c.dorsal");
					if(mysql_num_rows($pen)>0){
						while($fila=mysql_fetch_array($pen)){
							$dorsal = $fila['dorsal'];
							$motivo = $fila['motivo'];
							$concursante = $fila['concursante'];
							$piloto = $fila['piloto'];
							$copiloto = $fila['copiloto'];
							$marca = $fila['marca'];
							$modelo = $fila['modelo'];
							$control = $fila['control'];
							if($par%2==0)
								$classcss="filapar";
							else
								$classcss="filaimpar";
							echo "<tr class='".$classcss."'><td class='dor negrita'>".$dorsal."</td>
							<td class='con'>".$concursante."</td>
							<td>".$piloto."<br>".$copiloto."</td>
							<td>".$marca."<br>".$modelo."</td>
							<td>".$control."</td>
							<td>".$motivo."</td></tr>";
							$par++;
							}
					}//IF
					else
						echo "<tr><td colspan='7'>No existen Abandonos en este tramo</td></tr>";
					?>
					</tbody>
				</table>


