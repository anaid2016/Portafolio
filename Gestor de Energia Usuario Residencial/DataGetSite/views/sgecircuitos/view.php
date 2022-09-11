<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SgeCircuitos */

$this->title = $model->circuitos_id;
$this->params['breadcrumbs'][] = ['label' => 'Sge Circuitos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sge-circuitos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'circuitos_id' => $model->circuitos_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'circuitos_id' => $model->circuitos_id], [
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
            'circuitos_id',
            'alias',
            'fecha_creado',
            'fecha_modificador',
            'estado_id',
            'proyecto_id',
        ],
    ]) ?>

</div>
