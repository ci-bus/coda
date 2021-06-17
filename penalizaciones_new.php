<?php
include_once("includes/dateAfecha.php"); //para hacer operaciones con fechas
if (isset($_GET["id"])) {
	$idCarrera = $_GET["id"];
	include("conexion.php");
	include("escudos.php");
	include("includes/funciones.php");
	include("includes/funcionesTiempos.php");
	$dbQuery = "SELECT titulo,fecha_larga FROM web_pruebas WHERE idcarrera = '$idCarrera'";
	$resultado = $mysqli2->query($dbQuery) or print "No se pudo acceder al contenido.";
	if ($resultado->num_rows > 0) {
		while ($row = $resultado->fetch_array()) {
			$titulo = $row['titulo'];
			$fecha = $row['fecha_larga'];
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
					<a href="index.html"><img src="img/logo.png" alt="" title="" /></a>
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
						<p class="text-white">LISTA DE PENALIZACIONES</p>
					</div>
				</div>
			</div>
			<?php
			include("menu_pruebas.php");
			?>
		</div>
	</section>
	<div class="section-top-border">
		<?php
		/*$pen = $mysqli2->query("SELECT inscritos.piloto,inscritos.copiloto,tiempos.t_t,SUM(tiempos.penalizacion) AS penalizacion,inscritos.vehiculo,inscritos.concursante,
		inscritos.dorsal AS dorsal,inscritos.modelo,inscritos.grupo,
		inscritos.clase,inscritos.agrupacion,inscritos.categoria,inscritos.nac_piloto,inscritos.nac_copiloto,inscritos.nac_competidor
		FROM web_inscritos inscritos
	INNER JOIN web_tiempos tiempos ON tiempos.idinscrito = inscritos.idinscrito
	WHERE tiempos.idcarrera='$idCarrera' AND tiempos.penalizacion!=0
	GROUP BY dorsal");*/
	$pen = $mysqli->query("SELECT penalizacion.motivo,penalizacion.tiempo,penalizacion.control,piloto.nombre AS piloto,copiloto.nombre AS copiloto,
	concursante.nombre AS concursante, competidor.dorsal,vehiculo.marca AS vehiculo
	FROM abc_57os_ca_penalizacion penalizacion
	INNER JOIN abc_57os_ca_competidor competidor ON competidor.id=penalizacion.id_ca_competidor
	INNER JOIN abc_57os_ca_piloto piloto ON piloto.id = competidor.id_ca_piloto
	INNER JOIN abc_57os_ca_copiloto copiloto ON copiloto.id = competidor.id_ca_copiloto
	INNER JOIN abc_57os_ca_concursante concursante ON concursante.id = competidor.id_ca_concursante
	INNER JOIN abc_57os_ca_vehiculo vehiculo ON vehiculo.id = competidor.id_Ca_vehiculo
	WHERE penalizacion.id_ca_carrera='$idCarrera'
	ORDER BY competidor.dorsal ASC");
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
							<p class="mini1 nomargen">Cat./Agr.</p>
						</th>
						<th>MOTIVO</th>
						<th>TIEMPO</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if ($pen->num_rows > 0) {
						while ($fila = $pen->fetch_array()) {
							$dorsal = $fila['dorsal'];
							$motivo = $fila['motivo'];
							$concursante = $fila['concursante'];
							$piloto = $fila['piloto'];
							$copiloto = $fila['copiloto'];
							$marca = $fila['vehiculo'];
							$modelo = $fila['modelo'];
							$tiempo = milisegundos_a_tiempo(segundos_a_milisegundos($fila['tiempo']));
							$grupo = $fila['grupo'];
							$clase = $fila['clase'];
							$agr = $fila['agrupacion'];
							$cat = $fila['categoria'];
							$clases = $grupo . "/" . $clase . "<br>" . $cat . "/" . $agr;

							$con_nac = $fila['nac_competidor'];
							$con_nacs = explode("/", $con_nac);
							$con_nac1 = bandera($con_nacs[0]);
							$con_nac2 = bandera($con_nacs[1]);

							$pi_nac = $fila['nac_piloto'];
							$pi_nacs = explode('/', $pi_nac);
							$pi_nac1 = bandera($pi_nacs[0]);
							$pi_nac2 = bandera($pi_nacs[1]);

							$copi_nac = $fila['nac_copiloto'];
							$copi_nacs = explode('/', $copi_nac);
							$copi_nac1 = bandera($copi_nacs[0]);
							$copi_nac2 = bandera($copi_nacs[1]);
							if ($par % 2 == 0)
								$classcss = "filapar";
							else
								$classcss = "filaimpar";
							echo "<tr class='" . $classcss . "'><td class='dor negrita'>" . $dorsal . "</td><td>" . $concursante . "</td>";
							if ($copiloto == '' || $copiloto == '0')
								echo "<td>" . $piloto . "</td>";
							else {
								echo '<td class="con"><img class="banderas" src="' . $pi_nac1 . '"><img class="banderas" src="' . $pi_nac2 . '">' . $piloto;
								echo '<br><img class="banderas" src="' . $copi_nac1 . '"><img class="banderas" src="' . $copi_nac2 . '">' . $copiloto . '</td>';
							}
							echo "<td>" . escudo($marca) . "</td><td class='centro veh'>" . $marca . " " . $modelo . "<br>" . $clases . "</td>";
							echo "<td class='centro'>" . $motivo . "</td><td class='penalizaciones veh'>" . $tiempo . "</td></tr>";
							$par++;
						}
					} //IF
					else
						echo "<tr><td colspan='7'>No existen Penalizaciones en esta carrera</td></tr>";
					?>
			</table>
		</div>
	</div>
	<footer class="footer-area section-gap">
		<?php
		include("footer.php");
		?>
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