/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 100109
Source Host           : localhost:3306
Source Database       : proveedor

Target Server Type    : MYSQL
Target Server Version : 100109
File Encoding         : 65001

Date: 2016-03-14 11:23:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for prov_categorias
-- ----------------------------
DROP TABLE IF EXISTS `prov_categorias`;
CREATE TABLE `prov_categorias` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `referencia` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of prov_categorias
-- ----------------------------
INSERT INTO `prov_categorias` VALUES ('1', 'Dama', 'D');
INSERT INTO `prov_categorias` VALUES ('2', 'Caballero', 'C');
INSERT INTO `prov_categorias` VALUES ('3', 'Niña', 'NI');
INSERT INTO `prov_categorias` VALUES ('4', 'Niño', 'N');

-- ----------------------------
-- Table structure for prov_clientes
-- ----------------------------
DROP TABLE IF EXISTS `prov_clientes`;
CREATE TABLE `prov_clientes` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `direccion` varchar(11) DEFAULT NULL,
  `tipo_identificacion` int(11) DEFAULT NULL,
  `identificacion` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of prov_clientes
-- ----------------------------
INSERT INTO `prov_clientes` VALUES ('1', 'Bodega Despacho', 'UIS - Modul', '2', '10956873-5');

-- ----------------------------
-- Table structure for prov_color
-- ----------------------------
DROP TABLE IF EXISTS `prov_color`;
CREATE TABLE `prov_color` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `referencia` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of prov_color
-- ----------------------------
INSERT INTO `prov_color` VALUES ('1', 'Marron', 'M');
INSERT INTO `prov_color` VALUES ('2', 'Rojo', 'R');
INSERT INTO `prov_color` VALUES ('3', 'Negro', 'N');
INSERT INTO `prov_color` VALUES ('4', 'Azul', 'A');
INSERT INTO `prov_color` VALUES ('5', 'Blanco', 'B');
INSERT INTO `prov_color` VALUES ('6', 'Gris', 'G');
INSERT INTO `prov_color` VALUES ('7', 'Cafe', 'C');
INSERT INTO `prov_color` VALUES ('8', 'Dorado', 'D');
INSERT INTO `prov_color` VALUES ('9', 'Morado', 'M');
INSERT INTO `prov_color` VALUES ('10', 'Beige', 'B');
INSERT INTO `prov_color` VALUES ('11', 'Rosado', 'R');
INSERT INTO `prov_color` VALUES ('12', 'Fucsia', 'F');
INSERT INTO `prov_color` VALUES ('13', 'Verde', 'V');

-- ----------------------------
-- Table structure for prov_log
-- ----------------------------
DROP TABLE IF EXISTS `prov_log`;
CREATE TABLE `prov_log` (
  `nombre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of prov_log
-- ----------------------------
INSERT INTO `prov_log` VALUES ('PASO3');
INSERT INTO `prov_log` VALUES ('PASO3');
INSERT INTO `prov_log` VALUES ('PASO3');
INSERT INTO `prov_log` VALUES ('PASO3');
INSERT INTO `prov_log` VALUES ('PASO3');
INSERT INTO `prov_log` VALUES ('PASO3');
INSERT INTO `prov_log` VALUES ('PASO3');

-- ----------------------------
-- Table structure for prov_movimientoproducto
-- ----------------------------
DROP TABLE IF EXISTS `prov_movimientoproducto`;
CREATE TABLE `prov_movimientoproducto` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) DEFAULT NULL,
  `tipo` enum('2','1') DEFAULT NULL COMMENT '1- Salida 2- Entrada',
  `cantidad` int(11) DEFAULT NULL,
  `RFID` varchar(255) DEFAULT NULL,
  `fecha` date DEFAULT NULL COMMENT 'fecha_entrada',
  `ordenv_id` int(11) DEFAULT NULL,
  `precio_vendido` decimal(11,2) DEFAULT NULL,
  `fecha2` date DEFAULT NULL COMMENT 'fcha_vendido',
  `estado_id` int(11) DEFAULT NULL COMMENT '2- Recibido,3-Inventariado,4-Apartado Venta,5-Vendido',
  `etiquetado` enum('1','2') DEFAULT '1' COMMENT '1-NO, 2 - SI',
  PRIMARY KEY (`Id`),
  KEY `producto_id` (`producto_id`),
  KEY `ordenv_id` (`ordenv_id`),
  CONSTRAINT `prov_movimientoproducto_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `prov_producto` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `prov_movimientoproducto_ibfk_2` FOREIGN KEY (`ordenv_id`) REFERENCES `prov_ordenventa` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of prov_movimientoproducto
-- ----------------------------
INSERT INTO `prov_movimientoproducto` VALUES ('47', '2', '2', '1', '1', '2016-03-10', '5', '1200.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('48', '2', '2', '1', '2', '2016-03-10', null, null, null, '3', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('49', '2', '2', '1', '3', '2016-03-10', '5', '1200.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('50', '2', '2', '1', '4', '2016-03-10', '5', '1200.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('51', '2', '2', '1', '5', '2016-03-10', '5', '1200.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('52', '2', '2', '1', '6', '2016-03-10', '5', '1200.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('53', '2', '2', '1', '7', '2016-03-10', '5', '1200.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('54', '2', '2', '1', '8', '2016-03-10', '5', '1200.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('55', '2', '2', '1', '9', '2016-03-10', '5', '1200.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('57', '8', '2', '1', '11', '2016-03-10', '5', '1200.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('58', '8', '2', '1', '12', '2016-03-10', '5', '1200.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('59', '8', '2', '1', '13', '2016-03-10', '5', '1200.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('60', '8', '2', '1', '14', '2016-03-10', '5', '1200.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('61', '8', '2', '1', '15', '2016-03-10', '5', '1200.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('62', '8', '2', '1', '16', '2016-03-10', '5', '1200.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('63', '8', '2', '1', '17', '2016-03-10', '5', '1200.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('64', '8', '2', '1', '18', '2016-03-10', '5', '1200.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('65', '8', '2', '1', '19', '2016-03-10', null, null, null, '3', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('66', '13', '2', '1', '20', '2016-03-10', '8', '1440.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('67', '13', '2', '1', '21', '2016-03-10', '8', '1440.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('68', '13', '2', '1', '22', '2016-03-10', '8', '1440.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('69', '13', '2', '1', '23', '2016-03-10', '8', '1440.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('70', '13', '2', '1', '24', '2016-03-10', '8', '1440.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('71', '13', '2', '1', '25', '2016-03-10', '8', '1440.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('72', '13', '2', '1', '26', '2016-03-10', '8', '1440.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('73', '13', '2', '1', '27', '2016-03-10', null, null, null, '3', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('74', '13', '2', '1', '28', '2016-03-10', '8', '1440.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('75', '5', '2', '1', '29', '2016-03-10', '5', '1320.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('76', '5', '2', '1', '30', '2016-03-10', '5', '1320.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('77', '5', '2', '1', '31', '2016-03-10', '5', '1320.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('78', '5', '2', '1', '32', '2016-03-10', '5', '1320.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('79', '5', '2', '1', '33', '2016-03-10', '5', '1320.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('80', '5', '2', '1', '34', '2016-03-10', '5', '1320.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('81', '5', '2', '1', '35', '2016-03-10', '5', '1320.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('82', '5', '2', '1', '36', '2016-03-10', '5', '1320.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('83', '8', '2', '1', '37', '2016-03-10', null, null, null, '3', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('84', '9', '2', '1', '38', '2016-03-10', '5', '1320.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('85', '9', '2', '1', '39', '2016-03-10', '5', '1320.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('86', '9', '2', '1', '40', '2016-03-10', '5', '1320.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('87', '9', '2', '1', '41', '2016-03-10', '5', '1320.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('88', '9', '2', '1', '42', '2016-03-10', '5', '1320.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('89', '9', '2', '1', '43', '2016-03-10', '5', '1320.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('90', '9', '2', '1', '44', '2016-03-10', '5', '1320.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('91', '9', '2', '1', '45', '2016-03-10', null, null, null, '3', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('92', '9', '2', '1', '46', '2016-03-10', '5', '1320.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('93', '10', '2', '1', '47', '2016-03-10', '5', '1440.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('94', '10', '2', '1', '48', '2016-03-10', '5', '1440.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('95', '10', '2', '1', '49', '2016-03-10', '5', '1440.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('96', '10', '2', '1', '50', '2016-03-10', '5', '1440.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('97', '10', '2', '1', '51', '2016-03-10', '5', '1440.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('98', '10', '2', '1', '52', '2016-03-10', '5', '1440.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('99', '10', '2', '1', '53', '2016-03-10', null, null, null, '3', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('100', '10', '2', '1', '54', '2016-03-10', '5', '1440.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('101', '10', '2', '1', '55', '2016-03-10', '5', '1440.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('102', '10', '2', '1', '56', '2016-03-10', '5', '1440.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('103', '11', '2', '1', '57', '2016-03-10', '6', '1320.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('104', '11', '2', '1', '58', '2016-03-10', '6', '1320.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('105', '11', '2', '1', '59', '2016-03-10', '6', '1320.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('106', '11', '2', '1', '60', '2016-03-10', '6', '1320.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('107', '11', '2', '1', '61', '2016-03-10', '6', '1320.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('108', '11', '2', '1', '62', '2016-03-10', '6', '1320.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('109', '11', '2', '1', '63', '2016-03-10', '6', '1320.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('110', '11', '2', '1', '64', '2016-03-10', '6', '1320.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('111', '11', '2', '1', '65', '2016-03-10', '6', '1320.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('112', '12', '2', '1', '66', '2016-03-10', '7', '1380.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('113', '12', '2', '1', '67', '2016-03-10', '7', '1380.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('114', '12', '2', '1', '68', '2016-03-10', '7', '1380.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('115', '12', '2', '1', '69', '2016-03-10', '7', '1380.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('116', '12', '2', '1', '70', '2016-03-10', '7', '1380.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('117', '12', '2', '1', '71', '2016-03-10', '7', '1380.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('118', '12', '2', '1', '72', '2016-03-10', '7', '1380.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('119', '12', '2', '1', '73', '2016-03-10', '7', '1380.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('120', '12', '2', '1', '74', '2016-03-10', '7', '1380.00', '2016-03-10', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('133', '17', '2', '1', '75', '2016-03-11', null, null, null, '3', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('134', '16', '2', '1', '76', '2016-03-11', '9', '1200.00', '2016-03-11', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('135', '14', '2', '1', '77', '2016-03-11', '9', '1200.00', '2016-03-11', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('136', '19', '2', '1', '78', '2016-03-11', '10', '1200.00', '2016-03-11', '5', '2');
INSERT INTO `prov_movimientoproducto` VALUES ('137', '19', '2', '1', '79', '2016-03-11', '10', '1200.00', '2016-03-11', '5', '2');

-- ----------------------------
-- Table structure for prov_nombres
-- ----------------------------
DROP TABLE IF EXISTS `prov_nombres`;
CREATE TABLE `prov_nombres` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `referencia` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of prov_nombres
-- ----------------------------
INSERT INTO `prov_nombres` VALUES ('1', 'Harland', 'H');
INSERT INTO `prov_nombres` VALUES ('2', 'Vans Baxter', 'V');
INSERT INTO `prov_nombres` VALUES ('3', 'Duke', 'D');
INSERT INTO `prov_nombres` VALUES ('4', 'Anna Flynn', 'A');
INSERT INTO `prov_nombres` VALUES ('5', 'Dakota', 'D');
INSERT INTO `prov_nombres` VALUES ('6', 'Bailarina Kenneth', 'A');
INSERT INTO `prov_nombres` VALUES ('7', 'Bikers Primrose', 'B');
INSERT INTO `prov_nombres` VALUES ('8', 'Mighty Flex', 'M');
INSERT INTO `prov_nombres` VALUES ('9', 'Pavlini', 'P');
INSERT INTO `prov_nombres` VALUES ('10', 'Audaz', 'A');
INSERT INTO `prov_nombres` VALUES ('11', 'Adizero', 'A');
INSERT INTO `prov_nombres` VALUES ('12', 'Cartago', 'C');
INSERT INTO `prov_nombres` VALUES ('13', 'Disney', 'D');
INSERT INTO `prov_nombres` VALUES ('14', 'Coqueta', 'C');
INSERT INTO `prov_nombres` VALUES ('15', 'Mafalda', 'M');
INSERT INTO `prov_nombres` VALUES ('16', 'Vizzano', 'V');
INSERT INTO `prov_nombres` VALUES ('17', 'Art Dance', 'A');
INSERT INTO `prov_nombres` VALUES ('18', 'Mafalda Sheccid', 'M');

-- ----------------------------
-- Table structure for prov_ordenventa
-- ----------------------------
DROP TABLE IF EXISTS `prov_ordenventa`;
CREATE TABLE `prov_ordenventa` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `numeroorden` varchar(255) DEFAULT NULL,
  `fechasalida` date DEFAULT NULL,
  `estado_id` enum('2','3','1') DEFAULT NULL COMMENT '1- Solicitada 2- Generada, 3- Despachada',
  `cliente_id` int(11) DEFAULT NULL,
  `total_orden` decimal(11,2) DEFAULT NULL,
  `fechacreada` date DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `cliente_id` (`cliente_id`),
  CONSTRAINT `prov_ordenventa_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `prov_clientes` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of prov_ordenventa
-- ----------------------------
INSERT INTO `prov_ordenventa` VALUES ('5', 'OV001', '2016-03-10', '3', '1', '53280.00', '2016-03-10');
INSERT INTO `prov_ordenventa` VALUES ('6', 'OV002', '2016-03-10', '3', '1', '11880.00', '2016-03-10');
INSERT INTO `prov_ordenventa` VALUES ('7', 'OV003', '2016-03-10', '3', '1', '12420.00', '2016-03-10');
INSERT INTO `prov_ordenventa` VALUES ('8', 'OV004', '2016-03-10', '3', '1', '11520.00', '2016-03-10');
INSERT INTO `prov_ordenventa` VALUES ('9', 'OV005', '2016-03-11', '3', '1', '2400.00', '2016-03-11');
INSERT INTO `prov_ordenventa` VALUES ('10', 'OV006', '2016-03-11', '3', '1', '2400.00', '2016-03-11');

-- ----------------------------
-- Table structure for prov_producto
-- ----------------------------
DROP TABLE IF EXISTS `prov_producto`;
CREATE TABLE `prov_producto` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` int(11) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `unidad_id` int(11) DEFAULT NULL,
  `precio_venta` decimal(11,2) DEFAULT NULL,
  `precio_produccion` decimal(11,2) DEFAULT NULL,
  `codbarras` varchar(255) DEFAULT NULL,
  `tipo_id` int(11) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `talla_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `codbarras` (`codbarras`) USING BTREE,
  KEY `categoria_id` (`categoria_id`),
  KEY `unidad_id` (`unidad_id`),
  KEY `tipo_id` (`tipo_id`),
  KEY `color_id` (`color_id`),
  KEY `talla_id` (`talla_id`),
  KEY `nombre` (`nombre`),
  CONSTRAINT `prov_producto_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `prov_categorias` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `prov_producto_ibfk_2` FOREIGN KEY (`unidad_id`) REFERENCES `prov_unidades` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `prov_producto_ibfk_3` FOREIGN KEY (`tipo_id`) REFERENCES `prov_tipo` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `prov_producto_ibfk_4` FOREIGN KEY (`color_id`) REFERENCES `prov_color` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `prov_producto_ibfk_5` FOREIGN KEY (`talla_id`) REFERENCES `prov_tallas` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `prov_producto_ibfk_6` FOREIGN KEY (`nombre`) REFERENCES `prov_nombres` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of prov_producto
-- ----------------------------
INSERT INTO `prov_producto` VALUES ('2', '1', '2', '1', '1200.00', '1000.00', 'CMHM39', '3', '1', '18');
INSERT INTO `prov_producto` VALUES ('5', '1', '2', '1', '1320.00', '1100.00', 'CMHR39', '3', '2', '18');
INSERT INTO `prov_producto` VALUES ('8', '1', '2', '1', '1200.00', '1000.00', 'CMHN39', '3', '3', '18');
INSERT INTO `prov_producto` VALUES ('9', '1', '2', '1', '1320.00', '1100.00', 'CMHA39', '3', '4', '18');
INSERT INTO `prov_producto` VALUES ('10', '2', '2', '1', '1440.00', '1200.00', 'CTVB39', '1', '5', '18');
INSERT INTO `prov_producto` VALUES ('11', '2', '2', '1', '1320.00', '1100.00', 'CTVG39', '1', '6', '18');
INSERT INTO `prov_producto` VALUES ('12', '2', '2', '1', '1380.00', '1150.00', 'CTVA39', '1', '4', '18');
INSERT INTO `prov_producto` VALUES ('13', '3', '2', '1', '1440.00', '1200.00', 'CZDC39', '2', '7', '18');
INSERT INTO `prov_producto` VALUES ('14', '1', '2', '1', '1200.00', '1000.00', 'CMHM40', '3', '1', '19');
INSERT INTO `prov_producto` VALUES ('15', '1', '2', '1', '1200.00', '1000.00', 'CMHR40', '3', '2', '19');
INSERT INTO `prov_producto` VALUES ('16', '1', '2', '1', '1200.00', '1000.00', 'CMHA40', '3', '4', '19');
INSERT INTO `prov_producto` VALUES ('17', '1', '2', '1', '1200.00', '1000.00', 'CMHB40', '3', '5', '19');
INSERT INTO `prov_producto` VALUES ('18', '2', '2', '1', '1200.00', '1000.00', 'CTVB40', '1', '5', '19');
INSERT INTO `prov_producto` VALUES ('19', '2', '2', '1', '1200.00', '1000.00', 'CTVG40', '1', '6', '19');

-- ----------------------------
-- Table structure for prov_productosorden
-- ----------------------------
DROP TABLE IF EXISTS `prov_productosorden`;
CREATE TABLE `prov_productosorden` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ordenventa_id` int(11) DEFAULT NULL,
  `movimiento_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `estado_id` enum('2','3','1') DEFAULT NULL COMMENT '1- Solicitado 2-Apartado 3. Despachado',
  `precio_venta` decimal(11,2) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `ordenventa_id` (`ordenventa_id`),
  KEY `movimiento_id` (`movimiento_id`),
  CONSTRAINT `prov_productosorden_ibfk_1` FOREIGN KEY (`ordenventa_id`) REFERENCES `prov_ordenventa` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `prov_productosorden_ibfk_2` FOREIGN KEY (`movimiento_id`) REFERENCES `prov_movimientoproducto` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of prov_productosorden
-- ----------------------------
INSERT INTO `prov_productosorden` VALUES ('35', '5', '47', '1', '3', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('37', '5', '49', '1', '3', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('38', '5', '50', '1', '3', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('39', '5', '51', '1', '3', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('40', '5', '52', '1', '3', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('41', '5', '53', '1', '3', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('42', '5', '54', '1', '3', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('43', '5', '76', '1', '3', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('45', '5', '55', '1', '3', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('46', '5', '57', '1', '3', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('47', '5', '77', '1', '3', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('48', '5', '78', '1', '3', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('49', '5', '81', '1', '3', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('50', '5', '82', '1', '3', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('51', '5', '75', '1', '3', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('52', '5', '79', '1', '3', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('53', '5', '80', '1', '3', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('54', '5', '58', '1', '3', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('55', '5', '59', '1', '3', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('56', '5', '60', '1', '3', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('57', '5', '61', '1', '3', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('58', '5', '62', '1', '3', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('59', '5', '63', '1', '3', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('60', '5', '64', '1', '3', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('62', '5', '84', '1', '3', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('63', '5', '85', '1', '3', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('64', '5', '86', '1', '3', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('65', '5', '87', '1', '3', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('66', '5', '88', '1', '3', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('67', '5', '89', '1', '3', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('68', '5', '90', '1', '3', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('69', '5', '92', '1', '3', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('70', '5', '93', '1', '3', '1440.00');
INSERT INTO `prov_productosorden` VALUES ('71', '5', '94', '1', '3', '1440.00');
INSERT INTO `prov_productosorden` VALUES ('72', '5', '95', '1', '3', '1440.00');
INSERT INTO `prov_productosorden` VALUES ('73', '5', '96', '1', '3', '1440.00');
INSERT INTO `prov_productosorden` VALUES ('74', '5', '97', '1', '3', '1440.00');
INSERT INTO `prov_productosorden` VALUES ('75', '5', '98', '1', '3', '1440.00');
INSERT INTO `prov_productosorden` VALUES ('76', '5', '100', '1', '3', '1440.00');
INSERT INTO `prov_productosorden` VALUES ('77', '5', '101', '1', '3', '1440.00');
INSERT INTO `prov_productosorden` VALUES ('78', '5', '102', '1', '3', '1440.00');
INSERT INTO `prov_productosorden` VALUES ('79', '6', '103', '1', '3', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('80', '6', '104', '1', '3', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('81', '6', '105', '1', '3', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('82', '6', '106', '1', '3', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('83', '6', '107', '1', '3', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('84', '6', '108', '1', '3', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('85', '6', '109', '1', '3', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('86', '6', '110', '1', '3', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('87', '6', '111', '1', '3', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('88', '7', '112', '1', '3', '1380.00');
INSERT INTO `prov_productosorden` VALUES ('89', '7', '113', '1', '3', '1380.00');
INSERT INTO `prov_productosorden` VALUES ('90', '7', '114', '1', '3', '1380.00');
INSERT INTO `prov_productosorden` VALUES ('91', '7', '115', '1', '3', '1380.00');
INSERT INTO `prov_productosorden` VALUES ('92', '7', '116', '1', '3', '1380.00');
INSERT INTO `prov_productosorden` VALUES ('93', '7', '117', '1', '3', '1380.00');
INSERT INTO `prov_productosorden` VALUES ('94', '7', '118', '1', '3', '1380.00');
INSERT INTO `prov_productosorden` VALUES ('95', '7', '119', '1', '3', '1380.00');
INSERT INTO `prov_productosorden` VALUES ('96', '7', '120', '1', '3', '1380.00');
INSERT INTO `prov_productosorden` VALUES ('97', '8', '66', '1', '3', '1440.00');
INSERT INTO `prov_productosorden` VALUES ('98', '8', '67', '1', '3', '1440.00');
INSERT INTO `prov_productosorden` VALUES ('99', '8', '68', '1', '3', '1440.00');
INSERT INTO `prov_productosorden` VALUES ('100', '8', '69', '1', '3', '1440.00');
INSERT INTO `prov_productosorden` VALUES ('101', '8', '70', '1', '3', '1440.00');
INSERT INTO `prov_productosorden` VALUES ('102', '8', '71', '1', '3', '1440.00');
INSERT INTO `prov_productosorden` VALUES ('103', '8', '72', '1', '3', '1440.00');
INSERT INTO `prov_productosorden` VALUES ('104', '8', '74', '1', '3', '1440.00');
INSERT INTO `prov_productosorden` VALUES ('105', '9', '134', '1', '3', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('106', '9', '135', '1', '3', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('107', '10', '136', '1', '3', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('108', '10', '137', '1', '3', '1200.00');

-- ----------------------------
-- Table structure for prov_productosorden2
-- ----------------------------
DROP TABLE IF EXISTS `prov_productosorden2`;
CREATE TABLE `prov_productosorden2` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ordenventa_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `estado_id` enum('2','1') DEFAULT NULL COMMENT '1- Solicitado 2-Despachado',
  `linea_bodega` int(11) DEFAULT NULL,
  `codbarras` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `ordenventa_id` (`ordenventa_id`),
  KEY `producto_id` (`producto_id`),
  CONSTRAINT `prov_productosorden2_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `prov_producto` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `prov_productosorden2_ibfk_2` FOREIGN KEY (`ordenventa_id`) REFERENCES `prov_ordenventa` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of prov_productosorden2
-- ----------------------------
INSERT INTO `prov_productosorden2` VALUES ('29', '5', '2', '8', '2', '24', 'CMHM39');
INSERT INTO `prov_productosorden2` VALUES ('30', '5', '5', '8', '2', '25', 'CMHR39');
INSERT INTO `prov_productosorden2` VALUES ('31', '5', '8', '8', '2', '26', 'CMHN39');
INSERT INTO `prov_productosorden2` VALUES ('32', '5', '9', '8', '2', '27', 'CMHA39');
INSERT INTO `prov_productosorden2` VALUES ('33', '5', '10', '9', '2', '28', 'CTVB39');
INSERT INTO `prov_productosorden2` VALUES ('34', '6', '11', '9', '2', '29', 'CTVG39');
INSERT INTO `prov_productosorden2` VALUES ('35', '7', '12', '9', '2', '30', 'CTVA39');
INSERT INTO `prov_productosorden2` VALUES ('36', '8', '13', '8', '2', '31', 'CZDC39');
INSERT INTO `prov_productosorden2` VALUES ('37', '9', '16', '1', '2', '32', 'CMHA40');
INSERT INTO `prov_productosorden2` VALUES ('38', '9', '14', '1', '2', '33', 'CMHM40');
INSERT INTO `prov_productosorden2` VALUES ('39', '10', '19', '2', '2', '34', 'CTVG40');

-- ----------------------------
-- Table structure for prov_tallas
-- ----------------------------
DROP TABLE IF EXISTS `prov_tallas`;
CREATE TABLE `prov_tallas` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `talla` int(2) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of prov_tallas
-- ----------------------------
INSERT INTO `prov_tallas` VALUES ('1', '22');
INSERT INTO `prov_tallas` VALUES ('2', '23');
INSERT INTO `prov_tallas` VALUES ('3', '24');
INSERT INTO `prov_tallas` VALUES ('4', '25');
INSERT INTO `prov_tallas` VALUES ('5', '26');
INSERT INTO `prov_tallas` VALUES ('6', '27');
INSERT INTO `prov_tallas` VALUES ('7', '28');
INSERT INTO `prov_tallas` VALUES ('8', '29');
INSERT INTO `prov_tallas` VALUES ('9', '30');
INSERT INTO `prov_tallas` VALUES ('10', '31');
INSERT INTO `prov_tallas` VALUES ('11', '32');
INSERT INTO `prov_tallas` VALUES ('12', '33');
INSERT INTO `prov_tallas` VALUES ('13', '34');
INSERT INTO `prov_tallas` VALUES ('14', '35');
INSERT INTO `prov_tallas` VALUES ('15', '36');
INSERT INTO `prov_tallas` VALUES ('16', '37');
INSERT INTO `prov_tallas` VALUES ('17', '38');
INSERT INTO `prov_tallas` VALUES ('18', '39');
INSERT INTO `prov_tallas` VALUES ('19', '40');

-- ----------------------------
-- Table structure for prov_tipo
-- ----------------------------
DROP TABLE IF EXISTS `prov_tipo`;
CREATE TABLE `prov_tipo` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `referencia` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of prov_tipo
-- ----------------------------
INSERT INTO `prov_tipo` VALUES ('1', 'Tennis', 'T');
INSERT INTO `prov_tipo` VALUES ('2', 'Zapato Material', 'Z');
INSERT INTO `prov_tipo` VALUES ('3', 'Mocasines', 'M');
INSERT INTO `prov_tipo` VALUES ('4', 'Baleta', 'B');
INSERT INTO `prov_tipo` VALUES ('5', 'Zapatilla Puntal', 'Z');
INSERT INTO `prov_tipo` VALUES ('6', 'Sandalia Plataforma', 'S');
INSERT INTO `prov_tipo` VALUES ('7', 'Sandalia', 'S');
INSERT INTO `prov_tipo` VALUES ('8', 'Zapato Cerrado', 'Z');
INSERT INTO `prov_tipo` VALUES ('9', 'Zapatos Wings', 'Z');

-- ----------------------------
-- Table structure for prov_unidades
-- ----------------------------
DROP TABLE IF EXISTS `prov_unidades`;
CREATE TABLE `prov_unidades` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of prov_unidades
-- ----------------------------
INSERT INTO `prov_unidades` VALUES ('1', 'Pares');

-- ----------------------------
-- Table structure for prov_users
-- ----------------------------
DROP TABLE IF EXISTS `prov_users`;
CREATE TABLE `prov_users` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `userp` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `fechacreado` date DEFAULT NULL,
  `estado_id` int(11) DEFAULT NULL COMMENT '1 - Activo , 2- Inactivo',
  `correo` varchar(255) DEFAULT NULL,
  `celular` int(12) DEFAULT NULL,
  `fechaentrada` date DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of prov_users
-- ----------------------------
INSERT INTO `prov_users` VALUES ('1', 'Diana', 'admin', '123456', null, '1', 'anaid0410@gmail.com', null, null);
INSERT INTO `prov_users` VALUES ('2', 'Pepito', 'pperez', '123456', null, '1', 'pperez@gmail.com', null, null);
INSERT INTO `prov_users` VALUES ('3', 'Jhonattan Moreno', 'jmoreno', '123456', null, '2', 'jmoreno@gmail.com', null, null);
INSERT INTO `prov_users` VALUES ('4', 'Javier', 'jarias', 'jarias2016', null, '1', 'jarias@gmail.com', null, null);

-- ----------------------------
-- View structure for view_clientes
-- ----------------------------
DROP VIEW IF EXISTS `view_clientes`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost`  VIEW `view_clientes` AS SELECT
	`prov_clientes`.`Id` AS `Id`,
	`prov_clientes`.`nombre` AS `nombre`,
	`prov_clientes`.`direccion` AS `direccion`,
	`prov_clientes`.`tipo_identificacion` AS `tipo_identificacion`,
	`prov_clientes`.`identificacion` AS `identificacion`,
	avg(
		`prov_ordenventa`.`total_orden`
	) AS `promedio`,
	max(
		`prov_ordenventa`.`fechacreada`
	) AS `maxorden`
FROM
	(
		`prov_clientes`
		LEFT JOIN `prov_ordenventa` ON (
			(
				`prov_ordenventa`.`cliente_id` = `prov_clientes`.`Id`
			)
		)
	)
GROUP BY
	`prov_clientes`.`Id` ;

-- ----------------------------
-- View structure for view_ordenproc
-- ----------------------------
DROP VIEW IF EXISTS `view_ordenproc`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `view_ordenproc` AS SELECT
	prov_movimientoproducto.producto_id,
	sum(
		prov_productosorden.cantidad
	) AS cantidad2,
	prov_ordenventa.numeroorden,
  prov_ordenventa.Id
FROM
	prov_ordenventa
LEFT JOIN prov_productosorden ON prov_productosorden.ordenventa_id = prov_ordenventa.Id
LEFT JOIN prov_movimientoproducto ON prov_productosorden.movimiento_id = prov_movimientoproducto.Id
WHERE prov_productosorden.estado_id = '1'
GROUP BY
	prov_movimientoproducto.producto_id,prov_movimientoproducto.ordenv_id ;

-- ----------------------------
-- View structure for view_ordensalida
-- ----------------------------
DROP VIEW IF EXISTS `view_ordensalida`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `view_ordensalida` AS SELECT
	prov_movimientoproducto.producto_id,prov_producto.nombre,prov_productosorden.precio_venta,prov_producto.codbarras,
	sum(
		prov_productosorden.cantidad
	) AS cantidad2,
	prov_ordenventa.numeroorden,
  prov_ordenventa.Id
FROM
	prov_ordenventa
LEFT JOIN prov_productosorden ON prov_productosorden.ordenventa_id = prov_ordenventa.Id
LEFT JOIN prov_movimientoproducto ON prov_productosorden.movimiento_id = prov_movimientoproducto.Id
LEFT JOIN prov_producto ON prov_producto.Id=prov_movimientoproducto.producto_id
WHERE prov_productosorden.estado_id = '3'
GROUP BY
	prov_movimientoproducto.producto_id,prov_movimientoproducto.ordenv_id ;

-- ----------------------------
-- View structure for view_productos
-- ----------------------------
DROP VIEW IF EXISTS `view_productos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `view_productos` AS SELECT
	`prov_producto`.`Id` AS `Id`,
	`prov_producto`.`precio_venta` AS `precio`,
	prov_producto.precio_produccion AS produccion,
	`prov_producto`.`codbarras` AS `codbarras`,
	`prov_producto`.`nombre` AS `nombre`,
	`prov_categorias`.`nombre` AS `categoria`,
	`prov_categorias`.`Id` AS `idcategoria`,
	`prov_producto`.`unidad_id` AS `unidad_id`,
	`prov_unidades`.`nombre` AS `unidades`,
   prov_producto.tipo_id,prov_producto.color_id,prov_producto.talla_id
FROM
	(
		(
			`prov_producto`
			LEFT JOIN `prov_categorias` ON (
				(
					`prov_categorias`.`Id` = `prov_producto`.`categoria_id`
				)
			)
		)
		LEFT JOIN `prov_unidades` ON (
			(
				`prov_unidades`.`Id` = `prov_producto`.`unidad_id`
			)
		)
	LEFT JOIN `prov_tipo` ON (
			(
				`prov_tipo`.`Id` = `prov_producto`.`tipo_id`
			)
		)
  LEFT JOIN `prov_tallas` ON (
			(
				`prov_tallas`.`Id` = `prov_producto`.`talla_id`
			)
		)
   LEFT JOIN `prov_color` ON (
			(
				`prov_color`.`Id` = `prov_producto`.`color_id`
			)
		)
LEFT JOIN `prov_nombres` ON (
			(
				`prov_nombres`.`Id` = `prov_producto`.`nombre`
			)
		)
	) ;

-- ----------------------------
-- View structure for view_usuarios
-- ----------------------------
DROP VIEW IF EXISTS `view_usuarios`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost`  VIEW `view_usuarios` AS SELECT
	`prov_users`.`Id` AS `Id`,
	`prov_users`.`nombre` AS `nombre`,
	`prov_users`.`userp` AS `userp`,
	`prov_users`.`password` AS `password`,
	`prov_users`.`estado_id` AS `estado_id`,
	`prov_users`.`correo` AS `correo`
FROM
	`prov_users` ;

-- ----------------------------
-- View structure for view_ventapendiente
-- ----------------------------
DROP VIEW IF EXISTS `view_ventapendiente`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `view_ventapendiente` AS SELECT
	GROUP_CONCAT(prov_productosorden2.Id) AS idorden2,
	prov_producto.Id,
	prov_nombres.nombre,
	prov_producto.codbarras,
	sum(cantidad) AS cantidad,
	precio_venta,
	(precio_venta * sum(cantidad)) AS totallinea
FROM
	prov_productosorden2
LEFT JOIN prov_producto ON prov_producto.Id = prov_productosorden2.producto_id
LEFT JOIN prov_nombres ON prov_nombres.Id = prov_producto.nombre
WHERE
	prov_productosorden2.estado_id = '1'
GROUP BY
	producto_id ;

-- ----------------------------
-- View structure for view_ventas
-- ----------------------------
DROP VIEW IF EXISTS `view_ventas`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `view_ventas` AS SELECT
	`prov_ordenventa`.`Id` AS `Id`,
	`prov_ordenventa`.`numeroorden` AS `orden_number`,
	prov_clientes.Id AS idcliente,
	`prov_clientes`.`nombre` AS `nombre`,
	`prov_clientes`.`direccion` AS `direccion`,
	`prov_ordenventa`.`total_orden` AS `total_orden`,
	`prov_ordenventa`.`fechacreada` AS `fechacreada`,
	`prov_ordenventa`.`fechasalida` AS `fechasalida`,
	`prov_ordenventa`.`estado_id` AS `estado_id`
FROM
	(
		`prov_ordenventa`
		LEFT JOIN `prov_clientes` ON (
			(
				`prov_clientes`.`Id` = `prov_ordenventa`.`cliente_id`
			)
		)
	) ;
DROP TRIGGER IF EXISTS `trg_categorias`;
DELIMITER ;;
CREATE TRIGGER `trg_categorias` BEFORE INSERT ON `prov_categorias` FOR EACH ROW BEGIN

INSERT INTO bodega.com_lineaproducto SET Id=NEW.Id,nombre=NEW.nombre,referencia=NEW.referencia;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_categorias2`;
DELIMITER ;;
CREATE TRIGGER `trg_categorias2` BEFORE UPDATE ON `prov_categorias` FOR EACH ROW BEGIN

UPDATE bodega.com_lineaproducto SET Id=NEW.Id,nombre=NEW.nombre,referencia=NEW.referencia WHERE Id=NEW.Id;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_color`;
DELIMITER ;;
CREATE TRIGGER `trg_color` BEFORE INSERT ON `prov_color` FOR EACH ROW BEGIN

INSERT INTO bodega.com_color SET Id=NEW.Id, nombre=NEW.nombre, referencia=NEW.referencia;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_color2`;
DELIMITER ;;
CREATE TRIGGER `trg_color2` BEFORE UPDATE ON `prov_color` FOR EACH ROW BEGIN

UPDATE bodega.com_color SET  nombre=NEW.nombre, referencia=NEW.referencia WHERE Id=NEW.Id;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trigger1mov1`;
DELIMITER ;;
CREATE TRIGGER `trigger1mov1` BEFORE INSERT ON `prov_movimientoproducto` FOR EACH ROW BEGIN

SET @RFID2=(SELECT RFID FROM prov_movimientoproducto ORDER BY Id DESC LIMIT 1);
SET @RFNEW=@RFID2+1;
SET NEW.fecha=NOW();
SET NEW.tipo='2';
IF(@RFNEW>=1) THEN
    SET NEW.RFID=@RFNEW;
ELSE
  SET NEW.RFID='1';
END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trigger2mov2`;
DELIMITER ;;
CREATE TRIGGER `trigger2mov2` BEFORE UPDATE ON `prov_movimientoproducto` FOR EACH ROW BEGIN

SET @RFID=NEW.RFID;
SET @RFID2=OLD.RFID;
SET @estado=NEW.estado_id;
SET @estado2=OLD.estado_id;
SET @orden=NEW.ordenv_id;
 SET @producto=NEW.producto_id;

IF(LENGTH(@RFID)>0 AND @RFID2 is NULL) THEN

 SET NEW.estado_id=3;

END IF;

IF (@estado='4' and OLD.estado_id='3') THEN


SET @Idmov=NEW.Id;
SET @precio=(SELECT precio_venta FROM prov_producto WHERE Id=@producto);
SET NEW.precio_vendido=@precio;

   INSERT INTO prov_productosorden SET ordenventa_id=@orden, movimiento_id=@Idmov,cantidad='1',estado_id='1',precio_venta=@precio;

END IF;



IF (@estado='5' and OLD.estado_id='4') THEN


  SET NEW.tipo=1;

END IF;


END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_nombres`;
DELIMITER ;;
CREATE TRIGGER `trg_nombres` BEFORE INSERT ON `prov_nombres` FOR EACH ROW BEGIN

INSERT INTO bodega.com_nombres SET Id=NEW.Id,nombre=NEW.nombre,referencia=NEW.referencia;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_nombres2`;
DELIMITER ;;
CREATE TRIGGER `trg_nombres2` BEFORE UPDATE ON `prov_nombres` FOR EACH ROW BEGIN

UPDATE bodega.com_nombres SET nombre=NEW.nombre,referencia=NEW.referencia WHERE Id=NEW.Id;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_pedidos1`;
DELIMITER ;;
CREATE TRIGGER `trg_pedidos1` BEFORE INSERT ON `prov_ordenventa` FOR EACH ROW BEGIN

SET @sgteOC=(SELECT SUBSTR(numeroorden,5) FROM prov_ordenventa ORDER BY Id DESC LIMIT 1);
SET @OCNEW=@sgteOC+1;
SET NEW.fechacreada=NOW();
IF(@OCNEW>=1) THEN
    SET NEW.numeroorden=concat("OV00",@OCNEW);
ELSE
  SET NEW.numeroorden='OV001';
END IF;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_pedidosv2`;
DELIMITER ;;
CREATE TRIGGER `trg_pedidosv2` BEFORE UPDATE ON `prov_ordenventa` FOR EACH ROW BEGIN

DECLARE done INT DEFAULT FALSE;
DECLARE ids INT;
DECLARE ids2 INT;
DECLARE ids3 INT;
DECLARE ids4 INT;
DECLARE ids5 INT;
DECLARE ids6 INT;
DECLARE ids7 INT;
DECLARE ids8 VARCHAR(255);

DECLARE cur CURSOR FOR SELECT view_ventapendiente.Id,(cantidad-cantidad2) as faltantes,cantidad FROM view_ventapendiente LEFT JOIN ( SELECT cantidad2, producto_id,Id FROM view_ordenproc) AS data2 ON data2.producto_id=view_ventapendiente.Id WHERE data2.Id=NEW.Id;
DECLARE cur2 CURSOR FOR SELECT Id,producto_id,cantidad,linea_bodega,codbarras FROM prov_productosorden2 WHERE ordenventa_id IS NULL AND estado_id='1' ORDER BY producto_id;
DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;


IF(NEW.estado_id="1" && OLD.estado_id="2") THEN
     SET NEW.estado_id="2";
ELSEIF(NEW.estado_id="2" && OLD.estado_id="3") THEN
    SET NEW.estado_id="3";
ELSEIF(NEW.estado_id="3" && OLD.estado_id="1") THEN
    SET NEW.estado_id=1;
ELSEIF(NEW.estado_id="1" && OLD.estado_id="3") THEN
    SET NEW.estado_id="3";
END IF;



IF (NEW.estado_id="2" && OLD.estado_id="1") THEN

   
   INSERT INTO prov_log SET nombre='PASO3'; 
   OPEN cur;
    ins_loop: LOOP
            FETCH cur INTO ids,ids2,ids3;
            IF done THEN
                LEAVE ins_loop;
            END IF;
            

            IF ids2=0 THEN
              UPDATE prov_productosorden2 SET estado_id='2', ordenventa_id=NEW.Id WHERE producto_id=ids;
            ELSEIF (ids2>0) THEN
               SET @cantapartada=(ids3-ids2);
               SET @productopp=ids;

               OPEN cur2;
                  ins_loop2: LOOP
                
                   FETCH cur2 INTO ids4,ids5,ids6,ids7,ids8;
                   IF done THEN
                     LEAVE ins_loop2;
                   END IF;
                   

                   IF(@cantapartada=0) THEN
                         LEAVE ins_loop2;
                  END IF;

     
                   IF(@cantapartada=ids6 and @productopp=ids5) THEN
                        UPDATE prov_productosorden2 SET estado_id='2', ordenventa_id=NEW.Id WHERE Id=ids4;
                   ELSEIF (@cantapartada>ids6 and @productopp=ids5) THEN
                       SET @cantapartada=@cantapartada-ids6;
                       UPDATE prov_productosorden2 SET estado_id='2', ordenventa_id=NEW.Id WHERE Id=ids4;
                  ELSEIF(@cantapartada<ids6 and @productopp=ids5) THEN
                       SET @new_linea=ids6-@cantapartada;
                       UPDATE prov_productosorden2 SET estado_id='2', ordenventa_id=NEW.Id,cantidad=@cantapartada WHERE Id=ids4;
                       INSERT INTO prov_productosorden2 SET estado_id='1',ordenventa_id=NULL,cantidad=@new_linea,codbarras=ids8,linea_bodega=ids7;
                       SET @cantapartada=0;
                  END IF;

                END LOOP;
             CLOSE cur2;

               
         END IF;                 
        END LOOP;
    CLOSE cur;

   SET @totalorden=(SELECT sum(precio_venta) FROM prov_productosorden WHERE ordenventa_id=NEW.Id);
   UPDATE prov_productosorden SET estado_id="2" WHERE ordenventa_id=NEW.Id;
   SET NEW.total_orden=@totalorden;
END IF;



IF(NEW.estado_id="3" && OLD.estado_id="2") THEN
   SET @orden=NEW.Id;
   SET NEW.fechasalida=NOW();
   UPDATE prov_movimientoproducto SET estado_id='5',fecha2=NOW() WHERE ordenv_id=@orden;
   UPDATE prov_productosorden SET estado_id='3' WHERE ordenventa_id=@orden;
END IF;


END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_productos`;
DELIMITER ;;
CREATE TRIGGER `trg_productos` BEFORE INSERT ON `prov_producto` FOR EACH ROW BEGIN

SET @precio=(NEW.precio_produccion*1.2);
SET NEW.precio_venta=@precio;

SET @r1=(SELECT referencia FROM prov_categorias WHERE Id=NEW.categoria_id);
SET @r2=(SELECT referencia FROM prov_tipo WHERE Id=NEW.tipo_id);
SET @r5=(SELECT referencia FROM prov_nombres WHERE Id=NEW.nombre);
SET @r3=(SELECT referencia FROM  prov_color WHERE Id=NEW.color_id);
SET @r4=(SELECT talla FROM  prov_tallas WHERE Id=NEW.talla_id);

SET @codbarras=CONCAT(@r1,@r2,@r5,@r3,@r4);
SET NEW.codbarras=@codbarras;

INSERT INTO bodega.com_productos SET  lineaproducto_id=NEW.categoria_id, nombre=NEW.nombre, codbarras=@codbarras,unidadproducto_id=NEW.unidad_id,tipoproducto_id=NEW.tipo_id,estado_id='1',precio_compra=@precio,color_id=NEW.color_id,talla_id=NEW.talla_id;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_productos2`;
DELIMITER ;;
CREATE TRIGGER `trg_productos2` BEFORE UPDATE ON `prov_producto` FOR EACH ROW BEGIN

SET @precio=(NEW.precio_produccion*1.2);
SET NEW.precio_venta=@precio;
SET @r1=(SELECT referencia FROM prov_categorias WHERE Id=NEW.categoria_id);
SET @r2=(SELECT referencia FROM prov_tipo WHERE Id=NEW.tipo_id);
SET @r5=(SELECT referencia FROM prov_nombres WHERE Id=NEW.nombre);
SET @r3=(SELECT referencia FROM  prov_color WHERE Id=NEW.color_id);
SET @r4=(SELECT talla FROM  prov_tallas WHERE Id=NEW.talla_id);

SET @codbarras=CONCAT(@r1,@r2,@r5,@r3,@r4);
SET NEW.codbarras=@codbarras;

UPDATE  bodega.com_productos SET  lineaproducto_id=NEW.categoria_id, nombre=NEW.nombre, codbarras=@codbarras,unidadproducto_id=NEW.unidad_id,tipoproducto_id=NEW.tipo_id,estado_id='1',precio_compra=@precio,color_id=NEW.color_id,talla_id=NEW.talla_id WHERE codbarras=OLD.codbarras;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_productos3`;
DELIMITER ;;
CREATE TRIGGER `trg_productos3` AFTER DELETE ON `prov_producto` FOR EACH ROW BEGIN

UPDATE bodega.com_productos SET estado_id='2' WHERE codbarras=OLD.codbarras;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_delete`;
DELIMITER ;;
CREATE TRIGGER `trg_delete` AFTER DELETE ON `prov_productosorden` FOR EACH ROW BEGIN

SET @mov=OLD.movimiento_id;
UPDATE prov_movimientoproducto SET ordenv_id=NULL, precio_vendido=NULL, estado_id=3 WHERE Id=@mov;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_barras`;
DELIMITER ;;
CREATE TRIGGER `trg_barras` BEFORE INSERT ON `prov_productosorden2` FOR EACH ROW BEGIN

SET @producto_id=(SELECT Id FROM prov_producto WHERE codbarras=NEW.codbarras);
SET NEW.producto_id=@producto_id;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_barras2`;
DELIMITER ;;
CREATE TRIGGER `trg_barras2` BEFORE UPDATE ON `prov_productosorden2` FOR EACH ROW BEGIN

SET @producto_id=(SELECT Id FROM prov_producto WHERE codbarras=NEW.codbarras);
SET NEW.producto_id=@producto_id;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_tallas`;
DELIMITER ;;
CREATE TRIGGER `trg_tallas` BEFORE INSERT ON `prov_tallas` FOR EACH ROW BEGIN

INSERT INTO com_tallas SET Id=NEW.Id,talla=NEW.talla;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_tallas2`;
DELIMITER ;;
CREATE TRIGGER `trg_tallas2` AFTER UPDATE ON `prov_tallas` FOR EACH ROW BEGIN

UPDATE com_tallas SET talla=NEW.talla where Id=NEW.Id;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_tipo`;
DELIMITER ;;
CREATE TRIGGER `trg_tipo` BEFORE INSERT ON `prov_tipo` FOR EACH ROW BEGIN

INSERT INTO bodega.com_tipoproducto SET Id=NEW.Id,nombre=NEW.nombre, iteracion_id='2',cantubicaciones_id='1',tipo_ubicacion_id='1',referencia=NEW.referencia;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_tipo2`;
DELIMITER ;;
CREATE TRIGGER `trg_tipo2` BEFORE UPDATE ON `prov_tipo` FOR EACH ROW BEGIN

UPDATE bodega.com_tipoproducto SET nombre=NEW.nombre, iteracion_id='2',cantubicaciones_id='1',tipo_ubicacion_id='1',referencia=NEW.referencia WHERE Id=NEW.Id;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_ultentrda`;
DELIMITER ;;
CREATE TRIGGER `tr_ultentrda` BEFORE UPDATE ON `prov_users` FOR EACH ROW BEGIN

SET @fecha=sysdate();

END
;;
DELIMITER ;
