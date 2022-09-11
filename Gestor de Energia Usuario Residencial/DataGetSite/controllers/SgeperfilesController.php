<?php

namespace app\controllers;

use app\models\SgePerfiles;
use app\models\SgePerfilesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * SgeperfilesController implements the CRUD actions for SgePerfiles model.
 */
class SgeperfilesController extends Controller
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
     * Lists all SgePerfiles models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SgePerfilesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SgePerfiles model.
     * @param int $perfil_id Perfil ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($perfil_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($perfil_id),
        ]);
    }

    /**
     * Creates a new SgePerfiles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SgePerfiles();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'perfil_id' => $model->perfil_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SgePerfiles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $perfil_id Perfil ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($perfil_id)
    {
        $model = $this->findModel($perfil_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'perfil_id' => $model->perfil_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SgePerfiles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $perfil_id Perfil ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($perfil_id)
    {
        $this->findModel($perfil_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SgePerfiles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $perfil_id Perfil ID
     * @return SgePerfiles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($perfil_id)
    {
        if (($model = SgePerfiles::findOne(['perfil_id' => $perfil_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
