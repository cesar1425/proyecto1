<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modificar'])) {
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
        // Modificar estudiante
        $stmt = $pdo->prepare("UPDATE estudiantes SET nombre = ?, correo = ?, carrera = ?, codigo = ? WHERE id = ?");
        $stmt->execute([$nombre, $correo, $carrera, $codigo, $id]);
        echo "Estudiante modificado correctamente.";
    } else {
        echo "No se encontró el estudiante con el ID $id.";
    }
}
?>
