<?php
/* PARAMETROS ORIGINALES  */
//$IPservidor = "85.238.8.44";
$IPservidor = "db710399028.db.1and1.com";
$nombreBD = "db710399028";
$usuario = "dbo710399028";
$clave = "hola00==";
$conexion = mysql_connect($IPservidor, $usuario, $clave) or die("<h2>No hay conexi&oacute;n con el servidor MySQL</h2>");
mysql_query ("SET NAMES 'utf8'");
mysql_select_db($nombreBD) or die('no se encontro la bd');
/*$IPservidor = "localhost";
$nombreBD = "coda2";
$usuario = "root";
$clave = "";
$conexion = mysql_connect($IPservidor, $usuario, $clave) or die("<h2>No hay conexi&oacute;n con el servidor MySQL.</h2>");
mysql_query ("SET NAMES 'utf8'");
mysql_select_db($nombreBD);*/
?>