<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use Mpdf;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($dpa_canton=0)
    {
        
         //Limpiando Cache =================================//
        Yii::$app->cache->flush();
        
        //Cargando Periodos ================================//
        $periodos = $this->LoadPeriodos();
        
        //$allData='';
        $allData = $this->loadAll();
        
        //Trayendo listado de Provincias ===================//
        $provincias = $this->LoadProvincias();
        
        //Trayendo listado de cantones =====================//
        $cantones = $this->LoadCantones($dpa_canton);
        
        //Trayendo Listado de Indicadores ===================//
       // $indicadores = $this->LoadIndicadores();
        
        //Trayendo Ranking de Prestadores====================//
        $ranking = $this->actionLoadranking();
        
        
        
        //Trayendo datos ficticios de Makers Ficticios*//
        //$makers = $this->LoadMakers();
        
        //return $this->render('index',['cantones'=>$cantones,'provincias'=>$provincias,'indicadores'=>$indicadores,'periodos'=>$periodos]);
        
        return $this->render('index',['alldata'=>$allData,'periodos'=>$periodos,'cantones'=>$cantones[0],'provincias'=>$provincias,'buscador'=>$cantones[1],'js_canton'=>$dpa_canton,'js_nombre_canton'=>$cantones[2],'ranking'=>$ranking]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
       
        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    
    
    /*
     * Entrega Ranking primeros 50
     */
    public function actionLoadranking($anio=0){
        
        $v_data=array();
        $maxanio=0;
        
        
        $sql_anio = "SELECT anio FROM evaluacion_localizacion_prestador GROUP BY anio ORDER BY anio DESC";
        $allYear = Yii::$app->db->createCommand($sql_anio)->queryAll();

        foreach($allYear as $s_anio){
           $v_data['anios'][] =  $s_anio['anio'];

           if($maxanio<$s_anio['anio']){
               $maxanio = $s_anio['anio'];
           }
        }
        
        if($anio === 0){
            $anio = $maxanio;
        }
        
        $sql = "SELECT * from ranking_prestadores('".$anio."','".Yii::$app->cantidadRanking."',".Yii::$app->tipoPrestadorRanking.")";
        
        $allRanking = Yii::$app->db->createCommand($sql)->queryAll();
        $v_data['ranking'] = $allRanking;
        return json_encode($v_data);  
    }
    
    
    /*
     * Entrega listado de todos los cantones en la base de datos
     */
    protected function LoadCantones($cod_oficial = 0){
        
        $js_nombrecanton = "";
        
        $data = Yii::$app->cache->getOrSet('LoadCantones', function () use ($cod_oficial,$js_nombrecanton) {
            $_sqlcantones = "SELECT
                                localizacion.*,padre.cod_localizacion as cod_provincia,padre.nombre as nombre_provincia,
                                COUNT ( prestador.* ) AS conteo_prestadores 
                        FROM
                                localizacion
                                LEFT JOIN localizacion_prestador ON localizacion_prestador.cod_localizacion = localizacion.cod_localizacion  
                                LEFT JOIN localizacion as padre ON padre.cod_localizacion = localizacion.id_localizacionpadre
                                LEFT JOIN prestador ON prestador.cod_prestador = localizacion_prestador.cod_prestador and prestador.tipo='2'
                        WHERE
                                localizacion.id_tipolocalizacion = '2' 
                        GROUP BY
                                localizacion.cod_localizacion,padre.cod_localizacion";
            $ressql = Yii::$app->db->createCommand($_sqlcantones)->queryAll();        
                    
            $vcantones = array();
            $vbuscador = array();
 
            foreach($ressql as $_canton){
        
                if($cod_oficial != 0 and $cod_oficial == $_canton['cod_oficial']){
                    $js_nombrecanton = $_canton["nombre"];
                }
                
                $vcantones[]=[ 'cod_canton'=>$_canton["cod_localizacion"],
                               'nombre_canton'=>$_canton["nombre"],
                               'latcenter'=>floatval($_canton["latcenter"]),
                               'longcenter'=>floatval($_canton["longcenter"]),
                               'cabecera'=>$_canton['nombre_cabecera'],
                               'dpa_canton'=>$_canton['cod_oficial'],
                               'cod_provincia'=>$_canton['cod_provincia'],
                               'total_prestadores'=>$_canton['conteo_prestadores']];

                $vbuscador[]=['value'=>$_canton['cod_oficial'],'label'=>$_canton['nombre'].' - '.$_canton["nombre_provincia"],'id'=>$_canton['cod_oficial']];
            }
                return [json_encode($vcantones), $vbuscador,$js_nombrecanton];
        }, Yii::$app->params['timeCache']);
        //cachea la consulta de cantones
        return $data;
    }
    
    
    protected function LoadProvincias(){
        $data = Yii::$app->cache->getOrSet('LoadProvincias', function () {
            $_sqlprovincias = \app\models\gisindicadores\Localizacion::find()->where(['id_tipolocalizacion'=>'1'])->all();
            $vprovincias = array();

            foreach($_sqlprovincias as $provincia){
                $vprovincias[]=[ 'cod_provincia'=>$provincia["cod_oficial"],
                               'nombre_provincia'=>$provincia["nombre"],
                               'latcenter'=>floatval($provincia["latcenter"]),
                               'longcenter'=>floatval($provincia["longcenter"])
                            ];
            }

            return json_encode($vprovincias);
        }, Yii::$app->params['timeCache']);
        //cachea la consulta de provincias
        return $data;
    }
    
    
    
    protected function LoadIndicadores(){
        $data = Yii::$app->cache->getOrSet('LoadIndicadores', function () {
            $_sqlindicadores = \app\models\gisindicadores\Indicadorparametro::find()->where(['tipo'=>'I'])->all();
            $vindicadores = array();

            foreach($_sqlindicadores as $indicador){
                $vindicadores[]=[ 'cod_indicador'=>$indicador["cod_indi_param"],
                                 'sigla'=>$indicador["sigla"],
                                 'descripcion'=>$indicador["descripcion"]
                               ];
            }

            return json_encode($vindicadores);
        }, Yii::$app->params['timeCache']);
        //cachea la consulta de indicadores
        return $data;
    }
    
    
     protected function LoadPeriodos(){
         
         
        $data = Yii::$app->cache->getOrSet('LoadPeriodos', function () {
            
            $_sql = "SELECT anio FROM hechos GROUP BY anio ORDER BY anio ASC";
            $_sqlperiodos = Yii::$app->db->createCommand($_sql)->queryAll();

            $lastperiodo=0;
            $vperiodos = array();

            foreach($_sqlperiodos as $periodos){
                $vperiodos[]=[ 'periodo'=>$periodos["anio"],'seleccionar'=>'0'];
            }

            //Definiendo el ultimo para poder anexar el seleccionar
            $_count= count($vperiodos);

            //Se habilita si se quiere un periodo por defector
           // $vperiodos[($_count-1)]['seleccionar'] = '1';

            return json_encode($vperiodos);
         }, Yii::$app->params['timeCache']);
        //cachea la consulta de periodos
        return $data;
    }
    
    
    
    protected function loadAll(){
        
        //$tiempo_inicio = $this->microtime_float();
        //set_time_limit(90);
        
        $data = Yii::$app->cache->getOrSet('loadall', function () { 
          
            //Consultando sin calculo ==============================================================
           $sql = "SELECT * from loadall('N')";
           $allData = Yii::$app->db->createCommand($sql)->queryAll(); 

           $a=0;
           $vindicadores = array();
           $vsalida = array();
           
           foreach($allData as $_indicador){
               $vsalida[$a] = $_indicador;
               $a+=1;
           }
           
           //Consultando los que tienen imprimir en S ============================================
           /*Solo se realizan calculos para valores que sean de ingreso mensual y se calcula promedio anual*/
           /*
            * $_indicadorhecho['calcular_valor_imprimir'] == 'S'
            * $_indicadorhecho['frecuencia_ingreso'] == 'mensual'
            * $_indicadorhecho['tipo_calculo_indicador'] == 'promedio'
            * $_indicadorhecho['frecuencia_x_calculo'] == 'mensual por anio'
            */
           $sql = "SELECT * from loadall('S')";
           $allDataPROM = Yii::$app->db->createCommand($sql)->queryAll(); 
           foreach($allDataPROM as $_indicadorhecho){
                
               $vsalida[$a] = $_indicadorhecho;
                $_sqlprom = "SELECT anio,avg(valor) as promedio
                                    FROM hechos
                                    WHERE cod_indi_param = '".$_indicadorhecho['cod_indi_param']."'
                                    and cod_localizacion = '".$_indicadorhecho['cod_canton']."'    
                                    GROUP BY anio ORDER BY hechos.anio DESC";

                $resultados = Yii::$app->db->createCommand($_sqlprom)->queryAll(); 

                foreach($resultados as $resultado){
                    
                    $vsalida[$a]['anio']= $resultado['anio'];
                    $vsalida[$a]['periodo']= $resultado['anio'];
                    $vsalida[$a]['valor_su']= $resultado['promedio'];
                    $vsalida[$a]['valor']= ceil($resultado['promedio'])." ".$_indicadorhecho['setunidad'];

                    $a+=1;
                }

           }

           return json_encode($vsalida);  
        }, Yii::$app->params['timeCache']);
        
        //$tiempo_fin = $this->microtime_float();
        //$tiempo = $tiempo_fin - $tiempo_inicio;
        
        //Yii::debug("load all data demora: ".$tiempo." tiempo en cache: ".Yii::$app->params['timeCache']);
        
        
        //cachea la consulta de periodos
        return $data;
        
    }
    
    
    protected function loadAll_old($periodo = null){
        
        
        //Limpiando Cache =================================//
        //Yii::$app->cache->flush();
        
        $data = Yii::$app->cache->getOrSet('LoadAll', function () use ($periodo) {
            $sql = 'SELECT * FROM "loadAll"(2';
            if(!is_null($periodo)){
                $sql.=','.$periodo;
            }
            $sql.=')';
            $allData = Yii::$app->db->createCommand($sql)->queryAll();

            return json_encode($allData);  
         }, Yii::$app->params['timeCache']);
        
        //cachea la consulta de periodos
        return $data;
    }
    
    
    
    
    protected function actionHistorico($codindicador,$calcvalimp,$frec_ingreso,$tipo_cal_indicador,$frec_x_calc,$tipo_dato){
        
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
                $_sql = "SELECT anio,avg(valor) as promedio
                            FROM hechos
                            WHERE and cod_indi_param = '".$codindicador."'
                            GROUP BY anio";
                
                
                $resultados = Yii::$app->db->createCommand($_sql)->queryAll();

                foreach($resultados as $resultado){

                    $periodo = $resultado['anio'];
                    $arrayres[] = ceil($resultado['promedio']);
                   
                    
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
            
            $resultados = \app\models\gisindicadores\Hechos::find()->where(['cod_localizacion'=>$cod_localizacion,'cod_indi_param'=>$codindicador])->with('codIndiParam')->all();


            if($frec_ingreso == 'Anual'){

                foreach($resultados as $resultado){

                    $labels[] = $resultado->anio;
                    $arrayres[] = $resultado->valor;
                    
                    if($resultado['anio'] == $max_year){
                        $_valor_anio_max = $resultado['valor'].$_unidad;
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
                    $labels[] = $resultado->anio."-".$resultado->mes;
                    $arrayres[] = $resultado->valor;
                    
                    
                    if($resultado['anio'] == $max_year){
                        $_valor_anio_max = $resultado['valor'].$_unidad;
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
            
            $resultados = \app\models\gisindicadores\Hechos::find()->where(['cod_localizacion'=>$cod_localizacion,'cod_indi_param'=>$codindicador])->with('codIndiParam')->all();
            
            foreach($resultados as $resultado){
                $labels[] = $resultado->anio;
                $arrayres[] = $resultado->valor;

                if($resultado['anio'] == $max_year){
                    $_valor_anio_max = $resultado['valor'].$_unidad;
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
    
    
    /*Para su uso ver https://mpdf.github.io/getting-started/html-or-php.html*/
    public function actionGenpdf(){
        
        $string="<table>"
                . "<thead>"
                . "<th>Prueba 1</th>"
                . "<th>Prueba 2</th>"
                . "</thead>"
                . "<tbody>"
                . "<tr>"
                . "<td>Columna 1</td>"
                . "<td>Columna 2</td>"
                . "<td>Columna 3</td>"
                . "</tr>"
                . "</tbody>"
                . "<tfoot>"
                . "<tr>"
                . "<td colspan='2'>Pie de Tabla</td>"
                . "</tr>"
                . "</tfoot>"
                . "</table>";
        
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($string);
        $mpdf->Output();
        exit;
    }
    
    
    /*Para generar archivos de Excel*/
    public function actionGenexcel(){
        
       $htmlContent = '<table><tr><td class="celda1">Hello World</td></tr><tr><td>Hello World</td></tr><tr><td class="celda2">Hello World</td></table>';
       
       $generador = new \app\helpers\htmlToExcel();
       $generador->namefile = "ejemplo";
       $generador->descarga = true;
       $generador->htmlContent = $htmlContent;
       $generador->filecss = "css/cssExample/ejemplo.css";
       
        $generador->genExcel();
    }
    
    
    protected function microtime_float()
    {
    list($useg, $seg) = explode(" ", microtime());
    return ((float)$useg + (float)$seg);
    }
    
}
