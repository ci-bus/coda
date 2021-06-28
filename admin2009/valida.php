<?php
$uss = $_POST['uss'];
$pass = $_POST['pass'];
	if (isset($_POST['uss']) && !empty($_POST['uss']) && isset($_POST['pass']) && !empty($_POST['pass']) && $_POST['uss']!='' && $_POST['pass']!='')
		{
			include("../conexion.php");
		$sql = $mysqli2->query("SELECT * FROM web_usuarios WHERE uss='$uss' && pass='$pass'") or print("Error Accediendo a la B.D");	
			if($fila=$sql->fetch_array())
				{
					echo "usuario encontrado, accediendo a Dashboard";
				$permisos = $fila["permisos"];
				$activo = $fila["activo"];
				$id_uss = $fila["id"];
				}
				if($activo==1 || $activo=='1')
					{
					session_start();
					$_SESSION['usuario']= $uss;
					$_SESSION['id_uss'] = $id_uss;
					$_SESSION['permisos']= $permisos;
					$_SESSION['pass'] = $pass;
					echo "<img src='cargando.gif' style='left:35%;margin: 5% auto;position:absolute;'>";
					//$conexiones = mysql_query("INSERT INTO conexiones (usuario,ip,fecha,id_conexion) VALUES ('$uss','$ip','$todo','')") or die('hubo problemas de acceso a B.D');
					echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=examples/index.php?newDB=true">';			
					}
				else //USUARIO NO ACTIVO
					{
					echo "<img src='cargando.gif' style='left:35%;margin: 5% auto;position:absolute;'>";
					echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=index.php?error=1">';
					}
		}
	else
		{
		echo "<img src='cargando.gif' style='left:35%;margin: 5% auto;position:absolute;'>";
		echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=index.php?error=2">';
		}
?>

