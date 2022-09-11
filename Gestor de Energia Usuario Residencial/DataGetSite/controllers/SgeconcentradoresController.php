<?php

namespace app\controllers;

use app\models\SgeConcentradores;
use app\models\SgeConcentradoresSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SgeconcentradoresController implements the CRUD actions for SgeConcentradores model.
 */
class SgeconcentradoresController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
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
     * Lists all SgeConcentradores models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SgeConcentradoresSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SgeConcentradores model.
     * @param int $concentrador_id Concentrador ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($concentrador_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($concentrador_id),
        ]);
    }

    /**
     * Creates a new SgeConcentradores model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SgeConcentradores();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'concentrador_id' => $model->concentrador_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SgeConcentradores model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $concentrador_id Concentrador ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($concentrador_id)
    {
        $model = $this->findModel($concentrador_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'concentrador_id' => $model->concentrador_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SgeConcentradores model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $concentrador_id Concentrador ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($concentrador_id)
    {
        $this->findModel($concentrador_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SgeConcentradores model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $concentrador_id Concentrador ID
     * @return SgeConcentradores the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($concentrador_id)
    {
        if (($model = SgeConcentradores::findOne(['concentrador_id' => $concentrador_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
