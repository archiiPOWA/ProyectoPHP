<?php


session_start();

require 'conectar.php';

if (isset($_POST['submit'])) {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];


    // Sanitizar los datos de entrada
    $usuario = trim($usuario);
    $usuario = htmlspecialchars($usuario, ENT_QUOTES, 'UTF-8');
    $usuario = strip_tags($usuario);

    if (!empty($usuario) && !empty($password)) {
        // Preparar la consulta SQL
        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = ? AND password = ?");
        $stmt->bind_param("ss", $usuario, $password);

        // Ejecutar y verificar si existe el usuario
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Usuario autenticado
           
            $_SESSION['usuario'] = $usuario;

            header('Location:registros.php');
        
        } else {
            echo 'Usuario o contraseña incorrectos';
        }

        // Cerrar la conexión y liberar la memoria
        $stmt->close();
        $conexion->close();
    } else {
        
        echo 'Por favor ingresa tu usuario y contraseña.';
    }
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="form-container">
        <h2>Inicia Sesión.</h2>
        <form action="index.php" method="POST">

            <!-- usuario -->
            <label class="label" for="usuario">Usuario:</label>
            <input class="mod" type="text" id="usuario" name="usuario" placeholder="Usuario" required>


            <!-- Contraseña -->
            <label class="label" for="password">Contraseña:</label>
            <input class="mod" type="password" id="password" name="password" placeholder="Contraseña" required>


            <!-- Botones -->
            <button type="submit" name="submit">Ingresar</button>
            <button type="reset">Reset</button>
        </form>
    </div>
</body>

</html>