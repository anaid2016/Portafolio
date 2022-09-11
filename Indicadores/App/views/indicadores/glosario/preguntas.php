<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Alert;
use yii\jui\DatePicker;
use yii\bootstrap4\Accordion;

/* @var $this yii\web\View */
/* @var $model app\models\gisindicadores\IndicadorParametro */

$this->title = $model->cod_indi_param;
//$this->params['breadcrumbs'][] = ['label' => 'Indicador Parametros', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Preguntas Frecuentes';
?>

<section class="section-header bg-preguntas">
  <div class="container">
          <div class="canton-main py-2">
                  <div class="col-12 pt-1 align-items-center">
                          <h2 class="text-center">PREGUNTAS FRECUENTES</h2>


          </div>
  </div>
	</div>
</section>
	
	<section class="box-preguntas">
	<div class="container">
		
		<div class="indicador-parametro-view">


	
	<!--VALIDACION DE GUARDADO DE LOS DATOS---->

	<?php echo Accordion::widget([
    'items' => [
        // equivalent to the above
        [
            'label' => '¿PREGUNTA 1?',
            'content' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit, commodo tristique tortor id quisque lobortis facilisi feugiat, leo tempor venenatis dapibus odio phasellus.',
        ],
        // another group item
        [
 'label' => '¿PREGUNTA 2?',
            'content' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit, commodo tristique tortor id quisque lobortis facilisi feugiat, leo tempor venenatis dapibus odio phasellus.',
        ],
        // if you want to swap out .card-block with .list-group, you may use the following
        [
 'label' => '¿PREGUNTA 3?',
            'content' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit, commodo tristique tortor id quisque lobortis facilisi feugiat, leo tempor venenatis dapibus odio phasellus.',
        ],
                   [
 'label' => '¿PREGUNTA 4?',
            'content' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit, commodo tristique tortor id quisque lobortis facilisi feugiat, leo tempor venenatis dapibus odio phasellus.',
        ],
                   [
 'label' => '¿PREGUNTA 5?',
            'content' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit, commodo tristique tortor id quisque lobortis facilisi feugiat, leo tempor venenatis dapibus odio phasellus.',
        ],
           
 
    ]
]); ?>
   
</div>
		
	</div>

</section>
	
   

