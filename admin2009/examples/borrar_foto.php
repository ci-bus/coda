<?php
$id = $_GET['id'];
$id_com = $_GET['id_com'];
$tipo = $_GET['tipo'];
$tipo2 = $_GET['tipo2'];
$temporada = $_GET['temporada'];

$IPservidor = "localhost:3306";
$nombreBD = "codea_es_sistema";
$usuario = "manuel";
$clave = "coda200900==";
$mysqli = new mysqli($IPservidor, $usuario, $clave, $nombreBD);
$mysqli->set_charset("utf8");

$borrar = "UPDATE web_fotos SET ".$tipo."='' WHERE id_ca_competidor='".$id_com."'";
$borrar_foto = $mysqli->query($borrar);
mysqli_close($mysqli);
unlink('../../img/equipos/'.$temporada.'/'.$id.'/'.$id_com.'_'.$tipo2.'.jpg');
echo "BORRANDO IMAGEN....";
echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=fotos_ver.php?activo=extras&newBD=true&id='.$id.'">';
?>