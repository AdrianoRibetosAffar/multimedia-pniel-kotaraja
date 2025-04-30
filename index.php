<?php
include('config/database.php');

$berita = mysqli_query($conn, "SELECT * FROM berita ORDER BY id DESC");
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
    <title>Statistik Jemaat</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"> 
    <link rel="stylesheet" href="css/index.css">
</head>
<body>

<div class="container py-3">       
    <div class="row text-center" data-aos="fade-up" data-aos-duration="1000">
        <h2 class="text-center" style="font-size:xx-large; font-weight: bolder; font-family: Montserrat">
            JADWAL IBADAH GKI PNIEL KOTARAJA
        </h2> 
        <br>

        <?php
        $result = mysqli_query($conn, "SELECT * FROM jadwal_ibadah");
        while ($row = mysqli_fetch_assoc($result)) :
        ?>
            <div class="col-md-4 mb-4">
                <div class="card schedule-card shadow-sm">
                    <div class="card-img-overlay d-flex flex-column justify-content-center align-items-center text-white">
                        <h5 class="text-uppercase fw-bold"><?= htmlspecialchars($row['hari']) ?></h5>
                        <p class="mb-0"><?= htmlspecialchars($row['judul']) ?></p>
                        <p class="time"><?= htmlspecialchars($row['jam']) ?></p>
                    </div>
                    <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" class="card-img" alt="<?= htmlspecialchars($row['judul']) ?>">

                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<div class="container py-5">
        <h2 class="text-center mb-5" style="font-weight: bolder; font-family: Montserrat;">
            Gallery GKI Pniel
        </h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php while ($row = mysqli_fetch_assoc($berita)): ?>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="uploads/<?= $row['gambar'] ?>" class="card-img-top" alt="gambar berita">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title text-center"><?= htmlspecialchars($row['judul']) ?></h5>
                        <div class="text-center mt-3">
                            <a href="#" class="btn btn-outline-dark">Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
</div>


<div class="container my-5">
    <h2 class="text-center mb-4">Statistik Jemaat</h2>
    <div class="row">
        <div class="col-md-6">
            <canvas id="statistikDonut" style="height:300px"></canvas>
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

    <div class="row">
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
</div>

<script>
const ctx = document.getElementById('statistikDonut').getContext('2d');
const statistikDonut = new Chart(ctx, {
    type: "bar",
    data: {
        labels: <?= json_encode($nama_rayon); ?>,
        datasets: [{
            data: <?= json_encode($jumlah_jemaat); ?>,
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
                display: false // <- ini supaya tidak muncul legenda
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
        AOS.init();
</script>
</body>
</html>
