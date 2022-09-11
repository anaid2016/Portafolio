<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SgeMedidoresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Medidores';
$this->params['breadcrumbs'][] = $this->title;

$circuitos =  \app\models\SgeCircuitos::find()->with('concentrador')->all();
$vcircuitos=array();
foreach($circuitos as $circuito){
    
    $vcircuitos[$circuito->circuitos_id] = $circuito->concentrador['alias_concentrador']."-".$circuito->alias;
    
}
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

                [
                    'label' => 'Proyecto',
                    'value' => function ($model) {
                            return $model->sgeproyecto($model->medidor_id);
                    },
                    'attribute' => 'proyecto_id',
                    'filter' => ArrayHelper::map(\app\models\SgeProyectos::find()->all(), 'proyecto_id', 'nombre_proyecto'),
                    'filterInputOptions' => ['prompt' => 'Seleccione', 'class' => 'form-control', 'id' => null]
                ],
                [
                    'label' => 'Sure',
                    'value'=>'sgeSure.nombre_usuario',
                    'attribute' => 'usuario',
                ],            
                [
                    'label' => 'Circuito',
                    'value' => 'circuito.alias',
                    'attribute' => 'circuito_id',
                    'filter' => $vcircuitos,
                    'filterInputOptions' => ['prompt' => 'Seleccione', 'class' => 'form-control', 'id' => null]
                ],
                [
                    'label' => 'Serial del Medidor',
                    'value' => 'serial',
                    'attribute' => 'serial'
                ],
                [
                    'label' => 'Modbus',
                    'value' => 'modbusposition',
                    'attribute' => 'modbusposition'
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
                    'label' => 'Fecha',
                    'attribute' => 'fecha_creado',
                    'value' => 'fecha_creado',
                    'format' => 'raw',
                    'options' => ['style' => 'width: 20%;'],
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'fecha_creado',
                        'options' => ['readonly' => true],
                        'pluginOptions' => [
                            'id' => 'fecha',
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd',
                            'startView' => 'year',
                        ]
                    ])
                ],  
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update}'
                ]          
                //'fecha_modificado',

            ],
        ]); ?>
    </div>

</div>