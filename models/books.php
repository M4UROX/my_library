<?php

function getAllBooks(PDO $db, ?int $userId = null): array {
    if ($userId) {
        $stmt = $db->prepare("SELECT id, title, author, publish_date, user_id FROM books WHERE user_id = ? ORDER BY id DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    return []; // Si no hay userId, no devolver nada (privacidad)
}

function getBook(PDO $db, int $id, ?int $userId = null): ?array {
    $stmt = $db->prepare("SELECT id, title, author, publish_date, user_id FROM books WHERE id = ?");
    $stmt->execute([$id]);
    $book = $stmt->fetch();
    // Verificar propiedad si userId está presente
    if ($book && $userId && $book['user_id'] !== $userId) {
        return null; // No devolver si no es el propietario
    }
    return $book ?: null;
}

function addBook(PDO $db, string $title, string $author, string $publishDate, int $userId): bool {
    $stmt = $db->prepare("INSERT INTO books (title, author, publish_date, user_id) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$title, $author, $publishDate, $userId]);
}

function updateBook(PDO $db, int $id, string $title, string $author, string $publishDate, int $userId): bool {
    // Verificar propiedad antes de actualizar
    $book = getBook($db, $id, $userId);
    if (!$book) {
        return false;
    }
    $stmt = $db->prepare("UPDATE books SET title = ?, author = ?, publish_date = ? WHERE id = ? AND user_id = ?");
    return $stmt->execute([$title, $author, $publishDate, $id, $userId]);
}

function deleteBook(PDO $db, int $id, int $userId): bool {
    // Verificar propiedad antes de eliminar
    $book = getBook($db, $id, $userId);
    if (!$book) {
        return false;
    }
    $stmt = $db->prepare("DELETE FROM books WHERE id = ? AND user_id = ?");
    return $stmt->execute([$id, $userId]);
}

function bookExists(PDO $db, string $title, string $author, string $publishDate, int $userId): bool {
    $stmt = $db->prepare("SELECT COUNT(*) FROM books WHERE LOWER(title) = LOWER(?) AND LOWER(author) = LOWER(?) AND publish_date = ? AND user_id = ?");
    $stmt->execute([$title, $author, $publishDate, $userId]);
    return $stmt->fetchColumn() > 0;
}

// Funciones para comentarios
function getCommentsByBook(PDO $db, int $bookId): array {
    $stmt = $db->prepare("SELECT c.*, u.email FROM comments c JOIN users u ON c.user_id = u.id WHERE c.book_id = ? ORDER BY c.created_at DESC");
    $stmt->execute([$bookId]);
    return $stmt->fetchAll();
}

function addComment(PDO $db, int $bookId, int $userId, string $description): bool {
    $stmt = $db->prepare("INSERT INTO comments (book_id, user_id, description, created_at) VALUES (?, ?, ?, datetime('now'))");
    return $stmt->execute([$bookId, $userId, $description]);
}

function deleteComment(PDO $db, int $commentId, int $userId): bool {
    $stmt = $db->prepare("DELETE FROM comments WHERE id = ? AND user_id = ?");
    return $stmt->execute([$commentId, $userId]);
}

function getCommentById(PDO $db, int $commentId): ?array {
    $stmt = $db->prepare("SELECT * FROM comments WHERE id = ?");
    $stmt->execute([$commentId]);
    return $stmt->fetch() ?: null;
}

function getCommentsByUser(PDO $db, int $userId): array {
    $stmt = $db->prepare("SELECT c.*, b.title AS book_title FROM comments c JOIN books b ON c.book_id = b.id WHERE c.user_id = ? ORDER BY c.created_at DESC");
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}

function updateComment(PDO $db, int $commentId, int $userId, string $description): bool {
    $stmt = $db->prepare("UPDATE comments SET description = ? WHERE id = ? AND user_id = ?");
    return $stmt->execute([$description, $commentId, $userId]);
}