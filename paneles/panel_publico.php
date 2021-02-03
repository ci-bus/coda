<?php
	$IPservidor = "localhost";
	$nombreBD = "codea_es_sistema";
	$usuario = "manuel";
	$clave = "coda200900==";
include("funcionesTiempos.php");
$conexion = mysql_connect($IPservidor, $usuario, $clave) or die("<h2>No hay conexi&oacute;n con el servidor MySQL</h2>");
mysql_query ("SET NAMES 'utf8'");
mysql_select_db($nombreBD) or die('no se encontro la bd');
$idManga = $_GET['idmanga'];
$sql = mysql_query("SELECT m.tipo AS tipo_manga,m.numero AS num_manga,com.dorsal,pi.nombre AS piloto_nombre,
	veh.grupo AS grupo,veh.clase AS clase,veh.marca AS marca,veh.modelo As modelo
	FROM abc_57os_ca_carrera car
	INNER JOIN abc_57os_ca_competidor com ON car.id=com.id_ca_carrera
	INNER JOIN abc_57os_ca_etapa e ON e.id_ca_carrera=car.id
	INNER JOIN abc_57os_ca_seccion s ON s.id_ca_etapa=e.id
	INNER JOIN abc_57os_ca_manga m ON m.id_ca_seccion=s.id
	INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto
	INNER JOIN abc_57os_ca_vehiculo veh ON veh.id=com.id_ca_vehiculo
	WHERE dorsal NOT IN (SELECT id_ca_competidor FROM abc_57os_ca_abandono WHERE id_ca_manga='$idManga') 
	AND m.id='$idManga' AND com.autorizado='1'");
$total=mysql_num_rows($sql);
?>
<html>
	<head>
		<link rel="stylesheet" href="panel.css">
		<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen"/>
		<script type="text/javascript" src=" https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>	
		<script>
		 /*Esta es la famosa recarga automatica de evento, en este caso la usaremos de forma general*/
   var seconds = 10; // el tiempo en que se refresca
	var divid = "wrapper"; // el div que quieres actualizar!
	var url = "panel_recarga.php?idmanga=<?php echo $_GET['idmanga'];?>&total=54"; // el archivo que ira en el div

	function refreshdiv(){

		// The XMLHttpRequest object

		var xmlHttp;
		try{
			xmlHttp=new XMLHttpRequest(); // Firefox, Opera 8.0+, Safari
		}
		catch (e){
			try{
				xmlHttp=new ActiveXObject("Msxml2.XMLHTTP"); // Internet Explorer
			}
			catch (e){
				try{
					xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				catch (e){
					alert("Tu explorador no soporta AJAX.");
					return false;
				}
			}
		}

		// Timestamp for preventing IE caching the GET request
		var timestamp = parseInt(new Date().getTime().toString().substring(0, 10));
		var nocacheurl = url+"&t="+timestamp;

		// The code...

		xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState== 4 && xmlHttp.readyState != null){
				document.getElementById(divid).innerHTML=xmlHttp.responseText;
				setTimeout('refreshdiv()',seconds*1000);
			}
		}
		xmlHttp.open("GET",nocacheurl,true);
		xmlHttp.send(null);
	}

	// Empieza la función de refrescar
		refreshdiv(); // corremos inmediatamente la funcion
		</script>
	</head>
	<body>
		<div id="wrapper">
				<?php
				include("panel_recarga.php");				
				?>
			</div>
			<div id="footer">
				<div id="reloj">
				</div>
				<div id="manga">
				<p class="manga nomargen blanco fuente">MANGA: TC1-EL POZUELO</p>
				<p class="carerra nomargen blanco fuente">NOMBRE DE LA CARRERA</p>
				</div>
			</div>
		</div>
<!-- wrapper --></div>
	</body>
</html>