<?php

function getAllBooks(PDO $db): array {
    $stmt = $db->query("SELECT id, title, author, publish_date FROM books ORDER BY id DESC");
    return $stmt->fetchAll();
}

function getBook(PDO $db, int $id): ?array {
    $stmt = $db->prepare("SELECT id, title, author, publish_date FROM books WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch() ?: null;
}

function addBook(PDO $db, string $title, string $author, string $publishDate): bool {
    $stmt = $db->prepare("INSERT INTO books (title, author, publish_date) VALUES (?, ?, ?)");
    return $stmt->execute([$title, $author, $publishDate]);
}

function updateBook(PDO $db, int $id, string $title, string $author, string $publishDate): bool {
    $stmt = $db->prepare("UPDATE books SET title = ?, author = ?, publish_date = ? WHERE id = ?");
    return $stmt->execute([$title, $author, $publishDate, $id]);
}

function deleteBook(PDO $db, int $id): bool {
    $stmt = $db->prepare("DELETE FROM books WHERE id = ?");
    return $stmt->execute([$id]);
}

function bookExists(PDO $db, string $title, string $author, string $publishDate): bool {
    $stmt = $db->prepare("SELECT COUNT(*) FROM books WHERE LOWER(title) = LOWER(?) AND LOWER(author) = LOWER(?) AND publish_date = ?");
    $stmt->execute([$title, $author, $publishDate]);
    return $stmt->fetchColumn() > 0;
}

// Funciones para comentarios (CON created_at)
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