<?php
    require 'conexion_BD.php';
    $Correo = $_POST['Correo'];

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
			echo "Correo validado.";
			$sql = "SELECT Correo FROM sesion WHERE Correo = ('$Correo') ";
			$resultado = $mysqli->query($sql);
		} else {
			// Muestra los errores
			foreach ($errors as $error) {
				echo "<p>$error</p>";
			}
		}
	}

?>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="Estilos_Registro.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Registro</title>
    <style>
        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
    <script>

        /*window.onload = function() {
            document.getElementById('formularioRegistro').reset();
        };*/

        function validarCorreo(correo) {
            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(correo);
        }

        function comprobarCorreo() {
            const correo = document.getElementById("Correo").value;
            const mensajeError = document.getElementById("mensajeError");

            if (!validarCorreo(correo)) {
                mensajeError.textContent = "Por favor, introduce una dirección de correo electrónico válida.";
            } else {
                mensajeError.textContent = "";
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("Correo").addEventListener("input", comprobarCorreo);
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <form class="form-horizontal" method="POST" action="Actualizar_contraseña.html" autocomplete="off" name="f1">
            <div id="mensajeError" class="error"></div>
            <button type="submit" class="btn-primary">Actualizar</button>
            <div class="register-link">
                <p>Revisa que tu correo este registrado</p>
            </div>
        </form>
    </div>
</body>
</html>
