<?php

namespace App\Http\Controllers;

use App\Models\Preventa;
use App\Models\Producto;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PreventaController extends Controller
{
 
    public function index(Request $request)
    {
        $query = Preventa::with(['usuario', 'producto', 'tienda']);
    
    
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nombre_cliente', 'like', '%' . $search . '%');
        }
    
   
        if ($request->has('filter')) {
            $filter = $request->input('filter');
    
            switch ($filter) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month);
                    break;
                case 'year':
                    $query->whereYear('created_at', now()->year);
                    break;
                case 'period':
                    $startDate = Carbon::parse($request->input('start_date'));
                    $endDate = Carbon::parse($request->input('end_date'));
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                    break;
            }
        }
    
     
        if ($request->filled('specific_date')) {
            $query->whereDate('created_at', $request->input('specific_date'));
        }
    
       
        if ($request->filled('specific_month')) {
            $selectedMonth = $request->input('specific_month');
            $query->whereMonth('created_at', $selectedMonth);
        }
    
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->input('start_date'));
            $endDate = Carbon::parse($request->input('end_date'));
    
            $query->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                    ->orWhereDate('created_at', $startDate)
                    ->orWhereDate('created_at', $endDate);
            });
        } elseif ($request->filled('specific_year')) {
            $specificYear = $request->input('specific_year');
            $query->whereYear('created_at', $specificYear);
        }
        $preventas = $query->paginate(9)->appends($request->all());

    
        return view('preventas.index', compact('preventas'));
    }

    public function create()
    {
        $productos = Producto::all();
        $ubicaciones = Ubicacion::all();
        return view('preventas.create', compact('productos', 'ubicaciones'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'tienda_id' => 'required|exists:ubicaciones,id',
            'nombre_cliente' => 'required|string',
            'tel_cliente' => 'required|string',
            'cantidad' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0',
        ]);
    
   
        $producto = Producto::find($request->input('producto_id'));
    
       
        $precio_total = $request->input('cantidad') * $request->input('precio');
    
       
        $preventa = new Preventa([
            'user_id' => Auth::id(),
            'producto_id' => $request->input('producto_id'),
            'tienda_id' => $request->input('tienda_id'),
            'nombre_cliente' => $request->input('nombre_cliente'),
            'tel_cliente' => $request->input('tel_cliente'),
            'cantidad' => $request->input('cantidad'),
            'precio' => $request->input('precio'),
            'precio_total' => $precio_total,
        ]);
    
        $preventa->save();
    
        return redirect()->route('preventas.index')->with('success', 'Preventa creada exitosamente.');
    }
    public function edit($id)
    {
        $preventa = Preventa::find($id);
        $productos = Producto::all();
        $ubicaciones = Ubicacion::all();

        return view('preventas.edit', compact('preventa', 'productos', 'ubicaciones'));
    }

    public function update(Request $request, $id)
    {
      
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'tienda_id' => 'required|exists:ubicaciones,id',
            'nombre_cliente' => 'required|string',
            'tel_cliente' => 'required|string',
            'cantidad' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0',
            'precio_total' => 'required|numeric|min:0',
        ]);

   
        $producto = Producto::find($request->input('producto_id'));

    
        $preventa = Preventa::find($id);
        $preventa->producto_id = $request->input('producto_id');
        $preventa->tienda_id = $request->input('tienda_id');
        $preventa->nombre_cliente = $request->input('nombre_cliente');
        $preventa->tel_cliente = $request->input('tel_cliente');
        $preventa->cantidad = $request->input('cantidad');
        $preventa->precio = $request->input('precio');
        $preventa->precio_total = $request->input('precio_total');
        $preventa->save();

        return redirect()->route('preventas.index')->with('success', 'Preventa actualizada exitosamente.');
    }

    public function destroy($id)
    {
      
        $preventa = Preventa::find($id);
        $preventa->delete();

        return redirect()->route('preventas.index')->with('success', 'Preventa eliminada exitosamente.');
    }
}
