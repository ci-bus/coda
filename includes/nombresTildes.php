<?php
function nombresTildes($texto) {
/*
	ini_set('mssql.charset', 'UTF-8'); antes de la llamada a la base de datos debería funcionar, pero no funciona.
	htmlentities("texto o variable"); funciona pero corro el riesgo de cargarme algo en HTML, ya que lo convertiría a su código para mostrar
	Por tanto, finalmente usaré la funcion utf8_encode("texto o variable") de php
*/	
/*
	ucwords($str);//Cambia a letra Capital cada palabra de un string
	ucfirst($string);//Cambia a letra Capital la primera letra de un string (pone sólo la primera letra en mayuscula)
*/
	//$nombre = utf8_encode($texto);//Convierto a utf8 por si tiene acentos
	$nombre = Capitalizar($texto);//Podría hacerlo en una sola línea todo, pero así queda más claro.
	$nombre = utf8_encode($nombre);//Convierto a utf8 por si tiene acentos
	$nombre = limpiarNombre($nombre);
	return $nombre;
}
function Capitalizar($nombre)
{
    // Definimos un array de articulos (en minuscula)
    $articulos = array(
    '0' => 'a',
    '1' => 'de',
    '2' => 'del',
    '3' => 'la',
    '4' => 'los',
    '5' => 'las',
    );
    // Separamos por espacio
    $palabras = explode(' ', $nombre);
    // creamos la variable que contendrá el nombre
    $nuevoNombre = '';
    // parseamos cada palabra
    foreach($palabras as $elemento){
		//Para el caso de siglas, por ejemplo C.O.D.A.
		if(count(explode('.', $elemento))>1){
			// concatenamos seguido de un espacio
			$nuevoNombre .= strtoupper($elemento)." ";//Directamente en mayusculas
		}
        // si la palabra es un articulo
        else if(in_array(trim(strtolower($elemento)), $articulos)){
            // concatenamos seguido de un espacio
            $nuevoNombre .= strtolower($elemento)." ";
        }
		else {
			// si es un nombre propio, por lo tanto aplicamos
			// las funciones y concatenamos seguido de un espacio
			$nuevoNombre .= ucfirst(strtolower($elemento))." ";
		}
    }
    return trim($nuevoNombre);
}
/*
	Función para cambiarle los caracteres raros (tildes, eñes, etc.) a los archivos que se suben para guardarlos en la DB Ã
*/
function limpiarNombre($texto){
	$p = array('á','é','í','ó','ú','Á','É','Í','Ó','Ú','ñ','Ñ','ç','Ç','ä','ë','ï','ö','ü','à','è','ì','ò','ù','â','ê','î','ô','û','Ä','Ë','á©','Ï','Ö','Ü','À','È','Ì','Ò','Ù','Â','á³','Ê','Î','Ô','Û','´','`','¨','€','£','$','¿','¡','º','ª','@','#','·','%','&','¬','á©','á±','í³','Ã³','Ã©','Ãa','i±','á±','á­a','Á­A','Ã±','Ã­','Ão','ÃA','Ã');
	$r = array('a','e','i','o','u','A','E','I','O','U','n','N','c','C','a','e','i','o','u','a','e','i','o','u','a','e','i','o','u','A','E','é','I','O','U','A','E','I','O','U','A','o','E','I','O','U','','','','E','L','S','','','o','a','a','n','.','p','y','-','e','ñ','ó','ó','e','ñ','ñ','ñ','ía','ÍA','ñ','í','ú','í','ñ');
	$nuevoTexto = str_replace($p, $r, $texto);
	return $nuevoTexto;
}
?>
