<?php
function NumeroMangas ($idcarreras,$orden)
{
//include('Connections/TiemposOnline.php');
$query = sprintf('select count(idmangas) as numero from mangas where tipo_manga=1 and orden <=%s and idcarreras=%s'
, GetSQLValueString($orden, "int"), GetSQLValueString($idcarreras, "text"));
$Datos = mysql_query($query) or die(mysql_error());
$row_Datos = mysql_fetch_assoc($Datos);
return $row_Datos['numero'];

}

function MaxOrdenMangas ($idcarreras)
{
//include('Connections/TiemposOnline.php');
$query = sprintf('select MAX(orden) max_orden from mangas where idcarreras=%s and tipo_manga=1'
, GetSQLValueString($idcarreras, "int"));
$Datos = mysql_query($query) or die(mysql_error());
$row_Datos = mysql_fetch_assoc($Datos);
return $row_Datos['max_orden'];
}
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
  
  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
function FormatearTiempo ($tiempo)
{
   $miles = $tiempo % 1000;
   $tiempo = intval($tiempo / 1000);
//  $tiempo = date("H:i:s" , $tiempo).".".str_pad($miles,3,'0',STR_PAD_LEFT);
$horas = intval($tiempo / 3600);
$tiempo = $tiempo % 3600;
$min = intval($tiempo / 60);
$seg = $tiempo % 60;
#   $tiempo = strftime("%H:%M:%S" , $tiempo).".".str_pad($miles,3,'0',STR_PAD_LEFT);
   $tiempo = str_pad($horas,2,'0',STR_PAD_LEFT).":".str_pad($min,2,'0',STR_PAD_LEFT).':'.str_pad($seg,2,'0',STR_PAD_LEFT).'.'.str_pad($miles,3,'0',STR_PAD_LEFT);

   return  $tiempo;

}
/*
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
			if(strlen($hora)==1)
				$hora = '0'.$hora;
        $mili = $mili - ($hora * $h);
        $minuto = floor($mili / $m);
        $mili = $mili - ($minuto * $m);
        $segundo = floor($mili / $s);
        $mili = $mili - ($segundo * $s);
		if(strlen($hora)==1)
				$hora = '0'.$hora;
		if(strlen($minuto)==1)
				$minuto = '0'.$minuto;
		if(strlen($segundo)==1)
				$segundo = '0'.$segundo;
		if(strlen($mili)==1)
				$mili = $mili.'00';
        return $hora.':'.$minuto.':'.$segundo.'.'.$mili;
    }
	*/
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
            if (strlen($hora.'') == 1) $hora = '0'.$hora;
            if (strlen($minuto.'') == 1) $minuto = '0'.$minuto;
            if (strlen($segundo.'') == 1) $segundo = '0'.$segundo;
            if (strlen($mili.'') == 1) $mili = '00'.$mili;
            else if (strlen($mili.'') == 2) $mili = '0'.$mili;
            $time = $minuto.':'.$segundo.'.'.$mili;
            if ($hora != '00') {
                $time = $hora.':'.$time;
            }
            return $time;
        } else return $mili;
    }

	function segundos_a_milisegundos($segundos){
		$segundos = $segundos*1000;
		return $segundos;
	}
function acortar_nombre($nombre){
	if($nombre=='DEDO')
		return $nombre;
	else{
		$excepciones = array('DE','de','De');
		$nom = '';
		$acortar = explode(" ",$nombre);
		$long = count($acortar);
			if($long==3) //EL NOMBRE ES NOMBRE+APELLIDO+2APELLIDO
				{
				$nom = substr($acortar[0],0,1)."."; //COJO EL NOMBRE
				$nom = $nom." ".$acortar[1]." ".$acortar[2];
				}
			if($long>3) //EL NOMBRE PODRIA SER COMPUESTO
				{
				$nom = substr($acortar[0],0,1)."."; //COJO EL NOMBRE
				for($i=1;$i<$long;$i++) //BUSCO SI ES COMPUESTO
					{
					if(strlen($acortar[$i])==1)
						$nom = $nom.".".$acortar[$i];
					else
						$nom = $nom." ".$acortar[$i];
					}
				}
			if($long<=2){
				$nom = substr($acortar[0],0,1)."."; //COJO EL NOMBRE
				$nom = $nom." ".$acortar[1]." ".$acortar[2];
			}
			return $nom;
		}
}
?>