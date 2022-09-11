<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SgeSureusuarios */

$this->title = 'Sure-usuarios';
$this->params['breadcrumbs'][] = ['label' => 'Sure-usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Crear';
?>
<div class="sge-sureusuarios-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
        'medidores' => $medidores
    ]) ?>

</div>
