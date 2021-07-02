<?php
	function nombre_prueba($cadena)
	{
	if(stristr($cadena, 'esp') == TRUE || stristr($cadena, 'ESP') == TRUE){
		return "CAMPEONATO DE ESPA&Ntilde;A";
		}
	elseif(stristr($cadena, 'his') == TRUE || stristr($cadena, 'HIS') == TRUE){
		return "HIST&Oacute;RICOS Y PROMOCI&Oacute;N";
		}
	elseif(stristr($cadena, 'and') == TRUE || stristr($cadena, 'AND') == TRUE){
		return "CAMPEONATO DE ANDALUC&Iacute;A";
		}
	else{
		return $cadena;
		}
	}
?>