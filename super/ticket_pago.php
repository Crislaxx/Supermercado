<?php
session_start();
include('dbconfig.php');

// Verificar si hay detalles de compra en la sesión
if (!isset($_SESSION['detalles_compra'])) {
    header("Location: compras.php");
    exit();
}

// Obtener detalles de la compra de la sesión
$detalles_compra = $_SESSION['detalles_compra'];

// Obtener nombre del empleado
$id_empleado = $_SESSION['id_empleado'];
$nombre_empleado = obtenerNombreEmpleado($conn, $id_empleado);

// Función para obtener el nombre de un empleado por su ID
function obtenerNombreEmpleado($conn, $id_empleado) {
    $sql = "SELECT nombre FROM empleados WHERE id_empleado = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_empleado);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['nombre'];
    } else {
        return 'Empleado no encontrado';
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket de Pago</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<style>
body {
            background: rgb(238,174,202);
            background: radial-gradient(circle, rgba(238,174,202,1) 0%, rgba(148,187,233,1) 100%);
            color: #ffffff;
        }

        .ticket-container {
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            transition: background 1s ease; /* Transición suave del cambio de color */
        };
    </style>

<body class="container mt-5">

<h2>Ticket de Pago</h2>

<p>Atendido por: <?php echo $nombre_empleado; ?></p>

<table class="table">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total_compra = 0;

        foreach ($detalles_compra['productos'] as $index => $id_producto) {
            $cantidad = $detalles_compra['cantidades'][$index];

            // Obtener información del producto
            $sql_producto = "SELECT nombre, precio FROM productos WHERE id = ?";
            $stmt_producto = $conn->prepare($sql_producto);
            $stmt_producto->bind_param("i", $id_producto);
            $stmt_producto->execute();
            $result_producto = $stmt_producto->get_result();

            if ($result_producto->num_rows > 0) {
                $row_producto = $result_producto->fetch_assoc();
                $nombre_producto = $row_producto['nombre'];
                $precio_unitario = $row_producto['precio'];
                $total_producto = $precio_unitario * $cantidad;
                $total_compra += $total_producto;

                echo "<tr>";
                echo "<td>{$nombre_producto}</td>";
                echo "<td>{$cantidad}</td>";
                echo "<td>{$precio_unitario}</td>";
                echo "<td>{$total_producto}</td>";
                echo "</tr>";
            }
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3">Total:</td>
            <td><?php echo $total_compra; ?></td>
        </tr>
    </tfoot>
</table>

<a href="compras.php" class="btn btn-primary">Volver a Compras</a>

</body>
</html>

