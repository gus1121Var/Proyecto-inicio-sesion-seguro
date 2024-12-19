<?php
	require 'conexion_BD.php';

	$Correo = $_POST['Correo'];
	$Contraseña = $_POST['Contraseña'];

	$sql = "SELECT * FROM sesion WHERE Correo='$Correo' AND Contrasena='$Contraseña'";
	$resultado = $mysqli->query($sql);
	$row = $resultado->fetch_array(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
	<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel="stylesheet" href="Estilos.css">
			<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
			<title> Inicio </title>
	</head>
	<body>
		<div class="wrapper">
			<form action="Principal.html">
				<div class="container">
					<?php
					if($row){
					?>
					<h1>Inicio exitoso puedes acceder</h1>
					<button type="submit" class="btn-primary">Ir a tienda</button>
					<?php 
					}else{
					?>
					<h1>Error en correo y/o contraseña</h1>
					<?php
					}
					?>
				</div>
			</form>
		</div>
	</body>
</HTML> 