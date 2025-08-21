 <?php
    session_start();
    include "koneksi.php";

    // Ambil nilai filter dari URL
    $selected_genre = isset($_GET['genre']) ? mysqli_real_escape_string($koneksi, $_GET['genre']) : '';
    $selected_tahun = isset($_GET['tahun']) ? mysqli_real_escape_string($koneksi, $_GET['tahun']) : '';
    $selected_studio = isset($_GET['studio']) ? mysqli_real_escape_string($koneksi, $_GET['studio']) : '';
    $search_query = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';

    // query dasar
    $sql = "SELECT * FROM anime";
    $conditions = [];

    //  kondisi WHERE berdasarkan filter
    if (!empty($selected_genre)) {
        $conditions[] = "genre = '$selected_genre'";
    }
    if (!empty($selected_tahun)) {
        $conditions[] = "year = '$selected_tahun'";
    }
    if (!empty($selected_studio)) {
        $conditions[] = "studio = '$selected_studio'";
    }
    if (!empty($search_query)) {
        $conditions[] = "(tittle LIKE '%$search_query%' OR description LIKE '%$search_query%')"; 
    }

    // Gabungkan kondisi

    if (count($conditions) > 0) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }

    // Ambil query untuk daftar anime (filter)
    $ambildata = mysqli_query($koneksi, $sql);

    // --- Query Anime Populer Start ---
    
    $sql_populer = "SELECT * FROM anime ORDER BY id ASC LIMIT 3"; 
    $hasil_populer = mysqli_query($koneksi, $sql_populer);
    
    // --- Query Anime Populer End ---

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AniGrid | Beranda</title>

    <!-- CSS Boostrap -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
      crossorigin="anonymous"
    />

    <!-- CSS Eksternal -->
    <link rel="stylesheet" href="css/index.css" />

    <!-- Boostrap Icon -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />

  </head>
  <body>
    <!-- Navbar Start -->

    <nav
      class="fixed-top navbar navbar-dark bg-dark navbar-expand-lg bg-body-tertiary p-3"
    >
      <div class="container">
        <p class="navbar-brand mb-0 text-light fs-3 fw-bold">
          Ani<span style="color: #cbbaff">Grid</span>
        </p>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarTogglerDemo02"
          aria-controls="navbarTogglerDemo02"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
          <ul class="navbar-nav ms-auto me-5 mb-2 mb-lg-0 fw-light fs-5">
            <li class="nav-item">
              <a class="nav-link" href="#beranda">Beranda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#tentang-kami">Tentang Kami</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#daftar-anime">Daftar Anime</a>
            </li>
          </ul>

          <!-- Button Navbar Dinamis Start -->

          <!-- Cek User Sudah login -->

          <?php if (isset($_SESSION['user_id'])): ?>

              <!-- Jika Sudah, Tampil Button Dashboard dan Logout -->

              <div class="d-none d-lg-flex gap-3">
                  <a class="btn btn-outline-info" href="users/dashboard/index.php">Dashboard</a>
                  <a class="btn btn-outline-danger" href="logout.php">Logout</a>
              </div>
              <div class="d-flex d-lg-none flex-column gap-3 mt-3">
                  <a class="btn btn-outline-info w-100" href="users/dashboard/index.php">Dashboard</a>
                  <a class="btn btn-outline-danger w-100" href="logout.php">Logout</a>
              </div>


            <!-- Jika User Belum Login -->
          <?php else:  ?>
              <!-- Jika Belum, Tampil Button Daftar dan Masuk -->
              <div class="d-none d-lg-flex gap-3">
                  <a class="btn btn-outline-light" href="daftar.php">Daftar</a>
                  <a class="btn btn-light text-dark" href="login.php">Masuk</a>
              </div>
              <div class="d-flex d-lg-none flex-column gap-3 mt-3">
                  <a class="btn btn-outline-light w-100" href="daftar.php">Daftar</a>
                  <a class="btn btn-light w-100 text-dark" href="login.php">Masuk</a>
              </div>
          <?php endif; ?>
          <!-- Button Navbar Dinamis End -->

        </div>
      </div>
    </nav>

    <!-- Navbar End -->

    <!-- Carousel Start -->

    <section class="head-caraousel" id="beranda">
      <div
        id="carouselExampleAutoplaying"
        class="carousel slide"
        data-bs-ride="carousel"
      >
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="img/aot-populer.jpeg" class="d-block w-100" alt="..." />
          </div>
          <div class="carousel-item">
            <img src="img/demon-populer.jpeg" class="d-block w-100" alt="..." />
          </div>
          <div class="carousel-item">
            <img src="img/jujutsu-populer.jpeg" class="d-block w-100" alt="..." />
          </div>
        </div>
        <button
          class="carousel-control-prev"
          type="button"
          data-bs-target="#carouselExampleAutoplaying"
          data-bs-slide="prev"
        >
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button
          class="carousel-control-next"
          type="button"
          data-bs-target="#carouselExampleAutoplaying"
          data-bs-slide="next"
        >
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </section>

    <!-- Carousel End -->

    <!-- Section Tentang Kami Start -->

    <section class="tentang-kami" id="tentang-kami">
      <div class="tentang-img-container sca1">
        <img src="img/actor-anime.png" alt="Karakter" />
      </div>
      <div class="tentang-kami-text sca1">
        <h1 class="fw-bold text-light">
          Tentang <span style="color: #e9d8a6">Kami</span>
        </h1>
        <p class="fw-light">
          Didesain untuk penggemar anime yang ingin pengalaman menonton lebih
          praktis. AniGrid menawarkan sistem grid yang memudahkan pencarian
          anime, pengelolaan playlist, dan penemuan judul.
        </p>
      </div>
    </section>

    <!-- Section Tentang Kami End -->

    <!-- Section Anime Populer Start -->

    <section class="anime-terpopuler" id="anime-terpopuler">
      <div class="container sca2">
        <h1>Anime <span>Terpopuler</span></h1>
        <div class="card-grid">
          <?php 
            // Perulangan data anime populer
            if ($hasil_populer && mysqli_num_rows($hasil_populer) > 0) {
                while ($populer = mysqli_fetch_assoc($hasil_populer)) { 
          ?>
            <a href="detail_anime.php?id=<?php echo $populer['id']; ?>" class="card text-decoration-none text-white bg-dark"> <!-- Tautan ke detail -->
                <img class="mb-3 card-img-top-populer" 
                     src="img/img-anime/<?php echo htmlspecialchars($populer['thumbnail']); ?>" 
                     alt="<?php echo htmlspecialchars($populer['tittle']); ?>">
                <div class="card-body-populer px-3 pb-3">
                    <h3 class="fw-bold fs-5 mb-2"><?php echo htmlspecialchars($populer['tittle']); ?></h3>
                    <p class="fs-6 fw-light"><?php echo htmlspecialchars(substr($populer['description'], 0, 40)); ?></p>
                </div>
            </a>
          <?php 
                }
            } else {
                echo "<p class='text-white'>Data anime populer tidak tersedia.</p>";
            }
          ?>
        </div>
      </div>
    </section>

    <!-- Section Anime Populer End -->

    <!-- Section Daftar Anime Start -->

    <section class="daftar-anime" id="daftar-anime">
      <div class="container">
        <h1 class="fw-bold mb-4 sca2">
          <span class="text-warning">Daftar</span> Anime
        </h1>

        <!-- Dropdown Filter Start -->
        <form action="#daftar-anime" method="GET" class="row mb-4 sca3">
          <div class="col-md-3 mb-3">
            <select name="genre" class="form-select text-light fs-4 ps-3 bg-dark border-secondary">
              <option value="">Semua Genre</option>
              <option value="Action" <?php echo ($selected_genre == 'Action') ? 'selected' : ''; ?>>Action</option>
              <option value="Romance" <?php echo ($selected_genre == 'Romance') ? 'selected' : ''; ?>>Romance</option>
              <option value="Fantasy" <?php echo ($selected_genre == 'Fantasy') ? 'selected' : ''; ?>>Fantasy</option>
              <option value="Adventure" <?php echo ($selected_genre == 'Adventure') ? 'selected' : ''; ?>>Adventure</option>
            </select>
          </div>
          <div class="col-md-3 mb-3">
            <select name="tahun" class="form-select text-light fs-4 ps-3 bg-dark border-secondary">
              <option value="">Semua Tahun</option>
              <option value="2024" <?php echo ($selected_tahun == '2024') ? 'selected' : ''; ?>>2024</option>
              <option value="2023" <?php echo ($selected_tahun == '2023') ? 'selected' : ''; ?>>2023</option>
              <option value="2022" <?php echo ($selected_tahun == '2022') ? 'selected' : ''; ?>>2022</option>
            </select>
          </div>
          <div class="col-md-3 mb-3">
            <select name="studio" class="form-select text-light fs-4 ps-3 bg-dark border-secondary">
              <option value="">Semua Studio</option>
              <option value="MAPPA" <?php echo ($selected_studio == 'MAPPA') ? 'selected' : ''; ?>>MAPPA</option>
              <option value="Ufotable" <?php echo ($selected_studio == 'Ufotable') ? 'selected' : ''; ?>>Ufotable</option>
               <option value="Wit Studio" <?php echo ($selected_studio == 'Wit Studio') ? 'selected' : ''; ?>>Wit Studio</option>
            </select>
          </div>
          <div class="col-md-3 mb-3 d-flex">
            <input
              type="text"
              name="search"
              class="form-control text-light me-2 fs-4 ps-3 bg-dark border-secondary"
              placeholder="Cari"
              value="<?php echo htmlspecialchars($search_query); ?>"
            />
            <button type="submit" class="fs-4 btn btn-outline-success">
              <i class="bi bi-search"></i>
            </button>
          </div>
        </form>

        <!-- Card List -->
         <div class="row g-4 ">
            <?php

            // Cek query berhasil dan ada data
            if ($ambildata && mysqli_num_rows($ambildata) > 0) {
                while ( $tampildata = mysqli_fetch_array($ambildata) ) { 
            ?>
                <!-- Card Item Start -->
                <div class="col-6 col-md-4 col-lg-3">
                  <div class="card bg-dark text-white border-0 h-100">
                    <img
                     src="img/img-anime/<?php echo htmlspecialchars($tampildata['thumbnail']); ?>"
                     class="card-img-top"
                     alt="<?php echo htmlspecialchars($tampildata['tittle']); ?>"
                     style="height: 300px; object-fit: cover;"
                    />
                    <div class="card-body p-2 mt-2 d-flex flex-column">
                     <h5 class="card-title text-light fw-semibold mb-1 fs-5 flex-grow-1"><?php echo htmlspecialchars($tampildata['tittle']); ?></h5>
                     <p class="card-text fw-light text-light small"><?php echo htmlspecialchars(substr($tampildata['description'], 0, 50)) . '...'; ?></p>
                     <a href="detail_anime.php?id=<?php echo $tampildata['id']; ?>" class="btn btn-sm btn-primary mt-auto align-self-start">Detail</a>
                    </div>
                  </div>
                </div>
                <!-- Card Item End -->
            <?php 
                }
            }
            
            // Tampilkan pesan jika tidak ada data yang cocok
            else {
                echo "<p class='text-white text-center col-12'>Tidak ada anime yang cocok dengan kriteria pencarian Anda.</p>";
            }
            ?>
         </div>
        
      </div>
    </section>

    <!-- Section Daftar Anime End -->

    <!-- Footer Start -->

    <footer class="section-footer" id="footer">
      <div class="container container-footer text-center text-white">
        <div class="mb-3 d-flex justify-content-center gap-5">
          <a href="https://www.instagram.com/adzzz_21?igsh=MW9ibGg1d2Z4OHZocw==" target="_blank"
            ><i class="bi bi-instagram fs-1 text-white"></i
          ></a>
          <a href="https://github.com/MDafaAdiwinata" target="_blank"
            ><i class="bi bi-github fs-1 text-white"></i
          ></a>
          <a href="https://linkedin.com/in/adzzz" target="_blank"
            ><i class="bi bi-linkedin fs-1 text-white"></i
          ></a>
        </div>
        <div
          class="footer-link d-flex flex-column flex-md-row justify-content-center align-items-center gap-3 gap-md-5 mb-3"
        >
          <a
            class="text-white fw-bold fs-5 text-decoration-none"
            href="#beranda"
            >Beranda</a
          >
          <a
            class="text-white fw-bold text-decoration-none fs-5"
            href="#tentang-kami"
            >Tentang Kami</a
          >
          <a
            class="text-white fw-bold text-decoration-none fs-5"
            href="#daftar-anime"
            >Daftar Anime</a
          >

          <!-- Tombol Footer Dinamis -->

          <?php if (isset($_SESSION['user_id'])): ?>

<!-- Jika Sudah, Tampil Button Dashboard dan Logout -->

<a
            class="text-white fw-bold text-decoration-none fs-5"
            href="users/dashboard/index.php"
            >Dashboard</a
          >
          <a
            class="text-white fw-bold text-decoration-none fs-5"
            href="logout.php"
            >Logout</a
          >


<!-- Jika User Belum Login -->
<?php else:  ?>
<!-- Jika Belum, Tampil Button Daftar dan Masuk -->
<a
            class="text-white fw-bold text-decoration-none fs-5"
            href="login.php"
            >Login</a
          >
          <a
            class="text-white fw-bold text-decoration-none fs-5"
            href="daftar.php"
            >Daftar</a
          >
<?php endif; ?>

        </div>
        <div class="fs-5 fw-light">
          Created by <span class="fw-bold">Adi X - RPL</span> | © 2025
        </div>
      </div>
    </footer>

    <!-- Footer End -->

    <!-- Script Boostrap -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
      crossorigin="anonymous"
    ></script>
  </body>
</html>