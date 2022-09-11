<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SgeLecturas */

$this->title = 'Create Sge Lecturas';
$this->params['breadcrumbs'][] = ['label' => 'Sge Lecturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sge-lecturas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
