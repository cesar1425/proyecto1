<?php
// db.php

// Configuración de la base de datos
$host = 'localhost';
$db   = 'tienda'; // Cambia esto por el nombre de tu base de datos
$user = 'root';    // Usuario predeterminado de MySQL en XAMPP
$pass = '';        // Contraseña vacía (por defecto en XAMPP)
$charset = 'utf8mb4';

// Configurar DSN y opciones de PDO
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Modo de errores
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch como array asociativo
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Desactiva emulación de prepared statements
];

// Crear conexión a la base de datos
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}

// Función para autenticar usuario
function autenticarUsuario($usuario, $contraseña) {
    global $pdo;

    try {
        // Buscar al usuario en la base de datos
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $usuarioData = $stmt->fetch();

        // Verificar si el usuario existe y la contraseña coincide
        if ($usuarioData && password_verify($contraseña, $usuarioData['contraseña'])) {
            session_start();
            $_SESSION['usuario'] = $usuarioData['usuario'];
            $_SESSION['rol'] = $usuarioData['rol']; // Guardar rol del usuario (admin o cliente)
            return true;
        }
    } catch (PDOException $e) {
        echo "Error en la autenticación: " . $e->getMessage();
    }

    return false; // Usuario o contraseña incorrectos
}

// Función para verificar si el usuario es administrador
function esAdmin() {
    return isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';
}

// Función para verificar si el usuario es cliente
function esCliente() {
    return isset($_SESSION['rol']) && $_SESSION['rol'] === 'cliente';
}
?>

