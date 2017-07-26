<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pago extends Model
{
      use SoftDeletes;

      protected $dates = ['deleted_at'];

      protected $table = 'pagos';

      protected $fillable = [
          'branch_office_id', 'user_id', 'user_name' , 'email_user', 'pay_method' , 'subtotal' ,
          'tax_percent' , 'amount' , 'currency', 'description' , 'status_id' , 'status_name' , 'ip_adress' , 'external_creation_date'
      ];

      public $timestamps = true;

      //Relaciones
      public function user ()
      {
      	 return $this->belongsTo('App\User', 'user_id', 'id');
      }

      public function pago_detalles ()
      {
         return $this->hasMany('App\Models\PagoDetalles', 'id');
      }

      public function cliente_fd ()
      {
         return $this->belongsTo('App\Models\ClienteFrecuenciaDetalle', 'payment_request_id');
      }
}
