<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\gisindicadores\IndicadorParametro */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="indicador-parametro-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cod_indi_param')->textInput() ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sigla')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'formula')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cod_area')->textInput() ?>

    <?= $form->field($model, 'unidad')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descr_relacion_param')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fecha_desde')->textInput() ?>

    <?= $form->field($model, 'fecha_hasta')->textInput() ?>

    <?= $form->field($model, 'valor_cumplimiento')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
