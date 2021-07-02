<?php
	function escudo($cadena)
		{
			if(stristr($cadena, 'yund') == TRUE){
			   return "<img src='escudos/hyundai.png' width='60px'>";
			}
			elseif(stristr($cadena, 'ugeo') == TRUE){
			   return "<img src='escudos/peugeot.png' width='40px'>";
			}
			elseif(stristr($cadena, 'bmw') == TRUE){
				return "<img src='escudos/bmw.png' width='40px'>";
			}
			elseif(stristr($cadena, 'enau') == TRUE){
			   return "<img src='escudos/renault.png' width='40px'>";
			}
			elseif(stristr($cadena, 'pee') == TRUE){
			   return "<img src='escudos/speed.png' width='40px'>";
			}
			elseif(stristr($cadena, 'pel') == TRUE){
				return "<img src='escudos/opel.png' width='40px'>";
			}
			elseif(stristr($cadena, 'troe') == TRUE){
			   return "<img src='escudos/citroen.png' width='40px'>";
			}
			elseif(stristr($cadena, 'orsch') == TRUE){
			   return "<img src='escudos/porsche.png' width='40px'>";
			}
			elseif(stristr($cadena, 'ford') == TRUE || stristr($cadena, 'Ford') == TRUE || stristr($cadena, 'FORD') == TRUE){
				return "<img src='escudos/ford.png' width='60px' class='esc1'>";
			}
			elseif(stristr($cadena, 'eat') == TRUE){
			   return "<img src='escudos/seat.png' width='40px'>";
			}
			elseif(stristr($cadena, 'olkswa') == TRUE){
				return "<img src='escudos/volkswagen.png' width='50px'>";
			}
			elseif(stristr($cadena, 'ond') == TRUE){
				return "<img src='escudos/honda.png' width='40px'>";
			}
			elseif(stristr($cadena, 'itsubi') == TRUE){
			   return "<img src='escudos/mitsubishi.png' width='40px'>";
			}
			elseif(stristr($cadena, 'ubar') == TRUE){
				return "<img src='escudos/subaru.png' width='60px'>";
			}
			elseif(stristr($cadena, 'uzuk') == TRUE){
				return "<img src='escudos/suzuki.png' width='40px'>";
			}
			elseif(stristr($cadena, 'fiat') == TRUE || stristr($cadena, 'Fiat') == TRUE || stristr($cadena, 'FIAT') == TRUE){
				return "<img src='escudos/fiat.png' width='60px' class='esc1'>";
			}
			elseif(stristr($cadena, 'audi') == TRUE || stristr($cadena, 'Audi') == TRUE || stristr($cadena, 'AUDI') == TRUE){
				return "<img src='escudos/audi.png' width='60px' class='esc1'>";
			}
			elseif(stristr($cadena, 'ercede') == TRUE ){
				return "<img src='escudos/mercedes.png' width='40px' class='esc1'>";
			}
			elseif(stristr($cadena, 'oyot') == TRUE ){
				return "<img src='escudos/toyota.png' width='60px' class='esc1'>";
			}
			elseif(stristr($cadena, 'issan') == TRUE ){
				return "<img src='escudos/nissan.png' width='40px' class='esc1'>";
			}
			elseif(stristr($cadena, 'allope') == TRUE ){
				return "<img src='escudos/galloper.png' width='40px' class='esc1'>";
			}
			elseif(stristr($cadena, 'owle') == TRUE ){
				return "<img src='escudos/bowler.png' width='60px' class='esc1'>";
			}
			elseif(stristr($cadena, 'arrio') == TRUE ){
				return "<img src='escudos/warrior.png' width='60px' class='esc1'>";
			}
			else{
				return "<img src='escudos/coche.png' width='40px'>";
			}
		}
?>