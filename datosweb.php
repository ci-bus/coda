<?php

// Funciones de tiempo
function tiempo_a_milisegundos($tiempo)
{
    $s = 1000;
    $m = 60 * $s;
    $h = 60 * $m;
    list($tiempo, $mili) = explode('.', trim($tiempo), 2);
    list($hora, $minuto, $segundo) = explode(':', trim($tiempo), 3);
    $res = 0;
    if (is_numeric($mili) && is_numeric($hora) && is_numeric($minuto) && is_numeric($segundo)) {
        while (strlen($mili) != 3) {
            if (strlen($mili) < 3) $mili .= '0';
            else substr($mili, 0, -1);
        }
        $res = $mili;
        $res += $segundo * $s;
        $res += $minuto * $m;
        $res += $hora * $h;
    }
    return $res;
}

function milisegundos_a_tiempo($mili)
{
    if (is_numeric($mili)) {
        $s = 1000;
        $m = 60 * $s;
        $h = 60 * $m;
        $res = '';
        $hora = floor($mili / $h);
        $mili = $mili - ($hora * $h);
        $minuto = floor($mili / $m);
        $mili = $mili - ($minuto * $m);
        $segundo = floor($mili / $s);
        $mili = $mili - ($segundo * $s);
        if (strlen($hora . '') == 1) $hora = '0' . $hora;
        if (strlen($minuto . '') == 1) $minuto = '0' . $minuto;
        if (strlen($segundo . '') == 1) $segundo = '0' . $segundo;
        if (strlen($mili . '') == 1) $mili = '00' . $mili;
        else if (strlen($mili . '') == 2) $mili = '0' . $mili;
        $time = $minuto . ':' . $segundo . '.' . $mili;
        if ($hora != '00') {
            $time = $hora . ':' . $time;
        }
        return $time;
    } else return $mili;
}

function segundos_a_milisegundos($segundos)
{
    $segundos = $segundos * 1000;
    return $segundos;
}

// mostrar mensajes de procesamiento para verificar el funcionamiento del script
$mostrar_mensajes = true;

if ($mostrar_mensajes) {
    echo "Conectando a la base de datos local...";
}

// Conexion a la base de datos del sistema
$IPservidor = "sistema2020.codea.es";
$nombreBD = "codea_sistema";
$usuario = "codea_sistema_user";
$clave = "n^;eRM8+MWZu";
$mysqli = new mysqli($IPservidor, $usuario, $clave, $nombreBD);
if ($mysqli) {
    $mysqli->set_charset("utf8");
    if ($mostrar_mensajes) {
        echo " Conectado!";
    }
} else {
    die(' ERROR: No se ha podido conectar a la base de datos local');
}

if ($mostrar_mensajes) {
    echo "<br>Conectando a la base de la web...";
}

// Conexion a la base de datos de la web
$IPservidor = "localhost:3306";
$nombreBD2 = "web2020";
$usuario2 = "web2020";
$clave2 = "Kp!vt750";
$mysqli2 = new mysqli($IPservidor, $usuario2, $clave2, $nombreBD2);
if ($mysqli2) {
    $mysqli2->set_charset("utf8");
    if ($mostrar_mensajes) {
        echo " Conectado!";
    }
} else {
    die(' ERROR: No se ha podido conectar a la base de la web');
}

$id_carrera = $_GET['id'];

if ($mostrar_mensajes) {
    echo "<br>carrera ID: <strong>" . $id_carrera . "</strong>";
}

// Guarda la ultima id de tiempos
$nuevos = 0;
$actualizados = 0;

// TODO coger todos los competidores, mangas y tiempos

// ------------------------------------- //
// Cogemos los campeonatos de la carrera //
// ------------------------------------- //
$campeonatos = $mysqli->query("SELECT * FROM abc_57os_ca_campeonato WHERE id_ca_carrera = '$id_carrera'");

// Si existen campeonatos
if ($campeonatos->num_rows > 0) {

    if ($mostrar_mensajes) {
        echo "<h3>Campeonatos encontrados <strong>" . $campeonatos->num_rows . "</strong></h3>";
    }

    // Recorre los campeonatos
    while ($campeonato = $campeonatos->fetch_array()) {

        // Datos del campeonato
        $modo_tiempo = $campeonato['tiempo_tipo'];
        $id_campeonato = $campeonato['id'];
        $modalidad = $campeonato['id_ca_modalidad'];
        $nombre_campeonato = $campeonato['nombre'];
        // Fix arregla caracteres
        $nombre_campeonato = str_ireplace(array('Ã‘', 'Ã±'), array('Ñ', 'ñ'), $nombre_campeonato);

        if ($mostrar_mensajes) {
            echo "<br>Campeonato <strong>" . $nombre_campeonato . "</strong> ID <strong>" . $id_campeonato . "</strong>";
            echo "<br>Modo tiempo <strong>";
            switch ($modo_tiempo) {
                case 0:
                    echo "Acumulado";
                    break;
                case 1:
                    echo "Mejor manga";
                    break;
                case 2:
                    echo "Dos mejores mangas";
                    break;
                case 3:
                    echo "Tres mejores mangas";
                    break;
                default:
                    echo "Desconocido";
                    break;
            }
            echo "</strong>";
        }

        // Cuenta el número de mangas oficiales
        $mangas_oficiales = $mysqli->query("SELECT count(manga.id) FROM abc_57os_ca_manga manga 
					INNER JOIN abc_57os_ca_campeonato_manga campeonato_manga ON campeonato_manga.id_ca_manga=manga.id 
					WHERE campeonato_manga.id_ca_campeonato='$id_campeonato' AND manga.tipo='1'")->fetch_array();
        $numero_mangas_oficiales = $mangas_oficiales[0];

        if ($mostrar_mensajes) {
            echo "<br>Número de mangas oficiales: <strong>" . $numero_mangas_oficiales . "</strong>";
        }

        // Actualiza el campeonato
        $mysqli2->query("DELETE FROM web_campeonatos WHERE id='$id_campeonato'");
        $SQL = "INSERT INTO web_campeonatos (id, idcarrera, nombre, idmodalidad, tipo_tiempo, mangas_oficiales) VALUES ('$id_campeonato', '$id_carrera', '$nombre_campeonato', '$modalidad', '$modo_tiempo', '$numero_mangas_oficiales')";
        if ($mysqli2->query($SQL)) {
            if ($mostrar_mensajes) {
                echo "<br>Se ha insertado el campeonato: <strong>" . $nombre_campeonato . "</strong> ID <strong>" . $id_campeonato . "</strong>";
            }
        } else {
            die("ERROR: No se ha podido insertar un campeonato SQL: " . $SQL);
        }

        // -------------------------------- //
        // Cogemos las copas del campeonato //
        // -------------------------------- //
        $copas = $mysqli->query("SELECT id, descripcion FROM abc_57os_ca_copa WHERE id_ca_campeonato = '$id_campeonato'");

        if ($mostrar_mensajes) {
            echo "<h3>Copas encontrados <strong>" . $copas->num_rows . "</strong></h3>";
        }

        // Recorre las copas
        while ($copa = $copas->fetch_array()) {
            $id_copa = $copa['id'];
            $descripcion_copa = $copa['descripcion'];
            // Fix arregla caracteres
            $descripcion_copa = str_ireplace(array('Ã‘', 'Ã±'), array('Ñ', 'ñ'), $descripcion_copa);

            // Actualiza la copa del campeonato
            $mysqli2->query("DELETE FROM web_copas WHERE id_ca_campeonato='$id_campeonato'");
            $SQL = "INSERT INTO web_copas (id, descripcion, idcampeonato, idcarrera) VALUES ('$id_copa', '$descripcion_copa', '$id_campeonato', '$id_carrera')";
            if ($mysqli2->query($SQL)) {
                if ($mostrar_mensajes) {
                    echo "<br>Se ha insertado la copa: <strong>" . $descripcion_copa . "</strong> ID <strong>" . $id_copa . "</strong>";
                }
            } else {
                die("ERROR: No se ha podido insertar una copa SQL: " . $SQL);
            }

            // ----------------------------------- //
            // Cogemos los competidores de la copa //
            // ----------------------------------- //
            $competidores = $mysqli->query("SELECT id_ca_competidor FROM abc_57os_ca_copa_competidor WHERE id_ca_copa='$id_copa'");

            // Elimina los competidores de la copa para actualizarlos
            $mysqli2->query("DELETE FROM web_copas_inscritos WHERE idcopa='$id_copa'");

            // Recorre los competidores
            $competidores_insertados = 0;
            while ($competidor = $competidores->fetch_array()) {
                $id_competidor = $competidor['id_ca_competidor'];
                $SQL = "INSERT INTO web_copas_inscritos (id, idcopa, idcompetidor) VALUES ('','$id_copa','$id_competidor')";
                if ($mysqli2->query($SQL)) {
                    $competidores_insertados++;
                } else {
                    die("ERROR: No se ha podido insertar un competidor SQL: " . $SQL);
                }
            }
            if ($mostrar_mensajes) {
                echo "<br>Se ha insertado <strong>" . $competidores_insertados . "</strong> competidores de la copa";
            }
        }

        // --------------------------------------- //
        // Cogemos los competidores del campeonato //
        // --------------------------------------- //
        $competidoresQuery = $mysqli->query("SELECT id_ca_competidor AS id FROM abc_57os_ca_campeonato_competidor WHERE id_ca_campeonato=" . $id_campeonato);
        $competidores = array();
        while ($competidor = $competidoresQuery->fetch_array()) {
            $competidores[] = $competidor;
        }

        // --------------------------------- //
        // Cogemos las mangas del campeonato //
        // --------------------------------- //
        $mangasQuery = $mysqli->query("SELECT id_ca_manga AS id, tipo, numero FROM abc_57os_ca_campeonato_manga "
            . "INNER JOIN abc_57os_ca_manga ON abc_57os_ca_manga.id = abc_57os_ca_campeonato_manga.id_ca_manga "
            . "WHERE estado=1 AND id_ca_campeonato=" . $id_campeonato);
        $mangas = array();
        while ($manga = $mangasQuery->fetch_array()) {
            $id_manga = $manga['id'];
            $mangas[] = $manga;
        }

        // Recorre los competidores
        foreach ($competidores as $competidor) {
            // Recorre las mangas
            foreach ($mangas as $manga) {
                //-----------------------------------------//
                // Cogemos los tiempos de salida y llegada //
                //-----------------------------------------//
                $DB_PREFIJO = 'abc_57os_';
                $SQL = "SELECT " . $DB_PREFIJO . "ca_tiempo.*, " . $DB_PREFIJO . "ca_manga_control_horario.descripcion as control_horario "
                    . "FROM " . $DB_PREFIJO . "ca_tiempo "
                    . " INNER JOIN " . $DB_PREFIJO . "ca_manga_control_horario ON " . $DB_PREFIJO . "ca_tiempo.id_ca_manga_control_horario = " . $DB_PREFIJO . "ca_manga_control_horario.id "
                    . " INNER JOIN " . $DB_PREFIJO . "ca_manga ON " . $DB_PREFIJO . "ca_tiempo.id_ca_manga = " . $DB_PREFIJO . "ca_manga.id "
                    . "WHERE " . $DB_PREFIJO . "ca_tiempo.id_ca_manga=" . $manga['id'] . " AND id_ca_competidor=" . $competidor['id'];

                $tiempos = $mysqli->query($SQL);

                $tiempo_salida = null;
                $tiempo_llegada = null;
                $h_s = 0;
                $h_l = 0;
                $t_t = 0;
                $penal = 0;
                while ($tiempo = $tiempos->fetch_array()) {
                    if ($tiempo['control_horario'] == 'SALIDA') {
                        $tiempo_salida = tiempo_a_milisegundos($tiempo['tiempo']);
                    } else if ($tiempo['control_horario'] == 'LLEGADA') {
                        $tiempo_llegada = tiempo_a_milisegundos($tiempo['tiempo']);

                        $idtiempos = $tiempo['id'];
                        $idmanga = $manga['id'];
                        $idcarrera = $tiempo['id_ca_carrera'];
                        $penalizacion = $tiempo['id_ca_manga'];
                        $num_manga = $manga['numero'];
                        $tipo_manga = $manga['tipo'];
                        $idcampeonato = $campeonato['id'];
                    }
                }

                if ($tiempo_salida && $tiempo_llegada) {
                    $h_s = $tiempo_salida;
                    $h_l = $tiempo_llegada;
                    $t_t = $h_l - $h_s;
                    $penal = 0;

                    // Penalizaciones
                    $SQL = "SELECT * FROM abc_57os_ca_penalizacion WHERE id_ca_manga=" . $manga['id'] . " AND id_ca_competidor=" . $competidor['id'];
                    $penalizaciones = $mysqli->query($SQL);
                    while ($penalizacion = $penalizaciones->fetch_array()) {
                        $penal += $penalizacion['tiempo'];
                    }
                    
                    $mysqli2->query("DELETE FROM web_tiempos WHERE id_ca_manga=" . $manga['id'] . " AND id_ca_competidor=" . $competidor['id']);
                    $SQL = "INSERT INTO `web_tiempos` (`idtiempos`, `idmanga`, `h_s`, `h_l`, `idcarrera`, `t_t`, `penalizacion`, `idinscrito`, `num_manga`, `tipo_manga`, `idcampeonato`) "
                    ." VALUES ('$idtiempos', '$idmanga', '$h_s', '$h_l', '$idcarrera', '$t_t', '$penal', '".$competidor['id']."', '$num_manga', '$tipo_manga', '$idcampeonato')";
                    echo $SQL."<br>";
                    $mysqli2->query($SQL);
                }
            }
        }
    }
} //Fin while campeonatos
