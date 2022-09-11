<?php

use dosamigos\chartjs\ChartJs;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\assets\SgelecturasAsset;

SgelecturasAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\models\SgeLecturasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sge Graficos';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="card border-primary">
    <div class="card-header">
        <?php $form = ActiveForm::begin([

            'method' => 'get',
            'action' => ['sgelecturas/graficas'],

        ]); ?>
        <div class="row p-3">
            <div class="form-group col-lg-3">
                <label for="finicial">Fecha Inicial:</label>
                <input type="date" name="finicial" class="form-control" value="<?= $finicio ?>">
            </div>
            <div class="form-group col-lg-3">
                <label for="ffinal">Fecha Final:</label>
                <input type="date" name="ffinal" class="form-control" value="<?= $ffinal ?>">
            </div>

            <div class="form-group col-lg-3">
                <label for="cto">Circuito:</label>
                <select name="cto" class="form-control">
                    <?php
                    $selected = '';
                    foreach ($ctos as $key => $value) {

                        if ($cto ==  $value->circuitos_id) {
                            $selected = 'SELECTED=SELECTED';
                        } else {
                            $selected = '';
                        }
                        echo '<option ' . $selected . ' value=' . $value->circuitos_id . '>';
                        echo  $value->alias;
                        echo '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group col-lg-3">
                <label for="tgrafica">Tipo de grafica:</label>
                <select name="tgrafica" id="tgrafica" class="form-control">
                    <option value="" <?php
                                        if (empty($tgrafica)) {
                                            echo 'SELECTED=SELECTED';
                                        }
                                        ?>>Seleccione</option>
                    <option value="1" <?php
                                        if ($tgrafica == 1) {
                                            echo 'SELECTED=SELECTED';
                                        }
                                        ?>>Variables Electricas</option>
                    <option value="2" <?php
                                        if ($tgrafica == 2) {
                                            echo 'SELECTED=SELECTED';
                                        }
                                        ?>>Energias</option>
                </select>
            </div>
            <div class="form-group col-lg-12">
                <button class="btn btn-success">Buscar</button>
                <!-- <button class="btn btn-info" type="button" id="limpiar">Limpiar</button> -->
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="card-body">
        <div class="row">
            <?php if ($tgrafica == 1) {
                if (count($datos) > 0) { ?>
                    <div class="col-lg-12 form-group">

                        <?= ChartJs::widget([
                            'type' => 'line',
                            'options' => [
                                'height' => 150,
                                'width' => 400
                            ],
                            'clientOptions' => [
                                'title' => [
                                    'display' => true,
                                    'text' => 'Voltaje (V)'
                                ],
                                'scales' => [
                                    'xAxes' => [
                                        [
                                            'ticks' => [
                                                'fontSize' => 8
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            'data' => [
                                'labels' => $datos['fechas'],
                                'datasets' => [
                                    [
                                        'label' => "Tension FaseA",
                                        'backgroundColor' => "rgba(247, 208, 68,0.2)",
                                        'borderColor' => "rgb(247, 208, 68)",
                                        'pointBackgroundColor' => "rgb(247, 208, 68)",
                                        'pointBorderColor' => "#fff",
                                        'pointHoverBackgroundColor' => "#fff",
                                        'pointHoverBorderColor' => "rgb(247, 208, 68)",
                                        'data' => $datos[0]['tfa'],
                                        'fill' => false
                                    ],
                                    [
                                        'label' => "Tension FaseB",
                                        'backgroundColor' => "rgba(17, 17, 17,0.2)",
                                        'borderColor' => "rgba(17, 17, 17,1)",
                                        'pointBackgroundColor' => "rgba(17, 17, 17,1)",
                                        'pointBorderColor' => "#fff",
                                        'pointHoverBackgroundColor' => "#fff",
                                        'pointHoverBorderColor' => "rgba(17, 17, 17,1)",
                                        'data' => $datos[0]['tfb'],
                                        'fill' => false
                                    ],
                                    [
                                        'label' => "Tension FaseC",
                                        'backgroundColor' => "rgb(57, 59, 121,0.2)",
                                        'borderColor' => "rgb(57, 59, 121)",
                                        'pointBackgroundColor' => "rgb(57, 59, 121)",
                                        'pointBorderColor' => "#fff",
                                        'pointHoverBackgroundColor' => "#fff",
                                        'pointHoverBorderColor' => "rgb(57, 59, 121)",
                                        'data' => $datos[0]['tfc'],
                                        'fill' => false
                                    ]
                                ]
                            ]
                        ]);
                        ?>
                    </div>
                    <div class="col-lg-12 form-group">

                        <?= ChartJs::widget([
                            'type' => 'line',
                            'options' => [
                                'height' => 150,
                                'width' => 400
                            ],
                            'clientOptions' => [
                                'title' => [
                                    'display' => true,
                                    'text' => 'Corriente (A)'
                                ],
                                'scales' => [
                                    'xAxes' => [
                                        [
                                            'ticks' => [
                                                'fontSize' => 8
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            'data' => [
                                'labels' => $datos['fechas'],
                                'datasets' => [
                                    [
                                        'label' => "Corriente FaseA",
                                        'backgroundColor' => "rgba(247, 208, 68,0.2)",
                                        'borderColor' => "rgba(247, 208, 68,1)",
                                        'pointBackgroundColor' => "rgba(247, 208, 68,1)",
                                        'pointBorderColor' => "#fff",
                                        'pointHoverBackgroundColor' => "#fff",
                                        'pointHoverBorderColor' => "rgba(247, 208, 68,1)",
                                        'data' => $datos[1]['cfa'],
                                        'fill' => false
                                    ],
                                    [
                                        'label' => "Corriente FaseB",
                                        'backgroundColor' => "rgba(17, 17, 17,0.2)",
                                        'borderColor' => "rgba(17, 17, 17,1)",
                                        'pointBackgroundColor' => "rgba(17, 17, 17,1)",
                                        'pointBorderColor' => "#fff",
                                        'pointHoverBackgroundColor' => "#fff",
                                        'pointHoverBorderColor' => "rgba(17, 17, 17,1)",
                                        'data' => $datos[1]['cfb'],
                                        'fill' => false
                                    ],
                                    [
                                        'label' => "Corriente FaseC",
                                        'backgroundColor' => "rgb(57, 59, 121,0.2)",
                                        'borderColor' => "rgb(57, 59, 121)",
                                        'pointBackgroundColor' => "rgb(57, 59, 121)",
                                        'pointBorderColor' => "#fff",
                                        'pointHoverBackgroundColor' => "#fff",
                                        'pointHoverBorderColor' => "rgb(57, 59, 121)",
                                        'data' => $datos[1]['cfc'],
                                        'fill' => false
                                    ]
                                ]
                            ]
                        ]);
                        ?>
                    </div>
                    <div class="col-lg-12 form-group">

                        <?= ChartJs::widget([
                            'type' => 'line',
                            'options' => [
                                'height' => 150,
                                'width' => 400
                            ],
                            'clientOptions' => [
                                'title' => [
                                    'display' => true,
                                    'text' => 'Potencias'
                                ],
                                'scales' => [
                                    'xAxes' => [
                                        [
                                            'ticks' => [
                                                'fontSize' => 8
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            'data' => [
                                'labels' => $datos['fechas'],
                                'datasets' => [
                                    [
                                        'label' => "Activa FaseA (W)",
                                        'backgroundColor' => "rgba(247, 208, 68,0.2)",
                                        'borderColor' => "rgba(247, 208, 68,1)",
                                        'pointBackgroundColor' => "rgba(247, 208, 68,1)",
                                        'pointBorderColor' => "#fff",
                                        'pointHoverBackgroundColor' => "#fff",
                                        'pointHoverBorderColor' => "rgba(247, 208, 68,1)",
                                        'data' => $datos[2]['afa'],
                                        'fill' => false
                                    ],
                                    [
                                        'label' => "Activa FaseB (W)",
                                        'backgroundColor' => "rgba(17, 17, 17,0.2)",
                                        'borderColor' => "rgba(17, 17, 17,1)",
                                        'pointBackgroundColor' => "rgba(17, 17, 17,1)",
                                        'pointBorderColor' => "#fff",
                                        'pointHoverBackgroundColor' => "#fff",
                                        'pointHoverBorderColor' => "rgba(17, 17, 17,1)",
                                        'data' => $datos[2]['afb'],
                                        'fill' => false
                                    ],
                                    [
                                        'label' => "Activa FaseC (W)",
                                        'backgroundColor' => "rgb(57, 59, 121,0.2)",
                                        'borderColor' => "rgb(57, 59, 121)",
                                        'pointBackgroundColor' => "rgb(57, 59, 121)",
                                        'pointBorderColor' => "#fff",
                                        'pointHoverBackgroundColor' => "#fff",
                                        'pointHoverBorderColor' => "rgb(57, 59, 121)",
                                        'data' => $datos[2]['afc'],
                                        'fill' => false
                                    ],
                                    [
                                        'label' => "Activa Total (W)",
                                        'backgroundColor' => "rgb(204, 12, 12,0.2)",
                                        'borderColor' => "rgb(204, 12, 12)",
                                        'pointBackgroundColor' => "rgb(204, 12, 12)",
                                        'pointBorderColor' => "#fff",
                                        'pointHoverBackgroundColor' => "#fff",
                                        'pointHoverBorderColor' => "rgb(204, 12, 12)",
                                        'data' => $datos[2]['aitotal'],
                                        'fill' => false
                                    ],
                                    [
                                        'label' => "Reactiva Total (VAr)",
                                        'backgroundColor' => "rgb(0, 117, 0,0.2)",
                                        'borderColor' => "rgb(0, 117, 0)",
                                        'pointBackgroundColor' => "rgb(0, 117, 0)",
                                        'pointBorderColor' => "#fff",
                                        'pointHoverBackgroundColor' => "#fff",
                                        'pointHoverBorderColor' => "rgb(0, 117, 0)",
                                        'data' => $datos[2]['ritotal'],
                                        'fill' => false
                                    ]
                                ]
                            ]
                        ]);
                        ?>
                    </div>
                <?php } else { ?>
                    <div class="form-group col-lg-12">
                        <div class="alert alert-danger" role="alert">
                            Sin datos!!!
                        </div>
                    </div>
                <?php }
            } else { if (count($datos) > 0) { ?> 

                <?= ChartJs::widget([
                    'type' => 'bar',
                    'options' => [
                        'height' => 150,
                        'width' => 400
                    ],
                    'clientOptions' => [
                        'title' => [
                            'display' => true,
                            'text' => 'Energias'
                        ],
                        'scales' => [
                            'xAxes' => [
                                [
                                    'ticks' => [
                                        'fontSize' => 8
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'data' => [
                        'labels' => $datos['fechas'],
                        'datasets' => [
                            [
                                'label' => "Activa (kWh)",
                                'backgroundColor' => "rgb(57, 59, 121)",
                                'data' => $datos['datos_activa']
                            ],
                            [
                                'label' => "Reactiva kVAr/h",
                                'backgroundColor' => "rgb(0, 117, 0)",
                                'data' => $datos['datos_reactiva']
                            ]

                        ]
                    ]
                ]);

                ?>

            <?php } else {  ?>
                <div class="form-group col-lg-12">
                        <div class="alert alert-danger" role="alert">
                            Sin datos!!!
                        </div>
                    </div>
            <?php  } } ?>
        </div>
    </div>
</div>