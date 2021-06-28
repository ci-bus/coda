<?php
/*CONEXION A TEMPORADAS ANTERIORES
//echo "conexion::::ok";
	if(isset($_GET['newBD']))
	{
	$IPservidor = "localhost";
	$nombreBD = "codea_es_sistema";
	$usuario = "manuel";
	$clave = "coda200900==";
	//echo "newW_BD";
	}else{
	$IPservidor = "localhost";
	$nombreBD = "coda";
	$usuario = "manuel";
	$clave = "coda200900==";
	//echo "OLD";
	}
$conexion = mysql_connect($IPservidor, $usuario, $clave) or die("<h2>No hay conexi&oacute;n con el servidor MySQL</h2>");
mysql_query ("SET NAMES 'utf8'");
mysql_select_db($nombreBD) or die('no se encontro la bd');
*/
if (!$mysqli) {
    $IPservidor = "sistema2020.codea.es";
    $nombreBD = "codea_sistema";
    $usuario = "codea_sistema_user";
    $clave = "n^;eRM8+MWZu";
    $mysqli = new mysqli($IPservidor, $usuario, $clave, $nombreBD);
    $mysqli->set_charset("utf8");
}


/*--------------------------------ESTA ES LA B.D DE WEB EN CODA-----------------*/
if (!$mysqli2) {
    $IPservidor2 = "localhost:3306";
    $nombreBD2 = "web2020";
    $usuario2 = "web2020";
    $clave2 = "Kp!vt750";
    $mysqli2 = new mysqli($IPservidor2, $usuario2, $clave2, $nombreBD2);
    $mysqli2->set_charset("utf8");
}
?>