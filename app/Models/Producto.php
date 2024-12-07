<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Storage;

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
        'imagen',
        'cantidad',
    ];

     // Relación con los movimientos de inventario
     public function movimientos()
     {
         return $this->hasMany(MovimientoInventario::class, 'id', 'id_producto');
     }
     // Para acceder a la URL pública de la imagen
    public function getImagenUrlAttribute()
    {
        return $this->imagen ? Storage::url($this->imagen) : null;
    }
}
