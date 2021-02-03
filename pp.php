<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Cronometradores y Oficiales de Automovilismo" />
<title>C.O.D.A.  .:: Direcci&oacute;n de Carrera ::.</title>
<meta name="description" content="Cronometradores y Oficiales de Automovilismo" />
<meta name="keywords" content="Rally, Rallies, Cronometradores, Automovilismo, automovilista, carreras, carrera, tiempos online, tiempos on-line, tiempos en directo, coches, automoviles, rally, rallies, cronometradores, automovilismo" />
<link type="text/css" href="direccion.css" rel="stylesheet">
<link rel="shortcut icon" href="../normal/paginas/favicon.ico" />
		<script type="text/javascript" src=" https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
		<script>
		 /*Esta es la famosa recarga automatica de evento, en este caso la usaremos de forma general*/
   var seconds = 6; // el tiempo en que se refresca
	var divid = "miscojones"; // el div que quieres actualizar!
	var url = "pruebas.php"; // el archivo que ira en el div

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

	window.onload = function(){
		refreshdiv(); // corremos inmediatamente la funcion
	}
	function mostrar_piloto(datos){
		jQuery('#'+datos).css('visibility','visible');
	}
	function quitar_piloto(datos){
		jQuery('#'+datos).css('visibility','hidden');
	}
		</script>
</head>
<body>
	<div id="miscojones">
	</div>