<?php

/**
 * Sistema de enrutamiento simple
 * Convierte la URL en controlador correspondiente
 */
function router(array $routes): string {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = trim($uri, '/');
    $segments = explode('/', $uri);
    
    // Obtener la ruta base o usar 'home' por defecto
    $route = $segments[0] ?? 'home';
    if ($route === '') {
        $route = 'home';
    }
    
    // Manejo de parámetros en la URL
    if (count($segments) > 1) {
        $_GET['params'] = array_slice($segments, 1);
    }
    
    // Verificar si la ruta existe
    if (!in_array($route, $routes)) {
        http_response_code(404);
        require 'views/404.view.php';
        exit;
    }
    
    return $route . 'controller';
}

/**
 * Debug helper - Muestra variable y termina ejecución
 */
function dd($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}