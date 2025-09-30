<?php
require_once "../config/db.php";
require_once "../includes/layout.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, nama, email, password, role, phone FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            if ($user['role'] === 'admin') {
                header("Location: ../public/dashboard_admin.php");
            } else {
                header("Location: ../public/dashboard_user.php");
            }
            exit;
        } else {
            $errors[] = "Password salah.";
        }
    } else {
        $errors[] = "Email tidak ditemukan.";
    }
    $stmt->close();
}

ob_start();
?>
<h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Login</h2>

<?php foreach ($errors as $e): ?>
  <p class="bg-red-100 text-red-600 px-3 py-2 rounded mb-3"><?= $e ?></p>
<?php endforeach; ?>

<form method="post" class="space-y-4">
  <div>
    <label class="block text-sm text-gray-600">Email</label>
    <input type="email" name="email" required class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400">
  </div>
  <div>
    <label class="block text-sm text-gray-600">Password</label>
    <input type="password" name="password" required class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400">
  </div>

  <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg py-2">
    Login
  </button>
</form>

<p class="mt-4 text-center text-sm text-gray-600">
  Belum punya akun? <a href="register.php" class="text-blue-500 hover:underline">Daftar</a>
</p>
<?php
$content = ob_get_clean();
renderLayout("Login", $content);