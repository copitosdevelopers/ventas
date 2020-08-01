<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personas extends Model
{
    protected $fillable = [
        'nombres',
        'apellidos',
        'tipo_documento',
        'nro_documento',
        'direccion',
        'correo',
        'telefono',
        'estado',
        'usuario' 
    ];
}
