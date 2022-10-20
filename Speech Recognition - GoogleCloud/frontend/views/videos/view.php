<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Videos */

$this->title = $model->id_videos;
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="videos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_videos' => $model->id_videos], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_videos' => $model->id_videos], [
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
            'id_videos',
            'alias_video',
            'text_video',
            'scriptvideo',
            'dateload',
            'sessions_id',
        ],
    ]) ?>

</div>
