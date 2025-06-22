<?php
session_start();

// Cek apakah ini request AJAX untuk validasi session
if (isset($_GET['check_session'])) {
    if (!isset($_SESSION['admin_logged_in'])) {
        echo json_encode(['status' => 'expired']);
    } else {
        echo json_encode(['status' => 'active']);
    }
    exit();
}

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"> 
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

<!-- Main Content -->
<div class="content">
    <h2 data-aos="fade-right" data-aos-duration="1000">Selamat Datang di Dashboard Admin</h2>
    <h4 data-aos="fade-right" data-aos-duration="1000">Dashboard ini digunakan untuk mengelola data website Multimedia GKI Pniel Kotaraja</h4>
    
    <div class="row my-4">
        <div class="col-md-4" data-aos="fade-up" data-aos-duration="1000">
            <div class="card bg-primary shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Jemaat</h5>
                    <p class="card-text"><?php echo $totalJemaat; ?></p>
                </div>
            </div>
        </div>
    </div>

    <h4 class="mt-5" data-aos="fade-right" data-aos-duration="1000">Data Statistik Jemaat</h4>
    <table class="table table-bordered table-striped" data-aos="fade-up" data-aos-duration="1200">
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


<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
    
    // Sederhana: simulasi session expired setelah 30 detik
    setTimeout(function() {
        // Clear sessionStorage
        sessionStorage.clear();
        
        // Force logout server
        fetch('force_logout.php', {
            method: 'POST',
            cache: 'no-cache'
        }).finally(() => {
            alert('Session expired. Silakan login ulang.');
            
            // Paksa redirect dengan berbagai cara
            document.body.innerHTML = '<div style="text-align:center;margin-top:200px;"><h2>Session Expired</h2><p>Redirecting to login...</p></div>';
            
            setTimeout(() => {
                window.location.replace('login.php');
            }, 1000);
        });
    }, 180000); // 30 detik untuk testing
    
    // Prevent right click
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });
</script>
</body>
</html>