<?php
// index.php
session_start();

// Redirección si el usuario ya está logueado
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    if ($_SESSION["role"] === 'admin') {
        header("location: pages/admin_dashboard.php");
    } else if ($_SESSION["role"] === 'sales') {
        header("location: pages/sales_dashboard.php");
    } else { 
        header("location: pages/dashboard.php"); 
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TU VET | Cuidamos a quien más amas</title>
    <link rel="stylesheet" href="css/style.css">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    
    <header class="main-header">
        <div class="header-top-bar">
            <div class="logo">TU VET</div>
            
            <nav class="user-nav">
    <a href="pages/services.php"><i class="fas fa-boxes"></i> Servicios</a>
    <a href="pages/contact.php"><i class="fas fa-map-marker-alt"></i> Sucursales</a>
    <a href="pages/team.php"><i class="fas fa-users"></i> Nuestro equipo</a>
    <a href="pages/contact.php"><i class="fas fa-phone-alt"></i> Contáctanos</a>
    
    <a href="pages/login.php" class="btn-login"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</a>
</nav>
        </div>
    </header>

    <section class="hero-section">
        <div class="hero-content">
            <h1>Cuidamos a quien más amas</h1>
            <p>TAC, imagenología y laboratorio para diagnósticos precisos. Veterinarios especialistas y la mejor alimentación para cada etapa. <strong>Diagnóstico certero y cuidado integral</strong>.</p>
            
            <a href="pages/login.php" class="btn-cita">HAZ TU CITA</a>
        </div>
        
        
    </section>
    <div class="hero-image-container">
-            <div class="hero-image"></div>
+            
        </div>

    <section class="info-section">
        <h2>Conoce a TuVET</h2>
        <div class="info-cards">
            <div class="card-info">
                <h3><i class="fas fa-stethoscope"></i> Servicio Integral</h3>
                <p>Contamos con profesionales capacitados en procesos médicos veterinarios, comprometidos en brindar la mejor atención para las mascotas.</p>
            </div>
            <div class="card-info">
                <h3><i class="fas fa-truck-moving"></i> TuVET Drive</h3>
                <p>Nuestro servicio de Drive ofrece facilidad y comodidad de traslado de las mascotas hacia nuestras sucursales, para realizar los exámenes necesarios.</p>
            </div>
        </div>
    </section>

</body>
</html>