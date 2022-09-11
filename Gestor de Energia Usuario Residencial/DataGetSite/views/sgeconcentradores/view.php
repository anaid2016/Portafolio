<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SgeConcentradores */

$this->title = $model->concentrador_id;
$this->params['breadcrumbs'][] = ['label' => 'Sge Concentradores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sge-concentradores-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'concentrador_id' => $model->concentrador_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'concentrador_id' => $model->concentrador_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'concentrador_id',
            'alias_concentrador',
            'serial_concentrador',
            'proyecto_id',
            'ip',
        ],
    ]) ?>

</div>
