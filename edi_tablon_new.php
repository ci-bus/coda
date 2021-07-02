<<<<<<< HEAD
<?php
/*SCRIPT DE VALIDACION PARA USUARIOS DE LA WEB*/
session_start();
error_reporting(0);
include("conexion.php");
$id = $_GET['id'];
if (!isset($_SESSION['pass']) && empty($_SESSION['pass']))
	echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=acceso.php?id=' . $id . '">';
?>
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
					<ul class="nav-menu">
						<li><a href="cerrar.php?id=<?php echo $id; ?>">cerrar y volver al inicio</a></li>
					</ul>
				</nav><!-- #nav-menu-container -->
			</div>
		</div>
	</header><!-- #header -->
	<?php
	/*	$IPservidor = "localhost";
	$nombreBD = "codea_es_sistema";
	$usuario = "manuel";
	$clave = "coda200900==";
$conexion = mysql_connect($IPservidor, $usuario, $clave) or die("<h2>No hay conexi&oacute;n con el servidor MySQL</h2>");
mysql_query ("SET NAMES 'utf8'");
mysql_select_db($nombreBD) or die('no se encontro la bd');
*/
	include_once("includes/dateAfecha.php"); //para hacer operaciones con fechas
	include("includes/nombresTildes.php");
	if (isset($_GET["id"])) { //En el caso de pruebas creadas a través del PROGRAMA
		$idCarrera = $_GET["id"];
		if (isset($idCarrera)) {
			//idcarreras, descripcion, fecha_larga, estado, tipo_carrera, tipo_informe, modo_tiempos, temporada, organizador, fecha, idWeb, titulo, poblacion, desactivada, imagen
			$dbQuery = "SELECT nombre FROM abc_57os_ca_carrera WHERE abc_57os_ca_carrera.id = '$idCarrera'";
			$resultado = $mysqli->query($dbQuery) or print "No se pudo acceder al contenido.";
			if ($resultado->num_rows > 0) {
				$rows = $resultado->fetch_array();
				$titulo = $rows['nombre'];
			}
		}
	}
	/*$nom = mysql_query("SELECT nombre,id_usuario FROM abc_57os_ca_secretario WHERE id_ca_carrera='$idCarrera'");
	if(mysql_num_rows($nom) > 0)
	{
	$nombre = @mysql_result($nom, 0, "nombre");
	$usuario = @mysql_result($nom, 0, "id_usuario");
	}*/
	?>

	<!-- start banner Area -->
	<section class="generic-banner">
		<div class="container">
			<div class="row height align-items-center justify-content-center">
				<div class="col-lg-10">
					<div class="generic-banner-content margen1">
						<h2 class="text-white"><?php echo $titulo; ?></h2>
						<p class="text-white">USUARIO: <?php echo $nombre; ?> - EDITAR TABL&Oacute;N DE ANUNCIOS</p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="section-top-border">
		<h3 class="mb-30">DOCUMENTACI&Oacute;N PREVIA:</h3>
		<a href="subir_comp_new.php?tipo=previa&id=<?php echo $id; ?>&usuario=<?php echo $usuario; ?>"><span>SUBIR ARCHIVO</span></a>
		<?php
		$info = $mysqli2->query("SELECT nombre,ruta,orden,id FROM web_archivos
						WHERE idcarrera='$idCarrera' AND tipo='previa' ORDER BY orden ASC");
		if ($info->num_rows > 0) {
			$par = 0;
			echo '<table width="100%">';
			while ($fila = $info->fetch_array()) {
				if ($par % 2 == 0)
					$classcss = "filapar";
				else
					$classcss = "filaimpar";

				$titulo = $fila['nombre'];
				$orden = $fila['orden'];
				$idinfo = $fila['id'];
				$archivo = $fila['ruta'];
				$id_ta = $fila['id'];
				echo "<tr class='" . $classcss . "'><td>ID." . $id_ta . "</td><td><a href='http://codea.es/pruebas/2021/".$idCarrera."/" . $archivo . "' target='_blank'>" . $titulo . "</a>
								</td><td><a class='confir' href='borrar_new.php?id=" . $id . "&idinfo=" . $idinfo . "&tipo=previa&temporada=" . $temporada . "&archivo=" . $archivo . "'>BORRAR</a>
								</td><td>" . $orden . "</td></tr>";
				$par++;
			}
			echo '</table>';
		} else
			echo '<p>No existe documentacion</p>';
		?>
	</div>
	</section>
	<div class="section-top-border">
		<h3 class="mb-30">DOCUMENTACI&Oacute;N DE CARRERA:</h3>
		<a href="subir_comp_new.php?tipo=carrera&id=<?php echo $id; ?>&newBD=true&usuario=<?php echo $usuario; ?>"><span>SUBIR ARCHIVO</span></a>
		<?php
		$info = mysql_query("SELECT nombre,url_archivo,orden,id FROM abc_57os_ca_carrera_archivo
						WHERE id_ca_carrera='$idCarrera' AND tipo='carrera' ORDER BY orden ASC");
		if (mysql_num_rows($info) > 0) {
			$par = 0;
			echo '<table width="100%">';
			while ($fila = mysql_fetch_array($info)) {
				if ($par % 2 == 0)
					$classcss = "filapar";
				else
					$classcss = "filaimpar";

				$titulo = $fila['nombre'];
				$orden = $fila['orden'];
				$idinfo = $fila['id'];
				$archivo = $fila['url_archivo'];
				$id_ta = $fila['id'];
				echo '<tr class="' . $classcss . '"><td>ID.' . $id_ta . '</td><td><a href="http://codea.es/' . $archivo . '" target="_blank">' . $titulo . '</a>
								</td><td><a class="confir" href="borrar_new.php?id=' . $id . '&idinfo=' . $idinfo . '&tipo=carrera&temporada=' . $temporada . '&archivo=' . $archivo . '">BORRAR</a>
								</td><td>' . $orden . '</td></tr>';
				$par++;
			}
			echo '</table>';
		} else
			echo '<p>No existe documentacion</p>';
		?>
	</div>
	</section>
	<div class="section-top-border">
		<h3 class="mb-30">DOCUMENTACI&Oacute;N COMISARIOS:</h3>
		<a href="subir_comp_new.php?tipo=comisarios&id=<?php echo $id; ?>&newBD=true&usuario=<?php echo $usuario; ?>"><span>SUBIR ARCHIVO</span></a>
		<?php
		$info = mysql_query("SELECT nombre,url_archivo,orden,id FROM abc_57os_ca_carrera_archivo
						WHERE id_ca_carrera='$idCarrera' AND tipo='comisarios' ORDER BY orden ASC");
		if (mysql_num_rows($info) > 0) {
			$par = 0;
			echo '<table width="100%">';
			while ($fila = mysql_fetch_array($info)) {
				if ($par % 2 == 0)
					$classcss = "filapar";
				else
					$classcss = "filaimpar";

				$titulo = $fila['nombre'];
				$orden = $fila['orden'];
				$idinfo = $fila['id'];
				$archivo = $fila['url_archivo'];
				$id_ta = $fila['id'];
				echo '<tr class="' . $classcss . '"><td>ID.' . $id_ta . '</td><td><a href="http://codea.es/' . $archivo . '" target="_blank">' . $titulo . '</a></td><td><a class="confir" href="borrar_new.php?id=' . $id . '&idinfo=' . $idinfo . '&tipo=previa&temporada=' . $temporada . '&archivo=' . $archivo . '">BORRAR</a></td><td>' . $orden . '</td></tr>';
				$par++;
			}
			echo '</table>';
		} else
			echo '<p>No existe documentacion</p>';
		?>
	</div>
	</section>
	<div class="section-top-border">
		<h3 class="mb-30">DOCUMENTACI&Oacute;N DIRECCI&Oacute;N DE CARRERA:</h3>
		<a href="subir_comp_new.php?tipo=direccion&id=<?php echo $id; ?>&newBD=true&usuario=<?php echo $usuario; ?>"><span>SUBIR ARCHIVO</span></a>
		<?php
		$info = mysql_query("SELECT nombre,url_archivo,orden,id FROM abc_57os_ca_carrera_archivo
						WHERE id_ca_carrera='$idCarrera' AND tipo='direccion' ORDER BY orden ASC");
		if (mysql_num_rows($info) > 0) {
			$par = 0;
			echo '<table width="100%">';
			while ($fila = mysql_fetch_array($info)) {
				if ($par % 2 == 0)
					$classcss = "filapar";
				else
					$classcss = "filaimpar";

				$titulo = $fila['nombre'];
				$orden = $fila['orden'];
				$idinfo = $fila['id'];
				$archivo = $fila['url_archivo'];
				$id_ta = $fila['id'];
				echo '<tr class="' . $classcss . '"><td>ID.' . $id_ta . '</td><td><a href="http://codea.es/' . $archivo . '" target="_blank">' . $titulo . '</a></td><td><a class="confir" href="borrar_new.php?id=' . $id . '&idinfo=' . $idinfo . '&tipo=previa&temporada=' . $temporada . '&archivo=' . $archivo . '">BORRAR</a></td><td>' . $orden . '</td></tr>';
				$par++;
			}
			echo '</table>';
		} else
			echo '<p>No existe documentacion</p>';
		?>
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
					<div class="single-footer-widget">
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
	<script type="text/javascript">
		$('.confir').on('click', function() {
			return confirm('VAS A ELIMINAR UN COMPLEMENTO Y SU ARCHIVO?');
		});
	</script>
</body>

=======
<?php
/*SCRIPT DE VALIDACION PARA USUARIOS DE LA WEB*/
session_start();
error_reporting(0);
include("conexion.php");
$id = $_GET['id'];
if (!isset($_SESSION['pass']) && empty($_SESSION['pass']))
	echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=acceso.php?id=' . $id . '">';
?>
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
					<ul class="nav-menu">
						<li><a href="cerrar.php?id=<?php echo $id; ?>">cerrar y volver al inicio</a></li>
					</ul>
				</nav><!-- #nav-menu-container -->
			</div>
		</div>
	</header><!-- #header -->
	<?php
	/*	$IPservidor = "localhost";
	$nombreBD = "codea_es_sistema";
	$usuario = "manuel";
	$clave = "coda200900==";
$conexion = mysql_connect($IPservidor, $usuario, $clave) or die("<h2>No hay conexi&oacute;n con el servidor MySQL</h2>");
mysql_query ("SET NAMES 'utf8'");
mysql_select_db($nombreBD) or die('no se encontro la bd');
*/
	include_once("includes/dateAfecha.php"); //para hacer operaciones con fechas
	include("includes/nombresTildes.php");
	if (isset($_GET["id"])) { //En el caso de pruebas creadas a través del PROGRAMA
		$idCarrera = $_GET["id"];
		if (isset($idCarrera)) {
			//idcarreras, descripcion, fecha_larga, estado, tipo_carrera, tipo_informe, modo_tiempos, temporada, organizador, fecha, idWeb, titulo, poblacion, desactivada, imagen
			$dbQuery = "SELECT nombre FROM abc_57os_ca_carrera WHERE abc_57os_ca_carrera.id = '$idCarrera'";
			$resultado = $mysqli->query($dbQuery) or print "No se pudo acceder al contenido.";
			if ($resultado->num_rows > 0) {
				$rows = $resultado->fetch_array();
				$titulo = $rows['nombre'];
			}
		}
	}
	/*$nom = mysql_query("SELECT nombre,id_usuario FROM abc_57os_ca_secretario WHERE id_ca_carrera='$idCarrera'");
	if(mysql_num_rows($nom) > 0)
	{
	$nombre = @mysql_result($nom, 0, "nombre");
	$usuario = @mysql_result($nom, 0, "id_usuario");
	}*/
	?>

	<!-- start banner Area -->
	<section class="generic-banner">
		<div class="container">
			<div class="row height align-items-center justify-content-center">
				<div class="col-lg-10">
					<div class="generic-banner-content margen1">
						<h2 class="text-white"><?php echo $titulo; ?></h2>
						<p class="text-white">USUARIO: <?php echo $nombre; ?> - EDITAR TABL&Oacute;N DE ANUNCIOS</p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="section-top-border">
		<h3 class="mb-30">DOCUMENTACI&Oacute;N PREVIA:</h3>
		<a href="subir_comp_new.php?tipo=previa&id=<?php echo $id; ?>&usuario=<?php echo $usuario; ?>"><span>SUBIR ARCHIVO</span></a>
		<?php
		$info = $mysqli2->query("SELECT nombre,ruta,orden,id FROM web_archivos
						WHERE idcarrera='$idCarrera' AND tipo='previa' ORDER BY orden ASC");
		if ($info->num_rows > 0) {
			$par = 0;
			echo '<table width="100%">';
			while ($fila = $info->fetch_array()) {
				if ($par % 2 == 0)
					$classcss = "filapar";
				else
					$classcss = "filaimpar";

				$titulo = $fila['nombre'];
				$orden = $fila['orden'];
				$idinfo = $fila['id'];
				$archivo = $fila['ruta'];
				$id_ta = $fila['id'];
				echo "<tr class='" . $classcss . "'><td>ID." . $id_ta . "</td><td><a href='http://codea.es/pruebas/2021/".$idCarrera."/" . $archivo . "' target='_blank'>" . $titulo . "</a>
								</td><td><a class='confir' href='borrar_new.php?id=" . $id . "&idinfo=" . $idinfo . "&tipo=previa&temporada=" . $temporada . "&archivo=" . $archivo . "'>BORRAR</a>
								</td><td>" . $orden . "</td></tr>";
				$par++;
			}
			echo '</table>';
		} else
			echo '<p>No existe documentacion</p>';
		?>
	</div>
	</section>
	<div class="section-top-border">
		<h3 class="mb-30">DOCUMENTACI&Oacute;N DE CARRERA:</h3>
		<a href="subir_comp_new.php?tipo=carrera&id=<?php echo $id; ?>&newBD=true&usuario=<?php echo $usuario; ?>"><span>SUBIR ARCHIVO</span></a>
		<?php
		$info = mysql_query("SELECT nombre,url_archivo,orden,id FROM abc_57os_ca_carrera_archivo
						WHERE id_ca_carrera='$idCarrera' AND tipo='carrera' ORDER BY orden ASC");
		if (mysql_num_rows($info) > 0) {
			$par = 0;
			echo '<table width="100%">';
			while ($fila = mysql_fetch_array($info)) {
				if ($par % 2 == 0)
					$classcss = "filapar";
				else
					$classcss = "filaimpar";

				$titulo = $fila['nombre'];
				$orden = $fila['orden'];
				$idinfo = $fila['id'];
				$archivo = $fila['url_archivo'];
				$id_ta = $fila['id'];
				echo '<tr class="' . $classcss . '"><td>ID.' . $id_ta . '</td><td><a href="http://codea.es/' . $archivo . '" target="_blank">' . $titulo . '</a>
								</td><td><a class="confir" href="borrar_new.php?id=' . $id . '&idinfo=' . $idinfo . '&tipo=carrera&temporada=' . $temporada . '&archivo=' . $archivo . '">BORRAR</a>
								</td><td>' . $orden . '</td></tr>';
				$par++;
			}
			echo '</table>';
		} else
			echo '<p>No existe documentacion</p>';
		?>
	</div>
	</section>
	<div class="section-top-border">
		<h3 class="mb-30">DOCUMENTACI&Oacute;N COMISARIOS:</h3>
		<a href="subir_comp_new.php?tipo=comisarios&id=<?php echo $id; ?>&newBD=true&usuario=<?php echo $usuario; ?>"><span>SUBIR ARCHIVO</span></a>
		<?php
		$info = mysql_query("SELECT nombre,url_archivo,orden,id FROM abc_57os_ca_carrera_archivo
						WHERE id_ca_carrera='$idCarrera' AND tipo='comisarios' ORDER BY orden ASC");
		if (mysql_num_rows($info) > 0) {
			$par = 0;
			echo '<table width="100%">';
			while ($fila = mysql_fetch_array($info)) {
				if ($par % 2 == 0)
					$classcss = "filapar";
				else
					$classcss = "filaimpar";

				$titulo = $fila['nombre'];
				$orden = $fila['orden'];
				$idinfo = $fila['id'];
				$archivo = $fila['url_archivo'];
				$id_ta = $fila['id'];
				echo '<tr class="' . $classcss . '"><td>ID.' . $id_ta . '</td><td><a href="http://codea.es/' . $archivo . '" target="_blank">' . $titulo . '</a></td><td><a class="confir" href="borrar_new.php?id=' . $id . '&idinfo=' . $idinfo . '&tipo=previa&temporada=' . $temporada . '&archivo=' . $archivo . '">BORRAR</a></td><td>' . $orden . '</td></tr>';
				$par++;
			}
			echo '</table>';
		} else
			echo '<p>No existe documentacion</p>';
		?>
	</div>
	</section>
	<div class="section-top-border">
		<h3 class="mb-30">DOCUMENTACI&Oacute;N DIRECCI&Oacute;N DE CARRERA:</h3>
		<a href="subir_comp_new.php?tipo=direccion&id=<?php echo $id; ?>&newBD=true&usuario=<?php echo $usuario; ?>"><span>SUBIR ARCHIVO</span></a>
		<?php
		$info = mysql_query("SELECT nombre,url_archivo,orden,id FROM abc_57os_ca_carrera_archivo
						WHERE id_ca_carrera='$idCarrera' AND tipo='direccion' ORDER BY orden ASC");
		if (mysql_num_rows($info) > 0) {
			$par = 0;
			echo '<table width="100%">';
			while ($fila = mysql_fetch_array($info)) {
				if ($par % 2 == 0)
					$classcss = "filapar";
				else
					$classcss = "filaimpar";

				$titulo = $fila['nombre'];
				$orden = $fila['orden'];
				$idinfo = $fila['id'];
				$archivo = $fila['url_archivo'];
				$id_ta = $fila['id'];
				echo '<tr class="' . $classcss . '"><td>ID.' . $id_ta . '</td><td><a href="http://codea.es/' . $archivo . '" target="_blank">' . $titulo . '</a></td><td><a class="confir" href="borrar_new.php?id=' . $id . '&idinfo=' . $idinfo . '&tipo=previa&temporada=' . $temporada . '&archivo=' . $archivo . '">BORRAR</a></td><td>' . $orden . '</td></tr>';
				$par++;
			}
			echo '</table>';
		} else
			echo '<p>No existe documentacion</p>';
		?>
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
					<div class="single-footer-widget">
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
	<script type="text/javascript">
		$('.confir').on('click', function() {
			return confirm('VAS A ELIMINAR UN COMPLEMENTO Y SU ARCHIVO?');
		});
	</script>
</body>

>>>>>>> main
</html>