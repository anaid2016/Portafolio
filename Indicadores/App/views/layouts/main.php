<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

AppAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language; ?>">
<head>
    <meta charset="<?= Yii::$app->charset; ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!--FAVICON-->
	<link rel="apple-touch-icon" sizes="57x57" href="img/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="img/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="img/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="img/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="img/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="img/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="img/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="img/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="img/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="img/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="img/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
	<link rel="manifest" href="img/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="img/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
    <!---Se agrega para cambio del header, funcionamiento del filtro cantones -->
    <link href="css/bootstrap.min.css?v1" rel="stylesheet">
    
    <script src="openlayers/v6.3.1/ol.js"></script>
    <link rel="stylesheet" href="openlayers/v6.3.1/ol.css" type="text/css">
    
    <link href="css/mapcss.css?v7.3.3" rel="stylesheet" type="text/css" />
    
    <!--Material Design iconset-->
    <link href="css/fonts/material-icons.css" rel="stylesheet">
   <!---------------------------------------------------------------------------------------------------->
    
    <!---Agregando vinculaciones de katex, para las formulas, se agrega aqui para uso general--->
     <link rel="stylesheet" href="js/katex/katex.min.css" crossorigin="anonymous">

    <!-- The loading of KaTeX is deferred to speed up page rendering -->
    <script defer src="js/katex/katex.min.js" integrity="sha384-y23I5Q6l+B6vatafAwxRu/0oK/79VlbSz7Q9aiSZUvyWYIYsd+qj+o24G5ZU2zJz" crossorigin="anonymous"></script>

    
    <!---------------------------------------------------->
    <!--<link href="https://fonts.googleapis.com/css?family=Libre+Franklin:400,600,800&display=swap" rel="stylesheet">-->
    <link href="css/icons.css" rel="stylesheet" type="text/css" />
    <link href="css/fonts/franklincss.css" rel="stylesheet" type="text/css" />
    
    <!---ad chart-->
    <script src="js/chartjs/Chart.min.js" type="text/javascript"></script>
    
    
    <?php $this->registerCsrfMetaTags(); ?>
    <title>Sistema Indicadores</title>
    <?php $this->head(); ?>
	
</head>
<body class="homepage">

<div class="wrap">

     <header>
        <div class="container">
            <div class="canton-header py-3">
                <div class="row flex-nowrap justify-content-between align-items-center">
                    <div class="col-3 pt-1">
                      <a class="text-muted" onclick="goBack()" onmouseover="" style="cursor: pointer;"><img class="img-fluid" src="img/mainLogo_siap.png"/></a>
                    </div>
                    <div class="col-4 text-center">
                       <!--<input type="text" class="form-control-boot " id="filtroCantones" placeholder="Buscar otros Cantones">-->
                        <?php
                            //set go to http://127.0.0.1/ecuador/2019/INDICADORES/version05/indicadores/web/?r=indicadores/cantones/canton&dpa_canton=2202&periodo=null

                           //   Forma de gestionar la informacion para el buscador
                           //  $data = [['value'=>'valor 1','label'=>'etiqueta 1','id'=>'1'],['value'=>'valor 2','label'=>'etiqueta 2','id'=>'2']];
                               if (!empty($this->params['data'])) {
                            ?>    
                                 <input id="filer_data" size="40" class="form-control" placeholder="Explore cantones o provincias">
                            <?php
                                }
                           //Construyendo Ruta para Glosario
                            $_ulrglosario = yii\helpers\Url::toRoute(['indicadores/glosario/index']);
							$_ulrPREGUNTAS = yii\helpers\Url::toRoute(['indicadores/glosario/preguntas']);
							$_ulrcomparativo = yii\helpers\Url::toRoute(['indicadores/indicadorparametro/comparativo']);
                        ?>
                    </div>
                    <div class="col-2 d-flex justify-content-end align-items-center">
                        <div class="btn btn-default"><img class="img-responsive" src="img/ic_head1.png"/><a href="<?= $_ulrcomparativo ?>"> Comparativos</a></div>
                    </div>
                    <div class="col-1 d-flex justify-content-end align-items-center">
                        <div class="btn btn-default"><img class="img-responsive" src="img/ic_head2.png"/><a href="<?= $_ulrglosario ?>"> Glosario</a></div>
                    </div>
                    <div class="col-2 d-flex justify-content-end align-items-center">
                        <span class="btn btn-default"><img class="img-responsive" src="img/ic_head3.png"/><a href="<?= $_ulrPREGUNTAS ?>">Preguntas Frecuentes</a></span>                              
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h4 style="text-align: center">Información</h4>
                </div>
                
                
            </div>
       </div>

    </header>

    <div class="main-container">
        <!------------------------------------------------------------------------------------------>
        <!--ACTIVA LA VENTANA MODAL PARA LOS FORMULARIOS-------------------------------------------->
        <!------------------------------------------------------------------------------------------>
        <?php
                yii\bootstrap\Modal::begin([
                    'header' => '',
                    'headerOptions' => ['id' => 'modalHeader'],
                    'id' => 'modal',
                    'size' => 'modal-lg',
                    //'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
                ]);
                echo "<div id='modalContent'></div>";
                yii\bootstrap\Modal::end();
        ?>
        <div class="container">
                <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]); ?>
                <?= Alert::widget(); ?>
        </div>
        <?= $content; ?>
                
    </div>
</div>
  <footer class="footer">
        <div class="container text-center">
            <div class="wrapFooter-content">TEST VISUALIZACION MAPA</div>
            <p><?= date('Y'); ?></p>
        </div>
</footer>


<?php

//SE AGREGA PARA EL AUTOCOMPLETE ================================================================================================================
if (!empty($this->params['data'])) {
$script = <<< JS
 
        var projects = cantonesBusc;

        $( "#filer_data" ).autocomplete({
           minLength: 0,
           source: projects,
           select: function( event, ui ) {
              $( "#filer_data" ).val( ui.item.label );
              return false;
           }
        })

        .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
           return $( "<li style='padding:5px 2px !important;margin:5px 2px !important;border:none !important ' >" )
           .append( "<div style='clear:both'><div style='float:left;padding:0px 5px 1px 5px'><img src='img/makerredM.png' width='30px'></div><div style='float:left;width:85%'>"+item.label+"<br><a class='goperfil' style='float:left;Padding:5px 2px !important;color:#1768AC' onclick='funcion1(\""+item.value+"\")'> Ver Perfil > </a> <a class='goperfil' style='float:right;Padding:5px 2px !important;color:#1768AC' onclick='funcion2(\""+item.value+"\")'> Ver Mapa></a></div><div style='clear:both;height:1px'>&nbsp;</div></div>")
           .appendTo( ul );
        };  
JS;
$this->registerJs($script);
}

?>
    
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
