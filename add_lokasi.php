<?php
include 'koneksi.php';

$action = $_POST['action'];

if ($action == 'create') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    $stmt = $conn->prepare("INSERT INTO data_outlet (nama, alamat, latitude, longitude) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdd", $nama, $alamat, $latitude, $longitude);
    $stmt->execute();
    echo json_encode(['success' => true]);
} elseif ($action == 'read') {
    $result = $conn->query("SELECT * FROM data_outlet");
    $data = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($data);
}elseif ($action == 'update') {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
    
        $stmt = $conn->prepare("UPDATE data_outlet SET nama = ?, alamat = ?, latitude = ?, longitude = ? WHERE id = ?");
        $stmt->bind_param("sssdi", $nama, $alamat, $latitude, $longitude, $id);
    
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
    }
    elseif ($action == 'delete') {
        $id = $_POST['id'];
    
        $stmt = $conn->prepare("DELETE FROM data_outlet WHERE id = ?");
        $stmt->bind_param("i", $id);
    
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
    }
?>
