<?php
session_start();
include 'koneksi.php';

$id = $_SESSION['admin_id'];
$nama = $_POST['nama'];
$username = $_POST['username'];
$password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

$foto = null;
if ($_FILES['foto']['name']) {
    $foto = 'uploads/' . basename($_FILES['foto']['name']);
    move_uploaded_file($_FILES['foto']['tmp_name'], $foto);
}

$query = "UPDATE admin SET nama = ?, username = ?";
if ($password) $query .= ", password = ?";
if ($foto) $query .= ", foto = ?";
$query .= " WHERE id = ?";

$stmt = $conn->prepare($query);

if ($password && $foto) {
    $stmt->bind_param("ssssi", $nama, $username, $password, $foto, $id);
} elseif ($password) {
    $stmt->bind_param("sssi", $nama, $username, $password, $id);
} elseif ($foto) {
    $stmt->bind_param("sssi", $nama, $username, $foto, $id);
} else {
    $stmt->bind_param("ssi", $nama, $username, $id);
}

$stmt->execute();
echo json_encode(['success' => true]);
?>
