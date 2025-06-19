<?php
session_start();
include '../config/database.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Handle status update
if (isset($_POST['update_status'])) {
    $message_id = intval($_POST['message_id']);
    $new_status = $_POST['status'];
    
    $sql = "UPDATE contact_messages SET status = ?, updated_at = NOW() WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $new_status, $message_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Handle delete message
if (isset($_POST['delete_message'])) {
    $message_id = intval($_POST['message_id']);
    
    $sql = "DELETE FROM contact_messages WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $message_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Get filter parameters
$status_filter = isset($_GET['status']) ? $_GET['status'] : 'all';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Build query
$sql = "SELECT * FROM contact_messages WHERE 1=1";
$params = [];
$types = "";

if ($status_filter !== 'all') {
    $sql .= " AND status = ?";
    $params[] = $status_filter;
    $types .= "s";
}

if (!empty($search)) {
    $sql .= " AND (name LIKE ? OR email LIKE ? OR subject LIKE ? OR message LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "ssss";
}

$sql .= " ORDER BY created_at DESC";

$stmt = mysqli_prepare($conn, $sql);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Get statistics
$stats_sql = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'unread' THEN 1 ELSE 0 END) as unread,
                SUM(CASE WHEN status = 'read' THEN 1 ELSE 0 END) as read,
                SUM(CASE WHEN status = 'replied' THEN 1 ELSE 0 END) as replied
              FROM contact_messages";
$stats_result = mysqli_query($conn, $stats_sql);
$stats = mysqli_fetch_assoc($stats_result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Multimedia GKI Pniel Kotaraja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            border-radius: 8px;
            margin: 2px 0;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255,255,255,0.1);
        }
        .main-content {
            padding: 20px;
        }
        .stats-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .message-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 15px;
        }
        .status-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
        .message-content {
            max-height: 100px;
            overflow-y: auto;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-3">
                <div class="text-center mb-4">
                    <h5>Admin Panel</h5>
                    <small>GKI Pniel Kotaraja</small>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link active" href="dashboard.php">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a class="nav-link" href="messages.php">
                        <i class="fas fa-envelope me-2"></i>Pesan Kontak
                    </a>
                    <a class="nav-link" href="../home.php" target="_blank">
                        <i class="fas fa-external-link-alt me-2"></i>Lihat Website
                    </a>
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Dashboard Pesan Kontak</h2>
                    <span class="text-muted">Selamat datang, <?php echo $_SESSION['admin_name']; ?>!</span>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card stats-card text-center">
                            <div class="card-body">
                                <i class="fas fa-envelope-open-text fa-2x text-primary mb-2"></i>
                                <h4 class="text-primary"><?php echo $stats['total']; ?></h4>
                                <small class="text-muted">Total Pesan</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stats-card text-center">
                            <div class="card-body">
                                <i class="fas fa-envelope fa-2x text-warning mb-2"></i>
                                <h4 class="text-warning"><?php echo $stats['unread']; ?></h4>
                                <small class="text-muted">Belum Dibaca</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stats-card text-center">
                            <div class="card-body">
                                <i class="fas fa-envelope-open fa-2x text-info mb-2"></i>
                                <h4 class="text-info"><?php echo $stats['read']; ?></h4>
                                <small class="text-muted">Sudah Dibaca</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card stats-card text-center">
                            <div class="card-body">
                                <i class="fas fa-reply fa-2x text-success mb-2"></i>
                                <h4 class="text-success"><?php echo $stats['replied']; ?></h4>
                                <small class="text-muted">Sudah Dibalas</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Filter & Pencarian</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" class="row">
                            <div class="col-md-4 mb-2">
                                <select name="status" class="form-select">
                                    <option value="all" <?php echo $status_filter === 'all' ? 'selected' : ''; ?>>Semua Status</option>
                                    <option value="unread" <?php echo $status_filter === 'unread' ? 'selected' : ''; ?>>Belum Dibaca</option>
                                    <option value="read" <?php echo $status_filter === 'read' ? 'selected' : ''; ?>>Sudah Dibaca</option>
                                    <option value="replied" <?php echo $status_filter === 'replied' ? 'selected' : ''; ?>>Sudah Dibalas</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="text" name="search" class="form-control" placeholder="Cari nama, email, atau subjek..." value="<?php echo htmlspecialchars($search); ?>">
                            </div>
                            <div class="col-md-2 mb-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i> Cari
                                </button>