<?php

	//Trae categorias
	$data1=PV_001("Id,nombre","pv_categorias");
	$data1=explode(";;",$data1);
	
	//Trae unidades
	$data2=PV_001("Id,nombre","pv_unidades");
	$data2=explode(";;",$data2);

	//Aqui iniciar el codigo de KoolPHP
	$KoolControlsFolder="pages/KoolControls";
	require $KoolControlsFolder."/KoolAjax/koolajax.php";
	$koolajax->scriptFolder = $KoolControlsFolder."/KoolAjax";

	require $KoolControlsFolder."/KoolGrid/koolgrid.php";
	require $KoolControlsFolder."/KoolCalendar/koolcalendar.php";
	
		
	$ds = new MySQLDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
	$ds->SelectCommand = "SELECT * from view_clientes ";
	$ds->UpdateCommand = "update prov_clientes set nombre='@nombre',direccion='@direccion',tipo_identificacion='@tipo_identificacion',identificacion='@identificacion' where Id=@Id";
	$ds->DeleteCommand = "delete from prov_clientes where Id=@Id";
	$ds->InsertCommand = "insert into prov_clientes (nombre,direccion,tipo_identificacion,identificacion) values ('@nombre','@direccion','@tipo_identificacion','@identificacion');";
 

	$grid = new KoolGrid("grid");
	$grid->scriptFolder = $KoolControlsFolder."/KoolGrid";
	$grid->styleFolder = "office2010blue";

	$grid->AjaxEnabled = true;
	$grid->DataSource = $ds;
	$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
	$grid->Width = "1100px";
	$grid->ColumnWrap = true;
	$grid->AllowInserting = true;
	$grid->AllowEditing = true;
	$grid->AllowDeleting = true;
	
	
	$column = new GridBoundColumn();
	$column->DataField = "Id";
	$column->ReadOnly = true;
	$grid->MasterTable->AddColumn($column);

	$column = new GridBoundColumn();
	$column->DataField = "nombre";
	$column->HeaderText = "Nombre";
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridBoundColumn();
	$column->DataField = "direccion";
	$column->HeaderText = "Direccion";
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridDropDownColumn();
	$column->DataField = "tipo_identificacion";
	$column->HeaderText = "Tipo Documento";
	$column->AddItem("CC","1");
	$column->AddItem("NIT","2");
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridBoundColumn();
	$column->DataField = "identificacion";
	$column->HeaderText = "Identificacion";
	$grid->MasterTable->AddColumn($column);
		

	$column = new GridBoundColumn();
	$column->DataField = "promedio";
	$column->HeaderText = "Promedio";
	$column->DecimalNumber = 2;
	$column->ThousandSeperate = ",";
	$column->ReadOnly = true;
	$grid->MasterTable->AddColumn($column);
	
	//Para agregar campos fechas
	$column = new GridDateTimeColumn();
	$column->DataField = "maxorden";
	$column->HeaderText = "Ultima Orden";
	$column->ReadOnly = true;
	$column->FormatString = "Y-m-d";
	//Assign datepicker for GridDateTimeColumn, this is optional.
	$column->Picker = new KoolDatePicker();
	$column->Picker->scriptFolder = $KoolControlsFolder."/KoolCalendar";
	$column->Picker->styleFolder = "default";	
	$column->Picker->DateFormat = "Y-m-d";
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
