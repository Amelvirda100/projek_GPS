<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: dashboard_admin.php");
    exit;
}

$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['error_message']); // Hapus pesan error setelah ditampilkan
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
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
        .login-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-container h1 {
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
    </style>
</head>

<body>
    <div class="login-container" >
        <h1>Login Admin</h1>
        <?php if (!empty($error_message)): ?>
            <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <form action="login_process.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>
            <div class="form-group">
                <button type="submit">Login</button>
            </div>
        </form>
        <p>Belum punya akun? <a href="signup.php">Daftar di sini</a>.</p>
        <p class="signup-link">Bukan Admin? <a href="dashboard.html">Klik di sini untuk menuju dashboard.</a></p>
    </div>
</body>

</html>
