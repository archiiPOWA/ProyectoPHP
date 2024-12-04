<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
        <h1 class="text-center mb-4">Agregar Perro al Refugio.</h1>

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

        <form action="../core/nuevoPerro.php" method="POST" enctype="multipart/form-data" class="p-4 border rounded">


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
                <label for="txtESTADO" class="form-label">Estado:</label>
                <select name="txtESTADO" id="txtESTADO" class="form-control" required>
                    <option value="DISPONIBLE">Disponible</option>
                    <option value="ADOPTADO">Adoptado</option>
                </select>
            </div>



            <div class="d-flex justify-content-between">
                <button type="submit" name="accion" value="btnAgregar" class="btn btn-success">Agregar</button>
                <!-- <button type="submit" name="accion" value="btnModificar" class="btn btn-warning">Modificar</button>
                <button type="submit" name="accion" value="btnEliminar" class="btn btn-danger">Eliminar</button> -->
                <a href="principal.php" class="btn btn-danger" onclick="return confirm('¿Cancelas?')">Cancelar</a>
            </div>
        </form>
    </div>

</body>

</html>