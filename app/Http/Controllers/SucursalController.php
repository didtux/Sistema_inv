<?php

namespace App\Http\Controllers;

use App\Models\Sucursal as ModelsSucursal;
use Illuminate\Http\Request;

use App\Models\Ubicacion;

class SucursalController extends Controller
{
    public function index()
    {
        $sucursales = Ubicacion::all();
        return view('sucursal.index', compact('sucursales'));
    }

    public function create()
    {
        return view('sucursal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
        ]);

        Ubicacion::create($request->all());

        return redirect()->route('sucursal.index')
            ->with('success', 'Sucursal creada exitosamente.');
    }



    public function edit(Ubicacion $sucursal)
    {
        return view('sucursal.edit', compact('sucursal'));
    }
    

    public function update(Request $request, Ubicacion $sucursal)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
        ]);

        $sucursal->update($request->all());

        return redirect()->route('sucursal.index')
            ->with('success', 'Sucursal actualizada exitosamente.');
    }

    public function destroy(Ubicacion $sucursal)
    {
        $sucursal->delete();

        return redirect()->route('sucursal.index')
            ->with('success', 'Sucursal eliminada exitosamente.');
    }
}
