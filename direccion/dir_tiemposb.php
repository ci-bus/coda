<?php
//echo "copa--->".$_GET['copa']."manga--->".$_GET['manga'];
function atomicTime()
{
    /*** connect to the atomic clock ***/
    $fp = @fsockopen( "time-a.nist.gov", 37, $errno, $errstr, 10 );
    if ( !$fp )
    {
        throw new Exception( "$errno: $errstr" );
    }
    else
    { 
        fputs($fp, "\n"); 
        $time_info = fread($fp, 49);
        fclose($fp);
    }
    /*** create the timestamp ***/
    $atomic_time = (abs(hexdec('7fffffff') - hexdec(bin2hex($time_info)) - hexdec('7fffffff')) - 2208988800); 
    echo $errstr;
    return $atomic_time;
}
	session_start();
	include("valida2.php");
		$IPservidor = "localhost";
	$nombreBD = "codea_es_sistema";
	$usuario = "manuel";
	$clave = "coda200900==";
$modo_orden = $_GET['modo'];
$conexion = mysql_connect($IPservidor, $usuario, $clave) or die("<h2>No hay conexi&oacute;n con el servidor MySQL</h2>");
mysql_query ("SET NAMES 'utf8'");
mysql_select_db($nombreBD) or die('no se encontro la bd');
	$pass = $_SESSION['pass'];
	include_once("funcionesTiempos.php");
	include_once("nombresTildes.php");
		include('escudos.php');
	$n=0;
	$tiempo=0;
	$tiempo2=0;
		$prueba = $_GET['prueba'];
		$abandonos = array();
if(isset($_GET['manga']))
	{
	$idManga = $_GET['manga'];
	$sql = "SELECT descripcion FROM abc_57os_ca_manga_control_horario WHERE id_ca_manga='$idManga' AND orden!=0 AND orden!=10 ORDER BY orden";
	$res_int = mysql_query($sql);
	if(mysql_num_rows($res_int)>0)
		$num_inter = mysql_num_rows($res_int);
	else
		$num_inter = 0;
	/*$sql = "SELECT com.hora_salida AS hora,v.grupo,v.clase AS clase,v.marca,v.modelo,c.nombre AS competidor,ch.orden,ch.descripcion,co.nombre AS copiloto_nombre,
	pi.nombre AS piloto_nombre,pi.nacionalidad AS pi_nac,co.nacionalidad AS co_nac,
	t.tiempo,com.dorsal AS dorsal,t.id_ca_competidor AS idcompetidor
	FROM abc_57os_ca_tiempo t 
	INNER JOIN abc_57os_ca_competidor com ON com.id=t.id_ca_competidor 
	INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto 
	INNER JOIN abc_57os_ca_copiloto co ON co.id=com.id_ca_copiloto 
	INNER JOIN abc_57os_ca_manga_control_horario ch ON ch.id=t.id_ca_manga_control_horario
	INNER JOIN abc_57os_ca_concursante c ON c.id=com.id_ca_concursante
	INNER JOIN abc_57os_ca_vehiculo v on v.id=com.id_ca_vehiculo
	WHERE t.id_ca_manga='$idManga' 
	ORDER BY t.dorsal,t.tiempo";*/
	$sql = "SELECT com.dorsal,pi.nombre AS piloto_nombre,
	veh.grupo,veh.clase AS clase,veh.marca,veh.modelo,com.hora_salida AS hora
	FROM abc_57os_ca_carrera car
	INNER JOIN abc_57os_ca_competidor com ON car.id=com.id_ca_carrera
	INNER JOIN abc_57os_ca_etapa e ON e.id_ca_carrera=car.id
	INNER JOIN abc_57os_ca_seccion s ON s.id_ca_etapa=e.id
	INNER JOIN abc_57os_ca_manga m ON m.id_ca_seccion=s.id
	INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto
	INNER JOIN abc_57os_ca_vehiculo veh ON veh.id=com.id_ca_vehiculo
	WHERE m.id='$idManga' AND com.autorizado=1 ";

$resultado = mysql_query($sql) or print "No se pudo acceder al contenido de los tiempos online.";
$porsalir=0;
$enpista=0;
$llegada=0;
$t_p=0;
//FALTARA CONSULTAR EL ESTADO DE LA MANGA PARA SABER LOS RETIRADOS
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
			$hora = $fila['hora'];
			//$orden = $fila['orden'];
			$hora = $fila['hora'];
			$abandono = mysql_query("SELECT id FROM abc_57os_ca_abandono WHERE id_ca_manga='$idManga' AND dorsal='$dorsal'");
							if(mysql_num_rows($abandono)==0)
								{
								$aban=0;
								}
							else{
								$aban =1;
								array_push($abandonos,$dorsal);
								}
			$comp = mysql_query("SELECT ch.orden AS orden,t.tiempo FROM abc_57os_ca_tiempo t 
			INNER JOIN abc_57os_ca_manga_control_horario ch ON ch.id=t.id_ca_manga_control_horario 
			WHERE t.dorsal='$dorsal' AND t.id_ca_manga='$idManga'");//COMPRUEBO Q TENGA 2  TIEMPOS salida y llegada
			$tipo=0;
				if(mysql_num_rows($comp)==0)//SIN TIEMPO; POR SALIR
					{
					$t_l = "00:00:00:000";
					$t_s = "00:00:00:000";
					$porsalir++;
					$tipo= 1;
					//echo "**".$t_s;
					}
				if(mysql_num_rows($comp)>=1 && mysql_num_rows($comp)<=$num_inter+1)//1 TIEMPO (SALIDA) EN PISTA y LOS INTERMEDIOS
					{
					$enpista++;
					$t_s = @mysql_result($comp, 0, "tiempo");
					$t_l = "00:00:00:000";
					$tipo= 2;
					//echo "++".$t_s;
					}
				if(mysql_num_rows($comp)>1)//2 TIEMPOS, LLEGADA
					{
					while($fil=mysql_fetch_array($comp))
						{
							
								$orden = $fil['orden'];
								if($orden==10){//ES LLEGADA
								$t_l = $fil['tiempo'];
								$fin=1;
								$llegada++;
								$tipo= 3;
								}
								if($orden==0){//ES SALIDA
								$t_s = $fil['tiempo'];
								}
								
								if($orden==1){ //I1
									$i1 = $fil['tiempo'];
									}
								if($orden==2){ //I2
									$i2 = $fil['tiempo'];
									}
								if($orden==3){ //I3
									$i3 = $fil['tiempo'];
									}
								if($orden==4){ //I3
									$i4 = $fil['tiempo'];
									}
								if($orden==5){ //I3
									$i5 = $fil['tiempo'];
									}
						}
					}
			//if($fin==1){
				$tiempo = tiempo_a_milisegundos($t_l)-tiempo_a_milisegundos($t_s);
								$t=tiempo_a_milisegundos($t_l)-tiempo_a_milisegundos($t_s);
								//AQUI ME FALTA ASIGNAR UN TIPO PARAR MOSTRARLO TODO EN LA MISMA CONSULTA!!
//PASO A CALCULAR LAS POSICIONES SEGUN TIEMPO LLEGADA
						if($aban==0){
								$ordenar[] = array(
								'piloto' => $piloto, 
								'hora' => $hora, 
								'copiloto' => $copiloto,
								'dorsal'=>$dorsal,
								'tiempo'=>milisegundos_a_tiempo($t),
								'vehiculo'=>$vehiculo,
								'modelo'=>$modelo,
								'categoria'=>$categoria,
								'clase'=>$clase,
								'i1'=>$i1,
								'i2'=>$i2,
								'i3'=>$i3,
								'i4'=>$i4,
								'i5'=>$i5,
								'penalizacion'=>$t_p,
								'tipo'=>$tipo,
								't_s'=>$t_s,
								't_l'=>$t_l,
								'competidor' =>$competidor);
						}
					$fin=0;
			//	}
			}
$abandonados = count($abandonos,0);
echo "<table>";
echo "<tr><td class='amarillo cubos_leyenda'>".$porsalir."</td><td class='verde cubos_leyenda'>".$enpista."</td><td class='gris cubos_leyenda'>".$llegada."</td><td class='rojooo cubos_leyenda'>".$abandonados."</td><td class='azul cubos_leyenda'>0</td>";
echo "<td>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<hr>";
//REPITO LA MATRIZ POR SI HAY QUE CAMBIAR LA FORMA DE MOSTRARLOS
		
		$posicion = array();
		//EN PISTA
		foreach ($ordenar as $key => $row) {
			$aux[$key] = $row['hora'];
			if($row['t_l']>0) //ESTO LO MODIFIQUE POR SALIDA, ERA LLEGADA
			array_push($posicion,$row['dorsal']);
			/*HACER ARRAY PARA LAS POSiciones AL MISMO TIEMPO*/
		}
		array_multisort($aux, SORT_ASC, $ordenar);
		foreach ($ordenar as $key => $row) {
			//echo $row['dorsal'].' '.$row['piloto'].' '.$row['tiempo'].' '.$row['competidor'].'<br/>';
			$color = colores($row['tipo']);
			if($row['tipo']==2){
			echo "<div class='cubos ".$color."'><p class='dorsaln'>".$row['dorsal']."</p>
				<p class='nomargen t1'>EN PISTA</p>
				<p class='nomargen t2'>Hs:".$row['t_s']."</p>";
				if ($num_inter>0)
					{
					$mi_cuenta = 1;
					echo "<p class='nomargen t2'>INT: ";
					while($mi_cuenta!=$num_inter+1)
							{
								$int='i'.$mi_cuenta;
									if($row[$int]>0)
										echo "<span class='tachado'>".$mi_cuenta."</span> ";
									else
										echo "<span class='frojo'>".$mi_cuenta."</span> ";
							$mi_cuenta++;
							}
					echo "</p>";
					}
					echo "</div>";
			}
		}	
		foreach ($ordenar as $key => $row) {
			$aux[$key] = $row['hora'];
		}
		//COCHES POR SALIR:
		array_multisort($aux, SORT_ASC, $ordenar);
		foreach ($ordenar as $key => $row) {
			//echo $row['dorsal'].' '.$row['piloto'].' '.$row['tiempo'].' '.$row['competidor'].'<br/>';
			$color = colores($row['tipo']);
			if($row['tipo']==1)
			echo "<div class='cubos ".$color."'><p class='dorsaln'>".$row['dorsal']."</p><p class='negrita'>HORA TE&Oacute;RICA</p><p>".$row['hora']."</p></div>";
			$pos++;
		}
		//META
		foreach ($ordenar as $key => $row) {
			$aux[$key] = $row['tiempo'];
		}
		$posi=1;
		array_multisort($aux, SORT_ASC, $ordenar);
		foreach ($ordenar as $key => $row) {
			//echo $row['dorsal'].' '.$row['piloto'].' '.$row['tiempo'].' '.$row['competidor'].'<br/>';
			$color = colores($row['tipo']);
			$pos = array_search($row['dorsal'],$posicion)+1;
			if($row['tipo']==3){
			echo "<div class='cubos ".$color."'><p class='dorsaln'>".$row['dorsal']."</p>
		<p class='nomargen t1'>P. ".$posi."</p>
				<p class='nomargen t1'>".$row['tiempo']."</p>
				<p class='nomargen t2'>Hs: ".$row['t_s']."</p>
				<p class='nomargen t2'>Hl: ".$row['t_l']."</p>";
				$posi++;
			}
			
				/*if ($num_inter>0)
					{
					$mi_cuenta = 1;
					echo "<p class='nomargen t2'>INT: ";
					while($mi_cuenta!=$num_inter+1)
							{
								$int='i'.$mi_cuenta;
									if($row[$int]>0)
										echo "<span class='tachado'>".$mi_cuenta."</span> ";
									else
										echo "<span class='frojo'>".$mi_cuenta."</span> ";
							$mi_cuenta++;
							}
					echo "</p></div>";
					}
				else*/
					echo "</div>";
			$pos++;
		}	
		foreach ($abandonos as &$valor) {
			  echo "<div class='cubos rojooo'><p class='dorsaln'>".$valor."</p>";
				echo "<p class='nomargen t1'>ABANDONO</p></div>";
			  }
	}
		else
			echo "SELECCIONAR MANGA PARA MOSTRAR TIEMPOS...";
	}
unset($tiempos);
	?>