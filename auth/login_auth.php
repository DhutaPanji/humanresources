<?php
session_start();
require_once("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row["password"])) {
            // ✅ Login berhasil
            $_SESSION["username"] = $username;
            $_SESSION["name"] = $row["name"];
            $_SESSION["role"] = $row["role"];
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION['notification'] = [
                'type' => 'primary',
                'message' => 'Selamat Datang Kembali!'
            ];
            header('Location: ../dashboard.php');
            exit();
        } else {
            // ❌ Password salah
            $_SESSION['notification'] = [
                'type' => 'danger',
                'message' => 'Password salah'
            ];
        }
    } else {
        // ❌ Username tidak ditemukan
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Username tidak ditemukan'
        ];
    }

    // Redirect kembali ke halaman login
    header('Location: login.php');
    exit();
} else {
    // ❌ Bukan POST request
    $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'Akses tidak valid'
    ];
    header('Location: login.php');
    exit();
}

$conn->close();