Vue.component('m-config',{
    template: //html
    `    
    <div class="modal is-active p-2">   
        <div class="modal-background " style="background-color:#000000d9 !important"></div>
            <div class="modal-dialog modal-lg modal-dialog-centered modal-info">
                <div class="modal-content">
                  <div class="modal-header">
                    <h2><img src="./img/wmsas.png" class="img-thumbnail rounded" width="40px"> Configuración</h2>
                    <button class="delete" aria-label="close" @click="cerrar"></button>
                  </div>
                  <div class="modal-body">
                      <div class="col-lg-12 d-flex justify-content-center" v-if="preload">
                        <div class="spinner-grow" role="status">
                        </div>
                      </div>
                      <div class="col-lg-12" v-else>
                        <form>                       
                          <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="cfecha" v-model="checkp">
                            <label class="form-check-label" for="cfecha">Cambiar Lectura siguiente Periodo</label>
                          </div>
                          <div class="form-group row">
                            <label for="flectura" class="col-sm-6 col-form-label">Fecha de Lectura (dia: 1-30):</label>
                            <div class="col-sm-6">
                              <select class="form-control" id="flectura" :disabled="!checkp" v-model="flectura">
                                <option v-for="item of 30" :value="item">{{ item }}</option>
                              </select>
                            </div>
                          </div>      
                          <hr/> 
                          <div class="form-group row">
                            <label for="preciomensual" class="col-sm-6 col-form-label">Precio kWh Mensual: $</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" id="preciomensual" v-model="preciomensual">
                            </div>
                          </div>                           
                          <div class="form-group row">
                            <label for="alertd" class="col-sm-6 col-form-label">Limite de Alerta Diaria(kWh):</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" id="alertd" v-model="alertd">
                            </div>
                          </div>                           
                          <div class="form-group row">
                            <label for="alertm" class="col-sm-6 col-form-label">Limite de Alerta Mensual(kWh):</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" id="alertm" v-model="alertm">
                            </div>
                          </div>   
                          <hr/>                        
                          <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="hcorreo" v-model="checke">
                            <label class="form-check-label" for="hcorreo">Habilitar correo</label>
                          </div>   
                          <div class="form-group row">
                            <label for="email" class="col-sm-6 col-form-label">Correo Electronico para Alertas:</label>
                            <div class="col-sm-6">
                              <input type="email" class="form-control" id="email" :disabled="!checke" v-model="correo">
                            </div>
                          </div>                                                  
                        </form>   
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrar">Cancelar</button>
                    <button type="button" class="btn btn-primary" @click="savedata">Configurar</button>
                  </div>
                </div>
            </div>
        </div>   
    </div>   
    `,
    props:['dialog','vector_dia'],
    data() {
        return{
          checkp:false,
          checke:false,
          preload:true,
          flectura:0,
          preciomensual:'',
          correo:'',
          alertd:'',
          alertm:'',
        }
    },
    methods:{
      cerrar() {
        this.$emit("close");
      },      
      async getdata(){
        try{
          let datosget = await axios.get(
            "funciones/configuraciones.php",{
              params: {
                  vector: this.vector_dia
              }                
            }
          );
          this.preload = false
          this.flectura=datosget.data[9]
          this.preciomensual=datosget.data[10]
          this.alertd=datosget.data[11]
          this.alertm=datosget.data[12]
        }catch(err){
          console.log(err)
        }
      },
      savedata(){
        if(this.preciomensual=='' || this.preciomensual==0){
          swal({
            title: "Campos vacios!",
            text: "Precio Mensual debe ser mayor a cero",
            icon: "error",
            button: "Aceptar",
          });
        }else if(this.alertd=='' || this.alertd==0){
          swal({
            title: "Campos vacios!",
            text: "Limite de alerta diaria debe ser mayor a cero",
            icon: "error",
            button: "Aceptar",
          });
        }else if(this.alertm=='' || this.alertm==0){
          swal({
            title: "Campos vacios!",
            text: "Limite de alerta menusal debe ser mayor a cero",
            icon: "error",
            button: "Aceptar",
          });          
        }else{
        axios.get(
        "funciones/configurar-save.php",{
          params: {
              vector: this.vector_dia,
              checkp: this.checkp,
              fecha: this.flectura,
              precio: this.preciomensual,
              alertd: this.alertd,
              alertm: this.alertm,
              checke: this.checke,
              correo: this.correo,
          }                
        }).then((res) => {
          if(res.data=='ok'){
            swal({
              title: "Excelente!",
              text: "Cambios Realizados con Exito",
              icon: "success",
              button: "Aceptar",
            });  
            this.$emit("close");
          }
        })
      }
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
    created(){
      this.getdata()
    }

})