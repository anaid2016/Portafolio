<?php

namespace app\tests\unit\models\gisindicadores;

use Yii;
use yii\codeception\TestCase;
use Codeception\Specify;
use Codeception\Util\Debug;
use app\models\gisindicadores\Glosario;
/**
 * Este es el unit test para la clase "glosario".
 *
 * @property int4 $cod_glosario
 * @property varchar $nombre
 * @property varchar $descripcion
 */
class GlosarioTest extends \Codeception\Test\Unit
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
        $tester = new Glosario();
        $tester->cod_glosario = "Ingresar valor de pruebas para el campo cod_glosario de tipo int4";
        $tester->nombre = "Ingresar valor de pruebas para el campo nombre de tipo varchar";
        $tester->descripcion = "Ingresar valor de pruebas para el campo descripcion de tipo varchar";
            
        expect_that($tester->validate());
        // en caso de incluir valores errados para el modelo: expect_not($model->validate());
        return $tester;
    }
    
    public function testInsert()                                                             
    {                                                                                        
        $tester = new Glosario;
        $tester->cod_glosario = "Ingresar valor de pruebas para el campo cod_glosario de tipo int4";
        $tester->nombre = "Ingresar valor de pruebas para el campo nombre de tipo varchar";
        $tester->descripcion = "Ingresar valor de pruebas para el campo descripcion de tipo varchar";
            
        expect_that($tester->save());
        
        /**
        Esta prueba tambie puede ser evauada con Asserts, ejemplo:
        $tester->save();
        $this->assertNotNull($tester,                                                          
            'Glosario  Errors no se puede insertar en la base de datos.'); 
            */
        
        return $tester;
    }                     
    
    
    public function testSelect()                                                          
    {                                                                                        
        $tester = Glosario::findOne(                                                               
        [
           'cod_glosario' => "Ingresar valor de pruebas para el campo cod_glosario de tipo int4",
           'nombre' => "Ingresar valor de pruebas para el campo nombre de tipo varchar",
           'descripcion' => "Ingresar valor de pruebas para el campo descripcion de tipo varchar",
          ]);                                                
        
        
        // caso exitoso de consulta
        $this->assertNotNull($tester,                                                          
            'Glosario No se puede consultar en la base de datos, retorna nulo produciendose un error'); 
             /** Es posible tambien relizr con asserts, ejemplos
            en caso de un  retorno de un valor en caso de esperar nulo
        $this->assertNull($tester,                                                          
            'Glosario Ee puede consultar en la base de datos.');   */
            
            return $tester;
    }   
    
     
    public function testDelete()                                                             
    {                                                                                        
      
       $tester = Glosario::findOne(                                                               
        [
           'cod_glosario' => "Ingresar valor de pruebas para el campo cod_glosario de tipo int4",
           'nombre' => "Ingresar valor de pruebas para el campo nombre de tipo varchar",
           'descripcion' => "Ingresar valor de pruebas para el campo descripcion de tipo varchar",
         ]);              

       expect_that($tester->delete());
    }   

    
    
    public function testTableName()
    {
        $table= Glosario::tableName();
        $this->assertNotEmpty($table,                                                          
            'Se devolvio vacio el nombre de la tabla, se produjo un error '.$table); 

    }
    


    
    
    public function testRules()
    {
        $tester = new Glosario();
        $rules= $tester->rules();
         $this->assertNotEmpty($rules,
            'Se devolvio vacio el array de rules');  
    }


    
    
    public function testAttributeLabels()
    {
        $tester = new Glosario();
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
         expect($tester->cod_glosario)->equals('Ingresar valor de pruebas para el campo cod_glosario de tipo int4');
         expect($tester->nombre)->equals('Ingresar valor de pruebas para el campo nombre de tipo varchar');
         expect($tester->descripcion)->equals('Ingresar valor de pruebas para el campo descripcion de tipo varchar');
      }

}
