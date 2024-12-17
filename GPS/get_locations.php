<?php
include 'koneksi.php'; // Pastikan file koneksi benar

header('Content-Type: application/json');

// Query untuk mengambil data lokasi
$sql = "SELECT id_lokasi, namalokasi, alamat, lat, lng FROM tbl_lokasi";
$result = $conn->query($sql);

$locations = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $locations[] = [
            'id_lokasi' => $row['id_lokasi'],
            'namalokasi' => $row['namalokasi'],
            'alamat' => $row['alamat'],
            'lat' => (float) $row['lat'],
            'lng' => (float) $row['lng']
        ];
    }
}

// Debug: Tampilkan data ke browser
echo json_encode($locations, JSON_PRETTY_PRINT);
$conn->close();
?>
