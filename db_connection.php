<?php

$servername = "localhost";

$username = "root"; // Ganti dengan username MySQL Anda

$password = ""; // Ganti dengan password MySQL Anda

$database = "todo_list"; // Ganti dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $database);

// Periksa koneksi

if ($conn->connect_error) {

    die("Koneksi gagal: " . $conn->connect_error);
}
