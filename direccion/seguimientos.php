<?php

//lo primero es hacer la pedazo de consulta
include_once 'conexion.php';
include_once("funcionesTiempos.php");//Para algunas funciones que hacen falta para los tiempos online
include_once("include/nombresTildes.php");//Para formatear los nombres, especialmente los de las pruebas creadas por el programa


if(isset($_GET["manga"]) && isset($_GET["pruebaprograma"]) && isset($_GET['copa'])){
	$idManga = $_GET["manga"];
	$idCarrera = $_GET["pruebaprograma"];
    $idCopa = $_GET["copa"];
	

// RENUEVA CONSULTA HECHA POR JUANMA PARA PONERLOS POR TIEMPOS DE SALIDA del primer control intermedio

        $dbQuery = "SELECT i.dorsal
     , i.piloto
     , i.copiloto
     , i.concursante
     , i.vehiculo
     , i.clase
     , i.cilindrada
     , t1.tiempo_salida
     , t1.tiempo_llegada
     , t1.tiempo_total
     
FROM
tiempos t1
JOIN inscritos i
ON  i.idinscritos = t1.idinscritos

WHERE
  t1.idmangas = $idManga AND t1.idcarreras = $idCarrera
  AND i.autorizado = 1 AND i.excluido = 0
ORDER BY
  t1.tiempo_salida ASC";

$resultado = mysql_query($dbQuery) or print "No se pudo acceder al contenido de los tiempos online.";
if(mysql_num_rows($resultado)>0)
{
    while($fila = mysql_fetch_array($resultado))
    {
        // el div con el estilo
        if($fila['tiempo_llegada'] == 0 && $fila['tiempo_salida'] == 0){
            echo '<div  class="celda_seguimiento">';
        }else {
        echo '<div  class="celda_seguimiento celda_seguimiento_con_llegada">';
        }
        
        
        // LA DORSAL
        echo '<div class="divDorsalSeguimiento">' .  $fila['dorsal'] .' </div>';
        
        // el titulo del campo
        echo '<div style="color:black; font-size:12px; font-weight: bold; margin-left:5px"><div style="float:left; display:inline; width:60px"> SALIDA: </div>'. FormatearTiempo($fila["tiempo_salida"]) .'</div>';
        // el tiempo de llegada
        echo '<div style="color:black; font-size:12px;font-weight: bold; margin-left:5px "><div style="float:left; display:inline; width:60px">LLEGADA: </div>'. FormatearTiempo($fila["tiempo_llegada"]) .'</div>';
        // el total
        echo '<div style="color:red; font-size:12px;font-weight: bold; text-align:center">TOTAL: '. FormatearTiempo($fila["tiempo_total"]) .'</div>';
        
        echo '</div>';
    }
    
    
}else{
        echo '<div  style="float:left; display:inline">';
        echo 'NO EXISTEN SEGUIMIENTOS PARA ESTA PRUEBA';
        echo '</div>';
    
    }
}
?>
