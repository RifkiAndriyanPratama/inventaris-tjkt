-- MySQL dump 
-- Collation: utf8mb4_general_ci
-- Table order: users -> barang -> peminjaman

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
SET NAMES utf8mb4;

-- ----------------------------
-- Table: users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nis` varchar(20) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `kelas` varchar(10) DEFAULT NULL,
  `role` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_nis` (`nis`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` VALUES
(1,'4434','admin','$2y$10$BRSVh3GQeZLv6hwOtus/F.TRxs9B7DWH/5dvW98yezSlck8hP9yXu','XII TJKT B','admin'),
(9,'4435','Rifki User','$2y$10$15KPrSgdAD1IkBhQeVeHCe/E8u7Vs1H6tRhDTIyJVM0wGcluWpEZG','XII TJKT A','user'),
(10,'4436','Rifki Atmin','$2y$10$dvziPswDZuCIa8SSn4KT6efXXpJuZt.zzSDN9wJrPZBV6LKNiKHZm','XII TJKT B','admin'),
(12,'4437','jir','$2y$10$QslWIKFW8V8Zv831C/Ysku9sVPGtZl7Xq3Iz2vR73KRYy8Ba4nYTm','X TJKT A','admin');

-- ----------------------------
-- Table: barang
-- ----------------------------
DROP TABLE IF EXISTS `barang`;
CREATE TABLE `barang` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `stok` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `barang` VALUES
(4,'Laptopahjdshajd','baik',2),
(5,'Laptop','baik',8),
(6,'Mouse','rusak',20),
(7,'Keyboard','baik',15),
(8,'Monitor','baik',0),
(9,'Printer','baik',3),
(10,'adadad','baik',1),
(11,'dkadkjad','baik',4);

-- ----------------------------
-- Table: peminjaman
-- ----------------------------
DROP TABLE IF EXISTS `peminjaman`;
CREATE TABLE `peminjaman` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `id_barang` int DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_barang` (`id_barang`),
  CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `peminjaman` VALUES
(15,1,4,1,'2026-03-18',NULL,'dipinjam'),
(16,1,5,2,'2026-03-18',NULL,'dipinjam'),
(18,1,7,1,'2026-03-18',NULL,'ditolak'),
(19,1,8,1,'2026-03-18','2026-03-26','dikembalikan'),
(21,10,7,3,'2026-03-26','2026-03-26','dikembalikan'),
(22,9,4,1,'2026-03-26','2026-03-26','dikembalikan'),
(23,10,7,10,'2026-03-26',NULL,'ditolak'),
(24,9,4,1,'2026-03-30',NULL,'dipinjam'),
(25,9,8,1,'2026-03-30',NULL,'dipinjam'),
(26,9,5,7,'2026-03-30','2026-03-31','dikembalikan'),
(27,9,6,1,'2026-04-01','2026-04-01','dikembalikan'),
(28,9,11,2,'2026-04-01',NULL,'ditolak');

SET FOREIGN_KEY_CHECKS=1;
