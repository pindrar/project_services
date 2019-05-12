-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 12 Mei 2019 pada 18.29
-- Versi Server: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_services`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `base_config`
--

CREATE TABLE `base_config` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `config_key` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `base_config`
--

INSERT INTO `base_config` (`id`, `name`, `config_key`) VALUES
(1, 'engine_path', '/engine/bin/'),
(4, 'themes', '/themes/'),
(5, 'app_name', 'The Project');

-- --------------------------------------------------------

--
-- Struktur dari tabel `engine`
--

CREATE TABLE `engine` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `base_path` varchar(255) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `views` varchar(255) NOT NULL,
  `print` varchar(255) NOT NULL,
  `db_table` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `engine`
--

INSERT INTO `engine` (`id`, `name`, `base_path`, `controller`, `views`, `print`, `db_table`, `position`, `status`) VALUES
(1, 'Project', 'project', '/bin/app.php', '/display/app.dis.php', '/print/app.print.php', 'tb_project', 'normal_page', 'enable'),
(2, 'Homepage', 'homepage', '/bin/app.php', '/display/app.dis.php', '', '', 'landing_page', 'enable'),
(3, 'Field Purchase Requisition', 'fpr', '/bin/app.php', '/display/app.dis.php', '/print/app.print/php', 'tb_fpr', 'normal_page', 'enable'),
(4, 'List Item of FRP', 'fpr_item', '/bin/app.php', '/display/app.dis.php', '', 'tb_fpr_item', 'normal_page', 'enable');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_fpr`
--

CREATE TABLE `tb_fpr` (
  `id` int(128) NOT NULL,
  `fpr_no` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `date_reqd` date NOT NULL,
  `division` varchar(255) NOT NULL,
  `section` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `reqd_for` varchar(255) NOT NULL,
  `reviewed` varchar(255) NOT NULL,
  `approved` varchar(255) NOT NULL,
  `proceed` varchar(255) NOT NULL,
  `project_id` int(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_fpr`
--

INSERT INTO `tb_fpr` (`id`, `fpr_no`, `date`, `date_reqd`, `division`, `section`, `area`, `reqd_for`, `reviewed`, `approved`, `proceed`, `project_id`) VALUES
(1, '1001', '2019-05-01', '2019-05-04', 'PIPING', 'DPPS', 'TANGERANG', 'DPPU SOEKARNO HATTA', '', '', '', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_fpr_item`
--

CREATE TABLE `tb_fpr_item` (
  `id` int(128) NOT NULL,
  `fpr_id` int(128) NOT NULL,
  `material_code` varchar(255) NOT NULL,
  `qty` int(128) NOT NULL,
  `unit` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `unit_price` int(128) NOT NULL,
  `amount` int(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_fpr_item`
--

INSERT INTO `tb_fpr_item` (`id`, `fpr_id`, `material_code`, `qty`, `unit`, `description`, `unit_price`, `amount`) VALUES
(1, 1, 'M01', 4, 'EA', 'REGULATOR ARGON', 100000, 400000),
(2, 1, 'M02', 1, 'ROL', 'SELANG ARGON', 50000, 50000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_project`
--

CREATE TABLE `tb_project` (
  `id` int(255) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `no_project` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_project`
--

INSERT INTO `tb_project` (`id`, `project_name`, `no_project`) VALUES
(1, 'DPPU SOEKARNO-HATTA', '18.34108'),
(3, 'PROJECT LUAR ANGKASA', '123'),
(4, 'PROJECT LANGIT', 'P021');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `base_config`
--
ALTER TABLE `base_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `engine`
--
ALTER TABLE `engine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_fpr`
--
ALTER TABLE `tb_fpr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_fpr_item`
--
ALTER TABLE `tb_fpr_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_project`
--
ALTER TABLE `tb_project`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `base_config`
--
ALTER TABLE `base_config`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `engine`
--
ALTER TABLE `engine`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tb_fpr`
--
ALTER TABLE `tb_fpr`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tb_fpr_item`
--
ALTER TABLE `tb_fpr_item`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tb_project`
--
ALTER TABLE `tb_project`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
