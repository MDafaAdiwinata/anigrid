 <?php
session_start();
require_once '../koneksi.php';

$errors = [];

if (isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    // Validasi input dasar
    if (empty($username) || empty($password)) {
        $errors[] = "Username dan password tidak boleh kosong";
    } else {
        // Cari admin berdasarkan username
        $query = "SELECT * FROM admin WHERE username = '$username'";
        $result = mysqli_query($koneksi, $query);

        if ($result && mysqli_num_rows($result) == 1) {
            $admin = mysqli_fetch_assoc($result);

            if ($password === $admin['password']) { 
                // Password cocok, login berhasil
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                
                header("Location: index.php");
                exit();
            } else {
                // Password salah
                $errors[] = "Username atau password salah.";
            }
        } else {
            // User tidak ditemukan atau query error
            $errors[] = "Username atau password salah.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - AniGrid</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS Eksternal -->
     <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login-form">
        <div class="form-login">
      <form class="form-login-form p-4 mb-4 border" action="" method="POST">
        <div class="card-title">
          <h1 class="text-center pb-4 fs-3">Masuk <br> Sebagai Admin</span></h1>
        </div>

        <div class="mb-4">
          <label for="username" class="form-label">Username</label>
          <input
            type="text"
            class="form-control"
            id="username"
            name="username"
            required
          />
        </div>
        <div class="mb-5">
          <label for="password" class="form-label">Password</label>
          <input
            type="password"
            class="form-control"
            id="password"
            name="password"
            required
          />
        </div>
        <div class="d-grid gap-2">
          <button class="btn btn-primary" type="submit">Masuk</button>
        </div>
      </form>
    </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>