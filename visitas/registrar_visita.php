<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login/login.php");
    exit();
}

include("../config/conexion.php");

// Consultar todos los clientes para el formulario
$sql = "SELECT * FROM clientes ORDER BY nombre ASC";
$sentencia = $conexion->prepare($sql);
$sentencia->execute();
$clientes = $sentencia->fetchAll(PDO::FETCH_ASSOC);

// Si se envió el formulario para registrar visita
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_cliente = $_POST['id_cliente'];
    $id_sucursal = $_SESSION['id_sucursal']; // Tomamos la sucursal desde el login
    $fecha_visita = date('Y-m-d'); // Fecha actual

    // Insertar nueva visita
    $sql = "INSERT INTO visitas (id_cliente, id_sucursal, fecha_visita) VALUES (?, ?, ?)";
    $sentencia = $conexion->prepare($sql);
    $sentencia->execute([$id_cliente, $id_sucursal, $fecha_visita]);

    // Actualizar contador de visitas
    $sql = "UPDATE clientes SET visitas_totales = visitas_totales + 1 WHERE id_cliente = ?";
    $sentencia = $conexion->prepare($sql);
    $sentencia->execute([$id_cliente]);

    // Consultar visitas_totales del cliente
    $sql = "SELECT visitas_totales FROM clientes WHERE id_cliente = ?";
    $sentencia = $conexion->prepare($sql);
    $sentencia->execute([$id_cliente]);
    $cliente = $sentencia->fetch(PDO::FETCH_ASSOC);

    // Si llegó a 10 visitas
    if ($cliente['visitas_totales'] >= 10) {
        // Incrementar cortes gratis y resetear visitas
        $sql = "UPDATE clientes SET cortes_gratis = cortes_gratis + 1, visitas_totales = 0 WHERE id_cliente = ?";
        $sentencia = $conexion->prepare($sql);
        $sentencia->execute([$id_cliente]);

        echo "<script>alert('¡Felicidades! El cliente ganó un corte gratis.'); window.location.href='../panel.php';</script>";
        exit();
    }

    echo "<script>alert('Visita registrada correctamente'); window.location.href='../panel.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Visita - Barbería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Registrar Nueva Visita</h2>

    <form action="registrar_visita.php" method="POST" class="card p-4 shadow-sm">

        <div class="mb-3">
            <label for="id_cliente" class="form-label">Seleccionar Cliente</label>
            <select name="id_cliente" id="id_cliente" class="form-select" required>
                <option value="">Seleccione un cliente</option>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?php echo $cliente['id_cliente']; ?>">
                        <?php echo htmlspecialchars($cliente['nombre']); ?> (Visitas: <?php echo $cliente['visitas_totales']; ?> | Cortes Gratis: <?php echo $cliente['cortes_gratis']; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-success">Registrar Visita</button>
        </div>

    </form>

    <div class="mt-3">
        <a href="../panel.php" class="btn btn-secondary">Regresar al Panel</a>
    </div>
</div>

</body>
</html>
