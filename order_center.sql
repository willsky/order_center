/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : order_center

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2012-11-04 03:03:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `w_orders`
-- ----------------------------
DROP TABLE IF EXISTS `w_orders`;
CREATE TABLE `w_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` smallint(6) NOT NULL COMMENT '产品ID',
  `product_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `customer_realname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `customer_telephone` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `customer_email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_postal` varchar(7) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customer_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_note` text COLLATE utf8_unicode_ci COMMENT '客户备注信息',
  `customer_ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT '客户端ip',
  `ts_id` smallint(6) NOT NULL DEFAULT '0' COMMENT '物流id',
  `send_id` int(11) NOT NULL DEFAULT '0' COMMENT '发货人',
  `note` text COLLATE utf8_unicode_ci COMMENT '备注信息',
  `state` smallint(6) NOT NULL DEFAULT '0' COMMENT '0:未处理, 1：已发货, 2:完成，可能根据收款来判断',
  `payment` smallint(6) NOT NULL DEFAULT '0' COMMENT '0：货到付款,1：支付宝，后面再定义',
  `sended` int(11) NOT NULL DEFAULT '0' COMMENT '发货时间',
  `created` int(11) NOT NULL COMMENT '下单时间',
  `updated` int(11) NOT NULL COMMENT '最后操作时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
/*!50100 PARTITION BY RANGE (id)
(PARTITION p0 VALUES LESS THAN (200000) ENGINE = InnoDB,
 PARTITION p1 VALUES LESS THAN (400000) ENGINE = InnoDB,
 PARTITION p2 VALUES LESS THAN (600000) ENGINE = InnoDB,
 PARTITION p3 VALUES LESS THAN (800000) ENGINE = InnoDB,
 PARTITION p4 VALUES LESS THAN (1000000) ENGINE = InnoDB) */;

-- ----------------------------
-- Records of w_orders
-- ----------------------------
INSERT INTO `w_orders` VALUES ('1', '2', '美发店赢利秘笈', '徐仙华', '13798293705', '822178483', '518000', '深圳市南山区研祥科技大厦7楼', '深圳市南山区研祥科技大厦7楼, POS刷卡', '127.0.0.1', '0', '0', null, '0', '0', '0', '1351787699', '1351787699');
INSERT INTO `w_orders` VALUES ('2', '1', '主持人培训教程大全', '徐仙华', '18038040016', '252060583', '518000', '深圳市南山区科技园研祥科技大厦', '深圳市南山区科技园研祥科技大厦,上班时间送货', '127.0.0.1', '0', '0', null, '0', '0', '0', '1351787829', '1351787829');
INSERT INTO `w_orders` VALUES ('3', '1', '主持人培训教程大全', '徐仙华', '18038040016', '252060583', '518000', '深圳市南山区科技园研祥科技大厦', '深圳市南山区科技园研祥科技大厦,上班时间送货', '127.0.0.1', '0', '0', null, '0', '0', '0', '1351787860', '1351787860');
INSERT INTO `w_orders` VALUES ('4', '1', '主持人培训教程大全', '唐林玉', '13798293706', '254356805', '518000', '深圳市宝安区', '深圳市宝安区', '127.0.0.1', '0', '0', null, '0', '0', '0', '1351787987', '1351787987');
INSERT INTO `w_orders` VALUES ('5', '2', '美发店赢利秘笈', '唐林玉', '13798293706', '254356805', '518000', '深圳市宝安区41区', '随时可以送货', '127.0.0.1', '0', '0', null, '0', '0', '0', '1351788144', '1351788144');
INSERT INTO `w_orders` VALUES ('6', '3', '无基础开花店运营', '徐仙华', '13798293705', '252060583', '518000', '深圳市宝安区41区', '无基础开花店运营方案升级版 尖叫价 298元', '127.0.0.1', '0', '0', null, '0', '0', '0', '1351968138', '1351968138');

-- ----------------------------
-- Table structure for `w_products`
-- ----------------------------
DROP TABLE IF EXISTS `w_products`;
CREATE TABLE `w_products` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `price` float NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of w_products
-- ----------------------------
INSERT INTO `w_products` VALUES ('1', '主持人培训教程大全', '298', '主持人培训教程大全 限时秒杀价280元');
INSERT INTO `w_products` VALUES ('2', '美发店赢利秘笈', '398', '美发店赢利秘籍+发型设计软件+美发店活动方案 限时秒杀价 398元');
INSERT INTO `w_products` VALUES ('3', '无基础开花店运营', '298', '无基础开花店运营方案升级版 尖叫价 298元');

-- ----------------------------
-- Table structure for `w_users`
-- ----------------------------
DROP TABLE IF EXISTS `w_users`;
CREATE TABLE `w_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET latin1 NOT NULL,
  `nickname` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `password` char(32) CHARACTER SET latin1 NOT NULL,
  `operate` varchar(50) CHARACTER SET latin1 NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of w_users
-- ----------------------------
INSERT INTO `w_users` VALUES ('1', 'admin', 'Will Xu', '0bada7fde5c8074be440c8aa7ff714f3', 'admin', '1349959028', '1350575927');
INSERT INTO `w_users` VALUES ('3', 'kuerle', 'kuerle', '0bada7fde5c8074be440c8aa7ff714f3', 'admin', '1350577072', '1350198695');
INSERT INTO `w_users` VALUES ('5', 'will2012', 'will2012', '0bada7fde5c8074be440c8aa7ff714f3', 'admin', '1350577072', '1350577072');
