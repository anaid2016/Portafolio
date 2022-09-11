<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\SgeSureusuarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card border-light shadow">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card-body">

        <?= $form->field($model, 'nombre_usuario')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'correo_electronico')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'serwmpskey')->textInput(['maxlength' => true, 'type' => 'password']) ?>

        <?= $form->field($model, 'estado_id')->dropDownList(
            [1 => 'ACTIVO', 2 => 'INACTIVO'],
            ['prompt' => 'Seleccione.']
        ); ?>

        <?= $form->field($model, 'medidor_id')->dropDownList(
            ArrayHelper::map($medidores, 'medidor_id', 'serial'),
            ['prompt' => 'Seleccione.']
        ); ?>

    </div>
    <div class="card-footer">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>