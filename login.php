<?php
// Habilitar errores para diagnosticar problemas
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

// Iniciar sesión para manejar roles y datos del usuario
session_start();

// Función para autenticar al usuario
function autenticar($usuario, $contraseña) {
    // Acceder al objeto PDO desde db.php
    global $pdo;

    try {
        // Preparar la consulta SQL para obtener los datos del usuario
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $usuarioData = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontró el usuario y si la contraseña coincide
        if ($usuarioData && $usuarioData['contraseña'] === $contraseña) {
            // Configurar la sesión del usuario
            $_SESSION['usuario'] = $usuarioData['usuario'];
            $_SESSION['rol'] = $usuarioData['rol']; // Ejemplo: 'admin' o 'cliente'
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        echo "Error en la autenticación: " . $e->getMessage();
        return false;
    }
}

// Inicializar variables
$error = '';

// Procesar el formulario de login si se ha enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar si los campos están definidos y no son nulos
    $usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
    $contraseña = isset($_POST['contraseña']) ? trim($_POST['contraseña']) : '';

    // Validar los datos ingresados
    if (empty($usuario) || empty($contraseña)) {
        $error = "Por favor, completa todos los campos.";
    } elseif (autenticar($usuario, $contraseña)) {
        // Redirigir al usuario según su rol
        header('Location: ' . ($_SESSION['rol'] === 'admin' ? 'admin.php' : 'cliente.php'));
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="estilos/login.css">
</head>
<body>
    <h2>Mi Tienda</h2>
    <form method="POST" action="">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required>
        <button type="submit">Iniciar Sesión</button>
    </form>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
</body>
</html>
