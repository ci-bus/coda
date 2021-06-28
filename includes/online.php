<?php

function real_ip() // as string
{
    if ($for = getenv('HTTP_X_FORWARDED_FOR')){
        $afor = explode(",", $for);
        return trim($afor[0]);
    }else
        return getenv('REMOTE_ADDR');
}
$time = 1 ;
$date = time() ;
$ip = real_ip();
$limite = $date-$time*60 ;
mysql_query("delete from gente_online where date < $limite") ;
$resp = mysql_query("select * from gente_online where ip='$ip'") ;
if(mysql_num_rows($resp) != 0) {
mysql_query("update gente_online set date='$date' where ip='$ip'") ;
}
else {
mysql_query("insert into gente_online (date,ip) values ('$date','$ip')") ;
}
?>