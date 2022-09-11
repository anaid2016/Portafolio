<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SgeProyectos */

$this->title = $model->proyecto_id;
$this->params['breadcrumbs'][] = ['label' => 'Sge Proyectos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sge-proyectos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'proyecto_id' => $model->proyecto_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'proyecto_id' => $model->proyecto_id], [
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
            'proyecto_id',
            'nombre_proyecto',
            'fecha_creado',
            'fecha_modificado',
            'usuario_id',
        ],
    ]) ?>

</div>
