<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SgePerfiles */

$this->title = 'Create Sge Perfiles';
$this->params['breadcrumbs'][] = ['label' => 'Sge Perfiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sge-perfiles-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
