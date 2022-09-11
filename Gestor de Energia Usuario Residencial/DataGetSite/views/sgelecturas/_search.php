<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SgeLecturasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sge-lecturas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'registro_lectura_id') ?>

    <?= $form->field($model, 'fecha_hora_registro') ?>

    <?= $form->field($model, 'medidor_id') ?>

    <?= $form->field($model, 'tensionfaseA') ?>

    <?= $form->field($model, 'tensionfaseB') ?>

    <?php // echo $form->field($model, 'tensionfaseC') ?>

    <?php // echo $form->field($model, 'corrientefaseA') ?>

    <?php // echo $form->field($model, 'corrientefaseB') ?>

    <?php // echo $form->field($model, 'corrientefaseC') ?>

    <?php // echo $form->field($model, 'activainsfaseA') ?>

    <?php // echo $form->field($model, 'activainsfaseB') ?>

    <?php // echo $form->field($model, 'activainsfaseC') ?>

    <?php // echo $form->field($model, 'activainstotal') ?>

    <?php // echo $form->field($model, 'reactivainstotal') ?>

    <?php // echo $form->field($model, 'estado_rele') ?>

    <?php // echo $form->field($model, 'energia_activa') ?>

    <?php // echo $form->field($model, 'energia_reactiva') ?>

    <?php // echo $form->field($model, 'fpfaseA') ?>

    <?php // echo $form->field($model, 'fpfaseB') ?>

    <?php // echo $form->field($model, 'fpfaseC') ?>

    <?php // echo $form->field($model, 'frecuencia') ?>

    <?php // echo $form->field($model, 'fecha_hora_ingreso') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
