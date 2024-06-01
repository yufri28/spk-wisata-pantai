-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Jun 2024 pada 04.35
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_wisata_pantai`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alternatif`
--

CREATE TABLE `alternatif` (
  `id_alternatif` int(5) NOT NULL,
  `nama_alternatif` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `rating` int(1) NOT NULL,
  `biaya_alt` int(11) NOT NULL,
  `fasilitas_alt` text NOT NULL,
  `jarak_alt` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `nama_alternatif`, `alamat`, `gambar`, `latitude`, `longitude`, `rating`, `biaya_alt`, `fasilitas_alt`, `jarak_alt`) VALUES
(66, 'Coba Pantai', 'Tes saja', '2aab7b29f4d7b823e3e8c195e3f44f25.png', '-9.865149346683376', '124.41281113776452', 3, 3000, 'Kamar mandi aja', '0.50'),
(67, 'Halo Dek', 'Coba dulu', 'd74d3e7a4720060c14d9136e2454fd53.png', '-9.566116506971282', '124.2166851193804', 3, 1000, 'Kamar anak dan Kamar Orang Tua', '0.10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kecocokan_alt_kriteria`
--

CREATE TABLE `kecocokan_alt_kriteria` (
  `id_alt_kriteria` int(11) NOT NULL,
  `f_id_alternatif` int(5) NOT NULL,
  `f_id_kriteria` char(2) NOT NULL,
  `f_id_sub_kriteria` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kecocokan_alt_kriteria`
--

INSERT INTO `kecocokan_alt_kriteria` (`id_alt_kriteria`, `f_id_alternatif`, `f_id_kriteria`, `f_id_sub_kriteria`) VALUES
(265, 66, 'C1', 10),
(266, 66, 'C2', 11),
(267, 66, 'C3', 1),
(268, 66, 'C4', 29),
(269, 66, 'C5', 34),
(270, 67, 'C1', 9),
(271, 67, 'C2', 11),
(272, 67, 'C3', 1),
(273, 67, 'C4', 29),
(274, 67, 'C5', 36);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` char(2) NOT NULL,
  `nama_kriteria` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `nama_kriteria`) VALUES
('C1', 'Fasilitas'),
('C2', 'Jarak dari pusat kota'),
('C3', 'Biaya'),
('C4', 'Keamanan'),
('C5', 'Kebersihan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login_user`
--

CREATE TABLE `login_user` (
  `id_login` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `login_user`
--

INSERT INTO `login_user` (`id_login`, `username`, `password`, `level`) VALUES
(1, 'admin', '$2y$10$o9rw1S2HbWQolaKF3XKDdeu2B4fsebEq35Ca0KTwmytsi3tud1HCC', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id_sub_kriteria` int(5) NOT NULL,
  `nama_sub_kriteria` varchar(25) NOT NULL,
  `spesifikasi` text NOT NULL,
  `bobot_sub_kriteria` int(5) NOT NULL,
  `f_id_kriteria` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id_sub_kriteria`, `nama_sub_kriteria`, `spesifikasi`, `bobot_sub_kriteria`, `f_id_kriteria`) VALUES
(1, 'Sangat murah', 'Rp. 0 - 3.000', 5, 'C3'),
(2, 'Murah', 'Rp. &gt;3.000 - 6.000', 4, 'C3'),
(3, 'Sedang', 'Rp. &gt;6.000 - 9.000', 3, 'C3'),
(4, 'Mahal', 'Rp. &gt;9.000 - 12.000', 2, 'C3'),
(5, 'Sangat mahal', '&gt; Rp.12.000 - 15.000', 1, 'C3'),
(6, 'Sangat lengkap', 'Jika memenuhi 5 item dari fasilitas berikut ini: Kamar mandi, tempat parkir, area food court, tempat sampah, gazebo.', 5, 'C1'),
(7, 'Lengkap', 'Jika memenuhi 4 item dari fasilitas berikut ini: Kamar mandi, tempat parkir, area food court, tempat sampah, gazebo.', 4, 'C1'),
(8, 'Cukup lengkap', 'Jika memenuhi 3 item dari fasilitas berikut ini: Kamar mandi, tempat parkir, area food court, tempat sampah, gazebo. ', 3, 'C1'),
(9, 'Kurang lengkap', 'Jika memenuhi 2 item dari fasilitas berikut ini: Kamar mandi, tempat parkir, area food court, tempat sampah, gazebo.', 2, 'C1'),
(10, 'Tidak lengkap', 'Jika memenuhi 1 item dari fasilitas berikut ini: Kamar mandi, tempat parkir, area food court, tempat sampah, gazebo.', 1, 'C1'),
(11, 'Sangat dekat', '0 - 30 Km', 5, 'C2'),
(12, 'Dekat', '&gt; 30 - 60 Km', 4, 'C2'),
(13, 'Sedang', '&gt; 60 - 90 Km', 3, 'C2'),
(14, 'Jauh', '&gt; 90 - 120 Km', 2, 'C2'),
(15, 'Sangat jauh', '&gt; 120 - 150 Km', 1, 'C2'),
(29, 'Sangat Aman', 'Keamanan Sangat Lengkap', 5, 'C4'),
(30, 'Cukup Aman', 'Keamanan Cukup Lengkap', 3, 'C4'),
(31, 'Aman', 'Keamanan Lengkap', 4, 'C4'),
(32, 'Tidak Aman', 'Keamanan Tidak Lengkap', 2, 'C4'),
(33, 'Sangat Tidak Aman', 'Tidak Ada Keamanan', 1, 'C4'),
(34, 'Sangat Bersih', 'Sangat Dijaga Kebersihannya', 5, 'C5'),
(35, 'Bersih', 'Kebersihannya dijaga', 4, 'C5'),
(36, 'Cukup Bersih', 'Kebersihannya Cukup Dijaga', 3, 'C5'),
(37, 'Tidak Bersih', 'Tidak Dijaga Kebersihannya', 2, 'C5'),
(38, 'Sangat Tidak Bersih', 'Sangat Tidak Dijaga Kebersihannya', 1, 'C5');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indeks untuk tabel `kecocokan_alt_kriteria`
--
ALTER TABLE `kecocokan_alt_kriteria`
  ADD PRIMARY KEY (`id_alt_kriteria`),
  ADD KEY `f_id_alternatif` (`f_id_alternatif`),
  ADD KEY `f_id_kriteria` (`f_id_kriteria`),
  ADD KEY `f_id_sub_kriteria` (`f_id_sub_kriteria`);

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `login_user`
--
ALTER TABLE `login_user`
  ADD PRIMARY KEY (`id_login`);

--
-- Indeks untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id_sub_kriteria`),
  ADD KEY `f_id_kriteria` (`f_id_kriteria`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id_alternatif` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT untuk tabel `kecocokan_alt_kriteria`
--
ALTER TABLE `kecocokan_alt_kriteria`
  MODIFY `id_alt_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=275;

--
-- AUTO_INCREMENT untuk tabel `login_user`
--
ALTER TABLE `login_user`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_sub_kriteria` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kecocokan_alt_kriteria`
--
ALTER TABLE `kecocokan_alt_kriteria`
  ADD CONSTRAINT `kecocokan_alt_kriteria_ibfk_1` FOREIGN KEY (`f_id_sub_kriteria`) REFERENCES `sub_kriteria` (`id_sub_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kecocokan_alt_kriteria_ibfk_2` FOREIGN KEY (`f_id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kecocokan_alt_kriteria_ibfk_3` FOREIGN KEY (`f_id_alternatif`) REFERENCES `alternatif` (`id_alternatif`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD CONSTRAINT `sub_kriteria_ibfk_1` FOREIGN KEY (`f_id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
