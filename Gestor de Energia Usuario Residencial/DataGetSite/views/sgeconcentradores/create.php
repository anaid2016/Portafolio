<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SgeConcentradores */

$this->title = 'Create Sge Concentradores';
$this->params['breadcrumbs'][] = ['label' => 'Sge Concentradores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sge-concentradores-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
