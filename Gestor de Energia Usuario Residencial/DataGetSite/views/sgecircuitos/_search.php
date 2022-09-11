<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SgeCircuitosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sge-circuitos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'circuitos_id') ?>

    <?= $form->field($model, 'alias') ?>

    <?= $form->field($model, 'fecha_creado') ?>

    <?= $form->field($model, 'fecha_modificador') ?>

    <?= $form->field($model, 'estado_id') ?>

    <?php // echo $form->field($model, 'proyecto_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
