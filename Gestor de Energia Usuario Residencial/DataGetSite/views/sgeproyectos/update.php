<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SgeProyectos */

$this->title = 'Proyectos: ' . $model->proyecto_id;
$this->params['breadcrumbs'][] = ['label' => 'Proyectos', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Actualizar - '.$model->proyecto_id;
?>
<div class="sge-proyectos-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
