<?php

include "conexion_credenciales.php";

if (!$mysqli) {
	$mysqli = new mysqli($IPservidor, $usuario, $clave, $nombreBD);
	$mysqli->set_charset("utf8");
}

if (!$mysqli2) {
	$mysqli2 = new mysqli($IPservidor2, $usuario2, $clave2, $nombreBD2);
	$mysqli2->set_charset("utf8");
}
