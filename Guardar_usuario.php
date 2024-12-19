<?php
    require 'conexion_BD.php';
    $Nombre = $_POST['Nombre'];
    $Correo = $_POST['Correo'];
    $Contrasena = md5($_POST['Contraseña']);
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

			if (empty($Nombre)){
				$errors[] = 'El campo nombre es obligatorio';
			}
		
			if(!filter_var($Correo, FILTER_VALIDATE_EMAIL)){
				$errors[] = 'La dirreción de correo electronico no es válida';
			}
		}
	
		if (empty($errors)) {
			// Procesa el formulario (e.g., guarda los datos en la base de datos)
			echo "Formulario enviado exitosamente.";
			$sql = "INSERT INTO inicio (Nombre,Correo,Contraseña) VALUES ('$Nombre','$Correo','$Contrasena')";
			$sql2 = "INSERT INTO sesion (Correo,Contrasena) VALUES ('$Correo','$Contraseña2')";
			$resultado = $mysqli->query($sql);
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
			<link rel="stylesheet" href="Estilos_Registro.css">
			<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
			<title> Registro </title>
	</head>
	<body>
		<div class="wrapper">
			<form action="index.html">
				<h1>Registro de cuenta</h1>
				<div class="input-box">
					<input type="text" id="Nombre" placeholder="Nombre completo"
					required>
					<i class="bx bxs-user"></i>
				</div>
				<div class="input-box">
					<input type="text" id="Correo" placeholder="Correo electrónico"
					required>
					<i class='bx bx-at'></i>
				</div>
				<div class="input-box">
					<input type="text" id="Contraseña" placeholder="Contraseña"
					required>
					<i class='bx bx-key'></i>
				</div>
				<div class="register-link">
					<p> Se usará el correo para iniciar sesión</p>
				</div>
			</form>
			<form action="index.html">
				<button type="submit" class="btn-primary">Regresar</button>
			</form>
		</div>
	</body>
</HTML>
