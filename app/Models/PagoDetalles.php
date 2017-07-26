<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PagoDetalles extends Model
{
        use SoftDeletes;

        protected $dates = ['deleted_at'];

        protected $table = 'pago_detalles';

        protected $fillable = [
            'payment_id', 'method', 'device_session_id' , 'autorization', 'external_creation_date' , 'customer_id' ,
            'status' , 'transaction_type' , 'external_id', 'issuing_bank' , 'card_type' , 'msi' , 'payment_plan' ,
            'card_mode', 'string_error'
        ];

        public $timestamps = true;

        //Relaciones
        public function pago ()
        {
          return $this->belongsTo('App\Models\Pago', 'payment_id', 'id');
        }
}
