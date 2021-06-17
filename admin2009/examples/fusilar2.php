<!DOCTYPE html>
<?php
include("../../conexion.php");
$idcarrera = $_GET['id'];
?>
<html lang="en">
<title>FUSILAR PRUEBA</title>

<head>
  <style>
    body {
      background: #000;
    }

    .verde {
      color: #00FF00;
    }

    .sindisplay {
      display: none;
    }

    .mensaje1 {
      display: none;
    }

    .mensaje2 {}
  </style>
  <script>
    function acorrer() {
      var mensaje = mensaje;
      document.querySelector("#mensaje1").style.display = "block";
    }
    acorrer();
  </script>
</head>
</body>
<h5 class="verde">FUSILANDO PRUEBA EN LA BD WEB ( NO AFECTA A SISTEMA)</h5>
<p class='verde' id="mensaje0">BORRANDO TIEMPOS DE B.D WEB</p>
<?php
$mysqli2->query("DELETE FROM web_tiempos WHERE idcarrera = '$idcarrera'");
if ($mysqli2)
  echo "BORRADOS";
  ?>
<p class='verde sindisplay' id="mensaje1">BORRANDO ABANDONOS</p>
<p class='verde sindisplay' id="mensaje2">BORRANDO ARCHIVOS DE TABLON</p>
<p class='verde sindisplay' name="mensaje3">BORRANDO CAMPEONATOS</p>
<p class='verde sindisplay' name="mensaje4">BORRANDO INSCRITOS A CAMPEONATOS</p>
<!--p class='verde'>BORRANDO COPAS</p>
<p class='verde'>BORRANDO INSCRITOS A COPAS</p>
<p class='verde'>BORRANDO MANGAS</p>
<p class='verde'>BORRANDO ETAPAS</p>
<p class='verde'>BORRANDO SECCIONES</p>
<p class='verde'>BORRANDO LISTA DE INSCRITOS</p-->
<?php
$open = fopen("../../datosweb_ultima_id","w+"); 
fwrite($open, '0'); 
fclose($open); 
echo "<p class='verde'>PONIENDO A 0 DATOSWEB.......</p>"
?>
</body>

</html>