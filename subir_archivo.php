<?php
session_start();
error_reporting(0);
include("conexion.php");
$id = $_GET['id'];
if (!isset($_SESSION['pass']) && empty($_SESSION['pass']))
		echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=acceso.php?id='.$id.'&error=1">';
$id = $_POST['id'];
$temporada = $_POST['temporada'];
$tipo = $_POST['tipo'];
$titulo = $_POST['titulo'];
	if($titulo!="")
	{
		$target_path = "../archivos/".$temporada."/idcarreras".$id."/".$tipo."/";
		$ruta = "archivos/".$temporada."/idcarreras".$id."/".$tipo."/".basename( $_FILES['archivo']['name']);
		$target_path = $target_path . basename( $_FILES['archivo']['name']); 
		if(move_uploaded_file($_FILES['archivo']['tmp_name'], $target_path)) {
			echo "El archivo ".  basename( $_FILES['archivo']['name']). 
			" ha sido subido";
			if($tipo=="previa")
				{
				$sql = mysql_query("SELECT * from infoprevia WHERE idcarreras = '$id'");
					if(mysql_num_rows($sql)!=0)
						{
						$sql2 = mysql_query("SELECT MAX(idInfo) AS max_info from infoprevia WHERE idcarreras='$id'");
						if($fila=mysql_fetch_array($sql2))
							{
							$idinfo = $fila["max_info"];
							}
						$idinfo++;
						$cons = mysql_query("INSERT into infoprevia (idcarreras,idWeb,idInfo,titulo,archivo,activo) VALUES ('$id','0','$idinfo','$titulo','$ruta','1')");
						}
					else	
						$sql = mysql_query("INSERT INTO infoprevia (idcarreras,idWeb,idInfo,titulo,archivo,activo) VALUES ('$id',0,'1','$titulo','$ruta','1')");
				}
				if($tipo=="carrera")
				{
				$sql = mysql_query("SELECT * from infocarrera WHERE idcarreras = '$id'");
					if(mysql_num_rows($sql)!=0)
						{
						$sql2 = mysql_query("SELECT MAX(idInfo) AS max_info from infocarrera WHERE idcarreras='$id'");
						if($fila=mysql_fetch_array($sql2))
							{
							$idinfo = $fila["max_info"];
							}
						$idinfo++;
						$cons = mysql_query("INSERT into infocarrera (idcarreras,idWeb,idInfo,titulo,archivo,activo) VALUES ('$id','0','$idinfo','$titulo','$ruta','1')");
						}
					else	
						$sql = mysql_query("INSERT INTO infocarrera (idcarreras,idWeb,idInfo,titulo,archivo,activo) VALUES ('$id',0,'1','$titulo','$ruta','1')");
				}
				if($tipo=="direccion")
				{
				$sql = mysql_query("SELECT * from infodireccion WHERE idcarreras = '$id'");
					if(mysql_num_rows($sql)!=0)
						{
						$sql2 = mysql_query("SELECT MAX(idInfo) AS max_info from infodireccion WHERE idcarreras='$id'");
						if($fila=mysql_fetch_array($sql2))
							{
							$idinfo = $fila["max_info"];
							}
						$idinfo++;
						$cons = mysql_query("INSERT into infodireccion (idcarreras,idWeb,idInfo,titulo,archivo,activo) VALUES ('$id','0','$idinfo','$titulo','$ruta','1')");
						}
					else	
						$sql = mysql_query("INSERT INTO infodireccion (idcarreras,idWeb,idInfo,titulo,archivo,activo) VALUES ('$id',0,'1','$titulo','$ruta','1')");
				}
				if($tipo=="comisarios")
				{
				$sql = mysql_query("SELECT * from infocomisarios WHERE idcarreras = '$id'");
					if(mysql_num_rows($sql)!=0)
						{
						$sql2 = mysql_query("SELECT MAX(idInfo) AS max_info from infocomisarios WHERE idcarreras='$id'");
						if($fila=mysql_fetch_array($sql2))
							{
							$idinfo = $fila["max_info"];
							}
						$idinfo++;
						$cons = mysql_query("INSERT into infocomisarios (idcarreras,idWeb,idInfo,titulo,archivo,activo) VALUES ('$id','0','$idinfo','$titulo','$ruta','1')");
						}
					else	
						$sql = mysql_query("INSERT INTO infocomisarios (idcarreras,idWeb,idInfo,titulo,archivo,activo) VALUES ('$id',0,'1','$titulo','$ruta','1')");
				}
		echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=edi_tablon.php?id='.$id.'">';
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