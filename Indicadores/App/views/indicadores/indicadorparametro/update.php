<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\gisindicadores\IndicadorParametro */

$this->title = 'Update Indicador Parametro: ' . $model->cod_indi_param;
$this->params['breadcrumbs'][] = ['label' => 'Indicador Parametros', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cod_indi_param, 'url' => ['view', 'id' => $model->cod_indi_param]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="indicador-parametro-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
