<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DetalleVenta;

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
    ];

    // Relación con el producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
