<?php
include 'config.php';

// Fungsi helper untuk redirect dan exit
function redirect($url) {
    header("Location: $url");
    exit();
}

// Tambah Departemen
if (isset($_POST['simpan'])) {
    if (!empty($_POST['nama_departemen'])) {
        $nama = mysqli_real_escape_string($conn, $_POST['nama_departemen']);
        $query = "INSERT INTO departemen (nama_departemen) VALUES ('$nama')";
        if (!mysqli_query($conn, $query)) {
            die("Gagal menyimpan: " . mysqli_error($conn));
        }
    }
    redirect("departemen.php");
}

// Update Departemen
if (isset($_POST['update'])) {
    if (isset($_POST['departemen_id']) && !empty($_POST['nama_departemen'])) {
        $id = (int) $_POST['departemen_id'];
        $nama = mysqli_real_escape_string($conn, $_POST['nama_departemen']);
        $query = "UPDATE departemen SET nama_departemen = '$nama' WHERE departemen_id = $id";
        if (!mysqli_query($conn, $query)) {
            die("Gagal mengupdate: " . mysqli_error($conn));
        }
    }
    redirect("departemen.php");
}

// Hapus Departemen
if (isset($_POST['delete'])) {
    if (isset($_POST['departemen_id'])) {
        $id = (int) $_POST['departemen_id'];
        $query = "DELETE FROM departemen WHERE departemen_id = $id";
        if (!mysqli_query($conn, $query)) {
            die("Gagal menghapus: " . mysqli_error($conn));
        }
    }
    redirect("departemen.php");
}
?>