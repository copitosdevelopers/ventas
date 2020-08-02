<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model
{
    protected $table ='proveedores';
    protected $filable =['id','contacto','telefono_contacto'];

    public $timestamps = false;

    
}
