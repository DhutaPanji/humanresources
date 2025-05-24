<?php
include '.includes/header.php';
include '.includes/toast_notification.php';
include './config.php';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Data Absensi</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAbsensi">Tambah Data Absensi</button>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table id="datatable" class="table table-hover">
                    <thead>
                        <tr class="text-center">
                            <th width="50px">NO</th>
                            <th>Nama Karyawan</th>
                            <th>Nama Departemen</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Pilihan</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    <?php
                    $index = 1;
                    $query = "SELECT absensi.*, karyawan.nama_karyawan, departemen.nama_departemen
                              FROM absensi
                              LEFT JOIN karyawan ON absensi.karyawan_id = karyawan.karyawan_id
                              LEFT JOIN departemen ON absensi.departemen_id = departemen.departemen_id
                              ORDER BY absensi.absensi_id DESC";
                    $exec = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($exec)) :
                    ?>
                        <tr>
                            <td class="text-center"><?= $index++; ?></td>
                            <td><?= $row['nama_karyawan']; ?></td>
                            <td><?= $row['nama_departemen']; ?></td>
                            <td><?= $row['tanggal']; ?></td>
                            <td><?= $row['keterangan']; ?></td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editAbsensi<?= $row['absensi_id']; ?>">
                                            <i class="bx bx-edit-alt me-2"></i> Edit
                                        </a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#deleteAbsensi<?= $row['absensi_id']; ?>">
                                            <i class="bx bx-trash me-2"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Edit Absensi -->
                        <div class="modal fade" id="editAbsensi<?= $row['absensi_id']; ?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog">
                            <form method="POST" action="proses_absensi.php">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">Edit Data Absensi</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                  <input type="hidden" name="absensi_id" value="<?= $row['absensi_id']; ?>">
                                  
                                  <div class="mb-3">
                                    <label class="form-label">Nama Karyawan</label>
                                    <input type="text" class="form-control" value="<?= $row['nama_karyawan']; ?>" readonly>
                                  </div>

                                  <div class="mb-3">
                                    <label class="form-label">Nama Departemen</label>
                                    <input type="text" class="form-control" value="<?= $row['nama_departemen']; ?>" readonly>
                                  </div>

                                  <div class="mb-3">
                                    <label class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal" value="<?= $row['tanggal']; ?>" required>
                                  </div>

                                  <div class="mb-3">
                                    <label class="form-label">Keterangan</label><br>
                                    <?php
                                    $keterangan = ['Hadir', 'Sakit', 'Izin'];
                                    foreach ($keterangan as $ket) {
                                        $checked = $row['keterangan'] === $ket ? 'checked' : '';
                                        echo '<div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="keterangan" value="' . $ket . '" ' . $checked . '>
                                                <label class="form-check-label">' . $ket . '</label>
                                              </div>';
                                    }
                                    ?>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="submit" name="update" class="btn btn-warning">Update</button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>

                        <!-- Modal Delete Absensi -->
                        <div class="modal fade" id="deleteAbsensi<?= $row['absensi_id']; ?>" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog">
                            <form method="POST" action="proses_absensi.php">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">Hapus Data Absensi</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                  <input type="hidden" name="absensi_id" value="<?= $row['absensi_id']; ?>">
                                  <p>Yakin ingin menghapus data absensi <strong><?= $row['nama_karyawan']; ?></strong> pada tanggal <?= $row['tanggal']; ?>?</p>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                  <button type="submit" name="delete" class="btn btn-danger">Hapus</button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>

                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Data Absensi -->
<div class="modal fade" id="addAbsensi" tabindex="-1" aria-labelledby="addAbsensiLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="proses_absensi.php">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data Absensi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nama Karyawan</label>
            <select class="form-select" name="karyawan_id" required>
              <option value="">-- Pilih Karyawan --</option>
              <?php
              $karyawanQuery = mysqli_query($conn, "SELECT * FROM karyawan");
              while ($karyawan = mysqli_fetch_assoc($karyawanQuery)) {
                  echo '<option value="' . $karyawan['karyawan_id'] . '">' . $karyawan['nama_karyawan'] . '</option>';
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Nama Departemen</label>
            <select class="form-select" name="departemen_id" required>
              <option value="">-- Pilih Departemen --</option>
              <?php
              $departemenQuery = mysqli_query($conn, "SELECT * FROM departemen");
              while ($departemen = mysqli_fetch_assoc($departemenQuery)) {
                  echo '<option value="' . $departemen['departemen_id'] . '">' . $departemen['nama_departemen'] . '</option>';
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" class="form-control" name="tanggal" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Keterangan</label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="keterangan" value="Hadir" required>
              <label class="form-check-label">Hadir</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="keterangan" value="Sakit">
              <label class="form-check-label">Sakit</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="keterangan" value="Izin">
              <label class="form-check-label">Izin</label>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <input type="hidden" name="simpan" value="1">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<?php include '.includes/footer.php'; ?>