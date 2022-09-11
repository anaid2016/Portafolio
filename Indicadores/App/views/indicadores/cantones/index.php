<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\indicadores\CantonesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cantones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cantones-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Cantones', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'cod_canton',
            'cod_provincia',
            'nombre_canton',
            'demarcaciones',
            'id_demarcacion',
            //'latcabecera',
            //'longcabecera',
            //'nombre_cabecera',
            //'dpa_canton',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
