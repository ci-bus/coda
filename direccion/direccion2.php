<?php
	session_start();
	include("valida2.php");
	include('conexion.php');
	include('escudos.php');
	$pass = $_SESSION['pass'];
	//echo $pass;
	$i=0;
	$j=0;
	$n=0;
	$k=0;
		$sql = mysql_query("SELECT id_prueba FROM direccion WHERE pass='$pass'");
			if(mysql_num_rows($sql)>0)
			{
				while($fila = mysql_fetch_array($sql))
				{
				$prueba = $fila['id_prueba'];	
				}
			}
	$dbQuery = "SELECT titulo FROM carreras WHERE idcarreras = '$prueba' AND (desactivada = '0' OR desactivada IS NULL) ORDER BY fecha DESC";
		$resultado = mysql_query($dbQuery);
		if (mysql_num_rows($resultado) != 0){
			$tituloJS = @mysql_result($resultado, 0, "titulo");
		}
	$idCarrera = $prueba;
	//$idManga = 560;
	//echo "<br>".$prueba."<br>";
	//lo primero es hacer la pedazo de consulta
	include_once("funcionesTiempos.php");//Para algunas funciones que hacen falta para los tiempos online
	include_once("nombresTildes.php");//Para formatear los nombres, especialmente los de las pruebas creadas por el programa
	
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
		 /*Esta es la famosa recarga automatica de evento, en este caso la usaremos de forma general*/
   var seconds = 55; // el tiempo en que se refresca
	var divid = "direccion_tiempos"; // el div que quieres actualizar!
	var url = "dir_tiempos.php?manga=<?php echo $_GET['manga'];?>&copa=<?php echo $_GET['copa'];?>&prueba=<?php echo $prueba;?>"; // el archivo que ira en el div

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

	// Empieza la función de refrescar

	window.onload = function(){
		refreshdiv(); // corremos inmediatamente la funcion
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
<p><a href="cerrar.php">CERRAR SESION</a></p>
<?php
		if (!isset($_GET['orden']))
			{
			$orden= 1;
			echo "esta seria la pagina de direccion2.php; AKI he recibido la varioable de orden";
			echo "<span class='orden'>HORA DE SALIDA | <a href='direccion2.php?orden=".$orden."&manga=".$mimanga."&copa=".$micopa."'>HORA DE LLEGADA</a></span>";
			}
		else
			{
			//$orden="ORDER BY tiempo_salida ASC";
			echo "<span class='orden'><a href='direccion2.php?manga=".$mimanga."&copa=".$micopa."'>HORA DE SALIDA</a> | HORA DE LLEGADA</span>";
			}
	?>
<div id="todo">
	<div id="titulo">
        <?php
		echo "DIRECCI&Oacute;N DE CARRERA: ".$tituloJS;
		echo "</div><div id='menu'>Copas: <ul>";
		if ($_GET['copa'] =='1')
			echo "<li class='marcada'><a href='direccion2.php?manga=".$_GET['manga']."&copa=1'>TODAS</a></li>";
		else
			echo "<li class='estilo1'><a href='direccion2.php?manga=".$_GET['manga']."&copa=1'>TODAS</a></li>";
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
						echo "<li class='marcada'><a href='direccion2.php?copa=".$idcopas."&manga=".$_GET['manga']."'>".$copa."</a></li>";
					else
						echo "<li class='estilo1'><a href='direccion2.php?copa=".$idcopas."&manga=".$_GET['manga']."'>".$copa."</a></li>";
					}
				else
					if ($idcopas == $_GET['copa'])
						echo "<li class='marcada'><a href='direccion2.php?copa=".$idcopas."'>".$copa."</a></li>";
					else
						echo "<li class='estilo1'><a href='direccion2.php?copa=".$idcopas."'>".$copa."</a></li>";
				}
			}
		echo "</ul></div><div id='menu2'>Mangas:<ul>";
		$query_copas = "select idmangas, descripcion, orden, longitud from mangas where idcarreras = $idCarrera order by orden asc";
        $resultado = mysql_query($query_copas) or print 'No se puede acceder a las copas';
        if (mysql_num_rows($resultado) != 0)
        {
            while($fila=mysql_fetch_array($resultado)){
                $idmanga = $fila["idmangas"];
                $descripcion = $fila["descripcion"];
                $longitud = $fila["longitud"];
                $orden = $fila["orden"];
				if(isset($_GET['manga']) && $_GET['manga']==$idmanga)
					echo "<li class='marcada'><a href='direccion2.php?manga=".$idmanga."&copa=1'>".$descripcion."</a></li>";
				else
					echo "<li class='estilo1'><a href='direccion2.php?manga=".$idmanga."&copa=".$_GET['copa']."'>".$descripcion."</a></li>";
                //echo "<option value=\"$idmanga\">$descripcion</option>";
	
            }
        }
		echo "</ul></div><div id='direccion_tiempos'>";
		include("dir_tiempos2.php");
	?>
</div>
</div>
</body>
</html>

