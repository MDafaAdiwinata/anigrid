 <?php
session_start();
require_once '../koneksi.php';

// Cek sesi admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$admin_username = isset($_SESSION['admin_username']) ? htmlspecialchars($_SESSION['admin_username']) : 'Admin';

// halaman aktif sidebar
$active_page = 'dashboard';

// Ambil data anime untuk ditampilkan di tabel
$sql_anime = "SELECT * FROM anime ORDER BY id ASC";
$result_anime = mysqli_query($koneksi, $sql_anime);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - AniGrid</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="css/admin_dashboard.css">

</head>
<body>

    <!-- Sidebar Admin Start -->
    <nav id="admin-sidebar"> 
        <div class="sidebar-header"><h3>Admin Panel</h3></div>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link active" href="index.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php#anime-table"><i class="bi bi-pencil-square"></i>Kelola Anime</a></li>
            <li class="nav-item mt-auto"><a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
        </ul>
    </nav>
    <!-- Sidebar Admin End -->

    <!-- Konten Admin Start -->
    <div id="admin-content">
        <div class="container-fluid">
            
            <?php 

            // Menampilkan flash message jika ada
            if (isset($_SESSION['flash_message'])):
                $message = $_SESSION['flash_message'];
                unset($_SESSION['flash_message']); // Hapus pesan setelah ditampilkan
            ?>
                <div class="alert alert-<?php echo $message['type']; ?> alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($message['text']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Header Konten Start -->
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                 <h1 class="h2">Dashboard</h1>
                 <div class="btn-toolbar mb-2 mb-md-0">
                 <span class="text-muted">Selamat datang, <?php echo $admin_username; ?>!</span>
                 </div>
            </div>
            <!-- Header Konten End -->

            <!-- Tabel Daftar Anime Start -->
            <h2 id="anime-table" class="mt-5 mb-3">Daftar Anime</h2>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr class="table-primary">
                            <th scope="col">#ID</th>
                            <th scope="col">Thumbnail</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Genre</th>
                            <th scope="col">Studio</th>
                            <th scope="col">Tahun</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result_anime && mysqli_num_rows($result_anime) > 0): ?>
                            <?php while ($anime = mysqli_fetch_assoc($result_anime)): ?>
                                <tr>
                                    <th scope="row"><?php echo $anime['id']; ?></th>
                                    <td>
                                        <img src="../img/img-anime/<?php echo htmlspecialchars($anime['thumbnail']); ?>" 
                                             alt="Thumb" width="50" height="70" style="object-fit: cover;">
                                    </td>
                                    <td><?php echo htmlspecialchars($anime['tittle']); ?></td>
                                    <td><?php echo htmlspecialchars($anime['genre']); ?></td>
                                    <td><?php echo htmlspecialchars($anime['studio']); ?></td>
                                    <td><?php echo htmlspecialchars($anime['year']); ?></td>
                                    <td class="action-buttons">
                                        <a href="edit_anime.php?id=<?php echo $anime['id']; ?>" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <a href="hapus_anime.php?id=<?php echo $anime['id']; ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus anime ini?');">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">Tidak Ada Data Anime</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Tabel Daftar Anime End -->

            <!-- Tambah Anime -->
            <div class="mt-4">
                 <a href="tambah_anime.php" class="btn btn-success">
                    <i class="bi bi-plus-circle-fill me-2"></i> Tambah Anime Baru
                 </a>
            </div>

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

    <!-- Script Boostrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>