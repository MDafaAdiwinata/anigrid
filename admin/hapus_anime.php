 <?php
session_start();
require_once '../koneksi.php';

// Cek sesi admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil ID dari URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
     $_SESSION['flash_message'] = ['type' => 'danger', 'text' => 'Error: ID Anime tidak valid untuk dihapus.'];
     header("Location: index.php#anime-table");
     exit();
}
$anime_id = mysqli_real_escape_string($koneksi, $_GET['id']);

// Ambil nama file thumbnail sebelum hapus data DB
$sql_get_thumb = "SELECT thumbnail FROM anime WHERE id = ?";
$stmt_get_thumb = mysqli_prepare($koneksi, $sql_get_thumb);
mysqli_stmt_bind_param($stmt_get_thumb, "i", $anime_id);
mysqli_stmt_execute($stmt_get_thumb);
$result_thumb = mysqli_stmt_get_result($stmt_get_thumb);
$thumb_to_delete = null;
if ($result_thumb && $row = mysqli_fetch_assoc($result_thumb)) {
    $thumb_to_delete = $row['thumbnail'];
}
mysqli_stmt_close($stmt_get_thumb);

// Hapus data dari database
$sql_delete = "DELETE FROM anime WHERE id = ?";
$stmt_delete = mysqli_prepare($koneksi, $sql_delete);
mysqli_stmt_bind_param($stmt_delete, "i", $anime_id);

if (mysqli_stmt_execute($stmt_delete)) {
    // Cek apakah ada baris yang terhapus
    if (mysqli_stmt_affected_rows($stmt_delete) > 0) {
         // Hapus file thumbnail
         if (!empty($thumb_to_delete)) {
             $file_path = "../img/img-anime/" . $thumb_to_delete;
             if (file_exists($file_path)) {
                 unlink($file_path);
             }
         }
         $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Anime berhasil dihapus.'];
    } else {
         $_SESSION['flash_message'] = ['type' => 'warning', 'text' => 'Anime tidak ditemukan atau sudah dihapus.'];
    }
} else {
    $_SESSION['flash_message'] = ['type' => 'danger', 'text' => 'Gagal menghapus anime: ' . mysqli_stmt_error($stmt_delete)];
}

mysqli_stmt_close($stmt_delete);

header("Location: index.php#anime-table");
exit();

?>