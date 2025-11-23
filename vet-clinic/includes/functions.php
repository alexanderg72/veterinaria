<?php
// functions.php

// 1. Acceso general (Cualquier usuario logueado)
function require_login() {
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: login.php");
        exit;
    }
}

// 2. Acceso para el Personal de la Clínica (Admin o Sales)
function require_clinic_access() {
    require_login();
    $role = $_SESSION["role"];
    if ($role !== 'admin' && $role !== 'sales') {
        header("location: dashboard.php"); // Redirige al cliente a su panel
        exit;
    }
}

// 3. Acceso solo para Administradores
function require_admin() {
    require_login();
    if ($_SESSION["role"] !== 'admin') {
        header("location: dashboard.php"); // Redirige a cualquier no-admin
        exit;
    }
}
?>