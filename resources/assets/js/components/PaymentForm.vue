<script>
    export default {
      name: "PaymentForm",
      data () {

          return {
              tarjeta : {
                'nombre_titular' : '',
                'no_tarjeta' : '' ,
                'anio_expiracion_tarjeta' : '',
                'mes_expiracion_tarjeta' : '',
                'codigo_seguridad' : '',
              },
              token_id : '',
              device_session_id : '',
              objetoRequest : {},
              url : ''

          }
      },
      props: ['datosMonto'],
      methods : {

            sendData () {
                let self = this
                let url = self.url
                //  let validateCard = OpenPay.card.validateCardNumber(self.tarjeta.no_tarjeta)
                //  let validateCVC = OpenPay.card.validateCVC(self.tarjeta.codigo_seguridad)
                //  let validateExpiry = OpenPay.card.validateExpiry(self.tarjeta.mes_expiracion_tarjeta, self.tarjeta.anio_expiracion_tarjeta)
                 //
                //  console.log(validateCard)
                //  console.log(validateCVC)
                //  console.log(validateExpiry)

                 //Funcion call back success
                let onSuccess = response => {
                     //Se obtiene el tokend id
                    //  console.log(response)
                    self.token_id = response.data.id

                     //Creamos objetoRequest
                    self.objetoRequest.sucursal_id = 5
                    self.objetoRequest.nombre_sucursal = "Calzada Independencia"
                    self.objetoRequest.vendedor_id = 2
                    self.objetoRequest.solicitud_cobro_id = 11
                    self.objetoRequest.nombre_vendedor = 'Mario Godínez'
                    self.objetoRequest.nombre_titular = self.tarjeta.nombre_titular
                    self.objetoRequest.correo_usuario = 'saca_las_panochas@hotmail.com'//self.datosMonto.destino
                    self.objetoRequest.monto = 8500.00//self.datosMonto.monto_cobrar
                    self.objetoRequest.token_id = self.token_id
                    self.objetoRequest.device_session_id = self.device_session_id
                    self.objetoRequest.no_tarjeta = self.tarjeta.no_tarjeta
                    self.objetoRequest.codigo_seguridad = self.tarjeta.codigo_seguridad
                    self.objetoRequest.mes_expiracion_tarjeta = self.tarjeta.mes_expiracion_tarjeta
                    self.objetoRequest.anio_expiracion_tarjeta = self.tarjeta.anio_expiracion_tarjeta

                     //console.log(self.objetoRequest)
                     //Realizamos peticion ajax
                    axios.post(url +'/vendedores/generar-pago' ,  self.objetoRequest)
                        .then(response => {
                            if ( response.data.succes == true && response.data.status == 200) {
                                 alert( response.data.msg );

                            }else{
                                let msg = processStrJson(response.data.msg)
                                if (msg != '') {
                                    alert(msg)
                                }
                            }
                        })
                        .catch(error => {
                            if (error.status == 404) {
                                console.log(error)
                            }
                        })
                }


                 //Funcion call back  error
                let onError = response => {
                    console.log(response)
                    let error = {
                       "status" : response.status,
                       "message" : response.message,
                       "description" : response.data.description,
                       "request_id" : response.data.request_id
                    }

                    alert('Status: '+ error.status + ' ' + 'Descripción: '+ error.description)

                }

                 //Creamos token de tarjeta
                OpenPay.token.extractFormAndCreate($("#processCard"), onSuccess , onError)

            }

      },
      mounted () {

            let id_openPay   = $('#openpay').data("openpay_id")
            let mode_sandbox = $('#openpay').data("openpay_mode_sandbox")
            let apiKey       = $("#openpay").data("openpay_public_key")

            OpenPay.setId( id_openPay )
            OpenPay.setApiKey( apiKey )
            OpenPay.setSandboxMode( mode_sandbox )

            this.device_session_id = OpenPay.deviceData.setup()

            this.url = $("#url-location").data("url")

      }
    }
</script>

<style lang="css">
</style>



<template lang="html">
    <form  @submit.prevent="sendData()" id="processCard" name="processCard">
      <h1>Test Form</h1>
      <p>Holder Name:</p><input data-openpay-card="holder_name" size="50" type="text" v-model="tarjeta.nombre_titular" placeholder="Nombre del titular">
      <p>Card number:</p><input data-openpay-card="card_number" size="50" type="text" v-model="tarjeta.no_tarjeta" placeholder="Número de tarjeta">
      <p>Expiration year:</p><input data-openpay-card="expiration_year" size="4" type="text" v-model="tarjeta.anio_expiracion_tarjeta" placeholder="AA">
      <p>Expiration month:</p><input data-openpay-card="expiration_month" size="4" type="text" v-model="tarjeta.mes_expiracion_tarjeta" placeholder="MM">
      <p>cvv2:</p><input data-openpay-card="cvv2" size="5" type="text" v-model="tarjeta.codigo_seguridad" placeholder="CVV2">
      <input type="submit" value="Crear Tarjeta">
    </form>
</template>
