<?php

$id = $_POST["id"];

include("conexion.php");
$query = $mysqli2->query("UPDATE web_archivos SET descargas=descargas + 1 WHERE id = '$id'");
$mysqli->close();

?>
