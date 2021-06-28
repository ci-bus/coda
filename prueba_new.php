	<!DOCTYPE html>
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
							<li><a href="index.php">Inicio</a></li>
							<li><a href="temporada.php?newBD=true">Temporada</a></li>
							<li><a href="archivo.php">Archivo</a></li>
						</ul>
					</nav>
				</div>
			</div>
		</header>
		<?php
		include("conexion.php");
		//include_once("includes/dateAfecha.php");
		//include("includes/nombresTildes.php");
		include("includes/funciones.php");
		if (isset($_GET["id"])) {
			$idCarrera = $_GET["id"];
			if (isset($idCarrera)) {
				$dbQuery = "SELECT web AS prueba_web,titulo AS nombre,fecha_larga,img_prueba AS cartel,tipo AS tipo_p,organizador,img_organizador,img_sponsor,web,ruta_tablon FROM web_pruebas WHERE web_pruebas.idcarrera = '$idCarrera'";
				$resultado = $mysqli2->query($dbQuery) or print "No se pudo acceder al contenido.";
				if ($resultado->num_rows > 0) {

					while ($fila = $resultado->fetch_array()) {
						$titulo = $fila['nombre'];
						//$organizador = $fila['organizador'];
						$imagen = $fila['cartel'];
						$fecha = $fila['fecha_larga'];
						$descripcion = $fila['descripcion'];
						$tipo_p = $fila['tipo_p'];
						$web = $fila['prueba_web'];
						$organizador = $fila['organizador'];
						$img_organizador = $fila['img_organizador'];
						$img_sponsor = $fila['img_sponsor'];
						$cabecera = cabecera($tipo_p);
						$ruta_tablon = $fila['ruta_tablon'];
					}
				}
			}
		} else
			echo "error accediendo a la prueba online";
		?>

		<!-- start banner Area -->
		<section class="banner-area prueba_new" id="home" style="background:url('<?php echo $cabecera; ?>');background-size: cover;">
			<div class="container">
				<div class="row fullscreen d-flex align-items-center justify-content-start">
					<div class="banner-content col-lg-7">
						<h6 class="text-white text-uppercase sombra"><?php echo $fecha; ?></h6>

						<p class="mih1">
							<?php //echo $descripcion;
							?><?php echo $titulo; ?>
						</p>

						<?php
						if ($web == 0) {
							if ($ruta_tablon == '') {
								echo "<a href='tablon_new.php?id=" . $idCarrera . "' class='primary-btn text-uppercase'>TABL&Oacute;N DE ANUNCIOS</a>";
								echo "<a href='tiempos_new.php?id=" . $idCarrera . "' class='primary-btn text-uppercase'>VER TIEMPOS ONLINE</a>";
							} else {
								echo "<a href='" . $ruta_tablon . "' target='_blank' class='primary-btn text-uppercase'>TABL&Oacute;N DE ANUNCIOS</a>";
								echo "<a href='tiempos_new.php?id=" . $idCarrera . "' class='primary-btn text-uppercase'>VER TIEMPOS ONLINE</a>";
							}
						} else {
							echo "<a href='" . $ruta_tablon . "' class='primary-btn text-uppercase'>TABL&Oacute;N DE ANUNCIOS</a>";
							echo "<a href='#' class='primary-btn text-uppercase'>TIEMPOS AJENOS A CODEA</a>";
						}

						?>
					</div>
				</div>
			</div>
		</section>

		<section class="blog-area" id="blog">
			<div class="container">
				<div class="row d-flex justify-content-center">
					<div class="menu-content pb-60 col-lg-10">
						<div class="title text-center">
							<h1 class="mb-10">Organiza <?php echo $organizador; ?></h1>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-md-6 single-blog">
						<!--img class="img-fluid" src="http://sistema.codea.es/<?php //echo $imagen;
																				?>" alt=""-->
						<img class="img-fluid" src="pruebas/2021/<?php echo $idCarrera . "/" . $imagen; ?>" alt="">
						<br>
						<br>
						<!--a href="#"><h4>Portable latest Fashion for young women</h4></a-->
						<!--p>
							
							</p-->
						<!--p class="post-date">
								31st January, 2018
							</p-->
					</div>
					<div class="col-lg-6 col-md-6 single-blog">
						<img class="img-fluid2" src="pruebas/2021/50/logo.png" alt="">
						<!--ul class="post-tags">
								<li><a href="#">Travel</a></li>
								<li><a href="#">Life Style</a></li>
							</ul>
							<a href="#"><h4>Portable latest Fashion for young women</h4></a>
							<p-->
						<?php //echo $descripcion; 
						?>
						<!--/p-->

					</div>
					<?php //MODIFICAR clase sponsor/sponsor2 para las imagenes horizontal o vertical AHORA MISMO IDENTIFICO EN LA BD con Swtich 
					$sql_sponsors = $mysqli2->query("SELECT img,ruta,orientacion FROM web_sponsors WHERE id_carrera= '$idCarrera'");
					if ($sql_sponsors->num_rows > 0) {
						echo "<div class='single-blog'><ul class='post-tags'>";
						while ($row = $sql_sponsors->fetch_array()) {
							$img = $row['img'];
							$orientacion = $row['orientacion'];
							if ($orientacion == 0)
								echo "<li><img src='pruebas/2021/".$idCarrera."/sponsors/" . $img . "' class='sponsors'></li>";
							else
								echo "<li><img src='pruebas/2021/".$idCarrera."/sponsors/" . $img . "' class='sponsors2'></li>";
						}
						echo "</ul></div>";
					}
					?>
				</div>
			</div>
		</section>

		<!-- start footer Area -->
		<footer class="footer-area section-gap">
			<?php
			include("footer.php");
			?>
		</footer>
		<!-- End footer Area -->

		<script src="js/vendor/jquery-2.2.4.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="js/vendor/bootstrap.min.js"></script>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
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
	</body>

	</html>