<?php
session_start();
	//sleep(1);
	include('../../includes/conexion.php') or die('no bd');
			if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
			echo "<p class='menus1'>LISTA DE AUTORIZADOS</p>";
		else
			echo "<p class='menus1'>AUTHORIZED LIST</p>";
if(isset($_GET["idprueba"])){//En el caso de pruebas creadas a través del PROGRAMA
			$idCarrera = $_GET["idprueba"];
		if(isset($idCarrera)){
		include("../../includes/conexion.php");//Lo hago arriba para saber el Título de la prueba
		include("../../includes/funcionesTiempos.php");//Para algunas funciones que hacen falta para los tiempos online
		include("../../includes/nombresTildes.php");
$dbQuery = "SELECT * FROM inscritos WHERE idcarreras = '$idCarrera' AND autorizado = '1' ORDER BY dorsal ASC";
$resultado = mysql_query($dbQuery) or print "No se pudo acceder al contenido de los tiempos online.";
		/*Aqui busco el tipo de prueba para quitar el competidor El problema es que todas las subidas son 0*/
		$tipo_prueba = mysql_query("SELECT tipo_carrera,modo_tiempos from carreras WHERE idcarreras = '$idCarrera'");
			while($fila2=mysql_fetch_array($tipo_prueba))
				{
				$tipo = $fila2['tipo_carrera'];
				$modo = $fila2['modo_tiempos'];
				}
?>
            <table width="100%" id="tab_tem">
            	<thead>
				<?php
				if ($tipo==1 || $tipo=='1')
				{ 
					if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
						echo "<tr class='encabezado2'><th>Dorsal</th><th>Equipo</th><th>Vehículo</th><th>Gr.</th><th>Cl.</th><th>Cilin.</th></tr>";
					else
						echo "<tr class='encabezado2'><th>Car No</th><th>Team</th><th>Car</th><th>Gr.</th><th>Cl.</th><th>C.C.</th></tr>";
				}
				else
					{
					if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
						if($idCarrera==189)
							echo "<tr class='encabezado2'><th>Dorsal</th><th>Concursante</th><th>Equipo</th><th>Vehículo</th><th>Gr.</th><th>Copa</th><th>Cilin.</th></tr>";
						else
							echo "<tr class='encabezado2'><th>Dorsal</th><th>Concursante</th><th>Equipo</th><th>Vehículo</th><th>Gr.</th><th>Cl.</th><th>Cilin.</th></tr>";
					else
						if($idCarrera==189)
							echo "<tr class='encabezado2'><th>Car No</th><th>Contestant</th><th>Team</th><th>Car</th><th>Gr.</th><th>Cup</th><th>C.C.</th></tr>";
						else
							echo "<tr class='encabezado2'><th>Car No</th><th>Contestant</th><th>Team</th><th>Car</th><th>Gr.</th><th>Cl.</th><th>C.C.</th></tr>";
					}
				?>
				</thead>
                <tbody>
<?php
if (mysql_num_rows($resultado) == 0)
	if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
		echo "<tr><td colspan='9'>No hay Lista de Autorizados disponible.</td></tr>";
	else
		echo "<tr><td colspan='9'>Authorized list not Avaliable.</td></tr>";
else{
$par = 1;//Variable para saber si se trata de una fila par o impar
$classcss="filaimpar";
while($fila=mysql_fetch_array($resultado)){
	$dorsal = $fila["dorsal"];
	$concursante = nombresTildes($fila["concursante"]);
	$piloto = nombresTildes($fila["piloto"]);
	$copiloto = nombresTildes($fila["copiloto"]);
	if(strlen($copiloto)<3)
		$equipo = "<img src='../images/casco1.png' width='25px'>".$piloto;
	else
	$equipo = "<img src='../images/casco1.png' width='25px'>".$piloto."<br><img src='../images/casco2.png' width='25px'>".$copiloto;
	$vehiculo = nombresTildes($fila["vehiculo"]);
	$gr = $fila["grupo"];
	$cl = $fila["clase"];
	$cilin = $fila["cilindrada"];
	if($cilin=='')
		$cilin='---';
	//Se supone que está actica según la consulta SQL
	//if($fila["desactivada"] == 0){//Si la prueba está activa
	if($par%2==0){//La fila es par
		$classcss="filapar";
	}
	else {
		$classcss="filaimpar";
	}
	if($tipo==1 || $tipo=='1')
		{	
		echo "<tr class='".$classcss."'><td align='center' style='font-weight:bold;font-size:18px'>".$dorsal."</td><td style='font-weight:bold;'>".$equipo."</td><td>".$vehiculo."</td><td align='center' style='font-weight:bold;'>".$gr."</td><td align='center'>".$cl."</td><td align='center' style='font-weight:bold;'>".$cilin."</td></tr>";
		}else{
		echo "<tr class='".$classcss."'><td align='center' style='font-weight:bold;font-size:18px'>".$dorsal."</td><td>".$concursante."</td><td style='font-weight:bold;'>".$equipo."</td><td>".$vehiculo."</td><td align='center' style='font-weight:bold;'>".$gr."</td><td align='center'>".$cl."</td><td align='center' style='font-weight:bold;'>".$cilin."</td></tr>";
		}
	$par++;
		}
	}
}}else
?> 
</table>
<p class="men2"></p>