<?php

namespace app\tests\unit\models\gisindicadores;

use Yii;
use yii\codeception\TestCase;
use Codeception\Specify;
use Codeception\Util\Debug;
use app\models\gisindicadores\AreaIndicaParam;
/**
 * Este es el unit test para la clase "area_indica_param".
 *
 * @property int4 $id_cod_area
 * @property bpchar $sigla
 * @property varchar $nombre_area
 *
 * @property IndicadorParametro[] $indicadorParametros
 */
class AreaIndicaParamTest extends \Codeception\Test\Unit
{

    /**
     * @var \frontend\tests\UnitTester
     */

    public function _before()
    {
        
    }
                                                                                        
    public function _after()                                                              
    {             
                                                             
    }                
    
    
     /** en caso de querer utilizar Asserts por favor revisar la documentacion en http://codeception.com/docs/modules/Asserts */
    public function testValidate()                                                             
    {                                                                                        
        $tester = new AreaIndicaParam();
        $tester->id_cod_area = "Ingresar valor de pruebas para el campo id_cod_area de tipo int4";
        $tester->sigla = "Ingresar valor de pruebas para el campo sigla de tipo bpchar";
        $tester->nombre_area = "Ingresar valor de pruebas para el campo nombre_area de tipo varchar";
            
        expect_that($tester->validate());
        // en caso de incluir valores errados para el modelo: expect_not($model->validate());
        return $tester;
    }
    
    public function testInsert()                                                             
    {                                                                                        
        $tester = new AreaIndicaParam;
        $tester->id_cod_area = "Ingresar valor de pruebas para el campo id_cod_area de tipo int4";
        $tester->sigla = "Ingresar valor de pruebas para el campo sigla de tipo bpchar";
        $tester->nombre_area = "Ingresar valor de pruebas para el campo nombre_area de tipo varchar";
            
        expect_that($tester->save());
        
        /**
        Esta prueba tambie puede ser evauada con Asserts, ejemplo:
        $tester->save();
        $this->assertNotNull($tester,                                                          
            'AreaIndicaParam  Errors no se puede insertar en la base de datos.'); 
            */
        
        return $tester;
    }                     
    
    
    public function testSelect()                                                          
    {                                                                                        
        $tester = AreaIndicaParam::findOne(                                                               
        [
           'id_cod_area' => "Ingresar valor de pruebas para el campo id_cod_area de tipo int4",
           'sigla' => "Ingresar valor de pruebas para el campo sigla de tipo bpchar",
           'nombre_area' => "Ingresar valor de pruebas para el campo nombre_area de tipo varchar",
          ]);                                                
        
        
        // caso exitoso de consulta
        $this->assertNotNull($tester,                                                          
            'AreaIndicaParam No se puede consultar en la base de datos, retorna nulo produciendose un error'); 
             /** Es posible tambien relizr con asserts, ejemplos
            en caso de un  retorno de un valor en caso de esperar nulo
        $this->assertNull($tester,                                                          
            'AreaIndicaParam Ee puede consultar en la base de datos.');   */
            
            return $tester;
    }   
    
     
    public function testDelete()                                                             
    {                                                                                        
      
       $tester = AreaIndicaParam::findOne(                                                               
        [
           'id_cod_area' => "Ingresar valor de pruebas para el campo id_cod_area de tipo int4",
           'sigla' => "Ingresar valor de pruebas para el campo sigla de tipo bpchar",
           'nombre_area' => "Ingresar valor de pruebas para el campo nombre_area de tipo varchar",
         ]);              

       expect_that($tester->delete());
    }   

    
    
    public function testTableName()
    {
        $table= AreaIndicaParam::tableName();
        $this->assertNotEmpty($table,                                                          
            'Se devolvio vacio el nombre de la tabla, se produjo un error '.$table); 

    }
    


    
    
    public function testRules()
    {
        $tester = new AreaIndicaParam();
        $rules= $tester->rules();
         $this->assertNotEmpty($rules,
            'Se devolvio vacio el array de rules');  
    }


    
    
    public function testAttributeLabels()
    {
        $tester = new AreaIndicaParam();
        $labels= $tester->attributeLabels();
         $this->assertNotEmpty($labels,
            'Se devolvio vacio array con los labels ');  
        
    }
    
    
    /**
    *  The following line indicates that the parameter values entered here are derived from testSelect Output 
    * @depends testSelect
    */
   public function testModelProperty($tester)
   {
         expect($tester->id_cod_area)->equals('Ingresar valor de pruebas para el campo id_cod_area de tipo int4');
         expect($tester->sigla)->equals('Ingresar valor de pruebas para el campo sigla de tipo bpchar');
         expect($tester->nombre_area)->equals('Ingresar valor de pruebas para el campo nombre_area de tipo varchar');
      }

}
