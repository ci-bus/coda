
    <?php
    $url= $_SERVER["REQUEST_URI"];
    if(stristr($url, 'inscritos') == TRUE ){
        $activo = 'inscritos';
    }
    if(stristr($url, 'autorizados') == TRUE ){
        $activo = 'autorizados';
    }
    if(stristr($url, 'abandonos') == TRUE ){
        $activo = 'abandonos';
    }
    if(stristr($url, 'excluidos') == TRUE ){
        $activo = 'excluidos';
    }
    if(stristr($url, 'penalizacion') == TRUE ){
        $activo = 'penalizacion';
    }
    if(stristr($url, 'clasificacion') == TRUE ){
        $activo = 'clasificacion';
    }
    if(stristr($url, 'comparativa') == TRUE ){
        $activo = 'comparativa';
    }
    ?>
    <a href="tiempos_archivo.php?id=<?php echo $idCarrera; ?>" class="primary-btn2 text-uppercase"><img src="img/home.png" class="iconos_menu"></a>
    <a href="inscritos_archivo.php?id=<?php echo $idCarrera; ?>" class="primary-btn text-uppercase <?php if($activo=='inscritos')echo "selected";?>"><img src="img/casco.png" class="iconos_menu">INSCRITOS</a>
    <a href="autorizados_archivo.php?id=<?php echo $idCarrera; ?>" class="primary-btn text-uppercase <?php if($activo=='autorizados')echo "selected";?>"><img src="img/volante.png" class="iconos_menu">AUTORIZADOS</a>
    <a href="abandonos_archivo.php?id=<?php echo $idCarrera; ?>" class="primary-btn text-uppercase <?php if($activo=='abandonos')echo "selected";?>"><img src="img/penalizacion.png" class="iconos_menu">ABANDONOS</a>
    <a href="excluidos_archivo.php?id=<?php echo $idCarrera; ?>" class="primary-btn text-uppercase <?php if($activo=='excluidos')echo "selected";?>"><img src="img/excluido.png" class="iconos_menu">DESCALIFICACIONES</a>
    <a href="penalizaciones_archivo.php?id=<?php echo $idCarrera; ?>" class="primary-btn text-uppercase <?php if($activo=='penalizacion')echo "selected";?>"><img src="img/copiloto.png" class="iconos_menu">PENALIZACIONES</a>
    <a href="#" class="primary-btn text-uppercase <?php if($activo=='comparativa')echo "selected";?>"><img src="img/grafica.png" class="iconos_menu">COMPARATIVAS</a>
    <a href="clas_final_archivo.php?id=<?php echo $idCarrera; ?>&copa=0" class="primary-btn text-uppercase <?php if($activo=='clasificacion')echo "selected";?>"><img src="img/podio.png" class="iconos_menu">CLASIFICACI&Oacute;N FINAL</a>
