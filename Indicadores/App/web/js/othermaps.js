//Funciones que inician al cargar toda la pagina *******************************//
/*
 * 1. Declaracion de variable globales del codigo
 *  a. codprovincia
 *  b. dpacanton
 *  
 *          
        
//        var features = vectorCantones.getFeatures();                //Obteniendo features del vectorCantones
//        jQuery.each(features, function(i, val) {
//            if(features[i].getProperties().DPA_CANTON !== undefined){
//                 features[i].setStyle(defaultStyle);
//            }
//        });
 */

//#region Variables Globales 
    var dpacanton=null;               
    var codprovincia=null;
    var codindicador=null;
    var periodo=null;
    var myProvincias="";
    var myCantones="";
    var myPeriodos="";
    var myIndicadores="";
    var filterObjet="";
    var dataTable="";
    var dataTable1="";
    var filasFooterTable=10;
    var htmlventana_Resultados="";
    var resutadosstring=0;
    var subMenus=['submenucantones','submenuprovincias','subperiodo','subindicadores'];
    var resultadosxpagina = 10;
    var cantonesPaint=[];
    var repaint = false;
    var totalJsonF = 0;
    var totalJsonF1=0;
    var indicador_old='';
    var lastprovincia;
    var lastcanton;
    var lastindicador;
    var myAllData;
    
    //Para centrados rapidos ==========================================================================
    var latitudeProv = [];
    var longitudeProv = [];        
    var latitudeCanton = [];
    var longitudeCanton = [];
//#endregion




//#region generales
    function descripcionEventClick(event){
        
       // console.log(event.target.id + event.target.name +' was clicked.'+ $(event.target).text());
        
        /*Clic sobre una Provincia*/
        if($(event.target).is('#submenuitem_prov')){
            selectProvincia($(event.target).text(),event.target.name);
        }
        
        /*Clic sobre el item PROVINCIA*/
        else if($(event.target).is('#provincias')){
            cleanSubMenus('submenuprovincias');
            $('#submenuprovincias').toggleClass('visible');
        }
        
        /*Clic sobre el item CANTON*/
        else if($(event.target).is('#cantones')){    
            cleanSubMenus('submenucantones');
            $('#submenucantones').toggleClass('visible');
        }
        
        /*Clici sobre el item CANTONES*/
        else if($(event.target).is('#submenuitem')){ 
            selectCant(event);
        }
        
        /*Click sobre item INDICADORES*/
        else if($(event.target).is('#indicadores')){ 
            cleanSubMenus('subindicadores');
            $('#subindicadores').toggleClass('visible');
        }
        
        else if($(event.target).is('#submenuitem_indi')){
            selectIndi(event);
        }
        
        /*Clic sobre item Periodos*/
        else if($(event.target).is('#periodos')){
            cleanSubMenus('subperiodo');
            $('#subperiodo').toggleClass('visible');
        }
        
        else if($(event.target).is('#submenuitem_periodo')){
            selectPeri(event);
        }
        
        /*Clic sobre borra filtros*/
        else if($(event.target).is('#delete_filtros')){
           setRealodmap();
        }
    }
    
    
    function cleanSubMenus(submenuexcept){
        subMenus.forEach(element => {
            if(element !== submenuexcept){
                
                if($('#'+element).is(':visible')){
                   $('#'+element).toggleClass('visible'); 
                }
            }
        });
    }
   
    function setCenterMap(latcenter,longcenter,zoom){
          
        var centerview = new ol.View({
            center: ol.proj.transform([longcenter,latcenter], 'EPSG:4326', 'EPSG:3857'),
            zoom: zoom
        });

        map.setView(centerview);
    }
            
    function setRealodmap(){
        
        $.LoadingOverlay("show");

            cleanSubMenus(null);
            
            if(selectCanton == true || selectProv == true || viewCanton == true){
                map.removeLayer(vectorLayerProvincias);
                map.removeLayer(vectorLayerCantones);
            }

           
            if(repaint === true){
                map.removeLayer(vectorMakers);
            }

            map.addLayer(vectorLayerProvincias);
            vectorLayerProvincias.setZIndex(1);
            
            
            viewCanton = false;
            viewProvincia = true;

            dpacanton=null;               
            codprovincia=null;
            codindicador=null;
            periodo=null;
            selectProv = false;
            selectCanton = false;
            selectIndicador = false;
            selectPeriodo = false;
            viewCanton = false;
            cantonesPaint=[];  
            latitudeProv=[];
            longitudeProv=[];
            latitudeCanton = [];
            longitudeCanton = [];

            $("#cantones" ).text("Cantones");
            $("#provincias" ).text("Provincias");
            $("#indicadores" ).text("Indicadores");
            $("#periodos" ).text("Periodo");
            
            $("#filtro_indicador").val('');
            
            

            $('#visibleespecificacion').hide();
            $('#visiblefiltro').hide();
        
            if(repaint === true){
                
                vectorSource = {};
                
                vectorSource = new ol.source.Vector({
                    features: arrayMaker
                });

                vectorMakers = new ol.layer.Vector({
                    id: 'makers',
                    source: vectorSource
                });
            
                map.addLayer(vectorMakers);
                vectorMakers.setZIndex(2);
                
                repaint = false;  
            }
        
            loadUlPeriodos(myPeriodos);
            setCenterMap(-1.831239,-78.183403,7);
            oldZoom = 7;
            
            setFilterData(null,null,null,null,myAllData);
        $.LoadingOverlay("hide");
    }
//#endregion



//Inicio region Periodos

    function filtroperiodo(event){
        
        filtrar = $('#filtro_periodo').val().toUpperCase();
        if(filtrar.length >= 1){
            
            var as=$(myPeriodos).filter(function (i,n){
                   return n.periodo.indexOf(filtrar) >= 0;
            });
            
            loadUlPeriodos(as);
        }else{
            loadUlPeriodos(myPeriodos);
        }
    }
    

    function loadUlPeriodos(myperiodos){

        var string_ulperiodos = '<ul class="itemsubmenu">';
        var arrayRevP = [];
        var periodoload = null;
        //console.log("que llega en periodos",myperiodos);
        
        jQuery.each(myperiodos, function(i, val) {
            
            if(myperiodos[i].seleccionar === '1'){
               periodoload = myperiodos[i].periodo;
            }
            
            if(arrayRevP[myperiodos[i].periodo] === undefined){
                string_ulperiodos = string_ulperiodos+'<li class="sub-menu-item"><a id="submenuitem_periodo" name="'+myperiodos[i].periodo+'" >'+myperiodos[i].periodo+'</a></li>';
                arrayRevP[myperiodos[i].periodo] = '1';
            }
        });

        string_ulperiodos = string_ulperiodos+'</ul>';

        $( "#ulperiodos").html(string_ulperiodos);
        //setFilterData(periodo,codprovincia,dpacanton,codindicador,myAllData);
    }
    
    
    
    function selectPeri(event){
        
        $.LoadingOverlay("show");
            selectPeriodo = true;
            var periodosel = $(event.target).text();
            $("#periodos" ).text("Periodo: "+periodosel);
            periodo = event.target.name;

            if(selectProv === false && selectCanton === false && selectIndicador === false){
                $('#visibleespecificacion').show();
                $('#visiblefiltro').show();
            }

            if(setFilterData(periodo,codprovincia,dpacanton,codindicador,myAllData) === true){
               $('#subperiodo').toggleClass('visible');
                doloadCantones();
            }
         $.LoadingOverlay("hide"); 
        
    }



//fin region periodos


    
  //#Region LoadUL  ==========================================================================
  
   function loadUlProvincias(my_provincias){
       
        var string_ulprovincias = '<ul class="itemsubmenu">';
        var arrayRevP = [];
        latitudeProv = [];
        longitudeProv = [];
        
        jQuery.each(my_provincias, function(i, val) {
            if(arrayRevP[my_provincias[i].cod_provincia] === undefined){
                
                string_ulprovincias = string_ulprovincias+'<li class="sub-menu-item"><a id="submenuitem_prov" name="'+my_provincias[i].cod_provincia+'" >'+my_provincias[i].nombre_provincia+'</a></li>';
                latitudeProv[my_provincias[i].cod_provincia] = my_provincias[i].latcenter;
                longitudeProv[my_provincias[i].cod_provincia] = my_provincias[i].longcenter;
                
                arrayRevP[my_provincias[i].cod_provincia] = '1';
            }
        });

        string_ulprovincias = string_ulprovincias+'</ul>';
        $( "#ulprovincias").html(string_ulprovincias);
    }
    
    
    
    
    function loadUlCantones(my_cantones){

        var string_ulcantones = '<ul class="itemsubmenu">';
        var arrayRevC = [];
        
        jQuery.each(my_cantones, function(i, val) {
            if(arrayRevC[my_cantones[i].dpa_canton] === undefined){
                
                string_ulcantones = string_ulcantones+'<li class="sub-menu-item"><a id="submenuitem" name="'+my_cantones[i].dpa_canton+'" >'+my_cantones[i].nombre_canton+'</a></li>';
                arrayRevC[my_cantones[i].dpa_canton] = '1';
                
                latitudeCanton[my_cantones[i].dpa_canton] = my_cantones[i].latcenter;
                longitudeCanton[my_cantones[i].dpa_canton] = my_cantones[i].longcenter;
            }    
        });

        string_ulcantones = string_ulcantones+'</ul>';

        $( "#ulcantones").html(string_ulcantones);
    }
    
    
    
    function loadUlIndicadores(myindicadores){

        var string_ulindicadores = '<ul class="itemsubmenu">';
         var arrayRevI = [];
         
        jQuery.each(myindicadores, function(i, val) {
            if(arrayRevI[myindicadores[i].cod_indicador] === undefined){
                string_ulindicadores = string_ulindicadores+'<li class="sub-menu-item"><a id="submenuitem_indi" name="'+myindicadores[i].cod_indicador+'" >'+myindicadores[i].sigla+'</a></li>';
                arrayRevI[myindicadores[i].cod_indicador] = '1';
            }    
        });

        string_ulindicadores = string_ulindicadores+'</ul>';

       $( "#ulindicadores").html(string_ulindicadores);
    }
   
    function loadIdResultados(totalresultados){

        var imprimir = totalresultados+" Resultados Encontrados <a onclick='loadDynamicContentModal()' href='javascript:void(0)' class='btn-modal-target' id='btn-responsive'>Ver Lista</a>";
        $( "#visibleespecificacion").html(imprimir);
        
    }
    
  //Region acciones Seleccion =====================================================================================================================================  
 
 
    function selectProvincia(nomprovincia,cod_provincia){
       $.LoadingOverlay("show"); 
       
        selectProv = true;
        codprovincia = cod_provincia;
        dpacanton=null;
        codindicador = null;
        periodo = null;
        
        //Asignando nombre al filtro y menu lateral =============================================
        $("#provincias" ).text("Provincia: "+nomprovincia);
        
        //Eliminando Texto de otras versiones ===================================================
        $("#cantones" ).text("Cantones");
        $("#indicadores" ).text("Indicadores");
        $("#periodos" ).text("Periodos");
        
        //Centrando el mapa =====================================================================
        setCenterMap(latitudeProv[cod_provincia],longitudeProv[cod_provincia],8);
        oldZoom = 8;
        
        if(setFilterData(periodo,codprovincia,dpacanton,codindicador,myAllData) === true){
            
            // $("#cantones" ).text("Cantones");
            $('#visibleespecificacion').show();
            $('#visiblefiltro').show();
            $('#submenuprovincias').toggleClass('visible');
            doloadCantones();
           
        }
      
    }  
    
    
  
    
    const doloadCantones = async () => {
     await loadjsonCantonesAsync();
    }
    
    
    
    const loadjsonCantonesAsync = () => {
        
        if(viewCanton === false){
            
          map.removeLayer(vectorLayerProvincias);
          map.addLayer(vectorLayerCantones);
          vectorLayerCantones.setZIndex(1);

          //CAmbiando tipo de vista
          viewProvincia = false;
          viewCanton = true;
        }
        

        return new Promise(resolve => {
          setTimeout(() => resolve(rePaintCantones()), 3000)
        })
    }
    
    
    
    
    function rePaintCantones(){

        var features={};
        var featuresCantones = vectorCantones.getFeatures(); 
        repaint = true;
        
        
        
        //Se compara featureCantones contra cantonesPaint si no coinciden se despintan ====
        jQuery.each(featuresCantones, function(u, val) {
            
          //  console.log("aqui que llega de cantones ",featuresCantones[u].getProperties().DPA_CANTON);
            
            if($.inArray(featuresCantones[u].getProperties().DPA_CANTON.toString(), cantonesPaint ) === -1){
                featuresCantones[u].setStyle(cantonStyle);
            }else{
                featuresCantones[u].setStyle(defaultStyle); 
            }
        });

        
        //Retirando Makers ===========================================================
        features = vectorSource.getFeatures();

        jQuery.each(features, function(i, val) {
            if($.inArray(features[i].values_.nameicon, cantonesPaint ) === -1){
                 vectorMakers.getSource().removeFeature(features[i]);
            }
         });
        
        $.LoadingOverlay("hide");
    }
    
    
    
    function selectCant(event){
        
        $.LoadingOverlay("show");
            selectCanton = true;
            var cantonsel = $(event.target).text();
            $("#cantones" ).text("Cantón: "+cantonsel);
            $("#indicadores" ).text("Indicadores");
            $("#periodos" ).text("Periodos");

            if(selectProv === false){
                $('#visibleespecificacion').show();
                $('#visiblefiltro').show();
            }

            dpacanton = event.target.name;
            codindicador = null;
            periodo = null;
        
            if(setFilterData(periodo,codprovincia,dpacanton,codindicador,myAllData) === true){
                doloadCantones();
                setCenterMap(latitudeCanton[dpacanton],longitudeCanton[dpacanton],10);
                oldZoom = 10;
                $('#submenucantones').toggleClass('visible');  
            }
    }
    
    
    
    function setCantonStart(select_canton){
        
            $.LoadingOverlay("show");
            selectCanton = true;
            $("#cantones" ).text("Cantón: "+nombrecanton);
            
            if(selectProv === false){
                $('#visibleespecificacion').show();
                $('#visiblefiltro').show();
            }

            dpacanton = select_canton;
            
            if(setFilterData(periodo,codprovincia,dpacanton,codindicador,myAllData) === true){
                doloadCantones();
                setCenterMap(latitudeCanton[dpacanton],longitudeCanton[dpacanton],10);
                oldZoom = 10;
                //$('#submenucantones').toggleClass('visible');  
            }
    }
    

    
    function selectIndi(event){
        
        $.LoadingOverlay("show");
            selectIndicador = true;
            var indicadorsel = $(event.target).text();
            codindicador = event.target.name;
            periodo = null;
            
            $("#indicadores" ).text("Indicador: "+indicadorsel);
            $("#periodos" ).text("Periodos");

            if(selectProv === false && selectCanton === false){
                $('#visibleespecificacion').show();
                $('#visiblefiltro').show();
            }

            if(setFilterData(periodo,codprovincia,dpacanton,codindicador,myAllData) === true){
                doloadCantones();
                $('#subindicadores').toggleClass('visible');
            }
        
        
    }
    
    
    
 //#region filtro generales   
 
 
 function filtroprovincia(event){
    
     filtrar = $('#filtro_provincia').val().toUpperCase();

    if(filtrar.length >= 1){
        var as=$(myProvincias).filter(function (i,n){
            return n.nombre_provincia.indexOf(filtrar) >= 0;
         });
        loadUlProvincias(as);
    }else if(filtrar.length < 1){
        loadUlProvincias(myProvincias);
    }
 }
 
 
 
 function filtrocanton(event){
     
    filtrar = $('#filtro_canton').val().toUpperCase();

    if(filtrar.length >= 1){
       var as=$(myCantones).filter(function (i,n){
            return n.nombre_canton.indexOf(filtrar) >= 0;
         });
        loadUlCantones(as);
    }else if(filtrar.length < 1){
        loadUlCantones(myCantones);
    }
 }
 
 
 
  function filtroindicador(event){

    filtrar = $('#filtro_indicador').val().toUpperCase();

    if(filtrar.length >= 1){
       var as=$(myIndicadores).filter(function (i,n){
            return n.sigla.indexOf(filtrar) >= 0;
         });
        loadUlIndicadores(as);
    }else if(filtrar.length < 1){
        loadUlIndicadores(myIndicadores);
    }
 }
 
 //#enregion filtros
 
 
 
 //region Modal Window Resultados
 
 function loadDynamicContentModal() {
        
        $(".informationover" ).fadeOut();
        var ResultadosHtml = stringContentModal(null,0);
        $('#ventanaResultados').html(ResultadosHtml);
        $('#ventanaResultados').fadeIn(1500);
}


function closedinamicModal(){
    
    $('#ventanaResultados').fadeOut();
     $(".informationover" ).fadeIn(1500);
}

function changePageResultados(pagina,iteracion){
    var ResultadosHtml = stringContentModal(pagina, iteracion);
    $('#ventanaResultados').html(ResultadosHtml);
}



function stringContentModal(pagina, iteracion){
    
     var totalpagias = Math.ceil(resutadosstring/resultadosxpagina);
     var totallineas = pagina*resultadosxpagina;
     var iniciolineas = totallineas-(resultadosxpagina);
     var conteo=0;
     
   
        if(pagina !== null){
            
          htmlventana_Resultados="";
          jQuery.each(filterObjet, function(i, val) {
            if(conteo>=iniciolineas && conteo<totallineas){
                htmlventana_Resultados = htmlventana_Resultados+"<tr>";
                    htmlventana_Resultados = htmlventana_Resultados+'<td><a onmouseover style="cursor:pointer" onclick="goCanton(\''+filterObjet[i].dpa_canton+'\')" >'+filterObjet[i].nombre_provincia+'</a></td>';
                    htmlventana_Resultados = htmlventana_Resultados+'<td><a onmouseover style="cursor:pointer" onclick="goCanton(\''+filterObjet[i].dpa_canton+'\')" >'+filterObjet[i].nombre_canton+'</a></td>';
                    //htmlventana_Resultados = htmlventana_Resultados+'<td><a onmouseover style="cursor:pointer" onclick="goCanton(\''+filterObjet[i].dpa_canton+'\')" >'+filterObjet[i].prestador+'</a></td>';
                    htmlventana_Resultados = htmlventana_Resultados+'<td><a onmouseover style="cursor:pointer" onclick="goCanton(\''+filterObjet[i].dpa_canton+'\')" >'+filterObjet[i].sigla+'</a></td>';
                    htmlventana_Resultados = htmlventana_Resultados+'<td><a onmouseover style="cursor:pointer" onclick="goCanton(\''+filterObjet[i].dpa_canton+'\')" >'+filterObjet[i].periodo+'</a></td>';
                    htmlventana_Resultados = htmlventana_Resultados+'<td><a onmouseover style="cursor:pointer" onclick="goCanton(\''+filterObjet[i].dpa_canton+'\')" >'+filterObjet[i].valor+'</a></td>';
                htmlventana_Resultados = htmlventana_Resultados+"</tr>"
            }
            conteo =conteo +1;  
          });              
        }
             
        var stringResulTable = "<a onclick='closedinamicModal()' href='javascript:void(0)'>  <span class='glyphicon glyphicon-chevron-left'></span> Volver</a>";
            stringResulTable = stringResulTable+"<hr/>";
            stringResulTable = stringResulTable+"<div class='table-responsive'><table class='table tableresultados'>";
            stringResulTable = stringResulTable+"<thead>";
                stringResulTable = stringResulTable+"<tr>";
                    stringResulTable = stringResulTable+"<th colspan='5'> Resultados</th>";
                stringResulTable = stringResulTable+"</tr>";   
                stringResulTable = stringResulTable+"<tr>";
                     stringResulTable = stringResulTable+"<th>Provincia</th>";
                     stringResulTable = stringResulTable+"<th>Cantón</th>";
                     stringResulTable = stringResulTable+"<th>Indicador</th>";
                     stringResulTable = stringResulTable+"<th>Periodo</th>";
                     stringResulTable = stringResulTable+"<th>Valor</th>";
                stringResulTable = stringResulTable+"</tr>";    
            stringResulTable = stringResulTable+"</thead>";
            stringResulTable = stringResulTable+"<tbody>";
                stringResulTable = stringResulTable+htmlventana_Resultados;
            stringResulTable = stringResulTable+"</tbody>";
            stringResulTable = stringResulTable+"<tfoot>";
                stringResulTable =stringResulTable+"<tr><td colspan='5'>";
				if(pagina == undefined || pagina==null) pagina=1;
                if((iteracion+1)*resultadosxpagina>10) 
				    stringResulTable= stringResulTable+"<a href='javascript:void(0)' onclick='changePageResultados("+iteracion*resultadosxpagina+","+ (iteracion-1) +")'>Anterior</a> |";
                var valSiguiente='';
                for (var i=iteracion*resultadosxpagina+1;i<=(totalpagias);i++) {
                    if(i<=(iteracion+1)*resultadosxpagina)
					{
						if(i==pagina) stringResulTable = stringResulTable+"<a href='javascript:void(0)' onclick='changePageResultados("+i + "," +iteracion +")'> <text class='"+ "text-bold'>"+i+"</text></a> |";
						else stringResulTable = stringResulTable+"<a href='javascript:void(0)' onclick='changePageResultados("+i + "," +iteracion +")'> <text class='"+ "bold'>"+i+"</text></a> |";
					}
                    else 
                    {
                        valSiguiente=i;
                        i=totalpagias;
                    }
                }
                if(valSiguiente != '')
                    stringResulTable= stringResulTable+"<a href='javascript:void(0)' onclick='changePageResultados("+valSiguiente+","+ (iteracion+1) +")'>Siguiente</a> |";
                  
                stringResulTable =stringResulTable+"</td></tr>";
            stringResulTable = stringResulTable+"</tfoot>";
        stringResulTable = stringResulTable+"</table></div>";
    
    return stringResulTable;
}



 
 
 //endregion
 
 
 
 //Inicio Region filtro general =======================================================================================================================

    function reloadMakers(){
        if(repaint === true){
            map.removeLayer(vectorMakers);
                
            vectorSource = {};

            vectorSource = new ol.source.Vector({
                features: arrayMaker
            });

            vectorMakers = new ol.layer.Vector({
                id: 'makers',
                source: vectorSource
            });

            map.addLayer(vectorMakers);
            vectorMakers.setZIndex(2);
                
            repaint = false;  
            
        }
    }


    function setFilterData(periodo=null,provincia=null,canton=null,indicador=null,objeto=null,){
        
        console.log("se recibe "+provincia);
        reloadMakers();
    
        var val="";
        cantonesPaint=[];

        filterObjet = objeto;

         if(periodo !== null){ 
             filterObjet=$(filterObjet).filter(function (i,n){
                 val = n.anio.toString();
                 return (val === periodo);
                 //return val.indexOf(periodo) >= 0;
             });
         }

         if(provincia !== null){
             filterObjet=$(filterObjet).filter(function (i,n){
                 val = n.cod_provincia.toString();
                 return (val === provincia);
                // return val.indexOf(provincia) >= 0;
             });
         }

         if(canton !== null){
              filterObjet=$(filterObjet).filter(function (i,n){
                 val = n.dpa_canton.toString();
                 return (val === canton);
             });
         }

         if(indicador !== null){
             filterObjet=$(filterObjet).filter(function (i,n){
                 val = n.cod_indicador.toString();
                 return (val === indicador);
             });
         }

         
         var provincias = '[';
         var cantones = '[';
         var indicadores = '[';
         var periodos = '[';
         var orderperiodo=[];
         resutadosstring =0;
         htmlventana_Resultados="";

         
         jQuery.each(filterObjet, function(i, val) {

             if($.inArray(filterObjet[i].dpa_canton,cantonesPaint) === -1){
                 cantonesPaint.push(filterObjet[i].dpa_canton);
             }
             

            // provincias = provincias+'{"cod_provincia":"'+filterObjet[i].cod_provincia+'", "nombre_provincia": "'+filterObjet[i].nombre_provincia+'", "latcenter": "'+filterObjet[i].latcenter+'","longcenter": "'+filterObjet[i].longcenter+'" },';
             
             if(lastprovincia != codprovincia || lastprovincia == undefined){
                cantones = cantones+'{"cod_canton":"'+filterObjet[i].cod_canton+'","nombre_canton":"'+filterObjet[i].nombre_canton+'","latcenter":"'+filterObjet[i].latcabecera+'","longcenter":"'+filterObjet[i].longcabecera+'","cabecera":"'+filterObjet[i].nombre_cabecera+'","dpa_canton":"'+filterObjet[i].dpa_canton+'","cod_provincia":"'+filterObjet[i].cod_provincia+'"},'; 
             }

             if(lastcanton != dpacanton || lastprovincia != codprovincia || lastprovincia == undefined || lastcanton == undefined){
                indicadores = indicadores +'{"cod_indicador":"'+filterObjet[i].cod_indicador+'","sigla":"'+filterObjet[i].sigla+'","descripcion":"'+filterObjet[i].descripcion+'"},';
             }   

             if(lastindicador != codindicador || lastcanton != dpacanton || lastprovincia != codprovincia || lastprovincia == undefined || lastcanton == undefined || lastindicador == undefined){
                orderperiodo.push(filterObjet[i].anio);
             }   
                     
             if(resutadosstring < resultadosxpagina){
                 htmlventana_Resultados = htmlventana_Resultados+"<tr>";
                     htmlventana_Resultados = htmlventana_Resultados+'<td><a onmouseover style="cursor:pointer" onclick="goCanton(\''+filterObjet[i].dpa_canton+'\')" >'+filterObjet[i].nombre_provincia+"</a></td>";
                     htmlventana_Resultados = htmlventana_Resultados+'<td><a onmouseover style="cursor:pointer" onclick="goCanton(\''+filterObjet[i].dpa_canton+'\')" >'+filterObjet[i].nombre_canton+'</a></td>';
                     htmlventana_Resultados = htmlventana_Resultados+'<td><a onmouseover style="cursor:pointer" onclick="goCanton(\''+filterObjet[i].dpa_canton+'\')" >'+filterObjet[i].sigla+'</a></td>';
                     
                    //Se asigna nuevo periodo ===========================================================================================
                    htmlventana_Resultados = htmlventana_Resultados+'<td><a onmouseover style="cursor:pointer" onclick="goCanton(\''+filterObjet[i].dpa_canton+'\')" >'+filterObjet[i].periodo+'</a></td>';
                    htmlventana_Resultados = htmlventana_Resultados+'<td><a onmouseover style="cursor:pointer" onclick="goCanton(\''+filterObjet[i].dpa_canton+'\')" >'+filterObjet[i].valor+'</a></td>';
                 htmlventana_Resultados = htmlventana_Resultados+"</tr>"; 
             }

             resutadosstring = resutadosstring+1;
             

         });

         
       // provincias = provincias.substr(0,provincias.length-1);
       // provincias = provincias+']';
       // myProvincias = JSON.parse(provincias);
        loadUlProvincias(myProvincias);

        console.log("Comparativo Provincias "+lastprovincia+"::"+codprovincia);

        if(lastprovincia != codprovincia || lastprovincia == undefined){
            cantones = cantones.substr(0,cantones.length-1);
            cantones = cantones+']';
            myCantones = JSON.parse(cantones);
            loadUlCantones(myCantones);
        }

        if(lastcanton != dpacanton || lastprovincia != codprovincia || lastprovincia == undefined || lastcanton == undefined){
            indicadores = indicadores.substr(0,indicadores.length-1);
            indicadores = indicadores+']';
            myIndicadores = JSON.parse(indicadores);
            loadUlIndicadores(myIndicadores);
        }    

        if(lastindicador != codindicador || lastcanton != dpacanton || lastprovincia != codprovincia || lastprovincia == undefined || lastcanton == undefined || lastindicador == undefined){
            setperiodo = orderperiodo.sort();
            jQuery.each(setperiodo, function(u, valor) { 
                  periodos = periodos+'{"periodo":"'+setperiodo[u]+'"},';
            });
            periodos = periodos.substr(0,periodos.length-1);
            periodos = periodos+']';
            myPeriodos = JSON.parse(periodos);
            loadUlPeriodos(myPeriodos);
        }    
         
        loadIdResultados(resutadosstring);
        
        
        lastprovincia=provincia;
        lastcanton=canton;
        lastindicador=indicador;
        lastperiodo=periodo;
         
        return true;
    }
    
    
    function loadData(objeto=null){
        
        var provincias = '[';

        
        jQuery.each(objeto, function(i, val) {
            provincias = provincias+'{"cod_provincia":"'+objeto[i].cod_provincia+'", "nombre_provincia": "'+objeto[i].nombre_provincia+'", "latcenter": "'+objeto[i].latcenter+'","longcenter": "'+objeto[i].longcenter+'" },';
        });
       
        provincias = provincias.substr(0,provincias.length-1);
        provincias = provincias+']';
        myProvincias = JSON.parse(provincias);
        loadUlProvincias(myProvincias);
        
        return true;
    }

    function setFooter(objeto,indicador=null,year=null, iteracion){
        
        if(indicador !== null){
             objeto=$(objeto).filter(function (i,n){
                 val = n.sigla.toString();
                 return (val === indicador);
             });
        }
        
        
        var string_f_indicador='';
        var string_f_year='';
        var string_f_table='<thead><tr><th>Cantón</th><th>Provincia<th>Valor</th></tr></thead>';
        
        var vIndicadores=[];
        var vPeriodos=[];
        var ordentabla=[];
      
        
        //Saca los indicadores del objeto principal ===========================================================================
        jQuery.each(myIndicadores, function(i, val) { 
           if($.inArray(myIndicadores[i].sigla,vIndicadores) === -1){
               
                if(myIndicadores[i].sigla === indicador){
                    string_f_indicador = string_f_indicador+"<option value='"+myIndicadores[i].sigla+"' selected >"+myIndicadores[i].sigla+"</option>";
                }else{
                    string_f_indicador = string_f_indicador+"<option value='"+myIndicadores[i].sigla+"'>"+myIndicadores[i].sigla+"</option>";
                } 
               vIndicadores.push(myIndicadores[i].sigla);
           }
          
        });
        
        //Saca los periodos de objeto_periodo ================================================================================
        jQuery.each(objeto, function(i, val) {
           if($.inArray(objeto[i].anio,vPeriodos) === -1){ 
             vPeriodos.push(objeto[i].anio);
           }
        });
        
        
        //Ordenando Años ====================================================================
        vPeriodos = vPeriodos.sort().reverse();
        
        jQuery.each(vPeriodos, function(i, val) { 
            
            if(year === null && i===0){
                year = vPeriodos[i].toString();
            }else if(year !== null && indicador_old != indicador && i===0){
                year = vPeriodos[i].toString();
            }
            
            if(vPeriodos[i].toString() === year){
                string_f_year = string_f_year+"<option value='"+vPeriodos[i]+"' selected>"+vPeriodos[i]+"</option>";
            }else{
                 string_f_year = string_f_year+"<option value='"+vPeriodos[i]+"'>"+vPeriodos[i]+"</option>";
            }
        });
        
              
        //Sacando tabla de resultados =============================================================
        if(year !== null){
             objeto=$(objeto).filter(function (i,n){
                 val = n.anio.toString();
                 return (val === year);
             });
        }
        
        objeto.sort(function(a, b) {
            return b.valor_su - a.valor_su;
        });
        
          
        dataTable = objeto;
        totalJsonF = dataTable.length;
        totalPagesF = Math.ceil(totalJsonF/filasFooterTable);
        
        jQuery.each(objeto, function(i, val) {
            if(i<filasFooterTable){
                
                if(objeto[i].valor_su === null || objeto[i].valor_su === undefined){
                    objeto[i].valor_su = '- Sin datos suficientes';
                }
                
                string_f_table = string_f_table+"<tr><td>"+objeto[i].nombre_canton+"</td><td>"+objeto[i].nombre_provincia+"</td><td>"+objeto[i].valor_su+" "+objeto[i].messfr+"</td></tr>";
            }
        });
        
        string_f_table = string_f_table+"<tr><td colspan='3'>";

        if((iteracion+1)*resultadosxpagina>10) 
            string_f_table = string_f_table+"<a onmouseover style='cursor:pointer'  onclick='changepageFotter("+iteracion*resultadosxpagina+","+ (iteracion-1) +")'>Anterior</a> | ";
		//if(page==null || page==undefined) page=1;
        var valSiguiente='';
            for (i = iteracion*resultadosxpagina+1; i <= (totalPagesF); i++) {
                if(i<=(iteracion+1)*resultadosxpagina)
				{
					if(i==1)
						string_f_table = string_f_table+"<a onmouseover style='cursor:pointer'  onclick='changepageFotter("+i + "," +iteracion +")'> <text class='"+ "text-bold'>"+i+"</text></a> | ";
					else 
						string_f_table = string_f_table+"<a onmouseover style='cursor:pointer'  onclick='changepageFotter("+i + "," +iteracion +")'> <text class='"+ "bold'>"+i+"</text></a> | ";
				}
                else 
                {
                    valSiguiente=i;
                    i=totalPagesF;
                }
            }
            if(valSiguiente != '')
                string_f_table = string_f_table+"<a onmouseover style='cursor:pointer'  onclick='changepageFotter("+valSiguiente+","+ (iteracion+1) +")'>Siguiente</a> | ";
        string_f_table = string_f_table+"</td></tr>";
        
        indicador_old = indicador;
        
        $('#indicador_footer').html(string_f_indicador);
        $('#year_footer').html(string_f_year);
        $('#tablefooter').html(string_f_table);
    }
    
 

    function changepageFotter(page, iteracion){

        var string_f_table='<thead><tr><th>Cantón</th><th>Provincia<th>Valor</th></tr></thead>';
        totalPagesF = Math.ceil(totalJsonF/filasFooterTable);
        filasPageFin = (filasFooterTable*page);
        filasPageInicio = (filasFooterTable*page)-filasFooterTable;
        
        if(filasPageFin>totalJsonF){
             filasPageFin1 = totalJsonF;
         }
        
        for (i = filasPageInicio; i < (filasPageFin); i++) {
            
             if(dataTable[i].valor_su === null || dataTable[i].valor_su === undefined){
                   dataTable[i].valor_su = '- Sin datos suficientes';
             }
            
             string_f_table = string_f_table+"<tr><td>"+dataTable[i].nombre_canton+"</td><td>"+dataTable[i].nombre_provincia+"</td><td>"+dataTable[i].valor_su+" "+dataTable[i].messfr+"</td></tr>";
        }
        
        string_f_table = string_f_table+"<tr><td colspan='3'>";
            if((iteracion+1)*resultadosxpagina>10) 
                string_f_table = string_f_table+"<a onmouseover style='cursor:pointer'  onclick='changepageFotter("+iteracion*resultadosxpagina+","+ (iteracion-1) +")'>Anterior</a> | ";
			if(page==null || page==undefined) page=1;
            var valSiguiente='';
            for (i = iteracion*resultadosxpagina+1; i <= (totalPagesF); i++) {
                if(i<=(iteracion+1)*resultadosxpagina)
				{
					if(i==page)
					string_f_table = string_f_table+"<a onmouseover style='cursor:pointer'  onclick='changepageFotter("+i + "," +iteracion +")'> <text class='"+ "text-bold'>"+i+"</text></a> | ";
				    else 
						string_f_table = string_f_table+"<a onmouseover style='cursor:pointer'  onclick='changepageFotter("+i + "," +iteracion +")'> <text class='"+ "bold'>"+i+"</text></a> | ";
				}
                else 
                {
                    valSiguiente=i;
                    i=totalPagesF;
                }
            }
            if(valSiguiente != '')
                string_f_table = string_f_table+"<a onmouseover style='cursor:pointer'  onclick='changepageFotter("+valSiguiente+","+ (iteracion+1) +")'>Siguiente</a> | ";

            /*for (i = 1; i <= (totalPagesF); i++) {
                if(i<=10)
                string_f_table = string_f_table+"<a onmouseover style='cursor:pointer' onclick='changepageFotter("+i+")'>"+i+"</a> | ";
            }*/
        string_f_table = string_f_table+"</td></tr>";
        
        $('#tablefooter').html(string_f_table);
        
    }
    
    function changeFooterFilter(){
        
        var indicador_foot = $('#indicador_footer').find(":selected").text();
        var year_foot = $('#year_footer').find(":selected").text();
        
        setFooter(indicadoresFooter,indicador_foot,year_foot,0);
        
    }
    
    
    
    
/***********************************************PARA LA TABLA DE RANKING *************************************************/    
    
    function setFooter2(objetorank,year=null){
         
        var string_rank_year='';  
        var str_rank_table='<thead><tr><th>Item</th><th>Cantón</th><th>Prestador</th><th>Valor</th><th>Desempeño</th></tr></thead>';
        var start;
       
        
        //Sacando Periodos (anios) ============================================================================
        jQuery.each(objetorank['anios'], function(y, val) { 
            if(year === null && y===0){
                year = objetorank['anios'][y].toString();
            }else{
                year = year.toString();
            }
            
            if(objetorank['anios'][y].toString() === year){
                string_rank_year = string_rank_year+"<option value='"+objetorank['anios'][y]+"' selected>"+objetorank['anios'][y]+"</option>";
            }else{
                string_rank_year = string_rank_year+"<option value='"+objetorank['anios'][y]+"'>"+objetorank['anios'][y]+"</option>";
            }
        });
        
        //Sacando listao de ranking ============================================================================
          
        //console.log("que llega en objeto ",objetorank['ranking']);
          
        dataTable1 = objetorank['ranking'];
        totalJsonF1 = dataTable1.length;
        totalPagesF1 = Math.ceil(totalJsonF1/filasFooterTable);
          
        jQuery.each(objetorank['ranking'], function(u, val) {
            if(u<filasFooterTable){
                str_rank_table = str_rank_table+"<tr><td>"+(u+1)+"</td><td>"+objetorank['ranking'][u].canton+"</td><td>"+objetorank['ranking'][u].prestador+"</td>";
                str_rank_table = str_rank_table+"<td>"+objetorank['ranking'][u].valor+"</td>";
                str_rank_table = str_rank_table+"<td>"+createStart(objetorank['ranking'][u])+"</td></tr>";
            }
        });
        
        
        str_rank_table = str_rank_table+"<tr><td colspan='5'>";

        for (v = 1; v <= (totalPagesF1); v++) {
            if(v<=10)
			{
				if(v==1)
					str_rank_table = str_rank_table+"<a onmouseover style='cursor:pointer'  onclick='changepageFotterRank("+v+")'><text class='"+ "text-bold'>"+v+"</text></a> | ";
				else
					str_rank_table = str_rank_table+"<a onmouseover style='cursor:pointer'  onclick='changepageFotterRank("+v+")'>"+v+"</a> | ";
			}
            
        }
        str_rank_table = str_rank_table+"</td></tr>";   
        $('#year_ranking').html(string_rank_year);
        $('#tablefooterRank').html(str_rank_table);
    }


    function changepageFotterRank(page){
        
         var str_rank_table='<thead><tr><th>Item</th><th>Cantón</th><th>Prestador</th><th>Valor</th><th>Desempeño</th></tr></thead>';
         totalPagesF1 = Math.ceil(totalJsonF1/filasFooterTable);
         filasPageFin1 = (filasFooterTable*page);
         filasPageInicio1 = (filasFooterTable*page)-filasFooterTable;
         
         if(filasPageFin1>totalJsonF1){
             filasPageFin1 = totalJsonF1;
         }
         
         for (w = filasPageInicio1; w < (filasPageFin1); w++) {
                str_rank_table = str_rank_table+"<tr><td>"+(w+1)+"</td><td>"+dataTable1[w].canton+"</td><td>"+dataTable1[w].prestador+"</td>";
                str_rank_table = str_rank_table+"<td>"+dataTable1[w].valor+"</td>";
                str_rank_table = str_rank_table+"<td>"+createStart(dataTable1[w])+"</td></tr>";
        }
        
        str_rank_table = str_rank_table+"<tr><td colspan='5'>";
            for (x = 1; x <= (totalPagesF1); x++) {
                if(x<=10)
				{
					if(x==page)
						str_rank_table = str_rank_table+"<a onmouseover style='cursor:pointer' onclick='changepageFotterRank("+x+")'> <text class='"+ "text-bold'>"+ x+"</text></a> | ";
					else 
						str_rank_table = str_rank_table+"<a onmouseover style='cursor:pointer' onclick='changepageFotterRank("+x+")'>"+ x+"</a> | ";
				}
                
            }
        str_rank_table = str_rank_table+"</td></tr>";
        
        $('#tablefooterRank').html(str_rank_table);
         
    }
    
    
    function createStart(setStart){
        
        var start = '<div class="cuadrado" style="background-color:'+setStart.color+'">'+setStart.nom_categoria+'</div>';
        start = start + '<div class="estrellas">';
        for (i = 0; i < setStart.cant_estrellas; i++) {
            start = start + '<div class="shield__container"><div class="container__star"></div></div>';
        }
        start = start + '</div>';
        start = start + '&nbsp;&nbsp;'; 
        
         //start = start + setStart.nom_calificacion;                --- ESTA ERA LA PALABRA EFICIENTE
               
        
        return start;
    }
    
    
    function changeFooterFilterRank(){
        
        var year_rank = $('#year_ranking').find(":selected").text();
        
        //Recargando objeto ===============================================================================
        getRanking(year_rank).done(function(objRanking) {
             myRanking = JSON.parse(objRanking);
             setFooter2(myRanking,year_rank);
        });
    }
    
    function getRanking(year){
        var today = new Date();
        var url = "http://"+window.location.hostname+(window.location.port ? ':'+window.location.port: '')+window.location.pathname+'?r=site/loadranking';

        return $.ajax({
                data:  "anio="+year,
                url:   url,
                type:  'get'
        });
    }
    
   
//Cargue total de la pagina

$(document).ready(function() {
   
    
    //#region Cargas Iniciales a los div de provincias y cantones
    myAllData = JSON.parse(allDataObjt);
    indicadoresFooter = myAllData;
    
    if(startcanton === '0'){
        loadData(myAllData);
        setFilterData(null,null,null,null,myAllData);
    }else{
        setCantonStart(startcanton);
    }   
    
    setFooter(indicadoresFooter,indicadoresFooter[0].sigla,null,0);
    
    
    myRanking = JSON.parse(ranking);
    setFooter2(myRanking);
    
//    myPeriodos = JSON.parse(periodosObjt);
//    loadUlPeriodos(myPeriodos);
//    $('#filtro_periodo').val("");
   
    
    //#region filtros
    $( "#filtro_periodo" ).keyup(function(event) {
            filtroperiodo(event);
    });
    
    
    $( "#filtro_provincia" ).keyup(function(event) {
            filtroprovincia(event);
    });
    
    $( "#filtro_canton" ).keyup(function(event) {
            filtrocanton(event);
    });
    
    $( "#filtro_indicador" ).keyup(function(event) {
            filtroindicador(event);
    });
    
    //endregion filtros
    
    
    //#region eventos al Click para provincias y cantones (solo para la caja overlay)
    $('.menu-featured-categories').click(function(event) {
        descripcionEventClick(event);
    });
    //#endregion
    
});