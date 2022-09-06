BEGIN
/*Creacion de la OC*/
INSERT INTO com_ordencompra (fechasolicitud,fecharecibido,direccionproveedor_id,totalantesiva,totaliva,totalconiva,usuario_id,estado_id) VALUES ('2013-02-01','2013-05-05','3','2950','0','2950','1','1');

/*Adheriendo Productos*/
INSERT INTO com_productosorden (proveedorproducto_id,cantidadpedida,valoractualsiniva,porcentajeiva,orden_id,cantidarecibida,fecharecibido,valorconiva,usuario_id,cantidadminima,preciominimo) VALUES ('5','800','800.00','','15','','','800.00',NULL,'1.00','1.00');
INSERT INTO com_productosorden (proveedorproducto_id,cantidadpedida,valoractualsiniva,porcentajeiva,orden_id,cantidarecibida,fecharecibido,valorconiva,usuario_id,cantidadminima,preciominimo) VALUES ('6','400','400.00','','15','','','400.00',NULL,'1.00','1.00');
INSERT INTO com_productosorden (proveedorproducto_id,cantidadpedida,valoractualsiniva,porcentajeiva,orden_id,cantidarecibida,fecharecibido,valorconiva,usuario_id,cantidadminima,preciominimo) VALUES ('9','600','600.00','','15','','','600.00',NULL,'1.00','1.00');
INSERT INTO com_productosorden (proveedorproducto_id,cantidadpedida,valoractualsiniva,porcentajeiva,orden_id,cantidarecibida,fecharecibido,valorconiva,usuario_id,cantidadminima,preciominimo) VALUES ('10','200','200.00','','15','','','200.00',NULL,'1.00','1.00');
INSERT INTO com_productosorden (proveedorproducto_id,cantidadpedida,valoractualsiniva,porcentajeiva,orden_id,cantidarecibida,fecharecibido,valorconiva,usuario_id,cantidadminima,preciominimo) VALUES ('12','400','400.00','','15','','','400.00',NULL,'1.00','1.00');
INSERT INTO com_productosorden (proveedorproducto_id,cantidadpedida,valoractualsiniva,porcentajeiva,orden_id,cantidarecibida,fecharecibido,valorconiva,usuario_id,cantidadminima,preciominimo) VALUES ('13','100','100.00','','15','','','100.00',NULL,'1.00','1.00');
INSERT INTO com_productosorden (proveedorproducto_id,cantidadpedida,valoractualsiniva,porcentajeiva,orden_id,cantidarecibida,fecharecibido,valorconiva,usuario_id,cantidadminima,preciominimo) VALUES ('39','200','200.00','','15','','','200.00',NULL,'1.00','1.00');
INSERT INTO com_productosorden (proveedorproducto_id,cantidadpedida,valoractualsiniva,porcentajeiva,orden_id,cantidarecibida,fecharecibido,valorconiva,usuario_id,cantidadminima,preciominimo) VALUES ('11','250','250.00','','15','','','250.00',NULL,'1.00','1.00');

/*Pasando a Estado Generado*/
UPDATE com_ordencompra SET estado_id='3' WHERE Id='15';
UPDATE com_productosorden SET estado_id='3' WHERE orden_id='15';

/*Pasando a Estado en Revisión*/
UPDATE com_ordencompra SET estado_id='4' WHERE Id='15';
UPDATE com_productosorden SET estado_id='4' WHERE orden_id='15';

/*Revisando la OC*/

UPDATE com_ordencompra SET fecharecibido='2013-05-05',estado_id='4' WHERE Id=15;
UPDATE com_productosorden SET cantidarecibida='800',fecharecibido='2013-05-05 00:30:47',usuario_id='1',estado_id='4',revisado='1',rollos='4' WHERE Id='128';
UPDATE com_productosorden SET cantidarecibida='400',fecharecibido='2013-05-05 00:31:19',usuario_id='1',estado_id='4',revisado='1',rollos='2' WHERE Id='129';
UPDATE com_productosorden SET cantidarecibida='600',fecharecibido='2013-05-05 00:31:12',usuario_id='1',estado_id='4',revisado='1',rollos='3' WHERE Id='130';
UPDATE com_productosorden SET cantidarecibida='200',fecharecibido='2013-05-05 00:31:04',usuario_id='1',estado_id='4',revisado='1',rollos='1' WHERE Id='131';
UPDATE com_productosorden SET cantidarecibida='400',fecharecibido='2013-05-05 00:31:40',usuario_id='1',estado_id='4',revisado='1',rollos='2' WHERE Id='132';
UPDATE com_productosorden SET cantidarecibida='100',fecharecibido='2013-05-05 00:31:46',usuario_id='1',estado_id='4',revisado='1',rollos='1' WHERE Id='133';
UPDATE com_productosorden SET cantidarecibida='200',fecharecibido='2013-05-05 00:31:51',usuario_id='1',estado_id='4',revisado='1',rollos='1' WHERE Id='134';
UPDATE com_productosorden SET cantidarecibida='250',fecharecibido='2013-05-05 00:31:55',usuario_id='1',estado_id='4',revisado='1',rollos='1' WHERE Id='135';
DELETE FROM com_ordenpendiente WHERE orden_id='15'

 
/*Ingreso a Inventario*/
INSERT INTO com_inventario SET producto_id='5',RFID='2264',cantidad='200',lineaoc_id='128',cantidad_entrada='200'
INSERT INTO com_inventario SET producto_id='5',RFID='2265',cantidad='200',lineaoc_id='128',cantidad_entrada='200'
INSERT INTO com_inventario SET producto_id='5',RFID='2266',cantidad='200',lineaoc_id='128',cantidad_entrada='200'
INSERT INTO com_inventario SET producto_id='5',RFID='2267',cantidad='200',lineaoc_id='128',cantidad_entrada='200'
UPDATE com_productosorden SET estado_id='5' WHERE Id='128'

INSERT INTO com_inventario SET producto_id='6',RFID='2268',cantidad='200',lineaoc_id='129',cantidad_entrada='200'
INSERT INTO com_inventario SET producto_id='6',RFID='2269',cantidad='200',lineaoc_id='129',cantidad_entrada='200'
UPDATE com_productosorden SET estado_id='5' WHERE Id='129'

INSERT INTO com_inventario SET producto_id='9',RFID='2270',cantidad='200',lineaoc_id='130',cantidad_entrada='200'
INSERT INTO com_inventario SET producto_id='9',RFID='2271',cantidad='200',lineaoc_id='130',cantidad_entrada='200'
INSERT INTO com_inventario SET producto_id='9',RFID='2272',cantidad='200',lineaoc_id='130',cantidad_entrada='200'
UPDATE com_productosorden SET estado_id='5' WHERE Id='130'
		   
INSERT INTO com_inventario SET producto_id='10',RFID='2273',cantidad='200',lineaoc_id='131',cantidad_entrada='200'
UPDATE com_productosorden SET estado_id='5' WHERE Id='131'

INSERT INTO com_inventario SET producto_id='12',RFID='2274',cantidad='200',lineaoc_id='132',cantidad_entrada='200'
INSERT INTO com_inventario SET producto_id='12',RFID='2275',cantidad='200',lineaoc_id='132',cantidad_entrada='200'
UPDATE com_productosorden SET estado_id='5' WHERE Id='132'

INSERT INTO com_inventario SET producto_id='13',RFID='2276',cantidad='100',lineaoc_id='133',cantidad_entrada='100'
UPDATE com_productosorden SET estado_id='5' WHERE Id='133'

INSERT INTO com_inventario SET producto_id='41',RFID='2277',cantidad='200',lineaoc_id='134',cantidad_entrada='200'
UPDATE com_productosorden SET estado_id='5' WHERE Id='134'

INSERT INTO com_inventario SET producto_id='11',RFID='2278',cantidad='250',lineaoc_id='135',cantidad_entrada='250'
UPDATE com_productosorden SET estado_id='5' WHERE Id='135'

UPDATE com_ordencompra SET estado_id='5' WHERE Id='15'


/*Etiquetado*/
UPDATE com_inventario SET estado='1',etiquetado='2' WHERE lineaoc_id BETWEEN '128' and '135';


/*Verificando acceso a bodega con RFID*/
UPDATE com_ordencompra SET fecharecibido='2013-05-05',estado_id='7' WHERE Id='15';
UPDATE com_productosorden SET estado_id='7' WHERE orden_id='15';
UPDATE com_inventario SET estado='2',verificado_id='1',fechaverificado='2013-05-05 00:50:52' WHERE lineaoc_id in ('128','129','130','131','132','133','134','135');

/*SE REEMPLAZA INSERT A MOVIMIENTO PRODUCTOS POR TRIGGER EN COM_INVENTARIO*/	  


/*Asignada en Bodega a auxiliar*/
UPDATE com_ordencompra SET estado_id='8' WHERE Id='15';
UPDATE com_productosorden SET estado_id='8' WHERE orden_id='15';
UPDATE com_inventario SET arraybodega_id='33' WHERE lineaoc_id in ('128','129','130');
UPDATE com_inventario SET arraybodega_id='31' WHERE lineaoc_id in ('131','132','133','134','135');
INSERT INTO com_responsablebodega SET orden_id='15',user_id='5',fechaasignada='2013-05-05';

/*En Bodega*/
UPDATE com_ordencompra SET estado_id='9',fechagenerada='2013-05-05' WHERE Id='15';
UPDATE com_productosorden SET estado_id='9' WHERE orden_id='15';

COMMIT