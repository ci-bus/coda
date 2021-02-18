<?php
$DB_PREFIJO = "abc_57os_";
if (isset($_GET["idmanga"]) && isset($_GET["id"]) && isset($_GET["idseccion"]) && isset($_GET['idetapa'])) {
    $idManga = $_GET["idmanga"];
    $idCarrera = $_GET["id"];
    $idseccion = $_GET["idseccion"];
    $idetapa = $_GET["idetapa"];
}
if (isset($_GET["campeonato"])) {
    $campeonato = $_GET["campeonato"];
} else {
    $campeonato = '0';
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
    $dbQuery = "SELECT titulo,fecha_larga FROM web_pruebas WHERE idcarrera = '$idCarrera'";
    $resultado = $mysqli2->query($dbQuery) or print "No se pudo acceder al contenido.";
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_array()) {
            $titulo = $row['titulo'];
            $fecha = $row['fecha_larga'];
        }
    }
}
$modo_tiempo = $mysqli2->query("SELECT tipo_tiempo FROM web_campeonatos WHERE idcarrera = '$idCarrera'");
if ($modo_tiempo->num_rows > 0)
    $row = $modo_tiempo->fetch_array();
$tipo_prueba = $row['tipo_tiempo'];
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
    <script>
        // Refresco automático
        // TODO Cambiar URL según el tipo de carrera y calsificación
        var url = "mangas_recarga_new.php?idmanga=<?php echo $_GET['idmanga']; ?>&id=<?php echo $_GET['id']; ?>&copa=<?php echo $_GET['copa']; ?>";
        var segundos_refresco = 5;
        var capa_contenido = "recarga";
        var ultima_id = "";
        (refrescar = () => {
            llamada_ajax("datosweb_coger_ultima_id.php?", (res) => {
                if (res !== ultima_id) {
                    ultima_id = res;
                    llamada_ajax(url, (res) => {
                        document.getElementById(capa_contenido).innerHTML = res;
                    });
                }
                setTimeout(refrescar, segundos_refresco * 1000);
            });
        })();
    </script>
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
            <a href="tiempos_new.php?id=<?php echo $idCarrera; ?>&newBD=true" class="primary-btn text-uppercase selected">VOLVER</a>
            <a href="clas_final_new.php?id=<?php echo $idCarrera; ?>&copa=0" class="primary-btn text-uppercase selected">CLASIFICACI&Oacute;N FINAL</a>
        </div>
    </section>
    <div class="section-top-border">
        <table>
            <form>
                <tr>
                    <?php
                        // TODO Descomentar cuando se vaya a arreglar
                        /*
                        echo "<td>COPAS:</td><td><select name='copas' onchange='surfto2(this.form)'>";
                        //echo "<td>COPAS:</td><td><select name='copas'>";
                        $FiltroCopa = "SELECT c.descripcion,c.id FROM web_copas c 
    INNER JOIN web_campeonatos ca ON c.id = ca.id 
    WHERE ca.idcarrera='$idCarrera'";

                        $copas = $mysqli2->query($FiltroCopa);
                        if ($copa == '0') {
                            echo "<option selected='selected'>TODAS</option>";
                        } else {
                            echo "<option value='manga_new.php?id=" . $idCarrera . "&idmanga=" . $idManga . "&copa=0'>TODAS LAS COPAS</option>";
                        }
                        while ($row = $copas->fetch_array()) {
                            $filtroCopa = $row["id"];
                            $filtroDesc = $row["descripcion"];
                            $filtroDesc = str_replace('ESPAÃ‘A', 'ESPAÑA', $filtroDesc);
                            if ($filtroCopa == $copa) {
                                echo "<option selected='selected'>" . $filtroDesc . "</option>";
                                $nom_copa = $filtroDesc;
                            } else
                                echo "<option value='manga_new.php?id=" . $idCarrera . "&idmanga=" . $idManga . "&copa=" . $filtroCopa . "'>" . $filtroDesc . "</option>";
                        }

                        echo "<td>MANGAS:</td><td><select name='mangas' onchange='surfto(this.form)'>";
                        $sqlm = "SELECT wm.descripcion,wm.id FROM web_manga wm
                        INNER JOIN web_seccion ws ON ws.id = wm.id_ca_seccion 
                        INNER JOIN web_etapa we ON we.id = ws.id_ca_etapa
                        WHERE wm.tipo!=2 AND we.id_ca_carrera = '$idCarrera'";
                        //echo $sqlm;
                        $resultadok = $mysqli2->query($sqlm) or print "No se pudo acceder al contenido de los tiempos online.";
                        if ($resultadok->num_rows > 0) {
                            while ($fila = $resultadok->fetch_array()) {
                                $idManga2 = $fila['id'];
                                $desc = $fila['descripcion'];
                                if ($_GET['idmanga'] == $idManga2) {
                                    echo '<option selected="selected">' . $desc . '</option>';
                                } else {
                                    echo "<option value='manga_new.php?id=" . $idCarrera . "&idmanga=" . $idManga2 . "&copa=" . $_GET['copa'] . "'>" . $desc . "</option>";
                                }
                            }
                        }
                        echo "</select></td>";
                        */
                    ?>
                </tr>
            </form>
        </table>
        <hr><br>
        <div id='recarga'></div>
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