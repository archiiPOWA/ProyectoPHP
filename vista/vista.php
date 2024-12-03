<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Adopciones</title>
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
    <div class="form-container">
        <h1 class="text-center mb-4">Gestión de Adopciones</h1>

        <?php
        if (isset($_GET['mensaje'])) {
            $mensaje = $_POST['mensaje'];
            echo "<script>alert('$mensaje');</script>";
        }
        ?>

        <?php
        if (isset($_GET['error'])) {
            $mensaje = $_GET['mensaje'];
            echo "<script>alert('$mensaje');</script>";
        }
        ?>

        <form action="../core/procesar.php" method="POST" enctype="multipart/form-data" class="p-4 border rounded">
            <h3>Datos del Adoptante</h3>
            <div class="mb-3">
                <label for="txtID_ADOPTA" class="form-label">ID Adopta:</label>
                <input type="text" name="txtID_ADOPTA" id="txtID_ADOPTA" class="form-control">
            </div>
            <div class="mb-3">
                <label for="txtDNI" class="form-label">DNI:</label>
                <input type="text" name="txtDNI" id="txtDNI" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="txtAPELLIDO" class="form-label">Apellido:</label>
                <input type="text" name="txtAPELLIDO" id="txtAPELLIDO" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="txtNOMBRE" class="form-label">Nombre:</label>
                <input type="text" name="txtNOMBRE" id="txtNOMBRE" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="txtFECHA_ADOPCION" class="form-label">Fecha de Adopción:</label>
                <input type="date" name="txtFECHA_ADOPCION" id="txtFECHA_ADOPCION" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="tuemail@ejemplo.com" required>
            </div>

            <h3>Datos del Perro</h3>
            <div class="mb-3">
                <label for="txtID_PERRO" class="form-label">ID Perro:</label>
                <input type="text" name="txtID_PERRO" id="txtID_PERRO" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="txtFECHA_INGRESO" class="form-label">Fecha de Ingreso:</label>
                <input type="date" name="txtFECHA_INGRESO" id="txtFECHA_INGRESO" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="txtCOLOR" class="form-label">Color:</label>
                <input type="text" name="txtCOLOR" id="txtCOLOR" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="txtESTADP" class="form-label">Estado:</label>
                <select name="txtESTADP" id="txtESTADP" class="form-control" required>
                    <option value="Disponible">Disponible</option>
                    <option value="Adoptado">Adoptado</option>
                </select>
            </div>

            <h3>Datos de Adopción</h3>
            <div class="mb-3">
                <label for="txtID_ADOPCION" class="form-label">ID Adopción:</label>
                <input type="text" name="txtID_ADOPCION" id="txtID_ADOPCION" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="txtID_USUARIO" class="form-label">ID Usuario:</label>
                <input type="text" name="txtID_USUARIO" id="txtID_USUARIO" class="form-control" required>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" name="accion" value="btnAgregar" class="btn btn-success">Agregar</button>
                <!-- <button type="submit" name="accion" value="btnModificar" class="btn btn-warning">Modificar</button>
                <button type="submit" name="accion" value="btnEliminar" class="btn btn-danger">Eliminar</button> -->
                <a href="registros.php" class="btn btn-danger" onclick="return confirm('¿Cancelas?')">Cancelar</a>
            </div>
        </form>
    </div>
</body>

</html>