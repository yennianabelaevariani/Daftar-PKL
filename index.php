<?php
require 'koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validasi input
    if (empty($email) || empty($password)) {
        $error = 'Email dan password tidak boleh kosong!';
    } else {
        // Cek kredensial login
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id']; // Menyimpan ID pengguna di session
                header('Location: pendaftaran.php'); // Arahkan ke halaman profile
                exit;
            } else {
                $error = 'Password salah!';
            }
        } else {
            $error = 'Email tidak ditemukan!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            border-radius: 14px;
            padding: 0px;
            width: 100%;
            max-width: 360px;
            text-align: center;
        }

        .sign__form {
            padding: 80px 50px;
        }

        .sign__group {
            margin-bottom: 29px;
            position: relative;
        }

        .sign__input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #44434c;
            border-radius: 8px;
            background-color: #1a191f;
            color: #fff;
            font-size: 14px;
            box-sizing: border-box;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .sign__input::placeholder {
            color: #88878f;
        }

        .sign__input:focus {
            outline: none;
            border-color: #f9ab00;
            box-shadow: 0 0 5px rgba(249, 171, 0, 0.7);
        }

        .sign__btn {
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
            margin-bottom: 20px;
        }

        .sign__btn:hover {
            background-color: rgba(249, 171, 0, 0.1);
            transform: scale(1.02);
        }

        .sign__delimiter {
            color: #88878f;
            font-size: 14px;
            margin: 15px 10;
        }

        .sign__text {
            font-size: 14px;
            color: #fff;
        }

        .sign__text a {
            color: #f9ab00;
            text-decoration: none;
            margin-top: 20px;
        }

        .sign__text a:hover {
            text-decoration: underline;
        }

        .error {
            color: #ff4c4c;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>

</head>

<body>

    <div class="container">
        <?php if (isset($error)) {
            echo "<p class='error'>$error</p>";
        } ?>
        <form action="" class="sign__form" method="post">
            <div class="sign__group">
                <input type="text" class="sign__input" name="email" placeholder="Email" required>
            </div>
            <div class="sign__group">
                <input type="password" class="sign__input" name="password" placeholder="Password" required>
            </div>
            <button class="sign__btn" type="submit">Sign in</button>
            <span class="sign__delimiter">or</span>
            <span class="sign__text">Belum punya akun? <a href="register.php">Sign up!</a></span>pendsf
        </form>
    </div>

</body>

</html>