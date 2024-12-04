<?php
// Conexión a la base de datos
$host = 'localhost';
$user = 'root'; 
$password = ''; 
$dbname = 'usuario';

$conexion = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener ID del dueño a eliminar
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Confirmar eliminación
    $sql = "DELETE FROM dueño WHERE ID_ADOPTA = $id";
    if ($conexion->query($sql) === TRUE) {
        header("Location:registros.php?mensaje=Registro eliminado exitosamente");
        exit;
    } else {
        echo "Error al eliminar: " . $conexion->error;
    }
} else {
    die("ID inválido.");
}

$conexion->close();
?>
