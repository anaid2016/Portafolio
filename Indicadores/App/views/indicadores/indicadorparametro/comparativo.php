<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\gisindicadores\IndicadorParametroSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comparar resultados de indicadores';
$this->params['data'] = $buscador;  
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="indicador-parametro-index">
	<section class="section-header bg-comparativo">
                    <div class="container">
                            <div class="canton-main py-3">
                                    <div class="col-12 pt-1 align-items-center">
                                            <h2 class="text-center"><?= Html::encode($this->title) ?></h2>
                                           
                                    </div>
                            </div>
                    </div>
     </section>
	
    <div class="container">
        
        <div class="row">
            <div class="col-12">
                
                <div class="row">
                    <?= '<label class="control-label">Indicador</label>'; ?>
                    <?= Select2::widget([
                        'name' => 'state_10',
                        'data' => $data_indi,
                        'id'=>'indicador',
                        'options' => [
                            'placeholder' => 'Seleccione Indicador ...',
                        ],
                        'pluginEvents' => [
                            "select2:select" => "function(params) { genGrafica(params.params.data.id,params.params.data.text) }",
                        ]
                    ]); ?>
                </div>    
                
                <div class="row">
                    <?= '<label class="control-label">Cantones-Prestador</label>'; ?>
                    <?= Select2::widget([
                        'name' => 'state_10',
                        'data' => $data_pres,
                        'showToggleAll' => false,
                        'options' => [
                            'placeholder' => 'Seleccione los Cantones ...',
                            'multiple' => true,
                            
                        ],
                        'pluginOptions' => [
							'allowClear' => true,
                            'tags' => true,
                            'maximumInputLength' => 3,
                        ],
                       'pluginEvents' => [
                            "select2:select" => "function(params) { addGrafica(params.params.data.id,params.params.data.text,document.getElementById('indicador').value) }",
                            "select2:unselect" => "function(params) { delDataset(params.params.data.text)}"
                         ]
                    ]); ?>
                </div>
            </div>

            <div class="col-12">
                <canvas id="chartcompare" width="400" height="150"></canvas>
            </div>
            
            <!-- AQUI ES EL MENSAJE CUANDO NO HAY RESULTADOS, SI SE QUIEREN PONER ESTILOS SOLO ES MODIFICAR EL CLASS, NO MODIFICAR EL ID -->
            <div class="col-12" id="mensaje">
                
            </div>
        </div>
       
    </div>
</div>
<?php
$_url = Yii::$app->getUrlManager()->createUrl('indicadores/indicadorparametro/getdata');
$_url2 = Yii::$app->getUrlManager()->createUrl('indicadores/indicadorparametro/getlabels');
$script = <<< JS
        
        var labelsg;
        var dataGrafica;
        var config;
        var allcantones;
           
        function addGrafica(canton,nom_canton,indicador){
        
            console.log("se lleva a url :"+canton);
            var page='$_url';
            $.ajax({
                url: page,
                type: "GET",
                data: {
                          indicador: indicador,
                          canton:canton
                      },
                 success: function (response) {
                    dataGrafica = JSON.parse(response);
                    setMensaje = true;
                    console.log("que llega en respuesta",dataGrafica);
                    addDataset(dataGrafica,canton,nom_canton);

                    jQuery.each(dataGrafica, function(i, val) {
                        if(dataGrafica[i] !== null){
                            setMensaje = false;
                        }
                    });
                   
                    if(setMensaje == true){
       
                       if(allcantones == undefined){
                            allcantones = nom_canton;
                       }else{
                            allcantones = allcantones+", "+nom_canton;
                       }
        
                       
                       $('#mensaje').html(""+allcantones+" no tiene resultados para el indicador seleccionado");     
                    }   
        
                 }
             });
        }
        
        
        function addDataset(datos,canton,nom_canton){
            var newDataset = {
                    label: nom_canton,
                    borderColor: random_rgba(),
                    data: [],
                    fill: false
            };
        
        
            jQuery.each(dataGrafica, function(i, val) {
                newDataset.data.push(dataGrafica[i]);
               // console.log("que llega en datagrafica [i]"+dataGrafica[i]);
            });
        
            config.data.datasets.push(newDataset);
            window.myLine.update();
        
            //Deshabilitando tipo de indicador a relacionar ==============================================
            document.getElementById("indicador").disabled = true;
        }
        
        
        function delDataset(catonnombre){
        
            jQuery.each(config.data.datasets, function(u, val2) {
                //console.log("que es esto ",config.data.datasets[u]);
                if(config.data.datasets[u] !== undefined && config.data.datasets[u].label === catonnombre){
                    config.data.datasets.splice(u, 1);
                    
                    allcantones= allcantones.replace(catonnombre,'');
                    allcantones= allcantones.replace(',,',',');
                    allcantones= allcantones.replace(', ',' ');
        
                    $('#mensaje').html(""+allcantones+" no tiene resultados para el indicador seleccionado"); 
                    window.myLine.update();
                }
              
            });
        
        
            //Habilitando tipo de de indicador a relacionar ===============================================
            if(config.data.datasets.length === 0){
                document.getElementById("indicador").disabled = false;
            }
        }

        
        //Generando Colores Random ====================================================================
        function random_rgba() {
           var o = Math.round, s = 255;
           return 'rgba(' + o(genR()*s) + ',' + o(genR()*s) + ',' + o(genR()*s) + ',' + genR().toFixed(1) + ')';
        }
        
        function genR(){
            return Math.random() * (0.7) + 0.3;
        }
        
        //Generando Grafica ============================================================================
        function genGrafica(codindicador,nomindicador){
        
            //Trae labels segun el codindicador ====================================================
            var page='$_url2';
            $.ajax({
                url: page,
                type: "GET",
                data: {
                          indicador: codindicador
                      },
                 success: function (response) {
        
                    labelsg = JSON.parse(response);
                    var ctx2 = document.getElementById('chartcompare');
                    config = {
                        type: 'line',
                        data: {
                            labels: labelsg,
                            datasets: []
                        },
                        options: {
                            title:{
                                display:true,
                                text:nomindicador,
                            },
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                      
                                    }
                                }]
                            }
                        }
                    }; 
                    window.myLine = new Chart(ctx2, config);
        
                 }
             });
        
           
        }
        
//        window.onload = function() {
//           
//	};
JS;
$this->registerJs($script);
?>

<script>
   var cantonesBusc = <?php echo json_encode($buscador) ?>; 
</script>    