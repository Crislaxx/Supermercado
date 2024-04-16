<?php
require_once("dbconfig.php");
require_once("funciones_crud.php");

// Verifica la sesión del administrador
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Verifica si se proporciona un ID válido
if (isset($_GET['id_empleado']) && is_numeric($_GET['id_empleado'])) {
    $id_empleado = $_GET['id_empleado'];

    // Llama a la función para eliminar el empleado
    if (eliminarEmpleado($conn, $id_empleado)) {
        echo "Eliminado❌";
    } else {
        echo "Error al eliminar el empleado.";
    }
} else {
    echo "ID de empleado no válido.";
}
?>
<a href="javascript:history.go(-1)">Regresar</a>
