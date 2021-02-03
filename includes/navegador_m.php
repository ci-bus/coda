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
			case($platform=='Windows'): $sql_pla= mysql_query("SELECT contador FROM navegador WHERE id_navegador='24'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE navegador SET contador='$cont' WHERE id_navegador='24'");
				break;
			case($platform=='Linux'): $sql_pla= mysql_query("SELECT contador FROM navegador WHERE id_navegador='23'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE navegador SET contador='$cont' WHERE id_navegador='23'");
				break;
			case($platform=='Macintosh'): $sql_pla= mysql_query("SELECT contador FROM navegador WHERE id_navegador='25'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE navegador SET contador='$cont' WHERE id_navegador='25'");
				break;
			case($platform!='Windows' || $platform!='Linux' || $platform!='Macintosh'): 
										$sql_pla= mysql_query("SELECT contador FROM navegador WHERE id_navegador='26'");
										$cont = @mysql_result($sql_pla, 0, "contador");
										$cont++;
										$sql_pla2=mysql_query("UPDATE navegador SET contador='$cont' WHERE id_navegador='26'");
				break;	
		}
$sql = mysql_query("SELECT contador FROM navegador WHERE id_navegador='27'");
										$cont2 = @mysql_result($sql, 0, "contador");
										$cont2++;
										$sql_pla2=mysql_query("UPDATE navegador SET contador='$cont2' WHERE id_navegador='27'");
/*************************FIN******/
?>