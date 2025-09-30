<?php
session_start();

// Kalau sudah login → redirect sesuai role
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: dashboard_admin.php");
        exit;
    } else {
        header("Location: dashboard_user.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home - Tiket Wisata</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center h-screen">

  <div class="bg-white p-8 rounded-2xl shadow-xl text-center max-w-md">
    <h1 class="text-3xl font-bold text-blue-700 mb-4">Selamat Datang</h1>
    <p class="text-gray-600 mb-6">Platform pemesanan tiket wisata mudah dan cepat.</p>

    <div class="flex justify-center gap-4">
      <a href="login.php" class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
        Login
      </a>
      <a href="register.php" class="px-6 py-2 bg-blue-100 text-blue-700 rounded-lg shadow hover:bg-blue-200 transition">
        Register
      </a>
    </div>
  </div>

</body>
</html>