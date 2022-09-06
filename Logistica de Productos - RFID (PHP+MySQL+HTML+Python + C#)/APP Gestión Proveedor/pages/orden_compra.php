<?php
	//Trae categorias
	$data1=PV_001("prov_producto.Id,CONCAT(prov_nombres.nombre,' ',prov_producto.codbarras) as nombre ","prov_producto LEFT JOIN prov_nombres ON prov_nombres.Id=prov_producto.nombre");
	$data1=explode(";;",$data1);
	
	
	$KoolControlsFolder="pages/KoolControls";
	require $KoolControlsFolder."/KoolAjax/koolajax.php";
	$koolajax->scriptFolder = $KoolControlsFolder."/KoolAjax";
 
	require $KoolControlsFolder."/KoolGrid/koolgrid.php";
	require $KoolControlsFolder."/KoolCalendar/koolcalendar.php";
	$ds = new MySQLDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
	$ds->SelectCommand = "select * from prov_movimientoproducto WHERE tipo='2' ORDER BY fecha DESC";
 	$ds->UpdateCommand = "update prov_movimientoproducto set estado_id='@estado_id' where Id=@Id";
	$ds->DeleteCommand = "delete from prov_movimientoproducto where Id=@Id";
	$ds->InsertCommand = "insert into prov_movimientoproducto (producto_id,tipo,cantidad,RFID,estado_id) values ('@producto_id','2','1','@RFID','3');";
	
	
	$grid = new KoolGrid("grid");
	$grid->scriptFolder = $KoolControlsFolder."/KoolGrid";
	$grid->styleFolder="office2010blue";
	$grid->MasterTable->DataSource = $ds;
	$grid->MasterTable->DataKeyNames = "Id"; // Need to set to get selection.
	$grid->Width = "1100px";
 	$grid->AllowInserting = true;
	$grid->AllowSelecting = true;// Allow row selecting
	$grid->AllowFiltering = true;
	$grid->AllowEditing = true;
	$grid->AllowDeleting = true;
 	$grid->AjaxEnabled = true;
	$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
	//$grid->AutoGenerateColumns = true;
	
	$column = new GridBoundColumn();
	$column->DataField = "Id";
	$column->ReadOnly = true;
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridDropDownColumn();
	$column->DataField = "producto_id";
	$column->HeaderText = "Producto";
	for($a=0;$a<count($data1);$a++){
		$datalinea=explode("::",$data1[$a]);
		$column->AddItem($datalinea[1],$datalinea[0]);
	}
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridDropDownColumn();
	$column->DataField = "tipo";
	$column->HeaderText = "Tipo Movimiento";
	$column->AddItem("Salida","1");
	$column->AddItem("Entrada","2");
	$column->ReadOnly = true;
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridNumberColumn();
	$column->DataField = "cantidad";
	$column->HeaderText = "Cantidad";
	$column->DefaultValue = "1";
	$grid->MasterTable->AddColumn($column);
		
	//Para agregar campos fechas
	$column = new GridDateTimeColumn();
	$column->DataField = "fecha";
	$column->HeaderText = "Fecha Ingreso";
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
	$column->DataField = "fecha2";
	$column->HeaderText = "Fecha Salida";
	$column->ReadOnly = true;
	$column->FormatString = "Y-m-d";
	//Assign datepicker for GridDateTimeColumn, this is optional.
	$column->Picker = new KoolDatePicker();
	$column->Picker->scriptFolder = $KoolControlsFolder."/KoolCalendar";
	$column->Picker->styleFolder = "default";	
	$column->Picker->DateFormat = "Y-m-d";
	$grid->MasterTable->AddColumn($column);
	
		
	$column = new GridBoundColumn();
	$column->DataField = "RFID";
	$column->HeaderText = "RFID";
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
	$grid->ClientSettings->ClientEvents["OnConfirmInsert"] = "Handle_OnStartInsert";
	$grid->Process();
	
	//Get selected keys after grid processing
	$selected_keys = $grid->GetInstanceMasterTable()->SelectedKeys;

?>
<form id="form1" method="post">
	<?php echo $koolajax->Render();?>
	<div style="padding:10px 0px 2px 10px;margin-top:10px">
    <script type="text/javascript">
		//These event handles function must be put before $grid->Render() function
		function Handle_OnStartInsert(sender,args)
		{
			var _row = args["TableView"];

			//Aqui debe entrar el codigo que saca la etiqueta
				/*$.ajax({
					type: "POST",
					url:"pages/imprimir_etiqueta.php",
					data:{"codigo": "1"},
					success: function(data){
						alert(data);
					}
				});*/
		}
		
	</script>	
  	<?php echo $grid->Render();?>
    </div>
</form>


	