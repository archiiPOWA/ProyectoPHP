<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "usuario";

$conexion = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>
