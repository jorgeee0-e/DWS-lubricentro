<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\MovimientoInventario;

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
            'marca'=>'required|string|max:100',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cantidad' => 'required|integer|min:1', 

        ]);

        if($request->hasFile('imagen')){
            $imagePath = $request->file('imagen')->store('public/productos');
            $validated['imagen'] = $imagePath; 
        } else{
            $imagePath = null;
        }
        $producto = Producto::create($validated);
        // Registrar un movimiento de inventario con la cantidad inicial
        MovimientoInventario::create([
            'id_producto' => $producto->id_producto,
            'tipo' => 'entrada', // Siempre será una entrada para la cantidad inicial
            'cantidad' => $validated['cantidad'],
        ]);
        return response()->json($producto);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $producto = Producto::findOrFail($id); // Buscar el producto por su id
        return response()->json($producto); 
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
        // Validar si precio_costo o precio_venta son cero, y no actualizar si es el caso
    if ($validated['precio_costo'] == 0) {
        unset($validated['precio_costo']);
    }

    if ($validated['precio_venta'] == 0) {
        unset($validated['precio_venta']);
    }

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
        $producto->delete();
        return response()->json(['mensaje'=>'Producto borrado con éxito'],204);
    }
}
