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
	opener.location.href = "../acceso.php?com_pg=9";
    window.close();
}

$(document).ready(function(){
	$(':checkbox[readonly=readonly]').click(function(){
		return false;         
	}); 
}); 

function array_unique(array){
  return array.filter(function(elm, i, array){
      return (array.indexOf(elm, i + 1) < 0);
    });
}

String.prototype.trim = function() { return this.replace(/^\s+|\s+$/g, ""); };

function revverificar(RFID,id_us,nomus,ttotales){
	/*var xmlhttp;
	var codigorecibido = new Array();
	var objeto = new Array();
	var t=0;
	xmlhttp=new XMLHttpRequest();
	xmlhttp.open('GET', "http://127.0.0.1/comertexv_2/log2.txt", false);
	xmlhttp.send();
	xmlhttp.responseText.replace('\n');
	xmlhttp.responseText.split('\n').map(function (i) {
	//alert("esto es"+i);
		if(i!=""){
			var str=i;
			
			var n=str.replace('\n',"");
			var q=n.replace(/^\s+|\s+$/g,'');
			var e=q.replace(/\"/g,"");
			if(e!=""){
			//alert("esto es:"+e);
				var number=parseInt(e, 16);
				objeto[t]=number;
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
 	//var codigorecibido=new Array("993","994");
	//Obteniendo Fecha -----------------------------------------//
	var myDate = new Date();
	var myDate_string = myDate.toISOString();
	var myDate_string = myDate_string.replace("T"," ");
	var myDate_string = myDate_string.substring(0, myDate_string.length - 5);
	
	for(var x in codnoverificados){
		/*for(var y in codigorecibido){
			if(codnoverificados[x]==codigorecibido[y]){*/
				q=Number(x)+1;
				document.getElementById('co'+q).checked=true;
				document.getElementById('ck'+q).value=nomus;
				document.getElementById('cp'+q).value=id_us;
				document.getElementById('cj'+q).value=myDate_string;
		/*	}
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
	$noorden="";
	$fechasolicitud=gmdate("Y-m-d");
	$fechacierre="";
	$provdireccion="";
	$totalsiniva=0;
	$totaliva=0;
	$totalconiva=0;
	$usercreo="";
	$userid="";
	$estado="";
	$estadoid="";
	
	$d=0;
	$id='';
	if(!empty($_GET['orden'])){
		
				// Busqueda del proveedor
				$id=$_GET['orden'];
				$buscar=mysql_query("SELECT com_ordencompra.*,CONCAT_WS(' ',com_usconect.nombre,com_usconect.apellidos) as creado,com_estadooc.nombre FROM com_ordencompra 
LEFT JOIN com_usconect ON com_usconect.Id=com_ordencompra.usuario_id
LEFT JOIN com_estadooc ON com_estadooc.Id=com_ordencompra.estado_id WHERE com_ordencompra.Id='$id'",$conexion);

				while($resultado=mysql_fetch_assoc($buscar)){
					$noorden=$resultado['noorden'];
					$fechasolicitud=$resultado['fechasolicitud'];
					$fechacierre=($resultado['fecharecibido']!='0000-00-00')? $resultado['fecharecibido']:gmdate('Y-m-d');
					$provdireccion=$resultado['direccionproveedor_id'];
					$totalsiniva=$resultado['totalantesiva'];
					$totaliva=$resultado['totaliva'];
					$totalconiva=$resultado['totalconiva'];
					$userid=$resultado['usuario_id'];
					$estadoid=$resultado['estado_id'];
					$usercreo=$resultado['creado'];
					$estado=$resultado['nombre'];
				}
				
				
							
				//Orden de Compra e Estado de Revision o con productos pendientes ----------------------
				if($estadoid<5){
					echo "<script lenguaje=\"JavaScript\">setTimeout('Cerrar()',3000);</script>";
					die('La orden de Compra no ha sido Revisada, hasta que el procedimiento de revision no se realice no es posible Verificar Productos');						
				}
				
				//Busqueda de los producto asociados a una orden de compra existente
				$bproductos=mysql_query("SELECT com_inventario.*,com_productos.nombre as producto, com_productos.codbarras,com_productosorden.fecharecibido,
CONCAT_WS(' ',com_usconect.nombre,com_usconect.apellidos) as verificador,com_unidades.nombre as unidad,com_movimientosproductos.Id as existe FROM com_inventario
LEFT JOIN com_productos ON com_productos.Id=com_inventario.producto_id
LEFT JOIN com_productosorden ON com_productosorden.Id=com_inventario.lineaoc_id
LEFT JOIN com_usconect ON com_usconect.Id=com_inventario.verificado_id
LEFT JOIN com_unidades ON com_unidades.Id=com_productos.unidadproducto_id
LEFT JOIN com_movimientosproductos ON com_movimientosproductos.inventario_id=com_inventario.Id
WHERE com_productosorden.orden_id='$id' and com_inventario.estado!='0'",$conexion);

			while($resultado=mysql_fetch_assoc($bproductos)){
			//echo $resultado['RFID'];
					array_push($arrid,$resultado['Id']);				//Id de la linea de inventario
					array_push($arra,$resultado['fechaverificado']);		//Id del producto
					array_push($arrb,$resultado['RFID']);				//Codigo RFID
					array_push($arrc,$resultado['cantidad']);			//Cantidad Actual del Rollo
					array_push($arrd,$resultado['estado']);				//Estado Actual
					array_push($arre,$resultado['lineaoc_id']);			//Linea de la Orden Compra
					array_push($arrf,$resultado['cantidad_entrada']);	//Cantidad de Entrada
					array_push($arrg,$resultado['verificado_id']);		//Id del usuario que realiza la verificacion en proceso
					array_push($arrh,$resultado['producto']);			//producto 
					array_push($arri,$resultado['codbarras']);			//codigo de barras
					array_push($arrj,$resultado['unidad']);		//Fecha enl a que se recibio la Orden de Compra
					array_push($arrk,$resultado['verificador']);		//Nombre del usuario que realiza la verificacion
					array_push($arrl,$resultado['existe']);		//Existencia del movimiento de producto apra no volver a ingresar
					$RFIDS.=$resultado['RFID'].",";
			}
			$RFIDS=substr($RFIDS,0,-1);		//Retira la ultima coma de rfids
	}
	
	
	$tpwindow="Verificar ";	
	$productostt=count($arrid);
	
?>

<div id="contenidof2">
    	<h2> >> <?php echo $tpwindow; ?> Orden de Compra</h2>
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
					
					$est1='c'.$b;		//nombre del producto
					$est2='d'.$b;		//unidad del producto
					$est3='l'.$b;		//numero linea de Inventario	---------------SI
					$est4='j'.$b;		//fechaverificado			-------------------SI
					$est5='m'.$b;		//RFID
					$est6='n'.$b;		//cantidad de entrada		-------------------SI
					$est7='o'.$b;		//estado actual				-------------------SI
					$est8='p'.$b;		//verificador_id			-------------------SI
					$est9='q'.$b;		//numero de la linea OC		-------------------SI
					$est10='r'.$b;		//numero linea en movimiento ------------------SI
					
					$vector1[$b]=$_POST[$est3];		//numero linea de Inventario
					$vector2[$b]=$_POST[$est4];		//fechaverificado	
					$vector3[$b]=$_POST[$est6];		//cantidad de entrada
					$vector4[$b]=(!empty($_POST[$est7]))? $_POST[$est7]:'';		//estado actual	
					$vector5[$b]=$_POST[$est8];		//verificador_id
					$vector6[$b]=$_POST[$est9];		//linea OC
					$vector7[$b]=$_POST[$est10];	//Movimiento Existente
						
					if(empty($_POST[$est7]) || $_POST[$est7]!='2'){
						$vector1[$b]="";		//numero linea de Inventario
						$vector2[$b]="";		//fechaverificado	
						$vector3[$b]="";		//cantidad de entrada
						$vector4[$b]="";		//estado actual	
						$vector5[$b]="";		//verificador_id
						$vector6[$b]="";		//linea OC
						$vector7[$b]="";	//Movimiento Existente
						$noverificadas+=1;
					}
					
					
				}
				
									
				$error = 0; //variable para detectar error
				mysql_query("BEGIN"); // Inicio de Transacción
				
				
/*ACTUALIZA ORDEN DE COMPRA ---------------- ---------------------------------------------------------------------------------------------------------------------*/
				
				if($noverificadas==0){
					$insertar=mysql_query("UPDATE com_ordencompra SET fecharecibido='$v2',estado_id='7' WHERE Id=$id");
					if(!$insertar)
					$error=1;
					
					$insertar=mysql_query("UPDATE com_productosorden SET estado_id='7' WHERE orden_id='$id' ");
					if(!$insertar)
					$error=1;
					
				}else{
					$insertar=mysql_query("UPDATE com_ordencompra SET fecharecibido='$v2',estado_id='6' WHERE Id=$id");
					if(!$insertar)
					$error=1;
				}
				

//ACTUALIZA DATOS EN COM_INVENTARIO Y CAMBIA ESTADO DE LA LINEA DE ORDEN DE COMPRA----------------------------------------------------------------------------//				 
				for($b=1;$b<=$cuantos;$b++){ 
					if($vector4[$b]=='2'){
						
						
						$insertar=mysql_query("UPDATE com_inventario SET estado='$vector4[$b]',verificado_id='$vector5[$b]',fechaverificado='$vector2[$b]' WHERE Id='$vector1[$b]'");
						if(!$insertar){
							$error=1;
						}
					
						$insertar=mysql_query("UPDATE com_productosorden SET estado_id='6' WHERE Id='$vector6[$b]' ");
						if(!$insertar)
						$error=1;
					
					
					}
				
				
/*INGRESA EL MOVIMIENTO A PRODUCTOS SI NO EXISTE AQUI TOCA CORREGIR DESPUES------------------------------------------------------------------*/
			
					/*if($vector7[$b]=='' && $vector4[$b]=='2'){
						inventario(1,$vector1[$b],$hoy,$vector3[$b],0,$iduser,$vector6[$b]);
					}*/
				
				}
				

/*REVISANDO ERRORES EN MYSQL --------------------------------------------------------------------------------------------------------------------------------------*/
				
				if($error==1) {
					mysql_query("ROLLBACK");
					echo "No se pudieron realizar los cambios";
				} else {
					mysql_query("COMMIT");
					echo "Verificación Guardada con éxito";
					
					//Limpiando archivo log2.txt
					/*$fn_2 = "../log2.txt";
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
                    	<td width="90">No de Orden:</td>
                        <td width="149"><span id="sprytextfield1">
                          		<input type="text" name="noorden" id="noorden" readonly="readonly" value="<?php echo $noorden; ?>" />
                          		<span class="textfieldRequiredMsg">*</span></span>
                        </td>
                        <td width="6">&nbsp;</td>
                        <td width="90">Fecha Solicitud</td>
                        <td width="261"><span id="sprytextfield2">
                          	<input type="date" name="fsolicitud" id="fsolicitud" value="<?php echo $fechasolicitud; ?>" readonly="readonly"/>
                          	<span class="textfieldRequiredMsg">*</span></span>
                        </td>
                        <td><input type="button" onclick="revverificar('<?php echo $RFIDS; ?>','<?php echo $iduser; ?>','<?php echo $user; ?>',<?php echo $productostt; ?>)" name="btn1" id="btn1" value="Escanear" /></td>
                  </tr>
                  <tr>
                   		<td>Fecha Recibido</td>
                        <td><input type="date" name="frecibido" id="frecibido" readonly="readonly" value="<?php echo $fechacierre; ?>"/></td>
                         <td>&nbsp;</td>
                         <td colspan="3">Proveedor / Direccion:
                       	   <span id="spryselect2">
                         	<label for="direccion"></label>
                         	<select name="direccion" id="direccion" disabled="disabled">
                            	<?php
									if($id==''){
										opdireccionproveedor($conexion);
									}else{
										opdireccionproveedorsel($conexion,$provdireccion);	
									}
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
                        <input type="hidden" class="clsAnchoTotal"  name="l<?php echo $d; ?>" id="cl<?php echo $d; ?>" size="5" value="<?php echo $arrid[$c]; ?>" /><!--Id de la linea en inventario-->           <input type="hidden" class="clsAnchoTotal"  name="q<?php echo $d; ?>" id="cq<?php echo $d; ?>" size="5" value="<?php echo $arre[$c]; ?>" /><!--Id de la linea en productosorden-->         
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
                     <td align="right"><input type="checkbox" name="o<?php echo $d; ?>" id="co<?php echo $d; ?>" <?php echo ($arrd[$c]!='2')? "":"checked"; ?> value="2" readonly="readonly"/>  </td>
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
</script>
<script type="text/javascript" src="js/manipulacion2.js"></script>
</body>
</html>