<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
       /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sucursales';

    protected $fillable = [
        'extern_id', 'branch_office_name'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;


    public function users ()
    {
    	return $this->hasMany('App\User', 'id');
    }

    public function correo_sc ()
    {
       return $this->belongsTo('App\Models\CorreoSolicitudCobro', 'branch_office_id', 'id');
    }
}
