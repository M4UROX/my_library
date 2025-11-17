<?php
session_start();

// Configuración de la base de datos
define('DB_CONNECTION', 'sqlite');
define('DB_SQLITE_PATH', __DIR__ . '/db/db.sqlite');
define('DB_HOST', 'localhost');
define('DB_NAME', 'mylibrary');
define('DB_USER', 'root');
define('DB_PASS', '');

// Configuración de la aplicación
define('APP_NAME', 'My Library');
define('APP_VERSION', '1.0');

// Rutas disponibles
$routes = [
    'home', 'books', 'login', 'logout', 'register', 'auth', 'profile',
    'add-book', 'edit-book', 'delete-book', 'save-book',
    'add-comment', 'save-comment', 'view-book', 'delete-comment',
    'edit-comment', 'save-edit-comment', 'delete-account', 'my-books-comments'  
];

// Inicializar variables de sesión si no existen
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = null;
}
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}