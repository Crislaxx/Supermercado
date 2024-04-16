<?php
session_start();

include('dbconfig.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['Nombre'];
    $contrasena = $_POST['contrasena'];

    $admin_query = "SELECT * FROM administradores WHERE nombre='$nombre' AND contrasena='$contrasena'";
    $admin_result = $conn->query($admin_query);

    if ($admin_result->num_rows > 0) {
        $row = $admin_result->fetch_assoc();
        $_SESSION['id'] = $row['id'];
        $_SESSION['rol'] = 'admin';
        $_SESSION['nombre'] = $row['nombre']; // Guarda el nombre del administrador en la sesión
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Credenciales incorrectas para el usuario '$nombre'";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Supermercado🛒</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh; /* Establece el 100% de la altura de la ventana */
            margin: 0; /* Elimina los márgenes predeterminados del cuerpo */
        }

        #contenedor {
            display: flex;
            align-items: center;
            justify-content: center;
            max-width: 800px; /* Ajusta según sea necesario */
            width: 100%;
            padding: 20px;
            box-shadow: 0 0 10px #ddd;
            background-color: #fff;
        }

        img {
            margin-right: 20px; /* Añade un espacio entre la imagen y el contenido */
            max-width: 100%;
            height: auto;
        }

        h2 {
            color: #333;
            text-align: center;
            margin-top: 0;
        }

        form {
            width: 300px;
            padding: 20px;
            border: 1px solid #ddd;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            outline: none;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #337ab7;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #286090;
        }

        p {
            text-align: center;
            margin-top: 20px;
        }

        a {
            color: #337ab7;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div id="contenedor">
    <img id="imagenSupermercado" src="s.jpeg" alt="">
        <div>
            <h2>Mundo de Compras🛒</h2>
            <form action="" method="post">
                Nombre: <input type="text" name="Nombre" required><br>
                Contraseña: <input type="password" name="contrasena" required><br>
                <input type="submit" value="Iniciar sesión">
            </form>
            <p>¿Eres nuevo? <a href="registro_cliente.php">Regístrate aquí como cliente</a></p>

            <?php
            if (isset($error)) {
                echo "<p>$error</p>";
            }
            ?>
        </div>
    </div>

    <script>
        // Array de nombres de las imágenes
        var imagenes = ["sup.jpeg", "super.jpeg", "supermercado.jpeg", "s.jpeg"];
        var indiceImagen = 0;

        // Función para cambiar la imagen cada 3 segundos
        function cambiarImagen() {
            document.getElementById("imagenSupermercado").src = imagenes[indiceImagen];
            indiceImagen = (indiceImagen + 1) % imagenes.length;
        }

        // Iniciar el cambio de imagen al cargar la página
        setInterval(cambiarImagen, 3000);
    </script>
</body>
</html>
