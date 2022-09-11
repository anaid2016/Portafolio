<?php

namespace app\tests\unit\models\gisindicadores;

use Yii;
use yii\codeception\TestCase;
use Codeception\Specify;
use Codeception\Util\Debug;
use app\models\gisindicadores\IndicadorParametro;
/**
 * Este es el unit test para la clase "indicador_parametro".
 *
 * @property int4 $cod_indi_param
 * @property varchar $nombre
 * @property varchar $sigla
 * @property varchar $descripcion
 * @property varchar $formula
 * @property bpchar $tipo
 * @property int4 $cod_area
 * @property varchar $unidad
 * @property varchar $descr_relacion_param
 * @property bpchar $estado
 * @property date $fecha_desde
 * @property date $fecha_hasta
 * @property bpchar $tipo_dato
 * @property int4 $relevancia_indicador
 * @property varchar $tipo_calc_parametro
 * @property numeric $valor_cumplimiento
 *
 * @property DesempenoIndiParam[] $desempenoIndiParams
 * @property Hechos[] $hechos
 * @property AreaIndicaParam $codArea
 * @property RelacionParamIndicador[] $relacionParamIndicadors
 * @property RelacionParamIndicador[] $relacionParamIndicadors0
 * @property IndicadorParametro[] $codParametros
 * @property IndicadorParametro[] $codIndicadors
 */
class IndicadorParametroTest extends \Codeception\Test\Unit
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
        $tester = new IndicadorParametro();
        $tester->cod_indi_param = "Ingresar valor de pruebas para el campo cod_indi_param de tipo int4";
        $tester->nombre = "Ingresar valor de pruebas para el campo nombre de tipo varchar";
        $tester->sigla = "Ingresar valor de pruebas para el campo sigla de tipo varchar";
        $tester->descripcion = "Ingresar valor de pruebas para el campo descripcion de tipo varchar";
        $tester->formula = "Ingresar valor de pruebas para el campo formula de tipo varchar";
        $tester->tipo = "Ingresar valor de pruebas para el campo tipo de tipo bpchar";
        $tester->cod_area = "Ingresar valor de pruebas para el campo cod_area de tipo int4";
        $tester->unidad = "Ingresar valor de pruebas para el campo unidad de tipo varchar";
        $tester->descr_relacion_param = "Ingresar valor de pruebas para el campo descr_relacion_param de tipo varchar";
        $tester->estado = "Ingresar valor de pruebas para el campo estado de tipo bpchar";
        $tester->fecha_desde = "Ingresar valor de pruebas para el campo fecha_desde de tipo date";
        $tester->fecha_hasta = "Ingresar valor de pruebas para el campo fecha_hasta de tipo date";
        $tester->tipo_dato = "Ingresar valor de pruebas para el campo tipo_dato de tipo bpchar";
        $tester->relevancia_indicador = "Ingresar valor de pruebas para el campo relevancia_indicador de tipo int4";
        $tester->tipo_calc_parametro = "Ingresar valor de pruebas para el campo tipo_calc_parametro de tipo varchar";
        $tester->valor_cumplimiento = "Ingresar valor de pruebas para el campo valor_cumplimiento de tipo numeric";
            
        expect_that($tester->validate());
        // en caso de incluir valores errados para el modelo: expect_not($model->validate());
        return $tester;
    }
    
    public function testInsert()                                                             
    {                                                                                        
        $tester = new IndicadorParametro;
        $tester->cod_indi_param = "Ingresar valor de pruebas para el campo cod_indi_param de tipo int4";
        $tester->nombre = "Ingresar valor de pruebas para el campo nombre de tipo varchar";
        $tester->sigla = "Ingresar valor de pruebas para el campo sigla de tipo varchar";
        $tester->descripcion = "Ingresar valor de pruebas para el campo descripcion de tipo varchar";
        $tester->formula = "Ingresar valor de pruebas para el campo formula de tipo varchar";
        $tester->tipo = "Ingresar valor de pruebas para el campo tipo de tipo bpchar";
        $tester->cod_area = "Ingresar valor de pruebas para el campo cod_area de tipo int4";
        $tester->unidad = "Ingresar valor de pruebas para el campo unidad de tipo varchar";
        $tester->descr_relacion_param = "Ingresar valor de pruebas para el campo descr_relacion_param de tipo varchar";
        $tester->estado = "Ingresar valor de pruebas para el campo estado de tipo bpchar";
        $tester->fecha_desde = "Ingresar valor de pruebas para el campo fecha_desde de tipo date";
        $tester->fecha_hasta = "Ingresar valor de pruebas para el campo fecha_hasta de tipo date";
        $tester->tipo_dato = "Ingresar valor de pruebas para el campo tipo_dato de tipo bpchar";
        $tester->relevancia_indicador = "Ingresar valor de pruebas para el campo relevancia_indicador de tipo int4";
        $tester->tipo_calc_parametro = "Ingresar valor de pruebas para el campo tipo_calc_parametro de tipo varchar";
        $tester->valor_cumplimiento = "Ingresar valor de pruebas para el campo valor_cumplimiento de tipo numeric";
            
        expect_that($tester->save());
        
        /**
        Esta prueba tambie puede ser evauada con Asserts, ejemplo:
        $tester->save();
        $this->assertNotNull($tester,                                                          
            'IndicadorParametro  Errors no se puede insertar en la base de datos.'); 
            */
        
        return $tester;
    }                     
    
    
    public function testSelect()                                                          
    {                                                                                        
        $tester = IndicadorParametro::findOne(                                                               
        [
           'cod_indi_param' => "Ingresar valor de pruebas para el campo cod_indi_param de tipo int4",
           'nombre' => "Ingresar valor de pruebas para el campo nombre de tipo varchar",
           'sigla' => "Ingresar valor de pruebas para el campo sigla de tipo varchar",
           'descripcion' => "Ingresar valor de pruebas para el campo descripcion de tipo varchar",
           'formula' => "Ingresar valor de pruebas para el campo formula de tipo varchar",
           'tipo' => "Ingresar valor de pruebas para el campo tipo de tipo bpchar",
           'cod_area' => "Ingresar valor de pruebas para el campo cod_area de tipo int4",
           'unidad' => "Ingresar valor de pruebas para el campo unidad de tipo varchar",
           'descr_relacion_param' => "Ingresar valor de pruebas para el campo descr_relacion_param de tipo varchar",
           'estado' => "Ingresar valor de pruebas para el campo estado de tipo bpchar",
           'fecha_desde' => "Ingresar valor de pruebas para el campo fecha_desde de tipo date",
           'fecha_hasta' => "Ingresar valor de pruebas para el campo fecha_hasta de tipo date",
           'tipo_dato' => "Ingresar valor de pruebas para el campo tipo_dato de tipo bpchar",
           'relevancia_indicador' => "Ingresar valor de pruebas para el campo relevancia_indicador de tipo int4",
           'tipo_calc_parametro' => "Ingresar valor de pruebas para el campo tipo_calc_parametro de tipo varchar",
           'valor_cumplimiento' => "Ingresar valor de pruebas para el campo valor_cumplimiento de tipo numeric",
          ]);                                                
        
        
        // caso exitoso de consulta
        $this->assertNotNull($tester,                                                          
            'IndicadorParametro No se puede consultar en la base de datos, retorna nulo produciendose un error'); 
             /** Es posible tambien relizr con asserts, ejemplos
            en caso de un  retorno de un valor en caso de esperar nulo
        $this->assertNull($tester,                                                          
            'IndicadorParametro Ee puede consultar en la base de datos.');   */
            
            return $tester;
    }   
    
     
    public function testDelete()                                                             
    {                                                                                        
      
       $tester = IndicadorParametro::findOne(                                                               
        [
           'cod_indi_param' => "Ingresar valor de pruebas para el campo cod_indi_param de tipo int4",
           'nombre' => "Ingresar valor de pruebas para el campo nombre de tipo varchar",
           'sigla' => "Ingresar valor de pruebas para el campo sigla de tipo varchar",
           'descripcion' => "Ingresar valor de pruebas para el campo descripcion de tipo varchar",
           'formula' => "Ingresar valor de pruebas para el campo formula de tipo varchar",
           'tipo' => "Ingresar valor de pruebas para el campo tipo de tipo bpchar",
           'cod_area' => "Ingresar valor de pruebas para el campo cod_area de tipo int4",
           'unidad' => "Ingresar valor de pruebas para el campo unidad de tipo varchar",
           'descr_relacion_param' => "Ingresar valor de pruebas para el campo descr_relacion_param de tipo varchar",
           'estado' => "Ingresar valor de pruebas para el campo estado de tipo bpchar",
           'fecha_desde' => "Ingresar valor de pruebas para el campo fecha_desde de tipo date",
           'fecha_hasta' => "Ingresar valor de pruebas para el campo fecha_hasta de tipo date",
           'tipo_dato' => "Ingresar valor de pruebas para el campo tipo_dato de tipo bpchar",
           'relevancia_indicador' => "Ingresar valor de pruebas para el campo relevancia_indicador de tipo int4",
           'tipo_calc_parametro' => "Ingresar valor de pruebas para el campo tipo_calc_parametro de tipo varchar",
           'valor_cumplimiento' => "Ingresar valor de pruebas para el campo valor_cumplimiento de tipo numeric",
         ]);              

       expect_that($tester->delete());
    }   

    
    
    public function testTableName()
    {
        $table= IndicadorParametro::tableName();
        $this->assertNotEmpty($table,                                                          
            'Se devolvio vacio el nombre de la tabla, se produjo un error '.$table); 

    }
    


    
    
    public function testRules()
    {
        $tester = new IndicadorParametro();
        $rules= $tester->rules();
         $this->assertNotEmpty($rules,
            'Se devolvio vacio el array de rules');  
    }


    
    
    public function testAttributeLabels()
    {
        $tester = new IndicadorParametro();
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
         expect($tester->cod_indi_param)->equals('Ingresar valor de pruebas para el campo cod_indi_param de tipo int4');
         expect($tester->nombre)->equals('Ingresar valor de pruebas para el campo nombre de tipo varchar');
         expect($tester->sigla)->equals('Ingresar valor de pruebas para el campo sigla de tipo varchar');
         expect($tester->descripcion)->equals('Ingresar valor de pruebas para el campo descripcion de tipo varchar');
         expect($tester->formula)->equals('Ingresar valor de pruebas para el campo formula de tipo varchar');
         expect($tester->tipo)->equals('Ingresar valor de pruebas para el campo tipo de tipo bpchar');
         expect($tester->cod_area)->equals('Ingresar valor de pruebas para el campo cod_area de tipo int4');
         expect($tester->unidad)->equals('Ingresar valor de pruebas para el campo unidad de tipo varchar');
         expect($tester->descr_relacion_param)->equals('Ingresar valor de pruebas para el campo descr_relacion_param de tipo varchar');
         expect($tester->estado)->equals('Ingresar valor de pruebas para el campo estado de tipo bpchar');
         expect($tester->fecha_desde)->equals('Ingresar valor de pruebas para el campo fecha_desde de tipo date');
         expect($tester->fecha_hasta)->equals('Ingresar valor de pruebas para el campo fecha_hasta de tipo date');
         expect($tester->tipo_dato)->equals('Ingresar valor de pruebas para el campo tipo_dato de tipo bpchar');
         expect($tester->relevancia_indicador)->equals('Ingresar valor de pruebas para el campo relevancia_indicador de tipo int4');
         expect($tester->tipo_calc_parametro)->equals('Ingresar valor de pruebas para el campo tipo_calc_parametro de tipo varchar');
         expect($tester->valor_cumplimiento)->equals('Ingresar valor de pruebas para el campo valor_cumplimiento de tipo numeric');
      }

}
