<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SgeProyectos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card border-light shadow">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card-body">

        <!-- <?= $form->field($model, 'proyecto_id')->textInput() ?> -->

        <?= $form->field($model, 'nombre_proyecto')->textInput(['maxlength' => true]) ?>
        
    </div>
    <div class="card-footer">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>