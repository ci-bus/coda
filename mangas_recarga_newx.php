<?php
//echo $orden;
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
//include("includes/funciones.php"); ME CAGO EN SU PUTA MADRE QUE NO FUNCIONAA!!!!! REVISAR
include("includes/funcionesTiempos.php");
$campeonatos_carrera = mysql_query("SELECT * FROM abc_57os_ca_campeonato WHERE id_ca_carrera='$idCarrera'");
	while($mifila=mysql_fetch_array($campeonatos_carrera))
		{
		$nom = strtoupper($mifila['nombre']);
		$id_campeonato = $mifila['id'];
if($copa=='0')
	{
	$sql = "SELECT com.id AS idconcursante, m.tipo AS tipo_manga,m.numero AS num_manga,com.dorsal,pi.nombre AS piloto_nombre,id_ca_copiloto_segundo AS copi2,
	con.nombre AS competidor,com.srally_esp AS ss,
	veh.grupo AS grupo,veh.clase AS clase,veh.marca AS marca,veh.modelo As modelo,pi.nacionalidad AS pi_nac,con.nacionalidad AS con_nac
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
	$resultado = mysql_query($sql) or print "No se pudo acceder al contenido de los tiempos online.";
	$res = mysql_num_rows($resultado);
	//echo $sql;
	$no_concursante=0;
	//ÑAPA AUTENTICA PARA EVITAR LOS CONCURSANTES 0
	if($res==0)
		{
		$no_concursante=1;
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
		WHERE m.id='$idManga' AND com.autorizado=1 AND ccm.id_ca_campeonato='$id_campeonato' GROUP BY dorsal";
		$resultado = mysql_query($sql) or print "No se pudo acceder al contenido de los tiempos online.";
		}
	}
	else{
	$sql = "SELECT com.id AS idconcursante, m.tipo AS tipo_manga,m.numero AS num_manga,com.dorsal,pi.nombre AS piloto_nombre,id_ca_copiloto_segundo AS copi2,
	con.nombre AS competidor,
	veh.grupo AS grupo,veh.clase AS clase,veh.marca AS marca,veh.modelo As modelo,pi.nacionalidad AS pi_nac,con.nacionalidad AS con_nac
	FROM abc_57os_ca_carrera car
	INNER JOIN abc_57os_ca_competidor com ON car.id=com.id_ca_carrera
    INNER JOIN abc_57os_ca_copa_competidor cocom ON cocom.id_ca_competidor=com.id
    INNER JOIN abc_57os_ca_copa copa ON copa.id=cocom.id_ca_copa
	INNER JOIN abc_57os_ca_etapa e ON e.id_ca_carrera=car.id
	INNER JOIN abc_57os_ca_seccion s ON s.id_ca_etapa=e.id
	INNER JOIN abc_57os_ca_manga m ON m.id_ca_seccion=s.id
	INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto
	INNER JOIN abc_57os_ca_concursante con ON con.id=com.id_ca_concursante
	INNER JOIN abc_57os_ca_vehiculo veh ON veh.id=com.id_ca_vehiculo
	INNER JOIN abc_57os_ca_campeonato_competidor ccm ON ccm.id_ca_competidor=com.id
	WHERE m.id='$idManga' AND com.autorizado=1 AND ccm.id_ca_campeonato='$id_campeonato' AND copa.id='$copa' GROUP BY dorsal";
			$resultado = mysql_query($sql) or print "No se pudo acceder al contenido de los tiempos online-COPAS.";
	}
$nom = str_replace('ESPAÃ‘A', 'ESPAÑA', $nom); //QUITO LA MIERDA de ''AÄ que no se xq sale imagino que algo de UTF8 en codificacion de BD
$afec = mysql_num_rows($resultado);
if($afec!=0){
echo "<br><p class='negrita centro fu1'>".$nom."</p><br>";
if(mysql_num_rows($resultado)>0)
		{
		while($fila=mysql_fetch_array($resultado))
			{
			$ss = $fila['ss'];
			$t_l=0;
			$cont=0;
			$dorsal = $fila['dorsal'];
			$competidor = $fila['competidor'];
			$con_nac = $fila['con_nac'];
			$con_nac = explode("/", $con_nac);
			$con_nac1 = bandera($con_nac[0]);
			$con_nac2 = bandera($con_nac[1]);
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
			$copi2 = $fila['copi2'];
				if($copi2!=0 || $copi2!='0' || !empty($copi2)){
			$sql_copi2 = mysql_query("SELECT copi.nombre AS copiloto,copi.nacionalidad AS nacionalidad FROM abc_57os_ca_copiloto copi 
			INNER JOIN abc_57os_ca_competidor com ON copi.id=com.id_ca_copiloto_segundo
			WHERE com.id_ca_carrera = '$idCarrera' AND com.id_ca_copiloto_segundo = '$copi2'");
				if(mysql_num_rows($sql_copi2)>0)
					{
					$copi2 = @mysql_result($sql_copi2, 0, "copiloto");
					$copi2_nac = @mysql_result($sql_copi2, 0, "nacionalidad");
					$copi2_nacs = explode('/',$copi2_nac);
					$copi2_nac1 = bandera($copi2_nacs[0]);
					$copi2_nac2 = bandera($copi2_nacs[1]);
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
									if(mysql_num_rows($comp)>=2)//MIN 2 TIEMPOS, SALIDA - LLEGADA
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
													$tiempo = tiempo_a_milisegundos($t_l)-tiempo_a_milisegundos($t_s);
													//echo $dorsal."--".$tiempo;
														//echo $cont."-".milisegundos_a_tiempo(tiempo_a_milisegundos($t_l)-tiempo_a_milisegundos($t_s))."<br>";
														//}
													}
											}
										}
							else
								$aban=1;

						if($tiempo>0){					
							$consultaX = "INSERT INTO web_trigger 
(idcarrera,idmanga,ss,piloto,copiloto,dorsal,vehiculo,modelo,grupo,clase,tiempo,penalizacion,idconcursante,tipo) VALUES('$idCarrera','$idManga','$ss','$piloto','$copiloto','$dorsal')";
							echo $consultaX."<br>";
								/*$ordenar[] = array(
								'ss' => $ss, 
								'piloto' => $piloto, 
								'copiloto' => $copiloto,
								'copiloto2' => $copi2,
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
								'copi2_nac1' =>$copi2_nac1,
								'copi2_nac2' =>$copi2_nac2,
								'con_nac1' =>$con_nac1,
								'con_nac2' =>$con_nac2,
								'idconcursante' =>$idconcursante,
								'acu_hasta' =>milisegundos_a_tiempo($tat),
								'pen_hasta'=>$t_pam+$t_p,
								'manga1' =>$tmanga[1],
								'manga2' =>$tmanga[2],
								'manga3' =>$tmanga[3],
								'manga4' =>$tmanga[4],
								'manga5' =>$tmanga[5],
								'manga6' =>$tmanga[6],
								'competidor' =>$competidor);*/
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
<!--VERSION MOVILES------>
<p class='des_pe1'>TIEMPOS:</p>
<table border="0" width="100%" id="tab_tem" class="des_pe1">
				<thead>
				<tr>
					<th width='10%'>Pos</th><th width='10%'>dorsal</th><th width='30%'>Equipo</th><th width='20%' colspan="2">Vehiculo<br>Grupo/Clase</th><th width='10%'>Anterior<br>Tiempo<br>Primero<br>Penalizacion</th>
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
		if(strlen($mejor_tiempo_tramo)>9){
			$dif_primero = milisegundos_a_tiempo(tiempo_a_milisegundos($row['tiempo']) - tiempo_a_milisegundos($mejor_tiempo_tramo));
			$dif_anterior = milisegundos_a_tiempo(tiempo_a_milisegundos($row['tiempo']) - tiempo_a_milisegundos($tiempo_anterior));
			}
		else{
			$dif_primero = milisegundos_a_tiempo(tiempo_a_milisegundos("00:".$row['tiempo']) - tiempo_a_milisegundos("00:".$mejor_tiempo_tramo));
			$dif_anterior = milisegundos_a_tiempo(tiempo_a_milisegundos("00:".$row['tiempo']) - tiempo_a_milisegundos("00:".$tiempo_anterior));
			}
	echo '<tr class="'.$classcss.'"><td class="pos negrita mini4">'.$pos.'</td><td class="dor mini4">'.$row['dorsal'];
	if($row['ss']!=0)
			echo '<br><span class="negrita">SR</span>';
		else
			echo '</td>';
		if($copiloto!=''){
				if($row['copiloto2']!='' || $row['copiloto2']!=0)
					echo '<td class="con mini1"><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['con_nac1'].'">'.$row['competidor'].'</p><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac1'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac2'].'">'.acortar_nombre($row['piloto']).'</p><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$copi_nac1.'"><img class="banderas" src="http://codea.es/coda2019/'.$copi_nac2.'">'.acortar_nombre($row['copiloto']).'</p><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['copi2_nac1'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['copi2_nac2'].'">'.acortar_nombre($row['copiloto2']).'</p></td>';
				else
					echo '<td class="con mini1"><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['con_nac2'].'">'.$row['competidor'].'</p><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac1']	.'"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac2'].'">'.acortar_nombre($row['piloto']).'</p><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['copi_nac1'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['copi_nac2'].'">'.acortar_nombre($row['copiloto']).'</p></td>';
			}
		else
			echo '<td class="con mini1"><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['con_nac1'].'">'.$row['competidor'].'<img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac2'].'">'.acortar_nombre($row['piloto']).'<br></td>';
	echo	'<td class="cla">'.escudo($row['vehiculo']).'</td><td><span class="veh mini3">'.$row['vehiculo'].' '.$row['modelo'].'</span>
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
	<br>
	<!--tablas para moviles, una arriba y otra abajo, HAY Q FORMATEAR LOS NOMBRES!!!!!!!!!!--> 
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
		if(strlen($mejor_tiempo_acumulado)>9){
			$dif_acu_primero = milisegundos_a_tiempo(tiempo_a_milisegundos($row['acu_hasta']) - tiempo_a_milisegundos($mejor_tiempo_acumulado));
			$dif_acu_anterior = milisegundos_a_tiempo(tiempo_a_milisegundos($row['acu_hasta']) - tiempo_a_milisegundos($tiempo_acu_anterior));
			}
		else{
			$dif_acu_primero = milisegundos_a_tiempo(tiempo_a_milisegundos("00:".$row['acu_hasta']) - tiempo_a_milisegundos("00:".$mejor_tiempo_acumulado));
			$dif_acu_anterior = milisegundos_a_tiempo(tiempo_a_milisegundos("00:".$row['acu_hasta']) - tiempo_a_milisegundos("00:".$tiempo_acu_anterior));
			}
	echo '<tr class="'.$classcss.'"><td class="pos negrita mini4">'.$pos.'</td>';
		
			if($variacion==0)
				echo "<td></td>";
			if($variacion<0)
				echo "<td class='variacion_verde centro mini4'>".$variacion."</td>";
			if($variacion>0)
				echo "<td class='variacion_rojo centro mini4'>+".$variacion."</td>";

		
	echo '<td class="dor mini4">'.$row['dorsal'];
	if($row['ss']!=0)
			echo '<br><span class="negrita">SR</span>';
		else
			echo '</td>';
		if($copiloto!=''){
				if($row['copiloto2']!='' || $row['copiloto2']!=0)
					echo '<td class="con mini1"><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['con_nac1'].'">'.$row['competidor'].'</p><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac1'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac2'].'">'.acortar_nombre($row['piloto']).'</p><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$copi_nac1.'"><img class="banderas" src="http://codea.es/coda2019/'.$copi_nac2.'">'.acortar_nombre($row['copiloto']).'</p><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['copi2_nac1'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['copi2_nac2'].'">'.acortar_nombre($row['copiloto2']).'</p></td>';
				else
					echo '<td class="con mini1"><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['con_nac1'].'">'.$row['competidor'].'</p><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac1']	.'"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac2'].'">'.acortar_nombre($row['piloto']).'</p><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['copi_nac1'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['copi_nac2'].'">'.acortar_nombre($row['copiloto']).'</p></td>';
			}
		else
			echo '<td class="con mini1"><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['con_nac1'].'">'.$row['competidor'].'<img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac2'].'">'.acortar_nombre($row['piloto']).'<br></td>';
	echo '<td class="cla">'.escudo($row['vehiculo']).'</td><td><span class="veh mini3">'.$row['vehiculo'].' '.$row['modelo'].'</span>
		<br><span class="gru mini1">'.$row['grupo'].'('.$posicion_grupo_dorsal.') / '.$row['clase'].'('.$posicion_clase_dorsal.')</span></td>
		<td class="tie centro">';
			if($pos!=1)
				echo '<p class="anterior cursiva nomargen mini2">+'.$dif_acu_anterior.'</p><p class="negrita nomargen mini2">'.$row['acu_hasta'].'</p><p class="cursiva nomargen mini2">+'.$dif_acu_primero.'</p>';
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
		?>
					</tbody>
					</table>
	<?php					
		}	//QUITAR ACUMULADOS
		?>
	<!--!FIN DE LA VERSION DE LOS PUTOS MOVILES----------------------------->	
<?php
$afec = mysql_num_rows($resultado);
//if($afec!=0){	?>				
	<table width="100%" border="0" class="top" id="des_gran"> <!--!evitar descuadre ESTA ES LA ---------------VERSION NORMAL PANTALLAS GRANDES-->
	<tr>
		<td>
			TIEMPOS:<br>
			<table border="0" width="100%" id="tab_tem">
				<thead>
				<tr>
		<?php
			if($no_concursante==1)
				echo "<th>P.</th><th>N.</th><th>Equipo</th><th colspan='2'>Vehiculo<br>Grupo/Clase</th><th class='centro tie'><p class='anterior cursiva nomargen'>Anterior</p><p class='negrita nomargen'>Tiempo</p><p class='anterior cursiva nomargen'>Primero</p><p><span class='penalizaciones nomargen'>Penalizacion</span></th>";
			else
				echo "<th>P.</th><th>N.</th><th colspan='2'>Concursante</th><th>Equipo</th><th colspan='2'>Vehiculo<br>Grupo/Clase</th><th class='centro tie'><p class='anterior cursiva nomargen'>Anterior</p><p class='negrita nomargen'>Tiempo</p><p class='anterior cursiva nomargen'>Primero</p><p><span class='penalizaciones nomargen'>Penalizacion</span></th>";
			?>
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
	$tiempo = $row['tiempo'];
	if($idManga=='1')//ÑAPA NUEVA PARA DEJAR A LA DECIMA
		$tiempo = substr ($tiempo, 0, strlen($tiempo) - 2)."00";
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
			if(strlen($mejor_tiempo_tramo)>9){
				$dif_primero = milisegundos_a_tiempo(tiempo_a_milisegundos($row['tiempo']) - tiempo_a_milisegundos($mejor_tiempo_tramo));
				$dif_anterior = milisegundos_a_tiempo(tiempo_a_milisegundos($row['tiempo']) - tiempo_a_milisegundos($tiempo_anterior));
				}
			else{
				$dif_primero = milisegundos_a_tiempo(tiempo_a_milisegundos("00:".$row['tiempo']) - tiempo_a_milisegundos("00:".$mejor_tiempo_tramo));
				$dif_anterior = milisegundos_a_tiempo(tiempo_a_milisegundos("00:".$row['tiempo']) - tiempo_a_milisegundos("00:".$tiempo_anterior));
				}
			if($row['con_nac1']!='')
				$nac1 = '<img class="banderas" src="http://codea.es/coda2019/'.$row['con_nac1'].'">';
			if($row['con_nac2']!='')
				$nac2 = '<img class="banderas" src="http://codea.es/coda2019/'.$row['con_nac2'].'">';
	echo '<tr class="'.$classcss.'"><td class="pos negrita">'.$pos.'</td><td class="dor">'.$row['dorsal'];
		if($row['ss']!=0)
			echo '<br><span class="negrita">SR</span>';
		else
			echo '</td>';
	if($no_concursante==0)
		echo '<td><p class="nomargen">'.$nac1.'</p><p class="nomargen">'.$nac2.'</p></td><td class="com">'.$row['competidor'].'</td>';
		if($copiloto!=''){
			if($row['copiloto2']!='' || $row['copiloto2']!=0)
				echo '<p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac1'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac2'].'">'.acortar_nombre($row['piloto']).'</p><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['copi_nac1'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['copi_nac2'].'">'.acortar_nombre($row['copiloto']).'</p><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['copi2_nac1'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['copi2_nac2'].'">'.acortar_nombre($row['copiloto2']).'</p></td>';
			else
				echo '<td class="con"><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac1'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac2'].'">'.acortar_nombre($row['piloto']).'</p><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['copi_nac1'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['copi_nac2'].'">'.acortar_nombre($row['copiloto']).'</p></td>';
			}
		else
			echo '<td class="con"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac'].'"><img class="banderas" src="http://codea.es/coda2019/'.$ow['pi_nac2'].'">'.acortar_nombre($row['piloto']).'<br></td>';
	echo '<td class="cla">'.escudo($row['vehiculo']).'</td><td><span class="veh">'.$row['vehiculo'].' '.$row['modelo'].'</span>
		<br><span class="gru">'.$row['grupo'].'('.$posicion_grupo_dorsal.') / '.$row['clase'].'('.$posicion_clase_dorsal.')</span></td>';
		if($pos!=1)
			echo '<td class="tie centro"><p class="anterior cursiva nomargen">+'.$dif_anterior.'</p><p class="negrita nomargen">'.$tiempo.'</p><p class="cursiva nomargen">+'.$dif_primero.'</p>';
		else
			echo '<td class="tie centro"><p class="negrita nomargen">'.$tiempo.'</p>';
			if($row['penalizacion']!=0)
				echo '<p><span class="penalizaciones nomargen">'.milisegundos_a_tiempo($row['penalizacion']).'</span></p></td></tr>';
			else
				echo '</td></tr>';
		$tiempo_anterior=$row['tiempo'];
		$par++;
		$pos++;
	}
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
				<?php
			if($no_concursante==1)
				echo "<th colspan='2'>Pos</th><th>dorsal</th><th>Equipo</th><th colspan='2'>Vehiculo<br>Grupo/Clase</th><th class='centro tie'><p class='anterior cursiva nomargen'>Anterior</p><p class='negrita nomargen'>Tiempo</p><p class='anterior cursiva nomargen'>Primero</p><p><span class='penalizaciones nomargen'>Penalizacion</span></th>";
			else
				echo "<th colspan='2'>Pos</th><th>dorsal</th><th colspan='2'>Concursante</th><th>Equipo</th><th colspan='2'>Vehiculo<br>Grupo/Clase</th><th class='centro tie'><p class='anterior cursiva nomargen'>Anterior</p><p class='negrita nomargen'>Tiempo</p><p class='anterior cursiva nomargen'>Primero</p><p><span class='penalizaciones nomargen'>Penalizacion</span></th>";
			?>
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
		//echo $row['grupo'];
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
						//echo $row['grupo'];
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
			if(strlen($mejor_tiempo_acumulado)>9){
				$dif_acu_primero = milisegundos_a_tiempo(tiempo_a_milisegundos($row['acu_hasta']) - tiempo_a_milisegundos($mejor_tiempo_acumulado));
				$dif_acu_anterior = milisegundos_a_tiempo(tiempo_a_milisegundos($row['acu_hasta']) - tiempo_a_milisegundos($tiempo_acu_anterior));
				}
			else{
				$dif_acu_primero = milisegundos_a_tiempo(tiempo_a_milisegundos("00:".$row['acu_hasta']) - tiempo_a_milisegundos("00:".$mejor_tiempo_acumulado));
				$dif_acu_anterior = milisegundos_a_tiempo(tiempo_a_milisegundos("00:".$row['acu_hasta']) - tiempo_a_milisegundos("00:".$tiempo_acu_anterior));
			}
	echo '<tr class="'.$classcss.'"><td class="pos negrita">'.$pos.'</td>';
		
			if($variacion==0)
				echo "<td></td>";
			if($variacion<0)
				echo "<td class='variacion_verde centro'>".$variacion."</td>";
			if($variacion>0)
				echo "<td class='variacion_rojo centro'>+".$variacion."</td>";
			if($row['con_nac1']!='')
				$nac1 = '<img class="banderas" src="http://codea.es/coda2019/'.$row['con_nac1'].'">';
			if($row['con_nac2']!='')
				$nac2 = '<img class="banderas" src="http://codea.es/coda2019/'.$row['con_nac2'].'">';
		
	echo '<td class="dor">'.$row['dorsal'];
	if($row['ss']!=0)
			echo '<br><span class="negrita">SR</span>';
		else
			echo '</td>';
		if($no_concursante==0)
			echo '<td><p class="nomargen">'.$nac1.'</p><p class="nomargen">'.$nac2.'</p></td><td class="com">'.$row['competidor'].'</td>';
		if(copiloto!=''){
			if($row['copiloto2']!='' || $row['copiloto2']!=0)
				echo '<p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac1'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac2'].'">'.acortar_nombre($row['piloto']).'</p><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['copi_nac1'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['copi_nac2'].'">'.acortar_nombre($row['copiloto']).'</p><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['copi2_nac1'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['copi2_nac2'].'">'.acortar_nombre($row['copiloto2']).'</p></td>';
			else
				echo '<td class="con"><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac1'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac2'].'">'.acortar_nombre($row['piloto']).'</p><p class="nomargen"><img class="banderas" src="http://codea.es/coda2019/'.$row['copi_nac1'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['copi_nac2'].'">'.acortar_nombre($row['copiloto']).'</p></td>';
			}
		else
			echo '<td class="con"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac'].'"><img class="banderas" src="http://codea.es/coda2019/'.$ow['pi_nac2'].'">'.acortar_nombre($row['piloto']).'<br></td>';
	echo '<td class="cla">'.escudo($row['vehiculo']).'</td><td><span class="veh">'.$row['vehiculo'].' '.$row['modelo'].'</span>';
		//<br><span class="gru">'.$row['grupo'].'('.$posicion_grupo_dorsal.') / '.$row['clase'].'('.$posicion_clase_dorsal.')</span></td>
		echo '<br><span class="gru">'.$row['grupo'].'/ '.$row['clase'].'</span></td>
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
		?>
					</tbody>	
			</table>
						<?php
		} //QUITAR LOS ACUMULADOS EN MANGAS ENTRENAMIENTOS
			?>
		</td>
	</tr>
</table>
			<?php
	unset($ordenar);
	unset($aux);
	}
}
	?>
<br>
<p>PENALIZACIONES</p>
<table border="0" width="100%" id="tab_tem">
				<thead>
				<tr>
					<th>dorsal</th><th>Concursante</th><th>Equipo</th><th>Vehiculo</th><th>Control</th><th>Descripcion</th><th>Tiempo</th>
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
					<th>dorsal</th><th>Concursante</th><th>Equipo</th><th>Vehiculo</th><th>Grupo</th><th>Clase</th><th>Raz&oacute;n</th>
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


