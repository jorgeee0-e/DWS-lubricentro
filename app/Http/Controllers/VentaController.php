<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\MovimientoInventario;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $ventas = Venta::with('detalles.producto')->get();
        return response()->json($ventas,200);
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
        $request->validate([
            'id_usuario'=> 'required|exists:users,id',
            'detalles'=> 'required|array|min:1',
            'detalles*.id_producto'=>'required|exists:productos, id_producto',
            'detalles.*.cantidad'=> 'required|integer|min: 1',
            'detalles.*.descuento'=> 'required|integer|min: 0|max:100',
        ]);

        $total= 0;

        
        foreach($request->detalles as $detalle){
            $id_producto = $detalle['id_producto']['id_producto'];
            $producto = Producto::find($id_producto);

            if($producto->cantidad <$detalle['cantidad']){
                return response()->json([
                    'message'=>'No hay suficiente {$producto->producto} en stock'
                ],400);
            }

            $descuento = $detalle['descuento'] ?? 0;
            $precioConDescuento = $producto->precio_venta - ($producto->precio_venta * $descuento / 100);
            $subtotal = $precioConDescuento* $detalle['cantidad'];

            $total += $subtotal;
            $venta= Venta::create([
                'id_usuario'=> $request->id_usuario,
                'total'=> $total,
            ]);
            DetalleVenta::create([ 
                'id_venta'=> $venta->id,
                'id_producto'=> $detalle['id_producto']['id_producto'],
                'cantidad' => $detalle['cantidad'],
                'subtotal'=>$subtotal,
                'descuento' => $descuento,
            ]);

            //Actualizar cantidad de producto
            $producto->decrement('cantidad',$detalle['cantidad']);

            MovimientoInventario::create([
                'id_producto' => $detalle['id_producto']['id_producto'],
                'tipo' => 'salida', // Asumimos que 'salida' es el tipo de movimiento para las ventas
                'cantidad' => $detalle['cantidad'],
            ]);
  
        }
        $venta->update(['total'=>$total]);
        return response()->json([
            'message'=>'Venta creada con éxito',
            'venta'=> $venta->load('detalles.producto'),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

        $venta = Venta::with('detalles.producto')->find($id);
        if(!$venta){
            return response()->json(['message'=>'Venta no encontrada'],404);
        }
        return response()->json($venta,200);

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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $venta = Venta::find($id);

        if (!$venta) {
            return response()->json(['message' => 'Venta no encontrada'], 404);
        }

        $venta->delete();

        return response()->json(['message' => 'Venta eliminada con éxito'], 200);
    }
}
