<?php
// config/database.php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "grafik_jemaat"; // nama database kamu

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
