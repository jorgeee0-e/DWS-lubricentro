<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $productos = Producto::all();
        return response()->json($productos);
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

        $validated = $request -> validate([
            'producto'=> 'required|string|max:100',
            'descripcion'=>'nullable|string',
            'precio_costo'=>'required|numeric|min:0',
            'precio_venta'=>'required|numeric',
            'marca'=>'required|string|max:100'

        ]);
        $producto = Producto::create($validated);
        return response()->json($producto);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

        $producto = Producto::findOrFail($id);

        $validated= $request->validate([
            'producto'=> 'required|string|max:100',
            'descripcion'=>'nullable|string',
            'precio_costo'=>'required|numeric|min:0',
            'precio_venta'=>'required|numeric',
            'marca'=>'required|string|max:100'
        ]);

        $producto->update($validated);
        return response()->json($producto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $producto = Producto::findOrFail($id);
        $product->delete();
        return response()->json(['mensaje'=>'Producto'+$id+'borrado con éxito'],204);
    }
}
