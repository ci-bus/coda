<<<<<<< HEAD
<?php
	function escudo($cadena)
		{
			if(stristr($cadena, 'yund') == TRUE){
			   return "<img src='img/escudos/hyundai.png' width='35px'>";
			}
			if(stristr($cadena, 'mini') == TRUE){
			   return "<img src='img/escudos/mini.png' width='35px'>";
			}
			elseif(stristr($cadena, 'mv') == TRUE ){
				return "<img src='img/escudos/mvracing.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'ugeo') == TRUE){
			   return "<img src='img/escudos/peugeot.png' width='30px'>";
			}
			elseif(stristr($cadena, 'sko' ) == TRUE || stristr($cadena, 'Sko') == TRUE ){
			   return "<img src='img/escudos/skoda.png' width='30px'>";
			}
			elseif(stristr($cadena, 'bmw') == TRUE){
				return "<img src='img/escudos/bmw.png' width='30px'>";
			}
			elseif(stristr($cadena, 'dacia') == TRUE){
				return "<img src='img/escudos/dacia.png' width='30px'>";
			}
			elseif(stristr($cadena, 'herrador') == TRUE){
				return "<img src='img/escudos/herrador.png' width='30px'>";
			}
			elseif(stristr($cadena, 'talex') == TRUE){
				return "<img src='img/escudos/talex.png' width='30px'>";
			}
			elseif(stristr($cadena, 'brc') == TRUE){
				return "<img src='img/escudos/brc.png' width='30px'>";
			}
			elseif(stristr($cadena, 'silver') == TRUE){
				return "<img src='img/escudos/silver.png' width='30px'>";
			}
			elseif(stristr($cadena, 'polari') == TRUE){
				return "<img src='img/escudos/polaris.png' width='30px'>";
			}
			elseif(stristr($cadena, 'abart') == TRUE){
				return "<img src='img/escudos/abarth.png' width='30px'>";
			}
			elseif(stristr($cadena, 'enau') == TRUE){
			   return "<img src='img/escudos/renault.png' width='30px'>";
			}
			elseif(stristr($cadena, 'pee') == TRUE){
			   return "<img src='img/escudos/speedcar.png' width='30px'>";
			}
			elseif(stristr($cadena, 'pel') == TRUE){
				return "<img src='img/escudos/opel.png' width='30px'>";
			}
			elseif(stristr($cadena, 'troe') == TRUE){
			   return "<img src='img/escudos/citroen.png' width='30px'>";
			}
			elseif(stristr($cadena, 'orsch') == TRUE){
			   return "<img src='img/escudos/porsche.png' width='30px'>";
			}
			elseif(stristr($cadena, 'ford') == TRUE || stristr($cadena, 'Ford') == TRUE || stristr($cadena, 'FORD') == TRUE){
				return "<img src='img/escudos/ford.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'eat') == TRUE){
			   return "<img src='img/escudos/seat.png' width='30px'>";
			}
			elseif(stristr($cadena, 'olkswa') == TRUE){
				return "<img src='img/escudos/volkswagen.png' width='35px'>";
			}
			elseif(stristr($cadena, 'ond') == TRUE){
				return "<img src='img/escudos/honda.png' width='30px'>";
			}
			elseif(stristr($cadena, 'itsubi') == TRUE){
			   return "<img src='img/escudos/mitsubishi.png' width='30px'>";
			}
			elseif(stristr($cadena, 'ubar') == TRUE){
				return "<img src='img/escudos/subaru.png' width='35px'>";
			}
			elseif(stristr($cadena, 'uzuk') == TRUE){
				return "<img src='img/escudos/suzuki.png' width='30px'>";
			}
			elseif(stristr($cadena, 'fiat') == TRUE || stristr($cadena, 'Fiat') == TRUE || stristr($cadena, 'FIAT') == TRUE){
				return "<img src='img/escudos/fiat.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'audi') == TRUE || stristr($cadena, 'Audi') == TRUE || stristr($cadena, 'AUDI') == TRUE){
				return "<img src='img/escudos/audi.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'ercede') == TRUE ){
				return "<img src='img/escudos/mercedes.png' width='30px' class='esc1'>";
			}
			elseif(stristr($cadena, 'oyot') == TRUE ){
				return "<img src='img/escudos/toyota.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'issan') == TRUE ){
				return "<img src='img/escudos/nissan.png' width='30px' class='esc1'>";
			}
			elseif(stristr($cadena, 'allope') == TRUE ){
				return "<img src='img/escudos/galloper.png' width='30px' class='esc1'>";
			}
			elseif(stristr($cadena, 'owle') == TRUE ){
				return "<img src='img/escudos/bowler.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'can') == TRUE ){
				return "<img src='img/escudos/canam.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'yamah') == TRUE ){
				return "<img src='img/escudos/yamaha.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'man') == TRUE ){
				return "<img src='img/escudos/man.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'ktm') == TRUE ){
				return "<img src='img/escudos/ktm.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'husq') == TRUE ){
				return "<img src='img/escudos/husqvarna.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'arrio') == TRUE ){
				return "<img src='img/escudos/warrior.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'husab') == TRUE ){
				return "<img src='img/escudos/husaberg.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'sher') == TRUE ){
				return "<img src='img/escudos/sherco.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'lancia') == TRUE ){
				return "<img src='img/escudos/lancia.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'beta') == TRUE ){
				return "<img src='img/escudos/beta.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'land') == TRUE ){
				return "<img src='img/escudos/landrover.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'vm') == TRUE ){
				return "<img src='img/escudos/vmcomp.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'mazda') == TRUE ){
				return "<img src='img/escudos/mazda.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'ginetta') == TRUE ){
				return "<img src='img/escudos/ginetta.png' width='35px' class='esc1'>";
			}
			else{
				return "<img src='img/escudos/coche.png' width='30px'>";
			}
		}
=======
<?php
	function escudo($cadena)
		{
			if(stristr($cadena, 'yund') == TRUE){
			   return "<img src='img/escudos/hyundai.png' width='35px'>";
			}
			if(stristr($cadena, 'mini') == TRUE){
			   return "<img src='img/escudos/mini.png' width='35px'>";
			}
			elseif(stristr($cadena, 'mv') == TRUE ){
				return "<img src='img/escudos/mvracing.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'ugeo') == TRUE){
			   return "<img src='img/escudos/peugeot.png' width='30px'>";
			}
			elseif(stristr($cadena, 'sko' ) == TRUE || stristr($cadena, 'Sko') == TRUE ){
			   return "<img src='img/escudos/skoda.png' width='30px'>";
			}
			elseif(stristr($cadena, 'bmw') == TRUE){
				return "<img src='img/escudos/bmw.png' width='30px'>";
			}
			elseif(stristr($cadena, 'dacia') == TRUE){
				return "<img src='img/escudos/dacia.png' width='30px'>";
			}
			elseif(stristr($cadena, 'herrador') == TRUE){
				return "<img src='img/escudos/herrador.png' width='30px'>";
			}
			elseif(stristr($cadena, 'talex') == TRUE){
				return "<img src='img/escudos/talex.png' width='30px'>";
			}
			elseif(stristr($cadena, 'brc') == TRUE){
				return "<img src='img/escudos/brc.png' width='30px'>";
			}
			elseif(stristr($cadena, 'silver') == TRUE){
				return "<img src='img/escudos/silver.png' width='30px'>";
			}
			elseif(stristr($cadena, 'polari') == TRUE){
				return "<img src='img/escudos/polaris.png' width='30px'>";
			}
			elseif(stristr($cadena, 'abart') == TRUE){
				return "<img src='img/escudos/abarth.png' width='30px'>";
			}
			elseif(stristr($cadena, 'enau') == TRUE){
			   return "<img src='img/escudos/renault.png' width='30px'>";
			}
			elseif(stristr($cadena, 'pee') == TRUE){
			   return "<img src='img/escudos/speedcar.png' width='30px'>";
			}
			elseif(stristr($cadena, 'pel') == TRUE){
				return "<img src='img/escudos/opel.png' width='30px'>";
			}
			elseif(stristr($cadena, 'troe') == TRUE){
			   return "<img src='img/escudos/citroen.png' width='30px'>";
			}
			elseif(stristr($cadena, 'orsch') == TRUE){
			   return "<img src='img/escudos/porsche.png' width='30px'>";
			}
			elseif(stristr($cadena, 'ford') == TRUE || stristr($cadena, 'Ford') == TRUE || stristr($cadena, 'FORD') == TRUE){
				return "<img src='img/escudos/ford.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'eat') == TRUE){
			   return "<img src='img/escudos/seat.png' width='30px'>";
			}
			elseif(stristr($cadena, 'olkswa') == TRUE){
				return "<img src='img/escudos/volkswagen.png' width='35px'>";
			}
			elseif(stristr($cadena, 'ond') == TRUE){
				return "<img src='img/escudos/honda.png' width='30px'>";
			}
			elseif(stristr($cadena, 'itsubi') == TRUE){
			   return "<img src='img/escudos/mitsubishi.png' width='30px'>";
			}
			elseif(stristr($cadena, 'ubar') == TRUE){
				return "<img src='img/escudos/subaru.png' width='35px'>";
			}
			elseif(stristr($cadena, 'uzuk') == TRUE){
				return "<img src='img/escudos/suzuki.png' width='30px'>";
			}
			elseif(stristr($cadena, 'fiat') == TRUE || stristr($cadena, 'Fiat') == TRUE || stristr($cadena, 'FIAT') == TRUE){
				return "<img src='img/escudos/fiat.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'audi') == TRUE || stristr($cadena, 'Audi') == TRUE || stristr($cadena, 'AUDI') == TRUE){
				return "<img src='img/escudos/audi.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'ercede') == TRUE ){
				return "<img src='img/escudos/mercedes.png' width='30px' class='esc1'>";
			}
			elseif(stristr($cadena, 'oyot') == TRUE ){
				return "<img src='img/escudos/toyota.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'issan') == TRUE ){
				return "<img src='img/escudos/nissan.png' width='30px' class='esc1'>";
			}
			elseif(stristr($cadena, 'allope') == TRUE ){
				return "<img src='img/escudos/galloper.png' width='30px' class='esc1'>";
			}
			elseif(stristr($cadena, 'owle') == TRUE ){
				return "<img src='img/escudos/bowler.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'can') == TRUE ){
				return "<img src='img/escudos/canam.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'yamah') == TRUE ){
				return "<img src='img/escudos/yamaha.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'man') == TRUE ){
				return "<img src='img/escudos/man.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'ktm') == TRUE ){
				return "<img src='img/escudos/ktm.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'husq') == TRUE ){
				return "<img src='img/escudos/husqvarna.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'arrio') == TRUE ){
				return "<img src='img/escudos/warrior.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'husab') == TRUE ){
				return "<img src='img/escudos/husaberg.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'sher') == TRUE ){
				return "<img src='img/escudos/sherco.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'lancia') == TRUE ){
				return "<img src='img/escudos/lancia.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'beta') == TRUE ){
				return "<img src='img/escudos/beta.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'land') == TRUE ){
				return "<img src='img/escudos/landrover.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'vm') == TRUE ){
				return "<img src='img/escudos/vmcomp.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'mazda') == TRUE ){
				return "<img src='img/escudos/mazda.png' width='35px' class='esc1'>";
			}
			elseif(stristr($cadena, 'ginetta') == TRUE ){
				return "<img src='img/escudos/ginetta.png' width='35px' class='esc1'>";
			}
			else{
				return "<img src='img/escudos/coche.png' width='30px'>";
			}
		}
>>>>>>> main
?>