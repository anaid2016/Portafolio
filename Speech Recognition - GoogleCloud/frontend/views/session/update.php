<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Sessions */

$this->title = 'Update Sessions: ' . $model->id_session;
$this->params['breadcrumbs'][] = ['label' => 'Sessions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_session, 'url' => ['view', 'id_session' => $model->id_session]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sessions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
