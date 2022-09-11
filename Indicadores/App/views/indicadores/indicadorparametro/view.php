<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\gisindicadores\IndicadorParametro */

$this->title = $model->cod_indi_param;
$this->params['breadcrumbs'][] = ['label' => 'Ficha Metodológica', 'url' => ['index']];
$this->params['data'] = $buscador;    
\yii\web\YiiAsset::register($this);
?>
<div class="indicador-parametro-view">
	<section class="section-header blueBg text-center">
                    <div class="container">
                            <div class="canton-main py-3">
                                    <div class="col-12 pt-1 align-items-center">
                                            <p class="h5 text-center">Ficha Metodol&oacute;gica</p>
                                            <!--<div class="titulo">Nombre del Indicador</div>-->
												<span class="h2"><?= $model->sigla; ?></span><br/>
												<span class="h4"><?= $model->nombre; ?></span>
                                    </div>
                            </div>
                    </div>
     </section>
    <section class="interior">
        <div class="container">
			<!--DESCRIPCION DEL INDICADOR-->
			<div class="col-md-8">
				<div class="card">
					<div class="card-header metodologica">
						<div class="desc-indicador-ficha">
							<div class="titulo">Definición</div>
							<?= $model->descripcion; ?>
						</div>
					
					</div>
					<div class="card-body">
						
						<!--FORMULA Y DEFINICION-->
						<div class="formula-calc">
							<div class="titulo">Fórmula de cálculo</div>
							<div id="formula" class="katex"></div>
						</div>
						<div class="formula-variables">
							<div class="titulo">Definición de las variables relacionadas</div>
							<div class="">
								 <?php
                                                                    foreach($model['descript_formula'] as $linea){
                                                                        if(!empty($linea['sigla'])){
                                                                    ?>
                                                                    <div class="variables-definicion">
                                                                        <div class="var-txt1"><?= $linea['sigla'] ?> =</div>
                                                                        <div class="var-txt1"><?= $linea['nombre'] ?></div>    
                                                                    </div>
                                                                    <?php
                                                                        }else{
                                                                    ?>
                                                                    <div class="variables-definicion">
                                                                        <div class="var-txt1">No existen definiciones registradas.</div>
                                                                    </div>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
							
							</div>
								
						</div>
						
						<div class="wrap-text">
							<div class="titulo">Limitaciones técnicas</div>
							<div class="txt-msg">No se tiene información</div>
						</div>
						<div class="wrap-text">
							<div class="titulo">Unidad de medida o expresión del indicador</div>
							<div class="txt-msg"><span class="unit">%</span></div>
						</div>
						
						
						
					</div>
				</div>
			
			</div>
			<!--OTROS INDICADORES-->
			<div class="col-md-4">
				<div class="card">
					<div class="card-header">
					<h4>Otros indicadores de interés</h4>
					</div>
					<div class="card-body">
						<div class="indicadoresList">
                                                    
                                                    <?php
                                                        foreach ($indicadores as $indicador){
                                                            
                                                            $url2 = Url::toRoute(['indicadores/indicadorparametro/view','id' => $indicador['id_indicador'] ],true);
                                                    ?>
                                                        <div class="wrapIndicador-list">
								<a href="<?= $url2; ?>">
									<div class="sigla"><?= $indicador['sigla']; ?></div>
									<div class="nombreIndicador"><?= $indicador['nombre']; ?></div>
								</a>
								
							</div>
                                                    <?php
                                                        }
                                                    ?>
						
						</div>
					
					
					</div>
				
				</div>
			
			</div>
			
            
        </div>
    </section>
    
</div>
<script>
var cantonesBusc = <?php echo json_encode($buscador) ?>; 
</script>

<!--------------------------------------PASANDO FORMULA --------------------!>
<?php
if(!empty($model->formula)){
$this->registerJs('
    katex.render("'.$model->formula.'", formula);
  ');
}
?>