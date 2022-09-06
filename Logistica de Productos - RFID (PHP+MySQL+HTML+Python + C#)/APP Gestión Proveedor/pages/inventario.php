<?php

	//Trae categorias
	
	
	$data1=PV_001("Id,nombre","prov_categorias");
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
	$ds->SelectCommand = "SELECT prov_producto.Id,prov_nombres.nombre,codbarras,precio_produccion,precio_venta,unidad_id,IF(entrada>0,entrada,0) as entrada2,IF(salida>0,salida,0) as salida2,IF(stock>0,stock,0) AS stock2,fechaentr,fechasal FROM prov_producto
LEFT JOIN
(
	SELECT producto_id,count(*) AS entrada,max(fecha) as fechaentr FROM prov_movimientoproducto
	LEFT JOIN prov_producto ON prov_producto.Id=prov_movimientoproducto.producto_id
	GROUP BY producto_id
) AS entradas ON (entradas.producto_id=prov_producto.Id)
LEFT JOIN
(
	SELECT producto_id,count(*) as salida,max(fecha2) as fechasal FROM prov_movimientoproducto
	LEFT JOIN prov_producto ON prov_producto.Id=prov_movimientoproducto.producto_id
	WHERE fecha2 is not NULL  GROUP BY producto_id
) AS salidas ON (salidas.producto_id=prov_producto.Id) 
LEFT JOIN
(
	SELECT producto_id,count(*) AS stock FROM prov_movimientoproducto
	LEFT JOIN prov_producto ON prov_producto.Id=prov_movimientoproducto.producto_id
	WHERE fecha2 is NULL GROUP BY producto_id
) AS stocks ON (stocks.producto_id=prov_producto.Id) 
LEFT JOIN prov_nombres ON prov_nombres.Id=prov_producto.nombre";
	//$ds->UpdateCommand = "update prov_producto set nombre='@nombre',codbarras='@codbarras',categoria_id='@idcategoria',precio='@precio',unidad_id='@unidad_id' where Id=@Id";
	//$ds->DeleteCommand = "delete from prov_producto where Id=@Id";
	//$ds->InsertCommand = "insert into prov_producto (nombre,categoria_id,precio,unidad_id,codbarras) values ('@nombre','@idcategoria','@precio','@unidad_id','@codbarras');";
 

	$grid = new KoolGrid("grid");
	$grid->scriptFolder = $KoolControlsFolder."/KoolGrid";
	$grid->styleFolder = "office2010blue";

	$grid->AjaxEnabled = true;
	$grid->DataSource = $ds;
	$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
	$grid->Width = "1100px";
	$grid->ColumnWrap = true;
	$grid->AllowSelecting =true;
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
	
	
	$column = new GridNumberColumn();
	$column->DecimalNumber = 2;
	$column->ThousandSeperate = ",";
	$column->DataField = "precio_produccion";
	$column->HeaderText = "Costo Producto";
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridNumberColumn();
	$column->DecimalNumber = 2;
	$column->ThousandSeperate = ",";
	$column->DataField = "precio_venta";
	$column->HeaderText = "Precio Venta";
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridNumberColumn();
	$column->DataField = "entrada2";
	$column->HeaderText = "Cant. Producida";
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridNumberColumn();
	$column->DataField = "salida2";
	$column->HeaderText = "Cant. Vendida";
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridNumberColumn();
	$column->DataField = "stock2";
	$column->HeaderText = "Stock";
	$column->CssClass = "blueColor";
	$grid->MasterTable->AddColumn($column);
	

	$column = new GridDropDownColumn();
	$column->DataField = "unidad_id";
	$column->HeaderText = "Unidad";
	for($a=0;$a<count($data2);$a++){
		$datalinea=explode("::",$data2[$a]);
		$column->AddItem($datalinea[1],$datalinea[0]);
	}
	$grid->MasterTable->AddColumn($column);
	

	$column = new GridBoundColumn();
	$column->DataField = "fechaentr";
	$column->HeaderText = "Ult. Fecha Entrada";
	$column->ReadOnly = true;
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridBoundColumn();
	$column->DataField = "fechasal";
	$column->HeaderText = "Ult. Fecha Salida";
	$column->ReadOnly = true;
	$grid->MasterTable->AddColumn($column);

	
	$grid->MasterTable->EditSettings->Mode = "Inline";//"Inline" is default value;
	//Show Function Panel
	$grid->MasterTable->ShowFunctionPanel = true;
	
	$grid->Process();
	
?>

<form id="form1" method="post">
	<style>
	.blueColor
	{
		background-color:#F60;
		color:#000;
		font-weight:bold;
	}
	</style>
	<?php echo $koolajax->Render();?>
    
	<?php echo $grid->Render();?>
</form>
