<?php
session_start();
include('../config/database.php'); // Ubah sesuai lokasi koneksi database kamu

// Cek jika user belum login
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}

// Ambil data link
$query = mysqli_query($conn, "SELECT * FROM live_streaming LIMIT 1");
$streaming = mysqli_fetch_assoc($query);

// Update proses
if (isset($_POST['update'])) {
    $link_youtube = mysqli_real_escape_string($conn, $_POST['link_youtube']);
    $update = mysqli_query($conn, "UPDATE live_streaming SET link_youtube = '$link_youtube' WHERE id = " . $streaming['id']);

    if ($update) {
        $_SESSION['success'] = "Link live streaming berhasil diperbarui!";
        header("Location: edit_live_streaming.php");
        exit();
    } else {
        $_SESSION['error'] = "Gagal memperbarui link.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Link Live Streaming</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style-admin.css">
</head>
<body class="bg-light">

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

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Link Live Streaming</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="link_youtube" class="form-label">Link Live Streaming</label>
                            <input type="text" name="link_youtube" id="link_youtube" class="form-control" value="<?= htmlspecialchars($streaming['link_youtube']); ?>" required>                            
                        </div>
                        <button type="submit" name="update" class="btn btn-success">Update Link</button>
                        <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
