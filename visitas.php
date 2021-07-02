<?php

				function buscarendirectorio($ruta,$vueltas){
	$dir="";// Variable para el directorio donde se encuentran los archivos a incluir
	$existe=false;
	for($i=0;$i<$vueltas && !$existe;$i++){
		if(file_exists($ruta)){
			$existe=true;
		}
		else {
			$dir="../".$dir;
			$ruta="../".$ruta;
		}
	}
	if($existe){
		return $dir;
	}
	else {
		return false;
	}
}
// Contador de visitas
$archivo="index.php";// index.php o cualquier archivo que esté en la carpeta raiz (login.php y Administrar.php estan en la raid)
$vueltas=3;
$dir=buscarendirectorio($archivo,$vueltas);
//Calcular IP real
if(isset($_SERVER)){
	if(isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
		$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	} 
	elseif(isset($_SERVER["HTTP_CLIENT_IP"])){
		$realip = $_SERVER["HTTP_CLIENT_IP"];
	}
	else {
		$realip = $_SERVER["REMOTE_ADDR"];
	}
}
else {
	if(getenv("HTTP_X_FORWARDED_FOR")){
		$realip = getenv("HTTP_X_FORWARDED_FOR");
	}
	elseif(getenv("HTTP_CLIENT_IP")){
		$realip = getenv("HTTP_CLIENT_IP");
	}
	else {
		$realip = getenv("REMOTE_ADDR");
	} 
}
// Contador de visitas
$ip = $realip;//$_SERVER["REMOTE_ADDR"];
$hoy = date("Y-m-d");

$resultado = $mysqli2->query("SELECT idVisita, ip, ultima, total FROM web_visitas WHERE ip='$ip'");
if($resultado->num_rows != 0){//Si la IP ya está en la base de datos
	$row = $resultado->fetch_array();
	$idVisita = $row['idVisita'];
	$total = $row['total'];
	$ultima = $row['ultima'];
	if($ultima != $hoy){
	$total = $total+1;
	$query = $mysqli2->query("UPDATE web_visitas SET ultima = '$hoy', total = '$total' WHERE visitas.idVisita = $idVisita");
	}
}
else {//Si no está la IP en la BD
	$query = $mysqli2->query("INSERT INTO web_visitas values ('0', '$ip', '$hoy', '1')");
}
//Visitas desde diferentes IPs hoy
$query = $mysqli2->query("SELECT COUNT(*) as today FROM web_visitas WHERE ultima = '$hoy'");
$row = $query->fetch_array();
$visitasHoy = $row['today'];
//Visitas totales desde diferentes IPs
$query = $mysqli2->query("SELECT SUM(total) as todas FROM web_visitas");
$resultado = $query->fetch_array();
$visitasTotales = $resultado['todas'];
//@mysql_free_result($resultado);
//mysql_close($conexion);
//Escribir las visitas
//Fin de Contador de visitas
$mes_actual = date('m');
$j=0;
			$este_anio = date('Y');
			$sql = $mysqli2->query("SELECT ultima from web_visitas");
			if($sql->num_rows>0)
							{
							while($fil= $sql->fetch_array())
								{
								$fecha = $fil['ultima'];
								$fecha2 = $fecha;
								$fecha2 = substr($fecha2,0,4);								
								$fecha = substr($fecha,5,2);
									if($este_anio==$fecha2)
										{
										$a++;
										if($fecha == $mes_actual)
											$j++;
										}
								}
							}
	//include('browser_class_inc.php');
	/*AGENTES Y NAVEGADORES
$br = new browser();
$br->whatBrowser();
$version = $br->version; 
$navegador = $br->browsertype;
$platform = $br->platform;
	switch($platform)
		{
			case($platform=='Windows'): $sql_pla= mysql_query("SELECT contador FROM web_navegador WHERE id_navegador='2'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE web_navegador SET contador='$cont' WHERE id_navegador='2'");
				break;
			case($platform=='Linux'): $sql_pla= mysql_query("SELECT contador FROM web_navegador WHERE id_navegador='1'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE web_navegador SET contador='$cont' WHERE id_navegador='1'");
				break;
			case($platform=='Macintosh'): $sql_pla= mysql_query("SELECT contador FROM web_navegador WHERE id_navegador='3'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE web_navegador SET contador='$cont' WHERE id_navegador='3'");
				break;
			case($platform=='OS/2'): $sql_pla= mysql_query("SELECT contador FROM web_navegador WHERE id_navegador='4'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE web_navegador SET contador='$cont' WHERE id_navegador='4'");
				break;
			case($platform=='BeOS'): $sql_pla= mysql_query("SELECT contador FROM web_navegador WHERE id_navegador='5'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE web_navegador SET contador='$cont' WHERE id_navegador='5'");
				break;
			case($platform=!'BeOS' || $platform!='Windows' || $platform!='Linux' || $platform!='Macintosh' || $platform!='OS/2'): 
										$sql_pla= mysql_query("SELECT contador FROM web_navegador WHERE id_navegador='21'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE web_navegador SET contador='$cont' WHERE id_navegador='21'");
				break;	
		}
	switch($navegador)
		{
			case ($navegador=='Firefox'):	$sql_pla= mysql_query("SELECT contador FROM web_navegador WHERE id_navegador='6'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE web_navegador SET contador='$cont' WHERE id_navegador='6'");
				break;
			case ($navegador=='Chrome'):	$sql_pla= mysql_query("SELECT contador FROM web_navegador WHERE id_navegador='15'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE web_navegador SET contador='$cont' WHERE id_navegador='15'");
				break;
			case ($navegador=='opera'):	$sql_pla= mysql_query("SELECT contador FROM web_navegador WHERE id_navegador='8'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE web_navegador SET contador='$cont' WHERE id_navegador='8'");
				break;
			case ($navegador=='MSIE'):		
										$sql_pla= mysql_query("SELECT contador FROM web_navegador WHERE id_navegador='10'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE web_navegador SET contador='$cont' WHERE id_navegador='10'");
				break;
			case ($navegador=='Konqueror'):		
										$sql_pla= mysql_query("SELECT contador FROM web_navegador WHERE id_navegador='16'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE web_navegador SET contador='$cont' WHERE id_navegador='16'");
				break;
			case ($navegador=='webtv'):		
										$sql_pla= mysql_query("SELECT contador FROM web_navegador WHERE id_navegador='18'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE web_navegador SET contador='$cont' WHERE id_navegador='18'");
				break;
			case ($navegador=='Safari'):		
										$sql_pla= mysql_query("SELECT contador FROM web_navegador WHERE id_navegador='20'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE web_navegador SET contador='$cont' WHERE id_navegador='20'");
				break;
			case ($navegador=='netscape' || $navegador=='Netscape'):		
										$sql_pla= mysql_query("SELECT contador FROM web_navegador WHERE id_navegador='7'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE web_navegador SET contador='$cont' WHERE id_navegador='7'");
				break;
			case ($navegador!='Safari' || $navegador!='Firefox' || $navegador!='Chrome' || $navegador!='opera' || $navegador!='MSIE' || $navegador!='Konqueror' || $navegador!='webtv' || $navegador!='netscape'):		
										$sql_pla= mysql_query("SELECT contador FROM web_navegador WHERE id_navegador='13'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE web_navegador SET contador='$cont' WHERE id_navegador='13'");
				break;
		}
$sql = mysql_query("SELECT contador FROM web_navegador WHERE id_navegador='28'");
										$cont2 = @mysql_result($sql, 0, "contador");
										$cont2++;
										$sql_pla2=mysql_query("UPDATE web_navegador SET contador='$cont2' WHERE id_navegador='28'");
										*/
?>