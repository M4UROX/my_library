<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar CSRF token específico
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Token CSRF inválido. Inténtalo de nuevo.";
    } else {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');
        
        if ($email && $password) {
            if (authenticate($db, $email, $password)) {
                // Regenerar token CSRF después de login exitoso
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                header('Location: /home');  
                exit;
            } else {
                $error = "Credenciales incorrectas";
            }
        } else {
            $error = "Datos del formulario inválidos";
        }
    }
    // Regenerar token CSRF en caso de error
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require __DIR__ . '/../views/login.view.php';