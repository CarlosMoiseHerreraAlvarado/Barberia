<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login/login.php");
    exit();
}

include("../config/conexion.php");

// Si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];

    // Insertar nuevo cliente
    $sql = "INSERT INTO clientes (nombre, telefono) VALUES (?, ?)";
    $sentencia = $conexion->prepare($sql);
    $sentencia->execute([$nombre, $telefono]);

    echo "<script>alert('Cliente creado correctamente'); window.location.href='../panel.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Cliente</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Registrar nuevo cliente</h2>
    <form method="POST" action="crear_cliente.php">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono:</label>
            <input type="text" class="form-control" name="telefono" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar cliente</button>
    </form>
</body>
</html>
