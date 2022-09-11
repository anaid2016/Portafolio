<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SgeLecturas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sge-lecturas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fecha_hora_registro')->textInput() ?>

    <?= $form->field($model, 'medidor_id')->textInput() ?>

    <?= $form->field($model, 'tensionfaseA')->textInput() ?>

    <?= $form->field($model, 'tensionfaseB')->textInput() ?>

    <?= $form->field($model, 'tensionfaseC')->textInput() ?>

    <?= $form->field($model, 'corrientefaseA')->textInput() ?>

    <?= $form->field($model, 'corrientefaseB')->textInput() ?>

    <?= $form->field($model, 'corrientefaseC')->textInput() ?>

    <?= $form->field($model, 'activainsfaseA')->textInput() ?>

    <?= $form->field($model, 'activainsfaseB')->textInput() ?>

    <?= $form->field($model, 'activainsfaseC')->textInput() ?>

    <?= $form->field($model, 'activainstotal')->textInput() ?>

    <?= $form->field($model, 'reactivainstotal')->textInput() ?>

    <?= $form->field($model, 'estado_rele')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'energia_activa')->textInput() ?>

    <?= $form->field($model, 'energia_reactiva')->textInput() ?>

    <?= $form->field($model, 'fpfaseA')->textInput() ?>

    <?= $form->field($model, 'fpfaseB')->textInput() ?>

    <?= $form->field($model, 'fpfaseC')->textInput() ?>

    <?= $form->field($model, 'frecuencia')->textInput() ?>

    <?= $form->field($model, 'fecha_hora_ingreso')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
