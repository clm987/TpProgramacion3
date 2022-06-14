<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    protected $table = 'Clientes';
    public $incrementing = true;
    public $timestamps = false;
    const CREATED_AT = 'fecha_alta';
    const UPDATED_AT = 'fecha_modificacion';
    const DELETED_AT = 'fecha_baja';

    protected $fillable = [
        'nombre', 'apellido', 'dni', 'email', 'telefono', 'fecha_alta', 'fecha_modificacion', 'fechaBaja'
    ];
}
