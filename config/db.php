<?php
$host = "localhost";
$user = "root"; // ganti sesuai setting MySQL kamu
$pass = "";     // ganti sesuai setting MySQL kamu
$db   = "tiket_wisata";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

session_start();
?>