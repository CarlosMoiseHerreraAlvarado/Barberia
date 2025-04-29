<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login/login.php");
    exit();
}

include("config/conexion.php");

// Consultar datos básicos del sistema
$sql = "SELECT COUNT(*) as total_clientes FROM clientes";
$sentencia = $conexion->prepare($sql);
$sentencia->execute();
$total_clientes = $sentencia->fetch(PDO::FETCH_ASSOC)['total_clientes'];

$sql = "SELECT COUNT(*) as total_visitas FROM visitas";
$sentencia = $conexion->prepare($sql);
$sentencia->execute();
$total_visitas = $sentencia->fetch(PDO::FETCH_ASSOC)['total_visitas'];

$sql = "SELECT SUM(cortes_gratis) as cortes_gratis FROM clientes";
$sentencia = $conexion->prepare($sql);
$sentencia->execute();
$total_cortes_gratis = $sentencia->fetch(PDO::FETCH_ASSOC)['cortes_gratis'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control - Barbería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Panel de Control</h2>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total de Clientes</h5>
                    <p class="card-text"><?php echo $total_clientes; ?></p>
                    <a href="clientes/listar_clientes.php" class="btn btn-primary">Ver Clientes</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total de Visitas</h5>
                    <p class="card-text"><?php echo $total_visitas; ?></p>
                    <a href="visitas/historial_visitas.php" class="btn btn-primary">Ver Historial de Visitas</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Cortes Gratis Otorgados</h5>
                    <p class="card-text"><?php echo $total_cortes_gratis; ?></p>
                    <a href="clientes/listar_clientes.php" class="btn btn-primary">Ver Clientes con Cortes Gratis</a>
                </div>
            </div>
        </div>
    </div>

    <div>
        <a href="visitas/registrar_visita.php" class="btn btn-success">Registrar Nueva Visita</a>
        <a href="clientes/crear_cliente.php" class="btn btn-success">Registrar Nuevo Cliente</a>
    </div>
</div>

</body>
</html>
