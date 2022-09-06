<?php

	

	//Trae categorias
	$data1=PV_001("Id,nombre","prov_clientes");
	$data1=explode(";;",$data1);
	
	$data2=PV_001("Id,nombre","prov_unidades");
	$data2=explode(";;",$data2);
	
	$_SESSION['bandera']=0;
	
	if(!empty($_SESSION['ordenventa'])){
		$_SESSION['estado']=PV_005($_SESSION['ordenventa']);
	}
	
	$KoolControlsFolder="pages/KoolControls";
	require $KoolControlsFolder."/KoolAjax/koolajax.php";
	$koolajax->scriptFolder = $KoolControlsFolder."/KoolAjax";
 
	require $KoolControlsFolder."/KoolGrid/koolgrid.php";
	require $KoolControlsFolder."/KoolCalendar/koolcalendar.php";
	$ds = new MySQLDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
	$ds->SelectCommand = "select Id,orden_number,idcliente,direccion,total_orden,fechacreada,fechasalida,estado_id from view_ventas";
 	$ds->UpdateCommand = "update prov_ordenventa set estado_id='@estado_id' where Id=@Id";
	$ds->DeleteCommand = "delete from prov_ordenventa where Id=@Id";
	$ds->InsertCommand = "insert into prov_ordenventa (estado_id,cliente_id) values ('@estado_id','@idcliente');";
	
	
	$grid = new KoolGrid("grid");
	$grid->scriptFolder = $KoolControlsFolder."/KoolGrid";
	$grid->styleFolder="office2010blue";
	$grid->MasterTable->DataSource = $ds;
	$grid->MasterTable->DataKeyNames = "Id"; // Need to set to get selection.
	$grid->Width = "750px";
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
	$column->DataField = "orden_number";
	$column->HeaderText = "Pedido";
	$column->ReadOnly = true;
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridBoundColumn();
	$column->DataField = "total_orden";
	$column->HeaderText = "Total Pedido";
	$column->ReadOnly = true;
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridDropDownColumn();
	$column->DataField = "estado_id";
	$column->HeaderText = "Estado";
	$column->AddItem("Solicitud","1");
	$column->AddItem("Generada","2");
	$column->AddItem("Finalizada","3");
	$grid->MasterTable->AddColumn($column);
	
	//Para agregar campos fechas
	$column = new GridDateTimeColumn();
	$column->DataField = "fechacreada";
	$column->HeaderText = "Fecha Generada";
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
	$column->DataField = "fechasalida";
	$column->HeaderText = "Fecha Despacho";
	$column->ReadOnly = true;
	$column->FormatString = "Y-m-d";
	//Assign datepicker for GridDateTimeColumn, this is optional.
	$column->Picker = new KoolDatePicker();
	$column->Picker->scriptFolder = $KoolControlsFolder."/KoolCalendar";
	$column->Picker->styleFolder = "default";	
	$column->Picker->DateFormat = "Y-m-d";
	$grid->MasterTable->AddColumn($column);
		
	$column = new GridDropDownColumn();
	$column->DataField = "idcliente";
	$column->HeaderText = "Cliente";
	for($a=0;$a<count($data1);$a++){
		$datalinea=explode("::",$data1[$a]);
		$column->AddItem($datalinea[1],$datalinea[0]);
	}
	$grid->MasterTable->AddColumn($column);
	
	$column = new GridBoundColumn();
	$column->DataField = "direccion";
	$column->HeaderText = "Direccion Cliente";
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
	$grid->ClientSettings->ClientEvents["OnRowConfirmEdit"] = "Handle_OnRowConfirmEdit";
		
	$grid->Process();
	
	//Get selected keys after grid processing
	$selected_keys = $grid->GetInstanceMasterTable()->SelectedKeys;
	
	//Visualizacion del Pedido Solicitado======================================================================================
	$ds5 = new MySQLDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
	$ds5->SelectCommand = "SELECT *,(cantidad-cantidad2) as faltantes FROM view_ventapendiente LEFT JOIN ( SELECT cantidad2, producto_id FROM view_ordenproc
) AS data2 ON data2.producto_id=view_ventapendiente.Id";

	$grid7 = new KoolGrid("grid7");
	$grid7->scriptFolder = $KoolControlsFolder."/KoolGrid";
	$grid7->DataSource = $ds5;
	$grid7->styleFolder="office2010blue";
	$grid7->AjaxEnabled = true;
	$grid7->MasterTable->Pager = new GridPrevNextAndNumericPager();
	$grid7->Width = "500px";
	
	$column = new GridBoundColumn();
	$column->DataField = "Id";
	$column->ReadOnly = true;
	$grid7->MasterTable->AddColumn($column);
	
	$column = new GridBoundColumn();
	$column->DataField = "nombre";
	$column->HeaderText = "Producto";
	$column->ReadOnly = true;
	$grid7->MasterTable->AddColumn($column);
	
	$column = new GridBoundColumn();
	$column->DataField = "codbarras";
	$column->HeaderText = "Codbarras";
	$column->ReadOnly = true;
	$grid7->MasterTable->AddColumn($column);
	
	$column = new GridBoundColumn();
	$column->DataField = "cantidad";
	$column->HeaderText = "Cantidad";
	$column->ReadOnly = true;
	$grid7->MasterTable->AddColumn($column);

	$column = new GridBoundColumn();
	$column->DataField = "cantidad2";
	$column->HeaderText = "Cant. Separada";
	$column->ReadOnly = true;
	$grid7->MasterTable->AddColumn($column);
	
	
	$column = new GridBoundColumn();
	$column->DataField = "precio_venta";
	$column->HeaderText = "($) Unitario";
	$column->ReadOnly = true;
	$grid7->MasterTable->AddColumn($column);
	
	$column = new GridBoundColumn();
	$column->DataField = "faltantes";
	$column->ReadOnly = true;
	
	$grid7->MasterTable->AddColumn($column);
	
	class MyGridEventHandler extends GridEventHandler
	{
		function OnRowPreRender($row,$args)
		{
			switch($row->DataItem["faltantes"])
			{
				case "0":
					$row->CssClass="css_inprocess";
					break;
				default:
			}
		}
	}
	$grid7->EventHandler = new MyGridEventHandler();
	
	$grid7->Process();
	
	
	?>

	<form id="form1" method="post">
    	<style type="text/css">
		tr.css_inprocess td.kgrCell
		{
			background:#A6D8F0;
		}
		</style>
   		 <?php echo $koolajax->Render();?>
         
    <div style="padding:10px 0px 2px 10px;float:left">
    	<p>Productos Pendientes por Pedido:</p>
     	<?php echo $grid7->Render();?>
    </div>
    
    <div style="padding:10px 0px 2px 15px;float:left">
    	 <script type="text/javascript">
		//These event handles function must be put before $grid->Render() function
		function Handle_OnRowConfirmEdit(sender,args)
		{
			var _row = args["Row"];
			var _estado=_row.getDataItem()["estado_id"];
			var _idorden=_row.getDataItem()["Id"];
			
			//alert("aqui que hace"+_estado);
			//Aqui debe entrar el codigo que saca la etiqueta
			if(_estado=='3'){
				
				$.ajax({
					type: "POST",
					url:"pages/correo.php",
					data:{"codigo": _idorden},
					success: function(data){
						alert(data);
					}
				});
				
				
			}

			window.location="http://127.0.0.1/industrial/proveedor/pedidos_index.php";
		}
		
		</script>
		<p>Pedidos:</p>
        <?php echo $grid->Render();?>
	
        <!-- modal content -->
        <div style="padding-top:10px;">
            <input type="submit" value = "Ver Pedido" />
        </div>
    </div>
	<div style="padding-top:10px;">
		<?php
			if (sizeof($selected_keys)>0)
			{
				$_SESSION['ordenventa']=$selected_keys[0]['Id'];
				$_SESSION['estado']=PV_005($_SESSION['ordenventa']);
				$_SESSION['idrfid']="";
			}
			
		?>			
	</div>	
	</form>
    
    <div style="clear:both"><hr /></div>
    
	<?php		
		if(!empty($_SESSION['ordenventa'])){
			 	//=================PRODUCTOS EN INVENTARIO=====================================================================================

    			$ds3 = new MySQLDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
				$ds3->SelectCommand = "SELECT
	prov_movimientoproducto.Id,
	prov_movimientoproducto.producto_id,
	prov_movimientoproducto.cantidad,
	prov_nombres.nombre,
	prov_producto.unidad_id,
	prov_producto.codbarras,
	prov_movimientoproducto.RFID,
	prov_producto.precio_venta
FROM
	prov_movimientoproducto
LEFT JOIN prov_producto ON prov_producto.Id = prov_movimientoproducto.producto_id
LEFT JOIN prov_nombres ON prov_nombres.Id=prov_producto.nombre
WHERE
	prov_movimientoproducto.estado_id = '3'";
					
				$grid3 = new KoolGrid("grid3");
				$grid3->scriptFolder = $KoolControlsFolder."/KoolGrid";
				$grid3->styleFolder="office2010blue";
				$grid3->MasterTable->DataSource = $ds3;
				$grid3->MasterTable->DataKeyNames = "Id"; // Need to set to get selection.
				$grid3->Width = "500px";
				$grid3->AllowFiltering = true;
				$grid3->AllowInserting = false;
				//$grid3->AllowSelecting = true;// Allow row selecting
				$grid3->AllowMultiSelecting = true;
				$grid3->AllowEditing = false;
				$grid3->AllowDeleting = false;
				$grid3->AjaxEnabled = true;
				$grid3->KeepGridRefresh = true;
				$grid3->MasterTable->Pager = new GridPrevNextAndNumericPager();
				
				
				$column = new GridBoundColumn();
				$column->DataField = "Id";
				$column->ReadOnly = true;
				$grid3->MasterTable->AddColumn($column);
			
				$column = new GridBoundColumn();
				$column->DataField = "nombre";
				$column->HeaderText = "Nombre";
				$grid3->MasterTable->AddColumn($column);
				
				$column = new GridBoundColumn();
				$column->DataField = "codbarras";
				$column->HeaderText = "Codbarras";
				$grid3->MasterTable->AddColumn($column);
				
				$column = new GridBoundColumn();
				$column->DataField = "RFID";
				$column->HeaderText = "RFID";
				$grid3->MasterTable->AddColumn($column);
				
				
				$column = new GridNumberColumn();
				$column->DecimalNumber = 2;
				$column->ThousandSeperate = ",";
				$column->DataField = "precio_venta";
				$column->HeaderText = "Valor";
				$grid3->MasterTable->AddColumn($column);
				
			
				$column = new GridDropDownColumn();
				$column->DataField = "unidad_id";
				$column->HeaderText = "Und.";
				for($a=0;$a<count($data2);$a++){
					$datalinea=explode("::",$data2[$a]);
					$column->AddItem($datalinea[1],$datalinea[0]);
				}
				$grid3->MasterTable->AddColumn($column);
							
				
				//$column = new GridEditDeleteColumn();
				//$column->Align = "center";
				//$grid3->MasterTable->AddColumn($column);
				//$grid3->MasterTable->EditSettings->Mode = "Inline";//"Inline" is default value;
				
				$grid3->Process();
				$selected_keys2 = $grid3->GetInstanceMasterTable()->SelectedKeys;
				
				//PRODUCTOS ADJUNTOS A LA ORDEN DE VENTA ======================================================================================
	
				$ds4 = new MySQLDataSource($db_con);//This $db_con link has been created inside KoolPHPSuite/Resources/runexample.php
				$ds4->SelectCommand = " SELECT
	prov_productosorden.Id,
	prov_movimientoproducto.RFID,
	prov_nombres.nombre,
	prov_producto.codbarras,
	prov_movimientoproducto.cantidad,
	prov_producto.precio_venta,
	prov_producto.unidad_id
FROM
	prov_productosorden
LEFT JOIN prov_ordenventa ON prov_ordenventa.Id = prov_productosorden.ordenventa_id
LEFT JOIN prov_movimientoproducto ON prov_movimientoproducto.Id = prov_productosorden.movimiento_id
LEFT JOIN prov_producto ON prov_producto.Id = prov_movimientoproducto.producto_id
LEFT JOIN prov_nombres ON prov_nombres.Id=prov_producto.nombre
WHERE
	prov_ordenventa.Id =".$_SESSION['ordenventa'];
				$ds4->DeleteCommand = "delete from prov_productosorden where Id=@Id and estado_id='1' ";
					
				$grid4 = new KoolGrid("grid4");
				$grid4->scriptFolder = $KoolControlsFolder."/KoolGrid";
				$grid4->styleFolder="office2010blue";
				$grid4->MasterTable->DataSource = $ds4;
				$grid4->MasterTable->DataKeyNames = "Id"; // Need to set to get selection.
				$grid4->Width = "650px";
				$grid4->AllowInserting = false;
				//$grid4->AllowSelecting = true;// Allow row selecting
				//$grid4->AllowMultiSelecting = true;
				$grid4->AllowEditing = false;
				$grid4->AllowDeleting = true;
				$grid4->AjaxEnabled = true;
				$grid4->AllowFiltering = true;
				$grid4->MasterTable->Pager = new GridPrevNextAndNumericPager();
				
				
				$column = new GridBoundColumn();
				$column->DataField = "Id";
				$column->ReadOnly = true;
				$grid4->MasterTable->AddColumn($column);
			
				$column = new GridBoundColumn();
				$column->DataField = "nombre";
				$column->HeaderText = "Nombre";
				$grid4->MasterTable->AddColumn($column);
				
				$column = new GridBoundColumn();
				$column->DataField = "codbarras";
				$column->HeaderText = "Codbarras";
				$grid4->MasterTable->AddColumn($column);
				
				$column = new GridBoundColumn();
				$column->DataField = "RFID";
				$column->HeaderText = "RFID";
				$grid4->MasterTable->AddColumn($column);
				
				
				$column = new GridNumberColumn();
				$column->DecimalNumber = 2;
				$column->ThousandSeperate = ",";
				$column->DataField = "precio_venta";
				$column->HeaderText = "Valor";
				$grid4->MasterTable->AddColumn($column);
				
				$column = new GridNumberColumn();
				$column->ThousandSeperate = ",";
				$column->DataField = "cantidad";
				$column->HeaderText = "Cant.";
				$grid4->MasterTable->AddColumn($column);
				
			
				$column = new GridDropDownColumn();
				$column->DataField = "unidad_id";
				$column->HeaderText = "Und.";
				for($a=0;$a<count($data2);$a++){
					$datalinea=explode("::",$data2[$a]);
					$column->AddItem($datalinea[1],$datalinea[0]);
				}
				$grid4->MasterTable->AddColumn($column);
							
				if($_SESSION['estado']==1){
					$column = new GridEditDeleteColumn();
					$column->Align = "center";
					$grid4->MasterTable->AddColumn($column);
				}
				
				$grid4->MasterTable->EditSettings->Mode = "Inline";//"Inline" is default value;
				
				//Show Function Panel
				$grid4->MasterTable->ShowFunctionPanel = true;
				//Insert Settings
				$grid4->MasterTable->InsertSettings->Mode = "Form";
				$grid4->MasterTable->InsertSettings->ColumnNumber = 2;
				$grid4->ClientSettings->ClientEvents["OnRowDelete"] = "DeleteRow_grid4";
				
				$grid4->Process();
	
	
	
	?>
    
         <form id="form1" method="post">
         <?php echo $koolajax->Render();?>
      	 <div style="float:left;padding:padding:10px 0px 0px 10px;margin-left:10px">
         	<p>Productos en Inventario</p>
            
            <?php echo $grid3->Render();?>
             <!-- modal content -->
            <div style="padding-top:10px;">
            <?php
				if($_SESSION['estado']=='1'){
              		echo '<input type="submit" value = "Anexar Productos" />';
				}
			?>
            </div>
        
            <div style="padding-top:10px;">
                <?php
                    if (sizeof($selected_keys2)>0)
                    {
                        //$_SESSION['idrfid']=$selected_keys2[0]['Id'];
						for($i=0;$i<sizeof($selected_keys2);$i++)
						{
							if(empty($_SESSION['idrfid'])){
								$_SESSION['idrfid']=$selected_keys2[$i]["Id"];
							}else{
								$_SESSION['idrfid'].=$selected_keys2[$i]["Id"];
							}
							if($i<sizeof($selected_keys2)-1)
							{
								$_SESSION['idrfid'].=" ,";	
							}
						}
                        $_SESSION['bandera']=1;
                    }
                ?>			
            </div>
         </div>
         <div style="float:left;padding:10px 0px 2px 15px;">
           <p>Productos anexos al Pedido <?php echo PV_003($_SESSION['ordenventa']); ?>:</p>
            <script type="text/javascript">
				//These event handles function must be put before $grid->Render() function
				function DeleteRow_grid4(sender,args)
				{
					 window.location="http://127.0.0.1/industrial/proveedor/pedidos_index.php";
						
				}
			</script>
           <?php echo $grid4->Render();?>
         </div>
        </form>	
     
    
     
     
     
     
     <div style="clear:both">
    
    <?php
    		if (!empty($_SESSION['idrfid']) and !empty($_SESSION['ordenventa']) and $_SESSION['bandera']==1)
			{
				$_SESSION['bandera']=0;
				
				//Insertando en la base de datos el rfid seleccionado========================================================
				$res_insert=PV_002($_SESSION['ordenventa'],$_SESSION['idrfid']);
				$_SESSION['idrfid']="";
	?>			
				
				<script type="text/javascript">
				 window.location="http://127.0.0.1/proveedor/pedidos_index.php";
				</script>		
	<?php			
			}
    
   
	}
	?>
   


	</div>
	