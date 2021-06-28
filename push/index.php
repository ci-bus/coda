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
echo $ip;
////////////////////////////////////////////////////////
$loginError = '';
//if (!empty($_POST['username']) && !empty($_POST['pwd'])) {
	include('Push.php');
	$push = new Push();
	$user = $push->loginUsers($ip);
	if (!empty($user)) {
		$_SESSION['username'] = $ip;
		//header("Location:index.php");
	} else {
		$loginError = "Invalido el usuario o contraseña!";
	}
//}
include('header.php');
?>
<title>C.O.D.A PRUEBA DE NOTIFICACIONES PUSH</title>
<script src="notification.js"></script>
<?php include('container.php');?>
<div class="container">		
	<h2>Ejemplo: Sistema de Notificación PUSH usando PHP y MySQL</h2>	

		<h4>Bienvenido <strong><?php echo $_SESSION['username']; ?></strong></h4>	
	
	<div style="margin:50px 0px 0px 0px;">
		<a class="btn btn-default read-more" style="background:#3399ff;color:white" href="http://www.baulphp.com/sistema-de-notificacion-push-php-y-mysql/">Volver al Tutorial</a>		
	</div>
</div>	
<?php include('footer.php');?>






