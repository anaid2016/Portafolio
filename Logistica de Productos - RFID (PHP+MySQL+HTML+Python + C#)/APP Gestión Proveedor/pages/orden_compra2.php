<?php	
    $KoolControlsFolder="pages/KoolControls";
	require $KoolControlsFolder."/KoolAjax/koolajax.php";
	$koolajax->scriptFolder = $KoolControlsFolder."/KoolAjax";
 
	require $KoolControlsFolder."/KoolGrid/koolgrid.php";
	require $KoolControlsFolder."/KoolCalendar/koolcalendar.php";
	$ds = new MySQLDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
	$ds->SelectCommand = "select Id,numberorden,totalorden,estado_id,fechacreada,fechallegada,proveedor from view_ordencompra";
 	$ds->UpdateCommand = "update pv_ordencompra set estado_id='@estado_id' where Id=@Id";
	$ds->DeleteCommand = "delete from pv_ordencompra where Id=@Id";
	$ds->InsertCommand = "insert into pv_ordencompra (estado_id,proveedor_id) values ('@estado_id','1');";
	
	
	$grid = new KoolGrid("grid");
	$grid->scriptFolder = $KoolControlsFolder."/KoolGrid";
	$grid->styleFolder="office2010blue";
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
	$column->DataField = "numberorden";
	$column->HeaderText = "Orden Compra";
	$column->ReadOnly = true;
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridBoundColumn();
	$column->DataField = "totalorden";
	$column->HeaderText = "Total Orden";
	$column->ReadOnly = true;
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridDropDownColumn();
	$column->DataField = "estado_id";
	$column->HeaderText = "Estado";
	$column->AddItem("Ingreso","1");
	$column->AddItem("Pedido Realizado","2");
	$column->AddItem("Recibido","3");
	$column->AddItem("En Inventario","4");
	$grid->MasterTable->AddColumn($column);
	
	//Para agregar campos fechas
	$column = new GridDateTimeColumn();
	$column->DataField = "fechacreada";
	$column->HeaderText = "Pedido";
	$column->ReadOnly = true;
	$column->FormatString = "Y-m-d";
	//Assign datepicker for GridDateTimeColumn, this is optional.
	$column->Picker = new KoolDatePicker();
	$column->Picker->scriptFolder = $KoolControlsFolder."/KoolCalendar";
	$column->Picker->styleFolder = "default";	
	$column->Picker->DateFormat = "Y-m-d";
	$grid->MasterTable->AddColumn($column);
	
	//Para agregar campos fechas
	$column = new GridDateTimeColumn();
	$column->DataField = "fechallegada";
	$column->HeaderText = "Fecha Llegada";
	$column->ReadOnly = true;
	$column->FormatString = "Y-m-d";
	//Assign datepicker for GridDateTimeColumn, this is optional.
	$column->Picker = new KoolDatePicker();
	$column->Picker->scriptFolder = $KoolControlsFolder."/KoolCalendar";
	$column->Picker->styleFolder = "default";	
	$column->Picker->DateFormat = "Y-m-d";
	$grid->MasterTable->AddColumn($column);
		
	$column = new GridBoundColumn();
	$column->DataField = "proveedor";
	$column->HeaderText = "Proveedor";
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
			if (sizeof($selected_keys)>0 and !empty($selected_keys))
			{
				$_SESSION['ordenc']=$selected_keys[0]['Id'];
			}
			
		?>			
	</div>	
</form>
<?php
			if(!empty($_SESSION['ordenc'])){
					
				

			}
			
?>