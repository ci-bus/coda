<?php

// CONEXION BASE DE DATOS LOCAL SISTEMA
$IPservidor = "localhost";
$nombreBD = "codea_sistema";
$usuario = "codea_sistema_user";
$clave = "n^;eRM8+MWZu";

// ESTA ES LA B.D DE WEB EN CODA
$IPservidor2 = "localhost";
$nombreBD2 = "web2020";
$usuario2 = "web2020";
$clave2 = "Kp!vt750";

// BASE DE DATOS DEL SERVIDOR DE JOSE
if ($_SERVER['SERVER_ADDR'] == '::1') {
  $IPservidor3 = "localhost";
} else {
  $IPservidor3 = "sistema2020.codea.es";
}
$nombreBD3 = "codea_sistema";
$usuario3 = "codea_sistema_user";
$clave3 = "n^;eRM8+MWZu";
$DB_PREFIJO = "abc_57os_";
