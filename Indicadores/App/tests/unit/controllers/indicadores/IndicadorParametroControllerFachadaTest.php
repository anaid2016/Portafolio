<?php

namespace app\tests\unit\controllers\indicadores;

use Yii;
use app\controllers\indicadores\IndicadorParametroControllerFachada;
/**
 * IndicadorParametroControllerFachadaTest implementa la verificaicon de los valores, consulta información para aplicar reglas de negocio, y transacciones conforme las acciones para el modelo IndicadorParametro.
 */
class IndicadorParametroControllerFachadaTest extends \Codeception\Test\Unit
{

/**para mayor informacion sobre asserts => http://codeception.com/docs/modules/Asserts y http://codeception.com/10-04-2013/specification-phpunit.html**/
    
    public function _before()
    {
       // declaraciones y asignacion de valores que se deben tener para realizar las funciones test
    }

                                                               
                                                                                             
    public function _after()                                                              
    {             
            // funcion que se ejecuta despues de los test                                                      
    }                
    
 
    public function testBehaviors()
    {
        //Se declara el objeto a verificar
        $tester = new  IndicadorParametroControllerFachada();
        // se valida que se cree la instancia exitosamente
        $this->assertTrue($tester!=null);
        $this->assertInstanceOf('app\controllers\indicadores\IndicadorParametroControllerFachada', $tester);
        
        //Se realiza el llamado a la funcion
        $behaviors= $tester->behaviors();
        
        // Se evalua el caso exitoso
        $this->assertNotEmpty($behaviors,                                                          
            'Se devolvio vacio behaviors');  
            
    }
	
	
    /**Accion para la barra de progreso y render de nuevo a la vista
    Ubicación: @web = frontend\web....*/

    public function testActionProgress(){

        //Se declara el objeto a verificar
        $tester = new  IndicadorParametroControllerFachada();
        // se valida que se cree la instancia exitosamente
        $this->assertTrue($tester!=null);
        $this->assertInstanceOf('app\controllers\indicadores\IndicadorParametroControllerFachada', $tester);

        // Se declaran las variables, $urlroute=null,$id=null para el reenvio de la barra de progreso, la llave tiene valor por defecto null, si se desea se puede cambiar por una llave. 
         $urlroute='/indicadorparametro/index';
         $id=null;
        //Se obtiene los valores para la barra de progreso
           $progressbar= $tester->actionProgress($urlroute,$id);
        //Se evalua caso exitoso   
        $this->assertNotEmpty($progressbar,
           'Se devolvio Vacio el html de actionProgress ');  

    }

	
	
    /**
     * Listado todos los datos del modelo IndicadorParametro que se encuentran en el tablename.
     * @return mixed
     */
    public function testActionIndex()
    {
    
        //Se declara el objeto a verificar
        $tester = new  IndicadorParametroControllerFachada();
        // se valida que se cree la instancia exitosamente
        $this->assertTrue($tester!=null);
        $this->assertInstanceOf('app\controllers\indicadores\IndicadorParametroControllerFachada', $tester);
        
        
        // Se declaran los $queryParams a enviar
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
                $actionindex= $tester->actionIndex($queryParams);
                         
              // se evaluan los casos exitosos
                $this->assertNotNull($actionindex['dataProvider'],                                                          
                    'Se devolvio nullo dataProvider de actionIndex ');  
                $this->assertNotNull($actionindex['searchModel'],                                                          
                    'Se devolvio nullo searchModel de actionIndex '); 
                    

                            
    }

    /**
     * Presenta un dato unico en el modelo IndicadorParametro.
     * @param integer $id
     * @return mixed
     */
    public function testActionView()
    {       
        //Se declara el objeto a verificar
        $tester = new  IndicadorParametroControllerFachada();
        // se valida que se cree la instancia exitosamente
        $this->assertTrue($tester!=null);
        $this->assertInstanceOf('app\controllers\indicadores\IndicadorParametroControllerFachada', $tester);
    
        // se deben declarar los valores de $id        
                        $id = 'valor adecuado para el tipo de dato del paramtero $id';
              
        
             // se realiza el action view, intrernamente usa la funcion findModel, a su vez utiliza el findone de Yii realizando la consulta con todos los valores de los parametros $id             
             $actionView= $tester->actionView($id);
             
             // se evalua el caso exitoso
             $this->assertNotNull($actionView,
                    'Se devolvio nullo actionView ');  
 
    }

    /**
     * Crea un nuevo dato sobre el modelo IndicadorParametro .
     * Si se crea correctamente guarda setFlash, presenta la barra de progreso y envia a view con la confirmación de guardado.
     * @return mixed
     */
    public function testActionCreate()
    {
    
        //Se declara el objeto a verificar
        $tester = new  IndicadorParametroControllerFachada();
        // se valida que se cree la instancia exitosamente
        $this->assertTrue($tester!=null);
        $this->assertInstanceOf('app\controllers\indicadores\IndicadorParametroControllerFachada', $tester);
             
            // Se declaran el rquest
              $request =  ['IndicadorParametroControllerFachada' => [
                                'cod_indi_param' => 'Ingresar valor de pruebas para el campo cod_indi_param de tipo int4',
                             'nombre' => 'Ingresar valor de pruebas para el campo nombre de tipo varchar',
                             'sigla' => 'Ingresar valor de pruebas para el campo sigla de tipo varchar',
                             'descripcion' => 'Ingresar valor de pruebas para el campo descripcion de tipo varchar',
                             'formula' => 'Ingresar valor de pruebas para el campo formula de tipo varchar',
                             'tipo' => 'Ingresar valor de pruebas para el campo tipo de tipo bpchar',
                             'cod_area' => 'Ingresar valor de pruebas para el campo cod_area de tipo int4',
                             'unidad' => 'Ingresar valor de pruebas para el campo unidad de tipo varchar',
                             'descr_relacion_param' => 'Ingresar valor de pruebas para el campo descr_relacion_param de tipo varchar',
                             'estado' => 'Ingresar valor de pruebas para el campo estado de tipo bpchar',
                             'fecha_desde' => 'Ingresar valor de pruebas para el campo fecha_desde de tipo date',
                             'fecha_hasta' => 'Ingresar valor de pruebas para el campo fecha_hasta de tipo date',
                             'tipo_dato' => 'Ingresar valor de pruebas para el campo tipo_dato de tipo bpchar',
                             'relevancia_indicador' => 'Ingresar valor de pruebas para el campo relevancia_indicador de tipo int4',
                             'tipo_calc_parametro' => 'Ingresar valor de pruebas para el campo tipo_calc_parametro de tipo varchar',
                             'valor_cumplimiento' => 'Ingresar valor de pruebas para el campo valor_cumplimiento de tipo numeric',
                          ]];
            
                $actionCreate = $tester->actionCreate($request,false);
                
                // se evaluan que se devuleva la informacion          
                $this->assertCount(0,$actionCreate['model']['_errors'],                                                          
                        'Se devolvieron errores en el model de actionCreate, verifique por favor');   
                $this->assertNotEmpty($actionCreate['create'],                                                          
                        'Se devolvio nulo el create de actionCreate '); 
                        
        /**Para imprimir los errores 
         * $this->assert($actionCreate['model']['_errors'],
                        'Se devolvieron errores en el model de actionCreate, verifique por favor')***/


    }

   
     /**
     * Modifica un dato existente en el modelo IndicadorParametro.
     * Si se modifica correctamente guarda setFlash, presenta la barra de progreso y envia a view con la confirmación de guardado..
     * @param integer $id
     * @return mixed
     */
    public function testActionUpdate($id)
    {
        //Se declara el objeto a verificar
        $tester = new  IndicadorParametroControllerFachada();
        // se valida que se cree la instancia exitosamente
        $this->assertTrue($tester!=null);
        $this->assertInstanceOf('app\controllers\indicadores\IndicadorParametroControllerFachada', $tester);
        
         // Se declaran el rquest
              $request =  ['IndicadorParametroControllerFachada' => [
                                'cod_indi_param' => 'Ingresar valor de pruebas para el campo cod_indi_param de tipo int4',
                             'nombre' => 'Ingresar valor de pruebas para el campo nombre de tipo varchar',
                             'sigla' => 'Ingresar valor de pruebas para el campo sigla de tipo varchar',
                             'descripcion' => 'Ingresar valor de pruebas para el campo descripcion de tipo varchar',
                             'formula' => 'Ingresar valor de pruebas para el campo formula de tipo varchar',
                             'tipo' => 'Ingresar valor de pruebas para el campo tipo de tipo bpchar',
                             'cod_area' => 'Ingresar valor de pruebas para el campo cod_area de tipo int4',
                             'unidad' => 'Ingresar valor de pruebas para el campo unidad de tipo varchar',
                             'descr_relacion_param' => 'Ingresar valor de pruebas para el campo descr_relacion_param de tipo varchar',
                             'estado' => 'Ingresar valor de pruebas para el campo estado de tipo bpchar',
                             'fecha_desde' => 'Ingresar valor de pruebas para el campo fecha_desde de tipo date',
                             'fecha_hasta' => 'Ingresar valor de pruebas para el campo fecha_hasta de tipo date',
                             'tipo_dato' => 'Ingresar valor de pruebas para el campo tipo_dato de tipo bpchar',
                             'relevancia_indicador' => 'Ingresar valor de pruebas para el campo relevancia_indicador de tipo int4',
                             'tipo_calc_parametro' => 'Ingresar valor de pruebas para el campo tipo_calc_parametro de tipo varchar',
                             'valor_cumplimiento' => 'Ingresar valor de pruebas para el campo valor_cumplimiento de tipo numeric',
                          ]];
        
        
        //se valida que sea exitoso
        $actionUpdate= $tester->actionUpdate($id,$request,false);
        $this->assertCount(0,$actionUpdate['model']['_errors'],                                                                                                    
                        'Se devolvieron errores en el model de actionUpdate, verifique por favor');  
        $this->assertNotEmpty($actionUpdate['update'],                                                          
                'Se devolvio nulo el create de actionUpdate '); 

                
        /**Para imprimir los errores 
         * $this->assert($actionUpdate['model']['_errors'],
                        'Se devolvieron errores en el model de actionCreate, verifique por favor')***/

        
    }

    
     /**
     * Deletes an existing IndicadorParametro model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function testActionDeletep()
    {
    
        //Se declara el objeto a verificar
        $tester = new  IndicadorParametroControllerFachada();
        // se valida que se cree la instancia exitosamente
        $this->assertTrue($tester!=null);
        $this->assertInstanceOf('app\controllers\indicadores\IndicadorParametroControllerFachada', $tester);
        
        
        // se deben llenar los siguientes valores
                        $id = 'valor adecuado para el tipo de dato del paramtero $id';
                
        // se valida que se pueda realizar el borrado del registro
        expect($tester->actionDeletep($id));

    }
    

}
