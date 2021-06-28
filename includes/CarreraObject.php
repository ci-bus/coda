<?php
class Carrera{
	//Variables: idcarreras, descripcion, fecha_larga, organizador, fecha, idWeb, titulo, poblacion
    var $idGrupo;
    var $idCarrera;
	var $idWeb;
    var $descripcion;
    var $fecha_larga;
    var $organizador;
	var $fecha;
	var $titulo;
	var $poblacion;
	var $imagen;

//Constructor 1
/*
function Carrera($idGrupo=0,$idCarrera=0,$idWeb=0,$descripcion="",$fecha_larga="",$organizador="",$fecha="2000-01-01",$titulo="",$poblacion=""){
	$this->idGrupo=$idGrupo;
    $this->idCarrera=$idCarrera;
	$this->idWeb=$idWeb;
    $this->descripcion=$descripcion;
    $this->fecha_larga=$fecha_larga;
    $this->organizador=$organizador;
	$this->fecha=$fecha;
	$this->titulo=$titulo;
	$this->poblacion=$poblacion;
}
*/
//Constructor 2
function __construct($idGrupo=0,$idCarrera=0,$idWeb=0,$descripcion="",$fecha_larga="",$organizador="",$fecha="2000-01-01",$titulo="",$poblacion="",$imagen=""){
	$this->idGrupo=$idGrupo;
    $this->idCarrera=$idCarrera;
	$this->idWeb=$idWeb;
    $this->descripcion=$descripcion;
    $this->fecha_larga=$fecha_larga;
    $this->organizador=$organizador;
	$this->fecha=$fecha;
	$this->titulo=$titulo;
	$this->poblacion=$poblacion;
	$this->imagen=$imagen;
}

function __destruct(){
	//echo "<br>destruido: " . $this->titulo;
}

/*
function introduce($cosa){
    $this->contenido = $cosa;
}

function muestra_contenido(){
    echo $this->contenido;
}
*/
public static function compararCarreras($a, $b){//comparar carreras por fecha
    $fechaa=$a->fecha;
	$fechab=$b->fecha;
	if ($fechaa == $fechab) {
        return 0;
    }
    //return ($fechaa < $fechab) ? -1 : 1;// Orden Ascendente
	return ($fechaa < $fechab) ? 1 : -1;// Orden Descendente
}
}// Fin Clase Carrera
?>
