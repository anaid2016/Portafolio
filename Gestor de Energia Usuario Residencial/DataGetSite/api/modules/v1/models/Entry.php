<?php

namespace app\api\modules\v1\models;

use Yii;
use \yii\behaviors\TimestampBehavior;
use \yii\behaviors\BlameableBehavior;
use \yii\db\ActiveRecord;
use \yii\db\Expression;
use \yii\helpers\Url;
use \yii\web\Link; // represents a link object as defined in JSON Hypermedia API Language.
use \yii\web\Linkable;

class Entry extends \yii\db\ActiveRecord implements Linkable {
    
    
     public static function tableName()
    {
        return 'entry';
    }
    
    
    public static function primaryKey()
    {
        return ['registro_id'];
    }
    
    
     public function rules()
    {
        return [
            [['prueba1','prueba2'], 'safe'],
         
        ];
    }
    
     public function behaviors()
    {
        date_default_timezone_set('America/New_York');
        $formattedCurDateTime = date('Y-m-d H:i:s'); // same format as NOW()
 
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at', // OR 'create_time', to override default field name
                'updatedAtAttribute' => 'updated_at', // OR 'update_time', to override default field name
                'value' => new \yii\db\Expression('NOW()'),
                //'value' => new \yii\db\Expression($formattedCurDateTime),
            ],
            //[
            //    'class' => BlameableBehavior::className(),
            //    'createdByAttribute' => 'created_by',  // OR 'author_id', to override default field name
            //    'updatedByAttribute' => 'updated_by',  // OR 'updater_id', to override default field name
            //],
        ];
    }
 
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['view',   'registro_id' => $this->registro_id], true),
            'edit'         => Url::to(['update', 'registro_id' => $this->registro_id], true),
            'index'        => Url::to(['index'], true),
        ];
    }
}
