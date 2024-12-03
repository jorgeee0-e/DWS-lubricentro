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
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id_producto');
            $table->string('producto', 100);
            $table->text('descripcion')->nullable();
            $table->decimal('precio_costo', 10, 2);
            $table->decimal('precio_venta', 10, 2);
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->string('marca', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
