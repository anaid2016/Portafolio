Vue.component('m-ahorro',{
    template: //html
    `    
    <div class="modal is-active p-2">   
        <div class="modal-background " style="background-color:#000000d9 !important"></div>
            <div class="modal-dialog my-modal-ahorra modal-dialog-centered modal-info">
                <div class="modal-content m-content-ahorra m-0">
                  <div class="modal-header">
                   <h2><img src="./img/wmsas.png" class="img-thumbnail rounded" width="40px"> Tips para ahorrar energia <a href="https://www.semana.com/tecnologia/tips/articulo/12-tips-para-ahorrar-energia-pagar-menos-su-recibo-luz/374082-3/" target="_blank">(Fuente)</a></h2>
                    <button class="delete" aria-label="close" @click="cerrar"></button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                        <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-ride="carousel">
                        <div class="carousel-inner">
                          <div class="carousel-item" :class="item.active" v-for="(item,index) in datos_carrusel" :key="item.id">
                            <img src="./img/f-ahorra.jpg" class="d-block w-100 rounded" alt="...">
                            <div class="carousel-caption rounded bg-dark-modal p-3">
                              <p>{{ index+1 }}. {{ item.texto }}</p>
                            </div>
                          </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-target="#carouselExampleCaptions" data-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="sr-only">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-target="#carouselExampleCaptions" data-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="sr-only">Next</span>
                        </button>
                      </div>                        
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>   
    </div>   
    `,
    props:['dialog','vector_dia'],
    data() {
        return{
          datos_carrusel:[
            {'texto': 'No deje los equipos, que se manejan con bater??a, conectados mucho tiempo. Nada m??s ench??felos por el tiempo necesario para cargar la bater??a.','active':'active'},
            {'texto': 'Si vive en tierra caliente, procure prender los ventiladores, en vez del aire acondicionado, estos gastan menos energ??a.','active':false},
            {'texto': 'Mantenga desenchufados todos los cargadores. Aunque no est??n cargando nada y parezcan apagados, siguen consumiendo energ??a.','active':false},
            {'texto': 'Nunca deje su televisor en modo de ???Sleep??? o su computador en ???Reiniciar??? pues siguen consumiendo mucha energ??a y de forma continua.','active':false},
            {'texto': 'Compre bombillos que ahorran energ??a. Estos tambi??n le har??n ahorrar dinero cuando le llegue su factura de la luz.','active':false},
            {'texto': 'Mantenga desenchufados los aparatos el??ctricos que no use muy seguido, sobre todo si vas a salir.','active':false},
            {'texto': 'Cuando no vaya a lavar una cantidad relevante de ropa, lo mejor es que use ciclos de lavados cortos y haga uso de aguda fr??a.','active':false},
            {'texto': 'Apague las luces cuando no las est?? usando.','active':false},
            {'texto': 'Si va a calentar la comida, en vez de usar la estufa o el horno el??ctrico, haga uso del microondas. Este calienta la comida m??s r??pido.','active':false},
            {'texto': 'Intente lavar el m??ximo de ropa que pueda en una sola lavada, esto con la idea de no estar usando a cada nada la lavadora que consume mucha energ??a.','active':false},
            {'texto': 'Mientras no est?? usando su computador, apague el monitor o pantalla.','active':false},
            {'texto': 'Si puede conectar la mayor??a de electrodom??sticos a una misma toma, es mejor. Puede conectar una multitoma a un s??lo enchufe y de hay conectar la mayor cantidad de electrodom??sticos posible.','active':false}
          ]
        }
    },
    methods:{
      cerrar() {
        this.$emit("close");
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
    }

})