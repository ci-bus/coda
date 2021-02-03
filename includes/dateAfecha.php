<?php
////////////////////////////////////////////////////
//Convierte fecha de mysql a normal
////////////////////////////////////////////////////
function date_a_fecha($fecha){
    ereg("([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
    //$lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
	$lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
    return $lafecha;
}

////////////////////////////////////////////////////
//Convierte fecha de normal a mysql
////////////////////////////////////////////////////

function fecha_a_date($fecha){
    //ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
	ereg("([0-9]{1,2})-([0-9]{1,2})-([0-9]{2,4})", $fecha, $mifecha);
    $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
    return $lafecha;
} 
/*
	Como las dos de arriba no funcionan, creo yo una para ambos casos
*/
function dateFecha($fecha){
	$mifecha = explode("-",$fecha);//separo por -
	$lafecha = $mifecha[2]."-".$mifecha[1]."-".$mifecha[0];
    return $lafecha;
}
/*
 Función para sumar dias a una fecha
*/
//http://dns.bdat.net/trucos/faqphp-v1/x385.html
function fechamasdias($fecha,$ndias){
	list($ano,$mes,$dia)=explode("-",$fecha);
	$nueva = mktime(0,0,0, $mes,$dia,$ano)+($ndias*24*60*60);
	$nuevafecha=date("Y-m-d",$nueva);
	return $nuevafecha;
}
/*
	Función para devolver la diferencia entres dos fechas. (la segunda mayor que la primera devuelve positivo)
*/
// http://www.desarrolloweb.com/articulos/calcular-dias-entre-dos-fechas-php.html
function diferenciafechas($fecha1,$fecha2){// fechas en formato aaaa-mm-dd
//defino fecha 1
$mifecha = explode("-",$fecha1);//separo por -
$ano1 = $mifecha[0]; 
$mes1 = $mifecha[1];
$dia1 = $mifecha[2]; 

//defino fecha 2 
$mifecha = explode("-",$fecha2);//separo por -
$ano2 = $mifecha[0]; 
$mes2 = $mifecha[1];
$dia2 = $mifecha[2]; 

//calculo timestam de las dos fechas 
$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1); 
$timestamp2 = mktime(0,0,0,$mes2,$dia2,$ano2); 

//resto a una fecha la otra 
$segundos_diferencia = $timestamp2 - $timestamp1; 
//echo $segundos_diferencia; 

//convierto segundos en días 
$dias_diferencia = $segundos_diferencia/(60 * 60 * 24); 

//obtengo el valor absoulto de los días (quito el posible signo negativo) 
//$dias_diferencia = abs($dias_diferencia); 

//quito los decimales a los días de diferencia 
$dias_diferencia = floor($dias_diferencia); 

return $dias_diferencia;
}
?>