-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.41 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for ssb_hbs
CREATE DATABASE IF NOT EXISTS `ssb_hbs` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `ssb_hbs`;

-- Dumping structure for table ssb_hbs.absensis
CREATE TABLE IF NOT EXISTS `absensis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint unsigned NOT NULL,
  `jadwal_latihan_id` bigint unsigned DEFAULT NULL,
  `tanggal` date NOT NULL,
  `status` enum('Hadir','Izin','Alpa') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `absensis_siswa_id_foreign` (`siswa_id`),
  KEY `absensis_jadwal_latihan_id_foreign` (`jadwal_latihan_id`),
  CONSTRAINT `absensis_jadwal_latihan_id_foreign` FOREIGN KEY (`jadwal_latihan_id`) REFERENCES `jadwal_latihans` (`id`) ON DELETE SET NULL,
  CONSTRAINT `absensis_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ssb_hbs.absensis: ~6 rows (approximately)
INSERT INTO `absensis` (`id`, `siswa_id`, `jadwal_latihan_id`, `tanggal`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
	(1, 2, 3, '2026-06-13', 'Hadir', NULL, '2026-06-13 12:55:49', '2026-06-13 12:55:49'),
	(2, 4, 3, '2026-06-13', 'Izin', NULL, '2026-06-13 12:56:17', '2026-06-13 12:56:17'),
	(3, 6, 3, '2026-06-13', 'Alpa', NULL, '2026-06-13 12:56:25', '2026-06-13 12:56:25'),
	(4, 5, 3, '2026-06-13', 'Hadir', NULL, '2026-06-13 12:56:33', '2026-06-13 12:56:33'),
	(5, 9, 1, '2026-06-14', 'Hadir', NULL, '2026-06-13 18:10:38', '2026-06-13 18:10:38'),
	(6, 2, 6, '2026-06-14', 'Izin', NULL, '2026-06-14 03:43:36', '2026-06-14 03:43:36'),
	(7, 4, 6, '2026-06-14', 'Izin', NULL, '2026-06-14 03:43:37', '2026-06-14 03:43:37'),
	(8, 5, 6, '2026-06-14', 'Hadir', NULL, '2026-06-14 03:43:37', '2026-06-14 03:43:37'),
	(9, 6, 6, '2026-06-14', 'Hadir', NULL, '2026-06-14 03:43:38', '2026-06-14 03:43:38'),
	(10, 10, 6, '2026-06-14', 'Hadir', NULL, '2026-06-14 03:43:39', '2026-06-14 03:43:39'),
	(11, 2, 3, '2026-06-14', 'Hadir', NULL, '2026-06-14 07:37:49', '2026-06-14 07:37:49'),
	(12, 5, 3, '2026-06-14', 'Alpa', NULL, '2026-06-14 07:37:50', '2026-06-14 07:37:50'),
	(13, 4, 3, '2026-06-14', 'Izin', NULL, '2026-06-14 07:37:50', '2026-06-14 07:37:50'),
	(14, 6, 3, '2026-06-14', 'Hadir', NULL, '2026-06-14 07:37:51', '2026-06-14 07:37:51'),
	(15, 10, 3, '2026-06-14', 'Hadir', NULL, '2026-06-14 07:37:51', '2026-06-14 07:37:51');

-- Dumping structure for table ssb_hbs.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ssb_hbs.cache: ~0 rows (approximately)

-- Dumping structure for table ssb_hbs.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ssb_hbs.cache_locks: ~0 rows (approximately)

-- Dumping structure for table ssb_hbs.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ssb_hbs.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table ssb_hbs.jadwal_latihans
CREATE TABLE IF NOT EXISTS `jadwal_latihans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pelatih_id` bigint unsigned DEFAULT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `kategori_latihan` enum('U-10','U-13','U-15','U-18') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jadwal_latihans_pelatih_id_foreign` (`pelatih_id`),
  CONSTRAINT `jadwal_latihans_pelatih_id_foreign` FOREIGN KEY (`pelatih_id`) REFERENCES `pelatihs` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ssb_hbs.jadwal_latihans: ~6 rows (approximately)
INSERT INTO `jadwal_latihans` (`id`, `pelatih_id`, `hari`, `jam_mulai`, `jam_selesai`, `kategori_latihan`, `lokasi`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Rabu', '15:30:00', '17:00:00', 'U-13', 'Lapangan Utama', '2026-06-10 15:24:12', '2026-06-10 08:31:40'),
	(2, 2, 'Rabu', '16:00:00', '17:30:00', 'U-10', 'Lapangan Mini', '2026-06-10 15:24:12', '2026-06-10 15:24:12'),
	(3, 3, 'Jumat', '15:30:00', '17:00:00', 'U-15', 'Lapangan Utama', '2026-06-10 15:24:12', '2026-06-10 15:24:12'),
	(4, 1, 'Selasa', '15:30:00', '17:00:00', 'U-18', 'Lapangan Tengah', '2026-06-10 15:24:12', '2026-06-10 08:31:50'),
	(5, 5, 'Kamis', '16:00:00', '17:30:00', 'U-13', 'Lapangan Utama', '2026-06-10 15:24:12', '2026-06-10 15:24:12'),
	(6, 3, 'Minggu', '19:00:00', '22:00:00', 'U-15', 'Lapangan Mini', '2026-06-14 02:59:11', '2026-06-14 02:59:11');

-- Dumping structure for table ssb_hbs.jenis_pembayarans
CREATE TABLE IF NOT EXISTS `jenis_pembayarans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_pembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ssb_hbs.jenis_pembayarans: ~0 rows (approximately)
INSERT INTO `jenis_pembayarans` (`id`, `nama_pembayaran`, `nominal`, `created_at`, `updated_at`) VALUES
	(1, 'SPP Bulanan', 150000, '2026-05-31 10:28:06', '2026-05-31 10:28:06');

-- Dumping structure for table ssb_hbs.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ssb_hbs.jobs: ~0 rows (approximately)

-- Dumping structure for table ssb_hbs.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ssb_hbs.job_batches: ~0 rows (approximately)

-- Dumping structure for table ssb_hbs.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ssb_hbs.migrations: ~15 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2026_05_30_163545_create_pendaftarans_table', 1),
	(5, '2026_05_31_162915_add_role_to_users_table', 2),
	(6, '2026_05_31_165329_create_ssb_hbs_tables', 3),
	(7, '2026_05_31_172610_add_bukti_pembayaran_to_pembayarans_table', 4),
	(8, '2026_05_31_173609_create_pesanan_jerseys_table', 5),
	(9, '2026_06_02_145512_create_tagihan_spps_table', 6),
	(10, '2026_06_05_103242_create_turnamen_siswas_table', 7),
	(11, '2026_06_06_052550_create_turnamen_siswas_table', 8),
	(12, '2026_06_06_091643_update_siswas_table_v2', 8),
	(13, '2026_06_06_094602_update_kategori_latihan_enum', 9),
	(14, '2026_06_06_135216_update_pembayarans_and_tagihan_spps_v2', 10),
	(15, '2026_06_12_184331_create_peserta_turnamens_table', 11);

-- Dumping structure for table ssb_hbs.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ssb_hbs.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table ssb_hbs.pelatihs
CREATE TABLE IF NOT EXISTS `pelatihs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lisensi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pelatihs_user_id_foreign` (`user_id`),
  CONSTRAINT `pelatihs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ssb_hbs.pelatihs: ~5 rows (approximately)
INSERT INTO `pelatihs` (`id`, `user_id`, `nama`, `lisensi`, `no_hp`, `created_at`, `updated_at`) VALUES
	(1, 2, 'Coach Andi', 'Nasional B', '081234567890', '2026-06-10 09:09:43', '2026-06-10 09:29:21'),
	(2, 3, 'Coach Budi', 'Nasional D', '081234567891', '2026-06-10 09:09:43', '2026-06-10 09:09:43'),
	(3, 26, 'Coach Dimas', 'Nasional C', '081234567892', '2026-06-10 09:09:43', '2026-06-10 09:09:43'),
	(4, 5, 'Coach Rudi', 'Nasional B', '081234567893', '2026-06-10 09:09:43', '2026-06-10 09:09:43'),
	(5, 6, 'Coach Fajar', 'Nasional C', '081234567894', '2026-06-10 09:09:43', '2026-06-10 09:09:43');

-- Dumping structure for table ssb_hbs.pembayarans
CREATE TABLE IF NOT EXISTS `pembayarans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint unsigned NOT NULL,
  `jenis_pembayaran_id` bigint unsigned NOT NULL,
  `tanggal_bayar` date DEFAULT NULL,
  `jumlah` int NOT NULL,
  `bukti_pembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Belum Bayar','Menunggu Verifikasi','Lunas','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum Bayar',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pembayarans_siswa_id_foreign` (`siswa_id`),
  KEY `pembayarans_jenis_pembayaran_id_foreign` (`jenis_pembayaran_id`),
  CONSTRAINT `pembayarans_jenis_pembayaran_id_foreign` FOREIGN KEY (`jenis_pembayaran_id`) REFERENCES `jenis_pembayarans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pembayarans_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ssb_hbs.pembayarans: ~2 rows (approximately)
INSERT INTO `pembayarans` (`id`, `siswa_id`, `jenis_pembayaran_id`, `tanggal_bayar`, `jumlah`, `bukti_pembayaran`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '2026-05-31', 150000, '1780248486_1.png', 'Menunggu Verifikasi', '2026-05-31 10:28:06', '2026-05-31 10:28:06'),
	(2, 1, 1, '2026-06-02', 150000, '1780410528_1.png', 'Menunggu Verifikasi', '2026-06-02 07:28:48', '2026-06-02 07:28:48');

-- Dumping structure for table ssb_hbs.pendaftarans
CREATE TABLE IF NOT EXISTS `pendaftarans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_latihan` enum('U-10','U-13','U-15','U-18') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_orang_tua` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','diterima','ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `foto_siswa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surat_izin_ortu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kartu_pelajar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pendaftarans_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ssb_hbs.pendaftarans: ~18 rows (approximately)
INSERT INTO `pendaftarans` (`id`, `nama`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `kategori_latihan`, `email`, `no_hp`, `nama_orang_tua`, `alamat`, `status`, `created_at`, `updated_at`, `foto_siswa`, `surat_izin_ortu`, `kartu_pelajar`) VALUES
	(1, 'sherlydea', 'Gresik', '2005-11-24', 'Perempuan', '', 'sherlysherliy8@gmail.com', '087716558787', 'Abdul Majid', 'Belahanrejo RT 13 RW 04, Kec. Kedamean, Kab. Gresik', 'pending', '2026-05-30 10:08:27', '2026-05-30 10:08:27', NULL, NULL, NULL),
	(2, 'Ahmad Baihaqi', 'Surabaya', '2010-02-12', 'Laki-laki', '', 'Ahmadbaihaqi23@gmail.com', '088899776655', 'Sutrisno', 'Rungkut Madya Barat, Surabaya', 'pending', '2026-05-31 09:08:57', '2026-05-31 09:08:57', NULL, NULL, NULL),
	(3, 'Andi Hartono', 'Surabaya', '2013-02-12', 'Laki-laki', 'U-15', 'Andi88@gmail.com', '08456778923', 'Sutrisno', 'Rungkut Madya, Surabaya', 'pending', '2026-06-04 22:43:25', '2026-06-04 22:43:25', NULL, NULL, NULL),
	(4, 'Lukman Aditya', 'Surabaya', '2014-02-12', 'Perempuan', '', 'Lukmanys@gmail.com', '086222334455', 'Harsono', 'Medokan Asri, Surabaya', 'pending', '2026-06-05 00:22:18', '2026-06-05 00:22:18', NULL, NULL, NULL),
	(5, 'Maulana ismail', 'Gresik', '2016-12-30', 'Laki-laki', 'U-10', 'Ismail98@gmail.com', '085622113466', 'Sulaiman', 'Gresik', 'pending', '2026-06-05 00:30:06', '2026-06-05 00:30:06', NULL, NULL, NULL),
	(6, 'Zakaria', 'Sidoarjo', '2013-02-12', 'Laki-laki', 'U-15', 'zkriaa87@gmail.com', '083246578779', 'Ahmadi', 'Sidoarjo', 'pending', '2026-06-05 00:36:38', '2026-06-05 00:36:38', NULL, NULL, NULL),
	(7, 'Dzulfikri Nasrullah', 'Sidoarjo', '2013-04-23', 'Laki-laki', 'U-15', 'nasrullah654@gmail.com', '084521113090', 'Mahmud', 'Sidoarjo', 'pending', '2026-06-05 00:42:45', '2026-06-05 00:42:45', NULL, NULL, NULL),
	(8, 'Ahmad Zakky', 'Surabaya', '2012-02-12', 'Laki-laki', 'U-15', 'Ahmadzakky90@gmail.com', '086547478908', 'Sulistyo', 'Sidoarjo', 'pending', '2026-06-05 00:44:45', '2026-06-05 00:44:45', NULL, NULL, NULL),
	(9, 'Doddy Atmaja', 'Surabaya', '2013-06-07', 'Laki-laki', 'U-15', 'Atmajaya54@gmail.com', '08675673422', 'Deddy Mulyadi', 'Surabaya', 'pending', '2026-06-05 01:10:48', '2026-06-05 01:10:48', NULL, NULL, NULL),
	(10, 'Hamdan Oktavio', 'Surabaya', '2015-05-04', 'Laki-laki', '', 'hamdanvio5@gmail.com', '086572829020', 'Firmanto', 'Sidoarjo', 'ditolak', '2026-06-05 01:15:26', '2026-06-05 01:15:26', NULL, NULL, NULL),
	(11, 'Ghofur', 'Surabaya', '2011-02-13', 'Laki-laki', 'U-15', 'Ghofurys54@gmail.com', '08175271571', 'Hamdan', 'Surabaya', 'diterima', '2026-06-05 20:20:58', '2026-06-05 20:20:58', NULL, NULL, NULL),
	(12, 'David Prasetyo', 'Surabaya', '2014-07-06', 'Laki-laki', 'U-15', 'Prastyi988@gmail.com', '01526152281', 'Prayitno', 'Surabaya', 'diterima', '2026-06-05 21:40:49', '2026-06-13 17:55:10', NULL, NULL, NULL),
	(13, 'Rendi Firmansyah', 'Surabaya', '2011-08-09', 'Laki-laki', 'U-15', 'Rendi6510@gmail.com', '067898971234', 'Tony', 'Surabaya', 'diterima', '2026-06-06 01:44:27', '2026-06-06 01:44:27', NULL, NULL, NULL),
	(14, 'Budi Santoso', 'Solo', '2013-06-17', 'Laki-laki', 'U-15', 'budist34@gmail.com', '085678905432', 'Santoso', 'Surabaya', 'diterima', '2026-06-06 03:28:40', '2026-06-06 03:28:40', NULL, NULL, NULL),
	(15, 'Maulana Haikal', 'Jakarta', '2016-09-14', 'Laki-laki', 'U-10', 'haikal23@gmail.com', '089056128765', 'Firman', 'Surabaya', 'diterima', '2026-06-06 07:29:43', '2026-06-06 07:29:43', NULL, NULL, NULL),
	(16, 'Adelia Noviyanti', 'lamongan', '2005-11-09', 'Perempuan', 'U-15', 'adelianoviyanti54@gmail.com', '081234567005', 'karina', 'Sidoarjo', 'diterima', '2026-06-13 01:50:51', '2026-06-13 01:50:51', 'pendaftaran/foto/ZTDWvrQNcodKYIO8rG1MSvvxjmT5ZSKA9YCIZN2b.jpg', 'pendaftaran/surat/t4pyBhgRVAlnAozXX8hQgd8dcbVy6lcCuLWRRcPE.jpg', 'pendaftaran/dokumen/TjcdUZ2XMeHLdVp5ZUtNnzA40xCiHMkj82NcZ2CL.jpg'),
	(17, 'ian', 'sidoarjo', '2020-06-14', 'Laki-laki', 'U-13', 'iandaegun@gmail.com', '081234567890', 'assalamualaikum', 'Sidoarjo', 'diterima', '2026-06-13 18:04:54', '2026-06-13 18:04:54', 'pendaftaran/foto/8p8a8bnqePuj25luCnKbryWCacRnfso3Czg8k8aJ.jpg', 'pendaftaran/surat/xvijm5YaAKnvNSS4KW3QJy0nKoEFWd7HLXLSbxHB.jpg', 'pendaftaran/dokumen/k81AXQPOFsZ4NVt1Y8QvXvFTk9nXfGtm6H2UjLcS.jpg'),
	(18, 'yayat', 'magelang', '2010-06-14', 'Laki-laki', 'U-18', 'yayat@gmail.com', '081234567005', 'welber', 'Magelang', 'diterima', '2026-06-13 18:07:32', '2026-06-13 18:07:32', 'pendaftaran/foto/RLnRKJ2IAmeqskvSZyEFAt5KIFFr7g6E0kZFVX5F.jpg', 'pendaftaran/surat/t0ZaZnqmIJ7boFEMYg7eohwhl5hG5jBkDRZ8UPHV.jpg', 'pendaftaran/dokumen/jXpm0w854ZBPEK7IfYsUSTTbneDlJi4xuuoIbatK.png');

-- Dumping structure for table ssb_hbs.pesanan_jerseys
CREATE TABLE IF NOT EXISTS `pesanan_jerseys` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint unsigned NOT NULL,
  `tipe_jersey` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ukuran` enum('S','M','L','XL','XXL') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_punggung` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_punggung` int DEFAULT NULL,
  `harga` int NOT NULL DEFAULT '120000',
  `status` enum('Menunggu','Diproses','Selesai','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bukti_pembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pesanan_jerseys_siswa_id_foreign` (`siswa_id`),
  CONSTRAINT `pesanan_jerseys_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ssb_hbs.pesanan_jerseys: ~3 rows (approximately)
INSERT INTO `pesanan_jerseys` (`id`, `siswa_id`, `tipe_jersey`, `ukuran`, `nama_punggung`, `nomor_punggung`, `harga`, `status`, `created_at`, `updated_at`, `bukti_pembayaran`) VALUES
	(1, 1, 'Training', 'S', 'Ahmad', 9, 100000, 'Menunggu', '2026-05-31 10:40:45', '2026-05-31 10:40:45', NULL),
	(2, 1, 'Home', 'L', 'Ahmad', 17, 120000, 'Menunggu', '2026-06-05 05:12:19', '2026-06-05 05:12:19', NULL),
	(3, 1, 'Training', 'M', 'Ahmad', 23, 100000, 'Selesai', '2026-06-06 07:27:23', '2026-06-13 23:39:15', NULL);

-- Dumping structure for table ssb_hbs.peserta_turnamens
CREATE TABLE IF NOT EXISTS `peserta_turnamens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `turnamen_id` bigint unsigned NOT NULL,
  `siswa_id` bigint unsigned NOT NULL,
  `pelatih_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `peserta_turnamens_turnamen_id_siswa_id_unique` (`turnamen_id`,`siswa_id`),
  KEY `peserta_turnamens_siswa_id_foreign` (`siswa_id`),
  KEY `peserta_turnamens_pelatih_id_foreign` (`pelatih_id`),
  CONSTRAINT `peserta_turnamens_pelatih_id_foreign` FOREIGN KEY (`pelatih_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `peserta_turnamens_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `peserta_turnamens_turnamen_id_foreign` FOREIGN KEY (`turnamen_id`) REFERENCES `turnamens` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ssb_hbs.peserta_turnamens: ~4 rows (approximately)
INSERT INTO `peserta_turnamens` (`id`, `turnamen_id`, `siswa_id`, `pelatih_id`, `created_at`, `updated_at`) VALUES
	(22, 2, 6, 26, '2026-06-14 07:37:05', '2026-06-14 07:37:05'),
	(23, 2, 10, 26, '2026-06-14 07:37:05', '2026-06-14 07:37:05'),
	(24, 1, 5, 26, '2026-06-14 08:23:00', '2026-06-14 08:23:00'),
	(26, 1, 8, 2, '2026-06-14 08:26:56', '2026-06-14 08:26:56'),
	(27, 1, 4, 26, '2026-06-14 14:32:59', '2026-06-14 14:32:59'),
	(28, 1, 6, 26, '2026-06-14 14:32:59', '2026-06-14 14:32:59'),
	(29, 2, 2, 26, '2026-06-14 14:33:21', '2026-06-14 14:33:21'),
	(30, 2, 4, 26, '2026-06-14 14:33:21', '2026-06-14 14:33:21'),
	(31, 3, 6, 26, '2026-06-14 14:39:07', '2026-06-14 14:39:07'),
	(32, 3, 5, 26, '2026-06-14 14:44:43', '2026-06-14 14:44:43');

-- Dumping structure for table ssb_hbs.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ssb_hbs.sessions: ~2 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('3LGYI8pY83WESpUM4QY6Q35gaHlg5NiJkHCrUgCi', 25, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTGJQWVh2WFRpVEJoY2VYMUp0Nng4U09NV1Vhb1dkYUlvc2M3bmc3WCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zaXN3YS9wZW1iYXlhcmFuIjtzOjU6InJvdXRlIjtzOjE2OiJzaXN3YS5wZW1iYXlhcmFuIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjU7fQ==', 1781475008);

-- Dumping structure for table ssb_hbs.siswas
CREATE TABLE IF NOT EXISTS `siswas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori_latihan` enum('U-10','U-13','U-15','U-18') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_orang_tua` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `foto_siswa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surat_izin_ortu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dokumen_pendukung` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_verifikasi` enum('Menunggu','Diterima','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu',
  `tanggal_daftar` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `siswas_user_id_foreign` (`user_id`),
  CONSTRAINT `siswas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ssb_hbs.siswas: ~9 rows (approximately)
INSERT INTO `siswas` (`id`, `user_id`, `nama`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `kategori_latihan`, `no_hp`, `nama_orang_tua`, `alamat`, `foto_siswa`, `surat_izin_ortu`, `dokumen_pendukung`, `status_verifikasi`, `tanggal_daftar`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Siswa Test', NULL, NULL, NULL, 'U-13', NULL, NULL, NULL, NULL, NULL, NULL, 'Menunggu', NULL, '2026-05-31 10:28:06', '2026-05-31 10:28:06'),
	(2, NULL, 'Adelia Noviyanti', 'lamongan', '2005-11-09', 'Perempuan', 'U-15', '081234567005', 'karina', 'Sidoarjo', 'pendaftaran/foto/ZTDWvrQNcodKYIO8rG1MSvvxjmT5ZSKA9YCIZN2b.jpg', 'pendaftaran/surat/t4pyBhgRVAlnAozXX8hQgd8dcbVy6lcCuLWRRcPE.jpg', 'pendaftaran/dokumen/TjcdUZ2XMeHLdVp5ZUtNnzA40xCiHMkj82NcZ2CL.jpg', 'Diterima', '2026-06-13', '2026-06-13 01:52:57', '2026-06-13 01:52:57'),
	(3, NULL, 'Maulana Haikal', 'Jakarta', '2016-09-14', 'Laki-laki', 'U-10', '089056128765', 'Firman', 'Surabaya', NULL, NULL, NULL, 'Diterima', '2026-06-13', '2026-06-13 01:57:01', '2026-06-13 01:57:01'),
	(4, NULL, 'Budi Santoso', 'Solo', '2013-06-17', 'Laki-laki', 'U-15', '085678905432', 'Santoso', 'Surabaya', NULL, NULL, NULL, 'Diterima', '2026-06-13', '2026-06-13 01:57:08', '2026-06-13 01:57:08'),
	(5, 25, 'Rendi Firmansyah', 'Surabaya', '2011-08-09', 'Laki-laki', 'U-15', '067898971234', 'Tony', 'Surabaya', NULL, NULL, NULL, 'Diterima', '2026-06-13', '2026-06-13 01:57:45', '2026-06-13 01:57:45'),
	(6, NULL, 'David Prasetyo', 'Surabaya', '2014-07-06', 'Laki-laki', 'U-15', '01526152281', 'Prayitno', 'Surabaya', NULL, NULL, NULL, 'Diterima', '2026-06-13', '2026-06-13 01:58:05', '2026-06-13 01:58:05'),
	(8, NULL, 'yayat', 'magelang', '2010-06-14', 'Laki-laki', 'U-18', '081234567005', 'welber', 'Magelang', 'pendaftaran/foto/RLnRKJ2IAmeqskvSZyEFAt5KIFFr7g6E0kZFVX5F.jpg', 'pendaftaran/surat/t0ZaZnqmIJ7boFEMYg7eohwhl5hG5jBkDRZ8UPHV.jpg', 'pendaftaran/dokumen/jXpm0w854ZBPEK7IfYsUSTTbneDlJi4xuuoIbatK.png', 'Diterima', '2026-06-14', '2026-06-13 18:08:09', '2026-06-13 18:08:09'),
	(9, NULL, 'ian', 'sidoarjo', '2020-06-14', 'Laki-laki', 'U-13', '081234567890', 'assalamualaikum', 'Sidoarjo', 'pendaftaran/foto/8p8a8bnqePuj25luCnKbryWCacRnfso3Czg8k8aJ.jpg', 'pendaftaran/surat/xvijm5YaAKnvNSS4KW3QJy0nKoEFWd7HLXLSbxHB.jpg', 'pendaftaran/dokumen/k81AXQPOFsZ4NVt1Y8QvXvFTk9nXfGtm6H2UjLcS.jpg', 'Diterima', '2026-06-14', '2026-06-13 18:08:20', '2026-06-13 18:08:20'),
	(10, NULL, 'Ghofur', 'Surabaya', '2011-02-13', 'Laki-laki', 'U-15', '08175271571', 'Hamdan', 'Surabaya', NULL, NULL, NULL, 'Diterima', '2026-06-14', '2026-06-13 23:29:35', '2026-06-13 23:29:35');

-- Dumping structure for table ssb_hbs.tagihan_spps
CREATE TABLE IF NOT EXISTS `tagihan_spps` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint unsigned DEFAULT NULL,
  `bulan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` year NOT NULL,
  `nominal` int NOT NULL DEFAULT '150000',
  `status` enum('Belum Bayar','Menunggu Verifikasi','Lunas','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum Bayar',
  `catatan_admin` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bukti_pembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_bayar` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tagihan_spps_siswa_id_foreign` (`siswa_id`),
  CONSTRAINT `tagihan_spps_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswas` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ssb_hbs.tagihan_spps: ~9 rows (approximately)
INSERT INTO `tagihan_spps` (`id`, `siswa_id`, `bulan`, `tahun`, `nominal`, `status`, `catatan_admin`, `bukti_pembayaran`, `tanggal_bayar`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Mei', '2026', 150000, 'Lunas', NULL, '1780412316_1.png', '2026-06-02 14:58:36', '2026-06-02 07:58:05', '2026-06-14 14:45:53'),
	(2, 2, 'June', '2026', 150000, 'Belum Bayar', NULL, NULL, NULL, '2026-06-13 01:52:57', '2026-06-13 01:52:57'),
	(3, 3, 'June', '2026', 150000, 'Belum Bayar', NULL, NULL, NULL, '2026-06-13 01:57:01', '2026-06-13 01:57:01'),
	(4, 4, 'June', '2026', 150000, 'Belum Bayar', NULL, NULL, NULL, '2026-06-13 01:57:08', '2026-06-13 01:57:08'),
	(5, 5, 'June', '2026', 150000, 'Lunas', NULL, '1781380864_marklee.jpeg', '2026-06-13 20:01:04', '2026-06-13 01:57:45', '2026-06-13 23:38:33'),
	(6, 6, 'June', '2026', 150000, 'Belum Bayar', NULL, NULL, NULL, '2026-06-13 01:58:05', '2026-06-13 01:58:05'),
	(7, 8, 'June', '2026', 150000, 'Belum Bayar', NULL, NULL, NULL, '2026-06-13 18:08:09', '2026-06-13 18:08:09'),
	(8, 9, 'June', '2026', 150000, 'Belum Bayar', NULL, NULL, NULL, '2026-06-13 18:08:20', '2026-06-13 18:08:20'),
	(9, 10, 'June', '2026', 150000, 'Belum Bayar', NULL, NULL, NULL, '2026-06-13 23:29:35', '2026-06-13 23:29:35'),
	(10, 2, 'November', '2026', 150000, 'Belum Bayar', NULL, NULL, NULL, '2026-06-14 15:02:32', '2026-06-14 15:02:32'),
	(11, 5, 'Juli', '2026', 150000, 'Belum Bayar', NULL, NULL, NULL, '2026-06-14 15:09:41', '2026-06-14 15:09:41');

-- Dumping structure for table ssb_hbs.turnamens
CREATE TABLE IF NOT EXISTS `turnamens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_turnamen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `lokasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Terdaftar','Menunggu','Selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ssb_hbs.turnamens: ~0 rows (approximately)
INSERT INTO `turnamens` (`id`, `nama_turnamen`, `tanggal`, `lokasi`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Piala Seoratin', '2026-06-27', 'Lapangan Angkasapura, Juanda', 'Terdaftar', '2026-06-13 03:25:24', '2026-06-13 03:25:24'),
	(2, 'Persebaya Youth', '2026-06-27', 'Gelora Bung Tomo', 'Terdaftar', '2026-06-14 04:16:10', '2026-06-14 04:16:10'),
	(3, 'Garuda Muda Cup', '2026-12-09', 'Malang', 'Terdaftar', '2026-06-14 14:36:38', '2026-06-14 14:36:38');

-- Dumping structure for table ssb_hbs.turnamen_siswas
CREATE TABLE IF NOT EXISTS `turnamen_siswas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint unsigned NOT NULL,
  `turnamen_id` bigint unsigned NOT NULL,
  `biaya` int NOT NULL DEFAULT '0',
  `bukti_pembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_pembayaran` enum('Belum Bayar','Menunggu Konfirmasi','Lunas') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum Bayar',
  `status_turnamen` enum('Aktif','Selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `turnamen_siswas_siswa_id_foreign` (`siswa_id`),
  KEY `turnamen_siswas_turnamen_id_foreign` (`turnamen_id`),
  CONSTRAINT `turnamen_siswas_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `turnamen_siswas_turnamen_id_foreign` FOREIGN KEY (`turnamen_id`) REFERENCES `turnamens` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ssb_hbs.turnamen_siswas: ~1 rows (approximately)

-- Dumping structure for table ssb_hbs.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'siswa',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ssb_hbs.users: ~5 rows (approximately)
INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Siswa Test', 'siswa', 'siswa@test.com', NULL, '$2y$12$5vEokbg4biE.MzzhmuuB3eeYfvHdAIJiUJsDl7wthd0bwljm5sUUK', 'siswa', 'kikexU04PskjwfVU9QF9cJNeyV2TzAE2ZjgUOw41hlqvBB272JWVoEM9zN6B', '2026-05-31 09:34:38', '2026-05-31 09:34:38'),
	(2, 'Pelatih Test', 'pelatih', 'pelatih@test.com', NULL, '$2y$12$2wTFHjEUjz8569ixVQF8j.adiT5RmSDupqfPt4GziHru5J8JDUfS6', 'pelatih', 'IPoIAnkzlv7wFnCLPyzwjM8d19NsG0Xm2zM8d3cpMeySauPVajMFLgwZ8ft7', '2026-05-31 09:34:48', '2026-05-31 09:34:48'),
	(3, 'Admin Test', 'admin', 'admin@test.com', NULL, '$2y$12$yCj8ZlSj/Ud2d6EOB9w8F.IY7bC6FGjaqc.s7L/J5wXwMkKRSTlw2', 'admin', 'rpwPTkp3I2NFmZRjk8e5rya1zNXFMqwDqWQLfPaOShPI3QNus8ULfOom6F1c', '2026-05-31 09:34:59', '2026-05-31 09:34:59'),
	(25, 'Rendi Firmansyah', 'rendi', 'rendi@ssb.com', NULL, '$2y$12$5vEokbg4biE.MzzhmuuB3eeYfvHdAIJiUJsDl7wthd0bwljm5sUUK', 'siswa', 'ZF9f2JYtBUzXQ0XJInzTObdOYxW9JoKFwczXRiSPb5NIsXfnqDkRp8SoiPbb', '2026-06-13 12:18:45', '2026-06-13 12:18:45'),
	(26, 'Coach Dimas', 'dimas', 'dimas@test.com', NULL, '$2y$12$5vEokbg4biE.MzzhmuuB3eeYfvHdAIJiUJsDl7wthd0bwljm5sUUK', 'pelatih', 'HKY5AaoC2cL96AOoMsGO9Gt6AzbDzzzFteHDRPVQGfEKZhTq22RH40YoMeRv', NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
