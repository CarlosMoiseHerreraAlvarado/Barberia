<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login/login.php");
    exit();
}

include("../config/conexion.php");

// Consultar todos los clientes
$sql = "SELECT * FROM clientes ORDER BY nombre ASC";
$sentencia = $conexion->prepare($sql);
$sentencia->execute();
$clientes = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Clientes - Barbería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Lista de Clientes</h2>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Visitas Totales</th>
                <th>Cortes Gratis</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes as $cliente): ?>
            <tr>
                <td><?php echo $cliente['id_cliente']; ?></td>
                <td><?php echo htmlspecialchars($cliente['nombre']); ?></td>
                <td><?php echo htmlspecialchars($cliente['telefono']); ?></td>
                <td><?php echo $cliente['visitas_totales']; ?></td>
                <td><?php echo $cliente['cortes_gratis']; ?></td>
                <td>
                    <a href="editar_cliente.php?id=<?php echo $cliente['id_cliente']; ?>" class="btn btn-sm btn-primary">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>

            <?php if (count($clientes) == 0): ?>
            <tr>
                <td colspan="6" class="text-center">No hay clientes registrados</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="../panel.php" class="btn btn-secondary">Regresar al Panel</a>
</div>

</body>
</html>
