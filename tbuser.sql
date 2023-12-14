-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Des 2023 pada 15.23
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbuts_m_ade_ilham_w`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbuser`
--

CREATE TABLE `tbuser` (
  `id` int(11) NOT NULL,
  `nama` varchar(40) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `user_role` enum('pembeli','penjual','admin') DEFAULT 'pembeli'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbuser`
--

INSERT INTO `tbuser` (`id`, `nama`, `email`, `password`, `user_role`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$GyDuZO2wGy0WLMl4a7LnVOwpkOQXniTW5d7HnBtQUEx5gM5sPNx4m', 'admin'),
(2, 'irazawa', 'irazawayui@gmail.com', '$2y$10$.dkD6PXYzVyFsScY8hTiKuiSTjYFk9H5jID3t6vO4.XRD2zPYvBtm', 'admin'),
(7, 'pembeli', 'pembeli@gmail.com', '$2y$10$F.AjPDbGLKW4LRrkkl5TIuCN0eQodzr6PQGFfdrsU.wHzZ.L6/.fi', 'pembeli'),
(8, 'penjual', 'penjual@gmail.com', '$2y$10$lPFQe3T.3YmQJ/weAXWTMOIEXOl2jtZMM6sGQSyGVTzuufU5APXvC', 'penjual');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbuser`
--
ALTER TABLE `tbuser`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbuser`
--
ALTER TABLE `tbuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
