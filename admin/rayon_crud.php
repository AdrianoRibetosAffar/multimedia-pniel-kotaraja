<?php
session_start();
include("../config/database.php");

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
}

// Tambah data
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama_rayon'];
    $jumlah = $_POST['jumlah_jemaat'];
    mysqli_query($conn, "INSERT INTO rayon (nama_rayon, jumlah_jemaat) VALUES ('$nama', '$jumlah')");
    header("Location: rayon_crud.php");
}

// Hapus data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM rayon WHERE id=$id");
    header("Location: rayon_crud.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kelola Data Rayon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="d-flex" style="min-height: 100vh;">
    <!-- Sidebar -->
    <div class="bg-dark text-white p-3" style="width: 250px;">
        <h2>Admin</h2>
        <ul class="nav flex-column mt-4">
            <li class="nav-item mb-2">
                <a href="dashboard.php" class="nav-link text-white">Dashboard</a>
            </li>
            <li class="nav-item mb-2">
                <a href="rayon_crud.php" class="nav-link text-white">Kelola Data Rayon</a>
            </li>
            <li class="nav-item">
                <a href="logout.php" class="nav-link text-danger">Logout</a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="p-4 flex-grow-1">
        <h1>Kelola Data Rayon</h1>

        <form method="POST" action="" class="mb-4">
            <div class="mb-3">
                <input type="text" class="form-control" name="nama_rayon" placeholder="Nama Rayon" required>
            </div>
            <div class="mb-3">
                <input type="number" class="form-control" name="jumlah_jemaat" placeholder="Jumlah Jemaat" required>
            </div>
            <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
        </form>

        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Rayon</th>
                    <th>Jumlah Jemaat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $data = mysqli_query($conn, "SELECT * FROM rayon");
                while ($d = mysqli_fetch_array($data)) {
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $d['nama_rayon'] ?></td>
                    <td><?= $d['jumlah_jemaat'] ?></td>
                    <td>
                    <a href="edit_rayon.php?id=<?= $d['id'] ?>" class="btn btn-primary btn-sm">Edit</a>    
                    <a href="rayon_crud.php?hapus=<?= $d['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <br><a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
</div>
</body>
</html>
