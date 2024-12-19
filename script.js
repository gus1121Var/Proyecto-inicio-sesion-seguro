document.getElementById('registrationForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Previene el envío del formulario por defecto

    // Limpiar mensajes de error
    document.getElementById('emailError').style.display = 'none';
    document.getElementById('passwordError').style.display = 'none';
    document.getElementById('confirmPasswordError').style.display = 'none';

    // Obtener valores de los campos
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirmPassword').value;

    // Validaciones
    var isValid = true;

    // Validar correo electrónico
    var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailPattern.test(email)) {
        document.getElementById('emailError').textContent = 'Ingrese un correo electrónico válido.';
        document.getElementById('emailError').style.display = 'block';
        isValid = false;
    }

    // Validar contraseña
    var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
    if (!passwordPattern.test(password)) {
        document.getElementById('passwordError').textContent = 'La contraseña debe tener al menos 8 caracteres, una letra mayúscula, una minúscula y un número.';
        document.getElementById('passwordError').style.display = 'block';
        isValid = false;
    }

    // Validar confirmación de contraseña
    if (password !== confirmPassword) {
        document.getElementById('confirmPasswordError').textContent = 'Las contraseñas no coinciden.';
        document.getElementById('confirmPasswordError').style.display = 'block';
        isValid = false;
    }

    // Si todas las validaciones pasan, se puede enviar el formulario
    if (isValid) {
        alert('Formulario enviado exitosamente.');
        // Aquí puedes enviar el formulario usando AJAX o cualquier otra técnica si lo deseas
        // this.submit(); // Descomentar para enviar el formulario
    }
});
