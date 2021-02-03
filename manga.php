<?php
	if(isset($_GET["manga"]) && isset($_GET["id"]) && isset($_GET["orden"]))
	{
	$idManga = $_GET["manga"];
	$idCarrera = $_GET["pruebaprograma"];
	$orden = $_GET["orden"];
	}
	if(isset($_GET["copa"])){
		$copa = $_GET["copa"];
		}
	else {
			$copa = '0';
		}
include_once("includes/dateAfecha.php");//para hacer operaciones con fechas
//include("includes/nombresTildes.php");
if(isset($_GET["id"])){//En el caso de pruebas creadas a través del PROGRAMA
	$idCarrera = $_GET["id"];
if(isset($idCarrera)){
include("conexion.php");
//idcarreras, descripcion, fecha_larga, estado, tipo_carrera, tipo_informe, modo_tiempos, temporada, organizador, fecha, idWeb, titulo, poblacion, desactivada, imagen
$dbQuery = "SELECT idcarreras, descripcion, fecha_larga, titulo, imagen, mapa FROM carreras WHERE idcarreras = '$idCarrera' AND (desactivada = '0' OR desactivada IS NULL)";
$resultado = mysql_query($dbQuery) or print "No se pudo acceder al contenido.";
if(mysql_num_rows($resultado) > 0){

	$idCarrera = @mysql_result($resultado, 0, "idCarreras");
	$descripcion = @mysql_result($resultado, 0, "descripcion");
	$fecha = @mysql_result($resultado, 0, "fecha_larga");
	$titulo = @mysql_result($resultado, 0, "titulo");
	$imagen = @mysql_result($resultado, 0, "imagen");
	$mapa = @mysql_result($resultado, 0, "mapa");
	$descripcion = utf8_encode(strtoupper($descripcion));//La paso a mayusculas y corrigo las tildes y eñes
	$descripcion=nl2br($descripcion);
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
								<h2 class="text-white"><?php echo $titulo;?></h2>
								<!--p class="text-white">It won’t be a bigger problem to find one video game lover in your <br> neighbor. Since the introduction of Virtual Game.</p-->
							</div>
						</div>
					</div>
					<a href="#" class="primary-btn text-uppercase">INSCRITOS</a>
					<a href="#" class="primary-btn text-uppercase">AUTORIZADOS</a>
					<a href="#" class="primary-btn text-uppercase">ABANDONOS</a>
					<a href="#" class="primary-btn text-uppercase">PENALIZACIONES</a>
				</div>
			</section>		
					<div class="section-top-border">
						   <table><form>
		<tr><td>COPAS:</td><td><select name="copas">
					<?php
					$dbQueryFiltroCopas = "SELECT idcopas, idcarreras, descripcion FROM copas WHERE idcarreras='$idCarrera' ORDER BY descripcion";
	$resultadoFiltroCopas = mysql_query($dbQueryFiltroCopas);
	//echo "<li>".$idCarrera."</li>";
	//echo $copa;
	   if($copa=='0'){
				echo "<option selected='selected'>TODAS COPAS</option>";
	   }
	   else{
				echo "<option>TODAS LAS COPAS</option>";
	   }
	   ?>
	   <!--li class="<?php //echo $clase2;?>" onclick="cargar2('tiempos/clasificacionFinal.php','capa','con_bus3')">TODAS</p-->
	   <?php
	   //echo "<li class='men_li'>TODAS</li>";
	while($row=mysql_fetch_array($resultadoFiltroCopas)){
		$filtroCopa = $row["idcopas"];
		$filtroDesc = $row["descripcion"];
			if($filtroCopa==$copa){
				echo "<option selected='selected'>".$filtroDesc."</option>";
				$nom_copa = $filtroDesc;
				}
			else
				$clase2="negro";
			echo "<option>".$filtroDesc."</option>";
}	
echo "</select></td>";
echo "<td>MANGAS:</td><td><select name='mangas'>";
	$dbQueryk = "SELECT * FROM mangas WHERE idcarreras = '$idCarrera' ORDER BY orden ASC";
	$resultadok = mysql_query($dbQueryk) or print "No se pudo acceder al contenido de los tiempos online.";
	if (mysql_num_rows($resultadok) > 0)
			{
			while($fila=mysql_fetch_array($resultadok))
				{
				$idManga2 = $fila["idmangas"];
				$idcarreras = $fila["idcarreras"];
				$nombre = utf8_encode(strtoupper($fila["descripcion"]));
				$orden2 = $fila["orden"];
				if($_GET['manga']==$idManga2)
					{
					echo "<option selected='selected'>".$nombre."</option>";
					}
				else{
					echo "<option>".$nombre."</option>";
					}
				}
			}

echo "</select></td></form></table>";
echo "<hr><br>";
						include("mangas_recarga.php");
					?>
						<!--table border="1" width="100%">
							<tr>
								<td>uno</td>
								<td>dos</td>
							</tr>
							<tr>
								<td>uno</td>
								<td>dos</td>
							</tr>
						</table-->
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
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
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