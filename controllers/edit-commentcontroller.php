<?php
requireAuth();

$commentId = $_GET['params'][0] ?? null;
$userId = $_SESSION['user']['id'];

if (!$commentId) {
    header('Location: /books?error=invalid');
    exit;
}

require_once __DIR__ . '/../models/books.php';
$comment = getCommentById($db, $commentId);

// Verificar que el comentario existe y pertenece al usuario
if (!$comment || $comment['user_id'] !== $userId) {
    header('Location: /books?error=notfound');
    exit;
}

// Obtener el libro para mostrar el título
$book = getBook($db, $comment['book_id'], $userId);
if (!$book) {
    header('Location: /books?error=notfound');
    exit;
}

require __DIR__ . '/../views/edit-comment.view.php';