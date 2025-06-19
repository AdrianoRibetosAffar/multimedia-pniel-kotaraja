<?php
include('../config/database.php');
session_start();

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM berita WHERE id=$id"));

if (isset($_POST['update'])) {
    $judul = $_POST['judul'];
    $link_drive = $_POST['link_drive'];
    
    if ($_FILES['gambar']['name']) {
        // Ada gambar baru
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        $folder = '../uploads/';
        $gambar_baru = time() . '_' . basename($gambar);
        
        if (move_uploaded_file($tmp, $folder . $gambar_baru)) {
            // Hapus gambar lama
            if (file_exists("../uploads/" . $data['gambar'])) {
                unlink("../uploads/" . $data['gambar']);
            }
            mysqli_query($conn, "UPDATE berita SET judul='$judul', gambar='$gambar_baru', link_drive='$link_drive' WHERE id=$id");
        }
    } else {
        // Tidak ada gambar baru
        mysqli_query($conn, "UPDATE berita SET judul='$judul', link_drive='$link_drive' WHERE id=$id");
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Edit Gallery Item
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="judul" class="form-label">
                                        <i class="fas fa-heading me-1"></i>Judul
                                    </label>
                                    <input type="text" name="judul" id="judul" class="form-control" 
                                           value="<?= htmlspecialchars($data['judul']) ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="link_drive" class="form-label">
                                        <i class="fab fa-google-drive me-1"></i>Link Google Drive
                                    </label>
                                    <input type="url" name="link_drive" id="link_drive" class="form-control" 
                                           value="<?= htmlspecialchars($data['link_drive'] ?? '') ?>" 
                                           placeholder="https://drive.google.com/...">
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Kosongkan jika tidak ada link drive
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="gambar" class="form-label">
                                        <i class="fas fa-image me-1"></i>Gambar Baru (Opsional)
                                    </label>
                                    <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                                    <div class="form-text">Kosongkan jika tidak ingin mengubah gambar</div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-eye me-1"></i>Gambar Saat Ini
                                    </label>
                                    <div class="border rounded p-3 text-center">
                                        <img src="../uploads/<?= $data['gambar'] ?>" 
                                             class="img-fluid rounded" 
                                             style="max-height: 200px;"
                                             alt="<?= htmlspecialchars($data['judul']) ?>">
                                    </div>
                                </div>
                                
                                <?php if (!empty($data['link_drive'])): ?>
                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="fab fa-google-drive me-1"></i>Link Drive Saat Ini
                                    </label>
                                    <div class="border rounded p-3">
                                        <a href="<?= $data['link_drive'] ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-external-link-alt me-1"></i>Buka Link
                                        </a>
                                        <div class="small text-muted mt-2" style="word-break: break-all;">
                                            <?= htmlspecialchars($data['link_drive']) ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="tambah_berita.php" class="btn btn-secondary me-md-2">
                                <i class="fas fa-arrow-left me-1"></i>Kembali
                            </a>
                            <button type="submit" name="update" class="btn btn-warning">
                                <i class="fas fa-save me-1"></i>Update Gallery
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Image Preview Function
document.getElementById('gambar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Create or update preview
            let preview = document.getElementById('newImagePreview');
            if (!preview) {
                preview = document.createElement('div');
                preview.id = 'newImagePreview';
                preview.className = 'mt-3 border rounded p-3 text-center';
                document.querySelector('input[type="file"]').parentNode.appendChild(preview);
            }
            
            preview.innerHTML = `
                <strong class="text-success">Preview Gambar Baru:</strong><br>
                <img src="${e.target.result}" class="img-fluid rounded mt-2" style="max-height: 150px;">
            `;
        };
        reader.readAsDataURL(file);
    }
});

// Form validation for Google Drive link
document.getElementById('link_drive').addEventListener('input', function(e) {
    const link = e.target.value;
    const isValidDriveLink = link === '' || link.includes('drive.google.com') || link.includes('docs.google.com');
    
    if (!isValidDriveLink && link !== '') {
        e.target.setCustomValidity('Harap masukkan link Google Drive yang valid');
        e.target.classList.add('is-invalid');
    } else {
        e.target.setCustomValidity('');
        e.target.classList.remove('is-invalid');
        if (link !== '') {
            e.target.classList.add('is-valid');
        }
    }
});
</script>

</body>
</html>