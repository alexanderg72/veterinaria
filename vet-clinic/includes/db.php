<?php
// db.php
// Configuración de la Base de Datos
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', ''); // ¡REVISA ESTA CONTRASEÑA!
define('DB_NAME', 'vet_clinic_db');

try {
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    session_start();
} catch (PDOException $e) {
    die("<div style='padding: 20px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px;'>
            <strong>ERROR DE CONEXIÓN A LA BASE DE DATOS:</strong> Asegúrate de que MySQL esté activo y la BD exista.<br>Mensaje: " . $e->getMessage() . "
        </div>");
}
?>