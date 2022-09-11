Vue.component('m-graficad',{
    extends: VueChartJs.Bar,
    props:['vector_dia'],
    methods:{
        getdata(){
          try{
          this.renderChart({
            labels: this.vector_dia.Fechas,        
            datasets: [
              {
                label: 'Consumo de Energia',
                backgroundColor: 'green',
                data: this.vector_dia.Costos
              }
            ]
          }, 
          {            
            scales: { //hides the y axis
              yAxes: [{
                  scaleLabel: {
                    display: true,
                    labelString: 'Costo Diario'
                  },
                  ticks: {
                    beginAtZero: true,
                    callback: function(value, index, values) {
                      if(parseInt(value) >= 1000){
                        return '$' + value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                      } else {
                        return '$' + value;
                      }
                    }
                  }                  
              }],
              xAxes: [{
                  scaleLabel: {
                    display: true,
                    labelString: 'Dias'
                  }
              }]
           },
           tooltips: {
              callbacks: {
                label: function(t, d) {
                    var yLabel = t.yLabel >= 1000 ?
                        '$' + t.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") :
                        '$' + t.yLabel;
                    return yLabel+' COP';
                }
            }            
           }
          }, {responsive: true, maintainAspectRatio: false})
        }catch(err){
          console.log(err)
        }
      }
    },
    mounted(){
      this.getdata()
    }

})