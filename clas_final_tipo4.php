<?php
//TIPO 4, SUMa DE LAS 3 MEJORES OFICIALES
include("conexion.php");
include("includes/funcionesTiempos.php");
include("escudos.php");
if(isset($_GET["campeonato"]))
			$campeonato = $_GET["campeonato"];
		else
			$campeonato = '0';
	$numMangas = mysql_query("SELECT m.id as idmanga,m.descripcion AS nom_manga FROM abc_57os_ca_carrera c
	INNER JOIN abc_57os_ca_etapa e ON c.id=e.id_ca_carrera
	INNER JOIN abc_57os_ca_seccion s ON e.id=s.id_ca_etapa
	INNER JOIN abc_57os_ca_manga m ON s.id=m.id_ca_seccion
	WHERE c.id='$idCarrera' AND m.tipo=1");  //mangas de tipo oficial tipo=1
	if(mysql_num_rows($numMangas)==0)
		echo "Aun no se ha publicado la Clasificaci&oacute;n Final";
	else{
		$i=1;
		while($fila=mysql_fetch_array($numMangas))
			{
			$nom_manga[$i]=$fila['nom_manga'];
			$i++;
			}
		$id_primera_manga = @mysql_result($numMangas, 0, "idmanga");
		$maxMangas = mysql_num_rows($numMangas);
		$idultima = mysql_query("SELECT MAX(m.id) AS maxid FROM abc_57os_ca_carrera c
			INNER JOIN abc_57os_ca_etapa e ON c.id=e.id_ca_carrera
			INNER JOIN abc_57os_ca_seccion s ON e.id=s.id_ca_etapa
			INNER JOIN abc_57os_ca_manga m ON s.id=m.id_ca_seccion
			WHERE c.id='$idCarrera' AND m.tipo=1");
		$id_ultima_manga = @mysql_result($idultima, 0, "maxid");
		}
	//echo "NUM: ".$maxMangas."MANGA1: ".$id_primera_manga;
	if($campeonato=='0')
	{
	$sql = "SELECT com.id AS idconcursante, m.tipo AS tipo_manga,m.numero AS num_manga,com.dorsal,pi.nombre AS piloto_nombre,co.nombre AS copiloto_nombre,
	con.nombre AS competidor,
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
	WHERE car.id='$idCarrera' AND com.autorizado=1 GROUP BY dorsal";
	}
	else{
		$sql = "SELECT com.id AS idconcursante, m.tipo AS tipo_manga,m.numero AS num_manga,com.dorsal,pi.nombre AS piloto_nombre,co.nombre AS copiloto_nombre,
	con.nombre AS competidor,
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
	INNER JOIN abc_57os_ca_campeonato_competidor ccm ON ccm.id_ca_competidor=com.id
	WHERE m.id='$idManga' AND ccm.id_ca_campeonato='$campeonato' AND com.autorizado=1 GROUP BY dorsal";
	}
$resultado = mysql_query($sql) or print "No se pudo acceder al contenido de los tiempos online.";
if(mysql_num_rows($resultado)>0)
		{
		while($fila=mysql_fetch_array($resultado))
			{
			$dorsal = $fila['dorsal'];
			$competidor = $fila['competidor'];
			$piloto = $fila['piloto_nombre'];
			$copiloto = $fila['copiloto_nombre'];
			$vehiculo = $fila['marca'];
			$modelo = $fila['modelo'];
			$grupo = $fila['grupo'];
			$clase = $fila['clase'];
			$idcomp = $fila['idcompetidor'];
			$pi_nac = bandera($fila['pi_nac']);
			$co_nac = bandera($fila['co_nac']);
			$num_manga = $fila['num_manga'];
			$tipo_manga = $fila['tipo_manga'];
			$idconcursante = $fila['idconcursante'];
				$mimanga=$id_primera_manga;
				$ta_s=0;
				$ta_l=0;
				$t_pa=0;
				$cont=1;
				$mejor_manga1=9999999999999;
				$mejor_manga2=9999999999999;
				$mejor_manga3=9999999999999;
					while($mimanga != $id_ultima_manga+1)
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
									$t_s = tiempo_a_milisegundos($fil['tiempo']);
									}
								if($orden==10){//ES LLEGADA
									$t_l = tiempo_a_milisegundos($fil['tiempo']);
									}
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
						$t_manga = $t_l-$t_s;
							if($t_manga<$mejor_manga1)
								{
								$mejor_manga1=$t_manga;
								$n_mejor_manga1=$cont;
								}
							else{ if($t_manga<$mejor_manga2){
								$mejor_manga2=$t_manga;
								$n_mejor_manga2=$cont;
									}
									else{ if($t_manga<$mejor_manga3){
										$mejor_manga3=$t_manga;
										$n_mejor_manga3=$cont;
											}
										}
								}
						$tiempo_manga[$cont]=milisegundos_a_tiempo($t_l-$t_s);
						$cont++;
						$mimanga++;						
						}
						
			/*$c_pen = mysql_query("SELECT tiempo FROM abc_57os_ca_penalizacion WHERE id_ca_manga='$idManga' AND dorsal='$dorsal'");
				if(mysql_num_rows($c_pen)>0)//lo recorro por si tiene mas de una penalizacion en la misma MANGA
					{
					$pen=0;
					while($rowp=mysql_fetch_array($c_pen))
						$pen+=$rowp['tiempo'];
					}
				else
					$pen=0;*/
				$t_pam = segundos_a_milisegundos($t_pa);
				$tiempo = tiempo_a_milisegundos($t_l)-tiempo_a_milisegundos($t_s)+segundos_a_milisegundos($pen);
				$t_p=segundos_a_milisegundos($pen);
				$tat = $ta_l-$ta_s; //tiempo acumulado en las mangas anteriores, lo sumamos a la actual
				$tat += (tiempo_a_milisegundos($t_l)-tiempo_a_milisegundos($t_s)+segundos_a_milisegundos($pen)+$t_pam);
				//echo "D:".$dorsal."M:".$cont."<br><br>";
//PASO A CALCULAR LAS POSICIONES SEGUN TIEMPO LLEGADA
 //HA COMPETIDO EN TODAS LAS MANGAS y el tiempo es >0
								$ordenar[] = array(
								'piloto' => $piloto, 
								'copiloto' => $copiloto,
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
								'idconcursante' =>$idconcursante,
								'acu_hasta' =>milisegundos_a_tiempo($tat),
								'pen_hasta'=>$t_pam+$t_p,
								'tiempo'=>milisegundos_a_tiempo($mejor_manga1+$mejor_manga2+$mejor_manga3),
								'competidor' =>$competidor,
								'manga1' =>$tiempo_manga[1],
								'manga2' =>$tiempo_manga[2],
								'manga3' =>$tiempo_manga[3],
								'manga4' =>$tiempo_manga[4],
								'manga5' =>$tiempo_manga[5],
								'manga6' =>$tiempo_manga[6],
								'manga7' =>$tiempo_manga[7],
								'manga8' =>$tiempo_manga[8],
								'manga9' =>$tiempo_manga[9],
								'manga10' =>$tiempo_manga[10],
								'manga11' =>$tiempo_manga[11],
								'n_mejor_manga1'=>$n_mejor_manga1,
								'n_mejor_manga2'=>$n_mejor_manga2,
								'n_mejor_manga3'=>$n_mejor_manga3,
								'mejor_manga1' =>milisegundos_a_tiempo($mejor_manga1),
								'mejor_manga2' =>milisegundos_a_tiempo($mejor_manga2),
								'mejor_manga3' =>milisegundos_a_tiempo($mejor_manga3),
								);
								
			}
		}
	?>
	<table border="0" width="100%" id="tab_tem">
				<thead>
				<tr>
					<th width='5%'>Pos</th><th width='5%'>dorsal</th><th width='15%'>Equipo</th><th width='20%' colspan="2">Vehiculo<br>Grupo/Clase</th>
					<?php
					for($i=1;$i<=$maxMangas;$i++){
						echo "<th class='mini1'>".$nom_manga[$i]."</th>";
						}
					?>
					<th width='10%'>Anterior<br>Tiempo<br>Primero<br>Penalizacion</th>
				</tr>
				</thead>
					<tbody>
	<?php
	$par=0;
	//echo $maxMangas;
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
			echo "<tr class='".$classcss."'><td class='pos negrita'>".$pos."</td><td class='dor'>".$row['dorsal']."</td>
	<td class='con'><img class='banderas' src='http://codea.es/coda2019/".$pi_nac."'>".acortar_nombre($row['piloto'])."<br>
	<img class='banderas' src='http://codea.es/coda2019/".$co_nac."'>".acortar_nombre($row['copiloto'])."</td>
	<td class='cla'>".escudo($row['vehiculo'])."</td>
	<td><span class='veh'>".$row['vehiculo']." ".$row['modelo']."</span>
	<br><span class='gru'>".$row['grupo']."(".$posicion_grupo_dorsal.") / ".$row['clase']."(".$posicion_clase_dorsal.")</span></td>";
		for($i=1;$i<=$maxMangas;$i++){
			$manga="manga".$i;
			if($i==$row['n_mejor_manga1'])
				echo "<td class='mini2 negrita'>".$row[$manga]."</td>";	
			else{
				if($i==$row['n_mejor_manga2'])
					echo "<td class='mini2 negrita'>".$row[$manga]."</td>";
				else{
					if($i==$row['n_mejor_manga3'])
						echo "<td class='mini2 negrita'>".$row[$manga]."</td>";
					else
						echo "<td class='mini2'>".$row[$manga]."</td>";
					}
				}
		}
	echo "<td>".$row['tiempo']."</td></tr>";
		$pos++;
		$par++;
		}
			
	?>
	</tbody>
		</table>
<br>
<br>
<br>
<br>


