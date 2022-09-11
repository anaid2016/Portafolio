<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SgeCircuitosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Circuitos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card border-light shadow">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <div class="card-header">

        <?= Html::a('Nuevo Circuito', ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <div class="card-body">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pager' => [
                'class' => \yii\bootstrap4\LinkPager::class
            ],
            'columns' => [
                'circuitos_id',
                'alias',
                'numerico',
                [
                    'label' => 'Concentrador',
                    'value' => 'concentrador.alias_concentrador',
                    'attribute' => 'concentrador_id',
                    'filter' => ArrayHelper::map(\app\models\SgeConcentradores::find()->all(), 'concentrador_id', 'alias_concentrador'),
                    'filterInputOptions' => ['prompt' => 'Seleccione', 'class' => 'form-control', 'id' => null]
                ],
                [
                    'label' => 'Proyecto',
                    'value' => 'concentrador.proyecto.nombre_proyecto',
                    'attribute' => 'proyecto_id',
                    'filter' => ArrayHelper::map(\app\models\SgeProyectos::find()->all(), 'proyecto_id', 'nombre_proyecto'),
                    'filterInputOptions' => ['prompt' => 'Seleccione', 'class' => 'form-control', 'id' => null]
                ],
               [
                    'label' => 'Estado',
                    'value' => function ($model) {
                        if($model->estado_id == 1){
                            return 'ACTIVO';
                        }else{
                            return 'INACTIVO';
                        }
                    },
                    'attribute' => 'estado_id',
                    'filter' => [1=> 'ACTIVO',2 => 'INACTIVO'],
                    'filterInputOptions' => ['prompt' => 'Seleccione', 'class' => 'form-control', 'id' => null]
                ],                
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update}'
                ] 

            ],
        ]); ?>


    </div>
</div>