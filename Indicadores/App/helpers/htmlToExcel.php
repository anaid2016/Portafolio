<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\helpers;

use Yii;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\helpers\Html;

/**
 * Description of htmlToExcel
 *
 * @author Diana B
 * 
 * @htmlContent -> Contenido html tipo tabla
 * @namefile->nombre del archivo sin xlsx
 * @descarga -> true descara el archivo automaticamente, false genera el archivo en la carpeta filexls
 *  Si descarga es igual a false, regresa un 1 si el archivo fue generado
 * 
 * Si ocurre algun error devuelve 0, y la variable $this->error entrega un string con el error
 * 
 * 
 * 
 */
class htmlToExcel {
    
    public $htmlContent; 
    public $namefile;
    public $descarga = true;
    public $error;
    public $filecss;
    
    public function genExcel(){
        
        /*Validando HTML que se encuentre correcto*/
        $validador = $this->validateHTML();
        if(!empty($validador)){
            $this->error = $validador;
            return '0';
        }
        
        /*Generando archivo de excel*/
        $tmpfile = tempnam(sys_get_temp_dir(), 'html');
        file_put_contents($tmpfile, $this->htmlContent);
        
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
        $spreadsheet = $reader->load($tmpfile);
        
        /*Aplicando stilos*/
        if(!empty($this->filecss)){
            
            /*Revisando estilos a aplicar*/
            $_vclases=$this->classceldas($this->htmlContent);

            //Convirtiendo css en estilos
            $_arraystilos=$this->responsecss($this->filecss);
                        
            
            
            foreach($_vclases as $_clave){
                
                $clase_aplicar=$_clave['class'];
                $celda_aplicar=$_clave['celda'];
                 
                if(!empty($clase_aplicar)){
                    $spreadsheet->getActiveSheet()->getStyle($celda_aplicar)->applyFromArray($_arraystilos[$clase_aplicar]);                 
                }
            }
        }
       
        
        /*Borrando archivo temporal ya no se necesita =============================*/
        unlink($tmpfile); 
         

        /*Generando Archivo ==============================================*/
        if($this->descarga === true){
            
            //Encabezados del archivo =======================================================
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$this->namefile.'.xlsx"');
            header('Cache-Control: max-age=0');

            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            exit;
            
        }else{
            
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save('filesxls/'.$this->namefile.'.xls'); 
            return '1';
        }
    }
    
    protected function validateHTML(){
        
        \libxml_use_internal_errors(true);
        $dom = New \DOMDocument();
        $dom->loadHTML($this->htmlContent);
        $errors = \libxml_get_errors();
        $returnstring="";
        
        if (!empty($errors)) {
            foreach($errors as $error){
                $returnstring.="Error en Linea: ".$error->line." Mensaje de Error: ".$error->message;
            }
            \libxml_clear_errors();
        }

        return $returnstring;
    }
    
    
    /*
     * Funcion que entrega el css a aplicar en cada celda
     * Entrada: String HTML solo aplica para tablas
     * Salida: Array asociativo con  class -> clase de la celda, celda -> celda sobre la cual se aplica
     * text->contenidod de la celda  
     */
    protected function classceldas($_stringhtml){
       
       
       // Create a new DOM Document to hold our webpage structure 
        $xml = new \DOMDocument(); 

        // Load the url's contents into the DOM 
        $xml->loadHTML($_stringhtml); 

        // Empty array to hold all links to return 
        $_class = array(); 
        $_ln=0;

        $_arraycolm=['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
            'AA',	'AB',	'AC',	'AD',	'AE',	'AF',	'AG',	'AH',	'AI',	'AJ',	'AK',	'AL',	'AM',	'AN',	'AO',	'AP',	'AQ',	'AR',	'AS',	'AT',	'AU',	'AV',	'AW',	'AX',	'AY',   'AZ',
            'BA',	'BB',	'BC',	'BD',	'BE',	'BF',	'BG',	'BH',	'BI',	'BJ',	'BK',	'BL',	'BM',	'BN',	'BO',	'BP',	'BQ',	'BR',	'BS',	'BT',	'BU',	'BV',	'BW',	'BX',	'BY',	'BZ',
            'CA',	'CB',	'CC',	'CD',	'CE',	'CF',	'CG',	'CH',	'CI',	'CJ',	'CK',	'CL',	'CM',	'CN',	'CO',	'CP',	'CQ',	'CR',	'CS',	'CT',	'CU',	'CV',	'CW',	'CX',	'CY',	'CZ',
            'DA',	'DB',	'DC',	'DD',	'DE',	'DF',	'DG',	'DH',	'DI',	'DJ',	'DK',	'DL',	'DM',	'DN',	'DO',	'DP',	'DQ',	'DR',	'DS',	'DT',	'DU',	'DV',	'DW',	'DX',	'DY',	'DZ',
            'EA',	'EB',	'EC',	'ED',	'EE',	'EF',	'EG',	'EH',	'EI',	'EJ',	'EK',	'EL',	'EM',	'EN',	'EO',	'EP',	'EQ',	'ER',	'ES',	'ET',	'EU',	'EV',	'EW',	'EX',	'EY',	'EZ',
            'FA',	'FB',	'FC',	'FD',	'FE',	'FF',	'FG',	'FH',	'FI',	'FJ',	'FK',	'FL',	'FM',	'FN',	'FO',	'FP',	'FQ',	'FR',	'FS',	'FT',	'FU',	'FV',	'FW',	'FX',	'FY',	'FZ',
            'GA',	'GB',	'GC',	'GD',	'GE',	'GF',	'GG',	'GH',	'GI',	'GJ',	'GK',	'GL',	'GM',	'GN',	'GO',	'GP',	'GQ',	'GR',	'GS',	'GT',	'GU',	'GV',	'GW',	'GX',	'GY',	'GZ',
            'HA',	'HB',	'HC',	'HD',	'HE',	'HF',	'HG',	'HH',	'HI',	'HJ',	'HK',	'HL',	'HM',	'HN',	'HO',	'HP',	'HQ',	'HR',	'HS',	'HT',	'HU',	'HV',	'HW',	'HX',	'HY',	'HZ',
            'IA',	'IB',	'IC',	'ID',	'IE',	'IF',	'IG',	'IH',	'II',	'IJ',	'IK',	'IL',	'IM',	'IN',	'IO',	'IP',	'IQ',	'IR',	'IS',	'IT',	'IU',	'IV',	'IW',	'IX',	'IY',	'IZ',
            'JA',	'JB',	'JC',	'JD',	'JE',	'JF',	'JG',	'JH',	'JI',	'JJ',	'JK',	'JL',	'JM',	'JN',	'JO',	'JP',	'JQ',	'JR',	'JS',	'JT',	'JU',	'JV',	'JW',	'JX',	'JY',	'JZ',
            'KA',	'KB',	'KC',	'KD',	'KE',	'KF',	'KG',	'KH',	'KI',	'KJ',	'KK',	'KL',	'KM',	'KN',	'KO',	'KP',	'KQ',	'KR',	'KS',	'KT',	'KU',	'KV',	'KW',	'KX',	'KY',	'KZ',
            'LA',	'LB',	'LC',	'LD',	'LE',	'LF',	'LG',	'LH',	'LI',	'LJ',	'LK',	'LL',	'LM',	'LN',	'LO',	'LP',	'LQ',	'LR',	'LS',	'LT',	'LU',	'LV',	'LW',	'LX',	'LY',	'LZ',
            'MA',	'MB',	'MC',	'MD',	'ME',	'MF',	'MG',	'MH',	'MI',	'MJ',	'MK',	'ML',	'MM',	'MN',	'MO',	'MP',	'MQ',	'MR',	'MS',	'MT',	'MU',	'MV',	'MW',	'MX',	'MY',	'MZ',
            'NA',	'NB',	'NC',	'ND',	'NE',	'NF',	'NG',	'NH',	'NI',	'NJ',	'NK',	'NL',	'NM',	'NN',	'NO',	'NP',	'NQ',	'NR',	'NS',	'NT',	'NU',	'NV',	'NW',	'NX',	'NY',	'NZ',
            'OA',	'OB',	'OC',	'OD',	'OE',	'OF',	'OG',	'OH',	'OI',	'OJ',	'OK',	'OL',	'OM',	'ON',	'OO',	'OP',	'OQ',	'OR',	'OS',	'OT',	'OU',	'OV',	'OW',	'OX',	'OY',	'OZ',
            'PA',	'PB',	'PC',	'PD',	'PE',	'PF',	'PG',	'PH',	'PI',	'PJ',	'PK',	'PL',	'PM',	'PN',	'PO',	'PP',	'PQ',	'PR',	'PS',	'PT',	'PU',	'PV',	'PW',	'PX',	'PY',	'PZ',
            'QA',	'QB',	'QC',	'QD',	'QE',	'QF',	'QG',	'QH',	'QI',	'QJ',	'QK',	'QL',	'QM',	'QN',	'QO',	'QP',	'QQ',	'QR',	'QS',	'QT',	'QU',	'QV',	'QW',	'QX',	'QY',	'QZ',
            'RA',	'RB',	'RC',	'RD',	'RE',	'RF',	'RG',	'RH',	'RI',	'RJ',	'RK',	'RL',	'RM',	'RN',	'RO',	'RP',	'RQ',	'RR',	'RS',	'RT',	'RU',	'RV',	'RW',	'RX',	'RY',	'RZ',
            'SA',	'SB',	'SC',	'SD',	'SE',	'SF',	'SG',	'SH',	'SI',	'SJ',	'SK',	'SL',	'SM',	'SN',	'SO',	'SP',	'SQ',	'SR',	'SS',	'ST',	'SU',	'SV',	'SW',	'SX',	'SY',	'SZ',
            'TA',	'TB',	'TC',	'TD',	'TE',	'TF',	'TG',	'TH',	'TI',	'TJ',	'TK',	'TL',	'TM',	'TN',	'TO',	'TP',	'TQ',	'TR',	'TS',	'TT',	'TU',	'TV',	'TW',	'TX',	'TY',	'TZ',
            'UA',	'UB',	'UC',	'UD',	'UE',	'UF',	'UG',	'UH',	'UI',	'UJ',	'UK',	'UL',	'UM',	'UN',	'UO',	'UP',	'UQ',	'UR',	'US',	'UT',	'UU',	'UV',	'UW',	'UX',	'UY',	'UZ',
            'VA',	'VB',	'VC',	'VD',	'VE',	'VF',	'VG',	'VH',	'VI',	'VJ',	'VK',	'VL',	'VM',	'VN',	'VO',	'VP',	'VQ',	'VR',	'VS',	'VT',	'VU',	'VV',	'VW',	'VX',	'VY',	'VZ',
            'WA',	'WB',	'WC',	'WD',	'WE',	'WF',	'WG',	'WH',	'WI',	'WJ',	'WK',	'WL',	'WM',	'WN',	'WO',	'WP',	'WQ',	'WR',	'WS',	'WT',	'WU',	'WV',	'WW',	'WX',	'WY',	'WZ',
            'XA',	'XB',	'XC',	'XD',	'XE',	'XF',	'XG',	'XH',	'XI',	'XJ',	'XK',	'XL',	'XM',	'XN',	'XO',	'XP',	'XQ',	'XR',	'XS',	'XT',	'XU',	'XV',	'XW',	'XX',	'XY',	'XZ',
            'YA',	'YB',	'YC',	'YD',	'YE',	'YF',	'YG',	'YH',	'YI',	'YJ',	'YK',	'YL',	'YM',	'YN',	'YO',	'YP',	'YQ',	'YR',	'YS',	'YT',	'YU',	'YV',	'YW',	'YX',	'YY',	'YZ',
            'ZA',	'ZB',	'ZC',	'ZD',	'ZE',	'ZF',	'ZG',	'ZH',	'ZI',	'ZJ',	'ZK',	'ZL',	'ZM',	'ZN',	'ZO',	'ZP',	'ZQ',	'ZR',	'ZS',	'ZT',	'ZU',	'ZV',	'ZW',	'ZX',	'ZY',	'ZZ',
            'AAA',	'AAB',	'AAC',	'AAD',	'AAE',	'AAF',	'AAG',	'AAH',	'AAI',	'AAJ',	'AAK',	'AAL',	'AAM',	'AAN',	'AAO',	'AAP',	'AAQ',	'AAR',	'AAS',	'AAT',	'AAU',	'AAV',	'AAW',	'AAX',	'AAY',	'AAZ',
            'ABA',	'ABB',	'ABC',	'ABD',	'ABE',	'ABF',	'ABG',	'ABH',	'ABI',	'ABJ',	'ABK',	'ABL',	'ABM',	'ABN',	'ABO',	'ABP',	'ABQ',	'ABR',	'ABS',	'ABT',	'ABU',	'ABV',	'ABW',	'ABX',	'ABY',	'ABZ',
            'ACA',	'ACB',	'ACC',	'ACD',	'ACE',	'ACF',	'ACG',	'ACH',	'ACI',	'ACJ',	'ACK',	'ACL',	'ACM',	'ACN',	'ACO',	'ACP',	'ACQ',	'ACR',	'ACS',	'ACT',	'ACU',	'ACV',	'ACW',	'ACX',	'ACY',	'ACZ',

            ];

        foreach($xml->getElementsByTagName('table') as $_table) {
            
		$_valuetable = $_table->nodeValue;
                
                if($_ln>0){
                   $_ln+=1; 
                }		
		foreach($_table->getElementsByTagName('tr') as $_lineas) {
			
			$_canttr = $_lineas->getElementsByTagName('tr');
			$_ln+=1;
			$_td=0;
			
			if($_canttr->length == 0){
				
				foreach($_lineas->getElementsByTagName('td') as $_celda) {
					
					if(!empty($_celda)){
                                            
						$_class[]=array('class' => trim($_celda->getAttribute('class')),'celda'=>$_arraycolm[$_td].''.$_ln,'text' => $_celda->nodeValue);
                                                
                                                if(!empty($_celda->getAttribute('colspan'))){
                                                    
                                                    $_apclase = trim($_celda->getAttribute('class'));
                                                    $_cantidadceldas=$_celda->getAttribute('colspan');
                                                    
                                                    for($col = 1; $col<$_cantidadceldas; $col++) {
                                                        $_tdnext=$_td+$col;
                                                        $_class[]=array('class' => trim($_apclase),'celda'=>$_arraycolm[$_tdnext].''.$_ln,'text' => $_celda->nodeValue);
                                                    }
                                                }
						$_td+=1;
					}
				}	
			}
		}	
        }
        return $_class;
    }
  
    
    /*Funcion conversora de CSS a estilos de PHPEXCEL*/
    public function responsecss($_archivocss){
        
        $_contenidocss = file_get_contents($_archivocss);
        $_vector1=explode("}",$_contenidocss);              //Pasando clases a vector
        $_filecss=array();
        $_clasescss=array();
        
        for($_css=0;$_css<count($_vector1);$_css++){
            $_clase= trim($_vector1[$_css]);
      
            if(!empty($_clase)){
         
                $_vectorint=explode("{",$_clase);
                
                //Asignando nombre de la clase==================================//
                $_nombreclase = trim(str_replace(".", "", $_vectorint[0]));
                
                //Asignando contenido de la clase===============================//
                $_vcontenido=explode(";",$_vectorint[1]);
                $_propiedades="";
                $_arrayexcel=array();
                
                /*Transformacion de las propiedades*/
                foreach($_vcontenido as $_propiedad){
                    
                    $_vpropiedad=explode(":",$_propiedad);
                    if(!empty($_vpropiedad[0]) and !empty($_vpropiedad[1])){
                        
                            
                        if(trim($_vpropiedad[0])=='text-align'){
                            
                            if(trim($_vpropiedad[1]) == 'right'){
                                
                                $_arrayexcel['alignment'] = array(
                                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                                );
                                        
                            }else if(trim($_vpropiedad[1]) == 'left'){
                                
                                $_arrayexcel['alignment'] = array(
                                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                                );
                            }else if(trim($_vpropiedad[1]) == 'center'){
                            
                                $_arrayexcel['alignment'] = array(
                                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                                );
                            }
                        }
                        
                        
                        else if(trim($_vpropiedad[0])=='border'){
                            
                                if(strpos($_vpropiedad[1],'solid') !== false){
                                    
                                    $_arrayexcel['borders']['allBorders']['borderStyle'] =  \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN;        
                                } 
                                if(strpos($_vpropiedad[1],'dotted') !== false){
                                    $_arrayexcel['borders']['allBorders']['borderStyle'] =  \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED;    
                                }
                                if(strpos($_vpropiedad[1],'double') !== false){
                                    $_arrayexcel['borders']['allBorders']['borderStyle'] =  \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE;   
                                }
                                if(strpos($_vpropiedad[1],'dashed') !== false){
                                    $_arrayexcel['borders']['allBorders']['borderStyle'] =  \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DASHED;   
                                }
                                if(strpos($_vpropiedad[1],'#') !== false){ 
                                    
                                    $_color= '00'.substr($_vpropiedad[1], (strpos(trim($_vpropiedad[1]),'#')+1),6);
                                    $_arrayexcel['borders']['allBorders']['color']['argb'] = $_color;       
                                }
                        }
                        
                        
                        else if(trim($_vpropiedad[0])=='border-right'){
                            
                            if(strpos($_vpropiedad[1],'solid') !== false){
                                    
                                    $_arrayexcel['borders']['right']['borderStyle'] =  \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN;        
                                } 
                                if(strpos($_vpropiedad[1],'dotted') !== false){
                                    $_arrayexcel['borders']['right']['borderStyle'] =  \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED;    
                                }
                                if(strpos($_vpropiedad[1],'double') !== false){
                                    $_arrayexcel['borders']['right']['borderStyle'] =  \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE;   
                                }
                                if(strpos($_vpropiedad[1],'dashed') !== false){
                                    $_arrayexcel['borders']['right']['borderStyle'] =  \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DASHED;   
                                }
                                if(strpos($_vpropiedad[1],'#') !== false){        
                                    $_color= '00'.substr($_vpropiedad[1], (strpos(trim($_vpropiedad[1]),'#')+1),6);
                                    $_arrayexcel['borders']['right']['color']['argb'] = $_color;       
                                }
                        }
                        
                        
                        
                        else if(trim($_vpropiedad[0])=='border-left'){
                            
                            if(strpos($_vpropiedad[1],'solid') !== false){
                                    
                                    $_arrayexcel['borders']['left']['borderStyle'] =  \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN;        
                                } 
                                
                                if(strpos($_vpropiedad[1],'dotted') !== false){
                                    $_arrayexcel['borders']['left']['borderStyle'] =  \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED;    
                                }
                                
                                if(strpos($_vpropiedad[1],'double') !== false){
                                    $_arrayexcel['borders']['left']['borderStyle'] =  \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE;   
                                }
                                
                                if(strpos($_vpropiedad[1],'dashed') !== false){
                                    $_arrayexcel['borders']['left']['borderStyle'] =  \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DASHED;   
                                }
                                
                                if(strpos($_vpropiedad[1],'#') !== false){        
                                    $_color= '00'.substr($_vpropiedad[1], (strpos(trim($_vpropiedad[1]),'#')+1),6);
                                    $_arrayexcel['borders']['left']['color']['argb'] = $_color;       
                                }
                        }
                        
                        
                        else if(trim($_vpropiedad[0])=='border-bottom'){
                            
                            if(strpos($_vpropiedad[1],'solid') !== false){
                                    
                                    $_arrayexcel['borders']['bottom']['borderStyle'] =  \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN;        
                                } 
                                
                                if(strpos($_vpropiedad[1],'dotted') !== false){
                                    $_arrayexcel['borders']['bottom']['borderStyle'] =  \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED;    
                                }
                                
                                if(strpos($_vpropiedad[1],'double') !== false){
                                    $_arrayexcel['borders']['bottom']['borderStyle'] =  \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE;   
                                }
                                
                                if(strpos($_vpropiedad[1],'dashed') !== false){
                                    $_arrayexcel['borders']['bottom']['borderStyle'] =  \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DASHED;   
                                }
                                
                                
                                if(strpos($_vpropiedad[1],'#') !== false){        
                                   $_color= '00'.substr($_vpropiedad[1], (strpos(trim($_vpropiedad[1]),'#')+1),6);
                                   $_arrayexcel['borders']['bottom']['color']['argb'] = $_color;   
                                }
                        }
                        
                        
                        else if(trim($_vpropiedad[0])=='background-color'){
                            
                            $_color= trim(str_replace("#","",$_vpropiedad[1]));
                            $_arrayexcel['fill']['fillType'] = \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID;
                            $_arrayexcel['fill']['startColor']['rgb'] = $_color;  
                            $_arrayexcel['fill']['endColor']['rgb'] = $_color;
                        }
                    }
                }
                
                $styleArray[$_nombreclase]=$_arrayexcel;
                
            }
        }
        
        return $styleArray;
    }
}
