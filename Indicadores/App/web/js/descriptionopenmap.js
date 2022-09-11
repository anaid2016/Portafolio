/*Inicializacion del Mapa*/
var arrayMaker = []; 
var oldZoom = 7;
var ulrRef = window.location.href;
ulrRef = ulrRef.replace(/[#\s]/g, ''); 

var map = new ol.Map({
    target: 'mapid',
    layers: [
      new ol.layer.Tile({
        source: new ol.source.OSM()
      }),
    ],
    view: new ol.View({
      center: ol.proj.fromLonLat([-78.183403, -1.831239]),
      zoom: 7
    })
  });
  
/*Fin Inicializaciones*/


/*================================================================STILOS =================================================================*/

var defaultStyle = new ol.style.Style({
                    fill: new ol.style.Fill({
                        color: [238, 182, 96, 0.4]
                    }),
                    stroke: new ol.style.Stroke({
                        color: [236, 157, 37, 1],
                        width: 0.8,
                        lineCap: 'round'
                    }),
                    zIndex: 2
                  });
                  

var cantonStyle = new ol.style.Style({
            stroke: new ol.style.Stroke({
                        color: [236, 157, 37, 1],
                        width: 0.8,
                        lineCap: 'round'
            }),
            fill: new ol.style.Fill({
              color: [255,255,255,0.2]
            }),
            zIndex: 1
        });


//========================================================PARA HIGHLIGHT =========================================================//
var highlightStyleCache = {};
var featureOverlay = new ol.layer.Vector({
       source: new ol.source.Vector(),
       map: map,
       style: function (feature, resolution) {
          // console.log("que es resolucion "+resolution);
           var text = resolution < 1300 ? feature.getProperties().DPA_DESCAN:'';
           highlightStyleCache[text] = new ol.style.Style({
                   stroke: new ol.style.Stroke({
                                    color: [236, 157, 37, 1],
                                    width: 0.8,
                                    lineCap: 'round'
                   }),
                   fill: new ol.style.Fill({
                          color: [255,255,255,0.5]
                   }),
                   text: new ol.style.Text({
                       font: '12px Calibri,sans-serif',
                       text: text,
                       overflow: false,
                       fill: new ol.style.Fill({
                           color: '#000'
                       }),

                   }),
                   zIndex: 3,
               });
           return highlightStyleCache[text];
       }
   });
   
var highlight;
var displayFeatureInfo = function (pixel) {
    var feature = map.forEachFeatureAtPixel(pixel, function (feature) {
        return feature;
    });


      
    if (feature !== highlight) {
        
        if (highlight) {
            featureOverlay.getSource().removeFeature(highlight);
        }
        if (feature) {
            //console.log("Entra en dispaly aqui 2"+feature);
            featureOverlay.getSource().addFeature(feature);
        }
        highlight = feature;
    }

};

/*======================================================================VECTORES ===========================================================*/



/*Vector para cantones*/
var vectorCantones = new ol.source.Vector({
  url: 'openlayers/geojson/cantones.geojson',
  format: new ol.format.GeoJSON(),
});

var vectorLayerCantones = new ol.layer.Vector({
    id: 'cantones',
    source: vectorCantones,
    style: defaultStyle
});
/*Fin Vector Cantones*/


/*Vector para provincias*/
var vectorProvincias = new ol.source.Vector({
  url: 'openlayers/geojson/provincias.geojson',
  format: new ol.format.GeoJSON()
});

var vectorLayerProvincias = new ol.layer.Vector({
    id: 'provincias',
    source: vectorProvincias,
});
/*Fin Vector Provincias*/



/*============================CARGANDO MAKERS==============================================================================================*/
/*Load Makers*/
var myMarkers = JSON.parse(cantonesObjt);
jQuery.each(myMarkers, function(i, val) {
  
   var longitude = myMarkers[i].longcenter;
   var latitude = myMarkers[i].latcenter;
   
   if(longitude != ""){
       
    var iconFeature = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.transform([longitude, latitude], 'EPSG:4326', 'EPSG:3857')),
        nameicon: myMarkers[i].dpa_canton.toString()
    });

    //src: "http://cdn.mapmarker.io/api/v1/pin?text=P&size=50&hoffset=1"
    
    var iconStyle = new ol.style.Style({
        image: new ol.style.Icon(({
            anchor: [0.5, 0.5],
            src: "img/marker_map.svg"
        })),
        zIndex: 2
    });

    iconFeature.setStyle(iconStyle);
    arrayMaker.push(iconFeature);
    
   }
});

var vectorMakers = new ol.source.Vector({
    features: arrayMaker
});

var vectorMakers = new ol.layer.Vector({
    id: 'makers',
    source: vectorMakers
});


/*Cierre load Makers*/


//==========================================OVERLAYS CLIC ON MAKERS==========================================================================//

/*Clic on Makers*/

var container = document.getElementById('popup');
var content = document.getElementById('popup-content');
var closer = document.getElementById('popup-closer');

var overlay = new ol.Overlay({
     element: container,
     autoPan: true,
     autoPanAnimation: {
         duration: 250
     }
 });
 map.addOverlay(overlay);


 closer.onclick = function() {
     overlay.setPosition(undefined);
     closer.blur();
     return false;
 };


var featureListener = function (event,feature,dpa_canton,nombre_icono) {

    console.log("que llega en canton "+dpa_canton);
    if (map.hasFeatureAtPixel(event.pixel) === true) {
       
       var coordinate = event.coordinate;
       var htmlbubble = '<p>';
       htmlbubble = htmlbubble+'<p>Estos Indicadores están ubicados en '+nombre_icono;
       htmlbubble = htmlbubble+'.</p><button onclick="goCanton(\''+dpa_canton+'\')" class="botonpopup" >Ver Perfil Cantón</button>';
  
       content.innerHTML = htmlbubble;
       overlay.setPosition(coordinate);
   } else {
       overlay.setPosition(undefined);
       closer.blur();
   }
};

function goCanton(dpa_canton){
    var urlref= ulrRef+"?r=indicadores/cantones/canton&dpa_canton="+dpa_canton.toString();
    window.location.href = urlref;
}
/*Cierre Clic on Makers*/


/*==================================================================ANIMATION ZOOM ====================================================*/


/*Funcion para cambio segun el  zoom*/
/*var currZoom = map.getView().getZoom();
map.on('moveend', function(e) {
    
    var newZoom = map.getView().getZoom();
    console.log("que llega de "+newZoom+ "--"+oldZoom);
    
    if(newZoom >= 10 && oldZoom<10){
        
        map.removeLayer(vectorLayerProvincias);
        map.addLayer(vectorLayerCantones);
        vectorLayerCantones.setZIndex(1);
        
       // vectorLayerCantones.set('selectable', true);
    }else if(newZoom < 10 && oldZoom>=10){
        
        map.removeLayer(vectorLayerCantones);
        map.addLayer(vectorLayerProvincias);
        vectorLayerProvincias.setZIndex(1);
      //  vectorLayerProvincias.set('selectable', true);
    }
    
    oldZoom = newZoom;
});*/

/*Cierre de acciones con zoom*/


/*======================================================EVENTO DE CLIC POR FAVOR NO BORRAR EL EVENTO LAYER SE NECESITARIA MAS ADELANTE ============*/

/*singleClick sobre el mapa*/
var nombreicono = "";
map.on('click', function(event) {
    
     map.forEachFeatureAtPixel(event.pixel, function(feature) {
   
        if (feature.get('nameicon') !== undefined ) {
            
            jQuery.each(myMarkers, function(i, val) {
                
                if(myMarkers[i].dpa_canton == feature.get('nameicon') ){
                    nombreicono =  myMarkers[i].nombre_canton;
                }    
                
            });
            console.log("que llega en 2 "+feature.get('nameicon'));
            featureListener(event,feature,feature.get('nameicon'),nombreicono);
        }
     });
    
    /*map.forEachLayerAtPixel(event.pixel, function(layer) {
        var id = layer.get('id');
    });*/
});

/*Fin del maker*/


/*===================================================EVENTO ON MOUSE OVER =============================================================*/

map.on('pointermove', function(evt) {
    
    if (evt.dragging) {
      return;
    }
    var pixel = map.getEventPixel(evt.originalEvent);
    displayFeatureInfo(pixel);
});

/*=========================================================LAYERS INICIALES =======================================================*/
map.addLayer(vectorLayerCantones);
map.addLayer(vectorMakers);
vectorLayerCantones.setZIndex(1);
vectorMakers.setZIndex(2);





//vectorLayerProvincias.set('selectable', true);
//map.getInteractions().extend([selectInteraction]);