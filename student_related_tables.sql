-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.13-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table sint_ams.student_awards_record
DROP TABLE IF EXISTS `student_awards_record`;
CREATE TABLE IF NOT EXISTS `student_awards_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `award_record_info` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table sint_ams.student_awards_record: ~0 rows (approximately)
DELETE FROM `student_awards_record`;
/*!40000 ALTER TABLE `student_awards_record` DISABLE KEYS */;
INSERT INTO `student_awards_record` (`id`, `user_id`, `award_record_info`, `updated_at`, `updated_by`) VALUES
	(1, 48, '{"5f67615fafd8c":{"award":"award","reason":"award","year":"2011"}}', '2020-09-20 14:04:45', 48);
/*!40000 ALTER TABLE `student_awards_record` ENABLE KEYS */;

-- Dumping structure for table sint_ams.student_basic_profile
DROP TABLE IF EXISTS `student_basic_profile`;
CREATE TABLE IF NOT EXISTS `student_basic_profile` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `course_id` int(11) NOT NULL DEFAULT 0,
  `commissioning_course_id` int(11) NOT NULL DEFAULT 0,
  `arms_service_id` int(11) DEFAULT 0,
  `ht_ft` decimal(10,0) DEFAULT 0,
  `ht_inch` decimal(10,1) DEFAULT 0.0,
  `weight` decimal(10,2) DEFAULT 0.00,
  `medical_categorize` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_id` int(11) DEFAULT 0,
  `formation_id` int(11) DEFAULT 0,
  `commanding_officer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commanding_officer_contact_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_place` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `religion_id` int(11) DEFAULT 0,
  `nationality` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commisioning_date` date DEFAULT NULL,
  `anti_date_seniority` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course_position` int(11) DEFAULT NULL,
  `position_out` int(11) DEFAULT NULL,
  `marital_status` enum('0','1','2','3','4') COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '1 = Married, 2 =Unmarried, 3 = Divorced, 4 = widow',
  `date_of_marriage` date DEFAULT NULL,
  `spouse_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spouse_work_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spouse_occupation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_occupation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_occupation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table sint_ams.student_basic_profile: ~2 rows (approximately)
DELETE FROM `student_basic_profile`;
/*!40000 ALTER TABLE `student_basic_profile` DISABLE KEYS */;
INSERT INTO `student_basic_profile` (`id`, `user_id`, `course_id`, `commissioning_course_id`, `arms_service_id`, `ht_ft`, `ht_inch`, `weight`, `medical_categorize`, `unit_id`, `formation_id`, `commanding_officer_name`, `commanding_officer_contact_no`, `birth_place`, `religion_id`, `nationality`, `commisioning_date`, `anti_date_seniority`, `course_position`, `position_out`, `marital_status`, `date_of_marriage`, `spouse_name`, `spouse_work_address`, `spouse_occupation`, `father_name`, `father_occupation`, `father_address`, `mother_name`, `mother_occupation`, `mother_address`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
	(1, 43, 1, 1, 0, NULL, 0.0, 0.00, NULL, 0, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-09-21 04:12:02', 43, '2020-09-21 04:12:02', 43),
	(2, 48, 1, 1, 2, 5, 4.0, 87.00, NULL, 6, 5, NULL, NULL, NULL, 1, NULL, '2020-09-14', NULL, 4, 4, '1', '2020-09-08', 'jorna', 'home', 'Housewife', 'Abdul Rahim', 'Job', 'dhaka', 'Fatima Begum', 'House wife', 'home', '2020-09-21 04:18:47', 48, '2020-09-21 04:18:47', 48);
/*!40000 ALTER TABLE `student_basic_profile` ENABLE KEYS */;

-- Dumping structure for table sint_ams.student_brothers_sisters
DROP TABLE IF EXISTS `student_brothers_sisters`;
CREATE TABLE IF NOT EXISTS `student_brothers_sisters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `brother_sister_info` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table sint_ams.student_brothers_sisters: ~0 rows (approximately)
DELETE FROM `student_brothers_sisters`;
/*!40000 ALTER TABLE `student_brothers_sisters` DISABLE KEYS */;
INSERT INTO `student_brothers_sisters` (`id`, `user_id`, `brother_sister_info`, `updated_at`, `updated_by`) VALUES
	(1, 48, '{"5f675fab93558":{"name":"foysal","relation":"brother","age":"22","occupation":"student","address":"rampura"},"5f6760c50917a":{"name":"fahad","relation":"brother","age":"27","occupation":"job holder","address":"rampura"}}', '2020-09-20 14:02:03', 48);
/*!40000 ALTER TABLE `student_brothers_sisters` ENABLE KEYS */;

-- Dumping structure for table sint_ams.student_civil_education
DROP TABLE IF EXISTS `student_civil_education`;
CREATE TABLE IF NOT EXISTS `student_civil_education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `civil_education_info` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table sint_ams.student_civil_education: ~0 rows (approximately)
DELETE FROM `student_civil_education`;
/*!40000 ALTER TABLE `student_civil_education` DISABLE KEYS */;
INSERT INTO `student_civil_education` (`id`, `user_id`, `civil_education_info`, `updated_at`, `updated_by`) VALUES
	(1, 48, '{"5f6761006dbee":{"institute_name":"bmlhs","examination":"ssc","result":"5","year":"2011"},"5f67611891696":{"institute_name":"bmarpc","examination":"hsc","result":"5","year":"2013"}}', '2020-09-20 14:03:19', 48);
/*!40000 ALTER TABLE `student_civil_education` ENABLE KEYS */;

-- Dumping structure for table sint_ams.student_medical_details
DROP TABLE IF EXISTS `student_medical_details`;
CREATE TABLE IF NOT EXISTS `student_medical_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `category` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `blood_group` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `over_under_weight` enum('0','1','2','3') COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '2=normal, 3=over, 1=under',
  `any_disease` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ht_ft` decimal(10,0) DEFAULT NULL,
  `ht_inch` decimal(10,1) DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table sint_ams.student_medical_details: ~0 rows (approximately)
DELETE FROM `student_medical_details`;
/*!40000 ALTER TABLE `student_medical_details` DISABLE KEYS */;
INSERT INTO `student_medical_details` (`id`, `user_id`, `category`, `blood_group`, `date_of_birth`, `over_under_weight`, `any_disease`, `ht_ft`, `ht_inch`, `weight`, `updated_at`, `updated_by`) VALUES
	(1, 48, 'category', 'b+', '2020-09-15', '3', NULL, NULL, NULL, NULL, '2020-09-21 03:56:42', 48);
/*!40000 ALTER TABLE `student_medical_details` ENABLE KEYS */;

-- Dumping structure for table sint_ams.student_next_kin
DROP TABLE IF EXISTS `student_next_kin`;
CREATE TABLE IF NOT EXISTS `student_next_kin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT 0,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `relation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `division_id` int(11) DEFAULT 0,
  `district_id` int(11) DEFAULT 0,
  `thana_id` int(11) DEFAULT 0,
  `address_details` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table sint_ams.student_next_kin: ~0 rows (approximately)
DELETE FROM `student_next_kin`;
/*!40000 ALTER TABLE `student_next_kin` DISABLE KEYS */;
INSERT INTO `student_next_kin` (`id`, `user_id`, `name`, `relation`, `division_id`, `district_id`, `thana_id`, `address_details`, `updated_at`, `updated_by`) VALUES
	(2, 48, 'Aziz', 'friend', 3, 1, 145, 'ajimpur', '2020-09-20 14:06:28', 48);
/*!40000 ALTER TABLE `student_next_kin` ENABLE KEYS */;

-- Dumping structure for table sint_ams.student_others
DROP TABLE IF EXISTS `student_others`;
CREATE TABLE IF NOT EXISTS `student_others` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `visited_countries_id` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `special_quality` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `professional_computer` enum('1','2') COLLATE utf8_unicode_ci DEFAULT '2' COMMENT '1 = YES, 2 = NO',
  `swimming` enum('0','1','2','3') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '1 = Swimmer, 2 = Weak Swimmer, 3 = Non Swimmer',
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table sint_ams.student_others: ~0 rows (approximately)
DELETE FROM `student_others`;
/*!40000 ALTER TABLE `student_others` DISABLE KEYS */;
INSERT INTO `student_others` (`id`, `user_id`, `visited_countries_id`, `special_quality`, `professional_computer`, `swimming`, `updated_at`, `updated_by`) VALUES
	(1, 43, '["1","2","3"]', 'Shooting', '1', '1', '2020-09-17 05:23:46', 43),
	(2, 48, '["1","2","3"]', 'sleeping', '1', '1', '2020-09-20 14:08:50', 48);
/*!40000 ALTER TABLE `student_others` ENABLE KEYS */;

-- Dumping structure for table sint_ams.student_permanent_address
DROP TABLE IF EXISTS `student_permanent_address`;
CREATE TABLE IF NOT EXISTS `student_permanent_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `division_id` int(11) DEFAULT 0,
  `district_id` int(11) DEFAULT 0,
  `thana_id` int(11) DEFAULT 0,
  `address_details` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table sint_ams.student_permanent_address: ~1 rows (approximately)
DELETE FROM `student_permanent_address`;
/*!40000 ALTER TABLE `student_permanent_address` DISABLE KEYS */;
INSERT INTO `student_permanent_address` (`id`, `user_id`, `division_id`, `district_id`, `thana_id`, `address_details`, `updated_at`, `updated_by`) VALUES
	(1, 43, 1, 34, 2, '1 no, kastom ghat,  khulna', '2020-09-20 04:55:05', 43),
	(2, 48, 3, 1, 145, 'banoshri', '2020-09-20 14:02:40', 48);
/*!40000 ALTER TABLE `student_permanent_address` ENABLE KEYS */;

-- Dumping structure for table sint_ams.student_punishment_record
DROP TABLE IF EXISTS `student_punishment_record`;
CREATE TABLE IF NOT EXISTS `student_punishment_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `punishment_record_info` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table sint_ams.student_punishment_record: ~0 rows (approximately)
DELETE FROM `student_punishment_record`;
/*!40000 ALTER TABLE `student_punishment_record` DISABLE KEYS */;
INSERT INTO `student_punishment_record` (`id`, `user_id`, `punishment_record_info`, `updated_at`, `updated_by`) VALUES
	(1, 48, '{"5f67617dd9333":{"punishment":"punish","reason":"punish","year":"2011"}}', '2020-09-20 14:05:10', 48);
/*!40000 ALTER TABLE `student_punishment_record` ENABLE KEYS */;

-- Dumping structure for table sint_ams.student_relative_in_defence
DROP TABLE IF EXISTS `student_relative_in_defence`;
CREATE TABLE IF NOT EXISTS `student_relative_in_defence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `student_relative_info` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table sint_ams.student_relative_in_defence: ~0 rows (approximately)
DELETE FROM `student_relative_in_defence`;
/*!40000 ALTER TABLE `student_relative_in_defence` DISABLE KEYS */;
INSERT INTO `student_relative_in_defence` (`id`, `user_id`, `student_relative_info`, `updated_at`, `updated_by`) VALUES
	(1, 48, '{"5f67619723104":{"course":"1","institute":"bmarpc","grading":"d","year":"2013"}}', '2020-09-20 14:05:42', 48);
/*!40000 ALTER TABLE `student_relative_in_defence` ENABLE KEYS */;

-- Dumping structure for table sint_ams.student_service_record
DROP TABLE IF EXISTS `student_service_record`;
CREATE TABLE IF NOT EXISTS `student_service_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `service_record_info` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table sint_ams.student_service_record: ~0 rows (approximately)
DELETE FROM `student_service_record`;
/*!40000 ALTER TABLE `student_service_record` DISABLE KEYS */;
INSERT INTO `student_service_record` (`id`, `user_id`, `service_record_info`, `updated_at`, `updated_by`) VALUES
	(1, 48, '{"5f676127b2782":{"unit":"7","appointment":"1","year":"2011"},"5f676146ead1e":{"unit":"7","appointment":"2","year":"2013"}}', '2020-09-20 14:04:15', 48);
/*!40000 ALTER TABLE `student_service_record` ENABLE KEYS */;

-- Dumping structure for table sint_ams.student_winter_collective_training
DROP TABLE IF EXISTS `student_winter_collective_training`;
CREATE TABLE IF NOT EXISTS `student_winter_collective_training` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `participated_no` int(11) DEFAULT 0,
  `training_info` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table sint_ams.student_winter_collective_training: ~0 rows (approximately)
DELETE FROM `student_winter_collective_training`;
/*!40000 ALTER TABLE `student_winter_collective_training` DISABLE KEYS */;
INSERT INTO `student_winter_collective_training` (`id`, `user_id`, `participated_no`, `training_info`, `updated_at`, `updated_by`) VALUES
	(1, 48, 2, '{"1":{"exercise":"winter-1","year":"2017","place":"dhaka"},"2":{"exercise":"winter-1","year":"2019","place":"barishal"}}', '2020-09-20 12:09:32', 48),
	(2, 43, 2, '{"1":{"exercise":"winter-3","year":"2011","place":"dhaka"},"2":{"exercise":"winter-4","year":"2013","place":"dhaka"}}', '2020-09-20 14:08:12', 43);
/*!40000 ALTER TABLE `student_winter_collective_training` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
