<?php
// Iniciar sesión
session_start();

// Incluir la conexión a la base de datos y las funciones
include 'db.php';

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['usuario'])) {
    // Función para verificar si el usuario es administrador
    function esAdmin() {
        return isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';
    }

    // Función para verificar si el usuario es cliente
    function esCliente() {
        return isset($_SESSION['rol']) && $_SESSION['rol'] === 'cliente';
    }

    // Redirigir según el rol del usuario
    if (esAdmin()) {
        header('Location: admin.php');
        exit;
    } elseif (esCliente()) {
        header('Location: cliente.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda Online</title>
    <link rel="stylesheet" href="estilos/inicio.css">
</head>
<body>
    <h1>Bienvenido a Nuestra Tienda Online</h1>
    <p>Para continuar, por favor <a href="login.php">inicie sesión</a>.</p>
</body>
</html>

