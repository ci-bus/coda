<!DOCTYPE html>
<?php
function acortar_nombre($nombre){
	$excepciones = array('DE','de','De');
	$nom = '';
	$acortar = explode(" ",$nombre);
	$long = count($acortar);
		if($long==3) //EL NOMBRE ES NOMBRE+APELLIDO+2APELLIDO
			{
			$nom = substr($acortar[0],0,1)."."; //COJO EL NOMBRE
			$nom = $nom." ".$acortar[1]." ".$acortar[2];
			}
		if($long>3) //EL NOMBRE PODRIA SER COMPUESTO
			{
			$nom = substr($acortar[0],0,1)."."; //COJO EL NOMBRE
			for($i=1;$i<$long;$i++) //BUSCO SI ES COMPUESTO
				{
				if(strlen($acortar[$i])==1)
					$nom = $nom.".".$acortar[$i];
				else
					$nom = $nom." ".$acortar[$i];
				}
			}
		if($long<=2){
			$nom = substr($acortar[0],0,1)."."; //COJO EL NOMBRE
			$nom = $nom." ".$acortar[1]." ".$acortar[2];
		}
		return $nom;
}
include("../../conexion.php");
$id = $_GET['id'];
$sql_temporada = $mysqli2->query("SELECT temporada FROM web_pruebas WHERE idcarrera='$id'");
    while($myrow=$sql_temporada->fetch_array())
      $temporada = $myrow['temporada'];
	?>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
     DashBoard C.D CODA::.....
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="../assets/css/black-dashboard.css?v=1.0.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper">
    <?php
		include("menu.php");
	?>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle d-inline">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="javascript:void(0)">FOTOS DE LOS PILOTOS</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse" id="navigation">
                    <?php
			include("usuario.php");
		?>
          </div>
        </div>
      </nav>
      <div class="modal modal-search fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="SEARCH">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="tim-icons icon-simple-remove"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Navbar -->
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header">
                <h4 class="card-title"> EQUIPOS:</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table tablesorter " id="">
                    <thead class=" text-primary">
                      <tr>
                        <th>
                          Equipo
                        </th>
                        <th>
                          Piloto
                        </th>
                        <th>
                          Copiloto
                        </th>
                        <th>
                          Extra1
                        </th>
						<th>
							Extra2
                        </th>
						<th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
						$sql=$mysqli2->query("SELECT idinscrito,concursante,piloto,copiloto FROM web_inscritos 
					WHERE idcarrera = '$id'");
							if($sql->num_rows==0)
								echo "<tr><td colspan='4'>No hay Pilotos Inscritos</td></tr>";
							else
								{
								while($fila=$sql->fetch_array())
									{
									$id_com = $fila['idinscrito'];
									$concursante = $fila['concursante'];
									$piloto = acortar_nombre($fila['piloto']);	
									$copiloto = acortar_nombre($fila['copiloto']);
										$img = $mysqli2->query("SELECT * FROM web_fotos WHERE id_ca_competidor = '$id_com'");                    
											if($img->num_rows>0)
											{
											//$img_pi = @mysql_result($img, 0, "img_piloto");
                      $img_pi ->fetch_array($img);
												if(empty($img_pi['img_piloto']) || $img_pi['img_piloto']=='')
													$img_pi = "<input type='file' class='form-control-file' name='img_pi'>";
												else
													$img_pi = "<img src='../../img/equipos/".$temporada."/".$id."/".$img_pi."' width='80px'><br><a href='borrar_foto.php?id_com=".$id_com."&tipo=img_piloto&id=".$id."&temporada=".$temporada."&tipo2=piloto'>BORRAR</a>";
										  //$img_copi = @mysql_result($img, 0, "img_copiloto");
												if(empty($img_pi['img_copiloto']) || $img_pi['copiloto']=='')
													$img_copi = "<input type='file' class='form-control-file' name='img_copi'>";
												else
													$img_copi = "<img src='../../img/equipos/".$temporada."/".$id."/".$img_copi."' width='80px'><br><a href='borrar_foto.php?id_com=".$id_com."&tipo=img_copiloto&id=".$id."&temporada=".$temporada."&tipo2=copiloto'>BORRAR</a>";
											//$img_com = @mysql_result($img, 0, "img_competidor");
												if(empty($$img_pi['img_com']) || $img_pi['img_com']=='')
													$img_com = "<input type='file' class='form-control-file' name='img_com'>";
												else
													$img_com = "<img src='../../img/equipos/".$temporada."/".$id."/".$img_com."' width='80px'><br><a href='borrar_foto.php?id_com=".$id_com."&tipo=img_competidor&id=".$id."&temporada=".$temporada."&tipo2=competidor'>BORRAR</a>";
											//$extra1 = @mysql_result($img, 0, "extra1");
												if(empty($img_pi['extra1']) || $img_pi['extra1']=='')
													$extra1 = "<input type='file' class='form-control-file' name='extra1'>";
												else
													$extra1 = "<img src='../../img/equipos/".$temporada."/".$id."/".$extra1."' width='80px'><br><a href='borrar_foto.php?id_com=".$id_com."&tipo=extra1&id=".$id."&temporada=".$temporada."&tipo2=extra1'>BORRAR</a>";
											//$extra2 = @mysql_result($img, 0, "extra2");
												if(empty($img_pi['extra2']) || $img_pi['extra2']=='')
													$extra2 = "<input type='file' class='form-control-file' name='extra2'>";
												else
													$extra2 = "<img src='../../img/equipos/".$temporada."/".$id."/".$extra2."' width='80px'><br><a href='borrar_foto.php?id_com=".$id_com."&tipo=extra2&id=".$id."&temporada=".$temporada."&tipo2=extra2'>BORRAR</a>";

											}
											else{
												$img_pi = "<input type='file' name='img_pi' class='form-control-file'>";
												$img_copi = "<input type='file' name='img_copi' class='form-control-file'>";
												$img_com = "<input type='file' name='img_com' class='form-control-file'>";
												$extra1 = "<input type='file' name='extra1' class='form-control-file'>";
												$extra2 = "<input type='file' name='extra2' class='form-control-file'>";
												
											}
											
									echo "<form action='fotos_subir.php' method='post' enctype='multipart/form-data'>
									<tr><td>".$concursante."<br>".$img_com."</td><td>".$piloto."<br>".$img_pi."</td>
									<td>".$copiloto."<br>".$img_copi."</td>
									<td>".$extra1."</td>
									<td>".$extra2."</td>
									<td><input type='submit' value='enviar'>
									<input type='hidden' value='".$id_com."' name='id_com'></td>
									<input type='hidden' value='".$id."' name='id'></td>
									</form></tr>";
									$img_pi='';
									$img_copi='';
									$img_com='';
									$extra1='';
									$extra2='';
									}
								}
					  ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer">
          <?php
			include("pie.php");
		?>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <!-- Place this tag in your head or just before your close body tag. -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Black Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/black-dashboard.min.js?v=1.0.0"></script>
  <!-- Black Dashboard DEMO methods, don't include it in your project! -->
  <script src="../assets/demo/demo.js"></script>
  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');
        $navbar = $('.navbar');
        $main_panel = $('.main-panel');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');
        sidebar_mini_active = true;
        white_color = false;

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();



        $('.fixed-plugin a').click(function(event) {
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .background-color span').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data', new_color);
          }

          if ($main_panel.length != 0) {
            $main_panel.attr('data', new_color);
          }

          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data', new_color);
          }
        });

        $('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function() {
          var $btn = $(this);

          if (sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            sidebar_mini_active = false;
            blackDashboard.showSidebarMessage('Sidebar mini deactivated...');
          } else {
            $('body').addClass('sidebar-mini');
            sidebar_mini_active = true;
            blackDashboard.showSidebarMessage('Sidebar mini activated...');
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);
        });

        $('.switch-change-color input').on("switchChange.bootstrapSwitch", function() {
          var $btn = $(this);

          if (white_color == true) {

            $('body').addClass('change-background');
            setTimeout(function() {
              $('body').removeClass('change-background');
              $('body').removeClass('white-content');
            }, 900);
            white_color = false;
          } else {

            $('body').addClass('change-background');
            setTimeout(function() {
              $('body').removeClass('change-background');
              $('body').addClass('white-content');
            }, 900);

            white_color = true;
          }


        });

        $('.light-badge').click(function() {
          $('body').addClass('white-content');
        });

        $('.dark-badge').click(function() {
          $('body').removeClass('white-content');
        });
      });
    });
	    $('.confir').on('click', function () {
        return confirm('VAS A ELIMINAR UN SECRETARIO DE CARRERA?');
    });
  </script>
</body>

</html>