<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use light\widgets\SweetSubmitAsset;			/* Para la confirmacion, ver archivo web/js/yiioverride*/
use yii\jui\DatePicker;					/*Libreria para el modulo de fechas*/

/* @var $this yii\web\View */
/* @var $model app\models\gisindicadores\IndicadorParametro */
/* @var $form yii\widgets\ActiveForm */


SweetSubmitAsset::register($this)
?>

<div class="indicador-parametro-form">

    <?php $form = ActiveForm::begin(['options' => [
                    'id' => 'create-form'
					]
                ]); ?>

    <?= $form->field($model, 'cod_indi_param')->textInput([
                                        'maxlength' => true,
                                        'title' => 'Indique Cod Indi Param',
                                        'data-toggle' => 'tooltip',
                                        'placeholder'=>'Indique Cod Indi Param'        
                                         ]) ?>

    <?= $form->field($model, 'nombre')->textInput([
                                        'maxlength' => true,
                                        'title' => 'Indique Nombre',
                                        'data-toggle' => 'tooltip',
                                        'placeholder'=>'Indique Nombre'        
                                         ]) ?>

    <?= $form->field($model, 'sigla')->textInput([
                                        'maxlength' => true,
                                        'title' => 'Indique Sigla',
                                        'data-toggle' => 'tooltip',
                                        'placeholder'=>'Indique Sigla'        
                                         ]) ?>

    <?= $form->field($model, 'descripcion')->textInput([
                                        'maxlength' => true,
                                        'title' => 'Indique Descripcion',
                                        'data-toggle' => 'tooltip',
                                        'placeholder'=>'Indique Descripcion'        
                                         ]) ?>

    <?= $form->field($model, 'formula')->textInput([
                                        'maxlength' => true,
                                        'title' => 'Indique Formula',
                                        'data-toggle' => 'tooltip',
                                        'placeholder'=>'Indique Formula'        
                                         ]) ?>

    <?= $form->field($model, 'tipo')->textInput([
                                        'maxlength' => true,
                                        'title' => 'Indique Tipo',
                                        'data-toggle' => 'tooltip',
                                        'placeholder'=>'Indique Tipo'        
                                         ]) ?>

    <?= $form->field($model, 'cod_area')->textInput([
                                        'maxlength' => true,
                                        'title' => 'Indique Cod Area',
                                        'data-toggle' => 'tooltip',
                                        'placeholder'=>'Indique Cod Area'        
                                         ]) ?>

    <?= $form->field($model, 'unidad')->textInput([
                                        'maxlength' => true,
                                        'title' => 'Indique Unidad',
                                        'data-toggle' => 'tooltip',
                                        'placeholder'=>'Indique Unidad'        
                                         ]) ?>

    <?= $form->field($model, 'descr_relacion_param')->textInput([
                                        'maxlength' => true,
                                        'title' => 'Indique Descr Relacion Param',
                                        'data-toggle' => 'tooltip',
                                        'placeholder'=>'Indique Descr Relacion Param'        
                                         ]) ?>

    <?= $form->field($model, 'estado')->textInput([
                                        'maxlength' => true,
                                        'title' => 'Indique Estado',
                                        'data-toggle' => 'tooltip',
                                        'placeholder'=>'Indique Estado'        
                                         ]) ?>

    <?= $form->field($model, 'fecha_desde')->
             widget(\yii\jui\DatePicker::className(),[
                'dateFormat' => 'dd/MM/yyyy',        //Formato de la fecha
                'clientOptions' => [
                    'yearRange' => '-90:+0',        //Años habilitados 90 años atras hasta el actual        
                    'changeYear' => true,            //Permitir cambio de año
                    'changeMonth' => true]            //Permitir cambio de Mes
            ]) ?>

    <?= $form->field($model, 'fecha_hasta')->
             widget(\yii\jui\DatePicker::className(),[
                'dateFormat' => 'dd/MM/yyyy',        //Formato de la fecha
                'clientOptions' => [
                    'yearRange' => '-90:+0',        //Años habilitados 90 años atras hasta el actual        
                    'changeYear' => true,            //Permitir cambio de año
                    'changeMonth' => true]            //Permitir cambio de Mes
            ]) ?>

    <?= $form->field($model, 'tipo_dato')->textInput([
                                        'maxlength' => true,
                                        'title' => 'Indique Tipo Dato',
                                        'data-toggle' => 'tooltip',
                                        'placeholder'=>'Indique Tipo Dato'        
                                         ]) ?>

    <?= $form->field($model, 'relevancia_indicador')->textInput([
                                        'maxlength' => true,
                                        'title' => 'Indique Relevancia Indicador',
                                        'data-toggle' => 'tooltip',
                                        'placeholder'=>'Indique Relevancia Indicador'        
                                         ]) ?>

    <?= $form->field($model, 'tipo_calc_parametro')->textInput([
                                        'maxlength' => true,
                                        'title' => 'Indique Tipo Calc Parametro',
                                        'data-toggle' => 'tooltip',
                                        'placeholder'=>'Indique Tipo Calc Parametro'        
                                         ]) ?>

    <?= $form->field($model, 'valor_cumplimiento')->textInput([
                                        'maxlength' => true,
                                        'title' => 'Indique Valor Cumplimiento',
                                        'data-toggle' => 'tooltip',
                                        'placeholder'=>'Indique Valor Cumplimiento'        
                                         ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
