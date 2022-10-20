<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Videos */

$this->title = 'Update Videos: ' . $model->id_videos;
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_videos, 'url' => ['view', 'id_videos' => $model->id_videos]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="videos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
