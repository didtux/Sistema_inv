<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraspasoConfig extends Model
{
    use HasFactory;
    protected $table = 'traspaso_config';
 // En el modelo TraspasoConfig
protected $fillable = ['cantidad_maxima', 'nombre_sistema', 'logo_path'];

}
