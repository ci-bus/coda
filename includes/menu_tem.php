	<li class="oe_heading">
		<?php if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
				echo "Ultimos Eventos</li>";
			  else
				echo "Latests Events</li>";
//include('conexion.php');
//$IPservidor = "85.238.8.44";
$IPservidor = "localhost";
$nombreBD = "coda";
$usuario = "manuel";
$clave = "coda200900==";
$conexion = mysql_connect($IPservidor, $usuario, $clave) or die("<h2>No hay conexi&oacute;n con el servidor MySQL.'conexion.php'</h2>");
mysql_query ("SET NAMES 'utf8'");
mysql_select_db($nombreBD) or die('no se encontro la bd');
include_once("dateAfecha.php");//para hacer operaciones con fechas
//include("nombresTildes.php");
$hoy=date("Y-m-d");
include("CarreraObject.php");//Clase Carrera, para instanciar objetos de tipo Carrera des la información de la Base de Datos, tablas carreras y grupos.
$anoActual = date("Y");
$noFilas = false;// Variable que indica si hay filas en las consultas a la Base de Datos
$CarrerasyGrupos = array();// Array para guardar los objetos Carrera
$grupoItereator = 0;// Iterador del array $CarrerasyGrupos
$dbQuery = "SELECT idcarreras, descripcion, fecha_larga, organizador, fecha, idWeb, titulo, poblacion FROM carreras WHERE (desactivada = '0' OR desactivada IS NULL) AND (idGrupo = '0' OR idGrupo IS NULL OR idGrupo IN (SELECT idGrupo FROM pruebas_especiales)) AND temporada = '".$anoActual."' ORDER BY fecha DESC limit 7";
$resultado = mysql_query($dbQuery) or print "No se pudo acceder al contenido de las pruebas online.";
if (mysql_num_rows($resultado) > 0){	
while($fila=mysql_fetch_array($resultado)){
	$idCarrera = $fila["idcarreras"];
	$descripcion = $fila["descripcion"];
	$fecha_larga = $fila["fecha_larga"];
	$organizador = $fila["organizador"];
	$fecha = $fila["fecha"];
	if($idCarrera!='0'){// Si está creada desde el programa
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
$dbQuery = "SELECT idGrupo, titulo, fecha, fecha_larga, temporada, organizador, poblacion, desactiva FROM grupos WHERE (desactiva = '0' OR desactiva IS NULL) AND idGrupo NOT IN (SELECT idGrupo FROM pruebas_especiales) AND temporada = '".$anoActual."' ORDER BY fecha DESC";
$resultado = mysql_query($dbQuery) or print "No se pudo acceder al contenido de las pruebas online.";
if (mysql_num_rows($resultado) > 0){	
while($fila=mysql_fetch_array($resultado)){
	$fecha_larga = $fila["fecha_larga"];
	$organizador = $fila["organizador"];
	$fecha = $fila["fecha"];
	$idGrupo = $fila["idGrupo"];// Se supone que no deben de haber idGrupos en esta consulta
	$titulo = $fila["titulo"];
	$poblacion = $fila["poblacion"];
	$CarrerasyGrupos[$grupoItereator] = new Carrera($idGrupo,0,0,"",$fecha_larga,$organizador,$fecha,$titulo,$poblacion);
	$grupoItereator++;
}
	$noFilas = true;
}
if (!$noFilas)
	echo "<li>No hay pruebas online disponibles.</li>";
else{
	usort($CarrerasyGrupos, "Carrera::compararCarreras");//ordenar array por fecha
for($i=0; $i<count($CarrerasyGrupos); $i++){
	if($CarrerasyGrupos[$i]->idGrupo>0){//Este objeto carrera se ha creado de la información de un grupo
if(isset($_GET['grupo']) && $CarrerasyGrupos[$i]->idGrupo==$_GET['grupo'])
			{
			$grupo = $_GET['grupo'];
			//echo "<li onclick=\"cargar('../includes/tem_act.php','capa','con_bus')\">".$CarrerasyGrupos[$i]->titulo."</li>";
			//echo "<tr class='negrita'><td colspan='4' class='center'>Grupo de Eventos ".$CarrerasyGrupos[$i]->titulo.":</td></tr>";
				$dbQuery = "SELECT idGrupo, titulo FROM grupos WHERE idGrupo='$grupo' AND (desactiva = '0' OR desactiva IS NULL) ORDER BY idGrupo DESC";
				$resultado = mysql_query($dbQuery) or die("No se pudieron recuperar contenidos de la Base de Datos.");
				if(mysql_num_rows($resultado) != 0){
					$tituloGrupo = @mysql_result($resultado, 0, "titulo");
					$dbQuery = "SELECT idcarreras, descripcion, fecha_larga, organizador, fecha, idWeb, titulo, poblacion FROM carreras WHERE (desactivada = '0' OR desactivada IS NULL) AND temporada = '".$anoActual."' AND idGrupo = '".$grupo."' GROUP BY idGrupo ORDER BY fecha DESC";
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
						if($idCarrera=='0' || $idCarrera==NULL || $idCarrera==''){//Prueba creada a través de la WEB
								echo "<li style='font-style:italic;'><a href='prueba.php?grupo=".$grupo."&lang=".$_GET['lang']."'>".$tituloGrupo."</a></li>";
							}
							else {//Prueba creada a través del PROGRAMA
								echo "<li style='font-style:italic;'><a href='prueba.php?grupo=".$grupo."&lang=".$_GET['lang']."'>".$tituloGrupo."</a></li>";
							}
						}
					//echo "<tr class='espaciostabla'><td colspan='4'></td></tr>";
					}
				}
			}
		else
			{
		$grupo = $CarrerasyGrupos[$i]->idGrupo;
		echo "<li style='font-style:italic;'><a href='prueba.php?grupo=".$grupo."&lang=".$_GET['lang']."'>".$CarrerasyGrupos[$i]->titulo."</a></li>";
			}
	}
	else {//Este objeto carrera se ha creado de la información de una carrera
		if($CarrerasyGrupos[$i]->idCarrera=='0' || $CarrerasyGrupos[$i]->idCarrera==NULL || $CarrerasyGrupos[$i]->idCarrera==''){//Prueba creada a través de la WEB
			echo "<li><a href='prueba.php?pruebaweb=".$CarrerasyGrupos[$i]->idWeb."&lang=".$_GET['lang']."'>".$CarrerasyGrupos[$i]->titulo."</a></li>";
		}
		else {//Prueba creada a través del PROGRAMA
			echo "<li><a href='prueba.php?pruebaprograma=".$CarrerasyGrupos[$i]->idCarrera."&lang=".$_GET['lang']."'>".$CarrerasyGrupos[$i]->titulo."</a></li>";
		}
	}
	//}
	$par++;
}
}
?>