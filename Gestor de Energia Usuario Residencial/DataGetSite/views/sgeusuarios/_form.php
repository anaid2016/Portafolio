<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\CgmUsuario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cgm-usuario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre_usuario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'correo_electronico')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'serwmpskey')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'perfil_id')->dropDownList(
            ArrayHelper::map($perfiles,'perfil_id','nombre_perfil'),
            ['prompt'=>'Seleccione Perfil.',
            'title'=>'Perfil de Usuario.']); ?>
    
   
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancelar',['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
