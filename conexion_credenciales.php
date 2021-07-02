<?php

// ESTA ES LA B.D DE WEB EN CODA
$IPservidor2 = "localhost";
$nombreBD2 = "web2020";
$usuario2 = "web2020";
$clave2 = "Kp!vt750";

// BASE DE DATOS DEL SERVIDOR DE JOSE
if (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'localhost') {
  $IPservidor3 = "localhost";
} else {
  $IPservidor3 = "sistema2020.codea.es";
}
$nombreBD3 = "codea_sistema";
$usuario3 = "codea_sistema_user";
$clave3 = "n^;eRM8+MWZu";
$DB_PREFIJO = "abc_57os_";
