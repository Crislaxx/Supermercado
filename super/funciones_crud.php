<?php
// Funciones CRUD para empleados
function agregarEmpleado($conn, $nombre, $salario, $horario) {
    $sql = "INSERT INTO empleados (nombre, salario, horario) VALUES ('$nombre', $salario, '$horario')";
    return $conn->query($sql);
}

function listarEmpleados($conn) {
    $sql = "SELECT * FROM empleados";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['nombre']} - Salario: {$row['salario']} - Horario: {$row['horario']} ";
            echo "<a href='eliminar_empleado.php?id_empleado={$row['id_empleado']}'>Eliminar</a></li>";
        }
        echo "</ul>";
    } else {
        echo "No hay empleados registrados.";
    }
}



// En funciones_crud.php
function eliminarEmpleado($conn, $id) {
    $sql = "DELETE FROM empleados WHERE id_empleado = $id";
    if ($conn->query($sql)) {
        return "Empleado eliminado con éxito.";
    } else {
        return "Error al eliminar el empleado.";
    }
}
function eliminarProveedor($conn, $id) {
    $sql = "DELETE FROM proveedores WHERE id = $id";
    return $conn->query($sql);
}

// Funciones CRUD para proveedores
// En funciones_crud.php
function agregarProveedor($conn, $nombre, $direccion, $telefono, $tipo_proveedor) {
    $sql = "INSERT INTO proveedores (nombre, direccion, telefono, tipo_proveedor) VALUES ('$nombre', '$direccion', '$telefono', '$tipo_proveedor')";
    return $conn->query($sql);
}



function listarProveedores($conn) {
    $sql = "SELECT * FROM proveedores";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['nombre']} - Dirección: {$row['direccion']} - Teléfono: {$row['telefono']}</li>";
            echo "<a href='eliminar_proveedor.php?id={$row['id']}'>Eliminar</a></li>";
        }
        echo "</ul>";
    } else {
        echo "No hay proveedores registrados.";
    }
}

// Resto de funciones CRUD...
?>
