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
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .btn {
            padding: 5px 10px;
            margin: 5px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #0056b3;
        }

        h3{
            text-align: center;
        }
    </style>
</head>
<body>

<?php
include 'navbar.php';
?>

    <h3>Registro Actualizado de Adoptantes</h3>
    <a href="vista.php" class="btn btn-success">Agregar Adoptante</a>

<div class="mb-3">
    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>DNI</th>
                    <th>Apellido</th>
                    <th>Nombre</th>
                    <th>Fecha de Adopción</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['ID_ADOPTA'] ?></td>
                        <td><?= $row['DNI'] ?></td>
                        <td><?= $row['APELLIDO'] ?></td>
                        <td><?= $row['NOMBRE'] ?></td>
                        <td><?= $row['FECHA_ADOPCION'] ?></td>
                        <td><?= $row['EMAIL'] ?></td>
                        <td>
                            <a href="editar_dueño.php?id=<?= $row['ID_ADOPTA'] ?>" class="btn">Editar</a>
                            <a href="eliminar_dueño.php?id=<?= $row['ID_ADOPTA'] ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este registro?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No se encontraron registros en la tabla.</p>
    <?php endif; ?>

    <?php $conexion->close(); ?>
</div>

       
</body>
</html>


