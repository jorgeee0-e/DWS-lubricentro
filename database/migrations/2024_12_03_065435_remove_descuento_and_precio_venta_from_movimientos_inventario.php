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
        Schema::table('movimientos_inventario', function (Blueprint $table) {
            $table->dropColumn('descuento');  // Eliminar columna descuento
            $table->dropColumn('precio_venta');  // Eliminar columna precio_venta
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movimientos_inventario', function (Blueprint $table) {
            $table->decimal('descuento', 8, 2)->default(0.00);  // Si necesitas revertir la migración
            $table->decimal('precio_venta', 8, 2)->default(0.00);  // Si necesitas revertir la migración
        });
    }
};
