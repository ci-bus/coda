<!DOCTYPE html>
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
	$IPservidor = "localhost";
	$nombreBD = "codea_es_sistema";
	$usuario = "manuel";
	$clave = "coda200900==";
	//echo "newW_BD";

$conexion = mysql_connect($IPservidor, $usuario, $clave) or die("<h2>No hay conexi&oacute;n con el servidor MySQL</h2>");
mysql_query ("SET NAMES 'utf8'");
mysql_select_db($nombreBD) or die('no se encontro la bd');


		$id = $_POST['id'];
    $sql_temporada = mysql_query("SELECT temporada FROM abc_57os_ca_carrera WHERE id='$id'");
    while($myrow=mysql_fetch_array($sql_temporada))
      $temporada = $myrow['temporada'];
		function crearThumbJPEG($rutaImagen,$rutaDestino,$anchoThumb=500,$calidad = 70){

        $original = imagecreatefromJPEG($rutaImagen);

        if ($original !== false){
			$ancho_or = imagesx($original);
            $alto_or = imagesy($original);
			$alto_proporcional = $anchoThumb*$alto_or/$ancho_or;
           $thumb = imageCreatetrueColor($anchoThumb,$alto_proporcional);
           if ($thumb !== false){
              $ancho = imagesx($original);
              $alto = imagesy($original);

              imagecopyresampled($thumb,$original,0,0,0,0,$anchoThumb,$alto_proporcional,$ancho,$alto);
              $resultado = imagejpeg($thumb,$rutaDestino,$calidad);
              //return $resultado;
           }
        }
        return false;
        
     } 
		$id_com = $_POST['id_com'];
		$img_pi = $_FILES['img_pi']['name'];
		$img_copi = $_FILES['img_copi']['name'];
		$img_com = $_FILES['img_com']['name'];
		$extra1 = $_FILES['extra1']['name'];
		$extra2 = $_FILES['extra2']['name'];
		if($img_pi!='')
			{
			$archivo = $id_com."_".basename( $_FILES['img_pi']['name']);
			$nombre = $id_com."_piloto.jpg";
			$target_path = "../../img/equipos/".$temporada."/".$id."/".$id_com."_piloto.jpg";
			if(move_uploaded_file($_FILES['img_pi']['tmp_name'], $target_path)) {
				echo "El archivo ".  basename( $_FILES['img_pi']['name']). 
				" ha sido subido";
				}
			$con_afectada = mysql_query("SELECT * FROM web_fotos WHERE id_ca_competidor = '$id_com'");
				if(mysql_num_rows($con_afectada)>0) // Existe en BD, Actualizamos
					$sql = mysql_query("UPDATE web_fotos SET img_piloto='$nombre' WHERE id_ca_competidor='$id_com'");
				else //NO EXISTE AUN, CREAMOS CON ESTA IMAGEN
					$sql = mysql_query("INSERT into web_fotos (id_ca_competidor,img_piloto,img_copiloto,img_competidor,extra1,extra2) 
					VALUES ('$id_com','$nombre','','','','')");
			crearThumbJPEG($target_path,$target_path);
			}
		if($img_copi!='')
			{
			$archivo = $id_com."_".basename( $_FILES['img_copi']['name']);
			$nombre = $id_com."_copiloto.jpg";
			$target_path = "../../img/equipos/".$temporada."/".$id."/".$id_com."_copiloto.jpg";
			if(move_uploaded_file($_FILES['img_copi']['tmp_name'], $target_path)) {
				echo "El archivo ".  basename( $_FILES['img_copi']['name']). 
				" ha sido subido";
				}
			$con_afectada = mysql_query("SELECT * FROM web_fotos WHERE id_ca_competidor = '$id_com'");
				if(mysql_num_rows($con_afectada)>0) // Existe en BD, Actualizamos
					$sql = mysql_query("UPDATE web_fotos SET img_copiloto='$nombre' WHERE id_ca_competidor='$id_com'");
				else //NO EXISTE AUN, CREAMOS CON ESTA IMAGEN
					$sql = mysql_query("INSERT into web_fotos (id_ca_competidor,img_piloto,img_copiloto,img_competidor,extra1,extra2) 
					VALUES ('$id_com','','$nombre','','','')");
			}
			if($img_com!='')
			{
			$archivo = $id_com."_".basename( $_FILES['img_com']['name']);
			$nombre = $id_com."_competidor.jpg";
			$target_path = "../../img/equipos/".$temporada."/".$id."/".$id_com."_competidor.jpg";
			if(move_uploaded_file($_FILES['img_com']['tmp_name'], $target_path)) {
				echo "El archivo ".  basename( $_FILES['img_com']['name']). 
				" ha sido subido";
				}
			$con_afectada = mysql_query("SELECT * FROM web_fotos WHERE id_ca_competidor = '$id_com'");
				if(mysql_num_rows($con_afectada)>0) // Existe en BD, Actualizamos
					$sql = mysql_query("UPDATE web_fotos SET img_competidor='$nombre' WHERE id_ca_competidor='$id_com'");
				else //NO EXISTE AUN, CREAMOS CON ESTA IMAGEN
					$sql = mysql_query("INSERT into web_fotos (id_ca_competidor,img_piloto,img_copiloto,img_competidor,extra1,extra2) 
					VALUES ('$id_com','','','$nombre','','')");
			}
			if($extra1!='')
			{
			$archivo = $id_com."_".basename( $_FILES['extra1']['name']);
			$nombre = $id_com."_extra1.jpg";
			$target_path = "../../img/equipos/".$temporada."/".$id."/".$id_com."_extra1.jpg";
			if(move_uploaded_file($_FILES['extra1']['tmp_name'], $target_path)) {
				echo "El archivo ".  basename( $_FILES['extra1']['name']). 
				" ha sido subido";
				}
			$con_afectada = mysql_query("SELECT * FROM web_fotos WHERE id_ca_competidor = '$id_com'");
				if(mysql_num_rows($con_afectada)>0) // Existe en BD, Actualizamos
					$sql = mysql_query("UPDATE web_fotos SET extra1='$nombre' WHERE id_ca_competidor='$id_com'");
				else //NO EXISTE AUN, CREAMOS CON ESTA IMAGEN
					$sql = mysql_query("INSERT into web_fotos (id_ca_competidor,img_piloto,img_copiloto,img_competidor,extra1,extra2) 
					VALUES ('$id_com','','','','$nombre','')");
			}
			if($extra2!='')
			{
			$archivo = $id_com."_".basename( $_FILES['extra2']['name']);
			$nombre = $id_com."_extra2.jpg";
			$target_path = "../../img/equipos/".$temporada."/".$id."/".$id_com."_extra2.jpg";
			if(move_uploaded_file($_FILES['extra2']['tmp_name'], $target_path)) {
				echo "El archivo ".  basename( $_FILES['extra2']['name']). 
				" ha sido subido";
				}
			$con_afectada = mysql_query("SELECT * FROM web_fotos WHERE id_ca_competidor = '$id_com'");
				if(mysql_num_rows($con_afectada)>0) // Existe en BD, Actualizamos
					$sql = mysql_query("UPDATE web_fotos SET extra2='$nombre' WHERE id_ca_competidor='$id_com'");
				else //NO EXISTE AUN, CREAMOS CON ESTA IMAGEN
					$sql = mysql_query("INSERT into web_fotos (id_ca_competidor,img_piloto,img_copiloto,img_competidor,extra1,extra2) 
					VALUES ('$id_com','','','','','$nombre')");
			}
		echo '<META HTTP-EQUIV=Refresh CONTENT="1; URL=fotos_ver.php?activo=extras&newBD=true&id='.$id.'">';
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
            <a class="navbar-brand" href="javascript:void(0)">NUEVA FOTO PILOTOS</a>
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
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <h5 class="title">Guardando Imagen...</h5>
				<p><?php echo $nombre;?></p>
              </div>
              <div class="card-body">
            </div>
          </div>
          <div class="col-md-4">

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
  </script>
</body>

</html>