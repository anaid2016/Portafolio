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
	$ds->SelectCommand = "SELECT pv_movimientoproducto.Id,pv_producto.nombre,pv_producto.codbarras,RFID,preciolinea,pv_ordencompra.numberorden,pv_ordenventa.orden_number,pv_producto.unidad_id FROM pv_movimientoproducto
LEFT JOIN pv_producto ON pv_producto.Id=pv_movimientoproducto.producto_id
LEFT JOIN pv_ordencompra ON pv_ordencompra.Id=pv_movimientoproducto.ordenc_id
LEFT JOIN pv_ordenventa ON pv_ordenventa.Id=pv_movimientoproducto.ordenv_id
LEFT JOIN pv_unidades ON pv_unidades.Id=pv_producto.unidad_id ";
	//$ds->UpdateCommand = "update pv_producto set nombre='@nombre',codbarras='@codbarras',categoria_id='@idcategoria',precio='@precio',unidad_id='@unidad_id' where Id=@Id";
	//$ds->DeleteCommand = "delete from pv_producto where Id=@Id";
	//$ds->InsertCommand = "insert into pv_producto (nombre,categoria_id,precio,unidad_id,codbarras) values ('@nombre','@idcategoria','@precio','@unidad_id','@codbarras');";
 

	$grid = new KoolGrid("grid");
	$grid->scriptFolder = $KoolControlsFolder."/KoolGrid";
	$grid->styleFolder = "office2010blue";

	$grid->AjaxEnabled = true;
	$grid->DataSource = $ds;
	$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
	$grid->Width = "900px";
	$grid->ColumnWrap = true;
	$grid->AllowFiltering = true;
	$grid->AllowInserting = false;
	$grid->AllowEditing = false;
	$grid->AllowDeleting = false;
	
	
	$column = new GridBoundColumn();
	$column->DataField = "Id";
	$column->ReadOnly = true;
	$grid->MasterTable->AddColumn($column);

	$column = new GridBoundColumn();
	$column->DataField = "nombre";
	$column->HeaderText = "Nombre";
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridBoundColumn();
	$column->DataField = "codbarras";
	$column->HeaderText = "Codbarras";
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridBoundColumn();
	$column->DataField = "RFID";
	$column->HeaderText = "RFID";
	$grid->MasterTable->AddColumn($column);
	
	
	$column = new GridNumberColumn();
	$column->DecimalNumber = 2;
	$column->ThousandSeperate = ",";
	$column->DataField = "preciolinea";
	$column->HeaderText = "Costo Producto";
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridBoundColumn();
	$column->DataField = "numberorden";
	$column->HeaderText = "Orden de Compra";
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridBoundColumn();
	$column->DataField = "orden_number";
	$column->HeaderText = "Orden de Venta";
	$grid->MasterTable->AddColumn($column);
	


	$column = new GridDropDownColumn();
	$column->DataField = "unidad_id";
	$column->HeaderText = "Unidad";
	for($a=0;$a<count($data2);$a++){
		$datalinea=explode("::",$data2[$a]);
		$column->AddItem($datalinea[1],$datalinea[0]);
	}
	$grid->MasterTable->AddColumn($column);

	//$column = new GridEditDeleteColumn();
	//$column->Align = "center";
	//$grid->MasterTable->AddColumn($column);
	
	
	$grid->MasterTable->EditSettings->Mode = "Inline";//"Inline" is default value;
	
	//Show Function Panel
	//$grid->MasterTable->ShowFunctionPanel = true;
	//Insert Settings
	//$grid->MasterTable->InsertSettings->Mode = "Form";
	//$grid->MasterTable->InsertSettings->ColumnNumber = 2;
	
	$grid->Process();
	
?>

<form id="form1" method="post">
	<?php echo $koolajax->Render();?>
	<?php echo $grid->Render();?>
</form>
