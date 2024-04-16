<?php
// Incluye el archivo de configuración
require_once("dbconfig.php");

// Verifica la sesión del administrador
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
$adminNombre = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Administrador'; // Ajusta según tu estructura
// Incluye el archivo de funciones CRUD
require_once("funciones_crud.php");

// Agrega un nuevo empleado si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar_empleado"])) {
    $nombre = $_POST["nombre"];
    $salario = $_POST["salario"];
    $horario = $_POST["horario"];
    $tipo_empleado = $_POST["tipo_empleado"];

    if (agregarEmpleado($conn, $nombre, $salario, $horario, $tipo_empleado)) {
        echo "Empleado agregado con éxito.";
    } else {
        echo "Error al agregar el empleado.";
    }
}

// Procesa el formulario para agregar proveedor
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar_proveedor"])) {
    $nombre_prov = $_POST["nombre_prov"];
    $direccion_prov = $_POST["direccion_prov"];
    $telefono_prov = $_POST["telefono_prov"];
    $tipo_proveedor = $_POST["tipo_proveedor"];

    if (agregarProveedor($conn, $nombre_prov, $direccion_prov, $telefono_prov, $tipo_proveedor)) {
        echo "Proveedor agregado con éxito.";
    } else {
        echo "Error al agregar el proveedor.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
<div class="container">
        <h2>Bienvenido Administrador👨‍💼, <?php echo $adminNombre; ?>.</h2>
        
        <h2>Empleados</h2>
        <div class="row">
            <div class="col-md-6">
                <h3>Listado de Empleados:</h3>
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Salario</th>
                            <th scope="col">Horario</th>
                            <th scope="col">Tipo</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
                <?php listarEmpleados($conn); ?>
            </div>
            <div class="col-md-6">
                <h3>Agregar Empleado:</h3>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="nombre">Nombre del Empleado:</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="salario">Salario:</label>
                        <input type="text" name="salario" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="horario">Horario:</label>
                        <input type="text" name="horario" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo_empleado">Tipo Area de Empleado:</label>
                        <select name="tipo_empleado" class="form-control" required>
                            <option value="servicios">Area limpieza🧼</option>
                            <option value="servicios">Area bebidas🥤</option>
                            <option value="servicios">Productos comida🍗</option>
                            <option value="servicios">Productos Panaderia🥖🥐</option>

                            <!-- Agrega más opciones según tus necesidades -->
                        </select>
                    </div>
                    <input type="submit" name="agregar_empleado" value="Agregar Empleado" class="btn btn-primary">
                </form>
            </div>
        </div>

        <h2>Proveedores</h2>
        <div class="row">
            <div class="col-md-6">
                <h3>Listado de Proveedores:</h3>
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Dirección</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">Tipo Proveedor</th>
                    </tr>
                    
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
                <?php listarProveedores($conn); ?>
            </div>
            <div class="col-md-6">
                <h3>Agregar Proveedor:</h3>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="nombre_prov">Nombre del Proveedor:</label>
                        <input type="text" name="nombre_prov" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="direccion_prov">Dirección del Proveedor:</label>
                        <input type="text" name="direccion_prov" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono_prov">Teléfono del Proveedor:</label>
                        <input type="text" name="telefono_prov" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo_proveedor">Tipo Area de Proveedor:</label>
                        <select name="tipo_proveedor" class="form-control" required>
                            <option value="productos">Productos bebibas🥤</option>
                            <option value="productos">Productos comida🍗</option>
                            <option value="productos">Productos panaderia🥖</option>
                            <option value="productos">Productos limpieza🧼</option>
                        </select>
                    </div>
                    <input type="submit" name="agregar_proveedor" value="Agregar Proveedor" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
    

    <!-- Agrega jQuery a tu archivo si aún no lo has hecho -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
       // Script para manejar la eliminación mediante AJAX
        function eliminarEmpleado(id) {
            if (confirm("¿Estás seguro de que deseas eliminar este empleado?")) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                           // Mostrar el mensaje de eliminación en el mismo lugar
                            alert(xhr.responseText);
                           // Recargar la lista de empleados (puedes ajustar esto según tu lógica)
                            location.reload();
                        } else {
                            alert("Error al eliminar el empleado.");
                        }
                    }
                };
                xhr.open("GET", "eliminar_empleado.php?id=" + id, true);
                xhr.send();
            }
        }
    </script>
    <style>/* Estilos para el enlace de cerrar sesión */
.logout-link {
    color: #ffffff; /* Color del texto */
    background-color: #dc3545; /* Color de fondo */
    padding: 8px 16px; /* Espaciado interno */
    text-decoration: none; /* Quita la subrayado por defecto */
    border-radius: 4px; /* Bordes redondeados */
    transition: background-color 0.3s ease; /* Transición suave del color de fondo */
}

.logout-link:hover {
    background-color: #c82333; /* Cambia el color de fondo al pasar el mouse */
}
</style>

<a href="logout.php" class="logout-link">Cerrar sesión</a>

</body>
</html>
