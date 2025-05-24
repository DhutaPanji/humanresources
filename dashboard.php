<?php
session_start();

// Validasi apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
$userId = $_SESSION['user_id'];

include(".includes/header.php");
$title = "Dashboard";
include '.includes/toast_notification.php';
include './config.php'; // Koneksi database

// Query jumlah karyawan
$jumlahKaryawanQuery = mysqli_query($conn, "SELECT COUNT(*) as total_karyawan FROM karyawan");
$jumlahKaryawan = mysqli_fetch_assoc($jumlahKaryawanQuery)['total_karyawan'] ?? 0;

// Query jumlah departemen
$jumlahDepartemenQuery = mysqli_query($conn, "SELECT COUNT(*) as total_departemen FROM departemen");
$jumlahDepartemen = mysqli_fetch_assoc($jumlahDepartemenQuery)['total_departemen'] ?? 0;

// Query jumlah absensi 'Hadir' hari ini
$tanggalHariIni = date('Y-m-d');

// Gunakan DATE() untuk memastikan cocok walau field mengandung waktu
$jumlahAbsensiQuery = mysqli_query($conn, " SELECT COUNT(*) as total_absen FROM absensi WHERE DATE(tanggal) = CURDATE() AND LOWER(TRIM(keterangan))='hadir'");

// Cek jika query gagal
if (!$jumlahAbsensiQuery) {
    die("Query Error: " . mysqli_error($conn));
}

// Ambil hasil
$jumlahAbsensi = mysqli_fetch_assoc($jumlahAbsensiQuery)['total_absen'] ?? 0;
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">

        <!-- Kotak Jumlah Karyawan -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">Jumlah Karyawan</h5>
                    <h2 class="text-primary"><?= $jumlahKaryawan; ?></h2>
                </div>
            </div>
        </div>

        <!-- Kotak Jumlah Departemen -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">Jumlah Departemen</h5>
                    <h2 class="text-success"><?= $jumlahDepartemen; ?></h2>
                </div>
            </div>
        </div>

        <!-- Kotak Jumlah Absensi Hari Ini (Hanya yang Hadir) -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">Absensi Hari Ini</h5>
                    <h2 class="text-warning"><?= $jumlahAbsensi; ?></h2>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include(".includes/footer.php"); ?>