<?php
/*ARCHIVO DE VALIDACION PARA USUARIOS DE LA WEB*/
if (!isset($_SESSION['id_uss']) && empty($_SESSION['id_uss']))
		echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../error.html">';
		if(!isset($_SESSION['permisos']) && empty($_SESSION['permisos']))
			echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../error.html">';
			if(!isset($_SESSION['pass']) && empty($_SESSION['pass']))
				echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=../error.html">';
?>
