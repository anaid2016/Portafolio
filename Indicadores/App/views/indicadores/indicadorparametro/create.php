<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\gisindicadores\IndicadorParametro */

$this->title = 'Create Indicador Parametro';
$this->params['breadcrumbs'][] = ['label' => 'Indicador Parametros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="indicador-parametro-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
