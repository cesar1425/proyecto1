<?php
session_start();

// Aumentar la cantidad de un producto en el carrito
if (isset($_GET['agregar'])) {
    $idProducto = $_GET['agregar'];
    if (isset($_SESSION['carrito'][$idProducto])) {
        // Si el producto ya está en el carrito, aumenta la cantidad
        $_SESSION['carrito'][$idProducto]['cantidad']++;
    }
    header('Location: carrito.php');
    exit;
}

// Quitar un producto del carrito
if (isset($_GET['quitar'])) {
    $idProducto = $_GET['quitar'];
    if (isset($_SESSION['carrito'][$idProducto])) {
        // Disminuye la cantidad y elimina si llega a 0
        $_SESSION['carrito'][$idProducto]['cantidad']--;
        if ($_SESSION['carrito'][$idProducto]['cantidad'] <= 0) {
            unset($_SESSION['carrito'][$idProducto]);
        }
    }
    header('Location: carrito.php');
    exit;
}

// Eliminar un producto completamente del carrito
if (isset($_GET['eliminar'])) {
    $idProducto = $_GET['eliminar'];
    if (isset($_SESSION['carrito'][$idProducto])) {
        unset($_SESSION['carrito'][$idProducto]);
    }
    header('Location: carrito.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="estilos/carrito.css">
</head>
<body>
    <h2>Carrito de Compras</h2>
    <a href="cliente.php">Volver a Productos</a>

    <ul>
        <?php if (empty($_SESSION['carrito'])): ?>
            <li>El carrito está vacío.</li>
        <?php else: ?>
            <?php foreach ($_SESSION['carrito'] as $id => $producto): ?>
                <li>
                    <?= $producto['nombre'] ?> - $<?= $producto['precio'] ?> x <?= $producto['cantidad'] ?> 
                    = $<?= $producto['precio'] * $producto['cantidad'] ?>
                    <a href="?agregar=<?= $id ?>">Agregar uno</a>
                    <a href="?quitar=<?= $id ?>">Quitar uno</a>
                    <a href="?eliminar=<?= $id ?>">Eliminar del carrito</a>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <h3>Total del Carrito: $<?php 
        $total = 0;
        foreach ($_SESSION['carrito'] as $producto) {
            $total += $producto['precio'] * $producto['cantidad'];
        }
        echo $total;
    ?></h3>
</body>
</html>
