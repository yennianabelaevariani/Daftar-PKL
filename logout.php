<?php
session_start(); // Memulai session
session_destroy(); // Menghapus semua data session
header('Location: index.php'); // Redirect ke halaman login
exit; // Menghentikan eksekusi script
