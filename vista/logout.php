
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<style>
    h3{
        text-align: center;
    }
</style>


</head>
<body>
    
<?php
include 'navbar.php';

session_start();
session_destroy();

echo '<h3>'.$_SESSION['usuario'].' Ha cerrado sesion.'.'</h3>';

echo '<h3><a href="index.php">Login</a></h3>';

?>
</body>
</html>