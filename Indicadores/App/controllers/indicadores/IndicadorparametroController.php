<?php

namespace app\controllers\indicadores;

use Yii;
use app\controllers\indicadores\IndicadorparametroControllerFachada;
use app\models\gisindicadores\IndicadorParametro;
use app\controllers\controllerspry\ControllerPry;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;	//Para presentar la barra de espera
use yii\helpers\Url;	//Para presentar la barra de espera
use yii\jui\ProgressBar;

/**
 * IndicadorParametroController implementa las acciones a través del sistema CRUD para el modelo IndicadorParametro.
 */
class IndicadorparametroController extends ControllerPry
{
  //private $facade =    IndicadorParametroControllerFachada;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $facade =  new  IndicadorParametroControllerFachada;
        return $facade->behaviors();
    }
	
    
	
    /**Accion para la barra de progreso y render de nuevo a la vista
    Ubicación: @web = frontend\web....*/

    public function actionProgress($urlroute=null,$id=null){
            $facade =  new  IndicadorParametroControllerFachada;
            echo $facade->actionProgress($urlroute,$id);
    }

	
	
    /**
     * Listado todos los datos del modelo IndicadorParametro que se encuentran en el tablename.
     * @return mixed
     */
    public function actionIndex()
    {
        $facade =  new  IndicadorParametroControllerFachada;
        $dataAndModel= $facade->actionIndex(Yii::$app->request->queryParams);
		        
        return $this->render('index', [
            'searchModel' => $dataAndModel['searchModel'],
            'dataProvider' => $dataAndModel['dataProvider'],
			'buscador'=>$this->loadFilterCantones(),
        ]);
    }

    /**
     * Presenta un dato unico en el modelo IndicadorParametro.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		
        $facade =  new  IndicadorParametroControllerFachada;
		$indicadores = $facade->actionGlosario($id);
        
        return $this->render('view', [
            'model' => $this->findModelIndicador($id),
            'buscador' => $this->loadFilterCantones(),
            'indicadores' => $indicadores[1]
        ]);
    }

    /**
     * Crea un nuevo dato sobre el modelo IndicadorParametro .
     * Si se crea correctamente guarda setFlash, presenta la barra de progreso y envia a view con la confirmación de guardado.
     * @return mixed
     */
    public function actionCreate()
    {
       $facade =  new  IndicadorParametroControllerFachada;
       $modelE= $facade->actionCreate(Yii::$app->request->post(),Yii::$app->request->isAjax);
       $model = $modelE['model'];
        if ($modelE['create'] == 'True') {
			
            Yii::$app->session->setFlash('FormSubmitted','2');
            return  $this->redirect(['progress', 'urlroute' => 'view', 'id' => $model->cod_indi_param]);		
			
        }elseif($modelE['create']=='Ajax'){
             return $this->renderAjax('create', [
                        'model' => $model
            ]);
        } 
        else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Modifica un dato existente en el modelo IndicadorParametro.
     * Si se modifica correctamente guarda setFlash, presenta la barra de progreso y envia a view con la confirmación de guardado..
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $facade =  new  IndicadorParametroControllerFachada;
        $modelE= $facade->actionUpdate($id,Yii::$app->request->post(),Yii::$app->request->isAjax);
        $model = $modelE['model'];

        if ($modelE['update'] == 'True') {
            
            Yii::$app->session->setFlash('FormSubmitted','1');		
            return $this->redirect(['progress', 'urlroute' => 'view', 'id' => $model->cod_indi_param]);
            
        }elseif($modelE['update']=='Ajax'){
            return $this->renderAjax('update', [
                        'model' => $model
            ]);
        } 
        else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing IndicadorParametro model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeletep($id)
    {
        $facade =  new  IndicadorParametroControllerFachada;
        $facade->actionDeletep($id);

        return $this->redirect(['index']);
    }

    private function loadFilterCantones(){
		
		$basicController = New \app\helpers\Consultasbasicas();
        $buscador = $basicController->LoadFiltroCantones();
		return $buscador;
	}
	
    protected function findModelIndicador($id)
    {
        $model = New IndicadorParametro();
        
        // $sql = "SELECT
			// indicador_parametro.*,
			// descrip_parametro.nombre as param_nombre,
			// descrip_parametro.sigla as param_sigla
		// FROM
			// indicador_parametro
			// LEFT JOIN relacion_param_indicador ON relacion_param_indicador.cod_indicador = indicador_parametro.cod_indi_param
			// LEFT JOIN indicador_parametro AS descrip_parametro ON descrip_parametro.cod_indi_param = relacion_param_indicador.cod_parametro
		// WHERE indicador_parametro.cod_indi_param=:indicador";
				
        // $allData = Yii::$app->db->createCommand($sql)->bindParam('indicador',$id)->queryAll();
        
		$a=1;
        $sql = 'SELECT * FROM "ModelIndicador"('.$id.')';
		$allData = Yii::$app->db->createCommand($sql)->queryAll();
        
		foreach($allData as $resultados){
            
            if($a==1){
                
                $model->cod_indi_param = $resultados['cod_indi_params'];
                $model->nombre = $resultados['nombre'];
                $model->formula = $resultados['formula'];
                $model->descripcion = $resultados['descripcion'];
                $model->unidad = $resultados['unidad'];
                $model->sigla = $resultados['sigla'];
            }
            
            $model->descript_formula[] = ['nombre'=>$resultados['param_nombre'],'sigla'=>$resultados['param_sigla']];
            
            
        }
        
        
        return $model;
    }
    
    
    public function actionComparativo(){
        
        //Obteniendo listado de indicadores
        $v_indicadores=array();
        $indicadores = \app\models\gisindicadores\Indicadorparametro::find()->where(['indicador_parametro.tipo'=>'I'])->orderBy(['sigla'=>'SORT_ASC'])->all();
        foreach($indicadores as $indicador){
            $v_indicadores[$indicador['cod_indi_param']] = $indicador['sigla']."-".$indicador['nombre'];
        }
        
        //Obteniendo listado de cantones
        $v_cantones=array();
        $_sqlcantones = \app\models\gisindicadores\LocalizacionPrestador::find()
                ->leftJoin('localizacion', 'localizacion_prestador.cod_localizacion = localizacion.cod_localizacion')
                ->where(['localizacion.id_tipolocalizacion'=>'2'])->with('codLocalizacion')->with('codPrestador')->all();

        foreach($_sqlcantones as $_canton){
            
            if(!empty($_canton["codPrestador"])){
                $v_cantones[$_canton['id_localizacion_prestador']]=$_canton['codLocalizacion']->nombre.'-'.$_canton["codPrestador"]->nombre;
            }else{
                $v_cantones[$_canton['id_localizacion_prestador']]=$_canton['codLocalizacion']->nombre;
            }
        }

        return $this->render('comparativo', [
                'buscador'=>$this->loadFilterCantones(),'data_indi'=>$v_indicadores,'data_pres'=>$v_cantones
        ]);
        
    }
    
    
    public function actionGetdata($indicador,$canton){
        
        //Sacando Hechos ========================================================================
        $hechos = array();
        $resultados = \app\models\gisindicadores\Hechos::find()
                    ->leftJoin('localizacion_prestador', 'localizacion_prestador.id_localizacion_prestador = hechos.id_localizacion_prestador')
                    ->where(['hechos.id_localizacion_prestador'=>$canton,'cod_indi_param'=>$indicador])->with('codIndiParam')->orderby(['anio'=>SORT_ASC])->all();

        foreach($resultados as $resultado){
            $hechos[$resultado->anio] = $resultado->valor;
        }
        
        //Cargando Años de los que se tiene información,esto se realiza por que debe existir un valor para cada año asi sea nulo ==============================================================
        $v_labels = array();
        $valores =array();
        
        $sqlyear = "select anio from hechos where cod_indi_param ='".$indicador."' group by anio order by anio";
        $anios = Yii::$app->db->createCommand($sqlyear)->queryAll();
        foreach($anios as $anio){
           if( !empty($hechos[$anio['anio']]) ){
               $valores[] = $hechos[ $anio['anio'] ];
           }else{
               $valores[] = null;
           }
        }
        
        return json_encode($valores);
        
//        $valores1=[null,10,20,0,2];
//        $valores2=[0,0,0,0,null];
//        $valores3=[-10,20,-10,5,10];
//        
//        
//        if($canton == '1'){
//            
//        }else if($canton == '2'){
//           return json_encode($valores2);
//        }else{
//           return json_encode($valores3);
//        }
    }
    
    
    public function actionGetlabels($indicador){
        
        //Cargando Años de los que se tiene información
        $v_labels = array();
        $sqlyear = "select anio from hechos where cod_indi_param ='".$indicador."' group by anio order by anio";
        $anios = Yii::$app->db->createCommand($sqlyear)->queryAll();
        foreach($anios as $anio){
            $v_labels[] = $anio['anio'];
        }
        
        return json_encode($v_labels);
    }
}
