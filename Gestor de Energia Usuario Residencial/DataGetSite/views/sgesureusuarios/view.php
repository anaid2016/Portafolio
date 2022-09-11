<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SgeSureusuarios */

$this->title = $model->usuario_id;
$this->params['breadcrumbs'][] = ['label' => 'Sge Sureusuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sge-sureusuarios-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'usuario_id' => $model->usuario_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'usuario_id' => $model->usuario_id], [
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
            'usuario_id',
            'nombre_usuario',
            'correo_electronico',
            'serwmpskey',
            'setwmpskey_hash',
            'setauthkey',
            'setps_reset_token',
            'hab_us_token_forzada',
            'estado_id',
            'medidor_id',
        ],
    ]) ?>

</div>
