 <?php
session_start();
require_once 'koneksi.php';

$errors = [];
$login_error_message = null;

// Cek dan ambil pesan error dari session
if (isset($_SESSION['login_error'])) {
    $login_error_message = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}

// Menampilkan pesan sukses dari registrasi
if (isset($_GET['success'])) {
    $success_message = htmlspecialchars($_GET['success']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    // Validasi input dasar
    if (empty($username) || empty($password)) {
        $errors[] = "Username dan password tidak boleh kosong";
    } else {
        // Cari user berdasarkan username
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($koneksi, $query);

        if ($result && mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);

            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Password cocok, login berhasil
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                
                // Redirect ke halaman utama (misalnya index.php)
                header("Location:index.php");
                exit();
            } else {
                // Password salah
                $errors[] = "Username atau password salah";
            }
        } else {
            // User tidak ditemukan
            $errors[] = "Username atau password salah";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AniGrid | Login User</title>

    <!-- CSS Boostrap -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
      crossorigin="anonymous"
    />

    <!-- CSS Eksternal -->
    <link rel="stylesheet" href="css/login.css" />
  </head>
  <body>
    <!-- Form Login Start -->
    <div class="form-login">
      <form class="form-login-form p-4 mb-4 border" action="" method="POST">
        <div class="card-title">
          <h1 class="text-center pb-4 fs-3">Masuk <br> Untuk Melanjutkan</span></h1>
        </div>

        <?php if (!empty($login_error_message)): ?>
            <div class="alert alert-warning">
                <p class="mb-0"><?php echo htmlspecialchars($login_error_message); ?></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success">
                <p class="mb-0"><?php echo $success_message; ?></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p class="mb-0"><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

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
      <div class="form-extra">
        <p>Belum Punya Akun? <a href="daftar.php">Daftar</a></p>
      </div>
    </div>

    <!-- Form Login End -->

    <!-- Script Boostrap -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
      crossorigin="anonymous"
    ></script>
  </body>
</html