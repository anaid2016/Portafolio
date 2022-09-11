<?php


use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\daterange\DateRangePicker;
use yii\bootstrap4\LinkPager;
use app\assets\SgelecturasAsset;

SgelecturasAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\models\SgeLecturasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sge Lecturas';
$this->params['breadcrumbs'][] = $this->title;

?>
<p>
    <?= Html::a("<span class='fa fa-download' aria-hidden='true'></span>", ['sgelecturas/descargaexcel', Yii::$app->request->queryParams], ['class' => 'btn btn-primary']) ?>
</p>
<div class="table-responsive">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <!-- <p>
        <?= Html::a('Create Sge Lecturas', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'class' => LinkPager::class
        ],
        'options' => ['style' => 'font-size:10px;', 'class' => 'setgridview'],
        'columns' => [
            // [
            //     'label' => '#',
            //     'value' => 'registro_lectura_id'                
            // ],
            [
                'label' => 'Concentrador',
                'value' => function ($model) {
                    return $model->getConcentrador($model->medidor_id);
                },
                'attribute' => 'alias',
                'filter' => ArrayHelper::map(app\models\SgeConcentradores::find()->leftJoin('sge_proyectos', 'sge_concentradores.proyecto_id = sge_proyectos.proyecto_id')->where(['sge_proyectos.usuario_id'=>Yii::$app->user->id])->all(), 'concentrador_id', 'alias_concentrador'),
                'filterInputOptions' => ['prompt' => 'Seleccione', 'class' => 'form-control', 'id' => null]
            ],
            [
                'label' => 'Fecha',
                'value' => 'fecha_hora_registro',
                'format' => 'raw',
                'options' => ['style' => 'width: 20%;'],
                'filter' => DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'fecha_hora_registro',
                    'readonly' => true,
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'timePicker' => false,
                        'timePickerIncrement' => 30,
                        'locale' => [
                            'format' => 'Y-m-d',
                            'cancelLabel' => 'Limpiar',
                            "daysOfWeek" => [
                                "Do",
                                "Lu",
                                "Ma",
                                "Mi",
                                "Ju",
                                "Vi",
                                "Sa"
                            ],
                            "monthNames" => [
                                "Enero",
                                "Febrero",
                                "Marzo",
                                "Abril",
                                "Mayo",
                                "Junio",
                                "Julio",
                                "Agosto",
                                "Setiembre",
                                "Octubre",
                                "Noviembre",
                                "Diciembre"
                            ],
                        ]
                    ]
                ])
            ],
            'tensionfaseA',
            'tensionfaseB',
            'tensionfaseC',
            'corrientefaseA',
            'corrientefaseB',
            'corrientefaseC',
            'activainsfaseA',
            'activainsfaseB',
            'activainsfaseC',
            'activainstotal',
            'reactivainstotal',
            // 'estado_rele',
            'energia_activa',
            'energia_reactiva',
            'fpfaseA',
            'fpfaseB',
            'fpfaseC',
            'frecuencia',
            //'fecha_hora_ingreso',
        ],
    ]); ?>


</div>