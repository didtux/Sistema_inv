<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traspaso extends Model
{
    protected $fillable = ['user_id', 'producto_id', 'ubicacion_origen_id', 'ubicacion_destino_id', 'cantidad', 'fecha', 'estado'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function ubicacionOrigen()
    {
        return $this->belongsTo(Ubicacion::class, 'ubicacion_origen_id');
    }

    public function ubicacionDestino()
    {
        return $this->belongsTo(Ubicacion::class, 'ubicacion_destino_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}

