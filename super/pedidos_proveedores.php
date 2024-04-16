<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Aquí puedes agregar cualquier lógica adicional específica del administrador, como funciones de CRUD, estadísticas, etc.
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedidos a Proveedores - Dashboard del Administrador</title>
</head>
<body>

<h2>Pedidos a Proveedores</h2>

<!-- Puedes agregar aquí funciones de CRUD específicas para pedidos a proveedores -->

<a href="logout.php">Cerrar sesión</a>

</body>
</html>
