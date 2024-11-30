<?php
// Configuración de seguridad
error_reporting(0); // Desactivar mostrar errores en producción
ini_set('display_errors', 0);

// Función para registrar intentos de login
function registrar_intento($usuario, $exitoso = false) {
    include("../core/conexion.php");
    
    $ip = $_SERVER['REMOTE_ADDR'];
    $sql = $exitoso 
        ? "INSERT INTO login_intentos (email, ip, exitoso) VALUES (?, ?, 1)"
        : "INSERT INTO login_intentos (email, ip, exitoso) VALUES (?, ?, 0)";
    
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $usuario, $ip);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Función para verificar intentos excedidos
function intentos_excedidos($usuario) {
    include("../core/conexion.php");
    
    $max_intentos = 3;
    $tiempo_bloqueo = 15 * 60; // 15 minutos
    
    $sql = "SELECT COUNT(*) as intentos FROM login_intentos 
            WHERE email = ? AND exitoso = 0 AND timestamp > DATE_SUB(NOW(), INTERVAL ? SECOND)";
    
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "si", $usuario, $tiempo_bloqueo);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    
    return $row['intentos'] >= $max_intentos;
}

// Procesamiento de login
if (isset($_POST['Login'])) {
    include("../core/conexion.php");

    if (!$conexion) {
        die("Error de conexión a la base de datos: " . mysqli_connect_error());
    }

    // Capturar y limpiar los datos de manera segura
    $u = filter_var(mysqli_real_escape_string($conexion, $_POST['dueño']), FILTER_VALIDATE_EMAIL);
    
    if (!$u) {
        header('Location: login.php?mensajee=Email inválido');
        exit();
    }

    // Verificar intentos excedidos
    if (intentos_excedidos($u)) {
        header('Location: login.php?mensajee=Demasiados intentos. Espere 15 minutos');
        exit();
    }

    // Consulta SQL preparada para obtener el hash de contraseña
    $sql = "SELECT * FROM dueño WHERE EMAIL = ?";

    $stmt = mysqli_prepare($conexion, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $u);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rstlogin = mysqli_fetch_assoc($result);

        if ($rstlogin) {
            // Verificar contraseña con password_verify
            if (password_verify($_POST['clave'], $rstlogin['CLAVE'])) {
                // Iniciar sesión de manera segura
                session_start();
                session_regenerate_id(true); // Prevenir secuestro de sesión

                // Configurar variables de sesión
                $_SESSION['dueño'] = $rstlogin['EMAIL'];
                $_SESSION['IDdueño'] = $rstlogin['ID_ADOPTA'];
                $_SESSION['Nombre'] = $rstlogin['NOMBRE'];
                $_SESSION['is_logged'] = 1;

                // Registrar intento exitoso
                registrar_intento($u, true);

                header('Location: index.php');
                exit();
            } else {
                // Contraseña incorrecta
                registrar_intento($u);
                header('Location: login.php?mensajee=Email o Contraseña Incorrectos');
                exit();
            }
        } else {
            // Usuario no encontrado
            header('Location: login.php?mensajee=Usuario no encontrado');
            exit();
        }

        mysqli_stmt_close($stmt);
    } else {
        // Error en preparación de consulta
        header('Location: login.php?mensajee=Error interno');
        exit();
    }

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
                <a class="navbar-brand" href="index.html"></a>
            </div>
        </nav>
    </header>
    <main>
        <section id="serOrador" class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-xl-8">
                    <?php 
                    // Mostrar mensajes de error
                    if(isset($_GET['mensajee'])) {
                        echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['mensajee']) . '</div>';
                    }
                    ?>
                    <h2 class="text-center">LOGIN</h2>
                    <form action="login.php" method="post" enctype="multipart/form-data" name="contact-form">
                        <div class="row gx-2">
                            <div class="form-floating col-md mb-3">
                                <input name="dueño" id="nombreOrador" type="email" class="form-control" placeholder="Email" aria-label="Email" required>
                                <label for="nombreOrador">Email</label>
                            </div>
                        </div>
                        <div class="row gx-2">
                            <div class="form-floating col-md mb-3">
                                <input name="clave" id="correoOrador" type="password" class="form-control" placeholder="Contraseña" aria-label="Contraseña" required>
                                <label for="correoOrador">Contraseña</label>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col mb-3">
                                <div class="d-grid">
                                    <button type="submit" name="Login" class="btn btn-success btn-lg btn-form">Ingresar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <a href="index.php">Volver</a>
                </div>
            </div>
        </section>
    </main>
    <footer></footer>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
        crossorigin="anonymous"></script>
</body>
</html>