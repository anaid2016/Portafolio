/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50616
Source Host           : 127.0.0.1:3306
Source Database       : punto_venta

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2016-03-17 16:55:49
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for com_log
-- ----------------------------
DROP TABLE IF EXISTS `com_log`;
CREATE TABLE `com_log` (
  `nombre` varchar(255) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of com_log
-- ----------------------------
INSERT INTO `com_log` VALUES ('10.00', '2016-03-17');

-- ----------------------------
-- Table structure for pv_categorias
-- ----------------------------
DROP TABLE IF EXISTS `pv_categorias`;
CREATE TABLE `pv_categorias` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `referencia` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pv_categorias
-- ----------------------------
INSERT INTO `pv_categorias` VALUES ('1', 'Dama', 'D');
INSERT INTO `pv_categorias` VALUES ('2', 'Caballero', 'C');
INSERT INTO `pv_categorias` VALUES ('3', 'Niña', 'NI');
INSERT INTO `pv_categorias` VALUES ('4', 'Niño', 'N');
INSERT INTO `pv_categorias` VALUES ('5', 'Caña', 'Ca');

-- ----------------------------
-- Table structure for pv_clientes
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
-- Table structure for pv_color
-- ----------------------------
DROP TABLE IF EXISTS `pv_color`;
CREATE TABLE `pv_color` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `referencia` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pv_color
-- ----------------------------
INSERT INTO `pv_color` VALUES ('1', 'Marron', 'M');
INSERT INTO `pv_color` VALUES ('2', 'Rojo', 'R');
INSERT INTO `pv_color` VALUES ('3', 'Negro', 'N');
INSERT INTO `pv_color` VALUES ('4', 'Azul', 'A');
INSERT INTO `pv_color` VALUES ('5', 'Blanco', 'B');
INSERT INTO `pv_color` VALUES ('6', 'Gris', 'G');
INSERT INTO `pv_color` VALUES ('7', 'Cafe', 'C');
INSERT INTO `pv_color` VALUES ('8', 'Dorado', 'D');
INSERT INTO `pv_color` VALUES ('9', 'Morado', 'M');
INSERT INTO `pv_color` VALUES ('10', 'Beige', 'B');
INSERT INTO `pv_color` VALUES ('11', 'Rosado', 'R');
INSERT INTO `pv_color` VALUES ('12', 'Fucsia', 'F');
INSERT INTO `pv_color` VALUES ('13', 'Verde', 'V');
INSERT INTO `pv_color` VALUES ('14', 'Vino Tinto', 'VT');

-- ----------------------------
-- Table structure for pv_inventario
-- ----------------------------
DROP TABLE IF EXISTS `pv_inventario`;
CREATE TABLE `pv_inventario` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` decimal(11,2) DEFAULT NULL,
  `fechaultmov` date DEFAULT NULL COMMENT 'fecha ultimo movimiento',
  `fechaprmov` date DEFAULT NULL COMMENT 'fecha primer movimiento',
  PRIMARY KEY (`Id`),
  KEY `producto_id` (`producto_id`) USING BTREE,
  CONSTRAINT `pv_inventario_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `pv_producto` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pv_inventario
-- ----------------------------

-- ----------------------------
-- Table structure for pv_movimientoproducto
-- ----------------------------
DROP TABLE IF EXISTS `pv_movimientoproducto`;
CREATE TABLE `pv_movimientoproducto` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) DEFAULT NULL,
  `RFID` varchar(20) DEFAULT NULL,
  `cantidad` decimal(11,2) DEFAULT NULL,
  `preciolinea` decimal(11,2) DEFAULT NULL,
  `precioventa` decimal(11,2) DEFAULT NULL COMMENT 'Precio de Venta',
  `tipo_ord` enum('2','1') DEFAULT NULL COMMENT '1- Orden Compra, 2 - Orden Venta',
  `ordenv_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `ordenc_id` int(11) DEFAULT NULL,
  `estado_id` int(11) DEFAULT NULL COMMENT '2- Recibido,3-Inventariado,4-Apartado Venta,5-Vendido',
  `fecha_inventario` date DEFAULT NULL COMMENT 'fecha_entrada_inventario',
  `fecha_venta` date DEFAULT NULL,
  `cajonera` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `usuario_id` (`usuario_id`) USING BTREE,
  KEY `pv_movimientoproducto_ibfk_2` (`ordenv_id`) USING BTREE,
  KEY `producto_id` (`producto_id`) USING BTREE,
  KEY `pv_movimientoproducto_ibfk_3` (`ordenc_id`) USING BTREE,
  CONSTRAINT `pv_movimientoproducto_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `pv_producto` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `pv_movimientoproducto_ibfk_2` FOREIGN KEY (`ordenv_id`) REFERENCES `pv_ordenventa` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `pv_movimientoproducto_ibfk_3` FOREIGN KEY (`ordenc_id`) REFERENCES `pv_ordencompra` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `pv_movimientoproducto_ibfk_4` FOREIGN KEY (`usuario_id`) REFERENCES `pv_users` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pv_movimientoproducto
-- ----------------------------

-- ----------------------------
-- Table structure for pv_nombres
-- ----------------------------
DROP TABLE IF EXISTS `pv_nombres`;
CREATE TABLE `pv_nombres` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `referencia` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pv_nombres
-- ----------------------------
INSERT INTO `pv_nombres` VALUES ('1', 'Harland', 'H');
INSERT INTO `pv_nombres` VALUES ('2', 'Vans Baxter', 'V');
INSERT INTO `pv_nombres` VALUES ('3', 'Duke', 'D');
INSERT INTO `pv_nombres` VALUES ('4', 'Anna Flynn', 'A');
INSERT INTO `pv_nombres` VALUES ('5', 'Dakota', 'D');
INSERT INTO `pv_nombres` VALUES ('6', 'Bailarina Kenneth', 'A');
INSERT INTO `pv_nombres` VALUES ('7', 'Bikers Primrose', 'B');
INSERT INTO `pv_nombres` VALUES ('8', 'Mighty Flex', 'M');
INSERT INTO `pv_nombres` VALUES ('9', 'Pavlini', 'P');
INSERT INTO `pv_nombres` VALUES ('10', 'Audaz', 'A');
INSERT INTO `pv_nombres` VALUES ('11', 'Adizero', 'A');
INSERT INTO `pv_nombres` VALUES ('12', 'Cartago', 'C');
INSERT INTO `pv_nombres` VALUES ('13', 'Disney', 'D');
INSERT INTO `pv_nombres` VALUES ('14', 'Coqueta', 'C');
INSERT INTO `pv_nombres` VALUES ('15', 'Mafalda', 'M');
INSERT INTO `pv_nombres` VALUES ('16', 'Vizzano', 'V');
INSERT INTO `pv_nombres` VALUES ('17', 'Art Dance', 'A');
INSERT INTO `pv_nombres` VALUES ('18', 'Mafalda Sheccid', 'M');
INSERT INTO `pv_nombres` VALUES ('19', 'Cualquiera', 'CA');

-- ----------------------------
-- Table structure for pv_ordencompra
-- ----------------------------
DROP TABLE IF EXISTS `pv_ordencompra`;
CREATE TABLE `pv_ordencompra` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `proveedor_id` int(11) DEFAULT NULL,
  `numberorden` varchar(255) DEFAULT NULL,
  `totalorden` decimal(11,2) DEFAULT NULL,
  `estado_id` int(11) DEFAULT NULL COMMENT '1-Creación, 2- Solicitud, 3- Recibida',
  `fechacreada` date DEFAULT NULL,
  `fechallegada` date DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `proveedor_id` (`proveedor_id`) USING BTREE,
  CONSTRAINT `pv_ordencompra_ibfk_1` FOREIGN KEY (`proveedor_id`) REFERENCES `pv_proveedor` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pv_ordencompra
-- ----------------------------
INSERT INTO `pv_ordencompra` VALUES ('8', '1', 'OC001', '48000.00', '2', '2016-03-17', null);

-- ----------------------------
-- Table structure for pv_ordenventa
-- ----------------------------
DROP TABLE IF EXISTS `pv_ordenventa`;
CREATE TABLE `pv_ordenventa` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `orden_number` varchar(255) DEFAULT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `total_orden` decimal(11,2) DEFAULT NULL,
  `fechacreada` date DEFAULT NULL,
  `fecharecibida` date DEFAULT NULL,
  `estado_id` int(11) DEFAULT NULL COMMENT '1-solicitud, 2-generada,3-finalizada',
  PRIMARY KEY (`Id`),
  KEY `cliente_id` (`cliente_id`) USING BTREE,
  CONSTRAINT `pv_ordenventa_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `pv_clientes` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pv_ordenventa
-- ----------------------------

-- ----------------------------
-- Table structure for pv_producto
-- ----------------------------
DROP TABLE IF EXISTS `pv_producto`;
CREATE TABLE `pv_producto` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` int(11) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `precio` decimal(11,2) DEFAULT NULL COMMENT 'preciocompra',
  `unidad_id` int(11) DEFAULT NULL,
  `precio_venta` decimal(11,2) DEFAULT NULL,
  `codbarras` varchar(255) DEFAULT NULL,
  `talla_id` int(11) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `tipo_id` int(11) DEFAULT NULL,
  `estado_id` int(2) DEFAULT '1' COMMENT '1- Activo\r\n2- Inactivo',
  PRIMARY KEY (`Id`),
  KEY `categoria_id` (`categoria_id`) USING BTREE,
  KEY `unidad_id` (`unidad_id`) USING BTREE,
  KEY `nombre` (`nombre`),
  KEY `talla_id` (`talla_id`),
  KEY `color_id` (`color_id`),
  KEY `tipo_id` (`tipo_id`),
  CONSTRAINT `pv_producto_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `pv_categorias` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `pv_producto_ibfk_2` FOREIGN KEY (`unidad_id`) REFERENCES `pv_unidades` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `pv_producto_ibfk_3` FOREIGN KEY (`nombre`) REFERENCES `pv_nombres` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `pv_producto_ibfk_4` FOREIGN KEY (`talla_id`) REFERENCES `pv_tallas` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `pv_producto_ibfk_5` FOREIGN KEY (`color_id`) REFERENCES `pv_color` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `pv_producto_ibfk_6` FOREIGN KEY (`tipo_id`) REFERENCES `pv_tipo` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pv_producto
-- ----------------------------
INSERT INTO `pv_producto` VALUES ('2', '1', '2', '1900.00', '1', null, 'CMHM39', '18', '1', '3', '1');
INSERT INTO `pv_producto` VALUES ('5', '1', '2', '1900.00', '1', null, 'CMHR39', '18', '2', '3', '1');
INSERT INTO `pv_producto` VALUES ('8', '1', '2', null, '1', null, 'CMHN39', '18', '3', '3', '1');
INSERT INTO `pv_producto` VALUES ('9', '1', '2', null, '1', null, 'CMHA39', '18', '4', '3', '1');
INSERT INTO `pv_producto` VALUES ('10', '2', '2', null, '1', null, 'CTVB39', '18', '5', '1', '1');
INSERT INTO `pv_producto` VALUES ('11', '2', '2', null, '1', null, 'CTVG39', '18', '6', '1', '1');
INSERT INTO `pv_producto` VALUES ('12', '2', '2', null, '1', null, 'CTVA39', '18', '4', '1', '1');
INSERT INTO `pv_producto` VALUES ('13', '3', '2', null, '1', null, 'CZDC39', '18', '7', '2', '1');
INSERT INTO `pv_producto` VALUES ('14', '1', '2', null, '1', null, 'CMHM40', '19', '1', '3', '1');
INSERT INTO `pv_producto` VALUES ('15', '1', '2', '1600.00', '1', null, 'CMHR40', '19', '2', '3', '1');
INSERT INTO `pv_producto` VALUES ('16', '1', '2', '2200.00', '1', null, 'CMHA40', '19', '4', '3', '1');
INSERT INTO `pv_producto` VALUES ('17', '1', '2', '1600.00', '1', null, 'CMHB40', '19', '5', '3', '1');
INSERT INTO `pv_producto` VALUES ('18', '2', '2', '1500.00', '1', null, 'CTVB40', '19', '5', '1', '1');
INSERT INTO `pv_producto` VALUES ('19', '2', '2', '1600.00', '1', null, 'CTVG40', '19', '6', '1', '1');
INSERT INTO `pv_producto` VALUES ('47', '2', '2', '2000.00', '1', null, 'CTVA40', '19', '4', '1', '1');

-- ----------------------------
-- Table structure for pv_productosoc
-- ----------------------------
DROP TABLE IF EXISTS `pv_productosoc`;
CREATE TABLE `pv_productosoc` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` decimal(11,2) DEFAULT NULL,
  `preciolinea` decimal(11,2) DEFAULT NULL,
  `orden_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `orden_id` (`orden_id`) USING BTREE,
  KEY `producto_id` (`producto_id`) USING BTREE,
  CONSTRAINT `pv_productosoc_ibfk_1` FOREIGN KEY (`orden_id`) REFERENCES `pv_ordencompra` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `pv_productosoc_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `pv_producto` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pv_productosoc
-- ----------------------------
INSERT INTO `pv_productosoc` VALUES ('10', '2', '10.00', '19000.00', '8');
INSERT INTO `pv_productosoc` VALUES ('11', '5', '10.00', '19000.00', '8');
INSERT INTO `pv_productosoc` VALUES ('12', '47', '5.00', '10000.00', '8');

-- ----------------------------
-- Table structure for pv_productosventa
-- ----------------------------
DROP TABLE IF EXISTS `pv_productosventa`;
CREATE TABLE `pv_productosventa` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ordenventa_id` int(11) DEFAULT NULL,
  `mv_producto_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `ordenventa_id` (`ordenventa_id`),
  KEY `mv_producto_id` (`mv_producto_id`),
  CONSTRAINT `pv_productosventa_ibfk_1` FOREIGN KEY (`ordenventa_id`) REFERENCES `pv_ordenventa` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `pv_productosventa_ibfk_2` FOREIGN KEY (`mv_producto_id`) REFERENCES `pv_movimientoproducto` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pv_productosventa
-- ----------------------------

-- ----------------------------
-- Table structure for pv_proveedor
-- ----------------------------
DROP TABLE IF EXISTS `pv_proveedor`;
CREATE TABLE `pv_proveedor` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pv_proveedor
-- ----------------------------
INSERT INTO `pv_proveedor` VALUES ('1', 'Distrisan');

-- ----------------------------
-- Table structure for pv_tallas
-- ----------------------------
DROP TABLE IF EXISTS `pv_tallas`;
CREATE TABLE `pv_tallas` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `talla` int(2) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pv_tallas
-- ----------------------------
INSERT INTO `pv_tallas` VALUES ('1', '22');
INSERT INTO `pv_tallas` VALUES ('2', '23');
INSERT INTO `pv_tallas` VALUES ('3', '24');
INSERT INTO `pv_tallas` VALUES ('4', '25');
INSERT INTO `pv_tallas` VALUES ('5', '26');
INSERT INTO `pv_tallas` VALUES ('6', '27');
INSERT INTO `pv_tallas` VALUES ('7', '28');
INSERT INTO `pv_tallas` VALUES ('8', '29');
INSERT INTO `pv_tallas` VALUES ('9', '30');
INSERT INTO `pv_tallas` VALUES ('10', '31');
INSERT INTO `pv_tallas` VALUES ('11', '32');
INSERT INTO `pv_tallas` VALUES ('12', '33');
INSERT INTO `pv_tallas` VALUES ('13', '34');
INSERT INTO `pv_tallas` VALUES ('14', '35');
INSERT INTO `pv_tallas` VALUES ('15', '36');
INSERT INTO `pv_tallas` VALUES ('16', '37');
INSERT INTO `pv_tallas` VALUES ('17', '38');
INSERT INTO `pv_tallas` VALUES ('18', '39');
INSERT INTO `pv_tallas` VALUES ('19', '40');
INSERT INTO `pv_tallas` VALUES ('20', '41');

-- ----------------------------
-- Table structure for pv_tipo
-- ----------------------------
DROP TABLE IF EXISTS `pv_tipo`;
CREATE TABLE `pv_tipo` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `referencia` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pv_tipo
-- ----------------------------
INSERT INTO `pv_tipo` VALUES ('1', 'Tennis', 'T');
INSERT INTO `pv_tipo` VALUES ('2', 'Zapato Material', 'Z');
INSERT INTO `pv_tipo` VALUES ('3', 'Mocasines', 'M');
INSERT INTO `pv_tipo` VALUES ('4', 'Baleta', 'B');
INSERT INTO `pv_tipo` VALUES ('5', 'Zapatilla Puntal', 'Z');
INSERT INTO `pv_tipo` VALUES ('6', 'Sandalia Plataforma', 'S');
INSERT INTO `pv_tipo` VALUES ('7', 'Sandalia', 'S');
INSERT INTO `pv_tipo` VALUES ('8', 'Zapato Cerrado', 'Z');
INSERT INTO `pv_tipo` VALUES ('9', 'Zapatos Wings', 'Z');
INSERT INTO `pv_tipo` VALUES ('10', 'Tennis Plataforma', 'TP');

-- ----------------------------
-- Table structure for pv_unidades
-- ----------------------------
DROP TABLE IF EXISTS `pv_unidades`;
CREATE TABLE `pv_unidades` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pv_unidades
-- ----------------------------
INSERT INTO `pv_unidades` VALUES ('1', 'Pares');

-- ----------------------------
-- Table structure for pv_users
-- ----------------------------
DROP TABLE IF EXISTS `pv_users`;
CREATE TABLE `pv_users` (
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
-- Records of pv_users
-- ----------------------------
INSERT INTO `pv_users` VALUES ('1', 'Diana', 'admin', '123456', null, '1', 'anaid0410@gmail.com', null, null);
INSERT INTO `pv_users` VALUES ('2', 'Pepito', 'pperez', '123456', null, '1', 'pperez@gmail.com', null, null);
INSERT INTO `pv_users` VALUES ('3', 'Jhonattan Moreno', 'jmoreno', '123456', null, '2', 'jmoreno@gmail.com', null, null);
INSERT INTO `pv_users` VALUES ('4', 'Javier', 'jarias', 'jarias2016', null, '1', 'jarias@gmail.com', null, null);

-- ----------------------------
-- View structure for pv_pedidos
-- ----------------------------
DROP VIEW IF EXISTS `pv_pedidos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER  VIEW `pv_pedidos` AS select `pv_ordenventa`.`Id` AS `Id`,`pv_ordenventa`.`orden_number` AS `orden_number`,`pv_clientes`.`Id` AS `idcliente`,`pv_clientes`.`nombre` AS `nombre`,`pv_clientes`.`direccion` AS `direccion`,`pv_ordenventa`.`total_orden` AS `total_orden`,`pv_ordenventa`.`fechacreada` AS `fechacreada`,`pv_ordenventa`.`fecharecibida` AS `fecharecibida`,`pv_ordenventa`.`estado_id` AS `estado_id` from (`pv_ordenventa` left join `pv_clientes` on((`pv_clientes`.`Id` = `pv_ordenventa`.`cliente_id`))) ; ;

-- ----------------------------
-- View structure for view_clientes
-- ----------------------------
DROP VIEW IF EXISTS `view_clientes`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `view_clientes` AS select `pv_clientes`.`Id` AS `Id`,`pv_clientes`.`nombre` AS `nombre`,`pv_clientes`.`direccion` AS `direccion`,`pv_clientes`.`tipo_identificacion` AS `tipo_identificacion`,`pv_clientes`.`identificacion` AS `identificacion`,avg(`pv_ordenventa`.`total_orden`) AS `promedio`,max(`pv_ordenventa`.`fechacreada`) AS `maxorden` from (`pv_clientes` left join `pv_ordenventa` on((`pv_ordenventa`.`cliente_id` = `pv_clientes`.`Id`))) group by `pv_clientes`.`Id` ; ;

-- ----------------------------
-- View structure for view_ordencompra
-- ----------------------------
DROP VIEW IF EXISTS `view_ordencompra`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `view_ordencompra` AS select `pv_ordencompra`.`Id` AS `Id`,`pv_ordencompra`.`proveedor_id` AS `proveedor_id`,`pv_ordencompra`.`numberorden` AS `numberorden`,`pv_ordencompra`.`totalorden` AS `totalorden`,`pv_ordencompra`.`estado_id` AS `estado_id`,`pv_ordencompra`.`fechacreada` AS `fechacreada`,`pv_ordencompra`.`fechallegada` AS `fechallegada`,'Bodega' AS `proveedor` from `pv_ordencompra` ; ;

-- ----------------------------
-- View structure for view_productos
-- ----------------------------
DROP VIEW IF EXISTS `view_productos`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `view_productos` AS SELECT
	`pv_producto`.`Id` AS `Id`,
	`pv_producto`.`precio` AS `precio`,
	`pv_producto`.`codbarras` AS `codbarras`,
	`pv_producto`.`nombre` AS `nombre`,
	`pv_categorias`.`nombre` AS `categoria`,
	`pv_categorias`.`Id` AS `idcategoria`,
	`pv_producto`.`unidad_id` AS `unidad_id`,
	`pv_unidades`.`nombre` AS `unidades`,
	 pv_producto.tipo_id,pv_producto.color_id,pv_producto.talla_id,pv_producto.precio_venta
FROM
	(
		(
			`pv_producto`
			LEFT JOIN `pv_categorias` ON (
				(
					`pv_categorias`.`Id` = `pv_producto`.`categoria_id`
				)
			)
		)
		LEFT JOIN `pv_unidades` ON (
			(
				`pv_unidades`.`Id` = `pv_producto`.`unidad_id`
			)
		)
		LEFT JOIN pv_tallas ON pv_tallas.Id=pv_producto.talla_id
		LEFT JOIN pv_color ON pv_color.Id=pv_producto.color_id
		LEFT JOIN pv_tipo ON pv_tipo.Id=pv_producto.tipo_id
	) ;

-- ----------------------------
-- View structure for view_usuarios
-- ----------------------------
DROP VIEW IF EXISTS `view_usuarios`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `view_usuarios` AS select `pv_users`.`Id` AS `Id`,`pv_users`.`nombre` AS `nombre`,`pv_users`.`userp` AS `userp`,`pv_users`.`password` AS `password`,`pv_users`.`estado_id` AS `estado_id`,`pv_users`.`correo` AS `correo` from `pv_users` ; ;
DROP TRIGGER IF EXISTS `TG_LOG`;
DELIMITER ;;
CREATE TRIGGER `TG_LOG` BEFORE INSERT ON `com_log` FOR EACH ROW BEGIN

SET NEW.fecha=NOW();

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `TRG_PVINV1`;
DELIMITER ;;
CREATE TRIGGER `TRG_PVINV1` BEFORE INSERT ON `pv_inventario` FOR EACH ROW BEGIN

SET NEW.fechaprmov=NOW();

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `TRG_PVINV2`;
DELIMITER ;;
CREATE TRIGGER `TRG_PVINV2` BEFORE UPDATE ON `pv_inventario` FOR EACH ROW BEGIN

SET NEW.fechaultmov=NOW();

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `TRG_MOV2`;
DELIMITER ;;
CREATE TRIGGER `TRG_MOV2` BEFORE UPDATE ON `pv_movimientoproducto` FOR EACH ROW BEGIN

SET @RFID=NEW.RFID;
SET @RFID2=OLD.RFID;
SET @estado=NEW.estado_id;
SET @estado2=OLD.estado_id;

IF(LENGTH(@RFID)>0 AND @RFID2 is NULL) THEN

 SET NEW.estado_id=3;
 SET @orden=NEW.ordenc_id;
 SET NEW.fecha_inventario=NOW();
 SET @producto=NEW.producto_id;
 SET @idinv=(SELECT Id FROM pv_inventario WHERE producto_id=@producto);
 SET  @cantidad=(SELECT cantidad FROM pv_inventario WHERE producto_id=@producto);
 SET @newcantidad=@cantidad+1; 

   IF (length(@idinv)>0) THEN
          UPDATE pv_inventario SET cantidad=@newcantidad WHERE producto_id=@producto;
   ELSE
          INSERT INTO pv_inventario SET cantidad=1,producto_id=@producto ;
   END IF;

END IF;


IF (@estado=4 and OLD.estado_id=3) THEN

SET @orden=NEW.ordenv_id;
SET @Idmov=NEW.Id;
SET @producto=NEW.producto_id;
SET @precio=(SELECT precio_venta FROM pv_producto WHERE Id=@producto);
SET NEW.precioventa=@precio;

   INSERT INTO pv_productosventa SET ordenventa_id=@orden, mv_producto_id=@Idmov;

END IF;



IF (@estado=5 and OLD.estado_id=4) THEN


SET @producto=NEW.producto_id;

   UPDATE pv_inventario SET cantidad=(cantidad-1) WHERE producto_id=@producto;

END IF;


END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_nombres`;
DELIMITER ;;
CREATE TRIGGER `trg_nombres` BEFORE INSERT ON `pv_nombres` FOR EACH ROW BEGIN

INSERT INTO bodega.com_nombres SET Id=NEW.Id,nombre=NEW.nombre,referencia=NEW.referencia;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_nombres2`;
DELIMITER ;;
CREATE TRIGGER `trg_nombres2` BEFORE UPDATE ON `pv_nombres` FOR EACH ROW BEGIN

UPDATE bodega.com_nombres SET nombre=NEW.nombre,referencia=NEW.referencia WHERE Id=NEW.Id;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `tgrr_init`;
DELIMITER ;;
CREATE TRIGGER `tgrr_init` BEFORE INSERT ON `pv_ordencompra` FOR EACH ROW BEGIN

SET @sgteOC=(SELECT SUBSTR(numberorden,5) FROM pv_ordencompra ORDER BY Id DESC LIMIT 1);
SET @OCNEW=@sgteOC+1;
SET NEW.fechacreada=NOW();
IF(@OCNEW>=1) THEN
    SET NEW.numberorden=concat("OC00",@OCNEW);
ELSE
  SET NEW.numberorden='OC001';
END IF;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `tgrr_pedido`;
DELIMITER ;;
CREATE TRIGGER `tgrr_pedido` AFTER UPDATE ON `pv_ordencompra` FOR EACH ROW BEGIN
DECLARE done INT DEFAULT FALSE;
DECLARE ids VARCHAR(255);
DECLARE ids2 DECIMAL(11,2);
DECLARE ids3 DECIMAL(11,2);
DECLARE ids4 INT;
DECLARE ids5 INT;
DECLARE ids6 INT;
DECLARE ids7 INT;
DECLARE ids8 VARCHAR(255);
DECLARE ids9 VARCHAR(255);
DECLARE cur CURSOR FOR SELECT codbarras,cantidad,preciolinea,producto_id FROM  pv_productosoc,pv_producto WHERE pv_productosoc.orden_id=NEW.Id and pv_producto.Id=producto_id;
DECLARE cur2 CURSOR FOR SELECT linea_cliente,cantidad,orden_compra,(preciolinea/cantidad),RFID,RFID2 FROM bodega.com_pedidos2  WHERE orden_compra=NEW.Id;
DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

IF(NEW.estado_id=2 && OLD.estado_id=1) THEN

SET @fechapedido=NOW();
SET @fechasalida=NOW();
SET @direccioncliente_id=1;
SET @totalantesiva=0;
SET @totaliva=0;
SET @totalesperado=NEW.totalorden;
SET @estado_id=1;
SET @orden=NEW.Id;
INSERT INTO bodega.com_pedidos SET  sol_cliente='1',fechapedido=@fechapedido,fechasalida=@fechasalida,fechaentrega='',direccioncliente_id=@direccioncliente_id,valoresperado=@totalesperado,estado_id=@estado_id;
SET @Idpedido=(SELECT max(Id) FROM bodega.com_pedidos WHERE sol_cliente='1');

OPEN cur;

 ins_loop: LOOP
            FETCH cur INTO ids,ids2,ids3,ids4;
            IF done THEN
                LEAVE ins_loop;
            END IF;
    
              INSERT INTO bodega.com_pedidos2 SET pedido_id=@Idpedido,codbarras=ids,cantidad=ids2,preciolinea=ids3,linea_cliente=ids4,orden_compra=@orden;

   END LOOP;

CLOSE cur;     
END IF;





IF(NEW.estado_id=3 and OLD.estado_id=2) THEN

OPEN cur2;

 ins_loop: LOOP
            FETCH cur2 INTO ids2,ids4,ids5,ids3,ids8,ids9;
            IF done THEN
                LEAVE ins_loop;
            END IF;
    
            SET @largocadena=(length(ids8)-length(ids9))+1;
             
             WHILE (@largocadena>0) DO
               INSERT INTO pv_movimientoproducto  SET producto_id=ids2,tipo_ord='1',cantidad=1,preciolinea=ids3,ordenc_id=ids5,estado_id='2';     
               SET @largocadena=@largocadena-1;

             END WHILE;

   END LOOP;

CLOSE cur2;     

ELSEIF(NEW.estado_id=4 and OLD.estado_id=3) THEN

 SET @orden=NEW.Id;
 SET @totallineas=(SELECT count(*) FROM pv_movimientoproducto WHERE ordenc_id=@orden);
 SET @lineasvan=(SELECT count(*) FROM pv_movimientoproducto WHERE ordenc_id=@orden and RFID is not null);
 SET @real=@totallineas-@lineasvan;
 
 INSERT INTO com_log SET nombre=@real;

 IF(@real>0) THEN
   
      UPDATE pv_ordencompra SET estado_id=3 WHERE Id=NEW.Id;

 END IF;

END IF;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_ped1`;
DELIMITER ;;
CREATE TRIGGER `trg_ped1` BEFORE INSERT ON `pv_ordenventa` FOR EACH ROW BEGIN

SET @sgteOC=(SELECT SUBSTR(orden_number,5) FROM pv_ordenventa ORDER BY Id DESC LIMIT 1);
SET @OCNEW=@sgteOC+1;
SET NEW.fechacreada=NOW();
IF(@OCNEW>=1) THEN
    SET NEW.orden_number=concat("PD00",@OCNEW);
ELSE
  SET NEW.orden_number='PD001';
END IF;
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_ped2`;
DELIMITER ;;
CREATE TRIGGER `trg_ped2` BEFORE UPDATE ON `pv_ordenventa` FOR EACH ROW BEGIN

IF(NEW.estado_id=1 && OLD.estado_id>1) THEN
     SET NEW.estado_id=OLD.estado_id;
ELSEIF(NEW.estado_id=2 && OLD.estado_id>2) THEN
    SET NEW.estado_id=OLD.estado_id;
ELSEIF(NEW.estado_id=2 && OLD.estado_id is NULL) THEN
    SET NEW.estado_id=1;
ELSEIF(NEW.estado_id=3 && OLD.estado_id>3) THEN
    SET NEW.estado_id=OLD.estado_id;
ELSEIF(NEW.estado_id=3 && OLD.estado_id is NULL) THEN
    SET NEW.estado_id=1;
END IF;


IF(NEW.estado_id=2 && OLD.estado_id=1) THEN
   SET @orden=NEW.Id;
   SET NEW.fecharecibida=NOW();
   SET NEW.estado_id=3;
   UPDATE pv_movimientoproducto SET estado_id=5 WHERE ordenv_id=@orden;

 
END IF;


END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trigger1`;
DELIMITER ;;
CREATE TRIGGER `trigger1` BEFORE INSERT ON `pv_productosoc` FOR EACH ROW BEGIN
SET @producto=NEW.producto_id;
SET @precio=(SELECT precio FROM pv_producto WHERE Id=@producto);
SET @cantidad=NEW.cantidad;
SET NEW.preciolinea=(@cantidad*@precio);
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trigger2`;
DELIMITER ;;
CREATE TRIGGER `trigger2` AFTER INSERT ON `pv_productosoc` FOR EACH ROW BEGIN
SET @ordenc=NEW.orden_id;
SET @total=(SELECT sum(preciolinea) FROM pv_productosoc WHERE orden_id=@ordenc);
UPDATE pv_ordencompra SET totalorden=@total WHERE Id=@ordenc;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trigger3`;
DELIMITER ;;
CREATE TRIGGER `trigger3` BEFORE UPDATE ON `pv_productosoc` FOR EACH ROW BEGIN
SET @producto=NEW.producto_id;
SET @precio=(SELECT precio FROM pv_producto WHERE Id=@producto);
SET @cantidad=NEW.cantidad;
SET NEW.preciolinea=(@cantidad*@precio);
END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trigger4`;
DELIMITER ;;
CREATE TRIGGER `trigger4` AFTER UPDATE ON `pv_productosoc` FOR EACH ROW BEGIN
SET @ordenc=NEW.orden_id;
SET @total=(SELECT sum(preciolinea) FROM pv_productosoc WHERE orden_id=@ordenc);
UPDATE pv_ordencompra SET totalorden=@total WHERE Id=@ordenc;

END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `tr_ultentrda`;
DELIMITER ;;
CREATE TRIGGER `tr_ultentrda` BEFORE UPDATE ON `pv_users` FOR EACH ROW BEGIN

SET @fecha=sysdate();

END
;;
DELIMITER ;
