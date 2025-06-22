<?php
include('config/database.php');
$berita = mysqli_query($conn, "SELECT * FROM berita ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="img/logo-judul.png" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"> 
    <link rel="stylesheet" href="mulmed.css">
    
    <style>
        /* Custom Gallery Styles */
        .gallery-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
            height: 350px;
        }

        .gallery-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }

        .gallery-card .card-img-top {
            height: 200px;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .gallery-card .card-body {
            padding: 15px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gallery-card .card-title {
            font-size: 20px;
            font-weight: 600;
            margin: 0;
            text-align: center;
            line-height: 1.2;
        }

        /* Hover Overlay with Eye Icon */
        .card-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 200px;
            background: rgba(0,0,0,0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .gallery-card:hover .card-overlay {
            opacity: 1;
        }

        .eye-icon {
            color: white;
            font-size: 2.5rem;
            transition: all 0.3s ease;


        }

        .gallery-card:hover .eye-icon {
            transform: scale(0.7);
            color: #ffcc00; /* Change color on hover */
            
        }
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

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .gallery-card {
                height: 250px;
            }
            .gallery-card .card-img-top {
                height: 170px;
            }
        }
    </style>
</head>
<body>
    
    <!--  Navbar Start-->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand text-white d-flex align-items-center me-auto" href="#">
                <img src="img/logo-mulmed.png" alt="Logo" style="height: 70px; width: auto; margin-right: 5px;">
                <h5 class="mb-0">Multimedia GKI Pniel Kotaraja</h5>
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
                    <h1 class="display-3 text-white text-center">Gallery</h1>                
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <div class="container py-5">
        <h2 class="page-title text-center mb-5">
            Gallery GKI Pniel
        </h2>
        
        <!-- Gallery Grid - 4 cards per row -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php while ($row = mysqli_fetch_assoc($berita)): ?>
            <div class="col" data-aos="fade-up" data-aos-delay="100">
                <div class="card gallery-card shadow-sm" onclick="openDriveLink('<?= isset($row['link_drive']) ? $row['link_drive'] : '#' ?>')">
                    <img src="uploads/<?= $row['gambar'] ?>" class="card-img-top" alt="<?= htmlspecialchars($row['judul']) ?>">
                    
                    <!-- Hover Overlay with Eye Icon -->
                    <div class="card-overlay">
                        <i class="fas fa-eye eye-icon"></i>
                    </div>
                    
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($row['judul']) ?></h5>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
    
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

    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        AOS.init({
            duration: 800,
            once: true
        });

        // Function to open Google Drive link
        function openDriveLink(link) {
            if (link && link !== '#' && link !== '') {
                window.open(link, '_blank');
            } else {
                alert('Link Google Drive belum tersedia untuk item ini.');
            }
        }

        // Add click sound effect (optional)
        document.querySelectorAll('.gallery-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.cursor = 'pointer';
            });
        });
    </script>    
</body>
</html>