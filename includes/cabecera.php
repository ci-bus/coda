	<div id="social">
		<a href="https://es-es.facebook.com/pages/CD-CODA-Cronometradores-y-Oficiales-De-Automovilismo/174390805936830" target="_blank"><img src="../images/icon_face.png" width="60px"></a>
		<a href="https://twitter.com/CD_CODA" target="_blank"><img src="../images/icon_twitter.png" width="60px"></a>
		<a target="_new" href="../../aplicacion/android/descarga.php"><img src="../images/icon_andro.png" width="60px"></a>
		<a target="_new" href="../../aplicacion/winmobile/descarga.php"><img src="../images/icon_win.png" width="60px"></a>
	</div>
	<div id="busca">
	<form action="buscador.php" method="post">
		<?php if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
				echo "<p class='negro'>BUSCADOR: <input type='text' class='formu1' name='busqueda'></p>";
			  else
				echo "<p class='negro'>SEARCH: <input type='text' class='formu1' name='busqueda'></p>";
			?>
		</form>
	</div>
		<div id="lang">
		<?php 
			$url1="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
			$url1 = str_replace('lang=1','lang=0',$url1);
			$url2="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
			$url2 = str_replace('lang=0','lang=1',$url2);
		?>	
			<a href="<?php echo $url1; ?>"><img src="../images/espa.jpg" width="40px"></a>
			<a href="<?php echo $url2; ?>"><img src="../images/engl.jpg" width="40px"></a>
		</div>
	<?php 
		if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
			echo "<div id='logo' onclick=\"window.location.href = '../paginas/index.php?lang=0'\">";
		else
			echo "<div id='logo' onclick=\"window.location.href = '../paginas/index.php?lang=1'\">";
$dia = date('d');
$mes = date('m');
	if ($mes=='12' || $mes=='01' && $dia=='01' || $mes=='01' && $dia=='02' || $mes=='01' && $dia=='03' || $mes=='01' && $dia=='04' || $mes=='01' && $dia=='05' || $mes=='01' && $dia=='06')
		if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
			echo "<a href='../index.php?lang=0'><img src='../images/codanavi.png' width='300px'></a>";
		else
			echo "<a href='../index.php?lang=1'><img src='../images/codanavi.png' width='300px'></a>";
	else
		if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
			echo "<a href='../index.php?lang=0'><img src='../images/coda.png' width='300px'></a>";
		else
			echo "<a href='../index.php?lang=1'><img src='../images/coda.png' width='300px'></a>";
?>
</div>
<div id="menu">
<?php 
	$browser = $_SERVER['HTTP_USER_AGENT'];
	$browser = substr("$browser", 25, 8);
	if ($browser == "MSIE 6.0")
		{
		include('../includes/menuexpl.php');
		}
	else
		{
		include('../includes/menu.php');
		}
	?>
</div>