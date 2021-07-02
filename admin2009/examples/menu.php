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
			if($_GET['activo']=='slider')
				echo '<li class="active">';
			else
				echo "<li>";
			?>
            <a href="./slider.php?activo=slider&newBD=true">
              <i class="tim-icons icon-atom"></i>
              <p>SLIDER HOME</p>
            </a>
          </li>
          <li>
		  <?php
			if($_GET['activo']=='direccion')
				echo '<li class="active">';
			else
				echo "<li>";
			?>
            <a href="./direccion.php?activo=direccion&newBD=true">
              <i class="tim-icons icon-pin"></i>
              <p>DIRECCION</p>
            </a>
          </li>
          <li>
		  <?php
			if($_GET['activo']=='secretarios')
				echo '<li class="active">';
			else
				echo "<li>";
			?>
            <a href="./secretarios.php?activo=secretarios&newBD=true">
              <i class="tim-icons icon-bell-55"></i>
              <p>SECRETARIOS</p>
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
          <li>
		  <?php
			if($_GET['activo']=='usuarios')
				echo '<li class="active">';
			else
				echo "<li>";
			?>
            <a href="usuarios.php?activo=usuarios&newBD=true">
              <i class="tim-icons icon-single-02"></i>
              <p>USUARIOS WEB</p>
            </a>
          </li>
          <?php
			if($_GET['activo']=='extras')
				echo '<li class="active">';
			else
				echo "<li>";
			?>
            <a href="extras.php?activo=extras&newBD=true">
              <i class="tim-icons icon-align-center"></i>
              <p>EXTRAS</p>
            </a>
          </li>
          <!--li>
            <a href="./rtl.html">
              <i class="tim-icons icon-world"></i>
              <p>RTL Support</p>
            </a>
          </li>
          <li class="active-pro">
            <a href="./upgrade.html">
              <i class="tim-icons icon-spaceship"></i>
              <p>Upgrade to PRO</p>
            </a>
          </li-->
        </ul>
      </div>