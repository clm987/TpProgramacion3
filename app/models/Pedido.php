<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    protected $table = 'Pedidos';
    public $incrementing = true;
    public $timestamps = true;

    const CREATED_AT = 'fecha_alta';
    const UPDATED_AT = 'fecha_modificacion';
    const DELETED_AT = 'fecha_baja';

    protected $fillable = [
        'codigo_pedido', 'id_empleado_mozo', 'id_empleado_back', 'id_cliente', 'codigo_mesa', 'id_producto', 'sector', 'tiempo_estimado_preparacion', 'tiempo_real_preparacion', 'estado_pedido', 'fecha_alta', 'fecha_modificacion', 'fecha_baja'
    ];

    public static function GenerarCodigo()
    {
        $codigo = '';
        $arrayLetras = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        $arrayNumeros = [0, 1, 2, 3, 4, 5, 7, 8, 9];
        $codigo = $arrayLetras[rand(0, 25)] . $arrayLetras[rand(0, 25)] .
            $arrayLetras[rand(0, 25)] .  $arrayNumeros[rand(0, 8)] . $arrayNumeros[rand(0, 8)];
        return $codigo;
    }
}
