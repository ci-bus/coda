<?php
	session_start();
	include("valida2.php");
	include('conexion.php');
	$pass = $_SESSION['pass'];
	include_once("funcionesTiempos.php");
	include_once("nombresTildes.php");
		include('escudos.php');
	$n=0;
	$tiempo=0;
	$tiempo2=0;
		$prueba = $_GET['prueba'];
if(isset($_GET['manga']))
		{
		$mimanga = $_GET['manga'];
		$salida = mysql_query("SELECT estado FROM mangas WHERE idmangas='$mimanga'");
		if(mysql_num_rows($salida))
			{
				while($fila2 = mysql_fetch_array($salida))
				{
				$est_car = $fila2['estado'];
				//echo $est_car;
				}
			}
			if($_GET['copa']=='1')
			{
			$micopa = $_GET['copa'];
			if($est_car==0)
				{/*CONSIDERAMOS QUE LA CARRERA NO HA COMENZADO, y mostramos otro orden*/
				$sql2 = mysql_query("SELECT t.idcarreras,t.idinscritos,t.idinscritos,i.idinscritos,t.tiempo_salida,t.tiempo_llegada,
				m.idmangas,m.idcarreras,m.idmangas,i.dorsal,i.excluido,i.autorizado,i.piloto,t.tiempo_total,t.idmangas, t.estado,
				t.idtiempos,i.copiloto, i.concursante, i.vehiculo,i.cilindrada 
				FROM tiempos t INNER JOIN mangas m ON t.idcarreras=m.idcarreras AND m.idmangas=t.idmangas INNER JOIN inscritos i 
				ON t.idinscritos=i.idinscritos
				WHERE t.idcarreras='$prueba' AND i.autorizado='1' AND i.excluido= 0 AND m.idmangas='$mimanga' 
				GROUP by i.piloto ORDER by i.dorsal ASC");
				}
			else
				{
				$sql2 = mysql_query("SELECT t.idcarreras,t.idinscritos,t.idinscritos,i.idinscritos,t.tiempo_salida,t.tiempo_llegada,
				m.idmangas,m.idcarreras,m.idmangas,i.dorsal,i.excluido,i.autorizado,i.piloto,t.tiempo_total,t.idmangas, t.estado,
				t.idtiempos,i.copiloto, i.concursante, i.vehiculo,i.cilindrada 
				FROM tiempos t INNER JOIN mangas m ON t.idcarreras=m.idcarreras AND m.idmangas=t.idmangas INNER JOIN inscritos i 
				ON t.idinscritos=i.idinscritos
				WHERE t.idcarreras='$prueba' AND i.autorizado='1' AND i.excluido= 0 AND m.idmangas='$mimanga' 
				GROUP by i.piloto ORDER by t.estado=3,t.estado=0,t.estado=1,t.estado=2,t.tiempo_llegada ASC");
				}
			$sql3 = mysql_query("SELECT t.idcarreras,t.idinscritos,t.idinscritos,i.idinscritos,t.tiempo_salida,t.tiempo_llegada,
			m.idmangas,m.idcarreras,m.idmangas,i.dorsal,i.excluido,i.autorizado,i.piloto,t.tiempo_total,t.idmangas, t.estado,
			t.idtiempos,i.copiloto
			FROM tiempos t INNER JOIN mangas m ON t.idcarreras=m.idcarreras AND m.idmangas=t.idmangas INNER JOIN inscritos i 
			ON t.idinscritos=i.idinscritos
			WHERE t.idcarreras='$prueba' AND i.autorizado='1' AND i.excluido= 0 AND m.idmangas='$mimanga' 
			GROUP by i.piloto ORDER by t.estado ASC,t.tiempo_salida ASC");/*ESTA CONSULTA SERA PA INCIDENCIA*/
			}
			else
			{
			if($est_car==0)
				{/*CONSIDERAMOS QUE LA CARRERA NO HA COMENZADO, y mostramos otro orden*/
				$micopa = $_GET['copa'];
				$sql2 =mysql_query("SELECT t.idcarreras,t.idinscritos,t.idinscritos,i.idinscritos,t.tiempo_salida,t.tiempo_llegada,
				m.idmangas,m.idcarreras,m.idmangas,i.dorsal,i.excluido,i.autorizado,i.piloto,t.tiempo_total,t.idmangas, t.estado,
				t.idtiempos,i.copiloto, i.concursante, i.vehiculo,i.cilindrada, ci.idcopas, ci.idinscritos
				FROM tiempos t INNER JOIN mangas m ON t.idcarreras=m.idcarreras AND m.idmangas=t.idmangas INNER JOIN inscritos i 
				ON t.idinscritos=i.idinscritos INNER JOIN copas_inscritos ci ON t.idinscritos=ci.idinscritos
				WHERE t.idcarreras='$prueba' AND i.autorizado='1' AND i.excluido= 0 AND m.idmangas='$mimanga' AND ci.idcopas='$micopa'
				GROUP by i.piloto ORDER by i.dorsal ASC");
				}
			else
				{
				$micopa = $_GET['copa'];
				$sql2 =mysql_query("SELECT t.idcarreras,t.idinscritos,t.idinscritos,i.idinscritos,t.tiempo_salida,t.tiempo_llegada,
				m.idmangas,m.idcarreras,m.idmangas,i.dorsal,i.excluido,i.autorizado,i.piloto,t.tiempo_total,t.idmangas, t.estado,
				t.idtiempos,i.copiloto, i.concursante, i.vehiculo,i.cilindrada, ci.idcopas, ci.idinscritos
				FROM tiempos t INNER JOIN mangas m ON t.idcarreras=m.idcarreras AND m.idmangas=t.idmangas INNER JOIN inscritos i 
				ON t.idinscritos=i.idinscritos INNER JOIN copas_inscritos ci ON t.idinscritos=ci.idinscritos
				WHERE t.idcarreras='$prueba' AND i.autorizado='1' AND i.excluido= 0 AND m.idmangas='$mimanga' AND ci.idcopas='$micopa'
				GROUP by i.piloto ORDER by t.estado=3,t.estado=0,t.estado=1,t.estado=2,t.tiempo_salida ASC");
				}
			$sql3 =mysql_query("SELECT ci.idinscritos, i.dorsal, i.piloto, i.copiloto, i.concursante, i.vehiculo, i.clase, 
			i.cilindrada, t1.tiempo_salida, t1.tiempo_llegada, t1.tiempo_total FROM tiempos t1 JOIN inscritos i 
			ON  i.idinscritos = t1.idinscritos INNER JOIN copas_inscritos as ci ON t1.idinscritos = ci.idinscritos
			WHERE t1.idmangas = '$mimanga' AND t1.idcarreras = '$prueba' AND i.autorizado = 1 AND i.excluido = 0 AND ci.idcopas='$micopa'
			ORDER BY t1.estado ASC, t1.tiempo_salida ASC");/*ESTA CONSULTA SERA PA INCIDENCIA*/
				
			}
		}
	else{
		echo "<p class='titulos2'>SELECCIONE MANGA</p>";
		/*$sql2 =mysql_query("SELECT i.dorsal, i.piloto, i.copiloto, i.concursante, i.vehiculo, i.clase, i.cilindrada, t1.tiempo_salida, t1.tiempo_llegada, t1.tiempo_total FROM tiempos t1 JOIN inscritos i ON  i.idinscritos = t1.idinscritos WHERE t1.idcarreras = $idcarreras AND i.autorizado = 1 AND i.excluido = 0
ORDER BY t1.tiempo_salida ASC");*/
		}	
//echo "<br>";		
?>
<hr>
<div id="leyenda">
	<div class="seg_5 cubo2">POR SALIR
		<div class="minicubo">
		<?php
			if($_GET['copa']==1)
			$sql = mysql_query("SELECT t.idtiempos FROM tiempos t INNER JOIN inscritos i ON t.idinscritos=i.idinscritos 
			WHERE idmangas='$mimanga' and estado=0 AND i.autorizado=1");
			else{
			$micopa=$_GET['copa'];
			$sql = mysql_query("SELECT t.idinscritos FROM tiempos t INNER JOIN copas_inscritos ci 
			ON t.idinscritos=ci.idinscritos INNER JOIN inscritos i ON t.idinscritos=i.idinscritos
			WHERE ci.idcopas='$micopa' AND t.idmangas='$mimanga' AND t.estado=0 AND t.tiempo_salida=0 
			AND i.autorizado=1 AND t.tiempo_llegada=0");
			}
			$cuenta = mysql_num_rows($sql);
			echo $cuenta;
		?>
		</div>
	</div>
	<div class="seg_4 cubo2">EN CARRERA
		<div class="minicubo">
		<?php
			if($_GET['copa']==1)
			$sql = mysql_query("select idtiempos from tiempos WHERE idmangas='$mimanga' and estado=1 and tiempo_salida>0 and tiempo_llegada=0");
			else{
			$sql = mysql_query("SELECT t.idinscritos FROM tiempos t INNER JOIN copas_inscritos ci 
			ON t.idinscritos=ci.idinscritos
			WHERE ci.idcopas='$micopa' AND t.idmangas='$mimanga' AND t.estado=1 AND t.tiempo_salida>0 AND t.tiempo_llegada=0");
			}
			$cuenta = mysql_num_rows($sql);
			echo $cuenta;
		?>
		</div>
	</div>
	<div class="seg_2 cubo2">LLEGADO
		<div class="minicubo">
		<?php
			if($_GET['copa']==1)
			$sql = mysql_query("select idtiempos from tiempos WHERE idmangas='$mimanga' and estado=2");
			else{
			$sql = mysql_query("SELECT t.idinscritos FROM tiempos t INNER JOIN copas_inscritos ci 
			ON t.idinscritos=ci.idinscritos
			WHERE ci.idcopas='$micopa' AND t.idmangas='$mimanga' AND t.estado=2");
			}
			$cuenta = mysql_num_rows($sql);
			echo $cuenta;
		?>
		</div>
	</div>
	<div class="seg_1 cubo2">INCIDENCIA
		<div class="minicubo">
		<?php
			if(mysql_num_rows($sql3))
			{
				while($fila2 = mysql_fetch_array($sql3))
				{
				if($j==1)
						{
						$tiempo2 = $t_lle;
						}
					else
						{
						$j=1;
						}
				$t_lle = $fila2['tiempo_llegada'];
				if($fila2['tiempo_llegada'] = 0 && $fila2['tiempo_salida'] > 0 && $fila2['estado']==1)//Consideramos META
					{
					if($t_lle<$tiempo2)
						{
						$n++;
						}
					}
					//DEBERIA CONTAR LOS REGISTROS EN INCIDENCIA PERO VAYA LIO!
				}
			}
			echo $n;
		?>
		</div>
	</div>
	<div class="seg_6 cubo2">RETIRADO
		<div class="minicubo">
		<?php
			if($_GET['copa']==1)
			$sql = mysql_query("SELECT idtiempos from tiempos WHERE idmangas='$mimanga' and tiempo_salida>0 and tiempo_llegada=0 AND estado=3");
			//$sql= mysql_query("SELECT * FROM tiempos WHERE idmangas =468 AND tiempo_salida >0 AND tiempo_llegada =0 AND estado =3 LIMIT 0 , 30");
			else{
			$sql = mysql_query("SELECT t.idinscritos FROM tiempos t INNER JOIN copas_inscritos ci 
			ON t.idinscritos=ci.idinscritos
			WHERE ci.idcopas='$micopa' AND t.idmangas='$mimanga' AND t.estado=3 AND t.tiempo_salida>0 AND t.tiempo_llegada=0");
			}
			$cuenta = mysql_num_rows($sql);
			echo $cuenta;
		?>
		</div>
	</div>
	<div class="seg_3 cubo2">NO SALE
		<div class="minicubo">
		<?php
			if($_GET['copa']==1)
			$sql = mysql_query("select idtiempos from tiempos WHERE idmangas='$mimanga' and estado=3 AND tiempo_salida=0 AND tiempo_llegada=0");
			else{
			$sql = mysql_query("SELECT t.idinscritos FROM tiempos t INNER JOIN copas_inscritos ci 
			ON t.idinscritos=ci.idinscritos
			WHERE ci.idcopas='$micopa' AND t.idmangas='$mimanga' AND t.estado=3 AND t.tiempo_salida=0 AND t.tiempo_llegada=0");
			}
			$cuenta = mysql_num_rows($sql);
			echo $cuenta;
		?>
		</div>
	</div>
	<div class="seg_7 cubo2"></div>
</div>	
<hr>
	<?php
		if(mysql_num_rows($sql2)>0)
			{
				while($fila = mysql_fetch_array($sql2))
				{
				$m++;
				$l = "a".$m;
				$dorsal = $fila['dorsal'];
					if($j==1)
						{
						$tiempo = $t_lle;
						}
					else
						{
						$j=1;
						}
				$t_sal = FormatearTiempo($fila['tiempo_salida']);
				$t_lle = FormatearTiempo($fila['tiempo_llegada']);
				$t_total = FormatearTiempo($fila['tiempo_total']);
				$estado = $fila['estado'];
				$idtiempos = $fila['idtiempos'];
				$idinscritos = $fila['idinscritos'];
				$piloto = $fila['piloto'];
				$copiloto = $fila['copiloto'];
				$concursante = $fila['concursante'];
				$vehiculo = $fila['vehiculo'];
				$cil = $fila['cilindrada'];						
				if($fila['tiempo_llegada'] > 0 && $fila['tiempo_salida'] > 0 && $estado==2)//Consideramos META
					{
					if($i==0)
						{
						$piloto_act=$fila['tiempo_llegada'];
						$i=1;
						}
					else
						{
						$piloto_ante=$fila['tiempo_llegada'];
						$i=0;
						}
					echo "<div class='seg_2 cubo' onmouseover='mostrar_piloto($l.id)' onmouseout='quitar_piloto($l.id)'>";
					echo "<div class='dorsal'>" .$dorsal." </div>";
					echo "<div class='datos' id='".$l."'><p class='margen0'><img src='casco1.png' width='30px'>".$piloto."</p>";
					if($copiloto =='')
						{
						echo "<p class='concu'>".$concursante."</p><p>".escudo($vehiculo)." &nbsp;&nbsp; ".$vehiculo."</p><p>".$cil."</p></div>";
						}
					else
						{
						echo "<p class='margen0'><img src='casco2.png' width='30px'>".$copiloto."</p><p class='concu'>".$concursante."</p><p>".escudo($vehiculo)." &nbsp;&nbsp; ".$vehiculo."</p><p>".$cil." cc.</p></div>";
						}	
					echo "<div class='fuente1'>SALIDA:<span class='negrita'>  ".$t_sal."</span></div>";
					echo "<div class='fuente1'>LLEGADA:<span class='negrita'> ".$t_lle."</span></div>";
					echo "<div class='fuente1'><span class='rojo'>".$t_total."</span></div>";
					$sql4 = mysql_query("SELECT idtiempos FROM tiempos WHERE idmangas='$mimanga' AND tiempo_total >0 ORDER BY tiempo_total ASC");
					$k=0;
					if(mysql_num_rows($sql4)>0)
						{
							while($fila3 = mysql_fetch_array($sql4))
							{
							$idtiempos2 = $fila3['idtiempos'];
							$k++;
							if ($idtiempos == $idtiempos2)
								{
								echo "<div id='pos'>P.".$k."</div>";
								}
							}
						}
					/*PRUEBA PARA CONTROLES INTERMEDIOS*/
					$dbQuery = mysql_query("SELECT tiempo_invertido from controles_tiempos where idinscritos='$idinscritos' AND idmangas='$mimanga'");
					if (mysql_num_rows($dbQuery)>0)
						{
							$p=0;
							echo "<p class='margen0'>Inter. |";
							while($filaa=mysql_fetch_array($dbQuery))
								{
								$p++;
								if($filaa['tiempo_invertido']>0)
									{
									echo "<span class='grande1 rojo3'>".$p."</span>|";
									}
								else
									{
									echo "<span class='grande1'>".$p."</span>|";
									}
							}
						}
					echo "</p>";
					/*FIN DE LA PRUEBA*/
					//echo "<p>".$tiempo."</p>";
					echo "</div>";
					}
				if($fila['tiempo_llegada'] == 0 && $fila['tiempo_salida'] == 0 && $estado==3)//NO SALE
					{
					echo "<div  class='seg_3 cubo' onmouseover='mostrar_piloto($l.id)' onmouseout='quitar_piloto($l.id)'>";
					echo "<div class='dorsal'>" .$dorsal." </div>";
					echo "<div class='datos' id='".$l."'><p class='margen0'><img src='casco1.png' width='30px'>".$piloto."</p>";
					if($copiloto =='')
						{
						echo "<p class='concu'>".$concursante."</p><p>".escudo($vehiculo)." &nbsp;&nbsp; ".$vehiculo."</p><p>".$cil."</p></div>";
						}
					else
						{
						echo "<p class='margen0'><img src='casco2.png' width='30px'>".$copiloto."</p><p class='concu'>".$concursante."</p><p>".escudo($vehiculo)." &nbsp;&nbsp; ".$vehiculo."</p><p>".$cil." cc.</p></div>";
						}
					echo "<div class='fuente1'>SALIDA:<span class='negrita'>  ".$t_sal."</span></div>";
					echo "<div class='fuente1'>LLEGADA:<span class='negrita'> ".$t_lle."</span></div>";
					echo "<div class='fuente1'><span class='rojo'>".$t_total."</span></div>";
										/*PRUEBA PARA CONTROLES INTERMEDIOS*/
					$dbQuery = mysql_query("SELECT tiempo_invertido from controles_tiempos where idinscritos='$idinscritos' AND idmangas='$mimanga'");
					if (mysql_num_rows($dbQuery)>0)
						{
							$p=0;
							echo "<p class='margen0'>Inter. |";
							while($filaa=mysql_fetch_array($dbQuery))
								{
								$p++;
								if($filaa['tiempo_invertido']>0)
									{
									echo "<span class='grande1 rojo3'>".$p."</span>|";
									}
								else
									{
									echo "<span class='grande1'>".$p."</span>|";
									}
							}
						}
					echo "</p>";
					/*FIN DE LA PRUEBA*/
					echo "</div>";
					}
				if($fila['tiempo_llegada'] == 0 && $fila['tiempo_salida'] == 0 && $estado==0) //POR SALIR
					{
					echo "<div  class='seg_5 cubo' onmouseover='mostrar_piloto($l.id)' onmouseout='quitar_piloto($l.id)'>";
					echo "<div class='dorsal'>" .$dorsal." </div>";
					echo "<div class='datos' id='".$l."'><p class='margen0'><img src='casco1.png' width='30px'>".$piloto."</p>";
					if($copiloto =='')
						{
						echo "<p class='concu'>".$concursante."</p><p>".escudo($vehiculo)." &nbsp;&nbsp; ".$vehiculo."</p><p>".$cil."</p></div>";
						}
					else
						{
						echo "<p class='margen0'><img src='casco2.png' width='30px'>".$copiloto."</p><p class='concu'>".$concursante."</p><p>".escudo($vehiculo)." &nbsp;&nbsp; ".$vehiculo."</p><p>".$cil." cc.</p></div>";
						}
					echo "<div class='fuente1'>SALIDA:<span class='negrita'>  ".$t_sal."</span></div>";
					echo "<div class='fuente1'>LLEGADA:<span class='negrita'> ".$t_lle."</span></div>";
					echo "<div class='fuente1'><span class='rojo'>".$t_total."</span></div>";
					/*PRUEBA PARA CONTROLES INTERMEDIOS*/
					$dbQuery = mysql_query("SELECT tiempo_invertido from controles_tiempos where idinscritos='$idinscritos' AND idmangas='$mimanga'");
					if (mysql_num_rows($dbQuery)>0)
						{
							$p=0;
							echo "<p class='margen0'>Inter. |";
							while($filaa=mysql_fetch_array($dbQuery))
								{
								$p++;
								if($filaa['tiempo_invertido']>0)
									{
									echo "<span class='grande1 rojo3'>".$p."</span>|";
									}
								else
									{
									echo "<span class='grande1'>".$p."</span>|";
									}
							}
						}
					echo "</p>";
					/*FIN DE LA PRUEBA*/
					echo "</div>";
					}
				if($fila['tiempo_llegada'] == 0 && $fila['tiempo_salida'] > 0 && $estado==3)//ABANDONO EN PiSTA
					{
					echo "<div  class='seg_6 cubo' onmouseover='mostrar_piloto($l.id)' onmouseout='quitar_piloto($l.id)'>";
					echo "<div class='dorsal'>" .$dorsal." </div>";
					echo "<div class='datos' id='".$l."'><p class='margen0'><img src='casco1.png' width='30px'>".$piloto."</p>";
					if($copiloto =='')
						{
						echo "<p class='concu'>".$concursante."</p><p>".escudo($vehiculo)." &nbsp;&nbsp; ".$vehiculo."</p><p>".$cil."</p></div>";
						}
					else
						{
						echo "<p class='margen0'><img src='casco2.png' width='30px'>".$copiloto."</p><p class='concu'>".$concursante."</p><p>".escudo($vehiculo)." &nbsp;&nbsp; ".$vehiculo."</p><p>".$cil." cc.</p></div>";
						}
					echo "<div class='fuente1'>SALIDA:<span class='negrita'>  ".$t_sal."</span></div>";
					echo "<div class='fuente1'>LLEGADA:<span class='negrita'> ".$t_lle."</span></div>";
					echo "<div class='fuente1'><span class='rojo'>".$t_total."</span></div>";
					/*PRUEBA PARA CONTROLES INTERMEDIOS*/
					$dbQuery = mysql_query("SELECT tiempo_invertido from controles_tiempos where idinscritos='$idinscritos' AND idmangas='$mimanga'");
					if (mysql_num_rows($dbQuery)>0)
						{
							$p=0;
							echo "<p class='margen0'>Inter. |";
							while($filaa=mysql_fetch_array($dbQuery))
								{
								$p++;
								if($filaa['tiempo_invertido']>0)
									{
									echo "<span class='grande1 rojo3'>".$p."</span>|";
									}
								else
									{
									echo "<span class='grande1'>".$p."</span>|";
									}
							}
						}
					echo "</p>";
					/*FIN DE LA PRUEBA*/
					echo "</div>";
					}
				if($fila['tiempo_llegada'] == 0 && $fila['tiempo_salida']>0 && $estado==1) //EN PISTA - INCIDENCIAAAAA
					{
					
					echo "<div  class='seg_4 cubo' onmouseover='mostrar_piloto($l.id)' onmouseout='quitar_piloto($l.id)'>";
					echo "<div class='dorsal'>" .$dorsal." </div>";
					echo "<div class='datos' id='".$l."'><p class='margen0'><img src='casco1.png' width='30px'>".$piloto."</p>";
					if($copiloto =='')
						{
						echo "<p class='concu'>".$concursante."</p><p>".escudo($vehiculo)." &nbsp;&nbsp; ".$vehiculo."</p><p>".$cil."</p></div>";
						}
					else
						{
						echo "<p class='margen0'><img src='casco2.png' width='30px'>".$copiloto."</p><p class='concu'>".$concursante."</p><p>".escudo($vehiculo)." &nbsp;&nbsp; ".$vehiculo."</p><p>".$cil." cc.</p></div>";
						}
					echo "<div class='fuente1'>SALIDA:<span class='negrita'>  ".$t_sal."</span></div>";
					echo "<div class='fuente1'>LLEGADA:<span class='negrita'> ".$t_lle."</span></div>";
					echo "<div class='fuente1'><span class='rojo'>".$t_total."</span></div>";
					/*PRUEBA PARA CONTROLES INTERMEDIOS*/
					$dbQuery = mysql_query("SELECT tiempo_invertido from controles_tiempos where idinscritos='$idinscritos' AND idmangas='$mimanga'");
					if (mysql_num_rows($dbQuery)>0)
						{
							$p=0;
							echo "<p class='margen0'>Inter. |";
							while($filaa=mysql_fetch_array($dbQuery))
								{
								$p++;
								if($filaa['tiempo_invertido']>0)
									{
									echo "<span class='grande1 rojo3'>".$p."</span>|";
									}
								else
									{
									echo "<span class='grande1'>".$p."</span>|";
									}
							}
						}
					echo "</p>";
					/*FIN DE LA PRUEBA*/
					echo "</div>";
					}
				/*momentaneamente esto me sobra
				if($fila['tiempo_llegada'] == 0 && $fila['tiempo_salida']==0 && $estado==0)
					{
					echo "<div  class='seg_5 cubo'>";
					echo "<div class='dorsal'>" .$dorsal." </div>";
					echo "<div class='fuente1'>SALIDA:<span class='negrita'>  ".$t_sal."</span></div>";
					echo "<div class='fuente1'>LLEGADA:<span class='negrita'> ".$t_lle."</span></div>";
					echo "<div class='fuente1'><span class='rojo'>".$t_total."</span><p>".$idtiempos."</p></div>";
					echo "</div>";
					}
				if($fila['tiempo_llegada'] == 0 && $fila['tiempo_salida']==0 && $estado==3)
					{
					echo "<div  class='seg_6 cubo'>";
					echo "<div class='dorsal'>" .$dorsal." </div>";
					echo "<div class='fuente1'>SALIDA:<span class='negrita'>  ".$t_sal."</span></div>";
					echo "<div class='fuente1'>LLEGADA:<span class='negrita'> ".$t_lle."</span></div>";
					echo "<div class='fuente1'><span class='rojo'>".$t_total."</span><p>".$idtiempos."</p></div>";
					echo "</div>";
					}*/
				//echo $dorsal."---".$t_sal."-----".$t_lle."------".$t_total."<br>";
				}
			}
	?>