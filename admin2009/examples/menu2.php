    <div class="sidebar">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red"
    -->
      <div class="sidebar-wrapper">
        <div class="logo">
          <a href="javascript:void(0)" class="simple-text logo-mini">
            C.D
          </a>
          <a href="javascript:void(0)" class="simple-text logo-normal">
            CODA
          </a>
        </div>
        <ul class="nav">
		<?php
			if($_GET['activo']=='index')
				echo '<li class="active pro">';
			else
				echo "<li>";
			?>
            <a href="./index.php?activo=index&newBD=true">
              <i class="tim-icons icon-chart-pie-36"></i>
              <p>INICIO</p>
            </a>
          </li>
          <?php
			if($_GET['activo']=='tablon')
				echo '<li class="active">';
			else
				echo "<li>";
			?>
            <a href="tablon.php?activo=tablon">
              <i class="tim-icons icon-puzzle-10"></i>
              <p>TABLON ANUNCIOS</p>
            </a>
          </li>
        </ul>
      </div>