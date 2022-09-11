<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SgeProyectosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Proyectos';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="card border-light shadow">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <div class="card-header">
        <?= Html::a('Nuevo Registro', ['create'], ['class' => 'btn btn-success']) ?>
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

                'nombre_proyecto',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update}'
                ]
            ],
        ]); ?>
    </div>
</div>