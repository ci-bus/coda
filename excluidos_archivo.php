<?php
include_once("includes/dateAfecha.php"); //para hacer operaciones con fechas
//include("includes/nombresTildes.php");
if (isset($_GET["id"])) {
	$idCarrera = $_GET["id"];
	include("conexion.php");
	include("escudos.php");
	include("includes/funciones.php");
	$DB_PREFIJO = "abc_57os_";
	$dbQuery = "SELECT titulo,fecha_larga FROM web_pruebas_archivo WHERE idcarrera = '$idCarrera'";
	$resultado = $mysqli2->query($dbQuery) or print "No se pudo acceder al contenido.";
	if ($resultado->num_rows > 0) {
		while ($row = $resultado->fetch_array()) {
			$titulo = $row['titulo'];
			$fechal = $row['fecha_larga'];
		}
	}
}
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
						<li>Inicio</li>
						<li><a href="temporada.php">Temporada</a></li>
						<li class="menu-active"><a href="archivo.php">Archivo</a></li>
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
						<p class="text-white">LISTA DE EXCLUIDOS</p>
					</div>
				</div>
			</div>
			<?php
			include("menu_pruebas_archivo.php");
			?>
		</div>
	</section>
	<div class="section-top-border">
		<?php
		$sql = "SELECT dorsal,idinscrito,concursante,piloto,copiloto,vehiculo,modelo,cc,cc_turbo,motivo_exclusion,
		grupo,clase,agrupacion,categoria
				FROM web_inscritos_archivo 
				WHERE idcarrera='$idCarrera' AND excluido=1 ORDER BY dorsal ASC";

		$resultado = $mysqli2->query($sql) or print "No se pudo acceder al contenido de los tiempos online.";
		?>
		<div id="div_contenedor">
			<table id="tabla_tiempos_ancha">
				<thead>
					<tr>
						<th>N.</th>
						<th>Concursante<img src='img/tactil.png' class='icono' name='tactil'></th>
						<th>Equipo</th>
						<th colspan="2" class="centro">
							<p>Vehiculo</p>
							<p class="mini1 nomargen">Grupo/clase</p>
							<p class="mini1 nomargen">Cat</p>
						</th>
						<th class="centro">MOTIVO</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if ($resultado->num_rows > 0) {
						$pos = 1;
						$par = 0;
						while ($fila = $resultado->fetch_array()) {
							if ($par % 2 == 0)
								$classcss = "filapar";
							else
								$classcss = "filaimpar";
							$dorsal = $fila['dorsal'];
							$competidor = $fila['concursante'];
							$agr = $fila['agrupacion'];
							$cat = $fila['categoria'];
							$piloto = $fila['piloto'];
							$copiloto = $fila['copiloto'];
							$vehiculo = $fila['vehiculo'];
							$modelo = $fila['modelo'];
							$grupo = $fila['grupo'];
							$clase = $fila['clase'];
							$clases = $grupo . "/" . $clase . "<br>" . $cat ;
							
							$motivo = $fila['motivo_exclusion'];

							$h_salida = $fila['hora_salida'];
							$idcompetidor = $fila['idinscrito'];
							if ($h_salida == '')
								$h_salida = "---";
							echo "<tr class='" . $classcss . "'><td class='dor negrita'>" . $dorsal . "</td><td>" . $competidor . "</td>";
							if ($copiloto == '' || $copiloto == '0')
								echo "<td>" . $piloto . "</td>";
							else {
								echo '<td>' . $piloto;
								echo '<br>' . $copiloto . '</td>';
							}
							echo "<td>" . escudo($vehiculo) . "</td><td class='centro veh'>" . $vehiculo . " " . $modelo . "<br>" . $clases . "</td><td class='centro'>" . $motivo . "</td></tr>";
							$pos++;
							$par++;
						}
					} else
						echo "<tr><td colspan='7'>No existen Descalificados...</td></tr>";


					?>
			</table>
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
</body>

</html>