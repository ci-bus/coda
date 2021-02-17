<?php
include_once("includes/dateAfecha.php"); //para hacer operaciones con fechas
//include("includes/nombresTildes.php");
if (isset($_GET["id"])) {
	$idCarrera = $_GET["id"];
	include("conexion.php");
	include("escudos.php");
	include("includes/funciones.php");
	$DB_PREFIJO = "abc_57os_";
	$dbQuery = "SELECT titulo,fecha_larga FROM web_pruebas WHERE idcarrera = '$idCarrera'";
	$resultado = $mysqli2->query($dbQuery) or print "No se pudo acceder al contenido.";
	if ($resultado->num_rows > 0) {
		while ($row = $resultado->fetch_array()) {
			$titulo = $row['titulo'];
			$fechal = $row['fecha_larga'];
		}
	}
}
/*	$saber_copis = mysql_query("SELECT id_ca_copiloto FROM abc_57os_ca_competidor WHERE id_ca_carrera='$idCarrera' AND id_ca_copiloto!=0");
		if(mysql_num_rows($saber_copis)==0)
			$copis=0;
		else
			$copis=1;*/
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
						<li class="menu-active"><a href="temporada.php?newBD=true">Temporada</a></li>
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
						<p class="text-white">LISTA DE INSCRITOS</p>
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
		$sql = "SELECT dorsal,idinscrito,concursante,piloto,copiloto,nac_competidor,nac_piloto,nac_copiloto,vehiculo,modelo,cc,cc_turbo,grupo,clase,categoria,agrupacion
				FROM web_inscritos 
				WHERE idcarrera='$idCarrera' AND excluido=0 ORDER BY dorsal ASC";

		$resultado = $mysqli2->query($sql) or print "No se pudo acceder al contenido de los tiempos online.";
		?>
		<table width="100%" border="0" id="tab_tem">
			<thead>
				<tr>
					<th>N.</th>
					<th>Concursante</th>
					<th>Equipo</th>
					<th class="centro" colspan="2">Vehiculo</th>
					<th class="centro">C.C</th>
					<th>Camp.</th>
					<th class="centro">Cat</th>
					<th class="centro">Grupo</th>
					<th class="centro">Clase</th>
					<th class="centro">Agru.</th>
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
						$idinscrito = $fila['idinscrito'];
						$campeonato='';
						$saber_campeonatos = $mysqli2->query("SELECT cam.nombre AS nombre FROM web_campeonatos cam 
						INNER JOIN web_campeonatos_inscritos ci ON ci.idcampeonato=cam.id
						WHERE ci.idinscrito='$idinscrito'");
						while($row=$saber_campeonatos->fetch_array()){
							$campeonato.=$row['nombre']."<br>";
						}
						$dorsal = $fila['dorsal'];
						$competidor = $fila['concursante'];
						//$cc = $fila['cc'];
						$cc_turbo = $fila['cc_turbo'];
						$agr = $fila['agrupacion'];
						$cat = $fila['categoria'];
						$piloto = $fila['piloto'];
						$copiloto = $fila['copiloto'];
						$vehiculo = $fila['vehiculo'];
						$modelo = $fila['modelo'];
						$grupo = $fila['grupo'];
						$clase = $fila['clase'];
						$con_nac = $fila['con_nac'];
						$con_nac = explode("/", $con_nac);
						$con_nac1 = bandera($con_nac[0]);
						$con_nac2 = bandera($con_nac[1]);

						$pi_nac = $fila['nac_piloto'];
						$pi_nacs = explode('/', $pi_nac);
						$pi_nac1 = bandera($pi_nacs[0]);
						$pi_nac2 = bandera($pi_nacs[1]);

						$copi_nac = $fila['nac_copiloto'];
						$copi_nacs = explode('/', $copi_nac);
						$copi_nac1 = bandera($copi_nacs[0]);
						$copi_nac2 = bandera($copi_nacs[1]);
						
						$h_salida = $fila['hora_salida'];
						$idcompetidor = $fila['idinscrito'];
						if ($h_salida == '')
							$h_salida = "---";
						echo "<tr class='" . $classcss . "'><td class='dor negrita'>" . $dorsal . "</td><td>" . $competidor . "</td>";
						if ($copiloto == '' || $copiloto == '0')
							echo "<td class='con'>" . $piloto . "</td>";
						else {
							echo '<td class="con"><img class="banderas" src="' . $pi_nac1 . '"><img class="banderas" src="' . $pi_nac2 . '">' . $piloto;
							echo '<br><img class="banderas" src="' . $copi_nac1 . '"><img class="banderas" src="' . $copi_nac2 . '">' . $copiloto . '</td>';
						}
						echo "<td>".escudo($vehiculo)."</td><td class='centro'>" . $vehiculo . "<br>" . $modelo . "</td><td class='centro'>" . $cc_turbo . "</td><td>".$campeonato."</td><td>".$cat."</td><td>".$grupo."</td><td>".$clase."</td><td>".$agr."</td></tr>";

						$pos++;
						$par++;
					}
				} else
					echo "No existe lista de inscritos...";


				?>
		</table>
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