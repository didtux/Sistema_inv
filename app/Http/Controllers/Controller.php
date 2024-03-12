<?php

namespace App\Http\Controllers;

use App\Models\TraspasoConfig;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function mostrarConfiguracion()
    {
        $configuracion = TraspasoConfig::first();
        View::share('configuracion', $configuracion);
        return view('configuracion.mostrar', compact('configuracion'));
    }
    


}
