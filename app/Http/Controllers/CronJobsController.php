<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Jenssegers\Date\Date;

//Models

use App\Models\CorreoSolicitudCobro;
use App \Models\ClienteFrecuenciaDetalle;

//Controllers
use App\Http\Controllers\Vendedor\VendedorController;

class CronJobsController extends Controller
{
    var $iniciar = true;
    var $msg = '';

    public function run ()
    {
       $patron = '* * * * *';
       //Establecer en 0 para no tener la restricción de tiempo de ejecución de un script
       set_time_limit(0);
       //Establecer en -1 para no tener resticcion de uso de memoria
       ini_set('memory_limit','-1');

     //  \Cron::add('solicitud_cobro_correo', $patron, function (){
            $fechaBase = Date::now()->format('Y-m-d');
            // dd($fechaBase);
            CorreoSolicitudCobro::select(
                                'correos_solicitud_cobro.id',
                                'correos_solicitud_cobro.branch_office_id',
                                'correos_solicitud_cobro.user_id',
                                'correos_solicitud_cobro.user_name',
                                'correos_solicitud_cobro.buyer_email'
                            )
                            //
                            ->whereExists( function ($query) {
                                $query
                                ->select(\DB::raw('count(pagos.id) as total_pagos'))
                                ->from('pagos')
                                ->where('pagos.status_id', '=', 3)
                                ->whereNull('pagos.deleted_at')
                                ->havingRaw('total_pagos < correos_solicitud_cobro.period_time')
                                ->whereRaw('pagos.payment_request_id = correos_solicitud_cobro.id');
                            })
                                 //
                            ->whereExists( function($query)use($fechaBase) {
                                $query
                                ->select(\DB::raw(1))
                                ->from('cliente_frecuencia_detalle')
                                ->take(1)
                                ->whereRaw('cliente_frecuencia_detalle.payment_request_id = correos_solicitud_cobro.id')
                                ->whereRaw("datediff('".$fechaBase."', DATE_FORMAT(cliente_frecuencia_detalle.created_at, '%Y-%m-%d')) = correos_solicitud_cobro.frecuency")
                                 ->orderBy('cliente_frecuencia_detalle.id', 'DESC');
                            })
                            ->with([
                                'sucursal' => function ($query) {
                                    $query->select('id', 'branch_office_name');
                                }
                            ])
                            ->chunk('100', function ($solicitudes) {
                                    //dd($solicitudes->toArray());
                                     //Enviar correo, crear registro en tabla cliente_frecuencia_detalle
                                foreach($solicitudes as $solicitud) {
                                	//dd($solicitud->toArray());
                                	$sc_id = $solicitud->id;
                                    $email = $solicitud->buyer_email;
                                    $cliente = $solicitud->user_name;
                                    $nombre_sucursal = $solicitud->sucursal->branch_office_name;
                                    $mensaje = 'La sucursal '. $nombre_sucursal .' de Marisa® ha enviado una solicitud de cobro para usted.
                                               Para
                                                realizar el pago ingrese dando click en el siguiente botón';
                                    try{
                                        \Mail::send('email_solicitud_cobro.solicitud_cobro', [
                                              'mensaje' => $mensaje,
                                            ], function($message)use($cliente, $email){
                                                
                                                $message->to($email, $cliente)
                                                		->from('vendedor@gmail.com', 'Vendedor')
                                                        ->subject(config('app.name').' - Nueva solicitud de pago '.$cliente);
                                        });
                                      //Indicar que no se envió un email
                  		                if( count(\Mail::failures()) > 0 ){
                  		                    $this->msg.='<p>Email No Enviado a '.$email.'</p>';
                  		                }
                  		                else{
                  		                    $this->msg.='<p>Email Enviado a '.$email.'</p>';

                  		                    $clientefc = new ClienteFrecuenciaDetalle;
                  		                    $clientefc->payment_request_id = $sc_id; 
                  		                    $clientefc->email_sent = 1;

                  		                    if ( $clientefc->save() ) {

                  		                    }else {
                  		                    	$this->msg.= '<p>Email enviado pero no se guardó el detalle de la frecuencia</p>';
                  		                    }
                  		                }
                                    }
                                    catch(\Exception $ex){
                                        $this->msg.= '<p>Ocurrió excepción general</p>';
                                      //Si existe log
                  		                if( \Storage::disk('local')->exists(Date::now()->format('Y-m-d').'_error_email.txt') ){
                  		                	\Storage::disk('local')->prepend(Date::now()->format('Y-m-d').'_error_email.txt', '['.Date::now()->format('Y-m-d H:i:s')."]\n".$ex."\n\n");
                  		                }
                  		                else{
                  		                	\Storage::disk('local')->put(Date::now()->format('Y-m-d').'_error_email.txt', '['.Date::now()->format('Y-m-d H:i:s')."]\n".$ex."\n\n");
                  		                }

                                    }
                                }
                            });

            if( !empty($this->msg) ){
              return $this->msg;
            }
            return true;
 //       }, true);

        if( $this->iniciar==true ){
  			//$report = \Cron::run();
  	    	//print_r ($report);
        	print_r('¡Corriendo tarea cron!');

  		}
    }
}
