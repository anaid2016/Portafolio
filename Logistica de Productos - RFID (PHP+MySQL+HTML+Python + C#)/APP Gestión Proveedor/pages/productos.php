<?php

	//Trae categorias
	
	
	$data1=PV_001("Id,nombre","prov_categorias");
	$data1=explode(";;",$data1);
	
	//Trae unidades
	$data2=PV_001("Id,nombre","prov_unidades");
	$data2=explode(";;",$data2);
	
	//Trae unidades
	$data3=PV_001("Id,nombre","prov_nombres");
	$data3=explode(";;",$data3);
	
	
	//Trae unidades
	$data4=PV_001("Id,nombre","prov_tipo");
	$data4=explode(";;",$data4);


	//Trae unidades
	$data5=PV_001("Id,nombre","prov_color");
	$data5=explode(";;",$data5);
	
	//Trae unidades
	$data6=PV_001("Id,talla","prov_tallas");
	$data6=explode(";;",$data6);
	
	//Aqui iniciar el codigo de KoolPHP
	$KoolControlsFolder="pages/KoolControls";
	require $KoolControlsFolder."/KoolAjax/koolajax.php";
	$koolajax->scriptFolder = $KoolControlsFolder."/KoolAjax";

	require $KoolControlsFolder."/KoolGrid/koolgrid.php";
	require $KoolControlsFolder."/KoolCalendar/koolcalendar.php";
	
		
	$ds = new MySQLDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
	$ds->SelectCommand = "SELECT * from view_productos ";
	$ds->UpdateCommand = "update prov_producto set nombre='@nombre',categoria_id='@idcategoria',precio_produccion='@produccion',unidad_id='@unidad_id',tipo_id='@tipo_id',talla_id='@talla_id',color_id='@color_id' where Id=@Id";
	$ds->DeleteCommand = "delete from prov_producto where Id=@Id";
	$ds->InsertCommand = "insert into prov_producto (nombre,categoria_id,precio_produccion,unidad_id,tipo_id,talla_id,color_id) values ('@nombre','@idcategoria','@produccion','@unidad_id','@tipo_id','@talla_id','@color_id');";
 

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
	$grid->MasterTable->Pager->PageSize = 20;
	
	
	$column = new GridBoundColumn();
	$column->DataField = "Id";
	$column->ReadOnly = true;
	$grid->MasterTable->AddColumn($column);

	$column = new GridDropDownColumn();
	$column->DataField = "nombre";
	$column->HeaderText = "Nombre";
	for($a=0;$a<count($data3);$a++){
		$datalinea=explode("::",$data3[$a]);
		$column->AddItem($datalinea[1],$datalinea[0]);
	}
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridNumberColumn();
	$column->DecimalNumber = 2;
	$column->ThousandSeperate = ",";
	$column->DataField = "precio";
	$column->HeaderText = "Precio";
	$column->ReadOnly = true;
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridNumberColumn();
	$column->DecimalNumber = 2;
	$column->ThousandSeperate = ",";
	$column->DataField = "produccion";
	$column->HeaderText = "Precio Produccion";
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridDropDownColumn();
	$column->DataField = "unidad_id";
	$column->HeaderText = "Unidad";
	for($a=0;$a<count($data2);$a++){
		$datalinea=explode("::",$data2[$a]);
		$column->AddItem($datalinea[1],$datalinea[0]);
	}
	$grid->MasterTable->AddColumn($column);
	
		
	//Agregando Columna de Relación
	$column = new GridDropDownColumn();
	$column->DataField = "idcategoria";
	$column->HeaderText = "Categoria";
	for($a=0;$a<count($data1);$a++){
		$datalinea=explode("::",$data1[$a]);
		$column->AddItem($datalinea[1],$datalinea[0]);
	}
	
	$grid->MasterTable->AddColumn($column);

	$column = new GridDropDownColumn();
	$column->DataField = "tipo_id";
	$column->HeaderText = "Tipo";
	for($a=0;$a<count($data4);$a++){
		$datalinea=explode("::",$data4[$a]);
		$column->AddItem($datalinea[1],$datalinea[0]);
	}
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridDropDownColumn();
	$column->DataField = "color_id";
	$column->HeaderText = "Color";
	for($a=0;$a<count($data5);$a++){
		$datalinea=explode("::",$data5[$a]);
		$column->AddItem($datalinea[1],$datalinea[0]);
	}
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridDropDownColumn();
	$column->DataField = "talla_id";
	$column->HeaderText = "Talla";
	for($a=0;$a<count($data6);$a++){
		$datalinea=explode("::",$data6[$a]);
		$column->AddItem($datalinea[1],$datalinea[0]);
	}
	$grid->MasterTable->AddColumn($column);

	$column = new GridBoundColumn();
	$column->DataField = "codbarras";
	$column->HeaderText = "Codbarras";
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
