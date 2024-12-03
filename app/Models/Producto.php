<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $primaryKey = 'id_producto';

    // Definir los campos que se pueden llenar 
    protected $fillable = [
        'producto',
        'descripcion',
        'precio_costo',
        'precio_venta',
        'marca',
    ];

     // Relación con los movimientos de inventario
     public function movimientos()
     {
         return $this->hasMany(MovimientoInventario::class, 'id', 'id_producto');
     }
}
