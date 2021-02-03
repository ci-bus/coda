<div id="pie_cont">

		<div id="pie_uno">
			<div id="margen2">
			<?php
				if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
					{
					echo "<p class='color1' onclick=\"window.location.href = '../paginas/index.php?lang=0'\">Inicio</p>";
					echo "<p class='color2' onclick=\"window.location.href = '../paginas/calendario.php?lang=0'\">Calendario de Eventos</p>";
					echo "<p class='color3' onclick=\"window.location.href = '../paginas/temporada.php?lang=0'\">Temporada ".date('Y')."</p>";
					echo "<p class='color4' onclick=\"window.location.href = '../paginas/noticias.php?lang=0'\">Noticias</p>";
					echo "<p class='color5' onclick=\"window.location.href = '../paginas/federaciones.php?lang=0'\">Federaciones</p>";
					echo "<p class='color6' onclick=\"window.location.href = '../paginas/circuitos.php?lang=0'\">Circuitos</p>";
					echo "<p class='color7' onclick=\"window.location.href = '../paginas/galerias.php?lang=0'\">Galer&iacute;a de Im&aacute;genes</p>";
					echo "<p class='color8' onclick=\"window.location.href = '../paginas/quienes.php?lang=0'\">Acerca de C.O.D.A</p>";
					echo "<p class='color9' onclick=\"window.location.href = '../paginas/quienes.php?lang=0'\">Ir a version Movil</p>";
					}
				else
					{
					echo "<p class='color1' onclick=\"window.location.href = '../paginas/index.php?lang=1'\">Home</p>";
					echo "<p class='color2' onclick=\"window.location.href = '../paginas/calendario.php?lang=1'\">Events Calendar</p>";
					echo "<p class='color3' onclick=\"window.location.href = '../paginas/temporada.php?lang=1'\">".date('Y')." Seasson</p>";
					echo "<p class='color4' onclick=\"window.location.href = '../paginas/noticias.php?lang=1'\">News</p>";
					echo "<p class='color5' onclick=\"window.location.href = '../paginas/federaciones.php?lang=1'\">Federations</p>";
					echo "<p class='color6' onclick=\"window.location.href = '../paginas/circuitos.php?lang=1'\">Circuits</p>";
					echo "<p class='color7' onclick=\"window.location.href = '../paginas/galerias.php?lang=1'\">image Gallery</p>";
					echo "<p class='color8' onclick=\"window.location.href = '../paginas/quienes.php?lang=1'\">About C.O.D.A</p>";
					echo "<p class='color9' onclick=\"window.location.href = '../paginas/quienes.php?lang=1'\">Mobile Version</p>";
					}
			?>
			</div>
		</div>
		<div id="pie_dos">
			<div id="margen1">
			<p class="titulo2" style="margin: 0 0 0 22px">
			<?php	if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
						echo "Informacion y Contacto</p>";
					else
						echo "Infomation & Contact</p>";
			?>
				<br>
			<p style="font-style: italic;font-weight: bold;text-transform: lowercase; margin:0 0 0 98px;">info@codea.es</p>
				<br>
			<p style="font-size:25px;font-style: italic;font-weight: bold;text-transform: lowercase; margin:0 0 0 68px;">www.codea.es</p>
				<br>
			<div id="social2">
				<a href="https://es-es.facebook.com/pages/CD-CODA-Cronometradores-y-Oficiales-De-Automovilismo/174390805936830" target="_blank"><img src="../images/icon_face.png" width="50px"></a>
				<a href="https://twitter.com/CD_CODA" target="_blank"><img src="../images/icon_twitter.png" width="50px"></a>
				<img src="../images/icon_andro.png" width="50px">
			</div>
			</div>
		</div>
		
		<div id="pie_tres">
				<a href="http://www.newsys.es" target="_blank">
			<div id="by" class="titulo2">by<br>
			</div>
			</a>
		</div>
		
		<div id="pie_cuatro">
		<p class="titulo" align="center" style="color:#ccc">
			<?php if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
						echo "VISITAS</p>";
				  else
						echo "VISITORS</p>";
				include_once("../includes/visitas.php");
			?>
		</div>
		
	<div id="pie_cinco"><br>
	<p class="titulo3">Club Deportivo coda, Cronometradores y Oficiales de Automovilismo &copy; <?php echo date('Y');?></p>
	</div>
</div>