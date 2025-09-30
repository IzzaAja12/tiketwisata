<?php
function renderLayout($title, $content) {
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($title) ?> - Tiket Wisata</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col bg-gradient-to-r from-blue-100 to-blue-200">

  <!-- Navbar -->
  <nav class="bg-white shadow-md">
    <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
      <h1 class="text-lg font-bold text-blue-600">🎫 Tiket Wisata</h1>
      <div class="space-x-4">
        <a href="index.php" class="text-gray-600 hover:text-blue-600">Home</a>
        <a href="login.php" class="text-gray-600 hover:text-blue-600">Login</a>
        <a href="register.php" class="text-gray-600 hover:text-blue-600">Register</a>
      </div>
    </div>
  </nav>

  <!-- Main -->
  <main class="flex-1 flex items-center justify-center p-6">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
      <?= $content ?>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-white shadow-inner py-4 text-center text-gray-500 text-sm">
    &copy; <?= date("Y") ?> Tiket Wisata
  </footer>

</body>
</html>
<?php
}