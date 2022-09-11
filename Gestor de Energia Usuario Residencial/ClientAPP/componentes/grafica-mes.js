Vue.component('m-graficam',{
    extends: VueChartJs.Bar,
    props:['vector_mes'],
    methods:{
      async getdata(){
        try{
          this.renderChart({
            labels: this.vector_mes.Fechas,        
            datasets: [
              {
                label: 'Consumo de Energia',
                backgroundColor: 'green',
                data: this.vector_mes.Costos
              }
            ]
          },
          {            
            scales: { //hides the y axis
              yAxes: [{
                  scaleLabel: {
                    display: true,
                    labelString: 'Costo Mensual'
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
                    labelString: 'Meses'
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