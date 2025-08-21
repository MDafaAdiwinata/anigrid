 <?php
session_start();
require_once '../koneksi.php';

// Keamanan: Cek sesi admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$errors = [];
$success_message = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $tittle = mysqli_real_escape_string($koneksi, $_POST['tittle']);
    $genre = mysqli_real_escape_string($koneksi, $_POST['genre']);
    $studio = mysqli_real_escape_string($koneksi, $_POST['studio']);
    $year = mysqli_real_escape_string($koneksi, $_POST['year']);
    $description = mysqli_real_escape_string($koneksi, $_POST['description']);
    $video_url = mysqli_real_escape_string($koneksi, $_POST['video_url']);
    
    // Validasi dasar (bisa ditambahkan lebih detail)
    if (empty($tittle) || empty($genre) || empty($year) || empty($_FILES['thumbnail']['name'])) {
        $errors[] = "Judul, Genre, Tahun, dan Thumbnail wajib diisi.";
    }

    // Proses Upload Thumbnail
    $thumbnail_name = '';
    $target_dir = "../img/img-anime/"; // Folder penyimpanan gambar
    $target_file = '';
    if (isset($_FILES['thumbnail']['name']) && $_FILES['thumbnail']['error'] == 0) {
        $imageFileType = strtolower(pathinfo($_FILES['thumbnail']["name"], PATHINFO_EXTENSION));
        $thumbnail_name = uniqid('thumb_', true) . '.' . $imageFileType; // Nama file unik
        $target_file = $target_dir . $thumbnail_name;
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        
        // Cek tipe file
        if (!in_array($imageFileType, $allowed_types)) {
            $errors[] = "Hanya file JPG, JPEG, PNG, & GIF yang diperbolehkan.";
        }
        
        // Cek ukuran file (misal maks 2MB)
        if ($_FILES['thumbnail']["size"] > 2000000) {
            $errors[] = "Ukuran file thumbnail terlalu besar (maks 2MB).";
        }

        // Coba upload jika tidak ada error validasi sebelumnya
        if (empty($errors)) {
            if (!move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file)) {
                $errors[] = "Maaf, terjadi kesalahan saat mengupload thumbnail.";
                $thumbnail_name = ''; // Reset nama jika gagal upload
            }
        }
    }

    // Jika tidak ada error, insert ke database
    if (empty($errors) && !empty($thumbnail_name)) {
        $sql = "INSERT INTO anime (tittle, genre, studio, year, description, thumbnail, video_url) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "sssssss", $tittle, $genre, $studio, $year, $description, $thumbnail_name, $video_url);
        
        if (mysqli_stmt_execute($stmt)) {
            $success_message = "Anime \". htmlspecialchars($tittle) . \" berhasil ditambahkan!";
             // Kosongkan form atau redirect?
             // header("Location: index.php?status=added"); exit();
        } else {
            $errors[] = "Gagal menyimpan data anime ke database: " . mysqli_stmt_error($stmt);
             // Hapus file gambar jika insert db gagal?
             if (file_exists($target_file)) { unlink($target_file); }
        }
        mysqli_stmt_close($stmt);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Anime Baru - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/admin_dashboard.css">
</head>
<body>
    <nav id="admin-sidebar">
         <div class="sidebar-header"><h3>Admin Panel</h3></div>
         <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="index.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php#anime-table"><i class="bi bi-list-ul"></i> Daftar Anime</a></li>
            <li class="nav-item"><a class="nav-link active" href="manage_anime.php"><i class="bi bi-pencil-square"></i> Manajemen Anime</a></li>
            <li class="nav-item mt-auto"><a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
         </ul>
    </nav>

    <div id="admin-content">
        <div class="container-fluid">
            <h1 class="h2 mb-4">Tambah Anime Baru</h1>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error): ?><p class="mb-0"><?php echo $error; ?></p><?php endforeach; ?>
                </div>
            <?php endif; ?>
             <?php if ($success_message): ?>
                <div class="alert alert-success">
                    <p class="mb-0"><?php echo $success_message; ?> <a href="index.php#anime-table">Kembali ke Daftar</a></p>
                </div>
            <?php endif; ?>

            <form method="POST" action="tambah_anime.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="tittle" class="form-label">Judul Anime *</label>
                            <input type="text" class="form-control" id="tittle" name="tittle" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="5"></textarea>
                        </div>
                        <div class="mb-3">
                             <label for="video_url" class="form-label">URL Video Trailer (Embed)</label>
                             <input type="url" class="form-control" id="video_url" name="video_url" placeholder="https://www.youtube.com/embed/...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="genre" class="form-label">Genre *</label>
                            <input type="text" class="form-control" id="genre" name="genre" required>
                        </div>
                        <div class="mb-3">
                            <label for="studio" class="form-label">Studio</label>
                            <input type="text" class="form-control" id="studio" name="studio">
                        </div>
                        <div class="mb-3">
                            <label for="year" class="form-label">Tahun Rilis *</label>
                            <input type="number" class="form-control" id="year" name="year" min="1900" max="<?php echo date('Y') + 2; ?>" required>
                        </div>
                         <div class="mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail *</label>
                            <input class="form-control" type="file" id="thumbnail" name="thumbnail" accept="image/*" required>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Anime</button>
                 <a href="index.php" class="btn btn-secondary">Batal</a>
            </form>
        
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>