Vue.component('m-estadisticas',{
    template: //html
    `    
    <div class="modal is-active p-2">   
        <div class="modal-background " style="background-color:#000000d9 !important"></div>
            <div class="modal-dialog my-modal modal-dialog-centered modal-info">
                <div class="modal-content m-content m-0">
                  <div class="modal-header">
                    <h2><img src="./img/wmsas.png" class="img-thumbnail rounded" width="40px"> Estadisticas de Consumo</h2>
                    <button class="delete" aria-label="close" @click="cerrar"></button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="card">
                          <div class="card-header">
                            <strong>Costo Energía (4 Ultimos Meses)</strong>
                          </div>
                          <div class="card-body">
                            <m-graficam :vector_mes="vector_mes" :height="300"></m-graficam>                       
                          </div>
                          </div>
                          </div>     
                          <div class="col-lg-6">
                          <div class="card">
                          <div class="card-header">                          
                          <strong>Costo Energía (6 Ultimos Dias)</strong>
                          </div>
                          <div class="card-body">
                            <m-graficad :vector_dia="vector_dia" :height="300"></m-graficad>                       
                          </div>
                        </div>                                              
                      </div>     
                    </div>
                  </div>
                </div>
            </div>
        </div>   
    </div>   
    `,
    props:['dialog','vector_dia','vector_mes'],
    data() {
        return{
         
        }
    },
    computed: {
      show: {
        get() {
          return this.dialog;
        },
        set(value) {
          if (!value) {
            this.$emit("close");
          }
        },
      },
    },
    methods:{
     
      cerrar() {
        this.$emit("close");
      },      

    },created(){
    }

})