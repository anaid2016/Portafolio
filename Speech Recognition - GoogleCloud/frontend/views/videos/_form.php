<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Videos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="videos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'alias_video')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text_video')->textInput() ?>

    <?= $form->field($model, 'scriptvideo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dateload')->textInput() ?>

    <?= $form->field($model, 'sessions_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
