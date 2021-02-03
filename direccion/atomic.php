<?php
date_default_timezone_set('Europe');
$hoy = getdate();
$horas = $hoy['hours'];
$minutos = $hoy['minutes'];
$segundos = $hoy['seconds'];
/*
    if($segundos<48)
        $segundos +=12;
    else{
        $minutos+=1;
        if($segundos==48)
            $segundos=0;
        if($segundos==49)
            $segundos=1; 
        if($segundos==50)
            $segundos=2; 
        if($segundos==51)
            $segundos=3;
        if($segundos==52)
            $segundos=4;    
        if($segundos==53)
            $segundos=5;
        if($segundos==54)
            $segundos=6;
        if($segundos==55)
            $segundos=7; 
        if($segundos==56)
            $segundos=8; 
        if($segundos==57)
            $segundos=9;
        if($segundos==58)
            $segundos=10;    
        if($segundos==59)
            $segundos=11; 
    }*/
$mimanga = $_GET['manga'];
    if(strlen($horas)==1)
    $horas = "0".$horas;
    
    if(strlen($minutos)==1)
         $minutos = "0".$minutos;

    if(strlen($segundos)==1)
        $segundos = "0".$segundos;
    /*    
        $coches_cero = mysql_query("SELECT salida_primero FROM web_direccion2 WHERE idmanga = '$mimanga'");
		if(mysql_num_rows($coches_cero)>0){
				while($myrow = mysql_fetch_array($coches_cero)){
					$comparar = $myrow['salida_primero'];
                }
        }
$comparar2 = $horas.":".$minutos;
    if($comparar==$comparar2)
          echo "<script>document.getElementById('salida').style.display = 'block'</script>"; */
echo $horas.":".$minutos.":".$segundos;
?> 