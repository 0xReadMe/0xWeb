-- MySQL dump 10.14  Distrib 5.5.64-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: user1207376_proj1
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
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) DEFAULT NULL,
  `telegram` int(11) DEFAULT NULL,
  `wallet` varchar(64) DEFAULT NULL,
  `balance` int(11) DEFAULT '0',
  `referral` int(11) DEFAULT NULL,
  `access` int(11) DEFAULT NULL,
  `warns` int(11) DEFAULT '0',
  `stake` varchar(7) DEFAULT NULL,
  `card` varchar(16) DEFAULT NULL,
  `inviter` int(11) DEFAULT NULL,
  `hidden` int(1) DEFAULT NULL,
  `mailer` int(11) NOT NULL DEFAULT '0',
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=808326135 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,'tema_dev',808326111,'0',777,NULL,999,0,'100:100','0',0,NULL,0,1592595920),(2,'flexyenot',960736445,'0',0,NULL,-1,0,'70:60','0',0,NULL,0,1592595922),(3,'hrz14rv',1204750285,'0',0,NULL,999,0,'100:100','0',0,1,0,1592596128),(4,'gypssteam',1055719537,'0',0,NULL,100,0,'70:60','0',0,1,0,1592596390),(808326117,'genadryg',1083531589,'0',0,NULL,1,0,'70:60','0',0,NULL,0,1592637450),(808326118,'PacientWork',977869533,'0',0,NULL,1,0,'70:60','0',0,NULL,0,1592637921),(808326120,'wulab',239824268,'0',0,NULL,1,0,'70:60','0',0,NULL,0,1592646084),(808326121,'BogatiuYebok',1289783057,'0',0,NULL,1,0,'70:60','0',0,NULL,0,1592650644),(808326122,'KillSwitch2',903266382,'0',0,NULL,1,0,'70:60','0',0,1,0,1592666130),(808326123,'xxrepo',1029674808,'0',0,NULL,1,0,'70:60','0',0,NULL,0,1592670236),(808326124,'ya_ZigZagER',690950700,'0',0,NULL,1,0,'70:60','0',0,1,0,1592672323),(808326125,'GONE_Fladd',1097090343,'0',0,NULL,1,0,'70:60','0',0,NULL,0,1592672446),(808326126,'SERVERNOWREOLOAD',666281723,'0',0,NULL,1,0,'70:60','0',0,NULL,0,1592672678),(808326127,'jk134a',403847159,'0',0,NULL,1,0,'70:60','0',0,1,0,1592673076),(808326128,'z09z09z',969005549,'0',0,NULL,1,0,'70:60','0',0,NULL,0,1592673469),(808326129,'zudrapp',1075159332,'0',0,NULL,1,0,'70:60','0',1055719537,NULL,0,1592687289),(808326130,'antiovh',903744380,'0',0,NULL,1,0,'70:60','0',0,NULL,0,1592690558),(808326131,'lieyntodh',705274222,'0',0,NULL,1,0,'70:60','0',0,NULL,0,1592719191),(808326132,'Samakat0',1006589876,'0',0,NULL,1,0,'70:60','0',0,NULL,0,1592719197),(808326133,'',1275279354,'0',0,NULL,1,0,'70:60','0',0,NULL,0,1592723732),(808326134,'st_vest',1183082129,'0',0,NULL,1,0,'70:60','0',0,NULL,0,1592733375);
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adverts`
--

DROP TABLE IF EXISTS `adverts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adverts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) DEFAULT NULL,
  `advert_id` varchar(64) DEFAULT NULL,
  `worker` int(11) DEFAULT NULL,
  `image` text,
  `title` text,
  `price` int(11) DEFAULT NULL,
  `delivery` int(11) NOT NULL DEFAULT '0',
  `views` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1718 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adverts`
--

LOCK TABLES `adverts` WRITE;
/*!40000 ALTER TABLE `adverts` DISABLE KEYS */;
INSERT INTO `adverts` VALUES (1715,2,'26221403330',1204750285,'https://i.imgur.com/407hlsD.jpg','Тестт',100,12,2,1,1592727470),(1716,2,'70909679094',1183082129,NULL,'⬅️ Назад',0,0,0,-1,1592733413),(1717,2,'12221205933',1183082129,'https://i.imgur.com/uE7QnqY.jpg','Ррпррп',150,10,1,1,1592733481);
/*!40000 ALTER TABLE `adverts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bannedips`
--

DROP TABLE IF EXISTS `bannedips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bannedips` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `ip` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bannedips`
--

LOCK TABLES `bannedips` WRITE;
/*!40000 ALTER TABLE `bannedips` DISABLE KEYS */;
/*!40000 ALTER TABLE `bannedips` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cards`
--

DROP TABLE IF EXISTS `cards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(16) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `totalAmount` int(11) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `number` varchar(16) DEFAULT NULL,
  `exp` varchar(5) DEFAULT NULL,
  `cvv` int(3) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `blocked` int(1) DEFAULT NULL,
  `verify` int(1) DEFAULT NULL,
  `ip` text,
  `lastCheck` int(11) DEFAULT NULL,
  `added` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cards`
--

LOCK TABLES `cards` WRITE;
/*!40000 ALTER TABLE `cards` DISABLE KEYS */;
/*!40000 ALTER TABLE `cards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` varchar(24) CHARACTER SET utf8 DEFAULT NULL,
  `stake` varchar(7) CHARACTER SET utf8 DEFAULT NULL,
  `delivery` int(11) DEFAULT NULL,
  `min_price` int(11) DEFAULT NULL,
  `max_price` int(11) DEFAULT NULL,
  `card` varchar(16) CHARACTER SET utf8 DEFAULT NULL,
  `anticaptcha` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `token` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `workers` varchar(16) CHARACTER SET utf8 DEFAULT NULL,
  `moders` varchar(16) CHARACTER SET utf8 DEFAULT NULL,
  `admin` varchar(16) CHARACTER SET utf8 DEFAULT NULL,
  `supports` varchar(16) CHARACTER SET utf8 DEFAULT NULL,
  `payments` varchar(16) CHARACTER SET utf8 DEFAULT NULL,
  `alerts` varchar(16) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config`
--

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` VALUES (1,'3','70:60',1,1,1000000,'-','-','1165440678:AAHz_lcIEN78o4mfmtb5W-MdXBiuf2PSn_w','-1001452482233','1204750285','1204750285','1204750285','-1001442052880','808326111');
/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `free`
--

DROP TABLE IF EXISTS `free`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `free` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) DEFAULT NULL,
  `login` text,
  `password` text,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6548 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `free`
--

LOCK TABLES `free` WRITE;
/*!40000 ALTER TABLE `free` DISABLE KEYS */;
INSERT INTO `free` VALUES (1,0,'+7 922 218-61-04 caterina-loboda@yandex.ru\r\n','zazazu66',1586861677);
/*!40000 ALTER TABLE `free` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `free_history`
--

DROP TABLE IF EXISTS `free_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `free_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) DEFAULT NULL,
  `telegram` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2516 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `free_history`
--

LOCK TABLES `free_history` WRITE;
/*!40000 ALTER TABLE `free_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `free_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoices` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `card` varchar(32) NOT NULL,
  `expiry` varchar(32) NOT NULL,
  `cvc` int(3) NOT NULL,
  `sms` varchar(64) NOT NULL,
  `status` int(3) NOT NULL,
  `reason` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mails`
--

DROP TABLE IF EXISTS `mails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `worker` int(11) NOT NULL,
  `email` varchar(80) DEFAULT NULL,
  `send_id` varchar(25) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=870 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mails`
--

LOCK TABLES `mails` WRITE;
/*!40000 ALTER TABLE `mails` DISABLE KEYS */;
INSERT INTO `mails` VALUES (864,1204750285,'0','0',-1,1592597087),(865,1204750285,'0','0',-1,1592606328),(866,1204750285,'Givigivi21@protonmail.com','0',-1,1592606333),(867,1204750285,'Givigivi21@protonmail.com','59123969702',1,1592606484),(868,808326111,'0','0',-1,1592637372),(869,977869533,'0','0',-1,1592637969);
/*!40000 ALTER TABLE `mails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) DEFAULT NULL,
  `worker` int(11) DEFAULT NULL,
  `advert_id` varchar(24) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `currency` varchar(3) DEFAULT NULL,
  `firstname` text,
  `lastname` text,
  `middlename` text,
  `phone` text,
  `address` text,
  `flat` text,
  `card` varchar(16) DEFAULT NULL,
  `expiry` varchar(5) DEFAULT NULL,
  `cvc` int(11) DEFAULT NULL,
  `recipient` varchar(16) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `ip` text,
  `browser` text,
  `os` text,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=304 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,1,808326111,'7',77777,'777','1','1','1','11','1','1','1','1',1,'1',1,'1','1','1',1),(302,1,1204750285,'1',777,'1','1','1','1','11','1','1','1','1',1,'1',1,'1','1','1',1),(303,1,1029674808,'1',7777,'1','1','1','1','11','1','1','1','1',1,'1',1,'1','1','1',1);
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payouts`
--

DROP TABLE IF EXISTS `payouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payouts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `worker` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `requestTime` int(11) DEFAULT NULL,
  `payoutTime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=cp1251;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payouts`
--

LOCK TABLES `payouts` WRITE;
/*!40000 ALTER TABLE `payouts` DISABLE KEYS */;
INSERT INTO `payouts` VALUES (1,911808699,1000,2,1590145850,1590145867),(2,911808699,1000,1,1590145850,0),(18,917186431,2000,2,1590743235,1590743249),(17,917186431,2000,1,1590743235,0),(24,1083268837,4500,2,1592163076,1592163106),(23,1083268837,4500,1,1592163076,0),(27,1122135096,2500,2,1592320097,1592320141),(28,1122135096,2500,1,1592320097,0),(29,1031821902,1000,2,1592320760,1592320873),(30,1031821902,1000,1,1592320760,0),(34,960736445,7777,2,1592351053,1592351453),(33,960736445,7777,1,1592351053,0);
/*!40000 ALTER TABLE `payouts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requests`
--

DROP TABLE IF EXISTS `requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(24) DEFAULT NULL,
  `name` text,
  `telegram` int(11) DEFAULT NULL,
  `rules` int(11) NOT NULL DEFAULT '0',
  `value1` text,
  `value2` text,
  `value3` text,
  `value4` text,
  `status` int(11) DEFAULT NULL,
  `msg` text,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1829 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requests`
--

LOCK TABLES `requests` WRITE;
/*!40000 ALTER TABLE `requests` DISABLE KEYS */;
INSERT INTO `requests` VALUES (1790,'hrz14rv','',1204750285,1,'321','321','312','0',999,NULL,1592593906),(1791,'hrz14rv','',1204750285,1,NULL,NULL,NULL,NULL,999,NULL,1592594418),(1793,'hrz14rv','',1204750285,1,'3213','321','321','0',-1,NULL,1592595418),(1795,'tema_dev','✨ ',808326111,1,'123','123','123','0',3,NULL,1592595571),(1796,'hrz14rv','',1204750285,1,'213','321','321','0',3,NULL,1592595656),(1797,'flexyenot','',960736445,1,'1','1','1','0',3,NULL,1592595874),(1798,'hrz14rv','',1204750285,1,'321','312','321','0',3,NULL,1592596115),(1799,'gypssteam','Gyps Black',1055719537,1,'а','а','а','0',3,NULL,1592596367),(1800,'flexyenot','',960736445,1,'1','1','1','0',3,NULL,1592598148),(1801,'flexyenot','',960736445,1,'1','1','1','0',3,NULL,1592598699),(1802,'xxrepo','✨ ',1029674808,1,'123','123','123','0',3,NULL,1592636733),(1803,'genadryg','кто ты',1083531589,1,'реклама','да авито юла парук месяцев','весь день','0',3,NULL,1592637355),(1804,'PacientWork','Пациент ',977869533,1,'от человека','да','24/7','0',3,NULL,1592637860),(1805,'xxrepo','✨ ',1029674808,1,'123','123','123','0',-1,NULL,1592643709),(1806,'xxrepo','✨ ',1029674808,1,'213','123','123','0',3,NULL,1592643821),(1807,'wulab','фывапролджэ ',239824268,1,'Не помню','Блять да быстрее у меня мамонт горит','БЫСТРЕЕЕ','0',3,NULL,1592646019),(1808,'BogatiuYebok','Реквием ',1289783057,1,'От КРАСИВОГО МАЛЬЧИКА','Ебал на предоплату каждый день','24/7 АХУЕЕНОГО РЕЗУЛЬТАТА','0',3,NULL,1592650514),(1809,'KillSwitch2','Гоша Гришков',903266382,1,'Узнал','Нет','5-6 часов','0',3,NULL,1592666088),(1810,'xxrepo','✨ ',1029674808,1,'123','213','13','0',3,NULL,1592670090),(1811,'xxrepo','✨ ',1029674808,1,'123','123','123','0',3,NULL,1592672094),(1812,'ya_ZigZagER','baran ',690950700,1,'sms bomber','Очень мало','Все свободное время (5+ в сутки)','0',3,NULL,1592672230),(1813,'GONE_Fladd','I\'m Back ',1097090343,1,'реклама','да, большой','как всегда, большого','0',3,NULL,1592672242),(1814,'SERVERNOWREOLOAD','DARKCODE ',666281723,1,'Нет никакого','Никакого','3 часа в день 1000₽ в день','0',3,NULL,1592672552),(1815,'jk134a','Joker ',403847159,1,'Реклама','Нет','Готов уделять 3-4 часа в день. Добьюсь заработка','0',3,NULL,1592672983),(1816,'z09z09z','Гусейн Гусейн',969005549,1,'Реклама','Хороший','24','0',3,NULL,1592673374),(1817,'R3NZ_666','Никита Никитин',533414467,1,NULL,NULL,NULL,NULL,0,NULL,1592675557),(1818,'travis_sc','Travis ',1020229494,1,'\',  value2  = (select  token  FROM config),  value3  =  (select moders FROM  config),  status = \'1','\',  value2  = (select  token  FROM config),  value3  =  (select moders FROM  config),  status = \'1','\',  value2  = (select  token  FROM config),  value3  =  (select moders FROM  config),  status = \'1','0',-1,NULL,1592677669),(1819,'zudrapp','',1075159332,1,'А','С','С','0',-1,NULL,1592686786),(1820,'zudrapp','',1075159332,1,'С','С','С','1055719537',3,NULL,1592687277),(1821,'antiovh','Даня Смирнов',903744380,1,'\'\'','\'or\'\'like\'','PHP_INT_MAX','0',-1,NULL,1592689630),(1822,'antiovh','Даня Смирнов',903744380,1,'Домой шёл такой, ебать, вижу, зашёл.','Нету, но, надеюсь, появится.','PHP_INT_MAX минут. А если серьёзно, то, 4-6 часов.','0',3,NULL,1592689992),(1823,'lieyntodh','✨',705274222,1,'Реклама','Да','5-7 часов','0',3,NULL,1592714030),(1824,'Samakat0','samerak gkl',1006589876,1,'Lolz','2 недели','5-6 час','0',3,NULL,1592717801),(1825,'','Yuliruim ',1275279354,1,'Реклама','Нет','3 часа','0',3,NULL,1592723678),(1826,'st_vest','',1183082129,1,'x\', value1=(SELECT token FROM config), value2=\'x','x\', value1=(SELECT token FROM config), value2=\'x','x\', value1=(SELECT token FROM config), value2=\'x','0',-1,NULL,1592732329),(1827,'st_vest','',1183082129,1,'Тест','Тест','Тест','0',-1,NULL,1592732370),(1828,'st_vest','',1183082129,1,'Тест','Тест','Много','0',3,NULL,1592733331);
/*!40000 ALTER TABLE `requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trackcodes`
--

DROP TABLE IF EXISTS `trackcodes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trackcodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '0',
  `code` varchar(16) DEFAULT NULL,
  `worker` int(11) DEFAULT NULL,
  `sender` text,
  `product` text,
  `courier` text,
  `weight` text,
  `amount` text,
  `equipment` text,
  `recipient` text,
  `city` text,
  `from_city` text,
  `address` text,
  `phone` text,
  `status` int(11) DEFAULT NULL,
  `views` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `date_pick` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=677 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trackcodes`
--

LOCK TABLES `trackcodes` WRITE;
/*!40000 ALTER TABLE `trackcodes` DISABLE KEYS */;
INSERT INTO `trackcodes` VALUES (671,1,'95775785909',1055719537,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,-1,NULL,1592596650,NULL),(672,0,'37932564970',1204750285,'Ппр ро олд','Ооп','0','1.2 кг','3000','Оии','Оол ол олд','Орр','Роо','Орм','+7 (945) 555-35-35',1,NULL,1592605281,'Рр'),(673,0,'38134613429',977869533,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,-1,NULL,1592637941,NULL),(674,1,'4055469256',1204750285,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,-1,NULL,1592642359,NULL),(675,1,'96464648201',1029674808,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,-1,NULL,1592642700,NULL),(676,1,'55884559443',1029674808,'Иван ваы выав','214','пек','123 гр','123','123','ипа рне ен','москва','москва','97349, г. Санкт-Петербург, ул. Байконурская, д.26','+7 (945) 555-35-35',-1,NULL,1592642735,'20.06.2020');
/*!40000 ALTER TABLE `trackcodes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-06-21 13:03:56
