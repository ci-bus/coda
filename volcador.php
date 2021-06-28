<?php
session_start();
	include("valida2.php");
	include("valida3.php");
?>
<section class="content-header">
      <h1>
        Compu&Phone
        <small>Nuevo Cliente</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Clientes</li>
      </ol>
    </section>

	  <div id="capa">
	  </div>
		<div id="listados">
			<form name="nuevo_cli" action="dash.php?action=nue_cliente2" method="post">
					<table id="tabla2">
						<tr><td>RAZON SOCIAL: </td><td><input type="text" name="nombre" size="30"></td></tr>
						<tr><td>NOMBRE Y APELLIDOS: </td><td><input type="text" name="apellidos" size="50"></td></tr>
						<tr><td>EMAIL: </td><td><input type="text" name="mail" size="50"></td></tr>
						<tr><td>NIF / DNI: </td><td><input type="text" name="dni"></td></tr>
						<tr><td>TELEFONO1: </td><td><input type="text" name="telf1"></td></tr>
						<tr><td>TELEFONO2: </td><td><input type="text" name="telf2"></td></tr>
						<tr><td>DIRECCION LINEA 1: </td><td><input type="text" name="dir1" size="50"></td></tr>
						<tr><td>DIRECCION LINEA 2: </td><td><input type="text" name="dir2" size="50"></td></tr>
						<tr><td>DTO: </td><td><input type="text" name="dto"></td></tr>
						<tr><td colspan="2"><input type="submit" value="ALTA DE CLIENTE"></td></tr>
					</table>
				</form>
		</div>
    </section>