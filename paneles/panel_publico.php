<html>

<head>
	<link rel="stylesheet" href="panel.css">
	<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" />
	<script type="text/javascript" src=" https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
	<script>
		/*Esta es la famosa recarga automatica de evento, en este caso la usaremos de forma general*/
		var seconds = 8; // el tiempo en que se refresca
		var divid = "wrapper"; // el div que quieres actualizar!
		var url = "panel_recarga.php?idmanga=<?php echo $_GET['idmanga']; ?>&total=<?php echo $_GET['total']; ?>&id=<?php echo $_GET['id'];?>"; // el archivo que ira en el div

		function refreshdiv() {

			// The XMLHttpRequest object

			var xmlHttp;
			try {
				xmlHttp = new XMLHttpRequest(); // Firefox, Opera 8.0+, Safari
			} catch (e) {
				try {
					xmlHttp = new ActiveXObject("Msxml2.XMLHTTP"); // Internet Explorer
				} catch (e) {
					try {
						xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
					} catch (e) {
						alert("Tu explorador no soporta AJAX.");
						return false;
					}
				}
			}

			// Timestamp for preventing IE caching the GET request
			var timestamp = parseInt(new Date().getTime().toString().substring(0, 10));
			var nocacheurl = url + "&t=" + timestamp;

			// The code...

			xmlHttp.onreadystatechange = function() {
				if (xmlHttp.readyState == 4 && xmlHttp.readyState != null) {
					document.getElementById(divid).innerHTML = xmlHttp.responseText;
					setTimeout('refreshdiv()', seconds * 1000);
				}
			}
			xmlHttp.open("GET", nocacheurl, true);
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
	<?php
	$max = 9999999999999;
	file_put_contents("./mejortiempo.txt", $max);
	?>
</body>

</html>