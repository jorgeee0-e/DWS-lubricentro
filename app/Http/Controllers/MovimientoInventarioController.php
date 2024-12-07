<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MovimientoInventario;
use App\Models\Producto;

class MovimientoInventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $movimientos = MovimientoInventario::with('producto')->get();
        return response()->json($movimientos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'id_producto.id_producto' => 'required|exists:productos,id_producto',
            'tipo' => 'required|in:entrada,salida',
            'cantidad' => 'required|integer|min:0',
        ]);
        $producto = Producto::findOrFail($validated['id_producto']['id_producto']);
        // Crear el movimiento de inventario
        $movimiento = MovimientoInventario::create([
        'id_producto' => $validated['id_producto']['id_producto'],
        'tipo' => $validated['tipo'],
        'cantidad' => $validated['cantidad'],
        ]);

        if($validated['tipo']=== 'entrada'){
            $producto->increment('cantidad',$validated['cantidad']);
        }elseif($validated['tipo']==='salida'){
            $producto->decrement('cantidad',$validated['cantidad']);
        }

        return response()->json($movimiento);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

        $movimiento = MovimientoInventario::with('producto')->findOrFail($id);
        return response()->json($movimiento);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $movimiento = MovimientoInventario::findOrFail($id);

        $validated = $request->validate([
            'id_producto' => 'required|exists:productos,id_producto',
            'tipo' => 'required|in:entrada,salida',
            'cantidad' => 'required|integer|min:1',
        ]);

        $producto = Producto::findOrFail($validated['id_producto']);


        // Revertir el movimiento anterior antes de aplicar la actualización
        if($movimiento->tipo==='entrada'){
            $product->decrement('cantidad',$movimiento->cantidad);
        }elseif($movimiento->tipo==='salida'){
            $product->increment('cantidad',$movimiento->cantidad);
        }

        //Actualizar movimiento
        $movimiento->update($validated);

        if($movimiento->tipo==='entrada'){
            $product->increment('cantidad',$movimiento->cantidad);
        }elseif($movimiento->tipo==='salida'){
            $product->decrement('cantidad',$movimiento->cantidad);
        }

        return response()->json($movimiento);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
