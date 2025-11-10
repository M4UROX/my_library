<?php
requireAuth();

$id = $_GET['params'][0] ?? null;

if ($id) {
    require_once __DIR__ . '/../models/books.php';
    $book = getBook($db, $id);
    
    if ($book) {
        require __DIR__ . '/../views/book_form.view.php';
    } else {
        header('Location: /books?error=notfound');
        exit;
    }
} else {
    header('Location: /books?error=invalid');
    exit;
}