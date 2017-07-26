<?php

namespace App\Http\Controllers\Vendedor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Vendedor\MsgErrorController;
use App\Http\Controllers\RandomStrController;
use Openpay;


//Models
use App\Models\Pago;
use App\Models\PagoDetalles;
use App\Models\MetodoEnvio;
use App\User;
use App\Models\CorreoSolicitudCobro;
use App\Models\ClienteFrecuenciaDetalle;

use App\Providers\AppServiceProvider;

class VendedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
    * Metodo para enviar correo al usuario de que se realizó una solicitus de cobro
    */
    public function enviar_monto(Request $request)
    {
        // dd($request->all());
        $success = false;
        $msg = '';
        $correo_solicitud_cobro_response = '';
        $token = '';
        //$pago_response = '';
        $array = array('required');

        if( $request->ajax() ) {

            $rules = [
              'monto' => ['required','numeric','regex:/^\d+(\.\d{1,2})?$/'],
              'destino' => $array,
              'frecuencia' => 'integer',
              'periodo_veces' => 'integer'
            ];

            $rulesMsg = [
              'destino.required' => 'Ingrese el correo electrónico o número telefónico a quien se enviará la solicitud de cobro',
              'monto.required'=> 'El monto es obligatorio.',
              'monto.numeric' => 'El valor del monto ingresado no es válido.',
              'monto.regex' => 'El formato del monto ingresado no es válido. Sólo se aceptan dos decimales.',
              'frecuencia.integer' => 'El valor de la frecuencia debe ser un número entero.',
              'periodo_veces.integer' => 'El valor del periodo debe ser un número entero.'
            ];

            if ( $request->input('tipo') == 'correo'  ) {
                //  $rules['destino'] = 'required|max:255|email';
                 array_push($array, 'max:255', 'email');
                 $rulesMsg['destino.email'] = 'El formato del correo no es válido.';
            }elseif ( $request->input('tipo') == 'numero') {
                //  $rules['destino'] = 'required|digits:10';
                 array($array, 'digits:10');
                 $rulesMsg['destino.digits'] = 'El límite de dígitos para el número telefónico es de :digits';
            }

            $validation = \Validator::make($request->all(), $rules, $rulesMsg);
            if( $validation->fails() ){
                //Enviar errores encontrados
                return response()->json([
                    'success'       => false,
                    'msg'           => $validation->getMessageBag()->toArray(),
                ]);
            }

            $data = [
                'correo_usuario' => $request->input('destino'),
                'nombre_sucursal' => $request->input('nombre_sucursal')
            ];


            //Enviamos correo al usuario
            $correo_response =  $this->enviar_correo($data);

            if( $correo_response['success'] == true ){

              //Guardamos datos del correo que se ha enviado
              try {

                  $str_random = new RandomStrController;
                  $token = $str_random->randString(15, false, false, true);

                  $correo_sc = new CorreoSolicitudCobro;
                  $correo_sc->branch_office_id = $request->input('sucursal_id');
                  $correo_sc->user_id = $request->input('vendedor_id');
                  $correo_sc->buyer_email = $request->input('destino');
                  $correo_sc->user_name = $request->input('nombre_vendedor');
                  $correo_sc->iva_amount = config('iva.iva');
                  $correo_sc->amount = $request->input('monto');
                  $correo_sc->status = 1;
                  $correo_sc->period_time = $request->input('periodo_veces');
                  $correo_sc->frecuency = $request->input('frecuencia');
                  $correo_sc->payment_request_token = $token;

                  if ( $correo_sc->save() ) {
                       $cliente_fd = new ClienteFrecuenciaDetalle;
                       $cliente_fd->payment_request_id = $correo_sc->id;
                       $cliente_fd->email_sent = 1;
                       $cliente_fd->save();
                  }
                  $msg = $correo_response['msg'];

              } catch (Exception $e) {
                  $msg = 'ERROR: ' . $e->getMessage();
              }

            }
            else{

                $msg = $correo_response['msg'];
            }
        }

        return compact('msg', 'success');
    }


    /**
     * Metodo para enviar correo a usuario
     */
    public function enviar_correo ($data = [])
    {
        $success         = false;
        $msg             = '';
        $correo_vendedor = 'vendedor@gmail.com';//env('EMAIL_VENDEDOR', '');//se generaran cuentas para el dominio de unexpect
        //dd( $correo_vendedor, $data);
        $mensaje = 'La sucursal '. $data['nombre_sucursal'] .' de Marisa® ha enviado una solicitud de cobro para usted.
                    Para realizar el pago ingrese dando click en el siguiente botón';
        //Enviamos correo
        try{
            Mail::send('email_solicitud_cobro.solicitud_cobro', ['mensaje' => $mensaje ], function ($m)  use($correo_vendedor, $data){
                $m->from($correo_vendedor, 'Vendedor Marisa')
                  ->to($data['correo_usuario'], 'Israel Alejandro')
                  ->subject('Solicitud de cobro Marisa');
            });

            if( count(Mail::failures()) > 0){
                $msg = 'No se envió el correo, intenta nuevamente';
            }
            else{
                $msg = 'Correo enviado correctamente';
                $success = true;
            }

        }catch (\Exception $e) {
            $msg = 'ERROR AL ENVIAR EL MAIL: '. $e->getMessage();
        }

        return compact('msg', 'success');
    }


    /**
     * Metodo que genera el pago con openpay
     */
    public function generar_pago (Request $request)
    {
        //dd($request->all());
        $success = false;
        $msg = [];
        $codigo_error = '';
        $infix = '';
        $openpay_sucursal = null;
        $numero_sucursal = 0;
        $error = false;
        $pago_detalles_id = '';
        $patron = '';

        if ( $request->ajax() )
        {

            $tipo_tarjetas = [
               'visa' => '(4\d{12}(?:\d{3})?)',
               'amex' => '(3[47]\d{13})',
               'mastercard' => '(5[1-5]\d{14})'
            ];

            $patron = "/^(?:".implode("|", $tipo_tarjetas).")$/";

            $rules = [
              'sucursal_id' => 'required|integer|exists:sucursales,id',
              'nombre_sucursal' => 'required|string',
              'vendedor_id' => 'required|integer|exists:users,id',
              'solicitud_cobro_id' => 'required|integer|exists:correos_solicitud_cobro,id',
              'nombre_titular' => ['required','string', 'max:50','regex:/^[A-zA-Zñáéíóú\s]+$/'],
              'correo_usuario' => 'required|max:255|email',
              'monto' => ['required','numeric','regex:/^\d+(\.\d{1,2})?$/'],
              'token_id' => 'required',
              'device_session_id' => 'required|string',
              'no_tarjeta' => ['required', 'regex:'. $patron, 'digits:16'],
              'codigo_seguridad' => 'required|integer|digits_between:3,4',
              'mes_expiracion_tarjeta' => 'required|integer|digits:2',
              'anio_expiracion_tarjeta' => 'required|integer|digits:2'
            ];

            $rulesMsg = [
              'sucursal_id.exists' => 'El id de sucursal seleccionado no es válido',
              'sucursal_id.required' => 'Se require el id de la sucursal.',
              'nombre_sucursal.required' => 'El nombre de la sucursal es obligatorio.',
              'nombre_sucursal.string' => 'El formato del nombre de la sucursal no es válido.',
              'vendedor_id.required' => 'Se require el id del vendedor.',
              'nombre_titular.required' => 'El nombre del titular es obligatorio.',
              'nombre_titular.regex' => 'El formato del nombre del titular no es válido.',
              'correo_usuario.required' => 'El correo de usuario es obligatorio.',
              'correo_usuario.email' => 'El formato del correo de usuario no es válido.',
              'monto.required' => 'El monto es obligatorio.',
              'monto.numeric' => 'El valor del monto no es válido.',
              'monto.regex' => 'El formato del valor del monto no es válido.',
              'token_id.required' => 'El id del token de la tarjeta es obligatorio.',
              'device_session_id.required' => 'El id de sesion del dispositivo es obligatorio.',
              'no_tarjeta.required' => 'El número de tarjeta es obligatorio.',
              'no_tarjeta.regex' => 'El formato del número de tarjeta no es válido.',
              'codigo_seguridad.required' => 'El código de seguridad es obligatorio.',
              'codigo_seguridad.digits' => 'El número de dígitos del código de seguridad es de:digits.',
              'codigo_seguridad.integer' => 'El valor del código de seguridad no es válido.',
              'mes_expiracion_tarjeta.required' => 'El mes de expiración de la tarjeta es obligatorio.',
              'mes_expiracion_tarjeta.digits' => 'El número de dígitos del mes de expiración de la tarjeta es de:digits.',
              'mes_expiracion_tarjeta.integer' => 'El valor del mes de expiración de la tarjeta no es válido.',
              'anio_expiracion_tarjeta.required' => 'El año de expiración de la tarjeta es obligatorio.',
              'anio_expiracion_tarjeta.digits' => 'El número de dígitos del año de eexpiración de la tarjeta es de:digits.',
              'anio_expiracion_tarjeta.integer' => 'El valor del año de expiración de la tarjeta no es válido.'
            ];



            $validation = \Validator::make($request->all(), $rules, $rulesMsg);
            if( $validation->fails() ){
                //Enviar errores encontrados
                return response()->json([
                    'success'       => false,
                    'msg'           => $validation->getMessageBag()->toArray(),
                ]);
            }


            $numero_sucursal = $request->input('sucursal_id');
            //Obtenemos sucursales registradas en Openpay del archivo de configuracion
            $openpay_sucursales = collect(config('openpay_sucursales.sucursales'));
            $openpay_sucursal = $openpay_sucursales->get('default');
            // if( $openpay_sucursales->has($numero_sucursal)) {
            //    $openpay_sucursal = $openpay_sucursales->get($numero_sucursal);
            // }
            // else{
            //    //Obtenemos de momento la sucursal por default
            //    $openpay_sucursal = $openpay_sucursales->get('default');
            // }

            //Calculamos subtotal e iva
            $monto_total = $request->input('monto');
            $iva = config('iva.iva');
            $subtotal = ($monto_total / (1 + ($iva)));
            $monto_iva = ($subtotal * $iva);
            //$total= $subtotal + $monto_iva;

            if ( $monto_total <= 0 ) {
                return response()->json([
                     'success'   => false,
                     'msg'       => 'El total debe ser mayor a 0, por favor verifique.',
                ]);
            }

            //Obtenemos metodo de envio (Se comento el fragmento de codigo por situaciones futuras)
            $metodo_envio = MetodoEnvio::where('cost', '=', 0)
                        ->orderBy('id', 'DESC')
                        ->first();

            $costo_envio         = $metodo_envio->cost;
            $nombre_metodo_envio = $metodo_envio->name_es;

            //Redondear monto a dos decimales
            $monto_total = round($monto_total, 2);

            $pago_exitoso = false;
            $pago_id     = '';

            $method       = 'card';
            $metodo_pago   = 'OpenPay';
            $currency     = 'MXN';
            $description  = config('app.name').' - Venta Terminal Móvil'. $metodo_pago;

            //Guardamos el pago en la base de datos
            $pago = new Pago;
            $pago->branch_office_id = $request->input('sucursal_id');
            $pago->user_id = $request->input('vendedor_id');
            $pago->payment_request_id = $request->input('solicitud_cobro_id');
            $pago->user_name = $request->input('nombre_vendedor');
            $pago->email_client = $request->input('correo_usuario');
            $pago->method = $method;
            $pago->pay_method = $metodo_pago;
            $pago->shipping_method_id = 0;//$metodo_envio->id;
            $pago->subtotal = round($subtotal, 2);
            $pago->iva_amount = round($monto_iva, 2);
            $pago->iva_percent = config('iva.iva');
            $pago->shippingamt = 0.00;
            $pago->amount = $monto_total;
            $pago->currency = $currency;
            $pago->description = $description;
            $pago->ip_adress = $request->getClientIp();


            if( $pago->save() ) {

                $datos_sucursal = [
                    'id' => $request->input('sucursal_id'),
                    'name' => $request->input('nombre_sucursal'),
                    'email' => $openpay_sucursal['email'],
                ];

                $pago_detalles = new PagoDetalles;
                $pago_detalles->payment_id = $pago->id;
                $pago_detalles->method = $metodo_pago;
                $pago_detalles->device_session_id = $request->input('device_session_id');

                //Por el momento la aplicacion no cuenta con el uso de meses sin intereses y planes de pago
                $pago_detalles->msi = null;
                $pago_detalles->payment_plan = null;

                if ( $pago_detalles->save() ) {
                     $pago_detalles_id = $pago_detalles->id;
                }else{
                     $msg[] = 'No se crearon lo datos del cargo.';
                }


                try {

                      //Creamos instancia de Openpay
                      OpenPay::setProductionMode(!$openpay_sucursal['mode_sandbox']);
                      $openpay = OpenPay::getInstance($openpay_sucursal['id'], $openpay_sucursal['private_key']);

                      //Payload con los datos del cliente
                      $cliente = [
                        'name' => $pago->user_name,
                        'phone_number' => 'Ninguno',
                        'email' => $pago->email_client
                      ];

                      if( $openpay_sucursal['mode_sandbox'] ) {
                          $infix = $openpay_sucursal['infix'];
                      }


                      $cargoRequest = [
                          'method' => $method,
                          'source_id' => $request->input('token_id'),//token proveniente del front-end
                          'amount' => $monto_total,
                          'currency' => $currency,
                          'description' => $description,
                          'order_id' => $openpay_sucursal['str_orden_id'].$infix.'-'.str_random(6),
                          'device_session_id' => $request->input('device_session_id'),//device_session_id proveniente del front-end
                          'customer' => $cliente
                      ];

                      $cargo = $openpay->charges->create($cargoRequest);
                      $fecha_cargo = date_create($cargo->creation_date);
                      $fecha_cargo = date_format($fecha_cargo , 'Y-m-d H:i:s');

                      if ( $cargo->status == 'completed') {
                           $pago_exitoso = true;
                      }
                      else{
                        // No hace nada
                      }


                      $pago_detalles->issuing_bank = $cargo->card->bank_name;
                      $pago_detalles->card_type = $cargo->card->type;
                      $pago_detalles->autorization = $cargo->authorization;
                      $pago_detalles->external_creation_date = $fecha_cargo;
                      $pago_detalles->customer_id = $cargo->customer_id;
                      $pago_detalles->status = $cargo->status;
                      $pago_detalles->transaction_type = $cargo->transaction_type;
                      $pago_detalles->external_id = $cargo->id;

                      //Guardamos los detalles del pago
                      if( $pago_detalles->save() ) {
                          //

                      }else{
                        $msg[] = 'No se actualizaron los datos del cargo.';
                      }

                    } catch (OpenpayApiTransactionError $e) {
                        $codigo_error = true;
                        $this->error_pago('OpenpayApiTransactionError', $e, $request, $datos_sucursal, $pago, $pago_detalles, $pago_exitoso, $msg);
                    } catch (OpenpayApiRequestError $e) {
                        $codigo_error = true;
                        $this->error_pago('OpenpayApiRequestError', $e, $request, $datos_sucursal, $pago, $pago_detalles, $pago_exitoso, $msg);
                    } catch (OpenpayApiConnectionError $e) {
                        $codigo_error = true;
                        $this->error_pago('OpenpayApiConnectionError', $e, $request, $datos_sucursal, $pago, $pago_detalles, $pago_exitoso, $msg);
                    } catch (OpenpayApiAuthError $e) {
                        $codigo_error = true;
                        $this->error_pago('OpenpayApiAuthError', $e, $request, $datos_sucursal, $pago, $pago_detalles, $pago_exitoso, $msg);
                    } catch (OpenpayApiError $e) {
                        $codigo_error = true;
                        $this->error_pago('OpenpayApiError', $e, $request, $datos_sucursal, $pago, $pago_detalles, $pago_exitoso, $msg);
                    } catch (Exception $e) {
                        $codigo_error = true;
                        $this->error_pago('Exception', $e, $request, $datos_sucursal, $pago, $pago_detalles, $pago_exitoso, $msg);
                    }

                 //Se generó el pago en Openpay pero puede que no haya sido exitoso . Verificamos que el cargo
                 //se haya efectuado correctamente con el metodo status
                 if ( $pago_exitoso == true ) {

                    if ( $cargo->status == 'completed') {

                         $pago_exitoso = true;

                         $pago_id = $pago->id;

                         $nombre_cliente = $request->input('nombre_titular');

                         $total_letra = \NumeroALetras::convertir($monto_total, 'pesos', 'centavos');
                         $total_letra = '('.$total_letra . ' 00/100 PESOS M.N.'.')';

                         $datos_ticket = [
                            'ver_imprimir'        => true,
                            'msg'                 => 'TICKET DE PAGO',
                            //'pago_id'             => $pago_id,
                            'nombre_cliente'      => $nombre_cliente,
                            'email_cliente'       => $pago->email_client,
                            'description'         => $pago->description,
                            'telefono'            => 'Ninguno',
                            'fecha'               => $cargo->creation_date,
                            //'costo_envio'         => $costo_envio,
                            'monto_impuesto'      => $pago->iva_amount,
                            'subtotal'            => $pago->subtotal,
                            'monto_total'         => $monto_total,
                            'total_letra'         => $total_letra,
                            'nombre_metodo_envio' => $nombre_metodo_envio,
                            'external_id'         => $cargo->id,
                            'metodoPago'          => $metodo_pago,
                            'requiere_factura'    => 'No',//$request->input('requiere_factura'),
                            'vendedor'            => $pago->user_name,
                            'sucursal'            => $datos_sucursal,
                         ];


                         $pago->status_id = 3;
                         $pago->status_name = $cargo->status;
                         $pago->external_creation_date = $fecha_cargo;

                         //Finalmete guardamos el pago
                         if ( $pago->save() ) {
                              //dd('El pago se ha efectuado con éxito!');

                              //$vista_ticket = $this->generar_ticket($datos_ticket);
                              $datos_ticket['ver_imprimir'] = false;

                              //Enviamos correo con el TICKET
                              $correo_ticket = $this->enviar_correo_ticket($datos_ticket);
                              if( !empty($correo_ticket['msg']) and $correo_ticket['success'] == true){
                                  $success = true;
                                  $msg[] = $correo_ticket['msg'];
                              }

                              //$vista_ticket = $this->generar_ticket($datos_ticket);

                         }else{
                           $msg[] = 'El cargo se efectuó pero no cambió el status en la Base de Datos, contacte al administrador.';
                         }

                    }else{
                       // No se completó el cargo
                       $msg[] = 'No se completó el cargo. Status:'.$cargo->status;
                    }
                }
                elseif ( $error == false ) {
                    $this->error_pago($titulo_exception='ExceptionCharge', $e='', $request, $datos_sucursal, $pago, $pago_detalles, $pago_exitoso, $msg);
                }

            }else{
              $msg[] = 'La orden no se guardó, no se hizo ningún cobro, intenta nuevamente';
            }

        }

        return compact('msg', 'success');//anexar $vista ticket
    }


    /**
     * Metodo que controla las excepciones al momento de un error de pago
     */
    public function error_pago ($titulo_exception='Exception', $e, $request, $datos_sucursal=null, $pago=null, $pago_detalles=null, $pago_exitoso=false, $msg)
    {
        if ( $titulo_exception == 'Exception' ) {
            $codigo_error = 'Hubo un problema con el código';
        }elseif ( $titulo_exception == 'ExceptionCharge') {
            $codigo_error = 'El cargo no se realizó';
        }
        else{
            $codigo_error = $e->getErrorCode();
        }

        $tarjeta_temporal = $request->input('no_tarjeta');
        $pago_id_temporal = '';

        if ( strlen($tarjeta_temporal) > 4) {
             $tarjeta_temporal = substr($tarjeta_temporal, -4);
        }

        if (isset($pago) and $pago) {
            $pago_id_temporal = $pago->id;
        }

        $datos_error = "Error: ".$codigo_error."\nCliente: ".$request->input('nombre_titular')."\nNo.Tarjeta: ".$tarjeta_temporal."\nPago ID: ".$pago_id_temporal."\n";

        if ( $datos_sucursal ) {

             $datos_error.="Sucursal ".$datos_sucursal['id'].": ".$datos_sucursal['name']."\n";
        }


        try {

            Mail::raw($datos_error . $titulo_exception .': '.($e), function($message)use($datos_sucursal){
               $subject = config('app.name').' - Terminal Movil Marisa - Error Venta';
               if( $datos_sucursal ){
                   $subject.=' '.$datos_sucursal['name'];
               }
               //Enviar al cliente
               $message->to(config('mail.mail_report'), config('name_mail_report'))
                       ->subject($subject);
            });


        } catch (Exception $e) {

        }

        if ( $titulo_exception == 'Exception' ) {

          $msg[] = $codigo_error;

        }else{

          $response = new MsgErrorController;
          $response->codigo = $codigo_error;
          $msg[] = $response->msgErrorOpenPay();

        }


        if ( isset($pago_detalles) and $pago_detalles  ) {

           if ( $titulo_exception == 'Exception' or $titulo_exception == 'ExceptionCharge' ) {

              $pago_detalles->string_error = $codigo_error;

           }else{

              $pago_detalles->string_error = $response->msgErrorOpenPay();
           }

        }

        if ( isset($pago) and $pago and $pago_exitoso == false) {

           $pago->delete();

        }

        if( isset($ordenPagoDetails) and $ordenPagoDetails and $pago_exitoso==false ) $ordenPagoDetails->delete();
    }


    /**
     * Metodo que renderiza la vista del ticket
     */
    // public function generar_ticket ($datos_ticket)
    // {
    //   return view('terminal_movil.ticket', compact('datos_ticket'));
    //    return view('terminal_movil.ticket', [
    //        'data' => $datos_ticket,
    //    ])->render();
    // }


    /**
     * Metodo que envia correo al cliente con los datos del ticket generado por el pago
     */
    public function enviar_correo_ticket ($datos_ticket)
    {

        $msg = '';
        $success = false;
        $email_cliente = $datos_ticket['email_cliente'];
        $cliente  = $datos_ticket['nombre_cliente'];
        $sucursal = $datos_ticket['sucursal'];
        $nombre_sucursal = $sucursal['name'];
        $correo_vendedor = 'vendedor@gmail.com';//env('EMAIL_VENDEDOR', '');
        //dd($email_cliente, $cliente , $sucursal);

        if ( empty($email_cliente) ) {

          $msg.= 'El email del cliente no debe estar vacío';

        }else{

            try {
                //Enviamos el correo al cliente con los datos del ticket
                Mail::send('terminal_movil.ticket' , [
                   'datos_ticket' => $datos_ticket,
                   'nombre_sucursal' => $nombre_sucursal
                ] , function ($mensaje) use ($email_cliente, $cliente , $nombre_sucursal, $correo_vendedor) {


                    // $nombre_suc = $sucursal['name'];
                    //
                    // if ( empty($sucursal) and isset($sucursal['email']) ) {
                    //      $nombre_suc = $sucursal['name'];
                    //      $id_sucursal = $sucursal['id'];
                    //      $mensaje->bcc($sucursal['email'], $nombre_suc);
                    // }

                    //$mensaje->bcc('i.loera@unexpect.mx', 'Israel Alejandro Loera Pérez');

                    $mensaje->from($correo_vendedor, 'Gerente Marisa')
                            ->to($email_cliente, $cliente)
                            ->subject(config('app.site_name').' - Ticket Terminal Movil Marisa '. $nombre_sucursal);

                });

                //Validamos si hubo un fallo en el envío del correo
                if ( count(\Mail::failures()) > 0 ) {
                   $msg.='Ticket No Enviado a '.$email_cliente;
                }else{
                   $success = true;
                   $msg.='Ticket Enviado a '.$email_cliente;
                }

            } catch (Exception $e) {
               $msg.= $e->getMessage();
            }
        }

        return compact('msg', 'success');
    }
}
