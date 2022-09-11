<?php

namespace app\controllers;


use Yii;
use app\models\SgeUsuarios;
use app\models\SgeUsuariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * SgeusuariosController implements the CRUD actions for SgeUsuarios model.
 */
class SgeusuariosController extends Controller
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
     * Lists all SgeUsuarios models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SgeUsuariosSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SgeUsuarios model.
     * @param int $usuario_id Usuario ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($usuario_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($usuario_id),
        ]);
    }

    /**
     * Creates a new SgeUsuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SgeUsuarios();
        $model->scenario = SgeUsuarios::SCENARIO_CREATE;
        $model->set_newpassword=true; 
        $perfiles = \app\models\SgePerfiles::find()->all();
        
        if ($this->request->isPost) {
            
              
            if ($model->load($this->request->post()) && $model->save()){
               
                
                
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'message' => "Guardado Exito",
                ]);
                
            }else{
               $this->session->setFlash('success', 'Error al guardar usuario');
            }
            
            
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,'perfiles'=>$perfiles
        ]);
    }

    /**
     * Updates an existing SgeUsuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $usuario_id Usuario ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
   public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = SgeUsuarios::SCENARIO_MODIFY;
        
        $perfiles = \app\models\SgePerfiles::find()->all();
        $_lastpassword = $model->serwmpskey;
        
        
       if ($this->request->isPost) {
            
            Yii::warning("que llega de contraseña ".$model->serwmpskey);
            if(is_null($model->serwmpskey) or empty($model->serwmpskey)){
                $model->set_newpassword=false;
               $model->serwmpskey = $_lastpassword;
            }else{
               $model->set_newpassword=true; 
            }
            
            if ($model->load($this->request->post()) && $model->save()){
                
               Yii::$app->session->setFlash('success', 'Guardado con Exito');
                
            }else{
               Yii::$app->session->setFlash('success', 'Error al guardar usuario');
            }
            
            return $this->redirect(['index']);
        }else{
            $model->serwmpskey = null;
        }

        return $this->render('update', [
            'model' => $model,'perfiles'=>$perfiles
        ]);
        
    }

    /**
     * Deletes an existing SgeUsuarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $usuario_id Usuario ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($usuario_id)
    {
        $this->findModel($usuario_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SgeUsuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $usuario_id Usuario ID
     * @return SgeUsuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($usuario_id)
    {
        if (($model = SgeUsuarios::findOne(['usuario_id' => $usuario_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
