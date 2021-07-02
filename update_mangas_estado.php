<?php

include "conexion_credenciales.php";

$mysqli = new mysqli($IPservidor3, $usuario3, $clave3, $nombreBD3);
$mysqli->set_charset("utf8");

$mysqli2 = new mysqli($IPservidor2, $usuario2, $clave2, $nombreBD2);
$mysqli2->set_charset("utf8");

$nuevos = 0;
$actualizados = 0;

$idCarrera = $_GET["id"];
// Carrera
$sql_carrera = $mysqli->query("SELECT * FROM abc_57os_ca_carrera WHERE id='$idCarrera'");
if ($sql_carrera->num_rows > 0) {
    $sql_etapa = $mysqli->query("SELECT id FROM abc_57os_ca_etapa WHERE id_ca_carrera='$idCarrera'");
    if ($sql_etapa->num_rows > 0) {
        while ($row = $sql_etapa->fetch_array()) {
            $id_etapa = $row['id'];
            $sql_seccion = $mysqli->query("SELECT id FROM abc_57os_ca_seccion WHERE id_ca_etapa = '$id_etapa'");
            if ($sql_seccion->num_rows > 0) {
                while ($row2 = $sql_seccion->fetch_array()) {
                    $id_seccion = $row2['id'];
                    $sql_mangas = $mysqli->query("SELECT id,descripcion,numero,longitud,tipo,hora_salida,estado,decimales FROM abc_57os_ca_manga WHERE id_ca_seccion = '$id_seccion'");
                    if ($sql_mangas->num_rows > 0) {
                        while ($row3 = $sql_mangas->fetch_array()) {
                            $des_manga = $row3['descripcion'];
                            $id_manga = $row3['id'];
                            $numero = $row3['numero'];
                            $hora = $row3['hora_salida'];
                            $estado = $row3['estado'];
                            $decimales = $row3['decimales'];
                            $longitud = $row3['longitud'];
                            $comprobar_manga = $mysqli2->query("SELECT id FROM web_manga WHERE id = '$id_manga'");
                            // Actualizar estado de mangas
                            if ($comprobar_manga->num_rows > 0) {
                                $mysqli2->query("UPDATE web_manga SET 
                                    descripcion='" . $des_manga . "', numero='" . $numero . "',
                                    longitud='" . $longitud . "', tipo='" . $tipo . "',
                                    hora_salida='" . $hora . "', estado='" . $estado . "', decimales='" . $decimales . "' WHERE id=" . $id_manga);
                            } else {
                                $crear_mangas = $mysqli2->query("INSERT INTO web_manga (id,id_usuario,id_ca_seccion,descripcion,numero,longitud,tipo,hora_salida,estado,decimales)
                                VALUES('$id_manga','2','$id_seccion','$des_manga','$numero','$longitud','$tipo','$hora','$estado','$decimales')");
                            }
                        }
                    } else
                        echo "NO EXISTEN MANGAS CREADAS";
                }
            } else
                echo "NO EXISTEN SECCIONES";
        }
    } else
        echo "NO EXISTEN ETAPAS";
} else {
    echo "No se encuentra ninguna carrera con este id";
}