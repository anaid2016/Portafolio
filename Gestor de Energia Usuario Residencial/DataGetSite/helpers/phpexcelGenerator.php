<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\helpers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\IOFactory;


/**
 * Description of phpexcelGenerator
 *
 * @author ANAID
 */
class phpexcelGenerator {
   
    
    
     /*
     * datagenerator es un vector 
      *     header: titulos ['titulo1','titulo2','titulo3']
      *     data: es un vector de vectores por cada linea ['v1','v2','v3'],['v1','v2','v3']
      *     'title': es un valor titulo del archivo
      *     'subject': para información metadata archivo
      *     'description': Descripcion del archivo
      *     'keywords': palabras clave
      *     'setcategory': set categoria
     */
    
    public function generarExcel($datagenerator,$sheets=1){
        
        for ($i = 'A'; $i !== 'AZ'; $i++){
            $alphabet[] = $i;
        }
//        $alphabet = range('A', 'Z');
        $_header = $datagenerator['header'];
        $_data = $datagenerator['data'];
        $_bckground = $datagenerator['bckground'];
        $_usuariocreado = '1';                  //Aqui falta mandarle el id del usuario
        
        /*
         * Aplicando Estilos
         * Ejemplo color 'FFCCFFCC'
         */
        
        $sharedStyle1 = new Style();
        $sharedStyle2 = new Style();

        $sharedStyle1->applyFromArray(
            ['fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => $_bckground[0]],
            ],
                'borders' => [
                    'bottom' => ['borderStyle' => Border::BORDER_THIN],
                    'right' => ['borderStyle' => Border::BORDER_MEDIUM],
                ],
            ]
        );

        $sharedStyle2->applyFromArray(
            ['fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => $_bckground[1]],
            ],
                'borders' => [
                    'bottom' => ['borderStyle' => Border::BORDER_THIN],
                    'right' => ['borderStyle' => Border::BORDER_MEDIUM],
                ],
            ]
        );
        
        
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
        ->setCreator($_usuariocreado)
        ->setLastModifiedBy($_usuariocreado)
        ->setTitle($datagenerator['title'])
        ->setSubject($datagenerator['subject'])
        ->setDescription($datagenerator['description'])
        ->setKeywords($datagenerator['keywords'])
        ->setCategory($datagenerator['setcategory']);
        
        
       
        
        for($a=0;$a<$sheets;$a++){
            
            
            $spreadsheet->setActiveSheetIndex($a);
             /*
            * Agregando Titulos
            */
           if(!empty($_header)){
                for($b=0;$b<count($_header);$b++){
                    $spreadsheet->getActiveSheet()->setCellValue($alphabet[$b].'1', $_header[$b]);
                    $lastcolumn = $alphabet[$b];
                }   
           }
           
           /*
            * Agregando Texto
            */
            if(!empty($_data)){
               
                for($c=0;$c<count($_data);$c++){
                    
                    $_linea = $_data[$c];
                    $e=0;
                   
                    foreach($_linea as $dato){
                        $f=($c+2);
                        $spreadsheet->getActiveSheet()->setCellValue($alphabet[$e].$f, $dato);
                        $lastdatacolumn = $alphabet[$e];
                        $e+=1;
                    }
                    
                }   
            }
            
        }
        
       
        $spreadsheet->getActiveSheet()->duplicateStyle($sharedStyle1,'A1:'.$lastcolumn.'1');
        $spreadsheet->getActiveSheet()->duplicateStyle($sharedStyle2,'A2:'.$lastdatacolumn.$f);
        
        $spreadsheet->getDefaultStyle()->getFont()->setName('Tahoma');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
        
        
        foreach(range('A','Z') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }
        


//        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
//        $writer->save('php://output');
//        exit();
        
//        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
//        $writer->save('Sgap Registro Lecturas.xls'); 
//        return true;
        
        
//       
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$datagenerator['title'].'.xlsx"');
        header('Cache-Control: max-age=0');
//        // If you're serving to IE 9, then the following may be needed
//        header('Cache-Control: max-age=1');
//
//        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
//
//        
////        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
////        $writer->save("05featuredemo.xlsx");
//
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
    
}
