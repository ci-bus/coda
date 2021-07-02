<?php

include "conexion_credenciales.php";

$mysqli = new mysqli($IPservidor3, $usuario3, $clave3, $nombreBD3);
$mysqli->set_charset("utf8");

$mysqli2 = new mysqli($IPservidor2, $usuario2, $clave2, $nombreBD2);
$mysqli2->set_charset("utf8");

$nuevos = 0;
$actualizados = 0;

$idCarrera = $_GET["id"];
<<<<<<< HEAD
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
///////////CREAR SECCIONES / ETAPAS  Y MANGAS   ////////////
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
$sql_etapa = $mysqli->query("SELECT descripcion,id,orden FROM abc_57os_ca_etapa WHERE id_ca_carrera='$idCarrera'");
if ($sql_etapa->num_rows > 0) {
    while ($row = $sql_etapa->fetch_array()) {
        $des_etapa = $row['descripcion'];
        $id_etapa = $row['id'];
        $orden_etapa = $row['orden'];
        echo "<br>" . $id_etapa . "Etapa: " . $des_etapa;
        $comprobar_etapa = $mysqli->query("SELECT id FROM web_etapa WHERE id = '$id_etapa'");
        if ($comprobar_etapa->num_rows > 0) {
            //ACTUALIZAMOS
        } else {
            $crear_etapas = $mysqli2->query("INSERT INTO web_etapa (id,id_usuario,id_ca_carrera,descripcion,orden) VALUES
            ('$id_etapa','2','$idCarrera','$des_etapa','$orden_etapa')");
        }
        $sql_seccion = $mysqli->query("SELECT id, descripcion,orden FROM abc_57os_ca_seccion WHERE id_ca_etapa = '$id_etapa'");
        if ($sql_seccion->num_rows > 0) {
            while ($row2 = $sql_seccion->fetch_array()) {
                $des_seccion = $row2['descripcion'];
                $id_seccion = $row2['id'];
                $orden_seccion = $row2['orden'];
                echo "<br>" . $id_seccion . " SECCION: " . $des_seccion;
                $comprobar_seccion = $mysqli2->query("SELECT id FROM web_seccion WHERE id = '$id_seccion'");
                if ($comprobar_seccion->num_rows > 0) {
                    //ACTUALIZAMOS REGISTRO
                } else {
                    $crear_seccion = $mysqli2->query("INSERT INTO web_seccion (id,id_usuario,id_ca_etapa,descripcion,orden) VALUES
                    ('$id_seccion','2','$id_etapa','$des_seccion','$orden_seccion')");
                }
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
                        //COMPROBAR SI EXISTE
                        $comprobar_manga = $mysqli2->query("SELECT id FROM web_manga WHERE id = '$id_manga'");
                        if ($comprobar_manga->num_rows > 0) {
                            //EXISTE LA ACTUALIZAMOS AUNQUE DE MOMENTO LO VOY A BORRAR que para el caso es lo mismo
                            //$borrar_mangas = $mysqli2->query("DELETE FROM web_mangas WHERE id='$id_manga'");
                        } else {
                            //NO EXISTE REGISTRO, LO CREAMOS
                            $crear_mangas = $mysqli2->query("INSERT INTO web_manga (id,id_usuario,id_ca_seccion,descripcion,numero,longitud,tipo,hora_salida,estado,decimales)
                            VALUES('$id_manga','2','$id_seccion','$des_manga','$numero','$longitud','$tipo','$hora','$estado','$decimales')");
                        }
                        echo "<br>" . $id_manga . " MANGA: " . $des_manga;
                        //COMPROBAR SI EXISTEN INTERMEDIOS///////
                        $saber_inter = $mysqli->query("SELECT descripcion,orden FROM abc_57os_ca_manga_control_horario WHERE id_ca_manga = '$id_manga' AND orden!=5 AND orden!=10");
                        $afectados_inter = $saber_inter->num_rows;
                        if($afectados_inter>0){
                            while($row4 = $saber_inter->fetch_array()){
                                $orden_inter = $row4['orden'];
                                $descripcion_inter = $row4['descripcion'];
                                echo "<br>INTERMEDIO!!!!! -> : ".$descripcion_inter;
                                $insertar_intermedio = $mysqli2->query("INSERT INTO web_manga_control_horario(id,id_usuario,descripcion,orden,id_ca_manga) VALUES('','1','$descripcion_inter','$orden_inter','$id_manga')");
                            }
                            echo "<hr>";
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
///////////////////////////////////////////////////////////
/////INSCRIBIR A CADA PARTICIPANTE EN CADA CAMPEONATO////////
///////////////////////////////////////////////////////////
echo "<br>";
$consulta_campeonatos = $mysqli->query("SELECT cacom.id_ca_campeonato AS idcampeonato,cacom.id_ca_competidor AS idcompetidor,cam.nombre AS nombre FROM abc_57os_ca_campeonato cam 
INNER JOIN abc_57os_ca_campeonato_competidor cacom
ON cacom.id_ca_campeonato = cam.id
WHERE cam.id_ca_carrera = '$idCarrera'");
if ($consulta_campeonatos->num_rows > 0) {
    //EVITAR QUE DUPLIQUE LOS INSCRITOS A LOS CAMPEONATOS
    $borrar_inscritos_para_no_cagarla = $mysqli2->query("DELETE FROM web_campeonatos_inscritos WHERE idcarrera='$idCarrera'");
    while ($row = $consulta_campeonatos->fetch_array()) {
        $nombre = $row['nombre'];
        $idcompetidor = $row['idcompetidor'];
        $idcampeonato = $row['idcampeonato'];
        echo "IDCAMP: ".$idcampeonato." IDCOMP: ".$idcompetidor." - ".$nombre;
        $inscribir_campeonatos = $mysqli2->query("INSERT INTO web_campeonatos_inscritos (id,idinscrito,idcampeonato,idcarrera) VALUES ('','$idcompetidor','$idcampeonato','$idCarrera')");
=======
// Carrera
$sql_carrera = $mysqli->query("SELECT * FROM abc_57os_ca_carrera WHERE id='$idCarrera'");
if ($sql_carrera->num_rows > 0) {
    $row = $sql_carrera->fetch_array();
    $comprobar_carrera = $mysqli2->query("SELECT idcarrera FROM web_pruebas WHERE idcarrera = '$idCarrera'");
    $modo_tiempos = $mysqli2->query("SELECT modo_tiempos FROM web_pruebas WHERE tipo = '" . $row['id_ca_tipo_prueba'] . "' LIMIT 1");
    if ($modo_tiempos) {
        $modo_tiempos = $modo_tiempos->fetch_array()['modo_tiempos'];
    } else {
        echo "<hr>No hay modo de tiempo para el tipo de carrera " . $row['id_ca_tipo_prueba'] . "<hr>";
        $modo_tiempos = 0;
    }
    $nombre = $row['nombre'];
    $descripcion = $row['descripcion'];
    $fecha_larga = $row['fecha_larga'];
    $fecha = $row['fecha'];
    $cartel = $row['cartel'];
    $id_ca_tipo_prueba = $row['id_ca_tipo_prueba'];
    $estado = $row['estado'];
    $coeficiente = $row['coeficiente'];
    $organizador = $row['organizador'];
    $prueba_web = $row['prueba_web'];
    $poblacion = $row['poblacion'];
    $carnet_ruta = $row['carnet_ruta'];
    $localidad = $row['localidad'];
    $temporada = $row['temporada'];
    if ($comprobar_carrera->num_rows > 0) {
        $mysqli2->query("UPDATE `web_pruebas` SET 
            `temporada` = '$temporada', `web` = '$prueba_web', `titulo` = '$nombre', `fecha` = '$fecha', 
            `fecha_larga` = '$fecha_larga', `poblacion` = '$poblacion', `estado` = '$estado',
            `tipo` = '$id_ca_tipo_prueba', `modo_tiempos` = '$modo_tiempos',
            `organizador` = '$organizador', `estado` = '$estado' 
            WHERE `web_pruebas`.`idcarrera` = " . $idCarrera) or die("UPDATE `web_pruebas` SET 
            `temporada` = '$temporada', `web` = '$prueba_web', `titulo` = '$nombre', `fecha` = '$fecha', 
            `fecha_larga` = '$fecha_larga', `poblacion` = '$poblacion', `estado` = '$estado',
            `tipo` = '$id_ca_tipo_prueba', `modo_tiempos` = '$modo_tiempos',
            `organizador` = '$organizador', `estado` = '$estado' 
            WHERE `web_pruebas`.`idcarrera` = " . $idCarrera);
    } else {
        $crear_carreras = $mysqli2->query("INSERT INTO `web_pruebas` (`idcarrera`, `temporada`, `web`, `ruta_tablon`, `titulo`, `fecha`, `fecha_larga`, `poblacion`, `tipo`, `modo_tiempos`, `img_prueba`, `img_organizador`, `img_sponsor`, `organizador`, `estado`, `pilotos_en_pista`) 
            VALUES ('$idCarrera', '$temporada', '$prueba_web', '', '$nombre', '$fecha', '$fecha_larga', '$poblacion', '$id_ca_tipo_prueba', '$modo_tiempos', '', '', '', '$organizador', '$estado', '0')");
>>>>>>> main
    }

    ////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////
    ///////////CREAR SECCIONES / ETAPAS  Y MANGAS   ////////////
    ////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////
    $sql_etapa = $mysqli->query("SELECT descripcion,id,orden FROM abc_57os_ca_etapa WHERE id_ca_carrera='$idCarrera'");
    if ($sql_etapa->num_rows > 0) {
        while ($row = $sql_etapa->fetch_array()) {
            $des_etapa = $row['descripcion'];
            $id_etapa = $row['id'];
            $orden_etapa = $row['orden'];
            echo "<br>" . $id_etapa . " ETAPA: " . $des_etapa;
            $comprobar_etapa = $mysqli->query("SELECT id FROM web_etapa WHERE id = '$id_etapa'");
            // Etapas
            if ($comprobar_etapa->num_rows > 0) {
                $mysqli2->query("UPDATE web_etapa SET descripcion='" . $des_etapa . "', orden='" . $orden_etapa . "' WHERE id=" . $id_etapa);
            } else {
                $crear_etapas = $mysqli2->query("INSERT INTO web_etapa (id,id_usuario,id_ca_carrera,descripcion,orden) VALUES
                ('$id_etapa','2','$idCarrera','$des_etapa','$orden_etapa')");
            }
            $sql_seccion = $mysqli->query("SELECT id, descripcion,orden FROM abc_57os_ca_seccion WHERE id_ca_etapa = '$id_etapa'");
            if ($sql_seccion->num_rows > 0) {
                while ($row2 = $sql_seccion->fetch_array()) {
                    $des_seccion = $row2['descripcion'];
                    $id_seccion = $row2['id'];
                    $orden_seccion = $row2['orden'];
                    echo "<br>" . $id_seccion . " SECCION: " . $des_seccion;
                    $comprobar_seccion = $mysqli2->query("SELECT id FROM web_seccion WHERE id = '$id_seccion'");
                    // Secciones
                    if ($comprobar_seccion->num_rows > 0) {
                        $mysqli2->query("UPDATE web_seccion SET descripcion='" . $des_seccion . "', orden='" . $orden_seccion . "' WHERE id=" . $id_seccion);
                    } else {
                        $crear_seccion = $mysqli2->query("INSERT INTO web_seccion (id,id_usuario,id_ca_etapa,descripcion,orden) VALUES
                        ('$id_seccion','2','$id_etapa','$des_seccion','$orden_seccion')");
                    }
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
                            // Mangas
                            if ($comprobar_manga->num_rows > 0) {
                                $mysqli2->query("UPDATE web_manga SET 
                                    descripcion='" . $des_manga . "', numero='" . $numero . "',
                                    longitud='" . $longitud . "', tipo='" . $tipo . "',
                                    hora_salida='" . $hora . "', estado='" . $estado . "', decimales='" . $decimales . "' WHERE id=" . $id_manga);
                            } else {
                                $crear_mangas = $mysqli2->query("INSERT INTO web_manga (id,id_usuario,id_ca_seccion,descripcion,numero,longitud,tipo,hora_salida,estado,decimales)
                                VALUES('$id_manga','2','$id_seccion','$des_manga','$numero','$longitud','$tipo','$hora','$estado','$decimales')");
                            }
                            echo "<br>" . $id_manga . " MANGA: " . $des_manga;
                            //COMPROBAR SI EXISTEN INTERMEDIOS///////
                            $saber_inter = $mysqli->query("SELECT id,descripcion,orden FROM abc_57os_ca_manga_control_horario WHERE id_ca_manga = '$id_manga' AND orden!=5 AND orden!=10");
                            $afectados_inter = $saber_inter->num_rows;
                            if ($afectados_inter > 0) {
                                while ($row4 = $saber_inter->fetch_array()) {
                                    $id_intermedio = $row4['id'];
                                    $orden_inter = $row4['orden'];
                                    $descripcion_inter = $row4['descripcion'];
                                    echo "<br>INTERMEDIO!!!!! -> : " . $descripcion_inter;
                                    $comprobar_intermedio = $mysqli2->query("SELECT id FROM web_manga_control_horario WHERE id = '$id_intermedio'");
                                    // Intermedios
                                    if ($comprobar_manga->num_rows > 0) {
                                        $mysqli2->query("UPDATE web_manga_control_horario SET descripcion='" . $descripcion_inter . "', orden='" . $orden_inter . "' WHERE id=" . $id_intermedio);
                                    } else {
                                        $insertar_intermedio = $mysqli2->query("INSERT INTO web_manga_control_horario(id,id_usuario,descripcion,orden,id_ca_manga) VALUES('','1','$descripcion_inter','$orden_inter','$id_manga')");
                                    }
                                }
                                echo "<hr>";
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











    // ------------------------------------- //
    // Cogemos los campeonatos de la carrera //
    // ------------------------------------- //
    $campeonatos = $mysqli->query("SELECT * FROM abc_57os_ca_campeonato WHERE id_ca_carrera = '$idCarrera'");

    // Si existen campeonatos
    if ($campeonatos->num_rows > 0) {

        echo "<h3>Campeonatos encontrados <strong>" . $campeonatos->num_rows . "</strong></h3>";

        // Recorre los campeonatos
        while ($campeonato = $campeonatos->fetch_array()) {

            // Datos del campeonato
            $modo_tiempo = $campeonato['tiempo_tipo'];
            $id_campeonato = $campeonato['id'];
            $modalidad = $campeonato['id_ca_modalidad'];
            $nombre_campeonato = $campeonato['nombre'];
            // Fix arregla caracteres
            $nombre_campeonato = str_ireplace(array('Ã‘', 'Ã±'), array('Ñ', 'ñ'), $nombre_campeonato);

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

            // Cuenta el número de mangas oficiales
            $mangas_oficiales = $mysqli->query("SELECT count(manga.id) FROM abc_57os_ca_manga manga 
                        INNER JOIN abc_57os_ca_campeonato_manga campeonato_manga ON campeonato_manga.id_ca_manga=manga.id 
                        WHERE campeonato_manga.id_ca_campeonato='$id_campeonato' AND manga.tipo='1'")->fetch_array();
            $numero_mangas_oficiales = $mangas_oficiales[0];

            echo "<br>Número de mangas oficiales: <strong>" . $numero_mangas_oficiales . "</strong>";

            // Actualiza el campeonato
            $mysqli2->query("DELETE FROM web_campeonatos WHERE id='$id_campeonato'");
            $SQL = "INSERT INTO web_campeonatos (id, idcarrera, nombre, idmodalidad, tipo_tiempo, mangas_oficiales) VALUES ('$id_campeonato', '$idCarrera', '$nombre_campeonato', '$modalidad', '$modo_tiempo', '$numero_mangas_oficiales')";
            if ($mysqli2->query($SQL)) {
                echo "<br><br> - Se ha insertado el campeonato: <strong>" . $nombre_campeonato . "</strong> ID <strong>" . $id_campeonato . "</strong>";
            } else {
                echo "ALERTA: No se ha podido borrar un campeonato SQL: " . $SQL;
            }
        }
    }










    ///////////////////////////////////////////////////////////
    /////INSCRIBIR A CADA PARTICIPANTE EN CADA CAMPEONATO////////
    ///////////////////////////////////////////////////////////
    echo "<br>";
    $consulta_campeonatos = $mysqli->query("SELECT cacom.id_ca_campeonato AS idcampeonato,cacom.id_ca_competidor AS idcompetidor,cam.nombre AS nombre FROM abc_57os_ca_campeonato cam 
    INNER JOIN abc_57os_ca_campeonato_competidor cacom
    ON cacom.id_ca_campeonato = cam.id
    WHERE cam.id_ca_carrera = '$idCarrera'");
    if ($consulta_campeonatos->num_rows > 0) {
        //EVITAR QUE DUPLIQUE LOS INSCRITOS A LOS CAMPEONATOS
        $borrar_inscritos_para_no_cagarla = $mysqli2->query("DELETE FROM web_campeonatos_inscritos WHERE idcarrera='$idCarrera'");
        while ($row = $consulta_campeonatos->fetch_array()) {
            $nombre = $row['nombre'];
            $idcompetidor = $row['idcompetidor'];
            $idcampeonato = $row['idcampeonato'];
            echo "<br>IDCAMP: " . $idcampeonato . " IDCOMP: " . $idcompetidor . " - " . $nombre;
            $inscribir_campeonatos = $mysqli2->query("INSERT INTO web_campeonatos_inscritos (id,idinscrito,idcampeonato,idcarrera) VALUES ('','$idcompetidor','$idcampeonato','$idCarrera')");
        }
        echo '<hr>';
    } else
        echo "<p>No existen campeonatos</p>";
    echo "<br>";
    /***********************SIGUE PROCESANDO.......... ********************/
    $sql = "SELECT com.dorsal AS dorsal,com.id AS idcompetidor,pi.nombre AS piloto,com.id_ca_copiloto_segundo AS copi2,
                    ve.marca AS marca,ve.modelo AS modelo,ve.clase AS clase,ve.grupo AS grupo,pi.nacionalidad AS pi_nac,com.hora_salida AS hora_salida,
                    ve.cilindrada AS cilindrada,ve.cilindrada_turbo AS cilindrada_turbo,ve.categoria AS cat,ve.agrupacion AS agr,com.srally AS sr
                    FROM abc_57os_ca_competidor com 
                    INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto
                    INNER JOIN abc_57os_ca_vehiculo ve ON ve.id=com.id_ca_vehiculo
                    WHERE com.id_ca_carrera='$idCarrera' AND com.excluido=0 ORDER BY com.dorsal ASC";

    $resultado = $mysqli->query($sql) or print "No se pudo acceder al contenido de los tiempos online.";

    ?>
    <table width="100%" border="0" id="tab_tem">
        <thead>
            <tr>
                <th>N.</th>
                <th>Concursante</th>
                <th>Piloto/Copiloto</th>
                <th>M/Of</th>
                <th></th>
                <th>Vehiculo</th>
                <th class="centro">C.C<br>C.C.Turbo</th>
                <th>Camp.</th>
                <th class="centro">Grupo</th>
                <th class="centro">Clase</th>
                <th class="centro">Cat</th>
                <th class="centro">Agru.</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($resultado->num_rows > 0) {
                $pos = 1;
                $par = 0;
                while ($fila = $resultado->fetch_array()) {
                    $dorsal = $fila['dorsal'];
                    $competidor = $fila['concursante'];
                    $cilin = $fila['cilindrada'];
                    $cilin_turbo = $fila['cilindrada_turbo'];
                    $agr = $fila['agr'];
                    $cat = $fila['cat'];
                    $piloto = $fila['piloto'];
                    $copi2 = $fila['copi2'];
                    $sr = $fila['sr'];
                    $sql_copi = $mysqli->query("SELECT copi.nombre AS copiloto,copi.nacionalidad AS nacionalidad FROM abc_57os_ca_copiloto copi 
                INNER JOIN abc_57os_ca_competidor com ON copi.id=com.id_ca_copiloto
                WHERE com.id_ca_carrera = '$idCarrera' AND com.dorsal = '$dorsal'");
                    if ($sql_copi->num_rows > 0) {
                        while ($filaa = $sql_copi->fetch_array()) {
                            $copiloto = $filaa['copiloto'];
                            $copi_nac = $filaa['nacionalidad'];
                        }
                    } else {
                        $copiloto = '';
                        $copi_nac = '';
                    }
                    $vehiculo = $fila['marca'];
                    $modelo = $fila['modelo'];
                    $grupo = $fila['grupo'];
                    $clase = $fila['clase'];
                    $con_nac = $fila['con_nac'];
                    $pi_nac = $fila['pi_nac'];
                    $h_salida = $fila['hora_salida'];
                    $idcompetidor = $fila['idcompetidor'];
                    $sql_comi = "SELECT con.nombre AS competidor,con.nacionalidad AS con_nac FROM abc_57os_ca_concursante con 
                    INNER JOIN abc_57os_ca_competidor com ON con.id=com.id_ca_concursante
                    WHERE com.id_ca_carrera = '$idCarrera' AND com.id='$idcompetidor'";
                    $sql_com = $mysqli->query($sql_comi);
                    if ($sql_com->num_rows > 0) {
                        while ($filacom = $sql_com->fetch_array()) {
                            $competidor = $filacom['competidor'];
                            $con_nac = $filacom['con_nac'];
                        }
                    } else {
                        $competidor = '';
                        $con_nac = '';
                    }
                    if ($h_salida == '')
                        $h_salida = "---";
                    $ordenar[] = array(
                        'dorsal' => $dorsal,
                        'idcompetidor' => $idcompetidor,
                        'competidor' => $competidor,
                        'cilin' => $cilin,
                        'cilin_turbo' => $cilin_turbo,
                        'agr' => $agr,
                        'cat' => $cat,
                        'piloto' => $piloto,
                        'copiloto' => $copiloto,
                        'pi_nac' => $pi_nac,
                        'copi_nac' => $copi_nac,
                        'con_nac' => $con_nac,
                        'vehiculo' => $vehiculo,
                        'modelo' => $modelo,
                        'h_salida' => $h_salida,
                        'sr' => $sr,
                        'grupo' => $grupo,
                        'clase' => $clase
                    );
                }
                foreach ($ordenar as $key => $row) {
                    $aux[$key] = $row['dorsal'];
                }
                array_multisort($aux, SORT_ASC, $ordenar);
                $pos = 1;
                foreach ($ordenar as $key => $row) {
                    $idcompetidor = $row['idcompetidor'];
                    //SABER CUANTAS MANGAS OFICIALES TIENE ESTE PILOTO EN ESTE CAMPEONATO
                    $man_oficiales = $mysqli->query("SELECT man.descripcion FROM abc_57os_ca_manga man 
                        INNER JOIN abc_57os_ca_campeonato_manga caman ON caman.id_ca_manga=man.id 
                        INNER JOIN abc_57os_ca_campeonato cam ON cam.id=caman.id_ca_campeonato 
                        INNER JOIN abc_57os_ca_campeonato_competidor cacom ON cacom.id_ca_campeonato=cam.id 
                        WHERE cam.id_ca_carrera='$idCarrera' AND cacom.id_ca_competidor='$idcompetidor' GROUP BY man.descripcion");
                    $man_ofi = $man_oficiales->num_rows;
                    echo '<tr><td  class="dor">' . $row['dorsal'] . '</td>';
                    if ($no_concusante == 0)
                        echo '<td>' . $row['competidor'] . '-' . $row['con_nac'] . '</td>';
                    else
                        echo '<td></td>';
                    if ($row['copiloto'] != '') {

                        echo "<td>" . $row['piloto'] . "-" . $row['pi_nac'] . "<br>" . $row['copiloto'] . "-" . $row['copi_nac'] . "</td>";
                    } else
                        echo '<td>' . $row['piloto'] . '</td>';

                    echo '<td>' . $man_ofi . '</td><td>' . $row['vehiculo'] . '<br>' . $row['modelo'] . '</td><td class="centro">' . $row['cilin'] . '<br>' . $row['cilin_turbo'] . '</td>';

                    $con_campeonato = "SELECT mo.nombre AS region_campeonato,mo.slug AS slug FROM abc_57os_ca_campeonato_competidor caco
                    INNER JOIN abc_57os_ca_campeonato ca ON caco.id_ca_campeonato = ca.id
                    INNER JOIN abc_57os_ca_modalidad mo ON mo.id=ca.id_ca_modalidad
                    WHERE caco.id_ca_competidor = '$idcompetidor' GROUP BY mo.nombre";
                    $res_con_campeonato = $mysqli->query($con_campeonato);
                    echo "<td class='centro'>";
                    while ($rows = $res_con_campeonato->fetch_array()) {
                        $slug = $rows['slug'];
                        $region = $rows['region_campeonato'];
                        $search  = array('Ã±', 'Ã­');
                        $replace = array('Ñ', 'Í');
                        $region = str_replace($search, $replace, $region);
                        echo "<p class='mini1 nomargen " . $slug . " negrita'>" . strtoupper($region) . "</p>";
                    }
                    echo "</td><td class='centro'>";
                    $res_con_campeonato = $mysqli->query($con_campeonato);
                    while ($rows = $res_con_campeonato->fetch_array()) {
                        $slug = $rows['slug'];
                        $con_grupo = $mysqli->query("SELECT gr.$slug FROM abc_57os_ca_competidor com
                                    INNER JOIN abc_57os_ca_vehiculo ve ON ve.id=com.id_ca_vehiculo
                                    INNER JOIN abc_57os_ca_grupo gr ON gr.id=ve.id_ca_grupo WHERE com.id='$idcompetidor'");
                        while ($fila = $con_grupo->fetch_array()) {
                            $grupo = $fila[$slug];
                        }
                        echo "<p class='mini1 nomargen " . $slug . " negrita'>" . $grupo . "</p>";
                    }
                    echo "</td><td class='centro'>";
                    $res_con_campeonato = $mysqli->query($con_campeonato);
                    while ($rows = $res_con_campeonato->fetch_array()) {
                        $slug = $rows['slug'];
                        $con_clase = $mysqli->query("SELECT cl.$slug FROM abc_57os_ca_competidor com
                                    INNER JOIN abc_57os_ca_vehiculo ve ON ve.id=com.id_ca_vehiculo
                                    INNER JOIN abc_57os_ca_clase cl ON cl.id=ve.id_ca_clase WHERE com.id='$idcompetidor'");
                        while ($fila = $con_clase->fetch_array()) {
                            $clase = $fila[$slug];
                        }
                        echo "<p class='mini1 nomargen " . $slug . " negrita'>" . $clase . "</p>";
                    }
                    echo "</td><td class='centro'>";
                    $res_con_campeonato = $mysqli->query($con_campeonato);
                    while ($rows = $res_con_campeonato->fetch_array()) {
                        $slug = $rows['slug'];
                        $cat = $row['cat'];
                        echo "<p class='mini1 nomargen " . $slug . " negrita'>" . $row['cat'] . "</p>";
                    }
                    echo "</td><td>";
                    $res_con_campeonato = $mysqli->query($con_campeonato);
                    while ($rows = $res_con_campeonato->fetch_array()) {
                        $slug = $rows['slug'];
                        $agr = $row['agr'];
                        echo "<p class='mini1 nomargen " . $slug . " negrita'>" . $row['agr'] . "</p>";
                    }
                    echo "<td class='centro'>" . $grupo . "</td><td class='centro'>" . $clase . "</td><td class='centro'>" . $cat . "</td><td class='centro'>" . $agr . "</td>";

                    $idcompetidor = $row['idcompetidor'];
                    $competidor = $row['competidor'];
                    $cilin = $row['cilin'];
                    $cilin_turbo = $row['cilin_turbo'];
                    $piloto = $row['piloto'];
                    $copiloto = $row['copiloto'];
                    $copiloto2 = $row['copiloto2'];
                    $nac_pi = $row['pi_nac'];
                    $nac_copi = $row['copi_nac'];
                    $nac_con = $row['con_nac'];
                    $vehiculo = $row['vehiculo'];
                    $modelo = $row['modelo'];
                    $grupo = $row['grupo'];
                    $agr = $row['agr'];
                    $cat = $row['cat'];
                    $clase = $row['clase'];
                    $h_s = $row['h_salida'];
                    $sr = $row['sr'];
                    $dorsal = $row['dorsal'];
                    //INSERTAR o ACTUALZIAR TIEMPOS EN web_inscritos
                    $cons = "SELECT idinscrito FROM web_inscritos WHERE idinscrito='$idcompetidor'";
                    $comp = $mysqli2->query($cons);
                    if ($comp->num_rows == 0) {
                        $insertar = "INSERT INTO web_inscritos (idcarrera,idinscrito,concursante,piloto,copiloto,copiloto2,nac_piloto,nac_copiloto,nac_copiloto2,
                    vehiculo,modelo,grupo,clase,agrupacion,categoria,dorsal,cc,cc_turbo,h_s,autorizado,excluido,sr) VALUES ('$idCarrera','$idcompetidor','$competidor','$piloto','$copiloto',
                    '','$nac_pi','$nac_copi','','$vehiculo','$modelo','$grupo','$clase','$agr','$cat','$dorsal','$cilin','$cilin_turbo','$h_s','1','0','$sr')";
                        $insert = $mysqli2->query($insertar) or print("error");
                        $nuevos++;
                    } else {
                        $update = $mysqli2->query("UPDATE web_inscritos SET 
                        concursante='$competidor',
                        piloto='$piloto',
                        copiloto='$copiloto',
                        copiloto2='',
                        nac_piloto='$nac_pi',
                        nac_copiloto='$nac_copi',
                        nac_copiloto2='',
                        nac_competidor='$nac_con',
                        vehiculo='$vehiculo',
                        modelo='$modelo',
                        grupo='$grupo',
                        clase='$clase',
                        agrupacion='$agr',
                        categoria='$cat',
                        cc='$cilin',
                        cc_turbo='$cilin_turbo',
                        dorsal='$dorsal',
                        h_s='$h_s',
                        sr='$sr'
                        WHERE idinscrito='$idcompetidor'") or print("error ACT");
                        $actualizados++;
                    }
                    echo "</td></tr>";
                    $pos++;
                    $par++;
                }
            } else
                echo "No existe lista de inscritos en SISTEMA...";

            echo "REG.NUEVOS: " . $nuevos . "<br>";
            echo "REG.ACTUALIZADOS: " . $actualizados . "<br>";
            ?>
    </table>
    </div>
<?php
} else {
    echo "No se encuentra ninguna carrera con este id";
}