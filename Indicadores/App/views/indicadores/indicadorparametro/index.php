<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\gisindicadores\IndicadorParametroSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Indicador Parametros';
$this->params['data'] = $buscador;  
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="indicador-parametro-index">
	<section class="section-header blueBg text-center">
                    <div class="container">
                            <div class="canton-main py-3">
                                    <div class="col-12 pt-1 align-items-center">
                                            <h2><?= Html::encode($this->title) ?></h2>
                                           
                                    </div>
                            </div>
                    </div>
     </section>
	
	<div class="container">

    

    <p>
        <?= Html::a('Crear Indicador Parametro', ['create'], ['class' => 'btn btn-primary btn-lg']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'cod_indi_param',
            'nombre',
            'sigla',
            'descripcion',
            'formula',
            //'tipo',
            //'cod_area',
            //'unidad',
            //'descr_relacion_param',
            //'estado',
            //'fecha_desde',
            //'fecha_hasta',
            //'tipo_dato',
            //'relevancia_indicador',
            //'tipo_calc_indicador',
            //'valor_cumplimiento',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
</div>
