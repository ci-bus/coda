<?php
//TIPO 1, MEJOR DE 2 MANGAS OFICIALES
include("conexion.php");
include("includes/funcionesTiempos.php");
include("escudos.php");
$ninguno=0;
if(isset($_GET["copa"]))
			$copa = $_GET["copa"];
		else
			$copa = '0';
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
	$saber_copis = mysql_query("SELECT id_ca_copiloto FROM abc_57os_ca_competidor WHERE id_ca_carrera='$idCarrera' AND id_ca_copiloto!=0");
		if(mysql_num_rows($saber_copis)==0)
			$copis=0;
		else
			$copis=1;
$campeonatos_carrera = mysql_query("SELECT * FROM abc_57os_ca_campeonato WHERE id_ca_carrera='$idCarrera'");
	while($mifila=mysql_fetch_array($campeonatos_carrera))
		{
		$nom = strtoupper($mifila['nombre']);
		$id_campeonato = $mifila['id'];
	if($copa=='0'){
			/*if($copis==1)
			{
			$sql = "SELECT com.id AS idconcursante, m.tipo AS tipo_manga,m.numero AS num_manga,com.dorsal,pi.nombre AS piloto_nombre,
			con.nombre AS competidor,copi.nombre AS copiloto_nombre,copi.nacionalidad AS copi_nac,
			veh.grupo AS grupo,veh.clase AS clase,veh.marca AS marca,veh.modelo As modelo,pi.nacionalidad AS pi_nac
			FROM abc_57os_ca_carrera car
			INNER JOIN abc_57os_ca_competidor com ON car.id=com.id_ca_carrera
			INNER JOIN abc_57os_ca_etapa e ON e.id_ca_carrera=car.id
			INNER JOIN abc_57os_ca_seccion s ON s.id_ca_etapa=e.id
			INNER JOIN abc_57os_ca_manga m ON m.id_ca_seccion=s.id
			INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto
			INNER JOIN abc_57os_ca_copiloto copi ON copi.id=com.id_ca_copiloto
			INNER JOIN abc_57os_ca_concursante con ON con.id=com.id_ca_concursante
			INNER JOIN abc_57os_ca_vehiculo veh ON veh.id=com.id_ca_vehiculo
			INNER JOIN abc_57os_ca_campeonato_competidor ccm ON ccm.id_ca_competidor=com.id
			WHERE car.id='$idCarrera' AND ccm.id_ca_campeonato='$id_campeonato' AND com.autorizado=1 GROUP BY dorsal";
			}
			else
			{*/
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
			WHERE car.id='$idCarrera' AND ccm.id_ca_campeonato='$id_campeonato' AND com.autorizado=1 GROUP BY dorsal";
			//}
	}else{
			if($copis==1)
			{
			$sql = "SELECT com.dorsal,cc.id_ca_campeonato,ve.marca,ve.modelo,pi.nombre AS piloto_nombre,com.id,ve.grupo,ve.clase,pi.nacionalidad AS pi_nac,con.nombre AS competidor,
			copi.nombre AS copiloto_nombre
			FROM abc_57os_ca_competidor com 
			INNER JOIN abc_57os_ca_copa_competidor cocom ON com.id=cocom.id_ca_competidor 
			INNER JOIN abc_57os_ca_piloto pi ON com.id_ca_piloto = pi.id 
			INNER JOIN abc_57os_ca_copiloto copi ON com.id_ca_copiloto = copi.id 
			INNER JOIN abc_57os_ca_vehiculo ve ON ve.id=com.id_ca_vehiculo 
			INNER JOIN abc_57os_ca_campeonato_competidor cc on cc.id_ca_competidor=com.id
			INNER JOIN abc_57os_ca_concursante con ON con.id=com.id_ca_concursante
			WHERE com.id_ca_carrera = '$idCarrera' AND cocom.id_ca_copa='$copa' AND cc.id_ca_campeonato='$id_campeonato'";
			}
			else
			{
			$sql = "SELECT com.dorsal,cc.id_ca_campeonato,ve.marca,ve.modelo,pi.nombre AS piloto_nombre,com.id,ve.grupo,ve.clase,pi.nacionalidad AS pi_nac,con.nombre AS competidor
			FROM abc_57os_ca_competidor com 
			INNER JOIN abc_57os_ca_copa_competidor cocom ON com.id=cocom.id_ca_competidor INNER JOIN abc_57os_ca_piloto pi ON com.id_ca_piloto = pi.id 
			INNER JOIN abc_57os_ca_vehiculo ve ON ve.id=com.id_ca_vehiculo INNER JOIN abc_57os_ca_campeonato_competidor cc on cc.id_ca_competidor=com.id
			INNER JOIN abc_57os_ca_concursante con ON con.id=com.id_ca_concursante
			WHERE com.id_ca_carrera = '$idCarrera' AND cocom.id_ca_copa='$copa' AND cc.id_ca_campeonato='$id_campeonato'"; 	
			}
	/*$sql = "SELECT com.id AS idconcursante, m.tipo AS tipo_manga,m.numero AS num_manga,com.dorsal,pi.nombre AS piloto_nombre,
	con.nombre AS competidor,
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
	INNER JOIN abc_57os_ca_copa_competidor cocom ON cocom.id_ca_competidor = com.id
	WHERE car.id='$idCarrera' AND ccm.id_ca_campeonato='$id_campeonato' AND com.autorizado=1 AND cocom.id='$copa' GROUP BY dorsal";*/
	}
	echo "<br><p class='negrita centro fu1'>".$nom."</p><br>";
	
$resultado = mysql_query($sql) or print "No se pudo acceder al contenido de los tiempos - online.";
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
				$t_s=0;
				$t_l=0;
				$t_pa=0;
				$cont=0;
				$mejor_manga1=9999999999999;
				$mejor_manga2=9999999999999;
				$manga_competida=0;
					while($mimanga != $id_ultima_manga+1)
						{
						//BUSCO PRIMERO EN LAS MANGAS Y ACUMULO
						$sql_acum = "SELECT ch.orden AS orden,t.tiempo,m.descripcion AS des FROM abc_57os_ca_tiempo t 
						INNER JOIN abc_57os_ca_manga_control_horario ch ON ch.id=t.id_ca_manga_control_horario 
						INNER JOIN abc_57os_ca_manga m ON ch.id_ca_manga=m.id 
						WHERE t.dorsal='$dorsal' AND t.id_ca_manga='$mimanga' AND m.tipo!=0 AND t.id_ca_carrera='$idCarrera'";
						$acum = mysql_query($sql_acum);
							if(mysql_num_rows($acum)>0)
								{
								$cont++;
								$t_s=0;
							$t_l=0;
								}
							if(mysql_num_rows($acum)>=2)//2 TIEMPOS, LLEGADA y SALiDA
							{
							$abandono = mysql_query("SELECT id FROM abc_57os_ca_abandono WHERE id_ca_manga='$mimanga' AND dorsal='$dorsal'");
							if(mysql_num_rows($abandono)==0)
								{
								$aban=0;
								$manga_competida++;
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
								else
									$aban=1;
/*if($dorsal=='115')
		echo "DORSAL:".$dorsal."--".$cont."-".milisegundos_a_tiempo($t_l-$t_s)."--".$manga_competida."AB: ".$aban."<br>";*/
				//BUSCO TB LAS PENALIZACIONES HASTA 
						$acum_pen = mysql_query("SELECT tiempo FROM abc_57os_ca_penalizacion WHERE id_ca_manga='$mimanga' AND dorsal='$dorsal'");
							if(mysql_num_rows($acum_pen)>0)//lo recorro por si tiene mas de una penalizacion en la misma MANGA
								{
								$t_pa=0;
									while($rowpa=mysql_fetch_array($acum_pen))
										$t_pa+=$rowpa['tiempo']; //tiempo en segundos
								}
							else
								$t_pa=0;
				// BUSCO SI HA ABANDONADO EN UNA MANGA OFICIAL
						if($t_s==0 || $t_l==0 || $aban==1)
							$t_manga=0;
						else
							$t_manga = $t_l-$t_s+segundos_a_milisegundos($t_pa);
					
							if($cont==1)
								{
									if($t_manga!=0)
									{
									$mejor_manga1=$t_manga;
									$n_mejor_manga1=$cont;
									}
								}
							else{
								if($t_manga!=0)
									{
									if($t_manga<$mejor_manga1)
										{
										$mejor_manga1=$t_manga;
										$n_mejor_manga1=$cont;
										}
									}
								}
							}
						if($t_s==0 || $t_l==0 || $aban==1)
							$tiempo_manga[$cont]=milisegundos_a_tiempo(0);
						else
							$tiempo_manga[$cont]=milisegundos_a_tiempo($t_l-$t_s+segundos_a_milisegundos($t_pa));
						$pen_manga[$cont]=segundos_a_milisegundos($t_pa);
						$mimanga++;						
						}
//PASO A CALCULAR LAS POSICIONES SEGUN TIEMPO LLEGADA
						if($manga_competida>=2) // CONDICION SI HA COMPETIDO 2 de LAS 3 OFICIALES
						{
								$ordenar[] = array(
								'piloto' => $piloto, 
								'copiloto' => $copiloto,
								'dorsal'=>$dorsal,
								'vehiculo'=>$vehiculo,
								'modelo'=>$modelo,
								'grupo'=>$grupo,
								'clase'=>$clase,
								'penalizacion'=>$pen_manga[1]+$pen_manga[2],
								'tipo'=>$tipo,
								'hora'=>$hora,
								'pi_nac' =>$pi_nac,
								'co_nac' =>$co_nac,
								'idconcursante' =>$idconcursante, 	
								'tiempo'=>$mejor_manga1,
								'competidor' =>$competidor,
								'manga1' =>$tiempo_manga[1],
								'manga2' =>$tiempo_manga[2],
								'p_manga1' =>$pen_manga[1],
								'p_manga2' =>$pen_manga[2],
								'n_mejor_manga1'=>$n_mejor_manga1,
								'mejor_manga1' =>milisegundos_a_tiempo($mejor_manga1),
								);
						}
			}
		}
		
//aqui generar tablas de nuevo
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
					<th width='10%'>Anterior<br>Tiempo<br>Primero</th>
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
		$mejor_tiempo=0;
		foreach ($ordenar as $key => $row) {
			if($pos==1)
				$mejor_tiempo=$row['tiempo'];
			$dif_primero=$row['tiempo']-$mejor_tiempo;
			$dif_anterior=$row['tiempo']-$tiempo_anterior;
			if($par%2==0)
				$classcss="filapar";
			else
				$classcss="filaimpar";
			echo "<tr class='".$classcss."'><td class='pos negrita'>".$pos."</td><td class='dor'>".$row['dorsal']."</td>
	<td class='con'>".$competidor."<br><img class='banderas' src='http://codea.es/coda2019/".$pi_nac."'>".$row['piloto'];
	if($copis==1)
		echo "<br><img class='banderas' src='http://codea.es/coda2019/".$copi_nac."'>".$row['copiloto']."</td>";
	else
		echo "</td>";
	echo "<td class='cla'>".escudo($row['vehiculo'])."</td>
	<td><span class='veh'>".$row['vehiculo']." ".$row['modelo']."</span>
	<br><span class='gru'>".$row['grupo']."(".$posicion_grupo_dorsal.") / ".$row['clase']."(".$posicion_clase_dorsal.")</span></td>";
		for($i=1;$i<=$maxMangas;$i++){
			$manga="manga".$i;
			$pmanga="p_manga".$i;
			if($i==$row['n_mejor_manga1'])
				echo "<td class='negrita'>".$row[$manga];	
			else{
				if($i==$row['n_mejor_manga2'])
					echo "<td class='negrita'>".$row[$manga];
				else{
					if($row[$manga]=='00:00.000' || $row[$manga]=='00:00:00.000')
						echo "<td>---";
					else
						echo "<td>".$row[$manga];
					}
				}
				/*if($row[$pmanga]>0)
					echo "<p><span class='penalizaciones nomargen'>".milisegundos_a_tiempo($row[$pmanga])."</span></p>";*/
			echo "</td>";
		}
		if($pos==1)
			echo "<td><p class='negrita'>".milisegundos_a_tiempo($row['tiempo'])."</p>";
		else	
			echo "<td><p class='cursiva'>+".milisegundos_a_tiempo($dif_anterior)."</p><p class='negrita'>".milisegundos_a_tiempo($row['tiempo'])."</p><p class='cursiva'>+".milisegundos_a_tiempo($dif_primero)."</p>";
		/*if($row['penalizacion']>0)
				echo "<p><span class='penalizaciones nomargen'>".milisegundos_a_tiempo($row['penalizacion'])."</span></p>";
		else*/
			echo "</td></tr>";
		$pos++;
		$par++;
		$tiempo_anterior=$row['tiempo'];
		}
			
	?>
	</tbody>
		</table>
	<?php
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
					$pen = mysql_query("SELECT pi.nombre AS piloto,veh.marca,veh.modelo,
					con.nombre AS concursante,p.dorsal,p.tiempo,p.motivo,p.control FROM abc_57os_ca_penalizacion p
					INNER JOIN abc_57os_ca_competidor com ON p.id_ca_competidor=com.id
					INNER JOIN abc_57os_ca_concursante con ON con.id=com.id_ca_concursante
					INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto
					INNER JOIN abc_57os_ca_vehiculo veh ON veh.id=com.id_ca_vehiculo 
					WHERE com.id_ca_carrera = '$idCarrera'
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
						echo "<tr><td colspan='7'>No existen Penalizaciones en esta Carrera</td></tr>";
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
					$pen = mysql_query("SELECT veh.grupo,veh.clase,veh.marca,veh.modelo,pi.nombre AS piloto,con.nombre AS concursante,c.dorsal,a.motivo FROM abc_57os_ca_abandono a
					INNER JOIN abc_57os_ca_competidor c ON c.id=a.id_ca_competidor 
					INNER JOIN abc_57os_ca_concursante con ON con.id=c.id_ca_concursante 
					INNER JOIN abc_57os_ca_piloto pi ON pi.id=c.id_ca_piloto
					INNER JOIN abc_57os_ca_vehiculo veh ON veh.id=c.id_ca_vehiculo 
					WHERE c.id_ca_carrera = '$idCarrera' ORDER BY c.dorsal");
					$excl = mysql_query("SELECT ve.grupo,ve.clase,con.nombre AS concursante,com.dorsal,com.excluido_motivo AS motivo,ve.marca,ve.modelo,pi.nombre AS piloto FROM abc_57os_ca_competidor com 
					INNER JOIN abc_57os_ca_vehiculo ve ON ve.id=com.id_ca_vehiculo 
					INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto
					INNER JOIN abc_57os_ca_concursante con ON con.id=com.id_ca_concursante				
					WHERE com.excluido=1 AND com.id_ca_carrera='$idCarrera' ORDER BY com.dorsal");
					if(mysql_num_rows($pen)>0){
						$ninguno=1;
						while($fila=mysql_fetch_array($pen)){
							$clase = $fila['clase'];
							$grupo = $fila['grupo'];
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
							<td>".$grupo."</td>
							<td>".$clase."</td>
							<td>".$motivo."</td></tr>";
							$par++;
							}
					}//IF
					if(mysql_num_rows($excl)>0){
						$ninguno=1;
						while($fila=mysql_fetch_array($excl)){
							$clase = $fila['clase'];
							$grupo = $fila['grupo'];
							$dorsal = $fila['dorsal'];
							$motivo = $fila['motivo'];
							$concursante = $fila['concursante'];
							$piloto = $fila['piloto'];
							$copiloto = $fila['copiloto'];
							$marca = $fila['marca'];
							$modelo = $fila['modelo'];
							$motivo = $fila['motivo'];
							if($par%2==0)
								$classcss="filapar";
							else
								$classcss="filaimpar";
							echo "<tr class='".$classcss."'><td class='dor negrita'>".$dorsal."</td>
							<td class='con'>".$concursante."</td>
							<td>".$piloto."<br>".$copiloto."</td>
							<td class='veh'>".$marca."<br>".$modelo."</td>
							<td>".$grupo."</td>
							<td>".$clase."</td>
							<td>EXCLUIDO<br>".$motivo."</td></tr>";
							$par++;
							}
					}//IF
					if($ninguno==0)
						echo "<tr><td colspan='7'>No existen Abandonos en este tramo</td></tr>";
					?>
					</tbody>
				</table>
<br>
<br>
<br>
<br>


