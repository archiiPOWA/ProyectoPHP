<?php
// Configuración de seguridad
error_reporting(0); // Desactivar mostrar errores en producción
ini_set('display_errors', 0);

// Archivo de configuración de base de datos
require_once("../core/conexion.php");

// Clase de gestión de login
class LoginManager {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    // Registrar intentos de login
    private function registrarIntento($usuario, $exitoso = false) {
        $ip = $_SERVER['REMOTE_ADDR'];
        $sql = $exitoso 
            ? "INSERT INTO login_intentos (email, ip, exitoso, timestamp) VALUES (?, ?, 1, NOW())"
            : "INSERT INTO login_intentos (email, ip, exitoso, timestamp) VALUES (?, ?, 0, NOW())";
        
        $stmt = mysqli_prepare($this->conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $usuario, $ip);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Verificar intentos excedidos
    private function intentosExcedidos($usuario) {
        $max_intentos = 3;
        $tiempo_bloqueo = 15 * 60; // 15 minutos
        
        $sql = "SELECT COUNT(*) as intentos FROM login_intentos 
                WHERE email = ? AND exitoso = 0 AND timestamp > DATE_SUB(NOW(), INTERVAL ? SECOND)";
        
        $stmt = mysqli_prepare($this->conexion, $sql);
        mysqli_stmt_bind_param($stmt, "si", $usuario, $tiempo_bloqueo);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        
        return $row['intentos'] >= $max_intentos;
    }

    // Validar credenciales
    public function validarLogin($email, $clave) {
        // Validar formato de email
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (!$email) {
            return ['success' => false, 'message' => 'Email inválido'];
        }

        // Verificar intentos excedidos
        if ($this->intentosExcedidos($email)) {
            return ['success' => false, 'message' => 'Demasiados intentos. Espere 15 minutos'];
        }

        // Consulta preparada
        $sql = "SELECT * FROM dueño WHERE EMAIL = ?";
        $stmt = mysqli_prepare($this->conexion, $sql);

        if (!$stmt) {
            return ['success' => false, 'message' => 'Error interno de consulta'];
        }

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $usuario = mysqli_fetch_assoc($result);

        if (!$usuario) {
            $this->registrarIntento($email);
            return ['success' => false, 'message' => 'Usuario no encontrado'];
        }

        // Verificar contraseña
        if (password_verify($clave, $usuario['CLAVE'])) {
            // Inicio de sesión exitoso
            $this->registrarIntento($email, true);
            return [
                'success' => true, 
                'usuario' => [
                    'email' => $usuario['EMAIL'],
                    'id' => $usuario['ID_ADOPTA'],
                    'nombre' => $usuario['NOMBRE']
                ]
            ];
        } else {
            // Contraseña incorrecta
            $this->registrarIntento($email);
            return ['success' => false, 'message' => 'Contraseña incorrecta'];
        }
    }

    // Iniciar sesión
    public function iniciarSesion($usuario) {
        session_start();
        session_regenerate_id(true);

        $_SESSION['dueño'] = $usuario['email'];
        $_SESSION['IDdueño'] = $usuario['id'];
        $_SESSION['Nombre'] = $usuario['nombre'];
        $_SESSION['is_logged'] = 1;
    }
}

// Procesamiento del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Login'])) {
    // Incluir conexión a la base de datos
    require_once("../core/conexion.php");

    // Crear instancia de LoginManager
    $loginManager = new LoginManager($conexion);

    // Intentar login
    $resultado = $loginManager->validarLogin($_POST['dueño'], $_POST['clave']);

    if ($resultado['success']) {
        // Login exitoso
        $loginManager->iniciarSesion($resultado['usuario']);
        header('Location: index.php');
        exit();
    } else {
        // Login fallido
        header('Location: login.php?mensajee=' . urlencode($resultado['message']));
        exit();
    }

    // Cerrar conexión
    mysqli_close($conexion);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Seguro</title>
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    <!-- CSS adicional -->
    <link rel="stylesheet" href="css/estilos.css" />
</head>
<body>
    <header>
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.html">Sistema de Login</a>
            </div>
        </nav>
    </header>
    
    <main class="container mt-5 pt-5">
        <section id="loginSection" class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center">
                        <h2>Iniciar Sesión</h2>
                    </div>
                    <div class="card-body">
                        <?php 
                        // Mostrar mensajes de error
                        if(isset($_GET['mensajee'])) {
                            echo '<div class="alert alert-danger text-center">' . 
                                 htmlspecialchars($_GET['mensajee']) . 
                                 '</div>';
                        }
                        ?>
                        <form action="login.php" method="post" name="loginForm">
                            <div class="form-floating mb-3">
                                <input 
                                    type="email" 
                                    class="form-control" 
                                    id="floatingInput" 
                                    name="dueño" 
                                    placeholder="nombre@ejemplo.com" 
                                    required
                                >
                                <label for="floatingInput">Correo Electrónico</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    id="floatingPassword" 
                                    name="clave" 
                                    placeholder="Contraseña" 
                                    required
                                >
                                <label for="floatingPassword">Contraseña</label>
                            </div>
                            
                            <div class="d-grid">
                                <button 
                                    type="submit" 
                                    name="Login" 
                                    class="btn btn-primary btn-lg"
                                >
                                    Iniciar Sesión
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <a href="recuperar-clave.php" class="text-muted">¿Olvidaste tu contraseña?</a>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <a href="index.php" class="btn btn-link">Volver al Inicio</a>
                </div>
            </div>
        </section>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
        crossorigin="anonymous"></script>
</body>
</html>