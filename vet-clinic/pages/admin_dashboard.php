<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_admin(); // RESTRICCIÓN: Solo administradores

// Lógica para obtener métricas
$total_citas = $pdo->query("SELECT COUNT(*) FROM appointments")->fetchColumn();
$usuarios_registrados = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$citas_pendientes = $pdo->query("SELECT COUNT(*) FROM appointments WHERE status='pending'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="es">
<head><title>Admin Dashboard</title><link rel="stylesheet" href="../css/style.css"></head>
<body><div class="container" style="max-width: 900px;">
    <h2>👑 Panel de Administrador</h2>
    <nav>
        <a href="sales_dashboard.php">Ver Citas/Recepción</a> | 
        <a href="logout.php">🚪 Cerrar Sesión</a>
    </nav>
    <hr>
    
    <h3>Resumen General</h3>
    <p>Total de Citas Agendadas (Todas): <strong><?php echo $total_citas; ?></strong></p>
    <p>Citas Pendientes de Confirmar: <strong><?php echo $citas_pendientes; ?></strong></p>
    <p>Total de Usuarios Registrados: <strong><?php echo $usuarios_registrados; ?></strong></p>

    <hr>
    <h3>Funciones</h3>
    <p>Desde el panel de Recepción puedes gestionar las citas.</p>
    <p>Otras funciones (Gestión de usuarios/Reportes) requieren más código SQL/PHP avanzado.</p>

</div></body></html>