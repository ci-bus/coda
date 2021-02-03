<?php
	$IPservidor = "localhost";
	$nombreBD = "codea_es_sistema";
	$usuario = "manuel";
	$clave = "coda200900==";
include("funcionesTiempos.php");
$conexion = mysql_connect($IPservidor, $usuario, $clave) or die("<h2>No hay conexi&oacute;n con el servidor MySQL</h2>");
mysql_query ("SET NAMES 'utf8'");
mysql_select_db($nombreBD) or die('no se encontro la bd');
$idManga = $_GET['idmanga'];
$sql = "SELECT m.tipo AS tipo_manga,m.numero AS num_manga,com.dorsal,pi.nombre AS piloto_nombre,
	veh.grupo AS grupo,veh.clase AS clase,veh.marca AS marca,veh.modelo As modelo,car.id AS idcarrera
	FROM abc_57os_ca_carrera car
	INNER JOIN abc_57os_ca_competidor com ON car.id=com.id_ca_carrera
	INNER JOIN abc_57os_ca_etapa e ON e.id_ca_carrera=car.id
	INNER JOIN abc_57os_ca_seccion s ON s.id_ca_etapa=e.id
	INNER JOIN abc_57os_ca_manga m ON m.id_ca_seccion=s.id
	INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto
	INNER JOIN abc_57os_ca_vehiculo veh ON veh.id=com.id_ca_vehiculo
	WHERE dorsal NOT IN (SELECT id_ca_competidor FROM abc_57os_ca_abandono WHERE id_ca_manga='$idManga') 
	AND m.id='$idManga' AND com.autorizado='1' GROUP BY dorsal";
$min= '9999999999';
$enpista = array();
$porsalir=0;
$salida=0;
$resultado = mysql_query($sql) or print "No se pudo acceder al contenido de los tiempos online. COMPROBAR CONEXION A INTERNET";
$sql_int = "SELECT descripcion FROM abc_57os_ca_manga_control_horario WHERE id_ca_manga='$idManga' AND orden!=0 AND orden!=10 ORDER BY orden";
$resultado_int = mysql_query($sql_int);
		$num_int = mysql_num_rows($resultado_int);
if(mysql_num_rows($resultado)>0)
		{
		while($fila=mysql_fetch_array($resultado))
			{
			$pen=0;
			$i1=0;
			$i2=0;
			$i3=0;
			$i4=0;
			$idCarrera = $fila['idcarrera'];
			$dorsal = $fila['dorsal'];
			$competidor = $fila['competidor'];
			$piloto = $fila['piloto_nombre'];
			$copiloto = $fila['copiloto_nombre'];
			$vehiculo = $fila['marca'];
			$modelo = $fila['modelo'];
			$grupo = $fila['grupo'];
			$clase = $fila['clase'];
			$idcomp = $fila['idcompetidor'];
			$num_manga = $fila['num_manga'];
			$tipo_manga = $fila['tipo_manga'];
			$comp = mysql_query("SELECT ch.orden AS orden,t.tiempo FROM abc_57os_ca_tiempo t 
			INNER JOIN abc_57os_ca_manga_control_horario ch ON ch.id=t.id_ca_manga_control_horario 
			WHERE t.dorsal='$dorsal' AND t.id_ca_manga='$idManga'");//COMPRUEBO Q TENGA 2  TIEMPOS salida y llegada
				if(mysql_num_rows($comp)==0)//0 PÔR SALIR
					{
					$porsalir++;
					}
				if(mysql_num_rows($comp)==1)//1 TIEMPOS, EN PISTA
					{
					$miorden = @mysql_result($comp, 0, "orden");
					if($miorden=='0' || $miorden==0)
						array_push($enpista,$dorsal);
					}
				if(mysql_num_rows($comp)>=2)//2 TIEMPOS, LLEGADA
					{
					while($fil=mysql_fetch_array($comp))
						{
						$orden = $fil['orden'];
						if($orden==0){//ES SALIDA
						$t_s = $fil['tiempo'];
							}
						if($orden==10){//ES LLEGADA
							$t_l = $fil['tiempo'];
							}
						if($orden==1){//IN1
							$i1 = milisegundos_a_tiempo(tiempo_a_milisegundos($fil['tiempo'])-tiempo_a_milisegundos($t_s));
							}
						if($orden==2){//IN2
							$i2 = milisegundos_a_tiempo(tiempo_a_milisegundos($fil['tiempo'])-tiempo_a_milisegundos($t_s));
							}
						if($orden==3){//IN3
							$i3 = milisegundos_a_tiempo(tiempo_a_milisegundos($fil['tiempo'])-tiempo_a_milisegundos($t_s));
							}
						if($orden==4){//IN4
							$i4 = milisegundos_a_tiempo(tiempo_a_milisegundos($fil['tiempo'])-tiempo_a_milisegundos($t_s));
							}	
						$salida = 1;
					}
					$c_pen = mysql_query("SELECT tiempo FROM abc_57os_ca_penalizacion WHERE id_ca_manga='$idManga' AND dorsal='$dorsal'");
					if(mysql_num_rows($c_pen)>0)//lo recorro por si tiene mas de una penalizacion en la misma MANGA
						{
						$pen=0;
						while($rowp=mysql_fetch_array($c_pen))
							$pen+=$rowp['tiempo'];
						}
					$tiempo = tiempo_a_milisegundos($t_l)-tiempo_a_milisegundos($t_s)+segundos_a_milisegundos($pen);
					if($tiempo<$min)
					{
					$min = $tiempo;
					$min_d = $dorsal;
					}
							$ordenar[] = array(
								'dorsal'=>$dorsal,
								'tiempo'=>milisegundos_a_tiempo($tiempo),//PASAR AQUI A MILISEGUNDOS
								'i1'=>$i1,
								'i2'=>$i2,
								'i3'=>$i3,
								'vehiculo'=>$vehiculo,
								'modelo'=>$modelo,
								'categoria'=>$categoria,
								'clase'=>$clase,
								'penalizacion'=>$pen,
								'tipo'=>$tipo,
								'hora'=>$hora,
								'competidor' =>$competidor);
					}
			}
	}
if($min=='9999999999')
	{
	$min = "--:'':''.---";
	$min_d = '--';
	}
$long=count($enpista);
?>
			<div id="header">
				<div id="logo"><img class="logo" src="logo.png"></div>
				<div id="primero">
					<div id="ult_tiempo"><span class="blanco t6 fuente">POR SALIR: </span><span class="fuente2 rojo"><?php echo $porsalir;?></span></div>
					<div id="num_enpista"><span class="blanco t6 fuente">EN PISTA: </span><span class="fuente2 rojo"><?php echo $long;?></span></div>
					<div id="tiempo1" class="fuente1">
						<span class="blanco">N.<?php echo $min_d;?>: </span>
						<span class="verde">
						<?php echo milisegundos_a_tiempo($min);?>
						</span>
					</div>
				</div>	
				<div id="dor_pista">
				<?php
						//echo "<p class='blanco'>".$long."</p>";
					for($i=0;$i<$long;$i++){
						echo "<div class='enpista fuente verde t1'>".$enpista[$i]."</div>";
						}
				?>
					<!--div class='enpista fuente verde t1'>12</div-->
				</div>
			</div>
			<div id="content">
<?php
			
$min = '99:99:99.999';
	if($salida==0)
	{
	echo "<p class='t5 blanco fuente centro'>ESPERANDO LLEGADA DEL PRIMER DORSAL...</p><br>";
	echo "<p class='t5 blanco fuente centro'>SIGUENOS EN NUESTRAS REDES SOCIALES</p>";
	echo "<p class='t7 blanco fuente centro'>WWW.codea.es</p><br>";
	}
	else{
		echo "<table width='100%' border='1' ><tr style='vertical-align:top'><td>";
			echo "<table border='0'><tr>TIEMPOS";			
					//MOSTRAMOS EN PANTALLA:
					foreach ($ordenar as $key => $row) 
						{
						$aux[$key] = $row['tiempo'];
						}
						array_multisort($aux, SORT_ASC, $ordenar);
						$pos=1;
						foreach ($ordenar as $key => $row) 
						{
						if($row['tiempo']<$min)
							{
							$min = $row['tiempo'];
							$min_d = $row['dorsal'];
							}
						if($row['penalizacion']>0)
							$class = 'rojo';
						else
							$class = 'amarillo';
						echo "<tr class='fuente'><td class='blanco t4 negrita'>".$pos."</td><td class='todos_tiempos ".$class." t2'>N.".$row['dorsal']." :".$row['tiempo'];
							if($num_int>0)
							{
							echo "<p class='nomargen blanco t3'>";
							for($i=1;$i<=$num_int;$i++)
								{
								$int = "i".$i;
									if(tiempo_a_milisegundos($row[$int])>0)
										echo $row[$int]." ";
									else
										echo " --- ";
								}
							echo "</p>";
							}
						echo "</td>";
						//echo "<td class='amarillo t3'>".$row['piloto']."<br>".$row['copiloto']."</td></td>";
						echo "</tr>";
							$pos++;
						if($num_int>0){
							if($pos==12 || $pos==23 || $pos==34)
							echo "</tr></table></td><td><table><tr>";
							}
						else{
							if($pos==16 || $pos==31 || $pos==46)
								echo "</tr></table></td><td><table><tr>";
							}
						}
	
		}
		//PASAMOS A CALCULAR LOS ACUMULADOS
	unset($ordenar);
	unset($aux);
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
			
	echo "</td></tr></table><td><table><tr><td class='t3 blanco fuente'>CLAS.GENERAL</td></tr>";
	$campeonatos_carrera = mysql_query("SELECT * FROM abc_57os_ca_campeonato WHERE id_ca_carrera='$idCarrera'");
	while($mifila=mysql_fetch_array($campeonatos_carrera))
		{
		$nom = strtoupper($mifila['nombre']);
		$id_campeonato = $mifila['id'];
		echo "<tr><td class='t3 blanco fuente centro'>".$nom."</td></tr>";
		
		$resultado = mysql_query($sql) or print "No se pudo acceder al contenido de los tiempos online.";
		if(mysql_num_rows($resultado)>0)
				{
				while($fila=mysql_fetch_array($resultado))
					{
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
			$dorsal = $fila['dorsal'];
			$idcomp = $fila['idcompetidor'];
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
						if($manga_competida>=2) // CONDICION SI HA COMPETIDO 2 de LAS 3 OFICIALES
						{
								echo "<tr class='blanco fuente t3'><td>".$dorsal.": .".milisegundos_a_tiempo($tiempo)."</td></tr>";
								$ordenar[] = array(
								'dorsal'=>$dorsal,	
								'tiempo'=>$tiempo_manga[$cont],
								);
						}
						
						}
				}
			}
		
		}
	
	echo "</table>";
echo "</table>";
?>
