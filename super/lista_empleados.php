<?php
// Incluye el archivo de configuración y funciones CRUD
require_once("config.php");
require_once("funciones_crud.php");

// Verifica la sesión del administrador
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Obtiene la lista de empleados
$empleados = listarEmpleados($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Empleados</title>
</head>
<body>

<h2>Lista de Empleados</h2>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <!-- Agrega más columnas según la información que desees mostrar -->
    </tr>
    <?php foreach ($empleados as $empleado) : ?>
        <tr>
            <td><?php echo $empleado['id']; ?></td>
            <td><?php echo $empleado['nombre']; ?></td>
            <!-- Agrega más celdas según la información que desees mostrar -->
        </tr>
    <?php endforeach; ?>
</table>

<a href="admin_dashboard.php">Volver al Dashboard</a>

</body>
</html>
