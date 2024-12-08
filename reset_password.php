<?php
require 'koneksi.php';
$error = ''; // Menambahkan variabel error

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Cek apakah token valid dan belum kedaluwarsa
    $stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_token_expire = NOW() + INTERVAL 1 HOUR WHERE email = ?");
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            // Validasi input
            if (empty($new_password) || empty($confirm_password)) {
                $error = 'Password baru dan konfirmasi password tidak boleh kosong!';
            } elseif ($new_password !== $confirm_password) {
                $error = 'Password baru tidak cocok!';
            } else {
                // Update password
                $new_password_hash = password_hash($new_password, PASSWORD_BCRYPT);
                $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expire = NULL WHERE reset_token = ?");
                $stmt->bind_param('ss', $new_password_hash, $token);
                $stmt->execute();

                echo "<p>Password Anda berhasil diperbarui!</p>";
            }
        }
    } else {
        $error = "Token tidak ditemukan!";
    }
} else {
    $error = "Token tidak ditemukan!";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1a191f;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }

        .container {
            background-color: #222028;
            border-radius: 12px;
            padding: 30px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .reset-password-form {
            width: 100%;
        }

        .reset-password-form h2 {
            color: #f9ab00;
            margin-bottom: 20px;
        }

        .reset-password-form label {
            font-size: 14px;
            color: #fff;
            display: block;
            margin-bottom: 8px;
        }

        .reset-password-form input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #44434c;
            border-radius: 8px;
            background-color: #1a191f;
            color: #fff;
            font-size: 14px;
            box-sizing: border-box;
            margin-bottom: 24px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .reset-password-form input::placeholder {
            color: #88878f;
        }

        .reset-password-form input:focus {
            outline: none;
            border-color: #f9ab00;
            box-shadow: 0 0 5px rgba(249, 171, 0, 0.7);
        }

        .reset-password-form button {
            width: 100%;
            padding: 12px;
            border: 2px solid #f9ab00;
            background-color: transparent;
            color: #fff;
            font-size: 14px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .reset-password-form button:hover {
            background-color: rgba(249, 171, 0, 0.1);
            transform: scale(1.02);
        }

        .error {
            color: #ff4c4c;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="reset-password-form">
            <h2>Reset Password</h2>
            <?php if (!empty($error)) {
                echo "<p class='error'>$error</p>";
            } ?>
            <form method="POST">
                <div class="sign__group">
                    <input type="password" placeholder="Password Baru" name="new_password" required><br>
                </div>
                <div class="sign__group">
                    <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required><br>
                </div>
                <button type="submit" class="sign__btn">Reset Password</button>
            </form>
        </div>
    </div>

</body>

</html>