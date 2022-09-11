<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SgeCircuitos */
/* @var $form yii\widgets\ActiveForm 
    <?= $form->field($model, 'proyecto_id')->dropDownList(
            ArrayHelper::map($proyectos, 'proyecto_id', 'nombre_proyecto'),
            ['prompt' => 'Seleccione.']
        ); ?>
 * 
 *  */
$vconcentradores = \app\models\SgeConcentradores::find()->all();


?>

<div class="card border-light shadow">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card-body">

        <?= $form->field($model, 'concentrador_id')->dropDownList(ArrayHelper::map($vconcentradores,'concentrador_id','alias_concentrador'),
            ['prompt' => 'Seleccione.']
        ); ?>
        
        <?= $form->field($model, 'alias')->textInput() ?>
        
        <?= $form->field($model, 'numerico')->textInput() ?>

        <?= $form->field($model, 'valorkWh')->textInput() ?>

        <?= $form->field($model, 'estrato')->textInput() ?>

        <?= $form->field($model, 'maxactivadia')->textInput() ?>

        <?= $form->field($model, 'maxreactivadia')->textInput() ?>

        <?= $form->field($model, 'estado_id')->dropDownList(
            [1=>'ACTIVO', 2 => 'INACTIVO'],
            ['prompt' => 'Seleccione.']
        ); ?>        

        <?= $form->field($model, 'imagenasociada')->dropDownList(
            ['bosques', 'colina', 'sure', 'serrania'],
            ['prompt' => 'Seleccione.']
        ); ?>
    </div>
    <div class="card-footer">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>