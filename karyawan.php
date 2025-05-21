<?php
include '.includes/header.php';
include '.includes/toast_notification.php';
include './config.php';

// Ambil data karyawan beserta relasi departemen
$query = "
    SELECT k.karyawan_id, k.nama_karyawan, d.departemen_id, d.nama_departemen, k.posisi, k.gaji, p.status, p.tanggal_mulai
    FROM karyawan k
    JOIN pekerjaan p ON k.karyawan_id = p.karyawan_id
    JOIN departemen d ON p.departemen_id = d.departemen_id
";
$exec = mysqli_query($conn, $query);
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Data Karyawan</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKaryawan">
                Tambah Data Karyawan
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table id="datatable" class="table table-hover">
                    <thead>
                        <tr class="text-center">
                            <th>NO</th>
                            <th>Nama Karyawan</th>
                            <th>Departemen</th>
                            <th>Posisi</th>
                            <th>Gaji</th>
                            <th>Status</th>
                            <th>Pilihan</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php $index = 1; while ($row = mysqli_fetch_assoc($exec)) : ?>
                            <tr>
                                <td><?= $index++; ?></td>
                                <td><?= htmlspecialchars($row['nama_karyawan']); ?></td>
                                <td><?= htmlspecialchars($row['nama_departemen']); ?></td>
                                <td><?= htmlspecialchars($row['posisi']); ?></td>
                                <td><?= number_format($row['gaji'], 0, ',', '.'); ?></td>
                                <td><?= htmlspecialchars($row['status']); ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn p-0 dropdown-toggle hide-arrow" type="button" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <!-- Tombol Edit buka modal berdasarkan ID -->
                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editKaryawan<?= $row['karyawan_id']; ?>">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>
                                            <!-- Form Delete -->
                                            <form action="proses_karyawan.php" method="POST" onsubmit="return confirm('Yakin ingin menghapus karyawan ini?')">
                                                <input type="hidden" name="karyawan_id" value="<?= $row['karyawan_id']; ?>">
                                                <button type="submit" name="delete" class="dropdown-item">
                                                    <i class="bx bx-trash me-1"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>

 <!-- Modal Edit Karyawan -->
<div class="modal fade" id="editKaryawan<?= $row['karyawan_id']; ?>" tabindex="-1" aria-labelledby="editKaryawanLabel<?= $row['karyawan_id']; ?>" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="proses_karyawan.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="editKaryawanLabel<?= $row['karyawan_id']; ?>">Edit Data Karyawan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="karyawan_id" value="<?= $row['karyawan_id']; ?>">

          <div class="mb-3">
            <label for="nama_karyawan<?= $row['karyawan_id']; ?>" class="form-label">Nama Karyawan</label>
            <input type="text" class="form-control" id="nama_karyawan<?= $row['karyawan_id']; ?>" name="nama_karyawan" value="<?= htmlspecialchars($row['nama_karyawan']); ?>" required>
          </div>

          <div class="mb-3">
            <label for="departemen<?= $row['karyawan_id']; ?>" class="form-label">Departemen</label>
            <select class="form-select" id="departemen<?= $row['karyawan_id']; ?>" name="departemen_id" required>
              <option value="">-- Pilih Departemen --</option>
              <?php
              $departemen = mysqli_query($conn, "SELECT * FROM departemen");
              while ($d = mysqli_fetch_assoc($departemen)) {
                $selected = ($d['departemen_id'] == $row['departemen_id']) ? 'selected' : '';
                echo "<option value='{$d['departemen_id']}' $selected>" . htmlspecialchars($d['nama_departemen']) . "</option>";
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="posisi<?= $row['karyawan_id']; ?>" class="form-label">Posisi</label>
            <input type="text" class="form-control" id="posisi<?= $row['karyawan_id']; ?>" name="posisi" value="<?= htmlspecialchars($row['posisi']); ?>" required>
          </div>

          <div class="mb-3">
            <label for="gaji<?= $row['karyawan_id']; ?>" class="form-label">Gaji</label>
            <input type="number" class="form-control" id="gaji<?= $row['karyawan_id']; ?>" name="gaji" value="<?= $row['gaji']; ?>" required>
          </div>

          <div class="mb-3">
            <label for="tanggal_masuk<?= $row['karyawan_id']; ?>" class="form-label">Tanggal Masuk</label>
            <input type="date" class="form-control" id="tanggal_masuk<?= $row['karyawan_id']; ?>" name="tanggal_masuk" value="<?= $row['tanggal_mulai']; ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Status</label>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="status" id="aktif<?= $row['karyawan_id']; ?>" value="Aktif" <?= ($row['status'] === 'Aktif') ? 'checked' : ''; ?>>
              <label class="form-check-label" for="aktif<?= $row['karyawan_id']; ?>">Aktif</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="status" id="tidakAktif<?= $row['karyawan_id']; ?>" value="Tidak Aktif" <?= ($row['status'] === 'Tidak Aktif') ? 'checked' : ''; ?>>
              <label class="form-check-label" for="tidakAktif<?= $row['karyawan_id']; ?>">Tidak Aktif</label>
            </div>
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

<!-- Modal Tambah Karyawan -->
<div class="modal fade" id="addKaryawan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="proses_karyawan.php" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Karyawan</label>
                    <input type="text" class="form-control" name="nama_karyawan" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Departemen</label>
                    <select class="form-control" name="departemen_id" required>
                        <option value="">-- Pilih Departemen --</option>
                        <?php
                        $departemen = mysqli_query($conn, "SELECT * FROM departemen");
                        while ($d = mysqli_fetch_assoc($departemen)) {
                            echo "<option value='" . $d['departemen_id'] . "'>" . htmlspecialchars($d['nama_departemen']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Posisi</label>
                    <input type="text" class="form-control" name="posisi" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Gaji</label>
                    <input type="number" class="form-control" name="gaji" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Masuk</label>
                    <input type="date" class="form-control" name="tanggal_masuk" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" value="Aktif" checked>
                        <label class="form-check-label">Aktif</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" value="Tidak Aktif">
                        <label class="form-check-label">Tidak Aktif</label>
                    </div>
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