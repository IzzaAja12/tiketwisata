<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

include '../config/db.php';

// Ambil data user
$user_id = $_SESSION['user_id'];
$nama = $_SESSION['nama'];

// Ambil daftar event
$events = $conn->query("SELECT * FROM events ORDER BY date_start ASC");

// Ambil riwayat order user
$orders = $conn->query("SELECT o.*, e.title 
                        FROM orders o 
                        JOIN events e ON o.event_id = e.event_id 
                        WHERE o.user_id = $user_id 
                        ORDER BY o.created_at DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard User</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 min-h-screen">
  <!-- Navbar -->
  <nav class="bg-blue-300 shadow-md p-4 flex justify-between items-center">
    <h1 class="text-xl font-bold text-blue-900">TiketWisata</h1>
    <div class="space-x-4">
      <a href="dashboard_user.php" class="text-blue-900 font-medium">Home</a>
      <a href="logout.php" class="text-red-600 font-medium">Logout</a>
    </div>
  </nav>

  <div class="container mx-auto p-6">
    <!-- Welcome -->
    <div class="mb-6">
      <h2 class="text-2xl font-semibold text-blue-900">Halo, <?= htmlspecialchars($nama) ?> 👋</h2>
      <p class="text-blue-700">Selamat datang di dashboard kamu</p>
    </div>

    <!-- Daftar Event -->
    <h3 class="text-xl font-semibold text-blue-800 mb-4">Event Tersedia</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
      <?php while ($row = $events->fetch_assoc()): ?>
        <div class="bg-white rounded-2xl shadow-lg p-4 hover:shadow-xl transition">
          <img src="uploads/<?= $row['image'] ?>" alt="<?= $row['title'] ?>" class="rounded-lg w-full h-40 object-cover mb-3">
          <h4 class="text-lg font-semibold text-blue-900"><?= $row['title'] ?></h4>
          <p class="text-sm text-gray-600"><?= date("d M Y", strtotime($row['date_start'])) ?> - <?= date("d M Y", strtotime($row['date_end'])) ?></p>
          <p class="text-blue-700 font-bold mt-2">Rp <?= number_format($row['price'],0,',','.') ?></p>
          <a href="order.php?event_id=<?= $row['event_id'] ?>" 
             class="mt-3 inline-block bg-blue-400 text-white px-4 py-2 rounded-xl hover:bg-blue-500 transition">
            Pesan Tiket
          </a>
        </div>
      <?php endwhile; ?>
    </div>

    <!-- Riwayat Pesanan -->
    <h3 class="text-xl font-semibold text-blue-800 mb-4">Pesanan Saya</h3>
    <div class="bg-white rounded-2xl shadow-lg p-4">
      <table class="w-full text-left">
        <thead>
          <tr class="border-b">
            <th class="py-2">Kode Pesanan</th>
            <th>Event</th>
            <th>Jumlah</th>
            <th>Total</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($order = $orders->fetch_assoc()): ?>
            <tr class="border-b">
              <td class="py-2"><?= $order['order_code'] ?></td>
              <td><?= $order['title'] ?></td>
              <td><?= $order['qty'] ?></td>
              <td>Rp <?= number_format($order['total'],0,',','.') ?></td>
              <td>
                <span class="px-2 py-1 rounded-xl text-sm
                  <?php if($order['status']=='paid') echo 'bg-green-200 text-green-800';
                        elseif($order['status']=='pending') echo 'bg-yellow-200 text-yellow-800';
                        elseif($order['status']=='cancelled') echo 'bg-red-200 text-red-800';
                        else echo 'bg-gray-200 text-gray-800'; ?>">
                  <?= ucfirst($order['status']) ?>
                </span>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>