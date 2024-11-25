<?php
require_once 'db.php';

// Variables para manejo de formularios
$nombre = $id = $facultad = '';
$director = null;

// Manejo de formularios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregar'])) {
        // Agregar director
        $nombre = $_POST['nombre'];
        $facultad = $_POST['facultad'];

        // Preparar e insertar director
        $stmt = $pdo->prepare("INSERT INTO directores (nombre, facultad) VALUES (?, ?)");
        $stmt->execute([$nombre, $facultad]);
        echo "Director agregado correctamente.";
    } elseif (isset($_POST['consultar'])) {
        // Consultar director por ID
        $id = $_POST['id'];
        $stmt = $pdo->prepare("SELECT * FROM directores WHERE id = ?");
        $stmt->execute([$id]);
        $director = $stmt->fetch();

        // Verificar si existe el director
        if (!$director) {
            echo "No se encontró el director con el ID $id.";
        }
    } elseif (isset($_POST['eliminar'])) {
        // Eliminar director
        $id = $_POST['id'];

        // Verificar si el director existe
        $stmt = $pdo->prepare("SELECT * FROM directores WHERE id = ?");
        $stmt->execute([$id]);
        $directorExistente = $stmt->fetch();

        if ($directorExistente) {
            // Eliminar el director
            $stmt = $pdo->prepare("DELETE FROM directores WHERE id = ?");
            $stmt->execute([$id]);
            echo "Director eliminado correctamente.";
        } else {
            echo "No se encontró el director con el ID $id.";
        }
    } elseif (isset($_POST['modificar'])) {
        // Modificar director
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $facultad = $_POST['facultad'];

        // Verificar si el director existe
        $stmt = $pdo->prepare("SELECT * FROM directores WHERE id = ?");
        $stmt->execute([$id]);
        $directorExistente = $stmt->fetch();

        if ($directorExistente) {
            // Actualizar el director
            $stmt = $pdo->prepare("UPDATE directores SET nombre = ?, facultad = ? WHERE id = ?");
            $stmt->execute([$nombre, $facultad, $id]);
            echo "Director modificado correctamente.";
        } else {
            echo "No se encontró el director con el ID $id.";
        }
    }
}

// Función para obtener todos los directores
function obtenerDirectores() {
    global $pdo;
    $stmt = $pdo->query('SELECT * FROM directores');
    return $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Directores</title>
    <link rel="stylesheet" href="estilos/admin.css">
</head>
<body>
    <h2>Gestión de Directores</h2>

    <!-- Formulario para agregar director -->
    <form action="director.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?= $nombre ?>" required>
        <br>
        
        <label for="facultad">Facultad:</label>
        <input type="text" id="facultad" name="facultad" value="<?= $facultad ?>" required>
        <br>

        <button type="submit" name="agregar">Agregar Director</button>
    </form>

    <!-- Formulario para consultar director por ID -->
    <form action="director.php" method="POST">
        <label for="id">ID del Director:</label>
        <input type="number" id="id" name="id" value="<?= $id ?>" required>
        <br>

        <button type="submit" name="consultar">Consultar Director</button>
    </form>

    <!-- Formulario para eliminar director por ID -->
    <form action="director.php" method="POST">
        <label for="id">ID del Director:</label>
        <input type="number" id="id" name="id" value="<?= $id ?>" required>
        <br>

        <button type="submit" name="eliminar">Eliminar Director</button>
    </form>

    <!-- Formulario para modificar director -->
    <form action="director.php" method="POST">
        <label for="id">ID del Director:</label>
        <input type="number" id="id" name="id" value="<?= $id ?>" required>
        <br>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?= $nombre ?>" required>
        <br>

        <label for="facultad">Facultad:</label>
        <input type="text" id="facultad" name="facultad" value="<?= $facultad ?>" required>
        <br>

        <button type="submit" name="modificar">Modificar Director</button>
    </form>

    <!-- Mostrar los directores -->
    <h3>Directores Registrados</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Facultad</th>
        </tr>
        <?php 
        $directores = obtenerDirectores();
        foreach ($directores as $dir): ?>
            <tr>
                <td><?= $dir['id'] ?></td>
                <td><?= $dir['nombre'] ?></td>
                <td><?= $dir['facultad'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Formulario para cerrar sesión -->
    <form action="logout.php" method="POST">
        <button type="submit">Cerrar Sesión</button>
    </form>

</body>
</html>
