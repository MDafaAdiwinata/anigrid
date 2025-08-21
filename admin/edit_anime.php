 <?php
session_start();
require_once '../koneksi.php';

// Cek sesi admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$errors = [];
$success_message = null;
$anime_data = null;
$anime_id = null;

// Ambil ID dari URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Error: ID Anime tidak valid.');
}
$anime_id = mysqli_real_escape_string($koneksi, $_GET['id']);

// Ambil data anime yang akan diedit
$sql_fetch = "SELECT * FROM anime WHERE id = ?";
$stmt_fetch = mysqli_prepare($koneksi, $sql_fetch);
mysqli_stmt_bind_param($stmt_fetch, "i", $anime_id);
mysqli_stmt_execute($stmt_fetch);
$result_fetch = mysqli_stmt_get_result($stmt_fetch);
if ($result_fetch && mysqli_num_rows($result_fetch) > 0) {
    $anime_data = mysqli_fetch_assoc($result_fetch);
} else {
    die('Error: Anime tidak ditemukan.');
}
mysqli_stmt_close($stmt_fetch);

// Proses Update jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Ambil data dari form
    $tittle = mysqli_real_escape_string($koneksi, $_POST['tittle']);
    $genre = mysqli_real_escape_string($koneksi, $_POST['genre']);
    $studio = mysqli_real_escape_string($koneksi, $_POST['studio']);
    $year = mysqli_real_escape_string($koneksi, $_POST['year']);
    $description = mysqli_real_escape_string($koneksi, $_POST['description']);
    $video_url = mysqli_real_escape_string($koneksi, $_POST['video_url']);
    $current_thumbnail = $anime_data['thumbnail']; // Nama thumbnail saat ini

    // Validasi dasar
    if (empty($tittle) || empty($genre) || empty($year)) {
        $errors[] = "Judul, Genre, dan Tahun wajib diisi.";
    }

    // Proses Upload Thumbnail BARU (jika ada)
    $new_thumbnail_name = $current_thumbnail;
    $target_dir = "../img/img-anime/";
    if (isset($_FILES['thumbnail']['name']) && !empty($_FILES['thumbnail']['name']) && $_FILES['thumbnail']['error'] == 0) {
        $imageFileType = strtolower(pathinfo($_FILES['thumbnail']["name"], PATHINFO_EXTENSION));
        $new_thumbnail_name_temp = uniqid('thumb_', true) . '.' . $imageFileType;
        $target_file = $target_dir . $new_thumbnail_name_temp;
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (!in_array($imageFileType, $allowed_types)) {
            $errors[] = "Hanya file JPG, JPEG, PNG, & GIF yang diperbolehkan.";
        }
        if ($_FILES['thumbnail']["size"] > 2000000) {
            $errors[] = "Ukuran file thumbnail baru terlalu besar (maks 2MB).";
        }

        if (empty($errors)) {
            if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file)) {
                
                 if (!empty($current_thumbnail) && file_exists($target_dir . $current_thumbnail)) {
                    unlink($target_dir . $current_thumbnail);
                 }
                 $new_thumbnail_name = $new_thumbnail_name_temp;
            } else {
                $errors[] = "Maaf, terjadi kesalahan saat mengupload thumbnail baru.";
            }
        }
    } // Akhir proses upload baru

    // Jika tidak ada error, update ke database
    if (empty($errors)) {
        $sql_update = "UPDATE anime SET tittle=?, genre=?, studio=?, year=?, description=?, thumbnail=?, video_url=? WHERE id=?";
        $stmt_update = mysqli_prepare($koneksi, $sql_update);
        mysqli_stmt_bind_param($stmt_update, "sssssssi", $tittle, $genre, $studio, $year, $description, $new_thumbnail_name, $video_url, $anime_id);
        
        if (mysqli_stmt_execute($stmt_update)) {
            
            $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Anime "' . htmlspecialchars($tittle) . '" berhasil diperbarui!'
        ];
             header("Location: index.php#anime-table"); 
             exit();
        } else {
            $errors[] = "Gagal memperbarui data anime: " . mysqli_stmt_error($stmt_update);
        }
        mysqli_stmt_close($stmt_update);
    }
    // Jika ada error, data $anime_data akan digunakan kembali
    $anime_data['tittle'] = $tittle;
    $anime_data['genre'] = $genre;
    $anime_data['studio'] = $studio;
    $anime_data['year'] = $year;
    $anime_data['description'] = $description;
    $anime_data['video_url'] = $video_url;

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anime - <?php echo htmlspecialchars($anime_data['tittle'] ?? ''); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/admin_dashboard.css">
</head>
<body>

    <!-- Sidebar Start -->
    <nav id="admin-sidebar"> 
        <div class="sidebar-header"><h3>Admin Panel</h3></div>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="index.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link active" href="manage_anime.php"><i class="bi bi-pencil-square"></i>Kelola Anime</a></li>
            <li class="nav-item mt-auto"><a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
        </ul>
    </nav>
    <!-- Sidebar End -->

    <div id="admin-content">
        <div class="container-fluid mb-5">
            <h1 class="h2 mb-4">Edit Anime: <?php echo htmlspecialchars($anime_data['tittle'] ?? ''); ?></h1>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error): ?><p class="mb-0"><?php echo $error; ?></p><?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="edit_anime.php?id=<?php echo $anime_id; ?>" enctype="multipart/form-data">
                 <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="tittle" class="form-label">Judul Anime *</label>
                            <input type="text" class="form-control" id="tittle" name="tittle" value="<?php echo htmlspecialchars($anime_data['tittle']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="5"><?php echo htmlspecialchars($anime_data['description']); ?></textarea>
                        </div>
                         <div class="mb-3">
                             <label for="video_url" class="form-label">URL Video Trailer (Embed)</label>
                             <input type="url" class="form-control" id="video_url" name="video_url" value="<?php echo htmlspecialchars($anime_data['video_url']); ?>" placeholder="https://www.youtube.com/embed/...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="genre" class="form-label">Genre *</label>
                            <input type="text" class="form-control" id="genre" name="genre" value="<?php echo htmlspecialchars($anime_data['genre']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="studio" class="form-label">Studio</label>
                            <input type="text" class="form-control" id="studio" name="studio" value="<?php echo htmlspecialchars($anime_data['studio']); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="year" class="form-label">Tahun Rilis *</label>
                            <input type="number" class="form-control" id="year" name="year" value="<?php echo htmlspecialchars($anime_data['year']); ?>" min="1900" max="<?php echo date('Y') + 2; ?>" required>
                        </div>
                         <div class="mb-3">
                            <label for="thumbnail" class="form-label">Ganti Thumbnail (Opsional)</label>
                            <input class="form-control" type="file" id="thumbnail" name="thumbnail" accept="image/*">
                            <small class="form-text text-muted">Thumbnail saat ini: <?php echo htmlspecialchars($anime_data['thumbnail']); ?></small><br>
                            <?php if (!empty($anime_data['thumbnail']) && file_exists("../img/img-anime/" . $anime_data['thumbnail'])): ?>
                                <img src="../img/img-anime/<?php echo htmlspecialchars($anime_data['thumbnail']); ?>" alt="Current Thumbnail" height="100" class="mt-2 img-thumbnail">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="index.php#anime-table" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>

        <!-- Mobile Navbar Start -->
        <nav class="mobile-navbar">
        <div class="container">
            <div class="row">
                <div class="col-4">
                    <a class="nav-link <?php echo ($active_page == 'dashboard') ? 'active' : ''; ?>" href="index.php">
                        <i class="bi bi-speedometer2"></i>
                        Dashboard
                    </a>
                </div>
                <div class="col-4">
                    <a class="nav-link <?php echo ($active_page == 'daftar_anime') ? 'active' : ''; ?>" href="index.php#anime-table">
                        <i class="bi bi-pencil-square"></i>
                        Kelola Anime
                    </a>
                </div>
                <div class="col-4">
                    <a class="nav-link" href="logout.php">
                        <i class="bi bi-box-arrow-left"></i>
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Mobile Navbar End -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>