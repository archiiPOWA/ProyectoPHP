<?php
include("../vista/conectar.php");

session_start();

// Verifica el usuario
if (!isset($_SESSION['usuario'])) {
    // Redirige al inicio de sesión si no está autenticado
    header("Location: index.php");
    exit();
}

// Procesar acciones
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accion = $_POST['accion'];

    switch($accion) {
        case 'btnAgregar':
            agregarAdopcion($conexion);
            header('location: ../vista/registros.php');
            break;
        
        case 'btnCancelar':
            cancelarAccion();
            break;
        default:
            header('location: index.php?error=Acción no reconocida');
            exit;
    }
}

function agregarAdopcion($conexion) {
    try {
        
        // Datos de perro
        $id_perro = $_POST['txtID_PERRO'];
        $fecha_ingreso = $_POST['txtFECHA_INGRESO'];
        $color = $_POST['txtCOLOR'];
        $estado = $_POST['txtESTADO'];

        // Validaciones básicas
        if (empty($id_perro) || empty($fecha_ingreso) || empty($color) || empty($estado)) {
            throw new Exception("Todos los campos son requeridos.");
        }
        

        

        // Consultas preparadas para prevenir inyección SQL
       
        $sql_perro = "INSERT INTO perro (ID_PERRO, FECHA_INGRESO, COLOR, ESTADO) 
                      VALUES (?, ?, ?, ?)";
        $stmt_perro = $conexion->prepare($sql_perro);
        $stmt_perro->bind_param("ssss", $id_perro, $fecha_ingreso, $color, $estado);
        $stmt_perro->execute();
        header('location:vista.php?mensaje=Adopción agregada exitosamente');
    } catch (Exception $e) {
        header('location:vista.php?error=' . urlencode($e->getMessage()));
    }
}

function cancelarAccion() {
    header('location: index.php');
    exit;
}
?>