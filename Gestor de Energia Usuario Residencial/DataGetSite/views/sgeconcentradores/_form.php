<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SgeConcentradores */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sge-concentradores-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'concentrador_id')->textInput() ?>

    <?= $form->field($model, 'alias_concentrador')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'serial_concentrador')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'proyecto_id')->textInput() ?>

    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
