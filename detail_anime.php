 <?php
session_start();
include "koneksi.php";

// Mengambil ID Anime dari URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<p>Error: ID Anime tidak ditemukan.</p>";
    exit(); 
}

$anime_id = mysqli_real_escape_string($koneksi, $_GET['id']);

// Cek apakah user sudah login
$user_logged_in = isset($_SESSION['user_id']);
$user_id = $user_logged_in ? $_SESSION['user_id'] : null;

// Variabel untuk status watchlist & pesan
$is_in_watchlist = false;
$watchlist_message = null;
$watchlist_message_type = 'info';

// Jika user login, cek status watchlist
if ($user_logged_in) {
    $check_sql = "SELECT id FROM watchlist WHERE user_id = '$user_id' AND anime_id = '$anime_id'";
    $check_result = mysqli_query($koneksi, $check_sql);
    if ($check_result && mysqli_num_rows($check_result) > 0) {
        $is_in_watchlist = true;
    }
}

// Proses Tambah dan Hapus WatchList
if ($_SERVER["REQUEST_METHOD"] == "POST" && $user_logged_in) {
    if (isset($_POST['add_to_watchlist'])) {
        if (!$is_in_watchlist) {
            $insert_sql = "INSERT INTO watchlist (user_id, anime_id) VALUES ('$user_id', '$anime_id')";
            if (mysqli_query($koneksi, $insert_sql)) {
                $is_in_watchlist = true;
                $watchlist_message = "Berhasil ditambahkan ke watchlist!";
                $watchlist_message_type = 'success';
            } else {
                 $watchlist_message = "Gagal menambahkan ke watchlist: " . mysqli_error($koneksi);
                 $watchlist_message_type = 'danger';
            }
        }
    } elseif (isset($_POST['remove_from_watchlist'])) {
        if ($is_in_watchlist) {
            $delete_sql = "DELETE FROM watchlist WHERE user_id = '$user_id' AND anime_id = '$anime_id'";
             if (mysqli_query($koneksi, $delete_sql)) {
                $is_in_watchlist = false; // Update status
                $watchlist_message = "Berhasil dihapus dari watchlist.";
                 $watchlist_message_type = 'success';
            } else {
                 $watchlist_message = "Gagal menghapus dari watchlist: " . mysqli_error($koneksi);
                 $watchlist_message_type = 'danger';
            }
        }
    }
}

// Proses Watchlist End

// Query untuk mengambil detail anime berdasarkan ID (setelah update watchlist)
$sql = "SELECT * FROM anime WHERE id = '$anime_id'";
$result = mysqli_query($koneksi, $sql);

// Cek apakah anime ditemukan
if (!$result || mysqli_num_rows($result) == 0) {
    echo "<p>Error: Anime dengan ID '$anime_id' tidak ditemukan.</p>";
    exit();
}

// Ambil data anime
$anime = mysqli_fetch_assoc($result);

// Embed Video Anime
$video_embed_url = htmlspecialchars($anime['video_url']); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo htmlspecialchars($anime['tittle']); ?> - Detail Anime - AniGrid</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <!-- CSS Eksternal -->
    <link rel="stylesheet" href="css/detail_anime.css">

</head>
<body>

    <!-- Navbar Start -->

    <nav
      class="fixed-top navbar navbar-dark bg-dark navbar-expand-lg bg-body-tertiary p-3"
    >
      <div class="container">
        <!-- <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarTogglerDemo02"
          aria-controls="navbarTogglerDemo02"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button> -->
        <div class="" id="navbarTogglerDemo02">

          <!-- Untuk Selain Mobile -->
          <form class="d-none d-lg-flex gap-3 ms-auto">
            <a class="btn btn-outline-warning" href="index.php">
            <i class="bi bi-caret-left-fill mb-0 me-1"></i>Kembali</a>
          </form>

          <!-- Untuk Mobile -->
          <form class="d-flex d-lg-none flex-column gap-3">
          <a class="btn btn-outline-warning" href="index.php">
          <i class="bi bi-caret-left-fill mb-0 me-1"></i>
          Kembali</a>
          </form>
        </div>

        <p class="navbar-brand mb-0 text-light fs-3 fw-bold">
          Ani<span style="color: #cbbaff">Grid</span>
        </p>
      </div>
    </nav>

    <!-- Navbar End -->

    <div class="container" style="padding-top: 7%;">
        <div class="row anime-details">
            
            <!-- Kolom Kiri: Thumbnail dan Info Singkat -->
            <div class="col-md-4 mb-4">
                <img src="img/img-anime/<?php echo htmlspecialchars($anime['thumbnail']); ?>" class="img-fluid rounded shadow-sm mb-3" alt="<?php echo htmlspecialchars($anime['tittle']); ?>">
                <h5 class="fw-bold text-white">Informasi</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>Genre:</b> <?php echo htmlspecialchars($anime['genre']); ?></li>
                    <li class="list-group-item"><b>Studio:</b> <?php echo htmlspecialchars($anime['studio']); ?></li>
                    <li class="list-group-item"><b>Tahun:</b> <?php echo htmlspecialchars($anime['year']); ?></li>
                </ul>
            </div>

            <!-- Kolom Kanan: Judul, Deskripsi, Video -->
            <div class="col-md-8">
                <h1 class="mb-3 display-5 fw-bold text-white"><?php echo htmlspecialchars($anime['tittle']); ?></h1>
                
                <h4 class="mt-4 text-white">Deskripsi</h4>
                <p class="lead text-white fw-light"><?php echo nl2br(htmlspecialchars($anime['description'])); ?></p>

                <h4 class="mt-4 mb-3 text-white">Trailer</h4>
                <?php if (!empty($video_embed_url)): ?>
                    <div class="video-container shadow-sm rounded">
                        <iframe 
                            src="<?php echo $video_embed_url; ?>" 
                            title="YouTube video player" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            referrerpolicy="strict-origin-when-cross-origin" 
                            allowfullscreen>
                        </iframe>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Video trailer tidak tersedia.</p>
                <?php endif; ?>
                
                 <!-- Tombol Aksi Lain (Watchlist) -->
                <div class="mt-4">
                    <?php if ($user_logged_in): ?>
                        <form action="detail_anime.php?id=<?php echo $anime_id; ?>#watchlist-button" method="POST" id="watchlist-button">
                            <?php if ($is_in_watchlist): ?>
                                <button type="submit" name="remove_from_watchlist" class="btn btn-danger">
                                    <i class="bi bi-bookmark-x-fill me-1"></i> Hapus dari Watchlist
                                </button>
                            <?php else: ?>
                                 <button type="submit" name="add_to_watchlist" class="btn btn-success">
                                     <i class="bi bi-bookmark-plus-fill me-1"></i> Tambahkan ke Watchlist
                                </button>
                            <?php endif; ?>
                        </form>
                    <?php else: ?>
                        <a href="login.php?redirect=detail_anime.php?id=<?php echo $anime_id; ?>" class="btn btn-outline-primary">
                            Login untuk menambahkan ke Watchlist
                        </a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>