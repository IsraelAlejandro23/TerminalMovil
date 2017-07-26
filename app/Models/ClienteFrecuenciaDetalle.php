<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteFrecuenciaDetalle extends Model
{
    protected $table = 'cliente_frecuencia_detalle';

    public $timestamps = true;



    public function cliente_frecuencia_detalle ()
    {
       return $this->hasOne('App\Models\CorreoSolicitudCobro', 'payment_request_id', 'id');
    }
}
