<?php

namespace app\helpers;

use Yii;

class Consultasbasicas {
    
    
    
    public function LoadFiltroCantones(){
        
        $_sqlcantones = \app\models\gisindicadores\Localizacion::find()->where(['id_tipolocalizacion'=>'2'])->with('localizacionpadre')->all();
        $vbuscador = array();
 
        foreach($_sqlcantones as $_canton){
          
            $vbuscador[]=['value'=>$_canton['nombre'].'-'.$_canton["localizacionpadre"]->nombre,'label'=>$_canton['nombre'].'-'.$_canton["localizacionpadre"]->nombre,'id'=>$_canton['cod_oficial']];
        }
        
        return $vbuscador;
    }
    
}
