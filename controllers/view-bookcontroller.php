<?php
requireAuth();

$bookId = $_GET['params'][0] ?? null;
$userId = $_SESSION['user']['id'];

if (!$bookId) {
    header('Location: /books?error=invalid');
    exit;
}

require_once __DIR__ . '/../models/books.php';
$book = getBook($db, $bookId, $userId);
$comments = getCommentsByBook($db, $bookId);

if (!$book) {
    header('Location: /books?error=notfound');
    exit;
}

require __DIR__ . '/../views/view_book.view.php';