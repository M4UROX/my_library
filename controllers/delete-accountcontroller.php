<?php
requireAuth();  // Requiere autenticación

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verifyToken()) {  // Verifica POST y CSRF
    $password = filter_input(INPUT_POST, 'delete_password');
    $userId = $_SESSION['user']['id'];
    
    if ($password) {
        require_once __DIR__ . '/../database.php';
        
        if (deleteUser($db, $userId, $password)) {
            // Destruir sesión y redirigir
            session_destroy();
            session_start();
            $_SESSION['user'] = null;
            header('Location: /home?success=account_deleted');
            exit;
        } else {
            header('Location: /profile?error=delete_failed');
            exit;
        }
    }
}

header('Location: /profile?error=invalid');
exit;