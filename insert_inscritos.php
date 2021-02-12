<?php
/*BASE DE DATOS DE SERVER CODA
$IPservidor = "localhost:3306";
$nombreBD = "codea_es_sistema";
$usuario = "manuel";
$clave = "coda200900==";
*/
/*BASE DE DATOS DEL SERVIDOR DE JOSE*/
$IPservidor = "sistema2020.codea.es";
$nombreBD = "codea_sistema";
$usuario = "codea_sistema_user";
$clave = "n^;eRM8+MWZu";
$mysqli = new mysqli($IPservidor, $usuario, $clave, $nombreBD);
$mysqli->set_charset("utf8");

$IPservidor2 = "localhost:3306";
$nombreBD2 = "web2020";
$usuario2 = "web2020";
$clave2 = "Kp!vt750";
$mysqli2 = new mysqli($IPservidor2, $usuario2, $clave2, $nombreBD2);
$mysqli2->set_charset("utf8");

$nuevos = 0;
$actualizados = 0;

$idCarrera = $_GET["id"];

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
                /*if($copi2!=0 || $copi2!='0' || !empty($copi2)){
			$sql_copi2 = $mysqli->query("SELECT copi.nombre AS copiloto,copi.nacionalidad AS nacionalidad FROM abc_57os_ca_copiloto copi 
			INNER JOIN abc_57os_ca_competidor com ON copi.id=com.id_ca_copiloto_segundo
			WHERE com.id_ca_carrera = '$idCarrera' AND com.id_ca_copiloto_segundo = '$copi2'");
				if($sql_copi2->num_rows>0)
					{
					$copi2 = @mysql_result($sql_copi2, 0, "copiloto");
					$copi2_nac = @mysql_result($sql_copi2, 0, "nacionalidad");
					$copi2_nacs = explode('/',$copi2_nac);
					$copi2_nac1 = bandera($copi2_nacs[0]);
					$copi2_nac2 = bandera($copi2_nacs[1]);
					}
				}
				else{
					$copi2 ='';
					$copi2_nac = '';
					}*/
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
                    //echo "<p class='mini1 nomargen espana negrita'>ESPAÑA</p>";
                    //echo "<p class='mini1 nomargen europa negrita'>EUROPA</p>";
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
                    //$clase = @mysql_result($con_clase, 0, $slug);
                    echo "<p class='mini1 nomargen " . $slug . " negrita'>" . $clase . "</p>";
                    //echo "<p class='mini1 nomargen andalucia negrita'>clase</p>";
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
				'','$nac_pi','$nac_copi','','$vehiculo','$modelo','$grupo','$clase','$agr','$cat','$dorsal','$cilin','$cilin_turbo','$h_s','0','0','$sr')";
                    $insert = $mysqli2->query($insertar) or print("error");
                    $nuevos++;
                } else {
                    //echo $copiloto."<br>";
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