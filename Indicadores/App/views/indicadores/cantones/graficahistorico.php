<?php

use yii\helpers\Html;
use dosamigos\chartjs\ChartJs;

/* @var $this yii\web\View */
/* @var $model app\models\indicadores\Cantones */

$this->params['breadcrumbs'][] = 'Hitorico';
?>
<div class="canton-historico">

    <h1><?= Html::encode($this->title) ?></h1>

    
    <?= ChartJs::widget([
        'type' => 'bar',
        'options' => [
            'height' => 400,
            'width' => 400
        ],
        'data' => [
            'labels' =>$labels,
            'datasets' => [
                [
                    'label' => "Historico",
                    'backgroundColor' => "rgba(37,176,236,0.8)",
                    'borderColor' => "rgba(37,176,236,0.8)",
                    'data' => $valores
                ]
            ],
        ],
        'clientOptions' =>[
            'scales' => [
                'yAxes' => [[
                    'ticks' => [
                       'beginAtZero' => true,
                        'steps' => 10,
                        'stepValue' => 10,
                        'max' => 110
                    ]
                ]]
            ]
        ]    
        
    ]);
    ?>

</div>
