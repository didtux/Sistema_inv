<?php

namespace App\Http\Controllers;

use App\Models\TraspasoConfig;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function mostrarConfiguracion()
{
    $configuracion = TraspasoConfig::first();
    return view('configuracion.mostrar', compact('configuracion'));
}

public function actualizarConfiguracion(Request $request)
{
    $request->validate([
        'cantidad_maxima' => 'nullable|integer|min:1',
        'nombre_sistema' => 'nullable|string|max:255',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Puedes ajustar los formatos y el tamaño máximo
    ]);

    $configuracionData = [
        'cantidad_maxima' => $request->cantidad_maxima,
        'nombre_sistema' => $request->nombre_sistema,
    ];

    if ($request->hasFile('logo')) {
        $logoPath = $request->file('logo')->store('logos', 'public');
        $configuracionData['logo_path'] = $logoPath;
    }

    TraspasoConfig::updateOrCreate([], $configuracionData);

    return redirect()->route('configuracion.mostrar')->with('success', 'Configuración actualizada correctamente.');
}
}

