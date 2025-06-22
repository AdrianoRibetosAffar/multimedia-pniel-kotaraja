<?php
session_start();
include('../config/database.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Handle Tambah Data
if (isset($_POST['tambah'])) {
    $nama_rayon = mysqli_real_escape_string($conn, $_POST['nama_rayon']);
    $jumlah_jemaat = intval($_POST['jumlah_jemaat']);

    mysqli_query($conn, "INSERT INTO rayon (nama_rayon, jumlah_jemaat) VALUES ('$nama_rayon', '$jumlah_jemaat')");
    header("Location: statistik.php");
    exit();
}

// Handle Edit Data
if (isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    $nama_rayon = mysqli_real_escape_string($conn, $_POST['nama_rayon']);
    $jumlah_jemaat = intval($_POST['jumlah_jemaat']);

    $update = "UPDATE rayon SET nama_rayon = '$nama_rayon', jumlah_jemaat = $jumlah_jemaat WHERE id = $id";
    if (mysqli_query($conn, $update)) {
        header("Location: statistik.php");
        exit();
    } else {
        echo "Gagal mengupdate data: " . mysqli_error($conn);
    }
}

// Handle Hapus Data
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($conn, "DELETE FROM rayon WHERE id=$id");
    header("Location: statistik.php");
    exit();
}

// Ambil Data Statistik
$statistik = mysqli_query($conn, "SELECT * FROM rayon");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kelola Statistik</title>
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

<!-- Content -->
<div class="content">
    <h2>Kelola Statistik Jemaat</h2>

    <!-- Form Tambah Data -->
    <form method="post" class="my-4">
        <div class="mb-3">
            <label>Nama Rayon</label>
            <input type="text" name="nama_rayon" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Jumlah Jemaat</label>
            <input type="number" name="jumlah_jemaat" class="form-control" required>
        </div>
        <button type="submit" name="tambah" class="btn btn-primary">Tambah Data</button>
    </form>

    <!-- Tabel Data Statistik -->
    <table class="table table-bordered table-striped mt-4">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Rayon</th>
                <th>Jumlah Jemaat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while($row = mysqli_fetch_assoc($statistik)) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['nama_rayon']); ?></td>
                <td><?= $row['jumlah_jemaat']; ?></td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="editData(<?= $row['id']; ?>, '<?= htmlspecialchars($row['nama_rayon']); ?>', <?= $row['jumlah_jemaat']; ?>)"><i class="fas fa-edit"></i></button> 
                    <a href="statistik.php?hapus=<?= $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>                    
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Statistik</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="mb-3">
                        <label for="edit_nama_rayon" class="form-label">Nama Rayon</label>
                        <input type="text" name="nama_rayon" id="edit_nama_rayon" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_jumlah_jemaat" class="form-label">Jumlah Jemaat</label>
                        <input type="number" name="jumlah_jemaat" id="edit_jumlah_jemaat" class="form-control" required>
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
function editData(id, nama_rayon, jumlah_jemaat) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_nama_rayon').value = nama_rayon;
    document.getElementById('edit_jumlah_jemaat').value = jumlah_jemaat;
    
    var editModal = new bootstrap.Modal(document.getElementById('editModal'));
    editModal.show();
}
</script>

</body>
</html>