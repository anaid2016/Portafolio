<?php

	//Trae categorias
	$data1=PV_001("Id,nombre","prov_producto");
	$data1=explode(";;",$data1);
	
	//Trae unidades
	$data2=PV_001("Id,nombre","prov_unidades");
	$data2=explode(";;",$data2);

	//Aqui iniciar el codigo de KoolPHP
	$KoolControlsFolder="pages/KoolControls";
	require $KoolControlsFolder."/KoolAjax/koolajax.php";
	$koolajax->scriptFolder = $KoolControlsFolder."/KoolAjax";

	require $KoolControlsFolder."/KoolGrid/koolgrid.php";
	require $KoolControlsFolder."/KoolCalendar/koolcalendar.php";
	
		
	$ds = new MySQLDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
	$ds->SelectCommand = "SELECT * from prov_movimientoproducto WHERE tipo='2' ";
	$ds->UpdateCommand = "update prov_movimientoproducto set producto_id='@producto_id',tipo='2',cantidad='@cantidad',RFID='@RFID' where Id=@Id";
	$ds->DeleteCommand = "delete from prov_movimientoproducto where Id=@Id";
	$ds->InsertCommand = "insert into prov_movimientoproducto (producto_id,cantidad,RFID) values ('@producto_id','@cantidad','@RFID');";
 

	$grid = new KoolGrid("grid");
	$grid->scriptFolder = $KoolControlsFolder."/KoolGrid";
	$grid->styleFolder = "redbrown";

	$grid->AjaxEnabled = true;
	$grid->DataSource = $ds;
	$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
	$grid->Width = "900px";
	$grid->ColumnWrap = true;
	$grid->AllowInserting = true;
	$grid->AllowEditing = true;
	$grid->AllowDeleting = true;
	
	
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
	
	$column = new GridNumberColumn();
	$column->DecimalNumber = 2;
	$column->ThousandSeperate = ",";
	$column->DataField = "cantidad";
	$column->HeaderText = "Cantidad";
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
	
	$grid->Process();
	
?>

<form id="form1" method="post">
	<?php echo $koolajax->Render();?>
	<?php echo $grid->Render();?>
</form>
