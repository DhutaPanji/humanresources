<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include './config.php';

// Tambah Data Absensi
if (isset($_POST['simpan'])) {
    $karyawan_id = $_POST['karyawan_id'];
    $departemen_id = $_POST['departemen_id'];
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];

    $queryInsert = "INSERT INTO absensi (karyawan_id, departemen_id, tanggal, keterangan)
                    VALUES ('$karyawan_id', '$departemen_id', '$tanggal', '$keterangan')";

    $exec = mysqli_query($conn, $queryInsert);

    if ($exec) {
        header("Location: absensi.php?success=1");
        exit();
    } else {
        echo "Gagal menyimpan data absensi: " . mysqli_error($conn);
        exit();
    }
}

// Hapus Data Absensi
if (isset($_POST['delete'])) {
    $absensi_id = $_POST['absensi_id'];

    $queryDelete = "DELETE FROM absensi WHERE absensi_id = $absensi_id";
    $exec = mysqli_query($conn, $queryDelete);

    if ($exec) {
        header("Location: absensi.php?deleted=1");
        exit();
    } else {
        echo "Gagal menghapus data absensi: " . mysqli_error($conn);
        exit();
    }
}

// Update Data Absensi
if (isset($_POST['update'])) {
    $absensi_id = $_POST['absensi_id'];
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];

    $queryUpdate = "UPDATE absensi
                    SET tanggal = '$tanggal',
                        keterangan = '$keterangan'
                    WHERE absensi_id = $absensi_id";

    $exec = mysqli_query($conn, $queryUpdate);

    if ($exec) {
        header("Location: absensi.php?updated=1");
        exit();
    } else {
        echo "Gagal update data absensi: " . mysqli_error($conn);
        exit();
    }
}
?>