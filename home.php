<?php
include('config/database.php');

$berita = mysqli_query($conn, "SELECT * FROM berita ORDER BY id DESC LIMIT 6");
$statistik = mysqli_query($conn, "SELECT * FROM rayon");

// Untuk Chart
$nama_rayon = [];
$jumlah_jemaat = [];
$total_jemaat = 0;

while ($row = mysqli_fetch_assoc($statistik)) {
    $nama_rayon[] = $row['nama_rayon'];
    $jumlah_jemaat[] = $row['jumlah_jemaat'];
    $total_jemaat += $row['jumlah_jemaat'];
}

// Ambil link terbaru
$query = mysqli_query($conn, "SELECT * FROM live_streaming LIMIT 1");
$streaming = mysqli_fetch_assoc($query);
$link_youtube = $streaming['link_youtube'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multimedia GKI Pniel Kotaraja</title>
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
    <link rel="stylesheet" href="mulmed.css">
    <style>     
        .page-title {
            text-align: center;
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 30px;
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
                <ul class="navbar-nav text-uppercase ms-auto py-1 py-lg-0">
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
    
    <!-- Masthead-->
    <header class="masthead">
        <div class="container">
            <div class="masthead-heading " data-aos="fade-right"  data-aos-duration="1000">Selamat Datang!
                <br>
                <p class="masthead-subheading">Di Website Multimedia GKI Pniel Kotaraja</p>
            </div>
            <a class="btn btn-primary" data-aos="zoom-in"  data-aos-duration="1000" href="gallery.php">Cek Gallery</a>
        </div>
    </header>
    
    <section class="py-5 ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="card-info col-md-6 col-lg-6 col-xs-20 py-4" data-aos="fade-up" data-aos-duration="1000"  >
                    <h2 style="font-size:xx-large; font-weight: bolder; font-family: Montserrat">Selamat Datang di</h2>
                    <h3 style="font-size:x-large; font-weight: bolder; font-family: Montserrat">Multimedia GKI Pniel Kotaraja</h3>
                    <p>
                        Puji syukur patut kita persembahkan kepada Tuhan Yesus Kristus Kepala Gereja Kristen Injili di Tanah Papua atas kasih dan penyertaan serta perkenan-Nya, 
                        sehingga pembuatan Website Multimedia GKI Pniel Kotaraja ini dapat terwujud
                    </p>
                    <p>
                        Website Multimedia GKI Pniel ini dimaksudkan untuk memberikan suatu gambaran tentang perjalanan, 
                        keadaan dan situasi serta kondisi Jemaat GKI Pniel Kotaraja agar anggota Jemaat dan semua yang berkepentingan dapat mengetahui infomasi secara online dengan baik...
                    </p>
                    <p class="" style="font-weight:700;">
                        Motto: <br> Kolose 3 : 23 "Apa pun juga yang kamu perbuat, perbuatlah dengan segenap hatimu seperti untuk Tuhan dan bukan untuk manusia."
                    </p>            
                    <div class="mt-3 mb-3">
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Baca lengkap                            
                        </button>
                    </div>
                </div>
                <div class="col-md-6" data-aos="fade-up" data-aos-duration="1000">
            <h1 class="text-center mb-4" style="font-size:xx-large; font-weight: bolder; font-family: Montserrat">Live Streaming</h1>
        <div class="ratio ratio-16x9">
        <iframe width="560" height="315" 
            src="<?= htmlspecialchars($link_youtube); ?>" 
            title="YouTube video player" frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
        </iframe>                    
        </div>
        <div class="text-center">
        <br><a href="<?= str_replace('embed/', 'watch?v=', $link_youtube); ?>" target="_blank" class="stream btn btn-danger">
            Ikuti Sekarang
        </a>
        </div>                
            </div>
        </div>
</section>

<div class="container py-3">       
    <div class="row text-center" data-aos="fade-up" data-aos-duration="1000">
        <h2 class="page-title text-center" style="font-size:xx-large; font-weight: bolder; font-family: Montserrat">
            JADWAL IBADAH UMUM
        </h2>
        <br>

        <?php
        $result = mysqli_query($conn, "SELECT * FROM jadwal_ibadah");
        while ($row = mysqli_fetch_assoc($result)) :
        ?>
            <div class="col-md-4 mb-4">
                <div class="card schedule-card shadow-sm">
                    <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center text-white">
                        <h5 class="text-uppercase fw-bold"> <?= htmlspecialchars($row['hari']) ?> </h5>
                        <p class="mb-0"><?= htmlspecialchars($row['judul']) ?></p>
                        <p class="time"><?= htmlspecialchars($row['jam']) ?></p>
                    </div>
                    <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" class="card-img" alt="<?= htmlspecialchars($row['judul']) ?>">

                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
    
<div class="container py-3">
    <div class="row text-center" data-aos="fade-up" data-aos-duration="1000">
        <h2 class="page-title text-center mb-5" style="font-weight: bolder; font-family: Montserrat;">
            Gallery GKI Pniel
        </h2>
        <div class="row equal-height-row">
            <?php while ($row = mysqli_fetch_assoc($berita)): ?>
            <div class="col-md-4 mb-4 d-flex">
                <div class="card w-100">                    
                    <img src="uploads/<?= $row['gambar'] ?>" class="card-img-top" alt="gambar berita" style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-center" style="min-height: 60px; display: flex; align-items: center; justify-content: center;">
                            <?= htmlspecialchars($row['judul']) ?>
                        </h5>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
            <div class="text-center mt-auto">
                <a href="gallery.php" class="btn btn-outline-dark">Selengkapnya</a>
            </div>
        </div>
    </div>
</div>

    <!-- Statistik Jemaat Start -->
<div class="container my-5">
    <div class="row text-center" data-aos="fade-up" data-aos-duration="1000">
    <h2 class="page-title text-center mb-5" style="font-weight: bolder; font-family: Montserrat;">
    Statistik Jemaat</h2>
        <div class="col-md-6">
            <canvas id="statistikDonut" style="height:500px; width:500px;"></canvas>
        </div>
        <div class="col-md-6">
            <h4>Total Jumlah Jemaat: <?= $total_jemaat; ?></h4>
            <table class="table table-bordered table-striped mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Rayon</th>
                        <th>Jumlah Jemaat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($nama_rayon as $index => $rayon): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($rayon); ?></td>
                        <td><?= $jumlah_jemaat[$index]; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
    <!-- Statistik Jemaat End -->

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

    <!-- Modal -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        AOS.init();
      </script>
    <script src="js/script.js"></script>
    <script>
    const ctx = document.getElementById('statistikDonut').getContext('2d');
    const statistikDonut = new Chart(ctx, {
        type: "bar",
        data: {
            labels: <?= json_encode($nama_rayon); ?>, // Array label nama rayon dari PHP
                datasets: [{
                    label: 'Jumlah Jemaat', // Label dataset agar tidak "undefined"
                data: <?= json_encode($jumlah_jemaat); ?>, // Array jumlah jemaat dari PHP
                backgroundColor: [
                    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796',
                    '#2e59d9', '#17a673', '#2c9faf', '#f4b619', '#e64a19', '#5d4037',
                    '#7b1fa2', '#1976d2', '#388e3c', '#c2185b'
                ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Jumlah Jemaat per Rayon',
                    font: {
                        size: 18
                    }
                },
                legend: {
                    display: false // Sembunyikan legenda jika tidak diperlukan
                },
                tooltip: {
                    enabled: true,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Jemaat'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Rayon'
                    }
                }
            }
        }
    });
    // Navbar scroll effect
window.addEventListener('scroll', function() {
    const navbar = document.getElementById('mainNav');
    if (window.scrollY > 50) {
        navbar.classList.add('navbar-scrolled');
    } else {
        navbar.classList.remove('navbar-scrolled');
    }
});

// Smooth scrolling untuk anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
</script>


</body>
</html>