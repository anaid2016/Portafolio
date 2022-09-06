<?php
	//Trae categorias
	$data1=PV_001("Id,nombre","prov_categorias");
	$data1=explode(";;",$data1);
	
	$data2=PV_001("Id,nombre","prov_producto");
	$data2=explode(";;",$data2);
	
	$KoolControlsFolder="pages/KoolControls";
	require $KoolControlsFolder."/KoolAjax/koolajax.php";
	$koolajax->scriptFolder = $KoolControlsFolder."/KoolAjax";
 
	require $KoolControlsFolder."/KoolGrid/koolgrid.php";
	require $KoolControlsFolder."/KoolCalendar/koolcalendar.php";
	$ds = new MySQLDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
	$ds->SelectCommand = "select Id,numeroorden,estado_id,'Bodega' as Proveedor from prov_ordenventa";
 	$ds->UpdateCommand = "update prov_ordenventa set estado_id='@estado_id' where Id=@Id";
	$ds->DeleteCommand = "delete from prov_ordenventa where Id=@Id";
	$ds->InsertCommand = "insert into prov_ordenventa (estado_id) values ('1');";
	
	
	$grid = new KoolGrid("grid");
	$grid->scriptFolder = $KoolControlsFolder."/KoolGrid";
	$grid->styleFolder="redbrown";
	$grid->MasterTable->DataSource = $ds;
	$grid->MasterTable->DataKeyNames = "Id"; // Need to set to get selection.
	$grid->Width = "655px";
 	$grid->AllowInserting = true;
	$grid->AllowSelecting = true;// Allow row selecting
	$grid->AllowEditing = true;
	$grid->AllowDeleting = true;
 	$grid->AjaxEnabled = true;
	$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
	//$grid->AutoGenerateColumns = true;
	
	$column = new GridBoundColumn();
	$column->DataField = "Id";
	$column->ReadOnly = true;
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridBoundColumn();
	$column->DataField = "numeroorden";
	$column->HeaderText = "Orden Venta";
	$column->ReadOnly = true;
	$grid->MasterTable->AddColumn($column);
	
	/*$column = new GridBoundColumn();
	$column->DataField = "totalorden";
	$column->HeaderText = "Total Orden";
	$column->ReadOnly = true;
	$grid->MasterTable->AddColumn($column);*/
	
	$column = new GridDropDownColumn();
	$column->DataField = "estado_id";
	$column->HeaderText = "Estado";
	$column->AddItem("Solicitud","1");
	$column->AddItem("Enviada","2");
	$grid->MasterTable->AddColumn($column);
	
	//Para agregar campos fechas
	/*$column = new GridDateTimeColumn();
	$column->DataField = "fechasalida";
	$column->HeaderText = "Fecha Envio";
	$column->ReadOnly = true;
	$column->FormatString = "Y-m-d";
	//Assign datepicker for GridDateTimeColumn, this is optional.
	$column->Picker = new KoolDatePicker();
	$column->Picker->scriptFolder = $KoolControlsFolder."/KoolCalendar";
	$column->Picker->styleFolder = "default";	
	$column->Picker->DateFormat = "Y-m-d";
	$grid->MasterTable->AddColumn($column);*/
	
		
	$column = new GridBoundColumn();
	$column->DataField = "Proveedor";
	$column->HeaderText = "Cliente";
	$column->ReadOnly = true;
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridEditDeleteColumn();
	$column->Align = "center";
	$grid->MasterTable->AddColumn($column);
	
	
	$grid->MasterTable->EditSettings->Mode = "Inline";//"Inline" is default value;
	
	//Show Function Panel
	$grid->MasterTable->ShowFunctionPanel = true;
	//Insert Settings
	$grid->MasterTable->InsertSettings->Mode = "Form";
	$grid->MasterTable->InsertSettings->ColumnNumber = 2;
	$grid->Process();
	
	//Get selected keys after grid processing
	$selected_keys = $grid->GetInstanceMasterTable()->SelectedKeys;

?>
<form id="form1" method="post">
	<?php echo $koolajax->Render();?>
	<?php echo $grid->Render();?>
	
    <!-- modal content -->
	<div style="padding-top:10px;">
		<input type="submit" value = "Submit" />
	</div>
	<div style="padding-top:10px;">
		<?php
			if (sizeof($selected_keys)>0)
			{
				$_SESSION['ordenc']=$selected_keys[0]['Id'];
			}
			
		?>			
	</div>	
</form>
<?php
			if(!empty($_SESSION['ordenc'])){
				
				
				//Visualizacion del Pedido Solicitado
				
				
			
				$ds3 = new MySQLDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
				$ds3->SelectCommand = "SELECT prov_productosorden2.Id,prov_productosorden2.producto_id,prov_productosorden2.cantidad,prov_unidades.nombre as unidad,(cantidad*precio_venta) as precio from prov_productosorden2
LEFT JOIN prov_producto on prov_producto.Id=prov_productosorden2.producto_id
LEFT JOIN prov_unidades ON prov_unidades.Id=prov_producto.unidad_id
where ordenventa_id=".$_SESSION['ordenc'];
				$ds3->UpdateCommand = "update prov_productosorden2 set producto_id='@producto_id',cantidad='@cantidad' where Id=@Id";
				$ds3->DeleteCommand = "delete from prov_productosorden2 where Id=@Id";
				$ds3->InsertCommand = "insert into prov_productosorden2 (producto_id,cantidad,ordenventa_id) values ('@producto_id','@cantidad','".$_SESSION['ordenc']."')";
			
				$grid3 = new KoolGrid("grid3");
				$grid3->scriptFolder = $KoolControlsFolder."/KoolGrid";
				$grid3->styleFolder = "redbrown";
			
				$grid3->AjaxEnabled = true;
				$grid3->DataSource = $ds3;
				$grid3->MasterTable->Pager = new GridPrevNextAndNumericPager();
				$grid3->Width = "900px";
				$grid3->ColumnWrap = true;
				$grid3->AllowInserting = true;
				$grid3->AllowEditing = true;
				$grid3->AllowDeleting = true;
				
				
				$column = new GridBoundColumn();
				$column->DataField = "Id";
				$column->ReadOnly = true;
				$grid3->MasterTable->AddColumn($column);
				
										
				$column = new GridDropDownColumn();
				$column->DataField = "producto_id";
				$column->HeaderText = "Producto";
				for($a=0;$a<count($data2);$a++){
					$datalinea=explode("::",$data2[$a]);
					$column->AddItem($datalinea[1],$datalinea[0]);
				}
				$grid3->MasterTable->AddColumn($column);
				
				
				$column = new GridNumberColumn();
				$column->DecimalNumber = 2;
				$column->ThousandSeperate = ",";
				$column->DataField = "cantidad";
				$column->HeaderText = "Cantidad";
				$grid3->MasterTable->AddColumn($column);
				
				$column = new GridBoundColumn();
				$column->DataField = "unidad";
				$column->HeaderText = "Unidad";
				$column->ReadOnly = true;
				$grid3->MasterTable->AddColumn($column);
				
				
				$column = new GridNumberColumn();
				$column->DecimalNumber = 2;
				$column->ThousandSeperate = ",";
				$column->DataField = "precio";
				$column->HeaderText = "Precio";
				$column->ReadOnly = true;
				$grid3->MasterTable->AddColumn($column);
				
				
				$column = new GridEditDeleteColumn();
				$column->Align = "center";
				$grid3->MasterTable->AddColumn($column);
				$grid3->MasterTable->EditSettings->Mode = "Inline";//"Inline" is default value;
				
				//Show Function Panel
				$grid3->MasterTable->ShowFunctionPanel = true;
				//Insert Settings
				$grid3->MasterTable->InsertSettings->Mode = "Form";
				$grid3->MasterTable->InsertSettings->ColumnNumber = 2;
				
				$grid3->Process();
				
			
			
			
			
				
				
				//Visualizacion de los productos en Movimientos Productos=============================================================//
				
				/*$ds2 = new MySQLDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
				$ds2->SelectCommand = "SELECT pv_movimientoproducto.Id,pv_movimientoproducto.producto_id,pv_movimientoproducto.RFID,pv_movimientoproducto.cantidad,pv_unidades.nombre as unidad,pv_movimientoproducto.estado_id,pv_movimientoproducto.preciolinea,pv_producto.codbarras from pv_movimientoproducto
LEFT JOIN pv_ordencompra ON pv_ordencompra.Id=pv_movimientoproducto.ordenc_id
LEFT JOIN pv_producto ON pv_producto.Id=pv_movimientoproducto.producto_id
LEFT JOIN pv_unidades ON pv_producto.unidad_id=pv_unidades.Id
WHERE ordenc_id=".$_SESSION['ordenc'];
				$ds2->UpdateCommand = "update pv_movimientoproducto set producto_id='@producto_id',RFID='@RFID',cantidad='@cantidad',tipo_ord='1',estado_id='@estado_id' where Id=@Id";
				$ds2->DeleteCommand = "delete from pv_movimientoproducto where Id=@Id";
				$ds2->InsertCommand = "insert into pv_movimientoproducto (producto_id,cantidad,tipo_ord,usuario_id,ordenc_id,estado_id) values ('@producto_id','@cantidad','1','1','".$_SESSION['ordenc']."','1')";
 
				
				$grid2 = new KoolGrid("grid2");
				$grid2->scriptFolder = $KoolControlsFolder."/KoolGrid";
				$grid2->styleFolder = "office2010blue";
			
				$grid2->AjaxEnabled = true;
				$grid2->DataSource = $ds2;
				$grid2->MasterTable->Pager = new GridPrevNextAndNumericPager();
				$grid2->Width = "900px";
				$grid2->ColumnWrap = true;
				$grid2->AllowInserting = true;
				$grid2->AllowEditing = true;
				$grid2->AllowDeleting = true;
				
				
				$column = new GridBoundColumn();
				$column->DataField = "Id";
				$column->ReadOnly = true;
				$grid2->MasterTable->AddColumn($column);
				
				$column = new GridBoundColumn();
				$column->DataField = "codbarras";
				$column->HeaderText = "Codbarras";
				$column->ReadOnly = true;
				$grid2->MasterTable->AddColumn($column);
							
				$column = new GridDropDownColumn();
				$column->DataField = "producto_id";
				$column->HeaderText = "Producto";
				for($a=0;$a<count($data2);$a++){
					$datalinea=explode("::",$data2[$a]);
					$column->AddItem($datalinea[1],$datalinea[0]);
				}
				$grid2->MasterTable->AddColumn($column);
				
				$column = new GridBoundColumn();
				$column->DataField = "RFID";
				$column->HeaderText = "RFID";
				$column->ReadOnly = true;
				$grid2->MasterTable->AddColumn($column);
				
				$column = new GridNumberColumn();
				$column->DecimalNumber = 2;
				$column->ThousandSeperate = ",";
				$column->DataField = "cantidad";
				$column->HeaderText = "Cantidad";
				$grid2->MasterTable->AddColumn($column);
				
				$column = new GridBoundColumn();
				$column->DataField = "unidad";
				$column->HeaderText = "Unidad";
				$column->ReadOnly = true;
				$grid2->MasterTable->AddColumn($column);
				
				
				$column = new GridNumberColumn();
				$column->DecimalNumber = 2;
				$column->ThousandSeperate = ",";
				$column->DataField = "preciolinea";
				$column->HeaderText = "Precio";
				$column->ReadOnly = true;
				$grid2->MasterTable->AddColumn($column);
				
				$column = new GridDropDownColumn();
				$column->DataField = "estado_id";
				$column->HeaderText = "Estado";
				$column->AddItem("Ingreso","1");
				$column->AddItem("Recibido","2");
				$column->AddItem("En Inventario","3");
				$grid2->MasterTable->AddColumn($column);
				
				$column = new GridEditDeleteColumn();
				$column->Align = "center";
				$grid2->MasterTable->AddColumn($column);
				$grid2->MasterTable->EditSettings->Mode = "Inline";//"Inline" is default value;
				
				//Show Function Panel
				$grid2->MasterTable->ShowFunctionPanel = true;
				//Insert Settings
				$grid2->MasterTable->InsertSettings->Mode = "Form";
				$grid2->MasterTable->InsertSettings->ColumnNumber = 2;
				
				$grid2->Process();*/
				?>				
							
		<?php		
				//echo "You select row with <b>customerNumber = ".$selected_keys[0]["Id"]."</b>";
			}
		?>

<?php
 if(!empty($grid3)){
?>
	<p>Pedido Solicitado al Proveedor</p>
    <form id="form1" method="post">
		<?php echo $koolajax->Render();?>
		<?php echo $grid3->Render();?>
	</form>	
   

	<!--<p>Pedido Recibido del Proveedor</p>
	<form id="form1" method="post">
		<?php //echo $koolajax->Render();?>
		<?php //echo $grid2->Render();?>
	</form>	-->


<?php
 }
?>


	