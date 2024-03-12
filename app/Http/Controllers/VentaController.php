<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\Ubicacion;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as FacadePdf;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as DomPDFFacadePdf;
use Carbon\Carbon;
class VentaController extends Controller
{
    public function index(Request $request)
    {
        $query = Venta::with('usuario', 'producto', 'ubicacion');
    
     
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('producto', function ($q) use ($search) {
                $q->where('nombre', 'like', '%' . $search . '%');
            });
        }
    
        // Aplicar filtro por fecha
        if ($request->has('filter')) {
            $filter = $request->input('filter');
    
            switch ($filter) {
                case 'today':
                    $query->whereDate('fecha', today());
                    break;
                case 'month':
                    $query->whereMonth('fecha', now()->month);
                    break;
                case 'year':
                    $query->whereYear('fecha', now()->year);
                    break;
            }
        }
    
        if ($request->filled('specific_date')) {
            $query->whereDate('fecha', $request->input('specific_date'));
        }
    
        if ($request->filled('specific_month')) {
            $selectedMonth = $request->input('specific_month');
            $query->whereMonth('fecha', $selectedMonth);
        }
    
    
        if ($request->filled('specific_year')) {
            $query->whereYear('fecha', $request->input('specific_year'));
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
    
        $ventas = $query->paginate(5)->appends($request->all());
    
        return view('ventas.index', compact('ventas'));
    }
    public function generatePDF(Request $request)
    {
        $query = Venta::with('usuario', 'producto', 'ubicacion');
    
        // Aplicar filtro por nombre de producto
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('producto', function ($q) use ($search) {
                $q->where('nombre', 'like', '%' . $search . '%');
            });
        }
    
        if ($request->has('filter')) {
            $filter = $request->input('filter');
            switch ($filter) {
                case 'today':
                    $query->whereDate('fecha', today());
                    break;
                case 'month':
                    $query->whereMonth('fecha', now()->month);
                    break;
                case 'year':
                    $query->whereYear('fecha', now()->year);
                    break;
            }
        }
    
        if ($request->filled('specific_date')) {
            $query->whereDate('fecha', $request->input('specific_date'));
        }
    
        if ($request->filled('specific_month')) {
            $selectedMonth = $request->input('specific_month');
            $query->whereMonth('fecha', $selectedMonth);
        }
    
        if ($request->filled('specific_year')) {
            $query->whereYear('fecha', $request->input('specific_year'));
        }
    
        // Agregar filtro de fecha a fecha
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->input('start_date'));
            $endDate = Carbon::parse($request->input('end_date'));
            $query->whereBetween('fecha', [$startDate, $endDate]);
        }
    
        $ventas = $query->get();
    
        $view = View::make('ventas.pdf', compact('ventas'));
        $pdf = DomPDFFacadePdf::loadHTML($view->render());
    
        // Obtener el nombre del PDF de la solicitud
        $pdfName = $request->input('pdfName');
    
        // Validar que el nombre no esté vacío
        if (!empty($pdfName)) {
            return $pdf->download($pdfName . '.pdf');
        } else {
            return $pdf->download('reporte_ventas.pdf');
        }
    }

    public function create()
    {
        $productos = Producto::all();
        $ubicaciones = Ubicacion::all();

        return view('ventas.create', compact('productos', 'ubicaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'ubicacion_id' => 'required|exists:ubicaciones,id',
            'cantidad' => 'required|integer|min:1',
            'precio' => 'required|numeric', 
        ]);
    
        $producto = Producto::findOrFail($request->producto_id);
    
        if ($producto->cantidad < $request->cantidad) {
            return redirect()->back()->with('error', 'La cantidad a vender es mayor a la cantidad disponible del producto.');
        }
    
        $venta = new Venta([
            'producto_id' => $request->producto_id,
            'ubicacion_id' => $request->ubicacion_id,
            'cantidad' => $request->cantidad,
            'precio' => $request->precio, 
            'precio_total' => $request->precio * $request->cantidad,
            'fecha' => now()->toDateString(),
            'hora' => now()->toTimeString(),
            'user_id' => Auth::id(),
        ]);
    
        $venta->save();
    
       
        $producto->decrement('cantidad', $request->cantidad);
    
        return redirect()->route('ventas.index')->with('success', 'Venta realizada exitosamente.');
    }
    
}