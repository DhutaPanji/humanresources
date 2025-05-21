<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include './config.php';

// Simpan (Tambah Data Baru)
if (isset($_POST['simpan'])) {
    $nama_karyawan = $_POST['nama_karyawan'];
    $posisi = $_POST['posisi'];
    $gaji = $_POST['gaji'];
    $departemen_id = $_POST['departemen_id'];
    $tanggal_mulai = $_POST['tanggal_masuk'];
    $status = $_POST['status'];

    $queryKaryawan = "INSERT INTO karyawan (nama_karyawan, posisi, gaji) VALUES ('$nama_karyawan', '$posisi', $gaji)";
    if (mysqli_query($conn, $queryKaryawan)) {
        $karyawan_id = mysqli_insert_id($conn);
        $queryPekerjaan = "INSERT INTO pekerjaan (karyawan_id, departemen_id, tanggal_mulai, status)
                           VALUES ($karyawan_id, $departemen_id, '$tanggal_mulai', '$status')";
        mysqli_query($conn, $queryPekerjaan);
    }

    header("Location: karyawan.php");
    exit();
}

// Hapus Data
if (isset($_POST['delete'])) {
    $id = $_POST['karyawan_id'];

    $queryDeletePekerjaan = "DELETE FROM pekerjaan WHERE karyawan_id = $id";
    mysqli_query($conn, $queryDeletePekerjaan);

    $queryDeleteKaryawan = "DELETE FROM karyawan WHERE karyawan_id = $id";
    mysqli_query($conn, $queryDeleteKaryawan);

    header("Location: karyawan.php");
    exit();
}

// Update Data (Edit)
if (isset($_POST['update'])) {
    $id = $_POST['karyawan_id'];
    $nama_karyawan = $_POST['nama_karyawan'];
    $posisi = $_POST['posisi'];
    $gaji = $_POST['gaji'];
    $departemen_id = $_POST['departemen_id'];
    $tanggal_mulai = $_POST['tanggal_masuk'];
    $status = $_POST['status'];

    // Update tabel karyawan
    $queryUpdateKaryawan = "UPDATE karyawan 
                            SET nama_karyawan = '$nama_karyawan', posisi = '$posisi', gaji = $gaji 
                            WHERE karyawan_id = $id";
    mysqli_query($conn, $queryUpdateKaryawan);

    // Update tabel pekerjaan
    $queryUpdatePekerjaan = "UPDATE pekerjaan 
                             SET departemen_id = $departemen_id, tanggal_mulai = '$tanggal_mulai', status = '$status'
                             WHERE karyawan_id = $id";
    mysqli_query($conn, $queryUpdatePekerjaan);

    header("Location: karyawan.php");
    exit();
}