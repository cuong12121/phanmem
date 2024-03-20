/*
 Navicat MySQL Data Transfer

 Source Server         : admin
 Source Server Type    : MySQL
 Source Server Version : 100121
 Source Host           : localhost:3306
 Source Schema         : sbong88

 Target Server Type    : MySQL
 Target Server Version : 100121
 File Encoding         : 65001

 Date: 16/08/2018 10:24:59
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for fs_phone_fast
-- ----------------------------
DROP TABLE IF EXISTS `fs_phone_fast`;
CREATE TABLE `fs_phone_fast`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` int(11) NULL DEFAULT NULL,
  `time` datetime(0) NULL DEFAULT NULL,
  `created_time` datetime(0) NULL DEFAULT NULL,
  `published` tinyint(1) NULL DEFAULT NULL,
  `ordering` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of fs_phone_fast
-- ----------------------------
INSERT INTO `fs_phone_fast` VALUES (1, 456789, '0000-00-00 00:00:00', NULL, NULL, NULL);
INSERT INTO `fs_phone_fast` VALUES (2, 56789, NULL, NULL, NULL, NULL);
INSERT INTO `fs_phone_fast` VALUES (3, 12356, NULL, NULL, NULL, NULL);
INSERT INTO `fs_phone_fast` VALUES (4, 234567, '0000-00-00 00:00:00', NULL, NULL, NULL);
INSERT INTO `fs_phone_fast` VALUES (5, 12345, '2018-05-20 19:39:13', NULL, NULL, NULL);
INSERT INTO `fs_phone_fast` VALUES (6, 456789, '2018-05-21 15:54:45', NULL, NULL, NULL);
INSERT INTO `fs_phone_fast` VALUES (7, 987654323, '2018-05-22 14:04:14', NULL, NULL, NULL);
INSERT INTO `fs_phone_fast` VALUES (8, 1234567890, '2018-06-04 09:34:45', NULL, NULL, NULL);
INSERT INTO `fs_phone_fast` VALUES (9, 1293485738, '2018-06-04 09:41:00', NULL, NULL, NULL);
INSERT INTO `fs_phone_fast` VALUES (10, 1234567890, '2018-06-14 08:43:36', NULL, NULL, NULL);
INSERT INTO `fs_phone_fast` VALUES (11, 2345678, '2018-06-14 08:52:08', NULL, NULL, NULL);
INSERT INTO `fs_phone_fast` VALUES (12, 12345678, '2018-06-14 08:55:06', NULL, NULL, NULL);
INSERT INTO `fs_phone_fast` VALUES (13, 123456, '2018-06-14 09:17:00', NULL, NULL, NULL);
INSERT INTO `fs_phone_fast` VALUES (14, 1234567, '2018-06-14 09:20:10', NULL, NULL, NULL);
INSERT INTO `fs_phone_fast` VALUES (15, 34567, '2018-06-14 09:31:33', NULL, NULL, NULL);

SET FOREIGN_KEY_CHECKS = 1;
