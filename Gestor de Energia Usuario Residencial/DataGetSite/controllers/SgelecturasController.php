<?php

namespace app\controllers;

use app\models\SgeLecturas;
use app\models\SgeLecturasSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * SgelecturasController implements the CRUD actions for SgeLecturas model.
 */
class SgelecturasController extends Controller
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
                'only' => ['index','create','update','delete','graficas','descargaexcel'],
                'rules' => [
                    [
                        'actions' => ['index','create','update','delete','graficas','descargaexcel'],
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
    public function actionGraficas($finicial = null, $ffinal = null, $cto = null, $tgrafica = null)
    {

        if ($this->Dfechas($finicial, $ffinal) > 8) {

            Yii::$app->getSession()->setFlash('error', [
                'type' => 'error',
                'message' => "Error !!!",
                'message2' => "Selecciona un rango de fechas menor o igual a 8 dias",
            ]);

            return $this->redirect(['graficas']);
        } else {

            $model = new SgeLecturas();
            $searchModel = new SgeLecturasSearch();
            $fecha_actual = date('Y-m-d');
            $fecha_anterior = date("Y-m-d", strtotime($fecha_actual . "- 1 days"));

            if (is_null($finicial)) {
                $finicial = $fecha_anterior;
            }

            if (is_null($ffinal)) {
                $ffinal = $fecha_actual;
            }

            if (is_null($tgrafica)) {
                $tgrafica = 1;
            }


            //cIRCUITOS ==================================================================== 
            $ctos = \app\models\SgeCircuitos::find()
            ->leftJoin('sge_proyectos', 'sge_proyectos.proyecto_id =sge_circuitos.proyecto_id')
            ->leftJoin('sge_usuarios', 'sge_usuarios.usuario_id =sge_proyectos.usuario_id')
            ->where(['sge_usuarios.usuario_id'=>Yii::$app->user->id])
            ->orderBy(['circuitos_id' => SORT_ASC])->all();

            if (is_null($cto)) {
                $cto = $ctos[0]['circuitos_id'];
            }

            // enviamos el objeto a la funcion=============================================
            $searchModel->ffin = $ffinal;
            $searchModel->finicio = $finicial;
            $searchModel->cto = $cto;
            $searchModel->tgrafica = $tgrafica;
            $dataProvider = $searchModel->searchg();

            $datos = [];
            if ($tgrafica == 1) {
                foreach ($dataProvider as $key => $value) {

                    $datos['fechas'][$key] = $value['fecha_hora_registro'];

                    $datos[0]['tfa'][$key] = $value['tensionfaseA'];
                    $datos[0]['tfb'][$key] = $value['tensionfaseB'];
                    $datos[0]['tfc'][$key] = $value['tensionfaseC'];

                    $datos[1]['cfa'][$key] = $value['corrientefaseA'];
                    $datos[1]['cfb'][$key] = $value['corrientefaseB'];
                    $datos[1]['cfc'][$key] = $value['corrientefaseC'];

                    $datos[2]['afa'][$key] = $value['activainsfaseA'];
                    $datos[2]['afb'][$key] = $value['activainsfaseB'];
                    $datos[2]['afc'][$key] = $value['activainsfaseC'];
                    $datos[2]['aitotal'][$key] = $value['activainstotal'];
                    $datos[2]['ritotal'][$key] = $value['reactivainstotal'];
                }
            } else {

                foreach ($dataProvider as $key => $value) {

                    $tactiva = 0;
                    $tractiva = 0;
                    $datos['fechas'][$key] = $value['date'].' - Hora '.$value['date_part'];


                    if ($key == 0 && $value['date_part'] == 0) {
                        $tactiva = $value['max_activa'] - $value['min_activa'];
                        $tractiva = $value['max_reactiva'] - $value['min_reactiva'];
                        
                    } else {
                        
                        $tactiva = $dataProvider[$key]['max_activa'] - $dataProvider[$key-1]['max_activa'];
                        $tractiva = $dataProvider[$key]['max_reactiva'] - $dataProvider[$key-1]['max_reactiva'];                        
                        
                    }

                    $datos['datos_activa'][] =  $tactiva;
                    $datos['datos_reactiva'][] =  $tractiva;
                }

                // print_r($dataProvider);

            }

            return $this->render('grafica', [
                'datos' => $datos,
                'ctos' => $ctos,
                'model' => $model,
                'ffinal' => $ffinal,
                'finicio' => $finicial,
                'cto' => $cto,
                'tgrafica' => $tgrafica
            ]);
        }
    }

    public function Dfechas($finicial = null, $ffinal = null)
    {
        $dateDifference = abs(strtotime($ffinal) - strtotime($finicial));

        $years  = floor($dateDifference / (365 * 60 * 60 * 24));
        $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

        return $days;
    }
    /**
     * Lists all SgeLecturas models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SgeLecturasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->sort->defaultOrder = ['fecha_hora_registro' => SORT_DESC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SgeLecturas model.
     * @param int $registro_lectura_id Registro Lectura ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($registro_lectura_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($registro_lectura_id),
        ]);
    }

    /**
     * Creates a new SgeLecturas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SgeLecturas();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'registro_lectura_id' => $model->registro_lectura_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SgeLecturas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $registro_lectura_id Registro Lectura ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($registro_lectura_id)
    {
        $model = $this->findModel($registro_lectura_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'registro_lectura_id' => $model->registro_lectura_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SgeLecturas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $registro_lectura_id Registro Lectura ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($registro_lectura_id)
    {
        $this->findModel($registro_lectura_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SgeLecturas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $registro_lectura_id Registro Lectura ID
     * @return SgeLecturas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($registro_lectura_id)
    {
        if (($model = SgeLecturas::findOne(['registro_lectura_id' => $registro_lectura_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDescargaexcel()
    {
        
        
        //Obteniendo el dataProvider
        $searchModel = new SgeLecturasSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams[1]);
        $dataProvider->pagination->pageSize = $dataProvider->getTotalCount();
        $posts = $dataProvider->getModels();

        //Obteniendo los datos
        $datos = array();

        $titulos = [
            'Fecha Registro',
            'Circuito',
            'Tension Fase A',
            'Tension Fase B',
            'Tension Fase C',
            'Corriente Fase A',
            'Corriente Fase B',
            'Corriente Fase C',
            'Activa Instantanea Fase A',
            'Activa Instantanea Fase B',
            'Activa Instantanea Fase C',
            'Activa Instantanea Total',
            'Reactiva Instantanea Total',
            'Energia Activa',
            'Energia Reactiva',
            'Factor de Potencia Fase A',
            'Factor de Potencia Fase B',
            'Factor de Potencia Fase C',
            'Frecuencia'
        ];

        $ctos = \app\models\SgeMedidores::find()->with('circuito')->all();

        $bibliotecactos = [];
        foreach ($ctos as $key => $value) {
            $circuito = $value['circuito']->alias;
            $bibliotecactos[$value->medidor_id] = $circuito;
        }

        
       
        foreach ($posts as $model) {

            // print_r($model);

            $datos[] = [
                $model['fecha_hora_registro'],
                $bibliotecactos[$model['medidor_id']],
                $model['tensionfaseA'],
                $model['tensionfaseB'],
                $model['tensionfaseC'],
                $model['corrientefaseA'],
                $model['corrientefaseB'],
                $model['corrientefaseC'],
                $model['activainsfaseA'],
                $model['activainsfaseB'],
                $model['activainsfaseC'],
                $model['activainstotal'],
                $model['reactivainstotal'],
                $model['energia_activa'],
                $model['energia_reactiva'],
                $model['fpfaseA'],
                $model['fpfaseB'],
                $model['fpfaseC'],
                $model['frecuencia']
            ];
        }

      
        // die;
        //Enviando informaci?n a excel ==================================================
        $data['title'] = 'Sgap Registro Lecturas';
        $data['subject'] = 'WMSAS - Sgap - Registro Lecturas';
        $data['description'] = 'WMSAS - Sgap - Registro Lecturas';
        $data['keywords'] = 'SGAP,REGISTRO LECTURAS';
        $data['setcategory']  = 'WMSAS - Sgap - Registro Lecturas';
        $data['data'] = $datos;
        $data['header'] = $titulos;
        $data['bckground'] = ["FFFFFF", "FFFFFF"];

      
        $_excel = new \app\helpers\phpexcelGenerator();
        $_genexcel = $_excel->generarExcel($data);
    }
    
    
    
    /*
     * Funcion para subir consumos csv
     */
     public function actionUpload($fecha=null,$pry=null){
        
        if(is_null($fecha)){
            $fecha = \date('ymd',strtotime("-1 days"));
        }
        
        if(is_null($pry)){
             throw new NotFoundHttpException('Error:'.$ex->message);
        }
        
        $ruta = "/usr/data/sge";
        
        
        try{
            
            
             //1. Traer Proyectos =============================================================
//            if(is_null($pry)){
//                 $proyectos = \app\models\SgeProyectos::find()->all();
//            }else{
//                $proyectos = \app\models\SgeProyectos::find()->where(['proyecto_id'=>$pry])->all();
//            }
            
            $proyectos[]=$pry;
           
            $senddata = array();
            
            
            $medidores ="SELECT sge_medidores.medidor_id,sge_circuitos.proyecto_id,sge_medidores.modbusposition FROM sge_medidores
                        LEFT JOIN sge_circuitos ON sge_medidores.circuito_id = sge_circuitos.circuitos_id
                        WHERE sge_medidores.estado_id=1";
            
            $resultados =Yii::$app->db->createCommand($medidores)->queryAll();
            $arramedidor = array();
            
            foreach ($resultados as $medidor){
                $arramedidor[$medidor['proyecto_id']][$medidor['modbusposition']] = $medidor['medidor_id'];
            }
            
            
        
            
            foreach($proyectos as $proyecto){
            
                $remote = $ruta."/".$proyecto."/pendientes/consumo".$fecha.".csv";
                $local = "/usr/data/SGE/".$proyecto."/consumo".$fecha.".csv";
                
                try{
                    Yii::warning("Solicitando archivo 2: ".$remote);
                    $getfileres = $this->getdatafile($remote, $local);
                } catch (Exception $ex) {
                    continue;
                }
                
                if($getfileres == false){
                    continue;
                }
                
                Yii::warning("Solicitando archivo: ".$remote);
                
                //Abriendo archivo ============================================================
                $data = file_get_contents("/usr/data/SGE/".$proyecto."/consumo".$fecha.".csv");
                
                //Realizando batchinsert ======================================================
                $rows = explode("\n",$data);
                
                foreach($rows as $row){
                    $dataline = explode(",",$row);
                    $fechareg = '20'.$dataline[0];
                    
                    if($fechareg == "20"){
                        continue;
                    }
                    
                    if(!empty($dataline[1]) && !empty($arramedidor[$dataline[2]][$dataline[1]])){
                    
                        $senddata[]=['20'.$dataline[0],
                                        $arramedidor[$dataline[2]][$dataline[1]],
                                        $dataline[3],
                                        $dataline[4],
                                        $dataline[5],
                                        $dataline[6],
                                        $dataline[7],
                                        $dataline[8],
                                        $dataline[9],
                                        $dataline[10],
                                        $dataline[11],
                                        $dataline[12],
                                        $dataline[13],
                                        $dataline[14],
                                        $dataline[15],
                                        $dataline[16],
                                        $dataline[17],
                                        $dataline[18],
                                        $dataline[19],
                                        $dataline[20]
                                  ];
                    }
                  
                }
            
            }

            
            Yii::$app->db->createCommand()->batchInsert('sge_lecturas', ['fecha_hora_registro','medidor_id','tensionfaseA','tensionfaseB','tensionfaseC','corrientefaseA','corrientefaseB','corrientefaseC','activainsfaseA','activainsfaseB','activainsfaseC','activainstotal','reactivainstotal','estado_rele','energia_activa','energia_reactiva','fpfaseA','fpfaseB','fpfaseC','frecuencia'], $senddata)->execute();
           

            
            
        } catch (Exception $ex) {
            throw new NotFoundHttpException('Error:'.$ex->message);
        }
        
       
        
        
        
        die();
    }
    
    
    protected function getdatafile($archivo,$local){
        
        
        $connection = ssh2_connect('10.101.0.1', 10022);
        ssh2_auth_password($connection, 'invitado', 'WMSAS2015');

        $sftp = ssh2_sftp($connection);

        
        $stream = @fopen("ssh2.sftp://$sftp$archivo", 'r');
        if (! $stream) {
              return false;
        }

        $contents = stream_get_contents($stream);
        file_put_contents ($local, $contents);
        @fclose($stream);
        return true;
    }
}
