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
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Llama a la función para eliminar el proveedor
    if (eliminarProveedor($conn, $id)) {
        echo "Eliminado❌";
    } else {
        echo "Error al eliminar el proveedor.";
    }
} else {
    echo "ID del proveedor no válido.";
}
?>
<a href="javascript:history.go(-1)">Regresar</a>
