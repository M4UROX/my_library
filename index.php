<?php
require 'config.php';
require 'database.php';
require 'helper.php';

// Conectar a la base de datos
try {
    $db = dbConnect();
} catch (Exception $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}

// Determinar qué controlador cargar según la ruta
$controller = router($routes);

// Cargar el controlador correspondiente o mostrar 404
if ($controller === '404') {
    http_response_code(404);
    require 'views/404.view.php';
} else {
    $controllerPath = "controllers/{$controller}.php";
    if (file_exists($controllerPath)) {
        require $controllerPath;
    } else {
        http_response_code(404);
        require 'views/404.view.php';
    }
}