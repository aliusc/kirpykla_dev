-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.36-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for kirpykla
CREATE DATABASE IF NOT EXISTS `kirpykla` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `kirpykla`;

-- Dumping structure for table kirpykla.tb_kirpejai
CREATE TABLE IF NOT EXISTS `tb_kirpejai` (
  `kirpejo_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `kirpejo_vardas` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`kirpejo_id`),
  UNIQUE KEY `vardas` (`kirpejo_vardas`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Dumping data for table kirpykla.tb_kirpejai: ~6 rows (approximately)
/*!40000 ALTER TABLE `tb_kirpejai` DISABLE KEYS */;
INSERT INTO `tb_kirpejai` (`kirpejo_id`, `kirpejo_vardas`) VALUES
	(7, 'Kirpėja Adona'),
	(11, 'Kirpėja Aušra'),
	(8, 'Kirpėja Žaneta'),
	(12, 'Kirpėjas Jonas'),
	(9, 'Kirpėjas Justas'),
	(10, 'Kirpėjas Mykolas');
/*!40000 ALTER TABLE `tb_kirpejai` ENABLE KEYS */;

-- Dumping structure for table kirpykla.tb_klientai
CREATE TABLE IF NOT EXISTS `tb_klientai` (
  `kliento_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `kliento_vardas` varchar(30) NOT NULL DEFAULT '',
  `kliento_stat` int(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`kliento_id`),
  UNIQUE KEY `vardas` (`kliento_vardas`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

-- Dumping data for table kirpykla.tb_klientai: ~6 rows (approximately)
/*!40000 ALTER TABLE `tb_klientai` DISABLE KEYS */;
INSERT INTO `tb_klientai` (`kliento_id`, `kliento_vardas`, `kliento_stat`) VALUES
	(1, 'Juozas Tumas', 0),
	(2, 'Jonas Basanavičius', 0),
	(3, 'Bernardas Brazdžionis', 0),
	(4, 'Vincas Kudirka', 0),
	(5, 'Vinas Mykolaitis', 0),
	(6, 'Kazys Grinius', 0),
	(11, 'Zigmas', 9),
	(12, 'Jonelis', 0),
	(13, 'Alina', 0),
	(14, 'Saulius', 0),
	(15, 'Aušra', 0),
	(16, 'Pusbrolis Itas', 0),
	(17, 'Miglė', 0),
	(18, 'Laimonas', 1),
	(19, 'Mykolas', 1),
	(20, 'Jonas', 0),
	(21, 'Saulė', 0),
	(22, 'Mindaugas', 0),
	(23, 'Borisas', 0),
	(24, 'Saulutė', 0),
	(25, 'Zigis', 0),
	(26, 'Rimvydas', 0),
	(27, 'Rimas', 0),
	(28, 'Germanas', 0),
	(29, 'Simas', 0),
	(30, 'Mindaugėlis', 0),
	(31, 'Rimantas', 0),
	(32, 'Gintarė', 0),
	(33, 'Dovydas', 0),
	(34, 'Lina', 0),
	(35, 'Ramunė', 0),
	(36, 'Linas', 0),
	(37, 'Loreta', 0),
	(38, 'Dovilė', 0),
	(39, 'Zuikis', 0),
	(40, 'Romualdas', 0),
	(41, 'Kotryna', 0),
	(42, 'Liutauras', 0),
	(43, 'Romas', 0),
	(44, 'Gražvydas', 0),
	(45, 'Herkus', 0);
/*!40000 ALTER TABLE `tb_klientai` ENABLE KEYS */;

-- Dumping structure for table kirpykla.tb_rezervacijos
CREATE TABLE IF NOT EXISTS `tb_rezervacijos` (
  `rezervacijos_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rezervacijos_kirpejo_id` int(5) unsigned NOT NULL DEFAULT '0',
  `rezervacijos_kliento_id` int(5) unsigned NOT NULL DEFAULT '0',
  `rezervacijos_data` date DEFAULT NULL,
  `rezervacijos_laikas` time DEFAULT NULL,
  `rezervacijos_aktyvus` enum('1','0') NOT NULL DEFAULT '1',
  PRIMARY KEY (`rezervacijos_id`),
  KEY `data` (`rezervacijos_data`,`rezervacijos_aktyvus`),
  KEY `laikas` (`rezervacijos_laikas`),
  KEY `FK_db_rezervacijos_db_kirpejai` (`rezervacijos_kirpejo_id`),
  KEY `FK_db_rezervacijos_db_klientai` (`rezervacijos_kliento_id`),
  CONSTRAINT `FK_db_rezervacijos_db_kirpejai` FOREIGN KEY (`rezervacijos_kirpejo_id`) REFERENCES `tb_kirpejai` (`kirpejo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_db_rezervacijos_db_klientai` FOREIGN KEY (`rezervacijos_kliento_id`) REFERENCES `tb_klientai` (`kliento_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

-- Dumping data for table kirpykla.tb_rezervacijos: ~3 rows (approximately)
/*!40000 ALTER TABLE `tb_rezervacijos` DISABLE KEYS */;
INSERT INTO `tb_rezervacijos` (`rezervacijos_id`, `rezervacijos_kirpejo_id`, `rezervacijos_kliento_id`, `rezervacijos_data`, `rezervacijos_laikas`, `rezervacijos_aktyvus`) VALUES
	(1, 7, 1, '2019-03-02', '10:00:00', '1'),
	(3, 11, 2, '2019-03-02', '10:15:00', '1'),
	(4, 7, 1, '2019-02-28', '14:30:00', '1'),
	(7, 7, 11, '2019-02-28', '16:45:00', '1'),
	(8, 9, 12, '2019-03-01', '14:15:00', '0'),
	(9, 11, 6, '2019-02-28', '19:15:00', '1'),
	(10, 7, 11, '2019-02-23', '19:30:00', '1'),
	(11, 8, 11, '2019-02-25', '19:15:00', '1'),
	(12, 12, 11, '2019-02-25', '19:30:00', '1'),
	(13, 9, 13, '2019-02-28', '19:45:00', '1'),
	(14, 12, 14, '2019-02-27', '20:00:00', '1'),
	(15, 8, 11, '2019-02-26', '20:00:00', '1'),
	(16, 12, 11, '2019-03-02', '12:00:00', '1'),
	(17, 12, 15, '2019-03-02', '11:45:00', '1'),
	(18, 11, 16, '2019-03-02', '13:00:00', '1'),
	(19, 10, 17, '2019-02-28', '20:00:00', '1'),
	(20, 7, 18, '2019-02-28', '20:00:00', '1'),
	(21, 10, 19, '2019-02-28', '19:45:00', '0'),
	(22, 10, 11, '2019-01-28', '19:45:00', '1'),
	(23, 9, 11, '2019-02-08', '20:00:00', '1'),
	(24, 11, 11, '2019-02-18', '20:00:00', '1'),
	(25, 9, 11, '2019-02-20', '10:45:00', '1'),
	(26, 8, 11, '2019-03-01', '10:15:00', '1'),
	(27, 12, 20, '2019-03-01', '10:30:00', '1'),
	(28, 11, 21, '2019-03-01', '11:15:00', '0'),
	(29, 8, 22, '2019-03-01', '11:30:00', '1'),
	(30, 12, 23, '2019-03-01', '12:15:00', '1'),
	(31, 9, 24, '2019-03-01', '12:30:00', '1'),
	(32, 12, 25, '2019-03-01', '11:30:00', '1'),
	(33, 10, 26, '2019-03-01', '13:00:00', '1'),
	(34, 11, 27, '2019-03-01', '12:30:00', '0'),
	(35, 11, 28, '2019-03-01', '14:00:00', '1'),
	(36, 7, 29, '2019-03-01', '11:15:00', '1'),
	(37, 11, 30, '2019-04-01', '13:30:00', '1'),
	(38, 11, 31, '2019-03-04', '13:00:00', '1'),
	(39, 8, 32, '2019-03-04', '13:00:00', '1'),
	(40, 12, 33, '2019-03-04', '13:00:00', '1'),
	(41, 9, 34, '2019-03-04', '13:00:00', '0'),
	(42, 9, 34, '2019-03-04', '13:00:00', '0'),
	(43, 9, 34, '2019-03-04', '13:00:00', '0'),
	(44, 7, 34, '2019-03-04', '12:30:00', '0'),
	(45, 11, 35, '2019-03-04', '14:30:00', '1'),
	(46, 12, 36, '2019-03-04', '17:15:00', '1'),
	(47, 10, 37, '2019-03-04', '15:30:00', '1'),
	(48, 11, 34, '2019-03-04', '14:45:00', '0'),
	(49, 8, 38, '2019-03-04', '17:45:00', '1'),
	(50, 9, 39, '2019-03-04', '13:00:00', '1'),
	(51, 7, 40, '2019-03-04', '13:15:00', '1'),
	(52, 9, 41, '2019-03-04', '19:15:00', '1'),
	(53, 8, 42, '2019-03-05', '11:00:00', '1'),
	(54, 8, 43, '2019-03-05', '11:15:00', '1'),
	(55, 10, 44, '2019-03-05', '11:15:00', '1'),
	(56, 12, 45, '2019-03-05', '14:00:00', '1');
/*!40000 ALTER TABLE `tb_rezervacijos` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
