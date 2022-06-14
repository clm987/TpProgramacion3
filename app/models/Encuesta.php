<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Encuesta extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    protected $table = 'Encuestas';
    public $incrementing = true;
    public $timestamps = true;

    const CREATED_AT = 'fecha_alta';
    const UPDATED_AT = 'fecha_modificacion';
    const DELETED_AT = 'fecha_baja';

    protected $fillable = [
        'puntuacion_mesa', 'puntuacion_restaurante', 'puntuacion_mozo',
        'puntuacion_cocinero', 'mensaje', 'fecha_alta', 'fecha_modificacion', 'fecha_baja'
    ];
}
