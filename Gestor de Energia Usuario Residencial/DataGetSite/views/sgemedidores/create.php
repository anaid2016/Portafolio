<?php

use yii\helpers\Html;
use app\assets\SgemedidorescreateAsset;

SgemedidorescreateAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\models\SgeMedidores */

$this->title = 'Crear Medidor';
$this->params['breadcrumbs'][] = ['label' => 'Medidores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sge-medidores-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
        'proyectos' => $proyectos
    ]) ?>

</div>
