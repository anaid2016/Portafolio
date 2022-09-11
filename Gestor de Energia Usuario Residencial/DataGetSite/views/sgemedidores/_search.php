<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SgeMedidoresSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sge-medidores-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'medidor_id') ?>

    <?= $form->field($model, 'circuito_id') ?>

    <?= $form->field($model, 'estado_id') ?>

    <?= $form->field($model, 'modbusposition') ?>

    <?= $form->field($model, 'serial') ?>

    <?php // echo $form->field($model, 'fecha_creado') ?>

    <?php // echo $form->field($model, 'fecha_modificado') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
