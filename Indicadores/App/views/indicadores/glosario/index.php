<?php

use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\jui\Tabs;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\gisindicadores\GlosarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Glosario';
$this->params['breadcrumbs'][] = $this->title;
?>

 <section class="section-header bg-glosario">
                    <div class="container">
                            <div class="canton-main py-2">
                                    <div class="col-12 pt-1 align-items-center">
                                            <h2 class="text-center"><?= Html::encode($this->title) ?></h2>
                                           
											
                            </div>
                    </div>
                </section>
	 <section class="glosarioContent">
		 <div class="container">
		 	<div class="glosario-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    
    function wrapPjax($grid, $id) {
    ob_start();

    Pjax::begin(['timeout' => 10000,'id' => $id]);
    echo $grid;
    Pjax::end();
    
    return ob_get_clean();
    }
    $tab1 = wrapPjax(GridView::widget([
         'id' => 'Indicadores',
        'dataProvider' => $dataIndicadores,
       // 'filterModel' => $searchIndicadores,
		'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
 
		    'sigla',

            'nombre',
            'descripcion',
            [
                'label'=>Html::encode('Ficha Metodológica'),
                'format'=>'html',
                'contentOptions' => ['style' => 'vertical-align : middle; text-align:center;'],
                'value' => function($model){
                    return Html::a(Html::img('img/ic_ficha1.png', ['alt'=>'Ficha Metodológica',]), [ 'indicadores/indicadorparametro/view', 'id' =>$model->cod_indi_param]);
                    }
               ],
            ],
        ]),'Indi');
    
    
    $tab2 = wrapPjax(GridView::widget([
         'id' => 'Parametros',
        'dataProvider' => $dataParametros,
       // 'filterModel' => $searchParametros,
		'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

		    'sigla',

            'nombre',
            'descripcion',
            'unidad',
            ],
        ]),'Para');
		
	$tab3 = wrapPjax(GridView::widget([
         'id' => 'Glosario',
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
		'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nombre',
            'descripcion',
            ],
        ]),'Glos');
    
    ?>

	<div class="glosario-index-tabs">
    <?= Tabs::widget([
		'items'=>[
		[
			'label'=> Html::icon('approve').'Indicadores',
			'content' => $tab1,
			'options' => ['class' => 'tab-indicadores'],
			
		],
		[
			'label'=> Html::icon('approve'). 'Par&aacute;metros',
			'content' => $tab2,
			'options' => ['class' => 'tab-parametros'],
			
		],
		[
			'label'=> Html::icon('approve'). Html::encode('General'),
			'content' => $tab3,
			'options' => ['class' => 'tab-general'],
			
		],],
		
		    'options' => ['tag' => 'div'],
			'headerOptions' => ['class' => 'glosario-tabs'],
			'encodeLabels' => false,
	]);
    
 ?>
	</div>

</div>
		 </div>
	 
	 </section>

