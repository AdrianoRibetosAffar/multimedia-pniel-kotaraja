<?php
session_start();
include('../config/database.php'); // Sesuaikan path-nya kalau perlu

// Pastikan sudah login
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}

// Ambil ID dari URL
if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan!";
    exit();
}

$id = intval($_GET['id']);

// Ambil data statistik berdasarkan ID
$query = "SELECT * FROM rayon WHERE id = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "Data tidak ditemukan!";
    exit();
}

$data = mysqli_fetch_assoc($result);

// Jika form disubmit
if (isset($_POST['submit'])) {
    $nama_rayon = mysqli_real_escape_string($conn, $_POST['nama_rayon']);
    $jumlah_jemaat = intval($_POST['jumlah_jemaat']);

    // Update data
    $update = "UPDATE rayon SET nama_rayon = '$nama_rayon', jumlah_jemaat = $jumlah_jemaat WHERE id = $id";
    if (mysqli_query($conn, $update)) {
        // Kalau berhasil, kembali ke halaman statistik
        header("Location: statistik.php");
        exit();
    } else {
        echo "Gagal mengupdate data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Statistik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
</head>
<body >

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="text-white text-center py-3">Admin Multimedia</h4>
    <a href="dashboard.php">Dashboard</a>
    <a href="tambah_jadwal.php">Jadwal Ibadah</a>
    <a href="tambah_berita.php">Gallery Berita</a>    
    <a href="statistik.php">Kelola Statistik</a>
    <a href="edit_live_streaming.php">Live Streaming</a>
    <a href="logout.php">Logout</a>
</div>

<div class="container mt-5">
    <h2>Edit Data Statistik</h2>
    <form method="post">
        <div class="mb-3">
            <label for="nama_rayon" class="form-label">Nama Rayon</label>
            <input type="text" name="nama_rayon" id="nama_rayon" class="form-control" value="<?= htmlspecialchars($data['nama_rayon']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="jumlah_jemaat" class="form-label">Jumlah Jemaat</label>
            <input type="number" name="jumlah_jemaat" id="jumlah_jemaat" class="form-control" value="<?= $data['jumlah_jemaat']; ?>" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Update</button>
        <a href="statistik.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
