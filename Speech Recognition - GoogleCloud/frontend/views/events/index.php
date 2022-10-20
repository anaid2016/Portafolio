<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EventsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="events-index">

    <h1><?= Html::encode($this->title) ?></h1>

  
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id_events',
            [
               'value'=>function($model){
                    if($model->type_event == 1){
                        return 'Web System Access';
                    }else if($model->type_event == 2){
                        return 'Load Video';
                    }else{
                        return 'Search Word';
                    }
               },
               'label'=>'Type Event',
               'attribute'=>'type_event',   
               'filter'=>array("1"=>"Web System Access","2"=>"Load Video","3"=>"Search Word"),     
                       
            ],
            'description',
            'dateevent',
            'video_id',
        ],
    ]); ?>


</div>
