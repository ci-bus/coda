<?php
/* PARAMETROS ORIGINALES  */
//$IPservidor = "85.238.8.44";
$IPservidor = "localhost";
$nombreBD = "coda";
$usuario = "manuel";
$clave = "coda200900==";
$mysqli = new mysqli($IPservidor, $usuario, $clave, $nombreBD);
$mysqli->set_charset("utf8");
/*$IPservidor = "localhost";
$nombreBD = "coda2";
$usuario = "root";
$clave = "";
$conexion = mysql_connect($IPservidor, $usuario, $clave) or die("<h2>No hay conexi&oacute;n con el servidor MySQL.</h2>");
mysql_query ("SET NAMES 'utf8'");
mysql_select_db($nombreBD);*/
?>