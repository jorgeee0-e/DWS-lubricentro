<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movimientos_inventario', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('id_producto')->constrained('productos')->onDelete('cascade'); // Relación con productos
            $table->enum('tipo', ['entrada', 'salida']); // 'entrada' para agregar stock, 'salida' para quitar stock
            $table->integer('cantidad'); // Cantidad de producto movido
            $table->decimal('descuento', 10, 2)->default(0.00); // Descuento aplicado (si aplica)
            $table->decimal('precio_venta', 10, 2); // Precio de venta al momento del movimiento
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos_inventario');
    }
};
