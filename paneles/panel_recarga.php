<?php
	$IPservidor = "localhost";
	$nombreBD = "codea_es_sistema";
	$usuario = "manuel";
	$clave = "coda200900==";
	$total = $_GET['total'];
	session_start();
	$pag = $_SESSION['pag'];
	$inicio = $_SESSION['inicio'];

include("funcionesTiempos.php");
$conexion = mysql_connect($IPservidor, $usuario, $clave) or die("<h2>No hay conexi&oacute;n con el servidor MySQL</h2>");
mysql_query ("SET NAMES 'utf8'");
mysql_select_db($nombreBD) or die('no se encontro la bd');
$idManga = $_GET['idmanga'];
$sql = "SELECT m.tipo AS tipo_manga,m.numero AS num_manga,com.dorsal,pi.nombre AS piloto_nombre,
	veh.grupo AS grupo,veh.clase AS clase,veh.marca AS marca,veh.modelo As modelo
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
		echo "<table width='100%' border='0' ><tr style='vertical-align:top'><td>";
		echo "<table><tr>";			
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
							//if($pos==12 || $pos==23 || $pos==34 || $pos==45)
							if($pos==20 || $pos==39 || $pos==58 || $pos==77 || $pos==96 || $pos==115)
							echo "</tr></table></td><td><table><tr>";
							}
						else{
							if($pos==16 || $pos==31 || $pos==46)
								echo "</tr></table></td><td><table><tr>";
							}
						}
			echo "</table>";
		}
	if($pag<$total){
		$pag+=44;
		$inicio +=44;
		$_SESSION['inicio']=$inicio;
		$_SESSION['pag']=$pag;
		}
	else{
		$pag=44;
		$inicio=0;
		$_SESSION['inicio']=$inicio;
		$_SESSION['pag']=$pag;
	}
/*	if($pag>=$total){
		$pag=44;
		$inicio = 0;
		$_SESSION['inicio']=$inicio;
		$_SESSION['pag']=$pag;
		}*/
?>
