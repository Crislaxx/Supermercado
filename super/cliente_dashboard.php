<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'cliente') {
    header("Location: login.php");
    exit();
}

// Puedes agregar aquí cualquier lógica adicional específica del cliente, como procesar compras, mostrar historial de compras, etc.
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard del Cliente</title>
</head>
<body>

<h2>Bienvenido al Dashboard del Cliente</h2>

<!-- Agrega aquí las funciones para realizar compras -->

<a href="logout.php">Cerrar sesión</a>

</body>
</html>
