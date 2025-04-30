<?php
session_start();
include('../config/database.php');

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Handle Tambah Data
if (isset($_POST['tambah'])) {
    $nama_rayon = $_POST['nama_rayon'];
    $jumlah_jemaat = $_POST['jumlah_jemaat'];

    mysqli_query($conn, "INSERT INTO rayon (nama_rayon, jumlah_jemaat) VALUES ('$nama_rayon', '$jumlah_jemaat')");
    header("Location: statistik.php");
}

// Handle Hapus Data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM rayon WHERE id=$id");
    header("Location: statistik.php");
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
    <style>
        body {
            min-height: 100vh;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            min-height: 100vh;
        }
        .sidebar a {
            color: white;
            padding: 15px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
    </style>
</head>
<body>

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
                    <a href="edit-statistik.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="statistik.php?hapus=<?= $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-sm">Hapus</a>                    
                </td>

            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
