<?php
require_once 'db.php';

// Puedes mantener la lógica de sesión si es necesaria
// Por ejemplo, verificar si el usuario está autenticado
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="estilos/admin.css">
</head>
<body>
    <h2>Panel de Administración</h2>

    <!-- Botones para redireccionar a las secciones -->
    <div class="menu">
        <button onclick="location.href='estudiante.php'">Gestionar Estudiantes</button>
        <button onclick="location.href='director.php'">Gestionar Directores de Proyecto</button>
        <button onclick="location.href='proyecto.php'">Gestionar Fechas de Proyecto</button>
    </div>

    <!-- Formulario para cerrar sesión -->
    <form action="logout.php" method="POST">
        <button type="submit">Cerrar Sesión y Volver al Login</button>
    </form>

</body>
</html>
