var cantonesTags = [];



$(function () {
    $('[data-toggle="popover"]').popover();
    loadFiltroCantones();
    
});


function loadFiltroCantones(){
    
    myCantones = JSON.parse(cantonesObjt);
    jQuery.each(myCantones, function(i, val) {
        cantonesTags.push(myCantones[i].nombre_canton);
    });
   
    $( "#filtroCantones" ).autocomplete({
      source: cantonesTags
    });
}

function reloadBusqueda(event){
    
    var seleccionada = $('#filtroCantones').val();
    
    jQuery.each(myCantones, function(i, val) {
        if(myCantones[i].nombre_canton === seleccionada){
            dpa_cantonsel = myCantones[i].dpa_canton;
        }
    });
    
    var urlref= "http://"+window.location.hostname+(window.location.port ? ':'+window.location.port: '')+window.location.pathname+"?r=indicadores/cantones/canton&dpa_canton="+dpa_cantonsel.toString();
    window.location.href = urlref;
}

function getIndicadores(year,codcanton,idlocalprestador){
   var today = new Date();
   var url = "http://"+window.location.hostname+(window.location.port ? ':'+window.location.port: '')+window.location.pathname+'?r=indicadores/cantones/resultados';

   return $.ajax({
           data:  "year="+year+"&cod_canton="+codcanton+"&id_localizacion_prestador="+idlocalprestador,
           url:   url,
           type:  'get'
   });
}

//'Desempeño:' +myIndicadores[i].eficianciaprint+ '  <span class="circulo" style="background-color:'+myIndicadores[i].coloreficiencia+'">&nbsp;</span>'
function changeIndicadorCanton(val,idlocalprestador) {
  
  $.LoadingOverlay("show");
  var stringHTML = "";
  var desempeHTML = "";

  $("#enlaceExcel").attr("href", window.location.pathname+"?r=indicadores%2Fcantones%2Fgenexcel&cod_canton="+ $("#cod_oficial").val()+"&year="+val+"");
  $("#enlacePdf").attr("href",window.location.pathname+"?r=indicadores%2Fcantones%2Fgenpdf&cod_canton="+ $("#cod_oficial").val()+"&year="+val+"");
  
   getIndicadores(val,codcanton,idlocalprestador).done(function(searchResultados) {
       
        var myIndicadores = JSON.parse(searchResultados);
        var q=0;
        
        jQuery.each(myIndicadores, function(i, val) {
            
            if(i === 0){
                
                desempeHTML = desempeHTML + 'Desempeño: ';
                desempeHTML = desempeHTML + '<div class="valor">'+myIndicadores[i].eval_valor+'</div>';
                desempeHTML = desempeHTML + '<div class="cuadrado" style="background-color:'+myIndicadores[i].coloreficiencia+'">'+myIndicadores[i].eficianciaprint+'</div>';
                desempeHTML = desempeHTML + '<div class="estrellas">';
                 
                for (i = 0; i < myIndicadores[i].cant_estrellas; i++) {
                    desempeHTML = desempeHTML + '<div class="shield__container"><div class="container__star"></div></div>';
                }
                 
                desempeHTML = desempeHTML + '</div>';
                desempeHTML = desempeHTML + myIndicadores[i].eficaciaprint2;
                
                $( "#desempeno-"+idlocalprestador ).html(desempeHTML); 
            }
            
            stringHTML='';
            
            stringHTML = stringHTML+'<div class="card">';
            stringHTML = stringHTML+'<div class="card-body">';
            stringHTML = stringHTML+'<div class="row">';
            stringHTML = stringHTML+'<div class="col-md-6 pt-1">';
            stringHTML = stringHTML+'<div class="headIndicador">';
            stringHTML = stringHTML+'<span class="h3">'+myIndicadores[i].sigla+'</span>';
            stringHTML = stringHTML+'<p>'+myIndicadores[i].descripcion+'</p>';
            stringHTML = stringHTML+'<a style="cursor: hand;color:#0069d9" onclick="metodologia('+myIndicadores[i].cod_indi_param+')">¿Cómo se calcula este Indicador?</a>';
            stringHTML = stringHTML+'</div>';
            stringHTML = stringHTML+'</div>';
            stringHTML = stringHTML+'<div class="col-xs-6 col-md-3 pt-4">';
            stringHTML = stringHTML+'<div class="data-values">';
            
            
            //Presentando Combo de valores  ===============================================================================================
            if(myIndicadores[i].frecuencia_ingreso === 'mensual' && myIndicadores[i].calcular_valor_imprimir === 'N'){
                stringHTML = stringHTML+'<span style="clear:both;display: block">';
                stringHTML = stringHTML+'<select name="mesindicador_'+myIndicadores[i].cod_indi_param+'" onchange="changemonth('+myIndicadores[i].cod_indi_param+',this.value,'+myIndicadores[i].final+',\''+myIndicadores[i].tipo_dato+'\')">';
               
                stringHTML = stringHTML+'<option value="1" ';
                stringHTML = (myIndicadores[i].mes_selected === '1')? stringHTML+'selected':stringHTML+'';
                stringHTML = stringHTML+'>Ene</option>';
                
                stringHTML = stringHTML+'<option value="2" ';
                stringHTML = (myIndicadores[i].mes_selected === '2')? stringHTML+'selected':stringHTML+'';
                stringHTML = stringHTML+'>Feb</option>';
                
                stringHTML = stringHTML+'<option value="3" ';
                stringHTML = (myIndicadores[i].mes_selected === '3')? stringHTML+'selected':stringHTML+'';
                stringHTML = stringHTML+'>Mar</option>';
                
                stringHTML = stringHTML+'<option value="4" ';
                stringHTML = (myIndicadores[i].mes_selected === '4')? stringHTML+'selected':stringHTML+'';
                stringHTML = stringHTML+'>Abr</option>';
                
                stringHTML = stringHTML+'<option value="5" ';
                stringHTML = (myIndicadores[i].mes_selected === '5')? stringHTML+'selected':stringHTML+'';
                stringHTML = stringHTML+'>May</option>';
                
                stringHTML = stringHTML+'<option value="6" ';
                stringHTML = (myIndicadores[i].mes_selected === '6')? stringHTML+'selected':stringHTML+'';
                stringHTML = stringHTML+'>Jun</option>';
                
                stringHTML = stringHTML+'<option value="7" ';
                stringHTML = (myIndicadores[i].mes_selected === '7')? stringHTML+'selected':stringHTML+'';
                stringHTML = stringHTML+'>Jul</option>';
                
                stringHTML = stringHTML+'<option value="8" ';
                stringHTML = (myIndicadores[i].mes_selected === '8')? stringHTML+'selected':stringHTML+'';
                stringHTML = stringHTML+'>Ago</option>';
                
                stringHTML = stringHTML+'<option value="9" ';
                stringHTML = (myIndicadores[i].mes_selected === '9')? stringHTML+'selected':stringHTML+'';
                stringHTML = stringHTML+'>Sep</option>';
                
                stringHTML = stringHTML+'<option value="10" ';
                stringHTML = (myIndicadores[i].mes_selected === '10')? stringHTML+'selected':stringHTML+'';
                stringHTML = stringHTML+'>Oct</option>';
                
                stringHTML = stringHTML+'<option value="11" ';
                stringHTML = (myIndicadores[i].mes_selected === '11')? stringHTML+'selected':stringHTML+'';
                stringHTML = stringHTML+'>Nov</option>';
                
                stringHTML = stringHTML+'<option value="12" ';
                stringHTML = (myIndicadores[i].mes_selected === '12')? stringHTML+'selected':stringHTML+'';
                stringHTML = stringHTML+'>Dic</option>';
                
                stringHTML = stringHTML+'</select>';    
                stringHTML = stringHTML+'</span>';
            }
            
            stringHTML = stringHTML+'<span class="h1" id="valorprint_'+idlocalprestador+'-'+myIndicadores[i].cod_indi_param+'">'+myIndicadores[i].valorprint+'</span>';
            stringHTML = stringHTML+'</div>';
            stringHTML = stringHTML+'</div>';
            stringHTML = stringHTML+'<div class="col-xs-6 col-md-3 pt-1">';
            stringHTML = stringHTML+'<div class="data-values">';
            stringHTML = stringHTML+'<span class="h6" style="display:block" >Valores de Cumplimiento</span>';
            stringHTML = stringHTML+'<span class="h1">>'+myIndicadores[i].valor_cumplimiento+'</span>';
            stringHTML = stringHTML+'</div>';
            stringHTML = stringHTML+'</div>';
            stringHTML = stringHTML+'</div>';
            stringHTML = stringHTML+'</div>';

            /*Grafica*/
            stringHTML = stringHTML+'<div class="card-footer">';
            stringHTML = stringHTML+'<div class="btn btn-default" type="button" data-toggle="collapse" data-target="#collapseExample_'+idlocalprestador+'-'+myIndicadores[i].cod_indi_param+'" aria-expanded="false" aria-controls="collapseExample">Ver Histórico</div>';   
            stringHTML = stringHTML+'<div class="collapse" id="collapseExample_'+idlocalprestador+'-'+myIndicadores[i].cod_indi_param+'">';
            stringHTML = stringHTML+'<div class="wrap-historico">';
            
            //Esta es la division de la grafica
            stringHTML = stringHTML+'<div class="row">';
            stringHTML = stringHTML+'<div class="col-12 col-md-8 titlegrpah">';
            stringHTML = stringHTML+'<span class="h5">Indicador '+myIndicadores[i].sigla+'</span>';
            stringHTML = stringHTML+'</div>';
            stringHTML = stringHTML+'<div class="col-6 col-md-4">';
            stringHTML = stringHTML+'<select id="tipegraph" name="'+idlocalprestador+'-'+myIndicadores[i].cod_indi_param+'" onchange="selectgraph(this)">';
            stringHTML = stringHTML+'<option value="1">Barras</option>';
            stringHTML = stringHTML+'<option value="2">Líneas</option>';
            stringHTML = stringHTML+'</select>';
            stringHTML = stringHTML+'</div>';
            stringHTML = stringHTML+'</div>';

            stringHTML = stringHTML+'<div id="bargrafica_'+idlocalprestador+'-'+myIndicadores[i].cod_indi_param+'">';
            stringHTML = stringHTML+'<canvas id="myChart_'+idlocalprestador+'-'+myIndicadores[i].cod_indi_param+'" width="400" height="150"></canvas>'
            stringHTML = stringHTML+'</div>';

            stringHTML = stringHTML+'<div id="lineagrafica_'+idlocalprestador+'-'+myIndicadores[i].cod_indi_param+'" style=" display: none;">'
            stringHTML = stringHTML+'<canvas id="myChart2_'+idlocalprestador+'-'+myIndicadores[i].cod_indi_param+'" width="400" height="150"></canvas>';
            stringHTML = stringHTML+'</div>';
            
            //Finaliza aqui 
            stringHTML = stringHTML+'</div>';
            stringHTML = stringHTML+'</div>';
            stringHTML = stringHTML+'</div>';
            stringHTML = stringHTML+'</div>';
            
            if(i === 0){
                $("#setIndicador-"+idlocalprestador).html(stringHTML);
            }else{
                $("#setIndicador-"+idlocalprestador).append(stringHTML);
            }
            
            
            
            var maxstep = parseInt(myIndicadores[i].maximo)+parseInt(myIndicadores[i].maximo*0.1);
	    var ctx = document.getElementById('myChart_'+idlocalprestador+'-'+myIndicadores[i].cod_indi_param);
            var ctx2 = document.getElementById('myChart2_'+idlocalprestador+'-'+myIndicadores[i].cod_indi_param);
            
            if(myIndicadores[i].frecuencia_ingreso === 'mensual' && myIndicadores[i].calcular_valor_imprimir === 'N'){
                var valor_graf = myIndicadores[i].valoresgraf[myIndicadores[i].final];
                var labels_graf = myIndicadores[i].labelsgraf[myIndicadores[i].final];
                
//                console.log("que llega en labels mensual",myIndicadores[i].labelsgraf);
//                console.log("que llega en valoresgraf mensual",myIndicadores[i].valoresgraf);
                
            }else{
                var valor_graf = myIndicadores[i].valoresgraf;
                var labels_graf = myIndicadores[i].labelsgraf;
                
//                console.log("que llega en labels anual",myIndicadores[i].labelsgraf);
//                console.log("que llega en valoresgraf anual",myIndicadores[i].valoresgraf);
            }
            
            
            var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels_graf,
                                datasets: [{
                                    label: 'Periodos',
                                    data: valor_graf,
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
                                            max:maxstep
                                        }
                                    }]
                                }
                            }
                        });
                        
                        
              
                var myChart2 = new Chart(ctx2, {
                    type: 'line',
                    data: {
                        labels: labels_graf,
                        datasets: [{
                            label: 'Periodos',
                            data: valor_graf,
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
                                    max: maxstep
                                }
                            }]
                        }
                    }
                });            
            
        });
        
        addPopover("[data-toggle=popover]");
         $.LoadingOverlay("hide");
   });
}



function changeComunitario(val){
    
    var listOfElements = $("div[class^='tpcomunitario']");
    
    for (let elem of listOfElements) {
        $(".tpcomunitario"+elem.id).css("display", "none");
    }
 
    
    $(".tpcomunitario"+val).css("display", "block");
    
}

function addPopover(selector){
$(selector).popover({
        html : true,
        trigger: 'click',
        content: function() {
            var content = $(this).attr("data-popover-content");
            return $(content).children(".popover-body").html();
        },
        title: function() {
            var title = $(this).attr("data-popover-content");
            return $(title).children(".popover-heading").html();
        }
    });
}



function goBack(){
	var Homeurl= "http://"+window.location.hostname+(window.location.port ? ':'+window.location.port: '')+window.location.pathname;

        Homeurl = Homeurl.replace(/[#\s]/g, ''); 
	Homeurl = Homeurl.replace(/goBack/g, '');
	Homeurl = Homeurl.replace(/[#\()]/g, '');

        
        window.location.href = Homeurl;
}


function glosario(){
	var Homeurl= "http://"+window.location.hostname+(window.location.port ? ':'+window.location.port: '')+window.location.pathname+"?r=indicadores/glosario/index";

        Homeurl = Homeurl.replace(/[#\s]/g, ''); 
	Homeurl = Homeurl.replace(/goBack/g, '');
	Homeurl = Homeurl.replace(/[#\()]/g, '');
        window.location.href = Homeurl;
}


function metodologia(indicador){
    
    var urlref= "http://"+window.location.hostname+(window.location.port ? ':'+window.location.port: '')+window.location.pathname+"?r=indicadores/indicadorparametro/view&id="+indicador.toString();
    window.open(urlref,'blank');
    
}


function changemonth(indicador,mes_value,final,tipo_dato){
    
        var url = "http://"+window.location.hostname+(window.location.port ? ':'+window.location.port: '')+window.location.pathname+'?r=indicadores/cantones/valorindicador';
        var und = "";
        
        if(tipo_dato === "P"){
         und = "[%]";   
        }
        
        $.ajax({
            data:  "indicador="+indicador+"&mes_value="+mes_value+"&final="+final+"&cod_canton="+codcanton,
            url:   url,
            type:  'get'
        }).done(function(data) {
            var s_value = data+" "+und;
            $("#valorprint_"+indicador).html(s_value);
        });
}


function selectgraph(getIndicador){
    
    var indicador = getIndicador.name.toString();
    
    if(getIndicador.value === '2'){
        document.getElementById("bargrafica_"+indicador).style.display  = "none";
        document.getElementById("lineagrafica_"+indicador).style.display  = "block";
    }else{
         document.getElementById("bargrafica_"+indicador).style.display  = "block";
        document.getElementById("lineagrafica_"+indicador).style.display  = "none";
    }
   
}