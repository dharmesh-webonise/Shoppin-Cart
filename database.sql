-- MySQL dump 10.13  Distrib 5.7.11, for Linux (x86_64)
--
-- Host: localhost    Database: shoping_cart_api
-- ------------------------------------------------------
-- Server version	5.7.11-0ubuntu6

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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(255) DEFAULT NULL,
  `c_description` varchar(255) DEFAULT NULL,
  `c_tax` double DEFAULT NULL,
  `c_created` datetime DEFAULT NULL,
  `c_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Electronics','All the electronics item will be provide in this category',18,'2019-11-11 18:53:00','2019-11-12 16:37:20'),(2,'cat2','Test Description',18,'2019-11-11 18:53:00',NULL),(4,'Fashion','Test',18,'2019-11-15 14:28:18','2019-11-15 14:32:36');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_name` varchar(255) DEFAULT NULL,
  `p_description` varchar(255) DEFAULT NULL,
  `p_price` double DEFAULT NULL,
  `p_discount` double DEFAULT NULL,
  `p_category` int(11) DEFAULT NULL,
  `p_created` datetime DEFAULT NULL,
  `p_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`p_id`),
  KEY `p_category` (`p_category`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`p_category`) REFERENCES `categories` (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (3,'charger','Charger description',49.99,10,1,'2019-11-12 12:37:52',NULL),(5,'Camera','Camera Description here',49.99,10,1,'2019-11-14 14:44:01',NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopping_cart`
--

DROP TABLE IF EXISTS `shopping_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopping_cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_user_id` int(11) DEFAULT NULL,
  `cart_product_id` int(11) DEFAULT NULL,
  `cart_product_price` double DEFAULT NULL,
  `cart_product_discount` double DEFAULT NULL,
  `cart_product_tax` double DEFAULT NULL,
  `cart_created` datetime DEFAULT NULL,
  `cart_modfied` datetime DEFAULT NULL,
  PRIMARY KEY (`cart_id`),
  KEY `cart_user_id` (`cart_user_id`),
  KEY `cart_product_id` (`cart_product_id`),
  CONSTRAINT `shopping_cart_ibfk_1` FOREIGN KEY (`cart_user_id`) REFERENCES `users` (`u_id`),
  CONSTRAINT `shopping_cart_ibfk_2` FOREIGN KEY (`cart_product_id`) REFERENCES `products` (`p_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopping_cart`
--

LOCK TABLES `shopping_cart` WRITE;
/*!40000 ALTER TABLE `shopping_cart` DISABLE KEYS */;
INSERT INTO `shopping_cart` VALUES (2,1,3,49.99,10,18,'2019-11-18 14:43:11','2019-11-18 14:43:11');
/*!40000 ALTER TABLE `shopping_cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `client_token` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'test-webonise','Test1234','Jhon Doe','eyJ1X2lkIjoiMSIsIjAiOiIxIiwidXNlcm5hbWUiOiJ0ZXN0LXdlYm9uaXNlIiwiMSI6InRlc3Qtd2Vib25pc2UiLCJwYXNzd29yZCI6IlRlc3QxMjM0IiwiMiI6IlRlc3QxMjM0IiwibmFtZSI6Ikpob24gRG9lIiwiMyI6Ikpob24gRG9lIiwiY2xpZW50X3Rva2VuIjoiZXlKMVgybGtJam9pTVNJc0lqQWlPaUl4SWl3aWRYTmxjbTVoYldVaU9pSjBaWE4wTFhkbFltOXVhWE5sSWl3aU1TSTZJblJsYzNRdGQyVmliMjVwYzJVaUxDSndZWE56ZDI5eVpDSTZJbFJsYzNReE1qTTBJaXdpTWlJNklsUmxjM1F4TWpNMElpd2libUZ0WlNJNklrcG9iMjRnUkc5bElpd2lNeUk2SWtwb2IyNGdSRzlsSWl3aVkyeHBaVzUwWDNSdmEyVnVJanB1ZFd4c0xDSTBJanB1ZFd4c2ZRPT0iLCI0IjoiZXlKMVgybGtJam9pTVNJc0lqQWlPaUl4SWl3aWRYTmxjbTVoYldVaU9pSjBaWE4wTFhkbFltOXVhWE5sSWl3aU1TSTZJblJsYzNRdGQyVmliMjVwYzJVaUxDSndZWE56ZDI5eVpDSTZJbFJsYzNReE1qTTBJaXdpTWlJNklsUmxjM1F4TWpNMElpd2libUZ0WlNJNklrcG9iMjRnUkc5bElpd2lNeUk2SWtwb2IyNGdSRzlsSWl3aVkyeHBaVzUwWDNSdmEyVnVJanB1ZFd4c0xDSTBJanB1ZFd4c2ZRPT0ifQ=='),(2,'test-user1','Test1234','Chris Evans',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-18 16:19:54
