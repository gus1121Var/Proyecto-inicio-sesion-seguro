<?php
session_start();

// Generar token CSRF si no existe
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificación del token CSRF
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Error: CSRF token inválido.");
    }

    $nombre = htmlspecialchars($_POST['Nombre']);
    $correo = filter_var($_POST['Correo'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['Contraseña'];
    $password2 = $_POST['Contraseña2'];
    
    // Validar contraseñas
    if ($password !== $password2) {
        die("Error: Las contraseñas no coinciden.");
    }

    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$/', $password)) {
        die("Error: La contraseña no cumple con los requisitos de seguridad.");
    }

    // Hash de la contraseña
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    $token = bin2hex(random_bytes(50));

    // Conexión a la base de datos
    $conn = new mysqli('localhost', 'username', 'password', 'database');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prevenir inyección SQL
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, password, token, verificado) VALUES (?, ?, ?, ?, 0)");
    $stmt->bind_param("ssss", $nombre, $correo, $passwordHash, $token);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    // Envío del correo de verificación
    $asunto = "Verifica tu correo electrónico";
    $mensaje = "Haz clic en el siguiente enlace para verificar tu correo electrónico: ";
    $mensaje .= "http://localhost/verify.php?token=" . $token;
    $headers = "From: no-reply@tu-sitio.com";

    if (mail($correo, $asunto, $mensaje, $headers)) {
        echo "Correo de verificación enviado. Por favor revisa tu bandeja de entrada.";
    } else {
        echo "Error al enviar el correo de verificación.";
    }
}
?>
