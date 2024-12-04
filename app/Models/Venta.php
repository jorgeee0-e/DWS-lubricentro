<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $fillable = ['id_usuario', 'total'];

    public function detalles(){
        return $this->hasMany(DetalleVenta::class, 'id');
    }
    public function usuario(){
    return $this->belongsTo(User::class, 'id_usuario', 'id');
    }
}
