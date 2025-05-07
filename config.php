<?php
// konfigurasi koneksi database
$host = "localhost"; // nama host server database
$username = "root"; // username untuk akses ke database
$password = ""; // password untuk akses ke database
$database = "humanresources"; // nama database yang digunakan

// membuat koneksi ke database menggunakan database mysqli
$conn = mysqli_connect($host, $username, $password, $database);

// mengecek apakah koneksi berhasil
if (!$conn) {
    // menampilkan pesan error jika koneksi gagal
    die("Database gagal terkoneksi: " . mysqli_connect_error());
}

// jika koneksi berhasil script akan jalan tanpa pesan error
?>