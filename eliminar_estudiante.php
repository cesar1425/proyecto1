<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    $id = $_POST['id'];
    
    // Verificar si el estudiante existe
    $stmt = $pdo->prepare("SELECT * FROM estudiantes WHERE id = ?");
    $stmt->execute([$id]);
    $estudianteExistente = $stmt->fetch();

    if ($estudianteExistente) {
        // Eliminar estudiante
        $stmt = $pdo->prepare("DELETE FROM estudiantes WHERE id = ?");
        $stmt->execute([$id]);
        echo "Estudiante eliminado correctamente.";
    } else {
        echo "No se encontró el estudiante con el ID $id.";
    }
}
?>
