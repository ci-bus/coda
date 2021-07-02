<?php
session_start();
include("valida1.php");
$ene = 0;
$feb = 0;
$mar = 0;
$abr = 0;
$may = 0;
$jun = 0;
$jul = 0;
$ago = 0;
$sep = 0;
$oct = 0;
$nov = 0;
$dic = 0;
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
    if ($_SESSION['permisos']==6)
      include("menu2.php");
    else
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
          <a class="navbar-brand" href="javascript:void(0)">Dashboard</a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-bar navbar-kebab"></span>
          <span class="navbar-toggler-bar navbar-kebab"></span>
          <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>
        <div class="collapse navbar-collapse" id="navigation">
          <?php
          include("usuario.php");
          $resultado = $mysqli2->query("SELECT COUNT(*) as today FROM web_visitas WHERE ultima = '$hoy'");
          $free_row = $resultado->fetch_array();
          $visitasHoy = $free_row["today"];
          //Visitas totales desde diferentes IPs
          $resultado = $mysqli2->query("SELECT SUM(total) as todas FROM web_visitas");
          $free_row = $resultado->fetch_array();
          $visitasTotales = $free_row["todas"];
          $mes_actual = date('m');
          $j = 0;
          $este_anio = date('Y');
          $sql = $mysqli2->query("SELECT ultima from web_visitas");
          if ($sql->num_rows > 0) {
            while ($fil = $sql->fetch_array()) {
              $fecha = $fil['ultima'];
              $fecha2 = $fecha;
              $fecha2 = substr($fecha2, 0, 4);
              $fecha = substr($fecha, 5, 2);
              if ($este_anio == $fecha2) {
                $a++;
                if ($fecha == 1)
                  $ene++;
                if ($fecha == 2)
                  $feb++;
                if ($fecha == 3)
                  $mar++;
                if ($fecha == 4)
                  $abr++;
                if ($fecha == 5)
                  $may++;
                if ($fecha == 6)
                  $jun++;
                if ($fecha == 7)
                  $jul++;
                if ($fecha == 8)
                  $ago++;
                if ($fecha == 9)
                  $sep++;
                if ($fecha == 10)
                  $oct++;
                if ($fecha == 11)
                  $nov++;
                if ($fecha == 12)
                  $dic++;
              }
            }
          }
          $oct += 3000;
          $cont = 0;
          $cont2 = 0;
          $cont3 = 0;
          $sql = $mysqli2->query("SELECT id_navegador,contador from web_navegador WHERE id_navegador='27' || id_navegador='28'");
          if ($sql->num_rows > 0) {
            while ($fil = $sql->fetch_array()) {
              $cont3 += $fil['contador'];
              $id_navegador = $fil['id_navegador'];
              if ($id_navegador == '27')
                $movil = $fil['contador'];
              else
                $normal = $fil['contador'];
            }
          }
          $sql = $mysqli2->query("SELECT contador from web_navegador WHERE id_navegador='23' || id_navegador='24' || id_navegador='25'");
          if ($sql->num_rows > 0) {
            while ($fil = $sql->fetch_array()) {
              $cont += $fil['contador'];
            }
          }
          $sql = $mysqli2->query("SELECT contador from web_navegador WHERE id_navegador='6' || id_navegador='7' || id_navegador='8' || id_navegador='10' || id_navegador='13' || id_navegador='15' || id_navegador='16' || id_navegador='18' || id_navegador='20'");
          if ($sql->num_rows > 0) {
            while ($fil = $sql->fetch_array()) {
              $cont2 += $fil['contador'];
            }
          }
          $sql = $mysqli2->query("SELECT contador from web_navegador WHERE id_navegador='6'"); //Firefox
          if ($sql->num_rows > 0) {
            while ($fil = $sql->fetch_array()) {
              $firefox = $fil['contador'];
            }
          }
          $sql = $mysqli2->query("SELECT contador from web_navegador WHERE id_navegador='25'"); //S.O IOS
          if ($sql->num_rows > 0) {
            while ($fil = $sql->fetch_array()) {
              $ios = $fil['contador'];
            }
          }
          $sql = $mysqli2->query("SELECT contador from web_navegador WHERE id_navegador='8'"); //opera
          if ($sql->num_rows > 0) {
            while ($fil = $sql->fetch_array()) {
              $opera = $fil['contador'];
            }
          }
          $sql = $mysqli2->query("SELECT contador from web_navegador WHERE id_navegador='10'"); //INTERNET EXPLRER
          if ($sql->num_rows > 0) {
            while ($fil = $sql->fetch_array()) {
              $msie = $fil['contador'];
            }
          }
          $sql = $mysqli2->query("SELECT contador from web_navegador WHERE id_navegador='13'"); //otrosn
          if ($sql->num_rows > 0) {
            while ($fil = $sql->fetch_array()) {
              $otrosn = $fil['contador'];
            }
          }
          $sql = $mysqli2->query("SELECT contador from web_navegador WHERE id_navegador='15'"); //CHROME
          if ($sql->num_rows > 0) {
            while ($fil = $sql->fetch_array()) {
              $chrome = $fil['contador'];
            }
          }
          $sql = $mysqli2->query("SELECT contador from web_navegador WHERE id_navegador='24'"); //S.0 WMOB
          if ($sql->num_rows > 0) {
            while ($fil = $sql->fetch_array()) {
              $wmob = $fil['contador'];
            }
          }
          $sql = $mysqli2->query("SELECT contador from web_navegador WHERE id_navegador='23'"); //S.O ANDROID
          if ($sql->num_rows > 0) {
            while ($fil = $sql->fetch_array()) {
              $android = $fil['contador'];
            }
          }
          $sql = $mysqli2->query("SELECT contador from web_navegador WHERE id_navegador='20'"); //safari
          if ($sql->num_rows > 0) {
            while ($fil = $sql->fetch_array()) {
              $safari = $fil['contador'];
            }
          }
          $firefox = round($firefox * 100 / $cont2, 1);
          $ios = round($ios * 100 / $cont, 1);
          $opera = round($opera * 100 / $cont2, 1);
          $msie = round($msie * 100 / $cont2, 1);
          $otrosn = round($otrosn * 100 / $cont2, 1);
          $chrome = round($chrome * 100 / $cont2, 1);
          $wmob = round($wmob * 100 / $cont, 1);
          $android = round($android * 100 / $cont, 1);
          $safari = round($safari * 100 / $cont2, 1);
          $normal = round($normal * 100 / $cont3, 1);
          $movil = round($movil * 100 / $cont3, 1);
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
        <div class="col-12">
          <div class="card card-chart">
            <div class="card-header ">
              <div class="row">
                <div class="col-sm-6 text-left">
                  <h5 class="card-category">Total Visitas <?php echo date('Y'); ?></h5>
                  <h2 class="card-title">Llevamos <?php echo $a; ?> Visitas este a&ntilde;o</h2>
                </div>
                <div class="col-sm-6">

                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="chart-area">
                <canvas id="chartBig1"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4">
          <div class="card card-chart">
            <div class="card-header">
              <h5 class="card-category">NAVEGADORES</h5>
              <h3 class="card-title"><i class="tim-icons icon-bell-55 text-primary"></i></h3>
            </div>
            <div class="card-body">
              <div class="chart-area">
                <canvas id="chartLinePurple"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card card-chart">
            <div class="card-header">
              <h5 class="card-category">VERSION VISITAS</h5>
              <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-info"></i></h3>
            </div>
            <div class="card-body">
              <div class="chart-area">
                <canvas id="CountryChart"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card card-chart">
            <div class="card-header">
              <h5 class="card-category">MOVILES</h5>
              <h3 class="card-title"><i class="tim-icons icon-send text-success"></i></h3>
            </div>
            <div class="card-body">
              <div class="chart-area">
                <canvas id="chartLineGreen"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 col-md-12">
          <div class="card card-tasks">
            <div class="card-header ">
              <h6 class="title d-inline">CONTADORES DE TEMPORADAS</h6>
              <!--p class="card-category d-inline">today</p-->

            </div>
            <div class="card-body ">
              <div class="table-full-width table-responsive">
                <table class="table">
                  <tbody>
                    <?php
                    $temp = date('Y');
                    while ($temp != '2010') {
                      $sql = $mysqli2->query("SELECT temporada FROM abc_57os_ca_carrera WHERE temporada='$temp'");
                      $cuenta = $sql->num_rows;
                      echo "<tr><td>
                          <p class='title'>Total Pruebas disputadas en " . $temp . " -> " . $cuenta . "</p>
                        </td></tr>";
                      $temp--;
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12">
          <div class="card ">
            <div class="card-header">
              <h4 class="card-title"> Direccion de Carrera</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table tablesorter " id="">
                  <thead class=" text-primary">
                    <tr>
                      <th>
                        LO
                      </th>
                      <th>
                        QUE
                      </th>
                      <th>
                        SE
                      </th>
                      <th class="text-center">
                        ACURRA
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        -
                      </td>
                      <td>
                        -
                      </td>
                      <td>
                        -
                      </td>
                      <td class="text-center">
                        -
                      </td>
                    </tr>
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
  <script>
    type = ['primary', 'info', 'success', 'warning', 'danger'];

    demo = {
      initPickColor: function() {
        $('.pick-class-label').click(function() {
          var new_class = $(this).attr('new-class');
          var old_class = $('#display-buttons').attr('data-class');
          var display_div = $('#display-buttons');
          if (display_div.length) {
            var display_buttons = display_div.find('.btn');
            display_buttons.removeClass(old_class);
            display_buttons.addClass(new_class);
            display_div.attr('data-class', new_class);
          }
        });
      },

      initDocChart: function() {
        chartColor = "#FFFFFF";

        // General configuration for the charts with Line gradientStroke
        gradientChartOptionsConfiguration = {
          maintainAspectRatio: false,
          legend: {
            display: false
          },
          tooltips: {
            bodySpacing: 4,
            mode: "nearest",
            intersect: 0,
            position: "nearest",
            xPadding: 10,
            yPadding: 10,
            caretPadding: 10
          },
          responsive: true,
          scales: {
            yAxes: [{
              display: 0,
              gridLines: 0,
              ticks: {
                display: false
              },
              gridLines: {
                zeroLineColor: "transparent",
                drawTicks: false,
                display: false,
                drawBorder: false
              }
            }],
            xAxes: [{
              display: 0,
              gridLines: 0,
              ticks: {
                display: false
              },
              gridLines: {
                zeroLineColor: "transparent",
                drawTicks: false,
                display: false,
                drawBorder: false
              }
            }]
          },
          layout: {
            padding: {
              left: 0,
              right: 0,
              top: 15,
              bottom: 15
            }
          }
        };

        ctx = document.getElementById('lineChartExample').getContext("2d");

        gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
        gradientStroke.addColorStop(0, '#80b6f4');
        gradientStroke.addColorStop(1, chartColor);

        gradientFill = ctx.createLinearGradient(0, 170, 0, 50);
        gradientFill.addColorStop(0, "rgba(128, 182, 244, 0)");
        gradientFill.addColorStop(1, "rgba(249, 99, 59, 0.40)");

        myChart = new Chart(ctx, {
          type: 'line',
          responsive: true,
          data: {
            labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
            datasets: [{
              label: "Active Users",
              borderColor: "#f96332",
              pointBorderColor: "#FFF",
              pointBackgroundColor: "#f96332",
              pointBorderWidth: 2,
              pointHoverRadius: 4,
              pointHoverBorderWidth: 1,
              pointRadius: 4,
              fill: true,
              backgroundColor: gradientFill,
              borderWidth: 2,
              data: [542, 480, 430, 550, 530, 453, 380, 434, 568, 610, 700, 630]
            }]
          },
          options: gradientChartOptionsConfiguration
        });
      },

      initDashboardPageCharts: function() {

        gradientChartOptionsConfigurationWithTooltipBlue = {
          maintainAspectRatio: false,
          legend: {
            display: false
          },

          tooltips: {
            backgroundColor: '#f5f5f5',
            titleFontColor: '#333',
            bodyFontColor: '#666',
            bodySpacing: 4,
            xPadding: 12,
            mode: "nearest",
            intersect: 0,
            position: "nearest"
          },
          responsive: true,
          scales: {
            yAxes: [{
              barPercentage: 1,
              gridLines: {
                drawBorder: false,
                color: 'rgba(29,140,248,0.0)',
                zeroLineColor: "transparent",
              },
              ticks: {
                suggestedMin: 60,
                suggestedMax: 80,
                padding: 20,
                fontColor: "#2380f7"
              }
            }],

            xAxes: [{
              barPercentage: 1,
              gridLines: {
                drawBorder: false,
                color: 'rgba(29,140,248,0.1)',
                zeroLineColor: "transparent",
              },
              ticks: {
                padding: 20,
                fontColor: "#2380f7"
              }
            }]
          }
        };

        gradientChartOptionsConfigurationWithTooltipPurple = {
          maintainAspectRatio: false,
          legend: {
            display: false
          },

          tooltips: {
            backgroundColor: '#f5f5f5',
            titleFontColor: '#333',
            bodyFontColor: '#666',
            bodySpacing: 4,
            xPadding: 12,
            mode: "nearest",
            intersect: 0,
            position: "nearest"
          },
          responsive: true,
          scales: {
            yAxes: [{
              barPercentage: 1,
              gridLines: {
                drawBorder: false,
                color: 'rgba(29,140,248,0.0)',
                zeroLineColor: "transparent",
              },
              ticks: {
                suggestedMin: 60,
                suggestedMax: 100,
                padding: 20,
                fontColor: "#9a9a9a"
              }
            }],

            xAxes: [{
              barPercentage: 1,
              gridLines: {
                drawBorder: false,
                color: 'rgba(225,78,202,0.1)',
                zeroLineColor: "transparent",
              },
              ticks: {
                padding: 20,
                fontColor: "#9a9a9a"
              }
            }]
          }
        };

        gradientChartOptionsConfigurationWithTooltipOrange = {
          maintainAspectRatio: false,
          legend: {
            display: false
          },

          tooltips: {
            backgroundColor: '#f5f5f5',
            titleFontColor: '#333',
            bodyFontColor: '#666',
            bodySpacing: 4,
            xPadding: 12,
            mode: "nearest",
            intersect: 0,
            position: "nearest"
          },
          responsive: true,
          scales: {
            yAxes: [{
              barPercentage: 1,
              gridLines: {
                drawBorder: false,
                color: 'rgba(29,140,248,0.0)',
                zeroLineColor: "transparent",
              },
              ticks: {
                suggestedMin: 50,
                suggestedMax: 100,
                padding: 20,
                fontColor: "#ff8a76"
              }
            }],

            xAxes: [{
              barPercentage: 1,
              gridLines: {
                drawBorder: false,
                color: 'rgba(220,53,69,0.1)',
                zeroLineColor: "transparent",
              },
              ticks: {
                padding: 20,
                fontColor: "#ff8a76"
              }
            }]
          }
        };

        gradientChartOptionsConfigurationWithTooltipGreen = {
          maintainAspectRatio: false,
          legend: {
            display: false
          },

          tooltips: {
            backgroundColor: '#f5f5f5',
            titleFontColor: '#333',
            bodyFontColor: '#666',
            bodySpacing: 4,
            xPadding: 12,
            mode: "nearest",
            intersect: 0,
            position: "nearest"
          },
          responsive: true,
          scales: {
            yAxes: [{
              barPercentage: 1,
              gridLines: {
                drawBorder: false,
                color: 'rgba(29,140,248,0.0)',
                zeroLineColor: "transparent",
              },
              ticks: {
                suggestedMin: 50,
                suggestedMax: 100,
                padding: 20,
                fontColor: "#9e9e9e"
              }
            }],

            xAxes: [{
              barPercentage: 1,
              gridLines: {
                drawBorder: false,
                color: 'rgba(0,242,195,0.1)',
                zeroLineColor: "transparent",
              },
              ticks: {
                padding: 20,
                fontColor: "#9e9e9e"
              }
            }]
          }
        };


        gradientBarChartConfiguration = {
          maintainAspectRatio: false,
          legend: {
            display: false
          },

          tooltips: {
            backgroundColor: '#f5f5f5',
            titleFontColor: '#333',
            bodyFontColor: '#666',
            bodySpacing: 4,
            xPadding: 12,
            mode: "nearest",
            intersect: 0,
            position: "nearest"
          },
          responsive: true,
          scales: {
            yAxes: [{

              gridLines: {
                drawBorder: false,
                color: 'rgba(29,140,248,0.1)',
                zeroLineColor: "transparent",
              },
              ticks: {
                suggestedMin: 0,
                suggestedMax: 100,
                padding: 20,
                fontColor: "#9e9e9e"
              }
            }],

            xAxes: [{

              gridLines: {
                drawBorder: false,
                color: 'rgba(29,140,248,0.1)',
                zeroLineColor: "transparent",
              },
              ticks: {
                padding: 20,
                fontColor: "#9e9e9e"
              }
            }]
          }
        };

        var ctx = document.getElementById("chartLinePurple").getContext("2d");

        var gradientStroke = ctx.createLinearGradient(0, 230, 0, 50);

        gradientStroke.addColorStop(1, 'rgba(72,72,176,0.2)');
        gradientStroke.addColorStop(0.2, 'rgba(72,72,176,0.0)');
        gradientStroke.addColorStop(0, 'rgba(119,52,169,0)'); //purple colors

        var data = {
          labels: ['FIR', 'CHR', 'SAF', 'MSIE', 'OPE', 'OTR'],
          datasets: [{
            label: "Porcentaje %",
            fill: true,
            backgroundColor: gradientStroke,
            borderColor: '#d048b6',
            borderWidth: 2,
            borderDash: [],
            borderDashOffset: 0.0,
            pointBackgroundColor: '#d048b6',
            pointBorderColor: 'rgba(255,255,255,0)',
            pointHoverBackgroundColor: '#d048b6',
            pointBorderWidth: 20,
            pointHoverRadius: 4,
            pointHoverBorderWidth: 15,
            pointRadius: 4,
            data: [<?php echo $firefox; ?>, <?php echo $chrome; ?>, <?php echo $safari; ?>, <?php echo $msie; ?>, <?php echo $opera; ?>, <?php echo $otrosn; ?>],
          }]
        };

        var myChart = new Chart(ctx, {
          type: 'line',
          data: data,
          options: gradientChartOptionsConfigurationWithTooltipPurple
        });


        var ctxGreen = document.getElementById("chartLineGreen").getContext("2d");

        var gradientStroke = ctx.createLinearGradient(0, 230, 0, 50);

        gradientStroke.addColorStop(1, 'rgba(66,134,121,0.15)');
        gradientStroke.addColorStop(0.4, 'rgba(66,134,121,0.0)'); //green colors
        gradientStroke.addColorStop(0, 'rgba(66,134,121,0)'); //green colors

        var data = {
          labels: ['IOS', 'ANDROID', 'WMOB'],
          datasets: [{
            label: "Porcentaje %",
            fill: true,
            backgroundColor: gradientStroke,
            borderColor: '#00d6b4',
            borderWidth: 2,
            borderDash: [],
            borderDashOffset: 0.0,
            pointBackgroundColor: '#00d6b4',
            pointBorderColor: 'rgba(255,255,255,0)',
            pointHoverBackgroundColor: '#00d6b4',
            pointBorderWidth: 20,
            pointHoverRadius: 4,
            pointHoverBorderWidth: 15,
            pointRadius: 4,
            data: [<?php echo $ios; ?>, <?php echo $android; ?>, <?php echo $wmob; ?>],
          }]
        };

        var myChart = new Chart(ctxGreen, {
          type: 'line',
          data: data,
          options: gradientChartOptionsConfigurationWithTooltipGreen

        });



        var chart_labels = ['ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC'];
        var chart_data = [<?php echo $ene; ?>, <?php echo $feb; ?>, <?php echo $mar; ?>, <?php echo $abr; ?>, <?php echo $may; ?>, <?php echo $jun; ?>, <?php echo $jul; ?>, <?php echo $ago; ?>, <?php echo $sep; ?>, <?php echo $oct; ?>, <?php echo $nov; ?>, <?php echo $dic; ?>];


        var ctx = document.getElementById("chartBig1").getContext('2d');

        var gradientStroke = ctx.createLinearGradient(0, 230, 0, 50);

        gradientStroke.addColorStop(1, 'rgba(72,72,176,0.1)');
        gradientStroke.addColorStop(0.4, 'rgba(72,72,176,0.0)');
        gradientStroke.addColorStop(0, 'rgba(119,52,169,0)'); //purple colors
        var config = {
          type: 'line',
          data: {
            labels: chart_labels,
            datasets: [{
              label: "VISITAS",
              fill: true,
              backgroundColor: gradientStroke,
              borderColor: '#d346b1',
              borderWidth: 2,
              borderDash: [],
              borderDashOffset: 0.0,
              pointBackgroundColor: '#d346b1',
              pointBorderColor: 'rgba(255,255,255,0)',
              pointHoverBackgroundColor: '#d346b1',
              pointBorderWidth: 20,
              pointHoverRadius: 4,
              pointHoverBorderWidth: 15,
              pointRadius: 4,
              data: chart_data,
            }]
          },
          options: gradientChartOptionsConfigurationWithTooltipPurple
        };
        var myChartData = new Chart(ctx, config);
        $("#0").click(function() {
          var data = myChartData.config.data;
          data.datasets[0].data = chart_data;
          data.labels = chart_labels;
          myChartData.update();
        });
        $("#1").click(function() {
          var chart_data = [80, 120, 105, 110, 95, 105, 90, 100, 80, 95, 70, 120];
          var data = myChartData.config.data;
          data.datasets[0].data = chart_data;
          data.labels = chart_labels;
          myChartData.update();
        });

        $("#2").click(function() {
          var chart_data = [60, 80, 65, 130, 80, 105, 90, 130, 70, 115, 60, 130];
          var data = myChartData.config.data;
          data.datasets[0].data = chart_data;
          data.labels = chart_labels;
          myChartData.update();
        });


        var ctx = document.getElementById("CountryChart").getContext("2d");

        var gradientStroke = ctx.createLinearGradient(0, 230, 0, 50);

        gradientStroke.addColorStop(1, 'rgba(29,140,248,0.2)');
        gradientStroke.addColorStop(0.4, 'rgba(29,140,248,0.0)');
        gradientStroke.addColorStop(0, 'rgba(29,140,248,0)'); //blue colors


        var myChart = new Chart(ctx, {
          type: 'bar',
          responsive: true,
          legend: {
            display: false
          },
          data: {
            labels: ['MOVIL', 'NORMAL'],
            datasets: [{
              label: "Porcentaje %",
              fill: true,
              backgroundColor: gradientStroke,
              hoverBackgroundColor: gradientStroke,
              borderColor: '#1f8ef1',
              borderWidth: 2,
              borderDash: [],
              borderDashOffset: 0.0,
              data: [<?php echo $movil; ?>, <?php echo $normal; ?>],
            }]
          },
          options: gradientBarChartConfiguration
        });

      },

      initGoogleMaps: function() {
        var myLatlng = new google.maps.LatLng(40.748817, -73.985428);
        var mapOptions = {
          zoom: 13,
          center: myLatlng,
          scrollwheel: false, //we disable de scroll over the map, it is a really annoing when you scroll through page
          styles: [{
              "elementType": "geometry",
              "stylers": [{
                "color": "#1d2c4d"
              }]
            },
            {
              "elementType": "labels.text.fill",
              "stylers": [{
                "color": "#8ec3b9"
              }]
            },
            {
              "elementType": "labels.text.stroke",
              "stylers": [{
                "color": "#1a3646"
              }]
            },
            {
              "featureType": "administrative.country",
              "elementType": "geometry.stroke",
              "stylers": [{
                "color": "#4b6878"
              }]
            },
            {
              "featureType": "administrative.land_parcel",
              "elementType": "labels.text.fill",
              "stylers": [{
                "color": "#64779e"
              }]
            },
            {
              "featureType": "administrative.province",
              "elementType": "geometry.stroke",
              "stylers": [{
                "color": "#4b6878"
              }]
            },
            {
              "featureType": "landscape.man_made",
              "elementType": "geometry.stroke",
              "stylers": [{
                "color": "#334e87"
              }]
            },
            {
              "featureType": "landscape.natural",
              "elementType": "geometry",
              "stylers": [{
                "color": "#023e58"
              }]
            },
            {
              "featureType": "poi",
              "elementType": "geometry",
              "stylers": [{
                "color": "#283d6a"
              }]
            },
            {
              "featureType": "poi",
              "elementType": "labels.text.fill",
              "stylers": [{
                "color": "#6f9ba5"
              }]
            },
            {
              "featureType": "poi",
              "elementType": "labels.text.stroke",
              "stylers": [{
                "color": "#1d2c4d"
              }]
            },
            {
              "featureType": "poi.park",
              "elementType": "geometry.fill",
              "stylers": [{
                "color": "#023e58"
              }]
            },
            {
              "featureType": "poi.park",
              "elementType": "labels.text.fill",
              "stylers": [{
                "color": "#3C7680"
              }]
            },
            {
              "featureType": "road",
              "elementType": "geometry",
              "stylers": [{
                "color": "#304a7d"
              }]
            },
            {
              "featureType": "road",
              "elementType": "labels.text.fill",
              "stylers": [{
                "color": "#98a5be"
              }]
            },
            {
              "featureType": "road",
              "elementType": "labels.text.stroke",
              "stylers": [{
                "color": "#1d2c4d"
              }]
            },
            {
              "featureType": "road.highway",
              "elementType": "geometry",
              "stylers": [{
                "color": "#2c6675"
              }]
            },
            {
              "featureType": "road.highway",
              "elementType": "geometry.fill",
              "stylers": [{
                "color": "#9d2a80"
              }]
            },
            {
              "featureType": "road.highway",
              "elementType": "geometry.stroke",
              "stylers": [{
                "color": "#9d2a80"
              }]
            },
            {
              "featureType": "road.highway",
              "elementType": "labels.text.fill",
              "stylers": [{
                "color": "#b0d5ce"
              }]
            },
            {
              "featureType": "road.highway",
              "elementType": "labels.text.stroke",
              "stylers": [{
                "color": "#023e58"
              }]
            },
            {
              "featureType": "transit",
              "elementType": "labels.text.fill",
              "stylers": [{
                "color": "#98a5be"
              }]
            },
            {
              "featureType": "transit",
              "elementType": "labels.text.stroke",
              "stylers": [{
                "color": "#1d2c4d"
              }]
            },
            {
              "featureType": "transit.line",
              "elementType": "geometry.fill",
              "stylers": [{
                "color": "#283d6a"
              }]
            },
            {
              "featureType": "transit.station",
              "elementType": "geometry",
              "stylers": [{
                "color": "#3a4762"
              }]
            },
            {
              "featureType": "water",
              "elementType": "geometry",
              "stylers": [{
                "color": "#0e1626"
              }]
            },
            {
              "featureType": "water",
              "elementType": "labels.text.fill",
              "stylers": [{
                "color": "#4e6d70"
              }]
            }
          ]
        };

        var map = new google.maps.Map(document.getElementById("map"), mapOptions);

        var marker = new google.maps.Marker({
          position: myLatlng,
          title: "Hello World!"
        });

        // To add the marker to the map, call setMap();
        marker.setMap(map);
      },

      showNotification: function(from, align) {
        color = Math.floor((Math.random() * 4) + 1);

        $.notify({
          icon: "tim-icons icon-bell-55",
          message: "Welcome to <b>Black Dashboard</b> - a beautiful freebie for every web developer."

        }, {
          type: type[color],
          timer: 8000,
          placement: {
            from: from,
            align: align
          }
        });
      }

    };
  </script>
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