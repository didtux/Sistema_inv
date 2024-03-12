<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\Traspaso;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
class HomeController extends Controller
{
    public function index()
    {
        Paginator::currentPageResolver(function () {
            return request()->input('productos_page') ?: 1;
        });
    
        $productos = Producto::paginate(2, ['*'], 'productos_page');
    
        Paginator::currentPageResolver(function () {
            return request()->input('ventas_page') ?: 1;
        });
    
        $ventasPorFecha = Venta::selectRaw('DATE(fecha) as fecha, SUM(cantidad) as total_ventas')
            ->groupBy('fecha')
            ->paginate(5, ['*'], 'ventas_page');
    
        Paginator::currentPageResolver(function () {
            return request()->input('ingresos_page') ?: 1;
        });
    
        $ingresosPorFecha = Venta::selectRaw('DATE(fecha) as fecha, SUM(precio_total) as total_ingresos')
            ->groupBy('fecha')
            ->paginate(5, ['*'], 'ingresos_page');
    
        Paginator::currentPageResolver(function () {
            return request()->input('enviados_page') ?: 1;
        });
    
        $traspasosPorFechaEnviados = Traspaso::selectRaw('fecha, SUM(cantidad) as total_traspasos')
            ->where('estado', 'enviado')
            ->groupBy('fecha')
            ->paginate(5, ['*'], 'enviados_page');
    
        Paginator::currentPageResolver(function () {
            return request()->input('recibidos_page') ?: 1;
        });
    
        $traspasosPorFechaRecibidos = Traspaso::selectRaw('fecha, SUM(cantidad) as total_traspasos')
            ->where('estado', 'recibido')
            ->groupBy('fecha')
            ->paginate(5, ['*'], 'recibidos_page');
    
        return view('home', compact('productos', 'ventasPorFecha', 'ingresosPorFecha', 'traspasosPorFechaEnviados', 'traspasosPorFechaRecibidos'));
    }
    
}

