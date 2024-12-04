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

// Verificar si se recibió un ID a través de GET
if (isset($_GET['id'])) {
    $idPerro = intval($_GET['id']); // Asegurar que sea un número entero

    // Preparar la consulta para eliminar el perro
    $sql = "DELETE FROM perro WHERE ID_PERRO = ?";

    // Usar una declaración preparada para evitar inyecciones SQL
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idPerro);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir de vuelta a la página principal con un mensaje de éxito
        header("Location: disponiblePerro.php?mensaje=Perro eliminado exitosamente");
        exit();
    } else {
        echo "Error al eliminar el perro: " . $conexion->error;
    }

    // Cerrar la declaración
    $stmt->close();
} else {
    echo "ID de perro no especificado.";
}

// Cerrar la conexión
$conexion->close();
?>
