<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SgeConcentradoresSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sge-concentradores-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'concentrador_id') ?>

    <?= $form->field($model, 'alias_concentrador') ?>

    <?= $form->field($model, 'serial_concentrador') ?>

    <?= $form->field($model, 'proyecto_id') ?>

    <?= $form->field($model, 'ip') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
