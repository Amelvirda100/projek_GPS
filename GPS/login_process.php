<?php
session_start();
require 'koneksi.php'; // File koneksi ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validasi input
    if (empty($username) || empty($password)) {
        $_SESSION['error_message'] = 'Username dan Password wajib diisi.';
        header('Location: login.php');
        exit;
    }

    // Query ke database menggunakan mysqli
    $stmt = $conn->prepare("SELECT username, password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Periksa kecocokan username dan password
    if ($user && $password === $user['password']) {
        // Jika login berhasil
        $_SESSION['username'] = $user['username'];
        header('Location: dashboard_admin.php');
        exit;
    } else {
        // Jika login gagal
        $_SESSION['error_message'] = 'Username atau Password salah.';
        header('Location: login.php');
        exit;
    }

    $stmt->close(); // Tutup statement
} else {
    // Jika akses langsung ke file ini
    header('Location: login.php');
    exit;
}
?>
