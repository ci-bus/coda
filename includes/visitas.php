<?php

function buscarendirectorio($ruta,$vueltas){
	$dir="";// Variable para el directorio donde se encuentran los archivos a incluir
	$existe=false;
	for($i=0;$i<$vueltas && !$existe;$i++){
		if(file_exists($ruta)){
			$existe=true;
		}
		else {
			$dir="../".$dir;
			$ruta="../".$ruta;
		}
	}
	if($existe){
		return $dir;
	}
	else {
		return false;
	}
}
// Contador de visitas
$archivo="index.php";// index.php o cualquier archivo que esté en la carpeta raiz (login.php y Administrar.php estan en la raid)
$vueltas=3;
$dir=buscarendirectorio($archivo,$vueltas);
//Calcular IP real
if(isset($_SERVER)){
	if(isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
		$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	} 
	elseif(isset($_SERVER["HTTP_CLIENT_IP"])){
		$realip = $_SERVER["HTTP_CLIENT_IP"];
	}
	else {
		$realip = $_SERVER["REMOTE_ADDR"];
	}
}
else {
	if(getenv("HTTP_X_FORWARDED_FOR")){
		$realip = getenv("HTTP_X_FORWARDED_FOR");
	}
	elseif(getenv("HTTP_CLIENT_IP")){
		$realip = getenv("HTTP_CLIENT_IP");
	}
	else {
		$realip = getenv("REMOTE_ADDR");
	} 
}
// Contador de visitas
$ip = $realip;//$_SERVER["REMOTE_ADDR"];
$hoy = date("Y-m-d");
include($dir."conexion.php");
$dbQuery = "SELECT idVisita, ip, ultima, total FROM visitas WHERE ip='$ip'";
$resultado = mysql_query($dbQuery) or print("No se pueden obtener las visitas.");
if(mysql_num_rows($resultado) != 0){//Si la IP ya está en la base de datos
	$idVisita = @mysql_result($resultado, 0, "idVisita");
	$total = @mysql_result($resultado, 0, "total");
	$ultima = @mysql_result($resultado, 0, "ultima");
	if($ultima != $hoy){
	$total = $total+1;
	$query = "UPDATE visitas SET ultima = '$hoy', total = '$total' WHERE visitas.idVisita = $idVisita";
	mysql_query($query);
	}
}
else {//Si no está la IP en la BD
	$query = "INSERT INTO visitas values ('0', '$ip', '$hoy', '1')";
	mysql_query($query);
}
//Visitas desde diferentes IPs hoy
$query = "SELECT COUNT(*) as today FROM visitas WHERE ultima = '$hoy'";
$resultado = mysql_query($query);
$visitasHoy = @mysql_result($resultado, 0, "today");
//Visitas totales desde diferentes IPs
$query = "SELECT SUM(total) as todas FROM visitas";
$resultado = mysql_query($query);
$visitasTotales = @mysql_result($resultado, 0, "todas");
@mysql_free_result($resultado);
mysql_close($conexion);
//Escribir las visitas
if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
	echo "<br><p class='visitas' align='center'>Hoy: <b>".$visitasHoy."</b> <b>|</b> Visitas totales: <b>".$visitasTotales."</b></p>";
else
	echo "<br><p class='visitas' align='center'>Today: <b>".$visitasHoy."</b> <b>|</b> Total Visitors: <b>".$visitasTotales."</b></p>";
//Fin de Contador de visitas
?>