<?php
//include("funcionesTiempos.php");
include("conexion.php");
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
			$dorsal = $fila['dorsal'];
			$comp = mysql_query("SELECT ch.orden AS orden,t.tiempo FROM abc_57os_ca_tiempo t 
			INNER JOIN abc_57os_ca_manga_control_horario ch ON ch.id=t.id_ca_manga_control_horario 
			WHERE WHERE dorsal NOT IN (SELECT id_ca_competidor FROM abc_57os_ca_abandono WHERE id_ca_manga='$idManga') 
			AND t.dorsal='$dorsal' AND t.id_ca_manga='$idManga'");//COMPRUEBO Q TENGA 2  TIEMPOS salida y llegada
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

			}
		}
$long=count($enpista);
//DE MOMENTO MUESTRO LOS COCHES EN PISTA A FIN DE MEJORAR Y PODER POSICIONARLOS QUE NO SE COMO LOS MOSTRARE SOLO TENGO EN CABEZA SU POSICION EN PISTA Y NO QUIERO QUE SE SOLAPEN, DEJO AQUI ESTO PARA ACORDARME DE LO QU HE PENSADO PARA EL NUEVO SCRIPT
		for($i=0;$i<$long;$i++){
			echo "<div class='enpista'><span class='pista_dorsal'>".$enpista[$i]."</span><img src='img/cochep.png' width='70px'></div>";
		}
?>