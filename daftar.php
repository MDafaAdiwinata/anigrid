 <?php
require_once 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    // Mengambil data dari form
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi input
    $errors = [];

    // Cek username sudah ada atau belum
    $check_username = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($check_username) > 0) {
        $errors[] = "Username sudah digunakan";
    }

    // Cek email sudah ada atau belum
    $check_email = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check_email) > 0) {
        $errors[] = "Email sudah digunakan";
    }

    // Validasi format email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid";
    }

    // Validasi password
    if (strlen($password) < 8) {
        $errors[] = "Password minimal 8 karakter";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Password tidak cocok";
    }

    // Jika tidak ada error, proses registrasi
    if (empty($errors)) {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert data ke database
        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        
        if (mysqli_query($koneksi, $query)) {
            $success = "Registrasi berhasil! Silakan login.";
            header("Location: login.php?success=" . urlencode($success));
            exit();
        } else {
            $errors[] = "Terjadi kesalahan: " . mysqli_error($koneksi);
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
    <link rel="stylesheet" href="css/daftar.css" />
  </head>
  <body>
    <!-- Form Login Start -->
    <div class="form-login">
      <form class="form-login-form p-4 mb-4 border" action="" method="POST">
        <div class="card-title">
          <h1 class="text-center pb-4 fs-2">Buat <br> Akun Baru</span></h1>
        </div>
        
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
        <div class="mb-4">
          <label for="email" class="form-label">Email</label>
          <input
            type="email"
            class="form-control"
            id="email"
            name="email"
            required
          />
        </div>
        <div class="mb-4">
          <label for="password" class="form-label">Password</label>
          <input
            type="password"
            class="form-control"
            id="password"
            name="password"
            required
          />
        </div>
        <div class="mb-4">
          <label for="confirm_password" class="form-label">Konfirmasi Password</label>
          <input
            type="password"
            class="form-control"
            id="confirm_password"
            name="confirm_password"
            required
          />
        </div>
        <div class="d-grid gap-2">
          <button class="btn btn-primary" type="submit">Daftar</button>
        </div>
      </form>
      <div class="form-extra">
        <p>Sudah Punya Akun? <a href="login.php">Masuk</a></p>
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