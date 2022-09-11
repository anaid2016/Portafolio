<?php

namespace app\controllers;

use app\models\SgeProyectos;
use app\models\SgeProyectosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * SgeproyectosController implements the CRUD actions for SgeProyectos model.
 */
class SgeproyectosController extends Controller
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
     * Lists all SgeProyectos models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SgeProyectosSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SgeProyectos model.
     * @param int $proyecto_id Proyecto ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($proyecto_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($proyecto_id),
        ]);
    }

    /**
     * Creates a new SgeProyectos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SgeProyectos();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'proyecto_id' => $model->proyecto_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SgeProyectos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $proyecto_id Proyecto ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SgeProyectos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $proyecto_id Proyecto ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($proyecto_id)
    {
        $this->findModel($proyecto_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SgeProyectos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $proyecto_id Proyecto ID
     * @return SgeProyectos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($proyecto_id)
    {
        if (($model = SgeProyectos::findOne(['proyecto_id' => $proyecto_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
