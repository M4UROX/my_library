<?php
requireAuth();  // Requiere autenticación para ver contenido privado

$userId = $_SESSION['user']['id'];

// Obtener libros del usuario
require_once __DIR__ . '/../models/books.php';
$books = getAllBooks($db, $userId);  // Solo libros del usuario

// Obtener comentarios del usuario (con info del libro)
$comments = getCommentsByUser($db, $userId);  // Necesitas esta función nueva en models

require __DIR__ . '/../views/my-books-comments.view.php';