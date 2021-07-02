<?php
	//if(isset($_GET["pruebaprograma"])){//En el caso de pruebas creadas a través del PROGRAMA
			//$idCarrera = $_GET["pruebaprograma"];
?>
		<div id="capa" style="display:none;margin: -35px 0 0 362px;">
		<img width="200px" src="../images/cargando.gif">
		</div>
		<?php
		if(isset($_GET['grupo']))
			{
			$grupo = $_GET['grupo'];
			$bus_logo = mysql_query("SELECT idcarreras from carreras where idGrupo = '$grupo'");
			if(mysql_num_rows($bus_logo) > 0)
					$idCarrera = @mysql_result($bus_logo, 0, "idcarreras");
			}
		$cons_logo = mysql_query("SELECT enlace,ruta FROM logos_pruebas where idprueba='$idCarrera' ORDER BY id_logo ASC");
		if (mysql_num_rows($cons_logo) > 0)
			{
			echo "<div id='logos'>";
				while($fi=mysql_fetch_array($cons_logo))
					{
					$enlace = $fi['enlace'];
					$ruta = $fi['ruta'];
						if($enlace!='' || !empty($enlace))
							echo "<a href='".$enlace."' target='_blank'><img src='../../".$ruta."' class='logos'></a>";
						else
							if ($ruta=='logos_pruebas/16aclorca.bmp' || $ruta=='logos_pruebas/16aclorca2.bmp')
								echo "<img src='../../".$ruta."' class='logos2'>";
							else
								echo "<img src='../../".$ruta."' class='logos'>";
					}
			echo "</div>";
			}
		?>
		<div id="menu2">
		<?php
			if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
				{
				?>
				<div id="m_item1" onclick="cargar2('tiempos/p_inscritos_grupos.php?grupo=<?php echo $grupo;?>&lang=0','capa','con_bus3')">INSCRITOS</div>
				<div id="m_item2" onclick="cargar2('tiempos/autorizados_grupos.php?grupo=<?php echo $grupo;?>&lang=0','capa','con_bus3')">AUTORIZADOS</div>
				<div id="m_item3" onclick="cargar2('tiempos/clasificaciones_grupos.php?grupo=<?php echo $grupo;?>&lang=0','capa','con_bus3')">CLASIFICACIONES</div>
				<div id="m_item4" onclick="cargar2('tiempos/abandonos_grupos2.php?grupo=<?php echo $grupo;?>&lang=0','capa','con_bus3')">ABANDONOS</div>
				<div id="m_item5" onclick="cargar2('tiempos/penalizaciones_grupos2.php?grupo=<?php echo $grupo;?>&lang=0','capa','con_bus3')">PENALIZACIONES</div>
		<?php
				}
			else{
			?>
				<div id="m_item1" onclick="cargar2('tiempos/p_inscritos_grupos.php?grupo=<?php echo $grupo;?>&lang=1','capa','con_bus3')">STARTLIST</div>
				<div id="m_item2" onclick="cargar2('tiempos/autorizados_grupos.php?grupo=<?php echo $grupo;?>&lang=1','capa','con_bus3')">AUTHORIZED</div>
				<div id="m_item3" onclick="cargar2('tiempos/clasificaciones_grupos.php?grupo=<?php echo $grupo;?>&lang=1','capa','con_bus3')">CLASSIFICATIONS</div>
				<div id="m_item4" onclick="cargar2('tiempos/abandonos_grupos2.php?grupo=<?php echo $grupo;?>&lang=1','capa','con_bus3')">RETIREMENTS</div>
				<div id="m_item5" onclick="cargar2('tiempos/penalizaciones_grupos2.php?grupo=<?php echo $grupo;?>&lang=1','capa','con_bus3')">PENALTIES</div>
			<?php	} ?>
		
</div>
<div id="con_bus3">
	<?php
		if(is_numeric($idCarrera)){
		//include("../include/conexion.php");//Lo hago arriba para saber el Título de la prueba
		include("funcionesTiempos.php");//Para algunas funciones que hacen falta para los tiempos online
		include("nombresTildes.php");//Para formatear los nombres, especialmente los de las pruebas creadas por el programa
		/* ******************************* Lista de Instritos ******************************* */
		//$dbQuery = "SELECT * FROM inscritos WHERE idcarreras = '$idCarrera' ORDER BY dorsal ASC";
		$dbQuery = "SELECT i.piloto,i.dorsal,i.copiloto,i.concursante,i.vehiculo,i.cilindrada,i.clase,i.grupo 
		FROM inscritos i INNER JOIN carreras c ON i.idcarreras = c.idcarreras
		INNER JOIN grupos g ON g.idGrupo = c.idGrupo WHERE g.idGrupo='$grupo' GROUP by i.dorsal ORDER BY i.dorsal ASC";
		$resultado = mysql_query($dbQuery) or print "No se pudo acceder al contenido de los tiempos online.";
		/*Aqui busco el tipo de prueba para quitar el competidor El problema es que todas las subidas son 0*/
		$tipo_prueba = mysql_query("SELECT tipo_carrera,modo_tiempos from carreras WHERE idGrupo = '$grupo'");
			while($fila2=mysql_fetch_array($tipo_prueba))
				{
				$tipo = $fila2['tipo_carrera'];
				$modo = $fila2['modo_tiempos'];
				}
if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
	echo "<p class='menus1'>Lista de Inscritos</p>";
else
	echo "<p class='menus1'>StartList</p>";
	?>
            <table width="100%" id="tab_tem">
            	<thead>
				<?php
				if ($tipo==1 || $tipo=='1')
					{ 
					if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
						echo "<tr><th>Dorsal</th><th>Equipo</th><th>Vehículo</th><th>Gr.</th><th>Cl.</th><th>Cilin.</th></tr>";
					else
						echo "<tr><th>Car No</th><th>Team</th><th>Car</th><th>Gr.</th><th>Cl.</th><th>C.C</th></tr>";
					}
				else
					{
					if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
						echo "<tr><th>Dorsal</th><th>Competidor</th><th>Equipo</th><th>Vehículo</th><th>Gr.</th><th>Cl.</th><th>Cilin.</th></tr>";
					else	
						echo "<tr><th>Car No</th><th>Contestant</th><th>Team</th><th>Car</th><th>Gr.</th><th>Cl.</th><th>C.C</th></tr>";
					} 
				?>
                </thead>
                <tbody>
<?php
if (mysql_num_rows($resultado) == 0)
	if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
		echo "<tr><td colspan='9'>No hay Lista de Instritos disponible.</td></tr>";
	else
		echo "<tr><td colspan='9'>Startlist not avaliable.</td></tr>";
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
	}
//}

?>       
            </tbody>
            </table>
<p class="men2"></p>
</div>