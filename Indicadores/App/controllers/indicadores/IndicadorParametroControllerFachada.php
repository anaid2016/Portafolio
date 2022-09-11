<?php

namespace app\controllers\indicadores;

use Yii;
use app\models\gisindicadores\IndicadorParametro;
use app\models\gisindicadores\IndicadorParametroSearch;
use app\models\gisindicadores\ParametroSearch;
use app\controllers\controllerspry\FachadaPry;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;	//Para presentar la barra de espera
use yii\helpers\Url;	//Para presentar la barra de espera
use yii\jui\ProgressBar;

/**
 * IndicadorParametroControllerFachada implementa la verificaicon de los valores, consulta información para aplicar reglas de negocio, y transacciones conforme las acciones para el modelo IndicadorParametro.
 */
class IndicadorParametroControllerFachada extends FachadaPry
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
	
	
	/**Accion para la barra de progreso y render de nuevo a la vista
	Ubicación: @web = frontend\web....*/
	
	public function actionProgress($urlroute=null,$id=null){
		
	
            $progressbar = "<div style='display:block;margin:auto;width:50%;text-align:center'>".Html::img('@web/images/lazul.gif')."</div>"; 
            $progressbar = $progressbar . "<div style='display:block;margin:auto;width:50%;text-align:center'>Guardando</div>"; 	
            $progressbar = $progressbar .  "<meta http-equiv='refresh' content='3;".Url::toRoute([$urlroute, 'id' => $id])."'>";
            return $progressbar;
	}

	
	
    /**
     * Listado todos los datos del modelo IndicadorParametro que se encuentran en el tablename.
     * @return mixed
     */
    public function actionIndex($queryParams)
    {
                $searchModel = new IndicadorParametroSearch();
                $dataProvider = $searchModel->search($queryParams);

                return [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
                ];
            }

            
            
    /**
     * Listado todos los datos del modelo IndicadorParametro que se encuentran en el tablename.
     * @return mixed
     */
    public function actionParametro($queryParams)
    {
                $searchModel = new ParametroSearch();
                $dataProvider = $searchModel->search($queryParams);

                return [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
                ];
            }

    /**
     * Presenta un dato unico en el modelo IndicadorParametro.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {       
        return $this->findModel($id);
    }
    
    
    public function actionGlosario($id)
    {       
        $sql = "SELECT
	parametro.cod_indi_param as codparam,
	parametro.nombre as nombreparam,
	parametro.sigla as siglaparam,
	indicador.cod_indi_param as codindicador,
	indicador.nombre as nombreindicador,
        indicador.sigla as siglaindicador
            FROM
	relacion_param_indicador
	LEFT JOIN indicador_parametro AS indicador ON indicador.cod_indi_param = relacion_param_indicador.cod_indicador
	LEFT JOIN indicador_parametro AS parametro ON parametro.cod_indi_param = relacion_param_indicador.cod_parametro 
        WHERE
	cod_indicador IN ( SELECT cod_indicador FROM relacion_param_indicador WHERE cod_parametro = '".$id."' ) 
	OR cod_parametro IN (
	SELECT
		cod_parametro 
	FROM
		relacion_param_indicador 
	WHERE
		cod_indicador = '".$id."' 
	)";
        
        $indicadores = Yii::$app->db->createCommand($sql)->queryAll();
        $_vindicadores = array();
        
        foreach($indicadores as $indicador){
            
            if(empty($_vindicadores[$indicador['codparam']])){
                
                $_vindicadores[$indicador['codparam']]['id_indicador'] = $indicador['codparam'];
                $_vindicadores[$indicador['codparam']]['sigla'] = $indicador['siglaparam'];
                $_vindicadores[$indicador['codparam']]['nombre'] = $indicador['nombreparam'];
                 
            }
            
            if(empty($_vindicadores[$indicador['codindicador']])){
                
                $_vindicadores[$indicador['codindicador']]['id_indicador'] = $indicador['codindicador'];
                $_vindicadores[$indicador['codindicador']]['sigla'] = $indicador['siglaindicador'];
                $_vindicadores[$indicador['codindicador']]['nombre'] = $indicador['nombreindicador'];
                 
            }
           
        }
        
        return [$this->findModel($id),$_vindicadores];
 
    }

    /**
     * Crea un nuevo dato sobre el modelo IndicadorParametro .
     * Si se crea correctamente guarda setFlash, presenta la barra de progreso y envia a view con la confirmación de guardado.
     * @return mixed
     */
    public function actionCreate($request,$isAjax)
    {
        $model = new IndicadorParametro();

        if ($model->load($request) && $model->save()) {
			
                return [
                    'model' => $model,
                    'create' => 'True'
                ];	

        }
        elseif ($isAjax) {
        
                return [
                    'model' => $model,
                    'create' => 'Ajax'
                ];	
           
        }  
        
        else {
        
                 return [
                    'model' => $model,
                    'create' => 'False'
                ];

        }
    }

    /**
     * Modifica un dato existente en el modelo IndicadorParametro.
     * Si se modifica correctamente guarda setFlash, presenta la barra de progreso y envia a view con la confirmación de guardado..
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id,$request,$isAjax)
    {
        $model = $this->findModel($id);

        if ($model->load($request) && $model->save()) {
			
			
			return [
                            'model' => $model,
                            'update' => 'True'
                        ];
        } 
         elseif ($isAjax) {
        
                return [
                    'model' => $model,
                    'update' => 'Ajax'
                ];	
           
        }  
        else {
                         return [
                            'model' => $model,
                            'update' => 'False'
                        ];
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
        $this->findModel($id)->delete();

    }

    /**
     * Encuentra el modelo de IndicadorParametro basado en el valor de la primary key.
     * Si no encuentra respuesta, arroja una excepcion 404 HTTP.
     * @param integer $id
     * @return IndicadorParametro el modelo cargado
     * @throws NotFoundHttpException si no puede ser encontrada la respuesta
     */
    protected function findModel($id)
    {
                    if (($model = IndicadorParametro::findOne($id)) !== null) {
                        return $model;
                    } else {
                        throw new NotFoundHttpException('The requested page does not exist.');
                    }
    }
    
    /**
     * Funcion generica para la consulta por parametros, debe ser llamada por la funcion publica
     * @param type $params contiene array con valores de query a columnas de la tabla
     * @return type  IndicadorParametro     */
    protected function findModelByParams($params)
    {
        if (($model = IndicadorParametro::findAll($params)) !== null) {
            return $model;
        }
        else{
            return null;
        } 
    }
     
    /**
     * Funcion visible para los objetos que necesiten una consulta al modelo IndicadorParametro     
     * @param type $params contiene array con valores de query a columnas de la tabla
     * @return type IndicadorParametro     */
     public function cargaIndicadorParametro($params){
        return $this->findModelByParams($params);
    }
}