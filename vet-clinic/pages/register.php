<?php
// pages/register.php
require_once '../includes/db.php';

$name = $email = $password = $phone = "";
$name_err = $email_err = $password_err = $phone_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Validación de campos
    if (empty(trim($_POST["name"]))) $name_err = "Por favor ingrese su nombre.";
    if (empty(trim($_POST["email"]))) $email_err = "Por favor ingrese su email.";
    if (empty(trim($_POST["password"])) || strlen(trim($_POST["password"])) < 6) $password_err = "La contraseña debe tener al menos 6 caracteres.";
    if (empty(trim($_POST["phone"]))) $phone_err = "Por favor ingrese su número de teléfono.";
    $phone = trim($_POST["phone"]);

    // 2. Verificar si el email ya existe
    if (empty($email_err)) {
        $sql = "SELECT id FROM users WHERE email = :email";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $param_email = trim($_POST["email"]);
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) { $email_err = "Este email ya está registrado."; }
            }
            unset($stmt);
        }
    }

    // 3. Insertar usuario si no hay errores
    if (empty($name_err) && empty($email_err) && empty($password_err) && empty($phone_err)) {
        // La consulta incluye 'phone'
        $sql = "INSERT INTO users (name, email, password_hash, phone, role) VALUES (:name, :email, :password_hash, :phone, 'client')";
        
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":password_hash", $param_password_hash, PDO::PARAM_STR);
            $stmt->bindParam(":phone", $param_phone, PDO::PARAM_STR); // Bindeo del teléfono

            $param_name = trim($_POST["name"]);
            $param_email = trim($_POST["email"]);
            $param_password_hash = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT); 
            $param_phone = $phone;
            
            if ($stmt->execute()) {
                header("location: login.php");
                exit();
            } else {
                echo "<div class='error'>Error al registrar.</div>";
            }
            unset($stmt);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Registro de Cliente</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="auth-container">
        <h2><i class="fas fa-user-plus"></i> Crear Cuenta</h2>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            
            <div class="form-group">
                <input type="text" name="name" placeholder="Nombre Completo" value="<?php echo htmlspecialchars($name); ?>" required>
                <span class="error"><?php echo $name_err; ?></span>
            </div>
            
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" required>
                <span class="error"><?php echo $email_err; ?></span>
            </div>
            
            <div class="form-group">
                <input type="text" name="phone" placeholder="Número de Teléfono" value="<?php echo htmlspecialchars($phone); ?>" required>
                <span class="error"><?php echo $phone_err; ?></span>
            </div>
            
            <div class="form-group">
                <input type="password" name="password" placeholder="Contraseña (mínimo 6 caracteres)" required>
                <span class="error"><?php echo $password_err; ?></span>
            </div>
            
            <button type="submit" class="btn-primary">Registrar</button>
        </form>
        
        <p class="link-register">
            ¿Ya tienes cuenta? 
            <a href="login.php">Inicia Sesión</a>
        </p>
    </div>
</body>
</html>