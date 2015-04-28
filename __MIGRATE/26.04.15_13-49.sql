# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 92.53.96.71 (MySQL 5.5.36-34.0-632.precise)
# Database: cu03970_test
# Generation Time: 2015-04-26 10:49:01 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table keys
# ------------------------------------------------------------

DROP TABLE IF EXISTS `keys`;

CREATE TABLE `keys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `domain` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expired_at` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `keys_module_code_foreign` (`module_code`),
  CONSTRAINT `keys_module_code_foreign` FOREIGN KEY (`module_code`) REFERENCES `modules` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `keys` WRITE;
/*!40000 ALTER TABLE `keys` DISABLE KEYS */;

INSERT INTO `keys` (`id`, `module_code`, `domain`, `expired_at`, `created_at`, `updated_at`)
VALUES
	(1,'test-download-module','modules.dev',NULL,'2015-02-28 19:40:19','2015-02-28 19:40:19'),
	(3,'Modules','modules.dev',NULL,'2015-03-18 12:43:07','2015-03-18 12:43:07'),
	(4,'Modules','modules-tester.dev',NULL,'2015-03-20 11:08:04','2015-03-20 11:08:04'),
	(5,'test-download-module','modules-tester.dev',NULL,'2015-04-16 12:26:02','2015-04-16 12:26:02');

/*!40000 ALTER TABLE `keys` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table languages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `languages`;

CREATE TABLE `languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;

INSERT INTO `languages` (`id`, `title`, `code`, `created_at`, `updated_at`)
VALUES
	(1,'English','en','2015-02-28 18:53:36','2015-02-28 18:53:36'),
	(2,'Русский','ru','2015-02-28 18:53:36','2015-02-28 18:53:36'),
	(3,'Українська','ua','2015-02-28 18:53:36','2015-02-28 18:53:36');

/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;


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
	('2015_01_15_102111_create_module_table',1),
	('2015_01_20_122416_create_users_table',1),
	('2015_01_22_130636_create_module_language_table',1),
	('2015_01_22_144020_create_language_table',1),
	('2015_01_23_143322_create_keys_table',1);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table module_languages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `module_languages`;

CREATE TABLE `module_languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `language_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `module_languages` WRITE;
/*!40000 ALTER TABLE `module_languages` DISABLE KEYS */;

INSERT INTO `module_languages` (`id`, `module_id`, `language_code`, `title`, `description`, `created_at`, `updated_at`)
VALUES
	(151,1,'en','Dante Green','Hic iusto facilis omnis qui sunt non voluptatem aspernatur excepturi.','2015-03-18 16:08:37','2015-03-18 16:08:37'),
	(152,1,'ru','Ronny O\'Connell','Deserunt magnam recusandae soluta at consequuntur ab et quo suscipit perspiciatis voluptatem sequi consequatur dolor laudantium.','2015-03-18 16:08:37','2015-03-18 16:08:37'),
	(153,1,'ua','Ursula Tremblay','Ab nam nihil ea ex nihil illum iusto eius cumque et est soluta nisi quia.','2015-03-18 16:08:37','2015-03-18 16:08:37'),
	(157,4,'en','Lilla Doyle PhD','Est sint ab animi sit praesentium architecto nesciunt fugit sed tempora asperiores.','2015-03-18 16:08:47','2015-03-18 16:08:47'),
	(158,4,'ru','Laurie Auer','Recusandae consequatur asperiores dolor sit distinctio eos aliquam qui et.','2015-03-18 16:08:47','2015-03-18 16:08:47'),
	(159,4,'ua','Hettie Frami','Voluptatem omnis labore dolores aut suscipit optio velit cumque praesentium.','2015-03-18 16:08:47','2015-03-18 16:08:47'),
	(160,5,'en','Leonard Dare','Id sapiente sequi saepe dolorem officia distinctio accusamus aut sed fugit consequatur nihil ex corporis est ea officia sunt.','2015-03-18 16:08:50','2015-03-18 16:08:50'),
	(161,5,'ru','Sheridan Franecki','Blanditiis sint dicta ad ad unde inventore non aut vero ut ut neque non rerum nostrum neque quae quia.','2015-03-18 16:08:50','2015-03-18 16:08:50'),
	(162,5,'ua','Hollie Stanton','Sequi eum omnis ipsa nisi officiis qui repudiandae laudantium beatae ut dolores alias voluptates quia cupiditate non suscipit ut.','2015-03-18 16:08:50','2015-03-18 16:08:50'),
	(163,6,'en','Lowell Sanford','Laborum molestiae blanditiis iusto ullam et enim iste quasi numquam minus quod nobis maiores omnis dolor ex incidunt dolores.','2015-03-18 16:08:58','2015-03-18 16:08:58'),
	(164,6,'ru','Asha Borer','Sed aut voluptatem quasi qui aliquam quidem sit cum laboriosam repudiandae alias aut soluta.','2015-03-18 16:08:58','2015-03-18 16:08:58'),
	(165,6,'ua','Lois Steuber','Commodi nam reprehenderit minus iure itaque sit dolor asperiores incidunt rem ullam et quia quidem suscipit ullam aspernatur.','2015-03-18 16:08:58','2015-03-18 16:08:58'),
	(166,7,'en','Ms. Dortha Kling MD','Eaque neque nisi maxime et aspernatur saepe eum eum nihil nobis sed nisi qui fugiat sint.','2015-03-18 16:09:01','2015-03-18 16:09:01'),
	(167,7,'ru','Mr. Beau Romaguera I','Autem earum autem quo dolor exercitationem sed consequatur repudiandae explicabo consectetur eum a iusto rerum repudiandae sint enim consequuntur.','2015-03-18 16:09:01','2015-03-18 16:09:01'),
	(168,7,'ua','Ayla Haag','Odio et possimus illo laboriosam tenetur et ad harum minus sint eum praesentium vel in qui et sunt sint.','2015-03-18 16:09:01','2015-03-18 16:09:01'),
	(169,8,'en','Khalid Spencer','Dolor reiciendis excepturi exercitationem corrupti illo qui quam laudantium minus nisi dignissimos voluptatibus.','2015-03-18 16:09:07','2015-03-18 16:09:07'),
	(170,8,'ru','Amely Hills III','Porro ut nulla molestiae id dolorem corrupti enim similique voluptates.','2015-03-18 16:09:07','2015-03-18 16:09:07'),
	(171,8,'ua','Nigel Leuschke','Excepturi et id corrupti aliquam et praesentium sint id enim officiis voluptate et dolorem.','2015-03-18 16:09:07','2015-03-18 16:09:07'),
	(172,9,'en','Fae Cummings','Et id eum repellat reprehenderit perferendis nisi ullam voluptas occaecati iste.','2015-03-18 16:09:11','2015-03-18 16:09:11'),
	(173,9,'ru','Billy Flatley','Eaque ea autem cumque aut accusamus architecto quidem alias qui.','2015-03-18 16:09:11','2015-03-18 16:09:11'),
	(174,9,'ua','Dallin Crist','Non officia laboriosam qui aut quibusdam veritatis aliquid dignissimos reprehenderit iste vero voluptas sed numquam necessitatibus.','2015-03-18 16:09:11','2015-03-18 16:09:11'),
	(175,10,'en','Boris Watsica MD','Nesciunt earum aut repudiandae ut aliquid dolor deserunt assumenda qui fugit esse adipisci cupiditate et nisi et rerum dolores.','2015-03-18 16:09:17','2015-03-18 16:09:17'),
	(176,10,'ru','Archibald Yost DDS','Quia incidunt quis dolor voluptatem voluptatem harum corporis molestiae harum ut.','2015-03-18 16:09:17','2015-03-18 16:09:17'),
	(177,10,'ua','Andreane VonRueden','Animi perferendis saepe et odit voluptatem atque autem consequatur nisi fuga adipisci commodi necessitatibus non veniam maiores laborum dolores error facilis pariatur.','2015-03-18 16:09:17','2015-03-18 16:09:17'),
	(178,11,'en','Vinnie Predovic','Qui inventore occaecati dolore asperiores et ad deserunt et velit.','2015-03-18 16:09:24','2015-03-18 16:09:24'),
	(179,11,'ru','Murl Powlowski','Qui ad alias aut facilis repudiandae non asperiores natus ipsum cum illum tempora maiores voluptatibus.','2015-03-18 16:09:24','2015-03-18 16:09:24'),
	(180,11,'ua','Blake Moore','Eveniet fugit id ab nam porro autem accusamus quas sit inventore rerum eos.','2015-03-18 16:09:24','2015-03-18 16:09:24'),
	(223,3,'en','CORE Modules','Ut omnis omnis ex ab sed aspernatur qui expedita fugit ut quia.','2015-04-25 07:42:08','2015-04-25 07:42:08'),
	(224,3,'ru','CORE Modules (ru)','Totam est quod quidem et nihil quis quo consequatur facilis ex possimus reprehenderit.','2015-04-25 07:42:08','2015-04-25 07:42:08'),
	(225,3,'ua','CORE Modules (ua)','Quos assumenda amet consectetur dolor esse hic enim distinctio eum assumenda occaecati officia provident dolor eos aperiam accusantium veniam quia pariatur.','2015-04-25 07:42:08','2015-04-25 07:42:08');

/*!40000 ALTER TABLE `module_languages` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table modules
# ------------------------------------------------------------

DROP TABLE IF EXISTS `modules`;

CREATE TABLE `modules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `version` text COLLATE utf8_unicode_ci NOT NULL,
  `price` int(11) NOT NULL DEFAULT '0',
  `downloads` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `logo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `modules_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `modules` WRITE;
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;

INSERT INTO `modules` (`id`, `code`, `version`, `price`, `downloads`, `status`, `logo`, `created_at`, `updated_at`)
VALUES
	(1,'test-download-module','0.0.1',0,23,1,'public/resources/test-download-module/276145843000.jpg','2015-02-28 18:53:36','2015-03-18 16:08:37'),
	(3,'Modules','0.0.30',0,19,1,'public/resources/Modules/1921862622000.jpg','2015-02-28 18:53:36','2015-04-26 10:43:03'),
	(4,'ab','0.0.1',100,12,1,'public/resources/ab/812322197000.jpg','2015-02-28 18:53:36','2015-03-18 16:08:47'),
	(5,'accusantium','0.0.1',22,9,1,'public/resources/accusantium/1615641393000.png','2015-02-28 18:53:36','2015-03-18 16:08:50'),
	(6,'temporibus','0.0.1',29,1,1,'public/resources/temporibus/2009141129000.png','2015-02-28 18:53:36','2015-03-18 16:08:58'),
	(7,'et','0.0.1',65,5,1,'public/resources/et/1771765490000.png','2015-02-28 18:53:36','2015-03-18 16:09:01'),
	(8,'nemo','0.0.1',11,41,1,'public/resources/nemo/691401175000.jpg','2015-02-28 18:53:36','2015-03-18 16:09:07'),
	(9,'a','0.0.1',12,15,1,'public/resources/a/1326788138000.jpg','2015-02-28 18:53:36','2015-03-18 16:09:11'),
	(10,'quia','0.0.1',26,40,1,'public/resources/quia/1573962537000.jpg','2015-02-28 18:53:36','2015-03-18 16:09:17'),
	(11,'voluptas','0.0.1',28,43,1,'public/resources/voluptas/1690348548000.png','2015-02-28 18:53:36','2015-03-18 16:09:24'),
	(12,'Pagemanager','0.0.16',0,0,1,NULL,'2015-04-26 10:47:00','2015-04-26 10:47:36');

/*!40000 ALTER TABLE `modules` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` text COLLATE utf8_unicode_ci NOT NULL,
  `is_admin` int(11) NOT NULL,
  `remember_token` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `login`, `email`, `password`, `is_admin`, `remember_token`, `created_at`, `updated_at`)
VALUES
	(1,'admin','admin@gmail.com','$2y$10$clCdx.T69tzvA75vPW4geOrCObKyJzb0OraXPyH/UD4iQhJMuxxfy',1,'','2015-02-28 18:53:36','2015-02-28 18:53:36'),
	(2,'kara.lakin','helena84@yahoo.com','$2y$10$clCdx.T69tzvA75vPW4geOrCObKyJzb0OraXPyH/UD4iQhJMuxxfy',0,'','2015-02-28 18:53:36','2015-02-28 18:53:36'),
	(3,'groob','elouise43@toy.com','$2y$10$clCdx.T69tzvA75vPW4geOrCObKyJzb0OraXPyH/UD4iQhJMuxxfy',0,'','2015-02-28 18:53:36','2015-02-28 18:53:36'),
	(4,'spaucek','vreichel@gmail.com','$2y$10$clCdx.T69tzvA75vPW4geOrCObKyJzb0OraXPyH/UD4iQhJMuxxfy',0,'','2015-02-28 18:53:36','2015-02-28 18:53:36'),
	(5,'taurean43','corwin.juwan@gmail.com','$2y$10$clCdx.T69tzvA75vPW4geOrCObKyJzb0OraXPyH/UD4iQhJMuxxfy',0,'','2015-02-28 18:53:36','2015-02-28 18:53:36'),
	(6,'ephraim90','ftreutel@altenwerthgerhold.biz','$2y$10$clCdx.T69tzvA75vPW4geOrCObKyJzb0OraXPyH/UD4iQhJMuxxfy',0,'','2015-02-28 18:53:36','2015-02-28 18:53:36'),
	(7,'jmills','kbayer@turcotte.org','$2y$10$clCdx.T69tzvA75vPW4geOrCObKyJzb0OraXPyH/UD4iQhJMuxxfy',0,'','2015-02-28 18:53:36','2015-02-28 18:53:36'),
	(8,'trent.fay','vchamplin@gmail.com','$2y$10$clCdx.T69tzvA75vPW4geOrCObKyJzb0OraXPyH/UD4iQhJMuxxfy',0,'','2015-02-28 18:53:36','2015-02-28 18:53:36'),
	(9,'mclaughlin.favian','reuben84@yahoo.com','$2y$10$clCdx.T69tzvA75vPW4geOrCObKyJzb0OraXPyH/UD4iQhJMuxxfy',0,'','2015-02-28 18:53:36','2015-02-28 18:53:36'),
	(10,'cabbott','sam51@yahoo.com','$2y$10$clCdx.T69tzvA75vPW4geOrCObKyJzb0OraXPyH/UD4iQhJMuxxfy',0,'','2015-02-28 18:53:36','2015-02-28 18:53:36'),
	(11,'daren.hackett','jillian.schoen@gmail.com','$2y$10$clCdx.T69tzvA75vPW4geOrCObKyJzb0OraXPyH/UD4iQhJMuxxfy',0,'','2015-02-28 18:53:36','2015-02-28 18:53:36');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
