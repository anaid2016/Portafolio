<?php

//Paso 0: Tiempo de Entrega del Proveedor -------------------
$L=6;


//Paso 1: Calculo de las Demanda ----------------------------------------------------------------
$vector_productos=array("001","002","003","004","005","006","007","008","009","010");
$vector_demanda=array("200","400","600","720","815","900","1000","1200","300","100");
$vector_cantidadminima=array("100","100","100","100","100","100","100","100","100","100");

//Capacidad del Contenedor
$cap_contenedor=12000;

$Ptela=60;	//Peso de la tela en (g*m2)
$Atela=1.6;	//Ancho de la tela
$Wtela=($cap_contenedor*1000)/($Ptela*$Atela); //Capacidad del contenedor en Metros

//Suma de todos los valores obtenidos en la estimación de la demanda
$sum_demanda=array_sum($vector_demanda);


//Calculado Tcapacidad -----
$Tcapacidad=$Wtela/$sum_demanda;
$Tcosto=1.98;

$Trevision=($Tcapacidad<$Tcosto)? $Tcapacidad:$Tcosto; //Seleccion del Tiempo de Revision

//Pasando demanda a días...
$vector_demanda_dias=array();
foreach($vector_demanda as $clave){
	array_push($vector_demanda_dias,number_format(($clave/30),2));
}


//Paso 5: Averiguando Inventario actual --------------------------------------
//Observacion:  Inventario actual es:  Inventario que hay en bodega + Inventario que esta por llegar durante t - (d*t) 

//<!---------------- DUDA AQUI SUPER IMPORTANTE ESTE $d es la estimación de demanda en dias del periodo anterior ---->

$inventario_bodega=array("5","10","4","10","40","35","10","25","34","12");	//Inventario en Bodega a la fecha

//<!--------------DUDA ESTA MERCANCIA POR LLEGAR ES LA DEL PERIODO $t que estoy revisando osea si la revision la hago el 4 de marzo, el debe buscar del 4 marzo al 4 de mayo lo que vaya a llegar --->
$mercancia_x_llegar=array("110","100","50","0","150","100","30","300","40","50");	//Mercancia por llegar durante el periodo t 

$inventario_actual=array();
for($b=0;$b<count($vector_productos);$b++){
	array_push($inventario_actual,number_format($inventario_bodega[$b]+$mercancia_x_llegar[$b]-($vector_demanda_dias[$b]*$Trevision),2));
}


//Paso 6: Calculo de SumIT: Inventario en transito durante L a partir del momento de la revisión: Ej: se hace la revisión el 4 de marzo y L es 3 meses 
//entonces todo lo que esta por llegar en esos 3 meses.


$sum_IT_duranteL=array("18","25","45","68","120","910","100","150","250","100");

//Paso 7: Calculo de M*: demanda en dias * (Tiempo de entrega del proveedor L+Tiempo de Revision T) Por que la demanda es en dias, si yo estoy dando el Tcapacidad en Meses.

$vector_M=array();
foreach($vector_demanda_dias as $clave){
	array_push($vector_M,number_format(($clave*($L+$Trevision)),2));
}

//Paso 8: Calculo de Qrequerida: M*-(Inventario_Actual+SumIT) (Esto se debe sumar con el inventario de seguridad solo para el primer caso?)

$vector_qrequerida=array();
for($c=0;$c<count($vector_productos);$c++){
	array_push($vector_qrequerida,number_format($vector_M[$c]-($inventario_actual[$c]+$sum_IT_duranteL[$c]),2));
}


//Paso 9: Valor a Solicitar de cada productos teniendo en cuenta "ojo mirar ojita del cuaderno, hay una inconsistencia en el excel del profesor
$vector_acomprar=array();

for($c=0;$c<count($vector_productos);$c++){
	if($vector_qrequerida[$c]<0){
		array_push($vector_acomprar,number_format(0));
	}else if($vector_qrequerida[$c]>0 and $vector_qrequerida[$c]>=$vector_cantidadminima[$c]){
		array_push($vector_acomprar,$vector_qrequerida[$c]);
	}else if($vector_qrequerida[$c]>0 and $vector_qrequerida[$c]<$vector_cantidadminima[$c]){
		array_push($vector_acomprar,$vector_cantidadminima[$c]);
	}
}


//Mostrando Información -------------------------------
?>
<table cellpadding="0" cellspacing="0" border="1">
	<tr>
		<td>Producto</td><td>Cantidad Minima</td><td>Demanda estimada</td><td>Demanda en Dias</td><td>Inventario Actual</td><td>Inventario Transito (L)</td><td>M*</td><td>Cant. Requerida</td><td>Cant. Comprar</td>
	</tr>
<?php
for($a=0;$a<count($vector_productos);$a++){
?>
	<tr>
		<td><?php echo $vector_productos[$a]; ?></td>
		<td><?php echo $vector_cantidadminima[$a]; ?></td>
		<td><?php echo $vector_demanda[$a]; ?></td>
		<td><?php echo $vector_demanda_dias[$a]; ?></td>
		<td><?php echo $inventario_actual[$a]; ?></td>
		<td><?php echo $sum_IT_duranteL[$a]; ?></td>
		<td><?php echo $vector_M[$a]; ?></td>
		<td><?php echo $vector_qrequerida[$a]; ?></td>
		<td><?php echo $vector_acomprar[$a]; ?></td>
	</tr>
<?php
}
?>
</table>
