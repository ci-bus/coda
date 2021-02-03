<?php
$DB_PREFIJO = "abc_57os_";
	if(isset($_GET["idmanga"]) && isset($_GET["id"]) && isset($_GET["idseccion"]) && isset($_GET['idetapa']))
	{
	$idManga = $_GET["idmanga"];
	$idCarrera = $_GET["id"];
	$idseccion = $_GET["idseccion"];
	$idetapa = $_GET["idetapa"];
	}
	if(isset($_GET["campeonato"])){
		$campeonato = $_GET["campeonato"];
		}
	else {
			$campeonato = '0';
		}
	if(isset($_GET["copa"]))
		$copa = $_GET["copa"];
	else
			$copa = '0';
//include_once("includes/dateAfecha.php");//para hacer operaciones con fechas
include("includes/funciones.php");
if(isset($_GET["id"])){//En el caso de pruebas creadas a través del PROGRAMA
	$idCarrera = $_GET["id"];
if(isset($idCarrera)){
include("conexion.php");
$dbQuery = "SELECT nombre,fecha_larga FROM abc_57os_ca_carrera WHERE id = '$idCarrera'";
$resultado = mysql_query($dbQuery) or print "No se pudo acceder al contenido.";
if(mysql_num_rows($resultado) > 0){
	$titulo = @mysql_result($resultado, 0, "nombre");
	$fecha = @mysql_result($resultado, 0, "fecha_larga");
			}
		}
	}
	$modo_tiempo = mysql_query("SELECT tiempo_tipo FROM abc_57os_ca_campeonato WHERE id_ca_carrera = '$idCarrera'");
	if(mysql_num_rows($modo_tiempo) > 0)
		$tipo_prueba = @mysql_result($modo_tiempo, 0, "tiempo_tipo");
$enlace_actual = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>	
	<!DOCTYPE html>
	<html lang="zxx" class="no-js">
	<head>
<META HTTP-EQUIV="Refresh" CONTENT="20;URL=<?php echo $enlace_actual;?>">
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
								<h2 class="text-white"><?php echo $tipo_prueba.$titulo;?></h2>
									<p class="text-white"><?php echo $fecha;?></p>
								</div>
						</div>
					</div>
					<a href="tiempos_new.php?id=<?php echo $idCarrera;?>&newBD=true" class="primary-btn text-uppercase selected">VOLVER</a>
					<a href="clas_final_newb.php?id=<?php echo $idCarrera;?>&newBD=true&campeonato=0&copa=0&grupo=0&clase=0" class="primary-btn text-uppercase selected">CLASIFICACI&Oacute;N FINAL</a>
				</div>
			</section>		
					<div class="section-top-border">
						   <table><form>
		<tr>
		<?php
	echo "<td>COPAS:</td><td><select name='copas' onchange='surfto2(this.form)'>";
	//echo "<td>COPAS:</td><td><select name='copas'>";
	$FiltroCopa = "SELECT c.descripcion,c.id FROM abc_57os_ca_copa c 
INNER JOIN abc_57os_ca_campeonato ca ON c.id_ca_campeonato = ca.id 
WHERE ca.id_ca_carrera='$idCarrera'";
	$copas = mysql_query($FiltroCopa);
	if($copa=='0'){
				echo "<option selected='selected'>TODAS</option>";
	   }
	   else{
				echo "<option value='manga_newd.php?id=".$idCarrera."&idetapa=".$idetapa."&idmanga=".$idManga."&idseccion=".$idseccion."&newBD=true&campeonato=0&copa=0'>TODAS LAS COPAS</option>";
	   }
	while($row=mysql_fetch_array($copas))
		{
		$filtroCopa = $row["id"];
		$filtroDesc = $row["descripcion"];
			if($filtroCopa==$copa){
				echo "<option selected='selected'>".$filtroDesc."</option>";
				$nom_copa = $filtroDesc;
				}
			else
			echo "<option value='manga_newd.php?id=".$idCarrera."&idetapa=".$idetapa."&idmanga=".$idManga."&idseccion=".$idseccion."&newBD=true&campeonato=0&copa=".$filtroCopa."'>".$filtroDesc."</option>";
		}	
	
echo "<td>MANGAS:</td><td><select name='mangas' onchange='surfto(this.form)'>";
$sqlm = "SELECT abc_57os_ca_manga.id AS idman,abc_57os_ca_manga.descripcion AS tramo,
abc_57os_ca_etapa.descripcion,abc_57os_ca_seccion.descripcion,abc_57os_ca_seccion.id AS idsec,
abc_57os_ca_etapa.id AS ideta 
FROM abc_57os_ca_etapa INNER JOIN abc_57os_ca_seccion ON abc_57os_ca_etapa.id=abc_57os_ca_seccion.id_ca_etapa 
INNER JOIN abc_57os_ca_manga ON abc_57os_ca_manga.id_ca_seccion=abc_57os_ca_seccion.id WHERE abc_57os_ca_etapa.id_ca_carrera = '$idCarrera'";
	$resultadok = mysql_query($sqlm) or print "No se pudo acceder al contenido de los tiempos online.";
	if (mysql_num_rows($resultadok) > 0)
			{
			while($fila=mysql_fetch_array($resultadok))
				{
				$idManga2 = $fila['idman'];
				$desc = $fila['tramo'];
				$ideta = $fila['ideta'];
				$idsec = $fila['idsec'];
				if($_GET['idmanga']==$idManga2)
					{
					echo '<option selected="selected">'.$desc.'</option>';
					}
				else{
					echo "<option value='manga_newd.php?id=".$idCarrera."&idetapa=".$ideta."&idmanga=".$idManga2."&idseccion=".$idsec."&newBD=true&campeonato=".$_GET['campeonato']."&copa=".$_GET['copa']."'>".$desc."</option>";
					}
				}
			}

echo "</select></td></form></table>";
echo "<hr><br>";
				if($tipo_prueba==2)
						include("mangas_recarga_subida.php");
					else
						include("mangas_recarga_newd.php");
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
			function surfto(form)
				{
				var myindex=form.mangas.selectedIndex;
				window.open(form.mangas.options[myindex].value,"_top");
				}
			function surfto2(form)
				{
				var myindex=form.copas.selectedIndex;
				window.open(form.copas.options[myindex].value,"_top");
				} 
			</script>
		</body>
	</html>