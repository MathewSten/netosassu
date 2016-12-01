-- phpMiniAdmin dump 1.9.140405
-- Datetime: 2016-11-19 04:29:40
-- Host: 
-- Database: rfomca

/*!40030 SET NAMES utf8 */;
/*!40030 SET GLOBAL max_allowed_packet=16777216 */;

DROP TABLE IF EXISTS `nato_saasu`;
CREATE TABLE `nato_saasu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `netoapi` varchar(250) NOT NULL,
  `netosite` varchar(250) NOT NULL,
  `saasufile` varchar(250) NOT NULL,
  `saasukey` varchar(250) NOT NULL,
  `ebaystore` varchar(250) NOT NULL,
  `autostart` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `nato_saasu` DISABLE KEYS */;
INSERT INTO `nato_saasu` VALUES ('2','er2ucreZ1nTOOyvrGBw2DmCxbnje6eKM','pkgwph','69483','C008542ADCE44E58B7FA74D3222F7933','','1'),('5','0lzA2aDwbEDj0c4lWH66XHPDEM0CdB9E','digoptions','69200','D0B96340B4914AFBBD355A87F697FC65','DIG_Options','0');
/*!40000 ALTER TABLE `nato_saasu` ENABLE KEYS */;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('1','1','admin','admin@admin.com','e10adc3949ba59abbe56e057f20f883e','1');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


-- phpMiniAdmin dump end
