<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorreoSolicitudCobro extends Model
{
   protected $table = 'correos_solicitud_cobro';

   public $timestamps = true;

   //Relaciones
   public function user ()
   {
      return $this->belongsTo('App\User', 'user_id', 'id');
   }

   //Relaciones
   public function pagos ()
   {
      return $this->hasMany('App\Models\Pago', 'payment_request_id');
   }

   public function cliente_frecuencia_detalle ()
   {
      return $this->hasOne('App\Models\ClienteFrecuenciaDetalle', 'payment_request_id', 'id');
   }

   public function sucursal ()
   {
      return $this->belongsTo('App\Models\Sucursal', 'branch_office_id','id');
   }
}
