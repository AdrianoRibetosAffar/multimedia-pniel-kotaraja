<?php
// Include database connection
include 'config/database.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    // Insert message into database
    $sql = "INSERT INTO contact_messages (name, email, subject, message, created_at) VALUES (?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $subject, $message);
    
    if (mysqli_stmt_execute($stmt)) {
        $success_message = "Pesan Anda berhasil dikirim! Terima kasih telah menghubungi kami.";
    } else {
        $error_message = "Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.";
    }
    
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - Multimedia GKI Pniel Kotaraja</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="img/logo-judul.png" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="mulmed.css">
    
    <style>
        
        .page-title {
            text-align: center;
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 50px;
            position: relative;
        }
        
        .page-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(135deg,rgb(0, 0, 0) 0%,#00d5ff 100%);
        }
        
        .contact-section {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgb(0, 0, 0);
            overflow: hidden;
            margin-bottom: 30px;
        }
        
        .contact-info {
            background: black;
            color: white;
            padding: 40px;
        }
        
        .contact-info h3 {
            font-weight: 700;
            margin-bottom: 30px;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .contact-item i {
            font-size: 20px;
            margin-right: 15px;
            width: 30px;
        }
        
        .contact-form-container {
            padding: 40px;
        }
        
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 8px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .map-container {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .map-container iframe {
            border-radius: 15px;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #f44336 0%, #da190b 100%);
            color: white;
        }   
        
        @media (max-width: 768px) {
            .contact-info, .contact-form-container {
                padding: 20px;
            }
            
            .main-content {
                margin-top: 80px;
                padding: 20px 0;
            }
        }
    </style>
</head>
<body>

    <!--  Navbar Start-->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand text-white d-flex align-items-center me-auto" href="#">
                <img src="img/logo-mulmed.png" alt="Logo">
                <h2>Multimedia GKI Pniel Kotaraja</h2>
            </a>
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars ms-1"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                    <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Profile
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="profile.html">Tentang Pniel</a></li>
                            <li><a class="dropdown-item" href="multimedia-pniel.html">Multimedia Pniel</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="gallery.php">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

        <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white text-center">Contact</h1>                
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->
    
    <!-- Main Content Start -->
    <div class="main-content">
        <div class="container">
        <h2 class="page-title text-center mb-5">
            Hubungi Kami
        </h2>
            
            <!-- Success/Error Messages -->
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert" data-aos="fade-down">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php echo $success_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert" data-aos="fade-down">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?php echo $error_message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <!-- Contact Section -->
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="contact-section" data-aos="fade-right">
                        <div class="row g-0">
                            <div class="col-md-5">
                                <div class="contact-info h-100">
                                    <h3>Informasi Kontak</h3>
                                    <div class="contact-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <div>
                                            <strong>Alamat:</strong><br>
                                            Jl. Raya Kotaraja No. 123<br>
                                            Jayapura, Papua 99351
                                        </div>
                                    </div>
                                    <div class="contact-item">
                                        <i class="fas fa-phone"></i>
                                        <div>
                                            <strong>Telepon:</strong><br>
                                            +62 967 123 456
                                        </div>
                                    </div>
                                    <div class="contact-item">
                                        <i class="fas fa-envelope"></i>
                                        <div>
                                            <strong>Email:</strong><br>
                                            info@gkipnielkotaraja.org
                                        </div>
                                    </div>
                                    <div class="contact-item">
                                        <i class="fas fa-clock"></i>
                                        <div>
                                            <strong>Jam Layanan:</strong><br>
                                            Senin - Jumat: 08:00 - 17:00<br>
                                            Sabtu: 08:00 - 12:00
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="contact-form-container">
                                    <h3 class="mb-4">Kirim Pesan</h3>
                                    <form method="POST" action="">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="name" class="form-label">Nama Lengkap *</label>
                                                <input type="text" class="form-control" id="name" name="name" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="email" class="form-label">Email *</label>
                                                <input type="email" class="form-control" id="email" name="email" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="subject" class="form-label">Subjek *</label>
                                            <input type="text" class="form-control" id="subject" name="subject" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="message" class="form-label">Pesan *</label>
                                            <textarea class="form-control" id="message" name="message" rows="5" required placeholder="Tulis pesan Anda di sini..."></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-outline-dark">
                                            <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Map Section -->
                <div class="col-lg-4 mb-4">
                    <div class="map-container" data-aos="fade-left">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3982.7234567890123!2d140.7180902!3d-2.5913901!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMsKwMzUnMjkuMCJTIDE0MMKwNDMnMDUuMSJF!5e0!3m2!1sen!2sid!4v1638319148355!5m2!1sen!2sid" 
                            width="100%" 
                            height="500" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Content End -->

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p class="mb-0">
                        &copy; 2025 Multimedia GKI Pniel Kotaraja. All rights reserved. | 
                        <a href="https://github.com/AdrianoRibetosAffar" class="text-white text-decoration-none">
                            <i class="fab fa-github me-1"></i>Developer
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true
        });
        
        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>
</html>