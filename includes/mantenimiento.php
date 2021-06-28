<?php
/*esta chapuza se queda aqui temporalmente ;-) el caso que funcione bien*/
	function leer_fichero_completo($nombre_fichero){
   $fichero_texto = fopen ($nombre_fichero, "r");
   $contenido_fichero = fread($fichero_texto, filesize($nombre_fichero));
   return $contenido_fichero;
}
$estado = leer_fichero_completo('estado.txt');
?>