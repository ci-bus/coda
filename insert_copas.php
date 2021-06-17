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
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
///////////CREAR SECCIONES / ETAPAS  Y MANGAS   ////////////
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
///BUSCAR COPAS PERTENECIENTES A LA CARRERA ////
$misql = "SELECT descripcion,id FROM abc_57os_ca_copa WHERE id_ca_carrera = '$idCarrera'";
$saber_copa_sistema = $mysqli->query($misql)->num_rows;
if($saber_copa_sistema==0)
    echo "NO EXITEN COPA(s) EN SISTEMA EN ESTA PRUEBA";
$con_copas = $mysqli->query($misql);
while ($row2 = $con_copas->fetch_array()) {
    $id = $row2['id'];
    $descripcion = $row2['descripcion'];
    echo "ID: " . $id . " " . $descripcion . "<br>";
    $saber_existe_copa = $mysqli2->query("SELECT id FROM web_copas WHERE id = '$id'")->num_rows;
    if ($saber_existe_copa == 0)
        $mysqli2->query("INSERT INTO web_copas (id,descripcion,idcampeonato,idcarrera) VALUES ('$id','$descripcion','87','$idCarrera')");
    else
        echo "ESTA COPA YA EXISTE EN LA B.D DE LA WEB<br>";
    //BUSCAMOS LOS INSCRITOS A ESTA COPA
    $con_inscritos = $mysqli->query("SELECT id_ca_competidor FROM abc_57os_ca_copa_competidor WHERE id_ca_copa = '$id'");
    while ($row3 = $con_inscritos->fetch_array()) {
        $idinscrito = $row3['id_ca_competidor'];
        echo "ID.INSCRITO: " . $idinscrito . "<br>";
        $saber_existe_inscrito = $mysqli2->query("SELECT id FROM web_copas_inscritos WHERE idcompetidor='$idinscrito' AND idcopa='$id'")->num_rows;
        if ($saber_existe_inscrito == 0)
            $mysqli2->query("INSERT INTO web_copas_inscritos (id,idcopa,idcompetidor) VALUES ('','$id','$idinscrito')");
        else
            echo "ESTE PILOTO YA ESTA INSRITO EN ESTA COPA";
    }
}
