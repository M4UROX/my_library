<?php
requireAuth();

$user = $_SESSION['user'];
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verifyToken()) {
    $new_email = filter_input(INPUT_POST, 'new_email', FILTER_VALIDATE_EMAIL);
    $confirm_email = filter_input(INPUT_POST, 'confirm_email');
    $email_password = filter_input(INPUT_POST, 'email_password');
    $current_password = filter_input(INPUT_POST, 'current_password');
    $new_password = filter_input(INPUT_POST, 'new_password');
    $confirm_password = filter_input(INPUT_POST, 'confirm_password');
    
    $email_updated = false;
    $password_updated = false;
    
    // Procesar cambio de email
    if ($new_email) {
        if (!$email_password) {
            $error = "Debes ingresar tu contraseña actual para cambiar el email.";
        } elseif (!password_verify($email_password, $user['password'])) {
            $error = "La contraseña actual es incorrecta para cambiar el email.";
        } elseif ($new_email !== $confirm_email) {
            $error = "Los correos electrónicos no coinciden.";
        } elseif ($new_email === $user['email']) {
            $error = "El nuevo correo electrónico debe ser diferente al actual.";
        } else {
            // Verificar si el nuevo email ya existe
            $stmt = $db->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
            $stmt->execute([$new_email, $user['id']]);
            
            if ($stmt->fetch()) {
                $error = "Este email ya está en uso por otro usuario.";
            } else {
                // Actualizar email
                $stmt = $db->prepare("UPDATE users SET email = ? WHERE id = ?");
                if ($stmt->execute([$new_email, $user['id']])) {
                    $_SESSION['user']['email'] = $new_email;
                    $email_updated = true;
                    $success = "Correo electrónico actualizado correctamente";
                } else {
                    $error = "Error al actualizar el correo electrónico";
                }
            }
        }
    }
    
    // Procesar cambio de contraseña
    if ($new_password) {
        if (!$current_password) {
            $error = "Debes ingresar tu contraseña actual para cambiarla.";
        } elseif (!password_verify($current_password, $user['password'])) {
            $error = "La contraseña actual es incorrecta.";
        } elseif ($new_password !== $confirm_password) {
            $error = "Las nuevas contraseñas no coinciden.";
        } elseif (strlen($new_password) < 6) {
            $error = "La nueva contraseña debe tener al menos 6 caracteres.";
        } else {
            $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
            if ($stmt->execute([$hashedPassword, $user['id']])) {
                $password_updated = true;
                if ($email_updated) {
                    $success .= " y contraseña actualizada correctamente";
                } else {
                    $success = "Contraseña actualizada correctamente";
                }
            } else {
                $error = "Error al actualizar la contraseña";
            }
        }
    }
    
    // Si no hay cambios pero se envió el formulario
    if (!$new_email && !$new_password && empty($error)) {
        $success = "No se realizaron cambios";
    }
    
    $user = $_SESSION['user']; // Actualizar datos
}

require __DIR__ . '/../views/profile.view.php';