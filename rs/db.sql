/*
Navicat MySQL Data Transfer

Source Server         : referralsystem
Source Server Version : 50540
Source Host           : 10.10.10.2:3306
Source Database       : referralsystem

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2015-01-22 14:40:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `core_settings`
-- ----------------------------
DROP TABLE IF EXISTS `core_settings`;
CREATE TABLE `core_settings` (
  `slug` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `default` text COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`slug`),
  UNIQUE KEY `unique - slug` (`slug`),
  KEY `index - slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Stores settings for the multi-site interface';

-- ----------------------------
-- Records of core_settings
-- ----------------------------
INSERT INTO `core_settings` VALUES ('date_format', 'g:ia -- m/d/y', 'g:ia -- m/d/y');
INSERT INTO `core_settings` VALUES ('lang_direction', 'ltr', 'ltr');
INSERT INTO `core_settings` VALUES ('status_message', 'This site has been disabled by a super-administrator.', 'This site has been disabled by a super-administrator.');

-- ----------------------------
-- Table structure for `core_sites`
-- ----------------------------
DROP TABLE IF EXISTS `core_sites`;
CREATE TABLE `core_sites` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ref` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `domain` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_on` int(11) NOT NULL DEFAULT '0',
  `updated_on` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Unique ref` (`ref`),
  UNIQUE KEY `Unique domain` (`domain`),
  KEY `ref` (`ref`),
  KEY `domain` (`domain`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of core_sites
-- ----------------------------
INSERT INTO `core_sites` VALUES ('1', 'Default Site', 'default', 'localhost', '1', '1406876169', '0');

-- ----------------------------
-- Table structure for `core_users`
-- ----------------------------
DROP TABLE IF EXISTS `core_users`;
CREATE TABLE `core_users` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `salt` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `group_id` int(11) DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `activation_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` int(11) NOT NULL,
  `last_login` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `forgotten_password_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Super User Information';

-- ----------------------------
-- Records of core_users
-- ----------------------------
INSERT INTO `core_users` VALUES ('1', 'sushilmishra@cdnsol.com', '04ab4033784601ea0f07f1702e2a5af44ad5683f', '49585', '1', null, '1', null, '1406876168', '1406876168', 'admin', null, null);

-- ----------------------------
-- Table structure for `default_admin_configuration`
-- ----------------------------
DROP TABLE IF EXISTS `default_admin_configuration`;
CREATE TABLE `default_admin_configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `referral_point` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `paypal_id` varchar(255) DEFAULT NULL,
  `referral_point_amt` varchar(150) DEFAULT NULL,
  `currency` varchar(150) DEFAULT NULL,
  `minimum_referral_point` int(11) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of default_admin_configuration
-- ----------------------------
INSERT INTO `default_admin_configuration` VALUES ('2', '5', '58', 'support@cdnsol.com', 'tester@cdnsol.com', '0.5', 'USD', '5', '2014-12-03 19:00:55');

-- ----------------------------
-- Table structure for `default_affiliate_banner_log`
-- ----------------------------
DROP TABLE IF EXISTS `default_affiliate_banner_log`;
CREATE TABLE `default_affiliate_banner_log` (
  `aff_banner_id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` int(11) DEFAULT NULL,
  `banner_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`aff_banner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of default_affiliate_banner_log
-- ----------------------------
INSERT INTO `default_affiliate_banner_log` VALUES ('1', '56', '1');
INSERT INTO `default_affiliate_banner_log` VALUES ('2', '55', '1');
INSERT INTO `default_affiliate_banner_log` VALUES ('3', '5', '4');
INSERT INTO `default_affiliate_banner_log` VALUES ('4', '58', '4');
INSERT INTO `default_affiliate_banner_log` VALUES ('5', '55', '4');
INSERT INTO `default_affiliate_banner_log` VALUES ('6', '55', '2');
INSERT INTO `default_affiliate_banner_log` VALUES ('7', '123', '5');
INSERT INTO `default_affiliate_banner_log` VALUES ('12', '124', '9');
INSERT INTO `default_affiliate_banner_log` VALUES ('13', '127', '5');
INSERT INTO `default_affiliate_banner_log` VALUES ('14', '126', '10');
INSERT INTO `default_affiliate_banner_log` VALUES ('15', '129', '1');
INSERT INTO `default_affiliate_banner_log` VALUES ('16', '126', '11');
INSERT INTO `default_affiliate_banner_log` VALUES ('17', '126', '13');
INSERT INTO `default_affiliate_banner_log` VALUES ('18', '126', '16');
INSERT INTO `default_affiliate_banner_log` VALUES ('19', '126', '15');
INSERT INTO `default_affiliate_banner_log` VALUES ('20', '126', '12');
INSERT INTO `default_affiliate_banner_log` VALUES ('21', '137', '1');
INSERT INTO `default_affiliate_banner_log` VALUES ('22', '138', '5');
INSERT INTO `default_affiliate_banner_log` VALUES ('23', '140', '1');
INSERT INTO `default_affiliate_banner_log` VALUES ('24', '141', '1');
INSERT INTO `default_affiliate_banner_log` VALUES ('25', '142', '1');
INSERT INTO `default_affiliate_banner_log` VALUES ('26', '143', '1');
INSERT INTO `default_affiliate_banner_log` VALUES ('27', '144', '1');
INSERT INTO `default_affiliate_banner_log` VALUES ('28', '146', '1');
INSERT INTO `default_affiliate_banner_log` VALUES ('29', '147', '26');
INSERT INTO `default_affiliate_banner_log` VALUES ('30', '147', '29');
INSERT INTO `default_affiliate_banner_log` VALUES ('31', '147', '28');
INSERT INTO `default_affiliate_banner_log` VALUES ('32', '147', '27');
INSERT INTO `default_affiliate_banner_log` VALUES ('33', '147', '25');
INSERT INTO `default_affiliate_banner_log` VALUES ('34', '55', '3');
INSERT INTO `default_affiliate_banner_log` VALUES ('35', '147', '24');
INSERT INTO `default_affiliate_banner_log` VALUES ('36', '147', '23');
INSERT INTO `default_affiliate_banner_log` VALUES ('37', '147', '18');
INSERT INTO `default_affiliate_banner_log` VALUES ('38', '149', '27');
INSERT INTO `default_affiliate_banner_log` VALUES ('39', '5', '30');
INSERT INTO `default_affiliate_banner_log` VALUES ('40', '5', '5');
INSERT INTO `default_affiliate_banner_log` VALUES ('41', '55', '30');
INSERT INTO `default_affiliate_banner_log` VALUES ('42', '55', '5');
INSERT INTO `default_affiliate_banner_log` VALUES ('43', '152', '1');
INSERT INTO `default_affiliate_banner_log` VALUES ('44', '151', '31');
INSERT INTO `default_affiliate_banner_log` VALUES ('45', '151', '35');
INSERT INTO `default_affiliate_banner_log` VALUES ('46', '154', '5');
INSERT INTO `default_affiliate_banner_log` VALUES ('47', '153', '36');
INSERT INTO `default_affiliate_banner_log` VALUES ('48', '153', '37');

-- ----------------------------
-- Table structure for `default_affiliate_configuration`
-- ----------------------------
DROP TABLE IF EXISTS `default_affiliate_configuration`;
CREATE TABLE `default_affiliate_configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_mode` enum('0','1') DEFAULT '0',
  `paypal_id` varchar(255) DEFAULT NULL,
  `chinapay_id` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of default_affiliate_configuration
-- ----------------------------
INSERT INTO `default_affiliate_configuration` VALUES ('2', '1', null, 'chinapay@chinapay.com', 'tester@tester.com', '63', 'tester', 'tester', 'this is another details for testing', '2014-10-10 06:35:22');
INSERT INTO `default_affiliate_configuration` VALUES ('3', '0', 'paypal@paypal.com', null, 'rajendrapatidar@cdnsol.com', '62', 'raj', 'pati', 'this is details for testing', '2014-10-10 06:35:43');
INSERT INTO `default_affiliate_configuration` VALUES ('4', '1', null, 'chinapay@chinapay.com', 'tester@tester.com', '62', 'testertt', 'testert', 'this is another details for testing', '2014-10-10 06:35:54');
INSERT INTO `default_affiliate_configuration` VALUES ('5', '0', 'amitwali@cdnsol.com', null, 'rajendrapatidar@cdnsol.com', '61', 'rajendra', 'patidar', 'this is details for testing', '2014-11-24 05:40:26');
INSERT INTO `default_affiliate_configuration` VALUES ('17', '1', null, 'fdsfsf', 'test@cdnsol.com', '61', 'rajendra', 'gdfgdf', 'fdsf', '2014-11-22 09:10:49');
INSERT INTO `default_affiliate_configuration` VALUES ('20', '0', 'amitwali@cdnsol.com', null, 'rajendrapatidar@cdnsol.com', '55', 'rajendra', 'patidar', 'this is details for testing in the form of data side event for the details in the form of testing', '2014-12-11 17:28:36');
INSERT INTO `default_affiliate_configuration` VALUES ('21', '0', 'rajendrapatidar@cdnsol.com', null, 'rajendrapatidar@cdnsol.com', '126', 'Rajendra', 'Patidar', 'test', '2014-12-04 14:38:24');
INSERT INTO `default_affiliate_configuration` VALUES ('22', '0', 'rajendrapatidar@cdnsol.com', null, 'rajendrapatidar@cdnsol.com', '147', 'Rajendra', 'Patidar', 'hiohio', '2014-12-05 12:21:29');
INSERT INTO `default_affiliate_configuration` VALUES ('23', '0', 'rajendrapatidar@cdnsol.com', null, 'prashantgupta@cdnsol.com', '153', 'test', 'gupta', 'gfh', '2014-12-12 12:45:29');

-- ----------------------------
-- Table structure for `default_affiliate_product_email_log`
-- ----------------------------
DROP TABLE IF EXISTS `default_affiliate_product_email_log`;
CREATE TABLE `default_affiliate_product_email_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` int(11) DEFAULT NULL,
  `banner_id` int(11) DEFAULT NULL,
  `email_to` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=245 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of default_affiliate_product_email_log
-- ----------------------------
INSERT INTO `default_affiliate_product_email_log` VALUES ('1', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-11-21 15:24:01');
INSERT INTO `default_affiliate_product_email_log` VALUES ('2', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-11-21 11:20:24');
INSERT INTO `default_affiliate_product_email_log` VALUES ('3', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-11-21 11:20:27');
INSERT INTO `default_affiliate_product_email_log` VALUES ('4', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-11-21 11:22:17');
INSERT INTO `default_affiliate_product_email_log` VALUES ('5', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-11-21 11:23:05');
INSERT INTO `default_affiliate_product_email_log` VALUES ('6', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-11-21 17:03:46');
INSERT INTO `default_affiliate_product_email_log` VALUES ('7', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-11-21 11:24:18');
INSERT INTO `default_affiliate_product_email_log` VALUES ('8', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-11-21 11:25:38');
INSERT INTO `default_affiliate_product_email_log` VALUES ('9', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-11-21 11:25:46');
INSERT INTO `default_affiliate_product_email_log` VALUES ('10', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-11-21 11:26:10');
INSERT INTO `default_affiliate_product_email_log` VALUES ('11', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-11-21 11:26:36');
INSERT INTO `default_affiliate_product_email_log` VALUES ('12', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-11-21 11:26:58');
INSERT INTO `default_affiliate_product_email_log` VALUES ('13', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-11-21 11:27:57');
INSERT INTO `default_affiliate_product_email_log` VALUES ('14', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-11-21 11:30:06');
INSERT INTO `default_affiliate_product_email_log` VALUES ('15', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-11-25 05:42:39');
INSERT INTO `default_affiliate_product_email_log` VALUES ('16', '55', '1', 'rajendrapatidar@cdnsol.com,', '2014-11-25 05:47:46');
INSERT INTO `default_affiliate_product_email_log` VALUES ('17', '55', '1', 'rajendrapatidar@cdnsol.com,', '2014-11-25 05:49:52');
INSERT INTO `default_affiliate_product_email_log` VALUES ('18', '55', '1', 'rajendrapatidar@cdnsol.com,', '2014-11-25 11:40:14');
INSERT INTO `default_affiliate_product_email_log` VALUES ('19', '55', '1', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:02:58');
INSERT INTO `default_affiliate_product_email_log` VALUES ('20', '55', '1', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:04:57');
INSERT INTO `default_affiliate_product_email_log` VALUES ('21', '55', '1', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:06:54');
INSERT INTO `default_affiliate_product_email_log` VALUES ('22', '55', '1', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:08:52');
INSERT INTO `default_affiliate_product_email_log` VALUES ('23', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:10:58');
INSERT INTO `default_affiliate_product_email_log` VALUES ('24', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:15:29');
INSERT INTO `default_affiliate_product_email_log` VALUES ('25', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:17:42');
INSERT INTO `default_affiliate_product_email_log` VALUES ('26', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:18:23');
INSERT INTO `default_affiliate_product_email_log` VALUES ('27', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:18:42');
INSERT INTO `default_affiliate_product_email_log` VALUES ('28', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:18:54');
INSERT INTO `default_affiliate_product_email_log` VALUES ('29', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:37:34');
INSERT INTO `default_affiliate_product_email_log` VALUES ('30', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:38:13');
INSERT INTO `default_affiliate_product_email_log` VALUES ('31', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:38:50');
INSERT INTO `default_affiliate_product_email_log` VALUES ('32', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:38:53');
INSERT INTO `default_affiliate_product_email_log` VALUES ('33', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:39:06');
INSERT INTO `default_affiliate_product_email_log` VALUES ('34', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:39:32');
INSERT INTO `default_affiliate_product_email_log` VALUES ('35', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:39:41');
INSERT INTO `default_affiliate_product_email_log` VALUES ('36', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:39:44');
INSERT INTO `default_affiliate_product_email_log` VALUES ('37', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:42:05');
INSERT INTO `default_affiliate_product_email_log` VALUES ('38', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:42:22');
INSERT INTO `default_affiliate_product_email_log` VALUES ('39', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:42:43');
INSERT INTO `default_affiliate_product_email_log` VALUES ('40', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:43:13');
INSERT INTO `default_affiliate_product_email_log` VALUES ('41', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:43:21');
INSERT INTO `default_affiliate_product_email_log` VALUES ('42', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:43:27');
INSERT INTO `default_affiliate_product_email_log` VALUES ('43', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:43:46');
INSERT INTO `default_affiliate_product_email_log` VALUES ('44', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:44:00');
INSERT INTO `default_affiliate_product_email_log` VALUES ('45', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-11-25 06:45:30');
INSERT INTO `default_affiliate_product_email_log` VALUES ('46', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-11-25 12:57:31');
INSERT INTO `default_affiliate_product_email_log` VALUES ('47', '55', '6', 'rajendrapatidar@cdnsol.com,', '2014-11-25 13:05:01');
INSERT INTO `default_affiliate_product_email_log` VALUES ('48', '55', '6', 'piyushjain@cdnsol.com', '2014-11-25 13:05:38');
INSERT INTO `default_affiliate_product_email_log` VALUES ('49', '55', '6', 'prashantgupta@cdnsol.com', '2014-11-25 13:06:02');
INSERT INTO `default_affiliate_product_email_log` VALUES ('50', '55', '1', 'rajendrapatidar@cdnsol.com,', '2014-11-25 11:37:30');
INSERT INTO `default_affiliate_product_email_log` VALUES ('51', '55', '1', 'rajendrapatidar@cdnsol.com,', '2014-11-25 11:38:53');
INSERT INTO `default_affiliate_product_email_log` VALUES ('52', '55', '1', 'rajendrapatidar@cdnsol.com,', '2014-11-25 11:39:32');
INSERT INTO `default_affiliate_product_email_log` VALUES ('53', '55', '1', 'rajendrapatidar@cdnsol.com,', '2014-11-25 11:40:02');
INSERT INTO `default_affiliate_product_email_log` VALUES ('54', '55', '6', 'rajendrapatidar@cdnsol.com,', '2014-11-25 12:56:17');
INSERT INTO `default_affiliate_product_email_log` VALUES ('55', '124', '6', 'prashantgupta@cdnsol.com', '2014-11-26 11:38:29');
INSERT INTO `default_affiliate_product_email_log` VALUES ('56', '124', '8', 'prashantgupta@cdnsol.com', '2014-11-26 12:06:03');
INSERT INTO `default_affiliate_product_email_log` VALUES ('57', '124', '8', 'prashantgupta@cdnsol.com', '2014-11-26 12:49:35');
INSERT INTO `default_affiliate_product_email_log` VALUES ('58', '55', '1', 'sushimmishra@cdnsol.com', '2014-11-27 10:46:19');
INSERT INTO `default_affiliate_product_email_log` VALUES ('59', '55', '1', 'rajendrapatidar@cdnsol.com,', '2014-11-27 10:50:10');
INSERT INTO `default_affiliate_product_email_log` VALUES ('60', '55', '1', 'sushilmishra@cdnsol.com', '2014-11-27 10:52:54');
INSERT INTO `default_affiliate_product_email_log` VALUES ('61', '55', '1', 'rajendrapatidar@cdnsol.com', '2014-11-27 11:06:12');
INSERT INTO `default_affiliate_product_email_log` VALUES ('62', '55', '1', 'rajendrapatidar@cdnsol.com', '2014-11-27 11:07:46');
INSERT INTO `default_affiliate_product_email_log` VALUES ('63', '55', '2', 'sushilmishra@cdnsol.com', '2014-11-27 11:14:07');
INSERT INTO `default_affiliate_product_email_log` VALUES ('64', '55', '2', 'sushilmishra@cdnsol.com', '2014-11-27 11:18:04');
INSERT INTO `default_affiliate_product_email_log` VALUES ('65', '55', '1', 'sushilmishra@cdnsol.com', '2014-11-27 11:18:37');
INSERT INTO `default_affiliate_product_email_log` VALUES ('66', '55', '1', 'sushilmishra@cdnsol.com', '2014-11-27 11:19:35');
INSERT INTO `default_affiliate_product_email_log` VALUES ('67', '55', '1', 'rajendrapatidar@cdnsol.com', '2014-11-27 11:19:51');
INSERT INTO `default_affiliate_product_email_log` VALUES ('68', '55', '1', 'sushilmishra@cdnsol.com', '2014-11-27 11:20:15');
INSERT INTO `default_affiliate_product_email_log` VALUES ('69', '55', '1', 'sushilmishra@cdnsol.com', '2014-11-27 11:40:04');
INSERT INTO `default_affiliate_product_email_log` VALUES ('70', '55', '2', 'sushilmishra@cdnsol.com', '2014-11-27 06:03:50');
INSERT INTO `default_affiliate_product_email_log` VALUES ('71', '55', '2', 'sunilpatidar152207@gmail.com,sushil', '2014-11-27 06:04:09');
INSERT INTO `default_affiliate_product_email_log` VALUES ('72', '55', '2', 'sushilmishra@cdnsol.com,piyushjain@cdnsol.com', '2014-11-27 06:05:25');
INSERT INTO `default_affiliate_product_email_log` VALUES ('73', '55', '2', 'sushilmishra@cdnsol.com,', '2014-11-27 06:06:14');
INSERT INTO `default_affiliate_product_email_log` VALUES ('74', '55', '2', 'sushilmishra@cdnsol.com,', '2014-11-27 06:08:17');
INSERT INTO `default_affiliate_product_email_log` VALUES ('75', '55', '2', 'sushilmishra@cdnsol.com,', '2014-11-27 06:08:47');
INSERT INTO `default_affiliate_product_email_log` VALUES ('76', '55', '2', 'sushilmishra@cdnsol.com,', '2014-11-27 06:09:38');
INSERT INTO `default_affiliate_product_email_log` VALUES ('77', '55', '2', 'sushilmishra@cdnsol.com,', '2014-11-27 06:10:19');
INSERT INTO `default_affiliate_product_email_log` VALUES ('78', '55', '2', 'sushilmishra@cdnsol.com,', '2014-11-27 06:11:12');
INSERT INTO `default_affiliate_product_email_log` VALUES ('79', '55', '2', 'sushilmishra@cdnsol.com,', '2014-11-27 06:11:29');
INSERT INTO `default_affiliate_product_email_log` VALUES ('80', '55', '2', 'sushilmishra@cdnsol.com,', '2014-11-27 06:11:56');
INSERT INTO `default_affiliate_product_email_log` VALUES ('81', '55', '2', 'sushilmishra@cdnsol.com,', '2014-11-27 06:13:04');
INSERT INTO `default_affiliate_product_email_log` VALUES ('82', '55', '2', 'piyushjain@cdnsol.com,rajendrapatidar@cdnsol.com,', '2014-11-27 06:14:05');
INSERT INTO `default_affiliate_product_email_log` VALUES ('83', '55', '2', 'piyushjain@cdnsol.com,', '2014-11-27 06:14:21');
INSERT INTO `default_affiliate_product_email_log` VALUES ('84', '55', '2', 'sushilmishra@cdnsol.com', '2014-11-27 10:14:58');
INSERT INTO `default_affiliate_product_email_log` VALUES ('85', '55', '2', 'sushilmishra@cdnsol.com', '2014-11-27 10:15:29');
INSERT INTO `default_affiliate_product_email_log` VALUES ('86', '55', '2', 'sushilmishra@cdnsol.com', '2014-11-27 10:15:41');
INSERT INTO `default_affiliate_product_email_log` VALUES ('87', '55', '2', 'sushilmishra@cdnsol.com', '2014-11-27 10:16:09');
INSERT INTO `default_affiliate_product_email_log` VALUES ('88', '55', '2', 'sushilmishra1@cdnsol.com', '2014-11-27 10:16:27');
INSERT INTO `default_affiliate_product_email_log` VALUES ('89', '55', '2', 'sushilmishra@cdnsol.com', '2014-11-27 10:17:10');
INSERT INTO `default_affiliate_product_email_log` VALUES ('90', '124', '9', 'prashantgupta@cdnsol.com', '2014-11-28 15:21:16');
INSERT INTO `default_affiliate_product_email_log` VALUES ('91', '124', '9', 'prashantgupta@cdnsol.com', '2014-11-28 15:36:20');
INSERT INTO `default_affiliate_product_email_log` VALUES ('92', '126', '10', 'prashantgupta@cdnsol.com', '2014-12-02 12:57:07');
INSERT INTO `default_affiliate_product_email_log` VALUES ('93', '126', '10', 'prashantgupta@cdnsol.com', '2014-12-02 13:16:49');
INSERT INTO `default_affiliate_product_email_log` VALUES ('94', '126', '10', 'prashantgupta@cdnsol.com', '2014-12-02 13:19:35');
INSERT INTO `default_affiliate_product_email_log` VALUES ('95', '126', '10', 'prashantgupta@cdnsol.com', '2014-12-02 15:15:35');
INSERT INTO `default_affiliate_product_email_log` VALUES ('96', '126', '10', 'prashantgupta@cdnsol.com', '2014-12-02 15:42:57');
INSERT INTO `default_affiliate_product_email_log` VALUES ('97', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-12-03 07:22:43');
INSERT INTO `default_affiliate_product_email_log` VALUES ('98', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-12-03 07:23:42');
INSERT INTO `default_affiliate_product_email_log` VALUES ('99', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-12-03 07:24:55');
INSERT INTO `default_affiliate_product_email_log` VALUES ('100', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-12-03 07:26:03');
INSERT INTO `default_affiliate_product_email_log` VALUES ('101', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-12-03 07:26:18');
INSERT INTO `default_affiliate_product_email_log` VALUES ('102', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-12-03 07:26:32');
INSERT INTO `default_affiliate_product_email_log` VALUES ('103', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-12-03 07:26:46');
INSERT INTO `default_affiliate_product_email_log` VALUES ('104', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-12-03 07:27:34');
INSERT INTO `default_affiliate_product_email_log` VALUES ('105', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-12-03 07:28:05');
INSERT INTO `default_affiliate_product_email_log` VALUES ('106', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-12-03 07:28:21');
INSERT INTO `default_affiliate_product_email_log` VALUES ('107', '55', '1', 'rajendrapatidar@cdnsol.com,', '2014-12-03 14:52:58');
INSERT INTO `default_affiliate_product_email_log` VALUES ('108', '126', '10', 'prashantgupta@cdnsol.com', '2014-12-04 13:28:24');
INSERT INTO `default_affiliate_product_email_log` VALUES ('109', '126', '11', 'prashantgupta@cdnsol.com,', '2014-12-04 14:58:48');
INSERT INTO `default_affiliate_product_email_log` VALUES ('110', '126', '12', 'prashantgupta@cdnsol.com,', '2014-12-04 15:18:23');
INSERT INTO `default_affiliate_product_email_log` VALUES ('111', '126', '13', 'prashantgupta@cdnsol.com,', '2014-12-04 15:22:06');
INSERT INTO `default_affiliate_product_email_log` VALUES ('112', '55', '1', 'rajendrapatidar@cdnsol.com,', '2014-12-05 06:06:48');
INSERT INTO `default_affiliate_product_email_log` VALUES ('113', '55', '1', 'rajendrapatidar@cdnsol.com,', '2014-12-05 11:49:37');
INSERT INTO `default_affiliate_product_email_log` VALUES ('114', '55', '1', 'rajendrapatidar@cdnsol.com,', '2014-12-05 06:12:33');
INSERT INTO `default_affiliate_product_email_log` VALUES ('115', '55', '1', 'rajendrapatidar@cdnsol.com,', '2014-12-05 06:13:35');
INSERT INTO `default_affiliate_product_email_log` VALUES ('116', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-12-05 06:27:58');
INSERT INTO `default_affiliate_product_email_log` VALUES ('117', '147', '26', 'prashantgupta@cdnsol.com,', '2014-12-05 12:20:14');
INSERT INTO `default_affiliate_product_email_log` VALUES ('118', '147', '24', 'prashantgupta@cdnsol.com,', '2014-12-05 12:28:04');
INSERT INTO `default_affiliate_product_email_log` VALUES ('119', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-12-05 09:06:15');
INSERT INTO `default_affiliate_product_email_log` VALUES ('120', '55', '1', 'vaibhavjoshi@cdnsol.com', '2014-12-05 16:41:04');
INSERT INTO `default_affiliate_product_email_log` VALUES ('121', '55', '2', 'sushilmishra@cdnsol.com,', '2014-12-05 11:36:43');
INSERT INTO `default_affiliate_product_email_log` VALUES ('122', '55', '2', 'sushilmishra@cdnsol.com,', '2014-12-05 11:38:00');
INSERT INTO `default_affiliate_product_email_log` VALUES ('123', '55', '2', 'sushilmishra@cdnsol.com,', '2014-12-05 11:40:55');
INSERT INTO `default_affiliate_product_email_log` VALUES ('124', '55', '2', 'sushilmishra@cdnsol.com,', '2014-12-05 17:25:45');
INSERT INTO `default_affiliate_product_email_log` VALUES ('125', '55', '1', 'sushilmishra@cdnsol.com', '2014-12-05 17:26:37');
INSERT INTO `default_affiliate_product_email_log` VALUES ('126', '55', '4', 'sushilmishra@cdnsol.com,', '2014-12-05 17:27:30');
INSERT INTO `default_affiliate_product_email_log` VALUES ('127', '55', '4', 'sushilmishra@cdnsol.com,', '2014-12-05 17:28:34');
INSERT INTO `default_affiliate_product_email_log` VALUES ('128', '55', '1', 'sushilmishra@cdnsol.com,', '2014-12-05 17:30:32');
INSERT INTO `default_affiliate_product_email_log` VALUES ('129', '55', '1', 'sushilmishra@cdnsol.com,', '2014-12-05 17:30:44');
INSERT INTO `default_affiliate_product_email_log` VALUES ('130', '55', '1', 'sushilmishra@cdnsol.com', '2014-12-05 17:30:58');
INSERT INTO `default_affiliate_product_email_log` VALUES ('131', '55', '1', 'tosifqureshi@cdnsol.com', '2014-12-05 17:35:30');
INSERT INTO `default_affiliate_product_email_log` VALUES ('132', '55', '2', 'amitwali1111@cdnsol.com', '2014-12-05 11:55:51');
INSERT INTO `default_affiliate_product_email_log` VALUES ('133', '55', '4', 'rajendrapatidar@cdnsol.com', '2014-12-05 12:03:05');
INSERT INTO `default_affiliate_product_email_log` VALUES ('134', '55', '4', 'rajendrapatidar@cdnsol.com', '2014-12-05 12:04:33');
INSERT INTO `default_affiliate_product_email_log` VALUES ('135', '55', '4', 'fdsadsa', '2014-12-05 12:05:15');
INSERT INTO `default_affiliate_product_email_log` VALUES ('136', '55', '4', 'viev@fdfd.com', '2014-12-05 12:19:01');
INSERT INTO `default_affiliate_product_email_log` VALUES ('137', '55', '3', 'rajendrapatidar@cdnsol.com,', '2014-12-05 12:25:54');
INSERT INTO `default_affiliate_product_email_log` VALUES ('138', '55', '4', 'admin@cdnsol.com', '2014-12-05 18:11:31');
INSERT INTO `default_affiliate_product_email_log` VALUES ('139', '55', '4', 'sar@cdnsol.com', '2014-12-05 12:32:14');
INSERT INTO `default_affiliate_product_email_log` VALUES ('140', '55', '4', 'etest@cdnsol.com', '2014-12-05 18:13:51');
INSERT INTO `default_affiliate_product_email_log` VALUES ('141', '55', '4', 'sushilmishra@cdnsol.com', '2014-12-05 12:37:54');
INSERT INTO `default_affiliate_product_email_log` VALUES ('142', '55', '4', 'test@cdnsol.com', '2014-12-05 18:20:20');
INSERT INTO `default_affiliate_product_email_log` VALUES ('143', '55', '4', 'sushilmishra@cdnsol.com', '2014-12-05 18:20:40');
INSERT INTO `default_affiliate_product_email_log` VALUES ('144', '55', '4', 'tester@cdnsol.com', '2014-12-05 18:26:00');
INSERT INTO `default_affiliate_product_email_log` VALUES ('145', '55', '4', 'sushilmishra@cdnsol.com', '2014-12-05 18:26:57');
INSERT INTO `default_affiliate_product_email_log` VALUES ('146', '55', '4', 'pat@cdnsol.com', '2014-12-05 13:05:10');
INSERT INTO `default_affiliate_product_email_log` VALUES ('147', '55', '4', 'rajendra@cdnsol.com,sushilmishra@cdnsol.com', '2014-12-05 13:30:55');
INSERT INTO `default_affiliate_product_email_log` VALUES ('148', '55', '3', 'rajendrapati@cdnsol.com,sushimishra@cdnsol.com', '2014-12-05 13:32:44');
INSERT INTO `default_affiliate_product_email_log` VALUES ('149', '147', '24', 'prashantgupta@cdnsol.com', '2014-12-05 13:38:20');
INSERT INTO `default_affiliate_product_email_log` VALUES ('150', '55', '4', 'prashantgupta@cdnsol.com', '2014-12-05 19:26:19');
INSERT INTO `default_affiliate_product_email_log` VALUES ('151', '55', '4', 'ravikhare@cdnsol.com', '2014-12-05 19:33:37');
INSERT INTO `default_affiliate_product_email_log` VALUES ('152', '55', '4', 'gdfsgdfg @gdfgh.co', '2014-12-05 19:34:00');
INSERT INTO `default_affiliate_product_email_log` VALUES ('153', '55', '4', 'prashantgupta@cdnsol.com,sunilpal@cdnsol.com,akankshagupta@cdnsol.com,', '2014-12-05 19:34:48');
INSERT INTO `default_affiliate_product_email_log` VALUES ('154', '55', '4', 'sunilpal@cdnsol.com,', '2014-12-05 19:35:21');
INSERT INTO `default_affiliate_product_email_log` VALUES ('155', '55', '4', 'aman@cdnsol.com,', '2014-12-05 19:36:54');
INSERT INTO `default_affiliate_product_email_log` VALUES ('156', '55', '2', 'prashantgupta@cdnsol.com,', '2014-12-05 19:37:17');
INSERT INTO `default_affiliate_product_email_log` VALUES ('157', '55', '2', 'prashantgupta@cdnsol.com', '2014-12-05 19:37:31');
INSERT INTO `default_affiliate_product_email_log` VALUES ('158', '55', '2', 'akankshagupta@cdnsolcom', '2014-12-05 19:37:53');
INSERT INTO `default_affiliate_product_email_log` VALUES ('159', '55', '3', 'patidarrajendra@cdnsol.com,', '2014-12-05 19:40:39');
INSERT INTO `default_affiliate_product_email_log` VALUES ('160', '55', '4', 'trilochanumath@cdnsol.com,piyushjain@cdnsol.com,', '2014-12-05 14:01:47');
INSERT INTO `default_affiliate_product_email_log` VALUES ('161', '55', '3', 'akankshagupta@cdnsol.com,', '2014-12-05 14:10:58');
INSERT INTO `default_affiliate_product_email_log` VALUES ('162', '149', '27', 'akankshagupta@cdnsol.com,prashantgupta@cdnsol.com', '2014-12-05 19:56:10');
INSERT INTO `default_affiliate_product_email_log` VALUES ('163', '147', '26', 'rjdfjdsfdsfdfdsfdsnjfjdjfjdsjfjdsfjhdjfdhsfdjshfjdshf', '2014-12-05 14:24:56');
INSERT INTO `default_affiliate_product_email_log` VALUES ('164', '147', '26', 'jh', '2014-12-05 14:27:54');
INSERT INTO `default_affiliate_product_email_log` VALUES ('165', '55', '4', 'rajendrapatidar@cdnsol.com,fff', '2014-12-06 06:31:11');
INSERT INTO `default_affiliate_product_email_log` VALUES ('166', '55', '4', 'rajendrapatidar@cdnsol.com', '2014-12-06 07:05:02');
INSERT INTO `default_affiliate_product_email_log` VALUES ('167', '55', '4', 'rajendrapatidar@cdnsol.com', '2014-12-06 07:05:28');
INSERT INTO `default_affiliate_product_email_log` VALUES ('168', '55', '4', 'rajendrapatidar@cdnsol.com,patidar@cdnsol.com', '2014-12-06 07:07:56');
INSERT INTO `default_affiliate_product_email_log` VALUES ('169', '55', '4', 'rajendrapatidar@cdnsol.com,patidar@cdnsol.com.dfdfd', '2014-12-06 07:11:01');
INSERT INTO `default_affiliate_product_email_log` VALUES ('170', '55', '4', 'rajendrspatidar@cdnsol.com.vxcvxcvx', '2014-12-06 07:24:07');
INSERT INTO `default_affiliate_product_email_log` VALUES ('171', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-12-06 07:40:51');
INSERT INTO `default_affiliate_product_email_log` VALUES ('172', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-12-06 09:56:43');
INSERT INTO `default_affiliate_product_email_log` VALUES ('173', '55', '4', 'rajendrapatidar@cdnsol.com,sushilmishra@cdnsol.com', '2014-12-06 10:00:14');
INSERT INTO `default_affiliate_product_email_log` VALUES ('174', '55', '4', 'sushilmishra@cdnsol.com,', '2014-12-06 10:00:59');
INSERT INTO `default_affiliate_product_email_log` VALUES ('175', '55', '4', 'sushilmishra@cdnsol.com,', '2014-12-06 10:01:34');
INSERT INTO `default_affiliate_product_email_log` VALUES ('176', '147', '26', 'rrarjjfhdsjfhsdfsd@dsfds.com,rdfdsfsd@fsdfds.com', '2014-12-06 10:02:13');
INSERT INTO `default_affiliate_product_email_log` VALUES ('177', '147', '26', 'rrarjjfhdsjfhsdfsd@dsfds.com,rdfdsfsd@fsdfds.com', '2014-12-06 10:02:56');
INSERT INTO `default_affiliate_product_email_log` VALUES ('178', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-12-06 10:03:48');
INSERT INTO `default_affiliate_product_email_log` VALUES ('179', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-12-06 10:04:40');
INSERT INTO `default_affiliate_product_email_log` VALUES ('180', '147', '26', 'rajendrapatidar@cdnsol.com', '2014-12-06 10:05:20');
INSERT INTO `default_affiliate_product_email_log` VALUES ('181', '147', '26', 'rajendrapatidar@cdnsol.com,', '2014-12-06 10:05:55');
INSERT INTO `default_affiliate_product_email_log` VALUES ('182', '147', '26', 'rajendrapatidar@cdnsol.com,', '2014-12-06 10:37:27');
INSERT INTO `default_affiliate_product_email_log` VALUES ('183', '55', '4', 'rajendrapatidar@cdnsol.com,', '2014-12-06 10:38:47');
INSERT INTO `default_affiliate_product_email_log` VALUES ('184', '147', '26', 'rajendrapatidar@cdnsol.com,', '2014-12-06 10:42:18');
INSERT INTO `default_affiliate_product_email_log` VALUES ('185', '55', '4', 'karen12181@hotmail.com', '2014-12-06 18:41:19');
INSERT INTO `default_affiliate_product_email_log` VALUES ('186', '55', '3', 'karen12181@hotmail.com,richardchau@onelinkup.com', '2014-12-06 18:49:18');
INSERT INTO `default_affiliate_product_email_log` VALUES ('187', '55', '3', 'rajendrapatidar@cdnsol.com,', '2014-12-11 10:29:07');
INSERT INTO `default_affiliate_product_email_log` VALUES ('188', '55', '3', 'rajendrapatidar@cdnsol.com,piyushjain@cdnsol.com,', '2014-12-11 10:30:02');
INSERT INTO `default_affiliate_product_email_log` VALUES ('189', '55', '3', 'richardchau@onelinkup.com,piyushjain@cdnsol.com,', '2014-12-11 10:31:13');
INSERT INTO `default_affiliate_product_email_log` VALUES ('190', '55', '3', 'patidar@cdnsol.com,rajendra@cdnsol.com,patidarrajendra@cdnsol.com,', '2014-12-11 10:32:31');
INSERT INTO `default_affiliate_product_email_log` VALUES ('191', '55', '3', 'rajendrapatidar@cdnsol.com,', '2014-12-11 10:49:16');
INSERT INTO `default_affiliate_product_email_log` VALUES ('192', '55', '3', 'rajendrapatidar@cdnsol.com,piyushjain@cdnsol.com,', '2014-12-11 10:49:44');
INSERT INTO `default_affiliate_product_email_log` VALUES ('193', '55', '3', 'rajendrapatidar@cdnsol.com,piyushjain@cdnsol.com,', '2014-12-11 10:49:49');
INSERT INTO `default_affiliate_product_email_log` VALUES ('194', '55', '5', 'rajendrapatidar@cdnsol.com,prashantgupta@cdnsol.com', '2014-12-11 10:55:38');
INSERT INTO `default_affiliate_product_email_log` VALUES ('195', '55', '3', 'rajendra@cdnsol.com,prashantgupta@cdnsol.com,', '2014-12-11 11:12:11');
INSERT INTO `default_affiliate_product_email_log` VALUES ('196', '55', '3', 'rajendrapatidar@cdnsol.com,', '2014-12-11 11:13:56');
INSERT INTO `default_affiliate_product_email_log` VALUES ('197', '55', '4', 'rajendra@cdnsol.com,prashantgupta@cdnsol.com,', '2014-12-11 11:31:40');
INSERT INTO `default_affiliate_product_email_log` VALUES ('198', '55', '4', 'rajendrapatidar@cdnsol.com,prashantgupta@cdnsol.com,', '2014-12-11 11:45:36');
INSERT INTO `default_affiliate_product_email_log` VALUES ('199', '55', '4', 'rajendrapatidar@cdnsol.com,prashantgupta@cdnsol.com,', '2014-12-11 17:27:05');
INSERT INTO `default_affiliate_product_email_log` VALUES ('200', '151', '31', 'prashantgupta@cdnsol.com', '2014-12-11 17:44:37');
INSERT INTO `default_affiliate_product_email_log` VALUES ('201', '151', '35', 'akankshagupta@cdnsol.com,prashantgupta@cdnsol.com', '2014-12-11 19:20:07');
INSERT INTO `default_affiliate_product_email_log` VALUES ('202', '151', '35', 'prashantgupta@cdnsol.com,akankshagupta@cdnsol.com,', '2014-12-11 19:21:31');
INSERT INTO `default_affiliate_product_email_log` VALUES ('203', '151', '35', 'akankshagupta@cdnsol.com,prashantgupta@cdnsol.com', '2014-12-11 19:22:16');
INSERT INTO `default_affiliate_product_email_log` VALUES ('204', '151', '35', 'akankshagupta@cdnsol.com,prashantgupta@cdnsol.com', '2014-12-11 19:22:27');
INSERT INTO `default_affiliate_product_email_log` VALUES ('205', '151', '35', 'akankshagupta@cdnsol.com,prashantgupta@cdnsol.com,', '2014-12-11 19:23:05');
INSERT INTO `default_affiliate_product_email_log` VALUES ('206', '151', '35', 'prashangupta@cdnsol.com', '2014-12-11 19:23:41');
INSERT INTO `default_affiliate_product_email_log` VALUES ('207', '55', '4', 'prashantgupta@cdnsol.com,rajendrapatidar@cdnsol.com,rajendrapatidar@cdnsol.com,', '2014-12-11 19:27:47');
INSERT INTO `default_affiliate_product_email_log` VALUES ('208', '151', '35', 'prashantgupta@cdnsol.com,rajendrapatidar@cdnsol.com', '2014-12-11 19:32:43');
INSERT INTO `default_affiliate_product_email_log` VALUES ('209', '151', '35', 'prashantgupta@cdnsol.com,patidar@cdnsol.com,rajendrapatidar@cdnsol.com,rajendrapatidar@cdnsol.com,', '2014-12-11 19:33:40');
INSERT INTO `default_affiliate_product_email_log` VALUES ('210', '151', '35', 'prashantgupta@cdnsol.com,rajendrapatidar@cdnsol.com,rajendrapatidar@cdnsol.com,', '2014-12-11 19:38:18');
INSERT INTO `default_affiliate_product_email_log` VALUES ('211', '151', '35', 'prashantgupta@cdnsol.com,', '2014-12-11 19:38:30');
INSERT INTO `default_affiliate_product_email_log` VALUES ('212', '151', '35', 'prashantgupta@cdnsol.com,rajendrapatidar@cdnsol.com,akankshagupta@cdnsol.com,', '2014-12-11 19:38:44');
INSERT INTO `default_affiliate_product_email_log` VALUES ('213', '151', '35', 'prashantgupta@cdnsol.com,prashantgupta@cdnsol.com,', '2014-12-11 19:39:04');
INSERT INTO `default_affiliate_product_email_log` VALUES ('214', '151', '35', 'prashantgupta@cdnsl.com', '2014-12-11 19:40:46');
INSERT INTO `default_affiliate_product_email_log` VALUES ('215', '151', '35', 'prashantgupta@cdnsl.com', '2014-12-11 19:41:03');
INSERT INTO `default_affiliate_product_email_log` VALUES ('216', '151', '35', 'pras@cdnsol.com', '2014-12-11 19:42:24');
INSERT INTO `default_affiliate_product_email_log` VALUES ('217', '147', '29', 'tester@cdnsol.com', '2014-12-11 14:03:31');
INSERT INTO `default_affiliate_product_email_log` VALUES ('218', '147', '29', 'tester@cdnsol.com', '2014-12-11 14:03:50');
INSERT INTO `default_affiliate_product_email_log` VALUES ('219', '147', '29', 'trilochanumath@cdnsol.com', '2014-12-11 14:05:14');
INSERT INTO `default_affiliate_product_email_log` VALUES ('220', '55', '4', 'sushilmishra@cdnsol.com', '2014-12-11 14:07:06');
INSERT INTO `default_affiliate_product_email_log` VALUES ('221', '147', '29', 'trilochanumath@cdnsol.com', '2014-12-11 14:07:52');
INSERT INTO `default_affiliate_product_email_log` VALUES ('222', '55', '4', 'tster@cdnsol.com', '2014-12-11 14:13:01');
INSERT INTO `default_affiliate_product_email_log` VALUES ('223', '55', '4', 'usere@cdnsol.com', '2014-12-11 14:13:44');
INSERT INTO `default_affiliate_product_email_log` VALUES ('224', '55', '4', 'patidadsare@cdnsom.cpm', '2014-12-11 14:14:05');
INSERT INTO `default_affiliate_product_email_log` VALUES ('225', '147', '29', 'gdfgdf@vdsfgds.com', '2014-12-11 14:14:21');
INSERT INTO `default_affiliate_product_email_log` VALUES ('226', '147', '29', 'fdsfds@dfsd.com', '2014-12-11 14:14:30');
INSERT INTO `default_affiliate_product_email_log` VALUES ('227', '55', '4', 'fsfdsdsfds@dsfsd.com', '2014-12-11 14:15:39');
INSERT INTO `default_affiliate_product_email_log` VALUES ('228', '147', '29', 'fdsfdsfd@vdsrfsd.com', '2014-12-11 14:18:36');
INSERT INTO `default_affiliate_product_email_log` VALUES ('229', '147', '29', 'dsfdhfsjhfds@fdfds.com', '2014-12-11 14:20:06');
INSERT INTO `default_affiliate_product_email_log` VALUES ('230', '147', '29', 'fdsfjdshfsdjhdfsjffds@dfsfd.com', '2014-12-11 14:20:15');
INSERT INTO `default_affiliate_product_email_log` VALUES ('231', '147', '29', 'testestrete@fess.com', '2014-12-11 14:20:56');
INSERT INTO `default_affiliate_product_email_log` VALUES ('232', '147', '29', 'teerewrwerew@fdsfds.com', '2014-12-12 05:45:05');
INSERT INTO `default_affiliate_product_email_log` VALUES ('233', '55', '4', 'sdjhfdsfjhsd@fdsfd.com', '2014-12-12 11:28:59');
INSERT INTO `default_affiliate_product_email_log` VALUES ('234', '153', '36', 'prashantgupta@cdnsl.com', '2014-12-12 12:49:51');
INSERT INTO `default_affiliate_product_email_log` VALUES ('235', '153', '36', 'prashantgupta@cdnsol.com', '2014-12-12 12:59:45');
INSERT INTO `default_affiliate_product_email_log` VALUES ('236', '153', '37', 'prashantgupta@cdnsol.com,rajendrapatidar@cdnsol.com', '2014-12-12 16:12:14');
INSERT INTO `default_affiliate_product_email_log` VALUES ('237', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-12-15 06:18:54');
INSERT INTO `default_affiliate_product_email_log` VALUES ('238', '55', '2', 'rajendrapatidar@cdnsol.com,', '2014-12-15 06:21:47');
INSERT INTO `default_affiliate_product_email_log` VALUES ('239', '55', '3', 'rajendrapatidar@cdnsol.com,sunilpal@cdnsol.com', '2014-12-15 06:39:03');
INSERT INTO `default_affiliate_product_email_log` VALUES ('240', '55', '3', 'rajendrapatidar@cdnsol.com,rajendra@cdnsol.com,', '2014-12-15 12:21:02');
INSERT INTO `default_affiliate_product_email_log` VALUES ('241', '55', '3', 'rajendrapatidar@cdnsol.com,sunilpal@cdnsol.com,', '2014-12-15 06:42:15');
INSERT INTO `default_affiliate_product_email_log` VALUES ('242', '55', '3', 'rajendrapatidar@cdnsol.com,sunilpal@cdnsol.com,', '2014-12-15 12:24:33');
INSERT INTO `default_affiliate_product_email_log` VALUES ('243', '55', '1', 'ANUBHA.CDN@GMAIL.COM', '2014-12-18 13:13:06');
INSERT INTO `default_affiliate_product_email_log` VALUES ('244', '55', '1', 'sales@syrecohk.com,', '2015-01-17 20:15:43');

-- ----------------------------
-- Table structure for `default_affiliate_testimonial`
-- ----------------------------
DROP TABLE IF EXISTS `default_affiliate_testimonial`;
CREATE TABLE `default_affiliate_testimonial` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `affiliate_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of default_affiliate_testimonial
-- ----------------------------

-- ----------------------------
-- Table structure for `default_api_keys`
-- ----------------------------
DROP TABLE IF EXISTS `default_api_keys`;
CREATE TABLE `default_api_keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of default_api_keys
-- ----------------------------

-- ----------------------------
-- Table structure for `default_api_logs`
-- ----------------------------
DROP TABLE IF EXISTS `default_api_logs`;
CREATE TABLE `default_api_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) NOT NULL,
  `method` varchar(6) NOT NULL,
  `params` text NOT NULL,
  `api_key` varchar(40) NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `time` int(11) NOT NULL,
  `authorized` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of default_api_logs
-- ----------------------------
INSERT INTO `default_api_logs` VALUES ('1', 'services/savePaymentInfo/K7MyNLUGAA==/0', 'get', 'a:1:{s:12:\"K7MyNLUGAA==\";s:1:\"0\";}', '', '127.0.0.1', '1411451575', '1');
INSERT INTO `default_api_logs` VALUES ('2', 'services/savePaymentInfo/K7MyNLUGAA==/0', 'get', 'a:1:{s:12:\"K7MyNLUGAA==\";s:1:\"0\";}', '', '127.0.0.1', '1411451648', '1');
INSERT INTO `default_api_logs` VALUES ('3', 'services/savePaymentInfo/K7MyNLUGAA==/0', 'get', 'a:1:{s:12:\"K7MyNLUGAA==\";s:1:\"0\";}', '', '127.0.0.1', '1411451649', '1');
INSERT INTO `default_api_logs` VALUES ('4', 'services/savePaymentInfo/K7MyNLUGAA==/0', 'get', 'a:1:{s:12:\"K7MyNLUGAA==\";s:1:\"0\";}', '', '127.0.0.1', '1411451649', '1');
INSERT INTO `default_api_logs` VALUES ('5', 'services/savePaymentInfo/K7MyNLUGAA==/0', 'get', 'a:1:{s:12:\"K7MyNLUGAA==\";s:1:\"0\";}', '', '127.0.0.1', '1411451671', '1');
INSERT INTO `default_api_logs` VALUES ('6', 'services/savePaymentInfo/K7MyNLUGAA==/0', 'get', 'a:1:{s:12:\"K7MyNLUGAA==\";s:1:\"0\";}', '', '127.0.0.1', '1411451706', '1');
INSERT INTO `default_api_logs` VALUES ('7', 'services/saveBannerClick/S7Mys1IyMlIwVTBWsgYA/S7OytFIydFBW8cpLs7dXsgYA', 'get', 'a:1:{s:20:\"S7Mys1IyMlIwVTBWsgYA\";s:24:\"S7OytFIydFBW8cpLs7dXsgYA\";}', '', '127.0.0.1', '1411451940', '1');
INSERT INTO `default_api_logs` VALUES ('8', 'services/saveBannerClick/S7Mys1IyMtIx1TFWsgYA/S7OytFIydFBW8cpLs7dXsgYA', 'get', 'a:1:{s:20:\"S7Mys1IyMtIx1TFWsgYA\";s:24:\"S7OytFIydFBW8cpLs7dXsgYA\";}', '', '127.0.0.1', '1411451991', '1');
INSERT INTO `default_api_logs` VALUES ('9', 'services/savePaymentInfo/K7MyNLMGAA==/1', 'get', 'a:1:{s:12:\"K7MyNLMGAA==\";s:1:\"1\";}', '', '127.0.0.1', '1411452014', '1');
INSERT INTO `default_api_logs` VALUES ('10', 'services/savePaymentInfo/K7MyNLMGAA==/1', 'get', 'a:1:{s:12:\"K7MyNLMGAA==\";s:1:\"1\";}', '', '127.0.0.1', '1411452102', '1');
INSERT INTO `default_api_logs` VALUES ('11', 'services/saveBannerClick/S7Myt1IyMdYx1TEzVLIGAA==%20method=', 'get', 'a:1:{s:34:\"S7Myt1IyMdYx1TEzVLIGAA==%20method=\";N;}', '', '127.0.0.1', '1413424029', '1');
INSERT INTO `default_api_logs` VALUES ('12', 'services/saveBannerClick/S7Myt1IyMdYx1TEzVLIGAA==%20method=', 'get', 'a:1:{s:34:\"S7Myt1IyMdYx1TEzVLIGAA==%20method=\";N;}', '', '127.0.0.1', '1413424034', '1');
INSERT INTO `default_api_logs` VALUES ('13', 'services/saveBannerClick/S7Myt1IyMdYx1TEzVLIGAA==%20method=', 'get', 'a:1:{s:34:\"S7Myt1IyMdYx1TEzVLIGAA==%20method=\";N;}', '', '127.0.0.1', '1413424053', '1');
INSERT INTO `default_api_logs` VALUES ('14', 'services/saveBannerClick/S7Myt1IyMdYx1TEzVLIGAA==%20method=', 'get', 'a:1:{s:34:\"S7Myt1IyMdYx1TEzVLIGAA==%20method=\";N;}', '', '127.0.0.1', '1413424332', '1');
INSERT INTO `default_api_logs` VALUES ('15', 'services/saveBannerClick/S7Myt1IyMdYx1TEzVLIGAA==%20method=', 'get', 'a:1:{s:34:\"S7Myt1IyMdYx1TEzVLIGAA==%20method=\";N;}', '', '127.0.0.1', '1413424343', '1');
INSERT INTO `default_api_logs` VALUES ('16', 'services/saveBannerClick/S7Myt1IyMdYx1TEzVLIGAA==%20method=', 'get', 'a:1:{s:34:\"S7Myt1IyMdYx1TEzVLIGAA==%20method=\";N;}', '', '127.0.0.1', '1413424453', '1');
INSERT INTO `default_api_logs` VALUES ('17', 'services/saveBannerClick/S7Myt1IyMdYx1TEzVLIGAA==%20method=', 'get', 'a:1:{s:34:\"S7Myt1IyMdYx1TEzVLIGAA==%20method=\";N;}', '', '127.0.0.1', '1413424727', '1');
INSERT INTO `default_api_logs` VALUES ('18', 'services/saveBannerClick/S7Myt1IyMdYx1TEzVLIGAA==%20method=', 'get', 'a:1:{s:34:\"S7Myt1IyMdYx1TEzVLIGAA==%20method=\";N;}', '', '127.0.0.1', '1413425083', '1');

-- ----------------------------
-- Table structure for `default_banner_click_log`
-- ----------------------------
DROP TABLE IF EXISTS `default_banner_click_log`;
CREATE TABLE `default_banner_click_log` (
  `banner_log_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_id` int(11) DEFAULT NULL,
  `merchant_id` int(11) DEFAULT NULL,
  `affiliate_id` int(11) DEFAULT NULL,
  `payment_status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`banner_log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of default_banner_click_log
-- ----------------------------
INSERT INTO `default_banner_click_log` VALUES ('1', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('2', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('3', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('4', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('5', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('6', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('7', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('8', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('9', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('10', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('11', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('12', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('13', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('14', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('15', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('16', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('17', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('18', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('19', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('20', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('21', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('22', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('25', '6', '123', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('26', '6', '123', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('27', '6', '123', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('28', '6', '123', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('31', '6', '123', '124', null);
INSERT INTO `default_banner_click_log` VALUES ('32', '8', '123', '124', null);
INSERT INTO `default_banner_click_log` VALUES ('35', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('39', '8', '123', '124', null);
INSERT INTO `default_banner_click_log` VALUES ('40', '8', '123', '124', null);
INSERT INTO `default_banner_click_log` VALUES ('41', '8', '123', '124', null);
INSERT INTO `default_banner_click_log` VALUES ('43', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('44', '9', '123', '124', null);
INSERT INTO `default_banner_click_log` VALUES ('45', '9', '123', '124', null);
INSERT INTO `default_banner_click_log` VALUES ('46', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('47', '10', '127', '126', null);
INSERT INTO `default_banner_click_log` VALUES ('48', '10', '127', '126', null);
INSERT INTO `default_banner_click_log` VALUES ('49', '10', '127', '126', null);
INSERT INTO `default_banner_click_log` VALUES ('50', '10', '127', '126', null);
INSERT INTO `default_banner_click_log` VALUES ('51', '10', '127', '126', null);
INSERT INTO `default_banner_click_log` VALUES ('52', '10', '127', '126', null);
INSERT INTO `default_banner_click_log` VALUES ('53', '10', '127', '126', null);
INSERT INTO `default_banner_click_log` VALUES ('54', '10', '127', '126', null);
INSERT INTO `default_banner_click_log` VALUES ('55', '10', '127', '126', null);
INSERT INTO `default_banner_click_log` VALUES ('56', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('57', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('58', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('59', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('60', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('61', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('62', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('63', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('64', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('65', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('66', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('67', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('68', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('69', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('70', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('71', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('72', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('73', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('74', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('75', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('76', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('77', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('78', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('79', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('80', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('81', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('82', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('83', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('84', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('85', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('86', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('87', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('88', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('89', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('90', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('91', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('92', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('93', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('94', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('95', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('96', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('97', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('98', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('99', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('100', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('101', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('102', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('103', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('104', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('105', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('106', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('107', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('108', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('109', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('110', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('111', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('112', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('113', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('114', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('115', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('116', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('117', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('118', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('119', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('120', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('121', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('122', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('123', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('124', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('125', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('126', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('127', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('128', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('129', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('130', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('131', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('132', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('133', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('134', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('135', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('136', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('137', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('138', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('139', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('140', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('141', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('142', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('143', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('144', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('145', '10', '127', '126', null);
INSERT INTO `default_banner_click_log` VALUES ('146', '11', '127', '126', null);
INSERT INTO `default_banner_click_log` VALUES ('147', '12', '127', '126', null);
INSERT INTO `default_banner_click_log` VALUES ('148', '13', '127', '126', null);
INSERT INTO `default_banner_click_log` VALUES ('149', '4', '5', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('150', '26', '146', '147', null);
INSERT INTO `default_banner_click_log` VALUES ('151', '26', '146', '147', null);
INSERT INTO `default_banner_click_log` VALUES ('152', '26', '146', '147', null);
INSERT INTO `default_banner_click_log` VALUES ('153', '24', '146', '147', null);
INSERT INTO `default_banner_click_log` VALUES ('155', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('156', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('157', '3', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('158', '3', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('159', '3', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('160', '3', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('161', '3', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('162', '3', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('163', '3', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('164', '31', '152', '151', null);
INSERT INTO `default_banner_click_log` VALUES ('165', '36', '154', '153', null);
INSERT INTO `default_banner_click_log` VALUES ('168', '37', '154', '153', null);
INSERT INTO `default_banner_click_log` VALUES ('169', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('170', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('171', '1', '56', '55', null);
INSERT INTO `default_banner_click_log` VALUES ('172', '1', '56', '55', null);

-- ----------------------------
-- Table structure for `default_banner_option`
-- ----------------------------
DROP TABLE IF EXISTS `default_banner_option`;
CREATE TABLE `default_banner_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_id` int(11) DEFAULT NULL,
  `customise_color` varchar(255) DEFAULT NULL,
  `customise_size` varchar(255) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of default_banner_option
-- ----------------------------
INSERT INTO `default_banner_option` VALUES ('9', '6', '30', null, '2014-11-26 11:59:00');
INSERT INTO `default_banner_option` VALUES ('14', '7', 'gfdgdfgdf', 'fsddsfd', '2014-11-26 06:29:59');
INSERT INTO `default_banner_option` VALUES ('25', '18', '20', 'Light Blue', '2014-12-05 13:41:53');
INSERT INTO `default_banner_option` VALUES ('29', '1', 'Large', 'iphone 5.1', '2014-12-12 10:13:47');

-- ----------------------------
-- Table structure for `default_banner_option_details`
-- ----------------------------
DROP TABLE IF EXISTS `default_banner_option_details`;
CREATE TABLE `default_banner_option_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_id` int(11) DEFAULT NULL,
  `option_type` int(11) DEFAULT '0',
  `option_name` varchar(255) DEFAULT NULL,
  `price` varchar(150) DEFAULT NULL,
  `currency_type` varchar(150) DEFAULT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of default_banner_option_details
-- ----------------------------
INSERT INTO `default_banner_option_details` VALUES ('25', '6', '0', '20', '20', 'PHP', '2014-11-26 11:00:59');
INSERT INTO `default_banner_option_details` VALUES ('34', '7', '0', 'gfdgdg', '454', 'USD', '2014-11-26 06:58:29');
INSERT INTO `default_banner_option_details` VALUES ('35', '7', '1', 'asasdsa', null, null, '2014-11-26 06:58:29');
INSERT INTO `default_banner_option_details` VALUES ('36', '7', '1', 'dsadas', null, null, '2014-11-26 06:58:29');
INSERT INTO `default_banner_option_details` VALUES ('75', '18', '0', 'New', '10', 'USD', '2014-12-05 13:53:41');
INSERT INTO `default_banner_option_details` VALUES ('76', '18', '1', 'Light Gray', null, null, '2014-12-05 13:53:41');
INSERT INTO `default_banner_option_details` VALUES ('89', '1', '0', 'iphone 5.1', '300', 'SEK', '2014-12-12 10:46:13');
INSERT INTO `default_banner_option_details` VALUES ('90', '1', '0', 'iphone 5', '250', 'SEK', '2014-12-12 10:46:13');
INSERT INTO `default_banner_option_details` VALUES ('91', '1', '1', 'White', null, null, '2014-12-12 10:46:13');
INSERT INTO `default_banner_option_details` VALUES ('92', '1', '1', 'Black', null, null, '2014-12-12 10:46:13');

-- ----------------------------
-- Table structure for `default_banner_payment_log`
-- ----------------------------
DROP TABLE IF EXISTS `default_banner_payment_log`;
CREATE TABLE `default_banner_payment_log` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_id` int(11) DEFAULT NULL,
  `merchant_id` int(11) DEFAULT NULL,
  `affiliate_id` int(11) DEFAULT NULL,
  `txn_id` varchar(255) DEFAULT NULL,
  `ack` varchar(255) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `total_txn_amt` varchar(150) DEFAULT NULL,
  `currency` varchar(150) DEFAULT NULL,
  `receiver_email` varchar(255) DEFAULT NULL,
  `sender_email` varchar(250) DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `payer_id` varchar(255) DEFAULT NULL,
  `token_id` varchar(255) DEFAULT NULL,
  `banner_color` varchar(150) DEFAULT NULL,
  `banner_size` varchar(150) DEFAULT NULL,
  `banner_price` varchar(150) DEFAULT NULL,
  `referral_commission` varchar(150) DEFAULT NULL,
  `banner_quantity` int(11) DEFAULT NULL,
  `pay_status` int(11) DEFAULT '0',
  `affiliate_payment_status` tinyint(4) DEFAULT '0',
  `error_code` varchar(255) DEFAULT NULL,
  `error_msg` varchar(255) DEFAULT NULL,
  `pay_key` varchar(250) DEFAULT NULL,
  `tracking_id` varchar(250) DEFAULT NULL,
  `order_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of default_banner_payment_log
-- ----------------------------
INSERT INTO `default_banner_payment_log` VALUES ('1', '1', '56', '55', '71E13549SW284402G', 'Success', '5', null, 'USD', 'support@cdnsol.com', null, 'cart', 'MXNVVZNRBLFTG', 'EC-0CT05695HU418915H', 'White', 'Select Sizeiphone 5.1', '295', '5', '1', '0', '1', null, null, null, null, '2014-11-24 17:02:38');
INSERT INTO `default_banner_payment_log` VALUES ('2', '1', '56', '55', '8PF39018R8026905T', 'Success', '295', null, 'USD', 'amitwali@cdnsol.com', null, 'cart', 'MXNVVZNRBLFTG', 'EC-0CT05695HU418915H', 'White', 'Select Sizeiphone 5.1', '295', '5', '1', '1', '1', null, null, null, null, '2014-11-24 17:02:38');
INSERT INTO `default_banner_payment_log` VALUES ('3', '4', '5', '55', '65V722879L896484A', 'Success', '10', null, 'USD', 'support@cdnsol.com', null, 'cart', 'MXNVVZNRBLFTG', 'EC-29G978278N3543113', '', '', '240', '10', '1', '0', '0', null, null, null, null, '2014-11-21 15:23:57');
INSERT INTO `default_banner_payment_log` VALUES ('4', '4', '5', '55', '60K59701K78503354', 'Success', '240', null, 'USD', 'amitwali@cdnsol.com', null, 'cart', 'MXNVVZNRBLFTG', 'EC-29G978278N3543113', '', '', '240', '10', '1', '1', '0', null, null, null, null, '2014-11-21 15:23:57');
INSERT INTO `default_banner_payment_log` VALUES ('5', '4', '5', '55', '95T2684841116794A', 'Success', '10', null, 'USD', 'support@cdnsol.com', null, 'cart', 'MXNVVZNRBLFTG', 'EC-4NH21786AV6107724', '', '', '240', '10', '1', '0', '0', null, null, null, null, '2014-11-24 11:06:44');
INSERT INTO `default_banner_payment_log` VALUES ('6', '4', '5', '55', '95079212LK4832749', 'Success', '240', null, 'USD', 'amitwali@cdnsol.com', null, 'cart', 'MXNVVZNRBLFTG', 'EC-4NH21786AV6107724', '', '', '240', '10', '1', '1', '0', null, null, null, null, '2014-11-24 11:07:44');
INSERT INTO `default_banner_payment_log` VALUES ('11', '6', '123', '55', '4Y147782H3047662L', 'Success', '3', null, 'PHP', 'mahendrayadav@cdnsol.com', null, 'cart', 'MXNVVZNRBLFTG', 'EC-3GJ33069HJ9083932', '', '', '97.5', '2.5', '1', '0', '0', null, null, null, null, '2014-11-25 13:42:11');
INSERT INTO `default_banner_payment_log` VALUES ('12', '6', '123', '55', '3BK10119M13157258', 'Success', '98', null, 'PHP', 'amitwali@cdnsol.com', null, 'cart', 'MXNVVZNRBLFTG', 'EC-3GJ33069HJ9083932', '', '', '97.5', '2.5', '1', '1', '0', null, null, null, null, '2014-11-25 13:42:11');
INSERT INTO `default_banner_payment_log` VALUES ('13', '6', '123', '124', '7CM59545DJ388762N', 'Success', '3', null, 'PHP', 'mahendrayadav@cdnsol.com', null, 'cart', 'MXNVVZNRBLFTG', 'EC-3PY53917FW4519421', '', '20', '97.5', '2.5', '1', '0', '0', null, null, null, null, '2014-11-26 11:21:45');
INSERT INTO `default_banner_payment_log` VALUES ('14', '6', '123', '124', '1MR880029G843645F', 'Success', '98', null, 'PHP', 'amitwali@cdnsol.com', null, 'cart', 'MXNVVZNRBLFTG', 'EC-3PY53917FW4519421', '', '20', '97.5', '2.5', '1', '1', '0', null, null, null, null, '2014-11-26 11:21:45');
INSERT INTO `default_banner_payment_log` VALUES ('15', '8', '123', '124', '3B276752WT0214203', 'Success', '25', null, 'PLN', 'mahendrayadav@cdnsol.com', null, 'cart', 'MXNVVZNRBLFTG', 'EC-4G0266972D565591E', '', '', '9.5', '2.5', '10', '0', '0', null, null, null, null, '2014-11-26 12:52:07');
INSERT INTO `default_banner_payment_log` VALUES ('16', '8', '123', '124', '16K56840JH018512L', 'Success', '95', null, 'PLN', 'amitwali@cdnsol.com', null, 'cart', 'MXNVVZNRBLFTG', 'EC-4G0266972D565591E', '', '', '9.5', '2.5', '10', '1', '0', null, null, null, null, '2014-11-26 12:53:07');
INSERT INTO `default_banner_payment_log` VALUES ('26', '8', '123', '124', '13F56911230161108', 'Success', '25', null, 'PLN', 'mahendrayadav@cdnsol.com', null, 'cart', 'MXNVVZNRBLFTG', 'EC-6ML10178GH784842K', '', '', '9.5', '2.5', '10', '0', '0', null, null, null, null, '2014-11-26 12:46:50');
INSERT INTO `default_banner_payment_log` VALUES ('27', '8', '123', '124', '8YN95051FB0592913', 'Success', '95', null, 'PLN', 'amitwali@cdnsol.com', null, 'cart', 'MXNVVZNRBLFTG', 'EC-6ML10178GH784842K', '', '', '9.5', '2.5', '10', '1', '0', null, null, null, null, '2014-11-26 12:46:50');
INSERT INTO `default_banner_payment_log` VALUES ('28', '9', '123', '124', '87L69895BK726894D', 'Success', '50', null, 'CAD', 'mahendrayadav@cdnsol.com', null, 'cart', 'MXNVVZNRBLFTG', 'EC-6NE72603UR597030H', '', '', '5', '5', '10', '0', '0', null, null, null, null, '2014-11-28 15:09:23');
INSERT INTO `default_banner_payment_log` VALUES ('29', '9', '123', '124', '28T52434HV961673J', 'Success', '50', null, 'CAD', 'amitwali@cdnsol.com', null, 'cart', 'MXNVVZNRBLFTG', 'EC-6NE72603UR597030H', '', '', '5', '5', '10', '1', '0', null, null, null, null, '2014-11-28 15:10:23');
INSERT INTO `default_banner_payment_log` VALUES ('30', '9', '123', '124', '5NC013762L729850X', 'Success', '50', null, 'CAD', 'mahendrayadav@cdnsol.com', null, 'cart', 'MXNVVZNRBLFTG', 'EC-9YW43292MY912922B', '', '', '5', '5', '10', '0', '0', null, null, null, null, '2014-11-28 15:56:37');
INSERT INTO `default_banner_payment_log` VALUES ('31', '9', '123', '124', '6G356108SN454031J', 'Success', '50', null, 'CAD', 'amitwali@cdnsol.com', null, 'cart', 'MXNVVZNRBLFTG', 'EC-9YW43292MY912922B', '', '', '5', '5', '10', '1', '0', null, null, null, null, '2014-11-28 15:56:37');
INSERT INTO `default_banner_payment_log` VALUES ('32', '10', '127', '126', null, 'PartialSuccess', null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '0', null, null, null, null, '2014-12-02 13:19:04');
INSERT INTO `default_banner_payment_log` VALUES ('33', '10', '127', '126', null, 'PartialSuccess', null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '0', null, null, null, null, '2014-12-02 13:20:27');
INSERT INTO `default_banner_payment_log` VALUES ('34', '10', '127', '126', null, 'PartialSuccess', null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '0', null, null, null, null, '2014-12-02 15:35:49');
INSERT INTO `default_banner_payment_log` VALUES ('35', '10', '127', '126', null, 'PartialSuccess', null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '0', null, null, null, null, '2014-12-02 15:44:16');
INSERT INTO `default_banner_payment_log` VALUES ('36', '10', '127', '126', '5MN09029WE468143E', 'Success', '5', null, 'AUD', 'mahendrayadav@cdnsol.com', null, 'cart', '8LW8QPN7HCHXE', 'EC-1U280171GS069705P', '', '', '15', '5', '1', '0', '0', null, null, null, null, '2014-12-02 15:19:48');
INSERT INTO `default_banner_payment_log` VALUES ('37', '10', '127', '126', '3L679342LJ393424V', 'Success', '15', null, 'AUD', 'rajendrapatidar@cdnsol.com', null, 'cart', '8LW8QPN7HCHXE', 'EC-1U280171GS069705P', '', '', '15', '5', '1', '1', '0', null, null, null, null, '2014-12-02 15:19:48');
INSERT INTO `default_banner_payment_log` VALUES ('58', '1', '56', '55', '0G208188WV4394827', 'Success', '10', '600.00', 'USD', 'mahendrayadav@cdnsol.com', 'rajendrapatidar@cdnsol.com', null, null, null, 'White', 'Select Sizeiphone 5.1', '295', '5', '2', '0', '0', null, null, 'AP-4SR99721L8155603V', '1626455604', '2014-12-03 15:49:26');
INSERT INTO `default_banner_payment_log` VALUES ('59', '1', '56', '55', '0G208188WV4394827', 'Success', '590', '600.00', 'USD', 'amitwali@cdnsol.com', 'rajendrapatidar@cdnsol.com', null, null, null, 'White', 'Select Sizeiphone 5.1', '295', '5', '2', '1', '0', null, null, 'AP-4SR99721L8155603V', '1626455604', '2014-12-03 15:49:26');
INSERT INTO `default_banner_payment_log` VALUES ('60', '1', '56', '55', '5EK084601P4073725', 'Success', '5', '300.00', 'USD', 'mahendrayadav@cdnsol.com', 'rajendrapatidar@cdnsol.com', null, null, null, 'Black', 'iphone 5', '295', '5', '1', '0', '0', null, null, 'AP-6J802728AF7203821', '354172088', '2014-12-03 15:08:34');
INSERT INTO `default_banner_payment_log` VALUES ('61', '1', '56', '55', '5EK084601P4073725', 'Success', '295', '300.00', 'USD', 'amitwali@cdnsol.com', 'rajendrapatidar@cdnsol.com', null, null, null, 'Black', 'iphone 5', '295', '5', '1', '1', '0', null, null, 'AP-6J802728AF7203821', '354172088', '2014-12-03 15:08:34');
INSERT INTO `default_banner_payment_log` VALUES ('62', '4', '5', '55', '3P195830UC8879606', 'Success', '10', '250.00', 'USD', 'mahendrayadav@cdnsol.com', 'rajendrapatidar@cdnsol.com', null, null, null, '', '', '240', '10', '1', '0', '0', null, null, 'AP-6MD20853SH2873421', '1208648798', '2014-12-03 10:00:15');
INSERT INTO `default_banner_payment_log` VALUES ('63', '4', '5', '55', '3P195830UC8879606', 'Success', '240', '250.00', 'USD', 'patidar@cdnsol.com', 'rajendrapatidar@cdnsol.com', null, null, null, '', '', '240', '10', '1', '1', '0', null, null, 'AP-6MD20853SH2873421', '1208648798', '2014-12-03 10:00:15');
INSERT INTO `default_banner_payment_log` VALUES ('64', '4', '5', '55', '33D2273123620903E', 'Success', '10', '250.00', 'USD', 'mahendrayadav@cdnsol.com', 'rajendrapatidar@cdnsol.com', null, null, null, '', '', '240', '10', '1', '0', '0', null, null, 'AP-3V938234A7598910W', '621416577', '2014-12-03 12:02:35');
INSERT INTO `default_banner_payment_log` VALUES ('65', '4', '5', '55', '33D2273123620903E', 'Success', '240', '250.00', 'USD', 'patidar@cdnsol.com', 'rajendrapatidar@cdnsol.com', null, null, null, '', '', '240', '10', '1', '1', '0', null, null, 'AP-3V938234A7598910W', '621416577', '2014-12-03 12:02:35');
INSERT INTO `default_banner_payment_log` VALUES ('66', '1', '56', '55', '1KP57011RT363115H', 'Success', '5', '300.00', 'SEK', 'tester@cdnsol.com', 'rajendrapatidar@cdnsol.com', null, null, null, '', '', '295', '5', '1', '0', '0', null, null, 'AP-3YB65690D9791881S', '1120787194', '2014-12-03 19:22:30');
INSERT INTO `default_banner_payment_log` VALUES ('67', '1', '56', '55', '1KP57011RT363115H', 'Success', '295', '300.00', 'SEK', 'patidar@cdnsol.com', 'rajendrapatidar@cdnsol.com', null, null, null, '', '', '295', '5', '1', '1', '0', null, null, 'AP-3YB65690D9791881S', '1120787194', '2014-12-03 19:22:30');
INSERT INTO `default_banner_payment_log` VALUES ('68', '10', '127', '126', '5F251291AH844881C', 'Success', '5', '20.00', 'AUD', 'tester@cdnsol.com', 'patidar@cdnsol.com', null, null, null, '', '', '15', '5', '1', '0', '0', null, null, 'AP-112433058R297712C', '2025470133', '2014-12-04 13:16:33');
INSERT INTO `default_banner_payment_log` VALUES ('69', '10', '127', '126', '5F251291AH844881C', 'Success', '15', '20.00', 'AUD', 'rajendrapatidar@cdnsol.com', 'patidar@cdnsol.com', null, null, null, '', '', '15', '5', '1', '1', '0', null, null, 'AP-112433058R297712C', '2025470133', '2014-12-04 13:16:33');
INSERT INTO `default_banner_payment_log` VALUES ('70', '11', '127', '126', '8BD17359MP9121046', 'Success', '3', '10.00', 'USD', 'tester@cdnsol.com', 'buyer_1348040918_per@cdnsol.com', null, null, null, '', '', '7.5', '2.5', '1', '0', '0', null, null, 'AP-61R46751MX382115A', '807405481', '2014-12-04 15:46:01');
INSERT INTO `default_banner_payment_log` VALUES ('71', '11', '127', '126', '8BD17359MP9121046', 'Success', '8', '10.00', 'USD', 'rajendrapatidar@cdnsol.com', 'buyer_1348040918_per@cdnsol.com', null, null, null, '', '', '7.5', '2.5', '1', '1', '0', null, null, 'AP-61R46751MX382115A', '807405481', '2014-12-04 15:46:01');
INSERT INTO `default_banner_payment_log` VALUES ('72', '13', '127', '126', '19D22918MS913481E', 'Success', '8', '150.00', 'AUD', 'tester@cdnsol.com', 'buyer_1348040918_per@cdnsol.com', null, null, null, '', '', '142.5', '7.5', '1', '0', '0', null, null, 'AP-4HM39090GX712401D', '1627629209', '2014-12-04 15:54:23');
INSERT INTO `default_banner_payment_log` VALUES ('73', '13', '127', '126', '19D22918MS913481E', 'Success', '143', '150.00', 'AUD', 'rajendrapatidar@cdnsol.com', 'buyer_1348040918_per@cdnsol.com', null, null, null, '', '', '142.5', '7.5', '1', '1', '0', null, null, 'AP-4HM39090GX712401D', '1627629209', '2014-12-04 15:54:23');
INSERT INTO `default_banner_payment_log` VALUES ('74', '26', '146', '147', '7NB68058VB922783L', 'Success', '8', '150.00', 'AUD', 'tester@cdnsol.com', 'buyer_1348040918_per@cdnsol.com', null, null, null, '', '', '142.5', '7.5', '1', '0', '0', null, null, 'AP-1MX30167NG805383S', '606573727', '2014-12-05 12:54:22');
INSERT INTO `default_banner_payment_log` VALUES ('75', '26', '146', '147', '7NB68058VB922783L', 'Success', '143', '150.00', 'AUD', 'rajendrapatidar@cdnsol.com', 'buyer_1348040918_per@cdnsol.com', null, null, null, '', '', '142.5', '7.5', '1', '1', '0', null, null, 'AP-1MX30167NG805383S', '606573727', '2014-12-05 12:54:22');
INSERT INTO `default_banner_payment_log` VALUES ('76', '24', '146', '147', '31T576247R001020D', 'Success', '25', '100.00', 'USD', 'tester@cdnsol.com', 'buyer_1348040918_per@cdnsol.com', null, null, null, '', '', '7.5', '2.5', '10', '0', '0', null, null, 'AP-42H30420TF5995421', '308594792', '2014-12-05 12:27:31');
INSERT INTO `default_banner_payment_log` VALUES ('77', '24', '146', '147', '31T576247R001020D', 'Success', '75', '100.00', 'USD', 'rajendrapatidar@cdnsol.com', 'buyer_1348040918_per@cdnsol.com', null, null, null, '', '', '7.5', '2.5', '10', '1', '0', null, null, 'AP-42H30420TF5995421', '308594792', '2014-12-05 12:27:31');
INSERT INTO `default_banner_payment_log` VALUES ('78', '24', '146', '147', '31T576247R001020D', 'Success', '25', '100.00', 'USD', 'tester@cdnsol.com', 'buyer_1348040918_per@cdnsol.com', null, null, null, '', '', '7.5', '2.5', '10', '0', '0', null, null, 'AP-42H30420TF5995421', '308594792', '2014-12-05 12:36:31');
INSERT INTO `default_banner_payment_log` VALUES ('79', '24', '146', '147', '31T576247R001020D', 'Success', '75', '100.00', 'USD', 'rajendrapatidar@cdnsol.com', 'buyer_1348040918_per@cdnsol.com', null, null, null, '', '', '7.5', '2.5', '10', '1', '0', null, null, 'AP-42H30420TF5995421', '308594792', '2014-12-05 12:36:31');
INSERT INTO `default_banner_payment_log` VALUES ('82', '36', '154', '153', '3VC47777YD740990B', 'Success', '25', '230.00', 'PHP', 'tester@cdnsol.com', 'buyer_1348040918_per@cdnsol.com', null, null, null, '', '', '20.5', '2.5', '10', '0', '0', null, null, 'AP-9PD94345C8074721P', '1621935380', '2014-12-12 13:19:01');
INSERT INTO `default_banner_payment_log` VALUES ('83', '36', '154', '153', '3VC47777YD740990B', 'Success', '205', '230.00', 'PHP', 'rajendrapatidar@cdnsol.com', 'buyer_1348040918_per@cdnsol.com', null, null, null, '', '', '20.5', '2.5', '10', '1', '0', null, null, 'AP-9PD94345C8074721P', '1621935380', '2014-12-12 13:19:01');
INSERT INTO `default_banner_payment_log` VALUES ('84', '37', '154', '153', '38L402418P3177024', 'Success', '125', '1000.00', 'USD', 'tester@cdnsol.com', 'buyer_1348040918_per@cdnsol.com', null, null, null, '', '', '17.5', '2.5', '50', '0', '0', null, null, 'AP-7AR30437XR762914A', '827680717', '2014-12-12 16:05:14');
INSERT INTO `default_banner_payment_log` VALUES ('85', '37', '154', '153', '38L402418P3177024', 'Success', '875', '1000.00', 'USD', 'rajendrapatidar@cdnsol.com', 'buyer_1348040918_per@cdnsol.com', null, null, null, '', '', '17.5', '2.5', '50', '1', '0', null, null, 'AP-7AR30437XR762914A', '827680717', '2014-12-12 16:05:14');

-- ----------------------------
-- Table structure for `default_banner_share_log`
-- ----------------------------
DROP TABLE IF EXISTS `default_banner_share_log`;
CREATE TABLE `default_banner_share_log` (
  `share_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_id` int(11) DEFAULT NULL,
  `merchant_id` int(11) DEFAULT NULL,
  `affiliate_id` int(11) DEFAULT NULL,
  `share_status` int(1) DEFAULT '3',
  `share_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`share_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of default_banner_share_log
-- ----------------------------
INSERT INTO `default_banner_share_log` VALUES ('1', '1', '56', '55', '1', '2014-11-21 12:09:40');
INSERT INTO `default_banner_share_log` VALUES ('2', '1', '56', '55', '1', '2014-11-21 12:25:40');
INSERT INTO `default_banner_share_log` VALUES ('3', '1', '56', '55', '1', '2014-11-21 12:08:41');
INSERT INTO `default_banner_share_log` VALUES ('4', '1', '56', '55', '3', '2014-11-21 12:09:42');
INSERT INTO `default_banner_share_log` VALUES ('5', '4', '5', '55', '3', '2014-11-21 16:51:58');
INSERT INTO `default_banner_share_log` VALUES ('6', '1', '56', '55', '3', '2014-12-01 12:30:05');
INSERT INTO `default_banner_share_log` VALUES ('7', '1', '56', '55', '3', '2014-12-03 15:51:31');
INSERT INTO `default_banner_share_log` VALUES ('8', '3', '56', '55', '2', '2014-12-06 18:24:50');
INSERT INTO `default_banner_share_log` VALUES ('9', '2', '56', '55', '4', '2014-12-15 06:47:21');
INSERT INTO `default_banner_share_log` VALUES ('10', '3', '56', '55', '4', '2014-12-15 06:03:39');
INSERT INTO `default_banner_share_log` VALUES ('11', '3', '56', '55', '4', '2014-12-15 06:03:39');
INSERT INTO `default_banner_share_log` VALUES ('12', '3', '56', '55', '4', '2014-12-15 12:03:21');
INSERT INTO `default_banner_share_log` VALUES ('13', '3', '56', '55', '4', '2014-12-15 12:03:21');
INSERT INTO `default_banner_share_log` VALUES ('14', '3', '56', '55', '4', '2014-12-15 12:03:21');
INSERT INTO `default_banner_share_log` VALUES ('15', '3', '56', '55', '4', '2014-12-15 06:15:42');
INSERT INTO `default_banner_share_log` VALUES ('16', '3', '56', '55', '4', '2014-12-15 06:15:42');
INSERT INTO `default_banner_share_log` VALUES ('17', '3', '56', '55', '4', '2014-12-15 12:33:24');
INSERT INTO `default_banner_share_log` VALUES ('18', '3', '56', '55', '4', '2014-12-15 12:34:24');
INSERT INTO `default_banner_share_log` VALUES ('19', '1', '56', '55', '4', '2014-12-18 13:06:13');
INSERT INTO `default_banner_share_log` VALUES ('20', '1', '56', '55', '3', '2015-01-17 20:50:03');
INSERT INTO `default_banner_share_log` VALUES ('21', '1', '56', '55', '3', '2015-01-17 20:59:03');
INSERT INTO `default_banner_share_log` VALUES ('22', '1', '56', '55', '4', '2015-01-17 20:43:15');

-- ----------------------------
-- Table structure for `default_blocks`
-- ----------------------------
DROP TABLE IF EXISTS `default_blocks`;
CREATE TABLE `default_blocks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_created` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `date_modified` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of default_blocks
-- ----------------------------

-- ----------------------------
-- Table structure for `default_blog`
-- ----------------------------
DROP TABLE IF EXISTS `default_blog`;
CREATE TABLE `default_blog` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `ordering_count` int(11) DEFAULT NULL,
  `intro` longtext COLLATE utf8_unicode_ci,
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `parsed` text COLLATE utf8_unicode_ci NOT NULL,
  `keywords` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `author_id` int(11) NOT NULL DEFAULT '0',
  `created_on` int(11) NOT NULL,
  `updated_on` int(11) NOT NULL DEFAULT '0',
  `comments_enabled` enum('no','1 day','1 week','2 weeks','1 month','3 months','always') COLLATE utf8_unicode_ci NOT NULL DEFAULT '3 months',
  `status` enum('draft','live') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'draft',
  `type` set('html','markdown','wysiwyg-advanced','wysiwyg-simple') COLLATE utf8_unicode_ci NOT NULL,
  `preview_hash` char(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_blog
-- ----------------------------

-- ----------------------------
-- Table structure for `default_blog_categories`
-- ----------------------------
DROP TABLE IF EXISTS `default_blog_categories`;
CREATE TABLE `default_blog_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_slug` (`slug`),
  UNIQUE KEY `unique_title` (`title`),
  KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_blog_categories
-- ----------------------------

-- ----------------------------
-- Table structure for `default_ci_sessions`
-- ----------------------------
DROP TABLE IF EXISTS `default_ci_sessions`;
CREATE TABLE `default_ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `user_agent` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_ci_sessions
-- ----------------------------
INSERT INTO `default_ci_sessions` VALUES ('d3785369d6cdd295aa03181cccb4e77b', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1406896831', 'a:6:{s:8:\"username\";s:5:\"admin\";s:5:\"email\";s:23:\"sushilmishra@cdnsol.com\";s:2:\"id\";s:1:\"1\";s:7:\"user_id\";s:1:\"1\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('b8f8f12b2689778539e142a2f01e8517', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1407229098', 'a:6:{s:8:\"username\";s:5:\"admin\";s:5:\"email\";s:23:\"sushilmishra@cdnsol.com\";s:2:\"id\";s:1:\"1\";s:7:\"user_id\";s:1:\"1\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('46aff11a145d93785b66620650936814', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1407411783', '');
INSERT INTO `default_ci_sessions` VALUES ('2fe6ce26c741fd4c1a8b31cc24ecb9a6', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1409218685', 'a:6:{s:8:\"username\";s:5:\"admin\";s:5:\"email\";s:23:\"sushilmishra@cdnsol.com\";s:2:\"id\";s:1:\"1\";s:7:\"user_id\";s:1:\"1\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('507a60f711817000cafa51cedd80deb3', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1409385722', 'a:6:{s:8:\"username\";s:5:\"admin\";s:5:\"email\";s:23:\"sushilmishra@cdnsol.com\";s:2:\"id\";s:1:\"1\";s:7:\"user_id\";s:1:\"1\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('76246a610a29cba8070cdd9fb7660459', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1409389524', '');
INSERT INTO `default_ci_sessions` VALUES ('240cfe3afbc290b4a9ba3df1384f950a', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1409389558', '');
INSERT INTO `default_ci_sessions` VALUES ('ebfb02702df1806082ca64c75b00cc47', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1409390142', '');
INSERT INTO `default_ci_sessions` VALUES ('305df4ee8d3ff73bee7e2b92314aff80', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1409808269', '');
INSERT INTO `default_ci_sessions` VALUES ('2f55a6d68a3eddafaa815590baccd3e1', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1409549875', '');
INSERT INTO `default_ci_sessions` VALUES ('6df11205a3477307c7b6095e86cfa3c9', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1409549964', '');
INSERT INTO `default_ci_sessions` VALUES ('44e0563dba3bc96f049e5269a8bc71d4', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1409581655', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:1:\"1\";s:7:\"user_id\";s:1:\"1\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('b5e4737cc2884bf811c79b58d5938745', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1409637631', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:1:\"1\";s:7:\"user_id\";s:1:\"1\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('1b7d0501b5e85ef2955a0574d14fa393', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1409650175', 'a:1:{s:11:\"redirect_to\";s:5:\"users\";}');
INSERT INTO `default_ci_sessions` VALUES ('0292ee9797030266331677be234ab32c', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1409668318', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:1:\"1\";s:7:\"user_id\";s:1:\"1\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('dc2e7cf40559c129a575c7b5d2799a2d', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1409730782', 'a:7:{s:8:\"cap_word\";s:8:\"T6zH9icH\";s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:1:\"1\";s:7:\"user_id\";s:1:\"1\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('05f86598f431e9ae52092aac1e59b0a1', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1409730802', '');
INSERT INTO `default_ci_sessions` VALUES ('19703961d752645010dffb81f2c3f83c', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1409753500', 'a:1:{s:8:\"cap_word\";s:8:\"5liRpMX1\";}');
INSERT INTO `default_ci_sessions` VALUES ('d0ec0739d44993b33ac2dda1aaea6089', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1409731514', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:1:\"1\";s:7:\"user_id\";s:1:\"1\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('e9ed8c4de1e89390bebe0a31b8a3308d', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1409731514', '');
INSERT INTO `default_ci_sessions` VALUES ('bea45fefcf92868217192ec4ffec806b', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1409754990', 'a:7:{s:8:\"cap_word\";s:8:\"S21waxox\";s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:1:\"1\";s:7:\"user_id\";s:1:\"1\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('50939c217cf14ee97b0dcb577d3b00b2', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1409840061', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:1:\"1\";s:7:\"user_id\";s:1:\"1\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('cdfffe467bc5cfe2acaaf4e130c990da', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1409833826', 'a:1:{s:8:\"cap_word\";s:8:\"pWx0EmRP\";}');
INSERT INTO `default_ci_sessions` VALUES ('8b93f8710776473fedda8e3749e36416', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1409900083', '');
INSERT INTO `default_ci_sessions` VALUES ('7894e0056539141ffc667a59c5c11272', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1409915048', '');
INSERT INTO `default_ci_sessions` VALUES ('bc9992e2e50a6739ae4429f14bac802c', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1409926873', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:1:\"1\";s:7:\"user_id\";s:1:\"1\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('64abda881df021be744f8153930cab62', '192.168.0.74', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1409907391', '');
INSERT INTO `default_ci_sessions` VALUES ('ae96d028c294b08a96e043ac3a4bca2b', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1409966147', '');
INSERT INTO `default_ci_sessions` VALUES ('bb694b0cb10ac2ac629bec812192e68a', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1409994761', 'a:1:{s:8:\"cap_word\";s:8:\"vaFhPrrt\";}');
INSERT INTO `default_ci_sessions` VALUES ('4e3c5cc3a219366befa03664f76bc50b', '192.168.0.74', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1409974478', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:1:\"1\";s:7:\"user_id\";s:1:\"1\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('02898cc76448016c52d25732867d34fc', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1409990607', 'a:1:{s:17:\"flash:old:success\";s:25:\"You have been logged out.\";}');
INSERT INTO `default_ci_sessions` VALUES ('e8a98a91702ae63975914e9cc563723c', '192.168.0.74', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410135632', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:17:\"tester@tester.com\";s:2:\"id\";s:1:\"2\";s:7:\"user_id\";s:1:\"2\";s:8:\"group_id\";s:1:\"3\";s:5:\"group\";N;}');
INSERT INTO `default_ci_sessions` VALUES ('6986571d96eee28bf77e9c3961555424', '192.168.0.74', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410143701', '');
INSERT INTO `default_ci_sessions` VALUES ('3b4a5f6c00fa88cc94e3796860e9161b', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410185021', 'a:7:{s:8:\"cap_word\";s:5:\"qnAbQ\";s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:1:\"1\";s:7:\"user_id\";s:1:\"1\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('3da7c611cc1076c6d12542c386f955e4', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1410171304', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:1:\"1\";s:7:\"user_id\";s:1:\"1\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('93d539194cbf6f70512749fca2c0e240', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1410185600', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:1:\"1\";s:7:\"user_id\";s:1:\"1\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('706c6380bf2b416067fff35a3eb78a5b', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410185364', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:1:\"1\";s:7:\"user_id\";s:1:\"1\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('80d2482aaa2b9e7b3a6240e7e7580708', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410263790', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:1:\"1\";s:7:\"user_id\";s:1:\"1\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('e89045cf0a2779f1745ecd366406ce4d', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1410263868', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:1:\"1\";s:7:\"user_id\";s:1:\"1\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('64fa5bb5ae92fe66e83edca125fa8649', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410271154', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:1:\"1\";s:7:\"user_id\";s:1:\"1\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('da46d7a1b44ac7c7a036d3f418adfdb7', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410358828', 'a:7:{s:8:\"cap_word\";s:5:\"MZgJr\";s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:1:\"1\";s:7:\"user_id\";s:1:\"1\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('4726022e3eb8fa5fba19c03041aa9ddf', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410435172', 'a:7:{s:8:\"cap_word\";s:5:\"DEbq7\";s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:1:\"1\";s:7:\"user_id\";s:1:\"1\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('7b2f49301a8458392b2b076a71072a36', '192.168.0.74', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410414055', '');
INSERT INTO `default_ci_sessions` VALUES ('99eb38c1fb30ecc3a0fa7eec68818f3e', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410446246', 'a:1:{s:8:\"cap_word\";s:5:\"uf7Sx\";}');
INSERT INTO `default_ci_sessions` VALUES ('5f436a60c2781064cbf1f020be95d858', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1410529809', 'a:1:{s:8:\"cap_word\";s:5:\"5tJsd\";}');
INSERT INTO `default_ci_sessions` VALUES ('65ddc7ceaca133928f0729e272039c1c', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1410519673', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:1:\"1\";s:7:\"user_id\";s:1:\"1\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('ef076a04968bfb08e79331e0be4b9d6e', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410532038', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:1:\"1\";s:7:\"user_id\";s:1:\"1\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('5d2faa7775487409f8d76206389b60c6', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410585218', '');
INSERT INTO `default_ci_sessions` VALUES ('a84e9c51ac87229e7376140d7b665f92', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410590594', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:1:\"1\";s:7:\"user_id\";s:1:\"1\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('9564b75a5b6c1e05e09bf5f07c877639', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410591767', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:17:\"tester@tester.com\";s:2:\"id\";s:1:\"2\";s:7:\"user_id\";s:1:\"2\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('1996e6bbe5764ad063a9c565cb1aec52', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410591767', 'a:5:{s:5:\"email\";s:17:\"tester@tester.com\";s:2:\"id\";s:1:\"2\";s:7:\"user_id\";s:1:\"2\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('d85a018a270676d7e4fa0c5e339e0981', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410598764', 'a:7:{s:8:\"cap_word\";s:5:\"hBN9l\";s:8:\"username\";N;s:5:\"email\";s:17:\"tester@tester.com\";s:2:\"id\";s:1:\"2\";s:7:\"user_id\";s:1:\"2\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('bfb55f5a7b2f38a5bb1284b2a7a9abc4', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410845210', '');
INSERT INTO `default_ci_sessions` VALUES ('744578ff76c2e1839752b227b95a37d3', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1410572334', '');
INSERT INTO `default_ci_sessions` VALUES ('cc0adbb6ce06a223c62fdfac45858fd3', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1410788915', '');
INSERT INTO `default_ci_sessions` VALUES ('00ed249bcfde34ff2369efe1e1b398bb', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410867541', '');
INSERT INTO `default_ci_sessions` VALUES ('f7baef549097eecac716645709056ed3', '192.168.0.74', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410768452', '');
INSERT INTO `default_ci_sessions` VALUES ('4e34140e6e48d265b689f0c0bebaf709', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410790003', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:17:\"tester@tester.com\";s:2:\"id\";s:1:\"2\";s:7:\"user_id\";s:1:\"2\";s:8:\"group_id\";s:1:\"3\";s:5:\"group\";s:8:\"Merchant\";}');
INSERT INTO `default_ci_sessions` VALUES ('fecfb7e033ab7eb8a5f39df811fec0af', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410790334', '');
INSERT INTO `default_ci_sessions` VALUES ('04edbe4d458821c300f8614cb7825ea4', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1410866881', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:2:\"13\";s:7:\"user_id\";s:2:\"13\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('b72760088a15da2dc287751776be026e', '192.168.0.123', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36', '1410850893', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:17:\"tester@tester.com\";s:2:\"id\";s:1:\"2\";s:7:\"user_id\";s:1:\"2\";s:8:\"group_id\";s:1:\"3\";s:5:\"group\";s:8:\"Merchant\";}');
INSERT INTO `default_ci_sessions` VALUES ('2b8e58c512e2a989f00fe0e9515059bd', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410868584', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:2:\"13\";s:7:\"user_id\";s:2:\"13\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('925e735eb38fac01b2166cd8c2493671', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1410866849', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:2:\"13\";s:7:\"user_id\";s:2:\"13\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('7b8b754997175611d8049a0401f7e6f8', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410868632', '');
INSERT INTO `default_ci_sessions` VALUES ('dbf69fc8e5f9818b528b30b8dd5ad4bd', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410869399', 'a:7:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:2:\"13\";s:7:\"user_id\";s:2:\"13\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";s:15:\"flash:old:error\";s:36:\"Access denied for unauthorised user.\";}');
INSERT INTO `default_ci_sessions` VALUES ('448dd1745912c7ce4c51d0cb3e22eec4', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411018195', 'a:5:{s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:2:\"13\";s:7:\"user_id\";s:2:\"13\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('7519b3d4ffd449af131fe75baaf2d1bb', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410869197', '');
INSERT INTO `default_ci_sessions` VALUES ('7149739ff2406fe49d9914f688892814', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410877968', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:23:\"affiliate@affiliate.com\";s:2:\"id\";s:1:\"3\";s:7:\"user_id\";s:1:\"3\";s:8:\"group_id\";s:1:\"2\";s:5:\"group\";s:9:\"Affiliate\";}');
INSERT INTO `default_ci_sessions` VALUES ('65f72b3b12b8c9344938d4bc71a51eac', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410963347', '');
INSERT INTO `default_ci_sessions` VALUES ('8f327d6bec25fb90864fcfc5615b32c4', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410962551', '');
INSERT INTO `default_ci_sessions` VALUES ('d6c1928b88f8e93dacda2b3020305244', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1410959880', '');
INSERT INTO `default_ci_sessions` VALUES ('2aa3097ff0ef8c94d885331b39e2b2d4', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1410963358', '');
INSERT INTO `default_ci_sessions` VALUES ('074fca13e40813e87310eb795e0b1bb7', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410963364', '');
INSERT INTO `default_ci_sessions` VALUES ('e47866040ce336151e204b571aaa1ef8', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410963423', '');
INSERT INTO `default_ci_sessions` VALUES ('55e99b62f2e185b3d71c44e1ffe18d27', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1410965216', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:2:\"13\";s:7:\"user_id\";s:2:\"13\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('dbea44ccf8c827aa5350181ecac2c8e0', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411018469', 'a:5:{s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:2:\"13\";s:7:\"user_id\";s:2:\"13\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('7784c60fac12e080d0ff5645b38bb3ec', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411018541', 'a:7:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:2:\"13\";s:7:\"user_id\";s:2:\"13\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";s:17:\"flash:old:success\";s:32:\"You have logged in successfully.\";}');
INSERT INTO `default_ci_sessions` VALUES ('9fb9a99cbebe13959fe68bd57b972ba2', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1411047847', '');
INSERT INTO `default_ci_sessions` VALUES ('4160eb9986e5b1bb375b34b8dbd9c38d', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1411120158', '');
INSERT INTO `default_ci_sessions` VALUES ('9478c58aa5c7aa73cfbee48e1c097a26', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411038466', 'a:1:{s:14:\"admin_redirect\";s:16:\"admin/navigation\";}');
INSERT INTO `default_ci_sessions` VALUES ('4b77680d82db69c0272625b303f7b59c', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411038466', '');
INSERT INTO `default_ci_sessions` VALUES ('7f36afb18c76ed584395f54b1cb8060f', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411038466', '');
INSERT INTO `default_ci_sessions` VALUES ('ef1045871be34684f76b33d7c0138f1e', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411043857', '');
INSERT INTO `default_ci_sessions` VALUES ('6321bba108a8a11e0bb20d47c1dfab7a', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411054017', 'a:2:{s:11:\"redirect_to\";s:5:\"users\";s:8:\"cap_word\";s:5:\"B4GHB\";}');
INSERT INTO `default_ci_sessions` VALUES ('589c89eccd8aebf9eae8da249c760ff6', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1411120205', '');
INSERT INTO `default_ci_sessions` VALUES ('729bd8c451ae2b6b67f45a9536afb960', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1411120110', 'a:7:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:2:\"13\";s:7:\"user_id\";s:2:\"13\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";s:17:\"flash:old:success\";s:37:\"The module \"pages\" has been disabled.\";}');
INSERT INTO `default_ci_sessions` VALUES ('1977e7beaece65b1d7839e7df51a20b4', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411104913', '');
INSERT INTO `default_ci_sessions` VALUES ('b9efc79a24823d2cfb1e458cbecd03ca', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411120449', '');
INSERT INTO `default_ci_sessions` VALUES ('9bdad1017493810173373623f20bca97', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411120203', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:2:\"13\";s:7:\"user_id\";s:2:\"13\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('3d1cd4b2a0d5e5a7b443dab3eb67ce35', '192.168.0.74', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1411101804', '');
INSERT INTO `default_ci_sessions` VALUES ('2ac0293b2c5169d86b762184078a587c', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411120251', '');
INSERT INTO `default_ci_sessions` VALUES ('3116b8bf68e855cba6f0cc5b9a0dde89', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1411120252', '');
INSERT INTO `default_ci_sessions` VALUES ('8545de1b476336fba0058920cbf8c7e7', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411120295', '');
INSERT INTO `default_ci_sessions` VALUES ('e6638aaeeee9884c6fcb599c725a39d6', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1411120296', '');
INSERT INTO `default_ci_sessions` VALUES ('fe089d94e3dc9bc5315ff28a781dd58a', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411120337', '');
INSERT INTO `default_ci_sessions` VALUES ('256f02b9aa61bbe7dfd96155f3961f3e', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411120378', '');
INSERT INTO `default_ci_sessions` VALUES ('ee3699866ce8ca4240c55ecd2ec00f1e', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411120417', '');
INSERT INTO `default_ci_sessions` VALUES ('076b60b0fb26ecf37d2aa990aa435a34', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411120456', '');
INSERT INTO `default_ci_sessions` VALUES ('42082476746437031ca2f61065cdf5fb', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1411195784', '');
INSERT INTO `default_ci_sessions` VALUES ('847bfa6a5850f021cee1b8152a8d23f8', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1411195785', 'a:1:{s:14:\"admin_redirect\";s:12:\"admin/addons\";}');
INSERT INTO `default_ci_sessions` VALUES ('4cdeb37d7b2b27f348aff6f9b7fcec07', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411120519', '');
INSERT INTO `default_ci_sessions` VALUES ('a36e97919bda62685970225df37eb663', '192.168.0.19', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0', '1411103598', 'a:1:{s:14:\"admin_redirect\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('a73dcbe69cfc591c3578ff98f2773e2d', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411120655', '');
INSERT INTO `default_ci_sessions` VALUES ('aa0f2e61c9d45efff814e16ae86fe731', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411120693', '');
INSERT INTO `default_ci_sessions` VALUES ('b646cffaf6c4a6f783b999b9ae757d5e', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411120732', '');
INSERT INTO `default_ci_sessions` VALUES ('199fd936426ddd1c16775fc5b29602c7', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411120772', '');
INSERT INTO `default_ci_sessions` VALUES ('e3a9bde1aa383bfe546dbec82fe07c73', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411120816', '');
INSERT INTO `default_ci_sessions` VALUES ('e7aebfeda840de1568954943f638b2d5', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411120790', '');
INSERT INTO `default_ci_sessions` VALUES ('b5f25d0b8d2fef76dfbba83761c58e7b', '192.168.0.123', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36', '1411101637', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:2:\"13\";s:7:\"user_id\";s:2:\"13\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('cb935eeecaf73c090ffce2234752c7f2', '192.168.0.74', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411101767', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:2:\"13\";s:7:\"user_id\";s:2:\"13\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('fd32b23680929e43c314e59a82ff96dc', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411120936', '');
INSERT INTO `default_ci_sessions` VALUES ('f6e0033bfd2b6b8cf3de461b15f4bccb', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411121282', '');
INSERT INTO `default_ci_sessions` VALUES ('6e99fa083741031d02e3703a6566d980', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411120975', '');
INSERT INTO `default_ci_sessions` VALUES ('59189980a989f2735f84671fa0c2a5cd', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411121203', '');
INSERT INTO `default_ci_sessions` VALUES ('fc4ab516bf3d4ce1c324f95f790bee5f', '192.168.0.123', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36', '1411121212', '');
INSERT INTO `default_ci_sessions` VALUES ('0e463aef58fad272e422a2a2d06f0d9a', '192.168.0.123', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36', '1411101666', 'a:5:{s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:2:\"13\";s:7:\"user_id\";s:2:\"13\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('7aedc1addb4e3d4fce375b58dca1724a', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411121244', '');
INSERT INTO `default_ci_sessions` VALUES ('2d01245de50f96e9dcfd59ca5b6a6743', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411121321', '');
INSERT INTO `default_ci_sessions` VALUES ('bfbc42dfbd92a7963709b1dd471ff046', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411178933', 'a:7:{s:8:\"cap_word\";s:5:\"KCTMO\";s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:2:\"13\";s:7:\"user_id\";s:2:\"13\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('b27a46f9019f4dfef9bda081b7b3f569', '192.168.0.19', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0', '1411121350', '');
INSERT INTO `default_ci_sessions` VALUES ('130e45df1d5ab31f6d0f8760f0acf8e0', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1411195785', '');
INSERT INTO `default_ci_sessions` VALUES ('0bbee1a0ee61f6077d49f186564a3b9f', '192.168.0.123', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36', '1411122444', '');
INSERT INTO `default_ci_sessions` VALUES ('01710e685050cae7871e27224266a1f6', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411124394', '');
INSERT INTO `default_ci_sessions` VALUES ('b6ad70b2affc09a3a9f21c8310d944c2', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411124394', '');
INSERT INTO `default_ci_sessions` VALUES ('bab77102907dadc1fcd293943178ea22', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411104982', '');
INSERT INTO `default_ci_sessions` VALUES ('24b7393d21708e41690069b5368ac2dd', '192.168.0.74', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411125236', 'a:1:{s:8:\"cap_word\";s:5:\"oVE35\";}');
INSERT INTO `default_ci_sessions` VALUES ('8927da51d5223b2418cbd32d28c08b2b', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411188796', '');
INSERT INTO `default_ci_sessions` VALUES ('89f74796687aa4ae940deebfd251c7dc', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411124711', '');
INSERT INTO `default_ci_sessions` VALUES ('913e98636f223f1d9e29f390b27e49c2', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411124711', '');
INSERT INTO `default_ci_sessions` VALUES ('37e5d3f041c4c7e4cce7a523f138d28e', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411105302', '');
INSERT INTO `default_ci_sessions` VALUES ('5a62921153123b6e9ab67f759ab6d122', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411124911', 'a:1:{s:8:\"cap_word\";s:5:\"p4kuw\";}');
INSERT INTO `default_ci_sessions` VALUES ('56d187cb83a10e9640e14b13fe7ed05b', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1411127647', 'a:7:{s:8:\"cap_word\";s:5:\"KjYbf\";s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:2:\"13\";s:7:\"user_id\";s:2:\"13\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('93296f0e2aed7e618b0469c1fa4ef667', '192.168.0.74', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411169229', '');
INSERT INTO `default_ci_sessions` VALUES ('45e2be37c7def5438e5b50535ed6528f', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411116384', 'a:1:{s:8:\"cap_word\";s:5:\"rBlVN\";}');
INSERT INTO `default_ci_sessions` VALUES ('f55abd94ae4e40f6964812f754279aac', '192.168.0.74', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411118048', 'a:1:{s:8:\"cap_word\";s:5:\"qYRxg\";}');
INSERT INTO `default_ci_sessions` VALUES ('9e92e8d5c02d42a3d71e6fb7392bb4b0', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411138403', 'a:1:{s:8:\"cap_word\";s:5:\"HYw7z\";}');
INSERT INTO `default_ci_sessions` VALUES ('f5df6befbc188a47c81ca53d58cdd6c4', '192.168.0.74', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1411117833', 'a:1:{s:8:\"cap_word\";s:5:\"WFb57\";}');
INSERT INTO `default_ci_sessions` VALUES ('a5637f1b9cb01dbb653b283b59765b73', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411169929', 'a:1:{s:8:\"cap_word\";s:5:\"f7RAp\";}');
INSERT INTO `default_ci_sessions` VALUES ('7bf9bb672648f0c0f405ead286162cd0', '192.168.0.83', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0', '1411170957', '');
INSERT INTO `default_ci_sessions` VALUES ('a2c1b4f53471e4145ff1c7e53ffe84e0', '192.168.0.74', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411180706', 'a:1:{s:8:\"cap_word\";s:5:\"eJKN1\";}');
INSERT INTO `default_ci_sessions` VALUES ('9ace85ffa4a8c1c644e671c205d28690', '192.168.0.74', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1411176428', 'a:1:{s:8:\"cap_word\";s:5:\"4ZkDA\";}');
INSERT INTO `default_ci_sessions` VALUES ('5a0b9b898261ef5b8442ea51899eb14e', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411201778', '');
INSERT INTO `default_ci_sessions` VALUES ('281a28f31ebc5e0896e5a102cf0017a8', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411201777', '');
INSERT INTO `default_ci_sessions` VALUES ('5a46cdbb6c535187c5b5b254f0015a3e', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1411195784', 'a:1:{s:14:\"admin_redirect\";s:20:\"admin/addons/modules\";}');
INSERT INTO `default_ci_sessions` VALUES ('1f1a85eb8c6451b6913c7efcaf4efa33', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411201777', 'a:1:{s:8:\"cap_word\";s:5:\"gRaeR\";}');
INSERT INTO `default_ci_sessions` VALUES ('e17ec14e849ead86effc527f0796e317', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411201777', '');
INSERT INTO `default_ci_sessions` VALUES ('31d9b70b02cb00628d32c4775a259fb3', '192.168.0.83', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0', '1411177546', 'a:1:{s:17:\"flash:old:success\";s:25:\"You have been logged out.\";}');
INSERT INTO `default_ci_sessions` VALUES ('dcce769b4afa456133452ba660debeb0', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411201778', '');
INSERT INTO `default_ci_sessions` VALUES ('0ae2ac2f2b3347778097abc56c50cfdb', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411201778', '');
INSERT INTO `default_ci_sessions` VALUES ('a1aa36328a0088840e5ad90fed666e69', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411201778', '');
INSERT INTO `default_ci_sessions` VALUES ('aceb8ce02dc54ebe3a5a3f4214e0800c', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411201778', '');
INSERT INTO `default_ci_sessions` VALUES ('8f3cdc940a6d6c0a92945dd70d546857', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411201779', '');
INSERT INTO `default_ci_sessions` VALUES ('48025b0e65fd3e2a1b9359bb70b3901f', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411201779', '');
INSERT INTO `default_ci_sessions` VALUES ('80e8d9aa0bfff517e8db285a05c19c2d', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:31.0) Gecko/20100101 Firefox/31.0', '1411431329', '');
INSERT INTO `default_ci_sessions` VALUES ('7deece8c8a3a27ce279ecf48d02e84fb', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411201779', '');
INSERT INTO `default_ci_sessions` VALUES ('a44031e4632b4051fb0a365f7051666b', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411201779', '');
INSERT INTO `default_ci_sessions` VALUES ('60d6c36c775aa186abac6bc8be815431', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411201779', '');
INSERT INTO `default_ci_sessions` VALUES ('13cdf2c9dc18a172a60aa8a809b6d7f8', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411201780', '');
INSERT INTO `default_ci_sessions` VALUES ('077ae9c7965c0e187757407bee8fab05', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1411202239', 'a:1:{s:8:\"cap_word\";s:5:\"hemip\";}');
INSERT INTO `default_ci_sessions` VALUES ('2da776b403de23f4b3a2630f2234de09', '14.0.145.169', 'Mozilla/5.0 (iPhone; CPU iPhone OS 8_0 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12A365 ', '1411431561', 'a:2:{s:8:\"cap_word\";s:5:\"ud8YR\";s:14:\"admin_redirect\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('0be95611eef3f41ffe2ac91bbab1f47e', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411202753', 'a:1:{s:8:\"cap_word\";s:5:\"RRQUY\";}');
INSERT INTO `default_ci_sessions` VALUES ('88dff050db7cccaa17b9dcc5097a74c6', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:31.0) Gecko/20100101 Firefox/31.0', '1411370203', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:2:\"13\";s:7:\"user_id\";s:2:\"13\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('c86d95188df08a2d65fbdbfd21c0e744', '192.168.0.30', 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.94 Safari/537.36', '1411453616', 'a:1:{s:8:\"cap_word\";s:5:\"sQk1R\";}');
INSERT INTO `default_ci_sessions` VALUES ('7059dc4c7a5fdb27890a87eebe81ae2b', '192.168.0.74', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411452971', '');
INSERT INTO `default_ci_sessions` VALUES ('ec090305dbebdf86efe21c8064608b8d', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1411473465', '');
INSERT INTO `default_ci_sessions` VALUES ('92f9ce1db193f69589172c86a899c5b2', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:31.0) Gecko/20100101 Firefox/31.0', '1411433498', 'a:7:{s:8:\"cap_word\";s:5:\"ThU2G\";s:8:\"username\";N;s:5:\"email\";s:23:\"affiliate@affiliate.com\";s:2:\"id\";s:1:\"3\";s:7:\"user_id\";s:1:\"3\";s:8:\"group_id\";s:1:\"2\";s:5:\"group\";s:9:\"Affiliate\";}');
INSERT INTO `default_ci_sessions` VALUES ('1c300047b508214f85a39e9ef6e31ab5', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411472774', 'a:1:{s:17:\"flash:old:success\";s:25:\"You have been logged out.\";}');
INSERT INTO `default_ci_sessions` VALUES ('6fdf287298d3b6eefc95cebf632ebb0f', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:30.0) Gecko/20100101 Firefox/30.0', '1411472692', '');
INSERT INTO `default_ci_sessions` VALUES ('dfe9748800e2e46864bf7a9891f95728', '61.92.57.42', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36', '1411450204', 'a:1:{s:8:\"cap_word\";s:5:\"68hqM\";}');
INSERT INTO `default_ci_sessions` VALUES ('c5df05a4a07207c34c7470418c521803', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411454314', 'a:1:{s:8:\"cap_word\";s:5:\"ynaz8\";}');
INSERT INTO `default_ci_sessions` VALUES ('58e053b4e9979d37bb4a67fc7e83313f', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:31.0) Gecko/20100101 Firefox/31.0', '1411461343', 'a:1:{s:8:\"cap_word\";s:5:\"ciJil\";}');
INSERT INTO `default_ci_sessions` VALUES ('acb8cbc76a942745bf97c4a2644693bf', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411473200', '');
INSERT INTO `default_ci_sessions` VALUES ('94eee353c66948f7f5160a65e2545e5f', '192.168.0.74', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411453389', '');
INSERT INTO `default_ci_sessions` VALUES ('48d66dcf16af0150a99ff94a448cd085', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411473387', 'a:1:{s:8:\"cap_word\";s:5:\"NZxiQ\";}');
INSERT INTO `default_ci_sessions` VALUES ('35b279c04c27b1e4b792e9526e51aefd', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411474384', 'a:1:{s:8:\"cap_word\";s:5:\"yxYGt\";}');
INSERT INTO `default_ci_sessions` VALUES ('bc98259369e8f2dcffb64b77c208803f', '192.168.0.74', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411463827', 'a:1:{s:8:\"cap_word\";s:5:\"XKhMq\";}');
INSERT INTO `default_ci_sessions` VALUES ('29a9a79de1c083c97b029ef51770624d', '61.92.57.42', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36', '1411500058', 'a:1:{s:14:\"admin_redirect\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('6662179b7395b420096454e2e68b6a94', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411485824', 'a:2:{s:8:\"cap_word\";s:5:\"YJO5R\";s:17:\"flash:old:success\";s:32:\"You have logged in successfully.\";}');
INSERT INTO `default_ci_sessions` VALUES ('50f15aa2272b44bd6bf399f9a99a9f0d', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:31.0) Gecko/20100101 Firefox/31.0', '1411517997', '');
INSERT INTO `default_ci_sessions` VALUES ('de598a4a62aa00325cbb360aed96ee07', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:31.0) Gecko/20100101 Firefox/31.0', '1411535571', 'a:1:{s:8:\"cap_word\";s:5:\"C85i1\";}');
INSERT INTO `default_ci_sessions` VALUES ('1033e109b7e529d225570f04b4612556', '192.168.0.136', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:27.0) Gecko/20100101 Firefox/27.0', '1411535785', 'a:1:{s:8:\"cap_word\";s:5:\"In41l\";}');
INSERT INTO `default_ci_sessions` VALUES ('ed067859ae1fdfd99456eebafb560e7e', '192.168.0.74', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411535069', 'a:1:{s:8:\"cap_word\";s:5:\"EMjPe\";}');
INSERT INTO `default_ci_sessions` VALUES ('a4adc0983ef27af5791e33e9c6dac2b0', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411540581', 'a:1:{s:17:\"flash:old:success\";s:25:\"You have been logged out.\";}');
INSERT INTO `default_ci_sessions` VALUES ('464ce1ee2612782655ab9c0e9bb22a35', '192.168.0.74', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411635807', '');
INSERT INTO `default_ci_sessions` VALUES ('c30f890aa84f07c17411f8bc9d233727', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411641010', 'a:7:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:2:\"47\";s:7:\"user_id\";s:2:\"47\";s:8:\"group_id\";s:1:\"2\";s:5:\"group\";s:9:\"Affiliate\";s:17:\"flash:old:success\";s:32:\"You have logged in successfully.\";}');
INSERT INTO `default_ci_sessions` VALUES ('508dd7226bff9163e68f7aa84d77bba3', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411542894', 'a:1:{s:17:\"flash:old:success\";s:25:\"You have been logged out.\";}');
INSERT INTO `default_ci_sessions` VALUES ('2218404736772cfb40e4d06cfd3c37b9', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:31.0) Gecko/20100101 Firefox/31.0', '1411547989', 'a:1:{s:8:\"cap_word\";s:5:\"WTWVU\";}');
INSERT INTO `default_ci_sessions` VALUES ('6ac038656e38ba7ccd435edbcedae718', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411547328', 'a:7:{s:8:\"cap_word\";s:5:\"2zAL2\";s:8:\"username\";N;s:5:\"email\";s:21:\"merchant@merchant.com\";s:2:\"id\";s:1:\"5\";s:7:\"user_id\";s:1:\"5\";s:8:\"group_id\";s:1:\"3\";s:5:\"group\";s:8:\"Merchant\";}');
INSERT INTO `default_ci_sessions` VALUES ('0e0d9388fd877d553bf1f25ebaefc7bf', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411571469', 'a:1:{s:8:\"cap_word\";s:5:\"Y@QHE\";}');
INSERT INTO `default_ci_sessions` VALUES ('32d5992d5364a9db4b4141f778252047', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411629933', '');
INSERT INTO `default_ci_sessions` VALUES ('cc919b8acc1b652c0db41fe1cc641d95', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:31.0) Gecko/20100101 Firefox/31.0', '1411615960', '');
INSERT INTO `default_ci_sessions` VALUES ('678a1e4fa3c0da5a336e7f0f743d766a', '192.168.0.111', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36', '1411619971', 'a:7:{s:8:\"cap_word\";s:5:\"NTzmE\";s:8:\"username\";N;s:5:\"email\";s:21:\"merchant@merchant.com\";s:2:\"id\";s:1:\"5\";s:7:\"user_id\";s:1:\"5\";s:8:\"group_id\";s:1:\"3\";s:5:\"group\";s:8:\"Merchant\";}');
INSERT INTO `default_ci_sessions` VALUES ('5e43321db0c4b1dc312085022dd902a6', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:31.0) Gecko/20100101 Firefox/31.0', '1411617036', '');
INSERT INTO `default_ci_sessions` VALUES ('689fcf6a261cd1033db0fc42c5ac5195', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411642679', '');
INSERT INTO `default_ci_sessions` VALUES ('aa810ffc0c297ab11a985262dfb2326a', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411653781', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:21:\"merchant@merchant.com\";s:2:\"id\";s:1:\"5\";s:7:\"user_id\";s:1:\"5\";s:8:\"group_id\";s:1:\"3\";s:5:\"group\";s:8:\"Merchant\";}');
INSERT INTO `default_ci_sessions` VALUES ('227feac26686b699b48ec7409586a5dc', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411647320', '');
INSERT INTO `default_ci_sessions` VALUES ('c88375d8e0483b18070d2af6128b470d', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411648404', '');
INSERT INTO `default_ci_sessions` VALUES ('0497f7562ff2721ea2af9f6495392c73', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411646714', '');
INSERT INTO `default_ci_sessions` VALUES ('75f58fefafaee0fba71f292eb46fcb81', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411648318', '');
INSERT INTO `default_ci_sessions` VALUES ('7c93fe68600441faf75a4bc529405a30', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411655459', '');
INSERT INTO `default_ci_sessions` VALUES ('f5a7cccabf1aec5f0e3cca57f70b92e9', '192.168.0.74', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411691316', '');
INSERT INTO `default_ci_sessions` VALUES ('97d998619da4da89620b32cd0a232e1b', '192.168.0.74', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411636944', '');
INSERT INTO `default_ci_sessions` VALUES ('69bcc6fa5f295b2c294f440c499f9c9e', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411658907', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:21:\"merchant@merchant.com\";s:2:\"id\";s:1:\"5\";s:7:\"user_id\";s:1:\"5\";s:8:\"group_id\";s:1:\"3\";s:5:\"group\";s:8:\"Merchant\";}');
INSERT INTO `default_ci_sessions` VALUES ('1972f42d3679732635003853391134b7', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411636530', 'a:1:{s:17:\"flash:old:success\";s:25:\"You have been logged out.\";}');
INSERT INTO `default_ci_sessions` VALUES ('07312fc398fe72693e76e4519fcca8a6', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411709486', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:21:\"merchant@merchant.com\";s:2:\"id\";s:1:\"5\";s:7:\"user_id\";s:1:\"5\";s:8:\"group_id\";s:1:\"3\";s:5:\"group\";s:8:\"Merchant\";}');
INSERT INTO `default_ci_sessions` VALUES ('eae2095e0abe3f4d0bc7af34941f5c09', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411718112', '');
INSERT INTO `default_ci_sessions` VALUES ('a737ccb0e005bd2239428887b50c5474', '192.168.0.74', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411705968', '');
INSERT INTO `default_ci_sessions` VALUES ('de095196b3eb37b7bf12494bf93905b5', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411727107', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:21:\"merchant@merchant.com\";s:2:\"id\";s:1:\"5\";s:7:\"user_id\";s:1:\"5\";s:8:\"group_id\";s:1:\"3\";s:5:\"group\";s:8:\"Merchant\";}');
INSERT INTO `default_ci_sessions` VALUES ('d3ee789df247f32850fd2a8bf9921351', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411712569', '');
INSERT INTO `default_ci_sessions` VALUES ('4c734a3d08afcb795a8582c9c85f0173', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411711282', '');
INSERT INTO `default_ci_sessions` VALUES ('94d9fc120b2a3c66aa645d47a567e39c', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411708851', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:2:\"45\";s:7:\"user_id\";s:2:\"45\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('f78efbd2a8a53061340dd50a2b921fe3', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411739436', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:21:\"merchant@merchant.com\";s:2:\"id\";s:1:\"5\";s:7:\"user_id\";s:1:\"5\";s:8:\"group_id\";s:1:\"3\";s:5:\"group\";s:8:\"Merchant\";}');
INSERT INTO `default_ci_sessions` VALUES ('ab96fe0e59c80e076b2ae3ca12931fac', '192.168.0.74', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411717161', '');
INSERT INTO `default_ci_sessions` VALUES ('ab5ab7f803963827015d2e62b3ebc88f', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411721614', '');
INSERT INTO `default_ci_sessions` VALUES ('613e34848794cec0510930e0af581fda', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411787271', 'a:1:{s:14:\"admin_redirect\";s:11:\"admin/users\";}');
INSERT INTO `default_ci_sessions` VALUES ('c265229eacfc111e24c53bf8b75f9ce4', '192.168.0.83', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0', '1411780676', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:23:\"sushilmishra@cdnsol.com\";s:2:\"id\";s:2:\"56\";s:7:\"user_id\";s:2:\"56\";s:8:\"group_id\";s:1:\"3\";s:5:\"group\";s:8:\"Merchant\";}');
INSERT INTO `default_ci_sessions` VALUES ('cc7055eb612d51e32d40961e7c292312', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411740284', 'a:1:{s:17:\"flash:old:success\";s:29:\"Account created successfully!\";}');
INSERT INTO `default_ci_sessions` VALUES ('29db976318734df5b2b5a6dea38a37e3', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411742359', '');
INSERT INTO `default_ci_sessions` VALUES ('0021bd6ba1d08216dbb44d285020cc6b', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411746311', 'a:1:{s:17:\"flash:old:success\";s:25:\"You have been logged out.\";}');
INSERT INTO `default_ci_sessions` VALUES ('ebe977d0d02b68962c34a86179674763', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411793524', '');
INSERT INTO `default_ci_sessions` VALUES ('466c5b049ae496f4a24c982e619f2c9a', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411776274', '');
INSERT INTO `default_ci_sessions` VALUES ('3003e639b44f71186913c5156d16dd5a', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411775994', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:23:\"sushilmishra@cdnsol.com\";s:2:\"id\";s:2:\"56\";s:7:\"user_id\";s:2:\"56\";s:8:\"group_id\";s:1:\"3\";s:5:\"group\";s:8:\"Merchant\";}');
INSERT INTO `default_ci_sessions` VALUES ('28037939a3dcc6af670c73ea57a81407', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411777012', 'a:1:{s:14:\"admin_redirect\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('126fc87f472f5d684b4379f10b4d7d3a', '192.168.0.83', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36', '1411780770', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:2:\"55\";s:7:\"user_id\";s:2:\"55\";s:8:\"group_id\";s:1:\"2\";s:5:\"group\";s:9:\"Affiliate\";}');
INSERT INTO `default_ci_sessions` VALUES ('187d4978faeb01628defe04117ad4da9', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411806189', 'a:8:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:2:\"55\";s:7:\"user_id\";s:2:\"55\";s:8:\"group_id\";s:1:\"2\";s:5:\"group\";s:9:\"Affiliate\";s:17:\"flash:old:success\";s:47:\"<p>Account Information Successfully Updated</p>\";s:15:\"flash:new:error\";s:0:\"\";}');
INSERT INTO `default_ci_sessions` VALUES ('ecd020054598dc5e73d4c597e1ce03dd', '192.168.0.74', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411785431', 'a:3:{s:15:\"global_messages\";a:1:{s:8:\"errorMsg\";a:1:{i:0;s:32:\"Please enter valid captcha code!\";}}s:15:\"flash:old:error\";s:32:\"Please enter valid captcha code!\";s:15:\"flash:new:error\";s:32:\"Please enter valid captcha code!\";}');
INSERT INTO `default_ci_sessions` VALUES ('5d016b737cfc969bcdb731e9bb20e5c6', '192.168.0.83', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36', '1411783931', '');
INSERT INTO `default_ci_sessions` VALUES ('aaaceefff7591a0996875a95b06d9eeb', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411950551', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:23:\"sushilmishra@cdnsol.com\";s:2:\"id\";s:2:\"56\";s:7:\"user_id\";s:2:\"56\";s:8:\"group_id\";s:1:\"3\";s:5:\"group\";s:8:\"Merchant\";}');
INSERT INTO `default_ci_sessions` VALUES ('82b5be643f1105d6a8536a7ef8cb4433', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411984543', 'a:6:{s:5:\"email\";s:15:\"admin@admin.com\";s:2:\"id\";s:2:\"10\";s:7:\"user_id\";s:2:\"10\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";s:15:\"flash:new:error\";s:0:\"\";}');
INSERT INTO `default_ci_sessions` VALUES ('c88b3fc3e18431b445d39cab8848ea30', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411976570', 'a:7:{s:8:\"username\";N;s:5:\"email\";s:15:\"admin@admin.com\";s:2:\"id\";s:2:\"10\";s:7:\"user_id\";s:2:\"10\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";s:15:\"flash:new:error\";s:0:\"\";}');
INSERT INTO `default_ci_sessions` VALUES ('68d923eeb9a3d1ff684b5fed539ad2c7', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411985218', 'a:6:{s:5:\"email\";s:15:\"admin@admin.com\";s:2:\"id\";s:2:\"10\";s:7:\"user_id\";s:2:\"10\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";s:15:\"flash:new:error\";s:0:\"\";}');
INSERT INTO `default_ci_sessions` VALUES ('0c36da7e2a71fa68841c243e14c16e99', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411965921', 'a:7:{s:14:\"admin_redirect\";s:5:\"admin\";s:8:\"username\";N;s:5:\"email\";s:23:\"sushilmishra@cdnsol.com\";s:2:\"id\";s:2:\"56\";s:7:\"user_id\";s:2:\"56\";s:8:\"group_id\";s:1:\"3\";s:5:\"group\";s:8:\"Merchant\";}');
INSERT INTO `default_ci_sessions` VALUES ('794c46d7ad2ecb70abb5fca8d4a02972', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411986199', 'a:6:{s:5:\"email\";s:15:\"admin@admin.com\";s:2:\"id\";s:2:\"10\";s:7:\"user_id\";s:2:\"10\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";s:15:\"flash:new:error\";s:0:\"\";}');
INSERT INTO `default_ci_sessions` VALUES ('8d6da0f9e556dac313fd0aedb8fa1257', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411993230', 'a:2:{s:15:\"flash:old:error\";s:0:\"\";s:15:\"flash:new:error\";s:0:\"\";}');
INSERT INTO `default_ci_sessions` VALUES ('9dc36990ade325050677200656f8f953', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411995200', 'a:8:{s:8:\"username\";N;s:5:\"email\";s:21:\"merchant@merchant.com\";s:2:\"id\";s:1:\"5\";s:7:\"user_id\";s:1:\"5\";s:8:\"group_id\";s:1:\"3\";s:5:\"group\";s:8:\"Merchant\";s:15:\"flash:old:error\";s:0:\"\";s:15:\"flash:new:error\";s:0:\"\";}');
INSERT INTO `default_ci_sessions` VALUES ('87159d07ec792dc7888f705980d9bb63', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411999462', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:21:\"merchant@merchant.com\";s:2:\"id\";s:1:\"5\";s:7:\"user_id\";s:1:\"5\";s:8:\"group_id\";s:1:\"3\";s:5:\"group\";s:8:\"Merchant\";}');
INSERT INTO `default_ci_sessions` VALUES ('44397469149a76aa033288fb819d4db8', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1411999775', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:21:\"merchant@merchant.com\";s:2:\"id\";s:1:\"5\";s:7:\"user_id\";s:1:\"5\";s:8:\"group_id\";s:1:\"3\";s:5:\"group\";s:8:\"Merchant\";}');
INSERT INTO `default_ci_sessions` VALUES ('d3e05ff5dcd8fc2e123924a0fab8b3b3', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1412001267', 'a:6:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:2:\"45\";s:7:\"user_id\";s:2:\"45\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('8a95fc0e063b7fb2e66047bcbe718044', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1411980986', '');
INSERT INTO `default_ci_sessions` VALUES ('8ba79d0412eb618587bc09a8a6553d41', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1412001267', 'a:5:{s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:2:\"45\";s:7:\"user_id\";s:2:\"45\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";}');
INSERT INTO `default_ci_sessions` VALUES ('7867e15ba95d33ec19ae0577a3d07744', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1412053893', 'a:6:{s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:2:\"45\";s:7:\"user_id\";s:2:\"45\";s:8:\"group_id\";s:1:\"1\";s:5:\"group\";s:5:\"admin\";s:16:\"flash:old:notice\";s:61:\"You are already logged in. Please logout before trying again.\";}');
INSERT INTO `default_ci_sessions` VALUES ('4ea7da5d9190571ff3d85369246a17fb', '192.168.0.123', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1412057312', '');
INSERT INTO `default_ci_sessions` VALUES ('e6007ca723bf867d1929f3a7ee5290e3', '192.168.0.74', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1412388052', 'a:7:{s:8:\"username\";N;s:5:\"email\";s:26:\"rajendrapatidar@cdnsol.com\";s:2:\"id\";s:2:\"58\";s:7:\"user_id\";s:2:\"58\";s:8:\"group_id\";s:1:\"3\";s:5:\"group\";s:8:\"Merchant\";s:17:\"flash:old:success\";s:32:\"You have logged in successfully.\";}');
INSERT INTO `default_ci_sessions` VALUES ('992514a19da0d1947b7194c61573e293', '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36', '1412407615', '');
INSERT INTO `default_ci_sessions` VALUES ('e847ade02ce86c63eca57a0d320b58a3', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0', '1412598549', '');
INSERT INTO `default_ci_sessions` VALUES ('f5edb17ca73ca04e4c1fbbb894068301', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:31.0) Gecko/20100101 Firefox/31.0', '1412817688', '');

-- ----------------------------
-- Table structure for `default_comment_blacklists`
-- ----------------------------
DROP TABLE IF EXISTS `default_comment_blacklists`;
CREATE TABLE `default_comment_blacklists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_comment_blacklists
-- ----------------------------

-- ----------------------------
-- Table structure for `default_comments`
-- ----------------------------
DROP TABLE IF EXISTS `default_comments`;
CREATE TABLE `default_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_active` int(1) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_email` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_website` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `parsed` text COLLATE utf8_unicode_ci NOT NULL,
  `module` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `entry_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `entry_title` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `entry_key` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `entry_plural` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cp_uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` int(11) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_comments
-- ----------------------------

-- ----------------------------
-- Table structure for `default_contact_log`
-- ----------------------------
DROP TABLE IF EXISTS `default_contact_log`;
CREATE TABLE `default_contact_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `sender_agent` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sender_ip` varchar(45) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sender_os` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sent_at` int(11) NOT NULL DEFAULT '0',
  `attachments` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_contact_log
-- ----------------------------
INSERT INTO `default_contact_log` VALUES ('1', 'sushilmishra@cdnsol.com', 'Syrecohk.com :: Other', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 192.168.0.123\n				OS Linux\n				Agent Firefox 26.0\n				<hr />\n				Hello How r u?\n\n				Sushil,\n\n				sushilmishra@cdnsol.com', 'Firefox 26.0', '192.168.0.123', 'Linux', '1411714188', '');
INSERT INTO `default_contact_log` VALUES ('2', 'sushilmishra@cdnsol.com', 'Syrecohk.com :: Support', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 192.168.0.123\n				OS Linux\n				Agent Firefox 26.0\n				<hr />\n				Hello How r u?\n\n				My Apps,\n\n				sushilmishra@cdnsol.com', 'Firefox 26.0', '192.168.0.123', 'Linux', '1411714549', '');
INSERT INTO `default_contact_log` VALUES ('3', 'rajendrapatidar@cdnsol.com', 'Syrecohk.com :: Support', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				this is day details\n\n				rajendra,\n\n				rajendrapatidar@cdnsol.com', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411972714', '');
INSERT INTO `default_contact_log` VALUES ('4', 'rajendrapatidar@cdnsol.com', 'Syrecohk.com :: Support', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				this is day details\n\n				rajendra,\n\n				rajendrapatidar@cdnsol.com', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411972722', '');
INSERT INTO `default_contact_log` VALUES ('5', 'rajendrapatidar@cdnsol.com', 'Syrecohk.com :: Support', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				this is details in the form\n\n				rajendra,\n\n				rajendrapatidar@cdnsol.com', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411977200', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/help1.zip');
INSERT INTO `default_contact_log` VALUES ('6', 'rajendrapatidar@cdnsol.com', 'Syrecohk.com :: Support', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				this is details in the form\n\n				rajendra,\n\n				rajendrapatidar@cdnsol.com', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411977267', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/help2.zip');
INSERT INTO `default_contact_log` VALUES ('7', 'rajendrapatidar@cdnsol.com', 'Syrecohk.com :: Support', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				this is details in the form\n\n				rajendra,\n\n				rajendrapatidar@cdnsol.com', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411977269', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/help3.zip');
INSERT INTO `default_contact_log` VALUES ('8', 'rajendrapatidar@cdnsol.com', 'Syrecohk.com :: Support', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				this is details in the form\n\n				rajendra,\n\n				rajendrapatidar@cdnsol.com', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411977283', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/help4.zip');
INSERT INTO `default_contact_log` VALUES ('9', 'rajendrapatidar@cdnsol.com', 'Syrecohk.com :: Support', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				this is details in the form\n\n				rajendra,\n\n				rajendrapatidar@cdnsol.com', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411977316', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/help5.zip');
INSERT INTO `default_contact_log` VALUES ('10', 'rajendrapatidar@cdnsol.com', 'Syrecohk.com :: Support', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				this is details in the form\n\n				rajendra,\n\n				rajendrapatidar@cdnsol.com', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411977569', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/help6.zip');
INSERT INTO `default_contact_log` VALUES ('11', 'rajendrapatidar@cdnsol.com', 'Syrecohk.com :: Support', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				this is details in the form\n\n				rajendra,\n\n				rajendrapatidar@cdnsol.com', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411977572', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/help7.zip');
INSERT INTO `default_contact_log` VALUES ('12', 'rajendrapatidar@cdnsol.com', 'Syrecohk.com :: Support', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				this is details in the form\n\n				rajendra,\n\n				rajendrapatidar@cdnsol.com', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411977624', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/help8.zip');
INSERT INTO `default_contact_log` VALUES ('13', 'rajendrapatidar@cdnsol.com', 'Syrecohk.com :: Support', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				this is details in the form\n\n				rajendra,\n\n				rajendrapatidar@cdnsol.com', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411977626', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/help9.zip');
INSERT INTO `default_contact_log` VALUES ('14', 'rajendrapatidar@cdnsol.com', 'Syrecohk.com :: Support', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				this is\n\n				rajendra,\n\n				rajendrapatidar@cdnsol.com', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411978003', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/help12.zip');
INSERT INTO `default_contact_log` VALUES ('15', 'rajendrapatidar@cdnsol.com', 'Syrecohk.com :: Support', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				this is\n\n				rajendra,\n\n				rajendrapatidar@cdnsol.com', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411978023', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/help13.zip');
INSERT INTO `default_contact_log` VALUES ('16', 'rajendrapatidar@cdnsol.com', 'Syrecohk.com :: Support', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				this is\n\n				rajendra,\n\n				rajendrapatidar@cdnsol.com', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411978034', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/help14.zip');
INSERT INTO `default_contact_log` VALUES ('17', 'rajendrapatidar@cdnsol.com', 'Syrecohk.com :: Support', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				this is detials\n\n				rajendra,\n\n				rajendrapatidar@cdnsol.com', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411987207', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/loading.zip');
INSERT INTO `default_contact_log` VALUES ('18', 'rajendrapatidar@cdnsol.com', 'Syrecohk.com :: Support', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				this is detials\n\n				rajendra,\n\n				rajendrapatidar@cdnsol.com', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411987226', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/loading1.zip');
INSERT INTO `default_contact_log` VALUES ('19', 'rajendrapatidar@cdnsol.com', 'Syrecohk.com :: Support', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				this is data \n\n				rajendra,\n\n				rajendrapatidar@cdnsol.com', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411988394', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/loading2.zip');
INSERT INTO `default_contact_log` VALUES ('20', '', 'Syrecohk.com :: ', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				\n\n				,\n\n				', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411988982', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/loading4.zip');
INSERT INTO `default_contact_log` VALUES ('21', '', 'Syrecohk.com :: ', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				\n\n				,\n\n				', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411989018', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/loading5.zip');
INSERT INTO `default_contact_log` VALUES ('22', '', 'Syrecohk.com :: ', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				\n\n				,\n\n				', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411990084', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/loading6.zip');
INSERT INTO `default_contact_log` VALUES ('23', '', 'Syrecohk.com :: ', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				\n\n				,\n\n				', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411990397', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/help15.zip');
INSERT INTO `default_contact_log` VALUES ('24', '', '0', '', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411990706', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/help18.zip');
INSERT INTO `default_contact_log` VALUES ('25', '', 'Syrecohk.com :: ', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				\n\n				,\n\n				', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411990733', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/help19.zip');
INSERT INTO `default_contact_log` VALUES ('26', '', 'Syrecohk.com :: ', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				\n\n				,\n\n				', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411990757', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/help20.zip');
INSERT INTO `default_contact_log` VALUES ('27', '', 'Syrecohk.com :: ', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				\n\n				,\n\n				', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411990773', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/help21.zip');
INSERT INTO `default_contact_log` VALUES ('28', '', 'Syrecohk.com :: ', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				\n\n				,\n\n				', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411990909', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/help22.zip');
INSERT INTO `default_contact_log` VALUES ('29', '', 'Syrecohk.com :: ', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				\n\n				,\n\n				', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411990933', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/help23.zip');
INSERT INTO `default_contact_log` VALUES ('30', '', 'Syrecohk.com :: ', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				\n\n				,\n\n				', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411990958', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/help24.zip');
INSERT INTO `default_contact_log` VALUES ('31', '', 'Syrecohk.com :: ', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				\n\n				,\n\n				', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411990988', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/help25.zip');
INSERT INTO `default_contact_log` VALUES ('32', '', 'Syrecohk.com :: ', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				\n\n				,\n\n				', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411991015', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/help26.zip');
INSERT INTO `default_contact_log` VALUES ('33', '', 'Syrecohk.com :: ', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				\n\n				,\n\n				', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411991034', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/help27.zip');
INSERT INTO `default_contact_log` VALUES ('34', '', 'Syrecohk.com :: ', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				\n\n				,\n\n				', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411991071', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/help28.zip');
INSERT INTO `default_contact_log` VALUES ('35', '', 'Syrecohk.com :: ', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				\n\n				,\n\n				', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1411991119', '/var/www/html/referralsystem/php/uploads/default/contact_attachments/help29.zip');
INSERT INTO `default_contact_log` VALUES ('36', '', 'Syrecohk.com :: ', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				\n\n				,\n\n				', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1412170181', '');
INSERT INTO `default_contact_log` VALUES ('37', '', 'Syrecohk.com :: ', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				\n\n				,\n\n				', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1412171071', '');
INSERT INTO `default_contact_log` VALUES ('38', '', 'Syrecohk.com :: ', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 192.168.0.74\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				\n\n				,\n\n				', 'Chrome 35.0.1916.153', '192.168.0.74', 'Linux', '1415189871', '');
INSERT INTO `default_contact_log` VALUES ('39', '', 'Syrecohk.com :: ', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 192.168.0.74\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				\n\n				,\n\n				', 'Chrome 35.0.1916.153', '192.168.0.74', 'Linux', '1415191104', '');
INSERT INTO `default_contact_log` VALUES ('40', '', 'Syrecohk :: ', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 192.168.0.127\n				OS Linux\n				Agent Chrome 18.0.1025.151\n				<hr />\n				\n\n				,\n\n				', 'Chrome 18.0.1025.151', '192.168.0.127', 'Linux', '1416561970', '');
INSERT INTO `default_contact_log` VALUES ('41', '', 'Syrecohk :: ', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 192.168.0.74\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				\n\n				,\n\n				', 'Chrome 35.0.1916.153', '192.168.0.74', 'Linux', '1417774618', '');
INSERT INTO `default_contact_log` VALUES ('42', '', 'Syrecohk :: ', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 127.0.0.1\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				\n\n				,\n\n				', 'Chrome 35.0.1916.153', '127.0.0.1', 'Linux', '1417774414', '');
INSERT INTO `default_contact_log` VALUES ('43', '', 'Syrecohk :: ', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 192.168.0.74\n				OS Linux\n				Agent Chrome 35.0.1916.153\n				<hr />\n				\n\n				,\n\n				', 'Chrome 35.0.1916.153', '192.168.0.74', 'Linux', '1417775794', '');
INSERT INTO `default_contact_log` VALUES ('44', '', 'Syrecohk :: ', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: 192.168.0.74\n				OS Linux\n				Agent Firefox 30.0\n				<hr />\n				\n\n				,\n\n				', 'Firefox 30.0', '192.168.0.74', 'Linux', '1418383997', '');

-- ----------------------------
-- Table structure for `default_data_field_assignments`
-- ----------------------------
DROP TABLE IF EXISTS `default_data_field_assignments`;
CREATE TABLE `default_data_field_assignments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sort_order` int(11) NOT NULL,
  `stream_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `is_required` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `is_unique` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `instructions` text COLLATE utf8_unicode_ci,
  `field_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_data_field_assignments
-- ----------------------------
INSERT INTO `default_data_field_assignments` VALUES ('1', '1', '1', '1', 'yes', 'no', null, null);
INSERT INTO `default_data_field_assignments` VALUES ('2', '1', '2', '2', 'no', 'no', null, null);
INSERT INTO `default_data_field_assignments` VALUES ('3', '1', '3', '3', 'yes', 'no', null, null);
INSERT INTO `default_data_field_assignments` VALUES ('4', '2', '3', '4', 'yes', 'no', null, null);
INSERT INTO `default_data_field_assignments` VALUES ('5', '3', '3', '5', 'no', 'no', null, null);
INSERT INTO `default_data_field_assignments` VALUES ('6', '4', '3', '6', 'no', 'no', null, null);
INSERT INTO `default_data_field_assignments` VALUES ('7', '5', '3', '7', 'no', 'no', null, null);
INSERT INTO `default_data_field_assignments` VALUES ('8', '6', '3', '8', 'no', 'no', null, null);
INSERT INTO `default_data_field_assignments` VALUES ('9', '7', '3', '9', 'no', 'no', null, null);
INSERT INTO `default_data_field_assignments` VALUES ('10', '8', '3', '10', 'no', 'no', null, null);
INSERT INTO `default_data_field_assignments` VALUES ('11', '9', '3', '11', 'no', 'no', null, null);
INSERT INTO `default_data_field_assignments` VALUES ('12', '10', '3', '12', 'no', 'no', null, null);
INSERT INTO `default_data_field_assignments` VALUES ('13', '11', '3', '13', 'no', 'no', null, null);
INSERT INTO `default_data_field_assignments` VALUES ('14', '12', '3', '14', 'no', 'no', null, null);
INSERT INTO `default_data_field_assignments` VALUES ('15', '13', '3', '15', 'no', 'no', null, null);
INSERT INTO `default_data_field_assignments` VALUES ('16', '14', '3', '16', 'no', 'no', null, null);

-- ----------------------------
-- Table structure for `default_data_fields`
-- ----------------------------
DROP TABLE IF EXISTS `default_data_fields`;
CREATE TABLE `default_data_fields` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `field_slug` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `field_namespace` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `field_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `field_data` blob,
  `view_options` blob,
  `is_locked` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_data_fields
-- ----------------------------
INSERT INTO `default_data_fields` VALUES ('1', 'lang:blog:intro_label', 'intro', 'blogs', 'wysiwyg', 0x613A323A7B733A31313A22656469746F725F74797065223B733A363A2273696D706C65223B733A31303A22616C6C6F775F74616773223B733A313A2279223B7D, null, 'no');
INSERT INTO `default_data_fields` VALUES ('2', 'lang:pages:body_label', 'body', 'pages', 'wysiwyg', 0x613A323A7B733A31313A22656469746F725F74797065223B733A383A22616476616E636564223B733A31303A22616C6C6F775F74616773223B733A313A2279223B7D, null, 'no');
INSERT INTO `default_data_fields` VALUES ('3', 'lang:user:first_name_label', 'first_name', 'users', 'text', 0x613A323A7B733A31303A226D61785F6C656E677468223B693A35303B733A31333A2264656661756C745F76616C7565223B4E3B7D, null, 'no');
INSERT INTO `default_data_fields` VALUES ('4', 'lang:user:last_name_label', 'last_name', 'users', 'text', 0x613A323A7B733A31303A226D61785F6C656E677468223B693A35303B733A31333A2264656661756C745F76616C7565223B4E3B7D, null, 'no');
INSERT INTO `default_data_fields` VALUES ('5', 'lang:profile_company', 'company', 'users', 'text', 0x613A323A7B733A31303A226D61785F6C656E677468223B693A3130303B733A31333A2264656661756C745F76616C7565223B4E3B7D, null, 'no');
INSERT INTO `default_data_fields` VALUES ('6', 'lang:profile_bio', 'bio', 'users', 'textarea', 0x613A333A7B733A31323A2264656661756C745F74657874223B4E3B733A31303A22616C6C6F775F74616773223B4E3B733A31323A22636F6E74656E745F74797065223B4E3B7D, null, 'no');
INSERT INTO `default_data_fields` VALUES ('7', 'lang:user:lang', 'lang', 'users', 'pyro_lang', 0x613A313A7B733A31323A2266696C7465725F7468656D65223B733A333A22796573223B7D, null, 'no');
INSERT INTO `default_data_fields` VALUES ('8', 'lang:profile_dob', 'dob', 'users', 'datetime', 0x613A353A7B733A383A227573655F74696D65223B733A323A226E6F223B733A31303A2273746172745F64617465223B733A353A222D31303059223B733A383A22656E645F64617465223B4E3B733A373A2273746F72616765223B733A343A22756E6978223B733A31303A22696E7075745F74797065223B733A383A2264726F70646F776E223B7D, null, 'no');
INSERT INTO `default_data_fields` VALUES ('9', 'lang:profile_gender', 'gender', 'users', 'choice', 0x613A353A7B733A31313A2263686F6963655F64617461223B733A33343A22203A204E6F742054656C6C696E670A6D203A204D616C650A66203A2046656D616C65223B733A31313A2263686F6963655F74797065223B733A383A2264726F70646F776E223B733A31333A2264656661756C745F76616C7565223B4E3B733A31313A226D696E5F63686F69636573223B4E3B733A31313A226D61785F63686F69636573223B4E3B7D, null, 'no');
INSERT INTO `default_data_fields` VALUES ('10', 'lang:profile_phone', 'phone', 'users', 'text', 0x613A323A7B733A31303A226D61785F6C656E677468223B693A32303B733A31333A2264656661756C745F76616C7565223B4E3B7D, null, 'no');
INSERT INTO `default_data_fields` VALUES ('11', 'lang:profile_mobile', 'mobile', 'users', 'text', 0x613A323A7B733A31303A226D61785F6C656E677468223B693A32303B733A31333A2264656661756C745F76616C7565223B4E3B7D, null, 'no');
INSERT INTO `default_data_fields` VALUES ('12', 'lang:profile_address_line1', 'address_line1', 'users', 'text', 0x613A323A7B733A31303A226D61785F6C656E677468223B4E3B733A31333A2264656661756C745F76616C7565223B4E3B7D, null, 'no');
INSERT INTO `default_data_fields` VALUES ('13', 'lang:profile_address_line2', 'address_line2', 'users', 'text', 0x613A323A7B733A31303A226D61785F6C656E677468223B4E3B733A31333A2264656661756C745F76616C7565223B4E3B7D, null, 'no');
INSERT INTO `default_data_fields` VALUES ('14', 'lang:profile_address_line3', 'address_line3', 'users', 'text', 0x613A323A7B733A31303A226D61785F6C656E677468223B4E3B733A31333A2264656661756C745F76616C7565223B4E3B7D, null, 'no');
INSERT INTO `default_data_fields` VALUES ('15', 'lang:profile_address_postcode', 'postcode', 'users', 'text', 0x613A323A7B733A31303A226D61785F6C656E677468223B693A32303B733A31333A2264656661756C745F76616C7565223B4E3B7D, null, 'no');
INSERT INTO `default_data_fields` VALUES ('16', 'lang:profile_website', 'website', 'users', 'url', null, null, 'no');

-- ----------------------------
-- Table structure for `default_data_streams`
-- ----------------------------
DROP TABLE IF EXISTS `default_data_streams`;
CREATE TABLE `default_data_streams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stream_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `stream_slug` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `stream_namespace` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stream_prefix` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `about` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `view_options` blob NOT NULL,
  `title_column` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sorting` enum('title','custom') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'title',
  `permissions` text COLLATE utf8_unicode_ci,
  `is_hidden` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `menu_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_data_streams
-- ----------------------------
INSERT INTO `default_data_streams` VALUES ('1', 'lang:blog:blog_title', 'blog', 'blogs', null, null, 0x613A323A7B693A303B733A323A226964223B693A313B733A373A2263726561746564223B7D, null, 'title', null, 'no', null);
INSERT INTO `default_data_streams` VALUES ('2', 'Default', 'def_page_fields', 'pages', null, 'A simple page type with a WYSIWYG editor that will get you started adding content.', 0x613A323A7B693A303B733A323A226964223B693A313B733A373A2263726561746564223B7D, null, 'title', null, 'no', null);
INSERT INTO `default_data_streams` VALUES ('3', 'lang:user_profile_fields_label', 'profiles', 'users', null, 'Profiles for users module', 0x613A313A7B693A303B733A31323A22646973706C61795F6E616D65223B7D, 'display_name', 'title', null, 'no', null);

-- ----------------------------
-- Table structure for `default_def_page_fields`
-- ----------------------------
DROP TABLE IF EXISTS `default_def_page_fields`;
CREATE TABLE `default_def_page_fields` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `ordering_count` int(11) DEFAULT NULL,
  `body` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_def_page_fields
-- ----------------------------
INSERT INTO `default_def_page_fields` VALUES ('1', '2014-08-01 06:56:16', '2014-11-14 13:08:05', '1', null, '<div class=\"row\">\n<div class=\"col-sm-12\">\n<div class=\"affiliated_wrapper\">\n<div class=\"row\">\n<div class=\"col-sm-3 affiliated_img\"><img src=\"{{ url:site }}assets/images/affiliated_img.jpg\" /></div>\n\n<div class=\"col-sm-8  col-sm-offset-1  affiliated_content\">\n<h1>Affiliated Shop Provides Tools For Success</h1>\n\n<h3>Manage Your Program Like A Proffestional</h3>\n\n<p>AffiliateShop offers a feature-rich affiliate management solution that is perfect for any industry and business. Key features include:</p>\n\n<ul class=\"affiliated_ul\">\n <li>Fully Hosted and Supported</li>\n <li>Robust Feature Set</li>\n <li>SmartTrack Reporting</li>\n <li>Secure and Stable</li>\n <li>SEO Friendly</li>\n <li>Granular Affiliate Management</li>\n <li>Easy to Use</li>\n <li>Powerful Ad Tracking Tools</li>\n <li>Granular Affiliate Management</li>\n</ul>\n</div>\n</div>\n\n<div class=\"row\">\n<div class=\"col-sm-12\">\n<p class=\"affiliate_signup\">View our comprehensive list of <a href=\"affiliate\">affiliate tracking software features</a> and learn how you can start generating more revenue by managing your own affiliate marketing program.</p>\nvariables:sign_up</div>\n</div>\n</div>\n</div>\n</div>\n\n<div class=\"row col2_wrapper\">\n<div class=\"col-sm-6\">\n<div class=\"merchant_wrapper box_wrapper\"><span><img src=\"{{ url:site }}assets/images/merchant.png\" /> </span>\n\n<h2 class=\"box_heading\">Merchants &amp; Advertisers</h2>\n\n<p class=\"box_content\">Start building and managing a profitable affiliate program today with AffiliateShop.</p>\n<a class=\"btn medium_btn\" href=\"merchant\">View more</a></div>\n</div>\n\n<div class=\"col-sm-6\">\n<div class=\"publisher_wrapper box_wrapper\"><span><img src=\"{{ url:site }}assets/images/publisher.png\" /> </span>\n\n<h2 class=\"box_heading\">Affiliates &amp; Publishers</h2>\n\n<p class=\"box_content\">Want to make more money with your web site? Join one of our merchants&rsquo; affiliate programs aWant to make more money with your web site? Join one of our merchants&rsquo; affiliate programs and earn commissions for referring them traffic and sales.nd earn commissions for referring them traffic and sales.</p>\n<a class=\"btn medium_btn\" href=\"affiliate\">View more</a></div>\n</div>\n</div>\n');
INSERT INTO `default_def_page_fields` VALUES ('2', '2014-08-01 06:56:16', '2014-12-12 17:02:51', '1', null, '{{ contact:form email=&quot;text|required|valid_email&quot; subject=&quot;dropdown|Support|Sales|Feedback|Other&quot; message=&quot;textarea&quot; }}\n<div class=\"col-md-10 col-sm-9 content \">\n<div class=\"row\">\n<div class=\"title_bg col-sm-12 margin10\">\n<div class=\"title_bg col-sm-12 margin10\"><!--/TITTLE OF CREATE CONTENT/-->\n<div class=\"title padding_left0\" style=\"margin-left: 11px;\">To contact us please fill out the form below.</div>\n</div>\n</div>\n<!--/END OF TITTLE/-->\n\n<div class=\"row\">\n<div class=\"form-group col-sm-8\"><label for=\"RegInputEmail\">Name<span>*</span></label> <input autocomplete=\"off\" id=\"\" name=\"name\" placeholder=\"Name\" required=\"\" type=\"text\" /></div>\n\n<div class=\"form-group col-sm-8\"><label for=\"RegInputEmail\">Email<span>*</span></label> <input class=\"email\" id=\"contact_email\" name=\"email\" placeholder=\"Email\" required=\"\" type=\"text\" /></div>\n\n<div class=\"form-group col-sm-8\"><label for=\"RegInputEmail\">Subject<span>*</span></label> {{ subject }}</div>\n\n<div class=\"form-group col-sm-8\"><label for=\"RegInputEmail\">Message<span>*</span></label><textarea class=\"message\" cols=\"40\" id=\"contact_message\" name=\"message\" placeholder=\"Message\" rows=\"10\"></textarea></div>\n\n<div class=\"form-group col-sm-8\"><button class=\"btn btn-primary\" type=\"submit\"><span>Send</span></button></div>\n</div>\n</div>\n</div>\n<!--/END OF PRODUCT BANNER CONTENT/--> {{ /contact:form }} <script>\n$(\'input\').attr(\'required\',\'required\');\n$(\'textarea\').attr(\'required\',\'required\');\n</script>');
INSERT INTO `default_def_page_fields` VALUES ('3', '2014-08-01 06:56:16', null, '1', null, '{{ search:form class=\"search-form\" }} \n		<input name=\"q\" placeholder=\"Search terms...\" />\n	{{ /search:form }}');
INSERT INTO `default_def_page_fields` VALUES ('4', '2014-08-01 06:56:16', null, '1', null, '{{ search:form class=\"search-form\" }} \n		<input name=\"q\" placeholder=\"Search terms...\" />\n	{{ /search:form }}\n\n{{ search:results }}\n\n	{{ total }} results for \"{{ query }}\".\n\n	<hr />\n\n	{{ entries }}\n\n		<article>\n			<h4>{{ singular }}: <a href=\"{{ url }}\">{{ title }}</a></h4>\n			<p>{{ description }}</p>\n		</article>\n\n	{{ /entries }}\n\n        {{ pagination }}\n\n{{ /search:results }}');
INSERT INTO `default_def_page_fields` VALUES ('5', '2014-08-01 06:56:16', null, '1', null, '<p>We cannot find the page you are looking for, please click <a title=\"Home\" href=\"{{ pages:url id=\'1\' }}\">here</a> to go to the homepage.</p>');
INSERT INTO `default_def_page_fields` VALUES ('6', '2014-09-01 12:03:38', '2014-11-04 08:33:32', '1', '1', '<div class=\"row\">\n<div class=\"col-md-3 col-sm-4 sidebar\">\n<div class=\"widget\">\n<div class=\"title_bg col-sm-12 margin10\">\n<div class=\"title\">Services1</div>\n</div>\n\n<div class=\"clearfix\">&nbsp;</div>\n\n<ul class=\"bullet_arrow2 categories\">\n <li><a href=\"#\">Fully Hosted and Supported</a></li>\n <li><a href=\"#\">Secure and Stable</a></li>\n <li><a href=\"#\">Granular Affiliate Management</a></li>\n <li><a href=\"#\">Powerful Ad Tracking Tools</a></li>\n <li><a href=\"#\">Robust Feature Set</a></li>\n <li><a href=\"#\">SEO Friendly</a></li>\n <li><a href=\"#\">Easy to Use</a></li>\n <li><a href=\"#\">Granular Affiliate Management</a></li>\n <li><a href=\"#\">SmartTrack Reporting</a></li>\n</ul>\n</div>\n\n<div class=\"widget\">\n<div class=\"title_bg col-sm-12 margin_bottom20 margin_top0\">\n<div class=\"title\">Lorem ipsum dolor</div>\n</div>\n\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec a lorem eget dui lacinia ullamcorper. Nunc a mi ipsum, at porta odio. Vivamus hendrerit, massa et molestie bibendum, lacus neque.</p>\n</div>\n</div>\n\n<div class=\"col-md-9 col-sm-8 content\">\n<div class=\"title_bg col-sm-12 margin10\">\n<div class=\"title padding_left0\">About Syrecohk</div>\n</div>\n\n<div class=\"clearfix\">&nbsp;</div>\n\n<blockquote>\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante venenatis.</p>\n<small><cite title=\"\">Integer posuere erat a ante venenatis.</cite></small></blockquote>\n\n<h3 class=\"about_tittle\">Who we are ?</h3>\n\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras quis mi quis purus consectetur adipiscing vel eget nibh. Vivamus sed tortor massa, ac consequat sem. Suspendisse potenti. Donec blandit nibh luctus nibh dignissim vulputate. Sed interdum, augue at pulvinar dapibus, libero nibh semper massa, ut feugiat leo tortor vitae ante. Aliquam erat volutpat. Suspendisse luctus felis sit amet ipsum ornare eget commodo urna pharetra. Duis hendrerit risus ac nulla mattis rhoncus. Praesent iaculis egestas purus et varius.</p>\n\n<h3 class=\"about_tittle\">Our team</h3>\n\n<div class=\"row\">\n<div class=\"col-md-3\">\n<div class=\"team_member vcard\">\n<div class=\"ouerteam\">&nbsp;</div>\n\n<h4 class=\"fn\">John Doe</h4>\n\n<ul class=\"social_links\">\n <li>&nbsp;</li>\n <li>&nbsp;</li>\n <li>&nbsp;</li>\n</ul>\n<span class=\"title\">Founder</span>\n\n<div class=\"clearfix\">&nbsp;</div>\n\n<p>Sed condimentum aliquet rhoncus. Cras sed libero vitae ipsum suscipit volutpat nec ultricies.</p>\n</div>\n</div>\n\n<div class=\"col-md-3\">\n<div class=\"team_member vcard\">\n<div class=\"ouerteam\">&nbsp;</div>\n\n<h4 class=\"fn\">John Doe</h4>\n\n<ul class=\"social_links\">\n <li>&nbsp;</li>\n <li>&nbsp;</li>\n <li>&nbsp;</li>\n</ul>\n<span class=\"title\">Founder</span>\n\n<div class=\"clearfix\">&nbsp;</div>\n\n<p>Sed condimentum aliquet rhoncus. Cras sed libero vitae ipsum suscipit volutpat nec ultricies.</p>\n</div>\n</div>\n\n<div class=\"col-md-3\">\n<div class=\"team_member vcard\">\n<div class=\"ouerteam\">&nbsp;</div>\n\n<h4 class=\"fn\">John Doe</h4>\n\n<ul class=\"social_links\">\n <li>&nbsp;</li>\n <li>&nbsp;</li>\n <li>&nbsp;</li>\n</ul>\n<span class=\"title\">Founder</span>\n\n<div class=\"clearfix\">&nbsp;</div>\n\n<p>Sed condimentum aliquet rhoncus. Cras sed libero vitae ipsum suscipit volutpat nec ultricies.</p>\n</div>\n</div>\n\n<div class=\"col-md-3\">\n<div class=\"team_member vcard\">\n<div class=\"ouerteam\">&nbsp;</div>\n\n<h4 class=\"fn\">John Doe</h4>\n\n<ul class=\"social_links\">\n <li>&nbsp;</li>\n <li>&nbsp;</li>\n <li>&nbsp;</li>\n</ul>\n<span class=\"title\">Founder</span>\n\n<div class=\"clearfix\">&nbsp;</div>\n\n<p>Sed condimentum aliquet rhoncus. Cras sed libero vitae ipsum suscipit volutpat nec ultricies.</p>\n</div>\n</div>\n</div>\n</div>\n</div>\n');
INSERT INTO `default_def_page_fields` VALUES ('9', '2014-09-13 07:59:46', '2014-11-14 12:38:25', '2', '2', '<div class=\"col-md-6 pd_none\">\n    <div class=\"item\">\n         <img alt=\"\" src=\"http://cdnsolutionsgroup.com/referralsystem/php/system/cms/themes/referral/img/no_image.jpg\" class=\"img_responsive\">\n    </div>\n</div>\n<div class=\"col-md-6\">\n <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>\n <blockquote>\n  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque nisl risus, porta sit amet dui eget, adipiscing ornare lacus. Nunc metus dolor, blandit sed vestibulum eget, volutpat ac sem.</p>\n </blockquote>\n <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>\n</div>');
INSERT INTO `default_def_page_fields` VALUES ('10', '2014-09-16 13:11:24', '2014-09-16 13:12:16', '13', '3', '<div class=\"col-md-6 pd_none\">\n<div class=\"item\"><img alt=\"\" class=\"img_responsive\" src=\"{{ url:site }}system/cms/themes/referral/img/no_image.jpg\" /></div>\n</div>\n\n<div class=\"col-md-6\">\n<p>Lorem ipsum1 dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>\n\n<blockquote>\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque nisl risus, porta sit amet dui eget, adipiscing ornare lacus. Nunc metus dolor, blandit sed vestibulum eget, volutpat ac sem.</p>\n</blockquote>\n\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>\n</div>');
INSERT INTO `default_def_page_fields` VALUES ('11', '2014-09-19 06:35:29', '2014-12-03 14:01:32', '13', '4', '<div style=\"margin-left:21px; margin-right:15px\"><span -webkit-text-stroke-width:=\"\" ac=\"\" adipiscing=\"\" aliquam=\"\" amet=\"\" ante.=\"\" at=\"\" augue=\"\" background-color:=\"\" blandit=\"\" commodo=\"\" consectetur=\"\" consequat=\"\" cras=\"\" dignissim=\"\" display:=\"\" dolor=\"\" donec=\"\" duis=\"\" egestas=\"\" eget=\"\" elit.=\"\" erat=\"\" et=\"\" felis=\"\" feugiat=\"\" float:=\"\" font-family:=\"\" font-size:=\"\" font-style:=\"\" font-variant:=\"\" font-weight:=\"\" hendrerit=\"\" iaculis=\"\" inline=\"\" ipsum=\"\" leo=\"\" letter-spacing:=\"\" libero=\"\" line-height:=\"\" lorem=\"\" luctus=\"\" mattis=\"\" mi=\"\" nibh=\"\" nibh.=\"\" nulla=\"\" ornare=\"\" orphans:=\"\" pharetra.=\"\" potenti.=\"\" praesent=\"\" pulvinar=\"\" purus=\"\" quis=\"\" rhoncus.=\"\" risus=\"\" sed=\"\" sem.=\"\" semper=\"\" sit=\"\" span=\"\" suspendisse=\"\" text-align:=\"\" text-indent:=\"\" text-transform:=\"\" tortor=\"\" urna=\"\" ut=\"\" vel=\"\" vitae=\"\" vivamus=\"\" volutpat.=\"\" vulputate.=\"\" white-space:=\"\" widows:=\"\" word-spacing:=\"\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras quis mi quis purus consectetur adipiscing vel eget nibh. Vivamus sed tortor massa, ac consequat sem. Suspendisse potenti. Donec blandit nibh luctus nibh dignissim vulputate. Sed interdum, augue at pulvinar dapibus, libero nibh semper massa, ut feugiat leo tortor vitae ante. Aliquam erat volutpat. Suspendisse luctus felis sit amet ipsum ornare eget commodo urna pharetra. Duis hendrerit risus ac nulla mattis rhoncus. Praesent iaculis egestas purus et varius.<br />\n<br />\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Cras quis mi quis purus consectetur adipiscing vel eget nibh. Vivamus sed tortor massa, ac consequat sem. Suspendisse potenti. Donec</span>&nbsp;<span -webkit-text-stroke-width:=\"\" ac=\"\" adipiscing=\"\" aliquam=\"\" amet=\"\" ante.=\"\" at=\"\" augue=\"\" background-color:=\"\" blandit=\"\" commodo=\"\" consectetur=\"\" consequat=\"\" cras=\"\" dignissim=\"\" display:=\"\" dolor=\"\" donec=\"\" duis=\"\" egestas=\"\" eget=\"\" elit.=\"\" erat=\"\" et=\"\" felis=\"\" feugiat=\"\" float:=\"\" font-family:=\"\" font-size:=\"\" font-style:=\"\" font-variant:=\"\" font-weight:=\"\" hendrerit=\"\" iaculis=\"\" inline=\"\" ipsum=\"\" leo=\"\" letter-spacing:=\"\" libero=\"\" line-height:=\"\" lorem=\"\" luctus=\"\" mattis=\"\" mi=\"\" nibh=\"\" nibh.=\"\" nulla=\"\" ornare=\"\" orphans:=\"\" pharetra.=\"\" potenti.=\"\" praesent=\"\" pulvinar=\"\" purus=\"\" quis=\"\" rhoncus.=\"\" risus=\"\" sed=\"\" sem.=\"\" semper=\"\" sit=\"\" span=\"\" suspendisse=\"\" text-align:=\"\" text-indent:=\"\" text-transform:=\"\" tortor=\"\" urna=\"\" ut=\"\" vel=\"\" vitae=\"\" vivamus=\"\" volutpat.=\"\" vulputate.=\"\" white-space:=\"\" widows:=\"\" word-spacing:=\"\"> blandit nibh luctus nibh dignissim vulputate. Sed interdum, augue at pulvinar dapibus, libero nibh semper massa, ut feugiat leo tortor vitae ante. Aliquam erat volutpat. Suspendisse luctus felis sit amet ipsum ornare eget commodo urna pharetra. Duis hendrerit risus ac nulla mattis rhoncus. Praesent iaculis egestas purus et varius.\n\n<br />\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Cras quis mi quis purus consectetur adipiscing vel eget nibh. Vivamus sed tortor massa, ac consequat sem. Suspendisse potenti. Donec</span>&nbsp;<span -webkit-text-stroke-width:=\"\" ac=\"\" adipiscing=\"\" aliquam=\"\" amet=\"\" ante.=\"\" at=\"\" augue=\"\" background-color:=\"\" blandit=\"\" commodo=\"\" consectetur=\"\" consequat=\"\" cras=\"\" dignissim=\"\" display:=\"\" dolor=\"\" donec=\"\" duis=\"\" egestas=\"\" eget=\"\" elit.=\"\" erat=\"\" et=\"\" felis=\"\" feugiat=\"\" float:=\"\" font-family:=\"\" font-size:=\"\" font-style:=\"\" font-variant:=\"\" font-weight:=\"\" hendrerit=\"\" iaculis=\"\" inline=\"\" ipsum=\"\" leo=\"\" letter-spacing:=\"\" libero=\"\" line-height:=\"\" lorem=\"\" luctus=\"\" mattis=\"\" mi=\"\" nibh=\"\" nibh.=\"\" nulla=\"\" ornare=\"\" orphans:=\"\" pharetra.=\"\" potenti.=\"\" praesent=\"\" pulvinar=\"\" purus=\"\" quis=\"\" rhoncus.=\"\" risus=\"\" sed=\"\" sem.=\"\" semper=\"\" sit=\"\" span=\"\" suspendisse=\"\" text-align:=\"\" text-indent:=\"\" text-transform:=\"\" tortor=\"\" urna=\"\" ut=\"\" vel=\"\" vitae=\"\" vivamus=\"\" volutpat.=\"\" vulputate.=\"\" white-space:=\"\" widows:=\"\" word-spacing:=\"\"> blandit nibh luctus nibh dignissim vulputate. Sed interdum, augue at pulvinar dapibus, libero nibh semper massa, ut feugiat leo tortor vitae ante. Aliquam erat volutpat. Suspendisse luctus felis sit amet ipsum ornare eget commodo urna pharetra. Duis hendrerit risus ac nulla mattis rhoncus. Praesent iaculis egestas purus et varius.\n\n\n</span></div>\n');
INSERT INTO `default_def_page_fields` VALUES ('13', '2014-09-19 07:31:17', '2014-09-19 11:56:18', '13', '5', '<span  rgb(80, 80, 80); font-family: LatoRegular; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 20px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; display: inline !important; float: none; background-color: rgb(255, 255, 255);\">Lorem ipsum121 dolor sit amet, consectetur adipiscing elit. Cras quis mi quis purus consectetur adipiscing vel eget nibh. Vivamus sed tortor massa, ac consequat sem. Suspendisse potenti. Donec blandit nibh luctus nibh dignissim vulputate. Sed interdum, augue at pulvinar dapibus, libero nibh semper massa, ut feugiat leo tortor vitae ante. Aliquam erat volutpat. Suspendisse luctus felis sit amet ipsum ornare eget commodo urna pharetra. Duis hendrerit risus ac nulla mattis rhoncus. Praesent iaculis egestas purus et varius.</span><br />\n&nbsp;\n<div  border-box; display: inline-block;\"><span  rgb(80, 80, 80); font-family: LatoRegular; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 20px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; display: inline !important; float: none; background-color: rgb(255, 255, 255);\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras quis mi quis purus consectetur adipiscing vel eget nibh. Vivamus sed tortor massa, ac consequat sem. Suspendisse potenti. Donec blandit nibh luctus nibh dignissim vulputate. Sed interdum, augue at pulvinar dapibus, libero nibh semper massa, ut feugiat leo tortor vitae ante. Aliquam erat volutpat. Suspendisse luctus felis sit amet ipsum ornare eget commodo urna pharetra. Duis hendrerit risus ac nulla mattis rhoncus. Praesent iaculis egestas purus et varius.<br />\n<br />\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Cras quis mi quis purus consectetur adipiscing vel eget nibh. Vivamus sed tortor massa, ac consequat sem. Suspendisse potenti. Donec blandit nibh luctus nibh dignissim vulputate. Sed interdum, augue at pulvinar dapibus, libero nibh semper massa, ut feugiat leo tortor vitae ante. Aliquam erat volutpat. Suspendisse luctus felis sit amet ipsum ornare eget commodo urna pharetra. Duis hendrerit risus ac nulla mattis rhoncus. Praesent iaculis egestas purus et varius.</span><br />\n<br />\n&nbsp;</div>\n');
INSERT INTO `default_def_page_fields` VALUES ('15', '2014-09-24 14:57:11', '2014-09-24 15:11:00', '45', '6', '<span style=\"font-size: 13px;\">&nbsp;Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla&nbsp;</span>');
INSERT INTO `default_def_page_fields` VALUES ('17', '2014-11-29 11:46:32', '2014-11-29 11:48:04', '58', '7', 'Direct deposit, also known as direct credit, is a banking term that describes a deposit of money by a payer directly into a payee\'s bank account. Direct deposits are most commonly made by businesses in the payment of salaries and wages and for the payment of suppliers\' accounts, but the facility can be used for payments for any purpose, such payment of taxes and other government charges. Direct deposits are most commonly made by means of electronic funds transfers effected using online banking systems, but can also be effected by the physical deposit of money into the payee\'s bank account.');

-- ----------------------------
-- Table structure for `default_email_templates`
-- ----------------------------
DROP TABLE IF EXISTS `default_email_templates`;
CREATE TABLE `default_email_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_default` int(1) NOT NULL DEFAULT '0',
  `module` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_lang` (`slug`,`lang`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_email_templates
-- ----------------------------
INSERT INTO `default_email_templates` VALUES ('1', 'comments', 'Comment Notification', 'Email that is sent to admin when someone creates a comment', 'You have just received a comment from {{ name }}', '<h3>You have received a comment from {{ name }}</h3>\n				<p>\n				<strong>IP Address: {{ sender_ip }}</strong><br/>\n				<strong>Operating System: {{ sender_os }}<br/>\n				<strong>User Agent: {{ sender_agent }}</strong>\n				</p>\n				<p>{{ comment }}</p>\n				<p>View Comment: {{ redirect_url }}</p>', 'en', '1', 'comments');
INSERT INTO `default_email_templates` VALUES ('2', 'contact', 'Contact Notification', 'Template for the contact form', '{{ settings:site_name }} :: {{ subject }}', 'This message was sent via the contact form on with the following details:\n				<hr />\n				IP Address: {{ sender_ip }}\n				OS {{ sender_os }}\n				Agent {{ sender_agent }}\n				<hr />\n				{{ message }}\n\n				{{ name }},\n\n				{{ email }}', 'en', '1', 'pages');
INSERT INTO `default_email_templates` VALUES ('3', 'registered', 'New User Registered', 'Email sent to the site contact e-mail when a new user registers', '{{ settings:site_name }} :: You have just received a registration from {{ name }}', '<h3>You have received a registration from {{ name }}</h3>\n				<p><strong>IP Address: {{ sender_ip }}</strong><br/>\n				<strong>Operating System: {{ sender_os }}</strong><br/>\n				<strong>User Agent: {{ sender_agent }}</strong>\n				</p>', 'en', '1', 'users');
INSERT INTO `default_email_templates` VALUES ('4', 'activation', 'Activation Email', 'The email which contains the activation code that is sent to a new user', '{{ settings:site_name }} - Account Activation', '<p>Hello {{ user:first_name }},</p>\n				<p>Thank you for registering at {{ settings:site_name }}. Before we can activate your account, please complete the registration process by clicking on the following link:</p>\n				<p><a href=\"{{ url:site }}users/activate/{{ user:id }}/{{ activation_code }}\">{{ url:site }}users/activate/{{ user:id }}/{{ activation_code }}</a></p>\n				<p>&nbsp;</p>\n				<p>In case your email program does not recognize the above link as, please direct your browser to the following URL and enter the activation code:</p>\n				<p><a href=\"{{ url:site }}users/activate\">{{ url:site }}users/activate</a></p>\n				<p><strong>Activation Code:</strong> {{ activation_code }}</p>', 'en', '1', 'users');
INSERT INTO `default_email_templates` VALUES ('5', 'forgotten_password', 'Forgotten Password Email', 'The email that is sent containing a password reset code', '{{ settings:site_name }} - Forgotten Password', '<p>Hello {{ user:first_name }},</p>\n				<p>It seems you have requested a password reset. Please click this link to complete the reset: <a href=\"{{ url:site }}users/reset_pass/{{ user:forgotten_password_code }}\">{{ url:site }}users/reset_pass/{{ user:forgotten_password_code }}</a></p>\n				<p>If you did not request a password reset please disregard this message. No further action is necessary.</p>', 'en', '1', 'users');
INSERT INTO `default_email_templates` VALUES ('6', 'new_password', 'New Password Email', 'After a password is reset this email is sent containing the new password', '{{ settings:site_name }} - New Password', '<p>Hello {{ user:first_name }},</p>\n				<p>Your new password is: {{ new_password }}</p>\n				<p>After logging in you may change your password by visiting <a href=\"{{ url:site }}edit-profile\">{{ url:site }}edit-profile</a></p>', 'en', '1', 'users');

-- ----------------------------
-- Table structure for `default_file_folders`
-- ----------------------------
DROP TABLE IF EXISTS `default_file_folders`;
CREATE TABLE `default_file_folders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT '0',
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'local',
  `remote_container` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `date_added` int(11) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `hidden` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_file_folders
-- ----------------------------
INSERT INTO `default_file_folders` VALUES ('1', '0', 'untitled-folder', 'Untitled Folder', 'local', '', '1410953953', '1410953953', '0');

-- ----------------------------
-- Table structure for `default_files`
-- ----------------------------
DROP TABLE IF EXISTS `default_files`;
CREATE TABLE `default_files` (
  `id` char(15) COLLATE utf8_unicode_ci NOT NULL,
  `folder_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '1',
  `type` enum('a','v','d','i','o') COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `extension` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `mimetype` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `keywords` char(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `width` int(5) DEFAULT NULL,
  `height` int(5) DEFAULT NULL,
  `filesize` int(11) NOT NULL DEFAULT '0',
  `alt_attribute` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `download_count` int(11) NOT NULL DEFAULT '0',
  `date_added` int(11) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_files
-- ----------------------------
INSERT INTO `default_files` VALUES ('23d584d7113922a', '1', '58', 'i', 'test', '0778dfe502f965860375fe1beebd5b83.jpg', '{{ url:site }}files/large/0778dfe502f965860375fe1beebd5b83.jpg', '', '.jpg', 'image/jpeg', '', '380', '359', '25', '', '0', '1417048176', '0');
INSERT INTO `default_files` VALUES ('dba2ec227343dfb', '1', '58', 'i', 'land_4.jpg', 'ea656491c61243367b3dac9bcefe20f0.jpg', '{{ url:site }}files/large/ea656491c61243367b3dac9bcefe20f0.jpg', '', '.jpg', 'image/jpeg', '', '380', '359', '25', '', '0', '1417069093', '0');

-- ----------------------------
-- Table structure for `default_gmail_contact_log`
-- ----------------------------
DROP TABLE IF EXISTS `default_gmail_contact_log`;
CREATE TABLE `default_gmail_contact_log` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` int(11) DEFAULT NULL,
  `contact_email` varchar(250) DEFAULT NULL,
  `contact_type` int(11) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB AUTO_INCREMENT=265 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of default_gmail_contact_log
-- ----------------------------
INSERT INTO `default_gmail_contact_log` VALUES ('1', '55', 'rajendrapatidar@cdnsol.com', '1', '2014-11-18 16:34:46');
INSERT INTO `default_gmail_contact_log` VALUES ('2', '55', 'rajendra@cdnsol.com', '1', '2014-11-18 16:35:52');
INSERT INTO `default_gmail_contact_log` VALUES ('3', '55', 'piyushjain@cdnsol.com', '1', '2014-11-18 16:36:09');
INSERT INTO `default_gmail_contact_log` VALUES ('227', '151', 'rajendrapatidar@cdnsol.com', '1', '2014-12-11 19:32:43');
INSERT INTO `default_gmail_contact_log` VALUES ('228', '151', 'patidar@cdnsol.com', '1', '2014-12-11 19:33:40');
INSERT INTO `default_gmail_contact_log` VALUES ('229', '151', 'prashantgupta@cdnsl.com', '1', '2014-12-11 19:40:46');
INSERT INTO `default_gmail_contact_log` VALUES ('230', '151', 'pras@cdnsol.com', '1', '2014-12-11 19:42:24');
INSERT INTO `default_gmail_contact_log` VALUES ('231', '147', 'tester@cdnsol.com', '1', '2014-12-11 14:03:31');
INSERT INTO `default_gmail_contact_log` VALUES ('232', '147', 'trilochanumath@cdnsol.com', '1', '2014-12-11 14:05:14');
INSERT INTO `default_gmail_contact_log` VALUES ('233', '55', 'sushilmishra@cdnsol.com', '1', '2014-12-11 14:07:06');
INSERT INTO `default_gmail_contact_log` VALUES ('234', '55', 'tster@cdnsol.com', '1', '2014-12-11 14:13:01');
INSERT INTO `default_gmail_contact_log` VALUES ('235', '55', 'usere@cdnsol.com', '1', '2014-12-11 14:13:44');
INSERT INTO `default_gmail_contact_log` VALUES ('236', '55', 'patidadsare@cdnsom.cpm', '1', '2014-12-11 14:14:06');
INSERT INTO `default_gmail_contact_log` VALUES ('237', '147', 'gdfgdf@vdsfgds.com', '1', '2014-12-11 14:14:21');
INSERT INTO `default_gmail_contact_log` VALUES ('238', '147', 'fdsfds@dfsd.com', '1', '2014-12-11 14:14:30');
INSERT INTO `default_gmail_contact_log` VALUES ('239', '55', 'fsfdsdsfds@dsfsd.com', '1', '2014-12-11 14:15:40');
INSERT INTO `default_gmail_contact_log` VALUES ('240', '147', 'fdsfdsfd@vdsrfsd.com', '1', '2014-12-11 14:18:36');
INSERT INTO `default_gmail_contact_log` VALUES ('241', '147', 'dsfdhfsjhfds@fdfds.com', '1', '2014-12-11 14:20:06');
INSERT INTO `default_gmail_contact_log` VALUES ('242', '147', 'fdsfjdshfsdjhdfsjffds@dfsfd.com', '1', '2014-12-11 14:20:15');
INSERT INTO `default_gmail_contact_log` VALUES ('243', '147', 'testestrete@fess.com', '1', '2014-12-11 14:20:56');
INSERT INTO `default_gmail_contact_log` VALUES ('244', '147', 'teerewrwerew@fdsfds.com', '1', '2014-12-12 05:45:05');
INSERT INTO `default_gmail_contact_log` VALUES ('245', '55', 'sdjhfdsfjhsd@fdsfd.com', '1', '2014-12-12 11:28:59');
INSERT INTO `default_gmail_contact_log` VALUES ('246', '153', 'prashantgupta@cdnsl.com', '1', '2014-12-12 12:49:51');
INSERT INTO `default_gmail_contact_log` VALUES ('247', '153', 'prashantgupta@cdnsol.com', '1', '2014-12-12 12:59:45');
INSERT INTO `default_gmail_contact_log` VALUES ('248', '153', 'rajendrapatidar@cdnsol.com', '1', '2014-12-12 16:12:14');
INSERT INTO `default_gmail_contact_log` VALUES ('249', '55', '', '1', '2014-12-15 06:18:54');
INSERT INTO `default_gmail_contact_log` VALUES ('250', '55', 'sunilpal@cdnsol.com', '1', '2014-12-15 06:39:03');
INSERT INTO `default_gmail_contact_log` VALUES ('251', '55', 'ANUBHA.CDN@GMAIL.COM', '1', '2014-12-18 13:13:06');
INSERT INTO `default_gmail_contact_log` VALUES ('252', '55', 'sales1@fuste.com.cn', '1', '2015-01-17 20:03:25');
INSERT INTO `default_gmail_contact_log` VALUES ('253', '55', 'tonychou@wxjlcooler.com', '1', '2015-01-17 20:03:25');
INSERT INTO `default_gmail_contact_log` VALUES ('254', '55', 'sale1@qinhongda.cn', '1', '2015-01-17 20:03:25');
INSERT INTO `default_gmail_contact_log` VALUES ('255', '55', 'alibaba@syrecohk.com', '1', '2015-01-17 20:03:25');
INSERT INTO `default_gmail_contact_log` VALUES ('256', '55', 'Nancy@btxcjx.cn', '1', '2015-01-17 20:03:25');
INSERT INTO `default_gmail_contact_log` VALUES ('257', '55', 'sales1@tf166.com', '1', '2015-01-17 20:03:25');
INSERT INTO `default_gmail_contact_log` VALUES ('258', '55', 'sales@syrecohk.com', '1', '2015-01-17 20:03:25');
INSERT INTO `default_gmail_contact_log` VALUES ('259', '55', 'account@hybrid-power.com', '1', '2015-01-17 20:03:25');
INSERT INTO `default_gmail_contact_log` VALUES ('260', '55', 'wtsales07@gmail.com', '1', '2015-01-17 20:03:26');
INSERT INTO `default_gmail_contact_log` VALUES ('261', '55', '1184347429@qq.com', '1', '2015-01-17 20:03:26');
INSERT INTO `default_gmail_contact_log` VALUES ('262', '55', 'jenny@jtrmachine.com', '1', '2015-01-17 20:03:26');
INSERT INTO `default_gmail_contact_log` VALUES ('263', '55', 'iris@szelecs.com', '1', '2015-01-17 20:03:26');
INSERT INTO `default_gmail_contact_log` VALUES ('264', '55', 'frank.yin512@hotmail.com', '1', '2015-01-17 20:03:26');

-- ----------------------------
-- Table structure for `default_groups`
-- ----------------------------
DROP TABLE IF EXISTS `default_groups`;
CREATE TABLE `default_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_groups
-- ----------------------------
INSERT INTO `default_groups` VALUES ('1', 'admin', 'Administrator');
INSERT INTO `default_groups` VALUES ('2', 'Affiliate', 'Affiliate');
INSERT INTO `default_groups` VALUES ('3', 'Merchant', 'Merchant');
INSERT INTO `default_groups` VALUES ('4', 'live-support', 'Live Support');

-- ----------------------------
-- Table structure for `default_keywords`
-- ----------------------------
DROP TABLE IF EXISTS `default_keywords`;
CREATE TABLE `default_keywords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_keywords
-- ----------------------------

-- ----------------------------
-- Table structure for `default_keywords_applied`
-- ----------------------------
DROP TABLE IF EXISTS `default_keywords_applied`;
CREATE TABLE `default_keywords_applied` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hash` char(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `keyword_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_keywords_applied
-- ----------------------------

-- ----------------------------
-- Table structure for `default_membership_access`
-- ----------------------------
DROP TABLE IF EXISTS `default_membership_access`;
CREATE TABLE `default_membership_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `membership_id` int(11) NOT NULL,
  `feature_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=428 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of default_membership_access
-- ----------------------------
INSERT INTO `default_membership_access` VALUES ('398', '3', '5');
INSERT INTO `default_membership_access` VALUES ('399', '3', '4');
INSERT INTO `default_membership_access` VALUES ('400', '3', '3');
INSERT INTO `default_membership_access` VALUES ('401', '3', '2');
INSERT INTO `default_membership_access` VALUES ('402', '3', '1');
INSERT INTO `default_membership_access` VALUES ('403', '5', '9');
INSERT INTO `default_membership_access` VALUES ('404', '5', '8');
INSERT INTO `default_membership_access` VALUES ('405', '5', '7');
INSERT INTO `default_membership_access` VALUES ('406', '5', '6');
INSERT INTO `default_membership_access` VALUES ('407', '5', '5');
INSERT INTO `default_membership_access` VALUES ('408', '5', '4');
INSERT INTO `default_membership_access` VALUES ('409', '5', '3');
INSERT INTO `default_membership_access` VALUES ('410', '5', '2');
INSERT INTO `default_membership_access` VALUES ('411', '5', '1');
INSERT INTO `default_membership_access` VALUES ('421', '1', '9');
INSERT INTO `default_membership_access` VALUES ('422', '1', '8');
INSERT INTO `default_membership_access` VALUES ('423', '1', '5');
INSERT INTO `default_membership_access` VALUES ('424', '1', '4');
INSERT INTO `default_membership_access` VALUES ('425', '1', '3');
INSERT INTO `default_membership_access` VALUES ('426', '1', '2');
INSERT INTO `default_membership_access` VALUES ('427', '1', '1');

-- ----------------------------
-- Table structure for `default_membership_features`
-- ----------------------------
DROP TABLE IF EXISTS `default_membership_features`;
CREATE TABLE `default_membership_features` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feature_title` varchar(255) NOT NULL,
  `feature_description` text NOT NULL,
  `feature_status` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of default_membership_features
-- ----------------------------
INSERT INTO `default_membership_features` VALUES ('1', 'Fraud Protection', 'IPCheck, SourceCheck, and more to protect your marketing investment', '0');
INSERT INTO `default_membership_features` VALUES ('2', 'Direct Affiliate Linking', 'Affiliates use your own domain as the direct link code to benefit your search engine optimization efforts', '0');
INSERT INTO `default_membership_features` VALUES ('3', 'Features', 'All AffiliateShop features included', '0');
INSERT INTO `default_membership_features` VALUES ('4', 'Number of Clicks', 'Unlimited', '0');
INSERT INTO `default_membership_features` VALUES ('5', 'Number of Affiliates', 'Unlimited', '0');
INSERT INTO `default_membership_features` VALUES ('6', 'Expert Assistance', 'We will provide free consulting services if you need aditional help with landing pages, creative, affiliate agreements, Implementation testing and more. Please contact us.', '0');
INSERT INTO `default_membership_features` VALUES ('7', 'Affiliate Program Consulting', 'We can work with you to grow your affiliate program by proactively recruiting premium affiliates on your behalf, helping you identify appropriate affiliate industries, and much more.', '0');
INSERT INTO `default_membership_features` VALUES ('8', 'Email Support', '24 hours a day, 7 days a week', '0');
INSERT INTO `default_membership_features` VALUES ('9', 'Phone Support', 'China Business Hours , Monday through Friday 8AM-6PM', '0');

-- ----------------------------
-- Table structure for `default_membership_payment`
-- ----------------------------
DROP TABLE IF EXISTS `default_membership_payment`;
CREATE TABLE `default_membership_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `membership_id` int(11) NOT NULL,
  `amt` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of default_membership_payment
-- ----------------------------
INSERT INTO `default_membership_payment` VALUES ('1', '1', '3', '200.00', '96E516349E057930R', '2014-09-01 09:37:06');
INSERT INTO `default_membership_payment` VALUES ('2', '2', '2', '100.00', '4D679758UT4365624', '2014-09-01 11:12:14');
INSERT INTO `default_membership_payment` VALUES ('3', '5', '3', '200.00', '50868300FS6759341', '2014-09-05 12:27:23');
INSERT INTO `default_membership_payment` VALUES ('4', '6', '2', '100.00', '5JH049357V5763728', '2014-09-08 10:52:56');
INSERT INTO `default_membership_payment` VALUES ('5', '5', '5', '50.00', '9NH23705WV455492V', '2014-09-11 10:36:28');
INSERT INTO `default_membership_payment` VALUES ('6', '13', '2', '100.00', '17803416JT529303T', '2014-09-15 09:40:57');
INSERT INTO `default_membership_payment` VALUES ('7', '16', '5', '99.00', '9J507761Y4864150J', '2014-09-19 05:57:44');
INSERT INTO `default_membership_payment` VALUES ('8', '20', '5', '99.00', '82C38923Y8459480R', '2014-09-20 10:37:06');
INSERT INTO `default_membership_payment` VALUES ('9', '24', '5', '99.00', '14N956057P860572E', '2014-09-20 06:07:27');
INSERT INTO `default_membership_payment` VALUES ('10', '25', '5', '99.00', '4JJ115711V4026930', '2014-09-20 11:49:29');
INSERT INTO `default_membership_payment` VALUES ('11', '56', '5', '99.00', '3SC55601HF9895834', '2014-09-27 10:38:33');
INSERT INTO `default_membership_payment` VALUES ('12', '5', '5', '99.00', '9XF00737092225709', '2014-10-01 11:48:56');
INSERT INTO `default_membership_payment` VALUES ('13', '58', '5', '99.00', '4DT267663N615205T', '2014-10-01 12:03:45');
INSERT INTO `default_membership_payment` VALUES ('14', '5', '5', '99.00', '76N73797CP618623M', '2014-10-30 10:17:52');
INSERT INTO `default_membership_payment` VALUES ('15', '71', '5', '99.00', '9MJ87628U7277894P', '2014-10-30 12:16:30');
INSERT INTO `default_membership_payment` VALUES ('16', '5', '5', '99.00', '6RT359978K235434J', '2014-11-03 16:24:46');
INSERT INTO `default_membership_payment` VALUES ('17', '88', '5', '99.00', '1498536133116725K', '2014-11-03 13:41:30');
INSERT INTO `default_membership_payment` VALUES ('18', '5', '5', '99.00', '4C6771338R2610357', '2014-11-03 14:39:55');
INSERT INTO `default_membership_payment` VALUES ('19', '88', '5', '99.00', '2RJ76898EN009292U', '2014-11-03 14:56:24');
INSERT INTO `default_membership_payment` VALUES ('20', '92', '5', '99.00', '93H47301C1986262P', '2014-11-04 05:45:45');
INSERT INTO `default_membership_payment` VALUES ('21', '92', '5', '99.00', '06M24188AA3466151', '2014-11-04 05:50:12');
INSERT INTO `default_membership_payment` VALUES ('22', '106', '5', '99.00', '3T511625HJ483051G', '2014-11-04 14:32:16');
INSERT INTO `default_membership_payment` VALUES ('23', '5', '5', '99.00', '99T28326LE735743K', '2014-11-05 18:25:26');
INSERT INTO `default_membership_payment` VALUES ('24', '103', '5', '99.00', '6R211808U6393833K', '2014-11-06 17:44:05');
INSERT INTO `default_membership_payment` VALUES ('25', '5', '5', '99.00', '8T333911LB877601N', '2014-11-10 06:01:42');
INSERT INTO `default_membership_payment` VALUES ('26', '106', '5', '99.00', '7U358243MF770163B', '2014-11-10 06:12:41');
INSERT INTO `default_membership_payment` VALUES ('27', '106', '5', '99.00', '18X78859N65834532', '2014-11-10 06:14:48');
INSERT INTO `default_membership_payment` VALUES ('28', '106', '5', '99.00', '4X210764SG623281P', '2014-11-10 06:23:13');
INSERT INTO `default_membership_payment` VALUES ('29', '106', '5', '99.00', '85E83998K1638210P', '2014-11-10 14:05:55');
INSERT INTO `default_membership_payment` VALUES ('30', '118', '5', '99.00', '4TF06622NU099563R', '2014-11-11 20:11:12');
INSERT INTO `default_membership_payment` VALUES ('31', '56', '5', '99.00', '13A00194N60793122', '2014-11-12 10:41:26');
INSERT INTO `default_membership_payment` VALUES ('32', '5', '5', '99.00', '8DV55220H1544334Y', '2014-11-21 11:56:21');
INSERT INTO `default_membership_payment` VALUES ('33', '123', '5', '99.00', '3E611152KV776910A', '2014-11-25 12:36:33');
INSERT INTO `default_membership_payment` VALUES ('34', '127', '5', '99.00', '8YG64463SN943825D', '2014-12-02 12:41:57');
INSERT INTO `default_membership_payment` VALUES ('35', '144', '5', '99.00', '2AF44542B7139230S', '2014-12-04 14:20:44');
INSERT INTO `default_membership_payment` VALUES ('36', '142', '5', '99.00', '9AR67637MA334500R', '2014-12-04 14:26:12');
INSERT INTO `default_membership_payment` VALUES ('37', '143', '5', '99.00', '1HX47257GG783242H', '2014-12-04 20:08:24');
INSERT INTO `default_membership_payment` VALUES ('38', '146', '5', '99.00', '1YX691916R544623H', '2014-12-05 12:25:05');

-- ----------------------------
-- Table structure for `default_memberships`
-- ----------------------------
DROP TABLE IF EXISTS `default_memberships`;
CREATE TABLE `default_memberships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `membership_title` varchar(255) NOT NULL,
  `membership_price` varchar(255) NOT NULL,
  `membership_description` text NOT NULL,
  `membership_status` enum('0','1') NOT NULL DEFAULT '0',
  `membership_days` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of default_memberships
-- ----------------------------
INSERT INTO `default_memberships` VALUES ('1', 'Free Membership', '0', 'Description will come here', '0', '30', '2014-11-27 11:24:51', '2014-11-27 11:24:51');
INSERT INTO `default_memberships` VALUES ('3', 'Golden', '45', 'he minimum amount you have to maintain in your Escrow account. All affiliates\' commissions will be drawn from this escrow account..', '1', '180', '2014-11-24 12:48:15', '2014-11-24 07:08:25');
INSERT INTO `default_memberships` VALUES ('5', 'Paid Membership', '99', 'this is data for testing for details', '0', '365', '2014-11-24 12:48:56', '2014-11-24 07:09:06');

-- ----------------------------
-- Table structure for `default_merchant_banner`
-- ----------------------------
DROP TABLE IF EXISTS `default_merchant_banner`;
CREATE TABLE `default_merchant_banner` (
  `banner_id` int(11) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(11) DEFAULT NULL,
  `banner_name` tinytext NOT NULL,
  `item_id` varchar(255) DEFAULT NULL,
  `banner_price` varchar(150) DEFAULT NULL,
  `currency_type` varchar(150) DEFAULT NULL,
  `banner_postage` varchar(255) DEFAULT NULL,
  `tax_rate` varchar(150) DEFAULT NULL,
  `change_order` varchar(150) DEFAULT '0',
  `shipping_address` varchar(150) DEFAULT '0',
  `cancel_url` varchar(255) DEFAULT NULL,
  `checkout_url` varchar(255) DEFAULT NULL,
  `banner_description` text,
  `referral_point` int(11) DEFAULT NULL,
  `target_url` varchar(255) NOT NULL,
  `upload_type` int(11) DEFAULT '0',
  `image_url` varchar(255) NOT NULL,
  `upload_path` varchar(255) DEFAULT NULL,
  `upload_image_name` varchar(255) DEFAULT NULL,
  `image_type` int(11) NOT NULL DEFAULT '0',
  `image_width` int(11) DEFAULT NULL,
  `image_height` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `delete_status` int(11) DEFAULT '0',
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of default_merchant_banner
-- ----------------------------
INSERT INTO `default_merchant_banner` VALUES ('1', '56', 'iPhone', '#1', '300', 'SEK', '', '12', '1', '0', 'http://www.cdnsolutionsgroup.com/referralsystem/php/', 'www.google.com', 'With the launch of the new iPhone 5s, the most forward-thinking smartphone in the world, iPhone 5c, the most colorful iPhone yet and iOS 7, the most significant iOS update since the original iPhone, Apple is ushering in the next generation of mobile computing, delivering an incredible new hardware and software experience that only Apple could create.', '10', '', '1', 'https://www.apple.com/in/pr/products/images/iPhone6_34FR_SpGry_iPhone6plus_34FL_SpGry_Homescreen_HERO.jpg', 'assets/banner_images/', 'iPhone6_34FR_SpGry_iPhone6plus_34FL_SpGry_Homescreen_HERO.jpg', '1', '999', '50', '2014-12-12 15:54:42', '2014-12-12 10:13:46', '0');
INSERT INTO `default_merchant_banner` VALUES ('2', '56', 'I Grow Laser', '01', '695', 'USD', null, '15', '1', '1', 'http://www.cdnsolutionsgroup.com/referralsystem/php/', 'www.google.com', 'The groundbreaking iGrow Laser Hair Rejuvenation Treatment offers combination light therapy in a hair rejuvenation system. The patented design combines 21 Lasers and 30 LEDs into a single, HANDS-FREE, portable device for maximum full scalp effectiveness. The exclusive iGrow handset allows you to choose from 5 different treatment settings for a customized treatment. The innovative iGrow design incorporates an iPod/MP3 connector so you can listen to your favorite music during your convenient 20 minute treatment, 2 to 3 times a week. After 10 to 12 weeks of regular use (as directed) you can expect to see thicker, fuller, healthier hair. Continued use yields even better results.', '15', '', '0', 'http://cdnsolutionsgroup.com/inkriti_overit/overit/media/catalog/product/cache/1/image/600x/9df78eab33525d08d6e5fb8d27136e95/i/m/img5_1.jpg', null, null, '0', '999', '999', '2014-12-15 11:52:04', '2014-12-12 13:37:46', '0');
INSERT INTO `default_merchant_banner` VALUES ('3', '56', 'I Grow Laser II', '02', '695', 'USD', '', '20', '1', '1', 'www.google.com', 'www.google.com', 'The groundbreaking iGrow Laser Hair Rejuvenation Treatment offers combination light therapy in a hair rejuvenation system. The patented design combines 21 Lasers and 30 LEDs into a single, HANDS-FREE, portable device for maximum full scalp effectiveness. The exclusive iGrow handset allows you to choose from 5 different treatment settings for a customized treatment. The innovative iGrow design incorporates an iPod/MP3 connector so you can listen to your favorite music during your convenient 20 minute treatment, 2 to 3 times a week. After 10 to 12 weeks of regular use (as directed) you can expect to see thicker, fuller, healthier hair. Continued use yields even better results.', '8', '', '1', '', 'assets/banner_images/', 'img2_2.jpg', '0', '999', '999', '2014-12-12 16:02:20', '2014-12-12 16:02:20', '0');
INSERT INTO `default_merchant_banner` VALUES ('4', '5', 'Hair oil', '03', '250', 'USD', null, '10', '1', '1', 'www.google.com', 'www.google.com', 'HANDS-FREE, portable device for maximum full scalp effectiveness. The exclusive iGrow handset allows you to choose from 5 different treatment settings for a customized treatment. The innovative iGrow design incorporates an iPod/MP3 connector so you can listen to your favorite music during your convenient 20 minute treatment, 2 to 3 times a week. After 10 to 12 weeks of regular use (as directed) you can expect to see thicker, fuller, healthier hair. Continued use yields even better results.', '20', '', '0', 'http://cdnsolutionsgroup.com/inkriti_overit/overit/media/catalog/product/cache/1/thumbnail/66x/9df78eab33525d08d6e5fb8d27136e95/i/m/img1_1.jpg', null, null, '0', null, null, '2014-11-21 15:55:44', '2014-11-21 15:55:43', '0');
INSERT INTO `default_merchant_banner` VALUES ('5', '5', 'Hair   T-Strong 8 Oz', '04', '200', 'USD', '', '12', '1', '1', 'http://cdnsolutionsgroup.com/inkriti_overit/overit/hair-loss-products/t-strong-8-oz.html', 'http://www.cdnsolutionsgroup.com/referralsystem/php/', 'Designed to increase flexibility and decrease damage during styling.\n    Clinically proven to add elasticity & tensile strength.\n    Stops hair breakage in both wet combing & comb downs.\n    The comb glides through the hair, saving time while minimizing hair loss.\n    Use for hair that is normal, dry, damaged, oily and tangles easily. It\'s also great for hair that is thinning, dull and lifeless looking.', '8', '', '1', '', 'assets/banner_images/', 'img3_1.jpg', '2', '200', '100', '2014-12-03 15:21:26', '2014-12-03 15:21:26', '0');
INSERT INTO `default_merchant_banner` VALUES ('9', '123', 'test', '#101', '10', 'CAD', 'Today', '12.36', '1', '1', 'www.yahoo.com', 'www.cdnsolutionsgroup.com', 'New Banner', '10', '', '1', '', 'assets/banner_images/', 'Heribert_Smole_5MB.jpg', '1', null, null, '2014-11-28 15:19:27', '0000-00-00 00:00:00', '0');
INSERT INTO `default_merchant_banner` VALUES ('10', '127', 'Test', '#101', '20', 'AUD', 'Today', '12.36', '1', '1', 'www.google.com', 'www.yahoo.com', 'Test Test Test Test Test Test Test Test Test Test Test Test Test Test', '10', '', '1', '', 'assets/banner_images/', '2014-12-02-120329_1024x768_scrot.png', '1', null, null, '2014-12-04 15:04:08', '0000-00-00 00:00:00', '1');
INSERT INTO `default_merchant_banner` VALUES ('11', '127', 'New', '#102', '10', 'USD', 'Yesjk fjkl hkf454525555621c 24v5dfgv4df564g564vdf5bg45d4bv53d4xb64564gf4hd65gf4 65 456  5h545fg55', '12.36', '1', '1', 'www.google.com', 'www.yahoo.com', 'hJ juigh uiodhuih ui f uihiuhuisdgh oa jioj iuighauiohguiahguihuia shihg hshgaks\' apogopjiopsj j', '5', '', '0', 'http://www.brandeis.edu/communications/media/images/buildings/scicenter-240dpi.jpg', '', '', '0', null, null, '2014-12-04 15:02:43', '2014-12-04 15:02:43', '0');
INSERT INTO `default_merchant_banner` VALUES ('12', '127', 'Natural scenery of highdefinition picture', '#1122-A', '1000', 'GBP', '', '10', '1', '0', 'http://wwww.example.com/cancel', 'http://wwww.example.com/success', 'Natural beauty of high-quality pictures, natural scenery, landscapes, scenery, clouds, pyramid, desert, camels, characters, highways, roads, forest paths, sunset, sunrise and the sunset, blue sky, the sky, sun, mountains, meadows, roads, rocks, Dream, a vast, natural landscape, natural landscape', '15', '', '0', 'http://images.all-free-download.com/images/graphiclarge/natural_scenery_of_highdefinition_picture_166073.jpg', '', '', '0', '120', '100', '2014-12-04 15:18:04', '2014-12-04 15:18:04', '0');
INSERT INTO `default_merchant_banner` VALUES ('13', '127', 'HP Pavilion 11-n016tu x360', '#10A', '150', 'AUD', '', '10', '1', '1', 'http://wwww.example.com/cancel', 'http://wwww.example.com/success', 'The HP Pavilion 11-n016tu x360 is a convertible laptop with a touchscreen that can fold around and lie flat..', '15', '', '0', 'http://c271790.r90.cf1.rackcdn.com/162273.jpg', '', '', '0', '120', '100', '2014-12-04 15:17:14', '2014-12-04 15:17:14', '0');
INSERT INTO `default_merchant_banner` VALUES ('14', '127', 'Stanley Park Vancouver wallpaper', '#12', '10', 'USD', '', '10', '0', '0', 'http://wwww.example.com/cancel', 'http://wwww.example.com/success', 'Gorgeous Rooms and Waterfront Views Central Vancouver Location', '10', '', '0', 'http://static.hdw.eweb4.com/media/thumbs/1/87/867380.jpg', '', '', '0', '100', '100', '2014-12-04 15:17:37', '2014-12-04 15:17:37', '0');
INSERT INTO `default_merchant_banner` VALUES ('15', '127', 'Acer Aspire E1-570 NX.MEPSI.001', '#13A', '200', 'AUD', '', '10', '1', '1', 'http://wwww.example.com/cancel', 'http://wwww.example.com/success', 'The detailed features and larger Need help choosing your next laptop? Click here to see all laptops and use the filters to help narrow down your search.', '15', '', '0', 'http://static.acer.com/up/Resource/Acer/Home/20140919/Find_your_Laptop_Aspire_Switch_10.png', '', '', '2', '120', '100', '2014-12-04 15:09:56', '0000-00-00 00:00:00', '0');
INSERT INTO `default_merchant_banner` VALUES ('16', '127', 'Acer Aspire E1-570 NX.MEPSI.001', '#14A', '60', 'DKK', '', '10', '0', '0', 'http://wwww.example.com/cancel', 'http://wwww.example.com/success', 'Foxconn General Manager for Innovation Digital System Business Group (iDSBG) Young Liu showcasing an Intel-powered Foxconn tablet alongside James.', '11', '', '0', 'http://drop.ndtv.com/albums/GADGETS/intel_at_computex_2014/intel_keynote_computex_2014_and_overclocking_event_young_liu_with_renee_james_ndtv.jpg', '', '', '2', '120', '100', '2014-12-04 15:09:56', '0000-00-00 00:00:00', '0');
INSERT INTO `default_merchant_banner` VALUES ('17', '127', 'New', '#102', '10', 'USD', 'Yesjk fjkl hkf454525555621c 24v5dfgv4df564g564vdf5bg45d4bv53d4xb64564gf4hd65gf4 65 456  5h545fg55', '12.36', '1', '1', 'www.google.com', 'www.yahoo.com', 'hJ juigh uiodhuih ui f uihiuhuisdgh oa jioj iuighauiohguiahguihuia shihg hshgaks\' apogopjiopsj j', '5', '', '0', 'http://www.brandeis.edu/communications/media/images/buildings/scicenter-240dpi.jpg', '', '', '0', null, null, '2014-12-04 15:10:19', '0000-00-00 00:00:00', '0');
INSERT INTO `default_merchant_banner` VALUES ('18', '146', 'Nature', '#101', '10', 'USD', 'Today', '12.36', '1', '1', 'www.google.com', 'www.yahoo.com', 'This is the beautiful nature pic.............', '5', '', '0', 'http://www.logcollectionhotels.co.za/press/graywoodsignature_big.jpg', '', 'path_landscape-wide.jpg', '0', null, null, '2014-12-05 19:22:23', '2014-12-05 13:41:53', '0');
INSERT INTO `default_merchant_banner` VALUES ('19', '146', 'Natural scenery of highdefinition picture', '#1122-A', '1000', 'GBP', '', '10', '1', '0', 'http://wwww.example.com/cancel', 'http://wwww.example.com/success', 'Natural beauty of high-quality pictures, natural scenery, landscapes, scenery, clouds, pyramid, desert, camels, characters, highways, roads, forest paths, sunset, sunrise and the sunset, blue sky, the sky, sun, mountains, meadows, roads, rocks, Dream, a vast, natural landscape, natural landscape', '15', '', '0', 'http://images.all-free-download.com/images/graphiclarge/natural_scenery_of_highdefinition_picture_166073.jpg', '', '', '2', '120', '100', '2014-12-05 11:51:41', '0000-00-00 00:00:00', '0');
INSERT INTO `default_merchant_banner` VALUES ('20', '146', 'HP Pavilion 11-n016tu x360', '#10A', '150', 'AUD', '', '10', '1', '1', 'http://wwww.example.com/cancel', 'http://wwww.example.com/success', 'The HP Pavilion 11-n016tu x360 is a convertible laptop with a touchscreen that can fold around and lie flat..', '15', '', '0', 'http://c271790.r90.cf1.rackcdn.com/162273.jpg', '', '', '2', '120', '100', '2014-12-05 11:51:41', '0000-00-00 00:00:00', '0');
INSERT INTO `default_merchant_banner` VALUES ('21', '146', 'Stanley Park Vancouver wallpaper', '#12', '10', 'USD', '', '10', '0', '0', 'http://wwww.example.com/cancel', 'http://wwww.example.com/success', 'Gorgeous Rooms and Waterfront Views Central Vancouver Location', '10', '', '0', 'http://static.hdw.eweb4.com/media/thumbs/1/87/867380.jpg', '', '', '2', '100', '100', '2014-12-05 11:51:41', '0000-00-00 00:00:00', '0');
INSERT INTO `default_merchant_banner` VALUES ('22', '146', 'Acer Aspire E1-570 NX.MEPSI.001', '#13A', '200', 'AUD', '', '10', '1', '1', 'http://wwww.example.com/cancel', 'http://wwww.example.com/success', 'The detailed features and larger Need help choosing your next laptop? Click here to see all laptops and use the filters to help narrow down your search.', '15', '', '0', 'http://static.acer.com/up/Resource/Acer/Home/20140919/Find_your_Laptop_Aspire_Switch_10.png', '', '', '2', '120', '100', '2014-12-05 11:51:41', '0000-00-00 00:00:00', '0');
INSERT INTO `default_merchant_banner` VALUES ('23', '146', 'Acer Aspire E1-570 NX.MEPSI.001', '#14A', '60', 'DKK', '', '10', '0', '0', 'http://wwww.example.com/cancel', 'http://wwww.example.com/success', 'Foxconn General Manager for Innovation Digital System Business Group (iDSBG) Young Liu showcasing an Intel-powered Foxconn tablet alongside James.', '11', '', '0', 'http://drop.ndtv.com/albums/GADGETS/intel_at_computex_2014/intel_keynote_computex_2014_and_overclocking_event_young_liu_with_renee_james_ndtv.jpg', '', '', '2', '120', '100', '2014-12-05 11:51:41', '0000-00-00 00:00:00', '0');
INSERT INTO `default_merchant_banner` VALUES ('24', '146', 'New', '#102', '10', 'USD', 'Yesjk fjkl hkf454525555621c 24v5dfgv4df564g564vdf5bg45d4bv53d4xb64564gf4hd65gf4 65 456  5h545fg55', '12.36', '1', '1', 'www.google.com', 'www.yahoo.com', 'hJ juigh uiodhuih ui f uihiuhuisdgh oa jioj iuighauiohguiahguihuia shihg hshgaks\' apogopjiopsj j', '5', '', '0', 'http://www.brandeis.edu/communications/media/images/buildings/scicenter-240dpi.jpg', '', '', '0', null, null, '2014-12-05 11:52:17', '0000-00-00 00:00:00', '0');
INSERT INTO `default_merchant_banner` VALUES ('25', '146', 'Natural scenery of highdefinition picture', '#1122-A', '1000', 'GBP', '', '10', '1', '0', 'http://wwww.example.com/cancel', 'http://wwww.example.com/success', 'Natural beauty of high-quality pictures, natural scenery, landscapes, scenery, clouds, pyramid, desert, camels, characters, highways, roads, forest paths, sunset, sunrise and the sunset, blue sky, the sky, sun, mountains, meadows, roads, rocks, Dream, a vast, natural landscape, natural landscape', '15', '', '0', 'http://images.all-free-download.com/images/graphiclarge/natural_scenery_of_highdefinition_picture_166073.jpg', '', '', '2', '120', '100', '2014-12-05 11:52:39', '0000-00-00 00:00:00', '0');
INSERT INTO `default_merchant_banner` VALUES ('26', '146', 'HP Pavilion 11-n016tu x360', '#10A', '150', 'AUD', '', '10', '1', '1', 'http://wwww.example.com/cancel', 'http://wwww.example.com/success', 'The HP Pavilion 11-n016tu x360 is a convertible laptop with a touchscreen that can fold around and lie flat..', '15', '', '0', 'http://c271790.r90.cf1.rackcdn.com/162273.jpg', '', '', '0', '120', '100', '2014-12-05 12:14:13', '2014-12-05 12:14:13', '0');
INSERT INTO `default_merchant_banner` VALUES ('27', '146', 'Stanley Park Vancouver wallpaper', '#12', '10', 'USD', '', '10', '0', '0', 'http://wwww.example.com/cancel', 'http://wwww.example.com/success', 'Gorgeous Rooms and Waterfront Views Central Vancouver Location', '10', '', '0', 'http://static.hdw.eweb4.com/media/thumbs/1/87/867380.jpg', '', '', '2', '100', '100', '2014-12-05 11:52:39', '0000-00-00 00:00:00', '0');
INSERT INTO `default_merchant_banner` VALUES ('28', '146', 'Acer Aspire E1-570 NX.MEPSI.001', '#13A', '200', 'AUD', '', '10', '1', '1', 'http://wwww.example.com/cancel', 'http://wwww.example.com/success', 'The detailed features and larger Need help choosing your next laptop? Click here to see all laptops and use the filters to help narrow down your search.', '15', '', '0', 'http://static.acer.com/up/Resource/Acer/Home/20140919/Find_your_Laptop_Aspire_Switch_10.png', '', '', '2', '120', '100', '2014-12-05 11:52:39', '0000-00-00 00:00:00', '0');
INSERT INTO `default_merchant_banner` VALUES ('29', '146', 'Acer Aspire E1-570 NX.MEPSI.001', '#14A', '60', 'DKK', '', '10', '0', '0', 'http://wwww.example.com/cancel', 'http://wwww.example.com/success', 'Foxconn General Manager for Innovation Digital System Business Group (iDSBG) Young Liu showcasing an Intel-powered Foxconn tablet alongside James.', '11', '', '0', 'http://drop.ndtv.com/albums/GADGETS/intel_at_computex_2014/intel_keynote_computex_2014_and_overclocking_event_young_liu_with_renee_james_ndtv.jpg', '', '', '2', '120', '100', '2014-12-05 11:52:39', '0000-00-00 00:00:00', '0');
INSERT INTO `default_merchant_banner` VALUES ('35', '152', 'vfsda', '#101', '10', 'USD', 'fadf', '12.36', '1', '1', 'www.cdnsol.com', 'www.google.com', 'fsdfvg', '5', '', '1', '', 'assets/banner_images/', 'download.jpg', '2', '100', '100', '2014-12-11 19:18:01', '0000-00-00 00:00:00', '0');
INSERT INTO `default_merchant_banner` VALUES ('36', '154', 'vfsda', '26', '23', 'PHP', 'fadf', '12.36', '1', '1', 'www.cdnsol.com', 'www.google.com', 'grgt', '5', '', '1', '', 'assets/banner_images/', 'download.jpg', '1', '999', '999', '2014-12-12 16:04:10', '2014-12-12 16:04:10', '0');
INSERT INTO `default_merchant_banner` VALUES ('37', '154', 'hdfgh', '#101', '20', 'USD', 'Today', '12.36', '1', '1', 'www.cdnsol.com', 'www.google.com', 'gdsgd', '5', '', '0', 'http://cybercapetown.com/KnysnaLogInn/images/newelcome-01.jpg', '', 'Fifa.jpg', '1', null, null, '2014-12-12 16:06:29', '2014-12-12 16:06:29', '0');

-- ----------------------------
-- Table structure for `default_merchant_configuration`
-- ----------------------------
DROP TABLE IF EXISTS `default_merchant_configuration`;
CREATE TABLE `default_merchant_configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `product_commission` varchar(255) DEFAULT NULL,
  `currency_type` varchar(255) DEFAULT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `paypal_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of default_merchant_configuration
-- ----------------------------
INSERT INTO `default_merchant_configuration` VALUES ('1', '1', 'rajendra  patidar', null, null, 'http://localhost/referralsystem/php/merchant/configuration', 'amitwali@cdnsol.com', '2014-09-13 05:21:38');
INSERT INTO `default_merchant_configuration` VALUES ('4', '5', 'rajendra patidar', '10', 'USD', 'www.google.com', 'patidar@cdnsol.com', '2014-12-03 15:53:53');
INSERT INTO `default_merchant_configuration` VALUES ('5', '2', 'tester', '20', null, 'http://localhost/referralsystem/php/merchant/configuration', 'amitwali@cdnsol.com', '2014-09-16 14:00:42');
INSERT INTO `default_merchant_configuration` VALUES ('6', '71', null, null, null, null, 'amitwali@cdnsol.com', '2014-10-30 12:44:10');
INSERT INTO `default_merchant_configuration` VALUES ('7', '103', null, null, null, null, 'amitwali@cdnsol.com', '2014-11-10 15:10:53');
INSERT INTO `default_merchant_configuration` VALUES ('8', '56', null, null, null, null, 'patidar@cdnsol.com', '2014-12-11 11:22:39');
INSERT INTO `default_merchant_configuration` VALUES ('9', '123', null, null, null, null, 'amitwali@cdnsol.com', '2014-11-25 13:09:42');
INSERT INTO `default_merchant_configuration` VALUES ('10', '127', null, null, null, null, 'rajendrapatidar@cdnsol.com', '2014-12-02 13:17:46');
INSERT INTO `default_merchant_configuration` VALUES ('11', '143', null, null, null, null, 'rajendrapatidar@cdnsol.com', '2014-12-04 20:00:45');
INSERT INTO `default_merchant_configuration` VALUES ('12', '146', null, null, null, null, 'rajendrapatidar@cdnsol.com', '2014-12-05 12:21:52');
INSERT INTO `default_merchant_configuration` VALUES ('13', '154', null, null, null, null, 'rajendrapatidar@cdnsol.com', '2014-12-12 12:45:09');

-- ----------------------------
-- Table structure for `default_merchant_feedback`
-- ----------------------------
DROP TABLE IF EXISTS `default_merchant_feedback`;
CREATE TABLE `default_merchant_feedback` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `merchant_id` int(11) DEFAULT NULL,
  `affiliate_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of default_merchant_feedback
-- ----------------------------
INSERT INTO `default_merchant_feedback` VALUES ('28', '56', '55', 'Early verdict', 'The iPhone 6 is a really rather good handset indeed. While I can\'t bring myself to say \'it\'s the best iPhone ever made\' again (it is, but I promised I wouldn\'t write that again after saying the same thing for three reviews in a row), in the pantheon of Apple handsets the iPhone 6 will go down as a pivotal moment.', '2014-11-21 12:56:55');
INSERT INTO `default_merchant_feedback` VALUES ('29', '5', '55', 'Iphone 5', '1. If you are Email users for your Official use.. you CANNOT send any attachments in your mail. To do So you have to download DropBox and 1 more application. For a All that the New app does is send a link of the Dropbox where your Files resides. For Simple task of attachments.. Apple wants to restrict what you CAN do and CANNOT Do.\n2. CALL LOG - The SO CALLED highend SMART phone CANNOT store call logs more than 100 call logs. If you call a Contact for 10 times in day.. and if you are heavy phone user.. you log details will be lost in a DAY or 2. SUCH A PRIMITIVE STORAGE CAPACITY..WHATS THE USE OF THE 16/32/64 GB STORAGE.\nUnquote', '2014-11-24 08:03:14');
INSERT INTO `default_merchant_feedback` VALUES ('34', '5', '55', 'iphone 6', 'awesome work done!', '2014-12-03 15:27:13');
INSERT INTO `default_merchant_feedback` VALUES ('35', '127', '126', 'uighuifgasuig', 'hjiohfioghsjklghiohagjosklh', '2014-12-04 13:37:12');
INSERT INTO `default_merchant_feedback` VALUES ('37', '146', '147', 'sdf', 'sdvgfsvs', '2014-12-05 12:23:58');
INSERT INTO `default_merchant_feedback` VALUES ('38', '56', '55', 'My feedback', 'The iPhone 6 is a really rather good handset indeed. While I can\'t bring myself to say \'it\'s the best iPhone ever made\' again (it is, but I promised I wouldn\'t', '2014-12-11 11:23:11');

-- ----------------------------
-- Table structure for `default_migrations`
-- ----------------------------
DROP TABLE IF EXISTS `default_migrations`;
CREATE TABLE `default_migrations` (
  `version` int(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_migrations
-- ----------------------------
INSERT INTO `default_migrations` VALUES ('129');

-- ----------------------------
-- Table structure for `default_modules`
-- ----------------------------
DROP TABLE IF EXISTS `default_modules`;
CREATE TABLE `default_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `skip_xss` tinyint(1) NOT NULL,
  `is_frontend` tinyint(1) NOT NULL,
  `is_backend` tinyint(1) NOT NULL,
  `menu` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `installed` tinyint(1) NOT NULL,
  `is_core` tinyint(1) NOT NULL,
  `updated_on` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `enabled` (`enabled`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_modules
-- ----------------------------
INSERT INTO `default_modules` VALUES ('1', 'a:25:{s:2:\"en\";s:8:\"Settings\";s:2:\"ar\";s:18:\"الإعدادات\";s:2:\"br\";s:15:\"Configurações\";s:2:\"pt\";s:15:\"Configurações\";s:2:\"cs\";s:10:\"Nastavení\";s:2:\"da\";s:13:\"Indstillinger\";s:2:\"de\";s:13:\"Einstellungen\";s:2:\"el\";s:18:\"Ρυθμίσεις\";s:2:\"es\";s:15:\"Configuraciones\";s:2:\"fa\";s:14:\"تنظیمات\";s:2:\"fi\";s:9:\"Asetukset\";s:2:\"fr\";s:11:\"Paramètres\";s:2:\"he\";s:12:\"הגדרות\";s:2:\"id\";s:10:\"Pengaturan\";s:2:\"it\";s:12:\"Impostazioni\";s:2:\"lt\";s:10:\"Nustatymai\";s:2:\"nl\";s:12:\"Instellingen\";s:2:\"pl\";s:10:\"Ustawienia\";s:2:\"ru\";s:18:\"Настройки\";s:2:\"sl\";s:10:\"Nastavitve\";s:2:\"tw\";s:12:\"網站設定\";s:2:\"cn\";s:12:\"网站设定\";s:2:\"hu\";s:14:\"Beállítások\";s:2:\"th\";s:21:\"ตั้งค่า\";s:2:\"se\";s:14:\"Inställningar\";}', 'settings', '1.0.0', null, 'a:25:{s:2:\"en\";s:89:\"Allows administrators to update settings like Site Name, messages and email address, etc.\";s:2:\"ar\";s:161:\"تمكن المدراء من تحديث الإعدادات كإسم الموقع، والرسائل وعناوين البريد الإلكتروني، .. إلخ.\";s:2:\"br\";s:120:\"Permite com que administradores e a equipe consigam trocar as configurações do website incluindo o nome e descrição.\";s:2:\"pt\";s:113:\"Permite com que os administradores consigam alterar as configurações do website incluindo o nome e descrição.\";s:2:\"cs\";s:102:\"Umožňuje administrátorům měnit nastavení webu jako jeho jméno, zprávy a emailovou adresu apod.\";s:2:\"da\";s:90:\"Lader administratorer opdatere indstillinger som sidenavn, beskeder og email adresse, etc.\";s:2:\"de\";s:92:\"Erlaubt es Administratoren die Einstellungen der Seite wie Name und Beschreibung zu ändern.\";s:2:\"el\";s:230:\"Επιτρέπει στους διαχειριστές να τροποποιήσουν ρυθμίσεις όπως το Όνομα του Ιστοτόπου, τα μηνύματα και τις διευθύνσεις email, κ.α.\";s:2:\"es\";s:131:\"Permite a los administradores y al personal configurar los detalles del sitio como el nombre del sitio y la descripción del mismo.\";s:2:\"fa\";s:105:\"تنظیمات سایت در این ماژول توسط ادمین هاس سایت انجام می شود\";s:2:\"fi\";s:105:\"Mahdollistaa sivuston asetusten muokkaamisen, kuten sivuston nimen, viestit ja sähköpostiosoitteet yms.\";s:2:\"fr\";s:118:\"Permet aux admistrateurs de modifier les paramètres du site : nom du site, description, messages, adresse email, etc.\";s:2:\"he\";s:116:\"ניהול הגדרות שונות של האתר כגון: שם האתר, הודעות, כתובות דואר וכו\";s:2:\"id\";s:112:\"Memungkinkan administrator untuk dapat memperbaharui pengaturan seperti nama situs, pesan dan alamat email, dsb.\";s:2:\"it\";s:109:\"Permette agli amministratori di aggiornare impostazioni quali Nome del Sito, messaggi e indirizzo email, etc.\";s:2:\"lt\";s:104:\"Leidžia administratoriams keisti puslapio vavadinimą, žinutes, administratoriaus el. pašta ir kitą.\";s:2:\"nl\";s:114:\"Maakt het administratoren en medewerkers mogelijk om websiteinstellingen zoals naam en beschrijving te veranderen.\";s:2:\"pl\";s:103:\"Umożliwia administratorom zmianę ustawień strony jak nazwa strony, opis, e-mail administratora, itd.\";s:2:\"ru\";s:135:\"Управление настройками сайта - Имя сайта, сообщения, почтовые адреса и т.п.\";s:2:\"sl\";s:98:\"Dovoljuje administratorjem posodobitev nastavitev kot je Ime strani, sporočil, email naslova itd.\";s:2:\"tw\";s:99:\"網站管理者可更新的重要網站設定。例如：網站名稱、訊息、電子郵件等。\";s:2:\"cn\";s:99:\"网站管理者可更新的重要网站设定。例如：网站名称、讯息、电子邮件等。\";s:2:\"hu\";s:125:\"Lehetővé teszi az adminok számára a beállítások frissítését, mint a weboldal neve, üzenetek, e-mail címek, stb...\";s:2:\"th\";s:232:\"ให้ผู้ดูแลระบบสามารถปรับปรุงการตั้งค่าเช่นชื่อเว็บไซต์ ข้อความและอีเมล์เป็นต้น\";s:2:\"se\";s:84:\"Administratören kan uppdatera webbplatsens titel, meddelanden och E-postadress etc.\";}', '1', '0', '1', 'settings', '1', '1', '1', '1415789905');
INSERT INTO `default_modules` VALUES ('2', 'a:11:{s:2:\"en\";s:12:\"Streams Core\";s:2:\"pt\";s:14:\"Núcleo Fluxos\";s:2:\"fr\";s:10:\"Noyau Flux\";s:2:\"el\";s:23:\"Πυρήνας Ροών\";s:2:\"se\";s:18:\"Streams grundmodul\";s:2:\"tw\";s:14:\"Streams 核心\";s:2:\"cn\";s:14:\"Streams 核心\";s:2:\"ar\";s:31:\"الجداول الأساسية\";s:2:\"it\";s:12:\"Streams Core\";s:2:\"fa\";s:26:\"هسته استریم ها\";s:2:\"fi\";s:13:\"Striimit ydin\";}', 'streams_core', '1.0.0', null, 'a:11:{s:2:\"en\";s:29:\"Core data module for streams.\";s:2:\"pt\";s:37:\"Módulo central de dados para fluxos.\";s:2:\"fr\";s:32:\"Noyau de données pour les Flux.\";s:2:\"el\";s:113:\"Προγραμματιστικός πυρήνας για την λειτουργία ροών δεδομένων.\";s:2:\"se\";s:50:\"Streams grundmodul för enklare hantering av data.\";s:2:\"tw\";s:29:\"Streams 核心資料模組。\";s:2:\"cn\";s:29:\"Streams 核心资料模组。\";s:2:\"ar\";s:57:\"وحدة البيانات الأساسية للجداول\";s:2:\"it\";s:17:\"Core dello Stream\";s:2:\"fa\";s:48:\"ماژول مرکزی برای استریم ها\";s:2:\"fi\";s:48:\"Ydin datan hallinoiva moduuli striimejä varten.\";}', '1', '0', '0', '0', '1', '1', '1', '1414575736');
INSERT INTO `default_modules` VALUES ('3', 'a:21:{s:2:\"en\";s:15:\"Email Templates\";s:2:\"ar\";s:48:\"قوالب الرسائل الإلكترونية\";s:2:\"br\";s:17:\"Modelos de e-mail\";s:2:\"pt\";s:17:\"Modelos de e-mail\";s:2:\"da\";s:16:\"Email skabeloner\";s:2:\"el\";s:22:\"Δυναμικά email\";s:2:\"es\";s:19:\"Plantillas de email\";s:2:\"fa\";s:26:\"قالب های ایمیل\";s:2:\"fr\";s:17:\"Modèles d\'emails\";s:2:\"he\";s:12:\"תבניות\";s:2:\"id\";s:14:\"Template Email\";s:2:\"lt\";s:22:\"El. laiškų šablonai\";s:2:\"nl\";s:15:\"Email sjablonen\";s:2:\"ru\";s:25:\"Шаблоны почты\";s:2:\"sl\";s:14:\"Email predloge\";s:2:\"tw\";s:12:\"郵件範本\";s:2:\"cn\";s:12:\"邮件范本\";s:2:\"hu\";s:15:\"E-mail sablonok\";s:2:\"fi\";s:25:\"Sähköposti viestipohjat\";s:2:\"th\";s:33:\"แม่แบบอีเมล\";s:2:\"se\";s:12:\"E-postmallar\";}', 'templates', '1.1.0', null, 'a:21:{s:2:\"en\";s:46:\"Create, edit, and save dynamic email templates\";s:2:\"ar\";s:97:\"أنشئ، عدّل واحفظ قوالب البريد الإلكترني الديناميكية.\";s:2:\"br\";s:51:\"Criar, editar e salvar modelos de e-mail dinâmicos\";s:2:\"pt\";s:51:\"Criar, editar e salvar modelos de e-mail dinâmicos\";s:2:\"da\";s:49:\"Opret, redigér og gem dynamiske emailskabeloner.\";s:2:\"el\";s:108:\"Δημιουργήστε, επεξεργαστείτε και αποθηκεύστε δυναμικά email.\";s:2:\"es\";s:54:\"Crear, editar y guardar plantillas de email dinámicas\";s:2:\"fa\";s:92:\"ایحاد، ویرایش و ذخیره ی قالب های ایمیل به صورت پویا\";s:2:\"fr\";s:61:\"Créer, éditer et sauver dynamiquement des modèles d\'emails\";s:2:\"he\";s:54:\"ניהול של תבניות דואר אלקטרוני\";s:2:\"id\";s:55:\"Membuat, mengedit, dan menyimpan template email dinamis\";s:2:\"lt\";s:58:\"Kurk, tvarkyk ir saugok dinaminius el. laiškų šablonus.\";s:2:\"nl\";s:49:\"Maak, bewerk, en beheer dynamische emailsjablonen\";s:2:\"ru\";s:127:\"Создавайте, редактируйте и сохраняйте динамические почтовые шаблоны\";s:2:\"sl\";s:52:\"Ustvari, uredi in shrani spremenljive email predloge\";s:2:\"tw\";s:61:\"新增、編輯與儲存可顯示動態資料的 email 範本\";s:2:\"cn\";s:61:\"新增、编辑与储存可显示动态资料的 email 范本\";s:2:\"hu\";s:63:\"Csináld, szerkeszd és mentsd el a dinamikus e-mail sablonokat\";s:2:\"fi\";s:66:\"Lisää, muokkaa ja tallenna dynaamisia sähköposti viestipohjia.\";s:2:\"th\";s:129:\"การสร้างแก้ไขและบันทึกแม่แบบอีเมลแบบไดนามิก\";s:2:\"se\";s:49:\"Skapa, redigera och spara dynamiska E-postmallar.\";}', '1', '0', '1', 'structure', '0', '1', '1', '1414575736');
INSERT INTO `default_modules` VALUES ('4', 'a:25:{s:2:\"en\";s:7:\"Add-ons\";s:2:\"ar\";s:16:\"الإضافات\";s:2:\"br\";s:12:\"Complementos\";s:2:\"pt\";s:12:\"Complementos\";s:2:\"cs\";s:8:\"Doplňky\";s:2:\"da\";s:7:\"Add-ons\";s:2:\"de\";s:13:\"Erweiterungen\";s:2:\"el\";s:16:\"Πρόσθετα\";s:2:\"es\";s:9:\"Agregados\";s:2:\"fa\";s:17:\"افزونه ها\";s:2:\"fi\";s:9:\"Lisäosat\";s:2:\"fr\";s:10:\"Extensions\";s:2:\"he\";s:12:\"תוספות\";s:2:\"id\";s:7:\"Pengaya\";s:2:\"it\";s:7:\"Add-ons\";s:2:\"lt\";s:7:\"Priedai\";s:2:\"nl\";s:7:\"Add-ons\";s:2:\"pl\";s:12:\"Rozszerzenia\";s:2:\"ru\";s:20:\"Дополнения\";s:2:\"sl\";s:11:\"Razširitve\";s:2:\"tw\";s:12:\"附加模組\";s:2:\"cn\";s:12:\"附加模组\";s:2:\"hu\";s:14:\"Bővítmények\";s:2:\"th\";s:27:\"ส่วนเสริม\";s:2:\"se\";s:8:\"Tillägg\";}', 'addons', '2.0.0', null, 'a:25:{s:2:\"en\";s:59:\"Allows admins to see a list of currently installed modules.\";s:2:\"ar\";s:91:\"تُمكّن المُدراء من معاينة جميع الوحدات المُثبّتة.\";s:2:\"br\";s:75:\"Permite aos administradores ver a lista dos módulos instalados atualmente.\";s:2:\"pt\";s:75:\"Permite aos administradores ver a lista dos módulos instalados atualmente.\";s:2:\"cs\";s:68:\"Umožňuje administrátorům vidět seznam nainstalovaných modulů.\";s:2:\"da\";s:63:\"Lader administratorer se en liste over de installerede moduler.\";s:2:\"de\";s:56:\"Zeigt Administratoren alle aktuell installierten Module.\";s:2:\"el\";s:152:\"Επιτρέπει στους διαχειριστές να προβάλουν μια λίστα των εγκατεστημένων πρόσθετων.\";s:2:\"es\";s:71:\"Permite a los administradores ver una lista de los módulos instalados.\";s:2:\"fa\";s:93:\"مشاهده لیست افزونه ها و مدیریت آنها برای ادمین سایت\";s:2:\"fi\";s:60:\"Listaa järjestelmänvalvojalle käytössä olevat moduulit.\";s:2:\"fr\";s:66:\"Permet aux administrateurs de voir la liste des modules installés\";s:2:\"he\";s:160:\"נותן אופציה למנהל לראות רשימה של המודולים אשר מותקנים כעת באתר או להתקין מודולים נוספים\";s:2:\"id\";s:57:\"Memperlihatkan kepada admin daftar modul yang terinstall.\";s:2:\"it\";s:83:\"Permette agli amministratori di vedere una lista dei moduli attualmente installati.\";s:2:\"lt\";s:75:\"Vartotojai ir svečiai gali komentuoti jūsų naujienas, puslapius ar foto.\";s:2:\"nl\";s:79:\"Stelt admins in staat om een overzicht van geinstalleerde modules te genereren.\";s:2:\"pl\";s:81:\"Umożliwiają administratorowi wgląd do listy obecnie zainstalowanych modułów.\";s:2:\"ru\";s:83:\"Список модулей, которые установлены на сайте.\";s:2:\"sl\";s:65:\"Dovoljuje administratorjem pregled trenutno nameščenih modulov.\";s:2:\"tw\";s:54:\"管理員可以檢視目前已經安裝模組的列表\";s:2:\"cn\";s:54:\"管理员可以检视目前已经安装模组的列表\";s:2:\"hu\";s:79:\"Lehetővé teszi az adminoknak, hogy lássák a telepített modulok listáját.\";s:2:\"th\";s:162:\"ช่วยให้ผู้ดูแลระบบดูรายการของโมดูลที่ติดตั้งในปัจจุบัน\";s:2:\"se\";s:67:\"Gör det möjligt för administratören att se installerade mouler.\";}', '0', '0', '1', '0', '1', '1', '1', '1415873891');
INSERT INTO `default_modules` VALUES ('5', 'a:17:{s:2:\"en\";s:4:\"Blog\";s:2:\"ar\";s:16:\"المدوّنة\";s:2:\"br\";s:4:\"Blog\";s:2:\"pt\";s:4:\"Blog\";s:2:\"el\";s:18:\"Ιστολόγιο\";s:2:\"fa\";s:8:\"بلاگ\";s:2:\"he\";s:8:\"בלוג\";s:2:\"id\";s:4:\"Blog\";s:2:\"lt\";s:6:\"Blogas\";s:2:\"pl\";s:4:\"Blog\";s:2:\"ru\";s:8:\"Блог\";s:2:\"tw\";s:6:\"文章\";s:2:\"cn\";s:6:\"文章\";s:2:\"hu\";s:4:\"Blog\";s:2:\"fi\";s:5:\"Blogi\";s:2:\"th\";s:15:\"บล็อก\";s:2:\"se\";s:5:\"Blogg\";}', 'blog', '2.0.0', null, 'a:25:{s:2:\"en\";s:18:\"Post blog entries.\";s:2:\"ar\";s:48:\"أنشر المقالات على مدوّنتك.\";s:2:\"br\";s:30:\"Escrever publicações de blog\";s:2:\"pt\";s:39:\"Escrever e editar publicações no blog\";s:2:\"cs\";s:49:\"Publikujte nové články a příspěvky na blog.\";s:2:\"da\";s:17:\"Skriv blogindlæg\";s:2:\"de\";s:47:\"Veröffentliche neue Artikel und Blog-Einträge\";s:2:\"sl\";s:23:\"Objavite blog prispevke\";s:2:\"fi\";s:28:\"Kirjoita blogi artikkeleita.\";s:2:\"el\";s:93:\"Δημιουργήστε άρθρα και εγγραφές στο ιστολόγιο σας.\";s:2:\"es\";s:54:\"Escribe entradas para los artículos y blog (web log).\";s:2:\"fa\";s:44:\"مقالات منتشر شده در بلاگ\";s:2:\"fr\";s:34:\"Poster des articles d\'actualités.\";s:2:\"he\";s:19:\"ניהול בלוג\";s:2:\"id\";s:15:\"Post entri blog\";s:2:\"it\";s:36:\"Pubblica notizie e post per il blog.\";s:2:\"lt\";s:40:\"Rašykite naujienas bei blog\'o įrašus.\";s:2:\"nl\";s:41:\"Post nieuwsartikelen en blogs op uw site.\";s:2:\"pl\";s:27:\"Dodawaj nowe wpisy na blogu\";s:2:\"ru\";s:49:\"Управление записями блога.\";s:2:\"tw\";s:42:\"發表新聞訊息、部落格等文章。\";s:2:\"cn\";s:42:\"发表新闻讯息、部落格等文章。\";s:2:\"th\";s:48:\"โพสต์รายการบล็อก\";s:2:\"hu\";s:32:\"Blog bejegyzések létrehozása.\";s:2:\"se\";s:18:\"Inlägg i bloggen.\";}', '1', '1', '1', 'content', '0', '1', '1', '1414575736');
INSERT INTO `default_modules` VALUES ('6', 'a:25:{s:2:\"en\";s:8:\"Comments\";s:2:\"ar\";s:18:\"التعليقات\";s:2:\"br\";s:12:\"Comentários\";s:2:\"pt\";s:12:\"Comentários\";s:2:\"cs\";s:11:\"Komentáře\";s:2:\"da\";s:11:\"Kommentarer\";s:2:\"de\";s:10:\"Kommentare\";s:2:\"el\";s:12:\"Σχόλια\";s:2:\"es\";s:11:\"Comentarios\";s:2:\"fi\";s:9:\"Kommentit\";s:2:\"fr\";s:12:\"Commentaires\";s:2:\"fa\";s:10:\"نظرات\";s:2:\"he\";s:12:\"תגובות\";s:2:\"id\";s:8:\"Komentar\";s:2:\"it\";s:8:\"Commenti\";s:2:\"lt\";s:10:\"Komentarai\";s:2:\"nl\";s:8:\"Reacties\";s:2:\"pl\";s:10:\"Komentarze\";s:2:\"ru\";s:22:\"Комментарии\";s:2:\"sl\";s:10:\"Komentarji\";s:2:\"tw\";s:6:\"回應\";s:2:\"cn\";s:6:\"回应\";s:2:\"hu\";s:16:\"Hozzászólások\";s:2:\"th\";s:33:\"ความคิดเห็น\";s:2:\"se\";s:11:\"Kommentarer\";}', 'comments', '1.1.0', null, 'a:25:{s:2:\"en\";s:76:\"Users and guests can write comments for content like blog, pages and photos.\";s:2:\"ar\";s:152:\"يستطيع الأعضاء والزوّار كتابة التعليقات على المُحتوى كالأخبار، والصفحات والصّوَر.\";s:2:\"br\";s:97:\"Usuários e convidados podem escrever comentários para quase tudo com suporte nativo ao captcha.\";s:2:\"pt\";s:100:\"Utilizadores e convidados podem escrever comentários para quase tudo com suporte nativo ao captcha.\";s:2:\"cs\";s:100:\"Uživatelé a hosté mohou psát komentáře k obsahu, např. neovinkám, stránkám a fotografiím.\";s:2:\"da\";s:83:\"Brugere og besøgende kan skrive kommentarer til indhold som blog, sider og fotoer.\";s:2:\"de\";s:65:\"Benutzer und Gäste können für fast alles Kommentare schreiben.\";s:2:\"el\";s:224:\"Οι χρήστες και οι επισκέπτες μπορούν να αφήνουν σχόλια για περιεχόμενο όπως το ιστολόγιο, τις σελίδες και τις φωτογραφίες.\";s:2:\"es\";s:130:\"Los usuarios y visitantes pueden escribir comentarios en casi todo el contenido con el soporte de un sistema de captcha incluído.\";s:2:\"fa\";s:168:\"کاربران و مهمان ها می توانند نظرات خود را بر روی محتوای سایت در بلاگ و دیگر قسمت ها ارائه دهند\";s:2:\"fi\";s:107:\"Käyttäjät ja vieraat voivat kirjoittaa kommentteja eri sisältöihin kuten uutisiin, sivuihin ja kuviin.\";s:2:\"fr\";s:130:\"Les utilisateurs et les invités peuvent écrire des commentaires pour quasiment tout grâce au générateur de captcha intégré.\";s:2:\"he\";s:94:\"משתמשי האתר יכולים לרשום תגובות למאמרים, תמונות וכו\";s:2:\"id\";s:100:\"Pengguna dan pengunjung dapat menuliskan komentaruntuk setiap konten seperti blog, halaman dan foto.\";s:2:\"it\";s:85:\"Utenti e visitatori possono scrivere commenti ai contenuti quali blog, pagine e foto.\";s:2:\"lt\";s:75:\"Vartotojai ir svečiai gali komentuoti jūsų naujienas, puslapius ar foto.\";s:2:\"nl\";s:52:\"Gebruikers en gasten kunnen reageren op bijna alles.\";s:2:\"pl\";s:93:\"Użytkownicy i goście mogą dodawać komentarze z wbudowanym systemem zabezpieczeń captcha.\";s:2:\"ru\";s:187:\"Пользователи и гости могут добавлять комментарии к новостям, информационным страницам и фотографиям.\";s:2:\"sl\";s:89:\"Uporabniki in obiskovalci lahko vnesejo komentarje na vsebino kot je blok, stra ali slike\";s:2:\"tw\";s:75:\"用戶和訪客可以針對新聞、頁面與照片等內容發表回應。\";s:2:\"cn\";s:75:\"用户和访客可以针对新闻、页面与照片等内容发表回应。\";s:2:\"hu\";s:117:\"A felhasználók és a vendégek hozzászólásokat írhatnak a tartalomhoz (bejegyzésekhez, oldalakhoz, fotókhoz).\";s:2:\"th\";s:240:\"ผู้ใช้งานและผู้เยี่ยมชมสามารถเขียนความคิดเห็นในเนื้อหาของหน้าเว็บบล็อกและภาพถ่าย\";s:2:\"se\";s:98:\"Användare och besökare kan skriva kommentarer till innehåll som blogginlägg, sidor och bilder.\";}', '0', '0', '1', 'content', '0', '1', '1', '1414575736');
INSERT INTO `default_modules` VALUES ('7', 'a:25:{s:2:\"en\";s:7:\"Contact\";s:2:\"ar\";s:14:\"الإتصال\";s:2:\"br\";s:7:\"Contato\";s:2:\"pt\";s:8:\"Contacto\";s:2:\"cs\";s:7:\"Kontakt\";s:2:\"da\";s:7:\"Kontakt\";s:2:\"de\";s:7:\"Kontakt\";s:2:\"el\";s:22:\"Επικοινωνία\";s:2:\"es\";s:8:\"Contacto\";s:2:\"fa\";s:18:\"تماس با ما\";s:2:\"fi\";s:13:\"Ota yhteyttä\";s:2:\"fr\";s:7:\"Contact\";s:2:\"he\";s:17:\"יצירת קשר\";s:2:\"id\";s:6:\"Kontak\";s:2:\"it\";s:10:\"Contattaci\";s:2:\"lt\";s:18:\"Kontaktinė formą\";s:2:\"nl\";s:7:\"Contact\";s:2:\"pl\";s:7:\"Kontakt\";s:2:\"ru\";s:27:\"Обратная связь\";s:2:\"sl\";s:7:\"Kontakt\";s:2:\"tw\";s:12:\"聯絡我們\";s:2:\"cn\";s:12:\"联络我们\";s:2:\"hu\";s:9:\"Kapcsolat\";s:2:\"th\";s:18:\"ติดต่อ\";s:2:\"se\";s:7:\"Kontakt\";}', 'contact', '1.0.0', null, 'a:25:{s:2:\"en\";s:112:\"Adds a form to your site that allows visitors to send emails to you without disclosing an email address to them.\";s:2:\"ar\";s:157:\"إضافة استمارة إلى موقعك تُمكّن الزوّار من مراسلتك دون علمهم بعنوان البريد الإلكتروني.\";s:2:\"br\";s:139:\"Adiciona um formulário para o seu site permitir aos visitantes que enviem e-mails para voce sem divulgar um endereço de e-mail para eles.\";s:2:\"pt\";s:116:\"Adiciona um formulário ao seu site que permite aos visitantes enviarem e-mails sem divulgar um endereço de e-mail.\";s:2:\"cs\";s:149:\"Přidá na web kontaktní formulář pro návštěvníky a uživatele, díky kterému vás mohou kontaktovat i bez znalosti vaší e-mailové adresy.\";s:2:\"da\";s:123:\"Tilføjer en formular på din side som tillader besøgende at sende mails til dig, uden at du skal opgive din email-adresse\";s:2:\"de\";s:119:\"Fügt ein Formular hinzu, welches Besuchern erlaubt Emails zu schreiben, ohne die Kontakt Email-Adresse offen zu legen.\";s:2:\"el\";s:273:\"Προσθέτει μια φόρμα στον ιστότοπό σας που επιτρέπει σε επισκέπτες να σας στέλνουν μηνύμα μέσω email χωρίς να τους αποκαλύπτεται η διεύθυνση του email σας.\";s:2:\"fa\";s:239:\"فرم تماس را به سایت اضافه می کند تا مراجعین بتوانند بدون اینکه ایمیل شما را بدانند برای شما پیغام هایی را از طریق ایمیل ارسال نمایند.\";s:2:\"es\";s:156:\"Añade un formulario a tu sitio que permitirá a los visitantes enviarte correos electrónicos a ti sin darles tu dirección de correo directamente a ellos.\";s:2:\"fi\";s:128:\"Luo lomakkeen sivustollesi, josta kävijät voivat lähettää sähköpostia tietämättä vastaanottajan sähköpostiosoitetta.\";s:2:\"fr\";s:122:\"Ajoute un formulaire à votre site qui permet aux visiteurs de vous envoyer un e-mail sans révéler votre adresse e-mail.\";s:2:\"he\";s:155:\"מוסיף תופס יצירת קשר לאתר על מנת לא לחסוף כתובת דואר האלקטרוני של האתר למנועי פרסומות\";s:2:\"id\";s:149:\"Menambahkan formulir ke dalam situs Anda yang memungkinkan pengunjung untuk mengirimkan email kepada Anda tanpa memberikan alamat email kepada mereka\";s:2:\"it\";s:119:\"Aggiunge un modulo al tuo sito che permette ai visitatori di inviarti email senza mostrare loro il tuo indirizzo email.\";s:2:\"lt\";s:124:\"Prideda jūsų puslapyje formą leidžianti lankytojams siūsti jums el. laiškus neatskleidžiant jūsų el. pašto adreso.\";s:2:\"nl\";s:125:\"Voegt een formulier aan de site toe waarmee bezoekers een email kunnen sturen, zonder dat u ze een emailadres hoeft te tonen.\";s:2:\"pl\";s:126:\"Dodaje formularz kontaktowy do Twojej strony, który pozwala użytkownikom wysłanie maila za pomocą formularza kontaktowego.\";s:2:\"ru\";s:234:\"Добавляет форму обратной связи на сайт, через которую посетители могут отправлять вам письма, при этом адрес Email остаётся скрыт.\";s:2:\"sl\";s:113:\"Dodaj obrazec za kontakt da vam lahko obiskovalci pošljejo sporočilo brez da bi jim razkrili vaš email naslov.\";s:2:\"tw\";s:147:\"為您的網站新增「聯絡我們」的功能，對訪客是較為清楚便捷的聯絡方式，也無須您將電子郵件公開在網站上。\";s:2:\"cn\";s:147:\"为您的网站新增“联络我们”的功能，对访客是较为清楚便捷的联络方式，也无须您将电子邮件公开在网站上。\";s:2:\"th\";s:316:\"เพิ่มแบบฟอร์มในเว็บไซต์ของคุณ ช่วยให้ผู้เยี่ยมชมสามารถส่งอีเมลถึงคุณโดยไม่ต้องเปิดเผยที่อยู่อีเมลของพวกเขา\";s:2:\"hu\";s:156:\"Létrehozható vele olyan űrlap, amely lehetővé teszi a látogatók számára, hogy e-mailt küldjenek neked úgy, hogy nem feded fel az e-mail címedet.\";s:2:\"se\";s:53:\"Lägger till ett kontaktformulär till din webbplats.\";}', '0', '0', '0', '0', '0', '1', '1', '1414575736');
INSERT INTO `default_modules` VALUES ('8', 'a:24:{s:2:\"en\";s:5:\"Files\";s:2:\"ar\";s:16:\"الملفّات\";s:2:\"br\";s:8:\"Arquivos\";s:2:\"pt\";s:9:\"Ficheiros\";s:2:\"cs\";s:7:\"Soubory\";s:2:\"da\";s:5:\"Filer\";s:2:\"de\";s:7:\"Dateien\";s:2:\"el\";s:12:\"Αρχεία\";s:2:\"es\";s:8:\"Archivos\";s:2:\"fa\";s:13:\"فایل ها\";s:2:\"fi\";s:9:\"Tiedostot\";s:2:\"fr\";s:8:\"Fichiers\";s:2:\"he\";s:10:\"קבצים\";s:2:\"id\";s:4:\"File\";s:2:\"it\";s:4:\"File\";s:2:\"lt\";s:6:\"Failai\";s:2:\"nl\";s:9:\"Bestanden\";s:2:\"ru\";s:10:\"Файлы\";s:2:\"sl\";s:8:\"Datoteke\";s:2:\"tw\";s:6:\"檔案\";s:2:\"cn\";s:6:\"档案\";s:2:\"hu\";s:7:\"Fájlok\";s:2:\"th\";s:12:\"ไฟล์\";s:2:\"se\";s:5:\"Filer\";}', 'files', '2.0.0', null, 'a:24:{s:2:\"en\";s:40:\"Manages files and folders for your site.\";s:2:\"ar\";s:50:\"إدارة ملفات ومجلّدات موقعك.\";s:2:\"br\";s:53:\"Permite gerenciar facilmente os arquivos de seu site.\";s:2:\"pt\";s:59:\"Permite gerir facilmente os ficheiros e pastas do seu site.\";s:2:\"cs\";s:43:\"Spravujte soubory a složky na vašem webu.\";s:2:\"da\";s:41:\"Administrer filer og mapper for dit site.\";s:2:\"de\";s:35:\"Verwalte Dateien und Verzeichnisse.\";s:2:\"el\";s:100:\"Διαχειρίζεται αρχεία και φακέλους για το ιστότοπό σας.\";s:2:\"es\";s:43:\"Administra archivos y carpetas en tu sitio.\";s:2:\"fa\";s:79:\"مدیریت فایل های چند رسانه ای و فولدر ها سایت\";s:2:\"fi\";s:43:\"Hallitse sivustosi tiedostoja ja kansioita.\";s:2:\"fr\";s:46:\"Gérer les fichiers et dossiers de votre site.\";s:2:\"he\";s:47:\"ניהול תיקיות וקבצים שבאתר\";s:2:\"id\";s:42:\"Mengatur file dan folder dalam situs Anda.\";s:2:\"it\";s:38:\"Gestisci file e cartelle del tuo sito.\";s:2:\"lt\";s:28:\"Katalogų ir bylų valdymas.\";s:2:\"nl\";s:41:\"Beheer bestanden en mappen op uw website.\";s:2:\"ru\";s:78:\"Управление файлами и папками вашего сайта.\";s:2:\"sl\";s:38:\"Uredi datoteke in mape na vaši strani\";s:2:\"tw\";s:33:\"管理網站中的檔案與目錄\";s:2:\"cn\";s:33:\"管理网站中的档案与目录\";s:2:\"hu\";s:41:\"Fájlok és mappák kezelése az oldalon.\";s:2:\"th\";s:141:\"บริหารจัดการไฟล์และโฟลเดอร์สำหรับเว็บไซต์ของคุณ\";s:2:\"se\";s:45:\"Hanterar filer och mappar för din webbplats.\";}', '0', '0', '1', 'content', '0', '1', '1', '1414575736');
INSERT INTO `default_modules` VALUES ('9', 'a:24:{s:2:\"en\";s:6:\"Groups\";s:2:\"ar\";s:18:\"المجموعات\";s:2:\"br\";s:6:\"Grupos\";s:2:\"pt\";s:6:\"Grupos\";s:2:\"cs\";s:7:\"Skupiny\";s:2:\"da\";s:7:\"Grupper\";s:2:\"de\";s:7:\"Gruppen\";s:2:\"el\";s:12:\"Ομάδες\";s:2:\"es\";s:6:\"Grupos\";s:2:\"fa\";s:13:\"گروه ها\";s:2:\"fi\";s:7:\"Ryhmät\";s:2:\"fr\";s:7:\"Groupes\";s:2:\"he\";s:12:\"קבוצות\";s:2:\"id\";s:4:\"Grup\";s:2:\"it\";s:6:\"Gruppi\";s:2:\"lt\";s:7:\"Grupės\";s:2:\"nl\";s:7:\"Groepen\";s:2:\"ru\";s:12:\"Группы\";s:2:\"sl\";s:7:\"Skupine\";s:2:\"tw\";s:6:\"群組\";s:2:\"cn\";s:6:\"群组\";s:2:\"hu\";s:9:\"Csoportok\";s:2:\"th\";s:15:\"กลุ่ม\";s:2:\"se\";s:7:\"Grupper\";}', 'groups', '1.0.0', null, 'a:24:{s:2:\"en\";s:54:\"Users can be placed into groups to manage permissions.\";s:2:\"ar\";s:100:\"يمكن وضع المستخدمين في مجموعات لتسهيل إدارة صلاحياتهم.\";s:2:\"br\";s:72:\"Usuários podem ser inseridos em grupos para gerenciar suas permissões.\";s:2:\"pt\";s:74:\"Utilizadores podem ser inseridos em grupos para gerir as suas permissões.\";s:2:\"cs\";s:77:\"Uživatelé mohou být rozřazeni do skupin pro lepší správu oprávnění.\";s:2:\"da\";s:49:\"Brugere kan inddeles i grupper for adgangskontrol\";s:2:\"de\";s:85:\"Benutzer können zu Gruppen zusammengefasst werden um diesen Zugriffsrechte zu geben.\";s:2:\"el\";s:168:\"Οι χρήστες μπορούν να τοποθετηθούν σε ομάδες και έτσι να διαχειριστείτε τα δικαιώματά τους.\";s:2:\"es\";s:75:\"Los usuarios podrán ser colocados en grupos para administrar sus permisos.\";s:2:\"fa\";s:149:\"کاربرها می توانند در گروه های ساماندهی شوند تا بتوان اجازه های مختلفی را ایجاد کرد\";s:2:\"fi\";s:84:\"Käyttäjät voidaan liittää ryhmiin, jotta käyttöoikeuksia voidaan hallinnoida.\";s:2:\"fr\";s:82:\"Les utilisateurs peuvent appartenir à des groupes afin de gérer les permissions.\";s:2:\"he\";s:62:\"נותן אפשרות לאסוף משתמשים לקבוצות\";s:2:\"id\";s:68:\"Pengguna dapat dikelompokkan ke dalam grup untuk mengatur perizinan.\";s:2:\"it\";s:69:\"Gli utenti possono essere inseriti in gruppi per gestirne i permessi.\";s:2:\"lt\";s:67:\"Vartotojai gali būti priskirti grupei tam, kad valdyti jų teises.\";s:2:\"nl\";s:73:\"Gebruikers kunnen in groepen geplaatst worden om rechten te kunnen geven.\";s:2:\"ru\";s:134:\"Пользователей можно объединять в группы, для управления правами доступа.\";s:2:\"sl\";s:64:\"Uporabniki so lahko razvrščeni v skupine za urejanje dovoljenj\";s:2:\"tw\";s:45:\"用戶可以依群組分類並管理其權限\";s:2:\"cn\";s:45:\"用户可以依群组分类并管理其权限\";s:2:\"hu\";s:73:\"A felhasználók csoportokba rendezhetőek a jogosultságok kezelésére.\";s:2:\"th\";s:84:\"สามารถวางผู้ใช้ลงในกลุ่มเพื่\";s:2:\"se\";s:76:\"Användare kan delas in i grupper för att hantera roller och behörigheter.\";}', '0', '0', '1', 'users', '1', '1', '1', '1414575736');
INSERT INTO `default_modules` VALUES ('10', 'a:17:{s:2:\"en\";s:8:\"Keywords\";s:2:\"ar\";s:21:\"كلمات البحث\";s:2:\"br\";s:14:\"Palavras-chave\";s:2:\"pt\";s:14:\"Palavras-chave\";s:2:\"da\";s:9:\"Nøgleord\";s:2:\"el\";s:27:\"Λέξεις Κλειδιά\";s:2:\"fa\";s:21:\"کلمات کلیدی\";s:2:\"fr\";s:10:\"Mots-Clés\";s:2:\"id\";s:10:\"Kata Kunci\";s:2:\"nl\";s:14:\"Sleutelwoorden\";s:2:\"tw\";s:6:\"鍵詞\";s:2:\"cn\";s:6:\"键词\";s:2:\"hu\";s:11:\"Kulcsszavak\";s:2:\"fi\";s:10:\"Avainsanat\";s:2:\"sl\";s:15:\"Ključne besede\";s:2:\"th\";s:15:\"คำค้น\";s:2:\"se\";s:9:\"Nyckelord\";}', 'keywords', '1.1.0', null, 'a:17:{s:2:\"en\";s:71:\"Maintain a central list of keywords to label and organize your content.\";s:2:\"ar\";s:124:\"أنشئ مجموعة من كلمات البحث التي تستطيع من خلالها وسم وتنظيم المحتوى.\";s:2:\"br\";s:85:\"Mantém uma lista central de palavras-chave para rotular e organizar o seu conteúdo.\";s:2:\"pt\";s:85:\"Mantém uma lista central de palavras-chave para rotular e organizar o seu conteúdo.\";s:2:\"da\";s:72:\"Vedligehold en central liste af nøgleord for at organisere dit indhold.\";s:2:\"el\";s:181:\"Συντηρεί μια κεντρική λίστα από λέξεις κλειδιά για να οργανώνετε μέσω ετικετών το περιεχόμενό σας.\";s:2:\"fa\";s:110:\"حفظ و نگهداری لیست مرکزی از کلمات کلیدی برای سازماندهی محتوا\";s:2:\"fr\";s:87:\"Maintenir une liste centralisée de Mots-Clés pour libeller et organiser vos contenus.\";s:2:\"id\";s:71:\"Memantau daftar kata kunci untuk melabeli dan mengorganisasikan konten.\";s:2:\"nl\";s:91:\"Beheer een centrale lijst van sleutelwoorden om uw content te categoriseren en organiseren.\";s:2:\"tw\";s:64:\"集中管理可用於標題與內容的鍵詞(keywords)列表。\";s:2:\"cn\";s:64:\"集中管理可用于标题与内容的键词(keywords)列表。\";s:2:\"hu\";s:65:\"Ez egy központi kulcsszó lista a cimkékhez és a tartalmakhoz.\";s:2:\"fi\";s:92:\"Hallinnoi keskitettyä listaa avainsanoista merkitäksesi ja järjestelläksesi sisältöä.\";s:2:\"sl\";s:82:\"Vzdržuj centralni seznam ključnih besed za označevanje in ogranizacijo vsebine.\";s:2:\"th\";s:189:\"ศูนย์กลางการปรับปรุงคำค้นในการติดฉลากและจัดระเบียบเนื้อหาของคุณ\";s:2:\"se\";s:61:\"Hantera nyckelord för att organisera webbplatsens innehåll.\";}', '0', '0', '1', 'data', '0', '1', '1', '1414575736');
INSERT INTO `default_modules` VALUES ('11', 'a:15:{s:2:\"en\";s:11:\"Maintenance\";s:2:\"pt\";s:12:\"Manutenção\";s:2:\"ar\";s:14:\"الصيانة\";s:2:\"el\";s:18:\"Συντήρηση\";s:2:\"hu\";s:13:\"Karbantartás\";s:2:\"fa\";s:15:\"نگه داری\";s:2:\"fi\";s:9:\"Ylläpito\";s:2:\"fr\";s:11:\"Maintenance\";s:2:\"id\";s:12:\"Pemeliharaan\";s:2:\"it\";s:12:\"Manutenzione\";s:2:\"se\";s:10:\"Underhåll\";s:2:\"sl\";s:12:\"Vzdrževanje\";s:2:\"th\";s:39:\"การบำรุงรักษา\";s:2:\"tw\";s:6:\"維護\";s:2:\"cn\";s:6:\"维护\";}', 'maintenance', '1.0.0', null, 'a:15:{s:2:\"en\";s:63:\"Manage the site cache and export information from the database.\";s:2:\"pt\";s:68:\"Gerir o cache do seu site e exportar informações da base de dados.\";s:2:\"ar\";s:81:\"حذف عناصر الذاكرة المخبأة عبر واجهة الإدارة.\";s:2:\"el\";s:142:\"Διαγραφή αντικειμένων προσωρινής αποθήκευσης μέσω της περιοχής διαχείρισης.\";s:2:\"id\";s:60:\"Mengatur cache situs dan mengexport informasi dari database.\";s:2:\"it\";s:65:\"Gestisci la cache del sito e esporta le informazioni dal database\";s:2:\"fa\";s:73:\"مدیریت کش سایت و صدور اطلاعات از دیتابیس\";s:2:\"fr\";s:71:\"Gérer le cache du site et exporter les contenus de la base de données\";s:2:\"fi\";s:59:\"Hallinoi sivuston välimuistia ja vie tietoa tietokannasta.\";s:2:\"hu\";s:66:\"Az oldal gyorsítótár kezelése és az adatbázis exportálása.\";s:2:\"se\";s:76:\"Underhåll webbplatsens cache och exportera data från webbplatsens databas.\";s:2:\"sl\";s:69:\"Upravljaj s predpomnilnikom strani (cache) in izvozi podatke iz baze.\";s:2:\"th\";s:150:\"การจัดการแคชเว็บไซต์และข้อมูลการส่งออกจากฐานข้อมูล\";s:2:\"tw\";s:45:\"經由管理介面手動刪除暫存資料。\";s:2:\"cn\";s:45:\"经由管理介面手动删除暂存资料。\";}', '0', '0', '1', 'data', '0', '1', '1', '1414575736');
INSERT INTO `default_modules` VALUES ('12', 'a:25:{s:2:\"en\";s:10:\"Navigation\";s:2:\"ar\";s:14:\"الروابط\";s:2:\"br\";s:11:\"Navegação\";s:2:\"pt\";s:11:\"Navegação\";s:2:\"cs\";s:8:\"Navigace\";s:2:\"da\";s:10:\"Navigation\";s:2:\"de\";s:10:\"Navigation\";s:2:\"el\";s:16:\"Πλοήγηση\";s:2:\"es\";s:11:\"Navegación\";s:2:\"fa\";s:11:\"منو ها\";s:2:\"fi\";s:10:\"Navigointi\";s:2:\"fr\";s:10:\"Navigation\";s:2:\"he\";s:10:\"ניווט\";s:2:\"id\";s:8:\"Navigasi\";s:2:\"it\";s:11:\"Navigazione\";s:2:\"lt\";s:10:\"Navigacija\";s:2:\"nl\";s:9:\"Navigatie\";s:2:\"pl\";s:9:\"Nawigacja\";s:2:\"ru\";s:18:\"Навигация\";s:2:\"sl\";s:10:\"Navigacija\";s:2:\"tw\";s:12:\"導航選單\";s:2:\"cn\";s:12:\"导航选单\";s:2:\"th\";s:36:\"ตัวช่วยนำทาง\";s:2:\"hu\";s:11:\"Navigáció\";s:2:\"se\";s:10:\"Navigation\";}', 'navigation', '1.1.0', null, 'a:25:{s:2:\"en\";s:78:\"Manage links on navigation menus and all the navigation groups they belong to.\";s:2:\"ar\";s:85:\"إدارة روابط وقوائم ومجموعات الروابط في الموقع.\";s:2:\"br\";s:91:\"Gerenciar links do menu de navegação e todos os grupos de navegação pertencentes a ele.\";s:2:\"pt\";s:93:\"Gerir todos os grupos dos menus de navegação e os links de navegação pertencentes a eles.\";s:2:\"cs\";s:73:\"Správa odkazů v navigaci a všech souvisejících navigačních skupin.\";s:2:\"da\";s:82:\"Håndtér links på navigationsmenuerne og alle navigationsgrupperne de tilhører.\";s:2:\"de\";s:76:\"Verwalte Links in Navigationsmenüs und alle zugehörigen Navigationsgruppen\";s:2:\"el\";s:207:\"Διαχειριστείτε τους συνδέσμους στα μενού πλοήγησης και όλες τις ομάδες συνδέσμων πλοήγησης στις οποίες ανήκουν.\";s:2:\"es\";s:102:\"Administra links en los menús de navegación y en todos los grupos de navegación al cual pertenecen.\";s:2:\"fa\";s:68:\"مدیریت منو ها و گروه های مربوط به آنها\";s:2:\"fi\";s:91:\"Hallitse linkkejä navigointi valikoissa ja kaikkia navigointi ryhmiä, joihin ne kuuluvat.\";s:2:\"fr\";s:97:\"Gérer les liens du menu Navigation et tous les groupes de navigation auxquels ils appartiennent.\";s:2:\"he\";s:73:\"ניהול שלוחות תפריטי ניווט וקבוצות ניווט\";s:2:\"id\";s:73:\"Mengatur tautan pada menu navigasi dan semua pengelompokan grup navigasi.\";s:2:\"it\";s:97:\"Gestisci i collegamenti dei menu di navigazione e tutti i gruppi di navigazione da cui dipendono.\";s:2:\"lt\";s:95:\"Tvarkyk nuorodas navigacijų menių ir visas navigacijų grupes kurioms tos nuorodos priklauso.\";s:2:\"nl\";s:92:\"Beheer koppelingen op de navigatiemenu&apos;s en alle navigatiegroepen waar ze onder vallen.\";s:2:\"pl\";s:95:\"Zarządzaj linkami w menu nawigacji oraz wszystkimi grupami nawigacji do których one należą.\";s:2:\"ru\";s:136:\"Управление ссылками в меню навигации и группах, к которым они принадлежат.\";s:2:\"sl\";s:64:\"Uredi povezave v meniju in vse skupine povezav ki jim pripadajo.\";s:2:\"tw\";s:72:\"管理導航選單中的連結，以及它們所隸屬的導航群組。\";s:2:\"cn\";s:72:\"管理导航选单中的连结，以及它们所隶属的导航群组。\";s:2:\"th\";s:108:\"จัดการการเชื่อมโยงนำทางและกลุ่มนำทาง\";s:2:\"se\";s:33:\"Hantera länkar och länkgrupper.\";s:2:\"hu\";s:100:\"Linkek kezelése a navigációs menükben és a navigációs csoportok kezelése, amikhez tartoznak.\";}', '0', '0', '1', 'structure', '1', '1', '1', '1414575736');
INSERT INTO `default_modules` VALUES ('13', 'a:25:{s:2:\"en\";s:5:\"Pages\";s:2:\"ar\";s:14:\"الصفحات\";s:2:\"br\";s:8:\"Páginas\";s:2:\"pt\";s:8:\"Páginas\";s:2:\"cs\";s:8:\"Stránky\";s:2:\"da\";s:5:\"Sider\";s:2:\"de\";s:6:\"Seiten\";s:2:\"el\";s:14:\"Σελίδες\";s:2:\"es\";s:8:\"Páginas\";s:2:\"fa\";s:14:\"صفحه ها \";s:2:\"fi\";s:5:\"Sivut\";s:2:\"fr\";s:5:\"Pages\";s:2:\"he\";s:8:\"דפים\";s:2:\"id\";s:7:\"Halaman\";s:2:\"it\";s:6:\"Pagine\";s:2:\"lt\";s:9:\"Puslapiai\";s:2:\"nl\";s:13:\"Pagina&apos;s\";s:2:\"pl\";s:6:\"Strony\";s:2:\"ru\";s:16:\"Страницы\";s:2:\"sl\";s:6:\"Strani\";s:2:\"tw\";s:6:\"頁面\";s:2:\"cn\";s:6:\"页面\";s:2:\"hu\";s:7:\"Oldalak\";s:2:\"th\";s:21:\"หน้าเพจ\";s:2:\"se\";s:5:\"Sidor\";}', 'pages', '2.2.0', null, 'a:25:{s:2:\"en\";s:55:\"Add custom pages to the site with any content you want.\";s:2:\"ar\";s:99:\"إضافة صفحات مُخصّصة إلى الموقع تحتوي أية مُحتوى تريده.\";s:2:\"br\";s:82:\"Adicionar páginas personalizadas ao site com qualquer conteúdo que você queira.\";s:2:\"pt\";s:86:\"Adicionar páginas personalizadas ao seu site com qualquer conteúdo que você queira.\";s:2:\"cs\";s:74:\"Přidávejte vlastní stránky na web s jakýmkoliv obsahem budete chtít.\";s:2:\"da\";s:71:\"Tilføj brugerdefinerede sider til dit site med det indhold du ønsker.\";s:2:\"de\";s:49:\"Füge eigene Seiten mit anpassbaren Inhalt hinzu.\";s:2:\"el\";s:152:\"Προσθέστε και επεξεργαστείτε σελίδες στον ιστότοπό σας με ό,τι περιεχόμενο θέλετε.\";s:2:\"es\";s:77:\"Agrega páginas customizadas al sitio con cualquier contenido que tu quieras.\";s:2:\"fa\";s:96:\"ایحاد صفحات جدید و دلخواه با هر محتوایی که دوست دارید\";s:2:\"fi\";s:47:\"Lisää mitä tahansa sisältöä sivustollesi.\";s:2:\"fr\";s:89:\"Permet d\'ajouter sur le site des pages personalisées avec le contenu que vous souhaitez.\";s:2:\"he\";s:35:\"ניהול דפי תוכן האתר\";s:2:\"id\";s:75:\"Menambahkan halaman ke dalam situs dengan konten apapun yang Anda perlukan.\";s:2:\"it\";s:73:\"Aggiungi pagine personalizzate al sito con qualsiesi contenuto tu voglia.\";s:2:\"lt\";s:46:\"Pridėkite nuosavus puslapius betkokio turinio\";s:2:\"nl\";s:70:\"Voeg aangepaste pagina&apos;s met willekeurige inhoud aan de site toe.\";s:2:\"pl\";s:53:\"Dodaj własne strony z dowolną treścią do witryny.\";s:2:\"ru\";s:134:\"Управление информационными страницами сайта, с произвольным содержимым.\";s:2:\"sl\";s:44:\"Dodaj stran s kakršno koli vsebino želite.\";s:2:\"tw\";s:39:\"為您的網站新增自定的頁面。\";s:2:\"cn\";s:39:\"为您的网站新增自定的页面。\";s:2:\"th\";s:168:\"เพิ่มหน้าเว็บที่กำหนดเองไปยังเว็บไซต์ของคุณตามที่ต้องการ\";s:2:\"hu\";s:67:\"Saját oldalak hozzáadása a weboldalhoz, akármilyen tartalommal.\";s:2:\"se\";s:39:\"Lägg till egna sidor till webbplatsen.\";}', '1', '1', '1', 'content', '1', '1', '1', '1414575736');
INSERT INTO `default_modules` VALUES ('14', 'a:25:{s:2:\"en\";s:11:\"Permissions\";s:2:\"ar\";s:18:\"الصلاحيات\";s:2:\"br\";s:11:\"Permissões\";s:2:\"pt\";s:11:\"Permissões\";s:2:\"cs\";s:12:\"Oprávnění\";s:2:\"da\";s:14:\"Adgangskontrol\";s:2:\"de\";s:14:\"Zugriffsrechte\";s:2:\"el\";s:20:\"Δικαιώματα\";s:2:\"es\";s:8:\"Permisos\";s:2:\"fa\";s:15:\"اجازه ها\";s:2:\"fi\";s:16:\"Käyttöoikeudet\";s:2:\"fr\";s:11:\"Permissions\";s:2:\"he\";s:12:\"הרשאות\";s:2:\"id\";s:9:\"Perizinan\";s:2:\"it\";s:8:\"Permessi\";s:2:\"lt\";s:7:\"Teisės\";s:2:\"nl\";s:15:\"Toegangsrechten\";s:2:\"pl\";s:11:\"Uprawnienia\";s:2:\"ru\";s:25:\"Права доступа\";s:2:\"sl\";s:10:\"Dovoljenja\";s:2:\"tw\";s:6:\"權限\";s:2:\"cn\";s:6:\"权限\";s:2:\"hu\";s:14:\"Jogosultságok\";s:2:\"th\";s:18:\"สิทธิ์\";s:2:\"se\";s:13:\"Behörigheter\";}', 'permissions', '1.0.0', null, 'a:25:{s:2:\"en\";s:68:\"Control what type of users can see certain sections within the site.\";s:2:\"ar\";s:127:\"التحكم بإعطاء الصلاحيات للمستخدمين للوصول إلى أقسام الموقع المختلفة.\";s:2:\"br\";s:68:\"Controle quais tipos de usuários podem ver certas seções no site.\";s:2:\"pt\";s:75:\"Controle quais os tipos de utilizadores podem ver certas secções no site.\";s:2:\"cs\";s:93:\"Spravujte oprávnění pro jednotlivé typy uživatelů a ke kterým sekcím mají přístup.\";s:2:\"da\";s:72:\"Kontroller hvilken type brugere der kan se bestemte sektioner på sitet.\";s:2:\"de\";s:70:\"Regelt welche Art von Benutzer welche Sektion in der Seite sehen kann.\";s:2:\"el\";s:180:\"Ελέγξτε τα δικαιώματα χρηστών και ομάδων χρηστών όσο αφορά σε διάφορες λειτουργίες του ιστοτόπου.\";s:2:\"es\";s:81:\"Controla que tipo de usuarios pueden ver secciones específicas dentro del sitio.\";s:2:\"fa\";s:59:\"مدیریت اجازه های گروه های کاربری\";s:2:\"fi\";s:72:\"Hallitse minkä tyyppisiin osioihin käyttäjät pääsevät sivustolla.\";s:2:\"fr\";s:104:\"Permet de définir les autorisations des groupes d\'utilisateurs pour afficher les différentes sections.\";s:2:\"he\";s:75:\"ניהול הרשאות כניסה לאיזורים מסוימים באתר\";s:2:\"id\";s:76:\"Mengontrol tipe pengguna mana yang dapat mengakses suatu bagian dalam situs.\";s:2:\"it\";s:78:\"Controlla che tipo di utenti posssono accedere a determinate sezioni del sito.\";s:2:\"lt\";s:72:\"Kontroliuokite kokio tipo varotojai kokią dalį puslapio gali pasiekti.\";s:2:\"nl\";s:71:\"Bepaal welke typen gebruikers toegang hebben tot gedeeltes van de site.\";s:2:\"pl\";s:79:\"Ustaw, którzy użytkownicy mogą mieć dostęp do odpowiednich sekcji witryny.\";s:2:\"ru\";s:209:\"Управление правами доступа, ограничение доступа определённых групп пользователей к произвольным разделам сайта.\";s:2:\"sl\";s:85:\"Uredite dovoljenja kateri tip uporabnika lahko vidi določena področja vaše strani.\";s:2:\"tw\";s:81:\"用來控制不同類別的用戶，設定其瀏覽特定網站內容的權限。\";s:2:\"cn\";s:81:\"用来控制不同类别的用户，设定其浏览特定网站内容的权限。\";s:2:\"hu\";s:129:\"A felhasználók felügyelet alatt tartására, hogy milyen típusú felhasználók, mit láthatnak, mely szakaszain az oldalnak.\";s:2:\"th\";s:117:\"ควบคุมว่าผู้ใช้งานจะเห็นหมวดหมู่ไหนบ้าง\";s:2:\"se\";s:27:\"Hantera gruppbehörigheter.\";}', '0', '0', '1', 'users', '1', '1', '1', '1414575736');
INSERT INTO `default_modules` VALUES ('15', 'a:24:{s:2:\"en\";s:9:\"Redirects\";s:2:\"ar\";s:18:\"التوجيهات\";s:2:\"br\";s:17:\"Redirecionamentos\";s:2:\"pt\";s:17:\"Redirecionamentos\";s:2:\"cs\";s:16:\"Přesměrování\";s:2:\"da\";s:13:\"Omadressering\";s:2:\"el\";s:30:\"Ανακατευθύνσεις\";s:2:\"es\";s:13:\"Redirecciones\";s:2:\"fa\";s:17:\"انتقال ها\";s:2:\"fi\";s:18:\"Uudelleenohjaukset\";s:2:\"fr\";s:12:\"Redirections\";s:2:\"he\";s:12:\"הפניות\";s:2:\"id\";s:8:\"Redirect\";s:2:\"it\";s:11:\"Reindirizzi\";s:2:\"lt\";s:14:\"Peradresavimai\";s:2:\"nl\";s:12:\"Verwijzingen\";s:2:\"ru\";s:30:\"Перенаправления\";s:2:\"sl\";s:12:\"Preusmeritve\";s:2:\"tw\";s:6:\"轉址\";s:2:\"cn\";s:6:\"转址\";s:2:\"hu\";s:17:\"Átirányítások\";s:2:\"pl\";s:14:\"Przekierowania\";s:2:\"th\";s:42:\"เปลี่ยนเส้นทาง\";s:2:\"se\";s:14:\"Omdirigeringar\";}', 'redirects', '1.0.0', null, 'a:24:{s:2:\"en\";s:33:\"Redirect from one URL to another.\";s:2:\"ar\";s:47:\"التوجيه من رابط URL إلى آخر.\";s:2:\"br\";s:39:\"Redirecionamento de uma URL para outra.\";s:2:\"pt\";s:40:\"Redirecionamentos de uma URL para outra.\";s:2:\"cs\";s:43:\"Přesměrujte z jedné adresy URL na jinou.\";s:2:\"da\";s:35:\"Omadresser fra en URL til en anden.\";s:2:\"el\";s:81:\"Ανακατευθείνετε μια διεύθυνση URL σε μια άλλη\";s:2:\"es\";s:34:\"Redireccionar desde una URL a otra\";s:2:\"fa\";s:63:\"انتقال دادن یک صفحه به یک آدرس دیگر\";s:2:\"fi\";s:45:\"Uudelleenohjaa käyttäjän paikasta toiseen.\";s:2:\"fr\";s:34:\"Redirection d\'une URL à un autre.\";s:2:\"he\";s:43:\"הפניות מכתובת אחת לאחרת\";s:2:\"id\";s:40:\"Redirect dari satu URL ke URL yang lain.\";s:2:\"it\";s:35:\"Reindirizza da una URL ad un altra.\";s:2:\"lt\";s:56:\"Peradresuokite puslapį iš vieno adreso (URL) į kitą.\";s:2:\"nl\";s:38:\"Verwijs vanaf een URL naar een andere.\";s:2:\"ru\";s:78:\"Перенаправления с одного адреса на другой.\";s:2:\"sl\";s:44:\"Preusmeritev iz enega URL naslova na drugega\";s:2:\"tw\";s:33:\"將網址轉址、重新定向。\";s:2:\"cn\";s:33:\"将网址转址、重新定向。\";s:2:\"hu\";s:38:\"Egy URL átirányítása egy másikra.\";s:2:\"pl\";s:44:\"Przekierowanie z jednego adresu URL na inny.\";s:2:\"th\";s:123:\"เปลี่ยนเส้นทางจากที่หนึ่งไปยังอีกที่หนึ่ง\";s:2:\"se\";s:38:\"Omdirigera från en URL till en annan.\";}', '0', '0', '1', 'structure', '0', '1', '1', '1414575736');
INSERT INTO `default_modules` VALUES ('16', 'a:10:{s:2:\"en\";s:6:\"Search\";s:2:\"br\";s:7:\"Procura\";s:2:\"fr\";s:9:\"Recherche\";s:2:\"se\";s:4:\"Sök\";s:2:\"ar\";s:10:\"البحث\";s:2:\"tw\";s:6:\"搜尋\";s:2:\"cn\";s:6:\"搜寻\";s:2:\"it\";s:7:\"Ricerca\";s:2:\"fa\";s:10:\"جستجو\";s:2:\"fi\";s:4:\"Etsi\";}', 'search', '1.0.0', null, 'a:10:{s:2:\"en\";s:72:\"Search through various types of content with this modular search system.\";s:2:\"br\";s:73:\"Procure por vários tipos de conteúdo com este sistema de busca modular.\";s:2:\"fr\";s:84:\"Rechercher parmi différents types de contenus avec système de recherche modulaire.\";s:2:\"se\";s:36:\"Sök igenom olika typer av innehåll\";s:2:\"ar\";s:102:\"ابحث في أنواع مختلفة من المحتوى باستخدام نظام البحث هذا.\";s:2:\"tw\";s:63:\"此模組可用以搜尋網站中不同類型的資料內容。\";s:2:\"cn\";s:63:\"此模组可用以搜寻网站中不同类型的资料内容。\";s:2:\"it\";s:71:\"Cerca tra diversi tipi di contenuti con il sistema di reicerca modulare\";s:2:\"fa\";s:115:\"توسط این ماژول می توانید در محتواهای مختلف وبسایت جستجو نمایید.\";s:2:\"fi\";s:76:\"Etsi eri tyypistä sisältöä tällä modulaarisella hakujärjestelmällä.\";}', '0', '0', '0', '0', '1', '1', '1', '1414575736');
INSERT INTO `default_modules` VALUES ('17', 'a:20:{s:2:\"en\";s:7:\"Sitemap\";s:2:\"ar\";s:23:\"خريطة الموقع\";s:2:\"br\";s:12:\"Mapa do Site\";s:2:\"pt\";s:12:\"Mapa do Site\";s:2:\"de\";s:7:\"Sitemap\";s:2:\"el\";s:31:\"Χάρτης Ιστότοπου\";s:2:\"es\";s:14:\"Mapa del Sitio\";s:2:\"fa\";s:17:\"نقشه سایت\";s:2:\"fi\";s:10:\"Sivukartta\";s:2:\"fr\";s:12:\"Plan du site\";s:2:\"id\";s:10:\"Peta Situs\";s:2:\"it\";s:14:\"Mappa del sito\";s:2:\"lt\";s:16:\"Svetainės medis\";s:2:\"nl\";s:7:\"Sitemap\";s:2:\"ru\";s:21:\"Карта сайта\";s:2:\"tw\";s:12:\"網站地圖\";s:2:\"cn\";s:12:\"网站地图\";s:2:\"th\";s:21:\"ไซต์แมพ\";s:2:\"hu\";s:13:\"Oldaltérkép\";s:2:\"se\";s:9:\"Sajtkarta\";}', 'sitemap', '1.3.0', null, 'a:21:{s:2:\"en\";s:87:\"The sitemap module creates an index of all pages and an XML sitemap for search engines.\";s:2:\"ar\";s:120:\"وحدة خريطة الموقع تنشئ فهرساً لجميع الصفحات وملف XML لمحركات البحث.\";s:2:\"br\";s:102:\"O módulo de mapa do site cria um índice de todas as páginas e um sitemap XML para motores de busca.\";s:2:\"pt\";s:102:\"O módulo do mapa do site cria um índice de todas as páginas e um sitemap XML para motores de busca.\";s:2:\"da\";s:86:\"Sitemapmodulet opretter et indeks over alle sider og et XML sitemap til søgemaskiner.\";s:2:\"de\";s:92:\"Die Sitemap Modul erstellt einen Index aller Seiten und eine XML-Sitemap für Suchmaschinen.\";s:2:\"el\";s:190:\"Δημιουργεί έναν κατάλογο όλων των σελίδων και έναν χάρτη σελίδων σε μορφή XML για τις μηχανές αναζήτησης.\";s:2:\"es\";s:111:\"El módulo de mapa crea un índice de todas las páginas y un mapa del sitio XML para los motores de búsqueda.\";s:2:\"fa\";s:150:\"ماژول نقشه سایت یک لیست از همه ی صفحه ها به فرمت فایل XML برای موتور های جستجو می سازد\";s:2:\"fi\";s:82:\"sivukartta moduuli luo hakemisto kaikista sivuista ja XML sivukartta hakukoneille.\";s:2:\"fr\";s:106:\"Le module sitemap crée un index de toutes les pages et un plan de site XML pour les moteurs de recherche.\";s:2:\"id\";s:110:\"Modul peta situs ini membuat indeks dari setiap halaman dan sebuah format XML untuk mempermudah mesin pencari.\";s:2:\"it\";s:104:\"Il modulo mappa del sito crea un indice di tutte le pagine e una sitemap in XML per i motori di ricerca.\";s:2:\"lt\";s:86:\"struktūra modulis sukuria visų puslapių ir XML Sitemap paieškos sistemų indeksas.\";s:2:\"nl\";s:89:\"De sitemap module maakt een index van alle pagina\'s en een XML sitemap voor zoekmachines.\";s:2:\"ru\";s:144:\"Карта модуль создает индекс всех страниц и карта сайта XML для поисковых систем.\";s:2:\"tw\";s:84:\"站點地圖模塊創建一個索引的所有網頁和XML網站地圖搜索引擎。\";s:2:\"cn\";s:84:\"站点地图模块创建一个索引的所有网页和XML网站地图搜索引擎。\";s:2:\"th\";s:202:\"โมดูลไซต์แมพสามารถสร้างดัชนีของหน้าเว็บทั้งหมดสำหรับเครื่องมือค้นหา.\";s:2:\"hu\";s:94:\"Ez a modul indexeli az összes oldalt és egy XML oldaltéképet generál a keresőmotoroknak.\";s:2:\"se\";s:86:\"Sajtkarta, modulen skapar ett index av alla sidor och en XML-sitemap för sökmotorer.\";}', '0', '1', '0', 'content', '1', '1', '1', '1414575736');
INSERT INTO `default_modules` VALUES ('18', 'a:25:{s:2:\"en\";s:5:\"Users\";s:2:\"ar\";s:20:\"المستخدمون\";s:2:\"br\";s:9:\"Usuários\";s:2:\"pt\";s:12:\"Utilizadores\";s:2:\"cs\";s:11:\"Uživatelé\";s:2:\"da\";s:7:\"Brugere\";s:2:\"de\";s:8:\"Benutzer\";s:2:\"el\";s:14:\"Χρήστες\";s:2:\"es\";s:8:\"Usuarios\";s:2:\"fa\";s:14:\"کاربران\";s:2:\"fi\";s:12:\"Käyttäjät\";s:2:\"fr\";s:12:\"Utilisateurs\";s:2:\"he\";s:14:\"משתמשים\";s:2:\"id\";s:8:\"Pengguna\";s:2:\"it\";s:6:\"Utenti\";s:2:\"lt\";s:10:\"Vartotojai\";s:2:\"nl\";s:10:\"Gebruikers\";s:2:\"pl\";s:12:\"Użytkownicy\";s:2:\"ru\";s:24:\"Пользователи\";s:2:\"sl\";s:10:\"Uporabniki\";s:2:\"tw\";s:6:\"用戶\";s:2:\"cn\";s:6:\"用户\";s:2:\"hu\";s:14:\"Felhasználók\";s:2:\"th\";s:27:\"ผู้ใช้งาน\";s:2:\"se\";s:10:\"Användare\";}', 'users', '1.1.0', null, 'a:25:{s:2:\"en\";s:81:\"Let users register and log in to the site, and manage them via the control panel.\";s:2:\"ar\";s:133:\"تمكين المستخدمين من التسجيل والدخول إلى الموقع، وإدارتهم من لوحة التحكم.\";s:2:\"br\";s:125:\"Permite com que usuários se registrem e entrem no site e também que eles sejam gerenciáveis apartir do painel de controle.\";s:2:\"pt\";s:125:\"Permite com que os utilizadores se registem e entrem no site e também que eles sejam geriveis apartir do painel de controlo.\";s:2:\"cs\";s:103:\"Umožňuje uživatelům se registrovat a přihlašovat a zároveň jejich správu v Kontrolním panelu.\";s:2:\"da\";s:89:\"Lader brugere registrere sig og logge ind på sitet, og håndtér dem via kontrolpanelet.\";s:2:\"de\";s:108:\"Erlaube Benutzern das Registrieren und Einloggen auf der Seite und verwalte sie über die Admin-Oberfläche.\";s:2:\"el\";s:208:\"Παρέχει λειτουργίες εγγραφής και σύνδεσης στους επισκέπτες. Επίσης από εδώ γίνεται η διαχείριση των λογαριασμών.\";s:2:\"es\";s:138:\"Permite el registro de nuevos usuarios quienes podrán loguearse en el sitio. Estos podrán controlarse desde el panel de administración.\";s:2:\"fa\";s:151:\"به کاربر ها امکان ثبت نام و لاگین در سایت را بدهید و آنها را در پنل مدیریت نظارت کنید\";s:2:\"fi\";s:126:\"Antaa käyttäjien rekisteröityä ja kirjautua sisään sivustolle sekä mahdollistaa niiden muokkaamisen hallintapaneelista.\";s:2:\"fr\";s:112:\"Permet aux utilisateurs de s\'enregistrer et de se connecter au site et de les gérer via le panneau de contrôle\";s:2:\"he\";s:62:\"ניהול משתמשים: רישום, הפעלה ומחיקה\";s:2:\"id\";s:102:\"Memungkinkan pengguna untuk mendaftar dan masuk ke dalam situs, dan mengaturnya melalui control panel.\";s:2:\"it\";s:95:\"Fai iscrivere de entrare nel sito gli utenti, e gestiscili attraverso il pannello di controllo.\";s:2:\"lt\";s:106:\"Leidžia vartotojams registruotis ir prisijungti prie puslapio, ir valdyti juos per administravimo panele.\";s:2:\"nl\";s:88:\"Laat gebruikers registreren en inloggen op de site, en beheer ze via het controlepaneel.\";s:2:\"pl\";s:87:\"Pozwól użytkownikom na logowanie się na stronie i zarządzaj nimi za pomocą panelu.\";s:2:\"ru\";s:155:\"Управление зарегистрированными пользователями, активирование новых пользователей.\";s:2:\"sl\";s:96:\"Dovoli uporabnikom za registracijo in prijavo na strani, urejanje le teh preko nadzorne plošče\";s:2:\"tw\";s:87:\"讓用戶可以註冊並登入網站，並且管理者可在控制台內進行管理。\";s:2:\"cn\";s:87:\"让用户可以注册并登入网站，并且管理者可在控制台内进行管理。\";s:2:\"th\";s:210:\"ให้ผู้ใช้ลงทะเบียนและเข้าสู่เว็บไซต์และจัดการกับพวกเขาผ่านทางแผงควบคุม\";s:2:\"hu\";s:120:\"Hogy a felhasználók tudjanak az oldalra regisztrálni és belépni, valamint lehessen őket kezelni a vezérlőpulton.\";s:2:\"se\";s:111:\"Låt dina besökare registrera sig och logga in på webbplatsen. Hantera sedan användarna via kontrollpanelen.\";}', '0', '0', '1', '0', '1', '1', '1', '1416043264');
INSERT INTO `default_modules` VALUES ('19', 'a:25:{s:2:\"en\";s:9:\"Variables\";s:2:\"ar\";s:20:\"المتغيّرات\";s:2:\"br\";s:10:\"Variáveis\";s:2:\"pt\";s:10:\"Variáveis\";s:2:\"cs\";s:10:\"Proměnné\";s:2:\"da\";s:8:\"Variable\";s:2:\"de\";s:9:\"Variablen\";s:2:\"el\";s:20:\"Μεταβλητές\";s:2:\"es\";s:9:\"Variables\";s:2:\"fa\";s:16:\"متغییرها\";s:2:\"fi\";s:9:\"Muuttujat\";s:2:\"fr\";s:9:\"Variables\";s:2:\"he\";s:12:\"משתנים\";s:2:\"id\";s:8:\"Variabel\";s:2:\"it\";s:9:\"Variabili\";s:2:\"lt\";s:10:\"Kintamieji\";s:2:\"nl\";s:10:\"Variabelen\";s:2:\"pl\";s:7:\"Zmienne\";s:2:\"ru\";s:20:\"Переменные\";s:2:\"sl\";s:13:\"Spremenljivke\";s:2:\"tw\";s:12:\"系統變數\";s:2:\"cn\";s:12:\"系统变数\";s:2:\"th\";s:18:\"ตัวแปร\";s:2:\"se\";s:9:\"Variabler\";s:2:\"hu\";s:10:\"Változók\";}', 'variables', '1.0.0', null, 'a:25:{s:2:\"en\";s:59:\"Manage global variables that can be accessed from anywhere.\";s:2:\"ar\";s:97:\"إدارة المُتغيّرات العامة لاستخدامها في أرجاء الموقع.\";s:2:\"br\";s:61:\"Gerencia as variáveis globais acessíveis de qualquer lugar.\";s:2:\"pt\";s:58:\"Gerir as variáveis globais acessíveis de qualquer lugar.\";s:2:\"cs\";s:56:\"Spravujte globální proměnné přístupné odkudkoliv.\";s:2:\"da\";s:51:\"Håndtér globale variable som kan tilgås overalt.\";s:2:\"de\";s:74:\"Verwaltet globale Variablen, auf die von überall zugegriffen werden kann.\";s:2:\"el\";s:129:\"Διαχείριση μεταβλητών που είναι προσβάσιμες από παντού στον ιστότοπο.\";s:2:\"es\";s:50:\"Manage global variables to access from everywhere.\";s:2:\"fa\";s:136:\"مدیریت متغییر های جامع که می توانند در هر جای سایت مورد استفاده قرار بگیرند\";s:2:\"fi\";s:66:\"Hallitse globaali muuttujia, joihin pääsee käsiksi mistä vain.\";s:2:\"fr\";s:92:\"Gérer des variables globales pour pouvoir y accéder depuis n\'importe quel endroit du site.\";s:2:\"he\";s:96:\"ניהול משתנים גלובליים אשר ניתנים להמרה בכל חלקי האתר\";s:2:\"id\";s:59:\"Mengatur variabel global yang dapat diakses dari mana saja.\";s:2:\"it\";s:58:\"Gestisci le variabili globali per accedervi da ogni parte.\";s:2:\"lt\";s:64:\"Globalių kintamujų tvarkymas kurie yra pasiekiami iš bet kur.\";s:2:\"nl\";s:54:\"Beheer globale variabelen die overal beschikbaar zijn.\";s:2:\"pl\";s:86:\"Zarządzaj globalnymi zmiennymi do których masz dostęp z każdego miejsca aplikacji.\";s:2:\"ru\";s:136:\"Управление глобальными переменными, которые доступны в любом месте сайта.\";s:2:\"sl\";s:53:\"Urejanje globalnih spremenljivk za dostop od kjerkoli\";s:2:\"th\";s:148:\"จัดการตัวแปรทั่วไปโดยที่สามารถเข้าถึงได้จากทุกที่.\";s:2:\"tw\";s:45:\"管理此網站內可存取的全局變數。\";s:2:\"cn\";s:45:\"管理此网站内可存取的全局变数。\";s:2:\"hu\";s:62:\"Globális változók kezelése a hozzáféréshez, bárhonnan.\";s:2:\"se\";s:66:\"Hantera globala variabler som kan avändas över hela webbplatsen.\";}', '0', '0', '1', 'data', '0', '1', '1', '1414575736');
INSERT INTO `default_modules` VALUES ('20', 'a:23:{s:2:\"en\";s:7:\"Widgets\";s:2:\"br\";s:7:\"Widgets\";s:2:\"pt\";s:7:\"Widgets\";s:2:\"cs\";s:7:\"Widgety\";s:2:\"da\";s:7:\"Widgets\";s:2:\"de\";s:7:\"Widgets\";s:2:\"el\";s:7:\"Widgets\";s:2:\"es\";s:7:\"Widgets\";s:2:\"fa\";s:13:\"ویجت ها\";s:2:\"fi\";s:9:\"Vimpaimet\";s:2:\"fr\";s:7:\"Widgets\";s:2:\"id\";s:6:\"Widget\";s:2:\"it\";s:7:\"Widgets\";s:2:\"lt\";s:11:\"Papildiniai\";s:2:\"nl\";s:7:\"Widgets\";s:2:\"ru\";s:14:\"Виджеты\";s:2:\"sl\";s:9:\"Vtičniki\";s:2:\"tw\";s:9:\"小組件\";s:2:\"cn\";s:9:\"小组件\";s:2:\"hu\";s:9:\"Widget-ek\";s:2:\"th\";s:21:\"วิดเจ็ต\";s:2:\"se\";s:8:\"Widgetar\";s:2:\"ar\";s:14:\"الودجتس\";}', 'widgets', '1.2.0', null, 'a:23:{s:2:\"en\";s:69:\"Manage small sections of self-contained logic in blocks or \"Widgets\".\";s:2:\"ar\";s:132:\"إدارة أقسام صغيرة من البرمجيات في مساحات الموقع أو ما يُسمّى بالـ\"ودجتس\".\";s:2:\"br\";s:77:\"Gerenciar pequenas seções de conteúdos em bloco conhecidos como \"Widgets\".\";s:2:\"pt\";s:74:\"Gerir pequenas secções de conteúdos em bloco conhecidos como \"Widgets\".\";s:2:\"cs\";s:56:\"Spravujte malé funkční části webu neboli \"Widgety\".\";s:2:\"da\";s:74:\"Håndter små sektioner af selv-opretholdt logik i blokke eller \"Widgets\".\";s:2:\"de\";s:62:\"Verwaltet kleine, eigentständige Bereiche, genannt \"Widgets\".\";s:2:\"el\";s:149:\"Διαχείριση μικρών τμημάτων αυτόνομης προγραμματιστικής λογικής σε πεδία ή \"Widgets\".\";s:2:\"es\";s:75:\"Manejar pequeñas secciones de lógica autocontenida en bloques o \"Widgets\"\";s:2:\"fa\";s:76:\"مدیریت قسمت های کوچکی از سایت به طور مستقل\";s:2:\"fi\";s:81:\"Hallitse pieniä osioita, jotka sisältävät erillisiä lohkoja tai \"Vimpaimia\".\";s:2:\"fr\";s:41:\"Gérer des mini application ou \"Widgets\".\";s:2:\"id\";s:101:\"Mengatur bagian-bagian kecil dari blok-blok yang memuat sesuatu atau dikenal dengan istilah \"Widget\".\";s:2:\"it\";s:70:\"Gestisci piccole sezioni di logica a se stante in blocchi o \"Widgets\".\";s:2:\"lt\";s:43:\"Nedidelių, savarankiškų blokų valdymas.\";s:2:\"nl\";s:75:\"Beheer kleine onderdelen die zelfstandige logica bevatten, ofwel \"Widgets\".\";s:2:\"ru\";s:91:\"Управление небольшими, самостоятельными блоками.\";s:2:\"sl\";s:61:\"Urejanje manjših delov blokov strani ti. Vtičniki (Widgets)\";s:2:\"tw\";s:103:\"可將小段的程式碼透過小組件來管理。即所謂 \"Widgets\"，或稱為小工具、部件。\";s:2:\"cn\";s:103:\"可将小段的程式码透过小组件来管理。即所谓 \"Widgets\"，或称为小工具、部件。\";s:2:\"hu\";s:56:\"Önálló kis logikai tömbök vagy widget-ek kezelése.\";s:2:\"th\";s:152:\"จัดการส่วนเล็ก ๆ ในรูปแบบของตัวเองในบล็อกหรือวิดเจ็ต\";s:2:\"se\";s:83:\"Hantera små sektioner med egen logik och innehåll på olika delar av webbplatsen.\";}', '1', '0', '1', 'content', '0', '1', '1', '1414575736');
INSERT INTO `default_modules` VALUES ('21', 'a:10:{s:2:\"en\";s:7:\"WYSIWYG\";s:2:\"br\";s:7:\"WYSIWYG\";s:2:\"fa\";s:7:\"WYSIWYG\";s:2:\"fr\";s:7:\"WYSIWYG\";s:2:\"pt\";s:7:\"WYSIWYG\";s:2:\"se\";s:15:\"HTML-redigerare\";s:2:\"tw\";s:7:\"WYSIWYG\";s:2:\"cn\";s:7:\"WYSIWYG\";s:2:\"ar\";s:27:\"المحرر الرسومي\";s:2:\"it\";s:7:\"WYSIWYG\";}', 'wysiwyg', '1.0.0', null, 'a:11:{s:2:\"en\";s:56:\"Provides the WYSIWYG editor for CMS powered by CKEditor.\";s:2:\"br\";s:60:\"Provém o editor WYSIWYG para o CMS fornecido pelo CKEditor.\";s:2:\"fa\";s:73:\"ویرایشگر WYSIWYG که توسطCKEditor ارائه شده است. \";s:2:\"fr\";s:59:\"Fournit un éditeur WYSIWYG pour CMS propulsé par CKEditor\";s:2:\"pt\";s:57:\"Fornece o editor WYSIWYG para o CMS, powered by CKEditor.\";s:2:\"el\";s:109:\"Παρέχει τον επεξεργαστή WYSIWYG για το CMS, χρησιμοποιεί το CKEDitor.\";s:2:\"se\";s:37:\"Redigeringsmodul för HTML, CKEditor.\";s:2:\"tw\";s:79:\"提供 CMS 所見即所得（WYSIWYG）編輯器，由 CKEditor 技術提供。\";s:2:\"cn\";s:79:\"提供 CMS 所见即所得（WYSIWYG）编辑器，由 CKEditor 技术提供。\";s:2:\"ar\";s:72:\"توفر المُحرّر الرسومي لـCMS من خلال CKEditor.\";s:2:\"it\";s:57:\"Fornisce l\'editor WYSIWYG per PtroCMS creato con CKEditor\";}', '0', '0', '0', '0', '1', '1', '1', '1414575736');
INSERT INTO `default_modules` VALUES ('22', 'a:1:{s:2:\"en\";s:10:\"Membership\";}', 'membership', '2.0.0', null, 'a:1:{s:2:\"en\";s:28:\"This is a Membership Module.\";}', '0', '1', '1', '0', '1', '1', '0', '1414575736');
INSERT INTO `default_modules` VALUES ('23', 'a:1:{s:2:\"en\";s:8:\"Merchant\";}', 'merchant', '2.0.0', null, 'a:1:{s:2:\"en\";s:26:\"This is a Merchant Module.\";}', '0', '1', '1', '0', '1', '1', '0', '1414575736');
INSERT INTO `default_modules` VALUES ('24', 'a:1:{s:2:\"en\";s:9:\"Affiliate\";}', 'affiliate', '2.0.0', null, 'a:1:{s:2:\"en\";s:27:\"This is a Affiliate Module.\";}', '0', '1', '1', '0', '1', '1', '0', '1414575736');
INSERT INTO `default_modules` VALUES ('25', 'a:1:{s:2:\"en\";s:4:\"Home\";}', 'home', '2.0.0', null, 'a:1:{s:2:\"en\";s:22:\"This is a Home Module.\";}', '0', '1', '1', '0', '1', '1', '0', '1414575736');
INSERT INTO `default_modules` VALUES ('40', 'a:1:{s:2:\"en\";s:8:\"Services\";}', 'services', '2.0.0', null, 'a:1:{s:2:\"en\";s:26:\"This is a Services Module.\";}', '0', '1', '0', '0', '1', '1', '0', '1414487824');
INSERT INTO `default_modules` VALUES ('39', 'a:1:{s:2:\"en\";s:7:\"Request\";}', 'request', '2.0.0', null, 'a:1:{s:2:\"en\";s:25:\"This is a Request Module.\";}', '0', '1', '1', '0', '1', '1', '0', '1416549403');
INSERT INTO `default_modules` VALUES ('37', 'a:1:{s:2:\"en\";s:14:\"CaptchaHandler\";}', 'captchahandler', '2.0.0', null, 'a:1:{s:2:\"en\";s:32:\"This is a CaptchaHandler Module.\";}', '0', '1', '1', '0', '1', '1', '1', '1414575736');
INSERT INTO `default_modules` VALUES ('38', 'a:1:{s:2:\"en\";s:16:\"CaptchaResources\";}', 'captcharesources', '2.0.0', null, 'a:1:{s:2:\"en\";s:34:\"This is a CaptchaResources Module.\";}', '0', '1', '1', '0', '1', '1', '1', '1414575736');
INSERT INTO `default_modules` VALUES ('41', 'a:1:{s:2:\"en\";s:4:\"Chat\";}', 'chat', '2.0.0', null, 'a:1:{s:2:\"en\";s:22:\"This is a Chat Module.\";}', '0', '1', '1', '0', '1', '1', '0', '1415424411');
INSERT INTO `default_modules` VALUES ('43', 'a:1:{s:2:\"en\";s:6:\"Blocks\";}', 'cms', '2.0.0', null, 'a:1:{s:2:\"en\";s:23:\"This is a Block Module.\";}', '0', '0', '1', 'content', '0', '1', '0', '1416043264');

-- ----------------------------
-- Table structure for `default_navigation_groups`
-- ----------------------------
DROP TABLE IF EXISTS `default_navigation_groups`;
CREATE TABLE `default_navigation_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `abbrev` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `abbrev` (`abbrev`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_navigation_groups
-- ----------------------------
INSERT INTO `default_navigation_groups` VALUES ('1', 'Header', 'header');
INSERT INTO `default_navigation_groups` VALUES ('2', 'Sidebar', 'sidebar');
INSERT INTO `default_navigation_groups` VALUES ('3', 'Footer', 'footer');

-- ----------------------------
-- Table structure for `default_navigation_links`
-- ----------------------------
DROP TABLE IF EXISTS `default_navigation_links`;
CREATE TABLE `default_navigation_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `parent` int(11) DEFAULT NULL,
  `link_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'uri',
  `page_id` int(11) DEFAULT NULL,
  `module_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `navigation_group_id` int(5) NOT NULL DEFAULT '0',
  `position` int(5) NOT NULL DEFAULT '0',
  `target` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `restricted_to` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `class` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `navigation_group_id` (`navigation_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_navigation_links
-- ----------------------------
INSERT INTO `default_navigation_links` VALUES ('1', 'Home', '0', 'uri', '0', '0', '', '', '1', '0', '', '0', '');
INSERT INTO `default_navigation_links` VALUES ('2', 'Merchant', '0', 'module', '0', 'merchant', '', '', '1', '1', '', '0', '');
INSERT INTO `default_navigation_links` VALUES ('4', 'Affiliate', '0', 'module', '0', 'affiliate', '', '', '1', '2', '', '0', '');
INSERT INTO `default_navigation_links` VALUES ('5', 'About-Us', '0', 'page', '6', '', '', '', '1', '4', '', '0', '');
INSERT INTO `default_navigation_links` VALUES ('6', 'Contact-Us', '0', 'page', '2', '', '', '', '1', '5', '', '0', '');
INSERT INTO `default_navigation_links` VALUES ('10', 'Testimonial', null, 'uri', '0', '', '', 'users/testimonial', '3', '1', '', '0', '');
INSERT INTO `default_navigation_links` VALUES ('12', 'Dashbord', null, 'page', '9', '', '', '', '2', '1', '', '0', '');
INSERT INTO `default_navigation_links` VALUES ('14', 'About-Us', null, 'page', '6', '', '', '', '3', '2', '', '0', '');
INSERT INTO `default_navigation_links` VALUES ('15', 'Support', '0', 'page', '11', '', '', '', '1', '3', '', '0', '');
INSERT INTO `default_navigation_links` VALUES ('17', 'Privacy Policy', null, 'page', '13', '', '', '', '3', '3', '', '0', '');

-- ----------------------------
-- Table structure for `default_page_types`
-- ----------------------------
DROP TABLE IF EXISTS `default_page_types`;
CREATE TABLE `default_page_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `stream_id` int(11) NOT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_keywords` char(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8_unicode_ci,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `css` text COLLATE utf8_unicode_ci,
  `js` text COLLATE utf8_unicode_ci,
  `theme_layout` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
  `updated_on` int(11) NOT NULL,
  `save_as_files` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n',
  `content_label` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title_label` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_page_types
-- ----------------------------
INSERT INTO `default_page_types` VALUES ('1', 'default', 'Default', 'A simple page type with a WYSIWYG editor that will get you started adding content.', '2', null, null, null, '<h2>{{ page:title }}</h2>\n\n{{ body }}', '', '', 'default', '1406876177', 'n', null, null);

-- ----------------------------
-- Table structure for `default_pages`
-- ----------------------------
DROP TABLE IF EXISTS `default_pages`;
CREATE TABLE `default_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `class` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `uri` text COLLATE utf8_unicode_ci,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `type_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `entry_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `css` text COLLATE utf8_unicode_ci,
  `js` text COLLATE utf8_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_keywords` char(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_robots_no_index` tinyint(1) DEFAULT NULL,
  `meta_robots_no_follow` tinyint(1) DEFAULT NULL,
  `meta_description` text COLLATE utf8_unicode_ci,
  `rss_enabled` int(1) NOT NULL DEFAULT '0',
  `comments_enabled` int(1) NOT NULL DEFAULT '0',
  `status` enum('draft','live') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'draft',
  `created_on` int(11) NOT NULL DEFAULT '0',
  `updated_on` int(11) NOT NULL DEFAULT '0',
  `restricted_to` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_home` int(1) NOT NULL DEFAULT '0',
  `strict_uri` tinyint(1) NOT NULL DEFAULT '1',
  `order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `slug` (`slug`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_pages
-- ----------------------------
INSERT INTO `default_pages` VALUES ('1', 'home', '', 'Home', 'home', '0', '1', '1', '', '', '', '', '0', '0', '', '0', '0', 'live', '1406876177', '1415970485', '0', '1', '1', '0');
INSERT INTO `default_pages` VALUES ('2', 'contact-Us', '', 'Contact Us', 'contact-Us', '0', '1', '2', '', '', '', '', '0', '0', '', '0', '0', 'live', '1406876177', '1418364171', '0', '0', '1', '2');
INSERT INTO `default_pages` VALUES ('3', 'search', '', 'Search', 'search', '0', '1', '3', null, null, null, '', null, null, null, '0', '0', 'live', '1406876177', '0', '', '0', '1', '3');
INSERT INTO `default_pages` VALUES ('4', 'results', '', 'Results', 'search/results', '3', '1', '4', null, null, null, '', null, null, null, '0', '0', 'live', '1406876177', '0', '', '0', '0', '0');
INSERT INTO `default_pages` VALUES ('5', '404', '', 'Page missing', '404', '0', '1', '5', null, null, null, '', null, null, null, '0', '0', 'live', '1406876177', '0', '', '0', '1', '4');
INSERT INTO `default_pages` VALUES ('6', 'about-Us', '', 'About-Us', 'about-Us', '0', '1', '6', '', '', '', '', '0', '0', '', '0', '0', 'live', '1409573018', '1415090012', '0', '0', '1', '1');
INSERT INTO `default_pages` VALUES ('9', 'affiliates', '', 'Affiliates', 'dashbord', '0', '1', '9', '', '', '', '', '0', '0', '', '0', '0', 'live', '1410595186', '1415968705', '0', '0', '1', '1410595186');
INSERT INTO `default_pages` VALUES ('10', 'merchants', '', 'Merchants', 'merchant', '0', '1', '10', '', '', '', '', '0', '0', '', '0', '0', 'draft', '1410873084', '1410873136', '0', '0', '1', '1410873084');
INSERT INTO `default_pages` VALUES ('11', 'support', '', 'Support', 'support', '0', '1', '11', '', '', '', '', '0', '0', '', '0', '0', 'live', '1411108529', '1417615292', '0', '0', '1', '1411108529');
INSERT INTO `default_pages` VALUES ('13', 'privacy-policy', '', 'Privacy Policy', 'privacy-policy', '0', '1', '13', '', '', '', '', '0', '0', '', '0', '0', 'live', '1411111877', '1411127778', '0', '0', '1', '1411111877');
INSERT INTO `default_pages` VALUES ('15', 'terms-and-conditions', '', 'Terms & Conditions', 'terms-and-conditions', '0', '1', '15', '', '', '', '', '0', '0', '', '0', '0', 'live', '1411570631', '1411571460', '0', '0', '1', '1411570631');
INSERT INTO `default_pages` VALUES ('17', 'direct-deposit', '', 'Direct Deposit', 'direct-deposit', '0', '1', '17', '', '', '', '', '0', '0', '', '0', '0', 'draft', '1417261592', '1417261684', '0', '0', '1', '1417261592');

-- ----------------------------
-- Table structure for `default_permissions`
-- ----------------------------
DROP TABLE IF EXISTS `default_permissions`;
CREATE TABLE `default_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `module` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `roles` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for `default_product_testimonial_log`
-- ----------------------------
DROP TABLE IF EXISTS `default_product_testimonial_log`;
CREATE TABLE `default_product_testimonial_log` (
  `testimonial_id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` int(11) DEFAULT NULL,
  `banner_id` int(11) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`testimonial_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of default_product_testimonial_log
-- ----------------------------
INSERT INTO `default_product_testimonial_log` VALUES ('1', '55', '1', 'My Testimonials Title', 'test by roger', '2015-01-17 20:15:23');
INSERT INTO `default_product_testimonial_log` VALUES ('2', '55', '4', 'Hair oil', 'The exclusive iGrow handset allows you to choose from 5 different treatment settings for a customized treatment. The innovative iGrow design incorporates an iPod/MP3 connector so you can listen to your favorite music during your convenient 20 minute treatment, 2 to 3 times a week. After 10 to 12 weeks of regular use (as directed) you can expect to see thicker, fuller, healthier hair. Continued use yields even better results.', '2014-12-06 06:25:11');
INSERT INTO `default_product_testimonial_log` VALUES ('3', '124', '6', 'test test test testtest testtest testtest testtest testtest testtest testtest testtest testtest testtest testtest testtest testtest testtest testtest testtest testtest testtest test', 'test The World Is Not Enough\" is the theme song of the 1999 James Bond film of the same name, performed by alternative rock group Garbage (pictured in 2012). The song was written by composer David Arnold, who also scored the film, and lyricist Don Black, previously responsible for four other Bond songs. \"The World Is Not Enough\" was composed in the traditional style of the series\' title themes contrasting with the post-modern production technique and genre-hopping sound that Garbage had established on their first two albums. Garbage recorded the majority of \"The World Is Not Enough\" while touring Europe, telephoning Arnold as he recorded the orchestral backing in London before travelling to England themselves. Afterwards the band finished production of the song in Canada. The lyrics reflect the point of view of the film\'s antagonist Elektra King, with themes of world domination and seduction. The song and accompanying soundtrack were released by Radioactive Records as the film premiered around the world at the end of November 1999. Upon release, \"The World Is Not Enough\" was widely acclaimed by reviewers, and reached the top forty of ten singles charts. (Full article...) The World Is Not Enough\" is the theme song of the 1999 James Bond film of the same name, performed by alternative rock group Garbage (pictured in 2012). The song was written by composer David Arnold, who also scored the film, and lyricist Don Black, previously responsible for four other Bond songs. \"The World Is Not Enough\" was composed in the traditional style of the series\' title themes contrasting with the post-modern production technique and genre-hopping sound that Garbage had established on their first two albums. Garbage recorded the majority of \"The World Is Not Enough\" while touring Europe, telephoning Arnold as he recorded the orchestral backing in London before travelling to England themselves. Afterwards the band finished production of the song in Canada. The lyrics reflect the point of view of the film\'s antagonist Elektra King, with themes of world domination and seduction. The song and accompanying soundtrack were released by Radioactive Records as the film premiered around the world at the end of November 1999. Upon release, \"The World Is Not Enough\" was widely acclaimed by reviewers, and reached the top forty of ten singles charts. (Full article...)The World Is Not Enough\" is the theme song of the 1999 James Bond film of the same name, performed by alternative rock group Garbage (pictured in 2012). The song was written by composer David Arnold, who also scored the film, and lyricist Don Black, previously responsible for four other Bond songs. \"The World Is Not Enough\" was composed in the traditional style of the series\' title themes contrasting with the post-modern production technique and genre-hopping sound that Garbage had established on their first two albums. Garbage recorded the majority of \"The World Is Not Enough\" while touring Europe, telephoning Arnold as he recorded the orchestral backing in London before travelling to England themselves. Afterwards the band finished production of the song in Canada. The lyrics reflect the point of view of the film\'s antagonist Elektra King, with themes of world domination and seduction. The song and accompanying soundtrack were released by Radioactive Records as the film premiered around the world at the end of November 1999. Upon release, \"The World Is Not Enough\" was widely acclaimed by reviewers, and reached the top forty of ten singles charts. (Full article...)The World Is Not Enough\" is the theme song of the 1999 James Bond film of the same name, performed by alternative rock group Garbage (pictured in 2012). The song was written by composer David Arnold, who also scored the film, and lyricist Don Black, previously responsible for four other Bond songs. \"The World Is Not Enough\" was composed in the traditional style of the series\' title themes contrasting with the post-modern production technique and genre-hopping sound that Garbage had established on their first two albums. Garbage recorded the majority of \"The World Is Not Enough\" while touring Europe, telephoning Arnold as he recorded the orchestral backing in London before travelling to England themselves. Afterwards the band finished production of the song in Canada. The lyrics reflect the point of view of the film\'s antagonist Elektra King, with themes of world domination and seduction. The song and accompanying soundtrack were released by Radioactive Records as the film premiered around the world at the end of November 1999. Upon release, \"The World Is Not Enough\" was widely acclaimed by reviewers, and reached the top forty of ten singles charts. (Full article...)The World Is Not Enough\" is the theme song of the 1999 James Bond film of the same name, performed by alternative rock group Garbage (pictured in 2012). The song was written by composer David Arnold, who also scored the film, and lyricist Don Black, previously responsible for four other Bond songs. \"The World Is Not Enough\" was composed in the traditional style of the series\' title themes contrasting with the post-modern production technique and genre-hopping sound that Garbage had established on their first two albums. Garbage recorded the majority of \"The World Is Not Enough\" while touring Europe, telephoning Arnold as he recorded the orchestral backing in London before travelling to England themselves. Afterwards the band finished production of the song in Canada. The lyrics reflect the point of view of the film\'s antagonist Elektra King, with themes of world domination and seduction. The song and accompanying soundtrack were released by Radioactive Records as the film premiered around the world at the end of November 1999. Upon release, \"The World Is Not Enough\" was widely acclaimed by reviewers, and reached the top forty of ten singles charts. (Full article...)The World Is Not Enough\" is the theme song of the 1999 James Bond film of the same name, performed by alternative rock group Garbage (pictured in 2012). The song was written by composer David Arnold, who also scored the film, and lyricist Don Black, previously responsible for four other Bond songs. \"The World Is Not Enough\" was composed in the traditional style of the series\' title themes contrasting with the post-modern production technique and genre-hopping sound that Garbage had established on their first two albums. Garbage recorded the majority of \"The World Is Not Enough\" while touring Europe, telephoning Arnold as he recorded the orchestral backing in London before travelling to England themselves. Afterwards the band finished production of the song in Canada. The lyrics reflect the point of view of the film\'s antagonist Elektra King, with themes of world domination and seduction. The song and accompanying soundtrack were released by Radioactive Records as the film premiered around the world at the end of November 1999. Upon release, \"The World Is Not Enough\" was widely acclaimed by reviewers, and reached the top forty of ten singles charts. (Full article...)The World Is Not Enough\" is the theme song of the 1999 James Bond film of the same name, performed by alternative rock group Garbage (pictured in 2012). The song was written by composer David Arnold, who also scored the film, and lyricist Don Black, previously responsible for four other Bond songs. \"The World Is Not Enough\" was composed in the traditional style of the series\' title themes contrasting with the post-modern production technique and genre-hopping sound that Garbage had established on their first two albums. Garbage recorded the majority of \"The World Is Not Enough\" while touring Europe, telephoning Arnold as he recorded the orchestral backing in London before travelling to England themselves. Afterwards the band finished production of the song in Canada. The lyrics reflect the point of view of the film\'s antagonist Elektra King, with themes of world domination and seduction. The song and accompanying soundtrack were released by Radioactive Records as the film premiered around the world at the end of November 1999. Upon release, \"The World Is Not Enough\" was widely acclaimed by reviewers, and reached the top forty of ten singles charts. (Full article...)The World Is Not Enough\" is the theme song of the 1999 James Bond film of the same name, performed by alternative rock group Garbage (pictured in 2012). The song was written by composer David Arnold, who also scored the film, and lyricist Don Black, previously responsible for four other Bond songs. \"The World Is Not Enough\" was composed in the traditional style of the series\' title themes contrasting with the post-modern production technique and genre-hopping sound that Garbage had established on their first two albums. Garbage recorded the majority of \"The World Is Not Enough\" while touring Europe, telephoning Arnold as he recorded the orchestral backing in London before travelling to England themselves. Afterwards the band finished production of the song in Canada. The lyrics reflect the point of view of the film\'s antagonist Elektra King, with themes of world domination and seduction. The song and accompanying soundtrack were released by Radioactive Records as the film premiered around the world at the end of November 1999. Upon release, \"The World Is Not Enough\" was widely acclaimed by reviewers, and reached the top forty of ten singles charts. (Full article...)The World Is Not Enough\" is the theme song of the 1999 James Bond film of the same name, performed by alternative rock group Garbage (pictured in 2012). The song was written by composer David Arnold, who also scored the film, and lyricist Don Black, previously responsible for four other Bond songs. \"The World Is Not Enough\" was composed in the traditional style of the series\' title themes contrasting with the post-modern production technique and genre-hopping sound that Garbage had established on their first two albums. Garbage recorded the majority of \"The World Is Not Enough\" while touring Europe, telephoning Arnold as he recorded the orchestral backing in London before travelling to England themselves. Afterwards the band finished production of the song in Canada. The lyrics reflect the point of view of the film\'s antagonist Elektra King, with themes of world domination and seduction. The song and accompanying soundtrack were released by Radioactive Records as the film premiered around the world at the end of November 1999. Upon release, \"The World Is Not Enough\" was widely acclaimed by reviewers, and reached the top forty of ten singles charts. (Full article...)The World Is Not Enough\" is the theme song of the 1999 James Bond film of the same name, performed by alternative rock group Garbage (pictured in 2012). The song was written by composer David Arnold, who also scored the film, and lyricist Don Black, previously responsible for four other Bond songs. \"The World Is Not Enough\" was composed in the traditional style of the series\' title themes contrasting with the post-modern production technique and genre-hopping sound that Garbage had established on their first two albums. Garbage recorded the majority of \"The World Is Not Enough\" while touring Europe, telephoning Arnold as he recorded the orchestral backing in London before travelling to England themselves. Afterwards the band finished production of the song in Canada. The lyrics reflect the point of view of the film\'s antagonist Elektra King, with themes of world domination and seduction. The song and accompanying soundtrack were released by Radioactive Records as the film premiered around the world at the end of November 1999. Upon release, \"The World Is Not Enough\" was widely acclaimed by reviewers, and reached the top forty of ten singles charts. (Full article...) The World Is Not Enough\" is the theme song of the 1999 James Bond film of the same name, performed by alternative rock group Garbage (pictured in 2012). The song was written by composer David Arnold, who also scored the film, and lyricist Don Black, previously responsible for four other Bond songs. \"The World Is Not Enough\" was composed in the traditional style of the series\' title themes contrasting with the post-modern production technique and genre-hopping sound that Garbage had established on their first two albums. Garbage recorded the majority of \"The World Is Not Enough\" while touring Europe, telephoning Arnold as he recorded the orchestral backing in London before travelling to England themselves. Afterwards the band finished production of the song in Canada. The lyrics reflect the point of view of the film\'s antagonist Elektra King, with themes of world domination and seduction. The song and accompanying soundtrack were released by Radioactive Records as the film premiered around the world at the end of November 1999. Upon release, \"The World Is Not Enough\" was widely acclaimed by reviewers, and reached the top forty of ten singles charts. (Full article...)The World Is Not Enough\" is the theme song of the 1999 James Bond film of the same name, performed by alternative rock group Garbage (pictured in 2012). The song was written by composer David Arnold, who also scored the film, and lyricist Don Black, previously responsible for four other Bond songs. \"The World Is Not Enough\" was composed in the traditional style of the series\' title themes contrasting with the post-modern production technique and genre-hopping sound that Garbage had established on their first two albums. Garbage recorded the majority of \"The World Is Not Enough\" while touring Europe, telephoning Arnold as he recorded the orchestral backing in London before travelling to England themselves. Afterwards the band finished production of the song in Canada. The lyrics reflect the point of view of the film\'s antagonist Elektra King, with themes of world domination and seduction. The song and accompanying soundtrack were released by Radioactive Records as the film premiered around the world at the end of November 1999. Upon release, \"The World Is Not Enough\" was widely acclaimed by reviewers, and reached the top forty of ten singles charts. (Full article...)The World Is Not Enough\" is the theme song of the 1999 James Bond film of the same name, performed by alternative rock group Garbage (pictured in 2012). The song was written by composer David Arnold, who also scored the film, and lyricist Don Black, previously responsible for four other Bond songs. \"The World Is Not Enough\" was composed in the traditional style of the series\' title themes contrasting with the post-modern production technique and genre-hopping sound that Garbage had established on their first two albums. Garbage recorded the majority of \"The World Is Not Enough\" while touring Europe, telephoning Arnold as he recorded the orchestral backing in London before travelling to England themselves. Afterwards the band finished production of the song in Canada. The lyrics reflect the point of view of the film\'s antagonist Elektra King, with themes of world domination and seduction. The song and accompanying soundtrack were released by Radioactive Records as the film premiered around the world at the end of November 1999. Upon release, \"The World Is Not Enough\" was widely acclaimed by reviewers, and reached the top forty of ten singles charts. (Full article...)The World Is Not Enough\" is the theme song of the 1999 James Bond film of the same name, performed by alternative rock group Garbage (pictured in 2012). The song was written by composer David Arnold, who also scored the film, and lyricist Don Black, previously responsible for four other Bond songs. \"The World Is Not Enough\" was composed in the traditional style of the series\' title themes contrasting with the post-modern production technique and genre-hopping sound that Garbage had established on their first two albums. Garbage recorded the majority of \"The World Is Not Enough\" while touring Europe, telephoning Arnold as he recorded the orchestral backing in London before travelling to England themselves. Afterwards the band finished production of the song in Canada. The lyrics reflect the point of view of the film\'s antagonist Elektra King, with themes of world domination and seduction. The song and accompanying soundtrack were released by Radioactive Records as the film premiered around the world at the end of November 1999. Upon release, \"The World Is Not Enough\" was widely acclaimed by reviewers, and reached the top forty of ten singles charts. (Full article...)The World Is Not Enough\" is the theme song of the 1999 James Bond film of the same name, performed by alternative rock group Garbage (pictured in 2012). The song was written by composer David Arnold, who also scored the film, and lyricist Don Black, previously responsible for four other Bond songs. \"The World Is Not Enough\" was composed in the traditional style of the series\' title themes contrasting with the post-modern production technique and genre-hopping sound that Garbage had established on their first two albums. Garbage recorded the majority of \"The World Is Not Enough\" while touring Europe, telephoning Arnold as he recorded the orchestral backing in London before travelling to England themselves. Afterwards the band finished production of the song in Canada. The lyrics reflect the point of view of the film\'s antagonist Elektra King, with themes of world domination and seduction. The song and accompanying soundtrack were released by Radioactive Records as the film premiered around the world at the end of November 1999. Upon release, \"The World Is Not Enough\" was widely acclaimed by reviewers, and reached the top forty of ten singles charts. (Full article...)The World Is Not Enough\" is the theme song of the 1999 James Bond film of the same name, performed by alternative rock group Garbage (pictured in 2012). The song was written by composer David Arnold, who also scored the film, and lyricist Don Black, previously responsible for four other Bond songs. \"The World Is Not Enough\" was composed in the traditional style of the series\' title themes contrasting with the post-modern production technique and genre-hopping sound that Garbage had established on their first two albums. Garbage recorded the majority of \"The World Is Not Enough\" while touring Europe, telephoning Arnold as he recorded the orchestral backing in London before travelling to England themselves. Afterwards the band finished production of the song in Canada. The lyrics reflect the point of view of the film\'s antagonist Elektra King, with themes of world domination and seduction. The song and accompanying soundtrack were released by Radioactive Records as the film premiered around the world at the end of November 1999. Upon release, \"The World Is Not Enough\" was widely acclaimed by reviewers, and reached the top forty of ten singles charts. (Full article...)The World Is Not Enough\" is the theme song of the 1999 James Bond film of the same name, performed by alternative rock group Garbage (pictured in 2012). The song was written by composer David Arnold, who also scored the film, and lyricist Don Black, previously responsible for four other Bond songs. \"The World Is Not Enough\" was composed in the traditional style of the series\' title themes contrasting with the post-modern production technique and genre-hopping sound that Garbage had established on their first two albums. Garbage recorded the majority of \"The World Is Not Enough\" while touring Europe, telephoning Arnold as he recorded the orchestral backing in London before travelling to England themselves. Afterwards the band finished production of the song in Canada. The lyrics reflect the point of view of the film\'s antagonist Elektra King, with themes of world domination and seduction. The song and accompanying soundtrack were released by Radioactive Records as the film premiered around the world at the end of November 1999. Upon release, \"The World Is Not Enough\" was widely acclaimed by reviewers, and reached the top forty of ten singles charts. (Full article...)The World Is Not Enough\" is the theme song of the 1999 James Bond film of the same name, performed by alternative rock group Garbage (pictured in 2012). The song was written by composer David Arnold, who also scored the film, and lyricist Don Black, previously responsible for four other Bond songs. \"The World Is Not Enough\" was composed in the traditional style of the series\' title themes contrasting with the post-modern production technique and genre-hopping sound that Garbage had established on their first two albums. Garbage recorded the majority of \"The World Is Not Enough\" while touring Europe, telephoning Arnold as he recorded the orchestral backing in London before travelling to England themselves. Afterwards the band finished production of the song in Canada. The lyrics reflect the point of view of the film\'s antagonist Elektra King, with themes of world domination and seduction. The song and accompanying soundtrack were released by Radioactive Records as the film premiered around the world at the end of November 1999. Upon release, \"The World Is Not Enough\" was widely acclaimed by reviewers, and reached the top forty of ten singles charts. (Full article...)The World Is Not Enough\" is the theme song of the 1999 James Bond film of the same name, performed by alternative rock group Garbage (pictured in 2012). The song was written by composer David Arnold, who also scored the film, and lyricist Don Black, previously responsible for four other Bond songs. \"The World Is Not Enough\" was composed in the traditional style of the series\' title themes contrasting with the post-modern production technique and genre-hopping sound that Garbage had established on their first two albums. Garbage recorded the majority of \"The World Is Not Enough\" while touring Europe, telephoning Arnold as he recorded the orchestral backing in London before travelling to England themselves. Afterwards the band finished production of the song in Canada. The lyrics reflect the point of view of the film\'s antagonist Elektra King, with themes of world domination and seduction. The song and accompanying soundtrack were released by Radioactive Records as the film premiered around the world at the end of November 1999. Upon release, \"The World Is Not Enough\" was widely acclaimed by reviewers, and reached the top forty of ten singles charts. (Full article...)The World Is Not Enough\" is the theme song of the 1999 James Bond film of the same name, performed by alternative rock group Garbage (pictured in 2012). The song was written by composer David Arnold, who also scored the film, and lyricist Don Black, previously responsible for four other Bond songs. \"The World Is Not Enough\" was composed in the traditional style of the series\' title themes contrasting with the post-modern production technique and genre-hopping sound that Garbage had established on their first two albums. Garbage recorded the majority of \"The World Is Not Enough\" while touring Europe, telephoning Arnold as he recorded the orchestral backing in London before travelling to England themselves. Afterwards the band finished production of the song in Canada. The lyrics reflect the point of view of the film\'s antagonist Elektra King, with themes of world domination and seduction. The song and accompanying soundtrack were released by Radioactive Records as the film premiered around the world at the end of November 1999. Upon release, \"The World Is Not Enough\" was widely acclaimed by reviewers, and reached the top forty of ten singles charts. (Full article...)The World Is Not Enough\" is the theme song of the 1999 James Bond film of the same name, performed by alternative rock group Garbage (pictured in 2012). The song was written by composer David Arnold, who also scored the film, and lyricist Don Black, previously responsible for four other Bond songs. \"The World Is Not Enough\" was composed in the traditional style of the series\' title themes contrasting with the post-modern production technique and genre-hopping sound that Garbage had established on their first two albums. Garbage recorded the majority of \"The World Is Not Enough\" while touring Europe, telephoning Arnold as he recorded the orchestral backing in London before travelling to England themselves. Afterwards the band finished production of the song in Canada. The lyrics reflect the point of view of the film\'s antagonist Elektra King, with themes of world domination and seduction. The song and accompanying soundtrack were released by Radioactive Records as the film premiered around the world at the end of November 1999. Upon release, \"The World Is Not Enough\" was widely acclaimed by reviewers, and reached the top forty of ten singles charts. (Full article...)The World Is Not Enough\" is the theme song of the 1999 James Bond film of the same name, performed by alternative rock group Garbage (pictured in 2012). The song was written by composer David Arnold, who also scored the film, and lyricist Don Black, previously responsible for four other Bond songs. \"The World Is Not Enough\" was composed in the traditional style of the series\' title themes contrasting with the post-modern production technique and genre-hopping sound that Garbage had established on their first two albums. Garbage recorded the majority of \"The World Is Not Enough\" while touring Europe, telephoning Arnold as he recorded the orchestral backing in London before travelling to England themselves. Afterwards the band finished production of the song in Canada. The lyrics reflect the point of view of the film\'s antagonist Elektra King, with themes of world domination and seduction. The song and accompanying soundtrack were released by Radioactive Records as the film premiered around the world at the end of November 1999. Upon release, \"The World Is Not Enough\" was widely acclaimed by reviewers, and reached the top forty of ten singles charts. (Full article...)The World Is Not Enough\" is the theme song of the 1999 James Bond film of the same name, performed by alternative rock group Garbage (pictured in 2012). The song was written by composer David Arnold, who also scored the film, and lyricist Don Black, previously responsible for four other Bond songs. \"The World Is Not Enough\" was composed in the traditional style of the series\' title themes contrasting with the post-modern production technique and genre-hopping sound that Garbage had established on their first two albums. Garbage recorded the majority of \"The World Is Not Enough\" while touring Europe, telephoning Arnold as he recorded the orchestral backing in London before travelling to England themselves. Afterwards the band finished production of the song in Canada. The lyrics reflect the point of view of the film\'s antagonist Elektra King, with themes of world domination and seduction. The song and accompanying soundtrack were released by Radioactive Records as the film premiered around the world at the end of November 1999. Upon release, \"The World Is Not Enough\" was widely acclaimed by reviewers, and reached the top forty of ten singles charts. (Full article...)', '2014-11-26 11:40:10');
INSERT INTO `default_product_testimonial_log` VALUES ('4', '55', '2', 'My Testimonials', 'My Description will come here.', '2014-11-27 10:58:28');
INSERT INTO `default_product_testimonial_log` VALUES ('5', '147', '26', 'Test', 'Hello', '2014-12-05 12:18:17');

-- ----------------------------
-- Table structure for `default_profiles`
-- ----------------------------
DROP TABLE IF EXISTS `default_profiles`;
CREATE TABLE `default_profiles` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `ordering_count` int(11) DEFAULT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `display_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lang` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  `bio` text COLLATE utf8_unicode_ci,
  `dob` int(11) DEFAULT NULL,
  `gender` set('m','f','') COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_line1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_line2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_line3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postcode` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=157 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_profiles
-- ----------------------------
INSERT INTO `default_profiles` VALUES ('1', null, null, null, null, '1', 'rajendra patidar', 'rajendraa', 'patidara', 'CDNa', 'en', null, '0', null, '97878784', null, null, null, null, null, null, '1410589671');
INSERT INTO `default_profiles` VALUES ('2', '2014-09-01 06:54:23', null, null, '1', '1', 'rajendra patidar', 'rajendraa', 'patidara', 'CDNa', 'en', null, '0', null, '97878784', null, null, null, null, null, null, '1410589671');
INSERT INTO `default_profiles` VALUES ('3', '2014-09-01 08:28:55', null, null, '2', '2', 'tester.tester', 'tester', 'tester', 'cmp', 'en', null, '0', null, '9787878', null, null, null, null, null, null, '1410786357');
INSERT INTO `default_profiles` VALUES ('4', '2014-09-01 09:29:34', null, null, '3', '1', 'rajendra patidar', 'rajendraa', 'patidara', 'CDNa', 'en', null, '0', null, '97878784', null, null, null, null, null, null, '1410589671');
INSERT INTO `default_profiles` VALUES ('5', '2014-09-01 09:33:25', null, null, '4', '1', 'rajendra patidar', 'rajendraa', 'patidara', 'CDNa', 'en', null, '0', null, '97878784', null, null, null, null, null, null, '1410589671');
INSERT INTO `default_profiles` VALUES ('6', '2014-09-01 09:36:15', null, null, '5', '1', 'rajendra patidar', 'rajendraa', 'patidara', 'CDNa', 'en', null, '0', null, '97878784', null, null, null, null, null, null, '1410589671');
INSERT INTO `default_profiles` VALUES ('7', '2014-09-01 11:11:14', null, null, '6', '2', 'tester.tester', 'tester', 'tester', 'cmp', 'en', null, '0', null, '9787878', null, null, null, null, null, null, '1410786357');
INSERT INTO `default_profiles` VALUES ('65', '2014-09-27 05:57:24', null, null, '60', '57', 'testerer.testerer', 'testerer', 'testerer', 'cmp', 'en', null, null, null, '9778787', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('64', '2014-09-27 10:37:18', null, null, '59', '56', 'Sushil.Mishra', 'Sushil', 'Mishra', 'CDN', 'en', null, '0', null, '9713524996', null, null, null, null, null, null, '1418296969');
INSERT INTO `default_profiles` VALUES ('10', '2014-09-05 12:25:45', null, null, '9', '5', 'merchant.merchant', 'merchantv', 'merchant', null, 'en', null, '0', null, '985522', null, null, null, null, null, null, '1415698999');
INSERT INTO `default_profiles` VALUES ('11', '2014-09-08 10:51:55', null, null, '10', '6', 'user.user', 'user', 'user', 'cmp', 'en', null, null, null, '9778787', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('16', '2014-09-15 08:13:06', null, null, '12', '11', 'rajendra.patidar', 'rajendra', 'patidar', 'cmp', 'en', null, null, null, '454545', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('95', '2014-11-03 13:31:35', null, null, '90', '87', 'master.master', 'master', 'master', 'cmp', 'en', null, null, null, '97877878', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('17', '2014-09-15 09:39:55', null, null, '13', '13', 'rajendra.patidar', 'rajendra', 'patidar', 'cmp', 'en', null, null, null, '978778787', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('18', '2014-09-19 05:53:11', null, null, '14', '14', 'user.user', 'user', 'user', 'cmp', 'en', null, null, null, '9787878', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('19', '2014-09-19 05:54:45', null, null, '15', '15', 'user.user', 'user', 'user', 'cmp', 'en', null, null, null, '898777979', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('66', '2014-10-01 10:28:06', null, null, '61', '58', 'rajendra.patidar', 'rajendra', 'patidar', 'cmp', 'en', null, '0', null, '974545454', null, null, null, null, null, null, '1417396251');
INSERT INTO `default_profiles` VALUES ('67', '2014-10-09 08:12:12', null, null, '62', '59', 'tester.tester', 'tester', 'tester', 'cmp', 'en', null, null, null, '9787878', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('68', '2014-10-09 08:25:57', null, null, '63', '60', 'useruser.useruser', 'useruser', 'useruser', 'cmp', 'en', null, null, null, '978455454545', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('25', '2014-09-20 05:47:33', null, null, '21', '21', 'rajendra.patidar', 'rajendra', 'patidar', 'cmp', 'en', null, null, null, '2323232', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('72', '2014-10-16 08:16:31', null, null, '67', '64', 'tester.tester', 'tester', 'tester', 'cmo', 'en', null, null, null, '978787878', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('73', '2014-10-16 08:28:06', null, null, '68', '65', 'tester.tester', 'tester', 'tester', 'cmp', 'en', null, null, null, '978787878', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('69', '2014-10-09 08:39:09', null, null, '64', '61', 'affiliate.affiliate', 'affiliate', 'affiliate', 'cmp', 'en', null, '0', null, '978787878', null, null, null, null, null, null, '1413464171');
INSERT INTO `default_profiles` VALUES ('70', '2014-10-09 11:08:40', null, null, '65', '62', 'user.user', 'user', 'user', 'cmp', 'en', null, null, null, '97878787', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('71', '2014-10-09 16:48:58', null, null, '66', '63', 'test.test', 'test', 'test', 'asdfaf', 'en', null, null, null, '23423443', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('31', '2014-09-23 18:09:40', null, null, '27', '27', 'rajendra.patdair', 'rajendra', 'patdair', 'cmp', 'en', null, null, null, '97878', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('32', '2014-09-23 12:42:42', null, null, '28', '28', 'rajendra.patidar', 'rajendra', 'patidar', 'cmp', 'en', null, null, null, '7979897', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('33', '2014-09-23 12:44:19', null, null, '29', '29', 'rajendra.patidar', 'rajendra', 'patidar', 'cmp', 'en', null, null, null, '7979897', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('34', '2014-09-23 12:57:08', null, null, '30', '30', 'rajendra.patidar', 'rajendra', 'patidar', 'cmp', 'en', null, null, null, '454545', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('35', '2014-09-23 13:04:42', null, null, '31', '31', 'fdfds.fdsfds', 'fdfds', 'fdsfds', 'cmp', 'en', null, null, null, '4475455', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('36', '2014-09-23 13:33:40', null, null, '32', '32', 'rajendra.patidar', 'rajendra', 'patidar', 'CMP', 'en', null, null, null, '45454', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('37', '2014-09-23 14:15:13', null, null, '33', '33', 'rajendra.tester', 'rajendra', 'tester', 'cmp', 'en', null, null, null, '9785454', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('38', '2014-09-23 14:16:59', null, null, '34', '34', 'rajendra.patidar', 'rajendra', 'patidar', 'cmp', 'en', null, null, null, '54545', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('39', '2014-09-23 14:18:15', null, null, '35', '35', 'rajendra.patidar', 'rajendra', 'patidar', 'cmp', 'en', null, null, null, '77878', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('40', '2014-09-23 14:22:52', null, null, '36', '36', 'rajendra.patidar', 'rajendra', 'patidar', 'cmp', 'en', null, null, null, '565656', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('41', '2014-09-23 14:25:02', null, null, '37', '37', 'rajendra.patidar', 'rajendra', 'patidar', 'cmp', 'en', null, null, null, '565656', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('42', '2014-09-23 14:30:40', null, null, '38', '38', 'rajendra.patidar', 'rajendra', 'patidar', 'cmp', 'en', null, null, null, '45454', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('43', '2014-09-23 14:32:01', null, null, '39', '39', 'rajendra.patidar', 'rajendra', 'patidar', 'cmp', 'en', null, null, null, '45454', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('44', '2014-09-23 14:35:11', null, null, '40', '40', 'rajendra.patidar', 'rajendra', 'patidar', 'cmp', 'en', null, null, null, '45454', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('45', '2014-09-23 14:51:05', null, null, '41', '41', 'rajendra.patidar', 'rajendra', 'patidar', 'cmp', 'en', null, null, null, '454545', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('46', '2014-09-23 14:52:24', null, null, '42', '42', 'rajendra.patidar', 'rajendra', 'patidar', 'cmp', 'en', null, null, null, '454545', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('47', '2014-09-23 14:53:21', null, null, '43', '43', 'rajendra.patidar', 'rajendra', 'patidar', 'cmp', 'en', null, null, null, '454545', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('49', '2014-09-24 10:10:37', null, null, '45', '45', 'rajendra.patidar', 'rajendra', 'patidar', 'cmp', 'en', null, null, null, '78545454', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('50', '2014-09-24 10:12:04', null, null, '46', '46', 'rajendra.patidar', 'rajendra', 'patidar', 'cmp', 'en', null, null, null, '78545454', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('74', '2014-10-16 08:28:49', null, null, '69', '66', 'tester.tester', 'tester', 'tester', 'cmp', 'en', null, '0', null, '978787878', null, null, null, null, null, null, '1414821287');
INSERT INTO `default_profiles` VALUES ('52', '2014-09-24 12:00:32', null, null, '48', '48', 'rajendra.patidar', 'rajendra', 'patidar', 'cmp', 'en', null, null, null, '4545454', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('62', '2014-09-26 15:36:58', null, null, '57', '54', 'rajendra.patdair', 'rajendra', 'patdair', 'cmp', 'en', null, null, null, '454545454', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('54', '2014-09-24 12:06:35', null, null, '50', '50', 'rajendra.patidar', 'rajendra', 'patidar', 'cmp', 'en', null, null, null, '45454', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('61', '2014-09-26 14:54:16', null, null, '56', '53', 'rajendra.patidar', 'rajendra', 'patidar', 'CMP', 'en', null, null, null, '978989', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('56', '2014-09-25 20:17:12', null, null, '52', '48', 'rajendra.patidar', 'rajendra', 'patidar', 'cmp', 'en', null, null, null, '545454', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('58', '2014-09-26 14:06:00', null, null, '54', '50', 'piyush.jain', 'piyush', 'jain', 'cmp', 'en', null, null, null, '45454545', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('63', '2014-09-26 15:43:54', null, null, '58', '55', 'rajendra.patdair', 'raj', 'patidar', 'cmp', 'en', null, '0', null, '454545454', null, null, null, null, null, null, '1418279324');
INSERT INTO `default_profiles` VALUES ('75', '2014-10-17 12:13:05', null, null, '70', '67', 'rajendra.patidar', 'rajendra', 'patidar', 'cmp', 'en', null, '0', null, '9754545', null, null, null, null, null, null, '1414821559');
INSERT INTO `default_profiles` VALUES ('77', '2014-10-28 10:09:30', null, null, '72', '69', 'master.master', 'master', 'master', 'cmp', 'en', null, '0', null, '978787', null, null, null, null, null, null, '1414655693');
INSERT INTO `default_profiles` VALUES ('81', '2014-10-31 12:06:47', null, null, '76', '73', 'Sushil.Mishra', 'Sushil', 'Mishra', 'CDN', 'en', null, null, null, '9713524996', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('78', '2014-10-30 06:14:30', null, null, '73', '70', 'tester.tester', 'tester', 'tester', 'cmp', 'en', null, null, null, '9787878', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('80', '2014-10-30 13:10:32', null, null, '75', '72', 'user.user', 'user', 'user', 'cmp', 'en', null, null, null, '978545', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('82', '2014-10-31 12:20:54', null, null, '77', '74', 'Abhishek.Parashar', 'Abhishek', 'Parashar', 'CDN', 'en', null, '0', null, '123456', null, null, null, null, null, null, '1414741988');
INSERT INTO `default_profiles` VALUES ('83', '2014-10-31 08:22:20', null, null, '78', '75', 'gdfg.dfgdf', 'gdfg', 'dfgdf', 'gdfgdf', 'en', null, null, null, '78978787', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('84', '2014-10-31 09:49:31', null, null, '79', '76', 'gdfg.dfgdf', 'gdfg', 'dfgdf', 'gdfgdf', 'en', null, null, null, '78978787', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('85', '2014-10-31 09:52:03', null, null, '80', '77', 'gdfg.dfgdf', 'gdfg', 'dfgdf', 'gdfgdf', 'en', null, null, null, '78978787', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('86', '2014-10-31 09:53:11', null, null, '81', '78', 'gdfg.dfgdf', 'gdfg', 'dfgdf', 'gdfgdf', 'en', null, null, null, '78978787', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('87', '2014-10-31 10:28:59', null, null, '82', '79', 'rajendra.patidar', 'rajendra', 'patidar', null, 'en', null, null, null, '78978787', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('88', '2014-10-31 10:45:13', null, null, '83', '80', 'rajendra.dfgdf', 'rajendra', 'dfgdf', null, 'en', null, null, null, '78978787', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('89', '2014-10-31 10:47:26', null, null, '84', '81', 'rajendra.dfgdf', 'rajendra', 'dfgdf', null, 'en', null, null, null, '78978787', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('90', '2014-10-31 10:49:35', null, null, '85', '82', 'rajendra.dfgdf', 'rajendra', 'dfgdf', null, 'en', null, null, null, '78978787', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('91', '2014-10-31 11:02:43', null, null, '86', '83', 'rajendra.dfgdf', 'rajendra', 'dfgdf', null, 'en', null, null, null, '78978787', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('92', '2014-10-31 11:52:06', null, '58', '87', '84', 'adminuser.adminuser', 'adminuser', 'adminuser', 'cdn', 'en', null, null, null, '97787878', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('93', '2014-10-31 12:01:10', null, '58', '88', '85', 'rajndra.patidar', 'rajndra', 'patidar', 'rajendrapatidar@cdnsol.com', 'en', null, null, null, '9745445', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('96', '2014-11-03 13:40:26', null, null, '91', '88', 'master.master', 'master', 'master', null, 'en', null, null, null, '978787', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('94', '2014-11-01 05:09:45', null, null, '89', '86', 'tester.tester', 'tester', 'tester', null, 'en', null, null, null, '975326582', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('97', '2014-11-04 05:37:24', null, null, '92', '89', 'master.master', 'master', 'master', 'cmp', 'en', null, null, null, '97878787', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('98', '2014-11-04 05:40:55', null, null, '93', '90', 'master.master', 'master', 'master', 'cmp', 'en', null, null, null, '97878787', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('99', '2014-11-04 05:42:49', null, null, '94', '91', 'master.master', 'master', 'master', 'cmp', 'en', null, null, null, '97878787', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('100', '2014-11-04 05:44:49', null, null, '95', '92', 'master.merchant', 'master', 'merchant', 'cmp', 'en', null, null, null, '97878787', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('101', '2014-11-04 13:00:13', null, null, '96', '94', 'Prashant.Gupta', 'Prashant', 'Gupta', 'cdn', 'en', null, null, null, '123466799', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('102', '2014-11-04 13:17:25', null, null, '97', '95', 'rajendra.patidar', 'rajendra', 'patidar', 'cdn', 'en', null, null, null, '123456789', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('103', '2014-11-04 13:20:09', null, null, '98', '96', 'sunil.pal', 'sunil', 'pal', 'Cdn', 'en', null, '0', null, '123456789', null, null, null, null, null, null, '1415664475');
INSERT INTO `default_profiles` VALUES ('104', '2014-11-04 13:30:46', null, null, '99', '97', 'Prashant.Gupta', 'Prashant', 'Gupta', 'Cdn', 'en', null, '0', null, '9826711440', null, null, null, null, null, null, '1415074763');
INSERT INTO `default_profiles` VALUES ('105', '2014-11-04 11:09:27', null, null, '100', '98', 'merchantv.merchant', 'merchantv', 'merchant', null, 'en', null, null, null, '7878787', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('106', '2014-11-04 11:20:08', null, null, '101', '99', 'master.merchant', 'master', 'merchant', null, 'en', null, null, null, '9778787', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('107', '2014-11-04 11:37:26', null, null, '102', '100', 'prashant.gupta', 'prashant', 'gupta', 'cmp', 'en', null, null, null, '9787878', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('108', '2014-11-04 17:18:41', null, null, '103', '101', 'merchantv.merchant', 'merchantv', 'merchant', null, 'en', null, null, null, '97878787', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('109', '2014-11-04 17:20:45', null, null, '104', '102', 'prashant.gupta', 'prashant', 'gupta', 'cdn', 'en', null, '0', null, '9826711440', null, null, null, null, null, null, '1415090616');
INSERT INTO `default_profiles` VALUES ('110', '2014-11-04 17:32:28', null, null, '105', '103', 'Prashant.Gupta', 'Prashant', 'Gupta', 'cdn', 'en', null, '0', null, '9826711440', null, null, null, null, null, null, '1415241484');
INSERT INTO `default_profiles` VALUES ('111', '2014-11-04 14:27:26', null, null, '106', '106', 'tester.tester', 'tester', 'tester', null, 'en', null, null, null, '97878787', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('112', '2014-11-05 06:21:40', null, null, '107', '107', 'raheee gfddddd.rararra', 'raheee gfddddd', 'rararra', 'cmp', 'en', null, null, null, '978788888', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('113', '2014-11-05 10:42:27', null, null, '108', '108', 'fdgdg.gdg', 'fdgdg', 'gdg', null, 'en', null, null, null, '454545454', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('114', '2014-11-05 10:44:03', null, null, '109', '109', 'fdgdg.gdg', 'fdgdg', 'gdg', null, 'en', null, null, null, '454545454', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('115', '2014-11-05 14:03:51', null, null, '110', '110', 'fdgfdg.gfdgd', 'fdgfdg', 'gfdgd', null, 'en', null, null, null, '978787878', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('116', '2014-11-05 14:06:47', null, null, '111', '111', 'merchant.ddsfsd', 'merchant', 'ddsfsd', 'cmp', 'en', null, null, null, '985522', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('117', '2014-11-06 18:15:10', null, null, '112', '112', 'Akanksha.Gupta', 'Akanksha', 'Gupta', 'CDN', 'en', null, '0', null, '123456789', null, null, null, null, null, null, '1415696717');
INSERT INTO `default_profiles` VALUES ('118', '2014-11-07 05:20:26', null, null, '113', '113', 'czcx.czxczx', 'czcx', 'czxczx', 'cmp', 'en', null, null, null, '978754545', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('119', '2014-11-07 12:14:10', null, null, '114', '114', 'hsrish.kwstwal', 'hsrish', 'kwstwal', 'national title in 1961 and made his international debut at the 1962 British Empire and', 'en', null, null, null, '1234567891010', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('120', '2014-11-07 12:16:52', null, null, '115', '115', 'Prashant.Gupta', 'Prashant', 'Gupta', 'cdn', 'en', null, null, null, '1234567891212', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('121', '2014-11-07 14:34:56', null, null, '116', '116', 'akanksha.gupta', 'Anu', 'gupta', 'cdn', 'en', null, '0', null, '12345678', null, null, null, null, null, null, '1415334553');
INSERT INTO `default_profiles` VALUES ('122', '2014-11-11 11:38:41', null, null, '117', '117', 'harish.kestwal', 'Kapil', 'Prajapati', 'gd gsdfg dsgsd', 'en', null, '0', null, '1234567891212', null, null, null, null, null, null, '1415666591');
INSERT INTO `default_profiles` VALUES ('123', '2014-11-11 20:10:17', null, null, '118', '118', 'rajendra.patidar', 'rajendra', 'patidar', 'cmp', 'en', null, '0', null, '9787878787', null, null, null, null, null, null, '1416788243');
INSERT INTO `default_profiles` VALUES ('146', '2014-12-04 14:19:55', null, null, '128', '144', 'g.dfgdfgdf', 'g', 'dfgdfgdf', null, 'en', null, null, null, '974545454', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('130', '2014-12-03 07:38:24', null, null, '121', '128', 'dsad.asdasd', 'dsad', 'asdasd', 'cmp', 'en', null, null, null, '97878787', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('145', '2014-12-04 19:59:38', null, null, '127', '143', 'Prashant.gupta', 'Prashant', 'gupta', 'dfbgd', 'en', null, null, null, '1234567935414', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('144', '2014-12-04 14:16:49', null, null, '126', '142', 'fsdf.ddsfsd', 'fsdf', 'ddsfsd', 'sada', 'en', null, null, null, '974545454', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('131', '2014-12-03 07:40:12', null, null, '122', '129', 'dsadas.asdsad', 'dsadas', 'asdsad', 'fd', 'en', null, null, null, '974545454', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('147', '2014-12-04 20:02:01', null, null, '129', '145', 'prashant.Gupta', 'prashant', 'Gupta', 'sdfgsg', 'en', null, null, null, '+91789456123', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('143', '2014-12-04 14:07:57', null, null, '125', '141', 'fdsf.fdsfds', 'fdsf', 'fdsfds', 'dsfsd', 'en', null, null, null, '8787878', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('148', '2014-12-05 11:41:38', null, null, '130', '146', 'Prashant.Gupta', 'Prashant', 'Gupta', 'CDN Software Solution', 'en', null, '0', null, '1234567891212', null, null, null, null, null, null, '1417740149');
INSERT INTO `default_profiles` VALUES ('149', '2014-12-05 11:44:09', null, null, '131', '147', 'Sunil.Pal', 'Sunil', 'Pal', 'CDN Software Solution', 'en', null, null, null, '+919993978009', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('150', '2014-12-05 09:17:03', null, null, '132', '148', 'fsdfds.fdsf', 'fsdfds', 'fdsf', null, 'en', null, null, null, '97878787878', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('151', '2014-12-05 19:43:43', null, null, '133', '149', 'Prashant.gupta', 'Prashant', 'gupta', 'CDN Software Solution', 'en', null, null, null, '1234567935414', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('152', '2014-12-11 11:28:16', null, null, '134', '150', 'newtesting.new testing', 'newtesting', 'new testing', 'cmp', 'en', null, null, null, '9787787', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('153', '2014-12-11 17:31:26', null, null, '135', '151', 'Prashant.Gupta', 'Prashant', 'Gupta', 'CDN Software Solution', 'en', null, null, null, '1233478954878', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('154', '2014-12-11 17:33:55', null, null, '136', '152', 'Prashant.Gupta', 'Prashant', 'Gupta', 'CDN Software Solution', 'en', null, null, null, '4464645646421', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('155', '2014-12-12 12:41:59', null, null, '137', '153', 'Prashant.gupta', 'Prashant', 'gupta', 'CDN Software Solution', 'en', null, null, null, '1234567935414', null, null, null, null, null, null, null);
INSERT INTO `default_profiles` VALUES ('156', '2014-12-12 12:44:32', null, null, '138', '154', 'prashant.gupta', 'prashant', 'gupta', 'CDN', 'en', null, null, null, '+91789456123', null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for `default_purchase_product`
-- ----------------------------
DROP TABLE IF EXISTS `default_purchase_product`;
CREATE TABLE `default_purchase_product` (
  `purchase_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `affiliate_id` int(11) NOT NULL,
  `merchant_id` int(11) DEFAULT NULL,
  `banner_id` int(11) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `commission` varchar(255) DEFAULT NULL,
  `commission_amount` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `payment_method` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`purchase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of default_purchase_product
-- ----------------------------

-- ----------------------------
-- Table structure for `default_redirects`
-- ----------------------------
DROP TABLE IF EXISTS `default_redirects`;
CREATE TABLE `default_redirects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `to` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(3) NOT NULL DEFAULT '302',
  PRIMARY KEY (`id`),
  KEY `from` (`from`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_redirects
-- ----------------------------

-- ----------------------------
-- Table structure for `default_referral_payment_request`
-- ----------------------------
DROP TABLE IF EXISTS `default_referral_payment_request`;
CREATE TABLE `default_referral_payment_request` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_id` int(11) DEFAULT NULL,
  `affiliate_id` int(11) DEFAULT NULL,
  `merchant_id` int(11) DEFAULT NULL,
  `referral_commission` varchar(150) DEFAULT NULL,
  `product_price` varchar(150) DEFAULT NULL,
  `currency_type` varchar(150) DEFAULT NULL,
  `payment_status` tinyint(4) DEFAULT NULL,
  `txn_id` varchar(255) DEFAULT NULL,
  `token_id` varchar(250) DEFAULT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `transaction_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of default_referral_payment_request
-- ----------------------------
INSERT INTO `default_referral_payment_request` VALUES ('1', '1', '55', '56', '5', '5', 'USD', '1', '4DP533876Y960304A', 'EC-7DJ72435GJ555654J', '1', '2014-11-24 17:02:38', '2014-11-24 11:22:47');
INSERT INTO `default_referral_payment_request` VALUES ('2', '1', '55', '56', '5', '5', 'SEK', '0', null, null, '66', '2015-01-17 20:06:21', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `default_search_index`
-- ----------------------------
DROP TABLE IF EXISTS `default_search_index`;
CREATE TABLE `default_search_index` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `keywords` text COLLATE utf8_unicode_ci,
  `keyword_hash` char(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `module` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entry_key` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entry_plural` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `entry_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cp_edit_uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cp_delete_uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique` (`module`,`entry_key`,`entry_id`(190)),
  FULLTEXT KEY `full search` (`title`,`description`,`keywords`)
) ENGINE=MyISAM AUTO_INCREMENT=115 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_search_index
-- ----------------------------
INSERT INTO `default_search_index` VALUES ('98', 'Home', '', null, null, 'pages', 'pages:page', 'pages:pages', '1', 'home', 'admin/pages/edit/1', 'admin/pages/delete/1');
INSERT INTO `default_search_index` VALUES ('114', 'Contact Us', '', null, null, 'pages', 'pages:page', 'pages:pages', '2', 'contact-Us', 'admin/pages/edit/2', 'admin/pages/delete/2');
INSERT INTO `default_search_index` VALUES ('3', 'Search', '', null, null, 'pages', 'pages:page', 'pages:pages', '3', 'search', 'admin/pages/edit/3', 'admin/pages/delete/3');
INSERT INTO `default_search_index` VALUES ('4', 'Results', '', null, null, 'pages', 'pages:page', 'pages:pages', '4', 'search/results', 'admin/pages/edit/4', 'admin/pages/delete/4');
INSERT INTO `default_search_index` VALUES ('5', 'Page missing', '', null, null, 'pages', 'pages:page', 'pages:pages', '5', '404', 'admin/pages/edit/5', 'admin/pages/delete/5');
INSERT INTO `default_search_index` VALUES ('86', 'About-Us', '', null, null, 'pages', 'pages:page', 'pages:pages', '6', 'about-Us', 'admin/pages/edit/6', 'admin/pages/delete/6');
INSERT INTO `default_search_index` VALUES ('97', 'Affiliate', '', null, null, 'pages', 'pages:page', 'pages:pages', '9', 'dashbord', 'admin/pages/edit/9', 'admin/pages/delete/9');
INSERT INTO `default_search_index` VALUES ('106', 'Support', '', null, null, 'pages', 'pages:page', 'pages:pages', '11', 'support', 'admin/pages/edit/11', 'admin/pages/delete/11');
INSERT INTO `default_search_index` VALUES ('48', 'Privacy Policy', '', null, null, 'pages', 'pages:page', 'pages:pages', '13', 'privacy-policy', 'admin/pages/edit/13', 'admin/pages/delete/13');
INSERT INTO `default_search_index` VALUES ('54', 'Terms & Conditions', '', null, null, 'pages', 'pages:page', 'pages:pages', '15', 'terms-and-conditions', 'admin/pages/edit/15', 'admin/pages/delete/15');

-- ----------------------------
-- Table structure for `default_settings`
-- ----------------------------
DROP TABLE IF EXISTS `default_settings`;
CREATE TABLE `default_settings` (
  `slug` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `type` set('text','textarea','password','select','select-multiple','radio','file','checkbox') COLLATE utf8_unicode_ci NOT NULL,
  `default` text COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `options` text COLLATE utf8_unicode_ci NOT NULL,
  `is_required` int(1) NOT NULL,
  `is_gui` int(1) NOT NULL,
  `module` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `order` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`slug`),
  UNIQUE KEY `unique_slug` (`slug`),
  KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_settings
-- ----------------------------
INSERT INTO `default_settings` VALUES ('activation_email', 'Activation Email', 'Send out an e-mail with an activation link when a user signs up. Disable this so that admins must manually activate each account.', 'select', '1', '', '0=activate_by_admin|1=activate_by_email|2=no_activation', '0', '1', 'users', '961');
INSERT INTO `default_settings` VALUES ('addons_upload', 'Addons Upload Permissions', 'Keeps mere admins from uploading addons by default', 'text', '0', '1', '', '1', '0', '', '0');
INSERT INTO `default_settings` VALUES ('admin_force_https', 'Force HTTPS for Control Panel?', 'Allow only the HTTPS protocol when using the Control Panel?', 'radio', '0', '', '1=Yes|0=No', '1', '1', '', '0');
INSERT INTO `default_settings` VALUES ('admin_theme', 'Control Panel Theme', 'Select the theme for the control panel.', '', '', 'pyrocms', 'func:get_themes', '1', '0', '', '0');
INSERT INTO `default_settings` VALUES ('akismet_api_key', 'Akismet API Key', 'Akismet is a spam-blocker from the WordPress team. It keeps spam under control without forcing users to get past human-checking CAPTCHA forms.', 'text', '', '', '', '0', '1', 'integration', '981');
INSERT INTO `default_settings` VALUES ('api_enabled', 'API Enabled', 'Allow API access to all modules which have an API controller.', 'select', '0', '0', '0=Disabled|1=Enabled', '0', '0', 'api', '0');
INSERT INTO `default_settings` VALUES ('api_user_keys', 'API User Keys', 'Allow users to sign up for API keys (if the API is Enabled).', 'select', '0', '0', '0=Disabled|1=Enabled', '0', '0', 'api', '0');
INSERT INTO `default_settings` VALUES ('auto_username', 'Auto Username', 'Create the username automatically, meaning users can skip making one on registration.', 'radio', '1', '', '1=Enabled|0=Disabled', '0', '1', 'users', '964');
INSERT INTO `default_settings` VALUES ('cdn_domain', 'CDN Domain', 'CDN domains allow you to offload static content to various edge servers, like Amazon CloudFront or MaxCDN.', 'text', '', '', '', '0', '1', 'integration', '1000');
INSERT INTO `default_settings` VALUES ('ckeditor_config', 'CKEditor Config', 'You can find a list of valid configuration items in <a target=\"_blank\" href=\"http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html\">CKEditor\'s documentation.</a>', 'textarea', '', '{{# this is a wysiwyg-simple editor customized for the blog module (it allows images to be inserted) #}}\n$(\'textarea#intro.wysiwyg-simple\').ckeditor({\n	toolbar: [\n		[\'pyroimages\'],\n		[\'Bold\', \'Italic\', \'-\', \'NumberedList\', \'BulletedList\', \'-\', \'Link\', \'Unlink\']\n	  ],\n	extraPlugins: \'pyroimages\',\n	width: \'99%\',\n	height: 100,\n	dialog_backgroundCoverColor: \'#000\',\n	defaultLanguage: \'{{ helper:config item=\"default_language\" }}\',\n	language: \'{{ global:current_language }}\'\n});\n\n{{# this is the config for all wysiwyg-simple textareas #}}\n$(\'textarea.wysiwyg-simple\').ckeditor({\n	toolbar: [\n		[\'Bold\', \'Italic\', \'-\', \'NumberedList\', \'BulletedList\', \'-\', \'Link\', \'Unlink\']\n	  ],\n	width: \'99%\',\n	height: 100,\n	dialog_backgroundCoverColor: \'#000\',\n	defaultLanguage: \'{{ helper:config item=\"default_language\" }}\',\n	language: \'{{ global:current_language }}\'\n});\n\n{{# and this is the advanced editor #}}\n$(\'textarea.wysiwyg-advanced\').ckeditor({\n	toolbar: [\n		[\'Maximize\'],\n		[\'pyroimages\', \'pyrofiles\'],\n		[\'Cut\',\'Copy\',\'Paste\',\'PasteFromWord\'],\n		[\'Undo\',\'Redo\',\'-\',\'Find\',\'Replace\'],\n		[\'Link\',\'Unlink\'],\n		[\'Table\',\'HorizontalRule\',\'SpecialChar\'],\n		[\'Bold\',\'Italic\',\'StrikeThrough\'],\n		[\'JustifyLeft\',\'JustifyCenter\',\'JustifyRight\',\'JustifyBlock\',\'-\',\'BidiLtr\',\'BidiRtl\'],\n		[\'Format\', \'FontSize\', \'Subscript\',\'Superscript\', \'NumberedList\',\'BulletedList\',\'Outdent\',\'Indent\',\'Blockquote\'],\n		[\'ShowBlocks\', \'RemoveFormat\', \'Source\']\n	],\n	extraPlugins: \'pyroimages,pyrofiles\',\n	width: \'99%\',\n	height: 400,\n	dialog_backgroundCoverColor: \'#000\',\n	removePlugins: \'elementspath\',\n	defaultLanguage: \'{{ helper:config item=\"default_language\" }}\',\n	language: \'{{ global:current_language }}\'\n});', '', '1', '1', 'wysiwyg', '993');
INSERT INTO `default_settings` VALUES ('comment_markdown', 'Allow Markdown', 'Do you want to allow visitors to post comments using Markdown?', 'select', '0', '0', '0=Text Only|1=Allow Markdown', '1', '1', 'comments', '965');
INSERT INTO `default_settings` VALUES ('comment_order', 'Comment Order', 'Sort order in which to display comments.', 'select', 'ASC', 'DESC', 'ASC=Oldest First|DESC=Newest First', '1', '1', 'comments', '966');
INSERT INTO `default_settings` VALUES ('contact_email', 'Contact E-mail', 'All e-mails from users, guests and the site will go to this e-mail address.', 'text', 'sushilmishra@cdnsol.com', 'rajendrapatidar@cdnsol.com', '', '1', '1', 'email', '979');
INSERT INTO `default_settings` VALUES ('currency', 'Currency', 'The currency symbol for use on products, services, etc.', 'text', '&pound;', '', '', '1', '1', '', '994');
INSERT INTO `default_settings` VALUES ('dashboard_rss', 'Dashboard RSS Feed', 'Link to an RSS feed that will be displayed on the dashboard.', 'text', 'https://www.pyrocms.com/blog/rss/all.rss', 'https://www.syrecohk.com/blog/rss/all.rss', '', '0', '1', '', '990');
INSERT INTO `default_settings` VALUES ('dashboard_rss_count', 'Dashboard RSS Items', 'How many RSS items would you like to display on the dashboard?', 'text', '5', '5', '', '1', '1', '', '989');
INSERT INTO `default_settings` VALUES ('date_format', 'Date Format', 'How should dates be displayed across the website and control panel? Using the <a target=\"_blank\" href=\"http://php.net/manual/en/function.date.php\">date format</a> from PHP - OR - Using the format of <a target=\"_blank\" href=\"http://php.net/manual/en/function.strftime.php\">strings formatted as date</a> from PHP.', 'text', 'F j, Y', 'dd-mm-yyyy', '', '1', '1', '', '995');
INSERT INTO `default_settings` VALUES ('default_theme', 'Default Theme', 'Select the theme you want users to see by default.', '', 'default', 'referral', 'func:get_themes', '1', '0', '', '0');
INSERT INTO `default_settings` VALUES ('enable_comments', 'Enable Comments', 'Enable comments.', 'radio', '1', '1', '1=Enabled|0=Disabled', '1', '1', 'comments', '968');
INSERT INTO `default_settings` VALUES ('enable_profiles', 'Enable profiles', 'Allow users to add and edit profiles.', 'radio', '1', '', '1=Enabled|0=Disabled', '1', '1', 'users', '963');
INSERT INTO `default_settings` VALUES ('enable_registration', 'Enable user registration', 'Allow users to register in your site.', 'radio', '1', '', '1=Enabled|0=Disabled', '0', '1', 'users', '961');
INSERT INTO `default_settings` VALUES ('files_cache', 'Files Cache', 'When outputting an image via site.com/files what shall we set the cache expiration for?', 'select', '480', '480', '0=no-cache|1=1-minute|60=1-hour|180=3-hour|480=8-hour|1440=1-day|43200=30-days', '1', '1', 'files', '986');
INSERT INTO `default_settings` VALUES ('files_cf_api_key', 'Rackspace Cloud Files API Key', 'You also must provide your Cloud Files API Key. You will find it at the same location as your Username in your Rackspace account.', 'text', '', '', '', '0', '1', 'files', '989');
INSERT INTO `default_settings` VALUES ('files_cf_username', 'Rackspace Cloud Files Username', 'To enable cloud file storage in your Rackspace Cloud Files account please enter your Cloud Files Username. <a href=\"https://manage.rackspacecloud.com/APIAccess.do\">Find your credentials</a>', 'text', '', '', '', '0', '1', 'files', '990');
INSERT INTO `default_settings` VALUES ('files_enabled_providers', 'Enabled File Storage Providers', 'Which file storage providers do you want to enable? (If you enable a cloud provider you must provide valid auth keys below', 'checkbox', '0', '0', 'amazon-s3=Amazon S3|rackspace-cf=Rackspace Cloud Files', '0', '1', 'files', '994');
INSERT INTO `default_settings` VALUES ('files_s3_access_key', 'Amazon S3 Access Key', 'To enable cloud file storage in your Amazon S3 account provide your Access Key. <a href=\"https://aws-portal.amazon.com/gp/aws/securityCredentials#access_credentials\">Find your credentials</a>', 'text', '', '', '', '0', '1', 'files', '993');
INSERT INTO `default_settings` VALUES ('files_s3_geographic_location', 'Amazon S3 Geographic Location', 'Either US or EU. If you change this you must also change the S3 URL.', 'radio', 'US', 'US', 'US=United States|EU=Europe', '1', '1', 'files', '991');
INSERT INTO `default_settings` VALUES ('files_s3_secret_key', 'Amazon S3 Secret Key', 'You also must provide your Amazon S3 Secret Key. You will find it at the same location as your Access Key in your Amazon account.', 'text', '', '', '', '0', '1', 'files', '992');
INSERT INTO `default_settings` VALUES ('files_s3_url', 'Amazon S3 URL', 'Change this if using one of Amazon\'s EU locations or a custom domain.', 'text', 'http://{{ bucket }}.s3.amazonaws.com/', 'http://{{ bucket }}.s3.amazonaws.com/', '', '0', '1', 'files', '991');
INSERT INTO `default_settings` VALUES ('files_upload_limit', 'Filesize Limit', 'Maximum filesize to allow when uploading. Specify the size in MB. Example: 5', 'text', '5', '5', '', '1', '1', 'files', '987');
INSERT INTO `default_settings` VALUES ('frontend_enabled', 'Site Status', 'Use this option to the user-facing part of the site on or off. Useful when you want to take the site down for maintenance.', 'radio', '1', '', '1=Open|0=Closed', '1', '1', '', '988');
INSERT INTO `default_settings` VALUES ('ga_email', 'Google Analytic E-mail', 'E-mail address used for Google Analytics, we need this to show the graph on the dashboard.', 'text', '', 'rajendrapatidar@cdnsol.com', '', '0', '1', 'integration', '983');
INSERT INTO `default_settings` VALUES ('ga_password', 'Google Analytic Password', 'This is also needed to show the graph on the dashboard. You will need to allow access to Google to get this to work. See <a href=\"https://accounts.google.com/b/0/IssuedAuthSubTokens?hl=en_US\" target=\"_blank\">Authorized Access to your Google Account</a>', 'password', '', 'CDN123456', '', '0', '1', 'integration', '982');
INSERT INTO `default_settings` VALUES ('ga_profile', 'Google Analytic Profile ID', 'Profile ID for this website in Google Analytics', 'text', '', '', '', '0', '1', 'integration', '984');
INSERT INTO `default_settings` VALUES ('ga_tracking', 'Google Tracking Code', 'Enter your Google Analytic Tracking Code to activate Google Analytics view data capturing. E.g: UA-19483569-6', 'text', '', '', '', '0', '1', 'integration', '985');
INSERT INTO `default_settings` VALUES ('mail_line_endings', 'Email Line Endings', 'Change from the standard \\r\\n line ending to PHP_EOL for some email servers.', 'select', '1', '1', '0=PHP_EOL|1=\\r\\n', '0', '1', 'email', '972');
INSERT INTO `default_settings` VALUES ('mail_protocol', 'Mail Protocol', 'Select desired email protocol.', 'select', 'mail', 'smtp', 'mail=Mail|sendmail=Sendmail|smtp=SMTP', '1', '1', 'email', '977');
INSERT INTO `default_settings` VALUES ('mail_sendmail_path', 'Sendmail Path', 'Path to server sendmail binary.', 'text', '', '/usr/sbin/sendmail', '', '0', '1', 'email', '972');
INSERT INTO `default_settings` VALUES ('mail_smtp_host', 'SMTP Host Name', 'The host name of your smtp server.', 'text', '', '184.107.217.244', '', '0', '1', 'email', '976');
INSERT INTO `default_settings` VALUES ('mail_smtp_pass', 'SMTP password', 'SMTP password.', 'password', '', 'llB8eTk=oKtG', '', '0', '1', 'email', '975');
INSERT INTO `default_settings` VALUES ('mail_smtp_port', 'SMTP Port', 'SMTP port number.', 'text', '', '25', '', '0', '1', 'email', '974');
INSERT INTO `default_settings` VALUES ('mail_smtp_user', 'SMTP User Name', 'SMTP user name.', 'text', '', 'admin@cdnsolutionsgroup.com', '', '0', '1', 'email', '973');
INSERT INTO `default_settings` VALUES ('meta_topic', 'Meta Topic', 'Two or three words describing this type of company/website.', 'text', 'Content Management', 'Just sign up and earn rewards1', '', '0', '1', '', '998');
INSERT INTO `default_settings` VALUES ('moderate_comments', 'Moderate Comments', 'Force comments to be approved before they appear on the site.', 'radio', '1', '1', '1=Enabled|0=Disabled', '1', '1', 'comments', '967');
INSERT INTO `default_settings` VALUES ('profile_visibility', 'Profile Visibility', 'Specify who can view user profiles on the public site', 'select', 'public', '', 'public=profile_public|owner=profile_owner|hidden=profile_hidden|member=profile_member', '0', '1', 'users', '960');
INSERT INTO `default_settings` VALUES ('records_per_page', 'Records Per Page', 'How many records should we show per page in the admin section?', 'select', '25', '', '10=10|25=25|50=50|100=100', '1', '1', '', '992');
INSERT INTO `default_settings` VALUES ('registered_email', 'User Registered Email', 'Send a notification email to the contact e-mail when someone registers.', 'radio', '1', '', '1=Enabled|0=Disabled', '0', '1', 'users', '962');
INSERT INTO `default_settings` VALUES ('rss_feed_items', 'Feed item count', 'How many items should we show in RSS/blog feeds?', 'select', '25', '', '10=10|25=25|50=50|100=100', '1', '1', '', '991');
INSERT INTO `default_settings` VALUES ('server_email', 'Server E-mail', 'All e-mails to users will come from this e-mail address.', 'text', 'admin@localhost', 'rajendrapatidar@cdnsol.com', '', '1', '1', 'email', '978');
INSERT INTO `default_settings` VALUES ('site_lang', 'Site Language', 'The native language of the website, used to choose templates of e-mail notifications, contact form, and other features that should not depend on the language of a user.', 'select', 'en', 'en', 'func:get_supported_lang', '1', '1', '', '997');
INSERT INTO `default_settings` VALUES ('site_logo', 'Site Logo', 'The Logo of the website for use around the site', 'file', '', 'syrecohk_logo1.png', '', '0', '1', '', '999');
INSERT INTO `default_settings` VALUES ('site_name', 'Site Name', 'The name of the website for page titles and for use around the site.', 'text', 'Un-named Website', 'Syrecohk', '', '1', '1', '', '1000');
INSERT INTO `default_settings` VALUES ('site_public_lang', 'Public Languages', 'Which are the languages really supported and offered on the front-end of your website?', 'checkbox', 'en', 'en,fa', 'func:get_supported_lang', '1', '1', '', '996');
INSERT INTO `default_settings` VALUES ('site_slogan', 'Site Slogan', 'The slogan of the website for page titles and for use around the site', 'text', '', 'Get 10% commission on all products from our services store1', '', '0', '1', '', '999');
INSERT INTO `default_settings` VALUES ('unavailable_message', 'Unavailable Message', 'When the site is turned off or there is a major problem, this message will show to users.', 'textarea', 'Sorry, this website is currently unavailable.', '', '', '0', '1', '', '987');

-- ----------------------------
-- Table structure for `default_support_guest_users`
-- ----------------------------
DROP TABLE IF EXISTS `default_support_guest_users`;
CREATE TABLE `default_support_guest_users` (
  `guest_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_guest` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`guest_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of default_support_guest_users
-- ----------------------------
INSERT INTO `default_support_guest_users` VALUES ('1', 'lokendra', 'lokendrameena@cdnsol.com', null);

-- ----------------------------
-- Table structure for `default_supportchat`
-- ----------------------------
DROP TABLE IF EXISTS `default_supportchat`;
CREATE TABLE `default_supportchat` (
  `chat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_type_id` int(10) unsigned DEFAULT NULL,
  `author` int(11) DEFAULT NULL,
  `gravatar` varchar(32) NOT NULL,
  `text` varchar(255) NOT NULL,
  `to_user_id` int(11) DEFAULT NULL,
  `read_status` tinyint(4) DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`chat_id`),
  KEY `ts` (`ts`)
) ENGINE=MyISAM AUTO_INCREMENT=617 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of default_supportchat
-- ----------------------------
INSERT INTO `default_supportchat` VALUES ('428', '3', '5', 'test', 'rajendra npatidardn fdasdsads dasdjaskjd daxdsa djhjdsa dasda', null, '0', '2014-11-07 16:53:44');
INSERT INTO `default_supportchat` VALUES ('427', null, '105', 'test', 'hellow', null, '0', '2014-11-07 16:53:33');
INSERT INTO `default_supportchat` VALUES ('426', '1', '58', 'test', 'hai', '5', '0', '2014-11-07 16:48:57');
INSERT INTO `default_supportchat` VALUES ('425', '3', '5', 'test', 'eshdfsywfhsjfklxjfsflkjsklfsf', null, '0', '2014-11-07 16:44:57');
INSERT INTO `default_supportchat` VALUES ('424', '3', '5', 'test', 'erj', null, '0', '2014-11-07 16:28:33');
INSERT INTO `default_supportchat` VALUES ('423', '2', '73', 'test', 'asdd', null, '0', '2014-11-07 13:25:02');
INSERT INTO `default_supportchat` VALUES ('422', '2', '73', 'test', 'dadds', null, '0', '2014-11-07 13:25:01');
INSERT INTO `default_supportchat` VALUES ('421', '2', '73', 'test', 'dsfsdf', null, '0', '2014-11-07 12:56:00');
INSERT INTO `default_supportchat` VALUES ('420', '2', '73', 'test', 'hello', null, '0', '2014-11-06 19:10:21');
INSERT INTO `default_supportchat` VALUES ('419', '3', '103', 'test', ':)', null, '0', '2014-11-06 15:04:51');
INSERT INTO `default_supportchat` VALUES ('418', '1', '58', 'test', 'hiiiiiii', '103', '0', '2014-11-06 15:04:29');
INSERT INTO `default_supportchat` VALUES ('417', '2', '96', 'test', 'h r u', null, '0', '2014-11-06 15:03:13');
INSERT INTO `default_supportchat` VALUES ('415', null, '105', 'test', 'hiii', null, '0', '2014-11-06 14:49:30');
INSERT INTO `default_supportchat` VALUES ('416', '1', '58', 'test', 'hello', '96', '0', '2014-11-06 15:03:03');
INSERT INTO `default_supportchat` VALUES ('414', '1', '58', 'test', 'hello', '105', '0', '2014-11-06 14:49:21');
INSERT INTO `default_supportchat` VALUES ('413', '2', '96', 'test', 'hi', null, '0', '2014-11-06 13:36:58');
INSERT INTO `default_supportchat` VALUES ('412', '3', '103', 'test', 'hiii]', null, '0', '2014-11-06 13:36:52');
INSERT INTO `default_supportchat` VALUES ('411', '2', '55', 'test', 'hghghg', null, '0', '2014-11-06 12:20:40');
INSERT INTO `default_supportchat` VALUES ('409', '2', '55', 'test', 'hgchfh', null, '0', '2014-11-06 12:20:32');
INSERT INTO `default_supportchat` VALUES ('410', '1', '58', 'test', 'okay its working', '55', '0', '2014-11-06 12:20:38');
INSERT INTO `default_supportchat` VALUES ('408', '1', '58', 'test', 'wassup?', '55', '0', '2014-11-06 12:20:21');
INSERT INTO `default_supportchat` VALUES ('407', '1', '58', 'test', 'hey', '55', '0', '2014-11-06 12:20:14');
INSERT INTO `default_supportchat` VALUES ('406', null, '105', 'test', 'okay', null, '0', '2014-11-06 12:19:28');
INSERT INTO `default_supportchat` VALUES ('405', '1', '58', 'test', 'badiya he bas.........:)', '105', '0', '2014-11-06 12:19:25');
INSERT INTO `default_supportchat` VALUES ('404', null, '105', 'test', 'he admin wassup??', null, '0', '2014-11-06 12:19:15');
INSERT INTO `default_supportchat` VALUES ('402', null, '105', 'test', 'lkjl;j', null, '0', '2014-11-05 16:17:19');
INSERT INTO `default_supportchat` VALUES ('403', '1', '58', 'test', 'hellow', '105', '0', '2014-11-06 12:19:04');
INSERT INTO `default_supportchat` VALUES ('400', null, '105', 'test', 'hi', null, '0', '2014-11-05 16:08:38');
INSERT INTO `default_supportchat` VALUES ('401', '1', '58', 'test', 'lkj', '105', '0', '2014-11-05 16:17:11');
INSERT INTO `default_supportchat` VALUES ('398', null, '105', 'test', 'adf', null, '0', '2014-11-05 15:48:27');
INSERT INTO `default_supportchat` VALUES ('399', null, '105', 'test', 'adsadsa', null, '0', '2014-11-05 15:48:39');
INSERT INTO `default_supportchat` VALUES ('397', null, '105', 'test', 'hellow', null, '0', '2014-11-05 15:42:18');
INSERT INTO `default_supportchat` VALUES ('396', null, '105', 'test', 'hey', null, '0', '2014-11-05 15:27:13');
INSERT INTO `default_supportchat` VALUES ('395', '1', '58', 'test', 'hiii', '61', '0', '2014-11-05 15:24:23');
INSERT INTO `default_supportchat` VALUES ('394', '2', '61', 'test', 'hellow', null, '0', '2014-11-05 15:24:12');
INSERT INTO `default_supportchat` VALUES ('393', null, '105', 'test', 'okay', null, '0', '2014-11-05 12:34:56');
INSERT INTO `default_supportchat` VALUES ('392', '1', '58', 'test', 'hello', '105', '0', '2014-11-05 12:34:51');
INSERT INTO `default_supportchat` VALUES ('391', null, '105', 'test', 'hiii', null, '0', '2014-11-05 12:34:44');
INSERT INTO `default_supportchat` VALUES ('390', null, '105', 'test', 'hiii', null, '0', '2014-11-05 11:55:33');
INSERT INTO `default_supportchat` VALUES ('388', null, '105', 'test', 'yup', null, '0', '2014-11-05 11:54:34');
INSERT INTO `default_supportchat` VALUES ('389', '1', '58', 'test', 'grt:)', '105', '0', '2014-11-05 11:54:40');
INSERT INTO `default_supportchat` VALUES ('386', null, '105', 'test', 'sir', null, '0', '2014-11-05 11:54:12');
INSERT INTO `default_supportchat` VALUES ('387', '1', '58', 'test', 'r u enjoying my site?', '105', '0', '2014-11-05 11:54:27');
INSERT INTO `default_supportchat` VALUES ('385', null, '105', 'test', 'fine si', null, '0', '2014-11-05 11:54:11');
INSERT INTO `default_supportchat` VALUES ('384', '1', '58', 'test', 'wtsup buddy?', '105', '0', '2014-11-05 11:54:06');
INSERT INTO `default_supportchat` VALUES ('383', null, '105', 'test', 'hello sir', null, '0', '2014-11-05 11:54:00');
INSERT INTO `default_supportchat` VALUES ('381', null, '105', 'test', 'haoo', null, '0', '2014-11-04 20:14:10');
INSERT INTO `default_supportchat` VALUES ('380', null, '105', 'test', 'there?', null, '0', '2014-11-04 20:13:57');
INSERT INTO `default_supportchat` VALUES ('379', '1', '58', 'test', 'hey', '105', '0', '2014-11-04 20:13:49');
INSERT INTO `default_supportchat` VALUES ('376', null, '105', 'test', 'wowwww', null, '0', '2014-11-04 20:12:17');
INSERT INTO `default_supportchat` VALUES ('377', '1', '58', 'test', 'grt work men', '105', '0', '2014-11-04 20:12:25');
INSERT INTO `default_supportchat` VALUES ('378', null, '105', 'test', 'how your site works?', null, '0', '2014-11-04 20:12:39');
INSERT INTO `default_supportchat` VALUES ('375', '1', '58', 'test', 'helllo', '105', '0', '2014-11-04 20:12:03');
INSERT INTO `default_supportchat` VALUES ('373', null, '105', 'test', 'asfdf', null, '0', '2014-11-04 20:09:17');
INSERT INTO `default_supportchat` VALUES ('374', null, '105', 'test', 'iiii', null, '0', '2014-11-04 20:11:58');
INSERT INTO `default_supportchat` VALUES ('372', '1', '58', 'test', 'asdf', '105', '0', '2014-11-04 20:09:10');
INSERT INTO `default_supportchat` VALUES ('371', '1', '58', 'test', 'asdf', '105', '0', '2014-11-04 20:08:39');
INSERT INTO `default_supportchat` VALUES ('370', null, '105', 'test', 'hellow', null, '0', '2014-11-04 20:08:15');
INSERT INTO `default_supportchat` VALUES ('369', '1', '58', 'test', 'gher', '105', '0', '2014-11-04 20:08:02');
INSERT INTO `default_supportchat` VALUES ('368', '1', '58', 'test', 'sadf', '105', '0', '2014-11-04 20:06:15');
INSERT INTO `default_supportchat` VALUES ('367', '1', '58', 'test', 'hellow', '105', '0', '2014-11-04 20:06:05');
INSERT INTO `default_supportchat` VALUES ('366', '1', '58', 'test', 'hiii', '105', '0', '2014-11-04 19:45:50');
INSERT INTO `default_supportchat` VALUES ('382', '1', '58', 'test', 'hey lok', '105', '0', '2014-11-05 11:53:40');
INSERT INTO `default_supportchat` VALUES ('429', '3', '5', 'test', 'hello', null, '0', '2014-11-08 11:03:55');
INSERT INTO `default_supportchat` VALUES ('430', '1', '58', 'test', 'hello sir', '73', '0', '2014-11-08 11:07:31');
INSERT INTO `default_supportchat` VALUES ('431', '1', '58', 'test', 'hello', '96', '0', '2014-11-10 11:52:23');
INSERT INTO `default_supportchat` VALUES ('432', '1', '58', 'test', '123', '96', '0', '2014-11-10 11:52:49');
INSERT INTO `default_supportchat` VALUES ('433', '2', '96', 'test', 'gdfgsgfg', null, '0', '2014-11-10 11:53:12');
INSERT INTO `default_supportchat` VALUES ('434', '1', '58', 'test', 'fdsgdfgsgd', '96', '0', '2014-11-10 11:53:21');
INSERT INTO `default_supportchat` VALUES ('435', '3', '103', 'test', 'fsdgfdsgdg', null, '0', '2014-11-10 11:53:38');
INSERT INTO `default_supportchat` VALUES ('436', '2', '73', 'test', 'hii', null, '0', '2014-11-12 11:50:24');
INSERT INTO `default_supportchat` VALUES ('437', '2', '73', 'test', 'hello', null, '0', '2014-11-12 11:53:35');
INSERT INTO `default_supportchat` VALUES ('438', '3', '56', 'test', 'hello', null, '0', '2014-11-12 11:54:17');
INSERT INTO `default_supportchat` VALUES ('439', null, '105', 'test', 'test', null, '0', '2014-11-12 12:12:35');
INSERT INTO `default_supportchat` VALUES ('440', null, '105', 'test', 'hai', null, '0', '2014-11-12 12:12:40');
INSERT INTO `default_supportchat` VALUES ('441', '1', '58', 'test', 'testing ', '105', '0', '2014-11-12 12:14:01');
INSERT INTO `default_supportchat` VALUES ('442', null, '105', 'test', 'this is s', null, '0', '2014-11-12 12:14:07');
INSERT INTO `default_supportchat` VALUES ('443', '2', '55', 'test', 'HI', null, '0', '2014-11-12 18:39:26');
INSERT INTO `default_supportchat` VALUES ('444', '1', '58', 'test', 'HI', '55', '0', '2014-11-12 18:39:41');
INSERT INTO `default_supportchat` VALUES ('445', '3', '103', 'test', 'hi', null, '0', '2014-11-13 20:49:57');
INSERT INTO `default_supportchat` VALUES ('446', '3', '103', 'test', 'hiiiiiiiiiiiiiiii', null, '0', '2014-11-13 23:33:13');
INSERT INTO `default_supportchat` VALUES ('447', '3', '103', 'test', 'hiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii', null, '0', '2014-11-14 12:46:58');
INSERT INTO `default_supportchat` VALUES ('448', '1', '58', 'test', 'hello', '103', '0', '2014-11-14 12:48:47');
INSERT INTO `default_supportchat` VALUES ('449', '3', '103', 'test', ':)', null, '0', '2014-11-14 12:48:57');
INSERT INTO `default_supportchat` VALUES ('450', '1', '58', 'test', 'dfhhsghdh', '96', '0', '2014-11-14 13:01:03');
INSERT INTO `default_supportchat` VALUES ('451', '2', '96', 'test', 'gdfghfh', null, '0', '2014-11-14 13:01:26');
INSERT INTO `default_supportchat` VALUES ('452', '1', '58', 'test', 'jgfjghf', '96', '0', '2014-11-14 13:05:53');
INSERT INTO `default_supportchat` VALUES ('453', '1', '58', 'test', 'yiuywuif kwfh wuih sf ishfih asuifyua sfias asuhf ishfui ufha sfiuah shfasdjkfhuosy sfklsiaufosfjkn knvjyvgvfojfojfiouifydigfskfjbhasg ai sgauogh shkvgj higaus gskjh usiohas', '103', '0', '2014-11-14 13:06:14');
INSERT INTO `default_supportchat` VALUES ('454', '2', '96', 'test', 'dsfh  saklgj shjk lfh ioasoicjkascjksgdfyg ygfpIOAQH KFHSDHYIFGYGSBVHJBVHJB SKCVHOAOAPAUPIOUOUIFYJKSDOGTPGUP[SLJKLSJOAOPPOGWJHUIH V JIVGSAYIHXBVHJSBVYIGVSJKVNKJASVIGS', null, '0', '2014-11-14 13:06:44');
INSERT INTO `default_supportchat` VALUES ('455', '3', '103', 'test', 'GFAHSK AHKSHD HOHFOHFSDJKOH HOJA SD HSODIOAOIOHOIFHOLSFOASDLSFJPIO[AISPJKLAJKSH UHJ HJKZNJKZGVFWEFPWFIOP54567891654JKLHI WH', null, '0', '2014-11-14 13:07:15');
INSERT INTO `default_supportchat` VALUES ('456', '3', '103', 'test', 'GJKDF SHKHG;AS [QP UIOPWQJGIOOJHKHVJAHUSH[IQUWUPFIOFJKOASDJFUIOHYFAUFUDJFSDHFIHSDUIYFUSKFJHSJGFIAGHUOFIOALFNJKLAHGUOSOAJSGUIPIFOPIASOPGJOASHGUHNJKHVAISHUVIOSJIJAKLVS1V5687G4657856465A7S8G7SGMKHSDHLHSJDHADSKLJVAJSOHJSHJGHASDOFH', null, '0', '2014-11-14 13:07:46');
INSERT INTO `default_supportchat` VALUES ('457', '3', '103', 'test', 'Prashant Gupta:GFAHSK AHKSHD HOHFOHFSDJKOH HOJA SD HSODIOAOIOHOIFHOLSFOASDLSFJPIO[AISPJKLAJKSH UHJ HJKZNJKZGVFWEFPWFIOP54567891654JKLHI WH', null, '0', '2014-11-14 13:17:44');
INSERT INTO `default_supportchat` VALUES ('458', '1', '58', 'test', 'gsdfj lsj lsjilgj dli;gj il;sjklv djlkjs fldjsilj giojsdklgilsdfh gjkl;hsjkldfgklsdfjhdodfjklhjdfxljbvlckxbipusopdbjlksmblkhcxovhodshybopjskl;bjlkdhbiohxcoijbklcvbnkxbhjiohxbdklxv clkbhcvklhblbjovbodjklbxcvhbouhxclbnxjkchbjlxknjkljxnl;', '55', '0', '2014-11-14 13:21:58');
INSERT INTO `default_supportchat` VALUES ('459', '1', '58', 'test', 'dsfh saklgj shjk lfh ioasoicjkascjksgdfyg ygfpIOAQH KFHSDHYIFGYGSBVHJBVHJB SKCVHOAOAPAUPIOUOUIFYJKSDOGTPGUP[SLJKLSJOAOPPOGWJHUIH V JIVGSAYIHXBVHJSBVYIGVSJKVNK', '96', '0', '2014-11-14 13:28:58');
INSERT INTO `default_supportchat` VALUES ('460', '1', '58', 'test', 'gsdgjhs duih djkdghsaduishokhoisauioghsdjkghshyguiohagjksduisdhagjksdguiahogihasjkdghjkaghuiahgsdjigahuisdhgsbvgushajkgvsghuioashvonsdhvgjkashjoshdabvgjksgjkak', '96', '0', '2014-11-14 13:29:10');
INSERT INTO `default_supportchat` VALUES ('461', '1', '58', 'test', 'gfdnjgfjgnjfn', '96', '0', '2014-11-14 13:30:09');
INSERT INTO `default_supportchat` VALUES ('462', null, '105', 'test', 'hello', null, '0', '2014-11-17 17:46:29');
INSERT INTO `default_supportchat` VALUES ('463', '1', '58', 'test', 'hai', '55', '0', '2014-11-20 12:59:21');
INSERT INTO `default_supportchat` VALUES ('464', '2', '55', 'test', 'yes', null, '0', '2014-11-20 12:59:31');
INSERT INTO `default_supportchat` VALUES ('465', '2', '55', 'test', 'rajendra', null, '0', '2014-11-20 13:01:32');
INSERT INTO `default_supportchat` VALUES ('466', '1', '58', 'test', 'ha', '55', '0', '2014-11-20 13:01:45');
INSERT INTO `default_supportchat` VALUES ('467', '1', '58', 'test', 'my testing apps', '55', '0', '2014-11-20 13:05:38');
INSERT INTO `default_supportchat` VALUES ('468', '2', '55', 'test', 'test', null, '0', '2014-11-20 13:06:04');
INSERT INTO `default_supportchat` VALUES ('469', null, '120', 'test', 'hello all', null, '0', '2014-11-20 13:09:06');
INSERT INTO `default_supportchat` VALUES ('470', '1', '58', 'test', 'hai..', '120', '0', '2014-11-20 13:09:07');
INSERT INTO `default_supportchat` VALUES ('471', '1', '58', 'test', 'ok good ', '120', '0', '2014-11-20 13:09:16');
INSERT INTO `default_supportchat` VALUES ('472', '1', '58', 'test', 'thank you', '120', '0', '2014-11-20 13:09:19');
INSERT INTO `default_supportchat` VALUES ('473', null, '120', 'test', 'wc:)', null, '0', '2014-11-20 13:09:27');
INSERT INTO `default_supportchat` VALUES ('474', '1', '58', 'test', 'plz dont clost..', '120', '0', '2014-11-20 13:09:28');
INSERT INTO `default_supportchat` VALUES ('475', '1', '58', 'test', 'don\'t close..', '120', '0', '2014-11-20 13:09:52');
INSERT INTO `default_supportchat` VALUES ('476', '1', '58', 'test', 'thank you sir', '120', '0', '2014-11-20 13:09:56');
INSERT INTO `default_supportchat` VALUES ('477', '1', '58', 'test', 'hai', '120', '0', '2014-11-20 13:11:47');
INSERT INTO `default_supportchat` VALUES ('478', '2', '96', 'test', 'huihguihasuivfhskjgksag', null, '0', '2014-11-20 13:11:57');
INSERT INTO `default_supportchat` VALUES ('479', '1', '58', 'test', 'thank you', '96', '0', '2014-11-20 13:12:03');
INSERT INTO `default_supportchat` VALUES ('480', '2', '55', 'test', 'ha', null, '0', '2014-11-20 13:12:09');
INSERT INTO `default_supportchat` VALUES ('481', '2', '96', 'test', 'now u check', null, '0', '2014-11-20 13:12:14');
INSERT INTO `default_supportchat` VALUES ('482', '2', '96', 'test', 'my issue', null, '0', '2014-11-20 13:12:17');
INSERT INTO `default_supportchat` VALUES ('483', '2', '96', 'test', 'and 1 issue again raise here', null, '0', '2014-11-20 13:12:39');
INSERT INTO `default_supportchat` VALUES ('484', '2', '55', 'test', 'hello s', null, '0', '2014-11-20 13:12:39');
INSERT INTO `default_supportchat` VALUES ('485', '1', '58', 'test', 'fh', '96', '0', '2014-11-20 13:13:24');
INSERT INTO `default_supportchat` VALUES ('486', '1', '58', 'test', 'hgf', '120', '0', '2014-11-20 13:13:27');
INSERT INTO `default_supportchat` VALUES ('487', '1', '58', 'test', 'ghf', '55', '0', '2014-11-20 13:13:32');
INSERT INTO `default_supportchat` VALUES ('488', '2', '96', 'test', 'ma jaise h submit pr click karta hoon to user ka name late display hota h', null, '0', '2014-11-20 13:13:32');
INSERT INTO `default_supportchat` VALUES ('489', '2', '96', 'test', 'on my same screen', null, '0', '2014-11-20 13:13:56');
INSERT INTO `default_supportchat` VALUES ('490', '1', '58', 'test', 'ewef', '55', '0', '2014-11-20 13:14:29');
INSERT INTO `default_supportchat` VALUES ('491', '1', '58', 'test', 'few', '120', '0', '2014-11-20 13:14:32');
INSERT INTO `default_supportchat` VALUES ('492', '1', '58', 'test', 'ert', '96', '0', '2014-11-20 13:14:40');
INSERT INTO `default_supportchat` VALUES ('493', '2', '96', 'test', 'and when i scroll the same chat screen messages complete page are scroll', null, '0', '2014-11-20 13:15:21');
INSERT INTO `default_supportchat` VALUES ('494', '2', '55', 'test', 'sdsadas', null, '0', '2014-11-20 13:21:36');
INSERT INTO `default_supportchat` VALUES ('495', '1', '58', 'test', 'asdas', '96', '0', '2014-11-20 13:21:41');
INSERT INTO `default_supportchat` VALUES ('496', '1', '58', 'test', 'dsada', '120', '0', '2014-11-20 13:21:42');
INSERT INTO `default_supportchat` VALUES ('497', '1', '58', 'test', 'dasd', '55', '0', '2014-11-20 13:21:46');
INSERT INTO `default_supportchat` VALUES ('498', '1', '58', 'test', 'dasd', '96', '0', '2014-11-20 13:22:05');
INSERT INTO `default_supportchat` VALUES ('499', '1', '58', 'test', 'sdas', '120', '0', '2014-11-20 13:22:07');
INSERT INTO `default_supportchat` VALUES ('500', '1', '58', 'test', 'dsd', '55', '0', '2014-11-20 13:22:08');
INSERT INTO `default_supportchat` VALUES ('501', '1', '58', 'test', 'sd', '96', '0', '2014-11-20 13:22:49');
INSERT INTO `default_supportchat` VALUES ('502', '2', '61', 'test', 'hai sir', null, '0', '2014-11-20 13:29:47');
INSERT INTO `default_supportchat` VALUES ('503', '2', '61', 'test', 'this is ', null, '0', '2014-11-20 13:31:22');
INSERT INTO `default_supportchat` VALUES ('504', '2', '61', 'test', 'test', null, '0', '2014-11-20 13:32:10');
INSERT INTO `default_supportchat` VALUES ('505', '2', '61', 'test', 'gg', null, '0', '2014-11-20 13:33:27');
INSERT INTO `default_supportchat` VALUES ('506', '2', '61', 'test', 'hai sir', null, '0', '2014-11-20 13:34:18');
INSERT INTO `default_supportchat` VALUES ('507', '2', '61', 'test', 'rahe dr', null, '0', '2014-11-20 13:35:10');
INSERT INTO `default_supportchat` VALUES ('508', '2', '61', 'test', 'kese h aap', null, '0', '2014-11-20 13:35:22');
INSERT INTO `default_supportchat` VALUES ('509', '2', '55', 'test', 'yes sir', null, '0', '2014-11-20 13:46:49');
INSERT INTO `default_supportchat` VALUES ('510', '2', '55', 'test', 'fhgf', null, '0', '2014-11-20 13:51:18');
INSERT INTO `default_supportchat` VALUES ('511', '1', '58', 'test', 'yes', '55', '0', '2014-11-20 13:55:46');
INSERT INTO `default_supportchat` VALUES ('512', '1', '58', 'test', 'dfgdf', '55', '0', '2014-11-20 13:56:58');
INSERT INTO `default_supportchat` VALUES ('513', '1', '58', 'test', 'hai..', '55', '0', '2014-11-20 13:57:10');
INSERT INTO `default_supportchat` VALUES ('514', '2', '55', 'test', 'this is details', null, '0', '2014-11-20 13:57:47');
INSERT INTO `default_supportchat` VALUES ('515', '1', '58', 'test', 'new data', '55', '0', '2014-11-20 13:59:06');
INSERT INTO `default_supportchat` VALUES ('516', '2', '55', 'test', 'this is testing', null, '0', '2014-11-20 13:59:13');
INSERT INTO `default_supportchat` VALUES ('517', '1', '58', 'test', 'my test data', '55', '0', '2014-11-20 14:00:07');
INSERT INTO `default_supportchat` VALUES ('518', '1', '58', 'test', 'hai', '55', '0', '2014-11-20 15:12:25');
INSERT INTO `default_supportchat` VALUES ('519', '1', '58', 'test', 'hai', '5', '0', '2014-11-20 15:29:25');
INSERT INTO `default_supportchat` VALUES ('520', '1', '58', 'test', 'thank you', '96', '0', '2014-11-20 15:29:33');
INSERT INTO `default_supportchat` VALUES ('521', '2', '55', 'test', 'fdsds', null, '0', '2014-11-20 15:44:27');
INSERT INTO `default_supportchat` VALUES ('522', '2', '55', 'test', 'hg', null, '0', '2014-11-20 15:44:54');
INSERT INTO `default_supportchat` VALUES ('523', '2', '55', 'test', 'ghffg', null, '0', '2014-11-20 15:45:19');
INSERT INTO `default_supportchat` VALUES ('524', '1', '58', 'test', 'kopko', '55', '0', '2014-11-20 15:48:01');
INSERT INTO `default_supportchat` VALUES ('525', '1', '58', 'test', 'klop[op[op[', '55', '0', '2014-11-20 15:48:04');
INSERT INTO `default_supportchat` VALUES ('526', '1', '58', 'test', 'tiyuiu+', '5', '0', '2014-11-20 15:49:29');
INSERT INTO `default_supportchat` VALUES ('527', '1', '58', 'test', 'uyuy', '55', '0', '2014-11-20 15:49:33');
INSERT INTO `default_supportchat` VALUES ('528', '1', '58', 'test', 'ouiouio', '105', '0', '2014-11-20 15:51:16');
INSERT INTO `default_supportchat` VALUES ('529', '1', '58', 'test', 'uuio', '105', '0', '2014-11-20 15:51:17');
INSERT INTO `default_supportchat` VALUES ('530', '1', '58', 'test', 'u', '105', '0', '2014-11-20 15:51:17');
INSERT INTO `default_supportchat` VALUES ('531', '1', '58', 'test', 'i', '105', '0', '2014-11-20 15:51:17');
INSERT INTO `default_supportchat` VALUES ('532', '1', '58', 'test', 'i', '105', '0', '2014-11-20 15:51:18');
INSERT INTO `default_supportchat` VALUES ('533', '1', '58', 'test', 'io', '105', '0', '2014-11-20 15:51:18');
INSERT INTO `default_supportchat` VALUES ('534', '1', '58', 'test', 'io', '105', '0', '2014-11-20 15:51:18');
INSERT INTO `default_supportchat` VALUES ('535', '1', '58', 'test', 'uio', '105', '0', '2014-11-20 15:51:19');
INSERT INTO `default_supportchat` VALUES ('536', '1', '58', 'test', 'uio', '105', '0', '2014-11-20 15:51:19');
INSERT INTO `default_supportchat` VALUES ('537', '1', '58', 'test', 'uio', '105', '0', '2014-11-20 15:51:20');
INSERT INTO `default_supportchat` VALUES ('538', '1', '58', 'test', 'io', '105', '0', '2014-11-20 15:51:20');
INSERT INTO `default_supportchat` VALUES ('539', '1', '58', 'test', 'uio', '105', '0', '2014-11-20 15:51:21');
INSERT INTO `default_supportchat` VALUES ('540', null, '105', 'test', 'krwa de', null, '0', '2014-11-20 15:51:37');
INSERT INTO `default_supportchat` VALUES ('541', null, '105', 'test', 'asdf', null, '0', '2014-11-20 15:51:52');
INSERT INTO `default_supportchat` VALUES ('542', null, '105', 'test', 'gfgsgsdg', null, '0', '2014-11-20 15:51:58');
INSERT INTO `default_supportchat` VALUES ('543', null, '105', 'test', 'ddddddd', null, '0', '2014-11-20 15:52:10');
INSERT INTO `default_supportchat` VALUES ('544', null, '105', 'test', 'fdf', null, '0', '2014-11-20 15:52:27');
INSERT INTO `default_supportchat` VALUES ('545', null, '121', 'test', 'hello', null, '0', '2014-11-20 15:54:04');
INSERT INTO `default_supportchat` VALUES ('546', '1', '58', 'test', 'trtreds', '121', '0', '2014-11-20 15:54:27');
INSERT INTO `default_supportchat` VALUES ('547', null, '121', 'test', 'how r u?', null, '0', '2014-11-20 15:54:29');
INSERT INTO `default_supportchat` VALUES ('548', '2', '55', 'test', 'ytrytr', null, '0', '2014-11-20 16:00:46');
INSERT INTO `default_supportchat` VALUES ('549', '3', '5', 'test', 'trtyrt', null, '0', '2014-11-20 16:01:07');
INSERT INTO `default_supportchat` VALUES ('550', '3', '5', 'test', 'tytr', null, '0', '2014-11-20 16:01:10');
INSERT INTO `default_supportchat` VALUES ('551', '3', '5', 'test', ' l\';l\'l;\'l\'l\';l\';l\'', null, '0', '2014-11-20 16:06:07');
INSERT INTO `default_supportchat` VALUES ('552', '2', '55', 'test', 'jbklljkljkljkl', null, '0', '2014-11-20 16:06:25');
INSERT INTO `default_supportchat` VALUES ('553', '1', '58', 'test', 'ukyuiyuiyui', '105', '0', '2014-11-20 16:40:38');
INSERT INTO `default_supportchat` VALUES ('554', '1', '58', 'test', 'yui', '105', '0', '2014-11-20 16:40:38');
INSERT INTO `default_supportchat` VALUES ('555', '1', '58', 'test', 'yui', '105', '0', '2014-11-20 16:40:39');
INSERT INTO `default_supportchat` VALUES ('556', '1', '58', 'test', 'i', '105', '0', '2014-11-20 16:40:39');
INSERT INTO `default_supportchat` VALUES ('557', '1', '58', 'test', 'ui', '105', '0', '2014-11-20 16:40:39');
INSERT INTO `default_supportchat` VALUES ('558', '1', '58', 'test', 'i', '105', '0', '2014-11-20 16:40:39');
INSERT INTO `default_supportchat` VALUES ('559', '1', '58', 'test', 'ui', '105', '0', '2014-11-20 16:40:40');
INSERT INTO `default_supportchat` VALUES ('560', '1', '58', 'test', 'ygdfdg', '118', '0', '2014-11-20 19:31:12');
INSERT INTO `default_supportchat` VALUES ('561', '1', '58', 'test', 'gdfgfdgdf', '5', '0', '2014-11-21 17:53:42');
INSERT INTO `default_supportchat` VALUES ('562', '3', '5', 'test', 'dfdsf', null, '0', '2014-11-21 18:02:31');
INSERT INTO `default_supportchat` VALUES ('563', '3', '5', 'test', 'fsf', null, '0', '2014-11-21 18:15:25');
INSERT INTO `default_supportchat` VALUES ('564', '2', '55', 'test', 'ffdsf', null, '0', '2014-11-21 18:17:11');
INSERT INTO `default_supportchat` VALUES ('565', '2', '61', 'test', 'fgdfd', null, '0', '2014-11-21 19:16:26');
INSERT INTO `default_supportchat` VALUES ('566', '1', '58', 'test', 'rakemdra', null, '0', '2014-11-21 20:16:37');
INSERT INTO `default_supportchat` VALUES ('567', '2', '55', 'test', 'ghfh', null, '0', '2014-11-22 11:50:49');
INSERT INTO `default_supportchat` VALUES ('568', '2', '55', 'test', 'hgfh', null, '0', '2014-11-22 12:03:48');
INSERT INTO `default_supportchat` VALUES ('569', '2', '55', 'test', 'hgf', null, '0', '2014-11-22 12:04:47');
INSERT INTO `default_supportchat` VALUES ('570', '2', '55', 'test', 'vfdg', null, '0', '2014-11-22 12:20:04');
INSERT INTO `default_supportchat` VALUES ('571', '2', '55', 'test', 'rajendra', null, '0', '2014-11-22 12:24:06');
INSERT INTO `default_supportchat` VALUES ('572', '2', '55', 'test', 'ra', null, '0', '2014-11-22 12:25:06');
INSERT INTO `default_supportchat` VALUES ('573', '2', '55', 'test', 'hghgf', null, '0', '2014-11-22 12:44:27');
INSERT INTO `default_supportchat` VALUES ('574', '2', '55', 'test', 'rajendra', null, '0', '2014-11-22 12:45:47');
INSERT INTO `default_supportchat` VALUES ('575', '1', '58', 'test', 'ffdsf', '61', '0', '2014-11-22 12:46:07');
INSERT INTO `default_supportchat` VALUES ('576', '1', '58', 'test', 'rajendra patidar', '61', '0', '2014-11-22 12:47:52');
INSERT INTO `default_supportchat` VALUES ('577', '2', '61', 'test', 'dsfds', null, '0', '2014-11-22 12:58:19');
INSERT INTO `default_supportchat` VALUES ('578', '2', '61', 'test', 'dfsfds', null, '0', '2014-11-22 12:58:30');
INSERT INTO `default_supportchat` VALUES ('579', '2', '61', 'test', 'rahenbdra dasdasdasd dasdsadasdasdasdasdasd', null, '0', '2014-11-22 13:07:33');
INSERT INTO `default_supportchat` VALUES ('580', '1', '58', 'test', 'rajednra', null, '0', '2014-11-24 11:27:34');
INSERT INTO `default_supportchat` VALUES ('581', '2', '55', 'test', ',,n,m', null, '0', '2014-11-24 11:29:36');
INSERT INTO `default_supportchat` VALUES ('582', '1', '58', 'test', 'ji sir ', '55', '0', '2014-11-24 17:57:27');
INSERT INTO `default_supportchat` VALUES ('583', '1', '58', 'test', 'how are u ', '55', '0', '2014-11-24 17:57:31');
INSERT INTO `default_supportchat` VALUES ('584', '1', '58', 'test', 'fine', '55', '0', '2014-11-24 17:57:39');
INSERT INTO `default_supportchat` VALUES ('585', '1', '58', 'test', 'ok ', '55', '0', '2014-11-24 17:57:42');
INSERT INTO `default_supportchat` VALUES ('586', '1', '58', 'test', 'due you have some things ', '55', '0', '2014-11-24 17:57:52');
INSERT INTO `default_supportchat` VALUES ('587', '1', '58', 'test', 'you know that ', '55', '0', '2014-11-24 17:58:01');
INSERT INTO `default_supportchat` VALUES ('588', '1', '58', 'test', 'waht u want', '55', '0', '2014-11-24 17:58:07');
INSERT INTO `default_supportchat` VALUES ('589', '1', '58', 'test', 'mr. patidar', '55', '0', '2014-11-24 17:58:24');
INSERT INTO `default_supportchat` VALUES ('590', '1', '58', 'test', 'bhgfsjk', '56', '0', '2014-11-25 13:02:00');
INSERT INTO `default_supportchat` VALUES ('591', '1', '58', 'test', 'dfbhn', '118', '0', '2014-11-25 13:02:04');
INSERT INTO `default_supportchat` VALUES ('592', '1', '58', 'test', 'fgsdhg', '61', '0', '2014-11-25 13:02:05');
INSERT INTO `default_supportchat` VALUES ('593', '2', '55', 'test', 'gsdfgbhkg shjkhjksag', null, '0', '2014-11-25 13:02:50');
INSERT INTO `default_supportchat` VALUES ('594', '2', '124', 'test', 'Hiiii', null, '0', '2014-11-26 11:53:44');
INSERT INTO `default_supportchat` VALUES ('595', '3', '5', 'test', 'hjh', null, '0', '2014-11-26 13:16:56');
INSERT INTO `default_supportchat` VALUES ('596', '1', '58', 'test', 'jytu', '5', '0', '2014-11-26 13:20:02');
INSERT INTO `default_supportchat` VALUES ('597', '1', '58', 'test', 'rajnedra', '55', '0', '2014-11-26 13:21:28');
INSERT INTO `default_supportchat` VALUES ('598', '2', '55', 'test', 'hello', null, '0', '2014-12-03 15:12:38');
INSERT INTO `default_supportchat` VALUES ('599', '2', '55', 'test', 'hai', null, '0', '2014-12-03 18:36:31');
INSERT INTO `default_supportchat` VALUES ('600', '2', '55', 'test', 'raju', null, '0', '2014-12-03 18:42:32');
INSERT INTO `default_supportchat` VALUES ('601', null, '105', 'test', 'hai', null, '0', '2014-12-03 19:44:39');
INSERT INTO `default_supportchat` VALUES ('602', null, '105', 'test', 'tester', null, '0', '2014-12-03 19:44:55');
INSERT INTO `default_supportchat` VALUES ('603', null, '105', 'test', 'patidar', null, '0', '2014-12-03 19:45:01');
INSERT INTO `default_supportchat` VALUES ('604', null, '105', 'test', 'patidar', null, '0', '2014-12-03 19:47:33');
INSERT INTO `default_supportchat` VALUES ('605', '3', '56', 'test', 'rajendra', null, '0', '2014-12-03 19:47:51');
INSERT INTO `default_supportchat` VALUES ('606', '3', '56', 'test', 'patidar', null, '0', '2014-12-03 19:47:56');
INSERT INTO `default_supportchat` VALUES ('607', '3', '56', 'test', 'this is test', null, '0', '2014-12-03 19:48:07');
INSERT INTO `default_supportchat` VALUES ('608', '2', '126', 'test', 'hiiiiiiiii', null, '0', '2014-12-04 18:00:33');
INSERT INTO `default_supportchat` VALUES ('609', '3', '127', 'test', 'hiiiiiii', null, '0', '2014-12-04 18:00:56');
INSERT INTO `default_supportchat` VALUES ('610', '2', '147', 'test', 'hiiiiiiiiiiiiiiiiiiii', null, '0', '2014-12-05 12:08:12');
INSERT INTO `default_supportchat` VALUES ('611', '3', '146', 'test', 'hiiiiiiiiiiiiiiiiiii', null, '0', '2014-12-05 12:08:17');
INSERT INTO `default_supportchat` VALUES ('612', '3', '146', 'test', 'hnjgfjgkg', null, '0', '2014-12-05 12:09:07');
INSERT INTO `default_supportchat` VALUES ('613', '1', '58', 'test', 'ngfjghf', '147', '0', '2014-12-05 12:09:21');
INSERT INTO `default_supportchat` VALUES ('614', '3', '146', 'test', 'hjkhjlhjlhjl', null, '0', '2014-12-05 12:09:35');
INSERT INTO `default_supportchat` VALUES ('615', '2', '55', 'test', 'Hi', null, '0', '2014-12-05 16:42:40');
INSERT INTO `default_supportchat` VALUES ('616', '2', '55', 'test', 'Anybody available?', null, '0', '2014-12-05 16:42:45');

-- ----------------------------
-- Table structure for `default_supportchat_users`
-- ----------------------------
DROP TABLE IF EXISTS `default_supportchat_users`;
CREATE TABLE `default_supportchat_users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_guest` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `last_activity` (`last_activity`)
) ENGINE=MyISAM AUTO_INCREMENT=156 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of default_supportchat_users
-- ----------------------------
INSERT INTO `default_supportchat_users` VALUES ('55', 'Raj Patidar', '2015-01-22 11:45:16', '0');

-- ----------------------------
-- Table structure for `default_testimonial`
-- ----------------------------
DROP TABLE IF EXISTS `default_testimonial`;
CREATE TABLE `default_testimonial` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `affiliate_id` int(11) DEFAULT NULL,
  `topic` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of default_testimonial
-- ----------------------------
INSERT INTO `default_testimonial` VALUES ('7', '5', '50', 'My new message', '018.png', 'Det er en kendsgerning, at man bliver distraheret af læsbart indhold på en side, når man betragter dens layout. Meningen med at bruge Lorem Ipsum er, at teksten indeholder mere eller mindre almindelig tekstopbygning i modsætning til \"Tekst her – og mere tekst her\", mens det samtidigt ligner almindelig tekst.', '2014-09-26 13:13:53');
INSERT INTO `default_testimonial` VALUES ('8', '5', '50', 'My new feedback for affiliate', null, 'Det er en kendsgerning, at man bliver distraheret af læsbart indhold på en side, når man betragter dens layout. Meningen med at bruge Lorem Ipsum er, at teksten indeholder mere eller mindre almindelig tekstopbygning i modsætning til \"Tekst her – og mere tekst her\", mens det samtidigt ligner almindelig tekst.', '2014-09-30 06:59:03');
INSERT INTO `default_testimonial` VALUES ('20', '55', null, 'dasd', null, 'Man bliver distraheret af læsbart indhold på en side, når man betragter dens layout.', '2014-09-30 13:53:58');
INSERT INTO `default_testimonial` VALUES ('21', '55', null, 'this is testing affiliate', null, 'Man bliver distraheret af læsbart indhold på en side, når man betragter dens layout.', '2014-10-04 05:57:00');
INSERT INTO `default_testimonial` VALUES ('22', '55', null, 'my testimonila', null, 'this is testimonial in the form of data', '2014-10-06 07:29:04');
INSERT INTO `default_testimonial` VALUES ('23', '5', '55', 'My testing', null, 'Social media such as Twitter have become increasingly popular mediums for celebrities to endorse brands and influence purchasing behavior. According to Bloomberg News, social-media-ad spending is expected to reach a total of $4.8 billion at the end of 2012 and $9.8 billion by 2016.[1] Advertising and marketing companies sponsor celebrities to tweet and influence thousands (sometimes millions) of their followers to buy brand products. For example, Ryan Seacrest gets paid to promote Ford products.[2] Companies that pay celebs to tweet for them subscribe to the Malcolm Gladwell theory of influence.', '2014-10-06 07:39:11');
INSERT INTO `default_testimonial` VALUES ('24', '5', '55', 'Testing', null, 'In letters testimonial from Middle French lettres testimoniaulx, from Latin litteræ testimoniales, from testimonium (see testimony). The noun meaning \"writing testifying to one\'s qualification or character\" is recorded from 1570s; that of \"gift presented as an expression of appreciation\" is from 1838.', '2014-10-06 10:05:32');

-- ----------------------------
-- Table structure for `default_theme_options`
-- ----------------------------
DROP TABLE IF EXISTS `default_theme_options`;
CREATE TABLE `default_theme_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `type` set('text','textarea','password','select','select-multiple','radio','checkbox','colour-picker') COLLATE utf8_unicode_ci NOT NULL,
  `default` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `options` text COLLATE utf8_unicode_ci NOT NULL,
  `is_required` int(1) NOT NULL,
  `theme` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_theme_options
-- ----------------------------
INSERT INTO `default_theme_options` VALUES ('1', 'pyrocms_recent_comments', 'Recent Comments', 'Would you like to display recent comments on the dashboard?', 'radio', 'yes', 'yes', 'yes=Yes|no=No', '1', 'pyrocms');
INSERT INTO `default_theme_options` VALUES ('2', 'pyrocms_news_feed', 'News Feed', 'Would you like to display the news feed on the dashboard?', 'radio', 'yes', 'yes', 'yes=Yes|no=No', '1', 'pyrocms');
INSERT INTO `default_theme_options` VALUES ('3', 'pyrocms_quick_links', 'Quick Links', 'Would you like to display quick links on the dashboard?', 'radio', 'yes', 'yes', 'yes=Yes|no=No', '1', 'pyrocms');
INSERT INTO `default_theme_options` VALUES ('4', 'pyrocms_analytics_graph', 'Analytics Graph', 'Would you like to display the graph on the dashboard?', 'radio', 'yes', 'yes', 'yes=Yes|no=No', '1', 'pyrocms');
INSERT INTO `default_theme_options` VALUES ('5', 'show_breadcrumbs', 'Show Breadcrumbs', 'Would you like to display breadcrumbs?', 'radio', 'yes', 'no', 'yes=Yes|no=No', '1', 'default');
INSERT INTO `default_theme_options` VALUES ('6', 'layout', 'Layout', 'Which type of layout shall we use?', 'select', '2 column', 'full-width', '2 column=Two Column|full-width=Full Width|full-width-home=Full Width Home Page', '1', 'default');
INSERT INTO `default_theme_options` VALUES ('7', 'background', 'Background', 'Choose the default background for the theme.', 'select', 'fabric', 'fabric', 'black=Black|fabric=Fabric|graph=Graph|leather=Leather|noise=Noise|texture=Texture', '1', 'base');
INSERT INTO `default_theme_options` VALUES ('8', 'slider', 'Slider', 'Would you like to display the slider on the homepage?', 'radio', 'yes', 'yes', 'yes=Yes|no=No', '1', 'base');
INSERT INTO `default_theme_options` VALUES ('9', 'color', 'Default Theme Color', 'This changes things like background color, link colors etc…', 'select', 'pink', 'pink', 'red=Red|orange=Orange|yellow=Yellow|green=Green|blue=Blue|pink=Pink', '1', 'base');
INSERT INTO `default_theme_options` VALUES ('10', 'show_breadcrumbs', 'Do you want to show breadcrumbs?', 'If selected it shows a string of breadcrumbs at the top of the page.', 'radio', 'yes', 'no', 'yes=Yes|no=No', '1', 'base');
INSERT INTO `default_theme_options` VALUES ('13', 'show_breadcrumbs', 'Show Breadcrumbs', 'Would you like to display breadcrumbs?', 'radio', 'yes', 'no', 'yes=Yes|no=No', '1', 'referral');
INSERT INTO `default_theme_options` VALUES ('14', 'layout', 'Layout', 'Which type of layout shall we use?', 'select', '2 column', 'full-width', '2 column=Two Column|full-width=Full Width|full-width-home=Full Width Home Page', '1', 'referral');

-- ----------------------------
-- Table structure for `default_users`
-- ----------------------------
DROP TABLE IF EXISTS `default_users`;
CREATE TABLE `default_users` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(100) NOT NULL,
  `salt` varchar(6) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) NOT NULL,
  `last_login` int(11) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `sex` int(11) DEFAULT '0',
  `date_of_birth` datetime DEFAULT NULL,
  `address` text,
  `company` varchar(255) NOT NULL,
  `domain_name` varchar(255) NOT NULL,
  `membership_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `membership_expiry_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `membership_type` int(11) NOT NULL,
  `user_block` enum('0','1') NOT NULL DEFAULT '1',
  `is_guest` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=156 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of default_users
-- ----------------------------
INSERT INTO `default_users` VALUES ('5', 'merchantv', 'merchant', 'merchant@merchant.com', '54805f1bcef2d3c197bb64c588eacd8bd0c4c5f2', '041e0e', '3', '127.0.0.1', '1', null, '1409919945', '1418868578', null, '54805f1bcef2d3c197bb64c588eacd8bd0c4c5f2', null, '985522', '0', '1990-02-02 00:00:00', 'Address', '', 'http://www.cdn.com', '2014-12-18 13:09:38', '2015-11-16 00:00:00', '5', '0', null);
INSERT INTO `default_users` VALUES ('50', 'piyush', 'jain', 'piyushjain@cdnsol.com', '573abc28cd1c88dc2f803625e32505f54b7e525e', 'd05eaa', '3', '192.168.0.74', '0', null, '1411720560', '1411720560', null, null, null, '45454545', '0', null, null, 'cmp', 'http://cdnsolutionsgroup.com/referralsystem/', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '0', null);
INSERT INTO `default_users` VALUES ('55', 'raj', 'patidar', 'rajendrapatidar@cdnsol.com', '062df186d00de65179c113d4242dfd643653c9a2', '980e50', '2', '127.0.0.1', '1', null, '1411746234', '1421887515', null, '062df186d00de65179c113d4242dfd643653c9a2', 'a2a5cf00c9e280bed2acebed7c4b7215ab801070', '454545454', '0', '2014-10-23 00:00:00', 'testet', 'cmp', '', '2015-01-22 11:45:15', '2014-11-30 12:42:19', '0', '0', null);
INSERT INTO `default_users` VALUES ('56', 'Sushil', 'Mishra', 'sushilmishra@cdnsol.com', '948e3da7455600dd468dd088be46b94376f32750', '4e64d7', '3', '192.168.0.123', '1', '', '1411794438', '1418606480', null, 'cde055658f57190c75ba4459a33f0fdbf0e7e9d7', null, '9713524996', '0', '1990-02-02 00:00:00', 'fdgdfhdfhr', 'CDN', 'cdnsolutionsgroup.com', '2014-12-15 12:21:20', '2015-11-07 00:00:00', '5', '0', null);
INSERT INTO `default_users` VALUES ('58', 'rajendra', 'patidar', 'rajendrapatidar@cdnsol.com', '2412dc6f71a135efd77824d31d9222bbc922a784', 'f5f1a9', '1', '127.0.0.1', '1', null, '1412159286', '1421529087', null, '2412dc6f71a135efd77824d31d9222bbc922a784', 'dd3806d0b7e2124be01c173433fc08090272e0f8', '974545454', '0', '1970-01-01 00:00:00', 'Vivekand colony ujjian', 'cmp', 'www.goggle.com', '2015-01-18 08:11:27', '2014-11-30 12:34:25', '1', '0', null);
INSERT INTO `default_users` VALUES ('61', 'affiliate', 'affiliate', 'affiliate@cdnsol.com', '2a5ec77b934a35fc3e0ab8c91ee3141ab83f4fb4', 'd3c082', '2', '127.0.0.1', '1', null, '1412843949', '1416880897', null, null, null, '978787878', '0', '2014-10-23 00:00:00', 'tester', 'cmp', '', '2014-11-25 13:01:37', '0000-00-00 00:00:00', '0', '0', null);
INSERT INTO `default_users` VALUES ('62', 'user', 'user', 'user@cdnsol.com', '39e8c40561f66c43adc58e8509e99b7027e29815', '221217', '2', '127.0.0.1', '1', '', '1412852920', '1412852920', null, null, null, '97878787', '0', null, null, 'cmp', '', '2014-11-21 19:45:07', '0000-00-00 00:00:00', '0', '0', null);
INSERT INTO `default_users` VALUES ('63', 'test', 'test', 'test1@test.com', '260bd760c381c245fdbf1085afd77bda4e951cc3', '93e5a1', '2', '127.0.0.1', '1', null, '1412853538', '1415073272', null, null, null, '23423443', '0', null, null, 'asdfaf', '', '2014-11-04 15:03:09', '0000-00-00 00:00:00', '0', '0', null);
INSERT INTO `default_users` VALUES ('67', 'rajendra', 'patidar', 'f@cdnsol.com', 'c48e7e6c85ec95a0f46abb3ce30bc48d660def20', '3ee80b', '3', '127.0.0.1', '1', null, '1413547985', '1414647442', null, 'c48e7e6c85ec95a0f46abb3ce30bc48d660def20', null, '9754545', '0', '1970-01-01 00:00:00', 'tester', 'cmp', 'http://www.cdn.com', '2014-11-01 11:37:44', '0000-00-00 00:00:00', '1', '0', null);
INSERT INTO `default_users` VALUES ('73', 'Sushil', 'Mishra', 'sushilmishra@cdnsol.com', 'ab11896c052be805844c5a259d268a168b823aa0', '2ac497', '2', '192.168.0.123', '1', '', '1414737406', '1421486224', null, null, null, '9713524996', '0', '1982-08-25 00:00:00', 'Address will come here', 'CDN', 'http://cdnsolutionsgroup.com', '2015-01-17 20:17:04', '0000-00-00 00:00:00', '0', '0', null);
INSERT INTO `default_users` VALUES ('74', 'Abhishek', 'Parashar', 'abhishekparashar@cdnsol.com', 'f966df8e2579060b4174f8f8808276df60d6eece', '6a4223', '3', '192.168.0.123', '0', null, '1414738254', '1414738254', null, null, null, '123456', '0', '1986-06-11 00:00:00', 'Address Address Address', 'CDN', 'http://cdnsolutionsgroup.com', '2014-10-31 13:31:30', '0000-00-00 00:00:00', '5', '0', null);
INSERT INTO `default_users` VALUES ('86', 'tester', 'tester', 'tester@cdnsol.com', 'd3bc5529cf4e4382e0e6adea616342264702444b', 'd8858b', '1', '127.0.0.1', '1', null, '1414818585', '1414818585', null, 'd3bc5529cf4e4382e0e6adea616342264702444b', null, '975326582', '0', '2014-11-05 00:00:00', 'Vive', '', 'http://www.cdn.com', '2014-11-01 11:33:12', '2014-11-30 11:33:12', '0', '0', null);
INSERT INTO `default_users` VALUES ('92', 'master', 'merchant', 'rajendra@cdnsol.com', 'bd919121c40eb06badb07d7d4cec6584b23c31e7', '5fc8f2', '3', '127.0.0.1', '1', null, '1415079889', '1415079973', null, null, null, '97878787', '0', '2014-11-04 00:00:00', 'vivekand Colony ujjian', 'cmp', 'http://www.cdn.com', '2014-11-04 05:50:12', '2015-11-11 00:00:00', '5', '0', null);
INSERT INTO `default_users` VALUES ('105', 'lok', '', 'lokendrameena@cdnsol.com', '', '', null, null, null, null, '1415110019', '1415110019', 'lok', null, null, '0', '0', null, null, '', '', '2014-11-04 19:45:36', '0000-00-00 00:00:00', '0', '1', '1');
INSERT INTO `default_users` VALUES ('106', 'tester', 'tester', 'tester@cdnsol.com', '4fd1006387fe4e50125909893d0e5b54f951fe7c', '9e292b', '3', '127.0.0.1', '1', null, '1415111245', '1415630104', null, null, null, '97878787', '0', '2014-11-04 00:00:00', 'address', '', 'http://www.cdn.com', '2014-11-10 20:14:03', '2015-11-05 00:00:00', '5', '0', null);
INSERT INTO `default_users` VALUES ('118', 'rajendra', 'patidar', 'rajendrapatidar@cdnsol.com', '934444357bcf5dcdbc2c07ab1eab97107d766aa6', '3d4fef', '3', '192.168.0.74', '0', null, '1415716817', '1417050001', null, null, null, '9787878787', '0', '2000-02-05 00:00:00', 'Vivekand colony ujjain', 'cmp', 'www.cdnsol.com', '2014-11-27 12:00:01', '2015-11-06 00:00:00', '5', '0', null);
INSERT INTO `default_users` VALUES ('119', 'lok', '', 'lokendrameean@cdnsol.com', '', '', null, null, null, null, '1415773281', '1415773281', 'lok', null, null, '0', '0', null, null, '', '', '2014-11-12 12:00:27', '0000-00-00 00:00:00', '0', '1', '1');
INSERT INTO `default_users` VALUES ('120', 'trilok410', '', 'trilochanumath@cdnsol.com', '', '', null, null, null, null, '1416468562', '1416468562', 'trilok410', null, null, '0', '0', null, null, '', '', '2014-11-20 13:08:57', '0000-00-00 00:00:00', '0', '1', '1');
INSERT INTO `default_users` VALUES ('121', 'tosif', '', 'tosif@cdnsol.com', '', '', null, null, null, null, '1416479023', '1416479023', 'tosif', null, null, '0', '0', null, null, '', '', '2014-11-20 15:53:43', '0000-00-00 00:00:00', '0', '1', '1');
INSERT INTO `default_users` VALUES ('147', 'Sunil', 'Pal', 'Sunilpal@cdnsol.com', 'ea0b603353d702e150c8dc17d3ab16caa8f48665', '8b40f9', '2', '192.168.0.127', '1', '', '1417760049', '1418625499', null, null, null, '+919993978009', '0', '2003-12-29 00:00:00', 'Anoop Nagar Indore', 'CDN Software Solution', 'www.cdnsol.com', '2014-12-15 12:19:25', '0000-00-00 00:00:00', '1', '0', null);
INSERT INTO `default_users` VALUES ('153', 'Prashant', 'gupta', 'prashantgupta@cdnsol.com', '2796984d5f9b94682fcd8d4f86c030f7c3cd1479', '90b145', '2', '192.168.0.127', '1', '', '1418368319', '1418360619', null, null, null, '1234567935414', '0', '2004-12-02 00:00:00', 'sdgdg', 'CDN Software Solution', 'www.cdnsol.com', '2014-12-12 16:03:39', '0000-00-00 00:00:00', '1', '0', null);
INSERT INTO `default_users` VALUES ('154', 'prashant', 'gupta', 'prashantgupta@cdnsol.com', '7035130c217fbf7697e577bee9742b6fc97ade19', '9bf190', '3', '192.168.0.127', '1', '', '1418368472', '1418356889', null, null, null, '+91789456123', '0', '2004-12-02 00:00:00', 'cdsavgv', 'CDN', 'www.cdnsol.com', '2014-12-12 15:01:29', '2015-01-11 00:00:00', '1', '0', null);
INSERT INTO `default_users` VALUES ('155', 'roger', '', 'roger@hybrid-power.com', '', '', null, null, null, null, '1421504987', '1421504987', 'roger', null, null, '0', '0', null, null, '', '', '2015-01-17 19:59:47', '0000-00-00 00:00:00', '0', '1', '1');

-- ----------------------------
-- Table structure for `default_variables`
-- ----------------------------
DROP TABLE IF EXISTS `default_variables`;
CREATE TABLE `default_variables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_variables
-- ----------------------------
INSERT INTO `default_variables` VALUES ('1', 'sign_up', '<a href=\"register\" class=\"btn big_btn\">Sign Up Now</a>');

-- ----------------------------
-- Table structure for `default_widget_areas`
-- ----------------------------
DROP TABLE IF EXISTS `default_widget_areas`;
CREATE TABLE `default_widget_areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_widget_areas
-- ----------------------------
INSERT INTO `default_widget_areas` VALUES ('1', 'sidebar', 'Sidebar');

-- ----------------------------
-- Table structure for `default_widget_instances`
-- ----------------------------
DROP TABLE IF EXISTS `default_widget_instances`;
CREATE TABLE `default_widget_instances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `widget_id` int(11) DEFAULT NULL,
  `widget_area_id` int(11) DEFAULT NULL,
  `options` text COLLATE utf8_unicode_ci NOT NULL,
  `order` int(10) NOT NULL DEFAULT '0',
  `created_on` int(11) NOT NULL DEFAULT '0',
  `updated_on` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_widget_instances
-- ----------------------------

-- ----------------------------
-- Table structure for `default_widgets`
-- ----------------------------
DROP TABLE IF EXISTS `default_widgets`;
CREATE TABLE `default_widgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `version` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `enabled` int(1) NOT NULL DEFAULT '1',
  `order` int(10) NOT NULL DEFAULT '0',
  `updated_on` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of default_widgets
-- ----------------------------
INSERT INTO `default_widgets` VALUES ('1', 'google_maps', 'a:10:{s:2:\"en\";s:11:\"Google Maps\";s:2:\"el\";s:19:\"Χάρτης Google\";s:2:\"nl\";s:11:\"Google Maps\";s:2:\"br\";s:11:\"Google Maps\";s:2:\"pt\";s:11:\"Google Maps\";s:2:\"ru\";s:17:\"Карты Google\";s:2:\"id\";s:11:\"Google Maps\";s:2:\"fi\";s:11:\"Google Maps\";s:2:\"fr\";s:11:\"Google Maps\";s:2:\"fa\";s:17:\"نقشه گوگل\";}', 'a:10:{s:2:\"en\";s:32:\"Display Google Maps on your site\";s:2:\"el\";s:78:\"Προβάλετε έναν Χάρτη Google στον ιστότοπό σας\";s:2:\"nl\";s:27:\"Toon Google Maps in uw site\";s:2:\"br\";s:34:\"Mostra mapas do Google no seu site\";s:2:\"pt\";s:34:\"Mostra mapas do Google no seu site\";s:2:\"ru\";s:80:\"Выводит карты Google на страницах вашего сайта\";s:2:\"id\";s:37:\"Menampilkan Google Maps di Situs Anda\";s:2:\"fi\";s:39:\"Näytä Google Maps kartta sivustollasi\";s:2:\"fr\";s:42:\"Publiez un plan Google Maps sur votre site\";s:2:\"fa\";s:59:\"نمایش داده نقشه گوگل بر روی سایت \";}', 'Gregory Athons', 'http://www.gregathons.com', '1.0.0', '1', '1', '1410953800');
INSERT INTO `default_widgets` VALUES ('2', 'html', 's:4:\"HTML\";', 'a:10:{s:2:\"en\";s:28:\"Create blocks of custom HTML\";s:2:\"el\";s:80:\"Δημιουργήστε περιοχές με δικό σας κώδικα HTML\";s:2:\"br\";s:41:\"Permite criar blocos de HTML customizados\";s:2:\"pt\";s:41:\"Permite criar blocos de HTML customizados\";s:2:\"nl\";s:30:\"Maak blokken met maatwerk HTML\";s:2:\"ru\";s:83:\"Создание HTML-блоков с произвольным содержимым\";s:2:\"id\";s:24:\"Membuat blok HTML apapun\";s:2:\"fi\";s:32:\"Luo lohkoja omasta HTML koodista\";s:2:\"fr\";s:36:\"Créez des blocs HTML personnalisés\";s:2:\"fa\";s:58:\"ایجاد قسمت ها به صورت اچ تی ام ال\";}', 'Phil Sturgeon', 'http://philsturgeon.co.uk/', '1.0.0', '1', '2', '1410953800');
INSERT INTO `default_widgets` VALUES ('3', 'login', 'a:10:{s:2:\"en\";s:5:\"Login\";s:2:\"el\";s:14:\"Σύνδεση\";s:2:\"nl\";s:5:\"Login\";s:2:\"br\";s:5:\"Login\";s:2:\"pt\";s:5:\"Login\";s:2:\"ru\";s:22:\"Вход на сайт\";s:2:\"id\";s:5:\"Login\";s:2:\"fi\";s:13:\"Kirjautuminen\";s:2:\"fr\";s:9:\"Connexion\";s:2:\"fa\";s:10:\"لاگین\";}', 'a:10:{s:2:\"en\";s:36:\"Display a simple login form anywhere\";s:2:\"el\";s:96:\"Προβάλετε μια απλή φόρμα σύνδεσης χρήστη οπουδήποτε\";s:2:\"br\";s:69:\"Permite colocar um formulário de login em qualquer lugar do seu site\";s:2:\"pt\";s:69:\"Permite colocar um formulário de login em qualquer lugar do seu site\";s:2:\"nl\";s:32:\"Toon overal een simpele loginbox\";s:2:\"ru\";s:72:\"Выводит простую форму для входа на сайт\";s:2:\"id\";s:32:\"Menampilkan form login sederhana\";s:2:\"fi\";s:52:\"Näytä yksinkertainen kirjautumislomake missä vain\";s:2:\"fr\";s:54:\"Affichez un formulaire de connexion où vous souhaitez\";s:2:\"fa\";s:70:\"نمایش یک لاگین ساده در هر قسمتی از سایت\";}', 'Phil Sturgeon', 'http://philsturgeon.co.uk/', '1.0.0', '1', '3', '1410953800');
INSERT INTO `default_widgets` VALUES ('4', 'navigation', 'a:10:{s:2:\"en\";s:10:\"Navigation\";s:2:\"el\";s:16:\"Πλοήγηση\";s:2:\"nl\";s:9:\"Navigatie\";s:2:\"br\";s:11:\"Navegação\";s:2:\"pt\";s:11:\"Navegação\";s:2:\"ru\";s:18:\"Навигация\";s:2:\"id\";s:8:\"Navigasi\";s:2:\"fi\";s:10:\"Navigaatio\";s:2:\"fr\";s:10:\"Navigation\";s:2:\"fa\";s:10:\"منوها\";}', 'a:10:{s:2:\"en\";s:40:\"Display a navigation group with a widget\";s:2:\"el\";s:100:\"Προβάλετε μια ομάδα στοιχείων πλοήγησης στον ιστότοπο\";s:2:\"nl\";s:38:\"Toon een navigatiegroep met een widget\";s:2:\"br\";s:62:\"Exibe um grupo de links de navegação como widget em seu site\";s:2:\"pt\";s:62:\"Exibe um grupo de links de navegação como widget no seu site\";s:2:\"ru\";s:88:\"Отображает навигационную группу внутри виджета\";s:2:\"id\";s:44:\"Menampilkan grup navigasi menggunakan widget\";s:2:\"fi\";s:37:\"Näytä widgetillä navigaatio ryhmä\";s:2:\"fr\";s:47:\"Affichez un groupe de navigation dans un widget\";s:2:\"fa\";s:71:\"نمایش گروهی از منوها با استفاده از ویجت\";}', 'Phil Sturgeon', 'http://philsturgeon.co.uk/', '1.2.0', '1', '4', '1410953800');
INSERT INTO `default_widgets` VALUES ('5', 'rss_feed', 'a:10:{s:2:\"en\";s:8:\"RSS Feed\";s:2:\"el\";s:24:\"Τροφοδοσία RSS\";s:2:\"nl\";s:8:\"RSS Feed\";s:2:\"br\";s:8:\"Feed RSS\";s:2:\"pt\";s:8:\"Feed RSS\";s:2:\"ru\";s:31:\"Лента новостей RSS\";s:2:\"id\";s:8:\"RSS Feed\";s:2:\"fi\";s:10:\"RSS Syöte\";s:2:\"fr\";s:8:\"Flux RSS\";s:2:\"fa\";s:19:\"خبر خوان RSS\";}', 'a:10:{s:2:\"en\";s:41:\"Display parsed RSS feeds on your websites\";s:2:\"el\";s:82:\"Προβάλετε τα περιεχόμενα μιας τροφοδοσίας RSS\";s:2:\"nl\";s:28:\"Toon RSS feeds op uw website\";s:2:\"br\";s:48:\"Interpreta e exibe qualquer feed RSS no seu site\";s:2:\"pt\";s:48:\"Interpreta e exibe qualquer feed RSS no seu site\";s:2:\"ru\";s:94:\"Выводит обработанную ленту новостей на вашем сайте\";s:2:\"id\";s:42:\"Menampilkan kutipan RSS feed di situs Anda\";s:2:\"fi\";s:39:\"Näytä purettu RSS syöte sivustollasi\";s:2:\"fr\";s:39:\"Affichez un flux RSS sur votre site web\";s:2:\"fa\";s:46:\"نمایش خوراک های RSS در سایت\";}', 'Phil Sturgeon', 'http://philsturgeon.co.uk/', '1.2.0', '1', '5', '1410953800');
INSERT INTO `default_widgets` VALUES ('6', 'social_bookmark', 'a:10:{s:2:\"en\";s:15:\"Social Bookmark\";s:2:\"el\";s:35:\"Κοινωνική δικτύωση\";s:2:\"nl\";s:19:\"Sociale Bladwijzers\";s:2:\"br\";s:15:\"Social Bookmark\";s:2:\"pt\";s:15:\"Social Bookmark\";s:2:\"ru\";s:37:\"Социальные закладки\";s:2:\"id\";s:15:\"Social Bookmark\";s:2:\"fi\";s:24:\"Sosiaalinen kirjanmerkki\";s:2:\"fr\";s:13:\"Liens sociaux\";s:2:\"fa\";s:52:\"بوکمارک های شبکه های اجتماعی\";}', 'a:10:{s:2:\"en\";s:47:\"Configurable social bookmark links from AddThis\";s:2:\"el\";s:111:\"Παραμετροποιήσιμα στοιχεία κοινωνικής δικτυώσης από το AddThis\";s:2:\"nl\";s:43:\"Voeg sociale bladwijzers toe vanuit AddThis\";s:2:\"br\";s:87:\"Adiciona links de redes sociais usando o AddThis, podendo fazer algumas configurações\";s:2:\"pt\";s:87:\"Adiciona links de redes sociais usando o AddThis, podendo fazer algumas configurações\";s:2:\"ru\";s:90:\"Конфигурируемые социальные закладки с сайта AddThis\";s:2:\"id\";s:60:\"Tautan social bookmark yang dapat dikonfigurasi dari AddThis\";s:2:\"fi\";s:59:\"Konfiguroitava sosiaalinen kirjanmerkki linkit AddThis:stä\";s:2:\"fr\";s:43:\"Liens sociaux personnalisables avec AddThis\";s:2:\"fa\";s:71:\"تنظیم و نمایش لینک های شبکه های اجتماعی\";}', 'Phil Sturgeon', 'http://philsturgeon.co.uk/', '1.0.0', '1', '6', '1410953800');
INSERT INTO `default_widgets` VALUES ('7', 'archive', 'a:8:{s:2:\"en\";s:7:\"Archive\";s:2:\"br\";s:15:\"Arquivo do Blog\";s:2:\"fa\";s:10:\"آرشیو\";s:2:\"pt\";s:15:\"Arquivo do Blog\";s:2:\"el\";s:33:\"Αρχείο Ιστολογίου\";s:2:\"fr\";s:16:\"Archives du Blog\";s:2:\"ru\";s:10:\"Архив\";s:2:\"id\";s:7:\"Archive\";}', 'a:8:{s:2:\"en\";s:64:\"Display a list of old months with links to posts in those months\";s:2:\"br\";s:95:\"Mostra uma lista navegação cronológica contendo o índice dos artigos publicados mensalmente\";s:2:\"fa\";s:101:\"نمایش لیست ماه های گذشته به همراه لینک به پست های مربوطه\";s:2:\"pt\";s:95:\"Mostra uma lista navegação cronológica contendo o índice dos artigos publicados mensalmente\";s:2:\"el\";s:155:\"Προβάλλει μια λίστα μηνών και συνδέσμους σε αναρτήσεις που έγιναν σε κάθε από αυτούς\";s:2:\"fr\";s:95:\"Permet d\'afficher une liste des mois passés avec des liens vers les posts relatifs à ces mois\";s:2:\"ru\";s:114:\"Выводит список по месяцам со ссылками на записи в этих месяцах\";s:2:\"id\";s:63:\"Menampilkan daftar bulan beserta tautan post di setiap bulannya\";}', 'Phil Sturgeon', 'http://philsturgeon.co.uk/', '1.0.0', '0', '7', '1410953800');
INSERT INTO `default_widgets` VALUES ('8', 'blog_categories', 'a:8:{s:2:\"en\";s:15:\"Blog Categories\";s:2:\"br\";s:18:\"Categorias do Blog\";s:2:\"pt\";s:18:\"Categorias do Blog\";s:2:\"el\";s:41:\"Κατηγορίες Ιστολογίου\";s:2:\"fr\";s:19:\"Catégories du Blog\";s:2:\"ru\";s:29:\"Категории Блога\";s:2:\"id\";s:12:\"Kateori Blog\";s:2:\"fa\";s:28:\"مجموعه های بلاگ\";}', 'a:8:{s:2:\"en\";s:30:\"Show a list of blog categories\";s:2:\"br\";s:57:\"Mostra uma lista de navegação com as categorias do Blog\";s:2:\"pt\";s:57:\"Mostra uma lista de navegação com as categorias do Blog\";s:2:\"el\";s:97:\"Προβάλει την λίστα των κατηγοριών του ιστολογίου σας\";s:2:\"fr\";s:49:\"Permet d\'afficher la liste de Catégories du Blog\";s:2:\"ru\";s:57:\"Выводит список категорий блога\";s:2:\"id\";s:35:\"Menampilkan daftar kategori tulisan\";s:2:\"fa\";s:55:\"نمایش لیستی از مجموعه های بلاگ\";}', 'Stephen Cozart', 'http://github.com/clip/', '1.0.0', '0', '8', '1410953800');
INSERT INTO `default_widgets` VALUES ('9', 'latest_posts', 'a:8:{s:2:\"en\";s:12:\"Latest posts\";s:2:\"br\";s:24:\"Artigos recentes do Blog\";s:2:\"fa\";s:26:\"آخرین ارسال ها\";s:2:\"pt\";s:24:\"Artigos recentes do Blog\";s:2:\"el\";s:62:\"Τελευταίες αναρτήσεις ιστολογίου\";s:2:\"fr\";s:17:\"Derniers articles\";s:2:\"ru\";s:31:\"Последние записи\";s:2:\"id\";s:12:\"Post Terbaru\";}', 'a:8:{s:2:\"en\";s:39:\"Display latest blog posts with a widget\";s:2:\"br\";s:81:\"Mostra uma lista de navegação para abrir os últimos artigos publicados no Blog\";s:2:\"fa\";s:65:\"نمایش آخرین پست های وبلاگ در یک ویجت\";s:2:\"pt\";s:81:\"Mostra uma lista de navegação para abrir os últimos artigos publicados no Blog\";s:2:\"el\";s:103:\"Προβάλει τις πιο πρόσφατες αναρτήσεις στο ιστολόγιό σας\";s:2:\"fr\";s:68:\"Permet d\'afficher la liste des derniers posts du blog dans un Widget\";s:2:\"ru\";s:100:\"Выводит список последних записей блога внутри виджета\";s:2:\"id\";s:51:\"Menampilkan posting blog terbaru menggunakan widget\";}', 'Erik Berman', 'http://www.nukleo.fr', '1.0.0', '0', '9', '1410953800');

-- ----------------------------
-- Table structure for `limits`
-- ----------------------------
DROP TABLE IF EXISTS `limits`;
CREATE TABLE `limits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) NOT NULL,
  `count` int(10) NOT NULL,
  `hour_started` int(11) NOT NULL,
  `api_key` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of limits
-- ----------------------------

-- ----------------------------
-- Table structure for `nm_migrations`
-- ----------------------------
DROP TABLE IF EXISTS `nm_migrations`;
CREATE TABLE `nm_migrations` (
  `version` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of nm_migrations
-- ----------------------------
INSERT INTO `nm_migrations` VALUES ('1');
