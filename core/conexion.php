<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "usuario";

// Conexión a la base de datos
$conexion = mysqli_connect($host, $user, $password, $database);

// Verifica si la conexión falló
if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
} else {
    echo "Conexión exitosa a la base de datos";
}
?>