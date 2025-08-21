 <?php
session_start();
include "koneksi.php";

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    $_SESSION['login_error'] = "Anda harus login untuk melihat watchlist.";
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'User';

// Query untuk mengambil data anime dari watchlist user
$sql = "SELECT a.id, a.tittle, a.thumbnail, a.description 
        FROM anime a 
        JOIN watchlist w ON a.id = w.anime_id 
        WHERE w.user_id = ?
        ORDER BY w.added_at DESC"; // Urutkan berdasarkan kapan ditambahkan

$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id); // Bind user_id (integer)
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watchlist Saya - AniGrid</title>

    <!-- CSS Boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Boostrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- CSS Eksternal -->
    <link rel="stylesheet" href="css/index.css">
</head>
<body>

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top p-3">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3" href="index.php">
                Ani<span style="color: #cbbaff">Grid</span>
            </a>
            <div class="d-flex gap-2">
                <a href="users/dashboard/index.php" class="btn btn-outline-info btn-sm me-2 fs-5">Dashboard</a>
                <a href="logout.php" class="btn btn-outline-danger btn-sm fs-5">Logout</a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Watchlist content main Start -->
    <div class="container mt-4">
        <h1 class="mb-4 py-4 text-bold text-light text-center">Watchlist Saya</h1>
        
        <div class="row g-4">
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($anime = mysqli_fetch_assoc($result)): ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card bg-dark text-white border-0 h-100">
                            <img
                            src="img/img-anime/<?php echo htmlspecialchars($anime['thumbnail']); ?>"
                            class="card-img-top"
                            alt="<?php echo htmlspecialchars($anime['tittle']); ?>"
                            style="height: 300px; object-fit: cover;"
                            />
                            <div class="card-body p-2 mt-2 d-flex flex-column">
                                <h5 class="card-title text-light fw-semibold mb-1 fs-5 flex-grow-1"><?php echo htmlspecialchars($anime['tittle']); ?></h5>
                                <p class="card-text fw-light text-light small"><?php echo htmlspecialchars(substr($anime['description'], 0, 50)) . '...'; ?></p>
                                <div class="mt-auto d-flex justify-content-between align-items-end">
                                    <a href="detail_anime.php?id=<?php echo $anime['id']; ?>" class="btn btn-sm btn-primary">Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <p class="text-center text-light mt-5">Watchlist Anda masih kosong.</p>
                            <p class="text-center"><a href="index.php#daftar-anime">Cari anime untuk ditambahkan!</a></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Watchlist content main End -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php

// Tutup statement
mysqli_stmt_close($stmt);

?>