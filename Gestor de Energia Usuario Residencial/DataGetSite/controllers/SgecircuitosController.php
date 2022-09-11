<?php

namespace app\controllers;

use app\models\SgeCircuitos;
use app\models\SgeCircuitosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * SgecircuitosController implements the CRUD actions for SgeCircuitos model.
 */
class SgecircuitosController extends Controller
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
                'only' => ['index','create','update','delete'],
                'rules' => [
                    [
                        'actions' => ['index','create','update','delete'],
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
     * Lists all SgeCircuitos models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SgeCircuitosSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SgeCircuitos model.
     * @param int $circuitos_id Circuitos ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($circuitos_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($circuitos_id),
        ]);
    }

    /**
     * Creates a new SgeCircuitos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SgeCircuitos();
        
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $model->fecha_creado = date('Y-m-d H:i:s');

                if($model->save()){
                    return $this->redirect(['index']);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SgeCircuitos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $circuitos_id Circuitos ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $proyectos = \app\models\SgeProyectos::find()->all();

        if ($this->request->isPost && $model->load($this->request->post())) {
            if($model->save()){
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'proyectos' => $proyectos,
        ]);
    }

    public function actionListconcentradores($id = null)
    {

        if (!is_null($id) && $id != 'undefined') {

            $concentrador = \app\models\SgeConcentradores::find()->where(['proyecto_id' => $id])->all();
            $count_concentrador = \app\models\SgeConcentradores::find()->where(['proyecto_id' => $id])->count();
            if ($count_concentrador > 0) {
                echo "<option value=''>Seleccione Concentrador</option>";
                foreach ($concentrador as $item_concentrador) {
                    echo "<option value='" . $item_concentrador->concentrador_id . "'>" . $item_concentrador->alias_concentrador . "</option>";
                }
            } else {
                echo "<option value=''>Seleccione Concentrador</option>";
            }
        } else {
            echo "<option value=''>Seleccione Concentrador</option>";
        }
    }

    /**
     * Deletes an existing SgeCircuitos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $circuitos_id Circuitos ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($circuitos_id)
    {
        $this->findModel($circuitos_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SgeCircuitos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $circuitos_id Circuitos ID
     * @return SgeCircuitos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($circuitos_id)
    {
        if (($model = SgeCircuitos::findOne(['circuitos_id' => $circuitos_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
