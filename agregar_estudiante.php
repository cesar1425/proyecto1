<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $carrera = trim($_POST['carrera']);
    $codigo = trim($_POST['codigo']);

    if (empty($nombre) || empty($correo) || empty($carrera) || empty($codigo)) {
        echo "Todos los campos son obligatorios.";
    } else {
        try {
            // Preparar la consulta para insertar
            $stmt = $pdo->prepare("INSERT INTO estudiantes (nombre, correo, carrera, codigo) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nombre, $correo, $carrera, $codigo]);

            // Redirigir al listado principal
            header('Location: estudiantes.php');
            exit;
        } catch (PDOException $e) {
            echo "Error al agregar estudiante: " . $e->getMessage();
        }
    }
}
?>
