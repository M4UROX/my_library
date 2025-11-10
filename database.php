<?php

/**
 * Conexión a base de datos SQLite
 * Crea el directorio si no existe y establece la conexión PDO
 */
function connectSqlite($path = null) {
    $path = $path ?? DB_SQLITE_PATH;
    
    // Crear directorio si no existe
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    
    $pdo = new PDO("sqlite:$path");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    return $pdo;
}

/**
 * Conexión a base de datos MySQL
 * Establece conexión usando credenciales definidas en constantes
 */
function connectMysql() {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
}

/**
 * Conexión principal a la base de datos
 * Selecciona el driver según la configuración
 */
function dbConnect() {
    try {
        if (DB_CONNECTION === 'sqlite') {
            return connectSqlite();
        } else {
            return connectMysql();
        }
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}

/**
 * Ejecuta consulta SELECT y retorna todos los resultados
 */
function dbQuery($db, $sql, $params = []) {
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

/**
 * Ejecuta consulta SELECT y retorna un solo resultado
 */
function dbQueryOne($db, $sql, $params = []) {
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetch();
}

/**
 * Ejecuta consultas INSERT, UPDATE, DELETE
 */
function dbExecute($db, $sql, $params = []) {
    $stmt = $db->prepare($sql);
    return $stmt->execute($params);
}

/**
 * Autentica usuario verificando email y contraseña
 * Al éxito, establece variables de sesión
 */
function authenticate(PDO $db, string $email, string $password): bool {
    $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $stmt = $db->prepare($sql);
    
    if ($stmt->execute([$email])) {
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            $_SESSION['token'] = bin2hex(random_bytes(32));
            $_SESSION['welcome_message'] = "¡Bienvenido de nuevo! Has iniciado sesión correctamente.";
            return true;
        }
    }
    return false;
}

/**
 * Registra nuevo usuario en la base de datos
 * Verifica que el email no exista previamente
 */
function registerUser(PDO $db, string $email, string $password): bool {
    // Verificar si el usuario ya existe
    $checkSql = "SELECT id FROM users WHERE email = ?";
    $checkStmt = $db->prepare($checkSql);
    $checkStmt->execute([$email]);
    
    if ($checkStmt->fetch()) {
        return false; // Usuario ya existe
    }
    
    $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
    $stmt = $db->prepare($sql);
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    return $stmt->execute([$email, $hashedPassword]);
}

/**
 * Middleware para requerir autenticación
 * Redirige a login si no hay usuario en sesión
 */
function requireAuth() {
    if (!isset($_SESSION['user']) || $_SESSION['user'] === null) {
        header('Location: /login');
        exit;
    }
}

/**
 * Verifica token CSRF para protección contra ataques
 */
function verifyToken(): bool {
    return isset($_POST['token']) && $_POST['token'] === $_SESSION['token'];
}