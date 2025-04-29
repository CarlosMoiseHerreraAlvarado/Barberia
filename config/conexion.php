<?php
$host = "localhost";
$usuario = "root"; // el usuario de XAMPP (generalmente es root)
$contrasena = "";  // normalmente vacío en XAMPP
$base_datos = "barberia";

try {
    $conexion = new PDO("mysql:host=$host;dbname=$base_datos;charset=utf8", $usuario, $contrasena);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
?>
