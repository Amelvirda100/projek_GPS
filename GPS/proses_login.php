<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Menyiapkan query untuk mengambil data admin berdasarkan username
$query = $conn->prepare("SELECT * FROM admin WHERE username = ?");
$query->bind_param("s", $username);
$query->execute();
$result = $query->get_result();
$admin = $result->fetch_assoc();

// Memverifikasi password dan mengecek apakah data admin ditemukan
if ($admin && password_verify($password, $admin['password'])) {
    // Menyimpan data admin ke session
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_name'] = $admin['nama'];
    $_SESSION['admin_photo'] = $admin['foto'];

    // Mengarahkan ke halaman dashboard_admin.php
    header("Location: dashboard_admin.php");
    exit;
} else {
    // Jika login gagal, kirimkan pesan error
    echo json_encode(['eror' => false, 'message' => 'Username atau password salah']);
}
?>
