<script>
    import PaymentForm from '../components/PaymentForm.vue'
    export default {
      name: "PayOrder",
      data () {

          return {
              datosMonto : {
                'monto' : '',
                'destino' : '',
                'frecuencia' : '',
                'periodo_veces' :''
              }
          }
      },
      components : {
         PaymentForm
      },
      methods : {
            enviar_solicitud_cobro () {

                let self = this
                let url = self.url
                let regexPhoneNumber = /^\d{10}$/
                let regexEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                let destino = self.datosMonto.destino

                //Si se ingreso un número telefónico
                if ( destino.match(regexPhoneNumber) ) {
                   self.datosMonto.tipo = 'numero'
                }else{
                   //Si se ingresa un correo electrónico
                   if ( destino.match(regexEmail) ) {
                     self.datosMonto.tipo = 'correo'
                   }else{
                    //  console.log('El dato no hace match con ninguna de las expresiones');
                   }
                }

                //console.log(self.datosMonto)
                self.datosMonto.sucursal_id = 5;
                self.datosMonto.vendedor_id = 2;
                self.datosMonto.nombre_vendedor = 'Mario Godínez'
                self.datosMonto.nombre_sucursal = 'Calzada Independencia'

                axios.post(url+'/vendedores/enviar-monto', self.datosMonto)
                     .then(response=>{

                          if ( response.data.success == true && respon.data.status == 200) {

                               self.datosMonto.monto = ''
                               sel.datosMonto.correo_usuario = ''
                               alert(response.data.msg)

                          }else {
                             let msg = processStrJson(response.data.msg)
                             if (msg != '') {
                               alert(msg)
                             }
                          }

                     })
                     .catch(error=>{
                        console.log(error)
                     })

            }

      },
      mounted () {

          this.url = $("#url-location").data("url")

      }
    }
</script>

<style lang="css">
</style>



<template lang="html">
  <section>
    <PaymentForm :datosMonto="datosMonto"></PaymentForm>
    <h1></h1>
    <p>Monto a cobrar:</p><input type="text" v-model="datosMonto.monto" placeholder="$ Monto a cobrar"></br>
    <p>Correo electrónico/celular:</p><input type="email" v-model="datosMonto.destino" placeholder="Correo electrónico/celular">
    <div><p>frecuencia</p><input type="text" id="frecuencia" name="" value="" v-model="datosMonto.frecuencia"></div>
    <div><p>periodo veces:</p><input type="text" id="periodo_veces" name="" value="" v-model="datosMonto.periodo_veces"></div>
    <input type="button" value="ENVIAR" @click="enviar_solicitud_cobro()">
  </section>
</template>
