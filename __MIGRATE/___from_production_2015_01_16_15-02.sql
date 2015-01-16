# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.6.20)
# Database: opencart_admin_dev
# Generation Time: 2015-01-16 13:02:34 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`migration`, `batch`)
VALUES
	('2015_01_15_102111_create_module_table',1);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table modules
# ------------------------------------------------------------

DROP TABLE IF EXISTS `modules`;

CREATE TABLE `modules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` text COLLATE utf8_unicode_ci NOT NULL,
  `version` text COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `downloads` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `modules` WRITE;
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;

INSERT INTO `modules` (`id`, `code`, `version`, `price`, `downloads`, `created_at`, `updated_at`)
VALUES
	(1,'eum','0.0.1',0,26,'2015-01-15 11:42:12','2015-01-16 10:30:48'),
	(2,'non','0.0.1',34,47,'2015-01-15 11:42:12','2015-01-15 11:42:12'),
	(3,'inventore','0.0.1',64,11,'2015-01-15 11:42:12','2015-01-15 11:42:12'),
	(4,'dolores','0.0.1',35,26,'2015-01-15 11:42:12','2015-01-15 11:42:12'),
	(5,'assumenda','0.0.1',87,44,'2015-01-15 11:42:12','2015-01-15 11:42:12'),
	(6,'autem','0.0.1',42,15,'2015-01-15 11:42:12','2015-01-15 11:42:12'),
	(7,'ut','0.0.1',40,28,'2015-01-15 11:42:12','2015-01-15 11:42:12'),
	(8,'rerum','0.0.1',94,13,'2015-01-15 11:42:12','2015-01-15 11:42:12'),
	(9,'at','0.0.1',40,13,'2015-01-15 11:42:12','2015-01-15 11:42:12'),
	(10,'possimus','0.0.1',38,37,'2015-01-15 11:42:12','2015-01-15 11:42:12'),
	(11,'demo2','0.0.1',0,0,'2015-01-16 10:30:48','2015-01-16 10:30:48');

/*!40000 ALTER TABLE `modules` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
