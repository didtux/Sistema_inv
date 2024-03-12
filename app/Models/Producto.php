<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'codigo1', 'codigo2', 'descripcion', 'precio1', 'precio2', 'marca', 'foto', 'cantidad', 'estado', 'ubicacion_id'
    ];

    public function ubicaciones()
    {
        return $this->belongsToMany(Ubicacion::class)->withTimestamps();
    }

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'ubicacion_id');
    }
}

    

