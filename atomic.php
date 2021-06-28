<?php
echo "ATOMIC TIME";
date_default_timezone_set('Europe');
$hoy = getdate();
$horas = $hoy['hours'];
$minutos = $hoy['minutes'];
if(strlen($minutos)==1)
    $minutos = "0".$minutos;
$segundos = $hoy['seconds'];
if($segundos<47)
    $segundos+=13;
else{
    $segundos=0;
    $segundos+=13;
    }
echo "<div id='micapa'>";
echo $horas.":".$minutos.":".$segundos;
echo "</div>";
?> 