<?php
session_start();
include '../config/database.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php'); // Sesuaikan path jika perlu
    exit();
}

// Handle status update (specifically for 'replied' action)
if (isset($_POST['mark_replied'])) {
    $message_id = intval($_POST['message_id']);
    
    // Set status to 'replied'
    $sql_update_status = "UPDATE contact_messages SET status = 'replied', updated_at = NOW() WHERE id = ?";
    $stmt_update = mysqli_prepare($conn, $sql_update_status);
    if ($stmt_update) {
        mysqli_stmt_bind_param($stmt_update, "i", $message_id);
        mysqli_stmt_execute($stmt_update);
        mysqli_stmt_close($stmt_update);
        $_SESSION['success_message'] = "Pesan berhasil ditandai sebagai 'Sudah Dibalas'.";
    } else {
        $_SESSION['error_message'] = "Gagal memperbarui status pesan.";
    }
    header('Location: pesan.php'); // Redirect to refresh page after update
    exit();
}

// Handle delete message
if (isset($_POST['delete_message'])) {
    $message_id = intval($_POST['message_id']);
    
    // Using prepared statements for delete
    $sql_delete_message = "DELETE FROM contact_messages WHERE id = ?";
    $stmt_delete = mysqli_prepare($conn, $sql_delete_message);
    if ($stmt_delete) {
        mysqli_stmt_bind_param($stmt_delete, "i", $message_id);
        mysqli_stmt_execute($stmt_delete);
        mysqli_stmt_close($stmt_delete);
        $_SESSION['success_message'] = "Pesan berhasil dihapus!";
    } else {
        $_SESSION['error_message'] = "Gagal menghapus pesan.";
    }
    header('Location: pesan.php'); // Redirect to refresh page after delete
    exit();
}

// Query untuk mendapatkan semua pesan, tanpa filter, diurutkan berdasarkan created_at
$sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql); // Tidak perlu prepared statements karena tidak ada input user di query ini

// Get statistics (hanya total dan replied)
$stats_sql = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'replied' THEN 1 ELSE 0 END) as replied
              FROM contact_messages";
$stats_result = mysqli_query($conn, $stats_sql);
$stats = mysqli_fetch_assoc($stats_result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Admin Panel - Pesan Jemaat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style-admin.css"> <style>
        /* Gaya dasar dari contoh Anda */
        .sidebar {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background-color: #343a40;
            padding-top: 20px;
            color: white;
            z-index: 1000; /* Pastikan sidebar di atas konten lain */
        }
        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 1.1em;
            color: #adb5bd;
            display: block;
            transition: 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            color: #ffffff;
            background-color: #495057;
        }
        .sidebar a i {
            margin-right: 10px;
        }
        .content {
            margin-left: 250px; /* Sesuaikan dengan lebar sidebar */
            padding: 20px;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .content {
                margin-left: 0;
            }
        }
        /* Styling untuk card statistik */
        .stats-card .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 15px;
            min-height: 120px;
        }
        .stats-card .card-body i {
            margin-bottom: 8px;
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            font-weight: 600;
        }
        /* Style untuk tombol aksi */
        .btn-action-group {
            white-space: nowrap; /* Menjaga tombol tetap dalam satu baris */
        }
    </style>
</head>
<body>

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
    <a href="pesan.php" class="active"><i class="far fa-fw fa-envelope me-2"></i>Pesan Jemaat</a>
    <a href="logout.php"><i class="fas fa-fw fa-sign-out-alt me-2"></i>Logout</a>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0" style="font-weight: bold">Pesan Jemaat</h2>
                <p class="text-muted">Pengelolaan pertanyaan, saran dan masukan dari jemaat</p>
            </div>
            <div class="d-flex">
                <div class="col-auto me-3"> <div class="card stats-card text-center">
                        <div class="card-body">
                            <i class="fas fa-envelope-open-text fa-2x text-primary"></i>
                            <h4 class="text-primary"><?php echo $stats['total']; ?></h4>
                            <small class="text-muted">Total Pesan</small>
                        </div>
                    </div>
                </div>
                <div class="col-auto"> <div class="card stats-card text-center">
                        <div class="card-body">
                            <i class="fas fa-reply fa-2x text-success"></i>
                            <h4 class="text-success"><?php echo $stats['replied']; ?></h4>
                            <small class="text-muted">Sudah Dibalas</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Daftar Pesan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Subjek</th>
                                <th>Pesan</th>
                                <th>Dikirim</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; if (mysqli_num_rows($result) > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($row['name']) ?></td>
                                        <td><?= htmlspecialchars($row['email']) ?></td>
                                        <td><?= htmlspecialchars($row['subject']) ?></td>
                                        <td><?= nl2br(htmlspecialchars(substr($row['message'], 0, 100))) . (strlen($row['message']) > 100 ? '...' : ''); ?></td>
                                        <td><?= date('Y-m-d H:i', strtotime($row['created_at'])) ?></td>
                                        <td class="btn-action-group">
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#messageModal<?= $row['id'] ?>" title="Lihat Detail Pesan">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <?php if ($row['status'] !== 'replied'): ?>
                                            <form action="" method="POST" class="d-inline" onsubmit="return confirm('Tandai pesan ini sebagai sudah dibalas?');">
                                                <input type="hidden" name="message_id" value="<?= $row['id'] ?>">
                                                <button type="submit" name="mark_replied" class="btn btn-success btn-sm" title="Tandai Sudah Dibalas">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <?php else: ?>
                                                <span class="badge bg-success" title="Pesan Sudah Dibalas"><i class="fas fa-reply"></i> Dibalas</span>
                                            <?php endif; ?>

                                            <form action="" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?');">
                                                <input type="hidden" name="message_id" value="<?= $row['id'] ?>">
                                                <button type="submit" name="delete_message" class="btn btn-danger btn-sm" title="Hapus Pesan">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                            <div class="modal fade" id="messageModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="messageModalLabel<?= $row['id'] ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="messageModalLabel<?= $row['id'] ?>">Detail Pesan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>ID Pesan:</strong> <?= $row['id'] ?></p>
                                                            <p><strong>Nama:</strong> <?= htmlspecialchars($row['name']) ?></p>
                                                            <p><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
                                                            <p><strong>Subjek:</strong> <?= htmlspecialchars($row['subject']) ?></p>
                                                            <p><strong>Pesan:</strong><br><?= nl2br(htmlspecialchars($row['message'])) ?></p>
                                                            <p><strong>Status:</strong> <?= htmlspecialchars($row['status']) ?></p>
                                                            <p><strong>Dikirim Pada:</strong> <?= $row['created_at'] ?></p>
                                                            <p><strong>Terakhir Diperbarui:</strong> <?= $row['updated_at'] ?></p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada pesan yang ditemukan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>