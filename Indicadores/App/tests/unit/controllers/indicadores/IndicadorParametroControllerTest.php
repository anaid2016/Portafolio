<?php

namespace app\tests\unit\controllers\indicadores;

use Yii;
use app\controllers\indicadores\IndicadorParametroController;


/**
 * IndicadorParametroControllerTest implementa las acciones a través del sistema CRUD para el modelo IndicadorParametro.
 */
class IndicadorParametroControllerTest extends \Codeception\Test\Unit
{
    public function _before()
    {
       // declaraciones y asignacion de valores que se deben tener para realizar las funciones test
    }

                                                               
                                                                                             
    protected function _after()                                                              
    {             
            // funcion que se ejecuta despues de los test                                                      
    }                
   
    
    public function testBehaviors()
    {
        //Se declara el objeto a verificar
        $tester = new  IndicadorParametroController('IndicadorParametroController','app\controllers\indicadores\IndicadorParametroController');
        // se valida que se cree la instancia exitosamente
        $this->assertTrue($tester!=null);
        $this->assertInstanceOf('app\controllers\indicadores\IndicadorParametroController', $tester);
        
        //Se realiza el llamado a la funcion
        $behaviors= $tester->behaviors();
        
        // Se evalua el caso exitoso
        $this->assertNotEmpty($behaviors,
            'Se devolvio vacio behaviors');  
                        
    }
    
    

    
    public function testActionProgress(){

        //Se declara el objeto a verificar
        $tester = new  IndicadorParametroController('IndicadorParametroController','app\controllers\indicadores\IndicadorParametroController');
        // se valida que se cree la instancia exitosamente
        $this->assertTrue($tester!=null);
        $this->assertInstanceOf('app\controllers\indicadores\IndicadorParametroController', $tester);

        // Se declaran las variables, $urlroute=null,$id=null para el reenvio de la barra de progreso, la llave tiene valor por defecto null, si se desea se puede cambiar por una llave. 
        $urlroute='/indicadorparametro/index';
        $id=null;
        
        //Se ejecuta la funcion y se espera que realice todo
        expect_that($tester->actionProgress($urlroute,$id));
        
    }

	
	
    /**
     * Listado todos los datos del modelo IndicadorParametro que se encuentran en el tablename.
     * @return mixed
     */
    public function testActionIndex()
    {
    
        //Se declara el objeto a verificar
        $tester = new  IndicadorParametroController('IndicadorParametroController','app\controllers\indicadores\IndicadorParametroController');
        // se valida que se cree la instancia exitosamente
        $this->assertTrue($tester!=null);
        $this->assertInstanceOf('app\controllers\indicadores\IndicadorParametroController', $tester);
        
        
            // Se declaran los $queryParams a enviar los filtros
            $queryParams = ['IndicadorParametroSearch' => [
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
                              ]];
             
       
        // Se obtiene el resultado de action index     
        Yii::$app->request->queryParams=$queryParams;
       
        $actionIndex=Yii::$app->runAction('IndicadorParametroController/index');
   
        $this->assertNotNull($actionIndex);
       
    }

   
    
    public function testActionView()
    {       
        //Se declara el objeto a verificar
        $tester = new  IndicadorParametroController('IndicadorParametroController','app\controllers\indicadores\IndicadorParametroController');
        // se valida que se cree la instancia exitosamente
        $this->assertTrue($tester!=null);
        $this->assertInstanceOf('app\controllers\indicadores\IndicadorParametroController', $tester);
        
        // se deben declarar los valores de $id para enviar la llave
        
                        $id = 'valor adecuado para el tipo de dato del paramtero $id';
                                     // se realiza el action view, intrernamente usa la funcion findModel, a su vez utiliza el findone de Yii realizando la consulta con todos los valores de los parametros $id             
            $actionView=Yii::$app->runAction('IndicadorParametroController/view',['id' => $id]);
             
             // se evalua el caso exitoso
             $this->assertNotNull($actionView                  
                    'Se devolvio nullo actionView ');  
 
    }

       
    public function testActionCreate()
    {
    
        //Se declara el objeto a verificar
        $tester = new  IndicadorParametroController('IndicadorParametroController','app\controllers\indicadores\IndicadorParametroController');
        // se valida que se cree la instancia exitosamente
        $this->assertTrue($tester!=null);
        $this->assertInstanceOf('app\controllers\indicadores\IndicadorParametroController', $tester);
             
          
            // Se declaran los $queryParams a enviar los datos a crear
            $queryParams = ['IndicadorParametroController' => [
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
                              ]];
                            
       //       Se declaran el post1
            Yii::$app->request->queryParams =  $queryParams;
                            
            // se valida que se pueda realizar la insercion del registro
            $actionCreate=Yii::$app->runAction('IndicadorParametroController/create');
             
            // se evalua el caso exitoso
            $this->assertNotNull($actionCreate,
                    'Se devolvio nullo actionCreate ');  
       
    }

    
  
    public function testActionUpdate($id)
    {
        //Se declara el objeto a verificar
        $tester = new  IndicadorParametroController('IndicadorParametroController','app\controllers\indicadores\IndicadorParametroController');
        // se valida que se cree la instancia exitosamente
        $this->assertTrue($tester!=null);
        $this->assertInstanceOf('app\controllers\indicadores\IndicadorParametroController', $tester);
        
        
        // Se declaran los $queryParams a enviar los datos a actualizar
          $queryParams = ['IndicadorParametroController' => [
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
                          ]];
        
        
         // se deben declarar los valores de $id para enviar la llave
                         $id = 'valor adecuado para el tipo de dato del paramtero $id';
                                
        
         // se valida que se pueda realizar el update del registro
                                     
        $actionUpdate=Yii::$app->runAction('IndicadorParametroController/update',['id' => $id]);

        // se evalua el caso exitoso
        $this->assertNotNull($actionUpdate,
               'Se devolvio nullo actionUpdate ');  
 
    }


    
    
    public function testActionDeletep($id)
    {
    
        //Se declara el objeto a verificar
        $tester = new  IndicadorParametroController('IndicadorParametroController','app\controllers\indicadores\IndicadorParametroController');
        // se valida que se cree la instancia exitosamente
        $this->assertTrue($tester!=null);
        $this->assertInstanceOf('app\controllers\indicadores\IndicadorParametroController', $tester);
        
        
        // se deben llenar los siguientes valores para indicar el registro a borrar
                         $id = 'valor adecuado para el tipo de dato del paramtero $id';
                                
        // se valida que se pueda realizar el borrado del registro
         $actionDelete=Yii::$app->runAction(IndicadorParametroController/update',['id' => $id]);
             
             // se evalua el caso exitoso
             $this->assertNotNull($actionDelete,
                    'Se devolvio nullo actionDelete ');  


    }

    
}
