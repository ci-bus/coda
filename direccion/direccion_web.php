<?php
	session_start();
	include("valida2.php");
	include ("../conexion.php");	
	include('escudos.php');
	$pass = $_SESSION['pass'];
	$i=0;
	$j=0;
	$n=0;
	$k=0;
	$idCarrera = $_GET['id'];	
	$sql_titulo = $mysqli2->query("SELECT titulo FROM web_pruebas WHERE idcarrera = '$idCarrera'")->fetch_array();
		$tituloJS = $sql_titulo['titulo'];
	//$idManga = 560;
	//echo "<br>".$prueba."<br>";
	//lo primero es hacer la pedazo de consulta
	include_once("funcionesTiempos.php");//Para algunas funciones que hacen falta para los tiempos online
	//include_once("nombresTildes.php");//Para formatear los nombres, especialmente los de las pruebas creadas por el programa
	
	if(isset($_GET['copa']))
		$micopa = $_GET['copa'];
	else
		$micopa = 1;
		
	if(isset($_GET['manga']))
		$mimanga = $_GET['manga'];
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Cronometradores y Oficiales de Automovilismo" />
<title>C.O.D.A.  .:: Direcci&oacute;n de Carrera ::.</title>
<meta name="description" content="Cronometradores y Oficiales de Automovilismo" />
<meta name="keywords" content="Rally, Rallies, Cronometradores, Automovilismo, automovilista, carreras, carrera, tiempos online, tiempos on-line, tiempos en directo, coches, automoviles, rally, rallies, cronometradores, automovilismo" />
<link type="text/css" href="direccion.css" rel="stylesheet">
<link rel="shortcut icon" href="../normal/paginas/favicon.ico" />
		<script type="text/javascript" src=" https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
		<script>
/*$(document).ready(function () {
   $('.preloader').delay(4000).fadeOut('slow');
   $('.pre1').delay(1000).fadeOut('slow');
   $('.pre2').delay(2000).fadeOut('slow');
   $('.pre3').delay(3000).fadeOut('slow');
});*/
$(document).ready(function(){
//setInterval(loadpanel,4000);
//setInterval(loadatomic,1000);
//setInterval(loadatomic2,1000);
});
function loadpanel(){
$("#direccion_tiempos").load("dir_tiempos.php?manga=<?php echo $_GET['manga'];?>&modo=<?php echo $_GET['modo'];?>&id=<?php echo $idCarrera;?>");
}
 //FUNCINO NUEVA JQUERY ---------------CAMBIAR EN FUTURO LA VIEJA QUE RECARGA LOS PUTOS CUBOS

function loadatomic(){
$("#info").load("atomic.php");
}
function loadatomic2(){
//$("#info3").load("atomic.php");
}
	// Empieza la función de refrescar
   var seconds = 5; // el tiempo en que se refresca
	var divid = "direccion_tiempos"; // el div que quieres actualizar!
	var url = "dir_tiempos_web.php?manga=<?php echo $_GET['manga'];?>&modo=<?php echo $_GET['modo'];?>&id=<?php echo $idCarrera;?>"; // el archivo que ira en el div

	function refreshdiv(){

		// The XMLHttpRequest object

		var xmlHttp;
		try{
			xmlHttp=new XMLHttpRequest(); // Firefox, Opera 8.0+, Safari
		}
		catch (e){
			try{
				xmlHttp=new ActiveXObject("Msxml2.XMLHTTP"); // Internet Explorer
			}
			catch (e){
				try{
					xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				catch (e){
					alert("Tu explorador no soporta AJAX.");
					return false;
				}
			}
		}

		// Timestamp for preventing IE caching the GET request
		var timestamp = parseInt(new Date().getTime().toString().substring(0, 10));
		var nocacheurl = url+"&t="+timestamp;

		// The code...

		xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState== 4 && xmlHttp.readyState != null){
				document.getElementById(divid).innerHTML=xmlHttp.responseText;
				setTimeout('refreshdiv()',seconds*1000);
			}
		}
		xmlHttp.open("GET",nocacheurl,true);
		xmlHttp.send(null);
	}

	window.onload = function(){
		refreshdiv(); // corremos inmediatamente la funcion
	}

	function mostrar_piloto(datos){
		jQuery('#'+datos).css('visibility','visible');
	}
	function quitar_piloto(datos){
		jQuery('#'+datos).css('visibility','hidden');
	}
	function info(piloto,dorsal,vehiculo,modelo,copiloto){
		var piloto = piloto;
		var copiloto = copiloto;
		var dorsal = dorsal;
		var vehiculo = vehiculo;
		var modelo = modelo;
		$("#info").html("<span class='dorsal2'>D."+dorsal+"</span><p class='info'>"+piloto+"<br>"+copiloto+"<br>"+vehiculo+" "+modelo+"<p></p>");
		setTimeout(function(){$("#info").html(''); }, 10000);
	}
		</script>
</head>
<body>
<!--div class='preloader'>
<p class='pre1'>CARGANDO TRAMO....</p>
<p class='pre2'>CARGANDO INSCRITOS....</p>
<p class='pre3'>CARGANDO POSICIONES....</p>
</div-->	
	<?php
		if (!isset($_GET['orden']))
			{
			$orden="ORDER BY tiempo_salida ASC";
			//echo "<span class='orden'>HORA DE SALIDA | <a href='direccion.php&manga='".$mimanga."&copa='".$micopa"'&orden="'.$orden.'"'>HORA DE LLEGADA</a></span>";
			}
		else
			{
			$orden="ORDER BY tiempo_llegada ASC";
			//echo "<span class='orden'><a href='direccion.php&manga='".$mimanga."&copa='".$micopa"'&orden="'.$orden.'"'>HORA DE SALIDA</a> | HORA DE LLEGADA</span>";
			}
	?>
	</div>
<div id="todo">
	<div id="titulo">
        <?php
			$sql_manga  = $mysqli2->query("SELECT descripcion FROM web_manga WHERE id='".$_GET['manga']."'")->fetch_array();
			$titulo_manga = $con_man['descripcion'];
			echo "<span class='fuente3'>DIRECCI&Oacute;N DE CARRERA: ".$tituloJS."</span>";
		echo "<p class='fuente4'>".$titulo_manga."</p></div><div id='menu'>";
		?>
<div class="wrap">
<nav>
  <ul class="primary">
    <li>
      <a href="">COPAS</a>
      <ul class="sub">	
		
		<?php
		if ($_GET['copa'] =='1')
			echo "<li><a href='direccion_web.php?manga=".$_GET['manga']."&copa=1' class='sel'>TODAS</a></li>";
		else
			echo "<li><a href='direccion_web.php?manga=".$_GET['manga']."&copa=1' class='negro'>TODAS</a></li>";
		/*ESTO AHORA MISMO MUESTRA LAS COPAS*/
		$cons = $mysqli2->query("SELECT * FROM copas WHERE idcarreras='$prueba'");
		if($cons -> num_rows >0)
			{
				while($fila = $cons ->fetch_array())
				{
				$copa = $fila['descripcion'];	
				$idcopas = $fila['idcopas'];
				if(isset($_GET['manga']))
					{
					if ($idcopas == $_GET['copa'])
						echo "<li><a href='direccion_web.php?copa=".$idcopas."&manga=".$_GET['manga']."' class='sel'>".$copa."</a></li>";
					else
						echo "<li><a href='direccion_web.php?copa=".$idcopas."&manga=".$_GET['manga']."' class='negro'>".$copa."</a></li>";
					}
				else
					if ($idcopas == $_GET['copa'])
						echo "<li><a href='direccion_web.php?copa=".$idcopas."' class='sel'>".$copa."</a></li>";
					else
						echo "<li><a href='direccion_web.php?copa=".$idcopas."' class='negro'>".$copa."</a></li>";
				}
			}
		echo "</ul></li>";
		?>
 <li>
      <a href="">MANGAS</a>
      <ul class="sub">
		<?php
		$sqlm = "SELECT abc_57os_ca_manga.id AS idman,abc_57os_ca_manga.descripcion AS tramo,
abc_57os_ca_etapa.descripcion,abc_57os_ca_seccion.descripcion,abc_57os_ca_seccion.id AS idsec,
abc_57os_ca_etapa.id AS ideta 
FROM abc_57os_ca_etapa INNER JOIN abc_57os_ca_seccion ON abc_57os_ca_etapa.id=abc_57os_ca_seccion.id_ca_etapa 
INNER JOIN abc_57os_ca_manga ON abc_57os_ca_manga.id_ca_seccion=abc_57os_ca_seccion.id WHERE abc_57os_ca_etapa.id_ca_carrera = '$idCarrera'";
	$resultadok = $mysqli -> query ($sqlm) or print "No se pudo acceder al contenido de los tiempos online.";
	if ($resultadok ->num_rows > 0)
			{
			while($fila=$resultadok->fetch_array())
				{
				$idManga2 = $fila['idman'];
				$desc = $fila['tramo'];
				$ideta = $fila['ideta'];
				$idsec = $fila['idsec'];
				if($_GET['manga']==$idManga2)
					{
					$curso = $desc;
					//echo '<option selected="selected">'.$desc.'</option>';
					echo "<li><a href='direccion_web.php?manga=".$_GET['manga']."&id=".$idCarrera."' class='sel'>".$desc."</a></li>";
					}
				else{
					//echo "<option value='manga_new.php?id=".$idCarrera."&idetapa=".$ideta."&idmanga=".$idManga2."&idseccion=".$idsec."&newBD=true'>".$desc."</option>";
					echo "<li><a href='direccion_web.php?manga=".$idManga2."&id=".$idCarrera."' class='negro'>".$desc."</a></li>";
					}
				}
			}
		echo "</ul></li>";
		echo "<li><a href''>ORDEN</a><ul class='sub'><li><a href='direccion_web.php?id=".$idCarrera."&manga=".$idManga2."&modo=tiempo' class='sel'>TIEMPOS</a></li>
		<li><a href='direccion_web.php?id=".$idCarrera."&manga=".$idManga2."&modo=dorsal' class='negro'>DORSAL</a></li></ul></li>";
		echo "<li><a href='cerrar.php'>CERRAR SESION</a></li>";
		echo "</ul></nav></div></div><div id='salida'>SALIDA PRIMER DORSAL</div><div id='info'>";
		include ("atomic.php");
		echo "</div><div class='mangas'>".$curso."</div>";
		$coches_cero = $mysqli2->query("SELECT salida_primero FROM web_direccion2 WHERE idmanga = '$mimanga'");
		if($coches_cero->num_rows>0){
				while($myrow = $coches_cero->fetch_array()){
					$salida_primero = $myrow['salida_primero'];
				}
			$salida_milisegundos = $salida_primero.":00.000";
			$salida_milisegundos = tiempo_a_milisegundos($salida_milisegundos);
			$diferencia_000 = substr(milisegundos_a_tiempo($salida_milisegundos - tiempo_a_milisegundos("00:40:00.000")),0,-7);
			$diferencia_00 = substr(milisegundos_a_tiempo($salida_milisegundos - tiempo_a_milisegundos("00:20:00.000")),0,-7);
			$diferencia_0 = substr(milisegundos_a_tiempo($salida_milisegundos - tiempo_a_milisegundos("00:10:00.000")),0,-7);
			//echo $diferencia_000;
			echo "<div class='extra'>";
			echo "<p class='nomargen'><span class='ceros'>HORA SALIDA 000: </span><span class='horas'>".$diferencia_000."</span></p>";
			echo "<p class='nomargen'><span class='ceros'>HORA SALIDA 00: </span><span class='horas'>".$diferencia_00."</span></p>";
			echo "<p class='nomargen'><span class='ceros'>HORA SALIDA 0: </span><span class='horas'>".$diferencia_0."</span></p>";
			echo "<p class='nomargen'><span class='ceros'>HORA SALIDA 1º: </span><span class='horas'>".substr(milisegundos_a_tiempo($salida_milisegundos),0,-7)."</span></p>";
			echo "</div>";
			}
		echo "<div id='direccion_tiempos'>";
		include("dir_tiempos_web.php");
	?>
</div>
</div>
</body>
</html>

