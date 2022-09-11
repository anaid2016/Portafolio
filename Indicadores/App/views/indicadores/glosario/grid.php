<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\gisindicadores\GlosarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="indicador-parametro-index">
   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

		    'sigla',
            'nombre',
            'descripcion',
            'formula',
            'unidad',


        ],
    ]); ?>
</div>
