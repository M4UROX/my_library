<?php
requireAuth();

if (verifyToken()) {
    $id = $_GET['params'][0] ?? null;
    $userId = $_SESSION['user']['id'];
    
    if ($id) {
        require_once __DIR__ . '/../models/books.php';
        
        if (deleteBook($db, $id, $userId)) { // Verifica propiedad
            header('Location: /books?success=delete');
        } else {
            header('Location: /books?error=delete');
        }
        exit;
    }
}

header('Location: /books?error=invalid');
exit;