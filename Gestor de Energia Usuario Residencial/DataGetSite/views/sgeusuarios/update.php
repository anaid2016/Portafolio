<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SgeUsuarios */

$this->title = 'Update Sge Usuarios: ' . $model->usuario_id;
$this->params['breadcrumbs'][] = ['label' => 'Sge Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->usuario_id, 'url' => ['view', 'usuario_id' => $model->usuario_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sge-usuarios-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
