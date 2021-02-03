<?php
    // Funciones para sacar hasta la manga id X con todos los competidores, normal y acumulativo

    // archivo configuracion base de datos /librerias/configbd.php

    // Necesario $DB_PREFIJO, $DB_CONEXION

    function coger_competidores($id_ca_carrera, $order) {
        global $DB_PREFIJO, $DB_CONEXION;
        $competidores = array();
        if (!$order) {
            $order = $DB_PREFIJO."ca_competidor.dorsal ASC";
        }
        $SQL = "SELECT ".
            $DB_PREFIJO."ca_competidor.dorsal AS dorsal, ".
            $DB_PREFIJO."ca_competidor.id AS id, ".
            $DB_PREFIJO."ca_competidor.hora_salida AS hora_salida, ".
            $DB_PREFIJO."ca_competidor.posicion_salida AS posicion_salida, ".
            $DB_PREFIJO."ca_concursante.nombre AS concursante_nombre, ".
            $DB_PREFIJO."ca_concursante.nacionalidad AS concursante_nacionalidad, ".
            $DB_PREFIJO."ca_concursante_licencia.licencia AS concursante_licencia, ".
            $DB_PREFIJO."ca_piloto.nombre AS piloto_nombre, ".
            $DB_PREFIJO."ca_piloto_licencia.licencia AS piloto_licencia, ".
            $DB_PREFIJO."ca_copiloto_licencia.licencia AS copiloto_licencia, ".
            $DB_PREFIJO."ca_piloto.nacionalidad AS piloto_nacionalidad, ".
            $DB_PREFIJO."ca_copiloto.nombre AS copiloto_nombre, ".
            $DB_PREFIJO."ca_copiloto.nacionalidad AS copiloto_nacionalidad, ".
            $DB_PREFIJO."ca_vehiculo.marca AS vehiculo_marca, ".
            $DB_PREFIJO."ca_vehiculo.modelo AS vehiculo_modelo, ".
            $DB_PREFIJO."ca_vehiculo.categoria AS vehiculo_categoria, ".
            $DB_PREFIJO."ca_vehiculo.grupo AS vehiculo_grupo, ".
            $DB_PREFIJO."ca_competidor.prioritario AS prioritario, ".
            $DB_PREFIJO."ca_competidor.autorizado AS autorizado, ".
            $DB_PREFIJO."ca_competidor.excluido AS excluido FROM ".$DB_PREFIJO."ca_competidor, ".
                $DB_PREFIJO."ca_piloto, ".
                $DB_PREFIJO."ca_copiloto, ".
                $DB_PREFIJO."ca_concursante, ".
                $DB_PREFIJO."ca_vehiculo, ".
                $DB_PREFIJO."ca_piloto_licencia, ".
                $DB_PREFIJO."ca_copiloto_licencia, ".
                $DB_PREFIJO."ca_concursante_licencia WHERE ".
                $DB_PREFIJO."ca_piloto.id=".$DB_PREFIJO."ca_competidor.id_ca_piloto AND ".
                $DB_PREFIJO."ca_copiloto.id=".$DB_PREFIJO."ca_competidor.id_ca_copiloto AND ".
                $DB_PREFIJO."ca_concursante.id=".$DB_PREFIJO."ca_competidor.id_ca_concursante AND ".
                $DB_PREFIJO."ca_vehiculo.id=".$DB_PREFIJO."ca_competidor.id_ca_vehiculo AND ".
                $DB_PREFIJO."ca_piloto_licencia.id=".$DB_PREFIJO."ca_competidor.id_ca_piloto_licencia AND ".
                $DB_PREFIJO."ca_copiloto_licencia.id=".$DB_PREFIJO."ca_competidor.id_ca_copiloto_licencia AND ".
                $DB_PREFIJO."ca_concursante_licencia.id=".$DB_PREFIJO."ca_competidor.id_ca_concursante_licencia AND ".
                $DB_PREFIJO."ca_competidor.id_ca_carrera=".$id_ca_carrera." ORDER BY ".$order;

        $result = mysqli_query( $DB_CONEXION, $SQL );
        if ($result) {
            while($row = mysqli_fetch_array($result)) {
                foreach($row as $c=>$v) {
                    if (is_numeric($c)) {
                        unset($row[$c]);
                    }
                }
                array_push($competidores, $row);
            }
            return $competidores;
        } else {
            echo mysqli_error($DB_CONEXION);
        }
        
    }

    function filtrar_solo_autorizados($competidores) {
        $res = array();
        foreach($competidores AS $co) {
            if ($co['autorizado'] == 1) {
                array_push($res, $co);
            }
        }
        return $res;
    }

    function filtrar_excluidos($competidores) {
        $res = array();
        foreach($competidores AS $co) {
            if ($co['excluido'] == 0) {
                array_push($res, $co);
            }
        }
        return $res;
    }

    function tiempo_a_milisegundos ($tiempo) {
        $s = 1000;
        $m = 60 * $s;
        $h = 60 * $m;
        list ($tiempo, $mili) = explode('.', trim($tiempo), 2);
        list ($hora, $minuto, $segundo) = explode(':', trim($tiempo), 3);
        $res = 0;
        if (is_numeric($mili) && is_numeric($hora) && is_numeric($minuto) && is_numeric($segundo)) {
            while (strlen($mili) != 3) {
                if (strlen($mili) < 3) $mili .= '0';
                else substr($mili, 0, - 1);
            }
            $res = $mili;
            $res += $segundo * $s;
            $res += $minuto * $m;
            $res += $hora * $h;
        }
        return $res;
    }

    function milisegundos_a_tiempo ($mili) {
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
        return $hora.':'.$minuto.':'.$segundo.'.'.$mili;
    }

    function sort_milisegundos($a, $b)
    {
        if ($a['milisegundos'] + $a['penalizaciones_milisegundos']==$b['milisegundos'] + $b['penalizaciones_milisegundos']) return 0;
        return ($a['milisegundos'] + $a['penalizaciones_milisegundos'] < $b['milisegundos'] + $b['penalizaciones_milisegundos'])? -1: 1;
    }

    // Minimo necesita el id de carrera y el id de manga, las cabeceras se guardan en html en la base de datos

    if ($_GET['id_ca_carrera'] && $_GET['id_ca_manga']) {
        $id_ca_carrera = $_GET['id_ca_carrera'];
        $id_ca_manga = $_GET['id_ca_manga'];
        $cabecera = $_GET['cabecera'];
        $sub_cabecera = $_GET['sub_cabecera'];
        $color1 = $_GET['color1']? '#'.$_GET['color1']: '#000';
        $color2 = $_GET['color2']? '#'.$_GET['color2']: '#fff';

        // Cogemos cabeceras
        if ($cabecera) {
            $SQL = "SELECT contenido FROM ".$DB_PREFIJO."ca_informe_cabecera WHERE id=".$cabecera;
            $html_cabecera = mysqli_fetch_array(mysqli_query($DB_CONEXION, $SQL))['contenido'];
            if ($sub_cabecera) {
                $SQL = "SELECT contenido FROM ".$DB_PREFIJO."ca_informe_cabecera WHERE id=".$sub_cabecera;
                $html_sub_cabecera = mysqli_fetch_array(mysqli_query($DB_CONEXION, $SQL))['contenido'];
            }
        }

        // Cogemos competidores autorizados
        $competidores = coger_competidores($id_ca_carrera, $DB_PREFIJO.'ca_competidor.posicion_salida');
        $competidores = filtrar_solo_autorizados($competidores);

        // Cogemos id de seccion
        $SQL = "SELECT id_ca_seccion FROM ".$DB_PREFIJO."ca_manga WHERE id=".$id_ca_manga;
        $id_ca_seccion = mysqli_fetch_array(mysqli_query($DB_CONEXION, $SQL))['id_ca_seccion'];

        // Cogemos id de etapa
        $SQL = "SELECT id_ca_etapa FROM ".$DB_PREFIJO."ca_seccion WHERE id=".$id_ca_seccion;
        $id_ca_etapa = mysqli_fetch_array(mysqli_query($DB_CONEXION, $SQL))['id_ca_etapa'];

        // Cogemos ids de mangas y longitud
        $SQL ="SELECT ".$DB_PREFIJO."ca_manga.id, ".$DB_PREFIJO."ca_manga.longitud FROM ".$DB_PREFIJO."ca_manga, ".$DB_PREFIJO."ca_seccion WHERE id_ca_seccion=".$DB_PREFIJO."ca_seccion.id AND id_ca_etapa=".$id_ca_etapa." ORDER BY id_ca_seccion ASC, ".$DB_PREFIJO."ca_manga.numero ASC";
        $res = mysqli_query($DB_CONEXION, $SQL);
        $mangas = array();
        while ($row = mysqli_fetch_array($res)) {
            array_push($mangas, array('id' => $row['id'], 'longitud' => $row['longitud']));
        }

        // Cogemos id SALIDA y LLEGADA de las distintas mangas
        for($i = 0; $i < count($mangas); $i ++) {
            $manga = $mangas[$i];
            $SQL = "SELECT descripcion, id FROM ".$DB_PREFIJO."ca_manga_control_horario WHERE id_ca_manga=".$manga['id']." AND (descripcion='SALIDA' OR descripcion='LLEGADA')";
            $res = mysqli_query($DB_CONEXION, $SQL);
            while ($row = mysqli_fetch_array($res)) {
                $mangas[$i][$row['descripcion']] = $row['id'];
            }
        }

        // Cogemos los tiempos y penalizaciones para los distintos concursantes y las distintas mangas
        for ($i = 0; $i < count($mangas); $i ++) {
            $mangas[$i]['competidores'] = array();
            for ($j = 0; $j < count($competidores); $j ++) {
                $competidor = $competidores[$j];
                // Sacamos los tiempos
                $SQL = "SELECT tiempo FROM ".$DB_PREFIJO."ca_tiempo WHERE id_ca_manga_control_horario=".$mangas[$i]['SALIDA']." AND id_ca_competidor=".$competidores[$j]['id'];
                $mili_salida = tiempo_a_milisegundos(mysqli_fetch_array(mysqli_query($DB_CONEXION, $SQL))['tiempo']);
                $SQL = "SELECT tiempo FROM ".$DB_PREFIJO."ca_tiempo WHERE id_ca_manga_control_horario=".$mangas[$i]['LLEGADA']." AND id_ca_competidor=".$competidores[$j]['id'];
                $mili_llegada = tiempo_a_milisegundos(mysqli_fetch_array(mysqli_query($DB_CONEXION, $SQL))['tiempo']);
                if ($mili_salida && $mili_llegada) {
                    // Seteamos milisegundos
                    $competidor['milisegundos'] = ($mili_llegada - $mili_salida);
                    // Cogemos las penalizaciones
                    $competidor['penalizaciones_milisegundos'] = 0;
                    $SQL = "SELECT tipo, tiempo, motivo FROM ".$DB_PREFIJO."ca_penalizacion WHERE id_ca_manga=".$mangas[$i]['id']." AND id_ca_competidor=".$competidor['id'];
                    $res = mysqli_query($DB_CONEXION, $SQL);
                    while ($row = mysqli_fetch_array($res)) {
                        $pena = array('tipo' => $row['tipo'], 'milisegundos' => ($row['tiempo'] * 1000), 'motivo' => $row['motivo']);
                        if (!$competidor['penalizaciones']) {
                            $competidor['penalizaciones'] = array();
                        }
                        array_push($competidor['penalizaciones'], $pena);
                        $competidor['penalizaciones_milisegundos'] += $pena['milisegundos'];
                    }
                    // Calculamos km/h
                    $competidor['km_h'] = ($mangas[$i]['longitud']/1000) / ($competidor['milisegundos']/1000/3600);
                    // Añadimos competidor a la manga
                    array_push($mangas[$i]['competidores'], $competidor);
                }
            }
            //Ordenamos los competidores
            usort($mangas[$i]['competidores'], "sort_milisegundos");
            
            // Si es la manga que pasamos el id dejamos de procesar
            if ($mangas[$i]['id'] == $id_ca_manga) {
                break;
            }
        }

        // Clona la info para hacer calculo acumulativo
        $mangas_acumula = $mangas;

        // Acumula tiempos y penalizaciones por manga
        for ($i = 1; $i < count($mangas_acumula); $i ++) {
            // Sumamos la longitud
            $mangas_acumula[$i]['longitud'] += $mangas_acumula[$i-1]['longitud'];
            for ($j = 0; $j < count($mangas_acumula[$i]['competidores']); $j ++) {
                for ($n = 0; $n < count($mangas_acumula[$i-1]['competidores']); $n ++) {
                    if ($mangas_acumula[$i-1]['competidores'][$n]['id'] == $mangas_acumula[$i]['competidores'][$j]['id']) {
                        // Sumamos tiempo
                        $mangas_acumula[$i]['competidores'][$j]['milisegundos'] += $mangas_acumula[$i-1]['competidores'][$n]['milisegundos'];
                        // Añade penalizaciones
                        if ($mangas_acumula[$i-1]['competidores'][$n]['penalizaciones']) {
                            if (!$mangas_acumula[$i]['competidores'][$n]['penalizaciones']) {
                                $mangas_acumula[$i]['competidores'][$n]['penalizaciones'] = array();
                            }
                            foreach($mangas_acumula[$i-1]['competidores'][$n]['penalizaciones'] as $pena) {
                                array_push($mangas_acumula[$i]['competidores'][$n]['penalizaciones'], $pena);
                            }
                        }
                        // Sumamos penalizaciones
                        $mangas_acumula[$i]['competidores'][$j]['penalizaciones_milisegundos'] += $mangas_acumula[$i-1]['competidores'][$n]['penalizaciones_milisegundos'];
                        // Calculamos km/h
                        $mangas_acumula[$i]['competidores'][$j]['km_h'] = ($mangas_acumula[$i]['longitud']/1000) / ($mangas_acumula[$i]['competidores'][$j]['milisegundos']/1000/3600);
                        break;
                    }
                }
            }
            //Ordenamos los competidores con tiempos acumulados
            usort($mangas_acumula[$i]['competidores'], "sort_milisegundos");
        }

        // Calcula comparativa tiempos primero, anterior
        for ($i = 0; $i < count($mangas); $i ++) {
            for ($j = 0; $j < count($mangas[$i]['competidores']); $j ++) {
                if ($j === 0) {
                    $primero_milisegundos = $mangas[$i]['competidores'][$j]['milisegundos'];
                    $mangas[$i]['competidores'][$j]['primero_milisegundos'] = '---';
                    $mangas[$i]['competidores'][$j]['anterior_milisegundos'] = '---';
                } else {
                    $mangas[$i]['competidores'][$j]['primero_milisegundos'] = ($mangas[$i]['competidores'][$j]['milisegundos'] - $primero_milisegundos);
                    $mangas[$i]['competidores'][$j]['anterior_milisegundos'] = ($mangas[$i]['competidores'][$j]['milisegundos'] - $anterior_milisegundos);
                }
                $anterior_milisegundos = $mangas[$i]['competidores'][$j]['milisegundos'];
            }
        }

        // Calcula comparativa tiempos primero, anterior en acumulativos
        for ($i = 0; $i < count($mangas_acumula); $i ++) {
            for ($j = 0; $j < count($mangas_acumula[$i]['competidores']); $j ++) {
                if ($j === 0) {
                    $primero_milisegundos = $mangas_acumula[$i]['competidores'][$j]['milisegundos'];
                    $mangas_acumula[$i]['competidores'][$j]['primero_milisegundos'] = '---';
                    $mangas_acumula[$i]['competidores'][$j]['anterior_milisegundos'] = '---';
                } else {
                    $mangas_acumula[$i]['competidores'][$j]['primero_milisegundos'] = ($mangas_acumula[$i]['competidores'][$j]['milisegundos'] - $primero_milisegundos);
                    $mangas_acumula[$i]['competidores'][$j]['anterior_milisegundos'] = ($mangas_acumula[$i]['competidores'][$j]['milisegundos'] - $anterior_milisegundos);
                }
                $anterior_milisegundos = $mangas_acumula[$i]['competidores'][$j]['milisegundos'];
            }
        }

        echo '<pre style="overflow:auto;width:95%;height:40%;">';
        print_r($mangas);
        echo '</pre>';

        echo '<pre style="overflow:auto;width:95%;height:40%;">';
        print_r($mangas_acumula);
        echo '</pre>';

    } else {
        echo 'ERROR: Falta id de carrera o id de manga';
    }

?>