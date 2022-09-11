<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $searchModel app\models\SgeConcentradoresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Concentradores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card border-light shadow">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <div class="card-header">

        <?= Html::a('Nuevo Concentrador', ['create'], ['class' => 'btn btn-success']) ?>
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

                'alias_concentrador',
                'serial_concentrador',
                [
                    'label' => 'Proyecto',
                    'value' => 'proyecto.nombre_proyecto',
                    'attribute' => 'proyecto_id',
                    'filter' => ArrayHelper::map(\app\models\SgeProyectos::find()->all(), 'proyecto_id', 'nombre_proyecto'),
                    'filterInputOptions' => ['prompt' => 'Seleccione', 'class' => 'form-control', 'id' => null]
                ],
                'ip',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {config}',
                    'buttons' => [
                        'config' => function ($url, $model) {
                            return Html::a('<i class="fa fa-cogs" title="Estado" style="font-size:18px"></i>', $url = 'index.php?r=sgeconcentradores/configuraciones&concentrador_id='.$model->concentrador_id.'&ip_conecentrador='.$model->ip);
                        },
                    ]
                ]
            ],
        ]); ?>
    </div>

</div>