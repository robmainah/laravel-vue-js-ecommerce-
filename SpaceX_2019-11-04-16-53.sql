-- MySQL dump 10.13  Distrib 5.7.11, for Win64 (x86_64)
--
-- Host: localhost    Database: SpaceX
-- ------------------------------------------------------
-- Server version	5.7.11-log

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
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idNumber` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateOfBirth` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  `updated_by` bigint(20) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_userid_unique` (`userId`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'test',23232,'robmainah@gmail.com',NULL,'322','female','22','2019-10-10','$2y$10$Q4sWBXI8QQcgwa64Z2eiXO8Lj3m.3U6rvqDbEBxOejwesJVeb2AA.','1','3',1,1,NULL,'YHuKAQil41OPyv19sL75hMQLXWSq94oZDHM6mqgN3SiJJkZK29icwVtgBTCa','2019-10-11 13:38:26','2019-10-17 09:41:51');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoryId` int(10) unsigned NOT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  `updated_by` bigint(20) unsigned NOT NULL,
  `activated` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_categoryid_unique` (`categoryId`),
  KEY `categories_created_by_foreign` (`created_by`),
  KEY `categories_updated_by_foreign` (`updated_by`),
  CONSTRAINT `categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  CONSTRAINT `categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Softwares',446331,1,1,'Yes',NULL,'2019-10-11 22:29:34','2019-10-11 22:34:21'),(2,'Computers',337167,1,1,'Yes',NULL,'2019-10-11 22:31:54','2019-10-11 22:34:07'),(3,'Mobiles',749181,1,1,'Yes',NULL,'2019-10-11 22:33:33','2019-10-11 22:33:58');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customerId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idNumber` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `roles` int(3) unsigned NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (3,'dfAFD','','fgzsg@dzsgfs.zsfdv',NULL,'','','','','$2y$10$E5YzPec8.VXwrf4LuOR7fu9j56SjKjMVh9gm7s8Z6vyz0r.641bL2','0',1,NULL,NULL,'2019-10-11 11:31:26','2019-10-11 11:31:26'),(4,'dsafasd','','sdfsd@dsaf.sadf',NULL,'334','343','sdfd','male','$2y$10$wSg936DTVzyTvQLmUKuI.Ono6Vdkc3ybEV9dN/fZyNrMzh5UkRI3S','0',1,NULL,NULL,'2019-10-11 11:35:02','2019-10-11 11:35:02'),(5,'john','','johntoto@gmail.com',NULL,'3433','23223','nyeri','male','$2y$10$0jQgxtQGwg1b2n7bRc1RhOS8.raRBGQ/a4gs9JJ6mz1Wk7IyRHnJO','1',1,NULL,'lWrFz6JaYuu084AtwVzpCiGH5pYMfN7Ed6jzBebc8C8uF86k5VJtfHZwOf89','2019-10-11 11:36:06','2019-10-17 09:45:22'),(6,'szfg2','','rsrrt@afagd.dsfds',NULL,'34343','34343','fsdf','male','$2y$10$1vxwl6EvU7wNQwlyR6xRhO/0A3WaJ1OGeihwzqt0a9JyZAOk/Y9wm','0',1,NULL,NULL,'2019-10-11 11:44:45','2019-10-11 11:44:45'),(7,'daaFS','','fFD@zsfg.sfv',NULL,'33323','3434','dsff','male','$2y$10$w4Ey5oBDT6NbnxaGBCOyZefeTt62DYe.mqC/M3ie7nUzIONeKc/KG','0',1,NULL,NULL,'2019-10-11 11:48:54','2019-10-11 11:48:54'),(8,'sfsdfsfd','','sdfd@fdsafd.sdf',NULL,'42323','3243','adsff','male','$2y$10$5x13U8WhuukmBonHso/CN.2peGSD4OooOmfvlyumrubgosw./RKJq','0',1,NULL,NULL,'2019-10-11 11:49:56','2019-10-11 11:49:56'),(9,'knm,nm','','vccxv@zvcx.sdfx',NULL,'4545','3434','sdcv','male','$2y$10$vhIBg9cY30ynh.0hu4OzVuPWvdqsrA2jc1r7pH/BpsDHOSa403//G','0',1,NULL,NULL,'2019-10-11 12:00:51','2019-10-11 12:00:51'),(10,'zxczxczx','','zxccx@zfsd.sdf',NULL,'343','434343','sdcf','male','$2y$10$.ZBY.wREprk6jRKc8p0LSuh0R2O1gtxhU4nkT6Srt/STWizY3pRdS','0',1,NULL,NULL,'2019-10-11 12:06:18','2019-10-11 12:06:18'),(11,'zxczxczx','','zxccx@zfsd.sdfsds',NULL,'343','434343','sdcf','male','$2y$10$ZDJumN71aFeRG0qRo2co7uC9mF55HrBOqsYY3jkCDdp98y87ru/ba','0',1,NULL,NULL,'2019-10-11 12:07:09','2019-10-11 12:07:09'),(12,'zxczxczx','','zxccx@zfsd.sdfsdsdd',NULL,'343','434343','sdcf','male','$2y$10$wbU7rmr1zg8PecL9mNhoue5J7t6srJnMdTT/HN29hXbRRMJVfzmIy','0',1,NULL,NULL,'2019-10-11 12:12:08','2019-10-11 12:12:08'),(41,'john','','johntoto67@gmail.com','2019-10-18 16:20:07','132112','12121','fdsafd','male','$2y$10$Q4sWBXI8QQcgwa64Z2eiXO8Lj3m.3U6rvqDbEBxOejwesJVeb2AA.','1',1,NULL,NULL,'2019-10-18 13:19:28','2019-10-18 13:20:07');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_old_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_06_12_100715_create_categories_table',1),(4,'2019_06_14_091300_create_products_table',1),(5,'2019_07_05_152345_create_customers_table',1),(6,'2019_08_06_111900_create_orders_table',1),(7,'2019_08_06_114045_create_order_products_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_products`
--

DROP TABLE IF EXISTS `order_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `lineItemsNo` int(10) unsigned NOT NULL,
  `priceEach` decimal(8,2) NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  `updated_by` bigint(20) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_products_order_id_foreign` (`order_id`),
  KEY `order_products_product_id_foreign` (`product_id`),
  CONSTRAINT `order_products_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_products`
--

LOCK TABLES `order_products` WRITE;
/*!40000 ALTER TABLE `order_products` DISABLE KEYS */;
INSERT INTO `order_products` VALUES (1,6,1,1,12122.00,1,'incomplete',0,4,NULL,'2019-09-14 07:33:54','2019-09-14 07:33:54'),(2,6,2,2,50000.00,1,'incomplete',0,4,NULL,'2019-10-14 07:33:55','2019-10-14 07:33:55'),(3,6,3,3,45005.00,1,'incomplete',0,4,NULL,'2019-09-14 07:33:55','2019-09-14 07:33:55'),(4,7,1,1,12122.00,3,'incomplete',0,5,NULL,'2019-10-14 08:19:38','2019-10-14 08:19:38'),(5,7,2,2,50000.00,3,'incomplete',0,5,NULL,'2019-09-14 08:19:38','2019-09-14 08:19:38'),(6,8,3,1,45005.00,10,'incomplete',41,41,NULL,'2019-10-18 19:26:31','2019-10-18 19:26:31'),(7,9,1,1,12122.00,20,'complete',41,41,NULL,'2019-10-18 22:18:11','2019-10-18 22:18:11'),(8,9,2,2,50000.00,10,'complete',41,41,'2019-10-23 22:34:50','2019-10-18 22:18:11','2019-10-23 22:34:50'),(9,9,3,3,45005.00,10,'complete',41,41,NULL,'2019-10-18 22:18:11','2019-10-18 22:18:11'),(10,10,2,1,50000.00,1,'incomplete',41,41,NULL,'2019-10-21 13:56:45','2019-10-21 13:56:45'),(11,11,2,1,50000.00,1,'incomplete',41,41,NULL,'2019-10-23 13:30:38','2019-10-23 13:30:38'),(12,12,2,1,50000.00,3,'incomplete',4,4,NULL,'2019-10-23 20:21:17','2019-10-23 20:21:17'),(13,13,1,1,12122.00,1,'incomplete',41,41,NULL,'2019-10-23 21:31:53','2019-10-23 21:31:53'),(14,14,2,1,50000.00,3,'incomplete',41,41,NULL,'2019-10-24 13:22:38','2019-10-24 13:22:38'),(15,15,2,1,50000.00,3,'incomplete',41,41,NULL,'2019-10-29 14:21:33','2019-10-29 14:21:33'),(16,15,3,2,45005.00,4,'incomplete',41,41,NULL,'2019-10-29 14:21:33','2019-10-29 14:21:33'),(17,16,1,1,12122.00,4,'incomplete',41,41,NULL,'2019-10-29 14:28:56','2019-10-29 14:28:56'),(18,17,1,1,12122.00,4,'incomplete',41,41,NULL,'2019-09-29 14:32:16','2019-09-29 14:32:16'),(19,18,2,1,50000.00,1,'incomplete',41,41,NULL,'2019-11-04 10:09:46','2019-11-04 10:09:46');
/*!40000 ALTER TABLE `order_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `orderId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint(20) unsigned NOT NULL,
  `comments` text COLLATE utf8mb4_unicode_ci,
  `status` enum('complete','incomplete','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'incomplete',
  `shippingDate` datetime DEFAULT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  `updated_by` bigint(20) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_orderid_unique` (`orderId`),
  KEY `orders_customer_id_foreign` (`customer_id`),
  CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (6,'OR324794',4,'yes','incomplete','2019-10-23 11:40:20',0,4,NULL,'2019-10-14 07:33:54','2019-10-14 07:33:54'),(7,'OR726535',5,'yesddd','incomplete','2019-10-23 11:40:23',0,5,NULL,'2019-10-14 08:19:38','2019-10-14 08:19:38'),(8,'OR279339',41,'no','cancelled','2019-10-23 11:40:24',41,41,NULL,'2019-10-18 19:26:31','2019-10-23 12:48:13'),(9,'OR563552',41,'xcx','complete','2019-10-23 11:40:27',41,41,NULL,'2019-10-18 22:18:10','2019-10-18 22:18:10'),(10,'OR694141',41,'m m','cancelled','2019-10-23 11:40:29',41,41,'2019-10-23 22:12:08','2019-10-21 13:56:44','2019-10-23 22:12:08'),(11,'OR477253',41,NULL,'cancelled',NULL,41,41,'2019-10-23 22:11:35','2019-10-23 13:30:38','2019-10-23 22:11:35'),(12,'OR656654',4,NULL,'incomplete',NULL,4,4,NULL,'2019-10-23 20:21:17','2019-10-23 20:21:17'),(13,'OR859607',41,NULL,'incomplete',NULL,41,41,NULL,'2019-10-23 21:31:53','2019-10-23 21:31:53'),(14,'OR603467',41,NULL,'incomplete',NULL,41,41,NULL,'2019-10-24 13:22:38','2019-10-24 13:22:38'),(15,'OR991503',41,NULL,'incomplete',NULL,41,41,NULL,'2019-10-29 14:21:33','2019-10-29 14:21:33'),(16,'OR143462',41,NULL,'incomplete',NULL,41,41,NULL,'2019-10-29 14:28:56','2019-10-29 14:28:56'),(17,'OR690830',41,NULL,'incomplete',NULL,41,41,NULL,'2019-10-29 14:32:16','2019-10-29 14:32:16'),(18,'OR829070',41,NULL,'incomplete',NULL,41,41,NULL,'2019-11-04 10:09:46','2019-11-04 10:09:46');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `productId` int(10) unsigned NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  `updated_by` bigint(20) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_productid_unique` (`productId`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_created_by_foreign` (`created_by`),
  KEY `products_updated_by_foreign` (`updated_by`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,406402,1,'Software','','the best software you will ever get.',12122.00,0,'Software/OiijhE4ql5qmy4SHC06YIPO9onVOy168yHBDG9uD.jpeg',1,1,NULL,'2019-10-11 22:35:10','2019-10-29 14:32:16'),(2,718666,2,'Laptops','','The best Dell laptop in the market',50000.00,8,'Laptops/YZi0bzCckZfZiGFOgUb9SXYaaeKbXbmtMfPluZey.jpeg',1,1,NULL,'2019-10-11 22:35:51','2019-11-04 10:09:46'),(3,830889,3,'Gaming Computers','','only for those who can afford',45005.00,20,'Gaming computers/pFyhlFOUSTntJbRfidyCOyYTAHGlXDAEqFiwPpXy.jpeg',1,1,NULL,'2019-10-11 22:36:46','2019-10-29 14:21:33');
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

-- Dump completed on 2019-11-04 16:53:38
