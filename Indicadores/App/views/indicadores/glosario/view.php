<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Alert;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\gisindicadores\IndicadorParametro */

$this->title = $model->cod_indi_param;
//$this->params['breadcrumbs'][] = ['label' => 'Indicador Parametros', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Preguntas Frecuentes';
?>
<div class="indicador-parametro-view">


	<!--VALIDACION DE GUARDADO DE LOS DATOS---->

	<?php if  (Yii::$app->session->getFlash('FormSubmitted')=='2'):

		echo Alert::widget([
			'options' => [
				'class' => 'alert-info',
			],
			'body' =>'Guardado con Exito',
		]);
		elseif (Yii::$app->session->getFlash('FormSubmitted')=='1'):
		
		echo Alert::widget([
			'options' => [
				'class' => 'alert-info',
			],
			'body' =>'Modificado con Exito',
		]);
		
		
	endif; ?>
  &nbsp;&nbsp;&nbsp;&nbsp;      <div>
		<table id="w0" class="table table-striped table-bordered detail-view"><tr><th>Definición</th><th>Descripción</th></tr>
                <tr><td>DEFINICI&Oacute;N 1&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Lorem ipsum dolor sit amet consectetur adipiscing elit, commodo tristique tortor id quisque lobortis facilisi feugiat, leo tempor venenatis dapibus odio phasellus.</td></tr>
                <tr><td>DEFINICI&Oacute;N 2&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Lorem ipsum dolor sit amet consectetur adipiscing elit, commodo tristique tortor id quisque lobortis facilisi feugiat, leo tempor venenatis dapibus odio phasellus.</td></tr>
                <tr><td>DEFINICI&Oacute;N 3&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Lorem ipsum dolor sit amet consectetur adipiscing elit, commodo tristique tortor id quisque lobortis facilisi feugiat, leo tempor venenatis dapibus odio phasellus.</td></tr>
                <tr><td>DEFINICI&Oacute;N 4&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Lorem ipsum dolor sit amet consectetur adipiscing elit, commodo tristique tortor id quisque lobortis facilisi feugiat, leo tempor venenatis dapibus odio phasellus.</td></tr>
                <tr><td>DEFINICI&Oacute;N 5&nbsp;&nbsp;&nbsp;&nbsp;</td><td>Lorem ipsum dolor sit amet consectetur adipiscing elit, commodo tristique tortor id quisque lobortis facilisi feugiat, leo tempor venenatis dapibus odio phasellus.</td></tr>
                </table>
   
</div>   
</div>
