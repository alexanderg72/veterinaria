<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_clinic_access(); // RESTRICCIÓN: Solo Admin o Sales

$message = isset($_SESSION['status_message']) ? $_SESSION['status_message'] : '';
unset($_SESSION['status_message']); // Limpiar mensaje después de mostrar

// Lógica para obtener todas las citas activas
$sql_all_appts = "SELECT 
    a.id, a.date_time, a.reason, a.status, p.name AS pet_name, u.name AS client_name, u.phone 
    FROM appointments a 
    JOIN pets p ON a.pet_id = p.id 
    JOIN users u ON a.client_id = u.id 
    WHERE a.status IN ('pending', 'confirmed') 
    ORDER BY a.date_time ASC";

$stmt_all_appts = $pdo->prepare($sql_all_appts);
$stmt_all_appts->execute();
$all_appointments = $stmt_all_appts->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head><title>Recepción Dashboard</title><link rel="stylesheet" href="../css/style.css"></head>
<body><div class="container" style="max-width: 1000px;">
    <h2>📋 Panel de Recepción</h2>
    <nav>
        <?php if ($_SESSION["role"] === 'admin'): ?>
            <a href="admin_dashboard.php">Volver a Admin</a> |
        <?php endif; ?>
        <a href="logout.php">🚪 Cerrar Sesión</a>
    </nav>
    <hr>
    <?php if (!empty($message)): ?><div class="alert-success"><?php echo $message; ?></div><?php endif; ?>
    
    <h3>Próximas Citas Activas (<?php echo count($all_appointments); ?>)</h3>
    <?php if (empty($all_appointments)): ?>
        <p>No hay citas pendientes ni confirmadas.</p>
    <?php else: ?>
        <table style="width:100%;">
            <thead><tr><th>Fecha/Hora</th><th>Mascota</th><th>Cliente</th><th>Teléfono</th><th>Motivo</th><th>Estado</th><th>Acciones</th></tr></thead>
            <tbody>
                <?php foreach ($all_appointments as $appt): ?>
                <tr>
                    <td><?php echo date('d/m/Y H:i', strtotime($appt['date_time'])); ?></td>
                    <td><?php echo htmlspecialchars($appt['pet_name']); ?></td>
                    <td><?php echo htmlspecialchars($appt['client_name']); ?></td>
                    <td><?php echo htmlspecialchars($appt['phone']); ?></td>
                    <td><?php echo htmlspecialchars($appt['reason']); ?></td>
                    <td><span style="color: <?php echo $appt['status'] == 'confirmed' ? 'green' : ($appt['status'] == 'pending' ? 'orange' : 'red'); ?>;"><?php echo htmlspecialchars($appt['status']); ?></span></td>
                    <td>
                        <form method="POST" action="update_status.php" style="display:inline-flex; flex-direction:column;">
                            <input type="hidden" name="appt_id" value="<?php echo $appt['id']; ?>">
                            <?php if ($appt['status'] == 'pending'): ?>
                                <button type="submit" name="action" value="confirm" class="action-btn btn-confirm">Confirmar</button>
                            <?php endif; ?>
                            <button type="submit" name="action" value="complete" class="action-btn btn-complete">Completada</button>
                            <button type="submit" name="action" value="cancel" class="action-btn btn-cancel">Cancelar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div></body></html>