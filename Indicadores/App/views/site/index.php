<?php

use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'Sistema de Indicadores de Agua Potable';
$this->params['data'] = $buscador;                      //Asi se asigna el listado de etiquetas dinamico, falta agregar el envio al link tambien dinamico o el evento al selecionar
//[['value'=>'valor 1','label'=>'etiqueta 4','id'=>'1'],['value'=>'valor 2','label'=>'etiqueta 4','id'=>'2']];
                           
?>


<!--MAP CONTAINER-->
<section class="t1">
	<div class="container">
            
            <div class="map-container"> 
               <div class="row">
                    <!--FILTERS-->
                    <div class="informationover" id="Id_informationover">
                	
                    <ul id="menu-featured-categories" class="menu-featured-categories collapse in">

                        <!------------------------------------------------------------------>
                        <li class="menu-delete" id="visiblefiltro">
                            <span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>
                            <a href="#" id="delete_filtros">Borrar Filtros de Búsqueda</a>
                        </li>    

                        <!-----Menu Pronvicias --------------------------------------->
                        <li class="menu-item-has-children">
                          <a href="#" id="provincias">Filtro 1</a>
                           <div class="sub-menu" id="submenuprovincias">
                               <div class="filtromenu">
                                  <input class="icon" type="text" placeholder="&#61442;" name="filtro_provincia" id="filtro_provincia" />
                               </div>
                               <div id="ulprovincias">

                               </div>
                            </div>
                        </li>

                        <!---Menu Cantones -------------------------------------------------->
                        <li class="menu-item-has-children">
                          <a href="#" id="cantones">Filtro 2</a>
                            <div class="sub-menu" id="submenucantones">
                               <div class="filtromenu">
                                  <input class="icon" type="text" placeholder="&#61442;" name="filtro_canton" id="filtro_canton" />
                               </div>
                               <div id="ulcantones">

                               </div>
                            </div>
                        </li>


                        <!--------Menu Indicadores -------------------------------------------->
                        <li class="menu-item-has-children">
                          <a href="#" id="indicadores">Filtro 3</a>
                          <div class="sub-menu" id="subindicadores">
                              <div class="filtromenu">
                                   <input class="icon" type="text" placeholder="&#61442;" name="filtro_indicador" id="filtro_indicador" />
                              </div>
                              <div id="ulindicadores">

                              </div>
                          </div>
                        </li>


                         <!--------Menu Periodo -------------------------------------------->
                        <li class="menu-item-has-children">
                          <a href="#" id="periodos">Filtro 4</a>
                          <div class="sub-menu" id="subperiodo">
                              <div class="filtromenu">
                                   <input class="icon" type="text" placeholder="&#61442;" name="filtro_periodo" id="filtro_periodo" />
                              </div>
                              <div id="ulperiodos">

                              </div>
                          </div>
                        </li>

                        <!----MENU INFERIOR -------------------------------------------------->
                        <li class="menu-especificacion" id="visibleespecificacion">
                            
                        </li>
                    </ul>
					<div class="close-hide">
						<a class="btn btn-link"role="button" data-toggle="collapse" href="#menu-featured-categories" aria-expanded="true" aria-controls="collapseExample">Ocultar filtros</a>	
					</div>

                </div>
                    
                <!--DIV PARA EL MODAL..SE ABRE CON JAVASCRIPT NO SE USA YII, PARA NO HACER DOBLE CONSULTA A LA BD -->
                <div id="ventanaResultados" class="ventanaresultados">

                </div>
                <!---->
                    
                 <!--MAP CONTAINER-->
                <div class="col-md-12" id="mapid">

                </div>
            </div>
        </div>
            
    </div>
</section>

<!---EVALUACION PRESTADORES RANKING -->
<section class="t2">
	<div class="container">
		<div class="indicators-container">
		<div class="row">
			<div class="col-md-12">
				<h2 class="section-tit">
				Ranking Prestadores</h2>
				<p class="subtitle text-center">Clasificación de los prestadores de acuerdo a su nivel de servicio. <br/>
					
				</p>
				<div class="bBox">
					<span class="text-bold">A</span>=Eficiente, <span class="text-bold">B</span>= Bueno, <span class="text-bold">C</span>= Aceptable, <span class="text-bold">D</span>= Regular, <span class="text-bold">E</span>= Deficiente.
				</div>
			</div>
			
		</div>
			
		<div class="row py-4">
				<div class="col-md-4 col-md-offset-4">
					<label for="year_ranking">A&ntilde;o:</label>
					<select class="form-control" id="year_ranking" onchange="changeFooterFilterRank()"></select>
				</div>			
			
		</div>
			<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
					  <table id="tablefooterRank" class="table table-striped table-hover customTable">


					 </table>
						</div>
					</div>	
				</div>	
		</div>
	</div>
	
</section>





<!--<div class="site-index">
    <div class="body-content">
        <div class="row">
        </div>
    </div>
</div>-->




<!--DIV PARA EL POPUP AL DAR CLIC EN EL MAKER -->
<div id="popup" class="ol-popup">
     <a href="#" id="popup-closer" class="ol-popup-closer"></a>
     <div id="popup-content"></div>
 </div>
<!-->




<!--Pasando Variables del controlador, si estas variables cambian por solicitud nos toca hacer una funcion con ajax -->

<script>
    
    var startcanton = "<?php echo $js_canton; ?>";
    var nombrecanton = "<?php echo $js_nombre_canton; ?>";
    var cantonesObjt = <?php echo json_encode($cantones) ?>;    //Cantones listado completo carga en el arranque
    var provinciasObjt = <?php echo json_encode($provincias) ?>;    //Provincias  Listado completo carga en el arranque
    var periodosObjt = <?php echo json_encode($periodos) ?>;
    var allDataObjt = <?php echo json_encode($alldata) ?>; 
    var cantonesBusc = <?php echo json_encode($buscador) ?>; 
    var ranking = <?php echo json_encode($ranking) ?>; 
    var accentMap = {
      "á": "a",
      "é": "e",
      "í": "i",
      "ó": "o",
      "ú": "u",
      "ö": "o",
      "Á": "A",
      "É": "E",
      "Í": "I",
      "Ó": "O",
      "Ú": "U",
      "Ö": "O",
    };
      
      var normalize = function( term ) {
      var ret = "";
      for ( var i = 0; i < term.length; i++ ) {
        ret += accentMap[ term.charAt(i) ] || term.charAt(i);
      }
      
      return ret;
    };
</script>
<?php
    $this->registerJsFile('@web/js/descriptionfinalmap.js?v2.1.2');
    $this->registerJsFile('@web/js/othermaps.js?v2.3.12');
?>
<!-- Loading Overlay -->
<script src="js/loadingoverlay.min.js"></script>







