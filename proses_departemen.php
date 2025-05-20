<?php
include 'config.php';

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_departemen'];
    $query = "INSERT INTO departemen (nama_departemen) VALUES ('$nama')";
    mysqli_query($conn, $query);
    header("Location: departemen.php");
    exit();
}

if (isset($_POST['update'])) {
    $id = $_POST['departemen_id'];
    $nama = $_POST['nama_departemen'];
    $query = "UPDATE departemen SET nama_departemen = '$nama' WHERE departemen_id = $id";
    mysqli_query($conn, $query);
    header("Location: departemen.php");
    exit();
}

if (isset($_POST['delete'])) {
    $id = $_POST['departemen_id'];
    $query = "DELETE FROM departemen WHERE departemen_id = $id";
    mysqli_query($conn, $query);
    header("Location: departemen.php");
    exit();
}