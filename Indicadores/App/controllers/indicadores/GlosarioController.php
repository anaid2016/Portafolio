<?php

namespace app\controllers\indicadores;

use Yii;
use app\controllers\indicadores\GlosarioControllerFachada;
use app\controllers\indicadores\IndicadorparametroControllerFachada;
use app\controllers\controllerspry\ControllerPry;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;	//Para presentar la barra de espera
use yii\helpers\Url;	//Para presentar la barra de espera
use yii\jui\ProgressBar;

/**
 * GlosarioController implementa las acciones a través del sistema CRUD para el modelo IndicadorParametro.
 */
class GlosarioController extends ControllerPry
{
     /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $facade =  new IndicadorParametroControllerFachada;
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
        $facadeI =  new  IndicadorParametroControllerFachada;
		$facade =  new  GlosarioControllerFachada;
        $params = Yii::$app->request->queryParams;
        $dataAndModel= $facade->actionIndex($params);
        $params['IndicadorParametroSearch']['tipo']='I';
        $dataAndModelIndicadores= $facadeI->actionIndex($params);
        $params['IndicadorParametroSearch']['tipo']='P';
        $dataAndModelParametros= $facadeI->actionParametro($params);
		
        $dataAndModelIndicadores['dataProvider']->pagination->pageParam = 'dp1';
        $dataAndModelIndicadores['dataProvider']->pagination->pageSizeParam = 'dp1-size';

        $dataAndModelParametros['dataProvider']->pagination->pageParam = 'dp2';
        $dataAndModelParametros['dataProvider']->pagination->pageSizeParam = 'dp2-size';
        return $this->render('index', [
            'searchModel' => $dataAndModel['searchModel'],
            'dataProvider' => $dataAndModel['dataProvider'],
            'searchIndicadores' => $dataAndModelIndicadores['searchModel'],
            'dataIndicadores' => $dataAndModelIndicadores['dataProvider'],
            'searchParametros' => $dataAndModelParametros['searchModel'],
            'dataParametros' => $dataAndModelParametros['dataProvider'],
        ]);
    }
	
	    /**
     * Listado todos los datos del modelo IndicadorParametro que se encuentran en el tablename.
     * @return mixed
     */
    public function actionIndicadores()
    {
        $facade =  new  IndicadorParametroControllerFachada;
		$params = Yii::$app->request->queryParams;
		$params['IndicadorParametroSearch']['tipo']='I';
        $dataAndModel= $facade->actionIndex($params);
        
        return $this->renderPartial('grid', [
            'searchModel' => $dataAndModel['searchModel'],
            'dataProvider' => $dataAndModel['dataProvider']
        ]);
    }

	
	    /**
     * Listado todos los datos del modelo IndicadorParametro que se encuentran en el tablename.
     * @return mixed
     */
    public function actionParametros()
    {
        $facade =  new  IndicadorParametroControllerFachada;
		$params = Yii::$app->request->queryParams;
		$params['IndicadorParametroSearch']['tipo']='P';
        $dataAndModel= $facade->actionIndex($params);
        
        return $this->renderPartial('grid', [
            'searchModel' => $dataAndModel['searchModel'],
            'dataProvider' => $dataAndModel['dataProvider']
        ]);
    }
	
  
    public function actionPreguntas()
    {
        $facade =  new  IndicadorParametroControllerFachada;
		
        return $this->render('preguntas', [
            'model' => $facade->actionView(1),
        ]);
    }

   

}
