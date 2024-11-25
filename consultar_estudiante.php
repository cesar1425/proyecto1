<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['consultar'])) {
    $id = $_POST['id'];
    
    // Consultar el estudiante por ID
    $stmt = $pdo->prepare("SELECT * FROM estudiantes WHERE id = ?");
    $stmt->execute([$id]);
    $estudiante = $stmt->fetch();

    if ($estudiante) {
        echo "ID: " . $estudiante['id'] . "<br>";
        echo "Nombre: " . $estudiante['nombre'] . "<br>";
        echo "Correo: " . $estudiante['correo'] . "<br>";
        echo "Carrera: " . $estudiante['carrera'] . "<br>";
        echo "Código: " . $estudiante['codigo'] . "<br>";
    } else {
        echo "Estudiante no encontrado.";
    }
}
?>
