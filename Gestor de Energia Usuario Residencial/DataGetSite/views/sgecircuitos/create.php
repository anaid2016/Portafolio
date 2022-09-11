<?php

use yii\helpers\Html;
use app\assets\SgecircuitoscreateAsset;

SgecircuitoscreateAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\models\SgeCircuitos */

$this->title = 'Crear';
$this->params['breadcrumbs'][] = ['label' => 'Circuitos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sge-circuitos-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
