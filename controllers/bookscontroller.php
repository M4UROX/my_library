<?php
require_once __DIR__ . '/../models/books.php';

$userId = $_SESSION['user']['id'] ?? null;
$books = getAllBooks($db, $userId);
require __DIR__ . '/../views/books_list.view.php';