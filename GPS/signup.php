<?php

session_start();

include 'koneksi.php';  // Include koneksi database


// Cek jika sudah login

if (isset($_SESSION['username'])) {

    header("Location: dashboard_admin.php");

    exit;

}


$error_message = '';

$success_message = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];

    $password = $_POST['password'];

    $name = $_POST['name'];


    // Cek apakah username sudah ada

    $query = $conn->prepare("SELECT * FROM admin WHERE username = ?");

    $query->bind_param("s", $username);

    $query->execute();

    $result = $query->get_result();


    if ($result->num_rows > 0) {

        $error_message = 'Username sudah terdaftar. Silakan pilih username lain.';

    } else {

        // Menyimpan data admin baru ke database tanpa hashing password

        $insert_query = $conn->prepare("INSERT INTO admin (username, password, nama) VALUES (?, ?, ?)");

        $insert_query->bind_param("sss", $username, $password, $name);


        if ($insert_query->execute()) {

            $success_message = 'Pendaftaran berhasil! Silakan login.';

        } else {

            $error_message = 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.';

        }

    }

}

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sign Up Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>

        body {

            font-family: 'Roboto', sans-serif;

            display: flex;

            justify-content: center;

            align-items: center;

            height: 100vh;

            margin: 0;

            background-color: #e9ecef;

        }

        .signup-container {

            background: #ffffff;

            padding: 30px;

            border-radius: 8px;

            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);

            width: 100%;

            max-width: 400px;

        }

        .signup-container h1 {

            text-align: center;

            margin-bottom: 20px;

            color: #343a40;

        }

        .form-group {

            margin-bottom: 20px;

        }

        .form-group label {

            display: block;

            margin-bottom: 5px;

            color: #495057;

        }

        .form-group input {

            width: 100%;

            padding: 10px;

            border: 1px solid #ced4da;

            border-radius: 4px;

            box-sizing: border-box;

            transition: border-color 0.3s;

        }

        .form-group input:focus {

            border-color: #007bff;

            outline: none;

        }

        .form-group button {

            width: 100%;

            padding: 10px;

            background: #007bff;

            color: #ffffff;

            border: none;

            border-radius: 4px;

            cursor: pointer;

            transition: background 0.3s;

        }

        .form-group button:hover {

            background: #0056b3;

        }

        .error {

            color: red;

            margin-bottom: 15px;

            text-align: center;

        }

        .success {

            color: green;

            margin-bottom: 15px;

            text-align: center;

        }

    </style>

</head>

<body>

    <div class="signup-container">

        <h1>Sign Up Admin</h1>

        <?php if (!empty($error_message)): ?>

            <p class="error"><?php echo $error_message; ?></p>

        <?php endif; ?>

        <?php if (!empty($success_message)): ?>

            <p class="success"><?php echo $success_message; ?></p>

        <?php endif; ?>

        <form method="POST">

            <div class="form-group">

                <label for="name">Nama</label>

                <input type="text" id="name" name="name" placeholder="Masukkan nama" required>

            </div>

            <div class="form-group">

                <label for="username">Username</label>

                <input type="text" id="username" name="username" placeholder="Masukkan username" required>

            </div>

            <div class="form-group">

                <label for="password">Password</label>

                <input type="password" id="password" name="password" placeholder="Masukkan password" required>

            </div>

            <div class="form-group">

                <button type="submit">Daftar</button>

            </div>

        </form>

        <p style="text-align: center;">Sudah punya akun? <a href="login.php">Login di sini</a></p>

    </div>

</body>

</html>