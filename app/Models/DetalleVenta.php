<?php

namespace App\Models;

use App\Models\Venta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;
    protected $fillable = ['id_venta', 
                            'id_producto',
                            'cantidad',
                            'subtotal'];
    public function venta(){
        return $this->belongsTo(Venta::class,'id');
    }
    public function producto(){
        return $this->belongsTo(Producto::class,'id_producto');
    }
    
}
