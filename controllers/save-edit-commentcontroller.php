<?php
requireAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && verifyToken()) {
    $commentId = filter_input(INPUT_POST, 'comment_id', FILTER_VALIDATE_INT);
    $description = filter_input(INPUT_POST, 'description');
    $userId = $_SESSION['user']['id'];
    
    if ($commentId && $description) {
        require_once __DIR__ . '/../models/books.php';
        
        // Verificar propiedad antes de editar
        $comment = getCommentById($db, $commentId);
        if ($comment && $comment['user_id'] === $userId) {
            if (updateComment($db, $commentId, $userId, $description)) {
                header('Location: /view-book/' . $comment['book_id'] . '?success=comment_edited');
                exit;
            }
        }
    }
}

header('Location: /books?error=invalid');
exit;