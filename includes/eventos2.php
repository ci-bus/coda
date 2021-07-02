<div id="eventos2_izq">

		<p class="eventos2_t" class="cufon">SPONSORS</p>
	
			<?php
			error_reporting(5);
			include('../includes/conexion.php');
			$ruta = "../images/sponsors/";
			$directorio = opendir($ruta); 
			while ($archivo = readdir($directorio))
			{
				if (!is_dir($archivo) && $archivo!='Thumbs.db')
				{
					$cons= mysql_query("SELECT enlace from imagenes WHERE nombre='$archivo'");
					if(mysql_num_rows($cons))
						{
						while($fil= mysql_fetch_array($cons))
							{
							$enlace = $fil['enlace'];
							}
						}
					if($enlace=='' | $enlace==' ')
								echo "<img src='".$ruta.$archivo."' width='160px'>";
					else
					echo "<a href='".$enlace."' target='_blank'><img src='".$ruta.$archivo."' width='160px'></a>";
				}
			}
		?>
</div>

	<div id="eventos2_centro">
		<div id="capa">
		<img src="../images/cargando.gif" width="150px">
		</div>
		<p class="eventos2_t">
		<?php if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
				echo "REDES SOCIALES";
			else
				echo "SOCIAL NETWORKS";
		?>
		</p>
		<div id="redes_sociales">
			<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FCD-CODA-Cronometradores-y-Oficiales-De-Automovilismo%2F174390805936830&amp;width=530&amp;height=427&amp;colorscheme=light&amp;show_faces=false&amp;header=true&amp;stream=true&amp;show_border=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:500px; height:400px;" allowTransparency="true"></iframe>
		</div>
			<div class="eventos2_t2" align="center" style="height:50px;">
				<?php
					$browser = $_SERVER['HTTP_USER_AGENT'];
					$browser = substr("$browser", 25, 8);
				?>	
				<div class="twitter" onclick="cargar('twiter.php','capa','redes_sociales')"><?php if ($browser == "MSIE 6.0") echo 'Twitter';?></div>
				<div class="facebook" onclick="cargar('facebook.php','capa','redes_sociales')"><?php if ($browser == "MSIE 6.0") echo 'Facebook';?></div>
				<div class="youtube" onclick="cargar('youtube.php','capa','redes_sociales')"><?php if ($browser == "MSIE 6.0") echo 'Youtube';?></div>
			</div>
	</div>
		
		
	<div id="eventos2_der">

				<p class="eventos2_t" align="center" style="margin:5px auto;">
				<?php if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
						echo "WEB OFICIAL DE";
					else
						echo "OFFICIAL SITE";
					?>
				</p>
		<br>	
						<?php
					$ruta = "../images/patrocina/";
					$directorio = opendir($ruta); 
					while ($archivo = readdir($directorio))
					{
						if (!is_dir($archivo) && $archivo!='Thumbs.db')
						{
							$cons= mysql_query("SELECT enlace from imagenes WHERE nombre='$archivo'");
							if(mysql_num_rows($cons))
								{
								while($fil= mysql_fetch_array($cons))
									{
									$enlace = $fil['enlace'];
									}
								}
							//echo "<a href='".$enlace."' target='_blank'><img src='".$ruta.$archivo."' width='180px'></a><br>";
							if($enlace=='' | $enlace==' ')
								echo "<img src='".$ruta.$archivo."' width='180px'><br>";
							else
								echo "<a href='".$enlace."'><img src='".$ruta.$archivo."' width='180px'></a><br>";
						}
					}
				?>
	</div>
	
	<div id="eventos2_deb1">
	<p class="menus1">
		<?php if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
				echo "MUNDO RALLY";
			  else
				echo "WORLD RALLY";
			?>
		</p>
		<?php include("../includes/rss.php");?>
			<!--iframe src="http://codea.sinfoal.com/normal/paginas/rss2.php" width="1000px" height="500px" scrolling=no frameborder='0'>	
			</iframe-->
	</div>