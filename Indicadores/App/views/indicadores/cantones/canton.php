<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
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
        <!---CSS------------------------------------------------------------->
        <link href="css/fonts/material-icons.css" rel="stylesheet" />
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet" />
        <link href="css/canton.css?v2.5.1" rel="stylesheet" type="text/css" />
		<link href="css/site.css" rel="stylesheet" type="text/css" />
        
        <!---Boostrap js -->
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="js/chartjs/Chart.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        
        <title>Perfil de Canton</title>
        
        <!--autocomplete-->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            var js_array=[];
            var js_array2=[];
            var minstep=[];
            var maxstep=[];
            var numerico=[];
        </script>
  
    </head>
    <body>
        	<!--HEADER-->
            <header class="canton-interno">
                <div class="container">
                    <div class="canton-header py-3">
                        <div class="row">
                             <div class="col-xs-12 col-md-3 pt-1 head-logo">
							  <a onclick="goBack()" onmouseover="" style="cursor: pointer;"><img class="img-fluid" src="img/mainLogo_siap.png"/></a>
							</div>
							
                            <div class="col-xs-12 col-md-4 headOptions">
                                <!--SEARCH BOX-->
				<div class="searchBar pt-1">
                                    <input id="filer_data" size="40" class="form-control" placeholder="Buscar otros cantones">
                                </div>
								
                                </div>
							
							<div class="col-md-5">
							<?php

								//Construyendo Ruta para Glosario
										$_ulrglosario = yii\helpers\Url::toRoute(['indicadores/glosario/index']);
                                        $_ulrPREGUNTAS = yii\helpers\Url::toRoute(['indicadores/glosario/preguntas']);
                                        $_ulrcomparativo = yii\helpers\Url::toRoute(['indicadores/indicadorparametro/comparativo']);
								?>
                                <!--BOTONERA-->
                                <div class="botonera pt-1">
                                        <div class="btn btn-default"><img class="img-responsive" src="img/ic_head1.png"/><a href="<?= $_ulrcomparativo ?>"> Comparativos</a></div>
                                        <div class="btn btn-default"><img class="img-responsive" src="img/ic_head2.png"/><a onclick="glosario()" onmouseover="" style="cursor: pointer;"> Glosario </a></div>
                                        <div class="btn btn-default"><img class="img-responsive" src="img/ic_head3.png"/><a href="<?= $_ulrPREGUNTAS ?>"> Preguntas Frecuentes </a></div>
                                </div>
							</div>
							
							
                            </div>
                            	
                    </div>
               </div>

            </header>
			<!--CONTENT-->
            <main>
                <!--<section>
                    <div class="container">
                            <div class="py-3">
                                    <div class="row flex-nowrap justify-content-between align-items-center">
                                            <div class="col-12 pt-1">
                                                    <a href="goBack()">Volver al Inicio</a>
                                            </div>
                                    </div>
                            </div>
                    </div>
                </section>-->
                <section class="section-header bg-canton">
                    <div class="container">
                            <div class="canton-main py-2">
                                    <div class="col-12 pt-1 align-items-center">
                                            <h2 class="text-center"><?= $searchModel->nombre; ?></h2>
                                            <p class="text-center"><span class="">Cant&oacute;n de la provincia de :</span> <?= $searchModel->localizacionpadre['nombre'] ?></p>
                                            <p class="text-center"><span class="">Demarcaci&oacute;n:</span> <?= $searchModel->codDemarcacion['nombre']; ?></p>
                                           
                                    </div>
                            </div>
                    </div>
                </section>
                <section class="main-wrap">
                    <div class="container">
                        <div class="canton-main">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="tabs_box">
							
				<!--------------------------------APLICA PARA PRESTADORES NACIONALES CON ID=1 EN TIPO_PRESTADOR ------------------------------------>		
                                <?php
                                $i=0;
                                if(count($vprestadores['1'])>=1 and in_array('1',$barranav)){
                                ?>
                                    <ul class="nav nav-tabs" role="tablist">
                                        <?php 
                                        

                                        foreach($vprestadores['1'] as $idlocalizacionprestador => $prestador){
                                            if($i==0) {
                                                $extra1 = " active";
                                                
                                            }else{
                                                $extra1 = " ";
                                            }   
                                        ?>  
                                            <li class="nav-item">
                                                <a class="nav-link <?= $extra1; ?>" data-toggle="tab"  href="#prestador<?= $idlocalizacionprestador ?>"><?= $prestador['nom_prestador']; ?></a>
                                            </li>
                                        <?php 
                                            $i+=1;
                                        }
                                        ?>
                                     


                                <?php
                                }
                                ?>
                                
                                
                                <!---------------------------APLICA PARA PRESTADORES COMUNITARIOS CON ID=2 EN TIPO PRESTADOR ---------------------------------------->
                                <?php
                                if(!empty($vprestadores['2']) and count($vprestadores['2'])>=1 and in_array('1',$barranav)){
                                ?>    
                                    <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab"  href="#prestador_tipo2"><?= "PRESTADORES COMUNITARIOS DE AGUA POTABLE Y SANEAMIENTO" ?></a>
                                    </li>
                                <?php    
                                }
                                
                                ?>
                                
                                <?php
                                    if($i>0){
                                ?>        
                                    </ul>
                                <?php
                                    }
                                ?>
                                    
                             </div>
                            </div>    
                        <div class="tab-content">    
                       
                            <!-------------------------------------CONTENIDO DEL TAB DE PRESTADORES NACIONALES ------------------------->
                            <?php 
                            $i=0;
                            foreach($vprestadores['1'] as $idlocalizacionprestador => $prestador){
                                
                               if($i==0) {
                                   $extra2 = " active";
                               }else{
                                   $extra2 = " fade";
                               }
                                
                            ?>  
                           
                            
                            <div class="tab-pane container  <?= $extra2; ?>" id="prestador<?= $idlocalizacionprestador ?>">
                                <div class="canton-main">
                                    
                                    <!----------------------------------------LINEA 1--------------------------------------------------->
                                    <div class="row">
                                        <div class="col-12 filter-indicador-box">
                                            <span class="h4">Indicadores</span>

                                            <div class="selector-year">
                                                <select name="canton-year" id="canton-year" onchange="changeIndicadorCanton(this.value,<?= $idlocalizacionprestador ?>)" class="form-control">
                                                    <?php
                                                        foreach ($prestador['anios'] as $anio) {
                                                            $selected = ($anio == $prestador['maximo_anio']) ? 'selected' : ''; ?>
                                                            <option value="<?= $anio; ?>" <?= $selected; ?> ><?= $anio; ?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <input type="hidden" id="cod_oficial" value="<?=$searchModel->cod_oficial;?>" />
                                            <div class="actionlinks"><span><a class="btn btn-outlined" id="enlaceExcel" target="_blank" href="<?= yii\helpers\Url::toRoute(['indicadores/cantones/genexcel']);?>&cod_canton=<?=$searchModel->cod_oficial;?>&year=<?=$prestador['maximo_anio'];?>"><img src="img/excel.png"> <span class="text-enlacecanton">Descargar Excel</span></a></span><span><a  class="btn btn-outlined" id="enlacePdf" target="_blank" href="<?= yii\helpers\Url::toRoute(['indicadores/cantones/genpdf']);?>&cod_canton=<?=$searchModel->cod_oficial;?>&year=<?=$prestador['maximo_anio'];?>"><img src="img/pdf.png"> <span class="text-enlacecanton">Descargar PDF </span> </a></span></div>
                                            <div id="desempeno-<?= $idlocalizacionprestador ?>" class="performance">
                                                <span class="h5">Desempeño: </span>
                                                <div class="valor"><?= $prestador['eval_valor']; ?></div>
                                                <div class="cuadrado" style="background-color: <?= $prestador['color']; ?>"><?= $prestador['print_eficiencia']; ?></div>
                                                <div class="estrellas">
                                                    <?php
                                                
                                                        for($e=0;$e<$prestador['cant_estrellas'];$e++){
                                                            echo '<div class="shield__container">
                                                                    <div class="container__star"></div>
                                                                  </div>';
                                                        }
                                                
                                                    ?>
                                                </div>
                                                <span class="h4"><?= $prestador['print_eficiencia2']; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <!---------------------------------------------------------------------------------------------------->
                                    <div id="setIndicador-<?= $idlocalizacionprestador ?>">
                                        <?php
                                        if (count($prestador['resultados']) == 0) {
                                            ?>
                                            <div class="emptyMsg"><p>No existen resultados para el periodo seleccionado</p></div>
                                        <?php
                                        }
                                        foreach ($prestador['resultados'] as $indicador_parametro) {
                                          // print_r($indicador_parametro);
                                        ?>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6 pt-1">
                                                            <div class="headIndicador">
                                                                    <span class="h3"><?= $indicador_parametro['sigla']; ?></span>
                                                                    <p><?= $indicador_parametro['descripcion']; ?></p>
                                                                    <a style="cursor: hand;color:#000; font-weight: bold; text-decoration: underline" onclick="metodologia(<?= $indicador_parametro['cod_indi_param']; ?>)">¿Cómo se calcula este Indicador?</a>
                                                            </div>
                                                        </div>

                                                        <div class="col-xs-6 col-md-3 pt-4">
                                                            <div class="data-values">
                                                                    <?php
                                                                    if($indicador_parametro['frecuencia_ingreso'] == 'mensual' && $indicador_parametro['calcular_valor_imprimir'] == 'N'){
                                                                    ?>
                                                                    <span style="clear:both;display: block">
                                                                        <select name="mesindicador_<?= $indicador_parametro['cod_indi_param']; ?>" onchange="changemonth(<?= $indicador_parametro['cod_indi_param']; ?>,this.value,<?= $final ?>,'<?= $indicador_parametro['tipo_dato'] ?>')">
                                                                            <option value="1" <?= ($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['mes_select'] == '1')? 'selected':''; ?> >Ene</option>
                                                                            <option value="2" <?= ($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['mes_select'] == '2')? 'selected':''; ?>>Feb</option>
                                                                            <option value="3" <?= ($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['mes_select'] == '3')? 'selected':''; ?>>Mar</option>
                                                                            <option value="4" <?= ($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['mes_select'] == '4')? 'selected':''; ?>>Abr</option>
                                                                            <option value="5" <?= ($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['mes_select'] == '5')? 'selected':''; ?>>May</option>
                                                                            <option value="6" <?= ($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['mes_select'] == '6')? 'selected':''; ?>>Jun</option>
                                                                            <option value="7" <?= ($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['mes_select'] == '7')? 'selected':''; ?>>Jul</option>
                                                                            <option value="8" <?= ($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['mes_select'] == '8')? 'selected':''; ?>>Ago</option>
                                                                            <option value="9" <?= ($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['mes_select'] == '9')? 'selected':''; ?>>Sep</option>
                                                                            <option value="10" <?= ($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['mes_select'] == '10')? 'selected':''; ?>>Oct</option>
                                                                            <option value="11" <?= ($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['mes_select'] == '11')? 'selected':''; ?>>Nov</option>
                                                                            <option value="12" <?= ($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['mes_select'] == '12')? 'selected':''; ?>>Dic</option>
                                                                        </select>    
                                                                    </span>
                                                                    <script>
                                                                         js_array.push([<?php echo '"'.implode('","', $graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['labelsgraf'][$final]).'"'; ?>]);    
                                                                         js_array2.push([<?php echo '"'.implode('","', $graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['valoresgraf'][$final]).'"'; ?>]);     
                                                                         minstep.push(0);
                                                                         maxstep.push(parseInt(<?= ceil($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['maximo']); ?>)+10);
                                                                         numerico.push(<?= $idlocalizacionprestador.'-'.$indicador_parametro['cod_indi_param']; ?>); 
                                                                    </script>    
                                                                    <?php
                                                                    }else{
                                                                    ?>
                                                                    <script>
                                                                         js_array.push([<?php echo '"'.implode('","', $graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['labelsgraf']).'"'; ?>]);    
                                                                         js_array2.push([<?php echo '"'.implode('","', $graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['valoresgraf']).'"'; ?>]);     
                                                                         minstep.push(0);
                                                                         maxstep.push(parseInt(<?= ceil($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['maximo']); ?>)+10);
                                                                         numerico.push(<?= $idlocalizacionprestador ?>+'-'+<?= $indicador_parametro['cod_indi_param']; ?>);
                                                                    </script> 
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <span class="h1" id="valorprint_<?= $idlocalizacionprestador.'-'.$indicador_parametro['cod_indi_param']; ?>"><?= $valor_print[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]; ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-6 col-md-3 pt-1">
                                                            <div class="data-values">
                                                                <span class="h6" style="display:block" >Valores de Cumplimiento</span>
                                                                <span class="h1">><?= ceil($indicador_parametro['valor_cumplimiento']); ?></span>
                                                             </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!----------------------------Inicia la Grafica ----------------------------------------------------->
                                                <div class="card-footer">
                                                    <div class="btn btn-default" type="button" data-toggle="collapse" data-target="#collapseExample_<?= $idlocalizacionprestador.'-'.$indicador_parametro['cod_indi_param']; ?>" aria-expanded="false" aria-controls="collapseExample">Ver Histórico</div>   
                                                    <div class="collapse" id="collapseExample_<?= $idlocalizacionprestador.'-'.$indicador_parametro['cod_indi_param']; ?>">
                                                        <div class="wrap-historico">
                                                            <div class="row">
                                                                <div class="col-12 col-md-8 titlegrpah">
                                                                    <span class="h5">Indicador <?= $indicador_parametro['sigla']; ?> </span>
                                                                </div>
                                                                <div class="col-6 col-md-4">
                                                                    <select class="form-control" id="tipegraph" name="<?= $idlocalizacionprestador.'-'.$indicador_parametro['cod_indi_param']; ?>" onchange="selectgraph(this)">
                                                                        <option value="1">Barras</option>
                                                                        <option value="2">Líneas</option>
                                                                    </select>
                                                                </div>
                                                            </div>    
                                                    
                                                            <div id="bargrafica_<?= $idlocalizacionprestador.'-'.$indicador_parametro['cod_indi_param']; ?>">
                                                                <canvas id="myChart_<?= $idlocalizacionprestador.'-'.$indicador_parametro['cod_indi_param']; ?>" width="400" height="150"></canvas>
                                                            </div>
                                                    
                                                            <div id="lineagrafica_<?= $idlocalizacionprestador.'-'.$indicador_parametro['cod_indi_param']; ?>" style=" display: none;">
                                                                <canvas id="myChart2_<?= $idlocalizacionprestador.'-'.$indicador_parametro['cod_indi_param']; ?>" width="400" height="150"></canvas>
                                                            </div>
                                                    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                              </div>
                            <?php  
                                $i+=1;
                            }
                            ?> 
                            
                            
                            <!-------------------------------------CONTENIDO DEL TAB DE PRESTADORES COMUNITARIOS ------------------------->
                            <?php
                            if(!empty($vprestadores['2'])){
                            ?>   
                            
                                <div class="tab-pane container fade" id="prestador_tipo2">
                                <div class="canton-main">
                                    
                                    
                                    <!----------------------------------------LINEA 1 --------------------------------------------------->
                                    <div class="row">
                                            <div class="col-12 filter-indicador-box">
                                                <div class="select-prestador">
                                                    <label for="prestador-comunitario">Seleccione Prestador:</label>
                                                    <select name="prestador-comunitario" id="prestador-comunitario" class="form-control" onchange="changeComunitario(this.value)">
                                                         <?php 
                                                            foreach($vprestadores['2'] as $idlocalizacionprestador => $prestador){
                                                                ?>
                                                                    <option value="<?= $idlocalizacionprestador; ?>"><?= $prestador['nom_prestador']; ?></option>
                                                                <?php    
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>  
                                    
                                    
                                    
                                    <?php 
                                        $u=0;
                                        foreach($vprestadores['2'] as $idlocalizacionprestador => $prestador){
                                            
                                        if($u == 0){
                                            $_display = "block";
                                        }else{
                                           $_display = "none"; 
                                        }
                                        
                                    ?>
                                        
                                        <div id="<?= $idlocalizacionprestador ?>"  style="display:<?= $_display; ?>" class="tpcomunitario<?= $idlocalizacionprestador ?>">
                                    
                                                 <!----------------------------------------LINEA 1--------------------------------------------------->
                                                <div class="row">
                                                    <div class="col-12 filter-indicador-box">
                                                        <span class="h4">Indicadores <span id="nombrelocalizacion"><?= $prestador['nom_prestador'] ?></span></span>

                                                        <div class="selector-year">
                                                            <select name="canton-year" id="canton-year" onchange="changeIndicadorCanton(this.value,<?= $idlocalizacionprestador ?>)" class="form-control">
                                                                <?php
                                                                    foreach ($prestador['anios'] as $anio) {
                                                                        $selected = ($anio == $prestador['maximo_anio']) ? 'selected' : ''; ?>
                                                                        <option value="<?= $anio; ?>" <?= $selected; ?> ><?= $anio; ?></option>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        
                                                        <input type="hidden" id="cod_oficial" value="<?=$searchModel->cod_oficial;?>" />
                                                        <div class="actionlinks">
                                                            <span>
                                                                <a class="btn btn-outlined" id="enlaceExcel" target="_blank" href="<?= yii\helpers\Url::toRoute(['indicadores/cantones/genexcel']);?>&cod_canton=<?=$searchModel->cod_oficial;?>&year=<?=$prestador['maximo_anio'];?>"><img src="img/excel.png"> <span class="text-enlacecanton">Descargar Excel</span></a></span><span><a  class="btn btn-outlined" id="enlacePdf" target="_blank" href="<?= yii\helpers\Url::toRoute(['indicadores/cantones/genpdf']);?>&cod_canton=<?=$searchModel->cod_oficial;?>&year=<?=$prestador['maximo_anio'];?>"><img src="img/pdf.png"> <span class="text-enlacecanton">Descargar PDF </span> 
                                                                </a>
                                                                
                                                            </span>
                                                        </div>


                                                        <div id="desempeno-<?= $idlocalizacionprestador ?>" class="performance">
                                                            <span class="h5">Desempeño: </span>
                                                            <div class="valor"><?= $prestador['eval_valor']; ?></div>
                                                            <div class="cuadrado" style="background-color: <?= $prestador['color']; ?>"><?= $prestador['print_eficiencia']; ?></div>
                                                            <div class="estrellas">
                                                                <?php

                                                                    for($e=0;$e<$prestador['cant_estrellas'];$e++){
                                                                        echo '<div class="shield__container">
                                                                                <div class="container__star"></div>
                                                                              </div>';
                                                                    }

                                                                ?>
                                                            </div>
                                                            <span class="h4"><?= $prestador['print_eficiencia2']; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                 
                                                 
                                                 <!------------------------------------ INFORMACION LINEA 2 ----------------------------------------------------->
                                                 <div id="setIndicador-<?= $idlocalizacionprestador ?>">
                                                     <?php
                                                     
                                                        /*Se presenta informacion si no hay resultado*/
                                                        if (count($prestador['resultados']) == 0) {
                                                            ?>
                                                            <div class="emptyMsg"><p>No existen resultados para el periodo seleccionado</p></div>
                                                        <?php
                                                        }
                                                        
                                                        foreach ($prestador['resultados'] as $indicador_parametro) {
                                                        ?>    
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-6 pt-1">
                                                                        <div class="headIndicador">
                                                                                <span class="h3"><?= $indicador_parametro['sigla']; ?></span>
                                                                                <p><?= $indicador_parametro['descripcion']; ?></p>
                                                                                <a style="cursor: hand;color:#000; font-weight: bold; text-decoration: underline" onclick="metodologia(<?= $indicador_parametro['cod_indi_param']; ?>)">¿Cómo se calcula este Indicador?</a>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-xs-6 col-md-3 pt-4">
                                                                        <div class="data-values">
                                                                                <?php
                                                                                if($indicador_parametro['frecuencia_ingreso'] == 'mensual' && $indicador_parametro['calcular_valor_imprimir'] == 'N'){
                                                                                ?>
                                                                                <span style="clear:both;display: block">
                                                                                    <select name="mesindicador_<?= $indicador_parametro['cod_indi_param']; ?>" onchange="changemonth(<?= $indicador_parametro['cod_indi_param']; ?>,this.value,<?= $final ?>,'<?= $indicador_parametro['tipo_dato'] ?>')">
                                                                                        <option value="1" <?= ($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['mes_select'] == '1')? 'selected':''; ?> >Ene</option>
                                                                                        <option value="2" <?= ($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['mes_select'] == '2')? 'selected':''; ?>>Feb</option>
                                                                                        <option value="3" <?= ($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['mes_select'] == '3')? 'selected':''; ?>>Mar</option>
                                                                                        <option value="4" <?= ($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['mes_select'] == '4')? 'selected':''; ?>>Abr</option>
                                                                                        <option value="5" <?= ($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['mes_select'] == '5')? 'selected':''; ?>>May</option>
                                                                                        <option value="6" <?= ($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['mes_select'] == '6')? 'selected':''; ?>>Jun</option>
                                                                                        <option value="7" <?= ($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['mes_select'] == '7')? 'selected':''; ?>>Jul</option>
                                                                                        <option value="8" <?= ($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['mes_select'] == '8')? 'selected':''; ?>>Ago</option>
                                                                                        <option value="9" <?= ($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['mes_select'] == '9')? 'selected':''; ?>>Sep</option>
                                                                                        <option value="10" <?= ($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['mes_select'] == '10')? 'selected':''; ?>>Oct</option>
                                                                                        <option value="11" <?= ($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['mes_select'] == '11')? 'selected':''; ?>>Nov</option>
                                                                                        <option value="12" <?= ($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['mes_select'] == '12')? 'selected':''; ?>>Dic</option>
                                                                                    </select>    
                                                                                </span>
                                                                                <script>
                                                                                     js_array.push([<?php echo '"'.implode('","', $graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['labelsgraf'][$final]).'"'; ?>]);    
                                                                                     js_array2.push([<?php echo '"'.implode('","', $graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['valoresgraf'][$final]).'"'; ?>]);     
                                                                                     minstep.push(0);
                                                                                     maxstep.push(parseInt(<?= ceil($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['maximo']); ?>)+10);
                                                                                     numerico.push(<?= $idlocalizacionprestador.'-'.$indicador_parametro['cod_indi_param']; ?>); 
                                                                                </script>    
                                                                                <?php
                                                                                }else{
                                                                                ?>
                                                                                <script>
                                                                                     js_array.push([<?php echo '"'.implode('","', $graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['labelsgraf']).'"'; ?>]);    
                                                                                     js_array2.push([<?php echo '"'.implode('","', $graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['valoresgraf']).'"'; ?>]);     
                                                                                     minstep.push(0);
                                                                                     maxstep.push(parseInt(<?= ceil($graph[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]['maximo']); ?>)+10);
                                                                                     numerico.push(<?= $idlocalizacionprestador ?>+'-'+<?= $indicador_parametro['cod_indi_param']; ?>);
                                                                                </script> 
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                                <span class="h1" id="valorprint_<?= $idlocalizacionprestador.'-'.$indicador_parametro['cod_indi_param']; ?>"><?= $valor_print[$idlocalizacionprestador][$indicador_parametro['cod_indi_param']]; ?></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xs-6 col-md-3 pt-1">
                                                                        <div class="data-values">
                                                                            <span class="h6" style="display:block" >Valores de Cumplimiento</span>
                                                                            <span class="h1">><?= ceil($indicador_parametro['valor_cumplimiento']); ?></span>
                                                                         </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!----------------------------Inicia la Grafica ----------------------------------------------------->
                                                            <div class="card-footer">
                                                                <div class="btn btn-default" type="button" data-toggle="collapse" data-target="#collapseExample_<?= $idlocalizacionprestador.'-'.$indicador_parametro['cod_indi_param']; ?>" aria-expanded="false" aria-controls="collapseExample">Ver Histórico</div>   
                                                                <div class="collapse" id="collapseExample_<?= $idlocalizacionprestador.'-'.$indicador_parametro['cod_indi_param']; ?>">
                                                                    <div class="wrap-historico">
                                                                        <div class="row">
                                                                            <div class="col-12 col-md-8 titlegrpah">
                                                                                <span class="h5">Indicador <?= $indicador_parametro['sigla']; ?> </span>
                                                                            </div>
                                                                            <div class="col-6 col-md-4">
                                                                                <select class="form-control" id="tipegraph" name="<?= $idlocalizacionprestador.'-'.$indicador_parametro['cod_indi_param']; ?>" onchange="selectgraph(this)">
                                                                                    <option value="1">Barras</option>
                                                                                    <option value="2">Líneas</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>    

                                                                        <div id="bargrafica_<?= $idlocalizacionprestador.'-'.$indicador_parametro['cod_indi_param']; ?>">
                                                                            <canvas id="myChart_<?= $idlocalizacionprestador.'-'.$indicador_parametro['cod_indi_param']; ?>" width="400" height="150"></canvas>
                                                                        </div>

                                                                        <div id="lineagrafica_<?= $idlocalizacionprestador.'-'.$indicador_parametro['cod_indi_param']; ?>" style=" display: none;">
                                                                            <canvas id="myChart2_<?= $idlocalizacionprestador.'-'.$indicador_parametro['cod_indi_param']; ?>" width="400" height="150"></canvas>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                          </div>
                                                        <?php
                                                        }
                                                        ?>
                                                        
                                                 </div> 
                                                 
                                                 
                                    
                                    
                                        </div> 
                                    <?php
                                        $u+=1;
                                        }
                                    ?>    
                                    
                                    
                                     </div> 
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                        </div>   
                    </div>
                </section>
                

            </main>
            <footer class="footer">
        <div class="container text-center">
            <div class="wrapFooter-content">Visualizador de indicadores de Agua potable</div>
                    <p><img class="img-fluid" src="img/LogoArca.png"/></p>
                <p><?= date('Y'); ?></p>
        </div>
</footer>
        
                        
        <!------------------------------------JAVASCRIPT DE GRAFICAS ------------------------------------------>                
        <script>
            jQuery.each(numerico, function(i, val) {
              
                var ctx = document.getElementById('myChart_'+val);
                var myChart = new Chart(ctx, {
                     type: 'bar',
                     data: {
                         labels: js_array[i],
                         datasets: [{
                             label: 'Periodos',
                             data: js_array2[i],
                             backgroundColor: "rgba(37,176,236,0.8)",
                             borderColor: "rgba(37,176,236,0.8)",
                             borderWidth: 1
                         }]
                     },
                     options: {
                         scales: {
                             yAxes: [{
                                 ticks: {
                                     beginAtZero: true,
                                     steps: 5,
                                     max: maxstep[i]
                                 }
                             }]
                         }
                     }
                 }); 

                 var ctx2 = document.getElementById('myChart2_'+val);
                 var myChart2 = new Chart(ctx2, {
                     type: 'line',
                     data: {
                         labels: js_array[i],
                         datasets: [{
                             label: 'Periodos',
                             data: js_array2[i],
                             borderColor: "rgba(37,176,236,0.8)",
                             borderWidth: 1
                         }]
                     },
                     options: {
                         scales: {
                             yAxes: [{
                                 ticks: {
                                     beginAtZero: true,
                                     steps: 5,
                                     max: maxstep[i]
                                 }
                             }]
                         }
                     }
                 }); 
             });
        </script>
        
        <script>
            var codcanton = <?= $searchModel->cod_localizacion; ?>;
            var codprovincia = <?= $searchModel->localizacionpadre['cod_localizacion']; ?>;
            var cantonesObjt = <?php echo json_encode($allcantones); ?>;
            var cantonesBusc = <?php echo json_encode($buscador) ?>;
        </script>
        <script src="js/varias.js?v3.6.2" type="text/javascript"></script>
        <script src="js/yioverride.js?v2" type="text/javascript"></script>
        <script>
            $( function() {
                
                var projects = cantonesBusc;
                $( "#filer_data" ).autocomplete({
                   minLength: 0,
                   source: projects,
                   select: function( event, ui ) {
                      $( "#filer_data" ).val( ui.item.label );
                      return false;
                   }
                }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
                   return $( "<li style='padding:5px 2px !important;margin:5px 2px !important;border:none !important ' >" )
                   .append( "<div style='clear:both'><div style='float:left;padding:0px 5px 1px 5px'><img src='img/makerredM.png' width='30px'></div><div style='float:left;width:85%'>"+item.label+"<br><a class='goperfil' style='float:left;Padding:5px 2px !important;color:#1768AC' onclick='funcion1(\""+item.value+"\")'> Ver Perfil > </a> <a class='goperfil' style='float:right;Padding:5px 2px !important;color:#1768AC' onclick='funcion2(\""+item.value+"\")'> Ver Mapa></a></div><div style='clear:both;height:1px'>&nbsp;</div></div>")
                   .appendTo( ul );
                }; 
                
           });
        </script>
        <!-- Loading Overlay -->
        <script src="js/loadingoverlay.min.js"></script>
    </body>
</html>