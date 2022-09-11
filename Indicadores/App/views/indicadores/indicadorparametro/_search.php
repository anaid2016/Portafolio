<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\gisindicadores\IndicadorParametroSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="indicador-parametro-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'cod_indi_param') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'sigla') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'formula') ?>

    <?php // echo $form->field($model, 'tipo') ?>

    <?php // echo $form->field($model, 'cod_area') ?>

    <?php // echo $form->field($model, 'unidad') ?>

    <?php // echo $form->field($model, 'descr_relacion_param') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'fecha_desde') ?>

    <?php // echo $form->field($model, 'fecha_hasta') ?>

    <?php // echo $form->field($model, 'tipo_dato') ?>

    <?php // echo $form->field($model, 'relevancia_indicador') ?>

    <?php // echo $form->field($model, 'tipo_calc_indicador') ?>

    <?php // echo $form->field($model, 'valor_cumplimiento') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
