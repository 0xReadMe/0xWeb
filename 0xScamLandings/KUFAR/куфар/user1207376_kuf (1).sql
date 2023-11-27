-- MySQL dump 10.14  Distrib 5.5.64-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: user1207376_kuf
-- ------------------------------------------------------
-- Server version	5.5.64-MariaDB-cll-lve

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `Address` varchar(256) DEFAULT 'Чачково, ул. Трудовая 4, кв. 12',
  `price` varchar(256) DEFAULT '0',
  `Desc` varchar(256) DEFAULT 'unknown',
  `Image` varchar(256) DEFAULT '/assets/img/product.png',
  `Nickname` varchar(256) DEFAULT '@unknown',
  `Mt3` varchar(255) DEFAULT 'Владимирович',
  `Mt2` varchar(255) DEFAULT 'Сергей',
  `Mt1` varchar(255) DEFAULT 'Рогозин',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41316636 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (41316609,'ÐŸÑ€Ð¾Ð´Ð°ÐµÐ¼ Ð½Ð°Ñ‚ÑƒÑ€Ð°Ð»ÑŒÐ½Ñ‹Ðµ Ð²Ð¾Ð»Ð¾ÑÑ‹','Ð‘Ñ€ÐµÑÑ‚, ÐšÐ¾ÑÐ¼Ð¾Ð½Ð°Ð²Ñ‚Ð¾Ð² 25','300','','https://yams.kufar.by/api/v1/kufar-ads/images/13/1360294915.jpg?rule=gallery','@wulab','Ð­Ñ€Ð½ÐµÑÑ‚Ð¾Ð²Ð½Ð°','Ð¯Ð½Ð°','Ð‘Ð°Ð´Ð¸Ð½Ð°'),(41316614,'ÐÑƒÐ´Ð¸ 100 2.2 Ð³Ð±Ñ† Ð¾Ñ‚ Ð¼Ð¾Ñ‚Ð¾Ñ€Ð° wc','Чачково, ул. Трудовая 4, кв. 12','100','dwdw','we','@hrz14rv','Владимирович','Сергей','Рогозин'),(41316615,'Ð³Ð¾Ð»Ð¾Ð²Ð°-Ð¼Ð°Ð½ÐµÐºÐµÐ½ Ð±Ð¾Ð»Ð²Ð°Ð½ÐºÐ° Ð¿Ð°Ñ€Ð¸ÐºÐ¼Ð°Ñ…ÐµÑ€ÑÐºÐ°Ñ','Ð“Ð¾Ð¼ÐµÐ»ÑŒÑÐºÐ¸Ð¹ Ñ€Ð°Ð¹Ð¾Ð½, Ð¢ÐµÐ»ÐµÑˆÐ¸, ÑƒÐ».Ð¢Ñ€ÑƒÐ´Ð¾Ð²Ð°Ñ 4, Ð¾Ñ„. 12','110','','https://yams.kufar.by/api/v1/kufar-ads/images/33/3307291225.jpg?rule=gallery','@hrz14rv','Ð’Ð¸ÐºÑ‚Ð¾Ñ€Ð¾Ð²Ð½Ð°','ÐÐ»Ð¸Ð½Ð°','Ð Ð¾Ð³Ð¾Ð·Ð¸Ð½Ð°'),(41316617,'Ð¡ÐºÐµÐ¹Ñ‚ Ñ Ð¼Ð¾Ñ‚Ð¾Ñ€Ð¾Ð¼','Ð“Ð¾Ð¼ÐµÐ»ÑŒÑÐºÐ¸Ð¹ Ñ€Ð°Ð¹Ð¾Ð½, Ð¢ÐµÐ»ÐµÑˆÐ¸, ÑƒÐ».Ð¢Ñ€ÑƒÐ´Ð¾Ð²Ð°Ñ 4, Ð¾Ñ„. 12','200','','https://yams.kufar.by/api/v1/kufar-ads/images/94/9403171446.jpg?rule=gallery','@hrz14rv','Ð’Ð¸ÐºÑ‚Ð¾Ñ€Ð¾Ð²Ð½Ð°','ÐÐ»Ð¸Ð½Ð°','Ð Ð¾Ð³Ð¾Ð·Ð¸Ð½Ð°'),(41316618,'ÐŸÑ€Ð¾Ð´Ð°Ð¼ ÐºÐ¾Ð»ÑÑÐºÑƒ lorelli Ñ Ð¿ÐµÑ€ÐµÐºÐ¸Ð´Ð½Ð¾Ð¹ Ñ€ÑƒÑ‡ÐºÐ¾Ð¹.','Ð§Ð°Ñ‡ÐºÐ¾Ð²Ð¾, ÑƒÐ».Ð¢Ñ€ÑƒÐ´Ð¾Ð²Ð°Ñ 4, ÐºÐ².12','120','','https://yams.kufar.by/api/v1/kufar-ads/images/33/3325874217.jpg?rule=gallery','@hrz14rv','Ð’Ð¸ÐºÑ‚Ð¾Ñ€Ð¾Ð²Ð½Ð°','ÐÐ»Ð¸Ð½Ð°','Ð Ð¾Ð³Ð¾Ð·Ð¸Ð½Ð°'),(41316619,'Ð¡Ñ‚ÑƒÐ»ÑŒÑ','Ð§Ð°Ñ‡ÐºÐ¾Ð²Ð¾, ÑƒÐ».Ð¢Ñ€ÑƒÐ´Ð¾Ð²Ð°Ñ 4, ÐºÐ².12','110','','https://yams.kufar.by/api/v1/kufar-ads/images/33/3395336242.jpg?rule=gallery','@hrz14rv','Ð’Ð¸ÐºÑ‚Ð¾Ñ€Ð¾Ð²Ð½Ð°','ÐÐ»Ð¸Ð½Ð°','Ð Ð¾Ð³Ð¾Ð·Ð¸Ð½Ð°'),(41316620,'ÐŸÐ°Ñ€Ð° ÑˆÐ¸Ð½ r17','Ð§Ð°Ñ‡ÐºÐ¾Ð²Ð¾, ÑƒÐ».Ð¢Ñ€ÑƒÐ´Ð¾Ð²Ð°Ñ 4, ÐºÐ².12','150','','https://yams.kufar.by/api/v1/kufar-ads/images/26/2665443778.jpg?rule=gallery','@hrz14rv','Ð’Ð¸ÐºÑ‚Ð¾Ñ€Ð¾Ð²Ð½Ð°','ÐÐ»Ð¸Ð½Ð°','Ð Ð¾Ð³Ð¾Ð·Ð¸Ð½Ð°'),(41316623,'ÐÐ¼Ð¾Ñ€Ñ‚Ð¸Ð·Ð°Ñ‚Ð¾Ñ€','Ð“Ð¾Ð¼ÐµÐ»ÑŒÑÐºÐ¸Ð¹ Ñ€Ð°Ð¹Ð¾Ð½, Ð¢ÐµÐ»ÐµÑˆÐ¸, ÑƒÐ».Ð¢Ñ€ÑƒÐ´Ð¾Ð²Ð°Ñ 4, Ð¾Ñ„. 12','120','','https://yams.kufar.by/api/v1/kufar-ads/images/33/3345456354.jpg?rule=gallery','@hrz14rv','Ð’Ð¸ÐºÑ‚Ð¾Ñ€Ð¾Ð²Ð½Ð°','ÐÐ»Ð¸Ð½Ð°','Ð Ð¾Ð³Ð¾Ð·Ð¸Ð½Ð°'),(41316624,'ÐšÑ€Ñ‹ÑˆÐºÐ° Ð±Ð°Ð³Ð°Ð¶Ð½Ð¸ÐºÐ° Ð“Ð°Ð»Ð°ÐºÑÐ¸ Ð¨Ð°Ñ€Ð°Ð½ Ð°Ð»ÑŒÑ…Ð°Ð¼Ð±Ñ€Ð°','Ð§Ð°Ñ‡ÐºÐ¾Ð²Ð¾, ÑƒÐ».Ð¢Ñ€ÑƒÐ´Ð¾Ð²Ð°Ñ 4, ÐºÐ².12','100','','https://yams.kufar.by/api/v1/kufar-ads/images/33/3323358211.jpg?rule=gallery','@hrz14rv','Ð’Ð¸ÐºÑ‚Ð¾Ñ€Ð¾Ð²Ð½Ð°','ÐÐ»Ð¸Ð½Ð°','Ð Ð¾Ð³Ð¾Ð·Ð¸Ð½Ð°'),(41316625,'Ñ‡Ð°ÑÑ‹','Ð¼Ð¸Ð½ÑÐº','500000','','','@KillSwitch2','Ð²Ð°Ð½Ñ','Ð²Ð°Ð½Ñ','Ð²Ð°Ð½Ñ'),(41316626,'Ð‘Ð°Ð»ÐµÑ‚ÐºÐ¸ Caprice Ð½Ð°Ñ‚ÑƒÑ€Ð°Ð»ÑŒÐ½Ð°Ñ ÐºÐ¾Ð¶Ð°','Ð¿Ñ€Ð¾ÑÐ¿ÐµÐºÑ‚ Ð ÐµÐ²Ð¾Ð»ÑŽÑ†Ð¸Ð¸, 29 Ð‘Ð¾Ñ€Ð¸ÑÐ¾Ð², ÐœÐ¸Ð½ÑÐºÐ°Ñ Ð¾Ð±Ð»Ð°ÑÑ‚ÑŒ, Ð‘ÐµÐ»Ð°Ñ€ÑƒÑÑŒ','125','','https://yams.kufar.by/api/v1/kufar-ads/images/33/3393846229.jpg?rule=gallery','@KillSwitch2','','Ð¢Ð°Ñ‚ÑŒÑÐ½Ð°','Ð¡ÐµÑ€Ð°Ð²ÐºÐ¸Ð½Ð°'),(41316627,'Ð“Ð°Ð½Ð´Ð¾Ð½Ñ‹','Ð§Ðµ? ','5000','','https://i.imgur.com/fVx3gWv.jpg','@termenator','Ð˜Ð²Ð°Ð½','Ð˜Ð²Ð°Ð½','Ð˜Ð²Ð°Ð½ '),(41316628,'','','','','','','','',''),(41316629,'Ð¡ÐºÑ€Ð¸Ð¿ÐºÐ° ','Ð ÑƒÐ´ÐµÐ½ÑÐº ÑƒÐ».Ð·Ð°Ð²Ð¾Ð´ÑÐºÐ°Ñ 7/24','330','','https://i.imgur.com/407hlsD.jpg','@Murlarta','Ð’Ð°Ð»ÐµÑ€ÑŒÐµÐ²Ð½Ð°',' Ð¢Ð°Ñ‚ÑŒÑÐ½Ð° ','ÐÐ´Ð°ÑÑŒ '),(41316630,'','Ð¿Ñ€Ð¾ÑÐ¿ÐµÐºÑ‚ Ð ÐµÐ²Ð¾Ð»ÑŽÑ†Ð¸Ð¸, 29 Ð‘Ð¾Ñ€Ð¸ÑÐ¾Ð², ÐœÐ¸Ð½ÑÐºÐ°Ñ Ð¾Ð±Ð»Ð°ÑÑ‚ÑŒ, Ð‘ÐµÐ»Ð°Ñ€ÑƒÑÑŒ','125','','https://yams.kufar.by/api/v1/kufar-ads/images/33/3393846229.jpg?rule=gallery','@KillSwitch2','','Ð¢Ð°Ñ‚ÑŒÑÐ½Ð°',''),(41316631,'Sonia Michael','Nesciunt vel conseq','306','','Nihil quia consequat','Mallory Gilbert','Non in dolorem non i','Totam aliquam fuga ','Harum eu molestias i'),(41316632,'Ð‘Ð°Ð»ÐµÑ‚ÐºÐ¸ Caprice Ð½Ð°Ñ‚ÑƒÑ€Ð°Ð»ÑŒÐ½Ð°Ñ ÐºÐ¾Ð¶Ð°','Ð¿Ñ€Ð¾ÑÐ¿ÐµÐºÑ‚ Ð ÐµÐ²Ð¾Ð»ÑŽÑ†Ð¸Ð¸, 29 Ð‘Ð¾Ñ€Ð¸ÑÐ¾Ð², ÐœÐ¸Ð½ÑÐºÐ°Ñ Ð¾Ð±Ð»Ð°ÑÑ‚ÑŒ, Ð‘ÐµÐ»Ð°Ñ€ÑƒÑÑŒ','120','','https://yams.kufar.by/api/v1/kufar-ads/images/34/3453229947.jpg?rule=gallery','@KillSwitch2','','Ð›Ð°Ñ€Ð¸ÑÐ°',''),(41316633,'Ð¼Ð¸ÐºÑ€Ð¾Ñ„Ð¾Ð½ Behringer C-1','Ð“.Ð“Ð¾Ð¼ÐµÐ»ÑŒ ÑƒÐ».ÐšÑ€Ð°Ð¹Ð½ÑÑ,4 ÐºÐ² 1','83','','https://yams.kufar.by/api/v1/kufar-ads/images/32/3297914280.jpg?rule=gallery','@gypsteam','Ð˜Ð²Ð°Ð½Ð¾Ð²Ð½Ð°','Ð›ÐµÐ½Ð°','Ð¡Ð¾ÐºÐ¾Ð»Ð¾Ð²Ð°'),(41316634,'Ð‘Ð¾ÑÐ¾Ð½Ð¾Ð¶ÐºÐ¸ Tommy Hilfiger Ð½Ð¾Ð²Ñ‹Ðµ Ð¾Ñ€Ð¸Ð³Ð¸Ð½Ð°Ð»','Ð¿Ñ€Ð¾ÑÐ¿ÐµÐºÑ‚ Ð ÐµÐ²Ð¾Ð»ÑŽÑ†Ð¸Ð¸, 29 Ð‘Ð¾Ñ€Ð¸ÑÐ¾Ð², ÐœÐ¸Ð½ÑÐºÐ°Ñ Ð¾Ð±Ð»Ð°ÑÑ‚ÑŒ, Ð‘ÐµÐ»Ð°Ñ€ÑƒÑÑŒ','120','','https://yams.kufar.by/api/v1/kufar-ads/images/34/3453229947.jpg?rule=gallery','@KillSwitch2','','Ð›Ð°Ñ€Ð¸ÑÐ°',''),(41316635,'ÐšÐ°Ñ€Ñ‚Ð¾ÑˆÐºÐ°','ÑƒÐ»Ð¸Ñ†Ð° ÐœÐ¾ÑÐºÐ¾Ð²ÑÐºÐ°Ñ','150','','https://i.imgur.com/uE7QnqY.jpg','@st_vest','Ð¢ÐµÑÑ‚','Ð¢ÐµÑÑ‚','Ð¢ÐµÑÑ‚');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-06-21 13:04:38
