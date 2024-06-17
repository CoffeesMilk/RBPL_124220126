-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Jun 2024 pada 16.28
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `variasiomega`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barangmasuk`
--

CREATE TABLE `barangmasuk` (
  `id` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `tgl_masuk` varchar(50) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `jumlah_barang` int(11) NOT NULL,
  `jenis_barang` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barangmasuk`
--

INSERT INTO `barangmasuk` (`id`, `id_barang`, `tgl_masuk`, `nama_barang`, `jumlah_barang`, `jenis_barang`) VALUES
(4, 1, '18/05/2024', 'Seeutek GT Wing', 2, 'Spoiler'),
(5, 2, '18/05/2024', 'ZZDSNJ Glossy Black Chevrolet Camaro ZL1 1LE', 1, 'Spoiler'),
(33, 1, '19/05/2024', 'Seeutek GT Wing', 2, 'Spoiler'),
(39, 13, '19/05/2024', 'Kaca Film Hitam 20', 2, 'Kaca Film'),
(40, 14, '20/05/2024', 'Kaca Film Hitam 35', 5, 'Kaca Film'),
(41, 14, '20/05/2024', 'Kaca Film Hitam 35', 2, 'Kaca Film'),
(42, 1, '30/05/2024', 'Seeutek GT Wing', 1, 'Spoiler'),
(44, 13, '30/05/2024', 'Kaca Film Hitam 20', 1, 'Kaca Film'),
(45, 13, '06/06/2024', 'Kaca Film Hitam 20', 2, 'Kaca Film'),
(48, 2, '07/06/2024', 'ZZDSNJ Glossy Black Chevrolet Camaro ZL1 1LE', 1, 'Spoiler'),
(51, 2, '07/06/2024', 'ZZDSNJ Glossy Black Chevrolet Camaro ZL1 1LE', 1, 'Spoiler'),
(59, 1, '07/06/2024', 'Seeutek GT Wing', 1, 'Spoiler'),
(60, 2, '07/06/2024', 'ZZDSNJ Glossy Black Chevrolet Camaro ZL1 1LE', 1, 'Spoiler'),
(65, 3, '07/06/2024', 'Brembo', 3, 'Rem mobil'),
(77, 1, '17/06/2024', 'Seeutek GT Wing', 1, 'Spoiler'),
(78, 1, '17/06/2024', 'Seeutek GT Wing', 0, 'Spoiler'),
(80, 4, '17/06/2024', 'Kaca Spion Avanza Xenia', 2, 'Spion');

-- --------------------------------------------------------

--
-- Struktur dari tabel `databarang`
--

CREATE TABLE `databarang` (
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `jumlah_barang` int(11) NOT NULL,
  `jenis_barang` varchar(50) NOT NULL,
  `harga_barang` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `databarang`
--

INSERT INTO `databarang` (`id_barang`, `nama_barang`, `jumlah_barang`, `jenis_barang`, `harga_barang`) VALUES
(1, 'Seeutek GT Wing', 6, 'Spoiler', 500000),
(2, 'ZZDSNJ Glossy Black Chevrolet Camaro ZL1 1LE', 2, 'Spoiler', 2000000),
(3, 'Brembo', 3, 'Rem mobil', 5000000),
(4, 'Kaca Spion Avanza Xenia', 4, 'Spion', 0),
(13, 'Kaca Film Hitam 20', 4, 'Kaca Film', 200000),
(14, 'Kaca Film Hitam 35', 6, 'Kaca Film', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `no_bon` varchar(50) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `tgl_pesanan` varchar(50) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `jumlah_barang` int(11) NOT NULL,
  `jenis_barang` varchar(50) NOT NULL,
  `total_harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id`, `no_bon`, `id_barang`, `tgl_pesanan`, `nama_barang`, `jumlah_barang`, `jenis_barang`, `total_harga`) VALUES
(15, '12233', 1, '08/05/2024', 'Seeutek GT Wing', 2, 'Spoiler', 2000000),
(16, '11111', 3, '09/05/2024', 'Brembo', 2, 'Rem mobil', 10000000),
(17, '11111', 2, '09/05/2024', 'ZZDSNJ Glossy Black Chevrolet Camaro ZL1 1LE', 3, 'Spoiler', 6000000),
(19, '12345', 1, '22/05/2024', 'Seeutek GT Wing', 1, 'Spoiler', 1000000),
(20, '12345', 1, '30/05/2024', 'Seeutek GT Wing', 2, 'Spoiler', 2000000),
(21, '12345', 1, '30/05/2024', 'Seeutek GT Wing', 2, 'Spoiler', 2000000),
(24, '22222', 1, '07/06/2024', 'Seeutek GT Wing', 2, 'Spoiler', 2000000),
(25, '22222', 13, '07/06/2024', 'Kaca Film Hitam 20', 1, 'Kaca Film', 200000),
(26, '9999', 3, '17/06/2024', 'Brembo', 2, 'Rem mobil', 10000000),
(27, '55285', 3, '17/06/2024', 'Brembo', 2, 'Rem mobil', 10000000),
(28, '55285', 2, '17/06/2024', 'ZZDSNJ Glossy Black Chevrolet Camaro ZL1 1LE', 3, 'Spoiler', 6000000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `roles` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `roles`) VALUES
(1, 'Yeti', 'Yeti123', 'Manajer'),
(2, 'Wahyu', 'wahyu123', 'Staff Gudang'),
(3, 'Dian', 'D123', 'Kasir');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barangmasuk`
--
ALTER TABLE `barangmasuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_masuk` (`id_barang`);

--
-- Indeks untuk tabel `databarang`
--
ALTER TABLE `databarang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_keluar` (`id_barang`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barangmasuk`
--
ALTER TABLE `barangmasuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT untuk tabel `databarang`
--
ALTER TABLE `databarang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barangmasuk`
--
ALTER TABLE `barangmasuk`
  ADD CONSTRAINT `barang_masuk` FOREIGN KEY (`id_barang`) REFERENCES `databarang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `barang_keluar` FOREIGN KEY (`id_barang`) REFERENCES `databarang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
