Vue.component('modal',{





    template: //html



    `    

    <div class="modal is-active p-2">   

        <div class="modal-background" style="background-color:#000000d9 !important"></div>

            <div class="modal-dialog modal-lg modal-dialog-centered modal-info">

                <div class="modal-content ">

                    <form v-on:submit.prevent>

                        <div class="modal-header justify-content-center">

                            <img src="./img/logo-modal.png">                            

                        </div> 

                        <div class="modal-body">

                            <div class="mb-3">

                                <label for="usuario" class="form-label">Usuario:</label>

                                <input type="text" class="form-control" v-model="uname" name="uname" id="usuario" autocomplete="off">

                            </div>

                            <div class="mb-3">

                                <label for="pass" class="form-label">Contraseña:</label>

                                <input type="password" class="form-control" v-model="psw" name="psw" id="pass" autocomplete="off">

                            </div>

                        </div>

                        <div class="modal-footer">

                            <button class="btn btn-primary" type="submit" :disabled=" loading_btn == true "  @click="getConsulta">

                                <template v-if="loading_btn">

                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>

                                    Cargando...

                                </template>   

                                <template v-else>

                                    Ingresar

                                </template>   

                            </button>

                        </div>                        

                    </form>

                </div>

            </div>

        </div>   

    </div>   

    `,

    data() {

        return{

            uname:'',

            psw:'',

            loading_btn:false

        }

    },

    methods:{

        getConsulta(){

            this.loading_btn = true

            if( this.uname!='' &&  this.psw!=''){

                const token = 'WMSAS00498-984B-5BCC-123C-AC22B47E4CD4-token'

                let params = {

                    user: this.uname,

                    pass : this.psw,

                };

                axios.post("https://18.223.105.203/development/sge/basic/api/web/v1/sgelecturas/searchuser", params ,{

                    headers: { 

                        'Authorization': `Bearer ${token}`

                    }

                }).then((res) => {

                    if(res.data){

                        if(res.data[3]==0){

                            swal("Sin Registros!", "Usuario no tiene registros el dia de hoy!", "error");

                        this.loading_btn = false

                        }else{  

                            this.$emit('verifica',false)

                            this.$emit('cargardatos_mes',res.data)

                            this.$emit('cargardatos_dia',res.data)

                        }

                    }else{

                        swal("Error de ingreso!", "Usuario o contraseña incorrectos!", "error");

                        this.loading_btn = false

                    }                    

                });

            }else{

                swal("Error de ingreso!", "Ingrese un usuario y contraseña!", "error");

                this.loading_btn = false                

            }

        }

    }



})