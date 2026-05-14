-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Bulan Mei 2026 pada 16.47
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `kode_buku` varchar(20) NOT NULL,
  `judul_buku` varchar(50) NOT NULL,
  `pengarang` varchar(40) NOT NULL,
  `kategori` varchar(20) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id_buku`, `kode_buku`, `judul_buku`, `pengarang`, `kategori`, `stok`) VALUES
(1, 'BK001', 'Laskar Pelangi', 'Andrea Hirata', 'Fiksi', 4),
(2, 'BK002', 'Bumi Manusia', 'Pramoedya Ananta Toer', 'Sejarah', 3),
(3, 'BK003', 'Fisika Dasar', 'Halliday & Resnick', 'Sains', 1),
(4, 'BK004', 'Sejarah Dunia', 'E.H. Gombrich', 'Sejarah', 2),
(5, 'BK005', 'Pemrograman PHP', 'Raharjo', 'Teknologi', 11),
(6, 'BK006', 'Algoritma dan Struktur Data', 'Sukamto', 'Teknologi', 24),
(7, 'BK007', 'Negeri 5 Menara', 'Ahmad Fuadi', 'Fiksi', 17);

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE `login` (
  `id` int(10) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `login`
--

INSERT INTO `login` (`id`, `username`, `password`) VALUES
(1, 'admin', '12345');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int(11) NOT NULL,
  `kode_peminjaman` varchar(20) DEFAULT NULL,
  `nama_peminjam` varchar(50) DEFAULT NULL,
  `judul_buku` varchar(75) DEFAULT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `kode_peminjaman`, `nama_peminjam`, `judul_buku`, `tanggal_pinjam`, `tanggal_kembali`, `status`) VALUES
(1, 'P001', 'Wawan Dermawan', 'Laskar Pelangi', '2025-05-01', '2025-05-07', 'Dipinjam'),
(2, 'P002', 'Siti Amini', 'Bumi Manusia', '2025-05-02', '2025-05-08', 'Terlambat'),
(3, 'P003', 'Andi Wijaya', 'Fisika Dasar', '2025-05-03', '2025-05-09', 'Dipinjam'),
(4, 'P004', 'Dewi Lestari', 'Sejarah Dunia', '2025-05-04', '2025-05-10', 'Dikembalikan'),
(5, 'P005', 'Rudi Hartono', 'Pemrograman PHP', '2025-05-05', '2025-05-11', 'Dikembalikan'),
(6, 'P006', 'Maya Sari', 'Laskar Pelangi', '2025-05-06', '2025-05-12', 'Dikembalikan'),
(7, 'P007', 'Fajar Nugroho', 'Bumi Manusia', '2025-05-07', '2025-05-13', 'Dipinjam'),
(8, 'P010', 'Ayuni Fitriani', 'Laskar Pelangi', '2025-05-07', '2025-05-12', 'Dipinjam'),
(9, '1234', 'Dea ', 'Algoritma dan Struktur Data', '2026-05-14', '2026-05-21', 'Dipinjam');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD UNIQUE KEY `kode_buku` (`kode_buku`);

--
-- Indeks untuk tabel `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD UNIQUE KEY `kode_peminjaman` (`kode_peminjaman`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `login`
--
ALTER TABLE `login`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
