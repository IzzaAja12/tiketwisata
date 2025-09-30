<?php
require_once "../config/db.php";
require_once "../includes/layout.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama     = trim($_POST['nama']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $password = $_POST['password'];

    if (empty($nama) || empty($email) || empty($phone) || empty($password)) {
        $errors[] = "Semua field wajib diisi.";
    } else {
        // cek email unik
        $check = $conn->prepare("SELECT user_id FROM users WHERE email=?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();
        if ($result->num_rows > 0) {
            $errors[] = "Email sudah terdaftar.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO users (nama, email, password, role, phone) VALUES (?, ?, ?, 'user', ?)");
            $stmt->bind_param("ssss", $nama, $email, $hashedPassword, $phone);
            if ($stmt->execute()) {
                header("Location: login.php");
                exit;
            } else {
                $errors[] = "Terjadi kesalahan: " . $stmt->error;
            }
            $stmt->close();
        }
        $check->close();
    }
}

ob_start();
?>
<h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Daftar Akun</h2>

<?php foreach ($errors as $e): ?>
  <p class="bg-red-100 text-red-600 px-3 py-2 rounded mb-3"><?= $e ?></p>
<?php endforeach; ?>

<form method="post" class="space-y-4">
  <div>
    <label class="block text-sm text-gray-600">Nama</label>
    <input type="text" name="nama" required class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400">
  </div>
  <div>
    <label class="block text-sm text-gray-600">Email</label>
    <input type="email" name="email" required class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400">
  </div>
  <div>
    <label class="block text-sm text-gray-600">Nomor HP</label>
    <input type="text" name="phone" required class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400">
  </div>
  <div>
    <label class="block text-sm text-gray-600">Password</label>
    <input type="password" name="password" required class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400">
  </div>

  <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg py-2">
    Daftar
  </button>
</form>

<p class="mt-4 text-center text-sm text-gray-600">
  Sudah punya akun? <a href="login.php" class="text-blue-500 hover:underline">Login</a>
</p>
<?php
$content = ob_get_clean();
renderLayout("Register", $content);