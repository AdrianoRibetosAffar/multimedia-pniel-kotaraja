<?php
include('../config/database.php');
session_start();

// Tambah Berita
if (isset($_POST['tambah'])) {
    $judul = $_POST['judul'];
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $folder = '../uploads/';
    $gambar_baru = time() . '_' . basename($gambar);

    if (move_uploaded_file($tmp, $folder . $gambar_baru)) {
        mysqli_query($conn, "INSERT INTO berita (judul, gambar) VALUES ('$judul', '$gambar_baru')");
        header("Location: tambah_berita.php");
        exit();
    } else {
        echo "<script>alert('Gagal mengunggah gambar');</script>";
    }
}

// Hapus Berita
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT gambar FROM berita WHERE id=$id"));
    if ($data && file_exists("../uploads/" . $data['gambar'])) {
        unlink("../uploads/" . $data['gambar']);
    }
    mysqli_query($conn, "DELETE FROM berita WHERE id=$id");
    header("Location: tambah_berita.php");
    exit();
}

// Ambil semua data berita
$berita = mysqli_query($conn, "SELECT * FROM berita ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola Berita</title>
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
    <h2 class="mb-4">Kelola Berita Pniel</h2>

    <!-- Form Tambah -->
    <form method="POST" enctype="multipart/form-data" class="mb-5 border p-3 bg-white rounded">
        <div class="mb-3">
            <label for="judul">Judul</label>
            <input type="text" name="judul" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="gambar">Gambar</label>
            <input type="file" name="gambar" class="form-control" accept="image/*" required>
        </div>
        <button type="submit" name="tambah" class="btn btn-primary">Tambah Berita</button>
    </form>

    <!-- Tabel Berita -->
    <table class="table table-bordered table-striped bg-white">
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Judul</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($berita)): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><img src="../uploads/<?= $row['gambar'] ?>" width="100"></td>
                <td><?= htmlspecialchars($row['judul']) ?></td>
                <td>
                    <a href="edit_berita.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
