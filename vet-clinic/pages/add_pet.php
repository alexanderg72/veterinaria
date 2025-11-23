<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_login();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $species = trim($_POST["species"]);
    $breed = trim($_POST["breed"]);
    $birthdate = trim($_POST["birthdate"]);
    $user_id = $_SESSION["id"];

    if (!empty($name) && !empty($species)) {
        $sql = "INSERT INTO pets (user_id, name, species, breed, birthdate) VALUES (:user_id, :name, :species, :breed, :birthdate)";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":species", $species, PDO::PARAM_STR);
            $stmt->bindParam(":breed", $breed, PDO::PARAM_STR);
            $stmt->bindParam(":birthdate", $birthdate); 
            
            if ($stmt->execute()) {
                $message = "<div class='alert-success'>Mascota registrada con éxito!</div>";
            } else {
                $message = "<div class='error'>Error al registrar la mascota.</div>";
            }
            unset($stmt);
        }
    } else {
        $message = "<div class='error'>El nombre y la especie son obligatorios.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head><title>Añadir Mascota</title><link rel="stylesheet" href="../css/style.css"></head>
<body><div class="container">
    <h2>🐾 Registrar Mascota</h2>
    <nav><a href="dashboard.php">← Volver al Dashboard</a></nav>
    <?php echo $message; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div><input type="text" name="name" placeholder="Nombre de la Mascota" required></div>
        <div><select name="species" required>
            <option value="">Seleccione Especie</option>
            <option value="Perro">Perro</option>
            <option value="Gato">Gato</option>
            <option value="Otro">Otro</option>
        </select></div>
        <div><input type="text" name="breed" placeholder="Raza (opcional)"></div>
        <div><label for="birthdate">Fecha de Nacimiento (opcional):</label><input type="date" name="birthdate" id="birthdate"></div>
        <button type="submit">Guardar Mascota</button>
    </form>
</div></body></html>