<?php
	include('browser_class_inc.php');
	include('conexion.php');
	/*AGENTES Y NAVEGADORES*/
$br = new browser();
$br->whatBrowser();
$version = $br->version; 
$navegador = $br->browsertype;
$platform = $br->platform;
	switch($platform)
		{
			case($platform=='Windows'): $sql_pla= mysql_query("SELECT contador FROM navegador WHERE id_navegador='2'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE navegador SET contador='$cont' WHERE id_navegador='2'");
				break;
			case($platform=='Linux'): $sql_pla= mysql_query("SELECT contador FROM navegador WHERE id_navegador='1'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE navegador SET contador='$cont' WHERE id_navegador='1'");
				break;
			case($platform=='Macintosh'): $sql_pla= mysql_query("SELECT contador FROM navegador WHERE id_navegador='3'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE navegador SET contador='$cont' WHERE id_navegador='3'");
				break;
			case($platform=='OS/2'): $sql_pla= mysql_query("SELECT contador FROM navegador WHERE id_navegador='4'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE navegador SET contador='$cont' WHERE id_navegador='4'");
				break;
			case($platform=='BeOS'): $sql_pla= mysql_query("SELECT contador FROM navegador WHERE id_navegador='5'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE navegador SET contador='$cont' WHERE id_navegador='5'");
				break;
			case($platform=!'BeOS' || $platform!='Windows' || $platform!='Linux' || $platform!='Macintosh' || $platform!='OS/2'): 
										$sql_pla= mysql_query("SELECT contador FROM navegador WHERE id_navegador='21'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE navegador SET contador='$cont' WHERE id_navegador='21'");
				break;	
		}
	switch($navegador)
		{
			case ($navegador=='Firefox'):	$sql_pla= mysql_query("SELECT contador FROM navegador WHERE id_navegador='6'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE navegador SET contador='$cont' WHERE id_navegador='6'");
				break;
			case ($navegador=='Chrome'):	$sql_pla= mysql_query("SELECT contador FROM navegador WHERE id_navegador='15'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE navegador SET contador='$cont' WHERE id_navegador='15'");
				break;
			case ($navegador=='opera'):	$sql_pla= mysql_query("SELECT contador FROM navegador WHERE id_navegador='8'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE navegador SET contador='$cont' WHERE id_navegador='8'");
				break;
			case ($navegador=='MSIE'):		
										$sql_pla= mysql_query("SELECT contador FROM navegador WHERE id_navegador='10'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE navegador SET contador='$cont' WHERE id_navegador='10'");
				break;
			case ($navegador=='Konqueror'):		
										$sql_pla= mysql_query("SELECT contador FROM navegador WHERE id_navegador='16'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE navegador SET contador='$cont' WHERE id_navegador='16'");
				break;
			case ($navegador=='webtv'):		
										$sql_pla= mysql_query("SELECT contador FROM navegador WHERE id_navegador='18'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE navegador SET contador='$cont' WHERE id_navegador='18'");
				break;
			case ($navegador=='Safari'):		
										$sql_pla= mysql_query("SELECT contador FROM navegador WHERE id_navegador='20'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE navegador SET contador='$cont' WHERE id_navegador='20'");
				break;
			case ($navegador=='netscape' || $navegador=='Netscape'):		
										$sql_pla= mysql_query("SELECT contador FROM navegador WHERE id_navegador='7'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE navegador SET contador='$cont' WHERE id_navegador='7'");
				break;
			case ($navegador!='Safari' || $navegador!='Firefox' || $navegador!='Chrome' || $navegador!='opera' || $navegador!='MSIE' || $navegador!='Konqueror' || $navegador!='webtv' || $navegador!='netscape'):		
										$sql_pla= mysql_query("SELECT contador FROM navegador WHERE id_navegador='13'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE navegador SET contador='$cont' WHERE id_navegador='13'");
				break;
		}
$sql = mysql_query("SELECT contador FROM navegador WHERE id_navegador='28'");
										$cont2 = @mysql_result($sql, 0, "contador");
										$cont2++;
										$sql_pla2=mysql_query("UPDATE navegador SET contador='$cont2' WHERE id_navegador='28'");

/*************************FIN******/
?>