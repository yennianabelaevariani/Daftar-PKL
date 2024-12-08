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

// Ambil data user berdasarkan ID
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
?>
<!DOCTYPE html>
<html>

<head>
    <title>Profile</title>
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

        .profile {
            background-color: #222028;
            border-radius: 12px;
            padding: 30px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .profile h2 {
            color: #f9ab00;
            margin-bottom: 20px;
        }

        .profile p {
            margin: 10px 0;
            font-size: 14px;
        }

        .profile a {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
        }

        .profile a:hover {
            text-decoration: underline;
        }

        .edit {
            margin-top: 20px;
            background-color: #007bff;
            color: #fff;
            padding: 12px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }

        .logout {
            margin-top: 20px;
            background-color: #dc3545;
            color: #fff;
            padding: 12px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }

        .logout:hover {
            background-color: #b02a37;
        }
    </style>
</head>

<body>
    <div class="profile">
        <h2>Profile</h2>
        <p><strong>Nama:</strong> <?= htmlspecialchars($user['name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <a href="edit_profile.php" class="edit">Edit Profile</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</body>

</html>