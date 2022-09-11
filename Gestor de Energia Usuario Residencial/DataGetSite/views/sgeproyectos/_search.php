<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SgeProyectosSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="sge-proyectos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'proyecto_id') ?>

    <?= $form->field($model, 'nombre_proyecto') ?>

    <?= $form->field($model, 'fecha_creado') ?>

    <?= $form->field($model, 'fecha_modificado') ?>

    <?= $form->field($model, 'usuario_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
