<?php
requireAuth();

$bookId = $_GET['params'][0] ?? null;
if (!$bookId) {
    header('Location: /books?error=invalid');
    exit;
}

require_once __DIR__ . '/../models/books.php';
$book = getBook($db, $bookId);

if (!$book) {
    header('Location: /books?error=notfound');
    exit;
}

require __DIR__ . '/../views/add-comment.view.php';