		<script language="javascript">

			$(document).ready(function (){
					$("#pikame").PikaChoose({carousel:true, carouselVertical:true});
				});
		</script>
		<?php
		function check_in_range($start_date, $end_date, $evaluame) 
			{
			$start_ts = strtotime($start_date);
			$end_ts = strtotime($end_date);
			$user_ts = strtotime($evaluame);
			return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
			}
		?>
<div class="pikachoose">
	<ul id="pikame" class="jcarousel-skin-pika">
	<?php
	error_reporting(5);
			include("conexion.php");
			$ruta='../images/eventos/';
			$directorio_escaneado = scandir($ruta);
			$archivos = array();
			$i=0;
		if(count(scandir($ruta)) == 2)
		{
		echo "<li><a href='#'><img src='../images/cierre_t/coda_t.jpg'></a><span></span></li>";
		}
		else
		{
			foreach ($directorio_escaneado as $item) {
				if ($item != '.' and $item != '..' && $item!='Thumbs.db') {
					$cons= mysql_query("SELECT enlace,comentario,inicio,fin from imagenes WHERE nombre='$item'");
					if(mysql_num_rows($cons))
						{
						while($fil= mysql_fetch_array($cons))
							{
							$enlace = $fil['enlace'];
							$comentario= $fil['comentario'];
							$inicio = $fil['inicio'];
							$fin = $fil['fin'];
							}
						}
					if (check_in_range($inicio, $fin, date('Y-m-d')))
					{
						$k++;
						if($k>0)
						if(!isset($_GET['lang']) || $_GET['lang']==0 || $_GET['lang']=='0')
							echo "<li><a href='".$enlace."'><img src='".$ruta.$item."'></a><span>".$comentario."</span></li>";
						else	
							echo "<li><a href='".$enlace."'><img src='".$ruta.$item."'></a><span>".$comentario."</span></li>";
					}
				}
			}
			if($k==0)
			echo "<li><a href='#'><img src='../images/cierre_t/coda_t.jpg'></a><span></span></li>";
		}
		
	?>
	</ul>
</div>