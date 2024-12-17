<?php
include 'koneksi.php';
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM data_outlet WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: admin.php?message=Data berhasil dihapus");
    } else {
        echo "Error: " . $conn->error;
    }
}

?>
