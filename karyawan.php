<?php
include '.includes/header.php';
include '.includes/toast_notification.php';
include './config.php';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Data Karyawan</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDepartemen">
                Tambah Data Karyawan
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table id="datatable" class="table table-hover">
                    <thead>
                        <tr class="text-center">
                            <th width="50px">NO</th>
                            <th>Nama Karyawan</th>
                            <th width="150px">Pilihan</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                    <?php
                    $index = 1;
                    $query = "SELECT * FROM departemen";
                    $exec = mysqli_query($conn, $query);
                    while ($departemen = mysqli_fetch_assoc($exec)) :
                    ?>
                        <tr>
                            <td><?= $index++; ?></td>
                            <td><?= $departemen['nama_departemen']; ?></td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#editDepartemen_<?= $departemen['id_departemen']; ?>">
                                            <i class="bx bx-edit-alt me-2"></i> Edit
                                        </a>
                                        <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#deleteDepartemen_<?= $departemen['id_departemen']; ?>">
                                            <i class="bx bx-trash me-2"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Delete -->
                        <div class="modal fade" id="deleteDepartemen_<?= $departemen['id_departemen']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Hapus Karyawan?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="proses_departemen.php" method="POST">
                                            <p>Tindakan ini tidak bisa dibatalkan.</p>
                                            <input type="hidden" name="id_departemen" value="<?= $departemen['id_departemen']; ?>">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" name="delete" class="btn btn-danger">Hapus</button>
                                    </div>
                                        </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editDepartemen_<?= $departemen['id_departemen']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Karyawan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="proses_departemen.php" method="POST">
                                            <input type="hidden" name="id_departemen" value="<?= $departemen['id_departemen']; ?>">
                                            <div class="mb-3">
                                                <label>Nama Karyawan</label>
                                                <input type="text" name="nama_departemen" value="<?= $departemen['nama_departemen']; ?>" class="form-control" required>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" name="update" class="btn btn-warning">Update</button>
                                    </div>
                                        </form>
                                </div>
                            </div>
                        </div>

                    <?php endwhile; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Departemen -->
<div class="modal fade" id="addDepartemen" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="proses_departemen.php" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="nama_departemen" class="form-label">Nama Karyawan</label>
                    <input type="text" class="form-control" name="nama_departemen" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<?php include '.includes/footer.php'; ?>
