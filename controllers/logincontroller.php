<?php
// Generar token CSRF solo si no es POST (para evitar regeneración al enviar)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
require __DIR__ . '/../views/login.view.php';
