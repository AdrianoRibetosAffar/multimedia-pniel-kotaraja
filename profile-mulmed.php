<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Multimedia</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="img/logo-judul.png" />
    <!-- Font Awesome icons -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"> 
    <!-- CSS -->
    <link rel="stylesheet" href="style.css">
    <style>
         /* Navbar Background Fix */
        #mainNav {
            background-color: #212529; /* Warna gelap untuk navbar */
            backdrop-filter: blur(10px); /* Efek blur untuk background */
            -webkit-backdrop-filter: blur(10px); /* Untuk Safari */
            transition: all 0.3s ease-in-out;
        }

        /* Alternatif dengan gradient */
        #mainNav.gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        /* Untuk navbar yang scrolled */
        #mainNav.navbar-scrolled {
            background-color: rgba(33, 37, 41, 0.95); /* Semi-transparan saat scroll */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Styling untuk logo dan brand */
        #mainNav .navbar-brand {
            font-weight: 700;
            color: #fff !important;
        }

        #mainNav .navbar-brand img {
            height: 40px;
            width: auto;
            margin-right: 10px;
        }

        #mainNav .navbar-brand h2 {
            margin: 0;
            font-size: 1.2rem;
        }

        /* Styling untuk nav links */
        #mainNav .navbar-nav .nav-link {
            color: #fff !important;
            font-weight: 500;
            padding: 0.75rem 1rem;
            transition: color 0.3s ease;
        }

        #mainNav .navbar-nav .nav-link:hover {
            color: #ffc107 !important; /* Warna hover kuning */
        }

        /* Styling untuk dropdown */
        #mainNav .dropdown-menu {
            background-color: #343a40;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        #mainNav .dropdown-item {
            color: #fff;
            transition: background-color 0.3s ease;
        }

        #mainNav .dropdown-item:hover {
            background-color: #495057;
            color: #ffc107;
        }

        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            #mainNav {
                background-color: #212529 !important;
            }
            
            #mainNav .navbar-brand h2 {
                font-size: 1rem;
            }
        }

        @media (min-width: 992px) {
            
        }
        
        .breadcrumb-item a {
            text-decoration: none;
        }
        
        .breadcrumb-item a:hover {
            text-decoration: underline;
        }

        .member-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .member-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .avatar-container {
            position: relative;
            display: inline-block;
        }

        .avatar-container::after {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            border: 2px solid transparent;
            border-radius: 50%;
            background: linear-gradient(45deg, #4a90e2, #50c878, #ff6b6b, #ffd93d) border-box;
            -webkit-mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: subtract;
            mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
            mask-composite: subtract;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .member-card:hover .avatar-container::after {
            opacity: 1;
        }

        @media (max-width: 768px) {
            .col-lg-4 {
                flex: 0 0 auto;
                width: 100%;
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
                    <h1 class="display-3 text-white text-center">Profile Multimedia</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="home.php" class="text-white">Home</a></li>
                            <li class="breadcrumb-item"><a href="profile.html" class="text-white">Profile</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Multimedia Pniel</li>
                        </ol>
                    </nav>                
                </div>
            </div>
        </div>
    </div>

    <!-- Content Start -->
    <div class="container py-5">
        <!-- Sejarah & Visi Misi -->
        <div class="row mb-5" data-aos="fade-up">
    
            <!-- Sejarah Multimedia -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="fas fa-history fa-3x text-primary mb-3"></i>
                            <h3 style="font-family: Montserrat; font-weight: 700; color: #212529;">Sejarah Multimedia</h3>
                        </div>
                        <p class="text-muted mb-3" style="text-align: justify; line-height: 1.8;">
                            Tim Multimedia GKI Pniel Kotaraja dibentuk pada tahun 2018 dengan visi untuk mendukung pelayanan gereja melalui teknologi modern. Berawal dari kebutuhan dokumentasi kegiatan gereja, tim ini berkembang menjadi bagian integral dalam setiap ibadah dan acara gereja.
                        </p>
                        <p class="text-muted mb-3" style="text-align: justify; line-height: 1.8;">
                            Dengan semangat melayani, tim multimedia terus berkembang dan belajar teknologi terbaru untuk memberikan pengalaman ibadah yang lebih baik bagi jemaat. Dari sistem sound yang sederhana hingga live streaming dan dokumentasi profesional.
                        </p>
                        <p class="text-muted mb-0" style="text-align: justify; line-height: 1.8;">
                            Hingga kini, tim multimedia telah menjadi tulang punggung teknis dalam setiap kegiatan gereja, mendukung penyebaran firman Tuhan melalui media digital dan teknologi informasi.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Visi & Misi -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="fas fa-bullseye fa-3x text-success mb-3"></i>
                            <h3 style="font-family: Montserrat; font-weight: 700; color: #212529;">Visi & Misi</h3>
                        </div>
                        
                        <!-- Visi -->
                        <div class="mb-4">
                            <h5 class="text-primary mb-3" style="font-family: Montserrat; font-weight: 600;">
                                <i class="fas fa-eye me-2"></i>Visi
                            </h5>
                            <p class="text-muted" style="text-align: justify; line-height: 1.8;">
                                Menjadi tim multimedia yang profesional dan berkomitmen dalam mendukung pelayanan gereja melalui teknologi modern untuk kemuliaan nama Tuhan.
                            </p>
                        </div>

                        <!-- Misi -->
                        <div>
                            <h5 class="text-primary mb-3" style="font-family: Montserrat; font-weight: 600;">
                                <i class="fas fa-rocket me-2"></i>Misi
                            </h5>
                            <ul class="text-muted" style="line-height: 1.8;">
                                <li class="mb-2">Menyediakan dukungan teknis berkualitas untuk setiap ibadah dan kegiatan gereja</li>
                                <li class="mb-2">Mendokumentasikan setiap momen penting dalam kehidupan bergereja</li>
                                <li class="mb-2">Mengembangkan platform digital untuk memperluas jangkauan pelayanan</li>
                                <li class="mb-2">Melatih dan mengembangkan SDM di bidang multimedia gereja</li>
                                <li class="mb-0">Melayani dengan hati yang tulus untuk kemuliaan Tuhan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tim Multimedia -->
        <div class="row" data-aos="fade-up" data-aos-delay="200">
            <div class="col-lg-12 mb-5">
                <h2 class="text-center mb-5" style="font-family: Montserrat; font-weight: 700; color: #212529;">Tim Multimedia Kami</h2>
            </div>
            
            <!-- Baris 1: Anggota 1-3 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center member-card">
                    <div class="card-body p-4">
                        <div class="avatar-container mb-3">
                            <img src="img/logo-judul.png" alt="Member 1" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <h5 class="mb-2" style="font-family: Montserrat; font-weight: 600;">Billy Taudufu</h5>
                        <p class="text-muted mb-2">Sekretaris</p>
                        <div class="mt-3">
                            <i class="fas fa-camera fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center member-card">
                    <div class="card-body p-4">
                        <div class="avatar-container mb-3">
                            <img src="img/bg-par.jpg" alt="Member 2" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <h5 class="mb-2" style="font-family: Montserrat; font-weight: 600;">Kelly Soor</h5>
                        <p class="text-muted mb-2">Koordinator</p>
                        <div class="mt-3">
                            <i class="fas fa-desktop fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center member-card">
                    <div class="card-body p-4">
                        <div class="avatar-container mb-3">
                            <img src="img/bg-par.jpg" alt="Member 3" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <h5 class="mb-2" style="font-family: Montserrat; font-weight: 600;">Nella Wally</h5>
                        <p class="text-muted mb-2">Bendahara</p>
                        <div class="mt-3">
                        <i class="fas fa-video fa-2x text-danger"></i> 
                        </div>
                    </div>
                </div>
            </div>

            <!-- Baris 2: Anggota 4-6 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center member-card">
                    <div class="card-body p-4">
                        <div class="avatar-container mb-3">
                            <img src="img/bg-par.jpg" alt="Member 4" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <h5 class="mb-2" style="font-family: Montserrat; font-weight: 600;">Nuel Meraudje</h5>
                        <p class="text-muted mb-2">Kameraman</p>
                        <div class="mt-3">
                            <i class="fas fa-video fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center member-card">
                    <div class="card-body p-4">
                        <div class="avatar-container mb-3">
                            <img src="img/bg-par.jpg" alt="Member 5" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <h5 class="mb-2" style="font-family: Montserrat; font-weight: 600;">Reynaldo Retraubun</h5>
                        <p class="text-muted mb-2">Kameraman</p>
                        <div class="mt-3">
                            <i class="fas fa-video fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center member-card">
                    <div class="card-body p-4">
                        <div class="avatar-container mb-3">
                            <img src="img/bg-par.jpg" alt="Member 6" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <h5 class="mb-2" style="font-family: Montserrat; font-weight: 600;">Greath</h5>
                        <p class="text-muted mb-2">Kameraman & Fotografer</p>
                        <div class="mt-3">
                            <i class="fas fa-video fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Baris 3: Anggota 7-9 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center member-card">
                    <div class="card-body p-4">
                        <div class="avatar-container mb-3">
                            <img src="img/bg-par.jpg" alt="Member 7" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <h5 class="mb-2" style="font-family: Montserrat; font-weight: 600;">Pricilia Ardani</h5>
                        <p class="text-muted mb-2">Kameraman</p>
                        <div class="mt-3">
                            <i class="fas fa-video fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center member-card">
                    <div class="card-body p-4">
                        <div class="avatar-container mb-3">
                            <img src="img/bg-par.jpg" alt="Member 8" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <h5 class="mb-2" style="font-family: Montserrat; font-weight: 600;">Dawson Sermumes</h5>
                        <p class="text-muted mb-2">Kameraman</p>
                        <div class="mt-3">
                            <i class="fas fa-video fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center member-card">
                    <div class="card-body p-4">
                        <div class="avatar-container mb-3">
                            <img src="img/bg-par.jpg" alt="Member 9" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <h5 class="mb-2" style="font-family: Montserrat; font-weight: 600;">Miseri</h5>
                        <p class="text-muted mb-2">Kameraman</p>
                        <div class="mt-3">
                            <i class="fas fa-video fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Baris 4: Anggota 10-12 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center member-card">
                    <div class="card-body p-4">
                        <div class="avatar-container mb-3">
                            <img src="img/bg-par.jpg" alt="Member 10" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <h5 class="mb-2" style="font-family: Montserrat; font-weight: 600;">Quantico Meraudje</h5>
                        <p class="text-muted mb-2">Sound Man</p>
                        <div class="mt-3">
                            <i class="fas fa-headphones fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center member-card">
                    <div class="card-body p-4">
                        <div class="avatar-container mb-3">
                            <img src="img/bg-par.jpg" alt="Member 11" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <h5 class="mb-2" style="font-family: Montserrat; font-weight: 600;">Rein Swabra</h5>
                        <p class="text-muted mb-2">Sound Man</p>
                        <div class="mt-3">
                            <i class="fas fa-headphones fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center member-card">
                    <div class="card-body p-4">
                        <div class="avatar-container mb-3">
                            <img src="img/bg-par.jpg" alt="Member 12" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <h5 class="mb-2" style="font-family: Montserrat; font-weight: 600;">Chrisya Salamahu</h5>
                        <p class="text-muted mb-2">Sound Man</p>
                        <div class="mt-3">
                            <i class="fas fa-headphones fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Baris 5: Anggota 13-15 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center member-card">
                    <div class="card-body p-4">
                        <div class="avatar-container mb-3">
                            <img src="img/bg-par.jpg" alt="Member 13" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <h5 class="mb-2" style="font-family: Montserrat; font-weight: 600;">Adriano Affar</h5>
                        <p class="text-muted mb-2">VMix Operator & Designer</p>
                        <div class="mt-3">
                            <i class="fas fa-desktop fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center member-card">
                    <div class="card-body p-4">
                        <div class="avatar-container mb-3">
                            <img src="img/bg-par.jpg" alt="Member 14" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <h5 class="mb-2" style="font-family: Montserrat; font-weight: 600;">Nikita</h5>
                        <p class="text-muted mb-2">EW Operator</p>
                        <div class="mt-3">
                            <i class="fas fa-desktop fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm text-center member-card">
                    <div class="card-body p-4">
                        <div class="avatar-container mb-3">
                            <img src="img/bg-par.jpg" alt="Member 15" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                        <h5 class="mb-2" style="font-family: Montserrat; font-weight: 600;">Jeremi Swabra</h5>
                        <p class="text-muted mb-2">EW Operator</p>
                        <div class="mt-3">
                            <i class="fas fa-desktop fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content End -->
    
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
    <!-- Footer End -->

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        AOS.init();
    </script>    
</body>
</html>