<?php
session_start();
error_reporting(0);
$IPservidor = "localhost";
	$nombreBD = "codea_es_sistema";
	$usuario = "manuel";
	$clave = "coda200900==";
$conexion = mysql_connect($IPservidor, $usuario, $clave) or die("<h2>No hay conexi&oacute;n con el servidor MySQL</h2>");
mysql_query ("SET NAMES 'utf8'");
mysql_select_db($nombreBD) or die('no se encontro la bd');
if (!isset($_SESSION['pass']) && empty($_SESSION['pass']))
		echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=acceso_new.php?id='.$id.'">';
$id = $_GET['id'];
$tipo = $_GET['tipo'];
$archivo = $_GET['archivo'];
	switch($tipo){
		case "previa":
			$tipo="infoprevia";
			break;
		case "carrera":
			$tipo = "infocarrera";
			break;
		case "direccion":
			$tipo = "infodireccion";
			break;
		case "comisarios":
			$tipo = "infocomisarios";
			break;
		}
$idinfo = $_GET['idinfo'];
$temporada = $_GET['temporada'];
unlink("../$archivo");
$sql = mysql_query("DELETE FROM abc_57os_ca_carrera_archivo WHERE id_ca_carrera='$id' AND id='$idinfo'");
echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=edi_tablon_new.php?id='.$id.'&newBD=true">';
?>