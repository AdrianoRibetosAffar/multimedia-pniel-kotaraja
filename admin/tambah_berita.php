<?php
include('../config/database.php');
session_start();

// Tambah Berita
if (isset($_POST['tambah'])) {
    $judul = $_POST['judul'];
    $link_drive = $_POST['link_drive'];
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $folder = '../uploads/';
    $gambar_baru = time() . '_' . basename($gambar);

    if (move_uploaded_file($tmp, $folder . $gambar_baru)) {
        mysqli_query($conn, "INSERT INTO berita (judul, gambar, link_drive) VALUES ('$judul', '$gambar_baru', '$link_drive')");
        header("Location: tambah_berita.php");
        exit();
    } else {
        echo "<script>alert('Gagal mengunggah gambar');</script>";
    }
}

// Update Berita
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $judul = $_POST['judul_edit'];
    $link_drive = $_POST['link_drive_edit'];
    
    if ($_FILES['gambar_edit']['name']) {
        // Ada gambar baru
        $gambar = $_FILES['gambar_edit']['name'];
        $tmp = $_FILES['gambar_edit']['tmp_name'];
        $folder = '../uploads/';
        $gambar_baru = time() . '_' . basename($gambar);
        
        if (move_uploaded_file($tmp, $folder . $gambar_baru)) {
            // Hapus gambar lama
            $old_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT gambar FROM berita WHERE id=$id"));
            if ($old_data && file_exists("../uploads/" . $old_data['gambar'])) {
                unlink("../uploads/" . $old_data['gambar']);
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
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style-admin.css">
    
    <style>
        .preview-card {
            max-width: 200px;
            margin: 10px 0;
        }
        .preview-img {
            height: 120px;
            object-fit: cover;
        }
        .link-preview {
            font-size: 12px;
            color: #666;
            word-break: break-all;
        }
        .modal-img {
            max-height: 200px;
            object-fit: cover;
        }
    </style>
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
    <h2 class="mb-4"><i class="fas fa-images me-2"></i>Kelola Gallery Pniel</h2>

    <!-- Form Tambah -->
    <div class="card mb-5">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Tambah Item Gallery</h5>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="judul" class="form-label"><i class="fas fa-heading me-1"></i>Judul</label>
                            <input type="text" name="judul" id="judul" class="form-control" placeholder="Masukkan judul gallery" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="link_drive" class="form-label"><i class="fab fa-google-drive me-1"></i>Link Google Drive</label>
                            <input type="url" name="link_drive" id="link_drive" class="form-control" 
                                   placeholder="https://drive.google.com/..." 
                                   title="Masukkan link Google Drive yang valid">
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Pastikan link Google Drive dapat diakses publik
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="gambar" class="form-label"><i class="fas fa-image me-1"></i>Gambar</label>
                            <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*" required>
                            <div class="form-text">Format yang diizinkan: JPG, JPEG, PNG, GIF (Max: 5MB)</div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <!-- Preview Area -->
                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-eye me-1"></i>Preview</label>
                            <div id="imagePreview" class="border rounded p-3 text-center">
                                <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                <p class="text-muted">Preview gambar akan muncul di sini</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="reset" class="btn btn-secondary me-md-2">
                        <i class="fas fa-undo me-1"></i>Reset
                    </button>
                    <button type="submit" name="tambah" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Tambah Gallery
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Berita -->
    <div class="card">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Gallery</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Gambar</th>
                            <th width="30%">Judul</th>
                            <th width="30%">Link Drive</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($berita)): 
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <img src="../uploads/<?= $row['gambar'] ?>" class="img-thumbnail preview-img" 
                                     alt="<?= htmlspecialchars($row['judul']) ?>">
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($row['judul']) ?></strong>
                            </td>
                            <td>
                                <?php if (!empty($row['link_drive'])): ?>
                                    <a href="<?= $row['link_drive'] ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fab fa-google-drive me-1"></i>Lihat Drive
                                    </a>
                                    <div class="link-preview mt-1"><?= substr($row['link_drive'], 0, 50) ?>...</div>
                                <?php else: ?>
                                    <span class="text-muted"><i class="fas fa-times me-1"></i>Tidak ada link</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-warning" 
                                            onclick="editBerita(<?= $row['id'] ?>, '<?= htmlspecialchars($row['judul']) ?>', '<?= htmlspecialchars($row['link_drive'] ?? '') ?>', '<?= $row['gambar'] ?>')" 
                                            title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Yakin ingin menghapus item ini?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Berita -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Gallery Item
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" enctype="multipart/form-data" id="editForm">
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="judul_edit" class="form-label">
                                    <i class="fas fa-heading me-1"></i>Judul
                                </label>
                                <input type="text" name="judul_edit" id="judul_edit" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="link_drive_edit" class="form-label">
                                    <i class="fab fa-google-drive me-1"></i>Link Google Drive
                                </label>
                                <input type="url" name="link_drive_edit" id="link_drive_edit" class="form-control" 
                                       placeholder="https://drive.google.com/...">
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Kosongkan jika tidak ada link drive
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="gambar_edit" class="form-label">
                                    <i class="fas fa-image me-1"></i>Gambar Baru (Opsional)
                                </label>
                                <input type="file" name="gambar_edit" id="gambar_edit" class="form-control" accept="image/*">
                                <div class="form-text">Kosongkan jika tidak ingin mengubah gambar</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-eye me-1"></i>Gambar Saat Ini
                                </label>
                                <div class="border rounded p-3 text-center" id="currentImageContainer">
                                    <img id="currentImage" class="img-fluid rounded modal-img" alt="">
                                </div>
                            </div>
                            
                            <div class="mb-3" id="currentLinkContainer" style="display: none;">
                                <label class="form-label">
                                    <i class="fab fa-google-drive me-1"></i>Link Drive Saat Ini
                                </label>
                                <div class="border rounded p-3">
                                    <a id="currentLink" href="#" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-external-link-alt me-1"></i>Buka Link
                                    </a>
                                    <div class="small text-muted mt-2" style="word-break: break-all;" id="currentLinkText">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Preview gambar baru -->
                            <div id="newImagePreview" style="display: none;" class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-eye me-1"></i>Preview Gambar Baru
                                </label>
                                <div class="border rounded p-3 text-center">
                                    <img id="newImagePreviewImg" class="img-fluid rounded modal-img" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" name="update" class="btn btn-warning">
                        <i class="fas fa-save me-1"></i>Update Gallery
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Image Preview Function untuk form tambah
document.getElementById('gambar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" class="img-fluid rounded" style="max-height: 200px;">
                <p class="mt-2 mb-0 text-muted">${file.name}</p>
            `;
        }
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = `
            <i class="fas fa-image fa-3x text-muted mb-2"></i>
            <p class="text-muted">Preview gambar akan muncul di sini</p>
        `;
    }
});

// Image Preview Function untuk modal edit
document.getElementById('gambar_edit').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('newImagePreview');
    const previewImg = document.getElementById('newImagePreviewImg');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});

// Form validation for Google Drive link
function validateDriveLink(inputElement) {
    inputElement.addEventListener('input', function(e) {
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
}

// Apply validation to both forms
validateDriveLink(document.getElementById('link_drive'));
validateDriveLink(document.getElementById('link_drive_edit'));

// Function to open edit modal
function editBerita(id, judul, linkDrive, gambar) {
    // Set form values
    document.getElementById('edit_id').value = id;
    document.getElementById('judul_edit').value = judul;
    document.getElementById('link_drive_edit').value = linkDrive;
    
    // Set current image
    document.getElementById('currentImage').src = `../uploads/${gambar}`;
    document.getElementById('currentImage').alt = judul;
    
    // Show/hide link container
    const linkContainer = document.getElementById('currentLinkContainer');
    if (linkDrive && linkDrive.trim() !== '') {
        document.getElementById('currentLink').href = linkDrive;
        document.getElementById('currentLinkText').textContent = linkDrive;
        linkContainer.style.display = 'block';
    } else {
        linkContainer.style.display = 'none';
    }
    
    // Reset file input and preview
    document.getElementById('gambar_edit').value = '';
    document.getElementById('newImagePreview').style.display = 'none';
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('editModal'));
    modal.show();
}

// Reset form when modal is closed
document.getElementById('editModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('editForm').reset();
    document.getElementById('newImagePreview').style.display = 'none';
    
    // Remove validation classes
    const inputs = document.querySelectorAll('#editModal input');
    inputs.forEach(input => {
        input.classList.remove('is-valid', 'is-invalid');
    });
});
</script>

</body>
</html>