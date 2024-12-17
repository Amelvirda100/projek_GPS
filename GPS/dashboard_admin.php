<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';
include 'proses_delete.php';
include 'proses_update.php';

// Menampilkan data outlet
$result = $conn->query("SELECT * FROM tbl_lokasi");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - CRUD dengan Peta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            background-color: #f5f5f5;
        }

        .logout-btn {
            padding: 10px;
            background-color: #f44336;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: inline-block;
        }

        .logout-btn:hover {
            background-color: #d32f2f;
        }

        .container {
            display: flex;
            flex: 1;
            padding: 20px;
        }

        .form-container {
            width: 50%;
            padding: 20px;
            background-color: #fff;
            margin-right: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .map-container {
            width: 50%;
            height: 400px;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #ddd; /* Menambahkan border atau frame pada peta */
        }

        #map {
            height: 100%;
            width: 100%;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        form input,
        form textarea,
        form button {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        form input[type="text"],
        form textarea {
            width: 100%;
        }

        button {
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            border: none;
        }

        button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>

    <!-- Script Here Maps -->
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />
</head>

<body>

    <div class="container">

        <!-- Form Input Data Lokasi -->
        <div class="form-container">
            <h2>Input Data Tempat SPBU dan Bengkel</h2>
            <form action="crud.php" method="POST">
                <input type="hidden" name="id_lokasi" id="id_lokasi">
                <input type="text" name="namalokasi" id="namalokasi" placeholder="Nama Outlet" required>
                <textarea name="alamat" id="alamat" placeholder="Alamat" required></textarea>
                <input type="text" name="lat" id="lat" placeholder="Latitude" required>
                <input type="text" name="lng" id="lng" placeholder="Longitude" required>
                <button type="submit" name="action" value="update">Simpan</button>
            </form>
            <h3>Daftar Data Tempat SPBU dan Bengkel</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['namalokasi'] ?></td>
                        <td><?= $row['alamat'] ?></td>
                        <td><?= $row['lat'] ?></td>
                        <td><?= $row['lng'] ?></td>
                        <td>
                            <!-- Tombol Edit dengan link di dalamnya -->
                            <a href="edit.php?id_lokasi=<?= $row['id_lokasi'] ?>" style="text-decoration: none;">
                                <button type="button" style="background-color: #007BFF; border: none; padding: 10px 20px; cursor: pointer;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                        <path d="M12.146 0l3.708 3.708a1 1 0 0 1 0 1.414l-8.042 8.042-2.828-2.828 8.042-8.042A1 1 0 0 1 12.146 0zM11.707 4.5L5.5 10.707l-1.5-1.5L10.707 3h.043a1 1 0 0 1 1.414 1.414z"/>
                                    </svg> Edit
                                </button>
                            </a>

                            <!-- Tombol Hapus -->
                            <form action="crud.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id_lokasi" value="<?= $row['id_lokasi'] ?>">
                                <button type="submit" name="action" value="delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Peta untuk Memilih Lokasi -->
        <div class="map-container">
            <div id="map"></div>
        </div>

    </div>

    <a href="logout.php" class="logout-btn">Logout</a>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="script.js"></script>

    <script>
        // Inisialisasi peta
        const map = L.map('map').setView([-7.7956, 110.3695], 13);  // Titik pusat Yogyakarta

        // Tambahkan Tile Layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Load Data dari Database dan tambahkan marker dengan clustering untuk mengurangi beban
        fetch('crud.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'read' })
        })
        .then(response => response.json())
        .then(data => {
            const markers = L.markerClusterGroup();  // Inisialisasi marker cluster

            data.forEach(outlet => {
                // Tentukan warna pin berdasarkan outlet (contoh: warna merah untuk SPBU, hijau untuk bengkel)
                const pinColor = outlet.namalokasi.toLowerCase().includes("spbu") ? 'red' : 'green';
                const marker = L.marker([outlet.lat, outlet.lng], {
                    icon: L.divIcon({
                        className: 'custom-pin',
                        html: `<div style="background-color: ${pinColor}; width: 30px; height: 30px; border-radius: 50%;"></div>`
                    })
                }).bindPopup(`<b>${outlet.namalokasi}</b><br>${outlet.alamat}`);

                markers.addLayer(marker);  // Menambahkan marker ke marker cluster
            });

            map.addLayer(markers);  // Menambahkan marker cluster ke peta
        });

        // Event Klik Peta
        map.on('click', (e) => {
            const { lat, lng } = e.latlng;

            // Set koordinat ke input form
            document.getElementById('lat').value = lat.toFixed(6);
            document.getElementById('lng').value = lng.toFixed(6);
        });

        // Invalidate size setelah load peta untuk menghindari lag pada resize
        map.invalidateSize();
    </script>

</body>

</html>
