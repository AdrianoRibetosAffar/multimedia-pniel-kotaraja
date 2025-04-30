<?php
include('../config/database.php');
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: tambah_jadwal.php");
    exit();
}

// Ambil nama file gambar
$result = mysqli_query($conn, "SELECT gambar FROM jadwal_ibadah WHERE id=$id");
$data = mysqli_fetch_assoc($result);

// Hapus gambar dari folder
$gambar_path = '../uploads/' . $data['gambar'];
if (file_exists($gambar_path)) {
    unlink($gambar_path);
}

// Hapus data dari database
$query = mysqli_query($conn, "DELETE FROM jadwal_ibadah WHERE id=$id");

if ($query) {
    $_SESSION['success'] = "Jadwal berhasil dihapus!";
} else {
    $_SESSION['error'] = "Gagal menghapus data.";
}

header("Location: tambah_jadwal.php");
exit();
