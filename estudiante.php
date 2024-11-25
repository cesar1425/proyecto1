<?php
require_once 'db.php';

// Variables para manejo de formularios
$id = '';
$estudiante = null;

// Manejo de formularios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['consultar'])) {
        // Consultar estudiante por ID
        $id = $_POST['id'];
        $stmt = $pdo->prepare("SELECT * FROM estudiantes WHERE id = ?");
        $stmt->execute([$id]);
        $estudiante = $stmt->fetch();

        // Verificar si existe el estudiante
        if (!$estudiante) {
            echo "No se encontró el estudiante con el ID $id.";
        }
    } elseif (isset($_POST['eliminar'])) {
        // Eliminar estudiante
        $id = $_POST['id'];

        // Verificar si el estudiante existe
        $stmt = $pdo->prepare("SELECT * FROM estudiantes WHERE id = ?");
        $stmt->execute([$id]);
        $estudianteExistente = $stmt->fetch();

        if ($estudianteExistente) {
            // Eliminar el estudiante
            $stmt = $pdo->prepare("DELETE FROM estudiantes WHERE id = ?");
            $stmt->execute([$id]);
            echo "Estudiante eliminado correctamente.";
        } else {
            echo "No se encontró el estudiante con el ID $id.";
        }
    } elseif (isset($_POST['modificar'])) {
        // Modificar estudiante
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $carrera = $_POST['carrera'];
        $codigo = $_POST['codigo'];

        // Verificar si el estudiante existe
        $stmt = $pdo->prepare("SELECT * FROM estudiantes WHERE id = ?");
        $stmt->execute([$id]);
        $estudianteExistente = $stmt->fetch();

        if ($estudianteExistente) {
            // Actualizar el estudiante
            $stmt = $pdo->prepare("UPDATE estudiantes SET nombre = ?, correo = ?, carrera = ?, codigo = ? WHERE id = ?");
            $stmt->execute([$nombre, $correo, $carrera, $codigo, $id]);
            echo "Estudiante modificado correctamente.";
        } else {
            echo "No se encontró el estudiante con el ID $id.";
        }
    }
}

// Función para obtener todos los estudiantes
function obtenerEstudiantes() {
    global $pdo;
    $stmt = $pdo->query('SELECT * FROM estudiantes');
    return $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Estudiantes</title>
    <link rel="stylesheet" href="estilos/admin.css">
</head>
<body>
    <h2>Gestión de Estudiantes</h2>

    <!-- Formulario para agregar estudiantes -->
    <form action="agregar_estudiante.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br>
        
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required>
        <br>
        
        <label for="carrera">Carrera:</label>
        <input type="text" id="carrera" name="carrera" required>
        <br>
        
        <label for="codigo">Código:</label>
        <input type="text" id="codigo" name="codigo" required>
        <br>

        <button type="submit">Agregar Estudiante</button>
    </form>

    <!-- Formulario para consultar estudiante -->
    <form action="estudiantes.php" method="POST">
        <label for="id">ID del Estudiante:</label>
        <input type="number" id="id" name="id" required>
        <br>

        <button type="submit" name="consultar">Consultar Estudiante</button>
    </form>

    <!-- Formulario para eliminar estudiante -->
    <form action="estudiantes.php" method="POST">
        <label for="id">ID del Estudiante:</label>
        <input type="number" id="id" name="id" required>
        <br>

        <button type="submit" name="eliminar">Eliminar Estudiante</button>
    </form>

    <!-- Formulario para modificar estudiante -->
    <form action="estudiantes.php" method="POST">
        <label for="id">ID del Estudiante:</label>
        <input type="number" id="id" name="id" required>
        <br>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br>

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required>
        <br>

        <label for="carrera">Carrera:</label>
        <input type="text" id="carrera" name="carrera" required>
        <br>

        <label for="codigo">Código:</label>
        <input type="text" id="codigo" name="codigo" required>
        <br>

        <button type="submit" name="modificar">Modificar Estudiante</button>
    </form>

    <!-- Mostrar todos los estudiantes -->
    <h3>Estudiantes Registrados</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Carrera</th>
            <th>Código</th>
        </tr>
        <?php 
        $estudiantes = obtenerEstudiantes();
        foreach ($estudiantes as $est): ?>
            <tr>
                <td><?= htmlspecialchars($est['id']) ?></td>
                <td><?= htmlspecialchars($est['nombre']) ?></td>
                <td><?= htmlspecialchars($est['correo']) ?></td>
                <td><?= htmlspecialchars($est['carrera']) ?></td>
                <td><?= htmlspecialchars($est['codigo']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Formulario para cerrar sesión -->
    <form action="logout.php" method="POST">
        <button type="submit">Cerrar Sesión</button>
    </form>
</body>
</html>
