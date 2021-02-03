<?php
	$IPservidor = "localhost";
	$nombreBD = "codea_es_sistema";
	$usuario = "manuel";
	$clave = "coda200900==";
$conexion = mysql_connect($IPservidor, $usuario, $clave) or die("<h2>No hay conexi&oacute;n con el servidor MySQL</h2>");
mysql_query ("SET NAMES 'utf8'");
mysql_select_db($nombreBD) or die('no se encontro la bd');
?>