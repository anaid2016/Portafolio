<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SgeMedidores */

$this->title = $model->medidor_id;
$this->params['breadcrumbs'][] = ['label' => 'Sge Medidores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sge-medidores-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'medidor_id' => $model->medidor_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'medidor_id' => $model->medidor_id], [
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
            'medidor_id',
            'circuito_id',
            'estado_id',
            'modbusposition',
            'serial',
            'fecha_creado',
            'fecha_modificado',
        ],
    ]) ?>

</div>
