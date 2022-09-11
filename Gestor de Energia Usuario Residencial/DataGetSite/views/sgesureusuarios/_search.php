<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SgeSureusuariosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sge-sureusuarios-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'usuario_id') ?>

    <?= $form->field($model, 'nombre_usuario') ?>

    <?= $form->field($model, 'correo_electronico') ?>

    <?= $form->field($model, 'serwmpskey') ?>

    <?= $form->field($model, 'setwmpskey_hash') ?>

    <?php // echo $form->field($model, 'setauthkey') ?>

    <?php // echo $form->field($model, 'setps_reset_token') ?>

    <?php // echo $form->field($model, 'hab_us_token_forzada') ?>

    <?php // echo $form->field($model, 'estado_id') ?>

    <?php // echo $form->field($model, 'medidor_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
