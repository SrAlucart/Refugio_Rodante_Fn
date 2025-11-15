<?php
$conexion = new mysqli("127.0.0.1", "root", "", "rodante", env('DB_PORT', '3306'));


if ($conexion->connect_error) {
    die("❌ Error de conexión: " . $conexion->connect_error);
}
echo "✅ Conexión exitosa a MySQL en el puerto 3307 y a la base de datos 'rodante'";
?>
