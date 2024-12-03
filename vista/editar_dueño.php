<?php
// Conexión a la base de datos
$host = 'localhost';
$user = 'root'; // Cambia si tienes un usuario diferente
$password = ''; // Cambia si tienes una contraseña configurada
$dbname = 'usuario';

$conexion = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener ID del dueño a editar
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM dueño WHERE ID_ADOPTA = $id";
    $result = $conexion->query($sql);

    if ($result && $result->num_rows > 0) {
        $dueño = $result->fetch_assoc();
    } else {
        die("Registro no encontrado.");
    }
}

// Procesar formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['ID_ADOPTA']);
    $dni = $_POST['DNI'];
    $apellido = $_POST['APELLIDO'];
    $nombre = $_POST['NOMBRE'];
    $fecha_adopcion = $_POST['FECHA_ADOPCION'];
    $email = $_POST['EMAIL'];

    $sql_update = "UPDATE dueño SET 
        DNI = '$dni', 
        APELLIDO = '$apellido', 
        NOMBRE = '$nombre', 
        FECHA_ADOPCION = '$fecha_adopcion', 
        EMAIL = '$email' 
        WHERE ID_ADOPTA = $id";

    if ($conexion->query($sql_update) === TRUE) {
        header("Location:registros.php?mensaje=Registro actualizado exitosamente");
        exit;
    } else {
        echo "Error al actualizar: " . $conexion->error;
    }
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Dueño</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
        }

        .form-container {
            width: 100%;
            max-width: 600px;
            /* Ajusta el ancho máximo */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }
    </style>





</head>
<body>
<div class="mb-3">
    <h1>Editar Dueño</h1>
    <form method="POST" action="editar_dueño.php">
        <input type="hidden" name="ID_ADOPTA" value="<?= $dueño['ID_ADOPTA'] ?>">
        <label>DNI:</label>
        <input type="text" name="DNI" value="<?= $dueño['DNI'] ?>" required><br>
        <label>Apellido:</label>
        <input type="text" name="APELLIDO" value="<?= $dueño['APELLIDO'] ?>" required><br>
        <label>Nombre:</label>
        <input type="text" name="NOMBRE" value="<?= $dueño['NOMBRE'] ?>" required><br>
        <label>Fecha de Adopción:</label>
        <input type="date" name="FECHA_ADOPCION" value="<?= $dueño['FECHA_ADOPCION'] ?>" required><br>
        <label>Email:</label>
        <input type="email" name="EMAIL" value="<?= $dueño['EMAIL'] ?>" required><br>
        <button type="submit">Guardar Cambios</button>
    </form>
</div>
</body>
</html>
