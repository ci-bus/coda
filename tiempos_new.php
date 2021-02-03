<?php
include_once("includes/dateAfecha.php");//para hacer operaciones con fechas
include("includes/nombresTildes.php");
if(isset($_GET["id"])){//En el caso de pruebas creadas a través del PROGRAMA
	$idCarrera = $_GET["id"];
if(isset($idCarrera)){
include("conexion.php");
//idcarreras, descripcion, fecha_larga, estado, tipo_carrera, tipo_informe, modo_tiempos, temporada, organizador, fecha, idWeb, titulo, poblacion, desactivada, imagen
$dbQuery = "SELECT titulo,fecha_larga FROM web_pruebas WHERE idcarrera = '$idCarrera'";
$resultado = $mysqli2->query($dbQuery) or print "No se pudo acceder al contenido.";
if($resultado->num_rows > 0){
	while($row = $resultado ->fetch_array()){
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
function estado($estado){	
	switch($estado){
		case 0: $estado = "rojo.png";
		break;
		case 1: $estado = "verde.png";
		break;
		case 2: $estado = "meta.png";
		break;
		case 3: $estado = "amarillo.png";
		break;
		}
		return $estado;
	}
function estado2($estado){	
	switch($estado){
		case 0: $estado = "POR COMENZAR";
		break;
		case 1: $estado = "EN CURSO";
		break;
		case 2: $estado = "FINALIZADA";
		break;
		case 3: $estado = "NEUTRALIZADA";
		break;
		}
		return $estado;
	}
$num_mangas=0;
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
								<h2 class="text-white"><?php echo $titulo;?></h2>
								<p class="text-white"><?php echo $fechal;?></p>
							</div>
						</div>
					</div>
					<a href="inscritos_new.php?id=<?php echo $idCarrera;?>&newBD=true" class="primary-btn text-uppercase"><img src="img/casco.png" class="iconos_menu">INSCRITOS</a>
					<a href="autorizados_new.php?id=<?php echo $idCarrera;?>&newBD=true" class="primary-btn text-uppercase"><img src="img/volante.png" class="iconos_menu">AUTORIZADOS</a>
					<a href="abandonos_new.php?id=<?php echo $idCarrera;?>&newBD=true" class="primary-btn text-uppercase"><img src="img/penalizacion.png" class="iconos_menu">ABANDONOS</a>
					<a href="#" class="primary-btn text-uppercase"><img src="img/excluido.png" class="iconos_menu">EXCLUSIONES</a>
					<a href="penalizaciones_new.php?id=<?php echo $idCarrera;?>&newBD=true" class="primary-btn text-uppercase"><img src="img/copiloto.png" class="iconos_menu">PENALIZACIONES</a>
					<a href="#" class="primary-btn text-uppercase"><img src="img/grafica.png" class="iconos_menu">COMPARATIVAS</a>
					<a href="clas_final_newb.php?id=<?php echo $idCarrera;?>&newBD=true&campeonato=0&copa=0&clase=0&grupo=0&agrupacion=0&categoria=0" class="primary-btn text-uppercase selected"><img src="img/podio.png" class="iconos_menu">CLASIFICACI&Oacute;N FINAL</a>
				</div>
			</section>	
			
					<!--div class="section-top-border">
<div class="Timeline"-->

<?php 
/*
			$res = ($_GET['Ancho'])/$num_mangas; //FALTA PASAR A PHP LA RESOLUCION DEL EQUIPO CLIENTE y QUITARLO CON CSS DE MOVILES
			$n=1;
			$m=0;
					array_multisort($aux, SORT_ASC, $dias);

					foreach ($dias as $key => $row) {
						if($m==0)
							$tamano=50; //PRIMERA MANGA
						else
							$tamano = $res;
						echo "<svg height='5' width='".$tamano."'>";
						echo "<line x1='0' y1='0' x2='".$tamano."' y2='0' style='stroke:#004165;stroke-width:5'/>";
						echo "Lo sentimos, tu navegador no soporta SVG";
						echo "</svg>";
						$fecha = substr($row['fecha'],0,2);
						if($row['estado']==2){
							$clasetime = "event".$n." futureGray";
							$clasetime2 = "event".$n."Bubble futureOpacity";
							}
						else{
							$clasetime = "event".$n."Bubble";
							$clasetime2 = "eventTime";
							}
						echo "<div class='event2'><div class='".$clasetime."'><div class='".$clasetime2."'>";
						if($row['estado']==2)
							echo "<div class='eventTime'>";
						echo "<div class='DayDigit'>".$fecha."</div>";
						if($row['estado']==2)
							echo "<div class='Day'>".$row['dia']."<div class='MonthYear'>".$row['descripcion']."</div></div></div><div class='eventTitle'>".estado2($row['estado'])."</div></div></div>";
						else
							echo "<div class='Day'>".$row['dia']."<div class='MonthYear'>".$row['descripcion']."</div></div></div><div class='eventTitle'>".estado2($row['estado'])."</div></div>";
						echo "<svg height='20' width='20'>";
						echo "<circle cx='10' cy='11' r='5' fill='#004165' />";
						echo "</svg><div class='time'>".$row['hora']."</div></div>";
						if($row['estado']==1){
							  echo "<svg height='5' width='50'>";
							  echo "<line x1='0' y1='0' x2='5' y2='0' style='stroke:#004165;stroke-width:5'/>";
							  echo "Lo sentimos, tu navegador no soporta SVG";
							  echo "</svg>";
							  echo "<div class='now'>EN CARRERA</div>";
						}
					//$tamano +=300;
					if($n==1)
						$n=2;
					else
						$n=1;
					$m=1;
					}	*/
?>
			<!--/div>
					</div-->
					
					<div class="section-top-border">
<h3 class="mb-30">TRAMOS DISPONIBLES</h3>
					<table width="100%" id="tab_tem">
						<?php
						$par=0;
						$sql = "SELECT descripcion,id FROM web_etapa\n". "WHERE id_ca_carrera ='$idCarrera'";
						$etapas = $mysqli2->query ($sql) or print ("error");
							if($etapas->num_rows > 0)
								{
								while($fila=$etapas->fetch_array())
									{
									$idetapa = $fila['id'];
									$nom_etapa = $fila['descripcion'];
									echo '<tr class="etapa"><td class="eta_pd" colspan="5">'.$nom_etapa.'</td></tr>';
									$sql2 = "SELECT descripcion,id FROM web_seccion\n". "WHERE id_ca_etapa ='$idetapa'";
									$secciones = $mysqli2->query($sql2) or print ("error");
									if($secciones->num_rows > 0)
										{
										while($fila2=$secciones->fetch_array())
											{
											$idseccion = $fila2['id'];
											$fecha = $fila2['descripcion'];
											echo '<tr class="seccion"><td class="sec_pd" colspan="5">'.$fecha.'</td></tr>';
											$sql3 = "SELECT descripcion,id,hora_salida,estado,longitud FROM web_manga\n". "WHERE id_ca_seccion ='$idseccion' AND web_manga.tipo!=2";
											$mangas = $mysqli2->query($sql3) or print ("error");
											if($secciones->num_rows>0)
												{
												while($fila3=$mangas->fetch_array())
													{
														if($par%2==0)
															$classcss='filapar';
														else
													$classcss='filaimpar';
													$idmanga = $fila3['id'];
													$descripcion = $fila3['descripcion'];
													$hora = $fila3['hora_salida'];
													$estado = $fila3['estado'];
													$long = $fila3['longitud'];
													$inter = $mysqli2->query("SELECT id FROM web_manga_control_horario WHERE id_ca_manga='$idmanga'");
													/*$porsalir=0;
													$enpista=0;
													$enmeta = 0;
													$sql_pista = $mysqli->query("SELECT m.tipo AS tipo_manga,m.numero AS num_manga,com.dorsal,pi.nombre AS piloto_nombre,
														veh.grupo AS grupo,veh.clase AS clase,veh.marca AS marca,veh.modelo As modelo
														FROM abc_57os_ca_carrera car
														INNER JOIN abc_57os_ca_competidor com ON car.id=com.id_ca_carrera
														INNER JOIN abc_57os_ca_etapa e ON e.id_ca_carrera=car.id
														INNER JOIN abc_57os_ca_seccion s ON s.id_ca_etapa=e.id
														INNER JOIN abc_57os_ca_manga m ON m.id_ca_seccion=s.id
														INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto
														INNER JOIN abc_57os_ca_vehiculo veh ON veh.id=com.id_ca_vehiculo
														WHERE dorsal NOT IN (SELECT id_ca_competidor FROM abc_57os_ca_abandono WHERE id_ca_manga='$idmanga') 
														AND m.id='$idmanga' AND com.autorizado='1' GROUP BY dorsal");//FALTA DESCARTAR LOS ABANDONADOS
													/*
													if($sql_pista->num_rows>0)
															{
															while($fila=$sql_pista->num_rows())
																{
																$dorsal = $fila['dorsal'];
															$comp = $mysqli->query("SELECT ch.orden AS orden,t.tiempo FROM abc_57os_ca_tiempo t 
															INNER JOIN abc_57os_ca_manga_control_horario ch ON ch.id=t.id_ca_manga_control_horario 
															WHERE dorsal NOT IN (SELECT id_ca_competidor FROM abc_57os_ca_abandono WHERE id_ca_manga='$idmanga')
															AND t.dorsal='$dorsal' AND t.id_ca_manga='$idmanga'");//COMPRUEBO Q TENGA 2  TIEMPOS salida y llegada
																	if($comp->num_rows==1)//0 PÔR SALIR
																		{
																		$enpista++;
																		}
																	else if($comp->num_rows==0)//0 PÔR SALIR
																		{
																		$porsalir++;
																		}
																	else{
																		while($rows = $comp->fetch_array())
																			{
																			$orden = $rows['orden'];
																			if($orden==10)
																				$enmeta++;
																			}
																		}
																	
																}
															}
													$pen = $mysqli->query("SELECT a.motivo FROM abc_57os_ca_abandono a	WHERE a.id_ca_manga='$idmanga'");
													$abandonos = $pen->num_rows;*/
														if($inter->num_rows>2)
														{
															echo '<tr class="manga '.$classcss.'"><td class="man_pd">
															<p><a href="manga_new.php?id='.$idCarrera.'&idetapa='.$idetapa.'&idmanga='.$idmanga.'&idseccion='.$idseccion.'&newBD=true">'.$descripcion.'</a></p>';
															echo '<p class="margen_p_coches"><span class="span_coches">'.$porsalir.'<img src="img/coche2.png" width="30px" class="margen_coches"></span><span class="span_coches">'.$enpista.'<img src="img/coche3.png" width="30px" class="margen_coches"></span><span class="span_coches">'.$enmeta.'<img src="img/coche1.png" width="30px" class="margen_coches"></span><span class="span_coches">'.$abandonos.'<img src="img/coche4.png" width="30px" class="margen_coches"></span></p>';
															echo '</td><td class="cursiva"><a href="inter_new.php?id='.$idCarrera.'&idetapa='.$idetapa.'&idmanga='.$idmanga.'&idseccion='.$idseccion.'&newBD=true">TIEMPOS INTERMEDIOS</a></td>
															<td>'.$hora.' H</td><td>'.($long/1000).' Kms</td><td><img src="img/'.estado($estado).'" width="15px"></td></tr>';
															$par++;
														}
														else{
															echo '<tr class="manga '.$classcss.'"><td class="man_pd">
															<p><a href="manga_new.php?id='.$idCarrera.'&idetapa='.$idetapa.'&idmanga='.$idmanga.'&idseccion='.$idseccion.'&campeonato=0&newBD=true&copa=0">'.$descripcion.'</a></p>';
															echo '<p class="margen_p_coches"><span class="span_coches">'.$porsalir.'<img src="img/coche2.png" width="30px" class="margen_coches"></span><span class="span_coches">'.$enpista.'<img src="img/coche3.png" width="30px" class="margen_coches"></span><span class="span_coches">'.$enmeta.'<img src="img/coche1.png" width="30px" class="margen_coches"></span><span class="span_coches">'.$abandonos.'<img src="img/coche4.png" width="30px" class="margen_coches"></span></p>';
															echo '</td><td></td>
															<td>'.$hora.' H</td><td>'.($long/1000).' Kms</td><td><img src="img/'.estado($estado).'" width="15px"></td></tr>';
														}
													$par++;
													}
												}
											}
										}
									}
								}
							else
								echo '<tr><td>no existen etapas</td></tr>';
						?>
					</table>
			<br>
			<br>
			<div class="section-top-border">
						<h4 class="mb-30">&Uacute;LTIMA HORA:</h4>
						<div class="progress-table-wrap">
							<div class="progress-table">
							<?php
							$sql=$mysqli2->query("SELECT * FROM web_ult_hora WHERE idcarrera='$idCarrera' ORDER BY id DESC");
							if($sql->num_rows==0)
								echo "No se han publicado noticias";
							else{
								while ($row=$sql->fetch_array())
									{
									$info = $row['info'];
									$hora = $row['hora'];
									$icono = $row['icono'];
										switch($icono)
											{
											case 1 : $icono="iamarillo";
											break;
											case 2: $icono="iazul";
											break;
											case 3: $icono="iverde";
											break;
											case 4: $icono="inaranja";
											break;
											case 5: $icono="irojo";
											break;
											}
									echo "<div class='table-row ".$icono."'><div class='serial'>".$hora."</div><div class='country'>".$info."</div></div>";
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