<?php
	include('conexion.php');
	//include('../includes/online.php');
	//include_once('includes/scripts_ajax.php');
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
				          <li><a href="index.php">Inicio</a></li>
				          <li class="menu-active">Temporada</li>
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
								<h2 class="text-white">Eventos para la Temporada <?php echo date('Y')?></h2>
								<!--p class="text-white">It won’t be a bigger problem to find one video game lover in your <br> neighbor. Since the introduction of Virtual Game.</p-->
							</div>
						</div>
					</div>
				</div>
			</section>		
			
					<div class="section-top-border">

			<table border='0' width='100%' id='tab_tem'><thead>
			<tr><th>Fecha</th><th>Poblaci&oacute;n</th><th>Evento</th><th>Organizador</th></thead>
                <tbody>
								<?php
/*ANTES DE EMPEZAR...todo este codigo pertenece al amigo de Manolo, yo solo voy a modernizarlo para que puedan seguir
con la misma base de datos, temporada.php ya funciona con Ajax y tem_act.php, recargardo cada 2 segundo la pagina sin
que se aprecie
*/
$par2=0;
//error_reporting(5);
include_once("includes/dateAfecha.php");//para hacer operaciones con fechas
include("includes/nombresTildes.php");
$hoy=date("Y-m-d");
//include("includes/CarreraObject.php");//Clase Carrera, para instanciar objetos de tipo Carrera des la información de la Base de Datos, tablas carreras y grupos.
$anoActual = date("Y");
$noFilas = false;// Variable que indica si hay filas en las consultas a la Base de Datos
$CarrerasyGrupos = array();// Array para guardar los objetos Carrera
$grupoItereator = 0;// Iterador del array $CarrerasyGrupos
$dbQuery = "SELECT idcarrera AS id, titulo AS nombre, fecha_larga,organizador,fecha,poblacion,web FROM web_pruebas
WHERE estado!=5 AND idcarrera!=26 AND temporada='$anoActual'
ORDER BY fecha DESC";
$resultado = $mysqli2->query($dbQuery) or print "No se pudo acceder al contenido de las pruebas online.";
if ($resultado->num_rows > 0)
	{	
	while($fila = $resultado->fetch_array())
		{
		$idCarrera = $fila["id"];
		//$descripcion = $fila["descripcion"];
		$fecha_larga = $fila["fecha_larga"];
		$organizador = $fila["organizador"];
		$nombre = $fila["nombre"];
		$titulo = $fila["titulo"];
		$poblacion = $fila["poblacion"];
		$web = $fila['web'];
	
				if($par2%2==0)
					$class="filapar";
				else 
					$class="filaimpar";
			echo "<tr class='".$class."' onclick=\"location.href='prueba_new.php?id=".$idCarrera."'\">
			<td>".$fecha_larga."</td>
			<td>".$poblacion."</td>
			<td><a href='prueba_new.php?id=".$idCarrera."'>".strtoupper(nombresTildes($nombre))."</a></td>
			<td>".$organizador."</td></tr>";
		$par2++;
		}
	}
?>       
            </tbody>
            </table>
        </div>
						

					</div>
			<!-- start footer Area -->		
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