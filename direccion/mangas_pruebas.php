<?php
//echo $orden;include("conexion.php");
include("escudos.php");
		if(isset($_GET["campeonato"]))
			$campeonato = $_GET["campeonato"];
		else
			$campeonato = '0';
if(isset($_GET["copa"]))
			$copa = $_GET["copa"];
		else
			$copa = '0';
	if(isset($_GET["idmanga"]) && isset($_GET["id"]) && isset($_GET["idseccion"]) && isset($_GET['idetapa']))
		{
		$idManga = $_GET["idmanga"];
		$idCarrera = $_GET["id"];
		$idseccion = $_GET["idseccion"];
		$idetapa = $_GET["idetapa"];
		//$DB_PREFIJO = "abc_57os_";
		}
	echo "CARRERA:".$idCarrera."<br>";
	echo "MAnga:".$idManga."<br>";
//include("includes/nombresTildes.php");
include("includes/funcionesTiempos.php");
$campeonatos_carrera = mysql_query("SELECT * FROM abc_57os_ca_campeonato WHERE id_ca_carrera='$idCarrera'");
	while($mifila=mysql_fetch_array($campeonatos_carrera))
		{
		$nom = strtoupper($mifila['nombre']);
		$id_campeonato = $mifila['id'];
		echo "campeonato:".$id_campeonato;
					?>

<br>
<br>
<br>
<br>


