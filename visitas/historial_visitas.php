<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login/login.php");
    exit();
}

include("../config/conexion.php");

// Consultar todas las visitas
$sql = "SELECT v.id_visita, c.nombre AS cliente, s.nombre AS sucursal, v.fecha_visita
        FROM visitas v
        JOIN clientes c ON v.id_cliente = c.id_cliente
        JOIN sucursales s ON v.id_sucursal = s.id_sucursal
        ORDER BY v.fecha_visita DESC";
$sentencia = $conexion->prepare($sql);
$sentencia->execute();
$visitas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Visitas - Barbería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Historial de Visitas</h2>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Sucursal</th>
                <th>Fecha de Visita</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($visitas as $visita): ?>
            <tr>
                <td><?php echo $visita['id_visita']; ?></td>
                <td><?php echo htmlspecialchars($visita['cliente']); ?></td>
                <td><?php echo htmlspecialchars($visita['sucursal']); ?></td>
                <td><?php echo $visita['fecha_visita']; ?></td>
            </tr>
            <?php endforeach; ?>

            <?php if (count($visitas) == 0): ?>
            <tr>
                <td colspan="4" class="text-center">No hay visitas registradas</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="../panel.php" class="btn btn-secondary">Regresar al Panel</a>
</div>

</body>
</html>
