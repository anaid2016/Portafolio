<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SgeUsuariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sge Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sge-usuarios-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Sge Usuarios', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'class' => LinkPager::class
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'usuario_id',
            'nombre_usuario',
            'correo_electronico',
            'serwmpskey',
            'setwmpskey_hash',
            //'setauthkey',
            //'setps_reset_token',
            //'perfil_id',
            //'hab_us_token_forzada',
            //'estado_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'usuario_id' => $model->usuario_id]);
                 }
            ],
        ],
    ]); ?>


</div>
