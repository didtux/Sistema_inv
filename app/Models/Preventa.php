<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preventa extends Model
{
    protected $fillable = [
        'user_id',
        'producto_id',
        'tienda_id',
        'nombre_cliente',
        'tel_cliente',
        'cantidad',
        'precio',
        'precio_total',

    ];

 
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

   
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }


    public function tienda()
    {
        return $this->belongsTo(Ubicacion::class, 'tienda_id');
    }
}
