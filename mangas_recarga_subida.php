<?php
//echo $orden;
$tramo_actual=0;
include("conexion.php");
include("escudos.php");
		if(isset($_GET["campeonato"]))
			$campeonato = $_GET["campeonato"];
		else
			$campeonato = '0';
		
		if(isset($_GET["copa"]))
			$copa = $_GET["copa"];
		else
			$copa = '0';
		
	if(isset($_GET["idmanga"]) && isset($_GET["id"]) && isset($_GET["idseccion"]) && isset($_GET['idetapa']))
		{
		$idManga = $_GET["idmanga"];
		$idCarrera = $_GET["id"];
		$idseccion = $_GET["idseccion"];
		$idetapa = $_GET["idetapa"];
		//$DB_PREFIJO = "abc_57os_";
		}
//include("includes/nombresTildes.php");
/*-saber en que numero de tramo estamos*/
$tramo = mysql_query("SELECT m.id AS id_manga,m.descripcion FROM abc_57os_ca_manga m INNER JOIN abc_57os_ca_seccion s ON m.id_ca_seccion=s.id
INNER JOIN abc_57os_ca_etapa e ON s.id_ca_etapa=e.id WHERE e.id_ca_carrera='$idCarrera' AND m.tipo='1' ORDER BY m.numero");
$res_tramo = mysql_num_rows($tramo);
	while($row=mysql_fetch_array($tramo))
	{
		$tramo_actual++;
	if($row['id_manga']==$idManga)
		$actual = $tramo_actual;
	}
/***********************************************/
include("includes/funcionesTiempos.php");
$campeonatos_carrera = mysql_query("SELECT * FROM abc_57os_ca_campeonato WHERE id_ca_carrera='$idCarrera'");
	while($mifila=mysql_fetch_array($campeonatos_carrera))
		{
		$nom = strtoupper($mifila['nombre']);
		$id_campeonato = $mifila['id'];
		echo "<br><p class='negrita centro fu1'>".$nom."</p><br>";
if($copa=='0')
	{
	$sql = "SELECT com.id AS idconcursante, m.tipo AS tipo_manga,m.numero AS num_manga,com.dorsal,pi.nombre AS piloto_nombre,
	con.nombre AS competidor,con.nacionalidad as con_nac,
	veh.grupo AS grupo,veh.clase AS clase,veh.marca AS marca,veh.modelo As modelo,pi.nacionalidad AS pi_nac
	FROM abc_57os_ca_carrera car
	INNER JOIN abc_57os_ca_competidor com ON car.id=com.id_ca_carrera
	INNER JOIN abc_57os_ca_etapa e ON e.id_ca_carrera=car.id
	INNER JOIN abc_57os_ca_seccion s ON s.id_ca_etapa=e.id
	INNER JOIN abc_57os_ca_manga m ON m.id_ca_seccion=s.id
	INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto
	INNER JOIN abc_57os_ca_concursante con ON con.id=com.id_ca_concursante
	INNER JOIN abc_57os_ca_vehiculo veh ON veh.id=com.id_ca_vehiculo
	INNER JOIN abc_57os_ca_campeonato_competidor ccm ON ccm.id_ca_competidor=com.id
	WHERE m.id='$idManga' AND com.autorizado=1 AND ccm.id_ca_campeonato='$id_campeonato' GROUP BY dorsal";
	}
	else{
	$sql = "SELECT com.id AS idconcursante, m.tipo AS tipo_manga,m.numero AS num_manga,com.dorsal,pi.nombre AS piloto_nombre,co.nombre AS copiloto_nombre,
	con.nombre AS competidor,con.nacionalidad as con_nac,
	veh.grupo AS grupo,veh.clase AS clase,veh.marca AS marca,veh.modelo As modelo,pi.nacionalidad AS pi_nac,
	co.nacionalidad AS co_nac
	FROM abc_57os_ca_carrera car
	INNER JOIN abc_57os_ca_competidor com ON car.id=com.id_ca_carrera
	INNER JOIN abc_57os_ca_etapa e ON e.id_ca_carrera=car.id
	INNER JOIN abc_57os_ca_seccion s ON s.id_ca_etapa=e.id
	INNER JOIN abc_57os_ca_manga m ON m.id_ca_seccion=s.id
	INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto
	INNER JOIN abc_57os_ca_copiloto co ON co.id=com.id_ca_copiloto
	INNER JOIN abc_57os_ca_concursante con ON con.id=com.id_ca_concursante
	INNER JOIN abc_57os_ca_vehiculo veh ON veh.id=com.id_ca_vehiculo
	WHERE m.id='$idManga' AND com.autorizado=1 GROUP BY dorsal";
		}
$resultado = mysql_query($sql) or print "No se pudo acceder al contenido de los tiempos online.";
if(mysql_num_rows($resultado)>0)
		{
		while($fila=mysql_fetch_array($resultado))
			{
			$cont=0;
			$dorsal = $fila['dorsal'];
			$competidor = $fila['competidor'];
			$piloto = $fila['piloto_nombre'];
			$vehiculo = $fila['marca'];
			$modelo = $fila['modelo'];
			$grupo = $fila['grupo'];
			$clase = $fila['clase'];
			$idcomp = $fila['idcompetidor'];
			$pi_nac = $fila['pi_nac'];
			$pi_nacs = explode('/',$pi_nac);
			$pi_nac1 = bandera($pi_nacs[0]);
			$pi_nac2 = bandera($pi_nacs[1]);
			$num_manga = $fila['num_manga'];
			$tipo_manga = $fila['tipo_manga'];
			$idconcursante = $fila['idconcursante'];
			$con_nac = $fila['con_nac'];
			$con_nac = explode("/", $con_nac);
			$con_nac1 = bandera($con_nac[0]);
			$con_nac2 = bandera($con_nac[1]);
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
			//PARA SABER SI ES OFICIAL Y CONTARLA
			$sql_oficial = mysql_query("SELECT ch.orden AS orden,t.tiempo FROM abc_57os_ca_tiempo t 
			INNER JOIN abc_57os_ca_manga_control_horario ch ON ch.id=t.id_ca_manga_control_horario 
			INNER JOIN abc_57os_ca_manga m ON ch.id_ca_manga=m.id 
			WHERE t.dorsal='$dorsal' AND t.id_ca_manga='$idManga' AND m.tipo=1 GROUP BY ch.id_ca_manga");
			$oficiales=mysql_num_rows($sql_oficial);
			$comp = mysql_query("SELECT ch.orden AS orden,t.tiempo,m.tipo FROM abc_57os_ca_tiempo t 
			INNER JOIN abc_57os_ca_manga_control_horario ch ON ch.id=t.id_ca_manga_control_horario 
			INNER JOIN abc_57os_ca_manga m ON ch.id_ca_manga=m.id 
			WHERE t.dorsal='$dorsal' AND t.id_ca_manga='$idManga'");//COMPRUEBO Q TENGA 2  TIEMPOS salida y llegada
			$abandono = mysql_query("SELECT id FROM abc_57os_ca_abandono WHERE id_ca_manga='$idManga' AND dorsal='$dorsal'");
							if(mysql_num_rows($abandono)==0)
								{
								$aban=0;
								$tipo=0;
									if(mysql_num_rows($comp)>=2)//2 TIEMPOS, LLEGADA
										{
										while($fil=mysql_fetch_array($comp))
											{
											$tipo = $fil['tipo'];
											$orden = $fil['orden'];
											if($orden==0){//ES SALIDA
											$t_s = $fil['tiempo'];
											}
											if($orden==10){//ES LLEGADA
												$t_l = $fil['tiempo'];
												}
											if($tipo==1 && $orden==10)
												{
												$cont++;
												//if($dorsal==3){
													$tmanga[$cont] = tiempo_a_milisegundos($t_l)-tiempo_a_milisegundos($t_s);
													//echo $cont."-".milisegundos_a_tiempo(tiempo_a_milisegundos($t_l)-tiempo_a_milisegundos($t_s))."<br>";
													//}
												}
											}
								}
							else
								$aban=1;
				$mimanga=$idManga;
				$ta_s=0;
				$ta_l=0;
				$t_pa=0;
				$mejor_manga1=9999999999999;
				$mejor_manga2=9999999999999;
				//$cont=1;
					while($num_manga !=1)
						{
						$num_manga--;
						$mimanga--;
						//BUSCO PRIMERO EN LAS MANGAS Y ACUMULO
						$acum = mysql_query("SELECT ch.orden AS orden,t.tiempo FROM abc_57os_ca_tiempo t 
						INNER JOIN abc_57os_ca_manga_control_horario ch ON ch.id=t.id_ca_manga_control_horario 
						INNER JOIN abc_57os_ca_manga m ON ch.id_ca_manga=m.id 
						WHERE t.dorsal='$dorsal' AND t.id_ca_manga='$mimanga' AND m.tipo!=0");
						$abandono = mysql_query("SELECT id FROM abc_57os_ca_abandono WHERE id_ca_manga='$mimanga' AND dorsal='$dorsal'");
							if(mysql_num_rows($abandono)==0)
								{
								$aban_a=0;
									if(mysql_num_rows($acum)>=2)//2 TIEMPOS, LLEGADA
									{
									$oficiales++;
									$cont++;
									while($fil=mysql_fetch_array($acum))
										{
										$orden = $fil['orden'];
										if($orden==0){//ES SALIDA
											$ta_s += tiempo_a_milisegundos($fil['tiempo']);
											$tm_s = tiempo_a_milisegundos($fil['tiempo']);
											}
										if($orden==10){//ES LLEGADA
											$ta_l += tiempo_a_milisegundos($fil['tiempo']);
											$tm_l = tiempo_a_milisegundos($fil['tiempo']);
											}
										}
											//if($dorsal==3){
												$tmanga[$cont] = $tm_l-$tm_s;
												//echo $cont."-".milisegundos_a_tiempo($tm_l-$tm_s)."<br>";
												//}
									}
								}
							else{
									$aban_a=1;
									//echo $dorsal."ABANDONO";
									$ta_s += 0;
									$tm_s = 0;
									$ta_s += 0;
									$tm_s = 0;
									}
				//BUSCO TB LAS PENALIZACIONES HASTA 
						$acum_pen = mysql_query("SELECT tiempo FROM abc_57os_ca_penalizacion WHERE id_ca_manga='$mimanga' AND dorsal='$dorsal'");
							if(mysql_num_rows($acum_pen)>0)//lo recorro por si tiene mas de una penalizacion en la misma MANGA
								{
								$t_pa=0;
									while($rowpa=mysql_fetch_array($acum_pen))
										$t_pa+=$rowpa['tiempo']; //tiempo en segundos
								}
								
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
				
				if($tm_s==0 || $tm_l==0 || $aban_a==1)
							$t_manga=0;
						else
							$t_manga = $tm_l-$tm_s;
				
				$t_pam = segundos_a_milisegundos($t_pa);
				
				if($t_s==0 || $t_l==0 || $aban==1)
					$tiempo=0;
				else
					$tiempo = tiempo_a_milisegundos($t_l)-tiempo_a_milisegundos($t_s)+segundos_a_milisegundos($pen);
				
				$t_p=segundos_a_milisegundos($pen);
				if($oficiales==3)
					{
						for($i=1;$i<=3;$i++)
						{
							//echo $tmanga[$i];
								if($i==1)
									{
									if($t_manga!=0)
										{
										$mejor_manga1=$tmanga[$i];
										}
									}
							else{
									if($tmanga[$i]<$mejor_manga1)
										{
										$mejor_manga2=$mejor_manga1;
										$mejor_manga1=$tmanga[$i];
										}
									else{
										if($tmanga[$i]<$mejor_manga2)
											{
											$mejor_manga2=$tmanga[$i];
											}
										}
									
								}
						}
					$tat = $mejor_manga1+$mejor_manga2;
					}
				else{	
					$tat = $ta_l-$ta_s; //tiempo acumulado en las mangas anteriores, lo sumamos a la actual
					$tat += (tiempo_a_milisegundos($t_l)-tiempo_a_milisegundos($t_s)+segundos_a_milisegundos($pen)+$t_pam);
					}
				//echo $dorsal."mangas: ".$cont."<br>";
					//echo milisegundos_a_tiempo($tiempo);
//PASO A CALCULAR LAS POSICIONES SEGUN TIEMPO LLEGADA
						if($tiempo>0){
								$ordenar[] = array(
								'piloto' => $piloto, 
								'copiloto' => $copiloto,
								'dorsal'=>$dorsal,
								'tiempo'=>milisegundos_a_tiempo($tiempo),
								'vehiculo'=>$vehiculo,
								'modelo'=>$modelo,
								'grupo'=>$grupo,
								'clase'=>$clase,
								'penalizacion'=>$t_p,
								'tipo'=>$tipo,
								'hora'=>$hora,
								'pi_nac1' =>$pi_nac1,
								'pi_nac2' =>$pi_nac2,
								'copi_nac1' =>$copi_nac1,
								'copi_nac2' =>$copi_nac2,
								'idconcursante' =>$idconcursante,
								'acu_hasta' =>milisegundos_a_tiempo($tat),
								'pen_hasta'=>$t_pam+$t_p,
								'manga1' =>$tmanga[1],
								'manga2' =>$tmanga[2],
								'manga3' =>$tmanga[3],
								'cont' =>$cont,
								'competidor' =>$competidor);
							}
					}
			}
		}
	else
		echo "No hay contenido online para mostrar...";
	//AQUI METO DORSALES EN ORDEN DE LLEGADA POR TIEMPO para buscar luego su posicion anterior
$posiciones_anteriores = array();

	foreach ($ordenar as $key => $row) {
		$aux[$key] = $row['tiempo'];
	}
	array_multisort($aux, SORT_ASC, $ordenar);

	foreach ($ordenar as $key => $row) {
		array_push($posiciones_anteriores,$row['dorsal']);
	}
	
?>
<p class='des_pe1'>TIEMPOS:</p>
<table border="0" width="100%" id="tab_tem" class="des_pe1">
				<thead>
				<tr>
					<th width='10%'>P.</th><th width='10%'>N.</th><th width='30%'>Equipo</th><th width='20%' colspan="2">Vehiculo<br>Grupo/Clase</th><th width='10%'>Anterior<br>Tiempo<br>Primero<br>Penalizacion</th>
				</tr>
				</thead>
					<tbody>
	<?php
	foreach ($ordenar as $key => $row) {
		$aux[$key] = $row['tiempo'];
	}
	array_multisort($aux, SORT_ASC, $ordenar);
	$pos=1;
	foreach ($ordenar as $key => $row) {
		
			if($par%2==0)
				$classcss="filapar";
			else
				$classcss="filaimpar";
//////POSICIONES GRUPOS Y CLASES///////////SIN MAS COJONES HAY Q RECORRERLO ENTERO////////////////////////

				foreach ($ordenar as $key2 => $row2) {
						$aux2[$key2] = $row2['tiempo'];
					}
					array_multisort($aux2, SORT_ASC, $ordenar);
						$total_grupo=0;
						$total_clase=0;
						$pos_en_su_grupo=1;
						$pos_en_su_clase=1;
					foreach ($ordenar as $key2 => $row2) {
						
							if($row2['grupo']==$row['grupo']) //PERTENECE AL GRUPO
								{
								$total_grupo++; //Aqui calculo por calcular el total que pertenecen a este grupo
								if($row2['dorsal']==$row['dorsal']) // COMPARO SU DORSAL PARA SABER QUIEN POLLAS ES
									$posicion_grupo_dorsal = $pos_en_su_grupo;
								$pos_en_su_grupo++;
								}
							if($row2['clase']==$row['clase']) //PERTENECE A ESTA CLASE
								{
								$total_clase++; //Aqui calculo por calcular el total que pertenecen a esta CLAsE
								if($row2['dorsal']==$row['dorsal']) // COMPARO SU DORSAL PARA SABER QUIEN POLLAS ES
									$posicion_clase_dorsal = $pos_en_su_clase;
								$pos_en_su_clase++;
								}
						
					}
	//////////////////////////////Y TERMINAMOS CALCULO DE POSICIOnES/////////////////////////////////////

				if($pos==1){ //EL MEJOR TIEMPO......SIN DUDA ES EL PRIMErOO ;-)
					$mejor_tiempo_tramo = $row['tiempo'];
					$tiempo_anterior = $row['tiempo'];
				}

			if(strlen($mejor_tiempo_tramo>9)){
				$dif_primero = milisegundos_a_tiempo(tiempo_a_milisegundos($row['tiempo']) - tiempo_a_milisegundos($mejor_tiempo_tramo));
				$dif_anterior = milisegundos_a_tiempo(tiempo_a_milisegundos($row['tiempo']) - tiempo_a_milisegundos($tiempo_anterior));
				}
			else{
				$dif_primero = milisegundos_a_tiempo(tiempo_a_milisegundos("00:".$row['tiempo']) - tiempo_a_milisegundos("00:".$mejor_tiempo_tramo));
				$dif_anterior = milisegundos_a_tiempo(tiempo_a_milisegundos("00:".$row['tiempo']) - tiempo_a_milisegundos("00:".$tiempo_anterior));
				}
			//AQUI DEJO EL ENLACE DE VER PILOTOS ver_equipo.php?equipo='.$row['idconcursante'].'&id='.$idCarrera.'&idetapa='.$idetapa.'&idmanga='.$idManga.'&idseccion='.$idseccion.'&newBD=true
	echo '<tr class="'.$classcss.'"><td class="pos negrita mini4">'.$pos.'</td><td class="dor mini4">'.$row['dorsal'].'</td>';
		if($copiloto!=''){
			echo '<td class="con mini1"><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['con_nac1'].'">'.$row['competidor'].'</p><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac1'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac2'].'">'.acortar_nombre($row['piloto']).'</p><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['copi_nac1'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['copi_nac2'].'">'.acortar_nombre($row['copiloto']).'</p></td>';
			}
		else
			echo '<td class="con mini1"><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['con_nac1'].'">'.$row['competidor'].'</p><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac2'].'">'.acortar_nombre($row['piloto']).'<br></td>';
	
	echo '<td class="cla">'.escudo($row['vehiculo']).'</td><td><span class="veh mini3">'.$row['vehiculo'].' '.$row['modelo'].'</span>
		<br><span class="gru mini1">'.$row['grupo'].'('.$posicion_grupo_dorsal.') / '.$row['clase'].'('.$posicion_clase_dorsal.')</span></td>';
		if($pos!=1)
			echo '<td class="tie centro mini2"><p class="anterior cursiva nomargen mini2">+'.$dif_anterior.'</p><p class="negrita nomargen mini2">'.$row['tiempo'].'</p><p class="cursiva nomargen mini2">+'.$dif_primero.'</p>';
		else
			echo '<td class="tie centro mini2"><p class="negrita nomargen mini2">'.$row['tiempo'].'</p>';
			if($row['penalizacion']!=0)
				echo '<p><span class="penalizaciones nomargen mini2">'.milisegundos_a_tiempo($row['penalizacion']).'</span></p></td></tr>';
			else
				echo '</td></tr>';
		$tiempo_anterior=$row['tiempo'];
		$par++;
		$pos++;
	}
//unset($tiempos);
	?></tbody>
				</tr>		
			</table>
			<?php
	//echo $num_manga;
	if($tipo_manga!=0){
		?>	
		<p class='des_pe1'>ACUMULADOS:</p>
		<table border="0" width="100%" id="tab_tem" class="des_pe1">
				<thead>
				<tr>
					<th width='10%'>Pos</th><th width='10%' colspan="2">dorsal</th><th width='30%'>Equipo</th><th width='20%' colspan="2">Vehiculo<br>Grupo/Clase</th><th width='10%'>Anterior<br>Tiempo<br>Primero<br>Penalizacion</th>
				</tr>
				</thead>
					<tbody>
			<?php
			if($tipo_manga==0 AND $num_manga==1) //LA MANGA ES LA 1 Y NO PUNTUA
			echo "<tr><td colspan='7'>NO EXISTEN ACUMULADOS</td></tr>";
	else{
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
    		//////POSICIONES GRUPOS Y CLASES///////////SIN MAS COJONES HAY Q RECORRERLO ENTERO////////////////////////

				foreach ($ordenar as $key2 => $row2) {
						$aux2[$key2] = $row2['tiempo'];
					}
					array_multisort($aux2, SORT_ASC, $ordenar);
						$total_grupo=0;
						$total_clase=0;
						$pos_en_su_grupo=1;
						$pos_en_su_clase=1;
					foreach ($ordenar as $key2 => $row2) {
						
							if($row2['grupo']==$row['grupo']) //PERTENECE AL GRUPO
								{
								$total_grupo++; //Aqui calculo por calcular el total que pertenecen a este grupo
								if($row2['dorsal']==$row['dorsal']) // COMPARO SU DORSAL PARA SABER QUIEN POLLAS ES
									$posicion_grupo_dorsal = $pos_en_su_grupo;
								$pos_en_su_grupo++;
								}
							if($row2['clase']==$row['clase']) //PERTENECE A ESTA CLASE
								{
								$total_clase++; //Aqui calculo por calcular el total que pertenecen a esta CLAsE
								if($row2['dorsal']==$row['dorsal']) // COMPARO SU DORSAL PARA SABER QUIEN POLLAS ES
									$posicion_clase_dorsal = $pos_en_su_clase;
								$pos_en_su_clase++;
								}
						
					}

	//////////////////////////////Y TERMINAMOS CALCULO DE POSICIOnES/////////////////////////////////////
						if($pos==1){ //EL MEJOR TIEMPO......SIN DUDA ES EL PRIMErOO ;-)
							$mejor_tiempo_acumulado = $row['acu_hasta'];
							$tiempo_acu_anterior = $row['acu_hasta'];
						}
			$evolucion = array_search($row['dorsal'],$posiciones_anteriores)+1;

			$variacion = $pos-$evolucion; //me falta darle estilo en la web
			
			if(strlen($mejor_tiempo_acumulado>9)){
				$dif_acu_primero = milisegundos_a_tiempo(tiempo_a_milisegundos($row['acu_hasta']) - tiempo_a_milisegundos($mejor_tiempo_acumulado));
				$dif_acu_anterior = milisegundos_a_tiempo(tiempo_a_milisegundos($row['acu_hasta']) - tiempo_a_milisegundos($tiempo_acu_anterior));
				}
			else{
				$dif_acu_primero = milisegundos_a_tiempo(tiempo_a_milisegundos("00:".$row['acu_hasta']) - tiempo_a_milisegundos("00:".$mejor_tiempo_acumulado));
				$dif_acu_anterior = milisegundos_a_tiempo(tiempo_a_milisegundos("00:".$row['acu_hasta']) - tiempo_a_milisegundos("00:".$tiempo_acu_anterior));
				}
			if($actual==2){//CONDICION PARA LOS Q NO HAN SUMADO EN LA 1 MANGA
			if($row['cont']==$actual){
				echo '<tr class="'.$classcss.'"><td class="pos negrita">'.$pos.'</td>';
					
						if($variacion==0)
							echo "<td></td>";
						if($variacion<0)
							echo "<td class='variacion_verde centro'>".$variacion."</td>";
						if($variacion>0)
							echo "<td class='variacion_rojo centro'>+".$variacion."</td>";

					
				echo '<td class="dor">'.$row['dorsal'].'</td>';
				if($copiloto!=''){
			echo '<td class="con mini1"><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['con_nac1'].'">'.$row['competidor'].'</p><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac1'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac2'].'">'.acortar_nombre($row['piloto']).'</p><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['copi_nac1'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['copi_nac2'].'">'.acortar_nombre($row['copiloto']).'</p></td>';
			}
		else
			echo '<td class="con mini1"><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['con_nac1'].'">'.$row['competidor'].'</p><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac2'].'">'.acortar_nombre($row['piloto']).'<br></td>';
				
				echo '</td><td class="cla">'.escudo($row['vehiculo']).'</td><td><span class="veh">'.$row['vehiculo'].' '.$row['modelo'].'</span>
					<br><span class="gru">'.$row['grupo'].'('.$posicion_grupo_dorsal.') / '.$row['clase'].'('.$posicion_clase_dorsal.')</span></td>
					<td class="tie centro">';
						if($pos!=1)
							echo '<p class="mini2 cursiva nomargen">+'.$dif_acu_anterior.'</p><p class="nomargen mini2 negrita">'.$row['acu_hasta'].'</p><p class="cursiva nomargen mini2">+'.$dif_acu_primero.'</p>';
						else
							echo '<p class="negrita nomargen mini2">'.$row['acu_hasta'].'</p>';
						if($row['penalizacion']!=0)
							echo '<p><span class="penalizaciones mini2">'.milisegundos_a_tiempo($row['pen_hasta']).'</p></td></tr>';
						else
							echo '</td></tr>';
						$tiempo_acu_anterior=$row['acu_hasta'];
					$par++;
					$pos++;
					}
				}
			else{
							echo '<tr class="'.$classcss.'"><td class="pos negrita">'.$pos.'</td>';
					
						if($variacion==0)
							echo "<td></td>";
						if($variacion<0)
							echo "<td class='variacion_verde centro'>".$variacion."</td>";
						if($variacion>0)
							echo "<td class='variacion_rojo centro'>+".$variacion."</td>";

					
				echo '<td class="dor">'.$row['dorsal'].'</td><td class="com">'.$row['competidor'].'</td>
				<td class="con mini1"><img class="banderas" src="http://codea.es/coda2019/'.$pi_nac.'">'.acortar_nombre($row['piloto']).'<br><img class="banderas" src="http://codea.es/coda2019/'.$co_nac.'">'.acortar_nombre($row['copiloto']).'</td>
					<td class="cla">'.escudo($row['vehiculo']).'</td><td><span class="veh">'.$row['vehiculo'].' '.$row['modelo'].'</span>
					<br><span class="gru">'.$row['grupo'].'('.$posicion_grupo_dorsal.') / '.$row['clase'].'('.$posicion_clase_dorsal.')</span></td>
					<td class="tie centro">';
						if($pos!=1)
							echo '<p class="tie centro mini2">+'.$dif_acu_anterior.'</p><p class="negrita nomargen mini2">'.$row['acu_hasta'].'</p><p class="cursiva nomargen mini2">+'.$dif_acu_primero.'</p>';
						else
							echo '<p class="negrita nomargen mini2">'.$row['acu_hasta'].'</p>';
						if($row['penalizacion']!=0)
							echo '<p><span class="penalizaciones mini2">'.milisegundos_a_tiempo($row['pen_hasta']).'</p></td></tr>';
						else
							echo '</td></tr>';
						$tiempo_acu_anterior=$row['acu_hasta'];
					$par++;
					$pos++;
				}
	}
		}	
			?>
		</table>
		<?php					
		}	//QUITAR ACUMULADOS
		?>
	<br>						
	<table width="100%" border="0" class="top" id="des_gran"> <!--!evitar descuadre VERSION NORMAL PANTALLAS GRANDES-->
	<tr>
		<td>
			TIEMPOS:<br>
			<table border="0" width="100%" id="tab_tem">
				<thead>
				<tr>
					<th>P.</th><th>N.</th><th>Concursante</th><th>Equipo</th><th colspan="2">Vehiculo<br>Grupo/Clase</th><th class="centro tie"><p class="anterior cursiva nomargen">Anterior</p><p class="negrita nomargen">Tiempo</p><p class="anterior cursiva nomargen">Primero</p><p><span class="penalizaciones nomargen">Penalizacion</span></th>
				</tr>
				</thead>
					<tbody>
	<?php
	foreach ($ordenar as $key => $row) {
		$aux[$key] = $row['tiempo'];
	}
	array_multisort($aux, SORT_ASC, $ordenar);
	$pos=1;
	foreach ($ordenar as $key => $row) {
			if($par%2==0)
				$classcss="filapar";
			else
				$classcss="filaimpar";
		//////POSICIONES GRUPOS Y CLASES///////////SIN MAS COJONES HAY Q RECORRERLO ENTERO////////////////////////

				foreach ($ordenar as $key2 => $row2) {
						$aux2[$key2] = $row2['tiempo'];
					}
					array_multisort($aux2, SORT_ASC, $ordenar);
						$total_grupo=0;
						$total_clase=0;
						$pos_en_su_grupo=1;
						$pos_en_su_clase=1;
					foreach ($ordenar as $key2 => $row2) {
						
							if($row2['grupo']==$row['grupo']) //PERTENECE AL GRUPO
								{
								$total_grupo++; //Aqui calculo por calcular el total que pertenecen a este grupo
								if($row2['dorsal']==$row['dorsal']) // COMPARO SU DORSAL PARA SABER QUIEN POLLAS ES
									$posicion_grupo_dorsal = $pos_en_su_grupo;
								$pos_en_su_grupo++;
								}
							if($row2['clase']==$row['clase']) //PERTENECE A ESTA CLASE
								{
								$total_clase++; //Aqui calculo por calcular el total que pertenecen a esta CLAsE
								if($row2['dorsal']==$row['dorsal']) // COMPARO SU DORSAL PARA SABER QUIEN POLLAS ES
									$posicion_clase_dorsal = $pos_en_su_clase;
								$pos_en_su_clase++;
								}
						
					}
	//////////////////////////////Y TERMINAMOS CALCULO DE POSICIOnES/////////////////////////////////////

				if($pos==1){ //EL MEJOR TIEMPO......SIN DUDA ES EL PRIMErOO ;-)
					$mejor_tiempo_tramo = $row['tiempo'];
					//$tiempo_anterior = $row['tiempo'];
				}
//echo tiempo_a_milisegundos($row['tiempo']);
			if(strlen($mejor_tiempo_tramo>9)){
				$dif_primero = milisegundos_a_tiempo(tiempo_a_milisegundos($row['tiempo']) - tiempo_a_milisegundos($mejor_tiempo_tramo));
				$dif_anterior = milisegundos_a_tiempo(tiempo_a_milisegundos($row['tiempo']) - tiempo_a_milisegundos($tiempo_anterior));
				}
			else{
				$dif_primero = milisegundos_a_tiempo(tiempo_a_milisegundos("00:".$row['tiempo']) - tiempo_a_milisegundos("00:".$mejor_tiempo_tramo));
				$dif_anterior = milisegundos_a_tiempo(tiempo_a_milisegundos("00:".$row['tiempo']) - tiempo_a_milisegundos("00:".$tiempo_anterior));
				}
	//if($actual==2){//CONDICION PARA LOS Q NO HAN SUMADO EN LA 1 MANGA
		//	if($row['cont']==$actual){
				echo '<tr class="'.$classcss.'"><td class="pos negrita">'.$pos.'</td><td class="dor">'.$row['dorsal'].'</td><td class="com">'.$row['competidor'].'</td>
				<td class="con"><img class="banderas" src="http://codea.es/coda2019/'.$pi_nac.'">
				<a href="#">'.$row['piloto'];
				if($copiloto!='')
					echo '<br><img class="banderas" src="http://codea.es/coda2019/'.$co_nac.'">'.acortar_nombre($row['copiloto']).'</a>';
				
				echo '</td><td class="cla">'.escudo($row['vehiculo']).'</td><td><span class="veh">'.$row['vehiculo'].' '.$row['modelo'].'</span>
					<br><span class="gru">'.$row['grupo'].'('.$posicion_grupo_dorsal.') / '.$row['clase'].'('.$posicion_clase_dorsal.')</span></td>';
					if($pos!=1)
						echo '<td class="tie centro"><p class="anterior cursiva nomargen">+'.$dif_anterior.'</p><p class="negrita nomargen">'.$row['tiempo'].'</p><p class="cursiva nomargen">+'.$dif_primero.'</p>';
					else
						echo '<td class="tie centro"><p class="negrita nomargen">'.$row['tiempo'].'</p>';
						if($row['penalizacion']!=0)
							echo '<p><span class="penalizaciones nomargen">'.milisegundos_a_tiempo($row['penalizacion']).'</span></p></td></tr>';
						else
							echo '</td></tr>';
					$tiempo_anterior=$row['tiempo'];
					$par++;
					$pos++;
						}
				/*	}
			else{
						echo '<tr class="'.$classcss.'"><td class="pos negrita">'.$pos.'</td><td class="dor">'.$row['dorsal'].'</td><td class="com">'.$row['competidor'].'</td>
			<td class="con"><img class="banderas" src="http://codea.es/coda2019/'.$pi_nac.'">
			<a href="#">'.$row['piloto'];
			if($copiloto!='')
				echo '<br><img class="banderas" src="http://codea.es/coda2019/'.$co_nac.'">'.acortar_nombre($row['copiloto']).'</a>';
			
			echo '</td><td class="cla">'.escudo($row['vehiculo']).'</td><td><span class="veh">'.$row['vehiculo'].' '.$row['modelo'].'</span>
				<br><span class="gru">'.$row['grupo'].'('.$posicion_grupo_dorsal.') / '.$row['clase'].'('.$posicion_clase_dorsal.')</span></td>';
				if($pos!=1)
					echo '<td class="tie centro"><p class="anterior cursiva nomargen">+'.$dif_anterior.'</p><p class="negrita nomargen">'.$row['tiempo'].'</p><p class="cursiva nomargen">+'.$dif_primero.'</p>';
				else
					echo '<td class="tie centro"><p class="negrita nomargen">'.$row['tiempo'].'</p>';
					if($row['penalizacion']!=0)
						echo '<p><span class="penalizaciones nomargen">'.milisegundos_a_tiempo($row['penalizacion']).'</span></p></td></tr>';
					else
						echo '</td></tr>';
				$tiempo_anterior=$row['tiempo'];
				$par++;
				$pos++;
			}
	}*/
//unset($tiempos);
	?>
					</tbody>	
			</table>
			<?php
	//echo $num_manga;
	if($tipo_manga!=0){
		?>	
		</td>
		<td>ACUMULADOS:<br>
				<table border="0" width="100%" id="tab_tem">
				<thead>
				<tr>
					<th colspan="2">P.</th><th>N.</th><th>Concursante</th><th>Equipo</th><th colspan="2">Vehiculo<br>Grupo/Clase</th><th class="centro tie"><p class="anterior cursiva nomargen">Anterior</p><p class="negrita nomargen">Tiempo</p><p class="anterior cursiva nomargen">Primero</p><p><span class="penalizaciones nomargen">Penalizacion</span></th>
				</tr>
				</thead>
					<tbody>
		<?php
	if($tipo_manga==0 AND $num_manga==1) //LA MANGA ES LA 1 Y NO PUNTUA
			echo "<tr><td colspan='7'>NO EXISTEN ACUMULADOS</td></tr>";
	else{
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
    		//////POSICIONES GRUPOS Y CLASES///////////SIN MAS COJONES HAY Q RECORRERLO ENTERO////////////////////////

				foreach ($ordenar as $key2 => $row2) {
						$aux2[$key2] = $row2['tiempo'];
					}
					array_multisort($aux2, SORT_ASC, $ordenar);
						$total_grupo=0;
						$total_clase=0;
						$pos_en_su_grupo=1;
						$pos_en_su_clase=1;
					foreach ($ordenar as $key2 => $row2) {
						
							if($row2['grupo']==$row['grupo']) //PERTENECE AL GRUPO
								{
								$total_grupo++; //Aqui calculo por calcular el total que pertenecen a este grupo
								if($row2['dorsal']==$row['dorsal']) // COMPARO SU DORSAL PARA SABER QUIEN POLLAS ES
									$posicion_grupo_dorsal = $pos_en_su_grupo;
								$pos_en_su_grupo++;
								}
							if($row2['clase']==$row['clase']) //PERTENECE A ESTA CLASE
								{
								$total_clase++; //Aqui calculo por calcular el total que pertenecen a esta CLAsE
								if($row2['dorsal']==$row['dorsal']) // COMPARO SU DORSAL PARA SABER QUIEN POLLAS ES
									$posicion_clase_dorsal = $pos_en_su_clase;
								$pos_en_su_clase++;
								}
						
					}

	//////////////////////////////Y TERMINAMOS CALCULO DE POSICIOnES/////////////////////////////////////
						if($pos==1){ //EL MEJOR TIEMPO......SIN DUDA ES EL PRIMErOO ;-)
							$mejor_tiempo_acumulado = $row['acu_hasta'];
							$tiempo_acu_anterior = $row['acu_hasta'];
						}
			$evolucion = array_search($row['dorsal'],$posiciones_anteriores)+1;

			$variacion = $pos-$evolucion; //me falta darle estilo en la web
			
			if(strlen($mejor_tiempo_acumulado>9)){
				$dif_acu_primero = milisegundos_a_tiempo(tiempo_a_milisegundos($row['acu_hasta']) - tiempo_a_milisegundos($mejor_tiempo_acumulado));
				$dif_acu_anterior = milisegundos_a_tiempo(tiempo_a_milisegundos($row['acu_hasta']) - tiempo_a_milisegundos($tiempo_acu_anterior));
				}
			else{
				$dif_acu_primero = milisegundos_a_tiempo(tiempo_a_milisegundos("00:".$row['acu_hasta']) - tiempo_a_milisegundos("00:".$mejor_tiempo_acumulado));
				$dif_acu_anterior = milisegundos_a_tiempo(tiempo_a_milisegundos("00:".$row['acu_hasta']) - tiempo_a_milisegundos("00:".$tiempo_acu_anterior));
				}
			if($actual==2){//CONDICION PARA LOS Q NO HAN SUMADO EN LA 1 MANGA
			if($row['cont']==$actual){
				echo '<tr class="'.$classcss.'"><td class="pos negrita">'.$pos.'</td>';
					
						if($variacion==0)
							echo "<td></td>";
						if($variacion<0)
							echo "<td class='variacion_verde centro'>".$variacion."</td>";
						if($variacion>0)
							echo "<td class='variacion_rojo centro'>+".$variacion."</td>";

					
				echo '<td class="dor">'.$row['dorsal'].'</td><td class="com">'.$row['competidor'].'</td>
				<td class="con"><img class="banderas" src="http://codea.es/coda2019/'.$pi_nac.'">'.acortar_nombre($row['piloto']);
				
				if($copiloto!='')
					echo '<br><img class="banderas" src="http://codea.es/coda2019/'.$co_nac.'">'.acortar_nombre($row['copiloto']);
				
				echo '</td><td class="cla">'.escudo($row['vehiculo']).'</td><td><span class="veh">'.$row['vehiculo'].' '.$row['modelo'].'</span>
					<br><span class="gru">'.$row['grupo'].'('.$posicion_grupo_dorsal.') / '.$row['clase'].'('.$posicion_clase_dorsal.')</span></td>
					<td class="tie centro">';
						if($pos!=1)
							echo '<p class="anterior cursiva nomargen">+'.$dif_acu_anterior.'</p><p class="negrita nomargen">'.$row['acu_hasta'].'</p><p class="cursiva nomargen">+'.$dif_acu_primero.'</p>';
						else
							echo '<p class="negrita nomargen">'.$row['acu_hasta'].'</p>';
						if($row['penalizacion']!=0)
							echo '<p><span class="penalizaciones">'.milisegundos_a_tiempo($row['pen_hasta']).'</p></td></tr>';
						else
							echo '</td></tr>';
						$tiempo_acu_anterior=$row['acu_hasta'];
					$par++;
					$pos++;
					}
				}
			else{
							echo '<tr class="'.$classcss.'"><td class="pos negrita">'.$pos.'</td>';
					
						if($variacion==0)
							echo "<td></td>";
						if($variacion<0)
							echo "<td class='variacion_verde centro'>".$variacion."</td>";
						if($variacion>0)
							echo "<td class='variacion_rojo centro'>+".$variacion."</td>";

					
				echo '<td class="dor">'.$row['dorsal'].'</td><td class="com">'.$row['competidor'].'</td>
				<td class="con"><img class="banderas" src="http://codea.es/coda2019/'.$pi_nac.'">'.acortar_nombre($row['piloto']);
				
				if($copiloto!='')
					echo '<br><img class="banderas" src="http://codea.es/coda2019/'.$co_nac.'">'.acortar_nombre($row['copiloto']);
				
				echo '</td><td class="cla">'.escudo($row['vehiculo']).'</td><td><span class="veh">'.$row['vehiculo'].' '.$row['modelo'].'</span>
					<br><span class="gru">'.$row['grupo'].'('.$posicion_grupo_dorsal.') / '.$row['clase'].'('.$posicion_clase_dorsal.')</span></td>
					<td class="tie centro">';
						if($pos!=1)
							echo '<p class="anterior cursiva nomargen">+'.$dif_acu_anterior.'</p><p class="negrita nomargen">'.$row['acu_hasta'].'</p><p class="cursiva nomargen">+'.$dif_acu_primero.'</p>';
						else
							echo '<p class="negrita nomargen">'.$row['acu_hasta'].'</p>';
						if($row['penalizacion']!=0)
							echo '<p><span class="penalizaciones">'.milisegundos_a_tiempo($row['pen_hasta']).'</p></td></tr>';
						else
							echo '</td></tr>';
						$tiempo_acu_anterior=$row['acu_hasta'];
					$par++;
					$pos++;
				}
	}
		}	
		?>
					</tbody>	
			</table>
		</td>
	</tr>
</table>
<br>
	<?php
	}
	unset($ordenar);
	unset($aux);
	}
	?>
<p>PENALIZACIONES</p>
<table border="0" width="100%" id="tab_tem">
				<thead>
				<tr>
					<th>N.</th><th>Concursante</th><th>Equipo</th><th>Vehiculo</th><th>Control</th><th>Descripcion</th><th>Tiempo</th>
				</tr>
				</thead>
					<tbody>
					<?php
					$pen = mysql_query("SELECT pi.nombre AS piloto,co.nombre AS copiloto,veh.marca,veh.modelo,
					con.nombre AS concursante,p.dorsal,p.tiempo,p.motivo,p.control FROM abc_57os_ca_penalizacion p
					INNER JOIN abc_57os_ca_competidor com ON p.id_ca_competidor=com.id
					INNER JOIN abc_57os_ca_concursante con ON con.id=com.id_ca_concursante
					INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto 
					INNER JOIN abc_57os_ca_copiloto co ON co.id=com.id_ca_copiloto 
					INNER JOIN abc_57os_ca_vehiculo veh ON veh.id=com.id_ca_vehiculo 
					WHERE p.id_ca_manga='$idManga' 
					ORDER BY dorsal DESC");
					if(mysql_num_rows($pen)>0){
						while($fila=mysql_fetch_array($pen)){
							$dorsal = $fila['dorsal'];
							$tiempo = $fila['tiempo'];
							$motivo = $fila['motivo'];
							$control = $fila['control'];
							$concursante = $fila['concursante'];
							$piloto = $fila['piloto'];
							$copiloto = $fila['copiloto'];
							$marca = $fila['marca'];
							$modelo = $fila['modelo'];
							if($par%2==0)
								$classcss="filapar";
							else
								$classcss="filaimpar";
							echo "<tr class='".$classcss."'><td class='dor negrita'>".$dorsal."</td><td class='con'>".$concursante."</td><td>".$piloto."<br>".$copiloto."</td>
							<td class='veh'>".$marca."<br>".$modelo."</td><td>".$control."</td><td>".$motivo."</td><td>".$tiempo." Segundos</td></tr>";
							$par++;
							}
					}//IF
					else
						echo "<tr><td colspan='7'>No existen Penalizaciones en este tramo</td></tr>";
					?>
					</tbody>
				</table>
<br>
<p>ABANDONOS</p>
<table border="0" width="100%" id="tab_tem">
				<thead>
				<tr>
					<th>N.</th><th>Concursante</th><th>Equipo</th><th>Vehiculo</th><th>Grupo</th><th>Clase</th><th>Raz&oacute;n</th>
				</tr>
				</thead>
					<tbody>
					<?php
					$pen = mysql_query("SELECT veh.marca,veh.modelo,co.nombre AS copiloto,pi.nombre AS piloto,con.nombre AS concursante,c.dorsal,a.motivo FROM abc_57os_ca_abandono a
					INNER JOIN abc_57os_ca_competidor c ON c.id=a.id_ca_competidor 
					INNER JOIN abc_57os_ca_concursante con ON con.id=c.id_ca_concursante 
					INNER JOIN abc_57os_ca_piloto pi ON pi.id=c.id_ca_piloto 
					INNER JOIN abc_57os_ca_copiloto co ON co.id=c.id_ca_copiloto 
					INNER JOIN abc_57os_ca_vehiculo veh ON veh.id=c.id_ca_vehiculo 
					WHERE a.id_ca_manga='$idManga' ORDER BY c.dorsal");
					if(mysql_num_rows($pen)>0){
						while($fila=mysql_fetch_array($pen)){
							$dorsal = $fila['dorsal'];
							$motivo = $fila['motivo'];
							$concursante = $fila['concursante'];
							$piloto = $fila['piloto'];
							$copiloto = $fila['copiloto'];
							$marca = $fila['marca'];
							$modelo = $fila['modelo'];
							if($par%2==0)
								$classcss="filapar";
							else
								$classcss="filaimpar";
							echo "<tr class='".$classcss."'><td class='dor negrita'>".$dorsal."</td>
							<td class='con'>".$concursante."</td>
							<td>".$piloto."<br>".$copiloto."</td>
							<td class='veh'>".$marca."<br>".$modelo."</td>
							<td>".$control."</td><td></td>
							<td>".$motivo."</td></tr>";
							$par++;
							}
					}//IF
					else
						echo "<tr><td colspan='7'>No existen Abandonos en este tramo</td></tr>";
					?>
					</tbody>
				</table>

<br>
<br>
<br>
<br>


