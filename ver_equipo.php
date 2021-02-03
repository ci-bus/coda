<?php
//include_once("includes/dateAfecha.php");//para hacer operaciones con fechas
include("includes/funciones.php");
if(isset($_GET["id"])){//En el caso de pruebas creadas a través del PROGRAMA
	$idCarrera = $_GET["id"];
if(isset($idCarrera)){
include("conexion.php");
//idcarreras, descripcion, fecha_larga, estado, tipo_carrera, tipo_informe, modo_tiempos, temporada, organizador, fecha, idWeb, titulo, poblacion, desactivada, imagen
$dbQuery = "SELECT nombre,fecha_larga FROM abc_57os_ca_carrera WHERE id = '$idCarrera'";
$resultado = mysql_query($dbQuery) or print "No se pudo acceder al contenido.";
if(mysql_num_rows($resultado) > 0){
	$titulo = @mysql_result($resultado, 0, "nombre");
	$fecha = @mysql_result($resultado, 0, "fecha_larga");
			}
		}
	}
	$idcompetidor=$_GET['equipo'];
	include("escudos.php");
$sql = mysql_query("SELECT con.nacionalidad AS con_nac,pi.nacionalidad as pi_nac,copi.nacionalidad as copi_nac,
con.nombre AS competidor,pi.nombre AS piloto,copi.nombre AS copiloto FROM abc_57os_ca_competidor com 
INNER JOIN abc_57os_ca_concursante con ON com.id_ca_concursante=con.id
INNER JOIN abc_57os_ca_piloto pi ON com.id_ca_piloto=pi.id
INNER JOIN abc_57os_ca_copiloto copi ON com.id_ca_copiloto=copi.id
WHERE com.id='$idcompetidor'");
if(mysql_num_rows($sql) > 0){
	$equipo = @mysql_result($sql, 0, "competidor");
	$piloto = @mysql_result($sql, 0, "piloto");
	$copiloto = @mysql_result($sql, 0, "copiloto");
	$copi_nac = @mysql_result($sql, 0, "copi_nac");
	$pi_nac = @mysql_result($sql, 0, "pi_nac");
	$con_nac = @mysql_result($sql, 0, "con_nac");
}
$sql = mysql_query("SELECT id FROM abc_57os_ca_concursante WHERE nombre LIKE '%$equipo%'");
	$res = mysql_num_rows($sql);
$sql = mysql_query("SELECT id FROM abc_57os_ca_piloto WHERE nombre LIKE '%$piloto%'");
	$res2 = mysql_num_rows($sql);
$sql = mysql_query("SELECT id FROM abc_57os_ca_copiloto WHERE nombre LIKE '%$copiloto%'");
	$res3 = mysql_num_rows($sql);
$img = mysql_query("SELECT * FROM web_fotos WHERE id_ca_competidor = '$idcompetidor'");
	if(mysql_num_rows($img)>0)
		{
		$img_pi = @mysql_result($img, 0, "img_piloto");
			if(empty($img_pi) || $img_pi=='')
				{
				$img_pi = "<img class='img-fluid' src='img/equipos/piloto.jpg' alt=''>";
				$enl_pi = "<a href='img/equipos/piloto.jpg' class='img-pop-home'>";
				}
			else{
				$enl_pi = "<a href='img/equipos/".date('Y')."/".$idCarrera."/".$img_pi."' class='img-pop-home'>";
				$img_pi = "<img class='img-fluid' src='img/equipos/".date('Y')."/".$idCarrera."/".$img_pi."' alt=''>";
				}
		$img_copi = @mysql_result($img, 0, "img_copiloto");
			if(empty($img_copi) || $img_copi=='')
					{
					$img_copi = "<img class='img-fluid' src='img/equipos/copiloto.jpg' alt=''>";
					$enl_copi = "<a href='img/equipos/copiloto.jpg' class='img-pop-home'>";
					}
				else{
					$enl_copi = "<a href='img/equipos/".date('Y')."/".$idCarrera."/".$img_copi."' class='img-pop-home'>";
					$img_copi = "<img class='img-fluid' src='img/equipos/".date('Y')."/".$idCarrera."/".$img_copi."' alt=''>";
					}
		$img_com = @mysql_result($img, 0, "img_competidor");
			if(empty($img_com) || $img_com=='')
					{
					$img_com = "<img class='img-fluid' src='img/equipos/equipo.jpg' alt=''>";
					$enl_com = "<a href='img/equipos/equipo.jpg' class='img-pop-home'>";
					}
				else{
					$enl_com = "<a href='img/equipos/".date('Y')."/".$idCarrera."/".$img_com."' class='img-pop-home'>";
					$img_com = "<img class='img-fluid' src='img/equipos/".date('Y')."/".$idCarrera."/".$img_com."' alt=''>";
					}
		$extra1 = @mysql_result($img, 0, "extra1");
			if(empty($extra1) || $extra1=='')
						{
						$extra1 = "<img class='img-fluid' src='img/equipos/extra1.jpg' alt=''>";
						$enl_extra1 = "<a href='img/equipos/extra1.jpg' class='img-pop-home'>";
						}
					else{
						$enl_extra1 = "<a href='img/equipos/".date('Y')."/".$idCarrera."/".$extra1."' class='img-pop-home'>";
						$extra1 = "<img class='img-fluid' src='img/equipos/".date('Y')."/".$idCarrera."/".$extra1."' alt=''>";
						}
		$extra2 = @mysql_result($img, 0, "extra2");
			if(empty($extra2) || $extra2=='')
						{
						$extra2 = "<img class='img-fluid' src='img/equipos/extra2.jpg' alt=''>";
						$enl_extra2 = "<a href='img/equipos/extra2.jpg' class='img-pop-home'>";
						}
					else{
						$enl_extra2 = "<a href='img/equipos/".date('Y')."/".$idCarrera."/".$extra2."' class='img-pop-home'>";
						$extra2 = "<img class='img-fluid' src='img/equipos/".date('Y')."/".$idCarrera."/".$extra2."' alt=''>";
						}
		}
		else{
			$img_pi = "<img class='img-fluid' src='img/equipos/piloto.jpg' alt=''>";
			$enl_pi = "<a href='img/equipos/piloto.jpg' class='img-pop-home'>";	
			$img_copi = "<img class='img-fluid' src='img/equipos/copiloto.jpg' alt=''>";
			$enl_copi = "<a href='img/equipos/copiloto.jpg' class='img-pop-home'>";
			$img_com = "<img class='img-fluid' src='img/equipos/equipo.jpg' alt=''>";
			$enl_com = "<a href='img/equipos/equipo.jpg' class='img-pop-home'>";
			$extra1 = "<img class='img-fluid' src='img/equipos/extra1.jpg' alt=''>";
			$enl_extra1 = "<a href='img/equipos/extra1.jpg' class='img-pop-home'>";
			$extra2 = "<img class='img-fluid' src='img/equipos/extra2.jpg' alt=''>";
			$enl_extra2 = "<a href='img/equipos/extra2.jpg' class='img-pop-home'>";
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
							<img src="img/soc_ins.png">
							<img src="img/soc_fac.png">
							<img src="img/soc_twe.png">
							<img src="img/soc_and.png">
						</div>
				        <ul class="nav-menu">
				          <li><a href="index.php">Inicio</a></li>
				          <li><a href="temporada.php?newBD=true">Temporada</a></li>
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
								<h2 class="text-white"><?php echo $titulo;?></h2>
								<p class="text-white"><?php echo $fecha;?></p>
							</div>
						</div>
					</div>
					<a href="manga_new.php?id=<?php echo $idCarrera;?>&newBD=true&idmanga=<?php echo $_GET['idmanga'];?>&idetapa=<?php echo $_GET['idetapa'];?>&idseccion=<?php echo $_GET['idseccion'];?>" class="primary-btn text-uppercase">VOLVER</a>
				</div>
			</section>		
<section class="gallery-area section-gap" id="gallery">
				<div class="container">
					<div class="row d-flex justify-content-center">
						<div class="menu-content pb-60 col-lg-10">
							<div class="title text-center">
								<h1 class="mb-10">INFORMACI&Oacute;N DEL EQUIPO: </h1>
								<p><?php echo $equipo;?></p>
							</div>
						</div>
					</div>						
					<div class="row">
						<div class="col-lg-4">
								<?php echo $enl_pi.$img_pi; ?>
							</a>
							<p class="negrita"><?echo $piloto;?></p>
							<p><img src="<?php echo bandera($pi_nac);?>" class="banderas2"><?echo $pi_nac;?></p>
							<p>TOTAL PRUEBAS CON C.D CODA EN <?php echo date('Y').": <span class='total_pruebas'>".$res2;?></span></p>
								<?php echo $enl_copi.$img_copi; ?>
							</a>	
							<p class="negrita"><?echo $copiloto;?></p>
							<p><img src="<?php echo bandera($copi_nac);?>" class="banderas2"><?php echo $copi_nac; ?></p>
							<p>TOTAL PRUEBAS CON C.D CODA EN <?php echo date('Y').": <span class='total_pruebas'>".$res3;?></span></p>
						</div>
						<div class="col-lg-8">
							<?php echo $enl_com.$img_com; ?>
							</a>
							<p><img src="<?php echo bandera($con_nac);?>" class="banderas2"><?echo $equipo;?></p>	
							<div class="row">
								<div class="col-lg-6">
									<?php echo $enl_extra1.$extra1; ?>
									</a>	
								</div>
								<div class="col-lg-6">
									<?php echo $enl_extra2.$extra2; ?>
									</a>	
								</div>
							</div>
						</div>
					</div>
				</div>	
			</section>	
			<footer class="footer-area section-gap">
				<div class="container">
					<div class="row">
						<div class="col-lg-5 col-md-6 col-sm-6">
							<div class="single-footer-widget">
								<h6>About Us</h6>
								<p>
									Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore dolore magna aliqua.
								</p>
								<p class="footer-text">
									<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
								</p>								
							</div>
						</div>
						<div class="col-lg-5  col-md-6 col-sm-6">
							<div class="single-footer-widget">
								<h6>Newsletter</h6>
								<p>Stay update with our latest</p>
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
								<h6>Follow Us</h6>
								<p>Let us be social</p>
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