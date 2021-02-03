<?php
include_once("includes/dateAfecha.php");//para hacer operaciones con fechas
//include("includes/nombresTildes.php");
if(isset($_GET["id"])){//En el caso de pruebas creadas a través del PROGRAMA
	$idCarrera = $_GET["id"];
include("conexion.php");
include("escudos.php");
include("includes/funciones.php");
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
								<h2 class="text-white"><?php echo $titulo;?></h2>
									<p class="text-white">LISTA DE AUTORIZADOS</p>
								</div>
						</div>
					</div>
					
					<a href="tiempos_new.php?id=<?php echo $idCarrera;?>&newBD=true" class="primary-btn text-uppercase selected">VOLVER</a>
					<a href="inscritos_new.php?id=<?php echo $idCarrera;?>&newBD=true" class="primary-btn text-uppercase">INSCRITOS</a>	
					<a href="abandonos_new.php?id=<?php echo $idCarrera;?>&newBD=true" class="primary-btn text-uppercase">ABANDONOS</a>
					<a href="penalizaciones_new.php?id=<?php echo $idCarrera;?>&newBD=true" class="primary-btn text-uppercase">PENALIZACIONES</a>
				</div>
			</section>		
					<div class="section-top-border">
					<?php
			$sql = "SELECT com.dorsal AS dorsal,com.id AS idcompetidor,pi.nombre AS piloto,pi.nacionalidad AS pi_nac,con.nombre AS concursante,com.hora_salida AS hora,
			ve.marca AS marca,ve.modelo AS modelo,ve.clase AS clase,ve.grupo AS grupo,con.nacionalidad AS con_nac,com.id_ca_copiloto_segundo AS copi2,
			ve.cilindrada AS cilindrada,ve.cilindrada_turbo AS cilindrada_turbo,ve.categoria AS cat,ve.agrupacion AS agr
			FROM abc_57os_ca_competidor com 
			INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto
			INNER JOIN abc_57os_ca_concursante con ON con.id=com.id_ca_concursante
			INNER JOIN abc_57os_ca_vehiculo ve ON ve.id=com.id_ca_vehiculo
			WHERE com.id_ca_carrera='$idCarrera' AND com.autorizado=1 AND com.excluido=0 ORDER BY com.dorsal ASC";
$resultado = mysql_query($sql) or print "No se pudo acceder al contenido de los tiempos online.";
	
	if(mysql_num_rows($resultado)==0){
			$no_concusante = 1;
			$sql = "SELECT com.dorsal AS dorsal,com.id AS idcompetidor,pi.nombre AS piloto,pi.nacionalidad AS pi_nac,com.hora_salida AS hora,
			ve.marca AS marca,ve.modelo AS modelo,ve.clase AS clase,ve.grupo AS grupo,ve.cilindrada AS cilindrada,ve.cilindrada_turbo AS cilindrada_turbo,ve.categoria AS cat,ve.agrupacion AS agr
			FROM abc_57os_ca_competidor com 
			INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto
			INNER JOIN abc_57os_ca_vehiculo ve ON ve.id=com.id_ca_vehiculo
			WHERE com.id_ca_carrera='$idCarrera' AND com.autorizado=1 AND com.excluido=0 ORDER BY com.dorsal ASC";

		$resultado = mysql_query($sql) or print "No se pudo acceder al contenido de los tiempos online2.";
		}
?>
<table width="100%" border="0" id="tab_tem">
	<thead>
	<tr>
		<th>N.</th><th>Concursante</th><th>Piloto/Copiloto</th><th></th><th>Vehiculo</th><th class="centro">C.C<br>C.C.Turbo</th><th>Camp.</th><th class="centro">Grupo</th><th class="centro">Clase</th><th class="centro">Cat</th><th class="centro">Agru.</th><th>Hora Salida</th>
	</tr>
	</thead>
		<tbody>
		<?php
		if(mysql_num_rows($resultado)>0)
		{
			$pos=1;
			$par = 0;
		while($fila=mysql_fetch_array($resultado))
			{
			$dorsal = $fila['dorsal'];
			$competidor = $fila['concursante'];
			$cilin = $fila['cilindrada'];
			$cilin_turbo = $fila['cilindrada_turbo'];
			$agr = $fila['agr'];
			$cat = $fila['cat'];
			$piloto = $fila['piloto'];
			$pi_nac = $fila['pi_nac'];
			$pi_nacs = explode('/',$pi_nac);
			$pi_nac1 = bandera($pi_nacs[0]);
			$pi_nac2 = bandera($pi_nacs[1]);
			$con_nac = $fila['con_nac'];
			$con_nac = explode("/", $con_nac);
			$con_nac1 = bandera($con_nac[0]);
			$con_nac2 = bandera($con_nac[1]);
			$copi2 = $fila['copi2'];
				if($copi2!=0 || $copi2!='0' || !empty($copi2)){
			$sql_copi2 = mysql_query("SELECT copi.nombre AS copiloto,copi.nacionalidad AS nacionalidad FROM abc_57os_ca_copiloto copi 
			INNER JOIN abc_57os_ca_competidor com ON copi.id=com.id_ca_copiloto_segundo
			WHERE com.id_ca_carrera = '$idCarrera' AND com.id_ca_copiloto_segundo = '$copi2'");
				if(mysql_num_rows($sql_copi2)>0)
					{
					$copi2 = @mysql_result($sql_copi2, 0, "copiloto");
					$copi2_nac = bandera(@mysql_result($sql_copi2, 0, "nacionalidad"));
					}
				}
				else{
					$copi2 ='';
					$copi2_nac = '';
					}
			$sql_copi = mysql_query("SELECT copi.nombre AS copiloto,copi.nacionalidad AS nacionalidad FROM abc_57os_ca_copiloto copi 
			INNER JOIN abc_57os_ca_competidor com ON copi.id=com.id_ca_copiloto
			WHERE com.id_ca_carrera = '$idCarrera' AND com.dorsal = '$dorsal'");
				if(mysql_num_rows($sql_copi)>0)
					{
					$copiloto = @mysql_result($sql_copi, 0, "copiloto");
					$copi_nac = @mysql_result($sql_copi, 0, "nacionalidad");
					$copi_nacs = explode('/',$copi_nac);
					$copi_nac1 = bandera($copi_nacs[0]);
					$copi_nac2 = bandera($copi_nacs[1]);
					}
				else{
					$copiloto ='';
					$copi_nac ='';
					}
			$vehiculo = $fila['marca'];
			$modelo = $fila['modelo'];
			$grupo = $fila['grupo'];
			$clase = $fila['clase'];
			$h_salida = $fila['hora'];
			$idcompetidor=$fila['idcompetidor'];
				if($h_salida=='')
					$h_salida = "---";
			$ordenar[] = array(
								'dorsal' => $dorsal, 
								'competidor' => $competidor, 
								'idcompetidor' => $idcompetidor, 
								'cilin' => $cilin,
								'cat' => $cat,
								'agr' => $agr,
								'cilin_turbo' => $cilin_turbo,
								'agr'=>$agr,
								'cat'=>$cat,
								'piloto'=>$piloto,
								'copiloto'=>$copiloto,
								'pi_nac1'=>$pi_nac1,
								'pi_nac2'=>$pi_nac2,
								'copi_nac1'=>$copi_nac1,
								'copi_nac2'=>$copi_nac2,
								'con_nac1'=>$con_nac1,
								'con_nac2'=>$con_nac2,
								'vehiculo'=>$vehiculo,
								'modelo'=>$modelo,
								'h_salida'=>$h_salida,
								'grupo' =>$grupo);
							}
			/*if($par%2==0)
				$classcss="filapar";
			else
				$classcss="filaimpar";
			echo '<tr class="'.$classcss.'"><td class="dor">'.$dorsal.'</td>';
			
			if($no_concusante==0)
				echo '<td><img class="banderas" src="http://codea.es/coda2019/'.$con_nac.'">'.$competidor.'</td>';
			else
				echo '<td></td>';
			
				if($copiloto!=''){
					if($copi2!='' || $copi2!=0)
						echo '<td><img class="banderas" src="http://codea.es/coda2019/'.$pi_nac.'">'.$piloto.'<br><img class="banderas" src="http://codea.es/coda2019/'.$copi_nac.'">'.$copiloto.'<br><img class="banderas" src="http://codea.es/coda2019/'.$copi2_nac.'">'.$copi2.'</td>';
					else
						echo '<td><img class="banderas" src="http://codea.es/coda2019/'.$pi_nac.'">'.$piloto.'<br><img class="banderas" src="http://codea.es/coda2019/'.$copi_nac.'">'.$copiloto.'</td>';
					}
				else
					echo '<td><img class="banderas" src="http://codea.es/coda2019/'.$pi_nac.'">'.$piloto.'</td>';
			
			echo '<td>'.escudo($vehiculo).'</td><td>'.$vehiculo.'<br>'.$modelo.'</td><td class="centro">'.$cilin.'<br>'.$cilin_turbo.'</td><td class="centro">'.$grupo.'</td><td class="centro">'.$clase.'</td><td class="centro">'.$cat.'</td><td class="centro">'.$agr.'</td></td><td>'.$h_salida.'</td></tr>';
			$pos++;
			$par++;*/
			foreach ($ordenar as $key => $row) {
		$aux[$key] = $row['dorsal'];
	}
	array_multisort($aux, SORT_ASC, $ordenar);
	$pos=1;
	foreach ($ordenar as $key => $row) {
			$idcompetidor=$row['idcompetidor'];
			if($par%2==0)
				$classcss="filapar";
			else
				$classcss="filaimpar";
			echo '<tr class="'.$classcss.'"><td class="dor">'.$row['dorsal'].'</td>';
			if($no_concusante==0)
				echo '<td><img class="banderas" src="http://codea.es/coda2019/'.$row['con_nac1'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['con_nac2'].'">'.$row['competidor'].'</td>';
			else
				echo '<td></td>';
			
				if($copiloto!=''){
					if($copi2!='' || $copi2!=0)
						echo '<td><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac'].'">'.$row['piloto'].'<br><img class="banderas" src="http://codea.es/coda2019/'.$row['copi_nac'].'">'.$row['copiloto'].'<br><img class="banderas" src="http://codea.es/coda2019/'.$row['copi2_nac'].'">'.$row['copi2'].'</td>';
					else
						echo '<td><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac1'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac2'].'">'.$row['piloto'].'<br><img class="banderas" src="http://codea.es/coda2019/'.$row['copi_nac1'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['copi_nac2'].'">'.$row['copiloto'].'</td>';
					}
				else
					echo '<td><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac1'].'"><img class="banderas" src="http://codea.es/coda2019/'.$row['pi_nac2'].'">'.$row['piloto'].'</td>';
			
			echo '<td>'.escudo($row['vehiculo']).'</td><td>'.$row['vehiculo'].'<br>'.$row['modelo'].'</td><td class="centro">'.$row['cilin'].'<br>'.$row['cilin_turbo'].'</td>';
			$con_campeonato = "SELECT mo.nombre AS region_campeonato,mo.slug AS slug FROM abc_57os_ca_campeonato_competidor caco
				INNER JOIN abc_57os_ca_campeonato ca ON caco.id_ca_campeonato = ca.id
				INNER JOIN abc_57os_ca_modalidad mo ON mo.id=ca.id_ca_modalidad
				WHERE caco.id_ca_competidor = '$idcompetidor' GROUP BY mo.nombre";
				$res_con_campeonato = mysql_query($con_campeonato);
			echo "<td class='centro'>";
					while($rows=mysql_fetch_array($res_con_campeonato))
					{
					$slug = $rows['slug'];
					$region = $rows['region_campeonato'];
					$search  = array('Ã±', 'Ã­');
					$replace = array('Ñ', 'Í');
					$region = str_replace($search, $replace, $region);
					echo "<p class='mini1 nomargen ".$slug." negrita'>".strtoupper($region)."</p>";
					//echo "<p class='mini1 nomargen espana negrita'>ESPAÑA</p>";
					//echo "<p class='mini1 nomargen europa negrita'>EUROPA</p>";
					}
			echo "</td><td class='centro'>";
				$res_con_campeonato = mysql_query($con_campeonato);
					while($rows=mysql_fetch_array($res_con_campeonato))
					{
					$slug = $rows['slug'];
						$con_grupo = mysql_query("SELECT gr.$slug FROM abc_57os_ca_competidor com
								INNER JOIN abc_57os_ca_vehiculo ve ON ve.id=com.id_ca_vehiculo
								INNER JOIN abc_57os_ca_grupo gr ON gr.id=ve.id_ca_grupo WHERE com.id='$idcompetidor'");
					$grupo = @mysql_result($con_grupo, 0, $slug);
					echo "<p class='mini1 nomargen ".$slug." negrita'>".$grupo."</p>";
					}
			echo "</td><td class='centro'>";
				$res_con_campeonato = mysql_query($con_campeonato);
					while($rows=mysql_fetch_array($res_con_campeonato))
					{
					$slug = $rows['slug'];
						$con_clase = mysql_query("SELECT cl.$slug FROM abc_57os_ca_competidor com
								INNER JOIN abc_57os_ca_vehiculo ve ON ve.id=com.id_ca_vehiculo
								INNER JOIN abc_57os_ca_clase cl ON cl.id=ve.id_ca_clase WHERE com.id='$idcompetidor'");
					$clase = @mysql_result($con_clase, 0, $slug);
					echo "<p class='mini1 nomargen ".$slug." negrita'>".$clase."</p>";
				//echo "<p class='mini1 nomargen andalucia negrita'>clase</p>";
					}
			echo "</td><td class='centro'>";
				$res_con_campeonato = mysql_query($con_campeonato);
					while($rows=mysql_fetch_array($res_con_campeonato))
					{
						$slug = $rows['slug'];
					echo "<p class='mini1 nomargen ".$slug." negrita'>".$row['cat']."</p>";
					}
			echo "</td><td>";
				$res_con_campeonato = mysql_query($con_campeonato);
					while($rows=mysql_fetch_array($res_con_campeonato))
					{
						$slug = $rows['slug'];
					echo "<p class='mini1 nomargen ".$slug." negrita'>".$row['agr']."</p>";
					}
			echo '</td><td>'.$row['h_salida'].'</td></tr>';
			$pos++;
			$par++;
	}	
		}
	else
		echo "<tr><td colspan='5'>No existe lista de autorizados</td></tr>";

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