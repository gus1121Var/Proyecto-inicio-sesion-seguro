<?php
    require 'conexion_BD.php';
    $Correo = $_POST['Correo'];
    $Contrasena = $_POST['Contraseña'];
	$Contraseña2 = $_POST['Contraseña2'];

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$ip = $_SERVER['REMOTE_ADDR'];
		$captcha = $_POST['g-recaptcha-response'];
		$secretkey = "6LfkBe0pAAAAAJ1xvSIskiVm9dWSblmZ4TnCD2GM";
	
		// Verificar si la respuesta del captcha está presente
		if (!$captcha) {
			$errors[] = 'Por favor, verifica el captcha.';
		} else {
			$respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha&remoteip=$ip");
			$atributos = json_decode($respuesta, TRUE);
	
			if (!$atributos['success']) {
				$errors[] = 'Verificación del captcha fallida.';
			}

			if(!filter_var($Correo, FILTER_VALIDATE_EMAIL)){
				$errors[] = 'La dirreción de correo electronico no es válida';
			}
		}
	
		if (empty($errors)) {
			// Procesa el formulario (e.g., guarda los datos en la base de datos)
			echo "Contraseña actualizada.";
			$sql = "UPDATE inicio SET Contraseña = ('$Contrasena') WHERE Correo = ('$Correo')";
			$resultado = $mysqli->query($sql);
			$sql2 = "INSERT INTO sesion (Correo,Contrasena) VALUES ('$Correo','$Contraseña2')";
			$resultado2 = $mysqli->query($sql2);
		} else {
			// Muestra los errores
			foreach ($errors as $error) {
				echo "<p>$error</p>";
			}
		}
	}

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
			<form class="form-horizontal" method="POST" action="Index.html" autocomplete="off">
				<button type="submit" class="btn-primary">Ir registro</button>
			</form>
		</div>
	</body>
</HTML>