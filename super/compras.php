<?php
session_start();
include('dbconfig.php');

if (!isset($_SESSION['cliente_nombre'])) {
    header("Location: login.php");
    exit();
}

// Obtener nombre del cliente de la sesión
$cliente_nombre = $_SESSION['cliente_nombre'];

// Obtener lista de empleados para el desplegable
$sql_empleados = "SELECT id_empleado, nombre FROM empleados";
$result_empleados = $conn->query($sql_empleados);

// Obtener lista de categorías
$sql_categorias = "SELECT id_categoria, nombre_categoria FROM categorias";
$result_categorias = $conn->query($sql_categorias);

// Procesar selección de empleado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["seleccionar_empleado"])) {
    $id_empleado = $_POST["id_empleado"];
    // Guardar ID del empleado en la sesión
    $_SESSION['id_empleado'] = $id_empleado;
}

// Obtener nombre del empleado de la sesión
$nombre_empleado = isset($_SESSION['id_empleado']) ? obtenerNombreEmpleado($conn, $_SESSION['id_empleado']) : '';

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

// Inicializar variables para evitar los warnings
$productos_seleccionados = isset($_POST["productos"]) ? $_POST["productos"] : [];
$cantidades = isset($_POST["cantidades"]) ? $_POST["cantidades"] : [];

// Procesar compra de productos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["comprar"])) {
    // Realizar el proceso de compra
    $total_compra = 0;

    foreach ($productos_seleccionados as $index => $id_producto) {
        // Obtener información del producto
        $sql_producto = "SELECT nombre, precio FROM productos WHERE id = ?";
        $stmt_producto = $conn->prepare($sql_producto);
        $stmt_producto->bind_param("i", $id_producto);
        $stmt_producto->execute();
        $result_producto = $stmt_producto->get_result();

        if ($result_producto->num_rows > 0) {
            $row_producto = $result_producto->fetch_assoc();
            $nombre_producto = $row_producto['nombre'];
            $precio_producto = $row_producto['precio'];

            // Calcular el total
            $total_compra += $precio_producto * $cantidades[$index];
        }
    }

    // Guardar detalles de la compra en la sesión
    $_SESSION['detalles_compra'] = [
        'productos' => $productos_seleccionados,
        'cantidades' => $cantidades,
        'total' => $total_compra,
    ];

    // Redirigir a la página del ticket de pago
    header("Location: ticket_pago.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Supermercado - Compras</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body class="container mt-5">

<h2>Bienvenido👋, <?php echo $cliente_nombre; ?>, 🛒Al Supermercado Mundo de Compras🛒</h2>

<!-- Formulario para seleccionar empleado -->
<form action="" method="post" class="mb-3">
    <div class="form-group">
        <label for="id_empleado">Selecciona un empleado:</label>
        <select name="id_empleado" class="form-control" required>
            <?php
            while ($row = $result_empleados->fetch_assoc()) {
                echo "<option value='{$row['id_empleado']}'>{$row['nombre']}</option>";
            }
            ?>
        </select>
    </div>
    <input type="submit" name="seleccionar_empleado" value="Seleccionar Empleado" class="btn btn-primary">
</form>

<!-- Información del empleado seleccionado -->
<?php
if (!empty($nombre_empleado)) {
    echo "<p class='mb-3'>Empleado seleccionado: $nombre_empleado</p>";
}
?>

<!-- Formulario para comprar productos -->
<form action="" method="post">
    <h3>Selecciona los productos que deseas comprar:</h3>

    <!-- Mostrar productos por categoría -->
    <?php
    while ($row_categoria = $result_categorias->fetch_assoc()) {
        echo "<h4>{$row_categoria['nombre_categoria']}</h4>";
        echo "<table class='table'>";
        echo "<thead><tr><th>Producto</th><th>Descripcion</th><th>Precio</th><th>Cantidad</th><th>Seleccionar</th></tr></thead>";
        echo "<tbody>";

        // Obtener productos por categoría
        $sql_productos_categoria = "SELECT id, nombre, descripcion, precio FROM productos WHERE id_categoria = ?";
        $stmt_productos_categoria = $conn->prepare($sql_productos_categoria);
        $stmt_productos_categoria->bind_param("i", $row_categoria['id_categoria']);
        $stmt_productos_categoria->execute();
        $result_productos_categoria = $stmt_productos_categoria->get_result();

        while ($row_producto = $result_productos_categoria->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row_producto['nombre']}</td>";
            echo "<td>{$row_producto['descripcion']}</td>";
            echo "<td>{$row_producto['precio']}</td>";
            echo "<td><input type='number' name='cantidades[]' value='1' min='1' class='form-control'></td>";
            echo "<td><input type='checkbox' name='productos[]' value='{$row_producto['id']}'></td>";
            echo "</tr>";
        }

        echo "</tbody></table>";
    }
    ?>

    <input type="submit" name="comprar" value="Comprar" class="btn btn-success">
</form>

<a href="logout.php" class="btn btn-secondary">Cerrar sesión</a>

</body>
</html>
