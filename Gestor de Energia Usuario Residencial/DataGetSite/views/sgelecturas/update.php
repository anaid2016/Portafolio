<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SgeLecturas */

$this->title = 'Update Sge Lecturas: ' . $model->registro_lectura_id;
$this->params['breadcrumbs'][] = ['label' => 'Sge Lecturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->registro_lectura_id, 'url' => ['view', 'registro_lectura_id' => $model->registro_lectura_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sge-lecturas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
