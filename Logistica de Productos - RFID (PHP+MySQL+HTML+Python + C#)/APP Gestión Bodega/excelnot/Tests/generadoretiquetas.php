<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2009 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2009 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.6.5, 2009-01-05
 */

/*Obtención de Datos*/
	include("../../funciones/seguridad.php");
	$archivo="../../funciones/datos.txt";
	include("../../funciones/conexbd.php");
	include("../../funciones/librerias.php"); 

/*$consulta=array_recibe($_GET['imprimir']); 
$consultar=decryptData("blowfish", "cfb", "a", $consulta['0'], $consulta['1']);	*/

$lin_oc_id=$_GET['imprimir'];
$mysqlconsult=mysql_query("SELECT com_inventario.*,NOW() as fecha,com_productos.codbarras,com_productos.nombre FROM com_inventario 
LEFT JOIN com_productos ON com_productos.Id=com_inventario.producto_id
WHERE lineaoc_id in ($lin_oc_id)",$conexion);

/*echo "SELECT com_inventario.*,NOW() as fecha,com_productos.codbarras,com_productos.nombre FROM com_inventario 
LEFT JOIN com_productos ON com_productos.Id=com_inventario.producto_id
WHERE lineaoc_id in ($lin_oc_id)";*/

for($a=0;$a<2900;$a++){
	
}
/** Error reporting */
error_reporting(0);

/** Include path **/
set_include_path(get_include_path() . PATH_SEPARATOR . '../Classes/');

/** PHPExcel */
include 'PHPExcel.php';

/** PHPExcel_IOFactory */
include 'PHPExcel/IOFactory.php';

// Create new PHPExcel object
//echo date('H:i:s') . " Create new PHPExcel object\n";
$objPHPExcel=new PHPExcel();


// Set properties
echo date('H:i:s') . " Set properties 1 <br/>";
$objPHPExcel->getProperties()->setCreator($user);
$objPHPExcel->getProperties()->setLastModifiedBy($user);
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setDescription("Documento Generado por el Software Comertex - Libreria ExcelPHP.");
$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
$objPHPExcel->getProperties()->setCategory("Test result file");

$i=0;
while($impresion=mysql_fetch_assoc($mysqlconsult)){
	$i++;
	$nombre=stripAccents($impresion['nombre']);
	$codbarras=$impresion['codbarras'];
	$idinventario=$impresion['Id'];
	$fecha=$impresion['fecha'];
	$rfid=$impresion['RFID'];

	//echo $barrio.",".$zona.",".$ciudad."<br/>";
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $nombre);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $codbarras);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $idinventario);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $fecha);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $rfid);

} 
echo date('H:i:s') . " Set properties 2 <br/>";
$objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Arial');
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_DEFAULT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);

$objPHPExcel->setActiveSheetIndex(0);
/*$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', date('His').'.xlsx', __FILE__));*/

echo date('H:i:s') . " Write to CSV format3\n";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
$objWriter->setDelimiter(';');
$objWriter->setEnclosure('');
$objWriter->setLineEnding("\r\n");
$objWriter->setSheetIndex(0);
$objWriter->save(str_replace('.php', '.csv', __FILE__));

echo date('H:i:s') . " Read from CSV format4\n";
$objReader = PHPExcel_IOFactory::createReader('CSV');
$objReader->setDelimiter(';');
$objReader->setEnclosure('');
$objReader->setLineEnding("\r\n");
$objReader->setSheetIndex(0);
$objPHPExcelFromCSV = $objReader->load(str_replace('.php', '.csv', __FILE__));

echo date('H:i:s') . " Write to Excel2007 format5\n";
$objWriter2007 = PHPExcel_IOFactory::createWriter($objPHPExcelFromCSV, 'Excel2007');
$objWriter2007->save(str_replace('.php', '.xlsx', __FILE__));

// Echo memory peak usage
echo date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB\r\n";

// Echo done
echo date('H:i:s') . " Done writing files.\r\n";





?>
