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
	//echo "<a href='#s2'>Ver tabl&oacute;n de anuncios</a>";
	//$descripcion=nl2br($descripcion);//Convierte los saltos de línea en <br />
	echo "<div id='pru_con1'>";
	if($imagen!='' && $imagen!=NULL){//hay alguna ruta de imagen en la bd
		list($width, $height) = getimagesize("../../../".$imagen);
			if($width > $height)
				echo "<div id='pru_img2'><img src='../../../".$imagen."' alt='Imagen de la prueba'/></div>";
			else
				echo "<div id='pru_img'><img src='../../../".$imagen."' alt='Imagen de la prueba'/></div>";
	}
	if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
		{
		echo "<div id='botones'><div class='fecha'>".$fecha_larga."</div><a href='tiempos_grupos.php?grupo=".$grupo."&lang=0'><div class='boton1'>TIEMPOS ONLINE</div>";
		echo "<a href='#s2'><div class='boton13'>ver tablon de anuncios</div></a>";
		}
	else{	
		echo "<div id='botones'><div class='fecha'>".$fecha_larga."</div><a href='tiempos_grupos.php?grupo=".$grupo."&lang=1'><div class='boton1'>ONLINE TIMES</div>";
		echo "<a href='#s2'><div class='boton13'>Notice Board</div></a>";
		}
		/*<div class='boton11' onclick='secretario(this.id)' id='boton11'>Acceso Secretarios</div><div id='for_sec'>PASSWORD:
		<form class='form1'>
			<input type='password'>
			<input type='submit' value='acceder' class='submit'>
			</form>
		</div>";
		echo "<div id='tiempo'>";
	$consql = mysql_query("SELECT tp.id_tiempo,t.codigo FROM tiempo_prueba tp INNER JOIN tiempo t WHERE tp.idWeb='$idWeb' and tp.id_tiempo=t.id_tiempo");
		if (mysql_num_rows($consql) > 0){
		while($fila=mysql_fetch_array($consql)){
			$codigo = $fila['codigo'];
			}
		echo $codigo;
		}
		
	echo "</div>";*/
	echo "</div></div>";
	/*if($descripcion!='')
		{
		if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
			echo "<div id='pru_des'><span class='negrita'>Enlaces:</span><br><br>".$descripcion."</div>";
		else
			echo "<div id='pru_des'><span class='negrita'>Links:</span><br><br>".$descripcion."</div>";
		}
	//echo "<div id='tiempos'><a href='#' target='_self'><img src='../imagenes/cronoT.png' alt='crono' /><br />Tiempos Online</a></div>";
	echo "</div><br><section id='s2'>";
	//echo "<p class='men1'></p>";/*SEPARADOR*/
	//TABLÓN DE ANUNCIOS
	if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
		{
		echo "<div id='pru_con2'><p class='titulo' style='margin-bottom:30px'>Tablon de anuncios</p>";
		echo "<table id='tabla2'><thead><tr><th width='50%'>Informaci&oacute;n Previa</th><th>Informaci&oacute;n de Carrera</th></tr></thead><tbody><tr><td valign='top'>";	
		}
	else{
		echo "<div id='pru_con2'><p class='titulo' style='margin-bottom:30px'>Notice Board</p>";
		echo "<table id='tabla2'><thead><tr><th width='50%'>Prior information</th><th>Race Information</th></tr></thead><tbody><tr><td valign='top'>";	
		}
		/*
		$dbcarreras = mysql_query("SELECT idcarreras FROM carreras WHERE idGrupo = $grupo");
			if (mysql_num_rows($dbcarreras) > 0)
				{
				while($fil=mysql_fetch_array($dbcarreras))
					{
					$cons = $cons.$fil['idcarreras']." || ";
					}
				}
			echo $cons;*/
		$dbQuery = "SELECT c.idcarreras,i.titulo,i.archivo FROM carreras c INNER JOIN infoprevia i ON i.idcarreras=c.idcarreras  WHERE c.idGrupo = '$grupo' AND i.activo='1' ORDER BY idInfo";
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
		echo "</td>";
		}
			echo "<td valign='top'>";
		$dbQuery = "SELECT c.idcarreras,i.titulo,i.archivo FROM carreras c INNER JOIN infocarrera i ON i.idcarreras=c.idcarreras  WHERE c.idGrupo = '$grupo' AND i.activo='1' ORDER BY idInfo";
		$resultado = mysql_query($dbQuery) or print "No se pudo acceder al contenido.";
		if (mysql_num_rows($resultado) > 0){
		while($fila=mysql_fetch_array($resultado)){
			$titulo = $fila["titulo"];
			$archivo = $fila["archivo"];
			if($archivo!="" && $archivo!=NULL){//Si hay archivo
				include('extension.php');
				echo "<a href='../../../".$archivo."' target='_blank'><p class='boton2'><img src='".$img."'>".$titulo."</p></a>";
				/*echo "<a href='../".$archivo."' target='_blank'>".$titulo."</a>";*/
			}
		}

		}
		
			echo "</td></tr></tbody></table>";
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