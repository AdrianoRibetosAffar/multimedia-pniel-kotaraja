<?php
include('../config/database.php');
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}

// Proses simpan
if (isset($_POST['simpan'])) {
    $hari = $_POST['hari'];
    $judul = $_POST['judul'];
    $jam = $_POST['jam'];

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

// Ambil semua data jadwal
$data_jadwal = mysqli_query($conn, "SELECT * FROM jadwal_ibadah ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah & Lihat Jadwal</title>
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
    <h2>Tambah Jadwal Ibadah</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data" class="mb-5">
        <div class="mb-3">
            <label for="hari">Hari</label>
            <input type="text" name="hari" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="judul">Judul Ibadah</label>
            <input type="text" name="judul" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="jam">Jam</label>
            <input type="text" name="jam" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="gambar">Upload Gambar</label>
            <input type="file" name="gambar" class="form-control" accept="image/*" required>
        </div>
        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
    </form>

    <h3>Data Jadwal Ibadah</h3>
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
                    <a href="edit_jadwal.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="hapus_jadwal.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-danger btn-sm">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
