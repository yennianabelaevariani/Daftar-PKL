<?php
require 'koneksi.php';
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Redirect ke halaman login jika belum login
    exit;
}

// Ambil user ID dari session
$id = $_SESSION['user_id'];
$error = '';
$success = '';

// Ambil data user saat ini dari database
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Data user tidak ditemukan.";
    exit;
}

// Proses update profile jika form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Validasi input
    if (empty($name) || empty($email)) {
        $error = 'Nama dan Email tidak boleh kosong!';
    } else {
        // Update data user
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $stmt->bind_param('ssi', $name, $email, $id);

        if ($stmt->execute()) {
            $success = 'Profil berhasil diperbarui!';
            // Perbarui data di session
            $_SESSION['user_name'] = $name;
        } else {
            $error = 'Terjadi kesalahan saat memperbarui profil.';
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Profile</title>
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

        .edit-form {
            background-color: #222028;
            padding: 30px;
            border-radius: 12px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .edit-form h2 {
            color: #f9ab00;
            margin-bottom: 20px;
        }

        .edit-form label {
            display: block;
            margin-top: 10px;
            font-size: 14px;
            color: #fff;
        }

        .edit-form input {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            border: 1px solid #44434c;
            border-radius: 8px;
            background-color: #1a191f;
            color: #fff;
            font-size: 14px;
        }

        .edit-form input:focus {
            outline: none;
            border-color: #f9ab00;
        }

        .edit-form button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            border: 2px solid #f9ab00;
            background-color: transparent;
            color: #fff;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .edit-form button:hover {
            background-color: rgba(249, 171, 0, 0.8);
            transform: scale(1.02);
        }

        .alert {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        .success {
            color: green;
            text-align: center;
            margin-bottom: 10px;
        }

        .edit-form a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #f9ab00;
            text-decoration: none;
        }

        .edit-form a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="edit-form">
        <h2>Edit Profile</h2>
        <?php if ($error): ?>
            <p class="alert"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required placeholder="Nama">
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required placeholder="Email">

            <button type="submit">Simpan Perubahan</button>
        </form>
        <a href="profile.php">Kembali ke Profil</a>
    </div>
</body>

</html>