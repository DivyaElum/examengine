-- MySQL dump 10.13  Distrib 5.7.24, for Linux (x86_64)
--
-- Host: localhost    Database: examdemo
-- ------------------------------------------------------
-- Server version	5.7.24-0ubuntu0.16.04.1

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2018_12_03_094439_create_question_types',1),(4,'2018_12_03_103220_create_repositories',2),(5,'2018_12_03_103519_add_structure_to_question_types',2),(6,'2018_12_03_105250_add_html_to_question_types',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
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
-- Table structure for table `question_types`
--

DROP TABLE IF EXISTS `question_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1- active , 0 - inactive',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_types`
--

LOCK TABLES `question_types` WRITE;
/*!40000 ALTER TABLE `question_types` DISABLE KEYS */;
INSERT INTO `question_types` VALUES (1,'Multiple Choice','MC',1,'2018-12-03 10:09:57','2018-12-04 10:19:29'),(2,'Multiple Responce','MR',1,'2018-12-03 10:09:57','2018-12-04 10:19:32'),(3,'True False','TF',1,'2018-12-03 10:09:57','2018-12-04 10:19:35'),(4,'Fill in the blanks','FB',0,'2018-12-03 10:09:57','2018-12-04 12:20:56'),(5,'Match Following','MF',0,'2018-12-03 10:09:57','2018-12-04 12:20:59'),(6,'Match Matrix','MM',0,'2018-12-03 10:09:57','2018-12-04 12:21:03');
/*!40000 ALTER TABLE `question_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions_types_structure`
--

DROP TABLE IF EXISTS `questions_types_structure`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions_types_structure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_type_id` int(11) NOT NULL,
  `question_type` varchar(255) NOT NULL,
  `structure` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions_types_structure`
--

LOCK TABLES `questions_types_structure` WRITE;
/*!40000 ALTER TABLE `questions_types_structure` DISABLE KEYS */;
INSERT INTO `questions_types_structure` VALUES (1,1,'MC','<div class=\"multiple_choice\">\n\n	<div class=\"col-md-12\">\n		<label>Type your question</label>\n		<textarea type=\"text\" class=\"form-control\" name=\"question_text\" rows=\"5\"></textarea><br>\n	</div>\n\n	<div class=\"options\">\n		<div class=\"col-md-11\">\n			Correct\n			<div class=\"input-group\">\n            <span class=\"input-group-addon\">\n					<label>A</label><br>\n              <input type=\"radio\" name=\"correct\" value=\"a\">\n            </span>\n        	<textarea type=\"text\" name=\"option1\" class=\"form-control\"></textarea>\n      	</div><br>\n  	</div>\n	</div>\n	\n	<div class=\"options\">\n		<div class=\"col-md-11\">\n      	<div class=\"input-group\">\n            <span class=\"input-group-addon\">\n            	<label>B</label><br>\n              <input type=\"radio\" name=\"correct\" value=\"b\">\n            </span>\n        	<textarea type=\"text\" name=\"option2\" class=\"form-control\"></textarea>\n      	</div><br>\n  	</div>\n	</div>\n	\n	<div class=\"options\">\n		<div class=\"col-md-11\">\n      	<div class=\"input-group\">\n            <span class=\"input-group-addon\">\n            	<label>C</label><br>\n              <input type=\"radio\" name=\"correct\" value=\"c\">\n            </span>\n        	<textarea type=\"text\" name=\"option3\" class=\"form-control\"></textarea>\n      	</div><br>\n  	</div>\n	</div>\n	\n	<div class=\"options\">\n		<div class=\"col-md-11\">\n      	<div class=\"input-group\">\n            <span class=\"input-group-addon\">\n            	<label>D</label><br>\n              <input type=\"radio\" name=\"correct\" value=\"d\">\n            </span>\n        	<textarea type=\"text\" name=\"option4\" class=\"form-control\"></textarea>\n			</div><br>\n		</div>\n	</div>\n\n	<div class=\"col-md-11\" >\n		<a class=\"btn btn-info add_new_choice\" onclick=\"return AddMultipleChoiceOption(this)\" style=\"float: right;\" >Add new</a>\n	</div>\n\n	<div class=\"col-md-2\">\n		<div class=\"form-group\">\n			<label for=\"\">Right Marks</label>\n			<input type=\"number\" class=\"form-control\" placeholder=\"0\" value=\"\" name=\"right_marks\">\n		</div>\n	</div>\n</div>','2018-12-04 09:17:58','2018-12-05 11:43:07'),(2,2,'MR','\n<div class=\"multiple_response\">\n\n	<div class=\"col-md-12\">\n		<label>Type your question</label>\n		<textarea type=\"text\" class=\"form-control\" name=\"question_text\" rows=\"5\"></textarea><br>\n	</div>\n\n	<div class=\"options\">\n		<div class=\"col-md-11\">\n			Correct\n			<div class=\"input-group\">\n            <span class=\"input-group-addon\">\n					<label>A</label><br>\n              <input type=\"checkbox\" name=\"correct[]\" value=\"a\">\n            </span>\n        	<textarea type=\"text\" name=\"option1\" class=\"form-control\"></textarea>\n      	</div><br>\n  	</div>\n	</div>\n	\n	<div class=\"options\">\n		<div class=\"col-md-11\">\n      	<div class=\"input-group\">\n            <span class=\"input-group-addon\">\n            	<label>B</label><br>\n              <input type=\"checkbox\" name=\"correct[]\" value=\"b\">\n            </span>\n        	<textarea type=\"text\" name=\"option2\" class=\"form-control\"></textarea>\n      	</div><br>\n  	</div>\n	</div>\n	\n	<div class=\"options\">\n		<div class=\"col-md-11\">\n      	<div class=\"input-group\">\n            <span class=\"input-group-addon\">\n            	<label>C</label><br>\n              <input type=\"checkbox\" name=\"correct[]\" value=\"c\">\n            </span>\n        	<textarea type=\"text\" name=\"option3\" class=\"form-control\"></textarea>\n      	</div><br>\n  	</div>\n	</div>\n	\n	<div class=\"options\">\n		<div class=\"col-md-11\">\n      	<div class=\"input-group\">\n            <span class=\"input-group-addon\">\n            	<label>D</label><br>\n              <input type=\"checkbox\" name=\"correct[]\" value=\"d\">\n            </span>\n        	<textarea type=\"text\" name=\"option4\" class=\"form-control\"></textarea>\n			</div><br>\n		</div>\n	</div>\n\n	<div class=\"col-md-11\" >\n		<a class=\"btn btn-info add_new_response\" onclick=\"return AddMultipleResponseOption(this)\" style=\"float: right;\" >Add new</a>\n	</div>\n\n	<div class=\"col-md-2\">\n		<div class=\"form-group\">\n			<label for=\"\">Right Marks</label>\n			<input type=\"number\" class=\"form-control\" placeholder=\"0\" value=\"\" name=\"right_marks\">\n		</div>\n	</div>\n</div>','2018-12-04 09:17:58','2018-12-05 11:43:42'),(3,3,'TF','<div class=\"true_false\">\n\n	<div class=\"col-md-12\">\n		<label>Type your question</label>\n		<textarea type=\"text\" class=\"form-control\" name=\"question_text\" rows=\"5\"></textarea><br>\n	</div>\n\n	<div class=\"col-md-11\">\n		Correct\n		<div class=\"input-group\">\n        <span class=\"input-group-addon\">\n          <input type=\"radio\" name=\"correct\" value=\"a\" >\n        </span>\n    	<input type=\"text\" readonly name=\"option1\" value=\"True\" class=\"form-control\">\n  	</div><br>\n	</div>\n	<div class=\"col-md-11\">\n  	<div class=\"input-group\">\n        <span class=\"input-group-addon\">\n          <input type=\"radio\" name=\"correct\" value=\"b\" >\n        </span>\n    	<input type=\"text\" readonly name=\"option2\" value=\"False\" class=\"form-control\">\n  	</div><br>\n	</div>\n\n	<div class=\"col-md-2\">\n		<div class=\"form-group\">\n			<label for=\"\">Right Marks</label>\n			<input type=\"number\" class=\"form-control\" placeholder=\"0\" value=\"\" name=\"right_marks\">\n		</div>\n	</div>\n</div>','2018-12-04 09:17:58','2018-12-05 11:44:13');
/*!40000 ALTER TABLE `questions_types_structure` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `repository`
--

DROP TABLE IF EXISTS `repository`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `repository` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_type_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `question_type` varchar(255) NOT NULL,
  `option1` text,
  `option2` text,
  `option3` text,
  `option4` text,
  `option5` text,
  `option6` text,
  `option7` text,
  `option8` text,
  `option9` text,
  `option10` text,
  `option11` text,
  `option12` text,
  `option13` text,
  `option14` text,
  `option15` text,
  `option16` text,
  `correct_answer` varchar(255) NOT NULL,
  `right_marks` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `repository`
--

LOCK TABLES `repository` WRITE;
/*!40000 ALTER TABLE `repository` DISABLE KEYS */;
INSERT INTO `repository` VALUES (1,1,'fsdsafsadfsadf','MC','sadfsadf','sadffsad','sadf','safdsadf',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'a','5',NULL,'2018-12-04 06:24:16','2018-12-05 09:50:28'),(3,2,'sadfsadffsadsadfsdfsadf sa fsaf sadfsadfsadfsadfsadf sadfsadffsadsadfsdfsadf sa fsaf sadfsadfsadfsadfsadf','MR','sdfsadfas','sadfsadf','sadfsadf','sadf','sadf','sadf','sadf','sadf',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'a,b,c,d,e,f,g,h','1',NULL,'2018-12-04 06:45:03','2018-12-05 09:50:31'),(4,3,'sdfdfsasafdsadfdfs','TF','True','False',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'a','1',NULL,'2018-12-04 06:54:46','2018-12-05 09:49:28'),(5,1,'42352353425','MC','354235','3425','2345','4235',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'d','2',NULL,'2018-12-05 04:44:56','2018-12-05 04:44:56'),(6,1,'42352353425','MC','354235','3425','2345','4235',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'d','2',NULL,'2018-12-05 04:45:38','2018-12-05 04:45:38'),(7,1,'safsadf','MC','sadf','sadf','sadf','sadf',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'a','21',NULL,'2018-12-05 04:47:24','2018-12-05 04:47:24'),(8,1,'safdsadfsdaf','MC','asfdsadf','safdfsad','safdsad','safsadf',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'d','1',NULL,'2018-12-05 04:48:11','2018-12-05 04:48:11'),(9,1,'safdsadfsdaf','MC','asfdsadf','safdfsad','safdsad','safsadf',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'d','1',NULL,'2018-12-05 04:49:08','2018-12-05 04:49:08'),(10,1,'fassda','MC','saffsad','safdsafd','sadf','sadfsad',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'d','3',NULL,'2018-12-05 04:50:24','2018-12-05 04:50:24'),(11,1,'sadfsadf','MC','safdsdf','safd','saffsad','sadfsadf',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'a','2',NULL,'2018-12-05 04:51:21','2018-12-05 04:51:21'),(12,1,'sadfsadf','MC','safdsdf','safd','saffsad','sadfsadf',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'a','2',NULL,'2018-12-05 04:51:30','2018-12-05 04:51:30'),(13,1,'sadfsadf','MC','safdsdf','safd','saffsad','sadfsadf',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'a','2',NULL,'2018-12-05 04:51:30','2018-12-05 04:51:30'),(14,1,'sadfsadf','MC','safdsdf','safd','saffsad','sadfsadf',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'a','2',NULL,'2018-12-05 04:51:30','2018-12-05 04:51:30'),(15,1,'sadfsadf','MC','safdsdf','safd','saffsad','sadfsadf',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'a','2',NULL,'2018-12-05 04:51:31','2018-12-05 04:51:31'),(16,1,'sadfsadf','MC','safdsdf','safd','saffsad','sadfsadf',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'a','2',NULL,'2018-12-05 04:51:31','2018-12-05 04:51:31'),(17,1,'sadfsadf','MC','safdsdf','safd','saffsad','sadfsadf',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'a','2',NULL,'2018-12-05 04:51:31','2018-12-05 04:51:31'),(18,1,'sadfsadf','MC','safdsdf','safd','saffsad','sadfsadf',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'a','2',NULL,'2018-12-05 04:51:31','2018-12-05 04:51:31'),(19,1,'sadfsadf','MC','safdsdf','safd','saffsad','sadfsadf',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'a','2',NULL,'2018-12-05 04:51:31','2018-12-05 04:51:31'),(20,1,'sadfsadf','MC','safdsdf','safd','saffsad','sadfsadf',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'a','2',NULL,'2018-12-05 04:51:32','2018-12-05 04:51:32'),(21,1,'sdfasfd','MC','sadfsad','safdfsad','sadf','sadf',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'d','3',NULL,'2018-12-05 04:59:08','2018-12-05 04:59:08'),(22,2,'sadfadsfsaf','MR','sadfsda','sadfsad','sadf','sadf',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'a,b','2',NULL,'2018-12-05 05:00:53','2018-12-05 05:00:53'),(23,1,'21321212132132132323','MC','213213','213213','213213','213213',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'c','1',NULL,'2018-12-05 05:04:12','2018-12-05 05:04:12'),(24,1,'213213','MC','213','213','rweweq','rweerw',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'c','3',NULL,'2018-12-05 05:05:44','2018-12-05 05:05:44'),(25,2,'dfdasda','MR','sadfsadf','sadf',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'a,b','1',NULL,'2018-12-05 05:15:08','2018-12-05 05:15:08');
/*!40000 ALTER TABLE `repository` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
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

-- Dump completed on 2018-12-05 17:42:01
