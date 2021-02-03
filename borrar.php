<?php
session_start();
error_reporting(0);
include("conexion.php");
if (!isset($_SESSION['pass']) && empty($_SESSION['pass']))
		echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=acceso.php?id='.$id.'">';
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
$sql = mysql_query("DELETE FROM ".$tipo." WHERE idcarreras='$id' AND idInfo='$idinfo'");
echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=edi_tablon.php?id='.$id.'">';
?>