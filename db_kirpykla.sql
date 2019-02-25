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
  PRIMARY KEY (`kliento_id`),
  UNIQUE KEY `vardas` (`kliento_vardas`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table kirpykla.tb_klientai: ~6 rows (approximately)
/*!40000 ALTER TABLE `tb_klientai` DISABLE KEYS */;
INSERT INTO `tb_klientai` (`kliento_id`, `kliento_vardas`) VALUES
	(3, 'Bernardas Brazdžionis'),
	(2, 'Jonas Basanavičius'),
	(1, 'Juozas Tumas'),
	(6, 'Kazys Grinius'),
	(5, 'Vinas Mykolaitis'),
	(4, 'Vincas Kudirka');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table kirpykla.tb_rezervacijos: ~2 rows (approximately)
/*!40000 ALTER TABLE `tb_rezervacijos` DISABLE KEYS */;
INSERT INTO `tb_rezervacijos` (`rezervacijos_id`, `rezervacijos_kirpejo_id`, `rezervacijos_kliento_id`, `rezervacijos_data`, `rezervacijos_laikas`, `rezervacijos_aktyvus`) VALUES
	(1, 7, 1, '2019-03-01', '10:00:00', '1'),
	(3, 11, 2, '2019-03-01', '10:15:00', '1');
/*!40000 ALTER TABLE `tb_rezervacijos` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
