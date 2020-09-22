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

-- Dumping structure for table sint_ams.marking_ds_to_syn
DROP TABLE IF EXISTS `marking_ds_to_syn`;
CREATE TABLE IF NOT EXISTS `marking_ds_to_syn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `taining_year_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `term_syn_id` int(11) NOT NULL,
  `marking_ds_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Dumping data for table sint_ams.marking_ds_to_syn: ~0 rows (approximately)
DELETE FROM `marking_ds_to_syn`;
/*!40000 ALTER TABLE `marking_ds_to_syn` DISABLE KEYS */;
INSERT INTO `marking_ds_to_syn` (`id`, `taining_year_id`, `course_id`, `event_id`, `term_id`, `term_syn_id`, `marking_ds_id`, `updated_at`, `updated_by`) VALUES
	(3, 1, 2, 3, 1, 1, 42, '2020-09-21 14:26:20', 1);
/*!40000 ALTER TABLE `marking_ds_to_syn` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
