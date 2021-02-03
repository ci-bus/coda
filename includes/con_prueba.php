<?php

/*RETOMO EL CODIGO DEL AMIGO DE MANOLO, LE INCLUYO LOS NUEVOS ESTILOS, HTML5 Y AJAX
	POR SUPUESTO NO TOCO NADA PARA QUE SIGA FUNCIONANDO EL PROGRAMA*/
include('nombresTildes.php');
if(isset($_GET["pruebaweb"])){//En el caso de pruebas creadas a través de la WEB
	$idWeb = $_GET["pruebaweb"];
if(is_numeric($idWeb)){
include ("conexion.php");
$dbQuery = "SELECT descripcion, fecha_larga, idWeb, titulo, imagen, mapa FROM carreras WHERE idWeb = $idWeb AND desactivada = '0'";
$resultado = mysql_query($dbQuery) or print "No se pudo acceder al contenido.";
if(mysql_num_rows($resultado) > 0){
	$descripcion = @mysql_result($resultado, 0, "descripcion");
	$fecha = @mysql_result($resultado, 0, "fecha_larga");
	$idWeb = @mysql_result($resultado, 0, "idWeb");
	$titulo = @mysql_result($resultado, 0, "titulo");
	$imagen = @mysql_result($resultado, 0, "imagen");
	$mapa = @mysql_result($resultado, 0, "mapa");
	/*CONDICION nueva para ventana de SEGURIDAD, ahora mismo solo para la prueba de UGIJAR, idweb 62*/
		if($idWeb == 65 || $idWeb=='65')
			{
			echo "<div id='seguridad'><p><a href='http://codea.es/codea/normal/images/consejosseguridad3.jpg' target='_blank'><span class='seg_izq'>AMPLIAR</a></span><span class='seg_der' onclick='seg_cerrar()'>CERRAR</span></p>";
			echo "<p class='seg_cerrar'>ESTA VENTANA SE CERRAR&Aacute; EN <span id='cuenta'> </span> SEGUNDOS</p><div id='seg_den'><img src='../images/consejosseguridad3.jpg'></div></div>";
			echo "<script> updateReloj();</script>";
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
		echo "<div id='botones'><div class='fecha'>".$fecha."</div><a href='#'><div class='boton12'>No Disponible Tiempo online desde Codea.es (ver enlaces)</div>";
		echo "<a href='#s2'><div class='boton13'>ver tablon de anuncios</div></a>";
		}
	else{	
		echo "<div id='botones'><div class='fecha'>".$fecha."</div><a href='#'><div class='boton12'>Online Times not avaliable by CODEA.ES (see links)</div>";
		echo "<a href='#s2'><div class='boton13'>Notice Board</div></a>";
		}
		/*<div class='boton11' onclick='secretario(this.id)' id='boton11'>Acceso Secretarios</div><div id='for_sec'>PASSWORD:
		<form class='form1'>
			<input type='password'>
			<input type='submit' value='acceder' class='submit'>
			</form>
		</div>";*/
		echo "<div id='tiempo'>";
	$consql = mysql_query("SELECT tp.id_tiempo,t.codigo FROM tiempo_prueba tp INNER JOIN tiempo t WHERE tp.idWeb='$idWeb' and tp.id_tiempo=t.id_tiempo");
		if (mysql_num_rows($consql) > 0){
		while($fila=mysql_fetch_array($consql))
			{
			$codigo = $fila['codigo'];
			}
			if($codigo!='' || !empty($codigo))
				echo $codigo;
		}
		
	echo "</div>";
	echo "</div></div>";
		if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
			echo "<div id='pru_des'><span class='negrita'>Enlaces:</span><br><br>".$descripcion."</div>";
		else
			echo "<div id='pru_des'><span class='negrita'>Links:</span><br><br>".$descripcion."</div>";
	//echo "<div id='tiempos'><a href='#' target='_self'><img src='../imagenes/cronoT.png' alt='crono' /><br />Tiempos Online</a></div>";
	echo "</div><br><section id='s2'>";
	//echo "<p class='men1'></p>";/*SEPARADOR*/
	//TABLÓN DE ANUNCIOS
	if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
		{
		echo "<div id='pru_con2'><p class='titulo' style='margin-bottom:30px'>Tablon de anuncios</p>";
		echo "<table id='tabla2'><thead><tr><th width='50%'>Informaci&oacute;n Previa</th><th>";
			if($_GET['pruebaweb']=='62')
				echo "Pruebas Puntuables</th></tr></thead><tbody><tr><td valign='top'>";	
			else
				echo "Informaci&oacute;n de Carrera</th></tr></thead><tbody><tr><td valign='top'>";	
		}
	else{
		echo "<div id='pru_con2'><p class='titulo' style='margin-bottom:30px'>Notice Board</p>";
		echo "<table id='tabla2'><thead><tr><th width='50%'>Prior information</th><th>Race Information</th></tr></thead><tbody><tr><td valign='top'>";	
		}
		$dbQuery = "SELECT idWeb, idInfo, titulo, archivo FROM infoprevia WHERE idWeb = $idWeb AND activo = '1' ORDER BY idInfo";
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
		$dbQuery = "SELECT idWeb, idInfo, titulo, archivo FROM infocarrera WHERE idWeb = $idWeb AND activo = '1' ORDER BY idInfo";
		$resultado = mysql_query($dbQuery) or print "No se pudo acceder al contenido.";
		if ($_GET['pruebaweb']=='62')
			{	
				echo "<p class='boton2'><a href='http://www.codea.es/codea/normal/paginas/prueba.php?pruebaprograma=199&lang=0'>SOMONTIN</a></p>";
				echo "<p class='boton2'><a href='http://codea.es/codea/normal/paginas/tiempos_grupos.php?grupo=32&lang=0'>CANTORIA</a></p>";
			}
		 else{
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
else {
	echo "<h2>No se obtuvo ninguna informaci&oacute;n de la Base de Datos.</h2>";
}
mysql_free_result($resultado);
mysql_close($conexion);
}
else
	echo "<h2>No se detect&oacute; ninguna acci&oacute;n valida en la url.</h2>";
}
/*  HASTA AKI REVISADO FALTA LO DE ABAJO, PARA LAS PRUEBAS CREADAS DESDE EL PROGRAMA  */
else if(isset($_GET["pruebaprograma"])){//En el caso de pruebas creadas a través del PROGRAMA
	$idCarrera = $_GET["pruebaprograma"];
if(isset($idCarrera)){
include ("conexion.php");
//idcarreras, descripcion, fecha_larga, estado, tipo_carrera, tipo_informe, modo_tiempos, temporada, organizador, fecha, idWeb, titulo, poblacion, desactivada, imagen
$dbQuery = "SELECT idcarreras, descripcion, fecha_larga, titulo, imagen, mapa FROM carreras WHERE idcarreras = '$idCarrera' AND (desactivada = '0' OR desactivada IS NULL)";
$resultado = mysql_query($dbQuery) or print "No se pudo acceder al contenido.";
if(mysql_num_rows($resultado) > 0){

	$idCarrera = @mysql_result($resultado, 0, "idCarreras");
	$descripcion = @mysql_result($resultado, 0, "descripcion");
	$fecha = @mysql_result($resultado, 0, "fecha_larga");
	$titulo = @mysql_result($resultado, 0, "titulo");
	$imagen = @mysql_result($resultado, 0, "imagen");
	$mapa = @mysql_result($resultado, 0, "mapa");
	$descripcion = utf8_encode(strtoupper($descripcion));//La paso a mayusculas y corrigo las tildes y eñes
	echo "<p class='menus1'>".nombresTildes($titulo)."</p>";
	$descripcion=nl2br($descripcion);//Convierte los saltos de línea en <br />
	echo "<div id='pru_con1'>";
	if($imagen!='' && $imagen!=NULL){//hay alguna ruta de imagen en la bd
		list($width, $height) = getimagesize("../../../".$imagen);
			if($width > $height)
				echo "<div id='pru_img2'><img src='../../../".$imagen."' alt='Imagen de la prueba'/></div>";
			else
				echo "<div id='pru_img'><img src='../../../".$imagen."' alt='Imagen de la prueba'/></div>";
	}
	echo "<div id='botones'><div class='fecha'>".$fecha."</div>";
		if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
				echo "<a href='tiempos.php?pruebaprograma=".$idCarrera."&lang=0'><div class='boton1'>ver tiempos online</div></a>";
		else
				echo "<a href='tiempos.php?pruebaprograma=".$idCarrera."&lang=1'><div class='boton1'>online times</div></a>";
		if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
				echo "<a href='#s2'><div class='boton13'>ver tablon de anuncios</div></a>";
		else
			echo "<a href='#s2'><div class='boton13'>notice board</div></a>";
		/*<div class='boton11' onclick='secretario(this.id)' id='boton11'>Acceso Secretarios</div><div id='for_sec'>PASSWORD:
		<form class='form1'>
			<input type='password'>
			<input type='submit' value='acceder' class='submit'>
			</form>
		</div>";*/
	echo "<div id='tiempo'>";
	$consql = mysql_query("SELECT tp.id_tiempo,t.codigo FROM tiempo_prueba tp INNER JOIN tiempo t WHERE tp.idCarrera='$idCarrera' AND tp.idCarrera!='0' and tp.id_tiempo=t.id_tiempo");
		if (mysql_num_rows($consql) > 0){
		while($fila=mysql_fetch_array($consql)){
			$codigo = $fila['codigo'];
			}
		echo $codigo;
		}
		
	echo "</div>";
	echo "</div></div><br><br><br><br><br>";
	//echo "<div id='pru_des'><span class='negrita'>Descripci&oacute;n:</span><br><br>".$descripcion."</div>";
	//echo "<div id='tiempos'><a href='#' target='_self'><img src='../imagenes/cronoT.png' alt='crono' /><br />Tiempos Online</a></div>";
	echo "</div><section id='s2'>";
	//TABLÓN DE ANUNCIOS
	if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
		echo "<div id='pru_con2'><p class='titulo' style='margin-bottom:30px'>Tablon de anuncios</p>";
	else
		echo "<div id='pru_con2'><p class='titulo' style='margin-bottom:30px'>Notice board</p>";
		if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
			echo "<table id='tabla2'><thead><tr><th width='50%'>Informaci&oacute;n Previa</th><th>Informaci&oacute;n de Carrera</th></tr></thead><tbody><tr><td valign='top'>";		
		else
			echo "<table id='tabla2'><thead><tr><th width='50%'>prior information</th><th>Race information</th></tr></thead><tbody><tr><td valign='top'>";		
		$dbQuery = "SELECT idcarreras, idInfo, titulo, archivo FROM infoprevia WHERE idcarreras = '$idCarrera' AND idcarreras!= '0' AND activo = '1' ORDER BY idInfo";
		$resultado = mysql_query($dbQuery) or print "No se pudo acceder al contenido.";
		if (mysql_num_rows($resultado) > 0){
		//echo "<div id='documentos'>";
		while($fila=mysql_fetch_array($resultado)){
			//$idCarrera = $fila["idcarreras"];// Ya lo tengo
			//$idInfo = $fila["idInfo"];// No lo uso
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
		/*$dbQuery = "SELECT idcarreras, idInfo, titulo, archivo FROM infocarrera WHERE idcarreras = '$idCarrera' AND activo = '1' ORDER BY idInfo";
		$resultado = mysql_query($dbQuery) or print "No se pudo acceder al contenido.";
		if (mysql_num_rows($resultado) > 0){
		//echo "<div id='documentos'>";
		while($fila=mysql_fetch_array($resultado)){
			include('extension.php');
				echo "<a href='../".$archivo."' target='_blank'><p class='boton2'><img src='".$img."'>".$titulo."</p></a>";
				/*echo "<a href='../".$archivo."' target='_blank'>".$titulo."</a>";*/
		$dbQuery = "SELECT idcarreras, idInfo, titulo, archivo FROM infocarrera WHERE idcarreras = '$idCarrera' AND idcarreras!= '0' AND activo = '1' ORDER BY idInfo";
		$resultado = mysql_query($dbQuery) or print "No se pudo acceder al contenido.";
		if (mysql_num_rows($resultado) > 0){
		while($fila=mysql_fetch_array($resultado)){
			$titulo = $fila["titulo"];
			$archivo = $fila["archivo"];
			if($archivo!="" && $archivo!=NULL){//Si hay archivo
				include('extension.php');
				echo "<a href='../../../".$archivo."' target='_blank'><p class='boton2'><img src='".$img."'>".$titulo."</p></a>";
				}
			}
		}

		
		
			echo "</td></tr></tbody></table>";
		echo "</div></section>";
	//FIN TABLÓN DE ANUNCIOS
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
else {
	echo "<h2>No se obtuvo ninguna informaci&oacute;n de la Base de Datos.</h2>";
}
mysql_free_result($resultado);
mysql_close($conexion);
}
else
	echo "<h2>No se detect&oacute; ninguna acci&oacute;n valida en la url.</h2>";
}
else
	echo "<h2>No se detect&oacute; ninguna acci&oacute;n valida en la url.</h2>";
?>	