-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql202.infinityfree.com
-- Waktu pembuatan: 21 Agu 2025 pada 06.25
-- Versi server: 11.4.7-MariaDB
-- Versi PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_38768907_db_anigrid`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `anime`
--

CREATE TABLE `anime` (
  `id` int(11) NOT NULL,
  `tittle` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `studio` varchar(255) NOT NULL,
  `year` year(4) NOT NULL,
  `description` text NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `video_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `anime`
--

INSERT INTO `anime` (`id`, `tittle`, `genre`, `studio`, `year`, `description`, `thumbnail`, `video_url`) VALUES
(1, 'Chainsaw Man', 'Action, Fantasy', 'MAPPA', 2022, 'Denji, seorang pemuda miskin, bekerja sebagai pemburu iblis untuk melunasi hutang ayahnya.', 'chainsawman.jpg', 'https://www.youtube.com/embed/d1n552v1ng0?si=LMkJ8hQgucCe7hWz'),
(2, 'Jujutsu Kaisen', 'Action, Supernatural', 'MAPPA', 2023, 'Yuji Itadori dan teman-temannya bertarung melawan kutukan di dunia sihir yang keras.', 'jujutsukaisen.jpg', 'https://www.youtube.com/embed/pkKu9hLT-t8?si=gBU6avdG6DiK-hqi'),
(3, 'Attack on Titan', 'Action, Fantasy', 'MAPPA', 2023, 'Pertempuran terakhir antara umat manusia dan para Titan untuk bertahan hidup.', 'attackontitan.jpg', 'https://www.youtube.com/embed/3xNH23QkNpk?si=Ki3zxxdx5TVR4D7u'),
(4, 'Demon Slayer', 'Action, Adventure', 'Ufotable', 2023, 'Tanjiro Kamado bertarung melawan iblis untuk menyelamatkan adiknya.', 'demonslayer.jpg', 'https://www.youtube.com/embed/wyiZWYMilgk?si=qDh_FfL0rnQvr-h8'),
(5, 'Vinland Saga', 'Action, Adventure', 'MAPPA', 2023, 'Thorfinn, pejuang muda dari tanah Viking, berjuang mencari arti hidup sejati.', 'vinlandsaga.jpg', 'https://www.youtube.com/embed/f8JrZ7Q_p-8?si=5yq-1HGfGbG33rFI'),
(6, 'Hell\\\'s Paradise', 'Action, Fantasy', 'MAPPA', 2023, 'Seorang ninja yang hampir abadi harus menjalani misi di pulau misterius yang penuh bahaya.', 'hellsparadise.jpg', 'https://www.youtube.com/embed/693vXHCGu-M?si=e_01XPa70D3UTUm0'),
(7, 'Dorohedoro', 'Action, Fantasy', 'MAPPA', 2022, 'Caiman, manusia kadal, memburu penyihir untuk mengungkap masa lalunya.', 'dorohedoro.jpg', 'https://www.youtube.com/embed/ry-jzv18fOY?si=sB0H9vJvRog9E-PE'),
(8, 'Ranking of Kings', 'Adventure, Fantasy', 'Wit Studio', 2022, 'Pangeran tuli dan bisu bernama Bojji berjuang keras untuk menjadi raja terbaik.', 'rankingofkings.jpg', 'https://www.youtube.com/embed/lgeeNcL51A4?si=419DHVsi-lTGcYc0'),
(9, 'Spy x Family', 'Action, Comedy', 'Wit Studio', 2022, 'Mata-mata membentuk keluarga palsu demi menyelesaikan misi negara.', 'spyxfamily.jpg', 'https://www.youtube.com/embed/CCXLUQzuigw?si=m3yH80Hg7p7_F-y9'),
(10, 'Fate/stay night: Heaven\\\'s Feel', 'Action, Romance', 'Ufotable', 2022, 'Pertarungan epik antara penyihir dan roh pahlawan dalam Perang Cawan Suci.', 'fateheavensfeel.jpg', 'https://www.youtube.com/embed/AMr5pXzpvP0?si=zurkVAm0oiSgkM92'),
(11, 'Fate/Grand Order: Babylonia', 'Action, Fantasy', 'Ufotable', 2022, 'Ritsuka Fujimaru dan Mash Kyrielight melawan dewa-dewa kuno di Babilonia.', 'fatebabylonia.jpg', 'https://www.youtube.com/embed/BIZN34WMi5E?si=jnCb1kd4tyGrr3GK'),
(12, 'Bucchigiri?!', 'Action, Fantasy', 'MAPPA', 2024, 'Siswa SMA terlibat dalam pertarungan penuh kekuatan misterius.', 'bucchigiri.jpg', 'https://www.youtube.com/embed/Kw6JkejW_Hw?si=OEwd2gCtAZHKyI41'),
(13, 'Project Bullet/Bullet', 'Action, Fantasy', 'MAPPA', 2024, 'Cerita orisinal dengan visual intens tentang dunia peluru dan sihir.', 'projectbullet.jpg', 'https://www.youtube.com/embed/kixv4DqBbxc?si=9kbnQn6lL8ImbIqj'),
(14, 'Blue Lock', 'Action, Sports', 'Wit Studio', 2022, 'Persaingan keras antara striker Jepang untuk menjadi pemain terbaik dunia.', 'bluelock.jpg', 'https://www.youtube.com/embed/p2QriyWhK00?si=kfqwihZYoHkanTvF'),
(15, 'The Girl from the Other Side', 'Fantasy, Romance', 'Wit Studio', 2022, 'Hubungan magis antara gadis kecil dan makhluk misterius di dunia terkutuk.', 'thegirlotherside.jpg', 'https://www.youtube.com/embed/HPQin-uuI9o?si=Uk2tZ93eH8-hAOzd'),
(16, 'Ousama Ranking: Treasure Chest', 'Fantasy, Adventure', 'Wit Studio', 2023, 'Petualangan lanjutan Bojji setelah naik tahta dengan tantangan baru.', 'ousamaranking.jpg', 'https://www.youtube.com/embed/itswZ3iHRSY?si=dWCVLyM-r1U93m0W'),
(17, 'Mahoutsukai no Yome: Season 2', 'Fantasy, Romance', 'Wit Studio', 2023, 'Chise melanjutkan hidup barunya di dunia sihir bersama Elias.', 'mahoutsukai.jpg', 'https://www.youtube.com/embed/GL59JHo__wE?si=zEz1QcMz-alSaRRy'),
(18, 'Demon Slayer: Hashira Training Arc', 'Action, Adventure', 'Ufotable', 2024, 'Hashira melatih para pembasmi iblis sebelum perang besar.', 'hashiratraining.jpg', 'https://www.youtube.com/embed/rq1tllAUS1I?si=40SLEl2dPmjnewsa'),
(19, 'Fate/Strange Fake: Whispers of Dawn', 'Action, Fantasy', 'Ufotable', 2023, 'Perang Cawan Suci baru dimulai di kota Snowfield dengan pahlawan baru.', 'fatestrangefake.jpg', 'https://www.youtube.com/embed/RNFbMn25CGg?si=PXFdEwqRc-0ghR8g'),
(20, 'Vivy: Fluorite Eye\\\'s Song', 'Action, Sci-Fi', 'Wit Studio', 2022, 'AI bernama Vivy menjalani misi menyelamatkan masa depan umat manusia.', 'vivy.jpg', 'https://www.youtube.com/embed/Y653dJQ_ecs?si=rumZxatpEtFxx1ej');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'adi', 'adi@gmail.com', '$2y$10$5xkMKsdktr6XejpbeVGNtO1/.shk7F8LA3hDafcZ2mQGJPrug/2dq'),
(2, 'sidney', 'sidney@gmail.com', '$2y$10$g05stMFEuO3qwmf6/6IgieOrsnGx6.p/0frYUdlj1vvKJStUT0rQa'),
(3, 'Abdul Ganteng', 'ghaniyyalba123r@gmail.com', '$2y$10$rNelPL4WMkLWRQreDboopudZx5ur2/QWcTsMIM/hHGTja9kTVMgK.'),
(4, 'hasan13', 'hasan13@gmail.com', '$2y$10$vS2dxIwILKtPC/tWMMz.1uE85u2Nt3h/nfAhZc2dsoooeTPImZJu.'),
(5, 'hasan23', 'hasan23@gmail.com', '$2y$10$ucjvk36Ctf2uQyvFzHVrwOseAm6qobUtQPPwDCX9/UVf8JkaDX5eK'),
(6, 'Nabil', 'raffiwork875@gmail.com', '$2y$10$YEXkU065qP//f.6/xbErMuBYBDlNELZtcnvWr4XdoehQ3PzyV9U8C'),
(7, 'Danish ganteng ', 'razapangestu123@gmail.com', '$2y$10$MIhZgCcXf6wheaLhxqxV9OXP68nr7Nq8B3x9VY3jwtokvAjP0Jcu6'),
(8, 'woldin88', 'woldin@gmail.com', '$2y$10$vs0vjhhWfJiiSaqo.DoJOuIBqTvLEUE/5GjZlttxM4YVLG7WorhRG'),
(9, 'reisan', 'reisan@gmail.com', '$2y$10$hHBDOPGXb7FLg1qtvKmWO.Qmv1M9EVtSFTnCNZRdtempI1QkrLDsO'),
(10, '20615196', 'patrixmueller@gmail.com', '$2y$10$lnO96ObGFTL8IZNv5XMrLe4lu6wR11GnCGjpCla2SZes6QesQu7ZK');

-- --------------------------------------------------------

--
-- Struktur dari tabel `watchlist`
--

CREATE TABLE `watchlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `anime_id` int(11) NOT NULL,
  `added_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `watchlist`
--

INSERT INTO `watchlist` (`id`, `user_id`, `anime_id`, `added_at`) VALUES
(11, 5, 2, '2025-04-26 08:42:47'),
(12, 8, 3, '2025-05-20 07:45:13');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `anime`
--
ALTER TABLE `anime`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `watchlist`
--
ALTER TABLE `watchlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_watchlist_entry` (`user_id`,`anime_id`),
  ADD KEY `fk_watchlist_anime` (`anime_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `anime`
--
ALTER TABLE `anime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `watchlist`
--
ALTER TABLE `watchlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `watchlist`
--
ALTER TABLE `watchlist`
  ADD CONSTRAINT `fk_watchlist_anime` FOREIGN KEY (`anime_id`) REFERENCES `anime` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_watchlist_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `watchlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `watchlist_ibfk_2` FOREIGN KEY (`anime_id`) REFERENCES `anime` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
