<?php
//echo $orden;
include("conexion.php");
//Generar la llamada a la funcion dibujarPestanas
$mostrar="manga";//valor por defecto
$tituloJS="Carrera";//valor por defecto
if(isset($_GET["idmanga"]) && isset($_GET["id"]) && isset($_GET["orden"])){//Necesito las tres cosas
	$idManga = $_GET["idmanga"];
	$idCarrera = $_GET["id"];
	$orden = $_GET["orden"];
	if(isset($idCarrera)){
		//Obtengo el nombre de la prueba
		$dbQuery = "SELECT titulo FROM carreras WHERE idcarreras = '$idCarrera' AND (desactivada = '0' OR desactivada IS NULL) ORDER BY fecha DESC";
		$resultado = mysql_query($dbQuery);
		if (mysql_num_rows($resultado) != 0){
			$tituloJS = @mysql_result($resultado, 0, "titulo");
		}
	}/*
	else {
		//ya tiene un valor por defecto
	}*/
}
if(isset($_GET["mostrar"])){
	$mostrar = $_GET["mostrar"];
}
/*else {
	$mostrar = "inscritos";
}*/
/*$idCapa = "T".$mostrar;
$idLink = "B".$mostrar;*/

//Filtro de copas
if(isset($_GET["copa"])){
	$copa = $_GET["copa"];
}
else {
	$copa = '0';
}
//idcarreras, descripcion, fecha_larga, estado, tipo_carrera, tipo_informe, modo_tiempos, temporada, organizador, fecha, idWeb, titulo, poblacion, desactivada, imagen
//fecha_larga | poblacion | titulo | organizador

//Lista de Inscritos | Lista de Autorizados | Tramos | Abandonos | Penalizaciones | Tiempos
/*
P. | Nº | Equipo | Vehículo Gr. Cl. | Tiempo  | Primero Anterior
*/
if(isset($_GET["idmanga"]) && isset($_GET["id"]) && isset($_GET["orden"])){//Necesito las tres cosas
	$idManga = $_GET["idmanga"];
	$idCarrera = $_GET["id"];
	$orden = $_GET["orden"];
if(isset($idManga) && isset($idCarrera) && is_numeric($orden)){//Necesito las tres cosas de tipo numérico
//include("../../includes/conexion.php");
include("includes/funcionesTiempos.php");//Para algunas funciones que hacen falta para los tiempos online
include("includes/nombresTildes.php");//Para formatear los nombres, especialmente los de las pruebas creadas por el programa
/* ******************************* Tiempos Manga ******************************* */
//Distinta consulta dependiendo si se quiere mostrar sólo una copa o todas
if($copa=='0'){
	$dbQuery = "SELECT t.idcarreras, i.idinscritos, i.dorsal, i.piloto, i.copiloto, i.concursante, i.vehiculo, i.grupo, i.clase, i.cilindrada, 
	t.tiempo_invertido, t.penalizaciones as penalizaciones, t.tiempo_total FROM tiempos t inner join inscritos i on t.idinscritos=i.idinscritos and i.autorizado=1 
	and i.excluido=0 WHERE t.idmangas='$idManga' and t.estado=2 order BY t.tiempo_total ASC";
}
else {
	$dbQuery = "SELECT t.idcarreras, i.idinscritos, i.dorsal, i.piloto, i.copiloto, i.concursante, i.vehiculo, i.grupo, i.clase, i.cilindrada, 
	t.tiempo_invertido, t.penalizaciones, t.tiempo_total, c.idcopas FROM tiempos t INNER JOIN inscritos i ON t.idinscritos=i.idinscritos 
	and i.autorizado=1 and i.excluido=0 INNER JOIN copas_inscritos c ON i.idinscritos=c.idinscritos	WHERE t.idmangas='$idManga' 
	and t.estado=2 and c.idcopas='$copa' order BY t.tiempo_total ASC";
}
$resultado = mysql_query($dbQuery) or print "No se pudo acceder al contenido de los tiempos online.";
//Obtener nombre de la Manga
$dbQueryM = "SELECT idmangas, descripcion FROM mangas WHERE idmangas = '$idManga'";
$resultadoM = mysql_query($dbQueryM) or print "No se pudo obtener el nombre de la Manga actual.";
$nombreManga = "";
$nombreManga = @mysql_result($resultadoM, 0, "descripcion");
//Obtener tipo de prueba (acumulado o mejor tiempo)
$dbQueryM = "SELECT idcarreras, modo_tiempos FROM carreras WHERE idcarreras = '$idCarrera'";//Reutilizo las variables de obtener nombre de la Manga
$resultadoM = mysql_query($dbQueryM) or print "No se pudo obtener el tipo de Carrera.";
$modoTiempos = 0;
$modoTiempos = @mysql_result($resultadoM, 0, "modo_tiempos");         
$sqlcopas = mysql_query("SELECT idcopas FROM copas WHERE idcarreras='$idCarrera'");
$cuenta = mysql_num_rows($sqlcopas);
//echo "<div id='sub_exp'>";	

		if($modoTiempos == '0')
			{
				if($copa!='0')
					echo "<p class='lillo'>COPA: ".$nom_copa."</p><br>";
			
			}
			//echo '<p>..-'.$copa.'-..</p>';
// OBTENER COCHES EN PISTA Y DORSALES EN ESTE CASO CLASIFICADO POR MANGAS DIRectaMENe
if($copa=='0'){
	//echo "no copa";
	$cochesenpista = mysql_query("SELECT i.dorsal,i.piloto,i.copiloto FROM tiempos t INNER JOIN inscritos i on i.idinscritos=t.idinscritos 
	WHERE i.estado=2 AND t.idmangas='$idManga' AND t.tiempo_salida>0 AND t.tiempo_llegada=0 ORDER BY i.dorsal ASC");
}
else {
	//echo "copa";
	$cochesenpista = mysql_query("SELECT i.dorsal,i.piloto,i.copiloto FROM tiempos t INNER JOIN inscritos i on i.idinscritos=t.idinscritos
	INNER JOIN copas_inscritos c ON i.idinscritos=c.idinscritos
	WHERE i.estado=2 AND t.idmangas='$idManga' AND t.tiempo_salida>0 AND t.tiempo_llegada=0 and c.idcopas='$copa' ORDER BY i.dorsal ASC");
}

				if(mysql_num_rows($cochesenpista)>0)
					{
					echo '<p>PARTICIPANTES EN PISTA:</p>';
						while($row_pista = mysql_fetch_array($cochesenpista))
							{
							$pista = $row_pista['dorsal'];
							$p_piloto = $row_pista['piloto'];
							$p_copiloto = $row_pista['copiloto'];
							echo '<div class="ico_coche cursor" title="'.$p_piloto.' - '.$p_copiloto.'"><span class="dorsales">'.$pista.'</span><img src="../images/ico_coche.jpg" width="80px"></div>';						
							}
					}
				//FIN COCHES EN PISTA
		?>
		<!--SUBEXP-->
<!--/div-->
<br> 
<div id="con_bus_tiempos">
<table width="100%" border="0" id="tab_mar">
	<tr><td width="50%">
<?php
if($idCarrera==189 || $idCarrera==156 || $idCarrera==3005) //ESTA CHAPUZA KITA LOS ACUMULADOS
	$modoTiempos=1;
	if($modoTiempos == '1')
			echo "<div id='cont1b'>";
	else
			echo "<div id='cont1'>";
	if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
		echo "<p class='menus3'>Tiempos ".$nombreManga."</p>";
	else
		echo "<p class='menus3'>".$nombreManga." Times</p>";
		echo "<table width='100%' id='tab_tem'><thead>";
	if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
		if($idCarrera==189)		
            echo "<tr><th>P.</th><th>Nº</th><th></th><th>Equipo</th><th>Vehículo<br />Gr. / Copa</th><th><p style='font-style:italic'>Primero</p><p>Tiempo</p><p>Anterior</p><p><span class='penalizaciones'>Penalizaci&oacute;n</span></p></th></tr>";
		else
            echo "<tr><th>P.</th><th>Nº</th><th></th><th>Equipo</th><th>Vehículo<br />Gr. / Cl.</th><th><p style='font-style:italic'>Primero</p><p>Tiempo</p><p>Anterior</p><p><span class='penalizaciones'>Penalizaci&oacute;n</span></p></th></tr>";
	else
		if($idCarrera==189)	
            echo "<tr><th>P.</th><th>Nº</th><th></th><th>Team</th><th>Car<br />Gr. / Cup</th><th><p style='font-style:italic'>First</p><p>Time</p><p>Previous</p><p class='penalizaciones'>Penalties</p></th></tr>";
        else    
			echo "<tr><th>P.</th><th>Nº</th><th></th><th>Team</th><th>Car<br />Gr. / Cl.</th><th><p style='font-style:italic'>First</p><p>Time</p><p>Previous</p><p class='penalizaciones'>Penalties</p></th></tr>";
?>			
				</thead>
                <tbody>
		<?php
		if (mysql_num_rows($resultado) == 0)
			if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
				echo "<tr><td colspan='8'>No hay Tiempos Manga disponibles.</td></tr>";
			else
				echo "<tr><td colspan='8'>Stage Time not avaliable.</td></tr>";
else{
$par = 1;//Variable para saber si se trata de una fila par o impar
$classcss="filaimpar";
$p=1;//Posición
$primero=0;//tiempo del primer
$anterior=0;//tiempo del anterior
while($fila=mysql_fetch_array($resultado)){
	$penalizaciones = $fila['penalizaciones'];
	$dorsal = $fila["dorsal"];
	if($idCarrera=='A17' && ($dorsal==34 || $dorsal==10))
		$dorsal = $dorsal."<br>SR";
	$idinscrito = $fila["idinscritos"];
	$piloto = nombresTildes($fila["piloto"]);
	$copiloto = nombresTildes($fila["copiloto"]);
	$cop ='';
	$pil = '';
	/*FORMATEO los nombres para que la tabla parezca mas grande,
	los compuestos los abrevio y los 2dos apellidos los anulo*/
	$pilo = explode(' ',$piloto);
	if(count($pilo)>2)
		{
		for($j=0;$j<count($pilo)-1;$j++){
			if (count($pilo)>3 && $j==1){					
					$pilo[$j] = mb_substr($pilo[$j],0,1);
					$pilo[$j] = $pilo[$j].".";						
					}
			$pil = $pil." ".$pilo[$j];
			}
		}
	else
		{
		$pil = $piloto;
		}
	$copilo = explode(' ',$copiloto);
	if (count($copilo)>2)
		{
		for($j=0;$j<count($copilo)-1;$j++){
				if (count($copilo)>3 && $j==1){
						$copilo[$j] = mb_substr($copilo[$j],0,1);
						$copilo[$j] = $copilo[$j].".";
					}
			$cop = $cop." ".$copilo[$j];	
			}
		}
	else{
		$cop = $copiloto;
		}
	if(strlen($cop)<3)
	{
	$equipo = "<p class='negrita'>".$pil."</p>";
	$image = "<img src='../images/casco1.png' width='20px'>";
	}
	else
	{
	$equipo = "<p class='negrita'>".$pil."</p><p>".$cop."</p>";
	$image = "<img src='../images/casco1.png' width='20px'><br><img src='../images/casco2.png' width='20px'>";
	}
	$comp1 = strpos($equipo,$busqueda);
		if($comp1!=FALSE)
			$bus = 'rojo4';
		else
			$bus='';
	//$equipo = "<img src='../images/casco1.png' width='20px'>".$piloto."<br><img src='../images/casco2.png' width='20px'>".$copiloto;
	$tiempo = $fila["tiempo_total"];//tiempo en milésimas, para calcular diferencia con el primero y con el anterior
	$t = FormatearTiempo($tiempo);//tiempo en formato 13:34:22.568
	$vehiculo = nombresTildes($fila["vehiculo"]);
	$gr = $fila["grupo"];
	$cl = $fila["clase"];
	if($p==1){//primera vuelta, cojoel tiempo del primero y anterior que es el mismo
		$primero=$tiempo;
		$anterior=$tiempo;
	}
	$dp = FormatearTiempo(($tiempo-$primero));//Diferencia con el primero en formato 13:34:22.568
	$da = FormatearTiempo(($tiempo-$anterior));//Diferencia con el primero en formato 13:34:22.568
	//Se supone que está actica según la consulta SQL
	//if($fila["desactivada"] == 0){//Si la prueba está activa
	if($par%2==0){//La fila es par
		$classcss="filapar ".$bus;
	}
	else {
		$classcss="filaimpar ".$bus;
	}
	
	echo "<tr class='".$classcss."'><td class='center' style='font-size:18px;font-weight:bold;vertical-align:middle;'>".$p."</td><td class='center' style='vertical-align:middle;'>".$dorsal."</td><td style='vertical-align:middle;'>".$image."</td><td style='vertical-align:middle;'>".$equipo."</td><td class='center' style='font-size:x-small;vertical-align:middle;'>".$vehiculo."<br />".$gr." / ".$cl."</td>";
	if($da=='00:00:00.000')
			{
			echo "<td class='center negrita'><p>---</p><p>".$t."</p><p>---</p><p>---</p></td></tr>";
			}
		else
			{
			echo "<td class='center'><p class='rojo2'>+".$dp."</p><p class='negrita'>".$t."</p><p class='rojo'>+".$da."</p>";
				if($penalizaciones!=0 || $penalizaciones!='0')
					echo "<p><span class='penalizaciones'>".FormatearTiempo($penalizaciones)."</span></p>";
				else
					echo "<p>---</p></td></tr>";
			}
	//echo "<td class='center'>".$t."</td><td class='center'>".$dp."<p style='font-style:italic'>".$da."</p></td></tr>";
/*	
	echo "<tr class='".$classcss."' copas='0";

//Cosulta para copas

	$dbQueryCopas = "SELECT copas_inscritos.idcopas_inscritos, copas_inscritos.idcarreras, copas_inscritos.idcopas, copas_inscritos.idinscritos, copas.descripcion, inscritos.idinscritos FROM copas_inscritos INNER JOIN copas ON copas.idcopas = copas_inscritos.idcopas INNER JOIN inscritos ON inscritos.idinscritos = copas_inscritos.idinscritos WHERE copas_inscritos.idinscritos='$idinscrito' AND copas.idCarreras='$idCarrera' ORDER BY copas_inscritos.idinscritos";
	$resultadoCopas = mysql_query($dbQueryCopas);
	while($row=mysql_fetch_array($resultadoCopas)){
		$copas = $row["idcopas"];
		echo ",$copas";
	}
	echo "'><td class='cizq'></td><td class='center'>".$p."</td><td class='center'>".$dorsal."</td><td>".$equipo."</td><td>".$vehiculo."<br />".$gr." / ".$cl."</td><td class='center'>".$t."</td><td class='center'>".$dp."<br />".$da."</td><td class='cder'></td></tr>";
*/	
	$par++;
	$p++;
	$anterior=$tiempo;
}
}

?>       
            </tbody>
            </table>
			<p class="men2"></p>
	</div>
	</td>
	<?php
	if($modoTiempos==1 || $modoTiempos=='1')
		echo "</tr><tr><td><div id='cont2b'>";/* CAMBIOS EN <td> por la condicional de modotiempos*/
	else
		echo "<td><div id='cont2'>";
		if($modoTiempos != 1 || $modoTiempos != '1' || $modoTiempos != "1"){
/*
	Obtener los resultados de la manga anterior para compararlos (a partir de la segunda manga, ya que en la primera no tiene sentido, pues no hay con qué comparar)
*/
$posicionesAnteriores = array();// Array para los dorsales en el orden en que aparecen en la manga anterior (las posiciones)

//Obtener primera manga que no sea de entrenamientos
$dbQueryP = "SELECT idmangas, idcarreras, tipo_manga, orden FROM mangas WHERE idcarreras = '$idCarrera' AND tipo_manga='1' ORDER BY orden ASC";
$resultadoP = mysql_query($dbQueryP);
$primeraManga = 1;
$primeraManga = @mysql_result($resultadoP, 0, "orden");
@mysql_free_result($resultadoP);
if($orden>$primeraManga){//La manga no es la primera
$ordenAnterior = $orden -1;
$max_mangas = NumeroMangas($idCarrera,$ordenAnterior);// en include("../funcionesTiempos.php");
//Distinta consulta dependiendo si se quiere mostrar sólo una copa o todas
if($copa=='0'){
	$qClasifFinal = "select SUM(t.tiempo_total) as tiempo_total, SUM(t.tiempo_invertido) as tiempo_invertido,";
	$qClasifFinal = $qClasifFinal." i.idinscritos,i.dorsal,i.piloto, i.copiloto,";
	$qClasifFinal = $qClasifFinal." i.concursante,i.vehiculo,i.clase,i.grupo,i.cilindrada,";
	$qClasifFinal = $qClasifFinal." SUM(t.penalizaciones) as penalizaciones";
	$qClasifFinal = $qClasifFinal." from tiempos t";
	/*if ($param_COPA>0){
	$qClasifFinal = $qClasifFinal." inner join copas_inscritos c on c.idcopas=".$param_COPA." and c.idinscritos=t.idinscritos";}*/
	$qClasifFinal = $qClasifFinal." inner join inscritos i on i.idinscritos=t.idinscritos";
	$qClasifFinal = $qClasifFinal." inner join mangas m on m.idmangas=t.idmangas and m.orden<='$ordenAnterior' and m.tipo_manga=1";
	$qClasifFinal = $qClasifFinal." where t.idcarreras='$idCarrera' and i.autorizado=1 and i.excluido=0 and t.estado=2";
	$qClasifFinal = $qClasifFinal." and t.idinscritos not in";
	$qClasifFinal = $qClasifFinal." (select idinscritos from tiempos t, mangas m where t.idmangas=m.idmangas and m.tipo_manga=1 and m.orden<='$ordenAnterior' and t.estado=3)";
	/*if ($param_GRUPO<>"-1"){
	$qClasifFinal = $qClasifFinal." and i.grupo="".$param_GRUPO.""";}
	if ($param_CLASE<>"-1"){
	$qClasifFinal = $qClasifFinal." and i.clase="".$param_CLASE.""";}*/
	$qClasifFinal = $qClasifFinal." group by i.idinscritos,i.dorsal,i.piloto,";
	$qClasifFinal = $qClasifFinal." i.copiloto,i.concursante,";
	$qClasifFinal = $qClasifFinal." i.vehiculo,i.clase,i.grupo,i.cilindrada";
	$qClasifFinal = $qClasifFinal." having COUNT(i.idinscritos)='$max_mangas'";
	$qClasifFinal = $qClasifFinal." order by 1 asc";
} 
else {
	$qClasifFinal = "select SUM(t.tiempo_total) as tiempo_total, SUM(t.tiempo_invertido) as tiempo_invertido,";
	$qClasifFinal = $qClasifFinal." i.idinscritos,i.dorsal,i.piloto, i.copiloto,";
	$qClasifFinal = $qClasifFinal." i.concursante,i.vehiculo,i.clase,i.grupo,i.cilindrada,";
	
	$qClasifFinal = $qClasifFinal."  c.idcopas,";
	
	$qClasifFinal = $qClasifFinal." SUM(t.penalizaciones) as penalizaciones";
	$qClasifFinal = $qClasifFinal." from tiempos t";
	/*if ($param_COPA>0){
	$qClasifFinal = $qClasifFinal." inner join copas_inscritos c on c.idcopas=".$param_COPA." and c.idinscritos=t.idinscritos";}*/
	$qClasifFinal = $qClasifFinal." inner join inscritos i on i.idinscritos=t.idinscritos";
	$qClasifFinal = $qClasifFinal." inner join mangas m on m.idmangas=t.idmangas and m.orden<='$ordenAnterior' and m.tipo_manga=1";
	
	$qClasifFinal = $qClasifFinal." INNER JOIN copas_inscritos c ON i.idinscritos=c.idinscritos";
	
	$qClasifFinal = $qClasifFinal." where t.idcarreras='$idCarrera' and i.autorizado=1 and i.excluido=0 and t.estado=2";
	
	$qClasifFinal = $qClasifFinal." and c.idcopas='$copa'";
	
	$qClasifFinal = $qClasifFinal." and t.idinscritos not in";
	$qClasifFinal = $qClasifFinal." (select idinscritos from tiempos t, mangas m where t.idmangas=m.idmangas and m.tipo_manga=1 and m.orden<='$ordenAnterior' and t.estado=3)";
	/*if ($param_GRUPO<>"-1"){
	$qClasifFinal = $qClasifFinal." and i.grupo="".$param_GRUPO.""";}
	if ($param_CLASE<>"-1"){
	$qClasifFinal = $qClasifFinal." and i.clase="".$param_CLASE.""";}*/
	$qClasifFinal = $qClasifFinal." group by i.idinscritos,i.dorsal,i.piloto,";
	$qClasifFinal = $qClasifFinal." i.copiloto,i.concursante,";
	$qClasifFinal = $qClasifFinal." i.vehiculo,i.clase,i.grupo,i.cilindrada";
	$qClasifFinal = $qClasifFinal." having COUNT(i.idinscritos)='$max_mangas'";
	$qClasifFinal = $qClasifFinal." order by 1 asc";	
}
$resultado = mysql_query($qClasifFinal);

	if (mysql_num_rows($resultado) > 0){
		$posicionesItererator=0;//Iterador para añadir los dorsales al array $posicionesAnteriores
		while($fila=mysql_fetch_array($resultado)){
			$dorsal = $fila["dorsal"];
			$posicionesAnteriores[$posicionesItererator]=$dorsal;
			$posicionesItererator++;
		}
	}	
}


	
/* ******************************* Tiempos Acumulado (Clasificación Final) ******************************* */
$max_mangas = NumeroMangas($idCarrera,$orden);// en include("../funcionesTiempos.php");
//Distinta consulta dependiendo si se quiere mostrar sólo una copa o todas
if($copa=='0'){
	$qClasifFinal = "select SUM(t.tiempo_total) as tiempo_total, SUM(t.tiempo_invertido) as tiempo_invertido,";
	$qClasifFinal = $qClasifFinal." i.idinscritos,i.dorsal,i.piloto, i.copiloto,";
	$qClasifFinal = $qClasifFinal." i.concursante,i.vehiculo,i.clase,i.grupo,i.cilindrada,";
	$qClasifFinal = $qClasifFinal." SUM(t.penalizaciones) as penalizaciones";
	$qClasifFinal = $qClasifFinal." from tiempos t";
	/*if ($param_COPA>0){
	$qClasifFinal = $qClasifFinal." inner join copas_inscritos c on c.idcopas=".$param_COPA." and c.idinscritos=t.idinscritos";}*/
	
	$qClasifFinal = $qClasifFinal." inner join inscritos i on i.idinscritos=t.idinscritos";
	$qClasifFinal = $qClasifFinal." inner join mangas m on m.idmangas=t.idmangas and m.orden<='$orden' and m.tipo_manga=1";
	$qClasifFinal = $qClasifFinal." where t.idcarreras='$idCarrera' and i.autorizado=1 and i.excluido=0 and t.estado=2";
	$qClasifFinal = $qClasifFinal." and t.idinscritos not in";
	$qClasifFinal = $qClasifFinal." (select idinscritos from tiempos t, mangas m where t.idmangas=m.idmangas and m.tipo_manga=1 and m.orden<='$orden' and t.estado=3)";
	/*if ($param_GRUPO<>"-1"){
	$qClasifFinal = $qClasifFinal." and i.grupo="".$param_GRUPO.""";}
	
	if ($param_CLASE<>"-1"){
	$qClasifFinal = $qClasifFinal." and i.clase="".$param_CLASE.""";}*/
	
	$qClasifFinal = $qClasifFinal." group by i.idinscritos,i.dorsal,i.piloto,";
	$qClasifFinal = $qClasifFinal." i.copiloto,i.concursante,";
	$qClasifFinal = $qClasifFinal." i.vehiculo,i.clase,i.grupo,i.cilindrada";
	$qClasifFinal = $qClasifFinal." having COUNT(i.idinscritos)='$max_mangas'";
	$qClasifFinal = $qClasifFinal." order by 1 asc";
	/*
	Te digo los parametros:
	%s1: es el campo "orden" de la manga seleccionada 								//$orden
	%s2: es el idcarreras/															/$idCarrera
	%s3: es el valor devuelto por la funcion: NumeroMangas($param_IDCARRERAS,%s1)	//$max_mangas
	*/
}
else {
	$qClasifFinal = "select SUM(t.tiempo_total) as tiempo_total, SUM(t.tiempo_invertido) as tiempo_invertido,";
	$qClasifFinal = $qClasifFinal." i.idinscritos,i.dorsal,i.piloto, i.copiloto,";
	$qClasifFinal = $qClasifFinal." i.concursante,i.vehiculo,i.clase,i.grupo,i.cilindrada,";
	
	$qClasifFinal = $qClasifFinal."  c.idcopas,";
	
	$qClasifFinal = $qClasifFinal." SUM(t.penalizaciones) as penalizaciones";
	$qClasifFinal = $qClasifFinal." from tiempos t";
	/*if ($param_COPA>0){
	$qClasifFinal = $qClasifFinal." inner join copas_inscritos c on c.idcopas=".$param_COPA." and c.idinscritos=t.idinscritos";}*/
	
	$qClasifFinal = $qClasifFinal." inner join inscritos i on i.idinscritos=t.idinscritos";
	$qClasifFinal = $qClasifFinal." inner join mangas m on m.idmangas=t.idmangas and m.orden<='$orden' and m.tipo_manga=1";
	
	$qClasifFinal = $qClasifFinal." INNER JOIN copas_inscritos c ON i.idinscritos=c.idinscritos";
	
	$qClasifFinal = $qClasifFinal." where t.idcarreras='$idCarrera' and i.autorizado=1 and i.excluido=0 and t.estado=2";
	
	$qClasifFinal = $qClasifFinal." and c.idcopas='$copa'";
	
	$qClasifFinal = $qClasifFinal." and t.idinscritos not in";
	$qClasifFinal = $qClasifFinal." (select idinscritos from tiempos t, mangas m where t.idmangas=m.idmangas and m.tipo_manga=1 and m.orden<='$orden' and t.estado=3)";
	/*if ($param_GRUPO<>"-1"){
	$qClasifFinal = $qClasifFinal." and i.grupo="".$param_GRUPO.""";}
	
	if ($param_CLASE<>"-1"){
	$qClasifFinal = $qClasifFinal." and i.clase="".$param_CLASE.""";}*/
	
	$qClasifFinal = $qClasifFinal." group by i.idinscritos,i.dorsal,i.piloto,";
	$qClasifFinal = $qClasifFinal." i.copiloto,i.concursante,";
	$qClasifFinal = $qClasifFinal." i.vehiculo,i.clase,i.grupo,i.cilindrada";
	$qClasifFinal = $qClasifFinal." having COUNT(i.idinscritos)='$max_mangas'";
	$qClasifFinal = $qClasifFinal." order by 1 asc";
	/*
	Te digo los parametros:
	%s1: es el campo "orden" de la manga seleccionada 								//$orden
	%s2: es el idcarreras/															/$idCarrera
	%s3: es el valor devuelto por la funcion: NumeroMangas($param_IDCARRERAS,%s1)	//$max_mangas
*/
}
$resultado = mysql_query($qClasifFinal) or print "No se pudo acceder al contenido de los tiempos online.";
	if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
		{
		echo "<p class='menus3'>Acumulado hasta ".$nombreManga."</p>";
		echo "<table width='100%' id='tab_tem'><thead>";
       	echo "<tr><th colspan='2'>POS.</th><th>Nº</th><th></th><th>Equipo</th><th>Vehículo<br />Gr. / Cl.</th><th><p style='font-style:italic'>Primero</p><p>Tiempo</p><p>Anterior</p><p><span class='penalizaciones'>Penalizaci&oacute;n</span></p></th></tr>";
		}
	else{
		echo "<p class='menus3'>Acumulated up ".$nombreManga."</p>";
		echo "<table width='100%' id='tab_tem'><thead>";
       	echo "<tr><th colspan='2'>POS.</th><th>Nº</th><th></th><th>Team</th><th>Car<br />Gr. / Cl.</th><th><p style='font-style:italic'>First</p><p>Time</p><p>Previous</p><p><span class='penalizaciones'>Penalties</span></p></th></tr>";
		}
?>
            
				</thead>
                <tbody>
<?php
if($idCarrera==156 || $idCarrera==189 || $idcarrera==3005)
{
if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
	echo "<tr><td colspan='4'>NO EXISTE ACUMULADO</td></tr>";
else
	echo "<tr><td colspan='4'>Accumulated Time not exists.</td></tr>";
}
else
{
if (mysql_num_rows($resultado) == 0)
	if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
		echo "<tr><td colspan='8'>No hay Acumulado disponible.</td></tr>";
	else
		echo "<tr><td colspan='8'>Accumulated Time not exists.</td></tr>";
else{
$par = 1;//Variable para saber si se trata de una fila par o impar
$classcss="filaimpar";
$p=1;//Posición
$primero=0;//tiempo del primer
$anterior=0;//tiempo del anterior
while($fila=mysql_fetch_array($resultado)){
	$penalizaciones = $fila['penalizaciones'];
	$dorsal = $fila["dorsal"];
	$piloto = nombresTildes($fila["piloto"]);
	$copiloto = nombresTildes($fila["copiloto"]);
	$cop ='';
	$pil = '';
		/*FORMATEO los nombres para que la tabla parezca mas grande,
	los compuestos los abrevio y los 2dos apellidos los anulo*/
	$pilo = explode(' ',$piloto);
	if(count($pilo)>2)
		{
		for($j=0;$j<count($pilo)-1;$j++){
			if (count($pilo)>3 && $j==1){					
					$pilo[$j] = mb_substr($pilo[$j],0,1);
					$pilo[$j] = $pilo[$j].".";						
					}
			$pil = $pil." ".$pilo[$j];
			}
		}
	else
		{
		$pil = $piloto;
		}
	$copilo = explode(' ',$copiloto);
	if (count($copilo)>2)
		{
		for($j=0;$j<count($copilo)-1;$j++){
				if (count($copilo)>3 && $j==1){
						$copilo[$j] = mb_substr($copilo[$j],0,1);
						$copilo[$j] = $copilo[$j].".";
					}
			$cop = $cop." ".$copilo[$j];	
			}
		}
	else{
		$cop = $copiloto;
		}
	if(strlen($cop)<3)
	{
	$equipo = "<p class='negrita'>".$pil."</p>";
	$image = "<img src='../images/casco1.png' width='20px'>";
	}
	else
	{
	$equipo = "<p class='negrita'>".$pil."</p><p>".$cop."</p>";
	$image = "<img src='../images/casco1.png' width='20px'><br><img src='../images/casco2.png' width='20px'>";
	}
	$comp1 = strpos($equipo,$busqueda);
		if($comp1!=FALSE)
			$bus = 'rojo4';
		else
			$bus='';
	//$equipo = $pil."<br />".$cop;
	//$equipo = "<img src='../images/casco1.png' width='20px'>".$piloto."<br><img src='../images/casco2.png' width='20px'>".$copiloto;
	$tiempo = $fila["tiempo_total"];//tiempo en milésimas, para calcular diferencia con el primero y con el anterior
	$t = FormatearTiempo($tiempo);//tiempo en formato 13:34:22.568
	$vehiculo = nombresTildes($fila["vehiculo"]);
	$gr = $fila["grupo"];
	$cl = $fila["clase"];
	if($p==1){//primera vuelta, cojoel tiempo del primero y anterior que es el mismo
		$primero=$tiempo;
		$anterior=$tiempo;
	}
	$dp = FormatearTiempo(($tiempo-$primero));//Diferencia con el primero en formato 13:34:22.568
	$da = FormatearTiempo(($tiempo-$anterior));//Diferencia con el primero en formato 13:34:22.568
	//Se supone que está actica según la consulta SQL
	//if($fila["desactivada"] == 0){//Si la prueba está activa
	if($par%2==0){//La fila es par
		$classcss="filapar ".$bus;
	}
	else {
		$classcss="filaimpar ".$bus;
	}	
	echo "<tr class='".$classcss."'><td class='center' style='font-size:18px;font-weight:bold;vertical-align:middle;'>".$p."<td style='vertical-align:middle;'>";
	if($orden>$primeraManga){//La manga no es la primera
		//Evolucíon con respeto a la manga anterior.
		$posicionAnterior = array_search($dorsal, $posicionesAnteriores)+1;//Sumo uno ya que el primero está en la posición 0
		if($posicionAnterior){
			if($p>$posicionAnterior){//ha descendido posiciones
				$variacion = $p - $posicionAnterior;
				echo "<div class='descenso'>".$variacion."</div>";
			}
			else if($p<$posicionAnterior){//ha ascendido posiciones
				$variacion = $posicionAnterior - $p;
				echo "<div class='ascenso'>".$variacion."</div>";
			}
			//else echo "=";
		}
	}
	echo "</td></td><td class='center' style='vertical-align:middle;'>".$dorsal."</td><td style='vertical-align:middle;'>".$image."</td><td style='vertical-align:middle;'>".$equipo."</td><td class='center' style='font-size:x-small;vertical-align:middle;'>".$vehiculo."<br />".$gr." / ".$cl."</td>";
	if($da=='00:00:00.000')
			{
			if ($penalizaciones!=0 || $penalizaciones !='0')
					echo "<td class='center negrita'><p>---</p><p>".$t."</p><p>---</p><p class='penalizaciones'>".FormatearTiempo($penalizaciones)."</p></td></tr>";
			else	
			//echo "<td class='center negrita'><p>---</p><p>".$t."</p><p>---</p><p>---</p></td></tr>";
				echo "<td class='center negrita'><p>---</p><p>".$t."</p><p>---</p><p>---</p></td></tr>";
			}
		else
			{
			echo "<td class='center'><p class='rojo2'>+".$dp."</p><p class='negrita'>".$t."</p><p class='rojo'>+".$da."</p>";
				if ($penalizaciones!=0 || $penalizaciones !='0')
					echo "<p><span class='penalizaciones'>".FormatearTiempo($penalizaciones)."</span></p>";
				else
					echo "<p>---</p></td></tr>";
			}
	
	//echo "<td class='center'>".$t."</td><td class='center'>".$dp."<p style='font-style:italic;'>".$da."</td></tr>";
	$par++;
	$p++;
	$anterior=$tiempo;
}
}
}//solo prueba 156
?>       
            </tbody>
            </table>
		<p class="men2"></p>
	</div>
	</td></tr>
	<tr><td colspan="2">
	<div id="cont3">
		<?php  
unset($posicionesAnteriores);// borro la variable de memoria
}
/* ******************************* Abandonos Tramo ******************************* */
$max_orden = MaxOrdenMangas($idCarrera);// en include("../funcionesTiempos.php");
$max_mangas = NumeroMangas($idCarrera,$max_orden);// en include("../funcionesTiempos.php");

$query_Abandonos = "select i.dorsal,i.concursante,i.piloto, i.copiloto,i.vehiculo,i.grupo, i.clase,a.razon_abandono";
$query_Abandonos.= " from tiempos t";
$query_Abandonos.= " inner join inscritos i on i.idinscritos=t.idinscritos";
$query_Abandonos.= " inner join mangas m on m.idmangas=t.idmangas";
$query_Abandonos.= " inner join abandonos a on a.idinscritos=t.idinscritos";
$query_Abandonos .= " where t.estado=3 and t.idmangas='$idManga'";
$query_Abandonos.= " group by i.dorsal";
//$query_Abandonos.= " group by i.dorsal,i.concursante,i.piloto, i.copiloto,i.vehiculo,i.grupo, i.clase,a.razon_abandono";
//$query_Abandonos.= " having COUNT(i.idinscritos)='".$max_mangas."'";

$query_Abandonos .= " union all ";
$query_Abandonos .= " select i.dorsal,i.concursante,i.piloto, i.copiloto,i.vehiculo,i.grupo, i.clase,'EXCLUIDO' as razon_abandono ";
$query_Abandonos .= " from inscritos i";
$query_Abandonos .= " where excluido=1 and autorizado=1 and idcarreras = '$idCarrera'";
$query_Abandonos .= " order by 1";
//echo "<textarea>$query_Abandonos</textarea>";
$resultado = mysql_query($query_Abandonos) or print "No se pudo acceder al contenido de los tiempos online.";
        if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
			{
			echo "<p class='menus1'>Abandonos</p>";
			echo "<table width='100%' id='tab_tem'><thead>";
			if($idCarrera==189)
				echo "<tr><th>Dorsal</th><th>Concursante</th><th>Equipo</th><th>Vehículo</th><th>Gr.</th><th>Copa</th><th>Motivo</th></tr>";
			else
				echo "<tr><th>Dorsal</th><th>Concursante</th><th>Equipo</th><th>Vehículo</th><th>Gr.</th><th>Cl.</th><th>Motivo</th></tr>";
			echo "</thead><tbody>";
			}
		else{
			echo "<p class='menus1'>Retirements</p>";
			echo "<table width='100%' id='tab_tem'><thead>";
			if($idCarrera==189)
				echo "<tr><th>Car No</th><th>Contestant</th><th>Team</th><th>Car</th><th>Gr.</th><th>Cup</th><th>Reasson</th></tr>";
			else
				echo "<tr><th>Car No</th><th>Contestant</th><th>Team</th><th>Car</th><th>Gr.</th><th>Cl.</th><th>Reasson</th></tr>";
			echo "</thead><tbody>";
			}           	
if (mysql_num_rows($resultado) == 0)
		if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
			echo "<tr><td colspan='9'>No hay Abandonos Tramo disponibles.</td></tr>";
		else
			echo "<tr><td colspan='9'>Retirements not exists.</td></tr>";
else{
$par = 1;//Variable para saber si se trata de una fila par o impar
$classcss="filaimpar";
while($fila=mysql_fetch_array($resultado)){
	$dorsal = $fila["dorsal"];
	//$concursante = utf8_encode(strtoupper($fila["concursante"]));
	$concursante = nombresTildes($fila["concursante"]);
	$piloto = nombresTildes($fila["piloto"]);
	$copiloto = nombresTildes($fila["copiloto"]);
	$equipo = $piloto."<br />".$copiloto;
	$vehiculo = nombresTildes($fila["vehiculo"]);
	$gr = $fila["grupo"];
	$cl = $fila["clase"];
	$razon = nombresTildes($fila["razon_abandono"]);
	//Se supone que está actica según la consulta SQL
	//if($fila["desactivada"] == 0){//Si la prueba está activa
	if($par%2==0){//La fila es par
		$classcss="filapar";
	}
	else {
		$classcss="filaimpar";
	}	
	echo "<tr class='".$classcss."'><td class='center'>".$dorsal."</td><td>".$concursante."</td><td>".$equipo."</td><td>".$vehiculo."</td><td class='center'>".$gr."</td><td class='center'>".$cl."</td><td class='center'>".$razon."</td></tr>";
	$par++;
}
}

?>       
            </tbody>
            </table>
<p class="men2"></p>    
	</div>
	</td></tr></table>
<?php
		if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
			{
			if($idCarrera==189)
				{
				$con_tiem = mysql_query("SELECT * FROM modotiempos WHERE idcarreras='$idCarrera'");	
				if(mysql_num_rows($con_tiem)==0)	
					echo "<p align='center' class='botonx' style='cursor:pointer'> Ver la Clasificaci&oacute;n Final</p>";
				else
					echo "<p align='center' class='botonx' style='cursor:pointer'> Ver la Clasificaci&oacute;n Final</p>";
					//echo "<p align='center' onclick=\"cargar2('tiempos/clasificacionFinal.php?idprueba=$idCarrera&lang=0','capa','con_bus3')\" class='boton1' style='cursor:pointer'> Ver la Clasificaci&oacute;n Final</p>";
				}
			else
				echo "<p align='center' onclick=\"cargar2('tiempos/clasificacionFinal.php?idprueba=$idCarrera&lang=0','capa','con_bus3')\" class='boton1' style='cursor:pointer'> Ver la Clasificaci&oacute;n Final</p>";
			}
		else{
			if($idCarrera==189)
				{
				$con_tiem = mysql_query("SELECT * FROM modotiempos WHERE idcarreras='$idCarrera'");	
				if(mysql_num_rows($con_tiem)==0)	
					echo "<p align='center' class='botonx' style='cursor:pointer'>Final Classification</p>";
				else
					echo "<p align='center' class='botonx' style='cursor:pointer'> Ver la Clasificaci&oacute;n Final</p>";
					//echo "<p align='center' onclick=\"cargar2('tiempos/clasificacionFinal.php?idprueba=$idCarrera&lang=0','capa','con_bus3')\" class='boton1' style='cursor:pointer'>Final Classification</p>";
				}
			else
				echo "<p align='center' onclick=\"cargar2('tiempos/clasificacionFinal.php?idprueba=$idCarrera&lang=0','capa','con_bus3')\" class='boton1' style='cursor:pointer'>Final Classification</p>";
			}
mysql_free_result($resultado);
@mysql_free_result($resultadoM);
/*@mysql_free_result($resultadoCopas);*/
mysql_close($conexion);
}
else
	echo "<h2>No se detect&oacute; ninguna acci&oacute;n valida en la url.</h2>";
}
else
	echo "<h2>No se detect&oacute; ninguna acci&oacute;n valida en la url.</h2>";
?>


