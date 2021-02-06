	<!DOCTYPE html>
	<?php
	include("includes/funciones.php");
	include("conexion.php");
	?>
	<html lang="zxx" class="no-js">

	<head>
		<!-- Mobile Specific Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Favicon-->
		<link rel="shortcut icon" href="img/fav.png">
		<!-- Author Meta -->
		<meta name="author" content="codepixer">
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
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<link rel="stylesheet" href="css/bootstrap.css">
		<link rel="stylesheet" href="css/magnific-popup.css">
		<link rel="stylesheet" href="css/nice-select.css">
		<link rel="stylesheet" href="css/animate.min.css">
		<link rel="stylesheet" href="css/owl.carousel.css">
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" type="text/css" href="css/demo.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<noscript>
			<link rel="stylesheet" type="text/css" href="css/noscript.css" />
		</noscript>
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
							<li class="menu-active">Inicio</li>
							<li><a href="temporada.php">Temporada</a></li>
							<li><a href="archivo.php">Archivo</a></li>
						</ul>
					</nav><!-- #nav-menu-container -->
				</div>
			</div>
		</header><!-- #header -->


		<!-- start banner Area -->
		<section class="banner-area" id="home">

			<div class="contain">

				<div class="wrapper">
					<div id="ei-slider" class="ei-slider">
						<ul class="ei-slider-large">
							<?php
							$i = 1;
							$sql = $mysqli2->query("SELECT * FROM web_imagenes WHERE tipo=1");
							if ($sql->num_rows == 0)
								echo "no hay eventos";
							else {
								while ($fila = $sql->fetch_array()) {
									$inicio = $fila['inicio'];
									$fin = $fila['fin'];
									$ruta_donde = $fila['enlace'];
									$imagen = $fila['nombre'];
									$desc = $fila['comentario'];
									echo "<li><a href='" . $ruta_donde . "'><img src='slider/" . $imagen . "' alt='image0" . $i . "' />								
								<div class='ei-title'>
								<h2>" . $desc . "</h2>
								</a>
								</div>
								</li>";
									$i++;
								}
							}
							?>
						</ul>
						<ul class="ei-slider-thumbs">
							<li class="ei-slider-element">Current</li>
							<?php
							for ($n = 1; $n < $i; $n++)
								echo "<li><a href='#'></a></li>";
							?>
						</ul>
					</div>
				</div>
				<section class="gallery-area section-gap" id="gallery">
					<div class="container">

						<div class="col-lg-12">
							<img src="img/homologa.jpg">
						</div>
				</section>

		</section>
		<!-- ZONA DE PRUEBAS DE TEMPORADA CLASIFICADAS POR CATEGORIA -->
		<section class="menu-area section-gap" id="coffee">
			<div class="container">
				<div class="row d-flex justify-content-center">
					<div class="menu-content pb-60 col-lg-10">
						<div class="title text-center">
							<h1 class="mb-10">Pruebas Temporada <?php echo date('Y'); ?></h1>
							<!--p>DEJAR ESTO AQUI POR SI SE QUIERE AGREGAR COMENTARIOS</p-->
						</div>
					</div>
				</div>

				<br>
				<div class="row">
					<?php //RALLYE ASFALTO
					$anio = date('Y');
					echo "<div class='col-lg-4'>";
					echo "<p class='des_cub'>RALLYES ASFALTO</p>";
					echo "<div class='single-menu asfalto'>";
					$sql = $mysqli2->query("SELECT titulo,idcarrera FROM web_pruebas WHERE tipo=3 AND estado!=5 AND temporada='$anio'");
					if ($sql->num_rows > 0) {
						while ($fila = $sql->fetch_array()) {
							$nom = $fila['titulo'];
							$id = $fila['idcarrera'];

							echo "<div class='title-div justify-content-between d-flex'>
													<a href='prueba_new.php?id=" . $id . "&newBD=true'>
													<h4 class='tit_cub'>" . $nom . "</h4></a>	
													</div>";
						}
					}
					echo "</div></div>";
					echo "<div class='col-lg-4'>";
					echo "<p class='des_cub'>RALLYES TIERRA</p>"; //RALLYES TIERRA
					echo "<div class='single-menu tierra'>";
					$sql = $mysqli2->query("SELECT titulo,idcarrera FROM web_pruebas WHERE tipo=8 AND estado!=5 AND temporada='$anio'");
					if ($sql->num_rows > 0) {
						while ($fila = $sql->fetch_array()) {
							$nom = $fila['titulo'];
							$id = $fila['idcarrera'];

							echo "<div class='title-div justify-content-between d-flex'>
													<a href='prueba_new.php?id=" . $id . "&newBD=true'>
													<h4 class='tit_cub'>" . $nom . "</h4></a>	
													</div>";
						}
					}
					echo "</div></div>";
					echo "<div class='col-lg-4'>";
					echo "<p class='des_cub'>TODO TERRENO</p>"; //TODO TERRENO
					echo "<div class='single-menu tt'>";
					$cont = 0;
					$sql = $mysqli2->query("SELECT titulo,idcarrera FROM web_pruebas WHERE tipo=4 AND estado!=5 AND temporada='$anio'");
					if ($sql->num_rows > 0) {
						while ($fila = $sql->fetch_array()) {
							$nom = $fila['titulo'];
							$id = $fila['idcarrera'];

							echo "<div class='title-div justify-content-between d-flex'>
													<a href='prueba_new.php?id=" . $id . "&newBD=true'>
													<h4 class='tit_cub'>" . $nom . "</h4></a>	
													</div>";
						}
					}

					?>
				</div>
		</section>
		<section class="menu-area section-gap" id="coffee">
			<div class="container">

				<br>
				<div class="row">
					<?php //RALLYCRONO
					$anio = date('Y');
					echo "<div class='col-lg-4'>";
					echo "<p class='des_cub'>RALLYCRONO</p>";
					echo "<div class='single-menu rallycrono'>";
					$sql = $mysqli2->query("SELECT titulo,idcarrera FROM web_pruebas WHERE tipo=5 AND estado!=5 AND temporada='$anio'");
					if ($sql->num_rows > 0) {
						while ($fila = $sql->fetch_array()) {
							$nom = $fila['titulo'];
							$id = $fila['idcarrera'];

							echo "<div class='title-div justify-content-between d-flex'>
													<a href='prueba_new.php?id=" . $id . "&newBD=true'>
													<h4 class='tit_cub'>" . $nom . "</h4></a>	
													</div>";
						}
					}
					echo "</div></div>";
					echo "<div class='col-lg-4'>";
					echo "<p class='des_cub'>SUBIDAS MONTAÑA</p>"; //SUBIDAS MONTAÑA
					echo "<div class='single-menu subidas'>";
					$sql = $mysqli2->query("SELECT titulo,idcarrera FROM web_pruebas WHERE tipo=1 AND estado!=5 AND temporada='$anio'");
					if ($sql->num_rows > 0) {
						while ($fila = $sql->fetch_array()) {
							$nom = $fila['titulo'];
							$id = $fila['idcarrera'];

							echo "<div class='title-div justify-content-between d-flex'>
													<a href='prueba_new.php?id=" . $id . "&newBD=true'>
													<h4 class='tit_cub'>" . $nom . "</h4></a>	
													</div>";
						}
					}
					echo "</div></div>";
					echo "<div class='col-lg-4'>";
					echo "<p class='des_cub'>CRONOMETRADAS</p>"; //CRONOMETRADAS
					echo "<div class='single-menu cronometradas'>";
					$cont = 0;
					$sql = $mysqli2->query("SELECT titulo,idcarrera FROM web_pruebas WHERE tipo=2 AND estado!=5 AND temporada='$anio'");
					if ($sql->num_rows > 0) {
						while ($fila = $sql->fetch_array()) {
							$nom = $fila['titulo'];
							$id = $fila['idcarrera'];

							echo "<div class='title-div justify-content-between d-flex'>
													<a href='prueba_new.php?id=" . $id . "&newBD=true'>
													<h4 class='tit_cub'>" . $nom . "</h4></a>	
													</div>";
						}
					}

					?>
				</div>
		</section>
		<section class="menu-area section-gap" id="coffee">
			<div class="container">

				<br>
				<div class="row">
					<?php //AUTOCROSS
					$anio = date('Y');
					echo "<div class='col-lg-4'>";
					echo "<p class='des_cub'>AUTOCROSS</p>";
					echo "<div class='single-menu autocross'>";
					$sql = $mysqli2->query("SELECT titulo,idcarrera FROM web_pruebas WHERE tipo=7 AND estado!=5 AND temporada='$anio'");
					if ($sql->num_rows > 0) {
						while ($fila = $sql->fetch_array()) {
							$nom = $fila['titulo'];
							$id = $fila['idcarrera'];

							echo "<div class='title-div justify-content-between d-flex'>
													<a href='prueba_new.php?id=" . $id . "&newBD=true'>
													<h4 class='tit_cub'>" . $nom . "</h4></a>	
													</div>";
						}
					}
					echo "</div></div>";
					echo "<div class='col-lg-4'>";
					echo "<p class='des_cub'>SLALOM</p>"; //SLALOM
					echo "<div class='single-menu slalom'>";
					$sql = $mysqli2->query("SELECT titulo,idcarrera FROM web_pruebas WHERE tipo=6 AND estado!=5 AND temporada='$anio'");
					if ($sql->num_rows > 0) {
						while ($fila = $sql->fetch_array()) {
							$nom = $fila['titulo'];
							$id = $fila['idcarrera'];

							echo "<div class='title-div justify-content-between d-flex'>
													<a href='prueba_new.php?id=" . $id . "&newBD=true'>
													<h4 class='tit_cub'>" . $nom . "</h4></a>	
													</div>";
						}
					}
					echo "</div></div>";
					echo "<div class='col-lg-4'>";
					echo "<p class='des_cub'>OTRAS</p>"; //OTRAS
					echo "<div class='single-menu otras'>";
					$cont = 0;
					$sql = $mysqli2->query("SELECT titulo,idcarrera FROM web_pruebas WHERE tipo=9 AND estado!=5 AND temporada='$anio'");
					if ($sql->num_rows > 0) {
						while ($fila = $sql->fetch_array()) {
							$nom = $fila['titulo'];
							$id = $fila['idcarrera'];

							echo "<div class='title-div justify-content-between d-flex'>
													<a href='prueba_new.php?id=" . $id . "&newBD=true'>
													<h4 class='tit_cub'>" . $nom . "</h4></a>	
													</div>";
						}
					}

					?>
				</div>
		</section>
		<!-- End menu Area -->
		<!-- ZONA DE REDES SOCIALES -->
		<section class="gallery-area section-gap" id="gallery">
			<div class="container">
				<div class="row d-flex justify-content-center">
					<div class="menu-content pb-60 col-lg-10">
						<div class="title text-center">
							<h1 class="mb-10">Cronometradores y Oficiales De Automovilismo</h1>
							<p>S&iacute;guenos en nuestras Redes Sociales</p>
						</div>
					</div>
				</div>
				<div class="row">

					<div class="col-lg-12">
						<div id="p3">
							<!-- LightWidget WIDGET -->
							<script src="https://cdn.lightwidget.com/widgets/lightwidget.js"></script><iframe src="//lightwidget.com/widgets/ac28b9ab30125ca78f28f51ad5ecb993.html" scrolling="no" allowtransparency="true" class="lightwidget-widget" style="width:100%;border:0;overflow:hidden;"></iframe>
							<!--iframe class="fbook" src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FCD-CODA-Cronometradores-y-Oficiales-De-Automovilismo%2F174390805936830&amp;width=530&amp;height=427&amp;colorscheme=light&amp;show_faces=false&amp;header=true&amp;stream=true&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden;" allowTransparency="false"></iframe-->
						</div>
						<!--img class="img-fluid redes" src="img/g3.jpg" alt=""-->

					</div>
				</div>
		</section>
		<!-- End gallery Area -->


		<!-- Start review Area -->
		<?php
		include("visitas.php");
		?>
		<section class="review-area section-gap" id="review">
			<div class="container">
				<div class="row d-flex justify-content-center">
					<div class="menu-content col-lg-10">
						<div class="title text-center">
							<h1 class="mb-10">Visitas</h1>
						</div>
					</div>
				</div>
				<div class="row counter-row">
					<div class="col-lg-3 col-md-6 single-counter">
						<h1 class="counter"><?php echo $visitasHoy; ?></h1>
						<p>Hoy</p>
					</div>
					<div class="col-lg-3 col-md-6 single-counter">
						<h1 class="counter"><?php echo $j; ?></h1>
						<p>Mes</p>
					</div>
					<div class="col-lg-3 col-md-6 single-counter">
						<h1 class="counter"><?php echo $a + 52000; ?></h1>
						<p>Temporada</p>
					</div>
					<div class="col-lg-3 col-md-6 single-counter">
						<h1 class="counter"><?php echo $visitasTotales; ?></h1>
						<p>Visitas Totales</p>
					</div>
				</div>
			</div>
		</section>
		<!-- start footer Area -->
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
		<script src="js/waypoints.min.js"></script>
		<script src="js/jquery.counterup.min.js"></script>
		<script src="js/mail-script.js"></script>
		<script src="js/main.js"></script>
		<!--script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script-->
		<script type="text/javascript" src="js/jquery.eislideshow.js"></script>
		<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
		<script type="text/javascript">
			$(function() {
				$('#ei-slider').eislideshow({
					animation: 'center',
					autoplay: true,
					slideshow_interval: 6000,
					titlesFactor: 0
				});
			});
		</script>
	</body>

	</html>