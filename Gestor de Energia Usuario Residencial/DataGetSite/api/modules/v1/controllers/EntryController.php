<?php


namespace app\api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

class EntryController extends ActiveController{
 
     public $modelClass = 'app\api\modules\v1\models\Entry';    
     
     
     public function behaviors()
    {
        $behaviors = parent::behaviors();
 
        $isAuthenticationRequired = \Yii::$app->params['isApiAuthenticationEnabled'];
 
        if ($isAuthenticationRequired) {
            // Required for API authentication
            $behaviors['authenticator'] = [
                // HTTP Basic Authentication
                // header('Authorization: Basic '. base64_encode("user:password"));
                //'class' => HttpBasicAuth::className(),
 
                // Composite Authentication
                'class' => CompositeAuth::className(),
                'authMethods' => [
                    HttpBasicAuth::className(),    // header('Authorization: Basic '. base64_encode("user:password"));
                    HttpBearerAuth::className(),   // header('Authorization: Bearer '. $token);
                    QueryParamAuth::className(),   // https://example.com/cms/api/v1/entries?access-token=xxxxxxxx
                ],
            ];
        }
 
        return $behaviors;
    }
 
    //------------------------
    // Test actions
    //------------------------
    // Media index:
    // $ curl -i -H "Accept:application/json" http://127.0.0.1/cms/api/v1/entries
    //
    // Authorization: HTTP Basic Auth
    // $ curl -i -H "Accept:application/json" http://123-token@127.0.0.1/cms/api/v1/entries
    // $ curl -i -H "Accept:application/json" --user jdoe:secret http://127.0.0.1/cms/api/v1/entries
    //
    // Authorization: HTTP Bearer Token
    // $ curl -i -H "Accept:application/json" -H "Authorization: Bearer 123-token" http://127.0.0.1/cms/api/v1/entries
    //
    // Authorization: HTTP Query Param
    // $ curl -i -H "Accept:application/json" http://127.0.0.1/cms/api/v1/entries?access-token=123-token
    
}
