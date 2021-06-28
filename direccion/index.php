<?php
if (isset($_GET['noactivo'])) {
	$mensaje = 1;
} else {
	$mensaje = 0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="Cronometradores y Oficiales de Automovilismo" />
	<title>C.O.D.A. .:: Direcci&oacute;n de Carrera ::.</title>
	<meta name="description" content="Cronometradores y Oficiales de Automovilismo" />
	<meta name="keywords" content="Rally, Rallies, Cronometradores, Automovilismo, automovilista, carreras, carrera, tiempos online, tiempos on-line, tiempos en directo, coches, automoviles, rally, rallies, cronometradores, automovilismo" />
	<link type="text/css" href="direccion.css" rel="stylesheet">
	<link rel="shortcut icon" href="../normal/paginas/favicon.ico" />
	<script type="text/javascript" src=" https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
</head>

<body>
	<div id="todo">
		<div id="titulo">
			ACCESO A LA DIRECCI&Oacute;N DE CARRERA DE UNA PRUEBA EN CODEA.ES
		</div>
		<div id="login">
			<?php
			if($mensaje > 0){
				if($mensaje==1){
					echo "<p class='rojo'>ESTA CONTRAEÑA ESTA CADUCADA</p>";
				}
			}
			?>
			<p>A continuaci&oacute;n ingrese su contrase&ntilde;a</p>
			<div id="login_izq">
				<img src="../img/logo.png">
			</div>
			<div id="login_der">
				<form id="formu2" action="valida.php" method="post">
					Contrase&ntilde;a: <input type="password" name="pass" placeholder="ingrese su contrase&ntilde;a">
					<br>
					<input type="submit" value="Acceder" style="margin: 20px 80px 0;">
				</form>
			</div>
		</div>
		<p class="pie1"></p>
	</div>
	<p align="center">Problemas? Pongase en contacto con el administrador de la pagina. enrique@sinfoal.com</p>
	<p align="center">Club Deportivo CODA, Cronometradores y Oficiales de Automovilismo</p>
	<p align="center"><a href="http://www.compuandphone.com">Compu&Phone</a></p>
</body>

</html>