<?php
include 'koneksi.php';  // Pastikan file koneksi sudah benar

// Cek apakah data telah dikirimkan dari form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'update') {
        $id = $_POST['id_lokasi'];
        $nama = $_POST['namalokasi'];
        $alamat = $_POST['alamat'];
        $latitude = $_POST['lat'];
        $longitude = $_POST['lng'];

        // Validasi untuk memastikan data tidak kosong
        if (empty($nama) || empty($alamat) || empty($latitude) || empty($longitude)) {
            echo "Semua kolom harus diisi!";
            exit();  // Menghentikan eksekusi lebih lanjut jika data tidak lengkap
        }

        // Cek apakah ada ID untuk update
        if (!empty($id)) {
            // Update data
            $query = "UPDATE tbl_lokasi SET namalokasi = ?, alamat = ?, lat = ?, lng = ? WHERE id_lokasi = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssdi", $nama, $alamat, $latitude, $longitude, $id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "Data berhasil diperbarui!";
            } else {
                echo "Gagal memperbarui data.";
            }
        } else {
            // Menambahkan data baru
            $query = "INSERT INTO tbl_lokasi (namalokasi, alamat, lat, lng) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssss", $nama, $alamat, $latitude, $longitude);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "Data berhasil ditambahkan!";
            } else {
                echo "Gagal menambahkan data.";
            }
        }
        // Redirect atau update halaman setelah proses
        header("Location: dashboard_admin.php");  // Ganti dengan halaman yang sesuai
        exit();
    } else if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        // Proses hapus data
        $id = $_POST['id_lokasi'];
        $query = "DELETE FROM tbl_lokasi WHERE id_lokasi = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Data berhasil dihapus!";
        } else {
            echo "Gagal menghapus data.";
        }
        header("Location: dashboard_admin.php");  // Ganti dengan halaman yang sesuai
        exit();
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Cek apakah action read untuk mengambil data
    $action = $_POST['action'] ?? '';
    if ($action == 'read') {
        // Query untuk mengambil data lokasi
        $result = $conn->query("SELECT * FROM tbl_lokasi");
        $locations = [];
        
        while ($row = $result->fetch_assoc()) {
            // Menyimpan data dalam array
            $locations[] = [
                'namalokasi' => $row['namalokasi'],
                'alamat' => $row['alamat'],
                'lat' => (float) $row['lat'],  // Pastikan lat dan lng adalah float
                'lng' => (float) $row['lng']
            ];
        }
        
        // Mengembalikan data dalam format JSON
        echo json_encode($locations);
        exit;
    }
}
?>
?>
