<div class="oe_wrapper">
		<div id="oe_overlay" class="oe_overlay"></div>
			<ul id="oe_menu" class="oe_menu">
				<li style="font-size:xx-large;">
				<?php if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
						echo "<a href='../paginas/index.php?lang=0'>Inicio";
					  else
						echo "<a href='../paginas/index.php?lang=1'>Home";
						?>
				</a>		
				</li>
				<li style="width:142px;margin:0 22px 0 0 ;">
				<?php if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
						echo "<a href='temporada.php?lang=0' style='width:142px;'>Temporada ".date('Y')."</a>";
					  else
						echo "<a href='temporada.php?lang=1' style='width:142px;'>".date('Y')." Seasson</a>";;
						?>
					<div style="left:-111px;"><!-- -112px -->
					<ul class="oe_full">
						<?php
							include('menu_tem.php');
						?>
						<ul>
					</div>
				</li>
				<li>
				<?php if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
							echo "<a href='../paginas/archivo.php?lang=0'>Archivo</a>";
					  else
							echo "<a href='../paginas/archivo.php?lang=1'>Archive</a>";
				?>
					<div style="left:-183px;">
						<ul class="oe_heading">
							<li class="oe_heading">
							<?php
						if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
							echo "Temporadas Disponibles:</li>";
						else
							echo "Avaliable Seassons:</li>";
							$i=0;
							$j=0;
							$anio= date('Y')-1;
								while($anio!='2009' || $anio!=2009){
									if($i==8){
										echo "</ul><ul>";
										}
									if($j==19){
										echo "</ul><ul>";
										$i=0;
										}
										if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
											echo "<li><a href='../paginas/archivo.php?temporada=".$anio."&lang=0'>Temporada ".$anio."</a></li>";
										else
											echo "<li><a href='../paginas/archivo.php?temporada=".$anio."&lang=1'>".$anio." Seasson</a></li>";
											$anio-=1;
											$j++;
											$i++;
											}
							?>
						</ul>
					</div>
				</li>
				<li>
						<?php if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
									echo "<a href='galerias.php?lang=0'>Galerias</a>";
							  else
									echo "<a href='galerias.php?lang=1'>Gallery</a>";
						?>			
						<div style="left:-255px;">
						<ul class="oe_full">
							<li class="oe_heading">
							<?php
								if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
									echo "ULTIMAS GALERIAS DE IMAGENES</li>";
								else
									echo "LATESTS IMAGE GALLERY</li>";
								include("menu_gal.php");
							?>
						</ul>
					</div>
				</li>
				<li><a href="#">
					<?php if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
							echo "Enlaces</a>";
						  else
							echo "Links</a>";
					echo "<div style='left:-327px;'>";
					echo "<ul class='oe_full'>";
						if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
							{
							echo "<li class='oe_heading'>De Interes</li>";
							echo "<li><a href='federaciones.php?lang=0'>Federaciones</a></li>";
							echo "<li><a href='circuitos.php?lang=0'>Circuitos</a></li>";
							echo "<li><a href='info_motor.php?lang=0'>Informacion del motor</a></li>";
							}
						else
							{
							echo "<li class='oe_heading'>Of interest</li>";
							echo "<li><a href='federaciones.php?lang=1'>Federations</a></li>";
							echo "<li><a href='circuitos.php?lang=1'>Circuits</a></li>";
							echo "<li><a href='info_motor.php?lang=1'>Motor Information</a></li>";
							}
					?>
						</ul>
					</div>
				</li>
				<li><a href="#">
					<?php if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
							echo "Noticias</a>";
						  else
							echo "News</a>";
					?>
					<div style="left:-409px;">
						<ul class="oe_full">
						<?php if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
									{
									echo "<li class='oe_heading'>Noticias</li>";
									echo "<li><a href='noticias.php?lang=0'>Mundo Motor</a></li>";
									echo "<li><a href='calendario.php?lang=0'>Calendario de Temporada</a></li>";
									}
							  else{
									echo "<li class='oe_heading'>News</li>";
									echo "<li><a href='noticias.php?lang=1'>World Rally</a></li>";
									echo "<li><a href='calendario.php?lang=1'>Events Calendar</a></li>";
								  }
						?>
						</ul>
					</div>
				</li>
				<li style="width:122px;margin:0 22px 0 0 ;">
					<?php if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
								echo "<a href='quienes.php?lang=0' style='width:122px;'>Quienes Somos</a>";
						  else
								echo "<a href='quienes.php?lang=1' style='width:122px;'>About Us</a>";
					?>
				</li>
				<li><a href="#">
						<?php if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
									echo "Contacto</a>";
							  else
									echo "Contact</a>";
						?>
						<div style="left:-447px;">
						<ul class="oe_full">
							<?php if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
										{
										echo "<li class='oe_heading'>Contacte con Nosotros</li>";
										echo "<li><a href='contacto.php?lang=0'>A traves de nuestro formulario de contacto</a></li>";
										echo "<li><a href='mailto:info@codea.es'>En: info@codea.es</a></li>";
										}
								  else{
										echo "<li class='oe_heading'>Contact Us</li>";
										echo "<li><a href='contacto.php?lang=1'>through our contact form</a></li>";
										echo "<li><a href='mailto:info@codea.es'>Or: info@codea.es</a></li>";
									  }
							?>
						</ul>
					</div>
				</li>
			</ul>	
		</div>
		