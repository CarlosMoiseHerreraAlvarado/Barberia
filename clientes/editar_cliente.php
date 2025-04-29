<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login/login.php");
    exit();
}

include("../config/conexion.php");

// Verificar si enviaron un ID
if (!isset($_GET['id'])) {
    header("Location: listar_clientes.php");
    exit();
}

$id_cliente = $_GET['id'];

// Consultar los datos del cliente
$sql = "SELECT * FROM clientes WHERE id_cliente = ?";
$sentencia = $conexion->prepare($sql);
$sentencia->execute([$id_cliente]);
$cliente = $sentencia->fetch(PDO::FETCH_ASSOC);

if (!$cliente) {
    echo "<script>alert('Cliente no encontrado'); window.location.href='listar_clientes.php';</script>";
    exit();
}

// Si se envió el formulario para actualizar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];

    $sql = "UPDATE clientes SET nombre = ?, telefono = ? WHERE id_cliente = ?";
    $sentencia = $conexion->prepare($sql);
    $sentencia->execute([$nombre, $telefono, $id_cliente]);

    echo "<script>alert('Cliente actualizado correctamente'); window.location.href='listar_clientes.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente - Barbería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Editar Cliente</h2>

    <form action="editar_cliente.php?id=<?php echo $id_cliente; ?>" method="POST" class="card p-4 shadow-sm">

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Cliente</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo htmlspecialchars($cliente['nombre']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" name="telefono" id="telefono" class="form-control" value="<?php echo htmlspecialchars($cliente['telefono']); ?>">
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Actualizar Cliente</button>
        </div>

    </form>

    <div class="mt-3">
        <a href="listar_clientes.php" class="btn btn-secondary">Cancelar</a>
    </div>
</div>

</body>
</html>
