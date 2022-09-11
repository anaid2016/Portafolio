<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SgeMedidores */
/* @var $form yii\widgets\ActiveForm */

$tipos = app\models\SgeTipoMedidor::find()->all();
?>

<div class="card border-light shadow">
    <?php $form = ActiveForm::begin(); ?>

    <div class="card-body">

        <?= $form->field($model, 'proyecto_id')->dropDownList(ArrayHelper::map($proyectos, 'concentrador_id', 'alias_concentrador'), [
            'prompt' => 'Seleccione.',
            'onchange' => '$.post("index.php?r=sgemedidores/listcircuitos&id=' . '"+$(this).val(),function(data){
                                                                    $("#sgemedidores-circuito_id").html(data);
                                                    });'
        ]); ?>

        <?= $form->field($model, 'circuito_id')->dropDownList(['' => 'Seleccione Circuito']); ?>

        <?= $form->field($model, 'tipo_medidor_id')->dropDownList(ArrayHelper::map($tipos, 'tipo_medidor_id', 'alias_tipo_medidor'), ['prompt' => 'Seleccione.']); ?>

        <div id="c-01">
            <?= $form->field($model, 'corriente_1')->textInput() ?>

        </div>

        <div id="c-02">
            <?= $form->field($model, 'corriente_2')->textInput() ?>

        </div>

        <div id="c-03">
            <?= $form->field($model, 'corriente_3')->textInput() ?>

        </div>

        <?= $form->field($model, 'modbusposition')->textInput() ?>

        <?= $form->field($model, 'serial')->textInput(['maxlength' => true]) ?>

    </div>
    <div class="card-footer">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>