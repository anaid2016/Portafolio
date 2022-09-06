<?php

	//Aqui iniciar el codigo de KoolPHP
	$KoolControlsFolder="pages/KoolControls";
	require $KoolControlsFolder."/KoolAjax/koolajax.php";
	$koolajax->scriptFolder = $KoolControlsFolder."/KoolAjax";

	require $KoolControlsFolder."/KoolGrid/koolgrid.php";
	require $KoolControlsFolder."/KoolCalendar/koolcalendar.php";
	
		
	$ds = new MySQLDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
	$ds->SelectCommand = "SELECT * from view_usuarios ";
	$ds->UpdateCommand = "update prov_users set nombre='@nombre',correo='@correo',userp='@userp',password='@password',estado_id='@estado_id' where Id=@Id";
	$ds->DeleteCommand = "delete from prov_users where Id=@Id";
	$ds->InsertCommand = "insert into prov_users (nombre,correo,userp,password,estado_id) values ('@nombre','@correo','@userp','@password','@estado_id');";
 

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
	$column->HeaderText = "Nombres";
	$grid->MasterTable->AddColumn($column);
	
	
	
	$column = new GridBoundColumn();
	$column->DataField = "correo";
	$column->HeaderText = "E-mail";
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridBoundColumn();
	$column->DataField = "userp";
	$column->HeaderText = "Usuario";
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridBoundColumn();
	$column->DataField = "password";
	$column->HeaderText = "Contraseña";
	$column->Visible = false;
	$grid->MasterTable->AddColumn($column);
	
	
	//Agregando Columna de Relación
	$column = new GridDropDownColumn();
	$column->DataField = "estado_id";
	$column->HeaderText = "Estado";
	$column->AddItem("Activo","1");
	$column->AddItem("Inactivo","2");
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
