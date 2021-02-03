<?php
	function cabecera($valor){
		switch ($valor)
			{
			case 1: return("img/monta.jpg");
			break;
			case 2: return("img/crono.jpg");
			break;
			case 3: return("img/rallye.jpg");
			break;
			case 4: return("img/enduro.jpg");
			break;
			case 5: return("img/subida.jpg");
			break;
			case 6: return("img/rallye.jpg");
			break;
			case 7: return("img/enduro.jpg");
			break;
			case 8: return("img/tierra.jpg");
			break;
			case 9: return("img/subida.jpg");
			break;
			}
	}

	function bandera($cadena){
			if(stristr($cadena, 'esp') == TRUE || stristr($cadena, 'ESP') == TRUE){
				return("img/banderas/esp.jpg");
			}
			else if(stristr($cadena, 'fra') == TRUE){
			   return("img/banderas/fra.jpg");
			}
			else if(stristr($cadena, 'ger') == TRUE){
			   return("img/banderas/germany.jpg");
			}
			else if(stristr($cadena, 'por') == TRUE){
			   return("img/banderas/portugal.jpg");
			}
			else if(stristr($cadena, 'mco') == TRUE){
			   return("img/banderas/monaco.jpg");
			}
			else if(stristr($cadena, 'LIB') == TRUE || stristr($cadena, 'lib') == TRUE){
				return("img/banderas/libano.jpg");
			}
			else if(stristr($cadena, 'AND') == TRUE || stristr($cadena, 'and') == TRUE){
				return("img/banderas/comunidades/andalucia.jpg");
			}
			else if(stristr($cadena, 'ARA') == TRUE || stristr($cadena, 'ara') == TRUE){
				return("img/banderas/comunidades/aragon.jpg");
			}
			else if(stristr($cadena, 'AST') == TRUE || stristr($cadena, 'ast') == TRUE){
				return("img/banderas/comunidades/asturias.jpg");
			}
			else if(stristr($cadena, 'BAL') == TRUE || stristr($cadena, 'bal') == TRUE){
				return("img/banderas/comunidades/baleares.jpg");
			}
			else if(stristr($cadena, 'CAN') == TRUE || stristr($cadena, 'can') == TRUE){
				return("img/banderas/comunidades/canarias.jpg");
			}
			else if(stristr($cadena, 'CAB') == TRUE || stristr($cadena, 'cab') == TRUE){
				return("img/banderas/comunidades/cantabria.jpg");
			}
			else if(stristr($cadena, 'CAT') == TRUE || stristr($cadena, 'cat') == TRUE){
				return("img/banderas/comunidades/catalunia.jpg");
			}
			else if(stristr($cadena, 'EXT') == TRUE || stristr($cadena, 'ext') == TRUE){
				return("img/banderas/comunidades/extremadura.jpg");
			}
			else if(stristr($cadena, 'GAL') == TRUE || stristr($cadena, 'gal') == TRUE){
				return("img/banderas/comunidades/galicia.jpg");
			}
			else if(stristr($cadena, 'LEO') == TRUE || stristr($cadena, 'leo') == TRUE){
				return("img/banderas/comunidades/leon.jpg");
			}
			else if(stristr($cadena, 'MAD') == TRUE || stristr($cadena, 'mad') == TRUE){
				return("img/banderas/comunidades/madrid.jpg");
			}
			else if(stristr($cadena, 'MAN') == TRUE || stristr($cadena, 'man') == TRUE){
				return("img/banderas/comunidades/mancha.jpg");
			}
			else if(stristr($cadena, 'MEL') == TRUE || stristr($cadena, 'mel') == TRUE){
				return("img/banderas/comunidades/melilla.jpg");
			}
			else if(stristr($cadena, 'MUR') == TRUE || stristr($cadena, 'mur') == TRUE){
				return("img/banderas/comunidades/murcia.jpg");
			}
			else if(stristr($cadena, 'NAV') == TRUE || stristr($cadena, 'nav') == TRUE){
				return("img/banderas/comunidades/navarra.jpg");
			}
			else if(stristr($cadena, 'RIO') == TRUE || stristr($cadena, 'rio') == TRUE){
				return("img/banderas/comunidades/rioja.jpg");
			}
			else if(stristr($cadena, 'VAL') == TRUE || stristr($cadena, 'val') == TRUE){
				return("img/banderas/comunidades/valencia.jpg");
			}
			else if(stristr($cadena, 'VAS') == TRUE || stristr($cadena, 'vas') == TRUE){
				return("img/banderas/comunidades/vasco.jpg");
			}
			else
				return("img/banderas/nobandera.jpg");
	}
	function Afecha($fecha){
	$fecha = date_create($fecha);
	$fecha = date_format($fecha, 'd-m-Y');
	return($fecha);
	}
	
	
	function estado($valor){
		switch($valor){
			case 0: $valor="<img src='img/rojo.png' width='12px'>";
			break;
			case 1: $valor="<img src='img/verde.png' width='12px'>";
			break;
			case 2: $valor="<img src='img/amarillo.png' width='12px'>";
			break;
		}
		
		return $valor;
	}
?>