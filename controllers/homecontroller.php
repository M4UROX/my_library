<?php
require_once __DIR__ . '/../models/books.php';

$userId = $_SESSION['user']['id'] ?? null;
$books = getAllBooks($db, $userId); // Solo libros del usuario logueado, o ninguno
require __DIR__ . '/../views/home.view.php';