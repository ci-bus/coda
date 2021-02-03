<?php
	function cortarFrase($frase, $maxPalabras = 1, $noTerminales = ["de"]) {
	  $palabras = explode(" ", $frase);
	  $numPalabras = count($palabras);
	  if ($numPalabras > $maxPalabras) {
		 $offset = $maxPalabras - 1;
		 while (in_array($palabras[$offset], $noTerminales) && $offset < $numPalabras) { $offset++; }
		 return implode(" ", array_slice($palabras, 2, $offset + 1));
	  }
	  return $frase;
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
	function segundos_a_milisegundos($segundos){
		$segundos = $segundos*1000;
		return $segundos;
	}
?>