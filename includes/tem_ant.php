<?php
/*ANTES DE EMPEZAR...todo este codigo pertenece al amigo de Manolo, yo solo voy a modernizarlo para que puedan seguir
con la misma base de datos, temporada.php ya funciona con Ajax y tem_act.php, recargardo cada 2 segundo la pagina sin
que se aprecie
*/
error_reporting(5);
include_once("dateAfecha.php");//para hacer operaciones con fechas
include("nombresTildes.php");
$hoy=date("Y-m-d");
include('conexion.php');
mysql_query ("SET NAMES 'utf8'");
mysql_select_db($nombreBD);
if(isset($_GET['temporada']))
	{
	$temporada=$_GET['temporada'];
//include("CarreraObject.php");//Clase Carrera, para instanciar objetos de tipo Carrera des la información de la Base de Datos, tablas carreras y grupos.
$anoActual = date("Y");
$noFilas = false;// Variable que indica si hay filas en las consultas a la Base de Datos
$CarrerasyGrupos = array();// Array para guardar los objetos Carrera
$grupoItereator = 0;// Iterador del array $CarrerasyGrupos
$dbQuery = "SELECT idcarreras, descripcion, fecha_larga, organizador, fecha, idWeb, titulo, poblacion FROM carreras WHERE (desactivada = '0' OR desactivada IS NULL) AND (idGrupo = '0' OR idGrupo IS NULL) AND temporada = '".$temporada."' ORDER BY fecha DESC";
$resultado = mysql_query($dbQuery) or print "No se pudo acceder al contenido de las pruebas online.";
if (mysql_num_rows($resultado) > 0){	
while($fila=mysql_fetch_array($resultado)){
	$idCarrera = $fila["idcarreras"];
	$descripcion = $fila["descripcion"];
	$fecha_larga = $fila["fecha_larga"];
	$organizador = $fila["organizador"];
	$fecha = $fila["fecha"];
	if($idCarrera!=0 || $idCarrera!='0'){// Si está creada desde el programa
		$organizador = utf8_encode(strtoupper($organizador));
	}
	$idWeb = $fila["idWeb"];
	$titulo = $fila["titulo"];
	$poblacion = $fila["poblacion"];
	$CarrerasyGrupos[$grupoItereator] = new Carrera(0,$idCarrera,$idWeb,$descripcion,$fecha_larga,$organizador,$fecha,$titulo,$poblacion);
	$grupoItereator++;
}
	$noFilas = true;
}
$dbQuery = "SELECT idGrupo, titulo, fecha, fecha_larga, temporada, organizador, poblacion, desactiva FROM grupos WHERE (desactiva = '0' OR desactiva IS NULL) AND temporada = '".$temporada."' ORDER BY fecha DESC";
$resultado = mysql_query($dbQuery) or print "No se pudo acceder al contenido de las pruebas online.";
if (mysql_num_rows($resultado) > 0){	
while($fila=mysql_fetch_array($resultado)){
	$fecha_larga = $fila["fecha_larga"];
	$organizador = $fila["organizador"];
	$fecha = $fila["fecha"];
	$idGrupo = $fila["idGrupo"];// Se supone que no deben de haber idGrupos en esta consulta
	if($idCarrera!=0 || $idCarrera!='0'){// Si está creada desde el programa
		$organizador = utf8_encode(strtoupper($organizador));
	}
	$titulo = $fila["titulo"];
	$poblacion = $fila["poblacion"];
	$CarrerasyGrupos[$grupoItereator] = new Carrera($idGrupo,0,0,"",$fecha_larga,$organizador,$fecha,$titulo,$poblacion);
	$grupoItereator++;
}
	$noFilas = true;
}
?>
<br>
<p class="titulo">
	<?php
		if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
			{
			echo "EVENTOS PARA LA TEMPORADA ".$temporada."</p>";
			echo "<br><table border='0' width='100%' id='tab_tem'><thead>";
			echo "<tr><th>Fecha</th><th>Poblaci&oacute;n</th><th>Evento</th><th>Organizador</th></thead>";
			}
		else{
			echo $temporada." SEASSON TRIALS</p>";
			echo "<br><table border='0' width='100%' id='tab_tem'><thead>";
			echo "<tr><th>Date</th><th>Location</th><th>Trial</th><th>Organizer</th></thead>";
			}
	?>
                <tbody>
<?php
if (!$noFilas)
	echo "<tr><td colspan='6'>No hay pruebas online disponibles.</td></tr>";
else{
	usort($CarrerasyGrupos, "Carrera::compararCarreras");//ordenar array por fecha
$par = 1;//Variable para saber si se trata de una fila par o impar
$par2 = 1;
$classgrupo = "grupopar";
$classcss="filaimpar";
for($i=0; $i<count($CarrerasyGrupos); $i++){
	if(diferenciafechas($hoy,$CarrerasyGrupos[$i]->fecha)>-5 && diferenciafechas($hoy,$CarrerasyGrupos[$i]->fecha)<8){
		$classcss="filamarcada";
	}
	else if($par%2==0){//La fila es par
		$classcss="filapar";
	}
	else {
		$classcss="filaimpar";
	}
	if($CarrerasyGrupos[$i]->idGrupo>0){//Este objeto carrera se ha creado de la información de un grupo
		if(isset($_GET['grupo']) && $CarrerasyGrupos[$i]->idGrupo==$_GET['grupo'])
			{
			$grupo = $_GET['grupo'];
			//echo "<tr class='espaciostabla'><td colspan='4'></td></tr><tr class='grupodefecto' onclick=\"cargar('../includes/tem_act.php','capa','con_bus')\"><td class='center negrita'>Click para cerrar</td><td>".$CarrerasyGrupos[$i]->poblacion."</td><td>".$CarrerasyGrupos[$i]->titulo."</td><td>".$CarrerasyGrupos[$i]->organizador."</td></tr>";
			//echo "<tr class='negrita'><td colspan='4' class='center'>Grupo de Eventos ".$CarrerasyGrupos[$i]->titulo.":</td></tr>";
				$dbQuery = "SELECT idGrupo, titulo FROM grupos WHERE idGrupo='$grupo' AND (desactiva = '0' OR desactiva IS NULL) ORDER BY idGrupo DESC";
				$resultado = mysql_query($dbQuery) or die("No se pudieron recuperar contenidos de la Base de Datos.");
				if(mysql_num_rows($resultado) != 0){
					$tituloGrupo = @mysql_result($resultado, 0, "titulo");
					$dbQuery = "SELECT idcarreras, descripcion, fecha_larga, organizador, fecha, idWeb, titulo, poblacion FROM carreras WHERE (desactivada = '0' OR desactivada IS NULL) AND temporada = '".$temporada."' AND idGrupo = '".$grupo."' ORDER BY fecha DESC";
					$resultado = mysql_query($dbQuery) or print "No se pudo acceder al contenido de las pruebas online.";
					if (mysql_num_rows($resultado) == 0)
						echo "<h3>El grupo seleccionado no existe.</h3>";
					else{
						while($fila=mysql_fetch_array($resultado)){
						$idCarrera = $fila["idcarreras"];
						$descripcion = $fila["descripcion"];
						$fecha_larga = $fila["fecha_larga"];
						$organizador = $fila["organizador"];
						$fecha = $fila["fecha"];
						if($idCarrera!=0 || $idCarrera!='0'){// Si está creada desde el programa
							$organizador = utf8_encode(strtoupper($organizador));
						}
						$idWeb = $fila["idWeb"];
						$titulo = $fila["titulo"];
						$poblacion = $fila["poblacion"];
								if($par2%2==0){//La fila es par
									$classgrupo="grupopar";
								}
								else {
									$classgrupo="grupoimpar";
								}
						$par2++;
						if($idCarrera==0 || $idCarrera=='0' || $idCarrera==NULL || $idCarrera==''){//Prueba creada a través de la WEB
								echo "<tr class='".$classgrupo."' onclick=\"location.href='prueba.php?pruebaweb=".$idWeb."&lang=".$_GET['lang']."'\"><td>".$fecha_larga."</td><td>".$poblacion."</td><td><a href='prueba.php?pruebaweb=".$idWeb."'>".$titulo."</a></td><td>".$organizador."</td></tr>";
							}
							else {//Prueba creada a través del PROGRAMA
								echo "<tr class='".$classgrupo."' onclick=\"location.href='prueba.php?pruebaprograma=".$idCarrera."&lang=".$_GET['lang']."'\"><td>".$fecha_larga."</td><td>----".$poblacion."</td><td><a href='prueba.php?pruebaprograma=".$idCarrera."'>".nombresTildes($titulo)."</a></td><td>".$organizador."</td></tr>";
							}
						}
					echo "<tr class='espaciostabla'><td colspan='4'></td></tr>";
					}
				}
			}
		else
			{
		$grupo = $CarrerasyGrupos[$i]->idGrupo;
		echo "<tr class='".$classcss."' onclick=\"location.href='prueba.php?grupo=".$grupo."&lang=".$_GET['lang']."'\"><td>".$CarrerasyGrupos[$i]->fecha_larga."</td><td>".$CarrerasyGrupos[$i]->poblacion."</td><td>".nombresTildes($CarrerasyGrupos[$i]->titulo)."</td><td>".$CarrerasyGrupos[$i]->organizador."</td></tr>";
			}
	}
	else {//Este objeto carrera se ha creado de la información de una carrera
		if($CarrerasyGrupos[$i]->idCarrera=='0' || $CarrerasyGrupos[$i]->idCarrera==NULL || $CarrerasyGrupos[$i]->idCarrera==''){//Prueba creada a través de la WEB
			echo "<tr class='".$classcss."' onclick=\"location.href='prueba.php?pruebaweb=".$CarrerasyGrupos[$i]->idWeb."&lang=".$_GET['lang']."'\">
			<td class='negrita'>".$CarrerasyGrupos[$i]->fecha_larga."</td>
			<td>".$CarrerasyGrupos[$i]->poblacion."</td>
			<td><a href='prueba.php?pruebaweb=".$CarrerasyGrupos[$i]->idWeb."&lang=".$_GET['lang']."'>".nombresTildes($CarrerasyGrupos[$i]->titulo)."</a></td>
			<td>".$CarrerasyGrupos[$i]->organizador."</td></tr>";
		}
		else {//Prueba creada a través del PROGRAMA
			echo "<tr class='".$classcss."' onclick=\"location.href='prueba.php?pruebaprograma=".$CarrerasyGrupos[$i]->idCarrera."&lang=".$_GET['lang']."'\">
			<td>".$CarrerasyGrupos[$i]->fecha_larga."</td>
			<td>".$CarrerasyGrupos[$i]->poblacion."</td>
			<td><a href='prueba.php?pruebaprograma=".$CarrerasyGrupos[$i]->idCarrera."&lang=".$_GET['lang']."'>".nombresTildes($CarrerasyGrupos[$i]->titulo)."</a></td>
			<td>".$CarrerasyGrupos[$i]->organizador."</td></tr>";
		}
	}
	//}
	$par++;
}
}
}
else
{
if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
		echo "<p class='titulo'>TEMPORADAS DISPONIBLES</p>";
	else
		echo "<p class='titulo'>AVALIABLE SEASSONS</p>";
	echo "<br>";
	$i=0;
	$anoActual = date("Y");
	$dbQuery = "SELECT temporada FROM carreras WHERE temporada < '".$anoActual."' GROUP BY temporada ORDER BY temporada DESC";
	$resultado = mysql_query($dbQuery) or print "No se pudo acceder al contenido de las pruebas en el archivo.";
	if (mysql_num_rows($resultado) == 0)
		echo "<h2>No hay temporadas anteriores en el archivo.</h2>";
	else{
	echo "<table width='100%'>";
		while($fila=mysql_fetch_array($resultado)){
			$temporada = $fila["temporada"];
			if($i==2){ echo "</tr><tr>";$i=0;}
			//echo "<a href='archivo.php?temporada=".$temporada."' class='linkG'>Temporada ".$temporada."</a><br>";
				if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
					echo "<td><div class='boton2'><a href='archivo.php?temporada=".$temporada."&lang=0'>Temporada ".$temporada."</div></a></td>";
				else
					echo "<td><div class='boton2'><a href='archivo.php?temporada=".$temporada."&lang=1'>".$temporada." Seasson</div></a></td>";
			$i++;
		}
	}
}

mysql_free_result($resultado);
mysql_close($conexion);
?>       
            </tbody>
            </table>
        </div>