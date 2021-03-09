<?php
if (isset($_GET["idmanga"]) && isset($_GET["id"])) {
    $idManga = $_GET["idmanga"];
    $idCarrera = $_GET["id"];
    $idseccion = $_GET["idseccion"];
    $idetapa = $_GET["idetapa"];
}
if (isset($_GET["copa"]))
    $copa = $_GET["copa"];
else
    $copa = '0';
//include_once("includes/dateAfecha.php");//para hacer operaciones con fechas
//include("includes/funciones.php");
if (isset($_GET["id"])) {
    $idCarrera = $_GET["id"];
    include("conexion.php");
    //include("escudos.php");
    //include("includes/funciones.php");
    $DB_PREFIJO = "abc_57os_";
    $dbQuery = "SELECT titulo,fecha_larga,tipo FROM web_pruebas_archivo WHERE idcarrera = '$idCarrera'";
    $resultado = $mysqli2->query($dbQuery) or print "No se pudo acceder al contenido.";
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_array()) {
            $titulo = $row['titulo'];
            $fecha = $row['fecha_larga'];
            $tipo = $row['tipo'];
        }
    }
}
$enlace_actual = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <META HTTP-EQUIV="Refresh" CONTENT="460;URL=<?php echo $enlace_actual; ?>">
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
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!-- Site Title -->
    <title>C.O.D.A:.Cronometradores Y Oficiales De Automovilismo</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
    <!--
			CSS
			============================================= -->
    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">
    <script type="text/javascript" src="js/ajax.js"></script>
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
                        <h2 class="text-white"><?php echo $titulo; ?></h2>
                        <p class="text-white"><?php echo $fecha; ?></p>
                    </div>
                </div>
            </div>
            <a href="tiempos_archivo.php?id=<?php echo $idCarrera; ?>&newBD=true" class="primary-btn text-uppercase selected">VOLVER</a>
            <a href="clas_final_archivo.php?id=<?php echo $idCarrera; ?>&copa=0" class="primary-btn text-uppercase selected">CLASIFICACI&Oacute;N FINAL</a>
        </div>
    </section>
    <div class="section-top-border">
        <hr><br>
        <div id='recarga'>
            <?php
                include("mangas_recarga_archivo.php");
            ?>
        </div>
    </div>
    <?php
    include("visitas.php");
    ?>
    <footer class="footer-area section-gap">
        <?php
        include("footer.php");
        ?>
    </footer>
    <!-- End footer Area -->


    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <!--script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script-->
    <script type="text/javascript">
        function surfto(form) {
            var myindex = form.mangas.selectedIndex;
            window.open(form.mangas.options[myindex].value, "_top");
        }

        function surfto2(form) {
            var myindex = form.copas.selectedIndex;
            window.open(form.copas.options[myindex].value, "_top");
        }
    </script>
</body>

</html>