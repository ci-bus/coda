<?php
/*MODIFICO PARA QUE MUESTRE GRUPOS DE PRUEBAS*/
include('nombresTildes.php');
if(isset($_GET['grupo']))
	{
	$grupo = $_GET['grupo'];
	//echo "GRUPO--".$grupo;
	$dqsql = mysql_query("SELECT * from grupos WHERE idGrupo= $grupo") OR PRINT('error buscando los grupos');
		if(mysql_num_rows($dqsql) > 0)
		{
		$organizador = @mysql_result($dqsql, 0, "organizador");
		$fecha = @mysql_result($dqsql, 0, "fecha");
		$temporada = @mysql_result($dqsql, 0, "temporada");
		$titulo = @mysql_result($dqsql, 0, "titulo");
		$imagen = @mysql_result($dqsql, 0, "imagen");
		$fecha_larga = @mysql_result($dqsql, 0, "fecha_larga");
		}
	echo "<p class='menus1'>".nombresTildes($titulo)."</p>";
	echo "<div id='pru_con1'>";
	if($imagen!='' && $imagen!=NULL){//hay alguna ruta de imagen en la bd y la orientacion
		list($width, $height) = getimagesize("../../../".$imagen);
			if($width > $height)
				echo "<div id='pru_img4'><img src='../../..".$imagen."' alt='Imagen de la prueba'/></div>";
			else
				echo "<div id='pru_img3'><img src='../../..".$imagen."' alt='Imagen de la prueba'/></div>";
	}
	echo "</div>";
	if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
		echo "<div id='pru_pun'><p class='titulo'>PRUEBAS PUNTUABLES</p>";
	else
		echo "<div id='pru_pun'><p class='titulo'>RACES POINTS</p>";
	$dbQuery = "SELECT c.titulo,c.idcarreras,c.idWeb FROM carreras c INNER JOIN pruebas_especiales pe ON c.idGrupo=pe.idGrupo WHERE c.idGrupo = '$grupo' ORDER BY c.idcarreras";
		$resultado = mysql_query($dbQuery) or print "No se pudo acceder al contenido.";
		if (mysql_num_rows($resultado) > 0){
		while($fila=mysql_fetch_array($resultado)){
			$titulo = $fila["titulo"];
			$idcarreras = $fila["idcarreras"];
			$idWeb = $fila["idWeb"];
				if($idWeb > 0 || $idWeb!=NULL)
					echo "<a href='prueba.php?&idWeb=".$idWeb."'><p class='boton3'>".$titulo."</p></a>";
				else
					echo "<a href='prueba.php?pruebaprograma=".$idcarreras."'><p class='boton3'>".$titulo."</p></a>";
				}

		}
	echo "</div>";

	echo "</div><br><section id='s2'>";
	//TABLÓN DE ANUNCIOS; --> AHORA INFORMACION ESPECIFICA DE LA COPA <--
	if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
		{
		echo "<div id='pru_con3'><p class='titulo' style='margin-bottom:30px'>Informaci&oacute;n de Copa</p>";	
		}
	else{
		echo "<div id='pru_con2'><p class='titulo' style='margin-bottom:30px'>Cup information</p>";
		}

		$dbQuery = "SELECT titulo,archivo FROM infocopa WHERE idGrupo = '$grupo' AND activo='1' ORDER BY idinfo";
		$resultado = mysql_query($dbQuery) or print "No se pudo acceder al contenido.";
		if (mysql_num_rows($resultado) > 0){
		while($fila=mysql_fetch_array($resultado)){
			$titulo = $fila["titulo"];
			$archivo = $fila["archivo"];
			if($archivo!="" && $archivo!=NULL){//Si hay archivo
				/*CReAR CONDICION PARA EXTENSION DE ARCHIVO CON CADENA DE EXTENSION PHP*/
				include('extension.php');
				echo "<a href='../../../".$archivo."' target='_blank'><p class='boton2'><img src='".$img."'>".$titulo."</p></a>";
			}
		}

		}

		echo "</div></section>";
	////FIN TABLÓN DE ANUNCIOS
	//mapa de Google maps
	if($mapa!='' && $mapa!=NULL){//Si hay algún mapa en la BD
		if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
			echo "<div class='mapa'><h2>Mapa del lugar</h2>".$mapa."</div>";
		else
			echo "<div class='mapa'><h2>Location Map</h2>".$mapa."</div>";
	}
	echo "<p class='men1'></p>";
	echo "</div>";
	}
	?>