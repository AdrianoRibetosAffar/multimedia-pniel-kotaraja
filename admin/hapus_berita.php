`<?php
include('../config/database.php');
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id'];

// Ambil nama gambar
$data = mysqli_query($conn, "SELECT gambar FROM berita WHERE id=$id");
$row = mysqli_fetch_assoc($data);

if ($row) {
    $gambar_path = '../uploads/' . $row['gambar'];
    if (file_exists($gambar_path)) {
        unlink($gambar_path); // Hapus file gambar
    }

    mysqli_query($conn, "DELETE FROM berita WHERE id=$id");
    $_SESSION['success'] = "Berita berhasil dihapus.";
} else {
    $_SESSION['error'] = "Data tidak ditemukan.";
}

header("Location: tambah_berita.php");
exit();