<?php
include('../config/database.php');
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: dashboard.php");
    exit();
}

// Ambil data lama
$result = mysqli_query($conn, "SELECT * FROM jadwal_ibadah WHERE id = $id");
$data = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $hari = $_POST['hari'];
    $judul = $_POST['judul'];
    $jam = $_POST['jam'];

    // Jika ada gambar baru diupload
    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        $folder = '../uploads/';
        $gambar_baru = time() . '_' . basename($gambar);

        if (move_uploaded_file($tmp, $folder . $gambar_baru)) {
            // Hapus gambar lama (opsional)
            if (file_exists($folder . $data['gambar'])) {
                unlink($folder . $data['gambar']);
            }

            $query = "UPDATE jadwal_ibadah SET hari='$hari', judul='$judul', jam='$jam', gambar='$gambar_baru' WHERE id=$id";
        }
    } else {
        $query = "UPDATE jadwal_ibadah SET hari='$hari', judul='$judul', jam='$jam' WHERE id=$id";
    }

    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Jadwal berhasil diperbarui!";
        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION['error'] = "Gagal update data.";
    }
}
?>

<!-- Form HTML sama seperti tambah_jadwal.php tapi dengan isian data lama -->
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Jadwal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
</head>
<body class="bg-light">
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
<div class="container py-5">
    <h2>Edit Jadwal Ibadah</h2>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Hari</label>
            <input type="text" name="hari" class="form-control" value="<?= $data['hari'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" value="<?= $data['judul'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Jam</label>
            <input type="text" name="jam" class="form-control" value="<?= $data['jam'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Gambar Baru (Opsional)</label>
            <input type="file" name="gambar" class="form-control">
            <small>Gambar saat ini: <?= $data['gambar'] ?></small>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a href="dashboard.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
