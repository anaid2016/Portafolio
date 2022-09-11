<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SgePerfiles */

$this->title = $model->perfil_id;
$this->params['breadcrumbs'][] = ['label' => 'Sge Perfiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sge-perfiles-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'perfil_id' => $model->perfil_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'perfil_id' => $model->perfil_id], [
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
            'perfil_id',
            'nombre_perfil',
        ],
    ]) ?>

</div>
