<?php
//include('conexion.php') or print('error en acceso menu_gal en B.D');
$IPservidor = "localhost";
$nombreBD = "coda";
$usuario = "manuel";
$clave = "coda200900==";
$conexion = mysql_connect($IPservidor, $usuario, $clave) or die("<h2>No hay conexi&oacute;n con el servidor MySQL.'conexion.php'</h2>");
mysql_query ("SET NAMES 'utf8'");
mysql_select_db($nombreBD) or die('no se encontro la bd');
$sql = mysql_query("SELECT titulo,id_galeria FROM galeria_imagenes order by id_galeria DESC limit 8") or die('ERROR');

		while($fila=mysql_fetch_array($sql)){
			$titulo= $fila['titulo'];
			$idgaleria = $fila['id_galeria'];
					if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
						echo "<li><a href='galerias.php?idgaleria=".$idgaleria."&lang=0'>".$titulo."</a></li>";
					else
						echo "<li><a href='galerias.php?idgaleria=".$idgaleria."&lang=1'>".$titulo."</a></li>";
					}
?>