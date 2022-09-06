/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50616
Source Host           : 127.0.0.1:3306
Source Database       : proveedor

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2016-03-07 17:43:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for prov_categorias
-- ----------------------------
DROP TABLE IF EXISTS `prov_categorias`;
CREATE TABLE `prov_categorias` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of prov_categorias
-- ----------------------------
INSERT INTO `prov_categorias` VALUES ('1', 'Mujer');
INSERT INTO `prov_categorias` VALUES ('2', 'Hombre');

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
  PRIMARY KEY (`Id`),
  KEY `producto_id` (`producto_id`),
  KEY `ordenv_id` (`ordenv_id`),
  CONSTRAINT `prov_movimientoproducto_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `prov_producto` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `prov_movimientoproducto_ibfk_2` FOREIGN KEY (`ordenv_id`) REFERENCES `prov_ordenventa` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of prov_movimientoproducto
-- ----------------------------
INSERT INTO `prov_movimientoproducto` VALUES ('1', '2', '2', '1', '1', '2016-03-07', '1', '1200.00', null, '4');
INSERT INTO `prov_movimientoproducto` VALUES ('2', '2', '2', '1', '2', '2016-03-07', '1', '1200.00', null, '4');
INSERT INTO `prov_movimientoproducto` VALUES ('3', '2', '2', '1', '3', '2016-03-07', '1', '1200.00', null, '4');
INSERT INTO `prov_movimientoproducto` VALUES ('4', '5', '2', '1', '4', '2016-03-07', '1', '1320.00', null, '4');
INSERT INTO `prov_movimientoproducto` VALUES ('5', '5', '2', '1', '5', '2016-03-07', '1', '1320.00', null, '4');
INSERT INTO `prov_movimientoproducto` VALUES ('6', '5', '2', '1', '6', '2016-03-07', '1', '1320.00', null, '4');
INSERT INTO `prov_movimientoproducto` VALUES ('7', '2', '2', '1', '7', '2016-03-07', '1', '1200.00', null, '4');
INSERT INTO `prov_movimientoproducto` VALUES ('8', '2', '2', '1', '8', '2016-03-07', '1', '1200.00', null, '4');
INSERT INTO `prov_movimientoproducto` VALUES ('9', '2', '2', '1', '9', '2016-03-07', '1', '1200.00', null, '4');
INSERT INTO `prov_movimientoproducto` VALUES ('10', '2', '2', '1', '10', '2016-03-07', '1', '1200.00', null, '4');
INSERT INTO `prov_movimientoproducto` VALUES ('11', '2', '2', '1', '11', '2016-03-07', '1', '1200.00', null, '4');
INSERT INTO `prov_movimientoproducto` VALUES ('12', '2', '2', '1', '12', '2016-03-07', '1', '1200.00', null, '4');
INSERT INTO `prov_movimientoproducto` VALUES ('13', '2', '2', '1', '13', '2016-03-07', '1', '1200.00', null, '4');
INSERT INTO `prov_movimientoproducto` VALUES ('14', '2', '2', '1', '14', '2016-03-07', '1', '1200.00', null, '4');
INSERT INTO `prov_movimientoproducto` VALUES ('15', '2', '2', '1', '15', '2016-03-07', '1', '1200.00', null, '4');
INSERT INTO `prov_movimientoproducto` VALUES ('16', '2', '2', '1', '16', '2016-03-07', '1', '1200.00', null, '4');
INSERT INTO `prov_movimientoproducto` VALUES ('17', '2', '2', '1', '17', '2016-03-07', '1', '1200.00', null, '4');
INSERT INTO `prov_movimientoproducto` VALUES ('18', '2', '2', '1', '18', '2016-03-07', '1', '1200.00', null, '4');
INSERT INTO `prov_movimientoproducto` VALUES ('19', '2', '2', '1', '19', '2016-03-07', null, null, null, '3');
INSERT INTO `prov_movimientoproducto` VALUES ('20', '2', '2', '1', '20', '2016-03-07', null, null, null, '3');
INSERT INTO `prov_movimientoproducto` VALUES ('21', '2', '2', '1', '21', '2016-03-07', null, null, null, '3');
INSERT INTO `prov_movimientoproducto` VALUES ('22', '2', '2', '1', '22', '2016-03-07', null, null, null, '3');
INSERT INTO `prov_movimientoproducto` VALUES ('23', '2', '2', '1', '23', '2016-03-07', null, null, null, '3');
INSERT INTO `prov_movimientoproducto` VALUES ('24', '5', '2', '1', '24', '2016-03-07', null, null, null, '3');
INSERT INTO `prov_movimientoproducto` VALUES ('25', '5', '2', '1', '25', '2016-03-07', '1', '1320.00', null, '4');
INSERT INTO `prov_movimientoproducto` VALUES ('26', '5', '2', '1', '26', '2016-03-07', '1', '1320.00', null, '4');
INSERT INTO `prov_movimientoproducto` VALUES ('27', '5', '2', '1', '27', '2016-03-07', null, null, null, '3');
INSERT INTO `prov_movimientoproducto` VALUES ('28', '5', '2', '1', '28', '2016-03-07', null, null, null, '3');

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
  `fecharecibida` date DEFAULT NULL COMMENT 'fecha en la que senvio la orden',
  PRIMARY KEY (`Id`),
  KEY `cliente_id` (`cliente_id`),
  CONSTRAINT `prov_ordenventa_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `prov_clientes` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of prov_ordenventa
-- ----------------------------
INSERT INTO `prov_ordenventa` VALUES ('1', 'OV001', null, '1', '1', null, '2016-03-07', null);

-- ----------------------------
-- Table structure for prov_producto
-- ----------------------------
DROP TABLE IF EXISTS `prov_producto`;
CREATE TABLE `prov_producto` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `unidad_id` int(11) DEFAULT NULL,
  `precio_venta` decimal(11,2) DEFAULT NULL,
  `precio_produccion` decimal(11,2) DEFAULT NULL,
  `codbarras` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `categoria_id` (`categoria_id`),
  KEY `unidad_id` (`unidad_id`),
  CONSTRAINT `prov_producto_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `prov_categorias` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `prov_producto_ibfk_2` FOREIGN KEY (`unidad_id`) REFERENCES `prov_unidades` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of prov_producto
-- ----------------------------
INSERT INTO `prov_producto` VALUES ('2', 'Zapatilla Deport AF0546', '1', '1', '1200.00', '1000.00', '0001');
INSERT INTO `prov_producto` VALUES ('5', 'Zapatilla Deport AF0537', '2', '1', '1320.00', '1100.00', '0002');
INSERT INTO `prov_producto` VALUES ('8', 'Tacon Print Pardo', '1', '1', '1200.00', '1000.00', '0003');

-- ----------------------------
-- Table structure for prov_productosorden
-- ----------------------------
DROP TABLE IF EXISTS `prov_productosorden`;
CREATE TABLE `prov_productosorden` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ordenventa_id` int(11) DEFAULT NULL,
  `movimiento_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `estado_id` enum('2','1') DEFAULT NULL COMMENT '1- Solicitado 2-Despachado',
  `precio_venta` decimal(11,2) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `ordenventa_id` (`ordenventa_id`),
  KEY `movimiento_id` (`movimiento_id`),
  CONSTRAINT `prov_productosorden_ibfk_1` FOREIGN KEY (`ordenventa_id`) REFERENCES `prov_ordenventa` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `prov_productosorden_ibfk_2` FOREIGN KEY (`movimiento_id`) REFERENCES `prov_movimientoproducto` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of prov_productosorden
-- ----------------------------
INSERT INTO `prov_productosorden` VALUES ('1', '1', '1', '1', '1', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('2', '1', '3', '1', '1', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('3', '1', '2', '1', '1', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('4', '1', '7', '1', '1', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('5', '1', '8', '1', '1', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('6', '1', '4', '1', '1', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('7', '1', '5', '1', '1', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('8', '1', '6', '1', '1', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('9', '1', '9', '1', '1', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('10', '1', '10', '1', '1', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('11', '1', '11', '1', '1', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('12', '1', '12', '1', '1', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('13', '1', '13', '1', '1', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('14', '1', '14', '1', '1', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('15', '1', '15', '1', '1', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('16', '1', '16', '1', '1', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('17', '1', '17', '1', '1', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('18', '1', '18', '1', '1', '1200.00');
INSERT INTO `prov_productosorden` VALUES ('19', '1', '25', '1', '1', '1320.00');
INSERT INTO `prov_productosorden` VALUES ('20', '1', '26', '1', '1', '1320.00');

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
  PRIMARY KEY (`Id`),
  KEY `ordenventa_id` (`ordenventa_id`),
  KEY `producto_id` (`producto_id`),
  CONSTRAINT `prov_productosorden2_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `prov_producto` (`Id`) ON UPDATE CASCADE,
  CONSTRAINT `prov_productosorden2_ibfk_2` FOREIGN KEY (`ordenventa_id`) REFERENCES `prov_ordenventa` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of prov_productosorden2
-- ----------------------------
INSERT INTO `prov_productosorden2` VALUES ('4', null, '2', '10', '1', '1');
INSERT INTO `prov_productosorden2` VALUES ('5', null, '2', '5', '1', '2');
INSERT INTO `prov_productosorden2` VALUES ('6', null, '5', '5', '1', '3');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of prov_users
-- ----------------------------
INSERT INTO `prov_users` VALUES ('1', 'Diana', 'admin', '123456', null, '1', 'anaid0410@gmail.com', null, null);
INSERT INTO `prov_users` VALUES ('2', 'Pepito', 'pperez', '123456', null, '1', 'pperez@gmail.com', null, null);
INSERT INTO `prov_users` VALUES ('3', 'Jhonattan Moreno', 'jmoreno', '123456', null, '2', 'jmoreno@gmail.com', null, null);

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
	`prov_unidades`.`nombre` AS `unidades`
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
	) ;

-- ----------------------------
-- View structure for view_ordenproc
-- ----------------------------
DROP VIEW IF EXISTS `view_ordenproc`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `view_ordenproc` AS  ;

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
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `view_ventapendiente` AS SELECT prov_producto.Id,prov_producto.nombre,prov_producto.codbarras,sum(cantidad)as cantidad,precio_venta,(precio_venta*sum(cantidad)) as totallinea
FROM prov_productosorden2
LEFT JOIN prov_producto ON prov_producto.Id=prov_productosorden2.producto_id
WHERE prov_productosorden2.estado_id='1' GROUP BY producto_id ;

-- ----------------------------
-- View structure for view_ventas
-- ----------------------------
DROP VIEW IF EXISTS `view_ventas`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost`  VIEW `view_ventas` AS SELECT
	`prov_ordenventa`.`Id` AS `Id`,
	`prov_ordenventa`.`numeroorden` AS `orden_number`,
	prov_clientes.Id AS idcliente,
	`prov_clientes`.`nombre` AS `nombre`,
	`prov_clientes`.`direccion` AS `direccion`,
	`prov_ordenventa`.`total_orden` AS `total_orden`,
	`prov_ordenventa`.`fechacreada` AS `fechacreada`,
	`prov_ordenventa`.`fecharecibida` AS `fecharecibida`,
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

IF (@estado=4 and OLD.estado_id=3) THEN


SET @Idmov=NEW.Id;
SET @precio=(SELECT precio_venta FROM prov_producto WHERE Id=@producto);
SET NEW.precio_vendido=@precio;

   INSERT INTO prov_productosorden SET ordenventa_id=@orden, movimiento_id=@Idmov,cantidad='1',estado_id='1',precio_venta=@precio;

END IF;



IF (@estado=5 and OLD.estado_id=4) THEN


  SET NEW.tipo=1;

END IF;


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


IF(NEW.estado_id=3 && OLD.estado_id=2) THEN
   SET @orden=NEW.Id;
   SET NEW.fechasalida=NOW();
   UPDATE prov_moviientoproducto SET estado_id=5,fecha2=NOW() WHERE ordenv_id=@orden;
   UPDATE prov_productosorden SET estado_id=2 WHERE ordenventa_id=@orden;

 
END IF;


END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_productos`;
DELIMITER ;;
CREATE TRIGGER `trg_productos` BEFORE INSERT ON `prov_producto` FOR EACH ROW BEGIN

SET @precio=(NEW.precio_produccion*1.2);
SET NEW.precio_venta=@precio;
INSERT INTO bodega.com_productos SET Id=NEW.Id, lineaproducto_id=NEW.categoria_id, nombre=NEW.nombre, codbarras=NEW.codbarras,unidadproducto_id=NEW.unidad_id,tipoproducto_id='10',estado_id='1',precio_compra=@precio;






END
;;
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_productos2`;
DELIMITER ;;
CREATE TRIGGER `trg_productos2` BEFORE UPDATE ON `prov_producto` FOR EACH ROW BEGIN

SET @precio=(NEW.precio_produccion*1.2);
SET NEW.precio_venta=@precio;
UPDATE  bodega.com_productos SET  lineaproducto_id=NEW.categoria_id, nombre=NEW.nombre, codbarras=NEW.codbarras,unidadproducto_id=NEW.unidad_id,tipoproducto_id='10',estado_id='1',precio_compra=@precio WHERE Id=NEW.Id;

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
DROP TRIGGER IF EXISTS `tr_ultentrda`;
DELIMITER ;;
CREATE TRIGGER `tr_ultentrda` BEFORE UPDATE ON `prov_users` FOR EACH ROW BEGIN

SET @fecha=sysdate();

END
;;
DELIMITER ;
