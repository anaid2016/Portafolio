<?php
require_once dirname(__FILE__).'/../jq-config.php';
// include the jqGrid Class
require_once ABSPATH."pages/php/jqGrid.php";
// include the driver class
require_once ABSPATH."pages/php/jqGridPdo.php";
// Connection to the server
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
// Tell the db that we use utf-8
$conn->query("SET NAMES 'utf8'");

// Create the jqGrid instance
$grid = new jqGridRender($conn);
// Write the SQL Query
$grid->SelectCommand = 'SELECT  pv_clientes.Id, pv_clientes.nombre,pv_clientes.nit,pv_clientes.telefono,pv_clientes.mail
from pv_clientes';
// set the ouput format to json
$grid->table = 'pv_clientes';
$grid->setPrimaryKeyId('Id');
$grid->dataType = 'json';
// Let the grid create the model
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('pages/clientes.php');
// Set some grid options
$grid->setGridOptions(array("rowNum"=>20,"rowList"=>array(10,20,30), "sortname"=>"Id","height"=>320));
$grid->setColProperty("Id",array("editable"=>false));

#$grid->setSelect("proceso_id","SELECT Id,nombre FROM comx_procesos_generales");
// Enable toolbar searching
$grid->navigator = true;
$grid->setNavOptions('navigator',array("excel"=>false,"add"=>true,"edit"=>true,"del"=>true,"view"=>false, "search"=>true));
$grid->setNavOptions('edit', array("height"=>200,"dataheight"=>"auto"));
$grid->setNavOptions('add', array("height"=>200,"dataheight"=>"auto"));
$grid->setNavOptions('del', array("height"=>200,"dataheight"=>"auto"));
// Enjoy
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$conn = null;
?>