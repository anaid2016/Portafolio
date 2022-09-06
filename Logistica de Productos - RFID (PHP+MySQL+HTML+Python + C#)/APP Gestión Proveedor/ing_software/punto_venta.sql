/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50616
Source Host           : localhost:3306
Source Database       : punto_venta

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2015-05-13 10:37:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `pv_categorias`
-- ----------------------------
DROP TABLE IF EXISTS `pv_categorias`;
CREATE TABLE `pv_categorias` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pv_categorias
-- ----------------------------

-- ----------------------------
-- Table structure for `pv_clientes`
-- ----------------------------
DROP TABLE IF EXISTS `pv_clientes`;
CREATE TABLE `pv_clientes` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `direccion` varchar(11) DEFAULT NULL,
  `tipo_identificacion` int(11) DEFAULT NULL,
  `identificacion` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pv_clientes
-- ----------------------------

-- ----------------------------
-- Table structure for `pv_inventario`
-- ----------------------------
DROP TABLE IF EXISTS `pv_inventario`;
CREATE TABLE `pv_inventario` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` decimal(11,2) DEFAULT NULL,
  `fechaultmov` date DEFAULT NULL,
  `fechaprmov` date DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `producto_id` (`producto_id`),
  CONSTRAINT `pv_inventario_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `pv_producto` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pv_inventario
-- ----------------------------

-- ----------------------------
-- Table structure for `pv_movimientoproducto`
-- ----------------------------
DROP TABLE IF EXISTS `pv_movimientoproducto`;
CREATE TABLE `pv_movimientoproducto` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) DEFAULT NULL,
  `RFID` varchar(20) DEFAULT NULL,
  `cantidad` decimal(11,2) DEFAULT NULL,
  `preciolinea` decimal(11,2) DEFAULT NULL,
  `tipo_ord` enum('2','1') DEFAULT NULL COMMENT '1- Orden Compra, 2 - Orden Venta',
  `ordenv_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `ordenc_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `producto_id` (`producto_id`),
  KEY `ordenv_id` (`ordenv_id`),
  KEY `ordenc_id` (`ordenc_id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `pv_movimientoproducto_ibfk_4` FOREIGN KEY (`usuario_id`) REFERENCES `pv_users` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `pv_movimientoproducto_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `pv_producto` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `pv_movimientoproducto_ibfk_2` FOREIGN KEY (`ordenv_id`) REFERENCES `pv_ordenventa` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `pv_movimientoproducto_ibfk_3` FOREIGN KEY (`ordenc_id`) REFERENCES `pv_ordencompra` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pv_movimientoproducto
-- ----------------------------

-- ----------------------------
-- Table structure for `pv_ordencompra`
-- ----------------------------
DROP TABLE IF EXISTS `pv_ordencompra`;
CREATE TABLE `pv_ordencompra` (
  `Id` int(11) NOT NULL DEFAULT '0',
  `proveedor_id` int(11) DEFAULT NULL,
  `numberorden` varchar(255) DEFAULT NULL,
  `totalorden` decimal(11,2) DEFAULT NULL,
  `estado_id` int(11) DEFAULT NULL,
  `fechacreada` date DEFAULT NULL,
  `fechallegada` date DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pv_ordencompra
-- ----------------------------

-- ----------------------------
-- Table structure for `pv_ordenventa`
-- ----------------------------
DROP TABLE IF EXISTS `pv_ordenventa`;
CREATE TABLE `pv_ordenventa` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `orden_number` varchar(255) DEFAULT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `total_orden` decimal(11,2) DEFAULT NULL,
  `fechacreada` date DEFAULT NULL,
  `fecharecibida` date DEFAULT NULL,
  `estado_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `cliente_id` (`cliente_id`),
  CONSTRAINT `pv_ordenventa_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `pv_clientes` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pv_ordenventa
-- ----------------------------

-- ----------------------------
-- Table structure for `pv_producto`
-- ----------------------------
DROP TABLE IF EXISTS `pv_producto`;
CREATE TABLE `pv_producto` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `precio` decimal(11,2) DEFAULT NULL,
  `unidad_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `categoria_id` (`categoria_id`),
  KEY `unidad_id` (`unidad_id`),
  CONSTRAINT `pv_producto_ibfk_2` FOREIGN KEY (`unidad_id`) REFERENCES `pv_unidades` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `pv_producto_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `pv_categorias` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pv_producto
-- ----------------------------

-- ----------------------------
-- Table structure for `pv_unidades`
-- ----------------------------
DROP TABLE IF EXISTS `pv_unidades`;
CREATE TABLE `pv_unidades` (
  `Id` int(11) NOT NULL DEFAULT '0',
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pv_unidades
-- ----------------------------

-- ----------------------------
-- Table structure for `pv_users`
-- ----------------------------
DROP TABLE IF EXISTS `pv_users`;
CREATE TABLE `pv_users` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `fechacreado` date DEFAULT NULL,
  `estado_id` int(11) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `celular` int(12) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pv_users
-- ----------------------------
