<?php
session_start();
include('../config/database.php');


if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Ambil total jumlah jemaat
$query = "SELECT SUM(jumlah_jemaat) as total FROM rayon";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
$totalJemaat = $data['total'] ?? 0;

// Ambil semua data statistik
$statistik = mysqli_query($conn, "SELECT * FROM rayon");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
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

<!-- Main Content -->
<div class="content">
    <h2>Selamat Datang di Dashboard Admin</h2>
    <h4>Dashboard ini digunakan untuk mengelola data website Multimedia GKI Pniel Kotaraja</h4>
    
    <div class="row my-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Jemaat</h5>
                    <p class="card-text" style="font-size: 30px; font-weight: bold;"><?php echo $totalJemaat; ?></p>
                </div>
            </div>
        </div>
    </div>

    <h4 class="mt-5">Data Statistik Jemaat</h4>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Rayon</th>
                <th>Jumlah Jemaat</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while($row = mysqli_fetch_assoc($statistik)) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['nama_rayon']); ?></td>
                <td><?= $row['jumlah_jemaat']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
