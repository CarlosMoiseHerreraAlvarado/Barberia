<?php
session_start();
include("../config/conexion.php");

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

// Buscar usuario en la base de datos
$sql = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
$sentencia = $conexion->prepare($sql);
$sentencia->execute([$usuario]);
$empleado = $sentencia->fetch(PDO::FETCH_ASSOC);

// Después (comparación directa con texto plano)
if ($empleado && $contrasena == $empleado['contraseña']) {

    // Login correcto
    $_SESSION['id_usuario'] = $empleado['id_usuario'];
    $_SESSION['nombre_usuario'] = $empleado['nombre_usuario'];
    $_SESSION['id_sucursal'] = $empleado['id_sucursal'];
    header("Location: ../panel.php");
} else {
    // Login incorrecto
    echo "<script>alert('Usuario o contraseña incorrectos'); window.location.href='login.php';</script>";
}
?>
