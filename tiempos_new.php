<?php
include_once("includes/dateAfecha.php"); //para hacer operaciones con fechas
include("includes/nombresTildes.php");
if (isset($_GET["id"])) { //En el caso de pruebas creadas a través del PROGRAMA
	$idCarrera = $_GET["id"];
	if (isset($idCarrera)) {
		include("conexion.php");
		//idcarreras, descripcion, fecha_larga, estado, tipo_carrera, tipo_informe, modo_tiempos, temporada, organizador, fecha, idWeb, titulo, poblacion, desactivada, imagen
		$dbQuery = "SELECT titulo,fecha_larga FROM web_pruebas WHERE idcarrera = '$idCarrera'";
		$resultado = $mysqli2->query($dbQuery) or print "No se pudo acceder al contenido.";
		if ($resultado->num_rows > 0) {
			while ($row = $resultado->fetch_array()) {
				$titulo = $row['titulo'];
				$fechal = $row['fecha_larga'];
			}
		}
	}
}
/*
if(!isset($_GET['Ancho']) && !isset($_GET['Alto'])){
    echo "<script language=\"JavaScript\">
    document.location=\"$PHP_SELF?id=$idCarrera&newBD=true&Ancho=\"+screen.width;
    </script>";
}*/
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
/*
$sql = "SELECT descripcion,id FROM abc_57os_ca_etapa\n". "WHERE id_ca_carrera ='$idCarrera'";
						$etapas = $mysqli->query($sql) or print ("error");
							if($etapas->num_rows>0)
								{
								while($fila=$etapas->fetch_array())
									{
									$idetapa = $fila['id'];
									$nom_etapa = $fila['descripcion'];
									$sql2 = "SELECT descripcion,id FROM abc_57os_ca_seccion\n". "WHERE id_ca_etapa ='$idetapa'";
									$secciones = $mysqli->query($sql2) or print ("error");
									if($secciones->num_rows>0)
										{
										while($fila2 = $secciones->fetch_array())
											{
											$idseccion = $fila2['id'];
											$fecha = $fila2['descripcion'];
											$sql3 = "SELECT descripcion,id,hora_salida,estado,longitud FROM abc_57os_ca_manga\n". "WHERE id_ca_seccion ='$idseccion' AND abc_57os_ca_manga.tipo!=2";
											$mangas = $mysqli->query($sql3) or print ("error");
											if($secciones ->num_rows > 0)
												{
												while($fila3 = $mangas->fetch_array())
													{
													$idmanga = $fila3['id'];
													$descripcion = $fila3['descripcion'];
													$num_mangas++;
													$hora = $fila3['hora_salida'];
													$estado = $fila3['estado'];
													$long = $fila3['longitud'];
													$dias[] = array(
														'dia' => $nom_etapa, 
														'descripcion' => $descripcion, 
														'fecha' => $fecha,
														'idmanga' => $idmanga,
														'hora'=>$hora,
														'estado'=>$estado);
													}
												}
											}
										}
									}
								}
								*/
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
			include("menu_pruebas.php");
			?>
		</div>
	</section>

	<div class="section-top-border">
		<h3 class="mb-30">TRAMOS DISPONIBLES</h3>
		<table width="100%" id="tab_tem">
			<?php
			$par = 0;
			$sql = "SELECT descripcion,id FROM web_etapa\n" . "WHERE id_ca_carrera ='$idCarrera'";
			$etapas = $mysqli2->query($sql) or print("error");
			if ($etapas->num_rows > 0) {
				while ($fila = $etapas->fetch_array()) {
					$idetapa = $fila['id'];
					$nom_etapa = $fila['descripcion'];
					echo '<tr class="etapa"><td class="eta_pd" colspan="5">' . $nom_etapa . '</td></tr>';
					$sql2 = "SELECT descripcion,id FROM web_seccion\n" . "WHERE id_ca_etapa ='$idetapa'";
					$secciones = $mysqli2->query($sql2) or print("error");
					if ($secciones->num_rows > 0) {
						while ($fila2 = $secciones->fetch_array()) {
							$idseccion = $fila2['id'];
							$fecha = $fila2['descripcion'];
							echo '<tr class="seccion"><td class="sec_pd" colspan="5">' . $fecha . '</td></tr>';
							$sql3 = "SELECT descripcion,id,hora_salida,estado,longitud FROM web_manga\n" . "WHERE id_ca_seccion ='$idseccion' AND web_manga.tipo!=2";
							$mangas = $mysqli2->query($sql3) or print("error");
							if ($secciones->num_rows > 0) {
								while ($fila3 = $mangas->fetch_array()) {
									if ($par % 2 == 0)
										$classcss = 'filapar';
									else
										$classcss = 'filaimpar';
									$idmanga = $fila3['id'];
									$descripcion = $fila3['descripcion'];
									$hora = $fila3['hora_salida'];
									$estado = $fila3['estado'];
									$long = $fila3['longitud'];
									$inter = $mysqli2->query("SELECT id FROM web_manga_control_horario WHERE id_ca_manga='$idmanga'");
									if ($inter->num_rows > 0) {
										echo '<tr class="manga ' . $classcss . '"><td class="man_pd">
															<p><a href="manga_new.php?id=' . $idCarrera . '&idmanga=' . $idmanga . '">' . $descripcion . '</a></p>';
										echo '<p class="margen_p_coches"><span class="span_coches">' . $porsalir . '<img src="img/coche2.png" width="30px" class="margen_coches"></span><span class="span_coches">' . $enpista . '<img src="img/coche3.png" width="30px" class="margen_coches"></span><span class="span_coches">' . $enmeta . '<img src="img/coche1.png" width="30px" class="margen_coches"></span><span class="span_coches">' . $abandonos . '<img src="img/coche4.png" width="30px" class="margen_coches"></span></p>';
										echo '</td><td class="cursiva"><a href="inter_new.php?id=' . $idCarrera . '&idmanga=' . $idmanga . '">TIEMPOS INTERMEDIOS</a></td>
															<td>' . $hora . ' H</td><td>' . ($long / 1000) . ' Kms</td><td><img src="img/' . estado($estado) . '" width="15px"></td></tr>';
										$par++;
									} else {
										echo '<tr class="manga ' . $classcss . '"><td class="man_pd">
															<p><a href="manga_new.php?id=' . $idCarrera . '&idmanga=' . $idmanga . '&copa=0">' . $descripcion . '</a></p>';
										echo '<p class="margen_p_coches"><span class="span_coches">' . $porsalir . '<img src="img/coche2.png" width="30px" class="margen_coches"></span><span class="span_coches">' . $enpista . '<img src="img/coche3.png" width="30px" class="margen_coches"></span><span class="span_coches">' . $enmeta . '<img src="img/coche1.png" width="30px" class="margen_coches"></span><span class="span_coches">' . $abandonos . '<img src="img/coche4.png" width="30px" class="margen_coches"></span></p>';
										echo '</td><td></td>
															<td>' . $hora . ' H</td><td>' . ($long / 1000) . ' Kms</td><td><img src="img/' . estado($estado) . '" width="15px"></td></tr>';
									}
									$par++;
								}
							}
						}
					}
				}
			} else
				echo '<tr><td>no existen etapas</td></tr>';
			?>
		</table>
		<br>
		<br>
		<?php
		if ($idCarrera=='52'){
		echo '<div class="section-top-border">';
			echo '<h4 class="mb-30">TIEMPOS REGULARIDAD</h4>';
			echo '<div class="progress-table-wrap">';
				echo '<div class="progress-table">';
					echo "<div class='table-row'><a href='http://html5.anube.es/?rally=rally2847&token=' target='_blank'>REGULARIDAD SPORT</a><div class='serial'></div><div class='country'></div></div>";
					echo "<div class='table-row'><a href='http://html5.anube.es/?rally=rally2846&token=' target='_blank'>REGULARIDAD CLASICA</a><div class='serial'></div><div class='country'></div></div>";
				echo "</div></div></div></section>";
		}
				?>
		<div class="section-top-border">
			<h4 class="mb-30">&Uacute;LTIMA HORA:</h4>
			<div class="progress-table-wrap">
				<div class="progress-table">
					<?php
					$sql = $mysqli2->query("SELECT * FROM web_ult_hora WHERE idcarrera='$idCarrera' ORDER BY id DESC");
					if ($sql->num_rows == 0)
						echo "No se han publicado noticias";
					else {
						while ($row = $sql->fetch_array()) {
							$info = $row['info'];
							$hora = $row['hora'];
							$icono = $row['icono'];
							switch ($icono) {
								case 1:
									$icono = "iamarillo";
									break;
								case 2:
									$icono = "iazul";
									break;
								case 3:
									$icono = "iverde";
									break;
								case 4:
									$icono = "inaranja";
									break;
								case 5:
									$icono = "irojo";
									break;
							}
							echo "<div class='table-row " . $icono . "'><div class='serial'>" . $hora . "</div><div class='country'>" . $info . "</div></div>";
						}
					}

					?>
				</div>
			</div>
		</div>
		</section>
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