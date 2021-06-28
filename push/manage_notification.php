<?php 
session_start(); 
include('header.php');
include ('Push.php');  
$push = new Push();
?>
<title>Baulphp : Sistema de Notificación PUSH usando PHP y MySQL</title>
<?php include('container.php');?>
<style>
.borderless tr td {
    border: none !important;
    padding: 2px !important;
}
</style>
<div class="container">		
	<h2>Ejemplo: Sistema de Notificación PUSH usando PHP y MySQL</h2>	
	<a href="index.php">Portada</a> | <a href="logout.php">Salir</a>
	<hr>
	<div class="row">
		<div class="col-sm-6">
			<h3>Agregar nueva notificacion:</h3>
			<form method="post"  action="<?php echo $_SERVER['PHP_SELF']; ?>">										
				<table class="table borderless">
					<tr>
						<td>Titulo</td>
						<td><input type="text" name="title" class="form-control" required></td>
					</tr>	
					<tr>
						<td>Mensaje</td>
						<td><textarea name="msg" cols="50" rows="4" class="form-control" required></textarea></td>
					</tr>			
					<tr>
						<td>Tiempo de Emision</td>
						<td><select name="time" class="form-control"><option>Ahora</option></select> </td>
					</tr>
					<tr>
						<td>Bucle (tiempo)</td>
						<td><select name="loops" class="form-control">
						<?php 
							for ($i=1; $i<=5 ; $i++) { ?>
								<option value="<?php echo $i ?>"><?php echo $i ?></option>
						<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td>Bucle cada (Minutos)</td>
						<td><select name="loop_every" class="form-control">
						<?php 
						for ($i=1; $i<=60 ; $i++) { ?>
							<option value="<?php echo $i ?>"><?php echo $i ?></option>
						<?php } ?>
						</select> </td>
					</tr>
					<tr>
						<td>Por</td>
						<td><select name="user" class="form-control">
						<?php 		
							$user = $push->listUsers(); 
							foreach ($user as $key) {
						?>
							<option value="<?php echo $key['username'] ?>"><?php echo $key['username'] ?></option>
						<?php } ?>
						</select></td>
					</tr>
					<tr>
						<td colspan=1></td>
						<td colspan=1></td>
					</tr>					
					<tr>
						<td colspan=1></td>
						<td><button name="submit" type="submit" class="btn btn-info">Agregar Mensaje</button></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
	<?php 
	if (isset($_POST['submit'])) { 
		if(isset($_POST['msg']) and isset($_POST['time']) and isset($_POST['loops']) and isset($_POST['loop_every']) and isset($_POST['user'])) {
			$title = $_POST['title'];	
			$msg = $_POST['msg']; 
			$time = date('Y-m-d H:i:s'); 
			$loop= $_POST['loops']; 
			$loop_every=$_POST['loop_every']; 
			$user = $_POST['user']; 
			$isSaved = $push->saveNotification($title, $msg,$time,$loop,$loop_every,$user);
			if($isSaved) {
				echo '* Guardar nueva notificación de éxito';
			} else {
				echo 'error guardando informacion';
			}
		} else {
			echo '* completado el parámetro de arriba';
		}
	} 
	?>
	<h3>Notificaciones Lista:</h3>
	<table class="table">
		<thead>
			<tr>
				<th>No</th>
				<th>Siguiente horario</th>
				<th>Titulo</th>
				<th>Mensaje</th>
				<th>permanece</th>
				<th>Usuario</th>
			</tr>
		</thead>
		<tbody>
			<?php $a =1; 
			$notifList = $push->listNotification(); 
			foreach ($notifList as $key) {
			?>
			<tr>
				<td><?php echo $a ?></td>
				<td><?php echo $key['notif_time'] ?></td>
				<td><?php echo $key['title'] ?></td>
				<td><?php echo $key['notif_msg'] ?></td>
				<td><?php echo $key['notif_loop']; ?></td>
				<td><?php echo $key['username'] ?></td>
			</tr>
			<?php $a++; } ?>
		</tbody>
	</table>
</div>	
<?php include('footer.php');?>