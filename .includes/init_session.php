<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userId = $_SESSION["user_id"] ?? null;
$name = $_SESSION["name"] ?? null;
$role = $_SESSION["role"] ?? null;

// Ambil notifikasi jika ada, lalu hapus dari session
$notification = $_SESSION['notification'] ?? null;
if ($notification) {
    unset($_SESSION['notification']);
}

if (empty($_SESSION["username"]) || empty($_SESSION["role"])) {
    $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'Silahkan Login Terlebih Dahulu!'
    ];
    header('Location: ./auth/login.php');
    exit();
}
