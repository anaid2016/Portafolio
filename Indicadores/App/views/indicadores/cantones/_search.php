<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\indicadores\CantonesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cantones-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'cod_canton') ?>

    <?= $form->field($model, 'cod_provincia') ?>

    <?= $form->field($model, 'nombre_canton') ?>

    <?= $form->field($model, 'demarcaciones') ?>

    <?= $form->field($model, 'id_demarcacion') ?>

    <?php // echo $form->field($model, 'latcabecera') ?>

    <?php // echo $form->field($model, 'longcabecera') ?>

    <?php // echo $form->field($model, 'nombre_cabecera') ?>

    <?php // echo $form->field($model, 'dpa_canton') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
