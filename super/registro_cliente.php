<?php
session_start();

include('dbconfig.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];

    $insert_cliente_query = "INSERT INTO clientes (nombre, direccion, telefono) VALUES ('$nombre', '$direccion', '$telefono')";

    if ($conn->query($insert_cliente_query) === TRUE) {
        // Cliente registrado con éxito, redirigir a la página de compras
        $_SESSION['cliente_nombre'] = $nombre; // Guarda el nombre del cliente en sesión
        header("Location: compras.php");
        exit();
    } else {
        $error = "Error al registrar el cliente: " . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Cliente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('ss.jpeg'); /* Reemplaza 'tu_imagen_de_fondo.jpg' con la ruta de tu imagen */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            box-sizing: border-box;
            background-color: rgba(255, 255, 255, 0.8); /* Agrega un fondo blanco semi-transparente para mejorar la legibilidad */
            border-radius: 10px; /* Añade esquinas redondeadas */
        }

        form {
            display: grid;
            grid-template-columns: 1fr;
            grid-gap: 10px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 8px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p {
            margin-top: 20px;
            text-align: center;
        }

        p a {
            color: #007BFF;
            text-decoration: none;
        }

        p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Registro de Cliente</h2>
    <form action="" method="post">
        <label for="nombre">Nombre Completo📝:</label>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="direccion">Dirección⬆️:</label>
        <input type="text" id="direccion" name="direccion" required><br>

        <label for="telefono">Teléfono📱:</label>
        <input type="text" id="telefono" name="telefono" required><br>

        <input type="submit" value="Registrarse✅">
    </form>

    <?php
    if (isset($error)) {
        echo "<p>$error</p>";
    }
    ?>

    <p>Listo para tus compras🛒 <a href="login.php">Salir◀️</a></p>
</div>

</body>
</html>
