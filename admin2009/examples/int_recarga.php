<?php
//TIPO 3, SUMa DE TODAS LAS MANGA OFICIALES
include("conexion.php");
include("includes/funcionesTiempos.php");
include("escudos.php");
if(isset($_GET["copa"]))
			$copa = $_GET["copa"];
		else
			$copa = '0';
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
	if($copa=='0')
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
	else
		echo "MANDA COPA";
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
				$mimanga=$id_primera_manga+$maxMangas;
				$ta_s=0;
				$ta_l=0;
				$t_pa=0;
				$cont=0;
					while($mimanga != $id_primera_manga-1)
						{
						//BUSCO PRIMERO EN LAS MANGAS Y ACUMULO
						$acum = mysql_query("SELECT ch.orden AS orden,t.tiempo FROM abc_57os_ca_tiempo t 
						INNER JOIN abc_57os_ca_manga_control_horario ch ON ch.id=t.id_ca_manga_control_horario 
						INNER JOIN abc_57os_ca_manga m ON ch.id_ca_manga=m.id 
						WHERE t.dorsal='$dorsal' AND t.id_ca_manga='$mimanga' AND m.tipo!=0");
							if(mysql_num_rows($acum)==2)//2 TIEMPOS, LLEGADA
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
//PASO A CALCULAR LAS POSICIONES SEGUN TIEMPO LLEGADA
						if($cont==$maxMangas){  //HA COMPETIDO EN TODAS LAS MANGAS
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
								'competidor' =>$competidor);
								}
			}
		}
	?>
	<table border="0" width="100%" id="tab_tem">
				<thead>
				<tr>
					<th width='10%'>Pos</th><th width='10%'>dorsal</th><th width='30%'>Concursante</th><th>Equipo</th><th width='20%' colspan="2">Vehiculo<br>Grupo/Clase</th><th width='10%'>Anterior<br>Tiempo<br>Primero<br>Penalizacion</th>
				</tr>
				</thead>
					<tbody>
	<?php
	$par=0;
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
			echo "<tr class='".$classcss."'><td class='pos negrita'>".$pos."</td><td class='dor'>".$row['dorsal']."</td>
			<td class='com'>".$row['competidor']."</td>
	<td class='con'><img class='banderas' src='http://codea.es/coda2019/".$pi_nac."'>".acortar_nombre($row['piloto'])."<br>
	<img class='banderas' src='http://codea.es/coda2019/".$co_nac."'>".acortar_nombre($row['copiloto'])."</td>
	<td class='cla'>".escudo($row['vehiculo'])."</td>
	<td><span class='veh'>".$row['vehiculo']." ".$row['modelo']."</span>
	<br><span class='gru'>".$row['grupo']."(".$posicion_grupo_dorsal.") / ".$row['clase']."(".$posicion_clase_dorsal.")</span></td>
	<td>".$row['acu_hasta']."</td></tr>";
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


