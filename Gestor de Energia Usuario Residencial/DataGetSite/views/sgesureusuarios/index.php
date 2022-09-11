<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SgeSureusuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sure-usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card border-light shadow">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <div class="card-header">

        <?= Html::a('Crear Sure-usuarios', ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <div class="card-body">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pager' => [
                'class' => \yii\bootstrap4\LinkPager::class
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'nombre_usuario',
                'correo_electronico',
                [
                    'label'=>'Serial Medidor',
                    'value'=>'medidor.serial',
                    'attribute'=>'medidor_id'
                ],
                'medidor_id',

            ]
        ]); ?>

    </div>

</div>