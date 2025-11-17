<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Generar token CSRF solo si no es POST (para evitar regeneración al enviar)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar CSRF token específico
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Token CSRF inválido. Inténtalo de nuevo.";
    } else {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');
        $confirm_password = filter_input(INPUT_POST, 'confirm_password');
        
        if ($email && $password && $confirm_password) {
            if (strlen($password) >= 6) {
                if ($password === $confirm_password) {
                    if (registerUser($db, $email, $password)) {
                        $success = "Usuario registrado correctamente. Ahora puedes iniciar sesión.";
                        // Regenerar token CSRF después de registro exitoso
                        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                    } else {
                        $error = "Error al registrar el usuario. El email ya existe.";
                    }
                } else {
                    $error = "Las contraseñas no coinciden";
                }
            } else {
                $error = "La contraseña debe tener al menos 6 caracteres";
            }
        } else {
            $error = "Por favor, complete todos los campos correctamente";
        }
    }
    // Regenerar token CSRF en caso de error
    if (isset($error) && !empty($error)) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}

require __DIR__ . '/../views/register.view.php';