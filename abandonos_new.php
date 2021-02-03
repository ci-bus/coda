<?php
include_once("includes/dateAfecha.php");//para hacer operaciones con fechas
//include("includes/nombresTildes.php");
if(isset($_GET["id"])){//En el caso de pruebas creadas a través del PROGRAMA
	$idCarrera = $_GET["id"];
include("conexion.php");
$DB_PREFIJO = "abc_57os_";
$dbQuery = "SELECT nombre,fecha_larga FROM abc_57os_ca_carrera WHERE id = '$idCarrera'";
$resultado = mysql_query($dbQuery) or print "No se pudo acceder al contenido.";
if(mysql_num_rows($resultado) > 0){
	$titulo = @mysql_result($resultado, 0, "nombre");
	$fecha = @mysql_result($resultado, 0, "fecha_larga");
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
									<p class="text-white">LISTA DE ABANDONOS</p>
								</div>
						</div>
					</div>
					<a href="tiempos_new.php?id=<?php echo $idCarrera;?>&newBD=true" class="primary-btn text-uppercase selected">VOLVER</a>
					<a href="inscritos_new.php?id=<?php echo $idCarrera;?>&newBD=true" class="primary-btn text-uppercase">INSCRITOS</a>
					<a href="autorizados_new.php?id=<?php echo $idCarrera;?>&newBD=true" class="primary-btn text-uppercase">AUTORIZADOS</a>
					<a href="penalizaciones_new.php?id=<?php echo $idCarrera;?>&newBD=true" class="primary-btn text-uppercase">PENALIZACIONES</a>
				</div>
			</section>		
					<div class="section-top-border">
					<?php
					if($copis==1)
						{
						$pen = mysql_query("SELECT veh.marca,veh.modelo,pi.nombre AS piloto,
						con.nombre AS concursante,c.dorsal,a.motivo FROM abc_57os_ca_abandono a
						INNER JOIN abc_57os_ca_competidor c ON c.id=a.id_ca_competidor 
						INNER JOIN abc_57os_ca_concursante con ON con.id=c.id_ca_concursante 
						INNER JOIN abc_57os_ca_piloto pi ON pi.id=c.id_ca_piloto
						INNER JOIN abc_57os_ca_vehiculo veh ON veh.id=c.id_ca_vehiculo 
						WHERE a.id_ca_carrera='$idCarrera' ORDER BY c.dorsal");
						}
					else{
						$pen = mysql_query("SELECT veh.marca,veh.modelo,pi.nombre AS piloto,
						con.nombre AS concursante,c.dorsal,a.motivo,veh.grupo,veh.clase 
						FROM abc_57os_ca_abandono a
						INNER JOIN abc_57os_ca_competidor c ON c.id=a.id_ca_competidor 
						INNER JOIN abc_57os_ca_concursante con ON con.id=c.id_ca_concursante 
						INNER JOIN abc_57os_ca_piloto pi ON pi.id=c.id_ca_piloto
						INNER JOIN abc_57os_ca_vehiculo veh ON veh.id=c.id_ca_vehiculo 
						WHERE a.id_ca_carrera='$idCarrera' ORDER BY c.dorsal");
						}
			$excl = mysql_query("SELECT ve.grupo,ve.clase,con.nombre AS concursante,com.dorsal,com.excluido_motivo AS motivo,ve.marca,ve.modelo,pi.nombre AS piloto FROM abc_57os_ca_competidor com 
					INNER JOIN abc_57os_ca_vehiculo ve ON ve.id=com.id_ca_vehiculo 
					INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto
					INNER JOIN abc_57os_ca_concursante con ON con.id=com.id_ca_concursante				
					WHERE com.excluido=1 AND com.id_ca_carrera='$idCarrera' ORDER BY com.dorsal");
?>
<table width="100%" border="0" id="tab_tem">
	<thead>
			<tr>
				<th>dorsal</th><th>Concursante</th><th>Equipo</th><th>Vehiculo</th><th>Grupo</th><th>Clase</th><th>Raz&oacute;n</th>
			</tr>
	</thead>
		<tbody>
		<?php
		$ninguno=0;
		if(mysql_num_rows($pen)>0){
			$ninguno=1;
						while($fila=mysql_fetch_array($pen)){
							$dorsal = $fila['dorsal'];
							$motivo = $fila['motivo'];
							$concursante = $fila['concursante'];
							$piloto = $fila['piloto'];
							$copiloto = $fila['copiloto'];
							$marca = $fila['marca'];
							$modelo = $fila['modelo'];
							$clase = $fila['clase'];
							$grupo = $fila['grupo'];
							if($par%2==0)
								$classcss="filapar";
							else
								$classcss="filaimpar";
							echo "<tr class='".$classcss."'><td class='dor negrita'>".$dorsal."</td><td class='con'>".$concursante."</td><td>".$piloto."<br>".$copiloto."</td>
							<td class='veh'>".$marca."<br>".$modelo."</td><td>".$grupo."</td><td>".$clase."</td><td>".$motivo."</td></tr>";
							$par++;
							}
					}//IF
		if(mysql_num_rows($excl)>0){
			$ninguno=1;
						while($fila=mysql_fetch_array($excl)){
							$dorsal = $fila['dorsal'];
							$motivo = $fila['motivo'];
							$concursante = $fila['concursante'];
							$piloto = $fila['piloto'];
							$copiloto = $fila['copiloto'];
							$marca = $fila['marca'];
							$modelo = $fila['modelo'];
							$clase = $fila['clase'];
							$grupo = $fila['grupo'];
							if($par%2==0)
								$classcss="filapar";
							else
								$classcss="filaimpar";
							echo "<tr class='".$classcss."'><td class='dor negrita'>".$dorsal."</td><td class='con'>".$concursante."</td><td>".$piloto."<br>".$copiloto."</td>
							<td class='veh'>".$marca."<br>".$modelo."</td><td>".$grupo."</td><td>".$clase."</td><td>EXCLIDO<br>".$motivo."</td></tr>";
							$par++;
							}
					}//IF
					if($ninguno==0)
						echo "<tr><td colspan='7'>No existen Abandonos en esta carrera</td></tr>";
		?>
		</table>
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