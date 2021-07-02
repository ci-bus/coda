<?php
//header(location="index.php");
function real_ip() // as string
{
    if ($for = getenv('HTTP_X_FORWARDED_FOR')){
        $afor = explode(",", $for);
        return trim($afor[0]);
    }else
        return getenv('REMOTE_ADDR');
}
function check_in_range($start_date, $end_date, $evaluame) {
			$start_ts = strtotime($start_date);
			$end_ts = strtotime($end_date);
			$user_ts = strtotime($evaluame);
			return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
		}
date_default_timezone_set("Europe/Madrid");
$hora =date("G:i:s");
$fecha = date("j/m/Y");
$ip = real_ip();
$todo= $fecha.(" a las ").$hora;
//$uss = $_POST['uss'];
$pass = $_POST['pass'];
	if (isset($_POST['pass']) && !empty($_POST['pass']))
		{
		include("../conexion.php");
		$sql = $mysqli2->query("SELECT * FROM web_direccion WHERE pass='$pass'") or print("Error Accediendo a la B.D");	
			if($fila=$sql->fetch_array())
				{
				$inicio = $fila['inicio'];
				$fin = $fila['fin'];
				$id=$fila['idcarrera'];
		if (check_in_range($inicio, $fin, date('Y-m-d'))) {
					$activo= 1;
					} else {
					$activo= 0;
					}				
				}
				if($activo==1 || $activo=='1')
					{
					session_start();
					$_SESSION['pass'] = $pass;
					echo "<img src='cargando.gif' style='left:35%;margin: 5% auto;position:absolute;'>";
					//$conexiones = mysql_query("INSERT INTO conexiones (usuario,ip,fecha,id_conexion) VALUES ('$pass','$ip','$todo','')") or die('hubo problemas de acceso a B.D');
					echo '<META HTTP-EQUIV=Refresh CONTENT="1; URL=direccion_web.php?id='.$id.'&modo=tiempo">';			
					}
				else
					{
					echo "<img src='cargando.gif' style='left:35%;margin: 5% auto;position:absolute;'>";
					echo '<META HTTP-EQUIV=Refresh CONTENT="1; URL=index.php?noactivo=1">';
					}
		}
	else
		{
		echo "<img src='cargando.gif' style='left:35%;margin: 5% auto;position:absolute;'>";
		echo '<META HTTP-EQUIV=Refresh CONTENT="1; URL=index.php">';
		}
?>

