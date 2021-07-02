<?php
session_start();
include("valida1.php");
?>
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
          <a class="navbar-brand" href="javascript:void(0)">CAJON DE APLICACIONES EXTRAS</a>
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
        <div class="col-lg-4">
          <div class="card card-chart">
            <div class="card-header">
              <h5 class="card-category"><a href="intermedios.php?activo=extras"><img src="img/gps.png" class="iconos-card">TIEMPOS API GPS</h5></a>

            </div>
            <div class="card-body">
              <div class="chart-area">

                <!--img src="img/gps.jpg"-->
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card card-chart">
            <div class="card-header">
              <h5 class="card-category"><a href="panel_tiempos.php?activo=extras"><img src="img/tiempos.png" class="iconos-card">PANTALLA TIEMPOS</h5></a>

            </div>
            <div class="card-body">
              <div class="chart-area">
                <!--img src="img/pantallas.jpg"-->
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card card-chart">
            <div class="card-header">
              <h5 class="card-category"><a href="http://coda2019.codea.es/direccion/index.html" target="_blank"><img src="img/direccion.png" class="iconos-card">PANTALLA DIRECCION</h5></a>
            </div>
            <div class="card-body">
              <div class="chart-area">
                <!--img src="img/direccion.jpg"-->
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4">
          <div class="card card-chart">
            <div class="card-header">
              <h5 class="card-category"><a href="fotos.php?activo=extras"><img src="img/fotos.png" class="iconos-card">FOTOS PILOTOS Y EQUIPOS</h5></a>

            </div>
            <div class="card-body">
              <div class="chart-area">
                <!--img src="img/fotos.jpg"-->
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card card-chart">
            <div class="card-header">
              <h5 class="card-category"><a href="ult_hora.php?activo=extras"><img src="img/ultimahora.png" class="iconos-card">ULTIMA HORA EN PAGINA WEB</h5></a>

            </div>
            <div class="card-body">
              <div class="chart-area">
                <!--img src="img/ult_hora.jpg"-->
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card card-chart">
            <div class="card-header">
              <h5 class="card-category"><a href="fusilar.php"><img src="img/fusilar.png" class="iconos-card">FUSILAR PRUEBA</h5></a>

            </div>
            <div class="card-body">
              <div class="chart-area">
                <!--img src="img/ult_hora.jpg"-->
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card card-chart">
            <div class="card-header">
              <h5 class="card-category"><a href="extras_inscritos.php?activo=extras"><img src="img/casco.png" class="iconos-card">SINCRONIZAR LISTA INSCRITOS</h5></a>
            </div>
            <div class="card-body">
              <div class="chart-area">
                <!--img src="img/ult_hora.jpg"-->
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card card-chart">
            <div class="card-header">
              <h5 class="card-category"><a href="extras_datosweb.php?activo=extras"><img src="img/sincronizarauto.png" class="iconos-card">DATOSWEB AUTOMATICO</h5></a>
            </div>
            <div class="card-body">
              <div class="chart-area">
                <!--img src="img/ult_hora.jpg"-->
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card card-chart">
            <div class="card-header">
              <h5 class="card-category"><a href="extras_copas.php?activo=extras"><img src="img/sincronizarauto.png" class="iconos-card">SINCRONIZAR COPAS/INSCRIBIRLOS</h5></a>
            </div>
            <div class="card-body">
              <div class="chart-area">
                <!--img src="img/ult_hora.jpg"-->
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card card-chart">
            <div class="card-header">
              <h5 class="card-category"><a href="ult_hora.php?activo=extras"><img src="img/sincronizar.png" class="iconos-card">DATOSWEB MANUAL</h5></a>

            </div>
            <div class="card-body">
              <div class="chart-area">
                <!--img src="img/ult_hora.jpg"-->
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
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      demo.initDashboardPageCharts();

    });
  </script>
</body>

</html>