<?php

namespace app\controllers\indicadores;

use Yii;
use app\models\indicadores\Cantones;
use app\models\indicadores\CantonesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CantonesController implements the CRUD actions for Cantones model.
 */
class CantonesController extends Controller
{
    /**
     * {@inheritdoc}
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

    /**
     * Lists all Cantones models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CantonesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /*
     * Accion para visualizacion de cantones y su informacion
     */
    
    public function actionCanton($dpa_canton=null,$periodo=null)
    {
        $graph=Array();    
        $valorprint=Array();
        $searchModel = \app\models\gisindicadores\Localizacion::find()->where(['cod_oficial'=>$dpa_canton])->with('codDemarcacion')->with('localizacionpadre')->one();
        $barranav=array();
        
        //Años =============================================================================================
        $sql_1 = "SELECT * from indicadores_anios($searchModel->cod_localizacion)";
        $rs_sql1 = Yii::$app->db->createCommand($sql_1)->queryAll(); 
        
        foreach($rs_sql1 as $prestadores){
            
            if(empty($prestadores['maximo_anio'])){
                continue;
            }
            
            
            $v_prestadores[$prestadores['tipo']][$prestadores['id_localizacion_prestador']]['id_localizacion_prestador'] = $prestadores['id_localizacion_prestador'];
            $v_prestadores[$prestadores['tipo']][$prestadores['id_localizacion_prestador']]['codprestador'] = $prestadores['cod_prestador'];
            $v_prestadores[$prestadores['tipo']][$prestadores['id_localizacion_prestador']]['nom_prestador'] = (!empty($prestadores['nombre']))? $prestadores['nombre']:'-';
            $v_prestadores[$prestadores['tipo']][$prestadores['id_localizacion_prestador']]['maximo_anio'] = $prestadores['maximo_anio'];
            $v_prestadores[$prestadores['tipo']][$prestadores['id_localizacion_prestador']]['anios'] = explode(",", substr($prestadores['anios'],1,-1));
            
            //Busqueda de Evaluacion ==========================================================================================================
            $aniomax = $prestadores['maximo_anio'];
            $idlocalizacionprestador = (!empty($prestadores['id_localizacion_prestador']))? $prestadores['id_localizacion_prestador']:'NULL';
            $barranav[] = (!empty($prestadores['cod_prestador']))? '1':'0';
            $sql_2 = "select * FROM evaluacion_proveedor($aniomax, $idlocalizacionprestador)";
            $rs_sql2 = Yii::$app->db->createCommand($sql_2)->queryOne(); 
            
            $v_prestadores[$prestadores['tipo']][$prestadores['id_localizacion_prestador']]['eval_valor'] = $rs_sql2['valor'];
            $v_prestadores[$prestadores['tipo']][$prestadores['id_localizacion_prestador']]['print_eficiencia'] = (!empty($rs_sql2['nom_categoria']))? $rs_sql2['nom_categoria']:'' ;
            $v_prestadores[$prestadores['tipo']][$prestadores['id_localizacion_prestador']]['print_eficiencia2'] = (!empty($rs_sql2['nom_calificacion']))? $rs_sql2['nom_calificacion']:'NA' ;
            $v_prestadores[$prestadores['tipo']][$prestadores['id_localizacion_prestador']]['cant_estrellas'] = (!empty($rs_sql2['cant_estrellas']))? $rs_sql2['cant_estrellas']:0 ;
            $v_prestadores[$prestadores['tipo']][$prestadores['id_localizacion_prestador']]['color'] = (!empty($rs_sql2['color']))? $rs_sql2['color']:'transparent' ;
            
            
            
            //Bsuqeda de codigo de indicadores a presentar en pantalla =============================================================================
            $sql_3 = "select * FROM indicadores_prestador($idlocalizacionprestador, $aniomax)";
            $rs_sql3 = Yii::$app->db->createCommand($sql_3)->queryAll(); 
            $v_prestadores[$prestadores['tipo']][$prestadores['id_localizacion_prestador']]['resultados'] = $rs_sql3;
                    
            foreach($rs_sql3 as $indicador){
                
              $datagraph = $this->actionHistorico($indicador['cod_indi_param'], 
                                                    $prestadores['id_localizacion_prestador'],
                                                    $indicador['calcular_valor_imprimir'], 
                                                    $indicador['frecuencia_ingreso'], 
                                                    $indicador['tipo_calculo_indicador'], 
                                                    $indicador['frecuencia_x_calculo'], 
                                                    $aniomax,
                                                    $indicador['tipo_dato']);
              
                $graph[$prestadores['id_localizacion_prestador']][$indicador['cod_indi_param']]['labelsgraf'] =  $datagraph['labels'];
                $graph[$prestadores['id_localizacion_prestador']][$indicador['cod_indi_param']]['valoresgraf'] =  $datagraph['valores'];
                $graph[$prestadores['id_localizacion_prestador']][$indicador['cod_indi_param']]['minimo']  = $datagraph['minimo'];
                $graph[$prestadores['id_localizacion_prestador']][$indicador['cod_indi_param']]['maximo']  = $datagraph['maximo'];
                $graph[$prestadores['id_localizacion_prestador']][$indicador['cod_indi_param']]['mes_select']= $datagraph['max_mes'];
                $valorprint[$prestadores['id_localizacion_prestador']][$indicador['cod_indi_param']] = $datagraph['valor_anio_max'];
			

            }


        }
        
        $cantonesall =  $this->LoadCantones();
        
        $_cantonesall = $cantonesall[0];
        $_cantonesbusc = $cantonesall[1];
        
        return $this->renderPartial('canton', [
            'vprestadores'=>$v_prestadores,'searchModel' => $searchModel,'allcantones'=>$_cantonesall,'graph'=>$graph,'buscador'=>$_cantonesbusc,'valor_print'=>$valorprint,'barranav'=>$barranav
        ]);
    }

    /**
     * Displays a single Cantones model.
     * @param string $cod_canton
     * @param string $cod_provincia
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($cod_canton, $cod_provincia)
    {
        return $this->render('view', [
            'model' => $this->findModel($cod_canton, $cod_provincia),
        ]);
    }

    /**
     * Creates a new Cantones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cantones();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'cod_canton' => $model->cod_canton, 'cod_provincia' => $model->cod_provincia]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Cantones model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $cod_canton
     * @param string $cod_provincia
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($cod_canton, $cod_provincia)
    {
        $model = $this->findModel($cod_canton, $cod_provincia);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'cod_canton' => $model->cod_canton, 'cod_provincia' => $model->cod_provincia]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Cantones model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $cod_canton
     * @param string $cod_provincia
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($cod_canton, $cod_provincia)
    {
        $this->findModel($cod_canton, $cod_provincia)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Cantones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $cod_canton
     * @param string $cod_provincia
     * @return Cantones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($cod_canton, $cod_provincia)
    {
        if (($model = Cantones::findOne(['cod_canton' => $cod_canton, 'cod_provincia' => $cod_provincia])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    
    public function actionResultados($year,$cod_canton,$id_localizacion_prestador){
        
        $arrayres=array();
        
        $sql_4 = "select * FROM evaluacion_proveedor($year, $id_localizacion_prestador)";
        $rs_sql4 = Yii::$app->db->createCommand($sql_4)->queryOne(); 
               
        
        $print_eficiencia = (!empty($rs_sql4['nom_categoria']))? $rs_sql4['nom_categoria']:'' ;
        $print_eficiencia2 = (!empty($rs_sql4['nom_calificacion']))? $rs_sql4['nom_calificacion']:'NA';
        $color_eficiencia = (!empty($rs_sql4['color']))? $rs_sql4['color']:'transparent';
        $cantestrellas = (!empty($rs_sql4['cant_estrellas']))? $rs_sql4['cant_estrellas']:0 ;
        $evalor_valor = (!empty($rs_sql4['valor']))? $rs_sql4['valor']:'';
                
        $sql_5 = "select * FROM indicadores_prestador($id_localizacion_prestador, $year)";
        $rs_sql5 = Yii::$app->db->createCommand($sql_5)->queryAll(); 
            
        foreach($rs_sql5 as $resultado){
            
           $datagraph = $this->actionHistorico($resultado['cod_indi_param'],$id_localizacion_prestador, $resultado['calcular_valor_imprimir'], $resultado['frecuencia_ingreso'], $resultado['tipo_calculo_indicador'], $resultado['frecuencia_x_calculo'], $year,$resultado['tipo_dato']);
           
         
           $arrayres[]=['sigla'=>$resultado['sigla'],
                        'descripcion'=>$resultado['descripcion'],
                        'cod_indi_param'=>$resultado['cod_indi_param'],
                        'labelsgraf'=> $datagraph['labels'],
                        'valoresgraf'=> $datagraph['valores'],
                        'valor_cumplimiento' => ceil($resultado['valor_cumplimiento']),
                        'minimo' => $datagraph['minimo'],
                        'maximo' =>ceil($datagraph['maximo']),
                        'valorprint'=>$datagraph['valor_anio_max'],
                        'frecuencia_x_calculo'=>$resultado['frecuencia_x_calculo'],
                        'frecuencia_ingreso'=>$resultado['frecuencia_ingreso'],
                        'calcular_valor_imprimir'=>$resultado['calcular_valor_imprimir'],
                        'mes_selected'=>$datagraph['max_mes'],
                        'final'=>$year,
                        'tipo_dato'=>$resultado['tipo_dato'],
                        'coloreficiencia'=>$color_eficiencia,
                        'eficianciaprint'=>$print_eficiencia,
                        'eficaciaprint2'=>$print_eficiencia2,
                        'cant_estrellas'=>$cantestrellas,
                        'eval_valor'=>$evalor_valor,
                        ];
           
           
        } 
        
        return json_encode($arrayres);
        
    }
    
    /*
     * @calcular_valor_imprimir = 'S' requiere calculo, 'N' se imprime segun frecuencia de ingreso
     * @tipo_calculo_indicador = Operacion a realizar promedio, desviación
     * @frecuencia_x_calculo = mensual por anio -> se calculo el valor promedio por cada año desde enero a diciembre
     */
    protected function actionHistorico($codindicador,$id_localizacion_prestador,$calcvalimp,$frec_ingreso,$tipo_cal_indicador,$frec_x_calc,$max_year,$tipo_dato){
        
        $arrayres=array();
        $labels=array();
        $_bandera = false;
        $_maximo = 0;
        $_minimo = 0;
        $_valor_mes = 12;
        
        //Evaluando caracter de unidad por tipo de dato
        if($tipo_dato == 'P'){
            $_unidad = '[%]';
        }else{
            $_unidad = '';
        }
        
        
        if($calcvalimp == 'S')
        {
            /*Frecuencia Mensual*/
            if($frec_ingreso == 'mensual' && $tipo_cal_indicador == 'promedio' && $frec_x_calc == 'mensual por anio')
            {
                $_sql = "SELECT anio,avg(valor) as promedio,
                            (CASE WHEN (avg(valor)>desempeno_indi_param.v_limite_alto or avg(valor)<desempeno_indi_param.v_limite_bajo) THEN 'Fuera de Rango' ELSE '' END) as messfr
                            FROM hechos
                            WHERE hechos.id_localizacion_prestador = '".$id_localizacion_prestador."' and cod_indi_param = '".$codindicador."' and anio<='".$max_year."' 
                            LEFT JOIN desempeno_indi_param ON desempeno_indi_param.cod_indi_param = hechos.cod_indi_param    
                            GROUP BY anio,v_limite_bajo,v_limite_alto ORDER BY anio";
                
                
                $resultados = Yii::$app->db->createCommand($_sql)->queryAll();

                foreach($resultados as $resultado){

                    $labels[] = $resultado['anio'];
                    $arrayres[] = ceil($resultado['promedio']);
                    
                    if($resultado['anio'] == $max_year){
                        
                        if($resultado['promedio'] == null){
                            $_valor_anio_max = '- <br/><span style="font-size:12pt">Sin datos suficientes</span>';
                        }else{
                            $_valor_anio_max = ceil($resultado['promedio']).$_unidad." ".'<br/><span style="font-size:12pt">'.$resultado['messfr'].'</span>';
                        }    
                    }
                    
                    if($_maximo<$resultado['promedio']){
                        $_maximo = $resultado['promedio'];
                    }
                    
                    if($_minimo>$resultado['promedio']){
                        $_minimo = $resultado['promedio'];
                    }
                }


            }else{                              //Se programa solo mensual por ahora
                
               $_bandera = true;
                
            }
        }
        else
        {
            $command = "SELECT *, 
                    (CASE WHEN (hechos.valor>desempeno_indi_param.v_limite_alto or hechos.valor<desempeno_indi_param.v_limite_bajo) THEN 'Fuera de Rango' ELSE '' END) as messfr
                         FROM hechos 
                         LEFT JOIN desempeno_indi_param ON desempeno_indi_param.cod_indi_param = hechos.cod_indi_param 
                         WHERE (( id_localizacion_prestador = :id_localizacion_prestador )
                         AND ( hechos.cod_indi_param = :cod_indi_param )) 
                         AND ( anio <= :anio ) 
                        ORDER BY
                             anio ASC";
            
            $resultados = Yii::$app->db->createCommand($command)
                          ->bindValue(":id_localizacion_prestador",$id_localizacion_prestador)
                          ->bindValue(":cod_indi_param",$codindicador)
                          ->bindValue(":anio",$max_year)
                          ->queryAll(); 
            
//            $command = (new \yii\db\Query())
//                    ->select(['CASE WHEN `valor`>`desempeno_indi_param.v_limite_alto` and `valor`<`desempeno_indi_param.v_limite_bajo` THEN "Fuera de Rango" ELSE "" END AS `messfr`','hechos.cod_hechos,hechos.anio,hechos.cod_indi_param,hechos.valor,hechos.consecutivocarga,hechos.mes,hechos.cod_hecho_relacionado,hechos.id_localizacion_prestador'])
//                    ->leftJoin('hechos', 'hechos.cod_indi_param = desempeno_indi_param.cod_indi_param')
//                    ->from('hechos')
//                    ->where(['id_localizacion_prestador' =>$id_localizacion_prestador])
//                    ->andWhere(['hechos.cod_indi_param' => $codindicador])
//                    ->andwhere(['<=','anio',$max_year])->with('codIndiParam')
//                    ->orderBy(['anio' => SORT_ASC])
//                    ->createCommand();
//            $resultados = $command->queryAll();
            
            
            /*$resultados = \app\models\gisindicadores\Hechos::find()
                        ->where(['id_localizacion_prestador'=>$id_localizacion_prestador,'cod_indi_param'=>$codindicador])->orderby(['anio'=>SORT_ASC])->all();*/


            if($frec_ingreso == 'Anual'){

                foreach($resultados as $resultado){

                    $labels[] = $resultado['anio'];
                    $arrayres[] = $resultado['valor'];
                    
                    if($resultado['anio'] == $max_year){
                        
                        if($resultado['valor'] == null){
                           $_valor_anio_max = '- <br/><span style="font-size:12pt">Sin datos suficientes</span>';
                        }else{
                            $_valor_anio_max = $resultado['valor'].$_unidad." ".'<br/><span style="font-size:12pt">'.$resultado['messfr'].'</span>';
                        }    
                    }
                    
                    if($_maximo<$resultado['valor']){
                        $_maximo = $resultado['valor'];
                    }
                    
                    if($_minimo>$resultado['valor']){
                        $_minimo = $resultado['valor'];
                    }

                }

            }else if($frec_ingreso  == 'mensual'){


                foreach($resultados as $resultado){
                    $labels[$resultado['anio']][] = $resultado['anio']."-".$resultado['mes'];
                    $arrayres[$resultado['anio']][] = $resultado['valor'];
                    
                    
                    if($resultado['anio'] == $max_year){
                        
                        if($resultado['valor'] == null){
                           $_valor_anio_max = '- <br/><span style="font-size:12pt">Sin datos suficientes</span>';
                        }else{
                            $_valor_anio_max = $resultado['valor'].$_unidad." ".'<br/><span style="font-size:12pt">'.$resultado['messfr'].'</span>';
                        }  
                        $_valor_mes = $resultado->mes;
                    }
                    
                    if($_maximo<$resultado['valor']){
                        $_maximo = $resultado['valor'];
                    }
                    
                    if($_minimo>$resultado['valor']){
                        $_minimo = $resultado['valor'];
                    }
                }

            }else{                                              //Si no esta definido se muestra por año

                $_bandera = true;
            }
        }
        
        
        //Aqui entra cuando esta mal configurado ================================================
        if($_bandera == true){
            
            
            $command = "SELECT *, 
                    (CASE WHEN (hechos.valor>desempeno_indi_param.v_limite_alto or hechos.valor<desempeno_indi_param.v_limite_bajo) THEN 'Fuera de Rango' ELSE '' END) as messfr
                         FROM hechos 
                         LEFT JOIN desempeno_indi_param ON desempeno_indi_param.cod_indi_param = hechos.cod_indi_param 
                         WHERE (( id_localizacion_prestador = :id_localizacion_prestador )
                         AND ( hechos.cod_indi_param = :cod_indi_param )) 
                         AND ( anio <= :anio ) 
                        ORDER BY
                             anio ASC";
            
            $resultados = Yii::$app->db->createCommand($command)
                          ->bindValue(":id_localizacion_prestador",$id_localizacion_prestador)
                          ->bindValue(":cod_indi_param",$codindicador)
                          ->bindValue(":anio",$max_year)
                          ->queryAll(); 
            
            /*$resultados = \app\models\gisindicadores\Hechos::find()
                            ->where(['id_localizacion_prestador'=>$id_localizacion_prestador,'cod_indi_param'=>$codindicador])->andwhere(['<=','anio',$max_year])->with('codIndiParam')->orderby(['anio'=>SORT_ASC])->all();*/
            
            foreach($resultados as $resultado){
                $labels[] = $resultado['anio'];
                $arrayres[] = $resultado['valor'];

                if($resultado['anio'] == $max_year){
                    if($resultado['valor'] == null){
                        $_valor_anio_max = '- <br/><span style="font-size:12pt">Sin datos suficientes</span>';
                    }else{
                        $_valor_anio_max = $resultado['valor'].$_unidad." ".'<br/><span style="font-size:12pt">'.$resultado['messfr'].'</span>';
                    }    
                }
                
                if($_maximo<$resultado['valor']){
                        $_maximo = $resultado['valor'];
                }

                if($_minimo>$resultado['valor']){
                    $_minimo = $resultado['valor'];
                }
            }
            
        }
        
        return [
            'labels' => $labels,'valores' => $arrayres,'valor_anio_max' =>$_valor_anio_max,'maximo'=>$_maximo,'minimo'=>$_minimo,'max_mes'=>$_valor_mes
        ];
    }
    
    
    protected function LoadCantones(){
        
        $_sqlcantones = \app\models\gisindicadores\Localizacion::find()->where(['id_tipolocalizacion'=>'2'])->with('localizacionpadre')->all();
        $vcantones = array();
        $vbuscador = array();
 
        foreach($_sqlcantones as $_canton){
        
            $vcantones[]=[ 'dpa_canton'=>$_canton["cod_oficial"],
                           'nombre_canton'=>$_canton['nombre'].'-'.$_canton["localizacionpadre"]->nombre
                          ]; 
             
            $vbuscador[]=['value'=>$_canton['cod_oficial'],'label'=>$_canton['nombre'].' - '.$_canton["localizacionpadre"]->nombre,'id'=>$_canton['cod_oficial']];
      
        }
        
        return [json_encode($vcantones),$vbuscador];
    }
    
    
    
    public function actionValorindicador($cod_canton,$indicador,$mes_value,$final){
     
        $valorindicador = \app\models\gisindicadores\Hechos::find()->where(['cod_localizacion'=>$cod_canton,'cod_indi_param'=>$indicador,'mes'=>$mes_value,'anio'=>$final])->with('codIndiParam')->one();
        
        return $valorindicador['valor'];
    }
    
   /*Para su uso ver https://mpdf.github.io/getting-started/html-or-php.html*/
    public function actionGenpdf($cod_canton,$year=null){
        
        
//          $resultados = \app\models\gisindicadores\IndicadorParametro::find()->select(['*'])
//                        ->leftJoin('hechos', 'hechos.cod_indi_param = indicador_parametro.cod_indi_param')
//                        ->where(['hechos.cod_localizacion'=>$cod_canton,'hechos.anio'=>$year,'indicador_parametro.tipo'=>'I'])
//                        ->orderBy(['indicador_parametro.cod_indi_param'=>'SORT_ASC'])
//                        ->orderBy(['indicador_parametro.tipo'=>'SORT_ASC'])
//                        ->all();
//        $string='<div id="setIndicador"> ';
//                                if (count($resultados) == 0) {
//
//                                    $string.='<div class="emptyMsg"><p>No existen resultados para el periodo seleccionado</p></div>';
//                                }
//
//                                
//                                foreach ($resultados as $indicador_parametro) {
//                                
//                                     $string.='<div class="card">
//                                        <div class="card-body">
//                                            <div class="row">
//                                                <div class="col-md-6 pt-1">
//                                                    <div class="headIndicador"> 
//                                                            <span class="h3">'.$indicador_parametro['sigla'].'</span>
//                                                            <p>'.$indicador_parametro['descripcion'].'</p>
//                                                    </div>
//                                                </div>
//                                                <div class="col-xs-6 col-md-3 pt-4">
//                                                    <div class="data-values">
//                                                            <span class="h1" id="valorprint_'. $indicador_parametro['cod_indi_param'].'">'. $indicador_parametro['valor'].'</span>
//                                                    </div>
//                                                </div>
//                                                <div class="col-xs-6 col-md-3 pt-1">
//                                                   <div class="data-values">
//                                                       <span class="h6" style="display:block" >Valores de Cumplimiento</span>
//                                                       <span class="h1">'.ceil($indicador_parametro['valor_cumplimiento']).'</span>
//                                                    </div>
//                                                </div>
//                                            </div>
//                                        </div>
//                                        
//                                      
//                                    </div>';
//                                
//                                }
//                                
//                            $string.='</div>';   
        
        $sql2 = "SELECT * from evaluacion_proveedor_pdf('".$cod_canton."',".$year.")";
        $resultados2 = Yii::$app->db->createCommand($sql2)->queryAll(); 
        $htmlContent2='';
            if (count($resultados2) == 0) {
           
                 $htmlContent2 = '<div id="setIndicador"><div class="emptyMsg"><p>No existen evaluaciones de desempeño para el periodo seleccionado</p></div></div>';
            } 
            else{
                 $htmlContent2='<table><tr><td><h1><b>Desempeño de los proveedores</b></h1></td></tr></table><table style="border-spacing: 0; width:100%;"><tr>';
                $body='';
                $i=0;
 
                $htmlContent2=$htmlContent2.'<th style="background-color: #51d1f6;color: #ffffff;text-align: center;border:0.5px solid; width:auto; ">Año</th>';
                $htmlContent2=$htmlContent2.'<th style="background-color: #51d1f6;color: #ffffff;text-align: center;border:0.5px solid; width:auto;  ">Nombre del Proveedor</th>';
                $htmlContent2=$htmlContent2.'<th style="background-color: #51d1f6;color: #ffffff;text-align: center;border:0.5px solid; width:auto;  ">Calificación</th>';
                $htmlContent2=$htmlContent2.'<th style="background-color: #51d1f6;color: #ffffff;text-align: center;border:0.5px solid; width:auto; ">Desempeño</th>';
                $htmlContent2=$htmlContent2.'<th style="background-color: #51d1f6;color: #ffffff;text-align: center;border:0.5px solid; width:auto;  ">Categoria</th>';
                foreach($resultados2 as $row) {
                    $body=$body.'<tr>';
                    
                     foreach ($row as $columnName => $columnValue)                    
                     {
                          $pix=strlen(strval($columnValue))+5;
                        if($columnName=='color'){$body=$body.'<td style="width:'.$pix.'px; border:0.5px solid; padding:5px; background-color: '.$columnValue.';"> ';}
                        else{
                            if($columnName=='nom_categoria'){$body=$body.$columnValue.'</td>';}else{
                                $body=$body.'<td style="width:'.$pix.'px; border:0.5px solid; padding:5px; "> '.$columnValue.'</td>';
                            }
                        }
                    }
                     $i=$i+1;
                     $body=$body.'</tr>';
                }
                $htmlContent2=$htmlContent2.'</tr>'.$body.'</table>';
            }
        
         $sql = "SELECT * from loadIndicadores('".$cod_canton."',".$year.")";
           $resultados = Yii::$app->db->createCommand($sql)->queryAll(); 
           
           $htmlContent='';
            if (count($resultados) == 0) {
           
                 $htmlContent = '<div id="setIndicador"><div class="emptyMsg"><p>No existen indicadores o parametros para el periodo seleccionado</p></div></div>';
            } 
            else{
                $htmlContent='<table><tr><td><h1><b>Indicadores y parámetros</b></h1></td></tr></table><table style="border-spacing: 0; width:100%;"><tr>';
                $body='';
                $i=0;
                foreach($resultados as $row) {
                    $body=$body.'<tr>';
                    
                     foreach ($row as $columnName => $columnValue)                    
                     {
                        if ($i<=0){
                            $pix=strlen(strval($columnValue))+5;
                            $htmlContent=$htmlContent.'<th style="background-color: #51d1f6;color: #ffffff;text-align: center;border:0.5px solid; width:'.$pix.'px; ">'.$columnName.'</th>';

                        }
                         $body=$body.'<td style="width:auto; border:0.5px solid; padding:5px; "> '.$columnValue.'</td>';
                    }
                     $i=$i+1;
                     $body=$body.'</tr>';
                }
                $htmlContent=$htmlContent.'</tr>'.$body.'</table>';
            }
        
        $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
        $mpdf->WriteHTML($htmlContent2.'<br><br>'.$htmlContent);
        $mpdf->Output();
        exit;
    }
    
    
    /*Para generar archivos de Excel*/
    public function actionGenexcel($cod_canton,$year=null){
        
        $sql2 = "SELECT * from evaluacion_proveedor_pdf('".$cod_canton."',".$year.")";
        $resultados2 = Yii::$app->db->createCommand($sql2)->queryAll(); 
        $htmlContent2='';
            if (count($resultados2) == 0) {
           
                 $htmlContent2 = '<div id="setIndicador"><div class="emptyMsg"><p>No existen evaluaciones de desempeño para el periodo seleccionado</p></div></div>';
            } 
            else{
                 $htmlContent2='<table><tr><td><h1><b>Desempeño de los proveedores</b></h1></td></tr></table><table style="border-spacing: 0;width:100%;"><tr>';
                $body='';
                $i=0;
 
                $htmlContent2=$htmlContent2.'<th style="background-color: #51d1f6;color: #ffffff;text-align: center; width:auto; ">Año</th>';
                $htmlContent2=$htmlContent2.'<th style="background-color: #51d1f6;color: #ffffff;text-align: center; width:auto;  ">Nombre del Proveedor</th>';
                $htmlContent2=$htmlContent2.'<th style="background-color: #51d1f6;color: #ffffff;text-align: center; width:auto;  ">Calificación</th>';
                $htmlContent2=$htmlContent2.'<th style="background-color: #51d1f6;color: #ffffff;text-align: center; width:auto; ">Desempeño</th>';
                $htmlContent2=$htmlContent2.'<th style="background-color: #51d1f6;color: #ffffff;text-align: center; width:auto;  ">Categoria</th>';
                
                       foreach($resultados2 as $row) {
                    $body=$body.'<tr>';
                    
                     foreach ($row as $columnName => $columnValue)                    
                     {
                          $pix=strlen(strval($columnValue))+5;
                        if($columnName=='color'){$body=$body.'<td style="width:'.$pix.'px;  padding:5px; background-color: '.$columnValue.';"> ';}
                        else{
                            if($columnName=='nom_categoria'){$body=$body.$columnValue.'</td>';}else{
                                $body=$body.'<td style="width:'.$pix.'px;  padding:5px; "> '.$columnValue.'</td>';
                            }
                        }
                    }
                     $i=$i+1;
                     $body=$body.'</tr>';
                }
                $htmlContent2=$htmlContent2.'</tr>'.$body.'</table>';
            }
        
           $sql = "SELECT * from loadIndicadores('".$cod_canton."',".$year.")";
           $resultados = Yii::$app->db->createCommand($sql)->queryAll(); 
           
           $htmlContent='';
            if (count($resultados) == 0) {
           
                 $htmlContent = '<div id="setIndicador"><div class="emptyMsg"><p>No existen resultados para el periodo seleccionado</p></div></div>';
            } 
            else{
                $htmlContent='<table><tr><td><h1><b>Indicadores y parámetros</b></h1></td></tr></table><table><tr>';
                $body='';
                $i=0;
                foreach($resultados as $row) {
                    $body=$body.'<tr>';
                    
                     foreach ($row as $columnName => $columnValue)                    
                     {
                        if ($i<=0){
                            $pix=strlen(strval($columnValue))+5;
                            $htmlContent=$htmlContent.'<th style="background-color: #51d1f6;color: #ffffff;text-align: center;width:'.$pix.'px;">'.$columnName.'</th>';

                        }
                         $body=$body.'<td style="white-space:nowrap; "> '.$columnValue.'</td>';
                    }
                     $i=$i+1;
                     $body=$body.'</tr>';
                }
                $htmlContent=$htmlContent.'</tr>'.$body.'</table>';
            }
        
       $generador = new \app\helpers\htmlToExcel();
       $generador->namefile = "Canton".$cod_canton;
       $generador->descarga = true;
       $generador->htmlContent = $htmlContent2.'<br><br>'.$htmlContent;
       $generador->filecss = "css/cssExample/ejemplo.css";
       
        $generador->genExcel();
    }
    
}
