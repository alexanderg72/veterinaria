<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_login();

$user_id = $_SESSION["id"];
$message = "";

$sql_pets = "SELECT id, name FROM pets WHERE user_id = :user_id";
$stmt_pets = $pdo->prepare($sql_pets);
$stmt_pets->bindParam(":user_id", $user_id, PDO::PARAM_INT);
$stmt_pets->execute();
$pets = $stmt_pets->fetchAll(PDO::FETCH_ASSOC);

if (empty($pets)) {
    $message = "<div class='error'>No puedes agendar citas sin registrar una mascota. ¡Regístrala primero!</div>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($pets)) {
    $pet_id = trim($_POST["pet_id"]);
    $date_time = trim($_POST["date_time"]);
    $reason = trim($_POST["reason"]);
    
    if (!empty($pet_id) && !empty($date_time) && strtotime($date_time) > time()) {
        $sql = "INSERT INTO appointments (client_id, pet_id, date_time, reason, status) 
                VALUES (:client_id, :pet_id, :date_time, :reason, 'pending')";
        
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":client_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":pet_id", $pet_id, PDO::PARAM_INT);
            $stmt->bindParam(":date_time", $date_time, PDO::PARAM_STR);
            $stmt->bindParam(":reason", $reason, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                $message = "<div class='alert-success'>Cita agendada con éxito! La clínica la confirmará pronto.</div>";
            } else {
                $message = "<div class='error'>Error al agendar la cita.</div>";
            }
            unset($stmt);
        }
    } else {
        $message = "<div class='error'>Verifique la información. La fecha y hora deben ser futuras.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head><title>Agendar Cita</title><link rel="stylesheet" href="../css/style.css"></head>
<body><div class="container">
    <h2>📅 Agendar Nueva Cita</h2>
    <nav><a href="dashboard.php">← Volver al Dashboard</a></nav>
    <?php echo $message; ?>
    <?php if (!empty($pets)): ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label for="pet_id">Mascota:</label>
            <select name="pet_id" required>
                <?php foreach ($pets as $pet): ?>
                    <option value="<?php echo $pet['id']; ?>"><?php echo htmlspecialchars($pet['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="date_time">Fecha y Hora (Mínimo: Ahora):</label>
            <input type="datetime-local" name="date_time" required>
        </div>
        <div>
            <label for="reason">Motivo de la Cita:</label>
            <textarea name="reason" rows="3" required></textarea>
        </div>
        <button type="submit">Agendar Cita</button>
    </form>
    <?php endif; ?>
</div></body></html>