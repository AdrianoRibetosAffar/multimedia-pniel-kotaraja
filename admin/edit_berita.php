<?php
include('../config/database.php');
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM berita WHERE id=$id"));

if (isset($_POST['update'])) {
    $judul = $_POST['judul'];

    if ($_FILES['gambar']['name']) {
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        $folder = '../uploads/';
        $gambar_baru = time() . '_' . basename($gambar);
        move_uploaded_file($tmp, $folder . $gambar_baru);
        if (file_exists($folder . $data['gambar'])) {
            unlink($folder . $data['gambar']);
        }
        mysqli_query($conn, "UPDATE berita SET judul='$judul', gambar='$gambar_baru' WHERE id=$id");
    } else {
        mysqli_query($conn, "UPDATE berita SET judul='$judul' WHERE id=$id");
    }

    header("Location: tambah_berita.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Berita</title>
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
    <h2>Edit Berita</h2>
    <form method="POST" enctype="multipart/form-data" class="border p-3 bg-white rounded">
        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" value="<?= $data['judul'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Gambar (kosongkan jika tidak ingin ganti)</label>
            <input type="file" name="gambar" class="form-control" accept="image/*">
            <small>Gambar saat ini: <?= $data['gambar'] ?></small>
        </div>
        <button type="submit" name="update" class="btn btn-success">Simpan Perubahan</button>
        <a href="tambah_berita.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
