-- MySQL dump 10.13  Distrib 5.7.24, for Linux (x86_64)
--
-- Host: localhost    Database: examengine
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
-- Table structure for table `council_members`
--

DROP TABLE IF EXISTS `council_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `council_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `designation` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '0',
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `council_members`
--

LOCK TABLES `council_members` WRITE;
/*!40000 ALTER TABLE `council_members` DISABLE KEYS */;
INSERT INTO `council_members` VALUES (1,'sheshkumar prajapati','shesh@gmail.com','lorem ipsub dolor wer geenefc sadfn  saf \', sdf sdfnedn.','doloer',NULL,'1','2018-12-21 11:17:53','2018-12-21 05:46:54','2018-12-21 05:47:53');
/*!40000 ALTER TABLE `council_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `prerequisite_id` varchar(255) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `amount` decimal(16,2) NOT NULL,
  `discount` decimal(16,2) NOT NULL,
  `discount_by` varchar(255) NOT NULL,
  `calculated_amount` decimal(16,2) NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `featured_image_thumbnail` varchar(255) DEFAULT NULL,
  `featured_image_original_name` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course`
--

LOCK TABLES `course` WRITE;
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
/*!40000 ALTER TABLE `course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam`
--

DROP TABLE IF EXISTS `exam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `duration` bigint(100) NOT NULL,
  `total_question` bigint(100) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0- not active , 1- active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam`
--

LOCK TABLES `exam` WRITE;
/*!40000 ALTER TABLE `exam` DISABLE KEYS */;
/*!40000 ALTER TABLE `exam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_questions`
--

DROP TABLE IF EXISTS `exam_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_questions`
--

LOCK TABLES `exam_questions` WRITE;
/*!40000 ALTER TABLE `exam_questions` DISABLE KEYS */;
/*!40000 ALTER TABLE `exam_questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam_slots`
--

DROP TABLE IF EXISTS `exam_slots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exam_slots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exam_id` int(11) NOT NULL,
  `day` varchar(255) NOT NULL,
  `time` text NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_slots`
--

LOCK TABLES `exam_slots` WRITE;
/*!40000 ALTER TABLE `exam_slots` DISABLE KEYS */;
/*!40000 ALTER TABLE `exam_slots` ENABLE KEYS */;
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
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2018_12_03_094439_create_question_types',1),(4,'2018_12_03_103220_create_repositories',2),(5,'2018_12_03_103519_add_structure_to_question_types',2),(6,'2018_12_03_105250_add_html_to_question_types',3),(7,'2018_12_12_130124_create_permission_tables',4);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\User',1);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `option_structure`
--

DROP TABLE IF EXISTS `option_structure`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `option_structure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option` varchar(255) NOT NULL,
  `structure` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `option_structure`
--

LOCK TABLES `option_structure` WRITE;
/*!40000 ALTER TABLE `option_structure` DISABLE KEYS */;
INSERT INTO `option_structure` VALUES (1,'radio','<div class=\"multiple_choice\">\n\n	<div class=\"col-md-12\">\n		<label>Type your question</label>\n		<textarea type=\"text\" class=\"form-control\" name=\"question_text\" rows=\"5\"></textarea><br>\n	</div>\n\n	<div class=\"options\">\n		<div class=\"col-md-11\">\n			Correct\n			<div class=\"input-group\">\n            <span class=\"input-group-addon\">\n					<label>A</label><br>\n              <input type=\"radio\" name=\"correct\" value=\"a\">\n            </span>\n        	<textarea type=\"text\" name=\"option1\" class=\"form-control\"></textarea>\n      	</div><br>\n  	</div>\n	</div>\n	\n	<div class=\"options\">\n		<div class=\"col-md-11\">\n      	<div class=\"input-group\">\n            <span class=\"input-group-addon\">\n            	<label>B</label><br>\n              <input type=\"radio\" name=\"correct\" value=\"b\">\n            </span>\n        	<textarea type=\"text\" name=\"option2\" class=\"form-control\"></textarea>\n      	</div><br>\n  	</div>\n	</div>\n	\n	<div class=\"options\">\n		<div class=\"col-md-11\">\n      	<div class=\"input-group\">\n            <span class=\"input-group-addon\">\n            	<label>C</label><br>\n              <input type=\"radio\" name=\"correct\" value=\"c\">\n            </span>\n        	<textarea type=\"text\" name=\"option3\" class=\"form-control\"></textarea>\n      	</div><br>\n  	</div>\n	</div>\n	\n	<div class=\"options\">\n		<div class=\"col-md-11\">\n      	<div class=\"input-group\">\n            <span class=\"input-group-addon\">\n            	<label>D</label><br>\n              <input type=\"radio\" name=\"correct\" value=\"d\">\n            </span>\n        	<textarea type=\"text\" name=\"option4\" class=\"form-control\"></textarea>\n			</div><br>\n		</div>\n	</div>\n\n	<div class=\"col-md-11\" >\n		<a class=\"btn btn-info add_new_choice\" onclick=\"return AddMultipleChoiceOption(this)\" style=\"float: right;\" >Add new</a>\n	</div>\n\n	<div class=\"col-md-2\">\n		<div class=\"form-group\">\n			<label for=\"\">Right Marks</label>\n			<input type=\"text\" class=\"form-control\" placeholder=\"0\" value=\"\" name=\"right_marks\">\n		</div>\n	</div>\n</div>','2018-12-04 09:17:58','2018-12-21 10:33:56'),(2,'checkbox','\n<div class=\"multiple_response\">\n\n	<div class=\"col-md-12\">\n		<label>Type your question</label>\n		<textarea type=\"text\" class=\"form-control\" name=\"question_text\" rows=\"5\"></textarea><br>\n	</div>\n\n	<div class=\"options\">\n		<div class=\"col-md-11\">\n			Correct\n			<div class=\"input-group\">\n            <span class=\"input-group-addon\">\n					<label>A</label><br>\n              <input type=\"checkbox\" name=\"correct[]\" value=\"a\">\n            </span>\n        	<textarea type=\"text\" name=\"option1\" class=\"form-control\"></textarea>\n      	</div><br>\n  	</div>\n	</div>\n	\n	<div class=\"options\">\n		<div class=\"col-md-11\">\n      	<div class=\"input-group\">\n            <span class=\"input-group-addon\">\n            	<label>B</label><br>\n              <input type=\"checkbox\" name=\"correct[]\" value=\"b\">\n            </span>\n        	<textarea type=\"text\" name=\"option2\" class=\"form-control\"></textarea>\n      	</div><br>\n  	</div>\n	</div>\n	\n	<div class=\"options\">\n		<div class=\"col-md-11\">\n      	<div class=\"input-group\">\n            <span class=\"input-group-addon\">\n            	<label>C</label><br>\n              <input type=\"checkbox\" name=\"correct[]\" value=\"c\">\n            </span>\n        	<textarea type=\"text\" name=\"option3\" class=\"form-control\"></textarea>\n      	</div><br>\n  	</div>\n	</div>\n	\n	<div class=\"options\">\n		<div class=\"col-md-11\">\n      	<div class=\"input-group\">\n            <span class=\"input-group-addon\">\n            	<label>D</label><br>\n              <input type=\"checkbox\" name=\"correct[]\" value=\"d\">\n            </span>\n        	<textarea type=\"text\" name=\"option4\" class=\"form-control\"></textarea>\n			</div><br>\n		</div>\n	</div>\n\n	<div class=\"col-md-11\" >\n		<a class=\"btn btn-info add_new_response\" onclick=\"return AddMultipleResponseOption(this)\" style=\"float: right;\" >Add new</a>\n	</div>\n\n	<div class=\"col-md-2\">\n		<div class=\"form-group\">\n			<label for=\"\">Right Marks</label>\n			<input type=\"text\" class=\"form-control\" placeholder=\"0\" value=\"\" name=\"right_marks\">\n		</div>\n	</div>\n</div>','2018-12-04 09:17:58','2018-12-21 10:34:24'),(3,'true-false','<div class=\"true_false\">\n\n	<div class=\"col-md-12\">\n		<label>Type your question</label>\n		<textarea type=\"text\" class=\"form-control\" name=\"question_text\" rows=\"5\"></textarea><br>\n	</div>\n\n	<div class=\"col-md-11\">\n		Correct\n		<div class=\"input-group\">\n        <span class=\"input-group-addon\">\n          <input type=\"radio\" name=\"correct\" value=\"a\" >\n        </span>\n    	<input type=\"text\" readonly name=\"option1\" value=\"True\" class=\"form-control\">\n  	</div><br>\n	</div>\n	<div class=\"col-md-11\">\n  	<div class=\"input-group\">\n        <span class=\"input-group-addon\">\n          <input type=\"radio\" name=\"correct\" value=\"b\" >\n        </span>\n    	<input type=\"text\" readonly name=\"option2\" value=\"False\" class=\"form-control\">\n  	</div><br>\n	</div>\n\n	<div class=\"col-md-2\">\n		<div class=\"form-group\">\n			<label for=\"\">Right Marks</label>\n			<input type=\"text\" class=\"form-control\" placeholder=\"0\" value=\"\" name=\"right_marks\">\n		</div>\n	</div>\n</div>','2018-12-04 09:17:58','2018-12-21 10:34:08');
/*!40000 ALTER TABLE `option_structure` ENABLE KEYS */;
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
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`(191))
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
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prerequisite`
--

DROP TABLE IF EXISTS `prerequisite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prerequisite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `video_file_mime` varchar(255) DEFAULT NULL,
  `video_file_original_name` varchar(255) DEFAULT NULL,
  `video_file` varchar(255) DEFAULT NULL,
  `pdf_file_original_name` varchar(255) DEFAULT NULL,
  `pdf_file` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '1 - active, 0- Not active',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prerequisite`
--

LOCK TABLES `prerequisite` WRITE;
/*!40000 ALTER TABLE `prerequisite` DISABLE KEYS */;
/*!40000 ALTER TABLE `prerequisite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_category`
--

DROP TABLE IF EXISTS `question_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  `status` tinyint(4) DEFAULT '0' COMMENT '1-active,0-inactive',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_category`
--

LOCK TABLES `question_category` WRITE;
/*!40000 ALTER TABLE `question_category` DISABLE KEYS */;
INSERT INTO `question_category` VALUES (1,'Education',1,'2018-12-21 05:41:48','2018-12-21 05:41:48',NULL),(2,'Sports',1,'2018-12-21 06:11:41','2018-12-21 06:11:41',NULL),(3,'Economics',1,'2018-12-21 06:11:50','2018-12-21 06:11:50',NULL),(4,'Science and Technology',1,'2018-12-21 06:12:03','2018-12-21 06:12:03',NULL);
/*!40000 ALTER TABLE `question_category` ENABLE KEYS */;
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
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1- active , 0 - inactive',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_types`
--

LOCK TABLES `question_types` WRITE;
/*!40000 ALTER TABLE `question_types` DISABLE KEYS */;
INSERT INTO `question_types` VALUES (1,'multiple choice','multiple-choice','radio',1,NULL,'2018-12-21 06:11:11','2018-12-21 06:11:11'),(2,'Multiple Response','multiple-response','checkbox',1,NULL,'2018-12-21 06:11:26','2018-12-21 06:11:26');
/*!40000 ALTER TABLE `question_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `question_type` varchar(255) NOT NULL,
  `option_type` varchar(255) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (1,4,'Inventer of C Language','multiple-choice','radio','James Gosling','Danish Ritchi','Rasmus Lardorf','Linus torvalds',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'b','1',NULL,'2018-12-21 06:19:25','2018-12-21 06:19:25'),(2,4,'Inventer of  C++ language','multiple-choice','radio','Rasmus lardorf','Linus torvalds','Nikola tesla','Bjarn Starstrup',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'d','1',NULL,'2018-12-21 06:20:38','2018-12-21 06:20:38'),(3,4,'Inventer of java','multiple-choice','radio','James gosling','Bjarn Stratrup','denish ritchi','rasmus lardorf',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'a','1',NULL,'2018-12-21 06:21:41','2018-12-21 06:21:41');
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions_options_answer`
--

DROP TABLE IF EXISTS `questions_options_answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions_options_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `index` int(11) NOT NULL,
  `option` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions_options_answer`
--

LOCK TABLES `questions_options_answer` WRITE;
/*!40000 ALTER TABLE `questions_options_answer` DISABLE KEYS */;
INSERT INTO `questions_options_answer` VALUES (1,1,'option1','a','2018-12-10 05:18:53','2018-12-10 05:29:37'),(2,2,'option2','b','2018-12-10 05:18:53','2018-12-10 05:29:39'),(3,3,'option3','c','2018-12-10 05:18:53','2018-12-10 05:29:41'),(4,4,'option4','d','2018-12-10 05:18:53','2018-12-10 05:29:43'),(5,5,'option5','e','2018-12-10 05:18:53','2018-12-10 05:29:45'),(6,6,'option6','f','2018-12-10 05:18:53','2018-12-10 05:29:47'),(7,7,'option7','g','2018-12-10 05:18:53','2018-12-10 05:29:49'),(8,8,'option8','h','2018-12-10 05:18:53','2018-12-10 05:29:51');
/*!40000 ALTER TABLE `questions_options_answer` ENABLE KEYS */;
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
  `structure` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions_types_structure`
--

LOCK TABLES `questions_types_structure` WRITE;
/*!40000 ALTER TABLE `questions_types_structure` DISABLE KEYS */;
INSERT INTO `questions_types_structure` VALUES (1,1,'<div class=\"multiple_choice\">\n\n	<div class=\"col-md-12\">\n		<label>Type your question</label>\n		<textarea type=\"text\" class=\"form-control\" name=\"question_text\" rows=\"5\"></textarea><br>\n	</div>\n\n	<div class=\"options\">\n		<div class=\"col-md-11\">\n			Correct\n			<div class=\"input-group\">\n            <span class=\"input-group-addon\">\n					<label>A</label><br>\n              <input type=\"radio\" name=\"correct\" value=\"a\">\n            </span>\n        	<textarea type=\"text\" name=\"option1\" class=\"form-control\"></textarea>\n      	</div><br>\n  	</div>\n	</div>\n	\n	<div class=\"options\">\n		<div class=\"col-md-11\">\n      	<div class=\"input-group\">\n            <span class=\"input-group-addon\">\n            	<label>B</label><br>\n              <input type=\"radio\" name=\"correct\" value=\"b\">\n            </span>\n        	<textarea type=\"text\" name=\"option2\" class=\"form-control\"></textarea>\n      	</div><br>\n  	</div>\n	</div>\n	\n	<div class=\"options\">\n		<div class=\"col-md-11\">\n      	<div class=\"input-group\">\n            <span class=\"input-group-addon\">\n            	<label>C</label><br>\n              <input type=\"radio\" name=\"correct\" value=\"c\">\n            </span>\n        	<textarea type=\"text\" name=\"option3\" class=\"form-control\"></textarea>\n      	</div><br>\n  	</div>\n	</div>\n	\n	<div class=\"options\">\n		<div class=\"col-md-11\">\n      	<div class=\"input-group\">\n            <span class=\"input-group-addon\">\n            	<label>D</label><br>\n              <input type=\"radio\" name=\"correct\" value=\"d\">\n            </span>\n        	<textarea type=\"text\" name=\"option4\" class=\"form-control\"></textarea>\n			</div><br>\n		</div>\n	</div>\n\n	<div class=\"col-md-11\" >\n		<a class=\"btn btn-info add_new_choice\" onclick=\"return AddMultipleChoiceOption(this)\" style=\"float: right;\" >Add new</a>\n	</div>\n\n	<div class=\"col-md-2\">\n		<div class=\"form-group\">\n			<label for=\"\">Right Marks</label>\n			<input type=\"text\" class=\"form-control\" placeholder=\"0\" value=\"\" name=\"right_marks\">\n		</div>\n	</div>\n</div>','2018-12-21 06:11:11','2018-12-21 06:11:11'),(2,2,'\n<div class=\"multiple_response\">\n\n	<div class=\"col-md-12\">\n		<label>Type your question</label>\n		<textarea type=\"text\" class=\"form-control\" name=\"question_text\" rows=\"5\"></textarea><br>\n	</div>\n\n	<div class=\"options\">\n		<div class=\"col-md-11\">\n			Correct\n			<div class=\"input-group\">\n            <span class=\"input-group-addon\">\n					<label>A</label><br>\n              <input type=\"checkbox\" name=\"correct[]\" value=\"a\">\n            </span>\n        	<textarea type=\"text\" name=\"option1\" class=\"form-control\"></textarea>\n      	</div><br>\n  	</div>\n	</div>\n	\n	<div class=\"options\">\n		<div class=\"col-md-11\">\n      	<div class=\"input-group\">\n            <span class=\"input-group-addon\">\n            	<label>B</label><br>\n              <input type=\"checkbox\" name=\"correct[]\" value=\"b\">\n            </span>\n        	<textarea type=\"text\" name=\"option2\" class=\"form-control\"></textarea>\n      	</div><br>\n  	</div>\n	</div>\n	\n	<div class=\"options\">\n		<div class=\"col-md-11\">\n      	<div class=\"input-group\">\n            <span class=\"input-group-addon\">\n            	<label>C</label><br>\n              <input type=\"checkbox\" name=\"correct[]\" value=\"c\">\n            </span>\n        	<textarea type=\"text\" name=\"option3\" class=\"form-control\"></textarea>\n      	</div><br>\n  	</div>\n	</div>\n	\n	<div class=\"options\">\n		<div class=\"col-md-11\">\n      	<div class=\"input-group\">\n            <span class=\"input-group-addon\">\n            	<label>D</label><br>\n              <input type=\"checkbox\" name=\"correct[]\" value=\"d\">\n            </span>\n        	<textarea type=\"text\" name=\"option4\" class=\"form-control\"></textarea>\n			</div><br>\n		</div>\n	</div>\n\n	<div class=\"col-md-11\" >\n		<a class=\"btn btn-info add_new_response\" onclick=\"return AddMultipleResponseOption(this)\" style=\"float: right;\" >Add new</a>\n	</div>\n\n	<div class=\"col-md-2\">\n		<div class=\"form-group\">\n			<label for=\"\">Right Marks</label>\n			<input type=\"text\" class=\"form-control\" placeholder=\"0\" value=\"\" name=\"right_marks\">\n		</div>\n	</div>\n</div>','2018-12-21 06:11:26','2018-12-21 06:11:26');
/*!40000 ALTER TABLE `questions_types_structure` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','web','2018-12-12 07:41:53','2018-12-12 07:41:53'),(2,'candidate','web','2018-12-12 07:43:12','2018-12-12 07:43:12'),(3,'customer','web','2018-12-12 07:43:49','2018-12-12 07:43:49');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_setting`
--

DROP TABLE IF EXISTS `site_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_title` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `contact_no` bigint(20) NOT NULL,
  `email_id` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `meta_desc` varchar(255) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `deleted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_setting`
--

LOCK TABLES `site_setting` WRITE;
/*!40000 ALTER TABLE `site_setting` DISABLE KEYS */;
INSERT INTO `site_setting` VALUES (5,'Managed Services Council','Managed Services Council',123456789,'admin@gmail.com','Managed Services Council','Managed Services Council','1','2018-12-18 13:46:24','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `site_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(255) NOT NULL,
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `state` varchar(255) NOT NULL,
  `intent` varchar(255) NOT NULL,
  `cart` varchar(255) NOT NULL,
  `payer_id` varchar(255) NOT NULL,
  `payer_status` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `invoice` varchar(255) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `total_amount` decimal(16,2) NOT NULL,
  `description` text NOT NULL,
  `payment_response` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction`
--

LOCK TABLES `transaction` WRITE;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
/*!40000 ALTER TABLE `transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_info`
--

DROP TABLE IF EXISTS `user_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` bigint(101) NOT NULL,
  `organisation_name` varchar(255) DEFAULT NULL,
  `organisation_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_info`
--

LOCK TABLES `user_info` WRITE;
/*!40000 ALTER TABLE `user_info` DISABLE KEYS */;
INSERT INTO `user_info` VALUES (1,1,'admin','gmail',7770097073,NULL,'','2018-12-20 03:18:17','2018-12-20 03:18:17');
/*!40000 ALTER TABLE `user_info` ENABLE KEYS */;
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
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin_gmail','admin@gmail.com','$2y$10$Ik1xuPAoSHQzicpBWRyGIOjdMKl3mL2iZ3anFClgN0J.IgXZplenq','BSuGmHJzwY0jk0wMJkQGVPcEgbVCqbJt2qut9UyS8mJbsAjn1oWwGCXOIKYn','2018-12-20 03:18:17','2018-12-20 03:18:17');
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

-- Dump completed on 2018-12-21 17:27:08
