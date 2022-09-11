<?php

use yii\helpers\Html;
use app\assets\SgemedidoresupdateAsset;

SgemedidoresupdateAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\SgeMedidores */

$this->title = 'Medidores: ' . $model->medidor_id;
$this->params['breadcrumbs'][] = ['label' => 'Medidores', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Actualizar - '.$model->medidor_id;
?>
<div class="sge-medidores-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
        'proyectos' => $proyectos,

    ]) ?>

</div>
