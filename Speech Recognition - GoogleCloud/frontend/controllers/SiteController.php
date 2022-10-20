<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

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
    public function actionIndex()
    {
        $this->actionCreateevent(null,null,"1","Acces to the system");
        return $this->render('index');
    }


    
    public function actionUploadaudio(){
        
        if ($file = \yii\web\UploadedFile::getInstanceByName('videoattach')) {
                        
             /*
            * Create Seccion
            */
           $model_session = New \app\models\Sessions();
           $model_session->alias_sesion = $file->name;
           
            if($model_session->save()){
            
                /*Upload File*/
                if ($file->extension == 'mp3') { 
                    if ($file->saveAs(Yii::getAlias('@webroot') . '/audios/' . $file->name)) { 
                        
                        $modelvideo = $this->createvideo(Yii::getAlias('@webroot') . '/audios/' . $file->name, $model_session->id_session);
                        
                    }else{
                        throw new NotFoundHttpException('Error to load video, try again');
                    }
                }else{
                    throw new NotFoundHttpException('The video extensión is not valid.');
                }
                
                /*Conect Api*/
                $transcription = $this->connectAPI(Yii::getAlias('@webroot') . '/audios/' . $file->name, $model_session->id_session);
                
                if(!empty($modelvideo)){
                    $modelvideo->text_video = $transcription->text;
                    $modelvideo->save();
                }
                
                $dictionarywords=array();
                /*Array ( [0] => stdClass Object ( [word] => that's [start_time] => 0 [end_time] => 0.4 ) [1] => stdClass Object ( [word] => the [start_time] => 0.4 [end_time] => 0.6 ) [2] => stdClass Object ( [word] => challenge [start_time] => 0.6 [end_time] => 0.8 ) [3] => stdClass Object ( [word] => with [start_time] => 0.8 [end_time] => 1.3 ) [4] => stdClass Object ( [word] => this [start_time] => 1.3 [end_time] => 1.5 ) [5] => stdClass Object ( [word] => audio [start_time] => 1.5 [end_time] => 1.9 ) [6] => stdClass Object ( [word] => you [start_time] => 1.9 [end_time] => 2.3 ) [7] => stdClass Object ( [word] => have [start_time] => 2.3 [end_time] => 2.4 ) [8] => stdClass Object ( [word] => no [start_time] => 2.4 [end_time] => 2.6 ) [9] => stdClass Object ( [word] => more [start_time] => 2.6 [end_time] => 2.8 ) [10] => stdClass Object ( [word] => than [start_time] => 2.8 [end_time] => 2.8 ) [11] => stdClass Object ( [word] => 60 [start_time] => 2.8 [end_time] => 3.4 ) [12] => stdClass Object ( [word] => seconds [start_time] => 3.4 [end_time] => 3.8 ) [13] => stdClass Object ( [word] => for [start_time] => 3.8 [end_time] => 3.9 ) [14] => stdClass Object ( [word] => the [start_time] => 3.9 [end_time] => 4 ) [15] => stdClass Object ( [word] => test [start_time] => 4 [end_time] => 4.4 ) )*/
                foreach($transcription->timestamp as $value){
                    $this->createWord($modelvideo->id_videos,$value->word,$value->start_time,$value->end_time);
                    $dictionarywords[$value->word]['count']=(!empty($dictionarywords[$value->word]['count']))? $dictionarywords[$value->word]['count']+1:1;
                    $dictionarywords[$value->word]['time']=(!empty($dictionarywords[$value->word]['time']))? $dictionarywords[$value->word]['time'].",".$value->start_time:$value->start_time;
                }
                
                $this->actionCreateevent($modelvideo->id_videos,null,"2","Load Video ".$modelvideo->alias_video);
                
                $output = ["session"=> $modelvideo->id_videos,"text"=>$transcription->text,"words"=>$dictionarywords];
                
                return json_encode($output);
           }
           
        }
    }
    
    
    public function actionCreateevent($video,$word,$type,$description){
        
        $model = New \app\models\Events();
        $model->video_id = $video;
        $model->type_event = $type;
        $model->dateevent=date('Y-m-d h:i:s');
        $model->description = $description;
        
        if(!$model->save()){
            return false;
        }else{
            return true;
        }    
        
    }
    
    protected function createWord($video,$word,$start,$end){
        
        $model = New \app\models\WordTimestamp();
        $model->video_id = $video;
        $model->word = $word;
        $model->start = $start;
        $model->end = $end;
        
        if(!$model->save()){
            throw new NotFoundHttpException('Error saved word, try again');
        }else{
            return $model;
        }    
    }
    
    
    
    protected function createVideo($audio, $session){
        
        $model= New \app\models\Videos();
        $model->alias_video = $audio;
        $model->dateload= date('Y-m-d h:i:s');
        $model->sessions_id=$session;
        
        if(!$model->save()){
            throw new NotFoundHttpException('Error to load video, try again');
        }else{
            return $model;
        }        
    }
    
    
    protected function connectAPI($audio, $session){
        
        
        $curl = curl_init();
        $url="http://18.223.105.203:8000/speechsolvoapi?filemp3=".$audio."&session=".$session;

            
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $transcription = json_decode($response);
        
       
        return $transcription;
        
    }
    
    
    public function actionCreateeventajax($video,$word,$type,$description){
        
        $model = New \app\models\Events();
        $model->video_id = $video;
        $model->type_event = $type;
        $model->dateevent=date('Y-m-d h:i:s');
        $model->description = $description;
        
        if(!$model->save()){
            echo 1;
        }else{
            echo 2;
        }    
        
    }

    

    
    
  
}
