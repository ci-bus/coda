<?php
//TIPO 3, SUMa DE TODAS LAS MANGA OFICIALES
include("conexion.php");
include("includes/funcionesTiempos.php");
include("includes/funciones.php");
include("escudos.php");
if(isset($_GET["copa"]))
			$copa = $_GET["copa"];
		else
			$copa = '0';
$idCarrera = $_GET['id'];
$idManga = $_GET['idmanga'];
$idetapa=$_GET['idetapa'];
$idseccion=$_GET['idseccion'];
$sql = "SELECT descripcion FROM abc_57os_ca_manga_control_horario WHERE id_ca_manga='$idManga' AND orden!=0 AND orden!=10 ORDER BY orden";
$resultado = mysql_query($sql);
	if(mysql_num_rows($resultado)==0)
		echo "No existen puntos Tiempos Intermedios";
	else{
		$num_int = mysql_num_rows($resultado);
		echo "<table id='tab_tem' border='0' width='100%'>
			<thead>
			<tr><th colspan='4'></th><th colspan='".$num_int."' class='centro'>PUNTOS INTERMEDIOS</th><th></th></tr>
			<tr><th>N.</th><th>EQUIPO</th><th colspan='2'>VEHICULO<br>GRUPO/CLASE</th>";
		while($row=mysql_fetch_array($resultado))
			{
			$desc = $row['descripcion'];
			echo "<th>".$desc."</th>";
			}
		echo "<th>TIEMPO</th></tr></thead>";
		}
if($copa=='0')
	{
	$sql = "SELECT com.id AS idconcursante, m.tipo AS tipo_manga,m.numero AS num_manga,com.dorsal,pi.nombre AS piloto_nombre,
	con.nombre AS competidor,com.id_ca_copiloto_segundo AS copi2,
	veh.grupo AS grupo,veh.clase AS clase,veh.marca AS marca,veh.modelo As modelo,pi.nacionalidad AS pi_nac,
	con.nacionalidad AS co_nac,com.hora_salida AS hora
	FROM abc_57os_ca_carrera car
	INNER JOIN abc_57os_ca_competidor com ON car.id=com.id_ca_carrera
	INNER JOIN abc_57os_ca_etapa e ON e.id_ca_carrera=car.id
	INNER JOIN abc_57os_ca_seccion s ON s.id_ca_etapa=e.id
	INNER JOIN abc_57os_ca_manga m ON m.id_ca_seccion=s.id
	INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto
	INNER JOIN abc_57os_ca_concursante con ON con.id=com.id_ca_concursante
	INNER JOIN abc_57os_ca_vehiculo veh ON veh.id=com.id_ca_vehiculo
	WHERE m.id='$idManga' AND com.autorizado=1 GROUP BY dorsal";
	}
	else
		echo "MANDA COPA";
$resultado = mysql_query($sql) or print "No se pudo acceder al contenido de los tiempos online.";
if(mysql_num_rows($resultado)>0)
		{
		while($fila=mysql_fetch_array($resultado))
			{
			$hora = $fila['hora'];
			$dorsal = $fila['dorsal'];
			$competidor = $fila['competidor'];
			$piloto = $fila['piloto_nombre'];
			$copi2 = $fila['copi2'];
				if($copi2!=0 || $copi2!='0' || !empty($copi2)){
			$sql_copi2 = mysql_query("SELECT copi.nombre AS copiloto,copi.nacionalidad AS nacionalidad FROM abc_57os_ca_copiloto copi 
			INNER JOIN abc_57os_ca_competidor com ON copi.id=com.id_ca_copiloto_segundo
			WHERE com.id_ca_carrera = '$idCarrera' AND com.id_ca_copiloto_segundo = '$copi2'");
				if(mysql_num_rows($sql_copi2)>0)
					$copi2 = @mysql_result($sql_copi2, 0, "copiloto");
				else
					$copi2 ='';
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
			$comp = mysql_query("SELECT ch.orden AS orden,t.tiempo FROM abc_57os_ca_tiempo t 
			INNER JOIN abc_57os_ca_manga_control_horario ch ON ch.id=t.id_ca_manga_control_horario 
			WHERE t.dorsal='$dorsal' AND t.id_ca_manga='$idManga'");//EVITO SALIDAS Y LLEGADAS
			$t_s=0;
			$t_l=0;
			$i1=0;
			$i2=0;
			$i3=0;
			$i4=0;
			$i5=0;
				if(mysql_num_rows($comp)>0)//TODOS LOS PUNTOS SALIDA,LLEGADAS E INTERM
					{
					while($fil=mysql_fetch_array($comp))
						{
						$orden = $fil['orden'];
						if($orden==0){//ES SALIDA
							$t_s = tiempo_a_milisegundos($fil['tiempo']);
							}
						if($orden==10){//ES LLEGADA
							$t_l = tiempo_a_milisegundos($fil['tiempo']);
							}
						if($orden==1){ //I1
							$i1 = tiempo_a_milisegundos($fil['tiempo']);
							}
						if($orden==2){ //I2
							$i2 = tiempo_a_milisegundos($fil['tiempo']);
							}
						if($orden==3){ //I3
							$i3 = tiempo_a_milisegundos($fil['tiempo']);
							}
						if($orden==4){ //I4
							$i4 = tiempo_a_milisegundos($fil['tiempo']);
							}
						if($orden==5){ //I5
							$i5 = tiempo_a_milisegundos($fil['tiempo']);
							}	
						}	
				if($t_l!=0)
					$tiempo = $t_l-$t_s;
				else
					$tiempo = 0;	
				$i1 = $i1-$t_s;
				$i2 = $i2-$t_s;
				$i3 = $i3-$t_s;
				$i4 = $i4-$t_s;
				$i5 = $i5-$t_s;
//PASO A CALCULAR LAS POSICIONES SEGUN TIEMPO LLEGADA
								$ordenar[] = array(
								'piloto' => $piloto, 
								'hora' => $hora, 
								'copiloto' => $copiloto,
								'copi2' => $copi2,
								'dorsal'=>$dorsal,
								'tiempo'=>$tiempo,
								'vehiculo'=>$vehiculo,
								'modelo'=>$modelo,
								'grupo'=>$grupo,
								'clase'=>$clase,
								'i1'=>$i1,
								'i2'=>$i2,
								'i3'=>$i3,
								'i4'=>$i4,
								'i5'=>$i5,
								'tipo'=>$tipo,
								'hora'=>$hora,
								'pi_nac' =>$pi_nac2,
								'co_nac' =>$copi_nac2,
								'idconcursante' =>$idconcursante,
								'competidor' =>$competidor);
					}
			}
		}
	else
		echo "No hay contenido online para mostrar...";
	
	foreach ($ordenar as $key => $row) {
	$aux[$key] = $row['hora'];
	}
	array_multisort($aux, SORT_ASC, $ordenar);
	$pos=1;
	foreach ($ordenar as $key => $row) {
		if($par%2==0)
			$classcss='filapar';
		else
			$classcss='filaimpar';
		if($pos==1){ //EL MEJOR TIEMPO......SIN DUDA ES EL PRIMErOO ;-)
					$mejor_tiempo_tramo = $row['tiempo'];
					$tiempo_anterior = $row['tiempo'];
				}

			$dif_primero = milisegundos_a_tiempo($row['tiempo']-$mejor_tiempo_tramo);
			$dif_anterior = milisegundos_a_tiempo($row['tiempo']-$tiempo_anterior);
	echo "<tr class='".$classcss."' onclick=\"window.open('inter_com_new.php?dorsal=".$row['dorsal']."&idmanga=".$idManga."&idetapa=".$idetapa."&idseccion=".$idseccion."&id=".$idCarrera."&newBD=true','_self')\"><td class='dor'>".$row['dorsal']."</td>";
	if($copiloto!=''){
			//if($row['copi2']!='' || $row['copi2']!=0)
				//echo '<td class="con"><img class="banderas" src="http://codea.es/coda2019/'.$pi_nac.'">'.acortar_nombre($row['piloto']).'<br><img class="banderas" src="http://codea.es/coda2019/'.$co_nac.'">'.acortar_nombre($row['copiloto']).'<br><img class="banderas" src="http://codea.es/coda2019/'.$co_nac.'">'.acortar_nombre($row['copi2']).'</td>';
			//else
				echo '<td class="con"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac'].'">'.acortar_nombre($row['piloto']).'<br><img class="banderas" src="http://codea.es/coda2019/'.$row['co_nac'].'">'.acortar_nombre($row['copiloto']).'</td>';
		}
	else
		echo '<td class="con"><img class="banderas" src="http://codea.es/coda2019/'.$pi_nac.'">'.acortar_nombre($row['piloto']).'</td>';
	echo '<td class="cla">'.escudo($row['vehiculo']).'</td><td><span class="veh">'.$row['vehiculo'].' '.$row['modelo'].'</span>
	<br><span class="gru">'.$row['grupo'].' / '.$row['clase'].'</span></td>';
	for($i=1;$i<=$num_int;$i++)
		{
		$int = "i".$i;
		if($row[$int]<0)
				echo '<td> - </td>';
			else
				echo '<td class="tie">'.milisegundos_a_tiempo($row[$int]).'</td>';
		}
		if($pos!=1)
			echo '<td class="tie centro"><p class="anterior cursiva nomargen">+'.$dif_anterior.'</p><p class="tie negrita nomargen">'.milisegundos_a_tiempo($row['tiempo']).'</p><p class="cursiva nomargen">+'.$dif_primero.'</p>';
		else
			echo '<td class="tie centro negrita">'.milisegundos_a_tiempo($row['tiempo']).'</td></tr>';
		$par++;
		$pos++;
		$tiempo_anterior=$row['tiempo'];
	}
	?>
	</tbody>
		</table>
<br>
<br>
<br>
<br>


