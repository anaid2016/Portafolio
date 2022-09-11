<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SgeProyectos */

$this->title = 'Crear Proyectos';
$this->params['breadcrumbs'][] = ['label' => 'Proyectos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sge-proyectos-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
