<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Principal - Barbería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Barbería</a>
    <div class="d-flex">
        <span class="navbar-text text-white me-3">
            Bienvenido, <?php echo $_SESSION['nombre_usuario']; ?>
        </span>
        <a href="logout.php" class="btn btn-outline-light">Cerrar Sesión</a>
    </div>
  </div>
</nav>

<div class="container mt-5">
    <h1 class="mb-4">Panel Principal</h1>

    <div class="row g-4">
        <div class="col-md-6">
            <a href="clientes/crear_cliente.php" class="btn btn-primary w-100 p-3">Crear Cliente</a>
        </div>
        <div class="col-md-6">
            <a href="clientes/listar_clientes.php" class="btn btn-secondary w-100 p-3">Listar Clientes</a>
        </div>
        <div class="col-md-6">
            <a href="visitas/registrar_visita.php" class="btn btn-success w-100 p-3">Registrar Visita</a>
        </div>
        <div class="col-md-6">
            <a href="visitas/historial_visitas.php" class="btn btn-info w-100 p-3">Historial de Visitas</a>
        </div>
    </div>
</div>

</body>
</html>
