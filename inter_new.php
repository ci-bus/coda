<<<<<<< HEAD
<?php
include("conexion.php");
//include("includes/funciones.php");
if (isset($_GET["id"])) //En el caso de pruebas creadas a través del PROGRAMA
	$idCarrera = $_GET["id"];
if (isset($_GET["id"])) {
	$idCarrera = $_GET["id"];
	include("conexion.php");
	//include("escudos.php");
	//include("includes/funciones.php");
	$DB_PREFIJO = "abc_57os_";
	$dbQuery = "SELECT titulo,fecha_larga,modo_tiempos FROM web_pruebas WHERE idcarrera = '$idCarrera'";
	$resultado = $mysqli2->query($dbQuery) or print "No se pudo acceder al contenido.";
	if ($resultado->num_rows > 0) {
		while ($row = $resultado->fetch_array()) {
			$titulo = $row['titulo'];
			$fecha = $row['fecha_larga'];
			$modo_tiempos = $row['modo_tiempos'];
		}
	}
}
if (isset($_GET['copa']))
	$copa = $_GET['copa'];
else
	$copa = '0';
?>
<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
	<script>
		var seconds = 20; // el tiempo en que se refresca
		var divid = "recargas"; // el div que quieres actualizar!
		var url = "inter_recarga_new.php?id=<?php echo $idCarrera; ?>&idmanga=<?php echo $_GET['idmanga']; ?>"; // el archivo que ira en el div

		function refreshdiv() {
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
			var timestamp = parseInt(new Date().getTime().toString().substring(0, 10));
			var nocacheurl = url + "&t=" + timestamp;
			xmlHttp.onreadystatechange = function() {
				if (xmlHttp.readyState == 4 && xmlHttp.readyState != null) {
					document.getElementById(divid).innerHTML = xmlHttp.responseText;
					setTimeout('refreshdiv()', seconds * 1000);
				}
			}
			xmlHttp.open("GET", nocacheurl, true);
			xmlHttp.send(null);
		}

		window.onload = function() {
			refreshdiv(); // corremos inmediatamente la funcion
		}
	</script>
	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicon-->
	<link rel="shortcut icon" href="img/elements/fav.png">
	<!-- Author Meta -->
	<meta name="author" content="colorlib">
	<!-- Meta Description -->
	<meta name="description" content="">
	<!-- Meta Keyword -->
	<meta name="keywords" content="">
	<!-- meta character set -->
	<meta charset="UTF-8">
	<!-- Site Title -->
	<title>C.O.D.A:.Cronometradores Y Oficiales De Automovilismo</title>

	<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
	<!--
			CSS
			============================================= -->
	<link rel="stylesheet" href="css/linearicons.css">
	<link rel="stylesheet" href="css/owl.carousel.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/nice-select.css">
	<link rel="stylesheet" href="css/magnific-popup.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/main.css">
</head>

<body>

	<header id="header" id="home" class="header-scrolled">
		<div class="header-top">
			<div class="container">
				<div class="row justify-content-end">
					<div class="col-lg-8 col-sm-4 col-8 header-top-right no-padding">
						<ul>
							<li>
								Cronometradores y Oficiales De Automovilismo
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row align-items-center justify-content-between d-flex">
				<div id="logo">
					<a href="index.php"><img src="img/logo.png" alt="" title="" /></a>
				</div>
				<nav id="nav-menu-container">
					<ul class="nav-menu">
						<li><a href="index.php">Inicio</a></li>
						<li><a href="temporada.php?newBD=true">Temporada</a></li>
						<li><a href="#">Archivo</a></li>
					</ul>
				</nav><!-- #nav-menu-container -->
			</div>
		</div>
	</header><!-- #header -->

	<!-- Start banner Area -->
	<section class="generic-banner">
		<div class="container">
			<div class="row height align-items-center justify-content-center">
				<div class="col-lg-10">
					<div class="generic-banner-content margen1">
						<h2 class="text-white"><?php echo $titulo; ?></h2>
						<p class="text-white"><?php echo $fecha; ?></p>
					</div>
				</div>
			</div>
			<a href="tiempos_new.php?id=<?php echo $idCarrera; ?>&newBD=true" class="primary-btn text-uppercase selected">VOLVER</a>
		</div>
	</section>
	<div class="section-top-border">
		<!--table>
			<form>
				<tr>
					<td>COPAS:</td>
					<td><select name="copas"-->
							<?php
							/*
							$dbQueryFiltroCopas = "SELECT idcopas, idcarreras, descripcion FROM copas WHERE idcarreras='$idCarrera' ORDER BY descripcion";
							$resultadoFiltroCopas = mysql_query($dbQueryFiltroCopas);
							if ($copa == '0') {
								echo "<option selected='selected'>SCRATCH GENERAL</option>";
							} else {
								echo "<option>TODAS LAS COPAS</option>";
							}
							while ($row = mysql_fetch_array($resultadoFiltroCopas)) {
								$filtroCopa = $row["idcopas"];
								$filtroDesc = $row["descripcion"];
								if ($filtroCopa == $copa) {
									echo "<option selected='selected'>" . $filtroDesc . "</option>";
									$nom_copa = $filtroDesc;
								} else
									$clase2 = "negro";
								echo "<option>" . $filtroDesc . "</option>";
							}*/
							//echo "</select></td>";
							//echo "</table>";
							//echo "<hr><div id='recargas'><p>TIEMPOS INTERMEDIOS:</p>";
							include("inter_recarga_new.php");
							?>
	</div>
	</div>
	<footer class="footer-area section-gap">
        <?php
        include("footer.php");
        ?>
    </footer>
	<!-- End footer Area -->


	<script src="js/vendor/jquery-2.2.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<!--script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script-->
	<script src="js/easing.min.js"></script>
	<script src="js/hoverIntent.js"></script>
	<script src="js/superfish.min.js"></script>
	<script src="js/jquery.ajaxchimp.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/jquery.sticky.js"></script>
	<script src="js/jquery.nice-select.min.js"></script>
	<script src="js/parallax.min.js"></script>
	<script src="js/mail-script.js"></script>
	<script src="js/main.js"></script>
	<script type="text/javascript">
		function surfto(form) {
			var myindex = form.mangas.selectedIndex;
			window.open(form.mangas.options[myindex].value, "_top");
		}
	</script>
</body>

=======
<?php
include("conexion.php");
//include("includes/funciones.php");
if (isset($_GET["id"])) //En el caso de pruebas creadas a través del PROGRAMA
	$idCarrera = $_GET["id"];
if (isset($_GET["id"])) {
	$idCarrera = $_GET["id"];
	include("conexion.php");
	//include("escudos.php");
	//include("includes/funciones.php");
	$DB_PREFIJO = "abc_57os_";
	$dbQuery = "SELECT titulo,fecha_larga,modo_tiempos FROM web_pruebas WHERE idcarrera = '$idCarrera'";
	$resultado = $mysqli2->query($dbQuery) or print "No se pudo acceder al contenido.";
	if ($resultado->num_rows > 0) {
		while ($row = $resultado->fetch_array()) {
			$titulo = $row['titulo'];
			$fecha = $row['fecha_larga'];
			$modo_tiempos = $row['modo_tiempos'];
		}
	}
}
if (isset($_GET['copa']))
	$copa = $_GET['copa'];
else
	$copa = '0';
?>
<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
	<script>
		var seconds = 20; // el tiempo en que se refresca
		var divid = "recargas"; // el div que quieres actualizar!
		var url = "inter_recarga_new.php?id=<?php echo $idCarrera; ?>&idmanga=<?php echo $_GET['idmanga']; ?>"; // el archivo que ira en el div

		function refreshdiv() {
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
			var timestamp = parseInt(new Date().getTime().toString().substring(0, 10));
			var nocacheurl = url + "&t=" + timestamp;
			xmlHttp.onreadystatechange = function() {
				if (xmlHttp.readyState == 4 && xmlHttp.readyState != null) {
					document.getElementById(divid).innerHTML = xmlHttp.responseText;
					setTimeout('refreshdiv()', seconds * 1000);
				}
			}
			xmlHttp.open("GET", nocacheurl, true);
			xmlHttp.send(null);
		}

		window.onload = function() {
			refreshdiv(); // corremos inmediatamente la funcion
		}
	</script>
	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicon-->
	<link rel="shortcut icon" href="img/elements/fav.png">
	<!-- Author Meta -->
	<meta name="author" content="colorlib">
	<!-- Meta Description -->
	<meta name="description" content="">
	<!-- Meta Keyword -->
	<meta name="keywords" content="">
	<!-- meta character set -->
	<meta charset="UTF-8">
	<!-- Site Title -->
	<title>C.O.D.A:.Cronometradores Y Oficiales De Automovilismo</title>

	<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
	<!--
			CSS
			============================================= -->
	<link rel="stylesheet" href="css/linearicons.css">
	<link rel="stylesheet" href="css/owl.carousel.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/nice-select.css">
	<link rel="stylesheet" href="css/magnific-popup.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/main.css">
</head>

<body>

	<header id="header" id="home" class="header-scrolled">
		<div class="header-top">
			<div class="container">
				<div class="row justify-content-end">
					<div class="col-lg-8 col-sm-4 col-8 header-top-right no-padding">
						<ul>
							<li>
								Cronometradores y Oficiales De Automovilismo
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row align-items-center justify-content-between d-flex">
				<div id="logo">
					<a href="index.php"><img src="img/logo.png" alt="" title="" /></a>
				</div>
				<nav id="nav-menu-container">
					<ul class="nav-menu">
						<li><a href="index.php">Inicio</a></li>
						<li><a href="temporada.php?newBD=true">Temporada</a></li>
						<li><a href="#">Archivo</a></li>
					</ul>
				</nav><!-- #nav-menu-container -->
			</div>
		</div>
	</header><!-- #header -->

	<!-- Start banner Area -->
	<section class="generic-banner">
		<div class="container">
			<div class="row height align-items-center justify-content-center">
				<div class="col-lg-10">
					<div class="generic-banner-content margen1">
						<h2 class="text-white"><?php echo $titulo; ?></h2>
						<p class="text-white"><?php echo $fecha; ?></p>
					</div>
				</div>
			</div>
			<a href="tiempos_new.php?id=<?php echo $idCarrera; ?>&newBD=true" class="primary-btn text-uppercase selected">VOLVER</a>
		</div>
	</section>
	<div class="section-top-border">
		<!--table>
			<form>
				<tr>
					<td>COPAS:</td>
					<td><select name="copas"-->
							<?php
							/*
							$dbQueryFiltroCopas = "SELECT idcopas, idcarreras, descripcion FROM copas WHERE idcarreras='$idCarrera' ORDER BY descripcion";
							$resultadoFiltroCopas = mysql_query($dbQueryFiltroCopas);
							if ($copa == '0') {
								echo "<option selected='selected'>SCRATCH GENERAL</option>";
							} else {
								echo "<option>TODAS LAS COPAS</option>";
							}
							while ($row = mysql_fetch_array($resultadoFiltroCopas)) {
								$filtroCopa = $row["idcopas"];
								$filtroDesc = $row["descripcion"];
								if ($filtroCopa == $copa) {
									echo "<option selected='selected'>" . $filtroDesc . "</option>";
									$nom_copa = $filtroDesc;
								} else
									$clase2 = "negro";
								echo "<option>" . $filtroDesc . "</option>";
							}*/
							//echo "</select></td>";
							//echo "</table>";
							//echo "<hr><div id='recargas'><p>TIEMPOS INTERMEDIOS:</p>";
							include("inter_recarga_new.php");
							?>
	</div>
	</div>
	<footer class="footer-area section-gap">
        <?php
        include("footer.php");
        ?>
    </footer>
	<!-- End footer Area -->


	<script src="js/vendor/jquery-2.2.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<!--script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script-->
	<script src="js/easing.min.js"></script>
	<script src="js/hoverIntent.js"></script>
	<script src="js/superfish.min.js"></script>
	<script src="js/jquery.ajaxchimp.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/jquery.sticky.js"></script>
	<script src="js/jquery.nice-select.min.js"></script>
	<script src="js/parallax.min.js"></script>
	<script src="js/mail-script.js"></script>
	<script src="js/main.js"></script>
	<script type="text/javascript">
		function surfto(form) {
			var myindex = form.mangas.selectedIndex;
			window.open(form.mangas.options[myindex].value, "_top");
		}
	</script>
</body>

>>>>>>> main
</html>