<?php
session_start();
	session_destroy();
	$id = $_GET['id'];
	if(isset($_GET['newBD']))
		echo '<META HTTP-EQUIV=Refresh CONTENT="1; URL=prueba_new.php?id='.$id.'&newBD=true">';
	else
		echo '<META HTTP-EQUIV=Refresh CONTENT="1; URL=prueba.php?id='.$id.'">';
?>