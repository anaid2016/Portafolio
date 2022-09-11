<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SgeLecturas */

$this->title = $model->registro_lectura_id;
$this->params['breadcrumbs'][] = ['label' => 'Sge Lecturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sge-lecturas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'registro_lectura_id' => $model->registro_lectura_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'registro_lectura_id' => $model->registro_lectura_id], [
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
            'registro_lectura_id',
            'fecha_hora_registro',
            'medidor_id',
            'tensionfaseA',
            'tensionfaseB',
            'tensionfaseC',
            'corrientefaseA',
            'corrientefaseB',
            'corrientefaseC',
            'activainsfaseA',
            'activainsfaseB',
            'activainsfaseC',
            'activainstotal',
            'reactivainstotal',
            'estado_rele',
            'energia_activa',
            'energia_reactiva',
            'fpfaseA',
            'fpfaseB',
            'fpfaseC',
            'frecuencia',
            'fecha_hora_ingreso',
        ],
    ]) ?>

</div>
