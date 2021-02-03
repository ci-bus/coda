<?php
include("conexion.php");
include("includes/funcionesTiempos.php");
include("includes/funciones.php");
if(isset($_GET["id"])){//En el caso de pruebas creadas a través del PROGRAMA
	$idCarrera = $_GET["id"];
if(isset($idCarrera)){
$dbQuery = "SELECT nombre,fecha_larga,id_ca_tipo_prueba FROM abc_57os_ca_carrera WHERE id = '$idCarrera'";
$resultado = mysql_query($dbQuery) or print "No se pudo acceder al contenido.";
if(mysql_num_rows($resultado) > 0){
	$titulo = @mysql_result($resultado, 0, "nombre");
	$fecha = @mysql_result($resultado, 0, "fecha_larga");
	$tipo_prueba = @mysql_result($resultado, 0, "id_ca_tipo_prueba");
			}
		}
	}
if(isset($_GET['copa']))
	$copa=$_GET['copa'];
else
	$copa='0';

$bdorsal = $_GET['dorsal'];
$idManga = $_GET['idmanga'];
//BUSCO LOS TIEMPOS DEL dORSAL QUE ME LLEGA
$bus = mysql_query("SELECT ch.orden AS orden,t.tiempo FROM abc_57os_ca_tiempo t 
			INNER JOIN abc_57os_ca_manga_control_horario ch ON ch.id=t.id_ca_manga_control_horario 
			WHERE t.dorsal='$bdorsal' AND t.id_ca_manga='$idManga'");//EVITO SALIDAS Y LLEGADAS
				if(mysql_num_rows($bus)>0)//TODOS LOS PUNTOS SALIDA,LLEGADAS E INTERM
					{
					while($fil=mysql_fetch_array($bus))
						{
						$orden = $fil['orden'];
						if($orden==0){//ES SALIDA
							$tb_s = tiempo_a_milisegundos($fil['tiempo']);
							}
						if($orden==10){//ES LLEGADA
							$tb_l = tiempo_a_milisegundos($fil['tiempo']);
							}
						if($orden==1){ //I1
							$ib1 = tiempo_a_milisegundos($fil['tiempo']);
							}
						if($orden==2){ //I2
							$ib2 = tiempo_a_milisegundos($fil['tiempo']);
							}
						if($orden==3){ //I3
							$ib3 = tiempo_a_milisegundos($fil['tiempo']);
							}
						if($orden==4){ //I4
							$ib4 = tiempo_a_milisegundos($fil['tiempo']);
							}
						if($orden==5){ //I5
							$ib5 = tiempo_a_milisegundos($fil['tiempo']);
							}	
						}
					}
				if($tb_l!=0)
					$tiempob = $tb_l-$tb_s;
				else
					$tiempob = 0;

$int_com=array();				
				$int_com[1] = $ib1-$tb_s;
				$int_com[2] = $ib2-$tb_s;
				$int_com[3] = $ib3-$tb_s;
				$int_com[4] = $ib4-$tb_s;
				$int_com[5] = $ib5-$tb_s;					
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
									<p class="text-white"><?php echo $fecha;?></p>
								</div>
						</div>
					</div>
					<a href="inter_new.php?id=<?php echo $idCarrera;?>&idetapa=<?php echo $_GET['idetapa'];?>&idmanga=<?php echo $_GET['idmanga'];?>&idseccion=<?php echo $_GET['idseccion'];?>&newBD=true" class="primary-btn text-uppercase selected">VOLVER</a>
				</div>
			</section>		
					<div class="section-top-border">
						   <table><form>
		<tr><td>COPAS:</td><td><select name="copas">
					<?php
$dbQueryFiltroCopas = "SELECT idcopas, idcarreras, descripcion FROM copas WHERE idcarreras='$idCarrera' ORDER BY descripcion";
	$resultadoFiltroCopas = mysql_query($dbQueryFiltroCopas);
	   if($copa=='0'){
				echo "<option selected='selected'>SCRATCH GENERAL</option>";
	   }
	   else{
				echo "<option>TODAS LAS COPAS</option>";
	   }
	while($row=mysql_fetch_array($resultadoFiltroCopas))
		{
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
echo "</table>";
echo "<hr><p>TIEMPOS INTERMEDIOS:</p>";
include("escudos.php");
if(isset($_GET["copa"]))
			$copa = $_GET["copa"];
		else
			$copa = '0';
$idCarrera = $_GET['id'];
$idManga = $_GET['idmanga'];
$sql = "SELECT descripcion FROM abc_57os_ca_manga_control_horario WHERE id_ca_manga='$idManga' AND orden!=0 AND orden!=10 ORDER BY orden";
$resultado = mysql_query($sql);
	if(mysql_num_rows($resultado)==0)
		echo "No existen puntos Tiempos Intermedios";
	else{
		$num_int = mysql_num_rows($resultado);
		echo "<table id='tab_tem' border='0' width='100%'>
			<thead>
			<tr><th colspan='4'></th><th colspan='".$num_int."' class='centro'>PUNTOS INTERMEDIOS</th><th></th></tr>
			<tr><th>N.</th><th>EQUIPO</th><th colspan='2'>VEHICULO<br>GRUPO/CLASE</th>";
		while($row=mysql_fetch_array($resultado))
			{
			$desc = $row['descripcion'];
			echo "<th>".$desc."</th>";
			}
		echo "<th>TIEMPO</th></tr></thead>";
		}
if($copa=='0')
	{
	$sql = "SELECT com.id AS idconcursante, m.tipo AS tipo_manga,m.numero AS num_manga,com.dorsal,pi.nombre AS piloto_nombre,
	con.nombre AS competidor,com.id_ca_copiloto_segundo AS copi2,
	veh.grupo AS grupo,veh.clase AS clase,veh.marca AS marca,veh.modelo As modelo,pi.nacionalidad AS pi_nac,
	con.nacionalidad AS co_nac,com.hora_salida AS hora
	FROM abc_57os_ca_carrera car
	INNER JOIN abc_57os_ca_competidor com ON car.id=com.id_ca_carrera
	INNER JOIN abc_57os_ca_etapa e ON e.id_ca_carrera=car.id
	INNER JOIN abc_57os_ca_seccion s ON s.id_ca_etapa=e.id
	INNER JOIN abc_57os_ca_manga m ON m.id_ca_seccion=s.id
	INNER JOIN abc_57os_ca_piloto pi ON pi.id=com.id_ca_piloto
	INNER JOIN abc_57os_ca_concursante con ON con.id=com.id_ca_concursante
	INNER JOIN abc_57os_ca_vehiculo veh ON veh.id=com.id_ca_vehiculo
	WHERE m.id='$idManga' AND com.autorizado=1 GROUP BY dorsal";
	}
	else
		echo "MANDA COPA";
$resultado = mysql_query($sql) or print "No se pudo acceder al contenido de los tiempos online.";
if(mysql_num_rows($resultado)>0)
		{
		while($fila=mysql_fetch_array($resultado))
			{
			$hora = $fila['hora'];
			$dorsal = $fila['dorsal'];
			$competidor = $fila['competidor'];
			$piloto = $fila['piloto_nombre'];
			$copi2 = $fila['copi2'];
				if($copi2!=0 || $copi2!='0' || !empty($copi2)){
			$sql_copi2 = mysql_query("SELECT copi.nombre AS copiloto,copi.nacionalidad AS nacionalidad FROM abc_57os_ca_copiloto copi 
			INNER JOIN abc_57os_ca_competidor com ON copi.id=com.id_ca_copiloto_segundo
			WHERE com.id_ca_carrera = '$idCarrera' AND com.id_ca_copiloto_segundo = '$copi2'");
				if(mysql_num_rows($sql_copi2)>0)
					$copi2 = @mysql_result($sql_copi2, 0, "copiloto");
				else
					$copi2 ='';
				}
			$sql_copi = mysql_query("SELECT copi.nombre AS copiloto,copi.nacionalidad AS nacionalidad FROM abc_57os_ca_copiloto copi 
			INNER JOIN abc_57os_ca_competidor com ON copi.id=com.id_ca_copiloto
			WHERE com.id_ca_carrera = '$idCarrera' AND com.dorsal = '$dorsal'");
				if(mysql_num_rows($sql_copi)>0)
					$copiloto = @mysql_result($sql_copi, 0, "copiloto");
				else
					$copiloto ='';
			$vehiculo = $fila['marca'];
			$modelo = $fila['modelo'];
			$grupo = $fila['grupo'];
			$clase = $fila['clase'];
			$idcomp = $fila['idcompetidor'];
			$pi_nac = bandera($fila['pi_nac']);
			$co_nac = bandera($fila['co_nac']);
			$num_manga = $fila['num_manga'];
			$tipo_manga = $fila['tipo_manga'];
			$idconcursante = $fila['idconcursante'];
			$comp = mysql_query("SELECT ch.orden AS orden,t.tiempo FROM abc_57os_ca_tiempo t 
			INNER JOIN abc_57os_ca_manga_control_horario ch ON ch.id=t.id_ca_manga_control_horario 
			WHERE t.dorsal='$dorsal' AND t.id_ca_manga='$idManga'");//EVITO SALIDAS Y LLEGADAS
			$t_s=0;
			$t_l=0;
			$i1=0;
			$i2=0;
			$i3=0;
			$i4=0;
			$i5=0;
				if(mysql_num_rows($comp)>0)//TODOS LOS PUNTOS SALIDA,LLEGADAS E INTERM
					{
					while($fil=mysql_fetch_array($comp))
						{
						$orden = $fil['orden'];
						if($orden==0){//ES SALIDA
							$t_s = tiempo_a_milisegundos($fil['tiempo']);
							}
						if($orden==10){//ES LLEGADA
							$t_l = tiempo_a_milisegundos($fil['tiempo']);
							}
						if($orden==1){ //I1
							$i1 = tiempo_a_milisegundos($fil['tiempo']);
							}
						if($orden==2){ //I2
							$i2 = tiempo_a_milisegundos($fil['tiempo']);
							}
						if($orden==3){ //I3
							$i3 = tiempo_a_milisegundos($fil['tiempo']);
							}
						if($orden==4){ //I4
							$i4 = tiempo_a_milisegundos($fil['tiempo']);
							}
						if($orden==5){ //I5
							$i5 = tiempo_a_milisegundos($fil['tiempo']);
							}	
						}	
				if($t_l!=0)
					$tiempo = $t_l-$t_s;
				else
					$tiempo = 0;	
				$i1 = $i1-$t_s;
				$i2 = $i2-$t_s;
				$i3 = $i3-$t_s;
				$i4 = $i4-$t_s;
				$i5 = $i5-$t_s;
//PASO A CALCULAR LAS POSICIONES SEGUN TIEMPO LLEGADA
								$ordenar[] = array(
								'piloto' => $piloto, 
								'hora' => $hora, 
								'copiloto' => $copiloto,
								'copi2' => $copi2,
								'dorsal'=>$dorsal,
								'tiempo'=>$tiempo,
								'vehiculo'=>$vehiculo,
								'modelo'=>$modelo,
								'grupo'=>$grupo,
								'clase'=>$clase,
								'i1'=>$i1,
								'i2'=>$i2,
								'i3'=>$i3,
								'i4'=>$i4,
								'i5'=>$i5,
								'tipo'=>$tipo,
								'hora'=>$hora,
								'pi_nac' =>$pi_nac,
								'co_nac' =>$co_nac,
								'idconcursante' =>$idconcursante,
								'competidor' =>$competidor);
					}
			}
		}
	else
		echo "No hay contenido online para mostrar...";
	foreach ($ordenar as $key => $row) {
	$aux[$key] = $row['hora'];
	}
	array_multisort($aux, SORT_ASC, $ordenar);
	$pos=1;
	foreach ($ordenar as $key => $row) {
		if($par%2==0)
			$classcss='filapar';
		else
			$classcss='filaimpar';

	if($row['dorsal']==$bdorsal)
		echo "<tr class='bdorsal' onclick=\"window.open('inter_com_new.php?dorsal=".$row['dorsal']."&idmanga=".$idManga."&idetapa=".$idetapa."&idseccion=".$idseccion."&id=".$idCarrera."&newBD=true','_self')\"><td class='dor'>".$row['dorsal']."</td>";
	else
		echo "<tr class='".$classcss."' onclick=\"window.open('inter_com_new.php?dorsal=".$row['dorsal']."&idmanga=".$idManga."&idetapa=".$idetapa."&idseccion=".$idseccion."&id=".$idCarrera."&newBD=true','_self')\"><td class='dor'>".$row['dorsal']."</td>";
	if($copiloto!=''){
			//if($row['copi2']!='' || $row['copi2']!=0)
				//echo '<td class="con"><img class="banderas" src="http://codea.es/coda2019/'.$pi_nac.'">'.acortar_nombre($row['piloto']).'<br><img class="banderas" src="http://codea.es/coda2019/'.$co_nac.'">'.acortar_nombre($row['copiloto']).'<br><img class="banderas" src="http://codea.es/coda2019/'.$co_nac.'">'.acortar_nombre($row['copi2']).'</td>';
			//else
				echo '<td class="con"><img class="banderas" src="http://codea.es/coda2019/'.$pi_nac.'">'.acortar_nombre($row['piloto']).'<br><img class="banderas" src="http://codea.es/coda2019/'.$co_nac.'">'.acortar_nombre($row['copiloto']).'</td>';
		}
	else
		echo '<td class="con"><img class="banderas" src="http://codea.es/coda2019/'.$pi_nac.'">'.acortar_nombre($row['piloto']).'</td>';
	echo '<td class="cla">'.escudo($row['vehiculo']).'</td><td><span class="veh">'.$row['vehiculo'].' '.$row['modelo'].'</span>
	<br><span class="gru">'.$row['grupo'].' / '.$row['clase'].'</span></td>';
	for($i=1;$i<=$num_int;$i++)
		{
			$ib3 = milisegundos_a_tiempo($int_com[$i]);
			if(strlen($ib3)<10)
				$ib3 = "00:".$ib3;	
		$int = "i".$i;
		$row[$int] = milisegundos_a_tiempo($row[$int]);
	if(strlen($row[$int])<10)
		$row[$int] = "00:".$row[$int];
	
	if($row[$int]>$ib3){
		$dif = milisegundos_a_tiempo(tiempo_a_milisegundos($row[$int])-tiempo_a_milisegundos($ib3));
		$letra = "irojo";
		}
	else{
		$dif = milisegundos_a_tiempo(tiempo_a_milisegundos($ib3)-tiempo_a_milisegundos($row[$int]));
		$letra= "iverde";
		}
		if($row[$int]<0)
				echo '<td> - </td>';
			else{
				if($row['dorsal']==$bdorsal)
					echo '<td class="tie"><p>'.milisegundos_a_tiempo($row[$int]).'</p></td>';
				else
					echo '<td class="tie2"><p>'.milisegundos_a_tiempo($row[$int]).'</p><p class="'.$letra.' gran">'.$dif.'</p></td>';
				}
		}
		if($row['tiempo']>$tiempob){
			$dif_tiempo = $row['tiempo']-$tiempob;
			$letra = "irojo";
			}
		else{
			$dif_tiempo = $tiempob-$row['tiempo'];
			$letra = "iverde";
			}
		if($row['dorsal']==$bdorsal)
			echo '<td class="tie centro"><p class="anterior cursiva nomargen"></p><p class="tie gran negrita">'.milisegundos_a_tiempo($row['tiempo']).'</p><p class="cursiva nomargen"></p>';
		else
			echo '<td class="tie centro"><p class="anterior cursiva nomargen"></p><p class="tie gran '.$letra.'">'.milisegundos_a_tiempo($dif_tiempo).'</p><p class="cursiva nomargen"></p>';
		$par++;
		$pos++;
		//$tiempo_anterior=$row['tiempo'];
	}
	?>
	</tbody>
		</table>
<br>
<br>
<br>
<br>
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
			</script>
		</body>
	</html>


