<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\indicadores\Cantones */

$this->title = $model->cod_canton;
$this->params['breadcrumbs'][] = ['label' => 'Cantones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cantones-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'cod_canton' => $model->cod_canton, 'cod_provincia' => $model->cod_provincia], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'cod_canton' => $model->cod_canton, 'cod_provincia' => $model->cod_provincia], [
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
            'cod_canton',
            'cod_provincia',
            'nombre_canton',
            'demarcaciones',
            'id_demarcacion',
            'latcabecera',
            'longcabecera',
            'nombre_cabecera',
            'dpa_canton',
        ],
    ]) ?>

</div>
