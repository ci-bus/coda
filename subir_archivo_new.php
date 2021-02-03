<?php
session_start();
error_reporting(0);
	$IPservidor = "localhost";
	$nombreBD = "codea_es_sistema";
	$usuario = "manuel";
	$clave = "coda200900==";
$conexion = mysql_connect($IPservidor, $usuario, $clave) or die("<h2>No hay conexi&oacute;n con el servidor MySQL</h2>");
mysql_query ("SET NAMES 'utf8'");
mysql_select_db($nombreBD) or die('no se encontro la bd');
$id = $_GET['id'];
if (!isset($_SESSION['pass']) && empty($_SESSION['pass']))
		echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=acceso_new.php?id='.$id.'&error=1&newBD=true">';
$id = $_POST['id'];
$temporada = $_POST['temporada'];
$tipo = $_POST['tipo'];
$titulo = $_POST['titulo'];
$id_usuario = $_POST['id_usuario'];
	if($titulo!="")
	{
		$target_path = "../archivos/".$temporada."/".$id."/info".$tipo."/";
		echo $target_path;
		$ruta = "archivos/".$temporada."/".$id."/info".$tipo."/".basename( $_FILES['archivo']['name']);
		$target_path = $target_path . basename( $_FILES['archivo']['name']); 
		if(move_uploaded_file($_FILES['archivo']['tmp_name'], $target_path)) {
			echo "El archivo ".  basename( $_FILES['archivo']['name']). 
			" ha sido subido";
			if($tipo=="previa")
				{
					
				$sql = mysql_query("SELECT * from abc_57os_ca_carrera_archivo WHERE id_ca_carrera = '$id' AND tipo='previa'");
					if(mysql_num_rows($sql)!=0)
						{
						
						$sql2 = mysql_query("SELECT MAX(orden) AS max_info from abc_57os_ca_carrera_archivo WHERE id_ca_carrera='$id' AND tipo='previa'");
						if($fila=mysql_fetch_array($sql2))
							{
							$idinfo = $fila["max_info"];
							}
						$idinfo++;
						$cons = mysql_query("INSERT into abc_57os_ca_carrera_archivo (id,id_usuario,id_ca_carrera,nombre,tipo,url_archivo,orden) 
						VALUES ('','$id_usuario','$id','$titulo','$tipo','$ruta','$idinfo')");
						}
					else	
						$sql = mysql_query("INSERT into abc_57os_ca_carrera_archivo (id,id_usuario,id_ca_carrera,nombre,tipo,url_archivo,orden) 
						VALUES ('','$id_usuario','$id','$titulo','$tipo','$ruta','1')");
				}
			if($tipo=="carrera")
				{
				$sql = mysql_query("SELECT * from abc_57os_ca_carrera_archivo WHERE id_ca_carrera = '$id' AND tipo='carrera'");
					if(mysql_num_rows($sql)!=0)
						{
						echo "carrera";
						$sql2 = mysql_query("SELECT MAX(orden) AS max_info from abc_57os_ca_carrera_archivo WHERE id_ca_carrera='$id' AND tipo='carrera'");
						if($fila=mysql_fetch_array($sql2))
							{
							$idinfo = $fila["max_info"];
							}
						$idinfo++;
						$cons = mysql_query("INSERT into abc_57os_ca_carrera_archivo (id,id_usuario,id_ca_carrera,nombre,tipo,url_archivo,orden) 
						VALUES ('','$id_usuario','$id','$titulo','$tipo','$ruta','$idinfo')");
						}
					else	
						$sql = mysql_query("INSERT into abc_57os_ca_carrera_archivo (id,id_usuario,id_ca_carrera,nombre,tipo,url_archivo,orden) 
						VALUES ('','$id_usuario','$id','$titulo','$tipo','$ruta','1')");
				}
				if($tipo=="direccion")
				{
					echo "direccion";
				$sql = mysql_query("SELECT * from abc_57os_ca_carrera_archivo WHERE id_ca_carrera = '$id' AND tipo='direccion'");
					if(mysql_num_rows($sql)!=0)
						{
						
						$sql2 = mysql_query("SELECT MAX(orden) AS max_info from abc_57os_ca_carrera_archivo WHERE id_ca_carrera='$id' AND tipo='direccion'");
						if($fila=mysql_fetch_array($sql2))
							{
							$idinfo = $fila["max_info"];
							}
						$idinfo++;
						$cons = mysql_query("INSERT into abc_57os_ca_carrera_archivo (id,id_usuario,id_ca_carrera,nombre,tipo,url_archivo,orden) 
						VALUES ('','$id_usuario','$id','$titulo','$tipo','$ruta','$idinfo')");
						}
					else	
						$sql = mysql_query("INSERT into abc_57os_ca_carrera_archivo (id,id_usuario,id_ca_carrera,nombre,tipo,url_archivo,orden) 
						VALUES ('','$id_usuario','$id','$titulo','$tipo','$ruta','1')");
				}
				if($tipo=="comisarios")
				{
				$sql = mysql_query("SELECT * from abc_57os_ca_carrera_archivo WHERE id_ca_carrera = '$id' AND tipo='comisarios'");
					if(mysql_num_rows($sql)!=0)
						{
						
						$sql2 = mysql_query("SELECT MAX(orden) AS max_info from abc_57os_ca_carrera_archivo WHERE id_ca_carrera='$id' AND tipo='comisarios'");
						if($fila=mysql_fetch_array($sql2))
							{
							$idinfo = $fila["max_info"];
							}
						$idinfo++;
						$cons = mysql_query("INSERT into abc_57os_ca_carrera_archivo (id,id_usuario,id_ca_carrera,nombre,tipo,url_archivo,orden) 
						VALUES ('','$id_usuario','$id','$titulo','$tipo','$ruta','$idinfo')");
						}
					else	
						$sql = mysql_query("INSERT into abc_57os_ca_carrera_archivo (id,id_usuario,id_ca_carrera,nombre,tipo,url_archivo,orden) 
						VALUES ('','$id_usuario','$id','$titulo','$tipo','$ruta','1')");
				}
		echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=edi_tablon_new.php?id='.$id.'&newBD=true">';
		} else{
			echo "Ha ocurrido un error, trate de nuevo!";
		}
	}
	else{
		echo "el CAMPO titulo esta vacio";
		
		}
	 
/*
include('../../normal/includes/conexion.php');
$prueba = $_GET['id'];
$archivo2 = $_POST['nombre_archivo'];
$archivo3 = str_replace(' ','_',$archivo2);
$ruta="../../../archivos/".date('Y')."/idcarreras".$prueba."/previa/";
if (isset($_FILES['archivo'])) 
	{
    $archivo = $_FILES['archivo'];
    $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
	$time = time();
    $nombre = $archivo3.".".$extension;
	$archi = $ruta.$nombre;
		if (move_uploaded_file($archivo['tmp_name'], $ruta.$nombre)) 
		{
		/*HABRA QUE VALIDAR LAS PRUEBAS WEB y LAS PROGRAMA, AHORA MISMO LO DEJO SOLO PARA EL PRoGRAMA
		if($tipo == 0){
			$sql = mysql_query("SELECT * from infoprevia WHERE idcarreras = '$prueba'");
					if(mysql_num_rows($sql)!=0)
						{
						$sql2 = mysql_query("SELECT MAX(idInfo) AS max_info from infoprevia WHERE idcarreras='$prueba'");
						if($fila=mysql_fetch_array($sql2))
							{
							$idinfo = $fila["max_info"];
							}
						$idinfo++;
						//$prueba = substr($prueba,1);
						$cons = mysql_query("INSERT into infoprevia (idcarreras,idWeb,idInfo,titulo,archivo,activo) VALUES ('$prueba','0','$idinfo','$archivo2','$archi','1')");
						}
					else	
						$sql = mysql_query("INSERT INTO infoprevia (idcarreras,idWeb,idInfo,titulo,archivo,activo) VALUES ('$prueba',0,'1','$archivo2','$archi','1')");
		/*else
					{
			$sql = mysql_query("SELECT MAX(idInfo) AS max_info from infoprevia WHERE idcarreras='$prueba'");
			if($fila=mysql_fetch_array($sql))
					$idinfo = $fila["max_info"];
			$idinfo++;
			$archi = $ruta.$nombre;
			$cons = mysql_query("INSERT into infocarrera (idcarreras,idWeb,idInfo,titulo,archivo,activo) VALUES ('$prueba','0','$idinfo','$archivo2','$archi','1')");
			}
        echo 1;
		} 
		else 
		{
        echo 0;
		}
	}	*/
?>