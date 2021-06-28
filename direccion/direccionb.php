<?php
	session_start();
	include("valida2.php");
	$IPservidor = "localhost";
	$nombreBD = "codea_es_sistema";
	$usuario = "manuel";
	$clave = "coda200900==";
$conexion = mysql_connect($IPservidor, $usuario, $clave) or die("<h2>No hay conexi&oacute;n con el servidor MySQL</h2>");
mysql_query ("SET NAMES 'utf8'");
mysql_select_db($nombreBD) or die('no se encontro la bd');
	include('escudos.php');
	$pass = $_SESSION['pass'];
	//echo $pass;
	$i=0;
	$j=0;
	$n=0;
	$k=0;
				$prueba = $_GET['id'];	
	$dbQuery = "SELECT nombre FROM abc_57os_ca_carrera WHERE id = '$prueba'";
		$resultado = mysql_query($dbQuery);
		if (mysql_num_rows($resultado) != 0){
			$tituloJS = @mysql_result($resultado, 0, "nombre");
		}
	$idCarrera = $prueba;
	//$idManga = 560;
	//echo "<br>".$prueba."<br>";
	//lo primero es hacer la pedazo de consulta
	//include_once("funcionesTiempos.php");//Para algunas funciones que hacen falta para los tiempos online
	//include_once("nombresTildes.php");//Para formatear los nombres, especialmente los de las pruebas creadas por el programa
	
	if(isset($_GET['copa']))
		$micopa = $_GET['copa'];
	else
		$micopa = 1;
		
	if(isset($_GET['manga']))
		$mimanga = $_GET['manga'];
	function atomicTime()
	{
    /*** connect to the atomic clock ***/
    $fp = @fsockopen( "time-a.nist.gov", 37, $errno, $errstr, 10 );
    if ( !$fp )
    {
        throw new Exception( "$errno: $errstr" );
    }
    else
    { 
        fputs($fp, "\n"); 
        $time_info = fread($fp, 49);
        fclose($fp);
    }
    /*** create the timestamp ***/
    $atomic_time = (abs(hexdec('7fffffff') - hexdec(bin2hex($time_info)) - hexdec('7fffffff')) - 2208988800); 
    echo $errstr;
    return $atomic_time;
	}

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
		 /*Esta es la famosa recarga automatica de evento, en este caso la usaremos de forma general*/
   var seconds = 10; // el tiempo en que se refresca
	var divid = "direccion_tiempos"; // el div que quieres actualizar!
	var url = "dir_tiemposb.php?manga=<?php echo $_GET['manga'];?>&modo=<?php echo $_GET['modo'];?>&id=<?php echo $prueba;?>"; // el archivo que ira en el div
var seconds2 = 1; // el tiempo en que se refresca
	var divid2 = "atomic"; // el div que quieres actualizar!
	var url2 = "atomic.php"; // el archivo que ira en el div
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
function refreshdiv2(){

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
		var timestamp2 = parseInt(new Date().getTime().toString().substring(0, 10));
		var nocacheurl2 = url2+"&t="+timestamp2;

		// The code...

		xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState== 4 && xmlHttp.readyState != null){
				document.getElementById(divid2).innerHTML=xmlHttp.responseText;
				setTimeout('refreshdiv2()',seconds*1000);
			}
		}
		xmlHttp.open("GET",nocacheurl,true);
		xmlHttp.send(null);
	}
	// Empieza la función de refrescar

	window.onload = function(){
		refreshdiv(); // corremos inmediatamente la funcion
		refreshdiv2(); // corremos inmediatamente la funcion
	}
	function mostrar_piloto(datos){
		jQuery('#'+datos).css('visibility','visible');
	}
	function quitar_piloto(datos){
		jQuery('#'+datos).css('visibility','hidden');
	}
		</script>
</head>
<body>
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
			$con_man = mysql_query("SELECT descripcion FROM manga WHERE id='".$_GET['manga']."'");
			$titulo_manga = @mysql_result($con_man, 0, "descripcion");
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
			echo "<li><a href='direccion.php?manga=".$_GET['manga']."&copa=1' class='sel'>TODAS</a></li>";
		else
			echo "<li><a href='direccion.php?manga=".$_GET['manga']."&copa=1' class='negro'>TODAS</a></li>";
		/*ESTO AHORA MISMO MUESTRA LAS COPAS*/
		$cons = mysql_query("SELECT * FROM copas WHERE idcarreras='$prueba'");
		if(mysql_num_rows($cons)>0)
			{
				while($fila = mysql_fetch_array($cons))
				{
				$copa = $fila['descripcion'];	
				$idcopas = $fila['idcopas'];
				if(isset($_GET['manga']))
					{
					if ($idcopas == $_GET['copa'])
						echo "<li><a href='direccion.php?copa=".$idcopas."&manga=".$_GET['manga']."' class='sel'>".$copa."</a></li>";
					else
						echo "<li><a href='direccion.php?copa=".$idcopas."&manga=".$_GET['manga']."' class='negro'>".$copa."</a></li>";
					}
				else
					if ($idcopas == $_GET['copa'])
						echo "<li><a href='direccion.php?copa=".$idcopas."' class='sel'>".$copa."</a></li>";
					else
						echo "<li><a href='direccion.php?copa=".$idcopas."' class='negro'>".$copa."</a></li>";
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
	$resultadok = mysql_query($sqlm) or print "No se pudo acceder al contenido de los tiempos online.";
	if (mysql_num_rows($resultadok) > 0)
			{
			while($fila=mysql_fetch_array($resultadok))
				{
				$idManga2 = $fila['idman'];
				$desc = $fila['tramo'];
				$ideta = $fila['ideta'];
				$idsec = $fila['idsec'];
				if($_GET['manga']==$idManga2)
					{
					//echo '<option selected="selected">'.$desc.'</option>';
					echo "<li><a href='direccion.php?manga=".$idmanga."&id=".$idCarrera."' class='sel'>".$desc."</a></li>";
					}
				else{
					//echo "<option value='manga_new.php?id=".$idCarrera."&idetapa=".$ideta."&idmanga=".$idManga2."&idseccion=".$idsec."&newBD=true'>".$desc."</option>";
					echo "<li><a href='direccion.php?manga=".$idManga2."&id=".$idCarrera."' class='negro'>".$desc."</a></li>";
					}
				}
			}
		echo "</ul></li>";
		echo "<li><a href''>ORDEN</a><ul class='sub'><li><a href='direccion.php?id=".$idCarrera."&manga=".$idManga2."&modo=tiempo' class='sel'>TIEMPOS</a></li>
		<li><a href='direccion.php?id=".$idCarrera."&manga=".$idManga2."&modo=dorsal' class='negro'>DORSAL</a></li></ul></li>";
		echo "<li><a href='cerrar.php'>CERRAR SESION</a></li>";
		echo "</ul></nav></div></div><div id='direccion_tiempos'>";
		include("dir_tiempos.php");
	?>
<div id="atomic">
	<?php
	include("atomic.php");
	?>
</div>
</div>
</div>
</body>
</html>

