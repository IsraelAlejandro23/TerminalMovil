<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioSucursal extends Model
{
      /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'usuarios_sucursales';

    protected $fillable = [
       'user_id', 'branch_office_id'
    ];

    /**
    * Indicates if the model should be timestamped.
    *
    * @var bool
    */
    public $timestamps = true;

    //Relaciones
    public function usuario ()
    {
      return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
