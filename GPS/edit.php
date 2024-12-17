<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

// Periksa apakah id_lokasi tersedia di URL
if (isset($_GET['id_lokasi'])) {
    $id_lokasi = $_GET['id_lokasi'];

    // Ambil data berdasarkan ID lokasi yang dikirim via URL
    $result = $conn->query("SELECT * FROM tbl_lokasi WHERE id_lokasi = $id_lokasi");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        // Jika id_lokasi tidak ditemukan, redirect ke halaman dashboard atau error
        header("Location: dashboard_admin.php");
        exit;
    }
} else {
    // Jika id_lokasi tidak ada di URL, redirect ke dashboard atau halaman lain yang sesuai
    header("Location: dashboard_admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Tempat SPBU dan Bengkel</title>
    <style>
        /* Reset margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body style */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            color: #333;
            padding: 20px;
        }

        /* Header style */
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        /* Form container */
        form {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Back to Dashboard link */
        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            font-size: 16px;
        }

        .back-link a {
            text-decoration: none;
            color: #007bff;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2>Edit Data Tempat SPBU dan Bengkel</h2>

<!-- Form untuk mengedit data outlet -->
<form action="crud.php" method="POST">
    <input type="hidden" name="id_lokasi" value="<?= $row['id_lokasi'] ?>">

    <label for="namalokasi">Nama Outlet:</label>
    <input type="text" name="namalokasi" id="namalokasi" value="<?= $row['namalokasi'] ?>" required>

    <label for="alamat">Alamat:</label>
    <textarea name="alamat" id="alamat" required><?= $row['alamat'] ?></textarea>

    <label for="lat">Latitude:</label>
    <input type="text" name="lat" id="lat" value="<?= $row['lat'] ?>" required>

    <label for="lng">Longitude:</label>
    <input type="text" name="lng" id="lng" value="<?= $row['lng'] ?>" required>

    <button type="submit" name="action" value="update">Update</button>
</form>

<!-- Link untuk kembali ke Dashboard -->
<div class="back-link">
    <a href="dashboard_admin.php">Kembali ke Dashboard</a>
</div>

</body>
</html>
