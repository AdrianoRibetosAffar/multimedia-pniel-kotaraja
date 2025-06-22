<?php
include('../config/database.php');
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}

// Proses simpan jadwal baru
if (isset($_POST['simpan'])) {
    $hari = mysqli_real_escape_string($conn, $_POST['hari']);
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $jam = mysqli_real_escape_string($conn, $_POST['jam']);

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $folder = '../uploads/';
    $gambar_baru = time() . '_' . basename($gambar);

    if (move_uploaded_file($tmp, $folder . $gambar_baru)) {
        $query = mysqli_query($conn, "INSERT INTO jadwal_ibadah (hari, judul, jam, gambar) 
                                      VALUES ('$hari', '$judul', '$jam', '$gambar_baru')");
        if ($query) {
            $_SESSION['success'] = "Jadwal berhasil ditambahkan!";
            header("Location: tambah_jadwal.php");
            exit();
        } else {
            $_SESSION['error'] = "Gagal menambahkan ke database.";
        }
    } else {
        $_SESSION['error'] = "Gagal upload gambar.";
    }
}

// Proses edit jadwal
if (isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    $hari = mysqli_real_escape_string($conn, $_POST['hari']);
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $jam = mysqli_real_escape_string($conn, $_POST['jam']);

    // Cek apakah ada gambar baru yang diupload
    if (!empty($_FILES['gambar']['name'])) {
        // Ada gambar baru
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        $folder = '../uploads/';
        $gambar_baru = time() . '_' . basename($gambar);

        if (move_uploaded_file($tmp, $folder . $gambar_baru)) {
            // Hapus gambar lama
            $query_old = mysqli_query($conn, "SELECT gambar FROM jadwal_ibadah WHERE id = $id");
            $old_data = mysqli_fetch_assoc($query_old);
            if ($old_data && file_exists($folder . $old_data['gambar'])) {
                unlink($folder . $old_data['gambar']);
            }

            // Update dengan gambar baru
            $query = mysqli_query($conn, "UPDATE jadwal_ibadah SET 
                                         hari = '$hari', 
                                         judul = '$judul', 
                                         jam = '$jam', 
                                         gambar = '$gambar_baru' 
                                         WHERE id = $id");
        } else {
            $_SESSION['error'] = "Gagal upload gambar baru.";
        }
    } else {
        // Tidak ada gambar baru, update tanpa gambar
        $query = mysqli_query($conn, "UPDATE jadwal_ibadah SET 
                                     hari = '$hari', 
                                     judul = '$judul', 
                                     jam = '$jam' 
                                     WHERE id = $id");
    }

    if (isset($query) && $query) {
        $_SESSION['success'] = "Jadwal berhasil diupdate!";
        header("Location: tambah_jadwal.php");
        exit();
    } else if (!isset($_SESSION['error'])) {
        $_SESSION['error'] = "Gagal mengupdate jadwal.";
    }
}

// Handle Hapus Data
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    
    // Ambil nama file gambar sebelum dihapus
    $query_gambar = mysqli_query($conn, "SELECT gambar FROM jadwal_ibadah WHERE id = $id");
    $data_gambar = mysqli_fetch_assoc($query_gambar);
    
    // Hapus data dari database
    $query_hapus = mysqli_query($conn, "DELETE FROM jadwal_ibadah WHERE id = $id");
    
    if ($query_hapus) {
        // Hapus file gambar jika ada
        if ($data_gambar && file_exists('../uploads/' . $data_gambar['gambar'])) {
            unlink('../uploads/' . $data_gambar['gambar']);
        }
        $_SESSION['success'] = "Jadwal berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Gagal menghapus jadwal.";
    }
    
    header("Location: tambah_jadwal.php");
    exit();
}

// Ambil semua data jadwal
$data_jadwal = mysqli_query($conn, "SELECT * FROM jadwal_ibadah ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah & Lihat Jadwal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style-admin.css">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="text-white text-center py-3">
        <img src="../img/logo-judul.png" alt="Logo Admin" style="height: 30px; margin-right: 2px; vertical-align: middle;">
        Admin Multimedia
    </h4>
    <a href="dashboard.php"><i class="fas fa-fw fa-tachometer-alt me-2"></i>Dashboard</a>
    <a href="tambah_jadwal.php"><i class="far fa-fw fa-calendar-alt me-2"></i>Jadwal Ibadah</a>
    <a href="tambah_berita.php"><i class="far fa-fw fa-images me-2"></i>Gallery Berita</a>      
    <a href="statistik.php"><i class="fas fa-fw fa-chart-bar me-2"></i>Kelola Statistik</a>
    <a href="edit_live_streaming.php"><i class="fas fa-fw fa-video me-2"></i>Live Streaming</a>
    <a href="pesan.php"><i class="far fa-fw fa-envelope me-2"></i>Pesan Jemaat</a>
    <a href="logout.php"><i class="fas fa-fw fa-sign-out-alt me-2"></i>Logout</a>
</div>

<!-- Main Content -->
<div class="content">
    <div class="container-fluid">
        <h2 style="font-weight: bold">Tambah Jadwal Ibadah</h2>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form method="POST" action="" enctype="multipart/form-data" class="mb-5">
            <div class="mb-3">
                <label for="hari" class="form-label">Hari</label>
                <input type="text" name="hari" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="judul" class="form-label">Judul Ibadah</label>
                <input type="text" name="judul" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="jam" class="form-label">Jam</label>
                <input type="text" name="jam" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Upload Gambar</label>
                <input type="file" name="gambar" class="form-control" accept="image/*" required>
            </div>
            <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
        </form>

        <h3>Data Jadwal Ibadah</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Hari</th>
                        <th>Judul</th>
                        <th>Jam</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($data_jadwal)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['hari']) ?></td>
                        <td><?= htmlspecialchars($row['judul']) ?></td>
                        <td><?= htmlspecialchars($row['jam']) ?></td>
                        <td><img src="../uploads/<?= $row['gambar'] ?>" width="100" alt="Gambar"></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-warning" 
                                            onclick="editJadwal(<?= $row['id'] ?>, '<?= htmlspecialchars($row['hari']) ?>', '<?= htmlspecialchars($row['judul'] ?? '') ?>', '<?= $row['jam'] ?>')" 
                                            title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Yakin ingin menghapus item ini?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Jadwal Ibadah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="mb-3">
                        <label for="edit_hari" class="form-label">Hari</label>
                        <input type="text" name="hari" id="edit_hari" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_judul" class="form-label">Judul Ibadah</label>
                        <input type="text" name="judul" id="edit_judul" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_jam" class="form-label">Jam</label>
                        <input type="text" name="jam" id="edit_jam" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_gambar" class="form-label">Upload Gambar Baru (opsional)</label>
                        <input type="file" name="gambar" id="edit_gambar" class="form-control" accept="image/*">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar Saat Ini:</label>
                        <div>
                            <img id="current_image" src="" width="100" alt="Gambar saat ini">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="edit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function editJadwal(id, hari, judul, jam, gambar) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_hari').value = hari;
    document.getElementById('edit_judul').value = judul;
    document.getElementById('edit_jam').value = jam;
    document.getElementById('current_image').src = '../uploads/' + gambar;
    
    var editModal = new bootstrap.Modal(document.getElementById('editModal'));
    editModal.show();
}
</script>

</body>
</html>