<?php
//include_once("includes/dateAfecha.php"); //para hacer operaciones con fechas
if (isset($_GET["id"])) {
	$idCarrera = $_GET["id"];
	include("conexion.php");
	//include("escudos.php");
	include("includes/funciones.php");
	$dbQuery = "SELECT titulo,fecha_larga FROM web_pruebas WHERE idcarrera = '$idCarrera'";
	$resultado = $mysqli2->query($dbQuery) or print "No se pudo acceder al contenido.";
	if ($resultado->num_rows > 0) {
		while ($row = $resultado->fetch_array()) {
			$titulo = $row['titulo'];
			$fecha = $row['fecha_larga'];
		}
	}
}
$modo_tiempo = $mysqli2->query("SELECT tiempo_tipo FROM web_campeonatos WHERE idcarrera = '$idCarrera'");
if ($modo_tiempo->num_rows > 0)
	$row = $modo_tiempo->fetch_array();
$tipo_prueba = $row['tiempo_tipo'];
?>
<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
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
					<div class="social">
						<?php
						include("social.php");
						?>
					</div>
					<ul class="nav-menu">
						<li><a href="temporada.php">Inicio</a></li>
						<li><a href="temporada.php?newBD=true">Temporada</a></li>
						<li><a href="archivo.php">Archivo</a></li>
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
			<a href="tiempos_new.php?id=<?php echo $idCarrera; ?>&" class="primary-btn text-uppercase selected">VOLVER</a>
		</div>
	</section>
	<div class="section-top-border">
		<table>
			<form>
				<tr>
					<?php
					echo "<td>COPAS:</td><td><select name='copas' onchange='surfto2(this.form)'>";
					$FiltroCopa = "SELECT c.descripcion,c.id FROM web_copas c 
INNER JOIN web_campeonatos ca ON c.id = ca.id 
WHERE ca.idcarrera='$idCarrera'";

					$copas = $mysqli2->query($FiltroCopa);
					if ($copa == '0') {
						echo "<option selected='selected'>TODAS</option>";
					} else {
						echo "<option value='clas_final_new.php?id=" . $idCarrera . "&copa=0'>TODAS LAS COPAS</option>";
					}
					while ($row = $copas->fetch_array()) {
						$filtroCopa = $row["id"];
						$filtroDesc = $row["descripcion"];
						$filtroDesc = str_replace('ESPAÃ‘A', 'ESPAÑA', $filtroDesc);
						if ($filtroCopa == $copa) {
							echo "<option selected='selected'>" . $filtroDesc . "</option>";
							$nom_copa = $filtroDesc;
						} else
							echo "<option value='clas_final_new.php?id=" . $idCarrera . "&copa=" . $filtroCopa . "'>" . $filtroDesc . "</option>";
					}
					echo "</form></table>";
					echo "<hr><br>";
					echo "<p>CLASIFICACI&Oacute;N FINAL:" . $tipo_prueba . "</p>";
					switch ($tipo_prueba) {
						case 0:
							include("clas_final_tipo3.php");
							break;
						case 1:
							include("clas_final_tipo1.php");
							break;
						case 2:
							include("clas_final_tipo2.php");
							break;
						case 3:
							include("clas_final_tipo3.php");
							break;
						case 4:
							include("clas_final_tipo4.php");
							break;
						case 5:
							include("clas_final_tipo3.php");
							break;
					}

					?>
	</div>
	<footer class="footer-area section-gap">
		<div class="container">
			<div class="row">
				<div class="col-lg-5 col-md-6 col-sm-6">
					<div class="single-footer-widget">
						<h6>Acerca de C.O.D.A</h6>
						<p>
							Somos un Club deportivo constituido en 2009 con las diferentes licencias exigidas por la Real Federación Española de Automovilismo y los dispositivos de cronometraje para organizar pruebas de caracter oficial.
						</p>
						<p class="footer-text">
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
							Copyright &copy;<script>
								document.write(new Date().getFullYear());
							</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						</p>
					</div>
				</div>
				<div class="col-lg-5  col-md-6 col-sm-6">
					<div class="single-footer-widget" style="display:none">
						<h6>Newsletter</h6>
						<p>Mantente informado</p>
						<div class="" id="mc_embed_signup">
							<form target="_blank" novalidate="true" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01" method="get" class="form-inline">
								<input class="form-control" name="EMAIL" placeholder="Enter Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Email '" required="" type="email">
								<button class="click-btn btn btn-default"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>
								<div style="position: absolute; left: -5000px;">
									<input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value="" type="text">
								</div>

								<div class="info pt-20"></div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-lg-2 col-md-6 col-sm-6 social-widget">
					<div class="single-footer-widget">
						<h6>Siguenos</h6>
						<p>En nuestras redes sociales</p>
						<div class="footer-social d-flex align-items-center">
							<a href="#"><i class="fa fa-facebook"></i></a>
							<a href="#"><i class="fa fa-twitter"></i></a>
							<a href="#"><i class="fa fa-dribbble"></i></a>
							<a href="#"><i class="fa fa-behance"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
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
			var myindex = form.copas.selectedIndex;
			window.open(form.copas.options[myindex].value, "_top");
		}

		function surfto2(form) {
			var myindex = form.clases.selectedIndex;
			window.open(form.clases.options[myindex].value, "_top");
		}

		function surfto3(form) {
			var myindex = form.grupos.selectedIndex;
			window.open(form.grupos.options[myindex].value, "_top");
		}
	</script>
</body>

</html>