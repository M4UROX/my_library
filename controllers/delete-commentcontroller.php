<?php
requireAuth();
require __DIR__ . '/../models/books.php'; 
// Obtener el ID del comentario desde params
if (!isset($_GET['params']) || !isset($_GET['params'][0]) || !is_numeric($_GET['params'][0])) {
    header('Location: /books');
    exit;
}

$commentId = (int)$_GET['params'][0];
$userId = $_SESSION['user']['id'];

// Obtener el comentario para saber a qué libro pertenece
$comment = getCommentById($db, $commentId);

if (!$comment) {
    header('Location: /books');
    exit;
}

// Verificar que el comentario pertenece al usuario actual
if ($comment['user_id'] !== $userId) {
    header('Location: /view-book/' . $comment['book_id']);
    exit;
}

// Eliminar el comentario
if (deleteComment($db, $commentId, $userId)) {
    header('Location: /view-book/' . $comment['book_id'] . '?success=comment_deleted');
} else {
    header('Location: /view-book/' . $comment['book_id'] . '?error=delete_failed');
}
exit;