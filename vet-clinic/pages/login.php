<?php
require_once '../includes/db.php';
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    if ($_SESSION["role"] === 'admin') header("location: admin_dashboard.php");
    else if ($_SESSION["role"] === 'sales') header("location: sales_dashboard.php");
    else header("location: dashboard.php");
    exit;
}

$email = $password = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    
    $sql = "SELECT id, name, password_hash, role FROM users WHERE email = :email"; // <-- SELECCIONA EL ROL
    
    if ($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
        $param_email = $email;
        
        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                if ($row = $stmt->fetch()) {
                    $hashed_password = $row["password_hash"];
                    
                    if (password_verify($password, $hashed_password)) {
                        // Inicia sesión
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $row["id"];
                        $_SESSION["name"] = $row["name"];
                        $_SESSION["role"] = $row["role"]; // <-- GUARDA EL ROL
                        
                        // Redirección por rol
                        if ($_SESSION["role"] === 'admin') {
                            header("location: admin_dashboard.php");
                        } else if ($_SESSION["role"] === 'sales') {
                            header("location: sales_dashboard.php");
                        } else {
                            header("location: dashboard.php");
                        }
                        exit;
                    } else { $login_err = "Email o contraseña inválidos."; }
                }
            } else { $login_err = "Email o contraseña inválidos."; }
        }
    }
    unset($stmt);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Iniciar Sesión | Clínica Veterinaria</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="auth-container">
        <h2><i class="fas fa-paw"></i> Iniciar Sesión</h2>
        
        <?php if (!empty($login_err)): ?>
            <div class="error"><?php echo $login_err; ?></div>
        <?php endif; ?>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <input type="email" name="email" placeholder="Correo Electrónico" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn-primary">Entrar al Sistema</button>
        </form>
        
        <p class="link-register">
            ¿No tienes cuenta? 
            <a href="register.php">Regístrate aquí</a>
        </p>
    </div>
</body>
</html>