<?php

namespace app\controllers;

use app\models\SgeMedidores;
use app\models\SgeMedidoresSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * SgemedidoresController implements the CRUD actions for SgeMedidores model.
 */
class SgemedidoresController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'only' => ['index', 'create', 'update', 'delete'],
                    'rules' => [
                        [
                            'actions' => ['index', 'create', 'update', 'delete'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all SgeMedidores models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SgeMedidoresSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SgeMedidores model.
     * @param int $medidor_id Medidor ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($medidor_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($medidor_id),
        ]);
    }

    /**
     * Creates a new SgeMedidores model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SgeMedidores();
        $proyectos = \app\models\SgeConcentradores::find()->all();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $model->fecha_creado = date('Y-m-d H:i:s');
                $model->estado_id = 1;

                if ($model->save()) {
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success',
                        'message' => "Guardado Exito",
                        'message2' => "",
                    ]);
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->getSession()->setFlash('error', [
                        'type' => 'error',
                        'message' => "Error al guardar cambios, verifique la información o comuniquese con su adminitrador.",
                        'message2' => "",
                    ]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'proyectos' => $proyectos,
        ]);
    }

    public function actionListcircuitos($id)
    {

      if(is_null($id) || empty($id)){
          echo "";
      }
      
      $circuitos = \app\models\SgeCircuitos::find()
                   ->leftJoin('sge_concentradores', 'sge_concentradores.concentrador_id = sge_circuitos.concentrador_id ')
                   ->where(['sge_concentradores.concentrador_id'=>$id])
                    ->all();
      
      $_html="";
      
      foreach($circuitos as $circuito){
          
          $_html.="<option value='".$circuito->circuitos_id."'>".$circuito->alias."</option>";
          
      }
      
      
      echo $_html;
      
    }

    /**
     * Updates an existing SgeMedidores model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $medidor_id Medidor ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $proyectos = \app\models\SgeProyectos::find()->all();
        $model->proyecto_id = $model->circuito->proyecto_id;


        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'proyectos' => $proyectos,
            'update' => true
        ]);
    }

    /**
     * Deletes an existing SgeMedidores model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $medidor_id Medidor ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($medidor_id)
    {
        $this->findModel($medidor_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SgeMedidores model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $medidor_id Medidor ID
     * @return SgeMedidores the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($medidor_id)
    {
        if (($model = SgeMedidores::findOne(['medidor_id' => $medidor_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
