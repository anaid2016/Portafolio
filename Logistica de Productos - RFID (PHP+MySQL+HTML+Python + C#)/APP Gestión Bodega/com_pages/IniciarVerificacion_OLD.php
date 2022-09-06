<?php include("../funciones/seguridad.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Agregar Orden de Compra</title>
<link rel="stylesheet" type="text/css" href="../css/popupcss.css"/>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script> 
 function Cerrar(){
	opener.location.href = "../acceso.php?com_pg=8";
    window.close();
}

$(document).ready(function(){
	$(':checkbox[readonly=readonly]').click(function(){
		return false;         
	}); 
}); 

//Funciones de trim---
function array_unique(array){
  return array.filter(function(elm, i, array){
      return (array.indexOf(elm, i + 1) < 0);
    });
}

String.prototype.trim = function() { return this.replace(/^\s+|\s+$/g, ""); };

/*Recordar que esta funcion esta comentariada*/
function revverificar(RFID,id_us,nomus,ttotales){
	//Buscar productos en log2.txt
	/*var xmlhttp;
	var codigorecibido = new Array();
	var objeto = new Array();
	var t=0;
	xmlhttp=new XMLHttpRequest();
	xmlhttp.open('GET', "http://127.0.0.1/comertexv_2/log4.txt", false);
	xmlhttp.send();
	xmlhttp.responseText.replace('\n');
	xmlhttp.responseText.split('\n').map(function (i) {
		if(i!=""){
			var str=i;
			var n=str.replace('\n',"");
			var q=n.replace(/^\s+|\s+$/g,'');
			var e=q.replace(/\"/g,"");
			if(e!=""){
				var number=parseInt(e, 16);
				objeto[t]=number;
				//alert("que llega"+number);
				t=t+1;
			}
			//codigorecibido=array_unique(objeto);
			//var u=i.replace("\""," ");
			//var number=parseInt(u, 16);
			//codigorecibido[t]=number;
		}
	} );
	
	codigorecibido=array_unique(objeto);*/
	
	var codnoverificados=RFID.split(",");
 	//var codigorecibido=new Array("984");
	//Obteniendo Fecha -----------------------------------------//
	var myDate = new Date();
	var myDate_string = myDate.toISOString();
	var myDate_string = myDate_string.replace("T"," ");
	var myDate_string = myDate_string.substring(0, myDate_string.length - 5);
	
	for(var x in codnoverificados){
		/*for(var y in codigorecibido){
			if(codnoverificados[x]==codigorecibido[y]){*/
				q=Number(x)+1;
				//alert('Esto es'+q);
				document.getElementById('co'+q).checked=true;
				document.getElementById('ck'+q).value=nomus;
				document.getElementById('cp'+q).value=id_us;
				document.getElementById('cj'+q).value=myDate_string;
	/*		}
		}*/
	}
	
	var boton=document.getElementById('Guardar')
	if(q==ttotales){
		boton.disabled=false;
	}
	
 }

</script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
	$archivo="../funciones/datos.txt";
	include("../funciones/conexbd.php");
	include("../funciones/librerias.php");
	include("../funciones/seguridad.php");
	
	//Creación de Arrays 
	$arrid=array();
	$arra=array();
	$arrb=array();
	$arrc=array();
	$arrd=array();
	$arre=array();
	$arrf=array();
	$arrg=array();
	$arrh=array();
	$arri=array();
	$arrj=array();
	$arrk=array();
	$arrl=array();
	$RFIDS='';
	
	//Creacion de variables fijas
	$nopedido="";
	$fechapedido="";
	$direccion="";
	$totalsiniva="";
	$totaliva="";
	$totalconiva="";
	$responsable="";
	$estadoid="";
	$cliente="";
	
	$d=0;
	$id='';
	if(!empty($_GET['pedido'])){
		
				// Busqueda del proveedor
				$id=$_GET['pedido'];
				$buscar=mysql_query("SELECT com_pedidos.*,com_direccionclientes.direccion,com_ciudad.ciudad,
com_clientes.nombres,com_usconect.nombre as bodega,com_direccionclientes.Id as direccionc FROM com_pedidos
LEFT JOIN com_direccionclientes ON com_direccionclientes.Id=com_pedidos.direccioncliente_id
LEFT JOIN com_clientes ON com_clientes.Id=com_direccionclientes.cliente_id
LEFT JOIN com_ciudad ON com_direccionclientes.ciudad_id=com_ciudad.Id
LEFT JOIN com_usconect on com_usconect.Id=com_pedidos.userbodega_id
 WHERE com_pedidos.Id='$id'",$conexion);

				while($resultado=mysql_fetch_assoc($buscar)){
					$nopedido=$resultado['nopedido'];
					$fechapedido=$resultado['fechapedido'];
					$direccion=$resultado['direccionc'];
					$totalsiniva=$resultado['totalantesiva'];
					$totaliva=$resultado['totaliva'];
					$totalconiva=$resultado['totalconiva'];
					$responsable=$resultado['bodega'];
					$estadoid=$resultado['estado_id'];
				}
				
				
				
							
				//Orden de Compra e Estado de Revision o con productos pendientes ----------------------
				if($estadoid<7){
					echo "<script lenguaje=\"JavaScript\">setTimeout('Cerrar()',3000);</script>";
					die('El pedido no se encuentra Alistado, hasta que el procedimiento de Alistamiento no se realice no es posible Verificar Productos');						
				}
				
				//Busqueda de los producto asociados a un pedido existente
				$bproductos=mysql_query("SELECT com_inventario.Id as idinventario,com_productospedido.cantidadpedida,com_productos.nombre as producto, com_productos.codbarras,com_inventario.estado,
CONCAT_WS(' ',com_usconect.nombre,com_usconect.apellidos) as verificador,com_productospedido.Id as lineapedido,
com_unidades.nombre as unidad,com_inventario.RFID,com_inventario.fechasalida,com_usconect.Id as verificador_id,com_inventario.verificadosal_id FROM com_inventario
LEFT JOIN com_productos ON com_productos.Id=com_inventario.producto_id
LEFT JOIN com_productospedido ON com_productospedido.inventario_id=com_inventario.Id
LEFT JOIN com_usconect ON com_usconect.Id=com_inventario.verificadosal_id
LEFT JOIN com_unidades ON com_productos.unidadproducto_id=com_unidades.Id
WHERE com_productospedido.pedido_id='$id'",$conexion);

			while($resultado=mysql_fetch_assoc($bproductos)){
					array_push($arrid,$resultado['idinventario']);		//Id de la linea de inventario
					array_push($arra,$resultado['fechasalida']);		//Id del producto
					array_push($arrb,$resultado['RFID']);				//Codigo RFID
					array_push($arrc,$resultado['cantidadpedida']);		//Cantidad Actual del Rollo
					array_push($arrd,$resultado['estado']);				//2 - Verificada para venta, 3- Vendida
					array_push($arre,$resultado['lineapedido']);		//Linea del Pedido
					array_push($arrg,$resultado['verificadosal_id']);		//Id del usuario que realiza la verificacion en proceso
					array_push($arrh,$resultado['producto']);			//producto 
					array_push($arri,$resultado['codbarras']);			//codigo de barras
					array_push($arrj,$resultado['unidad']);				//Fecha enl a que se recibio la Orden de Compra
					array_push($arrk,$resultado['verificador']);		//Nombre del usuario que realiza la verificacion
					$RFIDS.=$resultado['RFID'].",";
			}
			$RFIDS=substr($RFIDS,0,-1);		//Retira la ultima coma de rfids
	}
	
	
	$tpwindow="Verificar ";	
	$productostt=count($arrid);
	
?>

<div id="contenidof2">
    	<h2> >> <?php echo $tpwindow; ?> Pedido</h2>
			<?php
			
			//Guardando Producto Creado -----------------------------------------------------------//
            if(!empty($_POST['Guardar'])){
				$noverificadas=0;
				$id=$_POST['Id'];
				$hoy=gmdate('Y-m-d');
				
				/*Datos Basicos de la Orden de Compra*/
				$v2=$_POST['frecibido'];
				$cuantos=$_POST['cuantos'];
				
				if(!empty($_POST['Id'])){
					$id=$_POST['Id'];
				}
				
				$vector1=array();
				$vector2=array();
				$vector3=array();
				$vector4=array();
				$vector5=array();
				$vector6=array();
				$vector7=array();
				$vector8=array();
				$vector9=array();
				$vector10=array();
				
				for($b=1;$b<=$cuantos;$b++){
					
					$est1='l'.$b;		//Id de la linea de inventario	-------------------SI
					$est2='q'.$b;		//I de la Linea de Productos Pedido	-------------------SI
					$est3='r'.$b;		//Id movimientos Producto		-------------------SI
					$est4='p'.$b;		//Id del verificador -------------------SI
					$est5='j'.$b;		//fecha de salid ------------------SI
					$est6='n'.$b;		//fecha de salid ------------------SI
					
					$vector1[$b]=$_POST[$est1];		
					$vector2[$b]=$_POST[$est2];			
					$vector3[$b]=$_POST[$est3];		
					$vector4[$b]=$_POST[$est4];			
					$vector5[$b]=$_POST[$est5];
					$vector6[$b]=$_POST[$est6];		
					
				}
				
									
				$error = 0; //variable para detectar error
				mysql_query("BEGIN"); // Inicio de Transacción
				
				
/*ACTUALIZA ORDEN DE COMPRA ---------------- ---------------------------------------------------------------------------------------------------------------------*/
				
		
			$insertar=mysql_query("UPDATE com_pedidos SET estado_id='5' WHERE Id=$id");
					if(!$insertar)
					$error=1;
					//echo "error 1:".$error;
					
			$insertar=mysql_query("UPDATE com_productospedido SET estado_id='5' WHERE pedido_id='$id' ");
					if(!$insertar)
					$error=1;
					//echo "error 2:".$error;
				

//ACTUALIZA DATOS EN COM_INVENTARIO Y CAMBIA ESTADO DE LA LINEA DE ORDEN DE COMPRA----------------------------------------------------------------------------//	
echo $cuantos;			 
				for($b=1;$b<=$cuantos;$b++){ 
					
						
						
						$insertar=mysql_query("UPDATE com_inventario SET estado='3',verificadosal_id='$vector4[$b]',fechasalida='$vector5[$b]' WHERE Id='$vector1[$b]'");
						
						if(!$insertar){
							$error=1;
						}
						//echo "error 3:".$error;
					
						$insertar=mysql_query("UPDATE com_productospedido SET estado_id='5' WHERE Id='$vector2[$b]' ");
						if(!$insertar)
						$error=1;
						//echo "error 4:".$error;
				
				
/*INGRESA EL MOVIMIENTO A PRODUCTOS SI NO EXISTE -----------------------------------------------------------------------------------------------------------------------------*/
			
						//inventario(2,$vector1[$b],$hoy,$vector6[$b],0,$iduser,$vector2[$b]);
						//echo "error 4:".$error;
				}
				

/*REVISANDO ERRORES EN MYSQL --------------------------------------------------------------------------------------------------------------------------------------*/
				
				if($error==1) {
					mysql_query("ROLLBACK");
					echo "No se pudieron realizar los cambios";
				} else {
					mysql_query("COMMIT");
					echo "Verificación Guardada con éxito";
					
					//Limpiando archivo log4.txt
					/*$fn_2 = "../log4.txt";
        			$fp2 = fopen($fn_2, "w");
					fwrite($fp2,"");
					fclose($fp2);*/
				}
				
				
				echo "<script lenguaje=\"JavaScript\">setTimeout('Cerrar()',2000);</script>"; 
			}else{
               

            ?>
            <p>Diligencie el formulario en su totalidad y de clic en Guardar:</p>
            
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="POST" class="other">
				<table width="1200" class="formulario">
					<tr>
                    	<td width="90">No de Pedido:</td>
                        <td width="149"><?php echo $nopedido; ?></td>
                        <td width="6">&nbsp;</td>
                        <td width="90">Fecha Solicitud</td>
                        <td width="261"><?php echo $fechapedido; ?></td>
                        <td><input type="button" onclick="revverificar('<?php echo $RFIDS; ?>','<?php echo $iduser; ?>','<?php echo $user; ?>',<?php echo $productostt; ?>)" name="btn1" id="btn1" value="Escanear" /></td>
                  </tr>
                  <tr>
                   		<td>Fecha Recibido</td>
                        <td><input type="date" name="frecibido" id="frecibido" readonly="readonly" value="<?php echo $fechacierre; ?>"/></td>
                         <td>&nbsp;</td>
                         <td colspan="3">Cliente / Direccion:
                       	   <span id="spryselect2">
                         	<label for="direccion"></label>
                         	<select name="direccion" id="direccion" disabled="disabled">
                            	<?php
									opdireccionclientesel($conexion,$direccion);	
								?>
                       	  	</select>
                       	 <span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
                   </tr>
                    <tr>
                   		<td colspan="5" align="right">&nbsp;</td>
                   </tr> 
                  
              </table>	
              
              <br/>
              <br/>
         <div class="datagrid">
              <table class="ventanapop" cellspacing="0" cellpadding="0" width="1450">
                <thead>
                <tr>
                  <th>Cod.</th>
                  <th>Producto</th>
                  <th>RFID</th>
                  <th>Cantidad </th>
                  <th>Und.</th>
                  <th>Verificador</th>
                  <th>Fecha</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
              	 <?php
			 			for($c=0;$c<count($arrid);$c++){
							$d=$c+1;
				?>
                	<tr id="linea<?php echo $d; ?>">
                      <td width="140">
                        <input type="hidden" class="clsAnchoTotal"  name="l<?php echo $d; ?>" id="cl<?php echo $d; ?>" size="5" value="<?php echo $arrid[$c]; ?>" /><!--Id de la linea en inventario-->           
                        <input type="hidden" class="clsAnchoTotal"  name="q<?php echo $d; ?>" id="cq<?php echo $d; ?>" size="5" value="<?php echo $arre[$c]; ?>" /><!--Id de la linea en productospedido-->         
                         <input type="hidden" class="clsAnchoTotal"  name="r<?php echo $d; ?>" id="cr<?php echo $d; ?>" size="5" value="<?php echo $arrl[$c]; ?>" /><!--Id de la linea en movimientos productos-->        
                        <input type="text" readonly="readonly" name="a<?php echo $d; ?>" id="cb<?php echo $d; ?>" size="10" value="<?php echo $arri[$c]; ?>" class="small"/><!--codigo de barras-->
                        <!--<input type="button" value="AP" onclick="ventana('<?php echo $d; ?>')"  style="display:inline" disabled="disabled" id="btnap<?php echo $d; ?>"  />-->
                      </td>
                      <td><input type="text" class="clsAnchoTotal"  readonly="readonly" name="c<?php echo $d; ?>"  id="cc<?php echo $d; ?>" value="<?php echo $arrh[$c]; ?>"/></td>
                      <td><input type="text" class="clsAnchoTotal"   name="m<?php echo $d; ?>"  id="cm<?php echo $d; ?>" value="<?php echo $arrb[$c]; ?>" readonly="readonly"/></td><!--RFID-->
                      <td><input type="text" class="clsAnchoTotal"   name="n<?php echo $d; ?>"  id="cn<?php echo $d; ?>" value="<?php echo $arrc[$c]; ?>" readonly="readonly"/></td><!--cantidad-->
                      <td><input type="text" class="clsAnchoTotal"   name="d<?php echo $d; ?>"  id="cd<?php echo $d; ?>" value="<?php echo $arrj[$c]; ?>" readonly="readonly"/></td><!--unidad-->
                      <td>
                      	<input type="text" class="clsAnchoTotal"   name="k<?php echo $d; ?>"  id="ck<?php echo $d; ?>" value="<?php echo $arrk[$c]; ?>" readonly="readonly"/><!--Verifico Nombre-->
                      	<input type="hidden" class="clsAnchoTotal"   name="p<?php echo $d; ?>"  id="cp<?php echo $d; ?>" value="<?php echo $arrg[$c]; ?>" readonly="readonly"/><!--Verifico Id ---->			 </td>
                     <td><input type="text" class="clsAnchoTotal"   name="j<?php echo $d; ?>"  id="cj<?php echo $d; ?>" value="<?php echo $arra[$c]; ?>" readonly="readonly"/></td><!--Fecha Recibido-->
                     <td align="right"><input type="checkbox" name="o<?php echo $d; ?>" id="co<?php echo $d; ?>" <?php echo ($arrd[$c]=='3' and empty($arrg[$c]))? "":"checked"; ?> value="2" readonly="readonly"/>  </td>
               		</tr>
      
                <?php
						}
						$nose=$d;
				?>	
                
                </tbody>
               <tfoot>
           		<tr>
						<td colspan="13" align="right">
							<?php
						    if(empty($_GET['view'])){
							?>
							<!--<input type="button" value="Agregar una fila" class="clsAgregarFila">-->
                            <input type="hidden" value="<?php echo $nose; ?>" name="cuantos" id="cuantos" />
							<input type="hidden" name="Id" id="Id" value="<?php echo $id; ?>"/>
                            <input type="submit" value="Enviar" name="Guardar" disabled="disabled" id="Guardar" />
							<?php
							}
							?>
						</td>
					</tr>
				</tfoot>
                </table>
            
           
           
       </div>  
       <br/>
       		<!--Totales de OC -->
           <table class="sinbordes" align="right" >
                            	<tr>
                                    <td>Total Base</td>
                                    <td><input type="text" value="<?php echo $totalsiniva; ?>" id="ttbase" readonly="readonly"/></td>
                                    <td>&nbsp;</td>
                                    <td>Total IVA</td>
                                    <td><input type="text" value="<?php echo $totaliva; ?>" id="ttiva" readonly="readonly"/></td>
                                    <td>&nbsp;</td>
                                    <td>Total Gravado</td>
                                    <td><input type="text" value="<?php echo $totalconiva; ?>" id="ttgravado" readonly="readonly"/></td>
                                </tr>
           </table>
       <br/>    
  </form>

  <?php
			}
			
			?>
</div>
<script type="text/javascript">
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
</script>
<script type="text/javascript" src="js/manipulacion2.js"></script>
</body>
</html>