<?php
session_start();
include('header.php');
//ASIGNAMOS IP COMO NOMBRE DE USUSARIO
if (isset($_SERVER)) {
	if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
		$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	} elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
		$realip = $_SERVER["HTTP_CLIENT_IP"];
	} else {
		$realip = $_SERVER["REMOTE_ADDR"];
	}
} else {
	if (getenv("HTTP_X_FORWARDED_FOR")) {
		$realip = getenv("HTTP_X_FORWARDED_FOR");
	} elseif (getenv("HTTP_CLIENT_IP")) {
		$realip = getenv("HTTP_CLIENT_IP");
	} else {
		$realip = getenv("REMOTE_ADDR");
	}
}
$ip = $realip;
////////////////////////////////////////////////////////
$loginError = '';
//if (!empty($_POST['username']) && !empty($_POST['pwd'])) {
	include('Push.php');
	$push = new Push();
	$user = $push->loginUsers($ip);
		$_SESSION['username'] = $ip;
		//header("Location:index.php");
//}

?>
<title>Baulphp.com : Sistema de Notificación PUSH usando PHP y MySQL</title>
<?php include('container.php'); ?>
<div class="container">
	<h2>Iniciar Sesión:</h2>
	<div class="row">
		<div class="col-sm-4">
			<form method="post">
				<div class="form-group">
					<?php if ($loginError) { ?>
						<div class="alert alert-warning"><?php echo $loginError; ?></div>
					<?php } ?>
				</div>
				<div class="form-group">
					<label for="username">Usuario:</label>
					<input type="username" class="form-control" name="username" required>
				</div>
				<div class="form-group">
					<label for="pwd">Contraseña:</label>
					<input type="password" class="form-control" name="pwd" required>
				</div>
				<button type="submit" name="login" class="btn btn-default">Iniciar Sesion</button>
			</form><br>
			<strong>Datos demo:</strong><br>
			<strong>Usuario:</strong> baulphp <br>
			<strong>Contraseña:</strong> 12345
		</div>
	</div>
</div>
<?php include('footer.php'); ?>