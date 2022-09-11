<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SgePerfiles */

$this->title = 'Update Sge Perfiles: ' . $model->perfil_id;
$this->params['breadcrumbs'][] = ['label' => 'Sge Perfiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->perfil_id, 'url' => ['view', 'perfil_id' => $model->perfil_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sge-perfiles-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
