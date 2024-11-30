<?php
if (isset($_POST['Login'])) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include("../core/conexion.php");

    if (!$conexion) {
        die("Error de conexión a la base de datos: " . mysqli_connect_error());
    }

    // Capturar y limpiar los datos
    $u = mysqli_real_escape_string($conexion, $_POST['dueño']);
    $p = md5($_POST['clave']); // Cambiar a password_hash() en el futuro para mayor seguridad

    // Consulta SQL
    $sql = "SELECT * FROM dueño WHERE EMAIL = ? AND CLAVE = ?";

    $stmt = mysqli_prepare($conexion, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $u, $p);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rstlogin = mysqli_fetch_assoc($result);

        if ($rstlogin) {
            session_start();
            session_regenerate_id(true);

            $_SESSION['dueño'] = $rstlogin['EMAIL'];
            $_SESSION['IDdueño'] = $rstlogin['ID_ADOPTA'];
            $_SESSION['Nombre'] = $rstlogin['NOMBRE'];
            $_SESSION['is_logged'] = 1;

            header('Location: index.php');
            exit();
        } else {
            header('Location: login.php?mensajee=Email o Contraseña Incorrectos');
            exit();
        }

        mysqli_stmt_close($stmt);
    } else {
        die("Error en la preparación de la consulta: " . mysqli_error($conexion));
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
    <title></title>
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    <!-- CSS adicional -->
    <link rel="stylesheet" href="css/estilos.css" />
</head>

<body>
    <header>
        <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.html">
                   
                </a>
                
            </div>
        </nav>
    </header>
    <main>
        <section id="serOrador" class="container" >
            <div class="row justify-content-center">
                <div class="col-lg-7 col-xl-8">
                    <p class="text-center"></p>
                    <h2 class="text-center">LOGIN</h2>
                    <p class="text-center"></p>
                    <form action="login.php" method="post" enctype="multipart/form-data" name="contact-form" >
                        <div class="row gx-2">
                            <div class="form-floating col-md mb-3">
                                <input name="dueño" id="nombreOrador" type="email" class="form-control" placeholder="Nombre" aria-label="Nombre" required>
                                <label for="nombreOrador">Email</label>
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
    <footer>
       
    </footer>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
        crossorigin="anonymous"></script>
    
</body>

</html>