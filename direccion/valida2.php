<?php
/*ARCHIVO DE VALIDACION PARA SUPERUSUARIO*/
if (!isset($_SESSION['pass']) && empty($_SESSION['pass']))
		{
		session_start();
		session_destroy();
		echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=error.html">';
		}
?>
