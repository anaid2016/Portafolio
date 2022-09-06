<?php


	//Aqui iniciar el codigo de KoolPHP
	$KoolControlsFolder="pages/KoolControls";
	require $KoolControlsFolder."/KoolAjax/koolajax.php";
	$koolajax->scriptFolder = $KoolControlsFolder."/KoolAjax";

	require $KoolControlsFolder."/KoolGrid/koolgrid.php";
	require $KoolControlsFolder."/KoolCalendar/koolcalendar.php";
	
		
	$ds = new MySQLDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
	$ds->SelectCommand = "SELECT * from prov_tipo ";
	$ds->UpdateCommand = "update prov_tipo set nombre='@nombre',referencia='@referencia' where Id=@Id";
	$ds->DeleteCommand = "delete from prov_tipo where nombre=@nombre";
	$ds->InsertCommand = "insert into prov_tipo (nombre,referencia) values ('@nombre','@referencia');";
 

	$grid = new KoolGrid("grid");
	$grid->scriptFolder = $KoolControlsFolder."/KoolGrid";
	$grid->styleFolder = "office2010blue";

	$grid->AjaxEnabled = true;
	$grid->DataSource = $ds;
	$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
	$grid->Width = "400px";
	$grid->ColumnWrap = true;
	$grid->AllowInserting = true;
	$grid->AllowEditing = true;
	$grid->AllowDeleting = true;
	$grid->MasterTable->Pager->PageSize = 20;
	
	
	$column = new GridBoundColumn();
	$column->DataField = "Id";
	$column->ReadOnly = true;
	$grid->MasterTable->AddColumn($column);

	$column = new GridBoundColumn();
	$column->DataField = "nombre";
	$column->HeaderText = "Nombre";
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridBoundColumn();
	$column->DataField = "referencia";
	$column->HeaderText = "Referencia";
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
