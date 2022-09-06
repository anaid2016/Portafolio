<?php 
$vproductos=array();
$demanda=array();
$lineaIds="";
$conteoproductos=$_POST['conteoproductos'];
$idprov=$_POST['proveedor'];
$prodjavascript="";
$sumatotalmetros=0;

//Productos y Demandas por dias ---------------------------------------------------//
for($a=0;$a<$conteoproductos;$a++){
	$recibido=$_POST['selector'.$a];	
	$exp_line=explode("--",$recibido);
	
	array_push($vproductos,$exp_line[0]);
	$demanda[$exp_line[0]]=number_format(($exp_line[1]/30),'2','.','');
	$lineaIds.=$exp_line[0].",";
	$prodjavascript.=$exp_line[0]."::";
}

$lineaIds=substr($lineaIds,0,-1);
$prodjavascript=substr($prodjavascript,0,-2);
$totalproductos=count($vproductos);


//Tiempo de Entrega del proveedor -------------------------------------------------//
$tiempo=mysql_query("SELECT tiempoentrega FROM com_proveedores
WHERE Id='$idprov'",$conexion);
$tarray=mysql_fetch_row($tiempo);
$L=$tarray[0];

//Capacidad del Contenedor
$cap_contenedor=12000;		//Capacida del contenedor en pies

$Ptela=60;	//Peso de la tela en (g*m2)
$Atela=1.6;	//Ancho de la tela
$Wtela=($cap_contenedor*1000)/($Ptela*$Atela); //Capacidad del contenedor en Metros


//Suma de todos los valores obtenidos en la estimación de la demanda en el periodo de entrega del producto por proveedor  L
$demandaperiodototal=array();
for($b=0;$b<count($vproductos);$b++){
	$indice=$vproductos[$b];
	$demandaperiodototal[$indice]=$demanda[$indice]*$L;
}
$sum_demanda=array_sum($demandaperiodototal);


//Calculado Tcapacidad -----
$Tcapacidad=$Wtela/$sum_demanda;
$Tcosto=1.98;


//Seleccionando Trevision
$Trevision=($Tcapacidad<$Tcosto)? $Tcapacidad:$Tcosto; //Seleccion del Tiempo de Revision
$Trevisiondias=$Trevision*30;


//Paso 5: Averiguando Inventario actual --------------------------------------
//Observacion:  Inventario actual es:  Inventario que hay en bodega + Inventario que llego desde el anterior t - hasta ahorita - ventas 

$total_inventario=mysql_query("SELECT sum(cantidad) as total,com_productos.Id
FROM com_inventario
LEFT JOIN com_productos ON com_productos.Id=com_inventario.producto_id 
LEFT JOIN com_unidades ON com_productos.unidadproducto_id=com_unidades.Id
WHERE estado in ('2','4') and com_productos.Id in (".$lineaIds.") GROUP BY producto_id",$conexion);

$inventario_actual=array();
while($registro=mysql_fetch_row($total_inventario)){
	$indice=$registro[1];
	$inventario_actual[$indice]=$registro[0];	
}


//Paso 6: Averiguando Ordenes Pendiente en el Tiempo de Entrega del proveedor contado a partir de la fecha 

$total_porllegar=mysql_query("SELECT sum(cantidadpedida),com_productos.Id FROM com_productosorden
LEFT JOIN com_proveedorproductos ON com_proveedorproductos.Id=com_productosorden.proveedorproducto_id
LEFT JOIN com_productos ON com_proveedorproductos.producto_id=com_productos.Id
LEFT JOIN com_ordencompra ON com_productosorden.orden_id=com_ordencompra.Id
WHERE com_productos.Id in (".$lineaIds.") and com_ordencompra.estado_id in ('3','4','5','6') 
and com_ordencompra.fecharecibido BETWEEN CURDATE() and DATE_ADD(CURDATE(),INTERVAL ".$L." DAY) GROUP BY com_proveedorproductos.Id",$conexion);

$sum_IT_duranteL=array();
while($registro=mysql_fetch_row($total_porllegar)){
	$indice=$registro[1];
	$sum_IT_duranteL[$indice]=$registro[0];	
}

//Paso 7: Calculo de M*: demanda en dias * (Tiempo de entrega del proveedor L (dias) +Tiempo de Revision T (dias)) Por que la demanda es en dias, si yo estoy dando el Tcapacidad en Meses.

$vector_M=array();
for($b=0;$b<count($vproductos);$b++){
	$indice=$vproductos[$b];
	$vector_M[$indice]=$demanda[$indice]*($L+$Trevisiondias);
}


//Paso 8: Calculo de Qrequerida: M*-(Inventario_Actual+SumIT) (Esto se debe sumar con el inventario de seguridad solo para el primer caso?)

$vector_qrequerida=array();
for($c=0;$c<count($vproductos);$c++){
	$indice=$vproductos[$c];
	$inventario_actual[$indice]=(!isset($inventario_actual[$indice]))? '0':$inventario_actual[$indice];	
	$sum_IT_duranteL[$indice]=(!isset($sum_IT_duranteL[$indice]))? '0':$sum_IT_duranteL[$indice];
	$vector_qrequerida[$indice]=$vector_M[$indice]-($inventario_actual[$indice]+$sum_IT_duranteL[$indice]);
}

//Consulta Cantidades Minimas------------------------------------------------//
//---------------------------------------------------------------------------//

$buscar2=mysql_query("SELECT com_proveedorproductos.producto_id,cantidadcompra FROM 	com_proveedorproductos
LEFT JOIN com_direccionproveedor ON com_direccionproveedor.Id=com_proveedorproductos.direccion_id
LEFT JOIN com_productos ON com_productos.Id=com_proveedorproductos.producto_id
WHERE com_direccionproveedor.Id='".$idprov."' and com_productos.id in (".$lineaIds.") ",$conexion);
while($registro=mysql_fetch_row($buscar2)){
	$indice=$registro[0];
	$vector_cantidadminima[$indice]=$registro[1];
}

//Paso 9: Valor a Solicitar de cada productos teniendo en cuenta ---------------------------------------------------------------//
$vector_acomprar=array();
$contenedorlleno=array();

for($c=0;$c<count($vproductos);$c++){
	$indice=$vproductos[$c];
	if($vector_qrequerida[$indice]<0){
		$vector_acomprar[$indice]=number_format(0);
		$contenedorlleno[$indice]=0;				//contenedor lleno no entra por que no se necesita cantidad de compra
	}else if($vector_qrequerida[$indice]>0 and $vector_qrequerida[$indice]>=$vector_cantidadminima[$indice]){
		$vector_acomprar[$indice]=number_format($vector_qrequerida[$indice],'2','.','');
		$contenedorlleno[$indice]=$vector_qrequerida[$indice];			//se habilita contenedor lleno dado que cantidad de requerida es mayor a cantidad de compra
	}else if($vector_qrequerida[$indice]>0 and $vector_qrequerida[$indice]<$vector_cantidadminima[$indice]){
		$vector_acomprar[$indice]=number_format($vector_cantidadminima[$indice],'2','.','');
		$contenedorlleno[$indice]=0;									//cantidad requerida menor que cantidad minima se saca de contenedor lleno
	}
}


//Paso 10: Suma total a comprar en metros de tela según Recomendación 1---------------------------------------------------//
$sumatotalmetros=array_sum($vector_acomprar);

//Paso 11: Cantidad de contenedores cubiertos por sumatotalmentros--------------------------------------------------------//
$cantcontenedor1=$sumatotalmetros/$Wtela;

//Paso 12: Faltante para completar ultimo contenedor ---------------------------------------------------------------------//
$faltante=(ceil($cantcontenedor1)-$cantcontenedor1)*$Wtela;

//Paso 13: Recomendacion 2 llenar el contenedor $faltante*($demandaperiodototal[$indice]/$sum_demanda)+$contenedorlleno[$indice] (faltate*(demanda durante L /suma de todas las demandas durante L))+cantidad de recomendación 1-------------------//
for($b=0;$b<count($vproductos);$b++){
	$indice=$vproductos[$b];
	if($contenedorlleno[$indice]>0){
		$contenedorlleno[$indice]=number_format(($faltante*($demandaperiodototal[$indice]/$sum_demanda))+$contenedorlleno[$indice],'2','.','');
	}
}


///---------------------------------------------------------------------------//
$buscar2=mysql_query("SELECT com_proveedorproductos.*,com_productos.nombre,com_productos.codbarras,com_unidades.nombre as unidad FROM 	com_proveedorproductos
LEFT JOIN com_direccionproveedor ON com_direccionproveedor.Id=com_proveedorproductos.direccion_id
LEFT JOIN com_proveedores ON com_direccionproveedor.proveedor_id=com_proveedores.Id
LEFT JOIN com_productos ON com_productos.Id=com_proveedorproductos.producto_id
LEFT JOIN com_unidades ON com_productos.unidadproducto_id=com_unidades.Id
WHERE com_direccionproveedor.Id='".$idprov."' and com_productos.id in (".$lineaIds.") ",$conexion);

	echo "<div class='datagrid'><table border='1' cellpadding='0' cellspacing='0'>
        	 <thead>
                <tr>
            		<th>Id</th>
					<th>Cod. de Barras</th>
					<th>Nombre del Producto</th>
					<th>Cant. Minima</th>
					<th>Demanda Días</th>
					<th>Inventario Actual</th>
					<th>Inventario Transito (L)</th>
					<th>M*</th>
					<th>Cant. Requerida</th>
					<th>Recom. 1</th>
					<th>Recom. 2</th>
					<th>Cant. Orden Compra</th>
              </tr></thead>";

	while($registro=mysql_fetch_row($buscar2)){
		$indice=$registro[1];
		
    ?>
        
        <tr>
        	<!--Id del producto --->
        	<td><?php echo $registro[0]; ?></td>
            
            <!--Codigo de Barras del producto -->
            <td><?php echo $registro[10]; ?></td>
            <td><?php echo $registro[9]; ?></td>
            <td><?php echo $registro[5]." ".$registro[11]; ?></td>
            <td><?php echo $demanda[$indice]; ?></td>
            <td><?php echo $inventario_actual[$indice]; ?></td>
			<td><?php echo $sum_IT_duranteL[$indice]; ?></td>
			<td><?php echo number_format($vector_M[$indice],'2','.',''); ?></td>
			<td><?php echo $vector_qrequerida[$indice]; ?></td>
            <!--Cantidad a Comprar según condición 1 por minima cuantia -->
			<td>
            	<table cellpadding="0" cellspacing="0">
                	<tr>
                    	<td style="font-size:1em;border:none"><input type="radio" value="<?php echo $vector_acomprar[$indice]; ?>" name="selp<?php echo $indice; ?>" id="selp<?php echo $indice; ?>" onclick="cantpoliticas(this)" checked="checked"/></td>
						<td style="font-size:1em;border:none"><?php echo $vector_acomprar[$indice]; ?></td>
                    </tr>
                </table>    
            </td>
            <td><!--Cantidad a Comprar según condición 2 llenar tanque -->
            	<table cellpadding="0" cellspacing="0">
                	<tr>
                    	<td style="font-size:1em;border:none"><input type="radio" value="<?php echo $contenedorlleno[$indice]; ?>" name="selp<?php echo $indice; ?>" id="selp<?php echo $indice; ?>" onclick="cantpoliticas(this)"/></td>
						<td style="font-size:1em;border:none"><?php echo $contenedorlleno[$indice]; ?></td>
                   </tr>
               </table>
            <td>
            	<input type="text" name="Prod<?php echo $indice; ?>" id="Prod<?php echo $indice; ?>" value="<?php echo $vector_acomprar[$indice]; ?>" onblur="politicamanual(this,'<?php echo $lineaIds; ?>')" />
                <input type="checkbox" name="dataline" value="<?php echo $registro[0]; ?>-<?php echo $registro[10]; ?>-<?php echo $registro[9]; ?>-<?php echo $registro[5]; ?>-<?php echo $registro[11]; ?>-<?php echo $registro[2]; ?>-<?php echo $registro[3]; ?>-<?php echo $registro[4]; ?>" id="dataline" checked  disabled="disabled"/>
            </td>
         </tr>   
	<?php
	}
	
	?>
    	 <tr>
        	<td colspan="12" style="border:none">&nbsp;</td>
        </tr>
    	<tr>
        	<td colspan="12">
            <table>
            	<thead class="foot">
            	<tr>
                    <th>Capacidad Contenedor (m):</th>
                    <th><input type="text" name="wtela" value="<?php echo $Wtela; ?>" id="wtela" disabled="disabled"/></th>
                    <th>Total Compra (m):</th>
                    <th><input type="text" name="totalenm" value="<?php echo $sumatotalmetros; ?>" id="totalenm" disabled="disabled"/></th>
                    <th>Cantidad de Contenedores (und):</th>
                    <th><input type="text" name="contenedores" value="<?php echo ceil($cantcontenedor1); ?>" id="contenedores" disabled="disabled"/></th>
                   <th>Cantidad Faltante (m):</th>
                   <th><input type="text" name="faltanteenm" value="<?php echo $faltante ?>" id="faltanteenm" disabled="disabled"/></th>
                </tr>
                </thead>
              </table>  
             </td> 
        </tr>
        <tr>
        	<td colspan="12">&nbsp;</td>
        </tr>
       <tr>
        	<td colspan="12"><input type="button" onClick="javascript: pasar('<?php echo $prodjavascript; ?>','<?php echo $totalproductos; ?>')" value="Registrar OC"/></td>
        </tr>    
    </table>
    </div>
