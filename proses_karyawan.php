<?php
include '.config.php';

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_departemen'];
    $query = "INSERT INTO departemen (nama_departemen) VALUES ('$nama')";
    mysqli_query($conn, $query);
    header("Location: departemen.php");
    exit();
}

if (isset($_POST['update'])) {
    $id = $_POST['id_departemen'];
    $nama = $_POST['nama_departemen'];
    $query = "UPDATE departemen SET nama_departemen = '$nama' WHERE id_departemen = $id";
    mysqli_query($conn, $query);
    header("Location: departemen.php");
    exit();
}

if (isset($_POST['delete'])) {
    $id = $_POST['id_departemen'];
    $query = "DELETE FROM departemen WHERE id_departemen = $id";
    mysqli_query($conn, $query);
    header("Location: karyawan.php");
    exit();
}