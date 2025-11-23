<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_login(); 

$user_id = $_SESSION["id"];

$sql_pets = "SELECT id, name, species FROM pets WHERE user_id = :user_id";
$stmt_pets = $pdo->prepare($sql_pets);
$stmt_pets->bindParam(":user_id", $user_id, PDO::PARAM_INT);
$stmt_pets->execute();
$pets = $stmt_pets->fetchAll(PDO::FETCH_ASSOC);

$sql_appts = "SELECT a.date_time, a.reason, a.status, p.name AS pet_name 
              FROM appointments a JOIN pets p ON a.pet_id = p.id 
              WHERE a.client_id = :user_id ORDER BY a.date_time DESC";
$stmt_appts = $pdo->prepare($sql_appts);
$stmt_appts->bindParam(":user_id", $user_id, PDO::PARAM_INT);
$stmt_appts->execute();
$appointments = $stmt_appts->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head><title>Dashboard Cliente</title><link rel="stylesheet" href="../css/style.css"></head>
<body><div class="container" style="max-width: 800px;">
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION["name"]); ?> (Cliente)</h2>
    <nav>
        <a href="schedule.php">📅 Agendar Cita</a> |
        <a href="add_pet.php">🐾 Gestionar Mascotas</a> |
        <a href="logout.php">🚪 Cerrar Sesión</a>
    </nav>
    <hr>

    <h3>Tus Mascotas (<?php echo count($pets); ?>)</h3>
    <?php if (empty($pets)): ?><p>Aún no has registrado ninguna mascota.</p><?php else: ?>
        <ul><?php foreach ($pets as $pet): ?>
                <li>**<?php echo htmlspecialchars($pet['name']); ?>** (<?php echo htmlspecialchars($pet['species']); ?>)</li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <hr>
    <h3>Tus Citas Recientes (<?php echo count($appointments); ?>)</h3>
    <?php if (empty($appointments)): ?><p>No tienes citas agendadas.</p><?php else: ?>
        <table style="width:100%;">
            <thead><tr><th>Mascota</th><th>Fecha y Hora</th><th>Motivo</th><th>Estado</th></tr></thead>
            <tbody>
                <?php foreach ($appointments as $appt): ?>
                <tr>
                    <td><?php echo htmlspecialchars($appt['pet_name']); ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($appt['date_time'])); ?></td>
                    <td><?php echo htmlspecialchars($appt['reason']); ?></td>
                    <td><span style="color: 
                        <?php if ($appt['status'] == 'confirmed') echo 'green'; else if ($appt['status'] == 'pending') echo 'orange'; else echo 'red'; ?>;">
                        <?php echo htmlspecialchars($appt['status']); ?></span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div></body></html>