<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SgeCircuitos */

$this->title = 'Update Sge Circuitos: ' . $model->circuitos_id;
$this->params['breadcrumbs'][] = ['label' => 'Sge Circuitos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->circuitos_id, 'url' => ['view', 'circuitos_id' => $model->circuitos_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sge-circuitos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
