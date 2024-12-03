<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    use HasFactory;

     // Definir tabla
     protected $table = 'movimientos_inventario';

     // Definir los campos que se pueden llenar
    protected $fillable = [
        'id_producto',
        'tipo',
        'cantidad',
        'descuento',
        'precio_venta',
    ];

    // Relación con el producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}