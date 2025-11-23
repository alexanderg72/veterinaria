
<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_clinic_access(); // Solo el personal de la clínica puede usar esta página

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $appt_id = $_POST['appt_id'];
    $action = $_POST['action'];

    $new_status = '';
    $message = '';

    switch ($action) {
        case 'confirm':
            $new_status = 'confirmed';
            $message = 'Cita confirmada con éxito.';
            break;
        case 'complete':
            $new_status = 'completed';
            $message = 'Cita marcada como completada.';
            break;
        case 'cancel':
            $new_status = 'canceled';
            $message = 'Cita cancelada con éxito.';
            break;
        default:
            $_SESSION['status_message'] = 'Acción inválida.';
            header("location: sales_dashboard.php");
            exit;
    }

    $sql = "UPDATE appointments SET status = :new_status WHERE id = :appt_id";
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":new_status", $new_status, PDO::PARAM_STR);
        $stmt->bindParam(":appt_id", $appt_id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $_SESSION['status_message'] = $message;
        } else {
            $_SESSION['status_message'] = 'Error al actualizar la base de datos.';
        }
    }
    unset($stmt);
}

// Redirigir siempre al dashboard de ventas/recepción
header("location: sales_dashboard.php");
exit;
?>