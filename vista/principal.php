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

// Consulta para obtener los datos de la tabla 'dueño'
$sql = "SELECT ID_ADOPTA, DNI, APELLIDO, NOMBRE, FECHA_ADOPCION, EMAIL FROM dueño";
$result = $conexion->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoptantes </title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    
      <style>
        main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Ocupa toda la altura de la pantalla */
            margin: 0;
            background-color: #f0f0f0; /* Color de fondo opcional */
        }
    
    </style>
</head>
<body>
    

  <?php
include 'navbar.php';
?>



<main>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="48" height="48" stroke-width="1">
        <path d="M11 5h2"></path>
        <path d="M19 12c-.667 5.333 -2.333 8 -5 8h-4c-2.667 0 -4.333 -2.667 -5 -8"></path>
        <path d="M11 16c0 .667 .333 1 1 1s1 -.333 1 -1h-2z"></path>
        <path d="M12 18v2"></path>
        <path d="M10 11v.01"></path>
        <path d="M14 11v.01"></path>
        <path d="M5 4l6 .97l-6.238 6.688a1.021 1.021 0 0 1 -1.41 .111a.953 .953 0 0 1 -.327 -.954l1.975 -6.815z"></path>
        <path d="M19 4l-6 .97l6.238 6.688c.358 .408 .989 .458 1.41 .111a.953 .953 0 0 0 .327 -.954l-1.975 -6.815z"></path>
    </svg>
</main>



</body>
</html>


