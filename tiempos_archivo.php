<?php
include_once("includes/dateAfecha.php"); //para hacer operaciones con fechas
include("includes/nombresTildes.php");
if (isset($_GET["id"])) { //En el caso de pruebas creadas a través del PROGRAMA
	$idCarrera = $_GET["id"];
	if (isset($idCarrera)) {
		include("conexion.php");
		$dbQuery = "SELECT titulo,fecha_larga FROM web_pruebas_archivo WHERE idcarrera = '$idCarrera'";
		$resultado = $mysqli2->query($dbQuery) or print "No se pudo acceder al contenido.";
		if ($resultado->num_rows > 0) {
			while ($row = $resultado->fetch_array()) {
				$titulo = $row['titulo'];
				$fechal = $row['fecha_larga'];
			}
		}
	}
}
function estado($estado)
{
	switch ($estado) {
		case 0:
			$estado = "rojo.png";
			break;
		case 1:
			$estado = "verde.png";
			break;
		case 2:
			$estado = "meta.png";
			break;
		case 3:
			$estado = "amarillo.png";
			break;
	}
	return $estado;
}
function estado2($estado)
{
	switch ($estado) {
		case 0:
			$estado = "POR COMENZAR";
			break;
		case 1:
			$estado = "EN CURSO";
			break;
		case 2:
			$estado = "FINALIZADA";
			break;
		case 3:
			$estado = "NEUTRALIZADA";
			break;
	}
	return $estado;
}
$num_mangas = 0;
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
	<link rel="stylesheet" href="css/linea_tiempo.css">
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
						<li class="menu-active"><a href="temporada.php">Temporada</a></li>
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
						<p class="text-white"><?php echo $fechal; ?></p>
					</div>
				</div>
			</div>
			<?php
			include("menu_pruebas_archivo.php");
			?>
		</div>
	</section>

	<div class="section-top-border">
		<h3 class="mb-30">MANGAS DISPONIBLES</h3>
		<table width="100%" id="tab_tem">
			<?php
			$mangas = $mysqli2->query("SELECT * FROM web_manga_archivo WHERE idcarrera='$idCarrera' ORDER BY numero ASC");
			if ($mangas->num_rows > 0) {
				while ($fila = $mangas->fetch_array()) {
					if ($par % 2 == 0)
						$classcss = 'filapar';
					else
						$classcss = 'filaimpar';
					$idmanga = $fila['id'];
					$descripcion = $fila['descripcion'];
					$hora = $fil['hora_salida'];
					$estado = $fila3['estado'];
					$long = $fila['longitud'];
					$inter = $mysqli2->query("SELECT id FROM web_manga_control_horario WHERE id_ca_manga='$idmanga'");
					if ($inter->num_rows > 2) {
						echo '<tr class="manga ' . $classcss . '"><td class="man_pd">
															<p><a href="manga_archivo.php?id=' . $idCarrera . '&idmanga=' . $idmanga . '">' . $descripcion . '</a></p>';
						echo '<p class="margen_p_coches"><span class="span_coches">' . $porsalir . '<img src="img/coche2.png" width="30px" class="margen_coches"></span><span class="span_coches">' . $enpista . '<img src="img/coche3.png" width="30px" class="margen_coches"></span><span class="span_coches">' . $enmeta . '<img src="img/coche1.png" width="30px" class="margen_coches"></span><span class="span_coches">' . $abandonos . '<img src="img/coche4.png" width="30px" class="margen_coches"></span></p>';
						echo '</td><td class="cursiva"><a href="inter_archivo.php?id=' . $idCarrera . '&idmanga=' . $idmanga . '">TIEMPOS INTERMEDIOS</a></td>
															<td>' . $hora . ' H</td><td>' . ($long / 1000) . ' Kms</td><td><img src="img/' . estado($estado) . '" width="15px"></td></tr>';
					} else {
						echo '<tr class="manga ' . $classcss . '"><td class="man_pd">
															<p><a href="manga_archivo.php?id=' . $idCarrera . '&idmanga=' . $idmanga . '&copa=0">' . $descripcion . '</a></p>';
						echo '<p class="margen_p_coches"><span class="span_coches">' . $porsalir . '<img src="img/coche2.png" width="30px" class="margen_coches"></span><span class="span_coches">' . $enpista . '<img src="img/coche3.png" width="30px" class="margen_coches"></span><span class="span_coches">' . $enmeta . '<img src="img/coche1.png" width="30px" class="margen_coches"></span><span class="span_coches">' . $abandonos . '<img src="img/coche4.png" width="30px" class="margen_coches"></span></p>';
						echo '</td><td></td>
															<td>' . $hora . ' H</td><td>' . ($long / 1000) . ' Kms</td><td><img src="img/' . estado($estado) . '" width="15px"></td></tr>';
					}
					$par++;
				}
			} else
				echo '<tr><td>no existen Mangas</td></tr>';
			?>
		</table>
		<br>
		<br>
	</div>
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
	<script src="js/mail-script.js"></script>
	<script src="js/main.js"></script>
</body>

</html>