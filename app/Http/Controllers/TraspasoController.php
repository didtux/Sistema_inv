<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Traspaso;
use App\Models\Producto;
use App\Models\Ubicacion;
use Illuminate\Support\Facades\Auth;
use App\Models\TraspasoConfig;
class TraspasoController extends Controller
{
    public function index(Request $request)
    {
        $query = Traspaso::with('ubicacionOrigen', 'ubicacionDestino', 'producto');
    
     
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('producto', function ($q) use ($search) {
                $q->where('nombre', 'like', '%' . $search . '%');
            });
        }
    
       
        if ($request->has('estado')) {
            $estado = $request->input('estado');
            $query->where('estado', $estado);
        }
    
       
        $traspasos = $query->paginate(5)->appends(request()->query());
    
        return view('traspasos.index', compact('traspasos'));
    }
    
    

    public function showFormEnviarProducto()
    {
        $productos = Producto::all();
        $ubicaciones = Ubicacion::all();

        return view('traspasos.enviar_producto', compact('productos', 'ubicaciones'));
    }
    public function enviarProducto(Request $request)
    {
        $configuracion = TraspasoConfig::first();
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'ubicacion_origen_id' => 'required|exists:ubicaciones,id',
            'ubicacion_destino_id' => 'required|exists:ubicaciones,id|different:ubicacion_origen_id',
            'cantidad' => 'required|integer|min:1|max:' . $configuracion->cantidad_maxima,
        
        ], [
            'ubicacion_destino_id.different' => 'La Sucursal de Destino debe ser diferente a la Sucursal de Origen.',
           
            'cantidad.max' => 'La cantidad no puede ser mayor a ' . $configuracion->cantidad_maxima . '.',
           
            'cantidad.min' => 'La cantidad mínima para enviar debe ser de 1 producto.',
        ]);
    
        $producto = Producto::findOrFail($request->producto_id);
    
        if ($producto->cantidad < $request->cantidad) {
            return redirect()->back()->with('error', 'La cantidad a enviar es mayor a la cantidad disponible del producto.');
        }
    
        $traspaso = new Traspaso([
            'producto_id' => $request->producto_id,
            'ubicacion_origen_id' => $request->ubicacion_origen_id,
            'ubicacion_destino_id' => $request->ubicacion_destino_id,
            'cantidad' => $request->cantidad,
            'fecha' => now(),
            'user_id' => Auth::id(),
            'estado' => 'enviado',
        ]);
    
        $traspaso->save();
    
       
        $producto->decrement('cantidad', $request->cantidad);
    
        return redirect()->route('traspasos.index')->with('success', 'Producto enviado exitosamente.');
    }
    
    public function showFormRecibirProducto()
    {
        $productos = Producto::all();
        $ubicaciones = Ubicacion::all();

        return view('traspasos.recibir_producto', compact('productos', 'ubicaciones'));
    }

    public function recibirProducto(Request $request)
    {  $configuracion = TraspasoConfig::first();
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'ubicacion_origen_id' => 'required|exists:ubicaciones,id',
            'ubicacion_destino_id' => 'required|exists:ubicaciones,id|different:ubicacion_origen_id',
            'cantidad' => 'required|integer|min:1|max:' . $configuracion->cantidad_maxima,
        
        ], [
            'ubicacion_destino_id.different' => 'La Sucursal de Destino debe ser diferente a la Sucursal de Origen.',
            
           
            'cantidad.max' => 'La cantidad no puede ser mayor a ' . $configuracion->cantidad_maxima . '.',
           
            'cantidad.min' => 'La cantidad minima para enviar debe ser de 1 producto.',
        ]);
    
        $traspaso = new Traspaso([
            'producto_id' => $request->producto_id,
            'ubicacion_origen_id' => $request->ubicacion_origen_id,
            'ubicacion_destino_id' => $request->ubicacion_destino_id,
            'cantidad' => $request->cantidad,
            'fecha' => now(),
            'user_id' => Auth::id(),
            'estado' => 'recibido', 
        ]);
    
        $traspaso->save();
    
      
        Producto::findOrFail($request->producto_id)->increment('cantidad', $request->cantidad);
    
        return redirect()->route('traspasos.index')->with('success', 'Producto recibido exitosamente.');
    }
    
}