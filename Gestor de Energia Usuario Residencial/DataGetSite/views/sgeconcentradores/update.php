<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SgeConcentradores */

$this->title = 'Update Sge Concentradores: ' . $model->concentrador_id;
$this->params['breadcrumbs'][] = ['label' => 'Sge Concentradores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->concentrador_id, 'url' => ['view', 'concentrador_id' => $model->concentrador_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sge-concentradores-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
