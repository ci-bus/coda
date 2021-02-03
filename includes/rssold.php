 <?php
error_reporting(5);
include('conexion.php');
/*$IPservidor = "85.238.8.44";
$nombreBD = "coda";
$usuario = "manuel";
$clave = "alonso";
$conexion = mysql_connect($IPservidor, $usuario, $clave) or die("<h2>No hay conexi&oacute;n con el servidor MySQL.'conexion.php'</h2>");
mysql_query ("SET NAMES 'utf8'");
mysql_select_db($nombreBD) or die('no se encontro la bd');*/
/*
Created by Global Syndication's RSS Parser
[url]http://www.globalsyndication.com/rss-parser[/url]
POR SI SE PIERDE: http://www.autohebdosport.es/feed/
*/
	if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
		$lan=3;
	else
		$lan=4;
$cons = mysql_query("SELECT nombre FROM configuracion where idconfiguracion='$lan'");
if (mysql_num_rows($cons)){
				while ($fila= mysql_fetch_array($cons)){
					$rss= $fila['nombre'];
				}
			}
set_time_limit(0);
//echo $rss;
$file = $rss; /* ESTO QUE LO RECIBA DE LA BD A FALTA DE INCLUIR LA CONEXION ETC ETC*/

$rss_channel = array();
$currently_writing = "";
$main = "";
$item_counter = 0;

function startElement($parser, $name, $attrs) {
       global $rss_channel, $currently_writing, $main;
       switch($name) {
           case "RSS":
           case "RDF:RDF":
           case "ITEMS":
               $currently_writing = "";
               break;
           case "CHANNEL":
               $main = "CHANNEL";
               break;
           case "IMAGE":
               $main = "IMAGE";
               $rss_channel["IMAGE"] = array();
               break;
           case "ITEM":
               $main = "ITEMS";
               break;
           default:
               $currently_writing = $name;
               break;
       }
}

function endElement($parser, $name) {
       global $rss_channel, $currently_writing, $item_counter;
       $currently_writing = "";
       if ($name == "ITEM") {
           $item_counter++;
       }
}

function characterData($parser, $data) {
    global $rss_channel, $currently_writing, $main, $item_counter;
    if ($currently_writing != "") {
        switch($main) {
            case "CHANNEL":
                if (isset($rss_channel[$currently_writing])) {
                    $rss_channel[$currently_writing] .= $data;
                } else {
                    $rss_channel[$currently_writing] = $data;
                }
                break;
            case "IMAGE":
                if (isset($rss_channel[$main][$currently_writing])) {
                    $rss_channel[$main][$currently_writing] .= $data;
                } else {
                    $rss_channel[$main][$currently_writing] = $data;
                }
                break;
            case "ITEMS":
                if (isset($rss_channel[$main][$item_counter][$currently_writing])) {
                    $rss_channel[$main][$item_counter][$currently_writing] .= $data;
                } else {
                    $rss_channel[$main][$item_counter][$currently_writing] = $data;
                }
                break;
        }
    }
}

$xml_parser = xml_parser_create();
xml_set_element_handler($xml_parser, "startElement", "endElement");
xml_set_character_data_handler($xml_parser, "characterData");
if (!($fp = fopen($file, "r"))) {
    die("No se puede abrir Rss");
}

while ($data = fread($fp, 4096)) {
    if (!xml_parse($xml_parser, $data, feof($fp))) {
        die(sprintf("XML error: %s at line %d",
                    xml_error_string(xml_get_error_code($xml_parser)),
                    xml_get_current_line_number($xml_parser)));
    }
}
xml_parser_free($xml_parser);

// output HTML
 //print ("<div class=\"channelname\">" . $rss_channel["TITLE"] . "</div>");   A TOMAR VIENTOS LOS PRINTS
if (isset($rss_channel["ITEMS"])) {
	//echo "<ul>";
    if (count($rss_channel["ITEMS"]) > 0) {
	        /*for($i = 0;$i < count($rss_channel["ITEMS"]);$i++) {  QUITO EL ORIGINAL SIN LITMITE Y LOS LIMITO A 3 NOTICIAS  Y COMO EL LECTOR ES GENERICO, PODREMOS CAMBIAR LA DIRECCION EN  LA ADMINISTRACION*/
        for($i = 0;$i<=2;$i++) {
            if (isset($rss_channel["ITEMS"][$i]["LINK"])) {
				if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
					echo "<a href='../paginas/noticias.php?lang=0'><div id='not2'><div id='not'>";
				else
					echo "<a href='../paginas/noticias.php?lang=1'><div id='not2'><div id='not'>";
					$browser = $_SERVER['HTTP_USER_AGENT'];
					$browser = substr("$browser", 25, 8);
					if ($browser == "MSIE 6.0")
					print ("\n<p class=\"tituloexpl\">" .$rss_channel["ITEMS"][$i]["TITLE"]."</p>");
					else
					print ("\n<p class=\"titulo\">" .$rss_channel["ITEMS"][$i]["TITLE"]."</p>");
            } else {
            print ("\n<p class=\"titulo\">" .$rss_channel["ITEMS"][$i]["TITLE"]."</p>");
            }
             print ("\n<p class=\"desc\">" .$rss_channel["ITEMS"][$i]["DESCRIPTION"]."</p>");
	if ($i==0 || $i==1)
	echo "</div><img src='../images/barra.jpg' class='img2'>";
			 echo "</div></a>";			 }
    } else {
        print ("<b>No existen noticias en este canal.</b>");
    }
}
echo "</div>";
?> 