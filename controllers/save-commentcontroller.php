<?php
requireAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verifyToken()) {
    $bookId = filter_input(INPUT_POST, 'book_id', FILTER_VALIDATE_INT);
    $description = filter_input(INPUT_POST, 'description');
    
    if ($bookId && $description) {
        require_once __DIR__ . '/../models/books.php';
        
        if (addComment($db, $bookId, $_SESSION['user']['id'], $description)) {
            header('Location: /view-book/' . $bookId . '?success=comment');
        } else {
            header('Location: /add-comment/' . $bookId . '?error=comment');
        }
        exit;
    }
}

header('Location: /books?error=invalid');
exit;