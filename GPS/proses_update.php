<?php
include 'koneksi.php';
if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $id = $_POST['id_lokasi'];
    $nama = $_POST['namalokasi'];
    $alamat = $_POST['alamat'];
    $latitude = $_POST['lat'];
    $longitude = $_POST['lng'];

    $stmt = $conn->prepare("UPDATE tbl_lokasi SET namalokasi = ?, alamat = ?, lat = ?, long = ? WHERE id_lokasi = ?");
    $stmt->bind_param("sssdi", $nama, $alamat, $latitude, $longitude, $id);

    if ($stmt->execute()) {
        echo "Data berhasil diperbarui!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
