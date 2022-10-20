<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VideosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="videos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_videos') ?>

    <?= $form->field($model, 'alias_video') ?>

    <?= $form->field($model, 'text_video') ?>

    <?= $form->field($model, 'scriptvideo') ?>

    <?= $form->field($model, 'dateload') ?>

    <?php // echo $form->field($model, 'sessions_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
