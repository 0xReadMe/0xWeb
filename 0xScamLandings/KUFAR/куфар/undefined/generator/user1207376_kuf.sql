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
) ENGINE=InnoDB AUTO_INCREMENT=41316605 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (41316569,'ÐŸÐ»Ð°Ð½ÑˆÐµÑ‚ Sony','Ð“.Ð“Ð¾Ð¼ÐµÐ»ÑŒ ÑƒÐ».ÐšÑ€Ð°Ð¹Ð½ÑÑ,4 ÐºÐ² 1','412','','https://yams.kufar.by/api/v1/kufar-ads/images/30/3002355875.jpg?rule=gallery','@gypsteam','Ð˜Ð²Ð°Ð½Ð¾Ð²Ð½Ð°','Ð›ÐµÐ½Ð°','Ð¡Ð¾ÐºÐ¾Ð»Ð¾Ð²Ð°'),(41316571,'Ð˜Ñ‚Ð°Ð»ÑŒÑÐ½ÑÐºÐ¸Ðµ ÑˆÐ»Ñ‘Ð¿Ð°Ð½Ñ†Ñ‹ Mary Claud','Ð“.Ð“Ð¾Ð¼ÐµÐ»ÑŒ ÑƒÐ».ÐšÑ€Ð°Ð¹Ð½ÑÑ,4 ÐºÐ² 1','182','','https://yams.kufar.by/api/v1/kufar-ads/images/30/3056154066.jpg?rule=gallery','@gypsteam','Ð˜Ð²Ð°Ð½Ð¾Ð²Ð½Ð°','Ð›ÐµÐ½Ð°','Ð¡Ð¾ÐºÐ¾Ð»Ð¾Ð²Ð°'),(41316574,'Ð›Ð°Ð·ÐµÑ€Ð½Ð°Ñ Ñ€ÑƒÐ»ÐµÑ‚ÐºÐ° Bosch DLE 70','Ð“.Ð“Ð¾Ð¼ÐµÐ»ÑŒ ÑƒÐ».ÐšÑ€Ð°Ð¹Ð½ÑÑ,4 ÐºÐ² 1','232','','https://yams.kufar.by/api/v1/kufar-ads/images/30/3031491492.jpg?rule=gallery','@gypsteam','Ð˜Ð²Ð°Ð½Ð¾Ð²Ð½Ð°','Ð›ÐµÐ½Ð°','Ð¡Ð¾ÐºÐ¾Ð»Ð¾Ð²Ð°'),(41316579,'ÐšÐ¾Ð¼Ð¾Ð´','Ð”Ð¾Ð±Ñ€ÑƒÑˆ, ÑƒÐ».Ð¢Ñ€ÑƒÐ´Ð¾Ð²Ð°Ñ 4','160','','https://yams.kufar.by/api/v1/kufar-ads/images/32/3203776440.jpg?rule=gallery','@atlasop','Ð’Ð¸ÐºÑ‚Ð¾Ñ€Ð¾Ð²Ð½Ð°','ÐÐ»Ð¸Ð½Ð°','Ð Ð¾Ð³Ð¾Ð·Ð¸Ð½Ð°'),(41316580,'ÐÐºÑƒÑÑ‚Ð¸Ñ‡ÐµÑÐºÐ°Ñ Ð³Ð¸Ñ‚Ð°Ñ€Ð° Cort Earth grand op','Ð“.Ð“Ð¾Ð¼ÐµÐ»ÑŒ ÑƒÐ».ÐšÑ€Ð°Ð¹Ð½ÑÑ,4 ÐºÐ² 1','282','','https://yams.kufar.by/api/v1/kufar-ads/images/30/3030226317.jpg?rule=gallery','@gypsteam','Ð˜Ð²Ð°Ð½Ð¾Ð²Ð½Ð°','Ð›ÐµÐ½Ð°','Ð¡Ð¾ÐºÐ¾Ð»Ð¾Ð²Ð°'),(41316581,'ÐŸÐ»Ð°Ð½ÑˆÐµÑ‚ Sony','Ð“.Ð“Ð¾Ð¼ÐµÐ»ÑŒ ÑƒÐ».ÐšÑ€Ð°Ð¹Ð½ÑÑ,4 ÐºÐ² 1','412','','https://yams.kufar.by/api/v1/kufar-ads/images/30/3002355875.jpg?rule=gallery','@gypsteam','Ð˜Ð²Ð°Ð½Ð¾Ð²Ð½Ð°','Ð›ÐµÐ½Ð°','Ð¡Ð¾ÐºÐ¾Ð»Ð¾Ð²Ð°'),(41316582,'ÐŸÐ»Ð°Ð½ÑˆÐµÑ‚ Sony','Ð“.Ð“Ð¾Ð¼ÐµÐ»ÑŒ ÑƒÐ».ÐšÑ€Ð°Ð¹Ð½ÑÑ,4 ÐºÐ² 1','412','','https://yams.kufar.by/api/v1/kufar-ads/images/30/3002355875.jpg?rule=gallery','@gypsteam','Ð˜Ð²Ð°Ð½Ð¾Ð²Ð½Ð°','Ð›ÐµÐ½Ð°','Ð¡Ð¾ÐºÐ¾Ð»Ð¾Ð²Ð°'),(41316583,'Ð—ÐµÑ€ÐºÐ°Ð»ÑŒÐ½Ñ‹Ð¹ Ñ„Ð¾Ñ‚Ð¾Ð°Ð¿Ð¿Ð°Ñ€Ð°Ñ‚ Nikon D3100 Kit','Ð“.Ð“Ð¾Ð¼ÐµÐ»ÑŒ ÑƒÐ».ÐšÑ€Ð°Ð¹Ð½ÑÑ,4 ÐºÐ² 1','312','','https://yams.kufar.by/api/v1/kufar-ads/images/30/3009702716.jpg?rule=gallery','@gypsteam','Ð˜Ð²Ð°Ð½Ð¾Ð²Ð½Ð°','Ð›ÐµÐ½Ð°','Ð¡Ð¾ÐºÐ¾Ð»Ð¾Ð²Ð°'),(41316584,'ÐšÐ¾Ð»ÑÑÐºÐ°','Ð“.Ð“Ð¾Ð¼ÐµÐ»ÑŒ ÑƒÐ».ÐšÑ€Ð°Ð¹Ð½ÑÑ,4 ÐºÐ² 1','282','','https://yams.kufar.by/api/v1/kufar-ads/images/30/3090048310.jpg?rule=gallery','@gypsteam','Ð˜Ð²Ð°Ð½Ð¾Ð²Ð½Ð°','Ð›ÐµÐ½Ð°','Ð¡Ð¾ÐºÐ¾Ð»Ð¾Ð²Ð°'),(41316585,'Ð’ÐµÑ€Ñ…Ð½ÑÑ Ñ‡Ð°ÑÑ‚ÑŒ Ð¿Ð°Ð½ÐµÐ»Ð¸ Chrysler PT cruiser','Ð§Ð°Ñ‡ÐºÐ¾Ð²Ð¾, ÑƒÐ».Ð¢Ñ€ÑƒÐ´Ð¾Ð²Ð°Ñ 4, ÐºÐ².12','100','','https://yams.kufar.by/api/v1/kufar-ads/images/32/3231011659.jpg?rule=gallery','@atlasop','Ð’Ð¸ÐºÑ‚Ð¾Ñ€Ð¾Ð²Ð½Ð°','ÐÐ»Ð¸Ð½Ð°','Ð Ð¾Ð³Ð¾Ð·Ð¸Ð½Ð°'),(41316590,'Ð˜Ð“Ð ÐžÐ’ÐžÐ™ Ð”ÐžÐœÐ˜Ðš MARIAN PLAST 560 Ð ÐÐ—Ð‘ÐžÐ ÐÐ«Ð™','Ð“Ð¾Ð¼ÐµÐ»ÑŒ, ÑƒÐ». Ð¥Ð¾Ð·ÑÐ¹ÑÑ‚Ð²ÐµÐ½Ð½Ð°Ñ Ð´.4','338 Ñ€.','','https://yams.kufar.by/api/v1/kufar-ads/images/22/2208671930.jpg?rule=gallery','@PacientWork','Ð’Ð»Ð°Ð´Ð¸Ð¼Ð¸Ñ€Ð¾Ð²Ð¸Ñ‡','ÐÐ»ÐµÐºÑÐ°Ð½Ð´Ñ€','Ð¡Ð¾ÐºÐ¾Ð»Ð¾Ð²ÑÐºÐ¸Ð¹'),(41316591,'Ð˜Ð“Ð ÐžÐ’ÐžÐ™ Ð”ÐžÐœÐ˜Ðš MARIAN PLAST 560 Ð ÐÐ—Ð‘ÐžÐ ÐÐ«Ð™','Ð“Ð¾Ð¼ÐµÐ»ÑŒ, ÑƒÐ». Ð¥Ð¾Ð·ÑÐ¹ÑÑ‚Ð²ÐµÐ½Ð½Ð°Ñ Ð´.4','338','','https://yams.kufar.by/api/v1/kufar-ads/images/22/2208671930.jpg?rule=gallery','@PacientWork','Ð’Ð»Ð°Ð´Ð¸Ð¼Ð¸Ñ€Ð¾Ð²Ð¸Ñ‡','ÐÐ»ÐµÐºÑÐ°Ð½Ð´Ñ€','Ð¡Ð¾ÐºÐ¾Ð»Ð¾Ð²ÑÐºÐ¸Ð¹'),(41316596,'Ð¢Ñ€ÑŽÐºÐ¾Ð²Ð¾Ð¹ ÑÐ°Ð¼Ð¾ÐºÐ°Ñ‚','ÐœÐ¸Ð½ÑÐº, ÑƒÐ». Ð¥Ð¾Ð·ÑÐ¹ÑÑ‚Ð²ÐµÐ½Ð½Ð°Ñ Ð´.4','125','','https://yams.kufar.by/api/v1/kufar-ads/images/32/3227510852.jpg?rule=gallery','@PacientWork','Ð’Ð»Ð°Ð´Ð¸Ð¼Ð¸Ñ€Ð¾Ð²Ð¸Ñ‡','ÐÐ»ÐµÐºÑÐ°Ð½Ð´Ñ€','Ð¡Ð¾ÐºÐ¾Ð»Ð¾Ð²ÑÐºÐ¸Ð¹'),(41316597,'Xiaomi Redmi 3s','Ð“Ð¾Ð¼ÐµÐ»ÑŒ, ÑƒÐ». Ð¥Ð¾Ð·ÑÐ¹ÑÑ‚Ð²ÐµÐ½Ð½Ð°Ñ Ð´.4','80','','https://yams.kufar.by/api/v1/kufar-ads/images/32/3205667399.jpg?rule=gallery','@PacientWork','Ð’Ð»Ð°Ð´Ð¸Ð¼Ð¸Ñ€Ð¾Ð²Ð¸Ñ‡','ÐÐ»ÐµÐºÑÐ°Ð½Ð´Ñ€','Ð¡Ð¾ÐºÐ¾Ð»Ð¾Ð²ÑÐºÐ¸Ð¹'),(41316598,'Ð²ÐµÐ»Ð¾Ñ‚ÑƒÑ„Ð»Ð¸','Ð“Ð¾Ð¼ÐµÐ»ÑŒ, ÑƒÐ». Ð¥Ð¾Ð·ÑÐ¹ÑÑ‚Ð²ÐµÐ½Ð½Ð°Ñ Ð´.4','235','','https://yams.kufar.by/api/v1/kufar-ads/images/32/3265136749.jpg?rule=gallery','@PacientWork','Ð’Ð»Ð°Ð´Ð¸Ð¼Ð¸Ñ€Ð¾Ð²Ð¸Ñ‡','ÐÐ»ÐµÐºÑÐ°Ð½Ð´Ñ€','Ð¡Ð¾ÐºÐ¾Ð»Ð¾Ð²ÑÐºÐ¸Ð¹'),(41316601,'Ð¨Ð¸Ð½Ñ‹, 4 ÑˆÑ‚, continental, 205/55/R16','ÐœÐ¸Ð½ÑÐº, ÑƒÐ». Ð¥Ð¾Ð·ÑÐ¹ÑÑ‚Ð²ÐµÐ½Ð½Ð°Ñ Ð´.4','215','','https://yams.kufar.by/api/v1/kufar-ads/images/32/3210744649.jpg?rule=gallery','@PacientWork','Ð’Ð»Ð°Ð´Ð¸Ð¼Ð¸Ñ€Ð¾Ð²Ð¸Ñ‡','ÐÐ»ÐµÐºÑÐ°Ð½Ð´Ñ€','Ð¡Ð¾ÐºÐ¾Ð»Ð¾Ð²ÑÐºÐ¸Ð¹'),(41316602,'ÐšÐ¾Ð»ÑÑÐºÐ°','Ð“.Ð“Ð¾Ð¼ÐµÐ»ÑŒ ÑƒÐ».ÐšÑ€Ð°Ð¹Ð½ÑÑ,4 ÐºÐ² 1','282','','https://yams.kufar.by/api/v1/kufar-ads/images/30/3090048310.jpg?rule=gallery','@gypsteam','Ð˜Ð²Ð°Ð½Ð¾Ð²Ð½Ð°','Ð›ÐµÐ½Ð°','Ð¡Ð¾ÐºÐ¾Ð»Ð¾Ð²Ð°'),(41316603,'','','','','','','','',''),(41316604,'ÐÐ¾ÑƒÑ‚Ð±ÑƒÐº','ÐœÐ¸Ð½ÑÐº , Ð§ÐµÐ»Ð½Ð¾Ð²ÑÐºÐ°Ñ 23','6000','','https://i.imgur.com/oVLUL8x.jpg','@anchoys1337','Ð¡ÐµÑ€Ð³ÐµÐµÐ²Ð¸Ñ‡','Ð’Ð¸Ñ‚Ð°Ð»Ð¸Ð¹ ','ÐŸÑƒÐ¿ÐºÐ¸Ð½');
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

-- Dump completed on 2020-06-19 23:42:17
