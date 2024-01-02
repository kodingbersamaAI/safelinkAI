<?php

// Periksa peran pengguna dari sesi
$userRole = isset($_SESSION['roleUser']) ? $_SESSION['roleUser'] : '';

// Tentukan peran yang diizinkan untuk mengakses folder ini
$allowedRoles = ['premium']; // Ganti dengan peran yang sesuai

if (!in_array($userRole, $allowedRoles)) {
    // Pengguna tidak memiliki peran yang sesuai, arahkan ke halaman yang sesuai
    header("Location: ../index/index.php?error=access"); // Ganti dengan halaman yang sesuai untuk akses yang tidak sah
    exit();
}

?>