<?php
session_start(); // Aktifkan session
include 'db_connection.php';

// Ambil data dari form login
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Hindari SQL Injection
$email = mysqli_real_escape_string($conn, $email);
$password = mysqli_real_escape_string($conn, $password);

// Query cari user
$query = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
$result = mysqli_query($conn, $query);

// Cek hasil query
if (mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);

    // Simpan ke session
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['email'] = $user['email'];

    // Redirect ke index.php
    header("Location: index.php");
    exit;
} else {
    // Redirect kembali ke login.php
    echo "<script>
        alert('Email atau password salah!');
        window.location.href = 'login.php';
    </script>";
    exit;
}

mysqli_close($conn);
?>
